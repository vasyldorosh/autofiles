<?php
class ImportCommand extends CConsoleCommand
{

	public function init() 
	{
		ini_set('max_execution_time', 3600*5);
		return parent::init();
	}

	public function actionBodyStyle()
	{
		$url = 'http://autos.aol.com/new-cars/';
		$content = CUrlHelper::getPage($url, '', '');
		
		preg_match_all('/<a href="\/car-finder\/style-(.*?)\/"><span><\/span>(.*?)<\/a>/', $content, $matches);
		
		if (isset($matches[1]) && isset($matches[2])) {
			foreach ($matches[1] as $key => $alias) {
				$bodyStyle = BodyStyle::model()->findByAttributes(array('alias'=>$alias));
				if (empty($bodyStyle))
					$bodyStyle = new BodyStyle;
					
				$bodyStyle->alias = $alias;
				$bodyStyle->title = $matches[2][$key];
				var_dump($bodyStyle->save());
			}
		}
	}

	public function actionMake()
	{
		$url = 'http://autos.aol.com/new-cars/';
		$content = CUrlHelper::getPage($url, '', '');

		preg_match_all('/<a href="\/car-finder\/make-(.*?)\/">(.*?)<\/a>/', $content, $matches);
		if (isset($matches[1]) && isset($matches[2])) {
			foreach ($matches[1] as $key => $alias) {
			
				$autoMake = AutoMake::model()->findByAttributes(array('alias'=>$alias));
				if (empty($autoMake))
					$autoMake = new AutoMake;			
			
				$autoMake->alias = $alias;
				$autoMake->title = $matches[2][$key];
				$autoMake->save();
			}
		}
	}	
	
	public function actionModel()
	{
		$autoMakes = (array)AutoMake::model()->findAll();
		$counterKey = 'model_count_pagesdddddііі';
		$data = Yii::app()->cache->get($counterKey);
		
		if (empty($data)) {		
			$data = array();
			foreach ($autoMakes as $makeKey=>$autoMake) {
				$url = 'http://autos.aol.com/' . $autoMake->alias;
				$content = CUrlHelper::getPage($url, '', '');
				preg_match_all('/<div class="pagecount">Page <span>1<\/span> of <span>(.*?)<\/span><\/div>/', $content, $matches);
				$data[$autoMake->alias] = (int) isset($matches[1][0]) ? $matches[1][0] : 1;
			}
			Yii::app()->cache->set($counterKey, $data, 60*60*24*31);
		}
		
		foreach ($autoMakes as $keyMake=>$autoMake) {
			
			echo $autoMake->id . ' - ' . $autoMake->title . "\n";
			
			$pages = $data[$autoMake->alias];
			
			for ($i=0;$i<$pages;$i++) {
				$url = 'http://autos.aol.com/' . $autoMake->alias . '/page-'.($i+1);
				$content = CUrlHelper::getPage($url, '', '');
				preg_match_all('/<li class="research_ifnoratings">All Years of <a class="first" href="\/(.*?)-(.*?)\/">(.*?)<\/a><\/li>/', $content, $matches);
				
				if (isset($matches[2]) && isset($matches[3])) {
					foreach ($matches[2] as $key => $alias) {
					
						$autoModel = AutoModel::model()->findByAttributes(array(
							'alias'=>$alias, 
							'title'=>$matches[3][$key], 
							'make_id'=>$autoMake->id
						));
						
						if (empty($autoModel))
							$autoModel = new AutoModel;
						
						$autoModel->alias = $alias;
						$autoModel->make_id = $autoMake->id;
						$autoModel->title = $matches[3][$key];
						$autoModel->save();
						
						echo "\t" . $autoModel->id . ' - ' . $autoModel->title . "\n";
					}
				}
			}
			
			
		}	
		
	}	
	
	
	public function actionModelYear()
	{
		$autoModels = (array)AutoModel::model()->findAll();
		foreach ($autoModels as $keyModel=>$autoModel) {
			
			echo $autoModel->id . ' - ' . $autoModel->title . "\n";
			
			$url = "http://autos.aol.com/{$autoModel->Make->alias}-{$autoModel->alias}/";
			$content = CUrlHelper::getPage($url, '', '');
			preg_match_all('/<li class="sub_title"><a href="\/cars-(.*?)-(.*?)-(.*?)\/">(.*?)<\/a><\/li>/', $content, $matches);
			
			preg_match_all('/<li class="sub_title"><a href="(.*?)">(.*?)<\/a><\/li>/', $content, $matchesUrl);
				
			if (isset($matches[3])) {
				foreach ($matches[3] as $key=>$year) {
					$autoModelYear = AutoModelYear::model()->findByAttributes(array(
						'model_id'=>$autoModel->id, 
						'year'=>$year
					));
						
					if (empty($autoModelYear))
						$autoModelYear = new AutoModelYear;
						
					$autoModelYear->url = $matchesUrl[1][$key];
					$autoModelYear->model_id = $autoModel->id;
					$autoModelYear->year = $year;
					$autoModelYear->save();	

					echo "\t" . $autoModelYear->id . ' - ' . $autoModelYear->year . "\n";
				}
			}
			
			
		}
	}	
	
	public function actionModelYearPhoto()
	{
		$autoModels = (array)AutoModelYear::model()->findAll();
		foreach ($autoModels as $keyYear=>$autoModelYear) {
			$url = "http://autos.aol.com".$autoModelYear->url."photos/";
			
			$content = CUrlHelper::getPage($url, '', '');
			preg_match_all('/<a href="http:\/\/o.aolcdn.com\/commerce\/images\/(.*?)_Large.jpg">/', $content, $matches);
		
			if (isset($matches[1])) {
				foreach ($matches[1] as $file) {
					$file_url = "http://o.aolcdn.com/commerce/images/{$file}_Large.jpg";
					$photo = new AutoModelYearPhoto;
					$photo->file_url = $file_url;
					$photo->year_id = $autoModelYear->id;
					var_dump($photo->save());
				}
			}
		}
	}		

	private function getSpecsGroup($attributes)
	{
		$group = AutoSpecsGroup::model()->findByAttributes($attributes);
						
		if (empty($group)) {
			$group = new AutoSpecsGroup;
			$group->attributes = $attributes;
			$group->save();
		} 

		return $group;
	}	
	
	private function getSpecs($attributes)
	{
		$group = AutoSpecs::model()->findByAttributes($attributes);
						
		if (empty($group)) {
			$group = new AutoSpecs;
			$group->attributes = $attributes;
			$group->save();
		} 

		return $group;
	}	
	
	private function getCompletion($attributes)
	{
		$completion = AutoCompletion::model()->findByAttributes($attributes);
						
		if (empty($completion)) {
			$completion = new AutoCompletion;
			$completion->attributes = $attributes;
			$completion->save(false);
		} 

		return $completion;
	}
	
	public function actionCompletion()
	{
		$autoModels = (array)AutoModelYear::model()->findAll();
		foreach ($autoModels as $keyYear=>$autoModelYear) {
			echo $autoModelYear->id . ' - ' . $autoModelYear->year . "\n";
			$url = "http://autos.aol.com{$autoModelYear->url}equipment/";
			$content = Yii::app()->cache->get($url);
			if (empty($content)) {		
				$content = CUrlHelper::getPage($url, '', '');
				Yii::app()->cache->set($url, $content, 60*60*24*31);
			}	
			
			file_put_contents('test.txt', $content);
			$html = file_get_html('test.txt');			
			$linkCompare = $html->find('.tools_first a', 0);
			
			$contentCompare = Yii::app()->cache->get($linkCompare->href);
			if (empty($contentCompare)) {		
				$contentCompare = CUrlHelper::getPage($linkCompare->href, '', '');
				Yii::app()->cache->set($linkCompare->href, $contentCompare, 60*60*24*31);
			}	
			
			file_put_contents('test.txt', $contentCompare);	
			$htmlCompare = file_get_html('test.txt');	
			foreach ($htmlCompare->find('#compTrimList1 option') as $option) {
				$completion = $this->getCompletion(array('model_year_id'=>$autoModelYear->id,'code'=>$option->value, 'title'=>$option->plaintext));
				echo "\t" . $completion->id . ' - ' . $completion->title . "\n";
			}
		}
	}	
	
	public function actionCompletionDetails()
	{
		$completions = (array)AutoCompletion::model()->findAll();
		foreach ($completions as $key=>$completion) {
			$url = "http://autos.aol.com/cars-compare?cur_page=details&v1={$completion->code}&v2=&v3=&v4=&v5=&v6=&v7=&v8=&v9=";
			$content = Yii::app()->cache->get($url);
			if (empty($content)) {		
				$content = CUrlHelper::getPage($url, '', '');
				Yii::app()->cache->set($url, $content, 60*60*24*31);
			}	
			
			file_put_contents('test.txt', $content);
			$html = file_get_html('test.txt');	
			$specsGroup = null;
			foreach ($html->find('#data_table tr') as $tr) {
			
				if ($tr->class == 'header') {
					$specsGroup = $this->getSpecsGroup(array('title'=>trim(str_replace('Compare ', '', $tr->find('td', 0)->plaintext))));
					echo  $specsGroup->title . '<br/>';
				} else if (!empty($specsGroup)) {
					$specs = $this->getSpecs(array('title'=>trim($tr->find('td', 0)->plaintext), 'group_id'=>$specsGroup->id));
		
					$completionSpecs = new AutoCompletionSpecsTemp;
					$completionSpecs->attributes = array(
						'completion_id' => $completion->id,
						'specs_id' => $specs->id,
						'value' => trim($tr->find('td', 1)->plaintext),
					);
					$completionSpecs->save();
					
					echo  $specs->title . '<br/>';
				}

			}
		}
	}		

}
?>