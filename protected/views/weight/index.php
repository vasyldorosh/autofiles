<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h1 class="section-name_1">Car weight</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=SiteConfig::getInstance()->getValue('weight_header_text_block')?>
			</div>
		</section>
		
		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Select make and model to view its curb weight</h2>
		
			<ul>
				<?php $key=1;foreach ($makes as $make):?>
					<li><a title="<?=$make['title']?> weight" href="/weight/<?=$make['alias']?>/"><?=$make['title']?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
			</ul>														
		
		</section>	
		
		<section class="product_photo_box make">
			<h2 class="section-name_2">5 easiest cars in our database</h2>
			<ul class="make__vehicle">
			<?php foreach ($easiestItems as $item):?>	
				<li>
					<div class="make__vehicle-image">
						<a title="<?= $item['make_title']?> <?= $item['make_alias']?> weight" href="/weight/<?= $item['make_alias']?>/<?= $item['model_alias']?>/">
							<img src="<?= $item['photo']?>"></a>
					</div>
					<h3><a title="<?= $item['make_title']?> <?= $item['model_title']?> weight" href="/weight/<?= $item['make_alias']?>/<?= $item['model_alias']?>/"><?= $item['model_year']?> <?= $item['make_title']?> <?= $item['model_title']?></a></h3>
					<h3><?= $item['completion_title']?></h3>
					<ul class="make__vehicle-specs">
						<li>Car weight <?= (int)$item['curb_weight']?> lbs.</li>
					</ul>
				</li>
			<?php endforeach;?>	
			</ul>
		</section>
		
		
			<section class="product_photo_box make">
			<h2 class="section-name_2">5 heaviest cars in our database</h2>
			<ul class="make__vehicle">
			<?php foreach ($heaviestItems as $item):?>	
				<li>
					<div class="make__vehicle-image">
						<a title="<?= $item['make_title']?> <?= $item['make_alias']?> weight" href="/weight/<?= $item['make_alias']?>/<?= $item['model_alias']?>/">
							<img src="<?= $item['photo']?>"></a>
					</div>
					<h3><a title="<?= $item['make_title']?> <?= $item['model_title']?> weight" href="/weight/<?= $item['make_alias']?>/<?= $item['model_alias']?>/"><?= $item['model_year']?> <?= $item['make_title']?> <?= $item['model_title']?></a></h3>
					<h3><?= $item['completion_title']?></h3>
					<ul class="make__vehicle-specs">
						<li>Car weight <?= (int)$item['curb_weight']?> lbs.</li>
					</ul>
				</li>
			<?php endforeach;?>	
			</ul>
		</section>
		
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('weight_footer_text_block')?>
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