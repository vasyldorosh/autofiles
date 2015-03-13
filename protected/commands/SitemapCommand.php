<?php
/** 
 * Класс SitemapCommand
 */ 
class SitemapCommand extends CConsoleCommand
{	
	public function init() 
	{
		ini_set('max_execution_time', 3600*12);
		date_default_timezone_set('America/Los_Angeles');
		return parent::init();
	}	
	
	public function actionRun()
	{
		$limit = (int)SiteConfig::getInstance()->getValue('count_items_in_file');	

		if ($limit <= 1) $limit = 1000;
		
		$site_url = 'http://autofiles.com';//SiteConfig::getInstance()->getValue('sitemap_domain_url');	

		$mapFiles = array(
			'/', 
			'/0-60-times.html',
			'/tires.html',
			'/horsepower.html',
		);
		
		$i=0;
		do {		
			$file = "/sitemap/make{$i}.xml";
			$doc	= new DOMDocument("1.0", 'utf-8');
			$urlset = $doc->createElement("urlset");
			$doc->appendChild($urlset);
			$xmlns = $doc->createAttribute("xmlns");
			$urlset->appendChild($xmlns);
			$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
			$xmlns->appendChild($value);
					
			$criteria = new CDbCriteria();
			$criteria->compare('is_active', 1);
			$criteria->compare('is_deleted', 0);
			$criteria->limit = $limit/2;
			$criteria->offset = $i*$limit/2;
			
			$makes = AutoMake::model()->findAll($criteria);	
				
			foreach ($makes as $make) {
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/'.$make['alias'].'/',
					'lastmod' => time(),
				));
			
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/0-60-times/'.$make['alias'].'/',
					'lastmod' => time(),
				));	
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/tires/'.$make['alias'].'/',
					'lastmod' => time(),
				));						
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/horsepower/'.$make['alias'].'/',
					'lastmod' => time(),
				));						
			}
				
			if (empty($makes))	{
				break;
			} 	
				
			$mapFiles[] = $file;
				
			$doc->formatOutput = true;
			$doc->save(dirname(__FILE__) ."/../../" . $file);	
			
			$i++;
		} while (true);
		
		$i=0;
		do {		
			$file = "/sitemap/model{$i}.xml";
			$doc	= new DOMDocument("1.0", 'utf-8');
			$urlset = $doc->createElement("urlset");
			$doc->appendChild($urlset);
			$xmlns = $doc->createAttribute("xmlns");
			$urlset->appendChild($xmlns);
			$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
			$xmlns->appendChild($value);
					
			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('Make.is_active', 1);
			$criteria->compare('Make.is_deleted', 0);
			$criteria->limit = $limit/2;
			$criteria->offset = $i*$limit/2;
			$criteria->with = array('Make');
			
			$models = AutoModel::model()->findAll($criteria);	
				
			foreach ($models as $model) {
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/' . $model->Make->alias . '/' . $model->alias . '/',
					'lastmod' => time(),
				));
			
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/0-60-times/' . $model->Make->alias . '/' . $model->alias.'/',
					'lastmod' => time(),
				));	
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/tires/' . $model->Make->alias . '/' . $model->alias.'/',
					'lastmod' => time(),
				));						
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/horsepower/' . $model->Make->alias . '/' . $model->alias.'/',
					'lastmod' => time(),
				));						
			}
				
			if (empty($models))	{
				break;
			}	
				
			$mapFiles[] = $file;
				
			$doc->formatOutput = true;
			$doc->save(dirname(__FILE__) ."/../../" . $file);	
			
			$i++;
		} while (true);
		
		
		$i=0;
		do {		
			$file = "/sitemap/model_year{$i}.xml";
			$doc	= new DOMDocument("1.0", 'utf-8');
			$urlset = $doc->createElement("urlset");
			$doc->appendChild($urlset);
			$xmlns = $doc->createAttribute("xmlns");
			$urlset->appendChild($xmlns);
			$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
			$xmlns->appendChild($value);
					
			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('Make.is_active', 1);
			$criteria->compare('Make.is_deleted', 0);
			$criteria->compare('Model.is_active', 1);
			$criteria->compare('Model.is_deleted', 0);
			$criteria->limit = $limit/2;
			$criteria->offset = $i*$limit/2;
			$criteria->with = array('Model', 'Model.Make');
			
			$models = AutoModelYear::model()->findAll($criteria);	
				
			foreach ($models as $model) {
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/' . $model->Model->Make->alias . '/' .  $model->Model->alias . '/' . $model->year . '/',
					'lastmod' => time(),
				));
			
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/' . $model->Model->Make->alias . '/' . $model->Model->alias . '/' . $model->year.'/photos.html',
					'lastmod' => time(),
				));					
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/tires/' . $model->Model->Make->alias . '/' . $model->Model->alias . '/' . $model->year.'/',
					'lastmod' => time(),
				));						
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/horsepower/' . $model->Model->Make->alias . '/' . $model->Model->alias . '/' . $model->year.'/',
					'lastmod' => time(),
				));						
			}
				
			if (empty($models))	{
				break;
			}	
				
			$mapFiles[] = $file;
				
			$doc->formatOutput = true;
			$doc->save(dirname(__FILE__) ."/../../" . $file);	
			
			$i++;
		} while (true);
		
		$i=0;
		do {		
			$file = "/sitemap/tires_r{$i}.xml";
			$doc	= new DOMDocument("1.0", 'utf-8');
			$urlset = $doc->createElement("urlset");
			$doc->appendChild($urlset);
			$xmlns = $doc->createAttribute("xmlns");
			$urlset->appendChild($xmlns);
			$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
			$xmlns->appendChild($value);
					
			$criteria = new CDbCriteria();
			$criteria->limit = $limit/2;
			$criteria->offset = $i*$limit/2;
			
			$models = TireRimDiameter::model()->findAll($criteria);	
				
			foreach ($models as $model) {
				
				$this->addItem($doc, $urlset, array(
					'url' => $site_url . '/tires/r'.$model->value.'.html',
					'lastmod' => time(),
				));
			}
				
			if (empty($models))	{
				break;
			}	
				
			$mapFiles[] = $file;
				
			$doc->formatOutput = true;
			$doc->save(dirname(__FILE__) ."/../../" . $file);	
			
			$i++;
		} while (true);
		
		
		$items = Yii::app()->db->createCommand("SELECT DISTINCT tire_id FROM `auto_model_year_tire`")->queryAll();
		$tireIds = array();
		foreach ($items as $item) {
			$tireIds[] = $item['tire_id'];
		}
		
		$i=0;
		$makeTireUrls = array();
		do {		
			$file = "/sitemap/tires_size{$i}.xml";
			$doc	= new DOMDocument("1.0", 'utf-8');
			$urlset = $doc->createElement("urlset");
			$doc->appendChild($urlset);
			$xmlns = $doc->createAttribute("xmlns");
			$urlset->appendChild($xmlns);
			$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
			$xmlns->appendChild($value);
					
			$criteria = new CDbCriteria();
			$criteria->limit = $limit/2;
			$criteria->offset = $i*$limit/2;
			$criteria->addInCondition('t.id', $tireIds);
			
			$criteria->with = array(
				'VehicleClass', 
				'SectionWidth', 
				'AspectRatio', 
				'RimDiameter', 
				'LoadIndex',
				'RearRimDiameter',
				'RearAspectRatio',
				'RearSectionWidth',
			);	
	
			$models = Tire::model()->findAll($criteria);	
				
			echo count($models);	
				
			foreach ($models as $model) {
				$tireAttr = array(
					'vehicle_class' => $model->VehicleClass->code,
					'section_width' => $model->SectionWidth->value,
					'aspect_ratio' => $model->AspectRatio->value,
					'rim_diameter' => $model->RimDiameter->value,
				);
				
				$makeModels = Tire::getMakeModelsByTireIds(array($model->id));
				foreach ($makeModels as $makeModel) {
					$url = $site_url . '/tires/'.$makeModel['alias'] . '/' . Tire::url($tireAttr, true);
					$makeTireUrls[$url] = $url;
				}

				$this->addItem($doc, $urlset, array(
					'url' => $site_url . Tire::url($tireAttr),
					'lastmod' => time(),
				));
			}

			if (empty($models))	{
				break;
			}	
				
			$mapFiles[] = $file;
				
			$doc->formatOutput = true;
			$doc->save(dirname(__FILE__) ."/../../" . $file);	
			
			$i++;
		} while (true);
		
		$file = "/sitemap/tires_make_size.xml";
		$doc	= new DOMDocument("1.0", 'utf-8');
		$urlset = $doc->createElement("urlset");
		$doc->appendChild($urlset);
		$xmlns = $doc->createAttribute("xmlns");
		$urlset->appendChild($xmlns);
		$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
		$xmlns->appendChild($value);		
		foreach ($makeTireUrls as $makeTireUrl) {				
			$this->addItem($doc, $urlset, array(
				'url' => $makeTireUrl,
				'lastmod' => time(),
			));			
		}
		$mapFiles[] = $file;
				
		$doc->formatOutput = true;
		$doc->save(dirname(__FILE__) ."/../../" . $file);		
		
		$doc	= new DOMDocument("1.0", 'utf-8');
		$urlset = $doc->createElement("urlset");
		$doc->appendChild($urlset);
		$xmlns = $doc->createAttribute("xmlns");
		$urlset->appendChild($xmlns);
		$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
		$xmlns->appendChild($value);
		
		//hp
		$file = "/sitemap/hp.xml";
		$doc	= new DOMDocument("1.0", 'utf-8');
		$urlset = $doc->createElement("urlset");
		$doc->appendChild($urlset);
		$xmlns = $doc->createAttribute("xmlns");
		$urlset->appendChild($xmlns);
		$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
		$xmlns->appendChild($value);		
		foreach ($hps = AutoCompletion::getHpList() as $hp) {
			$url = $site_url . '/horsepower/'.$hp . '/';
			$this->addItem($doc, $urlset, array(
				'url' => $url,
				'lastmod' => time(),
			));			
		}
		$mapFiles[] = $file;
				
		$doc->formatOutput = true;
		$doc->save(dirname(__FILE__) ."/../../" . $file);		
		
		
		foreach ($mapFiles as $mapFile) {
			$attributes = array(
				'url' => $site_url . $mapFile,
				'lastmod' => time(),
			);
			$this->addItem($doc, $urlset, $attributes);		
		}
	
		
		$doc->formatOutput = true;
		$doc->save(dirname(__FILE__) ."/../../sitemap.xml");		
		
		
		print_r($mapFiles);
	}
	
	private function addItem(& $doc, & $urlset, $attributes)
	{
		$url = $doc->createElement("url");
		$urlset->appendChild($url);
			
		$loc = $doc->createElement("loc");
		$url->appendChild($loc);	
		
		$value = $doc->createTextNode($attributes['url']);
		$loc->appendChild($value);	
			
		$lastmod = $doc->createElement("lastmod");
		$url->appendChild($lastmod);	
		$value = $doc->createTextNode(date("Y-m-d", $attributes['lastmod']));
		$lastmod->appendChild($value);		
	}
}