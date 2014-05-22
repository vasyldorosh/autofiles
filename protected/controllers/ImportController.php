<?php

class ImportController extends Controller
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
		$counterKey = 'model_count_pagesdd';
		$data = Yii::app()->cache->get($counterKey);
		if (empty($data) || true) {		
			$data = array();
			foreach ($autoMakes as $makeKey=>$autoMake) {
				$url = 'http://autos.aol.com/' . $autoMake->alias;
				$content = CUrlHelper::getPage($url, '', '');
				d($content);
				preg_match_all('/<div class="pagecount">Page <span>1<\/span> of <span>(.*?)<\/span><\/div>/', $content, $matches);
				$data[$autoMake->alias] = (int) isset($matches[1][0]) ? $matches[1][0] : 0;
			}
			Yii::app()->cache->set($counterKey, $data, 60*60*24*31);
		}
			
		d($data);	
			
		foreach ($autoMakes as $keyMake=>$autoMake) {
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
					}
				}
			}
			
			echo $autoMake->id . ' - ' . $autoMake->title . '<br/>';
		}	
		
	}	
	
	
	public function actionModelYear()
	{
		$autoModels = (array)AutoModel::model()->findAll();
		foreach ($autoModels as $keyModel=>$autoModel) {
		
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
						
					$autoModelYear->url = $matchesUrl[1][0];
					$autoModelYear->model_id = $autoModel->id;
					$autoModelYear->year = $year;
					$autoModelYear->save();				
				}
			}
			
			echo $autoModel->id . ' - ' . $autoModel->title . '<br/>';
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
	
	public function actionSpecs()
	{
		$autoModels = (array)AutoModelYear::model()->findAll();
		foreach ($autoModels as $keyYear=>$autoModelYear) {
			$url = "http://autos.aol.com".$autoModelYear->url."specs/";
			$content = Yii::app()->cache->get($url);
			if (empty($content)) {		
				$content = CUrlHelper::getPage($url, '', '');
				Yii::app()->cache->set($url, $content, 60*60*24*31);
			}	
			//echo $content;
			//die();
			
			file_put_contents('test.txt', $content);
			
			// Create DOM from URL or file
			$html = file_get_html('test.txt');

			// Find all images 
			$groups = array();
			$completions = array();
			foreach($html->find('#mm_data_navi li a span') as $key=>$element) {
				$title = trim($element->plaintext);
				$groups[$key] = $this->getSpecsGroup(array('title'=>$title));	

					$element = $html->find('.ymm_data_table_wrap', $key);
					file_put_contents('tab.txt', $element->innertext);
					$tab = file_get_html('tab.txt');
					foreach($html->find('.key_column .lgPadding') as $elTrim) {
						$titleTrim = trim($elTrim->plaintext);
						if ($titleTrim == 'Trims') continue;
						
						$completions[$key] = $this->getCompletion(array('title'=>$titleTrim, 'model_year_id'=>$autoModelYear->id));
						$completions[$key] = $this->getCompletion(array('title'=>$titleTrim));
						
						echo $titleTrim . '<br/>';
					}
					
					foreach ($html->find('.ymm_data_table_wrap', $key)->find('.data_column') as $element) {
						//d($element->find('.heading', 0)->plaintext);
						
						foreach ($element->find('.lgPadding') as $specsValue) {
							echo $specsValue->plaintext . '<br/>';
						}
						
						$specs = $this->getSpecs(array('title'=>$title, 'group_id'=>$groups[$key]->id));
						//echo $element->plaintext . '<br/>';
					}

					//$groups[$key]['wrap'] = $element->innertext;	
					//die();
				
			}
				
			//d($groups);
			
			die();
			
			if ($keyYear == 2) {
				die();
			}
			
			echo $url . '<br>';
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
			$completion->save();
		} 

		return $completion;
	}
	
}