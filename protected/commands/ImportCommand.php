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
		$from = Yii::app()->db->createCommand('SELECT MAX(year_id) FROM auto_model_year_photo')->queryScalar();
		AutoModelYearPhoto::model()->deleteAllByAttributes(array('year_id'=>$from));	
		
		$criteria = new CDbCriteria();
		$criteria->addCondition("id > {$from}");		
		$autoModels = (array)AutoModelYear::model()->findAll($criteria);
		foreach ($autoModels as $keyYear=>$autoModelYear) {
			$url = "http://autos.aol.com".$autoModelYear->url."photos/";
			
			$content = CUrlHelper::getPage($url, '', '');
			preg_match_all('/<a href="http:\/\/o.aolcdn.com\/commerce\/images\/(.*?)_Large.jpg">/', $content, $matches);
			
			echo $autoModelYear->id  . "\n" ;
			
			if (isset($matches[1])) {
				foreach ($matches[1] as $file) {
					$file_url = "http://o.aolcdn.com/commerce/images/{$file}_Large.jpg";
					$photo = new AutoModelYearPhoto;
					$photo->file_url = $file_url;
					$photo->year_id = $autoModelYear->id;
					$photo->save();
					echo "\t" . $photo->id . "\n" ;
				}
			}
		}
	}		

	public function actionModelYearP()
	{
		$sql = "SELECT * FROM `auto_model_year` WHERE  `file_name` =  '' ORDER BY id DESC LIMIT 500";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		$i = 0;
		$urls = array();
		foreach ($rows as $row) {
			$s = "-".$row['year'];
			$url = str_replace(array("cars-", $s), array("",""), $row['url']);
			$url = 'http://autos.aol.com'.$url;
			$urls[$url] = $url;
			
			
				$criteria = new CDbCriteria();
				$criteria->compare('id', $row['id']);				
				$modelYear = AutoModelYear::model()->find($criteria);	
				if (!empty($modelYear)) {
					//$data = explode('"', $matches[1][$k]);
					//$modelYear->file_url = $data[0];
					$modelYear->file_name = "{$modelYear->Model->Make->alias}-{$modelYear->Model->alias}-{$modelYear->year}.jpg";
					$modelYear->save(false);
					
					if (is_file($modelYear->image_directory . $modelYear->file_name)) {
						$sql = "UPDATE  `test_autof_db`.`auto_model_year` SET  `file_name` =  '{$modelYear->file_name}' WHERE  `auto_model_year`.`id` ={$modelYear->id}; \n";
						echo $sql;
					}
 					
				}			
			
		}
		die();
		
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
					$modelYear->file_name = "{$modelYear->Model->Make->alias}-{$modelYear->Model->alias}-{$modelYear->year}.jpg";
					$modelYear->save(false);
					
					if (is_file($modelYear->image_directory . $modelYear->file_name)) {
						$sql = "UPDATE  `test_autof_db`.`auto_model_year` SET  `file_name` =  '{$modelYear->file_name}' WHERE  `auto_model_year`.`id` ={$modelYear->id}; \n";
						echo $sql;
					}
 					
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
					$modelYear->file_name = "{$modelYear->Model->Make->alias}-{$modelYear->Model->alias}-{$modelYear->year}.jpg";
					$modelYear->save(false);
						
					if (is_file($modelYear->image_directory . $modelYear->file_name)) {
						$sql = "UPDATE  `test_autof_db`.`auto_model_year` SET  `file_name` =  '{$modelYear->file_name}' WHERE  `auto_model_year`.`id` ={$modelYear->id}; \n";
						echo $sql;
					}					
					
				}
				
				$i++;
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
			$completion->save(false);
		} 

		return $completion;
	}
	
	/*
	* Парсинг кодов комплектации
	*/	
	public function actionCompletion()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('id > 4788');
	
		$autoModels = (array)AutoModelYear::model()->findAll($criteria);
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
				echo "\t" . $completion->id . ' - ' . $completion->title . "\n";
			}
		}
	}	
	
	/*
	* Парсинг страницы комплектации
	*/	
	public function actionCompletionDetails()
	{
		$limit = 1000;
		
		$from = Yii::app()->db->createCommand('SELECT MAX(completion_id) FROM auto_completion_specs_temp')->queryScalar();
		
		AutoCompletionCompetitorsTemp::model()->deleteAllByAttributes(array('completion_id'=>$from));
		AutoCompletionSpecsTemp::model()->deleteAllByAttributes(array('completion_id'=>$from));		
		
		for ($offset=0; $offset<30000; $offset+=1000) {
		
			$criteria = new CDbCriteria();
			$criteria->limit = $limit;		
			$criteria->offset = $offset;	
			$criteria->addCondition("id >= $from");	//
			
			$completions = AutoCompletion::model()->findAll($criteria);
			if (empty($completions))
				die();
			
			foreach ($completions as $key=>$completion) {
				$url = "http://autos.aol.com/cars-compare?cur_page=details&v1={$completion->code}&v2=&v3=&v4=&v5=&v6=&v7=&v8=&v9=";
				
				$content = CUrlHelper::getPage($url, '', '');
				
				$html = str_get_html($content);	
				$specsGroup = null;
				foreach ($html->find('#data_table tr') as $tr) {
						
					
					if ($tr->class == 'header') {
						$specsGroup = $this->getSpecsGroup(array('title'=>trim(str_replace('Compare ', '', $tr->find('td', 0)->plaintext))));
					} else if (!empty($specsGroup)) {
						$specs = $this->getSpecs(array('title'=>trim($tr->find('td', 0)->plaintext), 'group_id'=>$specsGroup->id));
			
						$completionSpecs = new AutoCompletionSpecsTemp;
						$completionSpecs->attributes = array(
							'completion_id' => $completion->id,
							'specs_id' => $specs->id,
							'value' => trim($tr->find('td', 1)->plaintext),
						);
						
						$completionSpecs->save();
					}

				}
				
				$competitorCount = 0;
				if (substr_count($content, "Competitors for") == 1) {
					preg_match_all('/<a href="(.*?)" name="(.*?)" class="addVeh">/', $content, $matches);	
					if (isset($matches[2]) && !empty($matches[2])) {
						foreach ($matches[2] as $competitor_code) {
							$competitorCompletion = AutoCompletion::model()->findByAttributes(array('code'=>$competitor_code));
							if (!empty($competitorCompletion)) {
								$competitorsTemp = new AutoCompletionCompetitorsTemp;
								$competitorsTemp->completion_id = $completion->id;
								$competitorsTemp->competitor_id = $competitorCompletion->id;
								$competitorsTemp->save();
								$competitorCount++;
							} else {
								file_put_contents('Completion_404.txt', $competitor_code . "\n", true);
							}	
						}
					}	
				}
				
				echo $completion->id . ' ' . $competitorCount . ' ' . date('H:i:s') . "\n";
			}
		}
	}
	
	/*
	* Формируем тип полей характеристик
	* Добавляем сформирование поля в таблицу комплектаций
	*/
	public function actionSpecs()
	{
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
		
		AutoCompletion::deleteSpecsAttributes();
		$specs = AutoSpecs::model()->findAll();
		foreach ($specs as $spec) {
			$spec->addField();
			echo "added filed $spec->alias \n";
		}
		
		$t = time()-$time;
		
		echo $t;
		
	}
	
	/*
	* Заполняем поля таблицы комплектации значениямы
	*/
	public function actionCompletionData()
	{
		$limit = 1000;
		
		$specsData = AutoSpecs::getAllWithAttributes();
		
		for ($offset=0; $offset<30000; $offset+=$limit) {
		
			$criteria = new CDbCriteria();
			$criteria->limit = $limit;		
			$criteria->offset = $offset;	
			$criteria->order = 'id';	
			//$criteria->addCondition('id >= 16974');	
			
			$completions = AutoCompletion::model()->findAll($criteria);
			if (empty($completions))
				die();
			
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
							
					//echo $completion->id . ' ' . $specData['id'] ." $completionSpec->value \t $value $attr \n"; 							
					//echo "------------------------------------------------------- \n"; 							
			
				}
				unset($completionSpecs);

				if(!$completion->save()) {
					foreach ($completion->errors as $key=>$error) {
						echo "\t" . $completion->$key . "\t" . $error[0] . "\n";
					}
				}
						
				echo $completion->id . ' ' . date('H:i:s') . "\n";
			}
			unset($completions);
		}
	}

	/*
	* Восстановление кодов
	*/	
	/*
	public function actionCode()
	{
		$limit = 1000;
		
		for ($offset=0; $offset<30000; $offset+=1000) {
			$sql = "SELECT id, code FROM auto_completion_temp LIMIT $offset, $limit";
			$rows = Yii::app()->db->createCommand($sql)->queryAll();
			if (empty($rows)) die();
			foreach ($rows as $row) {
				$completion = AutoCompletion::model()->findByPk($row['id']);
				$completion->code = $row['code'];
				$completion->save(false);
				echo $completion->id . ' ' . $completion->code . "\n";
			}
		}
	}
	*/

	/*
	* Конкуренты моделей по годах
	*/	
	public function actionCompetitor()
	{
		$limit = 1000;
		$k = 0;
		for ($offset=0; $offset<200000; $offset+=1000) {
			$criteria = new CDbCriteria();
			$criteria->limit = $limit;		
			$criteria->offset = $offset;	
			
			$completionCompetitors = AutoCompletionCompetitorsTemp::model()->findAll($criteria);
			if (empty($completionCompetitors)) {
				die();
			}
			
			foreach ($completionCompetitors as $completionCompetitor) {
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
				
				echo "$k \n";	
				$k++;				
				
			}
		}

		
		$limit = 1000;
		$k = 0;
		for ($offset=0; $offset<200000; $offset+=1000) {
			$criteria = new CDbCriteria();
			$criteria->limit = $limit;		
			$criteria->offset = $offset;	
	
			$modelYearCompetitors = AutoModelYearCompetitor::model()->findAll($criteria);
			if (empty($modelYearCompetitors)) {
				die();
			}
			
			foreach ($modelYearCompetitors as $modelYearCompetitor) {
				$attributes = array(
					'model_year_id' => $modelYearCompetitor->competitor_id,
					'competitor_id' => $modelYearCompetitor->model_year_id,
				);
				
				$m = AutoModelYearCompetitor::model()->findByAttributes($attributes);
				if (empty($m)) {
					$autoModelYearCompetitor = new AutoModelYearCompetitor;
					$autoModelYearCompetitor->attributes = $attributes;
					$autoModelYearCompetitor->save();
				}
				
				echo "$k \n";	
				$k++;				
				
			}
		}		
		
	}
	
	public function actionTest()
	{
		AutoSpecsOption::model()->deleteAllByAttributes(array('specs_id'=>120));
		$sql = "SELECT DISTINCT value AS v FROM auto_completion_specs_temp WHERE specs_id=120 ORDER BY v";
		$items = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($items as $item) {
			$option = $this->getOption(array('value'=>$item['v'], 'specs_id'=>120));
			$data[$option->value] = $option->id;
		}
		
		$sql = "SELECT * FROM auto_completion_specs_temp WHERE specs_id=120";
		$items = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($items as $item) {
			$completion = AutoCompletion::model()->findByPk($item['completion_id']);
			$completion->specs_engine = $data[$item['value']];
			$completion->save(false);
			echo $completion->id . "\n";
		}
		
	}

	public function actionAlias()
	{
		$makes = AutoMake::model()->findAll();
		foreach ($makes as $make) {
			$make->save();
			echo "MAKE $make->id \n";
		}
		
		$models = AutoModel::model()->findAll();
		foreach ($models as $model) {
			$model->save();
			echo "MODEL $model->id \n";
		}
	}	
		
}
?>