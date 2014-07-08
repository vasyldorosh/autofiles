<main class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="model">
			<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> vehicles</h2>
			<p class="model__about">
				<?=$model['description']?>
			</p>
			
			<h3><a title="<?=$completion['year']?> <?=$make['title']?> <?=$model['title']?>" href="<?=$model['url']?><?=$completion['year']?>/"><?=$completion['year']?> <?=$make['title']?> <?=$model['title']?></a></h3>
			
			<div class="model__specs">
				<div class="model__specs-image">
				<a href="<?=$model['url']?><?=$completion['year']?>/"><img alt="Photo <?=$completion['year']?> <?=$make['title']?> <?=$model['title']?>" src="<?=$lastModelYear['photo']?>"></a></div>
				<?php $this->renderPartial('_model_specs', array('completion'=>$completion))?>
			</div>		
			
			<div>
			<?php foreach ($modelByYears as $modelByYear): if ($lastModelYear['year'] == $modelByYear['year']) {continue;}?>
				<a title="<?=$modelByYear['year']?> <?=$make['title']?> <?=$model['title']?>" href="<?=$model['url']?><?=$modelByYear['year']?>/" class="model__block"><span><?=$modelByYear['year']?></span><img src="<?=$modelByYear['photo']?>"></a>
			<?php endforeach;?>	
			</div>
		</section>
		<!-- section 2 -->
		<section class="all-models">
			<h2 class="section-name">All <?=$make['title']?> models</h2>
			<p><strong><?=$make['title']?>:</strong>
			<?php foreach ($models as $item):?>
				<a title="<?=$make['title']?> <?=$item['title']?>" href="<?=$item['url']?>"><?=$item['title']?></a>,
			<?php endforeach;?>
			</p>
		</section>
		
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
				<li class="speed"><a href="/0-60-times<?=$model['url']?>">0-60 times</a></li>
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