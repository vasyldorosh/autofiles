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
	
<script type="text/javascript" language="javascript">
  amzn_assoc_ad_type = "contextual";
  amzn_assoc_tracking_id = "auto0a70-20";
  amzn_assoc_marketplace = "amazon";
  amzn_assoc_region = "US";
  amzn_assoc_placement = "GHXNGETSQ3XJIX6K";
  amzn_assoc_linkid = "GHXNGETSQ3XJIX6K";
  amzn_assoc_emphasize_categories = "";
  amzn_assoc_fallback_products = "";
  amzn_assoc_width = "728";
  amzn_assoc_height = "90";
</script>
<script type="text/javascript" language="javascript" src="//z-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1&MarketPlace=US&source=ac"></script>
		

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
			<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> competitorsвЂ™ 0-60 mph acceleration</h2>

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