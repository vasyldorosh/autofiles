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
		$content = Yii::app()->cache->get($url);
		if ($content == false) {
			$content = CUrlHelper::getPage($url, '', '');
			Yii::app()->cache->get($url, $content, 60*60);
		}
		//$content = str_replace(array("\n", "\t", "\r", "                    ", "                "), "", $content);
		
		//preg_match_all('/<a href="(.*?)" class="medialistitem"><img src="(.*?)">(.*?)<div class="data">(.*?)<\/div><\/a>/', $content, $matches);
		//file_put_contents('xxx.txt', $content);
		//print_r($matches);
		
		$html = str_get_html($content);	
		foreach ($html->find('#postsarea a.medialistitem') as $key=>$a) {
				
			$album = $this->getParsingWorldcarfansAlbum(array(
				'url' => trim($a->href),
				'title' => trim($a->plaintext),
			), $a->find('img', 0)->src);
			
			echo  $album->id . "\n";
			if ($key == 4) continue;
		}
		
		die();
		
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
		
		foreach ($data as $title) {
			echo similar_text($title, '2015 Nissan Navara') . " $title \n";
		} 
		
		//print_r($data);
	}
	
	private function getParsingWorldcarfansAlbum($attributes, $logo_url) 
	{
		$model = ParsingWorldcarfansAlbum::model()->findByAttributes($attributes);
		if (empty($model)) {
			$model = new ParsingWorldcarfansAlbum;
			$model->attributes = $attributes;
			$model->logo_url = $logo_url;
			$model->save();
		}
		
		return $model;
	}

}	
?>