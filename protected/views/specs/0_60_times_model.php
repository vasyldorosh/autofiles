<main>
	<div class="l-col1">
		<!-- section 1 -->
				<section class="times">
			<h1 class="section-name_2"><?=$make['title']?> <?=$model['title']?> 0-60 times</h1>
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
            <tr><td><b>Trim, HP, Engine, Transmission</b></td><td><b>0-60 times</b></td><td><b>1/4 mile times</b></td></tr>
			<?php foreach ($completionsTime as $item):?>
				<tr>
					<td>
						<?php $expl = explode('@', $item['specs_horsepower']); $hp = trim($expl[0])?>
						<?=$item['title']?><?php if (!empty($hp)):?>,<?= str_replace('hp', '', trim($hp))?> hp <?php endif;?><br/>
						<small><?php 
						$engine = trim(AutoCompletion::getSpecsOptionTitle(AutoSpecs::SPEC_ENGINE, $item['specs_engine']));
						$transmission = AutoCompletion::getSpecsOptionTitle(AutoSpecs::SPEC_TRANSMISSION, $item['specs_transmission'])?>
						<?=!empty($item['specs_turbocharger'])?'turbo, ':''?><?php if (!empty($engine)):?><?=($engine!='Hybrid Electric Motor')?str_replace('Electric Motor', '', $engine):$engine?><?php endif;?><?php if (!empty($transmission)):?>, <?=str_replace('w/OD', '', $transmission)?><?php endif;?></small>
					</td>
					<td><h3>
						<?=(float)$item['specs_0_60mph__0_100kmh_s_']?> sec
					</h3></td>
					<td>	
						<?=(float)$item['specs_1_4_mile_time']?> @ <?=(float)$item['specs_1_4_mile_speed']?> mph
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
					<td><?=$item['year']?> <?=$make['title']?> <?=$model['title']?> 0-60, 1/4 mile</td>
					<td><h3>
					<?php if ($item['0_60_times']['mmax'] == $item['0_60_times']['mmin']):?>
						<?=$item['0_60_times']['mmin']?>
					<?php else:?>
						<?=$item['0_60_times']['mmin']?> - <?=$item['0_60_times']['mmax']?>
					<?php endif;?>	
						sec
					</h3></td>
					<td>
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
<br>
               <?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>

		<?php if (!empty($competitors)):?>
		<section class="table-container">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> competitors' 0-60 mph acceleration</h2>

			<table>
			<?php foreach ($competitors as $item):?>
				<tr>
					<td><a title="<?=$item['year']?> <?=$item['make']?> <?=$item['model']?> 0-60 times" href="/0-60-times/<?=$item['make_alias']?>/<?=$item['model_alias']?>/"><?=$item['year']?> <?=$item['make']?> <?=$item['model']?> 0-60</a></td>
					<td><h3>
					<?php if ($item['0_60_times']['mmax'] == $item['0_60_times']['mmin']):?>
						<?=$item['0_60_times']['mmin']?>
					<?php else:?>
						<?=$item['0_60_times']['mmin']?> - <?=$item['0_60_times']['mmax']?>
					<?php endif;?>	
						sec
					</h3></td>
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


		
		<?php if (!empty($completionsCarsWithSame060Time)):?>
		<section class="table-container">
			<h2 class="section-name_2">Cars with the same 0-60 time</h2>
			<table>
			<?php foreach ($completionsCarsWithSame060Time as $item):?>
				<tr>
					<td><a title="<?=$item['year']?> <?=$item['make']?> <?=$item['model']?> 0-60 times" href="/0-60-times/<?=$item['make_alias']?>/<?=$item['model_alias']?>/"><?=$item['year']?> <?=$item['make']?> <?=$item['model']?> </a></td>
					<td><h3>0-60 times <?=(float)$item['speed']?> sec</h3></td>
					<td>1/4 mile <?=(float)$item['mile_time']?> sec @ <?=(float)$item['mile_speed']?></td>
				</tr>
				
			<?php endforeach;?>	
			</table>
		</section>
		<?php endif;?>
		
		
		<?php $this->renderPartial('application.views.site._reviews', array(
			'items' => ReviewVsModelYear::getTextModel(ReviewVsModelYear::MARKER_060, $model['id']),
		)); ?>		
		
		<section class="seo-text">
			<?=$descriptionFooter?>
		</section>		
		
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