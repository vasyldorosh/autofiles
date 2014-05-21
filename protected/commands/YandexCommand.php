<?php
class YandexCommand extends CConsoleCommand
{
	public function actionQueries($limit)
	{	
		$criteria = new CDbCriteria();
		$criteria->compare('scanned', 0);
		$criteria->limit = $limit;
		$queries = Queries::model()->findAll($criteria);
		
		$statistic = array();
		foreach ($queries as $key=>$query) {
			$query->scanned = Queries::STATUS_RUN;
			$query->save(false);		
				
			$list = array();
			$center = array($query->center_lon, $query->center_lat);
			$region = array($query->reg_lon, $query->reg_lat);
			$yandexIds = $this->getMapList($query->keyword->keyword, $center, $region);
			
			$countAdded = 0;
			$countExists = 0;
			foreach ($yandexIds as $yandexId) {
				$criteria = new CDbCriteria();
				$criteria->compare('yandex_id', $yandexId);				
				$salon = Salon::model()->find($criteria);
				if (empty($salon)) {
					$salon = new Salon;
					$salon->city_id = $query->city_id;
					$salon->yandex_id = $yandexId;
					$salon->is_parsed = 0;
					$salon->save(false);
					$countAdded++;
				} else {
					$countExists++;
				}
			}
			$report = 'Добавлено: ' . $countAdded;
			$query->report = $report;
			$query->scanned = Queries::STATUS_COMPLETED;
			$query->updated = time();
			$query->save();
			echo $key . ' -- ' . $query->id . ' -- ' . $countAdded . ' -- ' . $countExists . "\n";
		}		
	}
	
	/*
	* Проходим по каждой карточке салона
	*/
    public function actionSalon($limit)
    {
		$criteria = new CDbCriteria();
		$criteria->compare('is_parsed', 0);
		$criteria->limit = $limit;
		$salons = Salon::model()->findAll($criteria);
		
		foreach ($salons as $key=>$salon) {
			$dataSalon = $this->getSalon($salon->yandex_id);
			
			//d($dataSalon);			
			
			//Категории
			$yandexCategoryIds = array();	
			$post_categories = array();	
			if (isset($dataSalon['rubrics']) && is_array($dataSalon['rubrics'])) {
				foreach ($dataSalon['rubrics'] as $rubric) {
					$rubric = trim($rubric);
					$title = 'Направления';
					$criteria = new CDbCriteria();
					$criteria->compare('yandex_category', $title);
					$criteria->compare('title', $rubric);
					$yandexCategory = YandexCategory::model()->find($criteria);
					if (empty($yandexCategory)) {
						$yandexCategory = new YandexCategory;
						$yandexCategory->yandex_category = $title;
						$yandexCategory->title = $rubric;
						$yandexCategory->save();
					}
					$yandexCategoryIds[] = $yandexCategory->id;
					if (!empty($yandexCategory->category_id))
						$post_categories[] = $yandexCategory->category_id;
				}
			}
			if (isset($dataSalon['options']) && is_array($dataSalon['options'])) {
				foreach ($dataSalon['options'] as $item) {
					$name = trim($item['name']);

					$subCats = explode(',', $item['description']);
					foreach ($subCats as $subCat) {
						$subCat = trim($subCat);					
						$criteria = new CDbCriteria();
						$criteria->compare('yandex_category', $name);
						$criteria->compare('title', $subCat);
						$yandexCategory = YandexCategory::model()->find($criteria);
						if (empty($yandexCategory)) {
							$yandexCategory = new YandexCategory;
							$yandexCategory->yandex_category = $name;
							$yandexCategory->title = $subCat;
							$yandexCategory->save();
						}
						$yandexCategoryIds[] = $yandexCategory->id;
						if (!empty($yandexCategory->category_id))
							$post_categories[] = $yandexCategory->category_id;						
					}
				}
			}
			
			//Метро
			$metroIds = array();
			if (isset($dataSalon['metro']) && is_array($dataSalon['metro'])) {
				foreach ($dataSalon['metro'] as $item) {
					$name = trim($item['name']);
					$criteria = new CDbCriteria();
					$criteria->compare('name', $name);
					$criteria->compare('city_id', $salon->city_id);		
					$metro = Metro::model()->find($criteria);
					if (empty($metro)) {
						$metro = new Metro;
						$metro->city_id = $salon->city_id;
						$metro->name = $name;
						$metro->save();
					}
					$metroIds[] = $metro->id;
				}
			}
			
			$salon->scenario = 'yandexImport';
			$salon->name = $dataSalon['name'];
			if (isset($dataSalon['phones']))
				$salon->phone = implode(',',$dataSalon['phones']);
			if (isset($dataSalon['work_time']))
				$salon->work_time = implode('; ',$dataSalon['work_time']);
			if (isset($dataSalon['address'])) {
				$address = str_replace($salon->city->name.',', '', $dataSalon['address']);
				$expl = explode(',', $address);
				$expl[0] = trim($expl[0]);
				if (is_numeric($expl[0])) {
					$address = str_replace($expl[0].',', '', $address);
				}
				$salon->address = $address;
			}
			if (isset($dataSalon['site']))
				$salon->site = $dataSalon['site'];
			$salon->post_yandex_categories = $yandexCategoryIds;
			$salon->post_metros = $metroIds;
			$salon->post_categories = $post_categories;
			$salon->create_date = time();
			$salon->is_parsed = 1;
			$salon->save(false);
			echo $key . ' -- ' . $salon->yandex_id . "\n";
		}
			
		// Удаляем лишние категории
		Yii::app()->db->createCommand(
			'DELETE FROM yandex_category WHERE 
				yandex_category LIKE "%цена%" OR 
				yandex_category LIKE "%стоимость%" OR
				yandex_category LIKE "%ценовая категория%" OR
				yandex_category LIKE "%категории граждан%" OR
				yandex_category LIKE "%оплата%" 
		')->query();	
		
	}
	
	function getSalon($yandex_id) 
	{
		$r = array();
		$url = "http://maps.yandex.ru/org/".$yandex_id."/";
		$content = CUrlHelper::getPage($url, '', '');
		if (!$content) return $r;
		preg_match_all('/<h1 class="b-page-title.*?">(.*?)<\/h1>/', $content, $m1);
		if (!$m1[1][0]) return $r;
		$r['name'] = $m1[1][0];
		preg_match_all('/<div class="b-rubrics">(.*?)<\/div>/', $content, $m1);
		preg_match_all('/<a.*?>(.*?)<\/a>/', $m1[1][0], $m2);
		if (isset($m2[1]))
			$r['rubrics'] = $m2[1];
		
		preg_match_all('/<p class="b-address">(.*?)<\/p>/', $content, $m1);
		if (isset($m1[1][0]))
			$r['address'] = $m1[1][0];
		
		preg_match_all('/<span class="b-phone__num">(.*?)<\/span>/', $content, $m1);
		if (isset($m1[1]))
			$r['phones'] = $m1[1];
		
		preg_match_all('/<h3 class="b-serp-item__title.*?<a class="b-serp-item__title-link.*?href="(.*?)"/', $content, $m1);
		if (isset($m1[1][0]))
			$r['site'] = $m1[1][0];
		
		$r['work_time'] = array();
		preg_match_all('/<tr class="b-work-mode__row">(.*?)<\/tr>/', $content, $m1);
		if (isset($m1[1]))
			foreach ($m1[1] as $row) $r['work_time'][] = strip_tags($row);
		
		$r['options'] = array();
		preg_match_all('/<tr class="b-description__item.*?">(.*?)<\/tr>/', $content, $m1);
		if (isset($m1[1]))
			foreach ($m1[1] as $row) {
				preg_match_all('/<td.*?>(.*?)<\/td>/', $row, $m2);
				$r['options'][] = array('name'=>strip_tags($m2[1][0]), 'description'=>$m2[1][1]);
			}
			
		$r['features'] = array();
		preg_match_all('/<li class="b-description__item.*?">.*?<\/span>(.*?)<\/li>/', $content, $m1);
		if (isset($m1[1]))
			foreach ($m1[1] as $row) $r['features'][] = strip_tags($row);
		
		preg_match_all('/<div class="b-stops__data">(.*?)<\/div>/', $content, $m1);
		$r['metro'] = array();
		if (isset($m1[1]))
			foreach ($m1[1] as $row) {
				preg_match_all('/<span.*?>(.*?)<\/span>/', $row, $m2);
				$r['metro'][] = array('name'=>$m2[1][0], 'distance'=>$m2[1][1]);
			}
			
		return $r;
	}	
		
	
	function getMapList($request, $map_center, $map_size) 
	{
		$prm = array(
			"text"=>$request,
			"ll"=>$map_center[0].','.$map_center[1],
			"sll"=>$map_center[0].','.$map_center[1],
			"spn"=>$map_size[0].','.$map_size[1],
			"sspn"=>($map_size[0]/2).','.($map_size[1]/2),
			"l"=>"map",
			"z"=>9,
			"results"=>5000
		);

		$url = "http://maps.yandex.ru/?".http_build_query($prm);
		$content = CUrlHelper::getPage($url, '', '');
		preg_match_all('/"CompanyMetaData":\{"id":"(.*?)"/', $content, $m);
		
		return $m[1];
	}	

}
?>