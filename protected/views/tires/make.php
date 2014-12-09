<main class="l">
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?> Tires</h2>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '300x250')); ?>
	</div>
	<div class="text_size">
		<?=$header_text_block?>		
	</div>
</section>
<section class="make">
	<h2 class="section-name_2">Search tire size by vehicle</h2>

	<ul class="make__vehicle">
	<?php foreach ($dataModels as $dataModel):?>	
		<li>
			<?php if (isset($dataModel['photo'])):?>
			<div class="make__vehicle-image">
				<a title="<?=$make['title']?> <?=$dataModel['title']?> tire size" href="/tires<?=$dataModel['url']?>">
					<img src="<?=$dataModel['photo']?>"> 
				</div>
			<?php endif;?>	
			<h3>
				<a href="/tires<?=$dataModel['url']?>"><?=$make['title']?> <?=$dataModel['title']?> tire size</a>
			</h3>
			
			<?php $rangeTireSize = AutoModel::getMinMaxTireSize($dataModel['id']);?>
			<?php if (!empty($rangeTireSize)):?>
			<ul class="make__vehicle-specs">
				<li>
					<?=$rangeTireSize['min']?> 
					<?php if ($rangeTireSize['min'] != $rangeTireSize['max']):?> - <?=$rangeTireSize['max']?><?php endif;?>
				</li>
			</ul>
			<?php endif;?>
			
			<ul class="make__vehicle-years">
			<?php foreach ($dataModel['years'] as $item):?>	
				<li>
					<a title="<?=$item['year']?> <?=$make['title']?> <?=$dataModel['title']?> tires" href="/tires<?=$dataModel['url']?><?=$item['year']?>/"><?=$item['year']?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</li>
	<?php endforeach;?>	
	</ul>
</section>

</div>
<div class="l-col2">

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

<section class="right-block">
	<?php $this->renderPartial('_make_info', array('make'=>$make))?>
</section>

</div>
</main>