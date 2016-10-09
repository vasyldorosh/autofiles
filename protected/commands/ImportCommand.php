<?php
class ImportCommand extends CConsoleCommand
{
	public function init() 
	{
		ini_set('max_execution_time', 3600*12);
		date_default_timezone_set('America/Los_Angeles');
		
		return parent::init();
	}

	public function actionNotModelYear() 
	{
		echo __FUNCTION__ . "_start_ \n";
		
		$sql = "SELECT y.id AS id FROM auto_model_year y 
			WHERE NOT EXISTS (
			 SELECT model_year_id FROM auto_completion c
			 WHERE y.id = c.model_year_id
			 GROUP BY c.model_year_id
			)";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		$dataIds = array();
		$i=0;
		foreach ($rows as $row) {
			$dataIds[$i][] = $row['id'];
			if (count($dataIds[$i]) >= 100) {
				$i++;
			}
		}
		
		print_r($dataIds);
		
		if (!empty($dataIds)) {
			foreach ($dataIds as $ids) {
			
				$completionIds = $this->actionCompletion($ids);
												
				if (!empty($completionIds)) {
					$this->actionCompletionDetails($completionIds);
					$this->actionSpecs();
					$this->actionCompletionData($completionIds);
				}			
			}
		}
		
		echo __FUNCTION__ . "_end_ \n";
	}

	protected function actionBodyStyle()
	{
		$url = 'http://www.autoblog.com/new-cars/';
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

	protected function actionMake()
	{
		$url = 'http://www.autoblog.com/api/taxonomy/newmake/';
		$items = json_decode(CUrlHelper::getPage($url, '', ''));
		
		foreach ($items as $makeTitle) {
			
			$alias = TextHelper::urlSafe(str_replace(' ', '+', $makeTitle));
			
			$autoMake = AutoMake::model()->findByAttributes(array('alias'=>$alias));
			if (!empty($autoMake)) continue;
						
			$autoMake = new AutoMake;
			$autoMake->alias = $alias;
			$autoMake->title = $makeTitle;
			$autoMake->is_active = 1;
			$autoMake->is_deleted = 0;
			$autoMake->save();
			
			if ($autoMake->save()) {
				echo "Make: $autoMake->id - $autoMake->title \n";
			} else {
				echo  $autoMake->title . "\n";
				print_r($autoMake->errors);
			}					
		}
	}	
	
	protected function actionModel()
	{
		$makes =  AutoMake::model()->findAll();
		foreach ($makes as $make) {
			$url = 'http://www.autoblog.com/api/taxonomy/newmodel/?make=' . urlencode(trim($make->title));
			$items = json_decode(CUrlHelper::getPage($url, '', ''));		
			if (!is_array($items)) {
				continue;
			}
			
			foreach ($items as $modelTitle) {
				
				$alias = TextHelper::urlSafe(str_replace(' ', '+', $modelTitle));
				
				$autoModel = AutoModel::model()->findByAttributes(array('alias'=>$alias, 'make_id'=>$make->id));
				if (!empty($autoModel)) {
					$autoModel->title = $modelTitle;
					$autoModel->save();
					continue;
				}
					
				$autoModel = new AutoModel;
				$autoModel->alias = $alias;
				$autoModel->title = $modelTitle;
				$autoModel->make_id = $make->id;
				$autoModel->is_active = 1;
				$autoModel->is_deleted = 0;
				if ($autoModel->save()) {
					echo "Model: $autoModel->id - $autoModel->title : $autoModel->id \n";
				} else {
					echo  $autoModel->title . "\n";
					print_r($autoModel->errors);
				}
			}
		}
	}	
	
	public function actionModelYear($year)
	{
		$modelYearIds = array();
		$dataMake = array();
		$dataModel = array(
			'Chrysler' => array('Town-Country'=>228),
		);
		
		$content = CUrlHelper::getPage("http://www.autoblog.com/car-finder/{$year}/");
		preg_match_all('/<span id="TotalResults">(.*?)<\/span>/', $content, $matchesPager);

		//DELETE
		//AutoModelYear::model()->deleteAllByAttributes(['year'=>$year]);
		
		$i=0;
		if (isset($matchesPager[1][0]) && is_numeric($matchesPager[1][0])) {
			for ($page=1; $page<=$matchesPager[1][0]; $page++) {
					
				$url = "http://www.autoblog.com/car-finder/{$year}/";
				if ($page > 1) {
					$url.= 'pg-'.$page.'/';
				}
				
				//DELETE
				//if ($page > 2) {continue;}
				
				echo "PAGE: $page - $url \n";	
				$content = CUrlHelper::getPage($url);
				
				preg_match_all('/<div class="trim__desc hidden-sm hidden-md hidden-lg"><div class="h4"><a class="desc__link" href="\/buy\/'.$year.'\-(.*?)\-(.*?)\/">'.$year.'(.*?)<\/a><\/div>/', $content, $matches);
				preg_match_all('/<img class="img-responsive" src="(.*?)" alt="'.$year.'(.*?)" \/>/', $content, $matchImgs);
				
				$imagesData = array();
				foreach ($matchImgs[1] as $key=>$img) {
					if (strpos($img, 'img-responsive')) {
						$expl = explode('<img class="img-responsive" src="', $img);
						$imagesData[$key] = end($expl);
					} else {
						$imagesData[$key] = $img;
					}
				}
											
				foreach ($matches[1] as $key=>$makeTitle) {
					$modelTitle = $matches[2][$key];
					$makeTitle	= str_replace(array('_', '+'), array('-', ' '), $makeTitle);
					$modelTitle	= str_replace(array('_', '+'), array('-', ' '), $modelTitle);
											
					$aliasMake = TextHelper::urlSafe(str_replace(' ', '+', $makeTitle));
					$modelAlias = TextHelper::urlSafe(str_replace(' ', '+', $modelTitle));
					
					if (!isset($dataMake[$aliasMake])) {
						$make = AutoMake::model()->findByAttributes(array('alias'=>$aliasMake));
						if (empty($make)) {
							$make = new AutoMake;
							$make->title = $makeTitle;
							$make->alias = $aliasMake;
							$make->save();
							
							echo "created: Make $makeTitle  \n";							
						}
						
						$dataMake[$aliasMake] = $make->id;
					}
					
					
					
					if (isset($dataMake[$aliasMake]) && !isset($dataModel[$aliasMake][$modelAlias])) {
						$model = AutoModel::model()->findByAttributes(array('alias'=>$modelAlias, 'make_id'=>$dataMake[$aliasMake]));
						if (empty($model)) {
							
							$model = new AutoModel;
							$model->title = $modelTitle;
							$model->alias = $modelAlias;
							$model->make_id = $dataMake[$aliasMake];
							$model->save();
							
							echo "\t created: model $makeTitle $modelTitle \n";
						}
						
						$dataModel[$aliasMake][$modelAlias] = $model->id;
				
					}
					
						$modelYear = AutoModelYear::model()->findByAttributes(array(
							'year' => $year,
							'model_id' => $dataModel[$aliasMake][$modelAlias],
						));
						
						if (empty($modelYear)) {
							$modelYear = new AutoModelYear;
							
							if (isset($imagesData[$key])) {
								$modelYear->file_url = $imagesData[$key];
								$modelYear->file_name = "{$model->Make->title}-{$model->title}-{$year}.jpg";	
							}
													
							$modelYear->is_active = 1;
							$modelYear->year = $year;
							$modelYear->model_id = $dataModel[$aliasMake][$modelAlias];
							if ($modelYear->save()) {
								$modelYearIds[] = $modelYear->id;
								echo "$i: created: ModelYear: {$modelYear->id} - $year $makeTitle $modelTitle \n";
							} else {
								print_r($modelYear->errors);
								die();
							} 							
						} else {
							echo "\t $i: isset: ModelYear: {$modelYear->id} - $year $makeTitle $modelTitle \n";
						}						
					$i++;
				}
			}
		} else {
			echo __FUNCTION__ . ": paggionation \n";
		}
		
		return $modelYearIds;
	}	
	
	public function actionCatalog()
	{	
		//$this->actionMake();
		//$this->actionModel();
		//$parsedModelYearIds = $this->actionModelYear(date('Y'));
		//$parsedModelYearIds = array_merge($parsedModelYearIds, $this->actionModelYear(date('Y')+1));
		
		$parsedModelYearIds = range(8372, 8417);
	
		if (!empty($parsedModelYearIds)) {
			//$this->actionModelYearPhoto($parsedModelYearIds);
			$completionIds = $this->actionCompletion($parsedModelYearIds);
			
			//$completionIds = range(27814, 27765);
			
			if (!empty($completionIds)) {
				$this->actionCompletionDetails($completionIds);
				$this->actionSpecs();
				$this->actionCompletionData($completionIds);
			}
		}
		
		//$this->actionNotModelYear();
		//$this->actionEmptyCompletion();
		//$this->actionNotCompletionTitle();
			
		//$this->actionMoveSpecs();	
			
		CUrlHelper::getPage('http://autotk.com/site/flush', '', '');
	}	
	
	function actionMoveSpecs()
	{
		$sql    = '';
		
		// fuel
		$s 	= "SELECT id, specs_epa_mileage_estimates FROM  auto_completion WHERE 
					specs_epa_mileage_estimates IS NOT NULL AND 
					specs_epa_mileage_estimates <> 'N/A' AND 
					specs_epa_mileage_estimates <> '' AND
					specs_fuel_economy__city IS NULL AND 
					specs_fuel_economy__highway IS NULL";
		$rows 	= Yii::app()->db->createCommand($s)->queryAll();
		foreach ($rows as $row) {
			$expl = explode('/', $row['specs_epa_mileage_estimates']);
			if (count($expl) == 2) {
				
				$city = (int) trim($expl[0]);
				$highway = (int) trim($expl[1]);
				
				$sql .= "UPDATE auto_completion
						SET specs_fuel_economy__city={$city}, specs_fuel_economy__highway = {$highway}
						WHERE id = " . $row['id'] . "; \n";
			}
		}	

		$s 	= "SELECT id, specs_fuel_tank_capacity FROM  auto_completion WHERE 
					specs_fuel_tank_capacity IS NOT NULL AND
					specs_fuel_tank_capacity <> '' AND
					specs_fuel_tank IS NULL";
		$rows 	= Yii::app()->db->createCommand($s)->queryAll();
		foreach ($rows as $row) {
			$sql .= "UPDATE auto_completion
					SET specs_fuel_tank=".$row['specs_fuel_tank_capacity']."
					WHERE id = " . $row['id'] . "; \n";
		}	
	
		if (!empty($sql)) {
			Yii::app()->db->createCommand($sql)->execute();
		}
	}
	
	public function actionNotCompletionTitle()
	{	
		$sql 	= "SELECT id FROM  auto_completion WHERE title = ''";
		$rows 	= Yii::app()->db->createCommand($sql)->queryAll();
		$completionIds = array();
		foreach ($rows as $row) {
			$completionIds[] = $row['id'];
		}
	
		//$completionIds = array(28409);
		if (!empty($completionIds)) {
			$this->actionCompletionDetails($completionIds);
			//$this->actionSpecs();
			//$this->actionCompletionData($completionIds);
		}	
	}	
	
	
	public function actionC()
	{	
			$sql = "SELECT id FROM auto_completion WHERE url <> ''";
			
			$completionIds = array();
			$rows = Yii::app()->db->createCommand($sql)->queryAll();
			foreach ($rows as $row) {
				$completionIds[] = $row['id'];
			}
			
			if (!empty($completionIds)) {
				$this->actionCompletionDetails($completionIds);
				$this->actionSpecs();
				$this->actionCompletionData($completionIds);
			}
	}

	public function actionEmptyCompletion() {
		$sql = "SELECT * FROM  `auto_completion` WHERE  `specs_msrp` IS NULL";
		$completionIds = array();
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($rows as $row) {
			$completionIds[]=$row['id'];
		}

		if (!empty($completionIds)) {
			$this->actionCompletionDetails($completionIds);
			$this->actionSpecs();
			$this->actionCompletionData($completionIds);
		}		
	}
	
	private function actionModelYearPhoto($ids)
	{
		$criteria = new CDbCriteria();
		$criteria->addInCondition('id', $ids);		
		$autoModels = (array)AutoModelYear::model()->findAll($criteria);
		foreach ($autoModels as $keyYear=>$autoModelYear) {
			$url = "http://www.autoblog.com/buy/{$autoModelYear->year}-".str_replace(array(' '), array('+'), $autoModelYear->Model->Make->title)."-".str_replace(array(' '), array('+'), $autoModelYear->Model->title)."/photos/";
			
			$content = CUrlHelper::getPage($url, '', '');
			preg_match_all('/<img alt=(.*?)" class="rsImg" data-rsBigImg="(.*?)" data-rsTmb="(.*?)" src="(.*?)" \/><\/div>/', $content, $matches);
			
			
			echo "created Model Year photos " . $autoModelYear->id  . "\n" ;
			
			if (isset($matches[2])) {
				foreach ($matches[2] as $file_url) {
					$photo = new AutoModelYearPhoto;
					$photo->file_url = $file_url;
					$photo->year_id = $autoModelYear->id;
					$photo->save();
					echo "\t Photo" . $photo->id . "\n" ;
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

	public function actionNotCompletionSpecs()
	{	
		$sql 	= "SELECT id FROM  auto_completion WHERE id >= 34511";
		//$sql 	= "SELECT id FROM  auto_completion WHERE id >= 36135 AND id <= 36135";
		$rows 	= Yii::app()->db->createCommand($sql)->queryAll();
		$completionIds = array();
		foreach ($rows as $row) {
			$completionIds[] = $row['id'];
		}
	
		//$completionIds = array(28409);
		if (!empty($completionIds)) {
			$this->actionCompletionDetails($completionIds);
			$this->actionSpecs();
			$this->actionCompletionData($completionIds, array(158));
		}	
	}	

	private function getSpecs($attributes)
	{
		$mapAlias = array(
			'length' 			=> 'exterior_length',
			'body_width' 		=> 'exterior_body_width',
			'body_height' 		=> 'exterior_height',
			'front_head_room' 	=> 'front_headroom',
			'rear_head_room' 	=> 'rear_headroom',
			'front_leg_room' 	=> 'front_legroom',
			'rear_leg_room' 	=> 'rear_legroom',
			'curb' 				=> 'curb_weight',
			'gross_weight' 		=> 'gross_vehicle_weight_rating_gvwr_',
			'fuel_tank_capacity'=> 'fuel_tank',
		);
		
		$attributes['alias'] = AutoSpecs::slug($attributes['title']);
		$attributes['alias'] = AutoSpecs::slug($attributes['alias']);
		
		if (isset($mapAlias[$attributes['alias']])) {
			$attributes['alias'] = $mapAlias[$attributes['alias']];
		}
		
		$attributes['alias'] = trim($attributes['alias']);
		
		$model = AutoSpecs::model()->findByAttributes(array('alias'=>$attributes['alias']));
		
		if (empty($model)) {
			$model = new AutoSpecs;
			$model->attributes = $attributes;
			if(!$model->save()) {
				echo $attributes['alias'] . "\n";
				print_r($model->errors);
			}
		} 

		return $model;
	}	
	
	private function getOption($attributes)
	{
		$option = AutoSpecsOption::model()->findByAttributes($attributes);
						
		if (empty($option)) {
			$option = new AutoSpecsOption;
			$option->attributes = $attributes;
			$option->save();
		} 

		return $option;
	}	
	
	private function getCompletion($attributes)
	{
		$completion = AutoCompletion::model()->findByAttributes($attributes);
						
		if (empty($completion)) {
			$completion = new AutoCompletion;
			$completion->attributes = $attributes;
			$completion->is_active = 1;
			$completion->save(false);
		} 

		return $completion;
	}
	
	/*
	* Парсинг кодов комплектации
	*/	
	private function actionCompletion($ids)
	{
		$completionIds = array();
		
		$criteria = new CDbCriteria();
		$criteria->with = array('Model', 'Model.Make');
		$criteria->addInCondition('t.id', $ids);
		$criteria->addInCondition('t.year', array(date('Y'), (date('Y')+1)));
	
		$modelYears = AutoModelYear::model()->findAll($criteria);
		
		echo __FUNCTION__ . ' : ' . count($modelYears) . "\n";
		
		foreach ($modelYears as $keyYear=>$autoModelYear) {
			//echo $autoModelYear->id . ' - ' . $autoModelYear->year . ' ' . $autoModelYear->Model->Make->title . ' ' .  $autoModelYear->Model->title . "\n";
		
			$url = "http://www.autoblog.com/buy/{$autoModelYear->year}-".str_replace(array("-", " ", '&'), array("_", "_", "_"), $autoModelYear->Model->Make->title)."-".str_replace(array(" ", "-", "&"), array("+", "_", "_"), $autoModelYear->Model->title)."/specs/";
			$content = CUrlHelper::getPage($url, '', '');
			
			echo $url . "\n";
			
			$p = '/<div class="row"><div class="col-tn-12 col-xs-7"><div class="col-tn-6">(.*?)<\/div><div class="msrp col-tn-6">(.*?)<\/div><\/div><div class="col-tn-12 col-xs-5"><a href="/\buy\/(.*?)\/" class="btn btn-sm pull-left">/';
			//echo $p . "\n";
			preg_match_all($p, $content, $matches);
			
			print_r($matches);
			die();
			
			$modelYearTitle = $autoModelYear->year.'-'.$autoModelYear->Model->Make->title.'-'.str_replace('/', '\/', $autoModelYear->Model->title);
	
			foreach ($matches[1] as $k=>$match) {
				$expl = explode('/', $match);
				$url  = $expl[0];
				
				if ($k==0) {
					continue;
				}
				
				$completion = $this->getCompletion(array('model_year_id'=>$autoModelYear->id,'url'=>$url));
				$completionIds[] = $completion->id;
				echo "created  Completion " . $completion->id . "\n";				
			} 
		}
		
		return $completionIds;
	}	
	
	/*
	* Парсинг страницы комплектации
	*/	
	private function actionCompletionDetails($ids)
	{
			$criteria = new CDbCriteria();
			$criteria->addInCondition('t.id', $ids);	//
			$criteria->with = array('ModelYear', 'ModelYear.Model', 'ModelYear.Model.Make');	//
			
			$completions = AutoCompletion::model()->findAll($criteria);
			
			foreach ($completions as $key=>$completion) {
				//AutoCompletionSpecsTemp::model()->deleteAllByAttributes(array('completion_id'=>$completion->id));
				$url = "http://www.autoblog.com/buy/" . $completion->url . '/';
				
				if (stripos($completion->url, '__') <= 0) {
					$content = CUrlHelper::getPage($url . 'specs/', '', '');
					preg_match_all('/<a href="(.*?)"><h3 data-toggle="tooltip" itemprop="vehicleConfiguration" title="(.*?)" data-car="(.*?)">(.*?)<\/h3><\/a>/', $content, $matchUrl);
					
					if (!isset($matchUrl[0][1])) {
						echo "NOT: " . $completion->url . "\n";
						continue;
					}
					
					$expl = explode('/', $matchUrl[0][1]);
					$u = $expl[2];
					$url = "http://www.autoblog.com/buy/" . $u . '/';
				}

				$content = '';
				$content.= CUrlHelper::getPage($url . 'specs/', '', '');
				$content.= CUrlHelper::getPage($url . 'equipment/', '', '');
				$content.= CUrlHelper::getPage($url . 'pricing/', '', '');
				
				$count = substr_count($content, '<title>Autoblog Sitemap</title>');
				if (!$count) {
					echo "$completion->url ========================================= \n";				
					echo "$completion->id ========================================= \n";				
				}
				continue;
				
				//preg_match_all('/<table id="data_table" cellpadding="0" cellspacing="0" class="fixed_wrap">(.*?)<\/table>/', $content, $matchTable);
				preg_match_all('/<thead><tr><td>(.*?)<\/td><\/tr><\/thead>/', $content, $matchTable);
				preg_match_all('/<div class="price pull-left">(.*?)<\/div>/', $content, $matchPrice);
				preg_match_all('/<h1 class="pull-left">(.*?)<br><span class="trim-style">(.*?)<span id="pricing-page-title">Specs<\/span><\/span><\/h1>/', $content, $matchTitle);
				preg_match_all('/<div id="build-and-price" data-acode="(.*?)" data-state/', $content, $matchCode);
				
				$data = array();
				if (isset($matchPrice[1][0])) {
					$completion->specs_msrp = str_replace(array('$', ','), array('',''), $matchPrice[1][0]);
					$data['specs_msrp'] = $completion->specs_msrp;
				}
				if (isset($matchTitle[1][0])) {
					$completion->title = $matchTitle[1][0];
					$data['title'] = $completion->title;
				}
				
				if (isset($matchCode[1][0])) {
					$completion->code = $matchCode[1][0];
					$data['code'] = $completion->code;
				}
				
				print_r($data);
				
				$completion->save(false);
				
				$temp = array();
				
				//foreach ($matchTable[1] as $groupTitle) {
					//preg_match_all('/<table><thead><tr><td>'.$groupTitle.'<\/td><\/tr><\/thead>(.*?)<\/table>/', $content, $matchGroup);
					//$specsGroup = $this->getSpecsGroup(array('title'=>$groupTitle));
					
					//if (isset($matchGroup[1][1])) {
					if (true) {
						preg_match_all('/<tr><td class="type">(.*?)<\/td><td class="spec">(.*?)<\/td><\/tr>/', $content, $matchSpecs);
						
						foreach ($matchSpecs[1] as $k=>$specTitle) {
							$specsTitle = trim(strip_tags($specTitle));
							$specs = $this->getSpecs(array('title'=>$specsTitle));
							
							//echo $specs->id . "\n";
							
							$tempValue = strip_tags($matchSpecs[2][$k]);	
							$tempValue = str_replace('&#034;', '', $tempValue);	
							$tempValue = trim($tempValue);
							
							if (in_array($specs->id, array(157, 158))) {
								$tempValue = str_replace(',', '', $tempValue);
								$tempValue = (float) $tempValue;
								echo  "$specs->title:  {$tempValue} \n";
								
							}
							
							$completionSpecs = new AutoCompletionSpecsTemp;
							$completionSpecs->attributes = array(
								'completion_id' => $completion->id,
								'specs_id' => $specs->id,
								'value' => $tempValue,
							);
							
							$temp[] = array(
								't' => $specs->title,
								'v' => $tempValue,
								'id' => $specs->id,
							);
							
							try {
								$completionSpecs->save();
							} catch (Exception $exc) {
								//var_dump($exc);
							} 														
						}
					}									
				//}
				
				
				//print_r($temp);
				
				echo "parses specs: completion: {$completion->id} \n";
				//die();
				
				
				//$content.= CUrlHelper::getPage('http://www.autoblog.com/buy/2016-Jeep-Cherokee/specs/', '', '');
				preg_match_all('/<div class="rsContent col-tn-4"><div><a href="\/buy\/(.*?)-(.*?)-(.*?)\/"><img alt="(.*?)" class="rsImg" src="(.*?)" \/><h4>(.*?)<\/h4><\/a><\/div><\/div>/', $content, $matchCompetitorsContent);
			
				if (isset($matchCompetitorsContent[1][0])) {
					foreach ($matchCompetitorsContent[1] as $k=>$year) {
						$criteria = new CDbCriteria;
						$criteria->compare('t.year', $year);
						$criteria->compare('Model.title', $matchCompetitorsContent[3][$k]);
						$criteria->compare('Make.title', $matchCompetitorsContent[2][$k]);
						$criteria->with = array('Model', 'Model.Make');
						$competitorModelYear = AutoModelYear::model()->find($criteria);
						
						if (!empty($competitorModelYear)) {
							$competitor = new AutoModelYearCompetitor;
							$competitor->model_year_id = $completion->model_year_id;
							$competitor->competitor_id = $competitorModelYear->id;
							try {
								$competitor->save();
								echo "\t \t saved competitor\n";
							} catch (Exception $exc) {} 						
						}
					}
				}
			}
	}
	
	/*
	* Формируем тип полей характеристик
	* Добавляем сформирование поля в таблицу комплектаций
	*/
	private function actionSpecs()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('type', AutoSpecs::TYPE_SELECT);	//
		$specs = AutoSpecs::model()->findAll($criteria);		
		
		foreach ($specs as $spec) {
			$sql = "SELECT DISTINCT value as value FROM `auto_completion_specs_temp` WHERE specs_id={$spec->id} ORDER BY value";
			$rows = Yii::app()->db->createCommand($sql)->queryAll();	
			
			echo "Proces specs $spec->id: \n";
			
			foreach ($rows as $row) {
				$criteria = new CDbCriteria();
				$criteria->compare('specs_id', $spec->id);			
				$criteria->compare('value', $row['value']);	
						
				$option = AutoSpecsOption::model()->find($criteria);
				if (empty($option)) {
					$option = new AutoSpecsOption;
					$option->specs_id = $spec->id;
					$option->value = $row['value'];
					$option->save();
					echo "\t add option $option->id: \n";
				}
			}
		}
		
		$time = time();
		AutoSpecsOption::model()->deleteAll();
		$specs = AutoSpecs::model()->findAll();
		$countSelect = 0;
		$countFloatDD = 0;
		foreach ($specs as $spec)
		{
			$sql = "SELECT DISTINCT value as value FROM `auto_completion_specs_temp` WHERE specs_id={$spec->id} ORDER BY value";
			$rows = Yii::app()->db->createCommand($sql)->queryAll();
			$size = sizeof($rows);
			
			$type = AutoSpecs::TYPE_STRING;
			$append = '';
			
			if ($size > 0) {
			
				$checkAppends = array(
					'lbs\.'=>'lbs.', 
					'passengers'=>'passengers', 
					'mph'=>'mph', 
					'cu\.ft\.'=>'cu.ft.', 
					'gal\.'=>'gal.', 
					'doors'=>'doors',
					'mpg'=>'mpg',
					'seconds'=>'seconds',
				);
				
				$isMatch = false;
				
				if ($spec->id == 169) {
					$isMatch = true;
					$type = AutoSpecs::TYPE_FLOAT;
					$append = '"';	
				}
				if (in_array($spec->id, array(120))) {
					$isMatch = true;
					$type = AutoSpecs::TYPE_SELECT;
				}
				if (in_array($spec->id, array(113, 234))) {
					$isMatch = true;
					$type = AutoSpecs::TYPE_STRING;
				}
				
				if (!$isMatch) {
					foreach ($checkAppends as $checkAppendKey=>$checkAppendValue) {
						if (preg_match("/^[0-9]{1,10}[\,][0-9]{1,10} $checkAppendKey/", $rows[0]['value'])) {
							echo $rows[0]['value'] . "\n";
							$append = $checkAppendValue;
							$type = AutoSpecs::TYPE_FLOAT;
							$isMatch = true;
						} else if (preg_match("/^[0-9]{1,10}[\.][0-9]{1,10} $checkAppendKey/", $rows[0]['value'])) {
							echo $rows[0]['value'] . "\n";
							$append = $checkAppendValue;
							$type = AutoSpecs::TYPE_FLOAT;
							$isMatch = true;
							
						} else if (preg_match("/^[0-9]{1,10} $checkAppendKey/", $rows[0]['value'])) {
							echo $rows[0]['value'] . "\n";
							$append = $checkAppendValue;
							$type = AutoSpecs::TYPE_INT;
							$isMatch = true;
						}					
					}
				}
				
				if (!$isMatch) {
				
					if (preg_match('/^[\$][0-9]{1,10}[\,][0-9]{1,5}/', $rows[0]['value'])) {
						echo $spec->id . " " . $rows[0]['value'] . "\n";
						$type = AutoSpecs::TYPE_INT;
						$append = '$';
						
					} else if (preg_match('/^[\$][0-9]{1,10}/', $rows[0]['value'])) {
						echo $spec->id . " " . $rows[0]['value'] . "\n";
						$type = AutoSpecs::TYPE_INT;
						$append = '$';					
											
					} else if (preg_match('/^[0-9]{1,10}[\.]{1}[0-9]{1,10} \"/', $rows[0]['value']) || preg_match('/^[0-9]{1,10}[\.]{1}[0-9]{1,10} \'\'/', $rows[0]['value'])) {
						echo $spec->id . " " . $rows[0]['value'] . "\n";
						$type = AutoSpecs::TYPE_FLOAT;
						$append = '"';					
						
					} else if (preg_match('/^[0-9]{1,10} \"/', $rows[0]['value']) || preg_match('/^[0-9]{1,10} \'\'/', $rows[0]['value'])) {
						echo $spec->id . " " . $rows[0]['value'] . "\n";
						$type = AutoSpecs::TYPE_INT;
						$append = '"';						
						
					} else if (preg_match('/^[\.][0-9]{1,10}/', $rows[0]['value'])) {
						echo $spec->id . " " . $rows[0]['value'] . "\n";
						$type = AutoSpecs::TYPE_FLOAT;
						$append = '';						

					} else if (preg_match('/^[0-9]{1,10}$/', $rows[0]['value'])) {
						echo $spec->id . " " . $rows[0]['value'] . "\n";
						$type = AutoSpecs::TYPE_INT;
						$append = '';
						
					} else if ($size <= 100 && $size >= 2) {

						foreach ($rows as $row) {
							$option = $this->getOption(array('specs_id'=>$spec->id, 'value'=>$row['value']));
							echo "\t option - $option->value \n";
						}

						$type = AutoSpecs::TYPE_SELECT;
						$append = '';					
					}
				}
				
				$spec->type = $type;
				$spec->append = $append;
				$spec->save(false);	

				echo $spec->id . ' ' .$spec->alias . ' ' . $spec->type . "\n";
			} 		
		}
		
		$t = time()-$time;
		echo $t;
	}
	
	/*
	* Заполняем поля таблицы комплектации значениямы
	*/
	private function actionCompletionData($ids, $specsIds=array())
	{
			$specsData = AutoSpecs::getAllWithAttributes();
	
			$criteria = new CDbCriteria();
			$criteria->addInCondition('id', $ids);	
			
			$completions = AutoCompletion::model()->findAll($criteria);

			foreach ($completions as $key=>$completion) {
				$criteria = new CDbCriteria();
				$criteria->compare('completion_id', $completion->id);				
			
				$completionSpecs = AutoCompletionSpecsTemp::model()->findAll($criteria);	
				foreach ($completionSpecs as $completionSpec) {
					if (!empty($specsIds) && !in_array($completionSpec['specs_id'], $specsIds)) {
						continue;
					}
					
					
					$specData = $specsData[$completionSpec['specs_id']];
				
					$value = trim($completionSpec->value);
						
					if (in_array($value, array('-'))) {
						$value = null;
					} else {
					
						if ($specData['type'] == AutoSpecs::TYPE_INT) {
							$value = str_replace(',', '.', $value);
							$value = (int) str_replace(array('$', ',', '"'. "'", 'lbs.', 'mph', 'cu.ft.', 'gal.', 'doors', 'passengers', 'mpg', 'seconds', '&#034;'), '', $value);
						} else if ($specData['type'] == AutoSpecs::TYPE_FLOAT) {
							$value = str_replace(',', '.', $value);
							$value = (float) str_replace(array('$', ',', '"'. "'", 'lbs.', 'mph', 'cu.ft.', 'gal.', 'doors', 'passengers', 'mpg','seconds', '&#034;'), '', $value);
						} else if ($specData['type'] == AutoSpecs::TYPE_SELECT) {
							$value = AutoSpecsOption::getIdByValueAndSpecsId($specData['id'], $value);
						}
					}
						
					$attr = AutoCompletion::PREFIX_SPECS . $specData['alias'];
					if ($completion->hasAttribute($attr) && !empty($value))
						$completion->$attr = $value;				
			
				}
				unset($completionSpecs);
				$completion->validateSpecs = false;
				$completion->validateTitle = false;
				if(!$completion->save()) {
					//print_r($completion->errors);
					//die();
				}
						
				echo 'Completion Data ' . $completion->id . "\n";
			}
			unset($completions);
	}
	
	public function actionModelYearPhotoItem()
	{
		$sql = "SELECT DISTINCT CONCAT(model_id, '_', year) AS ccc, model_id, year, url, file_name FROM  auto_model_year";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		$i = 0;
		$urls = array();
		$keyIsFile = 0;
		foreach ($rows as $row) {
			$file = Yii::getPathOfAlias('webroot'). '/photos/model_year_item/' . $row['file_name'];
			if (is_file($file)) {
				echo $keyIsFile . ' ' . $file . "\n";
				$keyIsFile++;
				continue;
			}
		
			$s = "-".$row['year'];
			$url = str_replace(array("cars-", $s), array("",""), $row['url']);
			$url = 'http://www.autoblog.com'.$url;
			$urls[$url] = $url;
		}
		
		foreach ($urls as $url) {

			$content = Yii::app()->cache->get($url);
			$content = str_replace(array(" ", "\n", "\t", "\r"), array("","","",""), $content);
			if ($content == false) {
				$content = CUrlHelper::getPage($url, '', '');	
				Yii::app()->cache->set($url, $content, 60*60*24);
			}

			preg_match_all('/<divclass="mkencl"><divclass="img"><imgsrc="(.*?)"width="150"height="93"style="padding-top:12px"alt="(.*?)"\/><\/div><divclass="data"><ul><liclass="sub_title"><ahref="(.*?)">(.*?)<\/a><\/li><liclass="info">/', $content, $matches);
			preg_match_all('/<divclass="img"><imgsrc="(.*?)"width="150"height="113"alt="(.*?)"\/><\/div><divclass="data"><ul><liclass="sub_title"><ahref="(.*?)">(.*?)<\/a><\/li><liclass="info">/', $content, $matchesTwo);
			//file_put_contents('x.txt', $content);

			foreach ($matches[3] as $k=>$url) {
				$criteria = new CDbCriteria();
				$criteria->compare('url', $url);				
				$modelYear = AutoModelYear::model()->find($criteria);	
				if (!empty($modelYear)) {
					$data = explode('"', $matches[1][$k]);
					$modelYear->file_url = $data[0];
					$modelYear->save();
					echo "$i \t" . $modelYear->id . " " .$modelYear->file_url. "\n";
				}

				$i++;
			}  

			foreach ($matchesTwo[3] as $k=>$url) {
				$criteria = new CDbCriteria();
				$criteria->compare('url', $url);				
				$modelYear = AutoModelYear::model()->find($criteria);	
				if (!empty($modelYear)) {
					$data = explode('"', $matchesTwo[1][$k]);
					$modelYear->file_url = $data[0];
					$modelYear->save();
					echo "$i \t" . $modelYear->id . " " .$modelYear->file_url. "\n";
				}

				$i++;
			}  
		}
	}	
	
	
}
?>