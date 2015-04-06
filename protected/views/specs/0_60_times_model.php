<main>
	<div class="l-col1">
		<!-- section 1 -->
				<section class="times">
			<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> 0-60 times</h2>
			<div class="times__container">
				<div class="google_links f_left p_rel">
					<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
				</div>
				<div class="text_size">
					<?=$description?>
				</div>
		</section>
		
		
		<?php if (!empty($completionsTime)):?>
		<section class="table-container">
			<h2 class="section-name_2"><?=$lastModelYear['year']?> <?=$make['title']?> <?=$model['title']?> 0-60 times, all trims</h2>

                     	<table>
			<?php foreach ($completionsTime as $item):?>
				<tr>
					<td>
						<?=$item['title']?> 0-60
					</td>
					<td>
						<?=(float)$item['specs_0_60mph__0_100kmh_s_']?> sec
					</td>
					<td>	
						1/4 mile <?=(float)$item['specs_1_4_mile_time']?> @ <?=(float)$item['specs_1_4_mile_speed']?> mph
					</td>					
				</tr>
			<?php endforeach;?>
			</table>
		</section>		
		<?php endif;?>		
	

		<section class="table-container">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> 0-60 mph acceleration across years</h2>

			<table>
			<?php foreach ($models as $item):?>
				<tr>
					<td><a href="/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/"  title="<?=$item['year']?> <?=$make['title']?> <?=$model['title']?> review"><?=$item['year']?> <?=$make['title']?> <?=$model['title']?></a></td>
					<td>
					<?php if ($item['0_60_times']['mmax'] == $item['0_60_times']['mmin']):?>
						<?=$item['0_60_times']['mmin']?>
					<?php else:?>
						<?=$item['0_60_times']['mmin']?> - <?=$item['0_60_times']['mmax']?>
					<?php endif;?>	
						sec
					</td>
					<td>
						1/4 mile
						<?php if ($item['mile_time']['min'] == 0):?>
							-
						<?php else:?>
							<?php if ($item['mile_time']['min'] == $item['mile_time']['max']):?>
								<?=$item['mile_time']['min']?> @ <?=$item['mile_speed']['min']?> mph
							<?php else:?>
								<?=$item['mile_time']['min']?> @ <?=$item['mile_speed']['min']?> - <?=$item['mile_time']['max']?> @ <?=$item['mile_speed']['max']?> mph
							<?php endif;?>	
						<?php endif;?>
					</td>					
				</tr>
			<?php endforeach;?>
			</table>
		</section>		

		<section class="parts">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> Parts &amp; Accessories on Amazon</h2>
		
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327565&rh=i%3Aautomotive%2Cn%3A15714131&tag=auto0a70-20&linkId=XQPA5UY34HTEUHIW"><img src="/img/Perffilter._V192201762_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327565&rh=i%3Aautomotive%2Cn%3A15714131&tag=auto0a70-20&linkId=XQPA5UY34HTEUHIW">Air Intakes &amp; Filters</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327800&rh=i%3Aautomotive%2Cn%3A15713821&tag=auto0a70-20&linkId=ARHZ6HUAHHZ3ONAO"><img src="/img/Perfexhaust._V192201762_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327800&rh=i%3Aautomotive%2Cn%3A15713821&tag=auto0a70-20&linkId=ARHZ6HUAHHZ3ONAO">Exhaust</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327864&rh=i%3Aautomotive%2Cn%3A2286884011&tag=auto0a70-20&linkId=6B5U7DGLISEWVHNS"><img src="/img/PerformanceChassis._V192201760_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327864&rh=i%3Aautomotive%2Cn%3A2286884011&tag=auto0a70-20&linkId=6B5U7DGLISEWVHNS">Suspension &amp; Chassis</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/mn/search/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327949&rh=i%3Aautomotive%2Cn%3A2286883011&tag=auto0a70-20&linkId=4RRLS7AW2OPT45XL"><img src="/img/PerformanceIgnition._V192201760_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/mn/search/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327949&rh=i%3Aautomotive%2Cn%3A2286883011&tag=auto0a70-20&linkId=4RRLS7AW2OPT45XL">Ignition &amp; Electrical</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328048&rh=i%3Aautomotive%2Cn%3A15736321&tag=auto0a70-20&linkId=JYGBSO5SQ7IBN3V2"><img src="/img/LightingPerformanceOffRoad._V192201765_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328048&rh=i%3Aautomotive%2Cn%3A15736321&tag=auto0a70-20&linkId=JYGBSO5SQ7IBN3V2">Lighting</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328119&rh=i%3Aautomotive%2Cn%3A15710921&tag=auto0a70-20&linkId=SQNHVOLAJZR6VUJE"><img src="/img/Brake._V192201789_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328119&rh=i%3Aautomotive%2Cn%3A15710921&tag=auto0a70-20&linkId=SQNHVOLAJZR6VUJE">Brakes &amp; Brake Parts</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328173&rh=i%3Aautomotive%2Cn%3A15714351&tag=auto0a70-20&linkId=35D5WO2IVKBQ2DSQ"><img src="/img/PerformanceFuel._V192201767_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328173&rh=i%3Aautomotive%2Cn%3A15714351&tag=auto0a70-20&linkId=35D5WO2IVKBQ2DSQ">Fuel System</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328212&rh=i%3Aautomotive%2Cn%3A15712301&tag=auto0a70-20&linkId=JGOREEAMVZGAXK65"><img src="/img/EngineCooling._V192201762_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328212&rh=i%3Aautomotive%2Cn%3A15712301&tag=auto0a70-20&linkId=JGOREEAMVZGAXK65">Engine Cooling</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/b/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&node=15718791&pf_rd_i=B00EVQSX08&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=2040563602&pf_rd_r=142BC53VXET4PATT98DW&pf_rd_s=center-1&pf_rd_t=1601&tag=auto0a70-20&vehicleId=6&linkId=D6CFHIWVQL3O3JGM"><img src="/img/PerformanceOils._V192201760_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/b/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&node=15718791&pf_rd_i=B00EVQSX08&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=2040563602&pf_rd_r=142BC53VXET4PATT98DW&pf_rd_s=center-1&pf_rd_t=1601&tag=auto0a70-20&vehicleId=6&linkId=D6CFHIWVQL3O3JGM">Oil &amp; Lubricants</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/b/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&node=15737011&pf_rd_i=B00EVQSX08&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=2040563602&pf_rd_r=142BC53VXET4PATT98DW&pf_rd_s=center-1&pf_rd_t=1601&tag=auto0a70-20&vehicleId=6&linkId=KPSIPO327YEAF2CB"><img src="/img/PerformanceAccessories._V192201766_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/b/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&node=15737011&pf_rd_i=B00EVQSX08&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=2040563602&pf_rd_r=142BC53VXET4PATT98DW&pf_rd_s=center-1&pf_rd_t=1601&tag=auto0a70-20&vehicleId=6&linkId=KPSIPO327YEAF2CB">Tuning Accessories</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
		</section>

		<?php if (!empty($competitors)):?>
		<section class="table-container">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> competitors' 0-60 mph acceleration</h2>

			<table>
			<?php foreach ($competitors as $item):?>
				<tr>
					<td><a title="<?=$item['year']?> <?=$item['make']?> <?=$item['model']?> 0-60" href="/0-60-times/<?=$item['make_alias']?>/<?=$item['model_alias']?>/"><?=$item['year']?> <?=$item['make']?> <?=$item['model']?> 0-60</a></td>
					<td>
					<?php if ($item['0_60_times']['mmax'] == $item['0_60_times']['mmin']):?>
						<?=$item['0_60_times']['mmin']?>
					<?php else:?>
						<?=$item['0_60_times']['mmin']?> - <?=$item['0_60_times']['mmax']?>
					<?php endif;?>	
						sec
					</td>
					<td>
						1/4 mile
						<?php if ($item['mile_time']['min'] == 0):?>
							-
						<?php else:?>
							<?php if ($item['mile_time']['min'] == $item['mile_time']['max']):?>
								<?=$item['mile_time']['min']?> @ <?=$item['mile_speed']['min']?> mph
							<?php else:?>
								<?=$item['mile_time']['min']?> @ <?=$item['mile_speed']['min']?> - <?=$item['mile_time']['max']?> @ <?=$item['mile_speed']['max']?> mph
							<?php endif;?>	
						<?php endif;?>
					</td>					
				</tr>
			<?php endforeach;?>
			</table>
			</section>
		<?php endif;?>		

		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>

		
		<?php if (!empty($completionsCarsWithSame060Time)):?>
		<section class="table-container">
			<h2 class="section-name">Cars with the same 0-60 time</h2>
			<table>
			<?php foreach ($completionsCarsWithSame060Time as $item):?>
				<tr>
					<td><a title="<?=$item['year']?> <?=$item['make']?> <?=$item['model']?> 0-60" href="/0-60-times/<?=$item['make_alias']?>/<?=$item['model_alias']?>/"><?=$item['year']?> <?=$item['make']?> <?=$item['model']?> 0-60</a></td>
					<td><?=(float)$item['speed']?> sec</td>
					<td>1/4 mile <?=(float)$item['mile_time']?> sec @ <?=(float)$item['mile_speed']?></td>
				</tr>
				
			<?php endforeach;?>	
			</table>
		</section>
		<?php endif;?>
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
		
	</div>
	<div class="l-col2">
		<br>
		<?php $this->renderPartial('application.views.specs._right_model', array(
			'lastModelYear'=>$lastModelYear,
			'make'=>$make,
			'model'=>$model,
		))?>		
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		
	</div>
	</div>
</main>