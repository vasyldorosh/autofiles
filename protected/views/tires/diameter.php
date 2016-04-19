<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h1 class="section-name_2"><?=$model['value']?> inch tires. R<?=$model['value']?> tire size</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>
		
		<?php if (!empty($tires)):?>
		<section class="product_photo_box make">
			<h2 class="section-name_2 mb30">All possible tire sizes for <?=$model['value']?> inches rim size</h2>
			
			<?php foreach ($tires as $tire): if ($tire['vehicle_class']=='LT'){continue;}?>
				<?php $this->renderPartial('_tire', array('tire'=>$tire))?>
			<?php endforeach;?>
			<?php foreach ($tires as $tire): if ($tire['vehicle_class']!='LT'){continue;}?>
				<?php $this->renderPartial('_tire', array('tire'=>$tire))?>
			<?php endforeach;?>
		
		</section>
		<?php endif;?>
		
	</div>
	<div class="l-col2">
		<section class="">
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		</section>
	</div>
</main>

<?php $this->renderPartial('_amazon_script');?>