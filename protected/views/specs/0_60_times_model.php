<main class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times">
			<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> 0-60 times</h2>
			<div class="times__container">
				<div class="times__image">
					<img alt="Photo <?=$make['title']?> <?=$model['title']?> 0-60 times" src="<?=$lastModelYear['photo']?>">
				</div>
<div class="times__textwrap">
					<?=$description?>
				</div>
		</section>

		<!-- banner -->
			<br><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- autofiles_300x250 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-3243264408777652"
     data-ad-slot="9434056455"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		
		<?php if (!empty($completionsTime)):?>
		<section class="table-container">
			<h2 class="section-name"><?=$lastModelYear['year']?> <?=$make['title']?> <?=$model['title']?> 0-60 times, all trims</h2>

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
			<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> 0-60 mph acceleration across years</h2>

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

		

		<?php if (!empty($competitors)):?>
		<section class="table-container">
			<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> competitors’ 0-60 mph acceleration</h2>

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

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- autof580 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:580px;height:400px"
     data-ad-client="ca-pub-3243264408777652"
     data-ad-slot="7653258858"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>            

		<?php endif;?>
		
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
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<?/*?>
		<section class="right-block">
			<h2 class="section-name">Car specs and dimensions</h2>
			<table class="right-block__specs-list">
				<tr>
					<td><a class="speed" href="#">0-60 times</a></td>
					<td class="spec-value">5.7 sec</td>
				</tr>
				<tr>
					<td><a class="engine" href="#">Engine specs</a></td>
					<td class="spec-value">3.5L V-6</td>
				</tr>
				<tr>
					<td><a class="horsepower" href="#">Horsepower</a></td>
					<td class="spec-value">273 hp</td>
				</tr>
				<tr>
					<td><a class="gas" href="#">Gas mileage</a></td>
					<td class="spec-value">19/27</td>
				</tr>
				<tr>
					<td><a class="towing" href="#">Towing capacity</a></td>
					<td class="spec-value">1500 lbs</td>
				</tr>
				<tr>
					<td><a class="length" href="#">Length</a></td>
					<td class="spec-value">183.5”</td>
				</tr>
				<tr>
					<td><a class="wheelbase" href="#">Wheelbase</a></td>
					<td class="spec-value">105.7”</td>
				</tr>
				<tr>
					<td><a class="clearance" href="#">Clearance</a></td>
					<td class="spec-value">5.4”</td>
				</tr>
				<tr>
					<td><a class="weight" href="#">Curb weight</a></td>
					<td class="spec-value">3.717 lbs</td>
				</tr>
				<tr>
					<td><a class="cargo" href="#">Cargo space</a></td>
					<td class="spec-value">61.3 cu.ft</td>
				</tr>
			</table>

                        
		</section>
		<?*/?>
		
	</div>
	</div>
</main>