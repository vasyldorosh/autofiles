<main class="l">
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?> horsepower</h2>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '300x250')); ?>
	</div>
	<div class="text_size">
		<?=$header_text_block?>	
	</div>
</section>
<section class="make">
	<h2 class="section-name_2"><?=$make['title']?> horsepower by models</h2>

	<ul class="make__vehicle">
	<?php foreach ($dataModels as $dataModel):?>	
		<li>
			<?php if (isset($dataModel['photo'])):?>
			<div class="make__vehicle-image">
				<a title="<?=$make['title']?> <?=$dataModel['title']?> tire size" href="/horsepower<?=$dataModel['url']?>">
					<img src="<?=$dataModel['photo']?>"> 
				</div>
			<?php endif;?>	
			<h3>
				<a href="/horsepower<?=$dataModel['url']?>" title="<?=$make['title']?> <?=$dataModel['title']?> horsepower"><?=$make['title']?> <?=$dataModel['title']?> horsepower</a>
			</h3>
			

			<ul class="make__vehicle-specs">
			<?php $rangeHorsepower = AutoModel::getMinMaxHorsepower($dataModel['id']);?>
			<?php if (!empty($rangeHorsepower) && (!empty($rangeHorsepower['min']) || !empty($rangeHorsepower['max']))):?>			
				<li>
					<?=$rangeHorsepower['min']?> 
					<?php if ($rangeHorsepower['min'] != $rangeHorsepower['max']):?> - <?=$rangeHorsepower['max']?><?php endif;?>
					hp
				</li>
			<?php endif;?>		
			<?php $rangeTimes = AutoModel::getMinMaxSpecs('0_60mph__0_100kmh_s_', $dataModel['id']);?>				
			<?php if (!empty($rangeTimes)):?>	
				<li>
					<a href="/0-60-times<?=$dataModel['url']?>" title="<?=$make['title']?> <?=$dataModel['title']?> acceleration times and quarter mile">
					0-60 times 
					<?=$rangeTimes['mmin']?> 
					<?php if ($rangeTimes['mmin'] != $rangeTimes['mmax']):?> - <?=$rangeTimes['mmax']?><?php endif;?>
					sec
					</a>
				</li>
			<?php endif;?>
			</ul>
			
			
			<ul class="make__vehicle-years">
			<?php foreach ($dataModel['years'] as $item):?>	
				<li>
					<a title="<?=$item['year']?> <?=$make['title']?> <?=$dataModel['title']?> horsepower" href="/horsepower<?=$dataModel['url']?><?=$item['year']?>/"><?=$item['year']?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</li>
	<?php endforeach;?>				
	</ul>
</section>

</div>
<div class="l-col2">
<br>

<section class="right-block">
	<?php $this->renderPartial('application.views.tires._make_info', array('make'=>$make))?>
</section>

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>


</div>
</main>