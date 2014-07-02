<?php
class ImportCommand extends CConsoleCommand
{

	public function init() 
	{
		ini_set('max_execution_time', 3600*12);
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

	private function actionMake()
	{
		$url = 'http://autos.aol.com/new-cars/';
		$content = CUrlHelper::getPage($url, '', '');

		preg_match_all('/<a href="\/car-finder\/make-(.*?)\/">(.*?)<\/a>/', $content, $matches);
		if (isset($matches[1]) && isset($matches[2])) {
			foreach ($matches[1] as $key => $alias) {
			
				$autoMake = AutoMake::model()->findByAttributes(array('alias'=>$alias));
				if (!empty($autoMake)) continue;
						
				$autoMake = new AutoMake;
				$autoMake->alias = $alias;
				$autoMake->title = $matches[2][$key];
				$autoMake->is_active = 1;
				$autoMake->is_deleted = 0;
				$autoMake->save();
			
				echo "Make $autoMake->id - $autoMake->title \n";
			}
		}
	}	
	
	private function actionModel()
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
							'make_id'=>$autoMake->id
						));
						
						if (!empty($autoModel)) continue;
							
						$autoModel = new AutoModel;
						$autoModel->alias = $alias;
						$autoModel->make_id = $autoMake->id;
						$autoModel->title = $matches[3][$key];
						$autoModel->is_active = 1;
						$autoModel->is_deleted = 0;						
						$autoModel->save();
						
						echo "Model $autoModel->id - $autoModel->title \n";
					}
				}
			}
			
			
		}	
		
	}	
	
	public function actionCatalog()
	{
		/*
		date_default_timezone_set('America/Los_Angeles');
		
		$this->actionMake();
		$this->actionModel();
		
		$parseYear = date('Y')+1;
		$parsedModelYearIds = array();
		
		$autoModels = (array)AutoModel::model()->findAll();
		foreach ($autoModels as $keyModel=>$autoModel) {
			$url = "http://autos.aol.com/{$autoModel->Make->alias}-{$autoModel->alias}/";
			
			$content = Yii::app()->cache->get($url);
			if ($content == false) {
				$content = CUrlHelper::getPage($url, '', '');	
				Yii::app()->cache->set($url, $content, 60*60*24);
			}			
			
			preg_match_all('/<li class="sub_title"><a href="\/cars-(.*?)-(.*?)-(.*?)\/">(.*?)<\/a><\/li>/', $content, $matches);
			preg_match_all('/<li class="sub_title"><a href="(.*?)">(.*?)<\/a><\/li>/', $content, $matchesUrl);
				
			if (isset($matches[3])) {
					
				$content = str_replace(array(" ", "\n", "\t", "\r"), array("","","",""), $content);

				//file_put_contents('1111.txt', $content);
				preg_match_all('/<divclass="mkencl"><divclass="img"><imgsrc="(.*?)"width="150"height="113"alt="(.*?)"\/><\/div>/', $content, $matchesImages);
				preg_match_all('/<divclass="mkencl"><divclass="img"><imgsrc="(.*?)"width="150"height="93"style="padding-top:12px"alt="(.*?)"\/><\/div>/', $content, $matchesImagesTwo);
				$avatars = array();	
				
				foreach ($matchesImages[1] as $k=>$url) {
					$data = explode('"', $url);
					$avatars[$matchesImages[2][$k]] = $data[0];
				} 				
				
				foreach ($matchesImagesTwo[1] as $k=>$url) {
					$data = explode('"', $url);
					$avatars[$matchesImagesTwo[2][$k]] = $data[0];
				} 

				foreach ($matches[3] as $key=>$year) {
					if ($parseYear != $year) continue;
				
					$autoModelYear = AutoModelYear::model()->findByAttributes(array(
						'model_id'=>$autoModel->id, 
						'year'=>$year
					));
					if (!empty($autoModelYear)) continue;
					
					$avaKey = trim($year) . trim($autoModel->Make->title) . trim($autoModel->title);
					
					$autoModelYear = new AutoModelYear;
					
					if (isset($avatars[$avaKey])) {
						$autoModelYear->file_url = $avatars[$avaKey];
						$autoModelYear->file_name = "{$autoModel->Make->title}-{$autoModel->title}-{$year}.jpg";
					} else {
						//print_r($matchesImages[2]);
						//print_r($matchesImagesTwo[2]);
						//print_r($avatars);
						//print($avaKey);
						//die();
					}
					
					$autoModelYear->url = $matchesUrl[1][$key];
					$autoModelYear->model_id = $autoModel->id;
					$autoModelYear->year = $year;
					$autoModelYear->is_active = 1;
					$autoModelYear->is_deleted = 0;						
					$autoModelYear->save();	
					$parsedModelYearIds[] = $autoModelYear->id;

					echo "ModelYear $autoModelYear->id - $autoModel->title - $autoModelYear->year \n";
				}
			}			
		}	
		*/
		
		//$parsedModelYearIds = range(4946, 5006);

		//if (!empty($parsedModelYearIds)) {
			//$this->actionModelYearPhoto($parsedModelYearIds);
			//$completionIds = $this->actionCompletion($parsedModelYearIds);
			
			$completionIds = range(27250, 28000);
			
			if (!empty($completionIds)) {
				$this->actionCompletionDetails($completionIds);
				$this->actionSpecs();
				$this->actionCompletionData($completionIds);
				$this->actionCompetitor();
			}
		//}

		
	}	
	
	private function actionModelYearPhoto($ids)
	{
		$criteria = new CDbCriteria();
		$criteria->addInCondition('id', $ids);		
		$autoModels = (array)AutoModelYear::model()->findAll($criteria);
		foreach ($autoModels as $keyYear=>$autoModelYear) {
			$url = "http://autos.aol.com".$autoModelYear->url."photos/";
			
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
		$completionIds = array();
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition('id', $ids);
	
		$autoModels = AutoModelYear::model()->findAll($criteria);
		foreach ($autoModels as $keyYear=>$autoModelYear) {
			echo $autoModelYear->id . ' - ' . $autoModelYear->year . "\n";
			$url = "http://autos.aol.com{$autoModelYear->url}equipment/";
			$content = CUrlHelper::getPage($url, '', '');
			preg_match_all('/cars-compare\?v1=(.*?)\&amp\;type\=other/', $content, $matches);
											
			$linkCompare = 'http://autos.aol.com/' . $matches[0][0];
			
			$contentCompare = CUrlHelper::getPage($linkCompare, '', '');	
			preg_match_all('/<select name="trim_1" class="trimSelecter" id="compTrimList1">(.*?)<\/select>/', str_replace(array("\n", "\t"), "", $contentCompare), $matches);
			
			preg_match_all('/<option value="(.*?)">(.*?)<\/option>/', $matches[1][0], $matchOptopns);

			foreach ($matchOptopns[1] as $key=>$code) {
				$completion = $this->getCompletion(array('model_year_id'=>$autoModelYear->id,'code'=>$code, 'title'=>$matchOptopns[2][$key]));
				echo "\t  Complation " . $completion->id . ' - ' . $completion->title . "\n";
				$completionIds[] = $completion->id;
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
				$url = "http://autos.aol.com/cars-compare?cur_page=details&v1={$completion->code}&v2=&v3=&v4=&v5=&v6=&v7=&v8=&v9=";
				
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
								$competitorsTemp->save();
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
?>