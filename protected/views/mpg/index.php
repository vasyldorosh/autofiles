<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h1 class="section-name_1">Mpg</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=SiteConfig::getInstance()->getValue('mpg_header_text_block')?>
			</div>
		</section>
		
		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Select make and model to view its mpg</h2>
		
			<ul>
				<?php $key=1;foreach ($makes as $make):?>
					<li><a title="<?=$make['title']?> mpg" href="/mpg/<?=$make['alias']?>/"><?=$make['title']?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
			</ul>														
		
		</section>	

		<section class="product_photo_box make">
			<h2 class="section-name_2">10 Best Fuel Economy Vehicles</h2>
			<ul class="make__vehicle">
			<?php foreach ($bestItems as $item):?>	
				<li>
					<div class="make__vehicle-image">
						<a title="<?= $item['make_title']?> <?= $item['make_alias']?> mpg" href="/mpg/<?= $item['make_alias']?>/<?= $item['model_alias']?>/">
							<img src="<?= $item['photo']?>"></a>
					</div>
					<h3><a title="<?= $item['make_title']?> <?= $item['model_title']?> mpg" href="/mpg/<?= $item['make_alias']?>/<?= $item['model_alias']?>/"><?= $item['model_year']?> <?= $item['make_title']?> <?= $item['model_title']?></a></h3>
					<h3><?= $item['completion_title']?></h3>
					<ul class="make__vehicle-specs">
						<li>City MPG <?= (int)$item['fuel_economy_city']?></li>
						<li>Highway MPG <?= (int)$item['fuel_economy_highway']?></li>
					</ul>
				</li>
			<?php endforeach;?>	
			</ul>
		</section>

		
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('mpg_footer_text_block')?>
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