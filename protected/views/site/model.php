<main class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="model">
			<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> vehicles</h2>
			<p class="model__about">
				<?=$model['description']?>
			</p>
			
			<h3><?=$completion['year']?> <?=$make['title']?> <?=$model['title']?></h3>
			<div class="model__specs">
				<div class="model__specs-image"><img src="<?=$lastModelYear['photo']?>"></div>
				<table class="model__specs-table">
					<tbody><tr>
						<td>MSRP <?=HtmlHelper::price($completion['specs_msrp'], 0, '', ',');?></td>
					
						<?php if (!empty($completion['specs_fuel_tank'])):?>
							<td>Fuel Tank <?=$completion['specs_fuel_tank']?> gal</td>
						<?php endif;?>							
						
						<?php if (!empty($completion['specs_wheelbase'])):?>
							<td>Wheelbase <?=$completion['specs_wheelbase']?> ”</td>
						<?php endif;?>							

					</tr>
					<tr>
					<?php if (!empty($completion['specs_fuel_economy__city']) && !empty($completion['specs_fuel_economy__highway'])):?>
						<td>MPG <?=$completion['specs_fuel_economy__city']?> city/<?=$completion['specs_fuel_economy__highway']?> hwy</td>
					<?php endif;?>	
					<?php if (!empty($completion['specs_0_60mph__0_100kmh_s_'])):?>
						<td>0-60 mph <?=$completion['specs_0_60mph__0_100kmh_s_']?> sec</td>
					<?php endif;?>		

					<?php if (!empty($completion['specs_ground_clearance'])):?>
						<td>Clearance <?=$completion['specs_ground_clearance']?>”</td>
					<?php endif;?>	
					</tr>
					
					<tr>
						<td>Engine <?=AutoSpecsOption::getV('engine', $completion['specs_engine'])?></td>
	
					<?php if (!empty($completion['specs_maximum_trailer_weight'])):?>
						<td>Towing <?=$completion['specs_maximum_trailer_weight']?> lbs</td>
					<?php endif;?>		
	
					<?php if (!empty($completion['specs_curb_weight'])):?>
						<td>Curb <?=$completion['specs_curb_weight']?> lbs</td>
					<?php endif;?>													
					</tr>
					<tr>
						<?php if (!empty($completion['specs_hp_horsepower'])):?>
							<td>HP <?=$completion['specs_hp_horsepower']?> rpm</td>
						<?php endif;?>							
						
						<?php if (!empty($completion['specs_front_tires'])):?>
							<td>Tires <?=$completion['specs_front_tires']?></td>
						<?php endif;?>							
			
						<?php if (!empty($completion['specs_luggage_volume'])):?>
							<td>Cargo <?=$completion['specs_luggage_volume']?> cu.ft</td>
						<?php endif;?>							
					</tr>
				</tbody></table>
			</div>
			<div>
			<?php foreach ($modelByYears as $modelByYear): if ($lastModelYear['year'] == $modelByYear['year']) {continue;}?>
				<a href="<?=$model['url']?><?=$modelByYear['year']?>/" class="model__block"><span><?=$modelByYear['year']?></span><img src="<?=$modelByYear['photo']?>"></a>
			<?php endforeach;?>	
			</div>
		</section>
		<!-- section 2 -->
		<section class="all-models">
			<h2 class="section-name">All <?=$make['title']?> models</h2>
			<p><strong><?=$make['title']?>:</strong>
			<?php foreach ($models as $item):?>
				<a href="<?=$item['url']?>"><?=$item['title']?></a>,
			<?php endforeach;?>
			</p>
		</section>
		
		<?php $this->widget('application.widgets.CatalogWidget', array('action' => 'makes')); ?>
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<?/*?>
		<section class="right-block">
			<h2 class="section-name">Find an Acura dealer near you</h2>
			<p class="find-dealer">Shop for cars in your area.<br>
			ZIP code: <input type="text" class="zipcode"><button type="submit" class="btn btn_zipcode">Search Used</button></p>
			<a href="#">Find Local Dealers</a>
		</section>
		<?*/?>
		
		<section class="right-block">
			<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> specs and dimensions</h2>
			<ul class="right-block__specs-list">
				<li class="speed"><a href="#">0-60 times</a></li>
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
		
		<?/*?>
		<section class="right-block">
			<h2 class="section-name">Acura wallpapers</h2>
			<ul class="right-block__wallpaper-list">
				<li><a href="#"></a></li>
				<li><a href="#">2015 Citroen DS3</a></li>
				<li><a href="#">2015 Citroen DS3 Cabrio</a></li>
				<li><a href="#">2015 Audi S7 Sportback</a></li>
				<li><a href="#">2015 Audi A7 Sportback</a></li>
				<li><a href="#">2015 GMC Sierra All Terrain</a></li>
				<li><a href="#">2015 Mercedes-Benz C-Class Estate</a></li>
				<li><a href="#">2014 Seat Ibiza Cupster Concept</a></li>
				<li><a href="#">2014 Nissan X-Trail</a></li>
				<li><a href="#">2015 Nissan Juke</a></li>
				<li><a href="#">2015 Nissan Pulsar</a></li>
			</ul>
		</section>
		<?*/?>
		
	</div>
</main>