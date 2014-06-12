<?php
class WorldcarfansCommand extends CConsoleCommand
{
	public function init() 
	{
		ini_set('max_execution_time', 3600*12);
		return parent::init();
	}

	public function actionPhoto()
	{
		$url = 'http://www.worldcarfans.com/photos';
		$content = CUrlHelper::getPage($url, '', '');
		
		$html = str_get_html($content);	
		$data = explode('of', $html->find('#postsarea .navs', 0)->plaintext);
		$countPage = (int) end($data);		
		
		for ($i=1; $i<=$countPage;$i++) {	
			$url = "http://www.worldcarfans.com/photos/{$i}";
			$content = CUrlHelper::getPage($url, '', '');
			$html = str_get_html($content);	
			
			foreach ($html->find('#postsarea a.medialistitem') as $key=>$a) {

				if (method_exists($a, 'find') && $data=$a->find('.data', 0) && property_exists($data, 'plaintext'))
					$photoCountText = $data->plaintext;	
					$title = str_replace(trim($photoCountText), '', trim($a->plaintext));
						
					$album = $this->getParsingWorldcarfansAlbum(array(
						'url' => trim($a->href),
						'title' => $title,
					), $a->find('img', 0)->src);
					
					echo  $album->id . "\n";
				} else {
					echo "error {$key} \n";
				}
			}
		}
	}
	
	public function actionP()
	{
		$limit = 100;
		
		$to = Yii::app()->db->createCommand('SELECT MAX(id) FROM parsing_worldcarfans_album')->queryScalar();
		
		for ($offset=0; $offset<=$to; $offset+=$limit) {
		
			$criteria = new CDbCriteria();
			$criteria->limit = $limit;		
			$criteria->offset = $offset;	
			
			$albums = ParsingWorldcarfansAlbum::model()->findAll($criteria);
			if (empty($albums))
				die();
			
			foreach ($albums as $key=>$album) {
				$content = Yii::app()->cache->get($album->url);
				if ($content == false) {
					$content = CUrlHelper::getPage($album->url, '', '');
					Yii::app()->cache->get($album->url, $content, 60*60*24);
				}
				
				//<a class="thumb" href="" title="" name="image"><img src="" alt="" height="" width="" /></a>
			
				echo $album->id . "\n";
			}
		}
	}	
	
	private function getParsingWorldcarfansAlbum($attributes, $logo_url) 
	{
		$model = ParsingWorldcarfansAlbum::model()->findByAttributes($attributes);
		if (empty($model)) {
			$model = new ParsingWorldcarfansAlbum;
			$model->attributes = $attributes;
			$model->logo_url = $logo_url;
			
			$modelYears = $this->getDataModelYear();
			$model_year_id = 0;
			
			foreach ($modelYears as $modelYearId => $modelYearTitle) {
				if (strpos($model->title, $modelYearTitle)) {
					$model_year_id = $modelYearId;
					break;
				}
			} 		
				
			$model->model_year_id = $model_year_id;	
			$model->save();				
			
			$model->save();
		}
			
		return $model;
	}
	
	private function getDataModelYear() 
	{
		$key = 'getDataModelYear';
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
		
			$criteria=new CDbCriteria;
			$criteria->with = array(
				'Model' => array('together'=>true),
				'Model.Make' => array('together'=>true),
			);	
			$items = AutoModelYear::model()->findAll($criteria);
			$data = array();
			foreach ($items as $item) {
				$data[$item->id] = $item->year . ' ' . $item->Model->Make->title . ' ' . $item->Model->title;
			}
			
			Yii::app()->cache->get($key, $data, 60*60);
		}
		
		return $data;
	}
}	
?>