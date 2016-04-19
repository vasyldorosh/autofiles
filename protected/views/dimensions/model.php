<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h1 class="section-name_2"><?=$make['title']?> <?=$model['title']?> dimensions</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>

		<section class="model">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> dimensions</h2>
<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
			<p class="model__about"></p>
			
			
			<div>
			<?php foreach ($modelByYears as $item):?>
				<a title="<?=$item['year']?> <?=$make['title']?> <?=$model['title']?> dimensions" href="/dimensions/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/" class="model__block"><span><?=$item['year']?></span><img src="<?=$item['photo']?>"></a>
			<?php endforeach;?>
			</div>
		</section>
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
	</div>

	<div class="l-col2">
	<br>

	<?php $this->renderPartial('application.views.specs._right_model', array(
		'make'=>$make,
		'model'=>$model,
		'lastModelYear'=>$lastModelYear,
	))?>
			
			
	<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>


	</div>	
	
	
</main>