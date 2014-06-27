<div class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="model-year">
			<h2 class="section-name section-name_regular"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?></h2>
			<div class="model-year__box">
				<div class="model-year__box-left">
					<div class="model-year__image">
						<img src="<?=$modelYear['photo']?>">
					</div>
					<!--
					<ul class="model-year__links">
						<li><a href="#">Photos</a></li>
						<li><a href="#">Wallpapers</a></li>
						<li><a href="#">Colors</a></li>
					</ul>
					-->
					
				</div>
				<div class="model-year__box-right">
					<h3><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> trim levels</h3>
					<?php if (!empty($completions)):?>
					<table>
						<tbody>
						<?php foreach ($completions as $completion):?>
						<tr>
							<td class="model-year__trim-levels"><?=$modelYear['year']?> <?=$model['title']?> <?=$completion['title']?>, Engine: <?=AutoSpecsOption::getV('engine', $completion['specs_engine']);?></td>
							<td class="model-year__cost">MSRP $<?=$completion['specs_msrp']?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
					</table>
					<!--
					<ul class="model-year__links">
						<li><a href="#">Compare trims</a></li>
						<li><a href="#">Across years</a></li>
						<li><a href="#">Competitors</a></li>
					</ul>		
					-->
					<?php else:?>
						<p>Trims not founded</p>
					<?php endif;?>

					<ul class="model-year__years">
						<?php foreach ($modelYears as $item):?>
							<li <?=($modelYear['year']==$item['year'])?'class="is-active"':''?>><a href="<?=$model['url']?><?=$item['year']?>/"><?=$item['year']?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		</section>
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
		
		<!--
		<section class="parts">
			<h2 class="section-name">Automotive Parts &amp; Accessories</h2>
		
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
				<ul>
					<li><a href="#">Brakes, Suspension</a></li>
					<li><a href="#">Electrical, Iqnition</a></li>
					<li><a href="#">Exhaust, Filters</a></li>
					<li><a href="#">Liqhting, Wiper Blades</a></li>
					<li><a href="#">Lift Supports</a></li>
					<li>
						<a href="#">Shocks &amp; Struts</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts &amp; Accessories</a></h2>
				<ul>
					<li><a href="#">Brake system</a></li>
					<li><a href="#">Exhaust system</a></li>
					<li><a href="#">Filters, Fuel system</a></li>
					<li><a href="#">Ignition Parts</a></li>
					<li><a href="#">Shocks &amp; Struts</a></li>
					<li>
						<a href="#">Suspension &amp; Chassis</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp; Portable Power</a></h2>
				<ul>
					<li><a href="#">Battery Chargers</a></li>
					<li><a href="#">Jump Starters</a></li>
					<li><a href="#">Power Inverters</a></li>
					<li><a href="#">Power Packs</a></li>
					<li>
						<a href="#">Renewable Energy</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>

			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
				<ul>
					<li><a href="#">Brakes, Suspension</a></li>
					<li><a href="#">Electrical, Iqnition</a></li>
					<li><a href="#">Exhaust, Filters</a></li>
					<li><a href="#">Liqhting, Wiper Blades</a></li>
					<li><a href="#">Lift Supports</a></li>
					<li>
						<a href="#">Shocks &amp; Struts</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts &amp; Accessories</a></h2>
				<ul>
					<li><a href="#">Brake system</a></li>
					<li><a href="#">Exhaust system</a></li>
					<li><a href="#">Filters, Fuel system</a></li>
					<li><a href="#">Ignition Parts</a></li>
					<li><a href="#">Shocks &amp; Struts</a></li>
					<li>
						<a href="#">Suspension &amp; Chassis</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp; Portable Power</a></h2>
				<ul>
					<li><a href="#">Battery Chargers</a></li>
					<li><a href="#">Jump Starters</a></li>
					<li><a href="#">Power Inverters</a></li>
					<li><a href="#">Power Packs</a></li>
					<li>
						<a href="#">Renewable Energy</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
		
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
				<ul>
					<li><a href="#">Brakes, Suspension</a></li>
					<li><a href="#">Electrical, Iqnition</a></li>
					<li><a href="#">Exhaust, Filters</a></li>
					<li><a href="#">Liqhting, Wiper Blades</a></li>
					<li><a href="#">Lift Supports</a></li>
					<li>
						<a href="#">Shocks &amp; Struts</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts &amp; Accessories</a></h2>
				<ul>
					<li><a href="#">Brake system</a></li>
					<li><a href="#">Exhaust system</a></li>
					<li><a href="#">Filters, Fuel system</a></li>
					<li><a href="#">Ignition Parts</a></li>
					<li><a href="#">Shocks &amp; Struts</a></li>
					<li>
						<a href="#">Suspension &amp; Chassis</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="/img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp; Portable Power</a></h2>
				<ul>
					<li><a href="#">Battery Chargers</a></li>
					<li><a href="#">Jump Starters</a></li>
					<li><a href="#">Power Inverters</a></li>
					<li><a href="#">Power Packs</a></li>
					<li>
						<a href="#">Renewable Energy</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
		</section>
		-->
	
		<?php if (!empty($competitors) && false):?>
		<section class="make make_competitors">
			<h2 class="section-name section-name_regular"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> competitors</h2>
			<ul class="make__vehicle">
			<?php foreach ($competitors as $item):?>
				<li>
					<div class="make__vehicle-image"><a title="<?=$item['year']?> <?=$item['make']?> <?=$item['model']?>" href="/<?=$item['make_alias']?>/<?=$item['model_alias']?>/<?=$item['year']?>/"><img alt="Photo <?=$item['year']?> <?=$item['make']?> <?=$item['model']?>" src="<?=$item['photo']?>"></a></div>
					<h3><a href="/<?=$item['make_alias']?>/<?=$item['model_alias']?>/<?=$item['year']?>/"><?=$item['year']?> <?=$item['make']?> <?=$item['model']?></a></h3>
					<ul class="make__vehicle-specs">
						<li>MSRP <?=HtmlHelper::price($item['price']['min']);?>
							<?php if ($item['price']['min'] != $item['price']['max']):?>
								- <?=HtmlHelper::price($item['price']['max']);?>
							<?php endif;?>
						</li>
						<li>Engine: <?=$item['completion']['engine']?></li>
						<?php if (!empty($item['completion']['fuel_economy_city']) && !empty($item['completion']['fuel_economy_highway'])):?>
							<li>MPG: <?=$item['completion']['fuel_economy_city']?> / <?=$item['completion']['fuel_economy_highway']?></li>
						<?php endif;?>
						<?php if (!empty($item['completion']['standard_seating'])):?>
							<li>Seating Capacity: <?=$item['completion']['standard_seating']?></li>
						<?php endif;?>
					</ul>
					<!--<a href="#" class="compare">Compare</a>-->
					
				</li>
			<?php endforeach;?>	
			</ul>
		</section>
		<?php endif;?>
	
		<section class="all-models">
			<h2 class="section-name section-name_regular">All <?=$modelYear['year']?> <?=$make['title']?> models</h2>
			<div class="model__block-box model__block-box_all-models">
			<?php foreach ($models as $item):?>
				<div class="model__block model__block_all-models">
				<a title="<?=$item['year']?> <?=$make['title']?> <?=$item['model']?>" href="/<?=$make['alias']?>/<?=$item['model_alias']?>/<?=$item['year']?>/">	
					<img alt="Photo <?=$item['year']?> <?=$make['title']?> <?=$item['model']?>" src="<?=$item['photo']?>">
					<div class="model__block-name"><h3><?=$item['year']?> <?=$make['title']?> <?=$item['model']?></h3></div>
					<span class="model__block-cost">MSRP <?=HtmlHelper::price($item['price']['min'])?> - <?=HtmlHelper::price($item['price']['max'])?></span>
				</a>
				</div>
			<?php endforeach;?>	
			</div>
		</section>
		
		<!--
		<section class="reviews">
			<h2 class="section-name section-name_regular"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> reviews</h2>
			<ul class="reviews__tabs">
				<li data-block="b1" class="is-active">
					<a href="#">Expert reviews</a>
				</li>
				<li data-block="b2"><a href="#">Video reviews</a></li>
				<li data-block="b3"><a href="#">Consumer reviews</a></li>
			</ul>
			<div id="b1" class="reviews__container">
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
			<div id="b2" class="reviews__container" hidden="true">
				<div class="reviews__block">
					
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
			<div id="b3" class="reviews__container" hidden="true">
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
		
		<!--
		<section class="write-review">
			<p class="section-name section-name_regular">Write your review about <?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?></p>
			<form action="">
				<div class="write-review__text"><textarea name="" id="" rows="6" placeholder="Add a review"></textarea></div>
				<div class="write-review__col">
					<div class="write-review__checkbox"><input name="notify" type="checkbox" checked=""> Notify me of follow-up comments</div>
					<div class="write-review__user-name"><span><i></i></span><input type="text" placeholder="Your Name"></div>
					<div class="write-review__user-email"><span><i></i></span><input type="text" placeholder="Email">
					<div class="write-review__captcha">
						<div class="write-review__captcha-image"><img src="/img/captcha.png"></div>
						<div class="write-review__captcha-input"><input type="text"></div>
					</div>
					<a class="write-review__captcha-reload" href="#">Try another image?</a>
					<button type="submit" class="btn btn_submit">Submit</button>
				</div>
			
		</div></form></section>
		-->
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<?php if (!empty($carSpecsAndDimensions) && false):?>
		<section class="right-block">
			<h2 class="section-name"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> specs and dimensions</h2>
			<table class="right-block__specs-list">
				<tbody><tr>
					<td><a class="speed" href="#">0-60 times</a></td>
					<td class="spec-value">
					<?php if ($carSpecsAndDimensions['0_60_times']['mmin'] != $carSpecsAndDimensions['0_60_times']['mmax']):?>
						<?=(float)$carSpecsAndDimensions['0_60_times']['mmin']?> - <?=(float)$carSpecsAndDimensions['0_60_times']['mmax']?>
					<?php else:?>
						<?=(float)$carSpecsAndDimensions['0_60_times']['mmin']?>
					<?php endif;?>
					sec
					</td>
				</tr>
				
				<?php if (!empty($carSpecsAndDimensions['engine'])):?>
				<tr>
					<td><a class="engine" href="#">Engine specs</a></td>
					<td class="spec-value"><?=$carSpecsAndDimensions['engine']?></td>
				</tr>
				<?php endif;?>
				
				<?php if (!empty($carSpecsAndDimensions['horsepower'])):?>
				<tr>
					<td><a class="horsepower" href="#">Horsepower</a></td>
					<td class="spec-value"><?=$carSpecsAndDimensions['horsepower']?></td>
				</tr>
				<?php endif;?>
				
				<?php if (!empty($carSpecsAndDimensions['horsepower'])):?>
				<tr>
					<td><a class="gas" href="#">Gas mileage</a></td>
					<td class="spec-value"><?=$carSpecsAndDimensions['gas_mileage']?></td>
				</tr>
				<?php endif;?>
				
				<tr>
					<td><a class="towing" href="#">Towing capacity</a></td>
					<td class="spec-value">
					<?php if ($carSpecsAndDimensions['towing_capacity']['mmin'] != $carSpecsAndDimensions['towing_capacity']['mmax']):?>
						<?=(float)$carSpecsAndDimensions['towing_capacity']['mmin']?> - <?=(float)$carSpecsAndDimensions['towing_capacity']['mmax']?>
					<?php else:?>
						<?=(float)$carSpecsAndDimensions['towing_capacity']['mmin']?>
					<?php endif;?>					
					lbs</td>
				</tr>
				
				<tr>
					<td><a class="length" href="#">Length</a></td>
					<td class="spec-value">
					<?php if ($carSpecsAndDimensions['length']['mmin'] != $carSpecsAndDimensions['length']['mmax']):?>
						<?=(float)$carSpecsAndDimensions['length']['mmin']?> - <?=(float)$carSpecsAndDimensions['length']['mmax']?>
					<?php else:?>
						<?=(float)$carSpecsAndDimensions['length']['mmin']?>
					<?php endif;?>					
					”</td>
				</tr>
				
				<tr>
					<td><a class="wheelbase" href="#">Wheelbase</a></td>
					<td class="spec-value">
					<?php if ($carSpecsAndDimensions['wheelbase']['mmin'] != $carSpecsAndDimensions['wheelbase']['mmax']):?>
						<?=(float)$carSpecsAndDimensions['wheelbase']['mmin']?> - <?=(float)$carSpecsAndDimensions['wheelbase']['mmax']?>
					<?php else:?>
						<?=(float)$carSpecsAndDimensions['wheelbase']['mmin']?>
					<?php endif;?>						
					”</td>
				</tr>
				<tr>
					<td><a class="clearance" href="#">Clearance</a></td>
					<td class="spec-value">
					<?php if ($carSpecsAndDimensions['clearance']['mmin'] != $carSpecsAndDimensions['clearance']['mmax']):?>
						<?=(float)$carSpecsAndDimensions['clearance']['mmin']?> - <?=(float)$carSpecsAndDimensions['clearance']['mmax']?>
					<?php else:?>
						<?=(float)$carSpecsAndDimensions['clearance']['mmin']?>
					<?php endif;?>						
					”</td>
				</tr>
				<tr>
					<td><a class="weight" href="#">Curb weight</a></td>
					<td class="spec-value">
					<?php if ($carSpecsAndDimensions['curb_weight']['mmin'] != $carSpecsAndDimensions['curb_weight']['mmax']):?>
						<?=(float)$carSpecsAndDimensions['curb_weight']['mmin']?> - <?=(float)$carSpecsAndDimensions['curb_weight']['mmax']?>
					<?php else:?>
						<?=(float)$carSpecsAndDimensions['curb_weight']['mmin']?>
					<?php endif;?>	
					lbs</td>
				</tr>
				<tr>
					<td><a class="cargo" href="#">Cargo space</a></td>
					<td class="spec-value">
					<?php if ($carSpecsAndDimensions['cargo_space']['mmin'] != $carSpecsAndDimensions['cargo_space']['mmax']):?>
						<?=(float)$carSpecsAndDimensions['cargo_space']['mmin']?> - <?=(float)$carSpecsAndDimensions['cargo_space']['mmax']?>
					<?php else:?>
						<?=(float)$carSpecsAndDimensions['cargo_space']['mmin']?>
					<?php endif;?>	
					cu.ft</td>
				</tr>
			</tbody></table>
		</section>
		<?php endif;?>
		
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
</div>