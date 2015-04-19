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
		$sql = "SELECT DISTINCT model_year_id AS model_year_id FROM `auto_completion`";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		$ids = array();
		foreach ($rows as $row) {
			$ids[] = $row['model_year_id'];
		}
		
		if (!empty($ids)) {
			$criteria = new CDbCriteria();
			$criteria->addNotInCondition('id', $ids);				
			$modelYears = AutoModelYear::model()->findAll($criteria);		
			$parsedModelYearIds = array();
			foreach ($modelYears as $modelYear) {
				$parsedModelYearIds[] = $modelYear->id;
			}	
			
			if (!empty($parsedModelYearIds)) {
				$completionIds = $this->actionCompletion($parsedModelYearIds);
											
				if (!empty($completionIds)) {
					$this->actionCompletionDetails($completionIds);
					$this->actionSpecs();
					$this->actionCompletionData($completionIds);
					$this->actionCompetitor();
				}
			}	
		}
	}

	protected function actionBodyStyle()
	{
		$url = 'http://autoblog.com/new-cars/';
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
		$url = 'http://autoblog.com/api/taxonomy/newmake/';
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
	
	public function actionModelYear()
	{
		$modelYearIds = array();
		$dataMake = array();
		$dataModel = array(
			'Chrysler' => array('Town-Country'=>228),
		);
		
		$year = date('Y');
		$content = CUrlHelper::getPage("http://www.autoblog.com/car-finder/year-{$year}/");
		preg_match_all('/<span class="pageCntr"> Page <strong>1<\/strong> of <strong>(.*?)<\/strong><\/span>/', $content, $matchesPager);
		if (isset($matchesPager[1][1]) && is_numeric($matchesPager[1][1])) {
			for ($page=1; $page<=$matchesPager[1][1]; $page++) {
				$notFound = false;
				
				$url = "http://www.autoblog.com/car-finder/year-{$year}/{$page}/";
				$content = CUrlHelper::getPage($url);
				preg_match_all('/<a class="overviewTitle" href="\/buy\/'.$year.'\-(.*?)\-(.*?)\/">(.*?)<\/a>/', $content, $matches);
				preg_match_all('/<div class="carImg"><a href="\/buy\/(.*?)\/"><img src="(.*?)" alt="(.*?)" \/><\/a><\/div>/', $content, $matchesImage);
				$imagesData = array();
				foreach ($matchesImage[0] as $key=>$val) {	
					$imagesData[trim($matchesImage[3][$key])] = $matchesImage[2][$key];
				}
				
				foreach ($matches[1] as $key=>$makeTitle) {
					$modelTitle = $matches[2][$key];
					$makeTitle	= str_replace(array('_', '+'), array('-', ' '), $makeTitle);
					$modelTitle	= str_replace(array('_', '+'), array('-', ' '), $modelTitle);
					
					
					$aliasMake = TextHelper::urlSafe(str_replace(' ', '+', $makeTitle));
					$modelAlias = TextHelper::urlSafe(str_replace(' ', '+', $modelTitle));
					
					if (!isset($dataMake[$aliasMake])) {
						$make = AutoMake::model()->findByAttributes(array('alias'=>$aliasMake));
						if (!empty($make)) {
							$dataMake[$aliasMake] = $make->id;
						} else {
							echo "Make $makeTitle not found \n";
							$notFound = true;
						}
					}
					
					
					
					if (isset($dataMake[$aliasMake]) && !isset($dataModel[$aliasMake][$modelAlias])) {
						$model = AutoModel::model()->findByAttributes(array('alias'=>$modelAlias, 'make_id'=>$dataMake[$aliasMake]));
						if (!empty($model)) {
							$dataModel[$aliasMake][$modelAlias] = $model->id;
						} else { 
							echo "model $makeTitle $modelTitle not found \n";
							$notFound = true;
						}
					}
					
					if (!$notFound) {
						$modelYear = AutoModelYear::model()->findByAttributes(array(
							'year' => $year,
							'model_id' => $dataModel[$aliasMake][$modelAlias],
						));
						
						if (empty($modelYear)) {
							$modelYear = new AutoModelYear;
							
							$keyImage = "{$year} {$model->Make->title} {$model->title}";
							if (isset($imagesData[$keyImage])) {
								$modelYear->file_url = $imagesData[$keyImage];
								$modelYear->file_name = "{$model->Make->title}-{$model->title}-{$year}.jpg";	
							}
													
							$modelYear->is_active = 1;
							$modelYear->year = $year;
							$modelYear->model_id = $dataModel[$aliasMake][$modelAlias];
							if ($modelYear->save()) {
								$modelYearIds[] = $modelYear->id;
								echo "ModelYear: {$modelYear->id} - $year $makeTitle $modelTitle \n";
							} else {
								echo "ModelYear: $year $makeTitle $modelTitle \n";
								print_r($modelYear->errors);
							}							
						}
					}	
				}
			}
		}
		
		return $modelYearIds;
	}	
	
	public function _actionModelYearNext()
	{
		$modelYearIds = array();
		$dataMake = array();
		$dataModel = array(
			'Chrysler' => array('Town-Country'=>228),
		);
		
		$year = date('Y') + 1;		
		if (true) {
			for ($page=1; $page<=10; $page++) {
				$notFound = false;
				
				$url = "http://www.autoblog.com/car-finder/sort-yr/{$page}/";
				$content = CUrlHelper::getPage($url);
				//preg_match_all('/<a class="overviewTitle" href="\/buy\/'.$year.'\-(.*?)\-(.*?)\/">(.*?)<\/a>/', $content, $matches);
				//preg_match_all('/<div class="carImg"><a href="\/buy\/(.*?)\/"><img src="(.*?)" alt="(.*?)" \/><\/a><\/div>/', $content, $matchesImage);
				$imagesData = array();
				foreach ($matchesImage[0] as $key=>$val) {	
					$imagesData[trim($matchesImage[3][$key])] = $matchesImage[2][$key];
				}
				
				foreach ($matches[1] as $key=>$makeTitle) {
					$modelTitle = $matches[2][$key];
					
					if ((int)$matches[3][$key] != $year) {
						break 2;
					}
					
					$makeTitle	= str_replace(array('_', '+'), array('-', ' '), $makeTitle);
					$modelTitle	= str_replace(array('_', '+'), array('-', ' '), $modelTitle);
					
					
					$aliasMake = TextHelper::urlSafe(str_replace(' ', '+', $makeTitle));
					$modelAlias = TextHelper::urlSafe(str_replace(' ', '+', $modelTitle));
					
					if (!isset($dataMake[$aliasMake])) {
						$make = AutoMake::model()->findByAttributes(array('alias'=>$aliasMake));
						if (!empty($make)) {
							$dataMake[$aliasMake] = $make->id;
						} else {
							echo "Make $makeTitle not found \n";
							$notFound = true;
						}
					}
					
					if (isset($dataMake[$aliasMake]) && !isset($dataModel[$aliasMake][$modelAlias])) {
						$model = AutoModel::model()->findByAttributes(array('alias'=>$modelAlias, 'make_id'=>$dataMake[$aliasMake]));
						if (!empty($model)) {
							$dataModel[$aliasMake][$modelAlias] = $model->id;
						} else { 
							echo "model $makeTitle $modelTitle not found \n";
							$notFound = true;
						}
					}
					
					if (!$notFound) {
						$modelYear = AutoModelYear::model()->findByAttributes(array(
							'year' => $year,
							'model_id' => $dataModel[$aliasMake][$modelAlias],
						));
						
						if (empty($modelYear)) {
							$modelYear = new AutoModelYear;
							
							$keyImage = "{$year} {$model->Make->title} {$model->title}";
							if (isset($imagesData[$keyImage])) {
								$modelYear->file_url = $imagesData[$keyImage];
								$modelYear->file_name = "{$model->Make->title}-{$model->title}-{$year}.jpg";	
							}
													
							$modelYear->is_active = 1;
							$modelYear->year = $year;
							$modelYear->model_id = $dataModel[$aliasMake][$modelAlias];
							if ($modelYear->save()) {
								$modelYearIds[] = $modelYear->id;
								echo "ModelYear: {$modelYear->id} - $year $makeTitle $modelTitle \n";
							} else {
								echo "ModelYear: $year $makeTitle $modelTitle \n";
								print_r($modelYear->errors);
							}							
						}
					}	
				}
			}
		}
		
		return $modelYearIds;
	}	
	
	public function actionModelYearNext()
	{
		echo "============================================== \n";
		
		$modelYearIds = array();
		$dataMake = array();
		$dataModel = array(
			'Chrysler' => array('Town-Country'=>228),
		);
		
		$year = date('Y') + 1;		
		if (true) {
			for ($page=1; $page<=3; $page++) {
				$notFound = false;
				
				$p=($page==1)?"":"pg-{$page}/";
				$url = "http://www.autoblog.com/car-finder/{$year}/{$p}";
				echo $url . "\n";
				$content = CUrlHelper::getPage($url);
				$content = str_replace(array("\n", "\t", "\r"), "", $content);
				
				preg_match_all('/<div class="trim__desc hidden-xs hidden-tn"><div class="h4"><a class="desc__link" href="http:\/\/www.autoblog.com\/buy\/'.$year.'\-(.*?)\-(.*?)\/">(.*?)<\/a><\/div><\/div>/', $content, $matches);
				preg_match_all('/<div class="col col-tn-6 col-sm-3 col--photo">(.*?)src="(.*?)" alt="(.*?)"(.*?)<\/div>/', $content, $matchesImage);

				$imagesData = array();
				foreach ($matchesImage[0] as $key=>$val) {	
					$imagesData[trim($matchesImage[3][$key])] = $matchesImage[2][$key];
				}
					
				echo count($imagesData) . "\n";	
				print_r($imagesData);	
	
				foreach ($matches[1] as $key=>$makeTitle) {
					$modelTitle = $matches[2][$key];
					
					$makeTitle	= str_replace(array('_', '+'), array('-', ' '), $makeTitle);
					$modelTitle	= str_replace(array('_', '+'), array('-', ' '), $modelTitle);
					
					
					$aliasMake = TextHelper::urlSafe(str_replace(' ', '+', $makeTitle));
					$modelAlias = TextHelper::urlSafe(str_replace(' ', '+', $modelTitle));
					
					if (!isset($dataMake[$aliasMake])) {
						$make = AutoMake::model()->findByAttributes(array('alias'=>$aliasMake));
						if (!empty($make)) {
							$dataMake[$aliasMake] = $make->id;
						} else {
							echo "Make $makeTitle not found \n";
							$notFound = true;
						}
					}
					
					if (isset($dataMake[$aliasMake]) && !isset($dataModel[$aliasMake][$modelAlias])) {
						$model = AutoModel::model()->findByAttributes(array('alias'=>$modelAlias, 'make_id'=>$dataMake[$aliasMake]));
						if (!empty($model)) {
							$dataModel[$aliasMake][$modelAlias] = $model->id;
						} else { 
							echo "model $makeTitle $modelTitle not found \n";
							$notFound = true;
						}
					}
					
					if (!$notFound) {
						$modelYear = AutoModelYear::model()->findByAttributes(array(
							'year' => $year,
							'model_id' => $dataModel[$aliasMake][$modelAlias],
						));
						
						if (empty($modelYear)) {
							$modelYear = new AutoModelYear;
							
							$keyImage = "{$year} {$model->Make->title} {$model->title}";
							if (isset($imagesData[$keyImage])) {
								$modelYear->file_url = $imagesData[$keyImage];
								$modelYear->file_name = "{$model->Make->title}-{$model->title}-{$year}.jpg";	
							}
													
							$modelYear->is_active = 1;
							$modelYear->year = $year;
							$modelYear->model_id = $dataModel[$aliasMake][$modelAlias];
							if ($modelYear->save()) {
								$modelYearIds[] = $modelYear->id;
								echo "ModelYear: {$modelYear->id} - $year $makeTitle $modelTitle \n";
							} else {
								echo "ModelYear: $year $makeTitle $modelTitle \n";
								print_r($modelYear->errors);
							}							
						}
					}	
				}
			}
		}
		
		print_r($modelYearIds);
		
		return $modelYearIds;
	}	
	
	
	
	public function actionCatalog()
	{	
		$this->actionMake();
		$this->actionModel();
		$parsedModelYearIds = $this->actionModelYear();
		$parsedModelYearIds = array_merge($parsedModelYearIds, $this->actionModelYearNext());
		
		//$parsedModelYearIds = range(5887, 5896);

		if (!empty($parsedModelYearIds)) {
			//$this->actionModelYearPhoto($parsedModelYearIds);
			$completionIds = $this->actionCompletion($parsedModelYearIds);
			
			//$completionIds = range(27250, 28000);
			
			if (!empty($completionIds)) {
				$this->actionCompletionDetails($completionIds);
				$this->actionSpecs();
				$this->actionCompletionData($completionIds);
				$this->actionCompetitor();
			}
		}
		
		$this->actionNotModelYear();
		$this->actionEmptyCompletion();
	}	
	
	public function actionEmptyCompletion() {
		Yii::app()->cache->flush();
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
			$this->actionCompetitor();
		}		
	}
	
	private function actionModelYearPhoto($ids)
	{
		$criteria = new CDbCriteria();
		$criteria->addInCondition('id', $ids);		
		$autoModels = (array)AutoModelYear::model()->findAll($criteria);
		foreach ($autoModels as $keyYear=>$autoModelYear) {
			$url = "http://autoblog.com".$autoModelYear->url."photos/";
			
			$content = CUrlHelper::getPage($url, '', '');
			preg_match_all('/<a href="http:\/\/o.aolcdn.com\/commerce\/images\/(.*?)_Large.jpg">/', $content, $matches);
			
			echo "Model Year photos " . $autoModelYear->id  . "\n" ;
			
			if (isset($matches[1])) {
				foreach ($matches[1] as $file) {
					$file_url = "http://o.aolcdn.com/commerce/images/{$file}_Large.jpg";
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
		print_r($ids);
		die();
		
		$completionIds = array();
		
		$criteria = new CDbCriteria();
		$criteria->with = array('Model', 'Model.Make');
		$criteria->addInCondition('t.id', $ids);
	
		$modelYears = AutoModelYear::model()->findAll($criteria);
		foreach ($modelYears as $keyYear=>$autoModelYear) {
			echo $autoModelYear->id . ' - ' . $autoModelYear->year . ' ' . $autoModelYear->Model->Make->title . ' ' .  $autoModelYear->Model->title . "\n";
		
			$url = "http://www.autoblog.com/buy/{$autoModelYear->year}-".str_replace(array("-", " ", '&'), array("_", "_", "_"), $autoModelYear->Model->Make->title)."-".str_replace(array(" ", "-", "&"), array("+", "_", "_"), $autoModelYear->Model->title)."/specs/";
			$url = str_replace(array('+'), array(''), $url);
			echo "$url \n";
			
			$content = CUrlHelper::getPage($url, '', '');

			preg_match_all('/<liclass="tools_first"><ahref="http:\/\/www.autoblog.com\/cars\-compare\?v1=(.*?)&amp;type=other">CompareCars<\/a><\/li>/', str_replace(array("\n", "\t", "\r"," "), "", $content), $matches);			
			print_r($matches);			
			die();
						
			if (isset($matches[1][0])) {					
				$linkCompare = 'http://www.autoblog.com/cars-compare?v1='.$matches[1][0].'&type=other';
				$contentCompare = CUrlHelper::getPage($linkCompare, '', '');	
				preg_match_all('/<select name="trim_1" class="trimSelecter" id="compTrimList1">(.*?)<\/select>/', str_replace(array("\n", "\t", "\r"), "", $contentCompare), $matches);
				preg_match_all('/<option value="(.*?)">(.*?)<\/option>/', $matches[1][0], $matchOptions);
				foreach ($matchOptions[1] as $key=>$code) {
					$completion = $this->getCompletion(array('model_year_id'=>$autoModelYear->id,'code'=>$code, 'title'=>$matchOptions[2][$key]));
					echo "\t  Completion " . $completion->id . ' - ' . $completion->title . "\n";
					$completionIds[] = $completion->id;
				}
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
			$criteria->addInCondition('id', $ids);	//
			
			$completions = AutoCompletion::model()->findAll($criteria);
			
			foreach ($completions as $key=>$completion) {
				AutoCompletionSpecsTemp::model()->deleteAllByAttributes(array('completion_id'=>$completion->id));
				$url = "http://autoblog.com/cars-compare?cur_page=details&v1={$completion->code}&v2=&v3=&v4=&v5=&v6=&v7=&v8=&v9=";
				
				$content = Yii::app()->cache->get($url);
				if ($content == false) {
					$content = CUrlHelper::getPage($url, '', '');	
					Yii::app()->cache->set($url, $content, 60*60*24);
				}	
				$content = str_replace(array("\n", "\t", "\r"), "", $content);
				
				preg_match_all('/<table id="data_table" cellpadding="0" cellspacing="0" class="fixed_wrap">(.*?)<\/table>/', $content, $matchTable);
				
				$headerTrs = explode('<tr class="header">', $matchTable[1][0]);
				
				$dataSpecsGroup = array();
				foreach ($headerTrs as $trKey=>$headerTr) {
					if ($trKey < 2) continue;
					preg_match_all('/<td class="anchor label"><span><em>Compare<\/em>(.*?)<\/span><\/td>/', $headerTr, $matchGroup);
					preg_match_all('/<tr(.*?)class="data(.*?)"><td class="anchor label"><span>(.*?)<\/span><\/td><td class="anchor right_bor(.*?)">(.*?)<\/td>/', $headerTr, $matchSpecs);
					
					$specsGroupTitle = trim($matchGroup[1][0]);
					$specsGroup = $this->getSpecsGroup(array('title'=>$specsGroupTitle));
						
					foreach ($matchSpecs[3] as $specsKey=>$matchSpecTitle) {
						$specsTitle = trim(strip_tags($matchSpecTitle));
						$specs = $this->getSpecs(array('title'=>$specsTitle, 'group_id'=>$specsGroup->id));
						$tempValue = strip_tags($matchSpecs[5][$specsKey]);
						
						$dataSpecsGroup[$specsGroup->title][$specs->title] = $tempValue;
						
						$completionSpecs = new AutoCompletionSpecsTemp;
						$completionSpecs->attributes = array(
							'completion_id' => $completion->id,
							'specs_id' => $specs->id,
							'value' => $tempValue,
						);
						
						$completionSpecs->save();										
					}	
				}

				$competitorCount = 0;
				if (substr_count($content, "Competitors for") == 1) {
					preg_match_all('/<a href="#top-chooser" class="addVeh add" name="(.*?)">Add to Compare<\/a>/', $content, $matches);	
					
					if (isset($matches[1]) && !empty($matches[1])) {
						foreach ($matches[1] as $competitor_code) {
							$competitorCompletion = AutoCompletion::model()->findByAttributes(array('code'=>$competitor_code));
							if (!empty($competitorCompletion)) {
								
								$competitorsTemp = new AutoCompletionCompetitorsTemp;
								$competitorsTemp->completion_id = $completion->id;
								$competitorsTemp->competitor_id = $competitorCompletion->id;
								$competitorsTemp->is_parsed = 1;
								try {
								  $competitorsTemp->save();
								} catch (Exception $exc) {
								  
								} 								
								
								$competitorCount++;
							}	
						}
					}	
				}
				
				echo "Completion parsed " . $completion->id . ' ' . $competitorCount . "\n";
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
		
		/*
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
		*/
	}
	
	/*
	* Заполняем поля таблицы комплектации значениямы
	*/
	private function actionCompletionData($ids)
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
					$specData = $specsData[$completionSpec['specs_id']];
				
					$value = trim($completionSpec->value);
						
					if (in_array($value, array('-'))) {
						$value = null;
					} else {
					
						if ($specData['type'] == AutoSpecs::TYPE_INT) {
							$value = (int) str_replace(array('$', ',', '"'. "'", 'lbs.', 'mph', 'cu.ft.', 'gal.', 'doors', 'passengers', 'mpg', 'seconds'), '', $value);
						} else if ($specData['type'] == AutoSpecs::TYPE_FLOAT) {
							$value = (float) str_replace(array('$', ',', '"'. "'", 'lbs.', 'mph', 'cu.ft.', 'gal.', 'doors', 'passengers', 'mpg','seconds'), '', $value);
						} else if ($specData['type'] == AutoSpecs::TYPE_SELECT) {
							$value = AutoSpecsOption::getIdByValueAndSpecsId($specData['id'], $value);
						}
					}
						
					$attr = AutoCompletion::PREFIX_SPECS . $specData['alias'];
					if ($completion->hasAttribute($attr) && !empty($value))
						$completion->$attr = $value;				
			
				}
				unset($completionSpecs);

				$completion->save();
						
				echo 'Completion Data ' . $completion->id . "\n";
			}
			unset($completions);
	}

	/*
	* Конкуренты моделей по годах
	*/	
	private function actionCompetitor()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('is_parsed', 1);	
			
		$completionCompetitors = AutoCompletionCompetitorsTemp::model()->findAll($criteria);

		foreach ($completionCompetitors as $completionCompetitor) {
			$completionCompetitor->is_parsed = 0;
			$completionCompetitor->save();
			
			if (isset($completionCompetitor->Completion) && isset($completionCompetitor->Competitor)) {
			
				$attributes = array(
					'model_year_id' => $completionCompetitor->Completion->model_year_id,
					'competitor_id' => $completionCompetitor->Competitor->model_year_id
				);
					
				$m = AutoModelYearCompetitor::model()->findByAttributes($attributes);
				if (empty($m)) {
					$autoModelYearCompetitor = new AutoModelYearCompetitor;
					$autoModelYearCompetitor->attributes = $attributes;
					$autoModelYearCompetitor->save();
				}
					
				echo "Add Competitors \n";
			}
		}
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
			$url = 'http://autoblog.com'.$url;
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