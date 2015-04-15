<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="make">
			<h2 class="section-name"><?=$make['title']?> vehicles</h2>
			<div class="make__logo">
				<img src="<?=$make['photo']?>" alt="<?=$make['title']?> Logo">
			</div>
			<div class="make__history">
				<?=$make['description']?>
			</div>
			<ul class="make__vehicle">
			<?php foreach ($dataModels as $dataModel):?>
				<li>
				<div class="make__vehicle-image"><a title="<?=$make['title']?> <?=$dataModel['title']?>" href="<?=$dataModel['url']?>">
					<?php if (isset($dataModel['photo'])):?>
						<img src="<?=$dataModel['photo']?>"> 
					<?php endif;?>
				</a></div>
					<h3><a href="<?=$dataModel['url']?>"><?=$make['title']?> <?=$dataModel['title']?></a></h3>
					<ul class="make__vehicle-specs">
						<li>MSRP <?=HtmlHelper::price($dataModel['price']['min']);?>
							<?php if ($dataModel['price']['min'] != $dataModel['price']['max']):?>
								- <?=HtmlHelper::price($dataModel['price']['max']);?>
							<?php endif;?>
						</li>
						<li>Engine: <?=$dataModel['completion']['engine']?></li>
						<?php if (!empty($dataModel['completion']['fuel_economy_city']) && !empty($dataModel['completion']['fuel_economy_highway'])):?>
							<li>MPG: <?=$dataModel['completion']['fuel_economy_city']?> / <?=$dataModel['completion']['fuel_economy_highway']?></li>
						<?php endif;?>
						<?php if (!empty($dataModel['completion']['standard_seating'])):?>
							<li>Seating Capacity: <?=$dataModel['completion']['standard_seating']?></li>
						<?php endif;?>
					</ul>
					<ul class="make__vehicle-years">
					<?php foreach ($dataModel['years'] as $item):?>	
						<li><a title="<?=$item['year']?> <?=$make['title']?> <?=$dataModel['title']?>" href="<?=$dataModel['url']?><?=$item['year']?>/"><?=$item['year']?></a></li>
					<?php endforeach; ?>
					</ul>
				</li>
			<?php endforeach;?>	
			</ul>
                <?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
		</section>
		
		
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<section class="right-block">
			<h2 class="section-name"><?=$make['title']?> specs and dimensions</h2>
			<ul class="right-block__specs-list">
				<li class="speed"><a href="/0-60-times<?=$make['url']?>">0-60 times</a></li>
				<!--
				<li class="engine"><a href="#">Engine specs</a></li>
				<li class="horsepower"><a href="#">Horsepower</a></li>
				<li class="gas"><a href="#">Gas mileage</a></li>
				<li class="towing"><a href="#">Towing capacity</a></li>
				<li class="length"><a href="#">Length</a></li>
				<li class="wheelbase"><a href="#">Wheelbase</a></li>
				<li class="clearance"><a href="#">Clearance</a></li>
				<li class="weight"><a href="#">Curb weight</a></li>
				<li class="cargo"><a href="#">Cargo space</a></li>
				-->
			</ul>
		</section>
		
		
		
	</div>
</main>