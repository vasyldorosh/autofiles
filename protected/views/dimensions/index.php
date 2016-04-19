<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h1 class="section-name_2">Car Dimensions</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=SiteConfig::getInstance()->getValue('dimensions_header_text_block')?>
			</div>
		</section>
		
		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Select the targeted make or model to view its dimensions</h2>
				<ul>
				<?php $key=1;foreach (AutoMake::getAllFront() as $makeUrl=>$makeTitle):?>
					<li><a title="<?=$makeTitle?> dimensions" href="/dimensions<?=$makeUrl?>"><?=$makeTitle?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
				</ul>			
		</section>	
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('dimensions_footer_text_block')?>
		</section>
	</div>
	
	
	<div class="l-col2">
				<br>
		<section class="right-block">
					
			<?php $this->renderPartial('application.views.specs._right_index')?>		

		</section>
<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

	</div>
	
	
</main>