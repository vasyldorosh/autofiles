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
			$ids[$row['model_year_id']] = $row['model_year_id'];
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
	
	public function actionModelYear($year)
	{
		$modelYearIds = array();
		$dataMake = array();
		$dataModel = array(
			'Chrysler' => array('Town-Country'=>228),
		);
		
		$content = CUrlHelper::getPage("http://www.autoblog.com/car-finder/year-{$year}/");
		preg_match_all('/<span id="TotalResults">(.*?)<\/span>/', $content, $matchesPager);
		
		//DELETE
		//AutoModelYear::model()->deleteAllByAttributes(['year'=>$year]);
		
		if (isset($matchesPager[1][0]) && is_numeric($matchesPager[1][0])) {
			for ($page=1; $page<=$matchesPager[1][0]; $page++) {
					
				$url = "http://www.autoblog.com/car-finder/{$year}/";
				if ($page > 1) {
					$url.= 'pg-'.$page.'/';
				}
				
				//DELETE
				//if ($page > 2) {continue;}
				
				//echo "PAGE: $page - $url \n";	
				
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
							
							echo "created: model $makeTitle $modelTitle \n";
						}
						
						$dataModel[$aliasMake][$modelAlias] = $model->id;
				
					}
					
					if (1) {
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
								echo "created: ModelYear: {$modelYear->id} - $year $makeTitle $modelTitle \n";
							} 							
						} else {
							echo "isset: ModelYear: {$modelYear->id} - $year $makeTitle $modelTitle \n";
						}
					}	
				}
			}
		} else {
			echo __FUNCTION__ . ": paggionation \n";
		}
		
		return $modelYearIds;
	}	
	
	public function actionCatalog()
	{	
		$this->actionMake();
		$this->actionModel();
		$parsedModelYearIds = $this->actionModelYear(date('Y'));
		$parsedModelYearIds = array_merge($parsedModelYearIds, $this->actionModelYear(date('Y')+1));
		
		//$parsedModelYearIds = range(7473, 7480);
	
		if (!empty($parsedModelYearIds)) {
			$this->actionModelYearPhoto($parsedModelYearIds);
			$completionIds = $this->actionCompletion($parsedModelYearIds);
			
			//$completionIds = range(27814, 27765);
			
			if (!empty($completionIds)) {
				$this->actionCompletionDetails($completionIds);
				$this->actionSpecs();
				$this->actionCompletionData($completionIds);
			}
		}
		
		$this->actionNotModelYear();
		$this->actionEmptyCompletion();
		
		CUrlHelper::getPage('http://autofiles.com/site/flush', '', '');
	}	
	
	public function actionC()
	{	
			$completionIds = range(34511, 35594);
			
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
			$url = "http://autoblog.com/buy/{$autoModelYear->year}-".str_replace(array(' '), array('+'), $autoModelYear->Model->Make->title)."-".str_replace(array(' '), array('+'), $autoModelYear->Model->title)."/photos/";
			
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
	
	private function getSpecs($attributes)
	{
		$attributes['alias'] = AutoSpecs::slug($attributes['title']);
		$attributes['alias'] = AutoSpecs::slug($attributes['alias']);
		
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
	
		$modelYears = AutoModelYear::model()->findAll($criteria);
		foreach ($modelYears as $keyYear=>$autoModelYear) {
			//echo $autoModelYear->id . ' - ' . $autoModelYear->year . ' ' . $autoModelYear->Model->Make->title . ' ' .  $autoModelYear->Model->title . "\n";
		
			$url = "http://www.autoblog.com/buy/{$autoModelYear->year}-".str_replace(array("-", " ", '&'), array("_", "_", "_"), $autoModelYear->Model->Make->title)."-".str_replace(array(" ", "-", "&"), array("+", "_", "_"), $autoModelYear->Model->title)."/specs/";
			$content = CUrlHelper::getPage($url, '', '');
			$p = '/<a href="\/buy\/(.*?)" class="btn btn-sm pull-left visible-sm visible-xs visible-tn">Explore<\/a>/';
			//echo $p . "\n";
			preg_match_all($p, $content, $matches);
			$modelYearTitle = $autoModelYear->year.'-'.$autoModelYear->Model->Make->title.'-'.str_replace('/', '\/', $autoModelYear->Model->title);
			
			foreach ($matches[1] as $k=>$match) {
				$expl = explode('/', $match);
				$url  = $expl[0];
				
				if (trim($modelYearTitle) == trim($url)) {
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
				AutoCompletionSpecsTemp::model()->deleteAllByAttributes(array('completion_id'=>$completion->id));
				$url = "http://www.autoblog.com/buy/" . $completion->url . '/';
				$content = '';
				$content.= CUrlHelper::getPage($url . 'specs/', '', '');
				$content.= CUrlHelper::getPage($url . 'equipment/', '', '');
				$content.= CUrlHelper::getPage($url . 'pricing/', '', '');
				
				//preg_match_all('/<table id="data_table" cellpadding="0" cellspacing="0" class="fixed_wrap">(.*?)<\/table>/', $content, $matchTable);
				preg_match_all('/<thead><tr><td>(.*?)<\/td><\/tr><\/thead>/', $content, $matchTable);
				preg_match_all('/<div class="price pull-left">(.*?)<\/div>/', $content, $matchPrice);
				preg_match_all('/<h1 class="pull-left">(.*?)<br><span class="trim-style">(.*?)<span id="pricing-page-title">Specs<\/span><\/span><\/h1>/', $content, $matchTitle);
				preg_match_all('/<div id="build-and-price" data-acode="(.*?)" data-state/', $content, $matchCode);
				
				file_put_contents('xxx.txt', $content);
				
				if (isset($matchPrice[1][0])) {
					$completion->specs_msrp = str_replace(array('$', ','), array('',''), $matchPrice[1][0]);
				}
				if (isset($matchTitle[1][0])) {
					$completion->title = $matchTitle[1][0];
				}
				if (isset($matchCode[1][0])) {
					$completion->code = $matchCode[1][0];
				}
				$completion->save(false);
				
				$temp = array();
				
				//foreach ($matchTable[1] as $groupTitle) {
					//preg_match_all('/<table><thead><tr><td>'.$groupTitle.'<\/td><\/tr><\/thead>(.*?)<\/table>/', $content, $matchGroup);
					//$specsGroup = $this->getSpecsGroup(array('title'=>$groupTitle));
					
					//if (isset($matchGroup[1][1])) {
					if (true) {
						preg_match_all('/<tr><td class="type">(.*?)<\/td><td class="spec">(.*?)<\/td><\/tr>/', $content, $matchSpecs);
						
						//d($matchSpecs);
						
						foreach ($matchSpecs[1] as $k=>$specTitle) {
							$specsTitle = trim(strip_tags($specTitle));
							//$specs = $this->getSpecs(array('title'=>$specsTitle, 'group_id'=>$specsGroup->id));
							$specs = $this->getSpecs(array('title'=>$specsTitle));
							
							//echo $specs->id . "\n";
							
							$tempValue = strip_tags($matchSpecs[2][$k]);	

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