<main>
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h1 class="section-name_2"><?=$make['title']?> Tires & all possible tire sizes</h1>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
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
					<img alt="<?=$make['title']?> <?=$dataModel['title']?> tire size" src="<?=$dataModel['photo']?>"> 
                                 </a>
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
					<a title="<?=$item['year']?> <?=$make['title']?> <?=$dataModel['title']?> tire sizes" href="/tires<?=$dataModel['url']?><?=$item['year']?>/"><?=$item['year']?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</li>
	<?php endforeach;?>	
	</ul>

<?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>

</section>

</div>

	<div class="l-col2">

		<br>
		<section class="right-block">
			<?php $this->renderPartial('application.views.specs._right_make', array('make'=>$make))?>
		</section>	
<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>


	</div>
</main>