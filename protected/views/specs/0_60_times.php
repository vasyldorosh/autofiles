<div>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times">
		<h2 class="section-name">0-60 times acceleration stats</h2>
			<div class="times__container">
				<div class="google_links f_left p_rel">
					<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
				</div>
				<div class="text_size">
					<?=SiteConfig::getInstance()->getValue('0_60_times_header_text_block');?>
				</div>
			</div>
		</section>
		
		<!-- section 2 -->
		<section class="all-makes">
			<h2 class="section-name">Browse by make and check your car's 0-60 times</h2>	
			<ul>
				<?php $key=1;foreach ($makes as $makeUrl=>$makeTitle):?>
					<li><a title="<?=$makeTitle?> 0-60 times" href="/0-60-times<?=$makeUrl?>"><?=$makeTitle?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
			</ul>		
		</section>
		<!-- section 3 -->
		<section class="make make_fastest-cars">
			<h2 class="section-name">The fastest cars in our database</h2>
			<ul class="make__vehicle">
			<?php foreach ($fastests as $fastest):?>
				<li>
					<div class="make__vehicle-image"><a title="<?=$fastest['make_title']?> <?=$fastest['model_title']?> 0-60 times" href="/0-60-times/<?=$fastest['make_alias']?>/<?=$fastest['model_alias']?>/"><img src="<?=$fastest['photo']?>"></a></div>
					<h3><a title="<?=$fastest['make_title']?> <?=$fastest['model_title']?> 0-60 times" href="/0-60-times/<?=$fastest['make_alias']?>/<?=$fastest['model_alias']?>/"><?=$fastest['year']?> <?=$fastest['make_title']?> <?=$fastest['model_title']?></a><span class="acceleration-time">0-60 <?=$fastest['speed']?> sec.</span></h3>
					<ul class="make__vehicle-specs">
						<li>1/4 mile <?=$fastest['mile_time']?> @ <?=$fastest['mile_speed']?> mph</li>
						<li>engine <?=$fastest['engine']?></li>
						<li><?=$fastest['horsepower']?> hp</li>
						<li><?=$fastest['torque']?> ft. lbs.</li>
					</ul>
				</li>
			<?php endforeach;?>
			</ul>
		</section>
		<!-- section 4 -->

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>

		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('0_60_times_footer_text_block');?>
		</section>
		<!--
		<section class="news news_related-articles">
			<h2 class="section-name">Related articles</h2>
			<div class="news__container">
				<ul class="news__list">
					<li>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
					<li>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
					<li>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
					<li>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
					<li>
						<h3><a href="#">The concept that wowed crowds at the 2009 Detroit auto show is now beautiful production car.</a></h3>
					</li>
				</ul>
				<a href="#" class="btn btn_news">More articles</a>
			</div>
		</section>
		-->
		
		<!-- 
		<section class="parts parts_min">
			<h2 class="section-name">Automotive Parts &amp Accessories</h2>
		
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts & Accessories</a></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp Portable Power</a></h2>
			</div>
	
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts & Accessories</a></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp Portable Power</a></h2>
			</div>
		
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts & Accessories</a></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp Portable Power</a></h2>
			</div>
		</section>
		-->
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<!--
		<section class="right-block">
			<h2 class="section-name">Car specs and dimensions</h2>
			<table class="right-block__specs-list">
				<tr>
					<td><a class="speed" href="#">0-60 times</a></td>
					<td class="spec-value">5.7 sec</td>
				</tr>
				<tr>
					<td><a class="engine" href="#">Engine specs</a></td>
					<td class="spec-value">3.5L V-6</td>
				</tr>
				<tr>
					<td><a class="horsepower" href="#">Horsepower</a></td>
					<td class="spec-value">273 hp</td>
				</tr>
				<tr>
					<td><a class="gas" href="#">Gas mileage</a></td>
					<td class="spec-value">19/27</td>
				</tr>
				<tr>
					<td><a class="towing" href="#">Towing capacity</a></td>
					<td class="spec-value">1500 lbs</td>
				</tr>
				<tr>
					<td><a class="length" href="#">Length</a></td>
					<td class="spec-value">183.5”</td>
				</tr>
				<tr>
					<td><a class="wheelbase" href="#">Wheelbase</a></td>
					<td class="spec-value">105.7”</td>
				</tr>
				<tr>
					<td><a class="clearance" href="#">Clearance</a></td>
					<td class="spec-value">5.4”</td>
				</tr>
				<tr>
					<td><a class="weight" href="#">Curb weight</a></td>
					<td class="spec-value">3.717 lbs</td>
				</tr>
				<tr>
					<td><a class="cargo" href="#">Cargo space</a></td>
					<td class="spec-value">61.3 cu.ft</td>
				</tr>
			</table>
		</section>
		-->
		
	</div>
</div>