<main class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h2 class="section-name pb18"><?=$model['value']?> inch tires. R<?=$model['value']?> tire size</h2>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '300x250')); ?>
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>
		
		<?php if (!empty($tires)):?>
		<section class="product_photo_box make">
			<h2 class="section-name_2 mb30">All possible tire sizes for <?=$model['value']?> inches rim size</h2>
			
			<?php foreach ($tires as $tire):?>
				<?php $tireText = Tire::format($tire);?>
				<div class="product_photo_item">
					<div class="product_photo_item_top">
						<a href="<?=Tire::url($tire)?>" class="product_photo_name"><?=$tireText?></a>
						<ul class="make__vehicle-specs">
							<li><a type="amzn" search="<?=$tireText?>" category="automotive">Buy on Amazon</a></li>
							<?php $rimWidth = TireRimWidth::getRangeWidth($tire['section_width']);?>
							<?php if (!empty($rimWidth)):?>
							<li>Rim width <?=$rimWidth['min']?><?php if($rimWidth['min']!=$rimWidth['max']):?> - <?=$rimWidth['max']?><?php endif;?>"</li>
							<?php endif;?>
							<li>Diameter <?=Tire::diameter($tire)?>"</li>
							<li>Sidewall height <?=Tire::sidewallHeight($tire)?>"</li>
						</ul>
					</div>				
				</div>
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