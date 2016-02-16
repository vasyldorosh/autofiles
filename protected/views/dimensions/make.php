<main>
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?> dimensions</h2>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
	</div>
	<div class="text_size">
		<?=$header_text_block?>	
	</div>
</section>
<section class="make">
	<h2 class="section-name_2">Select <?=$make['title']?> model</h2>
<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
	<ul class="make__vehicle">
	<?php foreach ($dataModels as $dataModel):?>	
		<li>
			<?php if (isset($dataModel['photo'])):?>
			<div class="make__vehicle-image">
				<a title="<?=$make['title']?> <?=$dataModel['title']?> dimensions" href="/dimensions<?=$dataModel['url']?>">
					<img src="<?=$dataModel['photo']?>"> 
				</a>
			</div>
			<?php endif;?>	
			<h3>
				<a href="/dimensions<?=$dataModel['url']?>" title="<?=$make['title']?> <?=$dataModel['title']?> dimensions"><?=$make['title']?> <?=$dataModel['title']?> dimensions</a>
			</h3>			
			
			<ul class="make__vehicle-years">
			<?php foreach ($dataModel['years'] as $item):?>	
				<li>
					<a title="<?=$item['year']?> <?=$make['title']?> <?=$dataModel['title']?> dimensions" href="/dimensions<?=$dataModel['url']?><?=$item['year']?>/"><?=$item['year']?></a>
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
	<?php $this->renderPartial('application.views.specs._right_make', array('make'=>$make))?>
</section>

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>


</div>
</main>