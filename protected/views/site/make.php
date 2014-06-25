<main class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="make">
			<h2 class="section-name"><?=$make['title']?> vehicles</h2>
			<div class="make__logo">
				<img src="<?=$make['photo']?>">
			</div>
			<div class="make__history">
				<?=$make['description']?>
			</div>
			<ul class="make__vehicle">
			<?php foreach ($dataModels as $dataModel):?>
				<li>
				<div class="make__vehicle-image"><a href="<?=$dataModel['url']?>">
					<?php if (isset($dataModel['photo'])):?>
						<img src="<?=$dataModel['photo']?>"> 
					<?php endif;?>
				</a></div>
					<h3><a href="<?=$dataModel['url']?>"><?=$make['title']?> <?=$dataModel['title']?></a></h3>
					<ul class="make__vehicle-specs">
						<li>MSRP $<?=number_format($dataModel['price']['min'], 0, '', ',');?>
							<?php if ($dataModel['price']['min'] != $dataModel['price']['max']):?>
								- $<?=number_format($dataModel['price']['max'], 0, '', ',');?>
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
					<?php foreach ($dataModel['years'] as $year):?>	
						<li><a href="#"><?=$year?></a></li>
					<?php endforeach; ?>
					</ul>
				</li>
			<?php endforeach;?>	
			</ul>
		</section>
		
		<!-- 
		<section class="news">
			<h2 class="section-name">Acura news</h2>
			<div class="news__container">
				<ul class="news__list">
					<li class="is-active">
						<div class="news__image">
							<a href="#"><img src="/img/reviews.jpg"></a>
						</div>
						<p class="news__date">Jun 04th, 2014</p>
						<h3><a href="#">2014 Cadillac ELR</a></h3>
						<p>The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car. The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car. The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</p>
					</li>
					<li>
						<p class="news__date">Jun 04th, 2014</p>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
					<li>
						<p class="news__date">Jun 04th, 2014</p>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
					<li>
						<p class="news__date">Jun 04th, 2014</p>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
					<li>
						<p class="news__date">Jun 04th, 2014</p>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
					<li>
						<p class="news__date">Jun 04th, 2014</p>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
				</ul>
				<a href="#" class="btn btn_news">More news</a>
			</div>
		</section>
		-->
		
		<!--
		<section class="reviews">
			<h2 class="section-name">Acura reviews</h2>
			<ul class="reviews__tabs">
				<li class="is-active"><a href="#">Expert reviews</a></li>
				<li><a href="#">Video reviews</a></li>
				<li><a href="#">Consumer reviews</a></li>
			</ul>
			<div class="reviews__container">
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<a href="#" class="btn btn_reviews">More reviews</a>
			</div>
		</section>
		-->
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('action' => 'home')); ?>
		
		<section class="right-block">
			<h2 class="section-name"><?=$make['title']?> specs and dimensions</h2>
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
		
		<!--
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
		-->
		
	</div>
</main>