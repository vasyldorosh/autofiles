<main class="l">
	<div class="l-col1">
		<!-- section 1 -->

		<?php $this->widget('application.widgets.CatalogWidget', array('action' => 'makes')); ?>
	
		<section class="seo-text">
			<h3>Discovering your car’s secrets!</h3>
	

			<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			
                  <p>Autofiles.com will guide you through the wide range of cars in the world.</p>
<p>The world’s auto market comprises more than 60 basic makes with hundreds of models and trims appearing every year. No wonder that sometimes it is quite difficult to select a vehicle meeting all your demands or find a specific detail fitting exactly into your car model. Autofiles.com will help you choose from the variety of options providing tools to compare different makes, models and trims by years, price or body style.</p>
<p>Browse through the list of car makes, choose your model, a desired trim and body style and we will provide you with an extensive data on your car technical specifications and features, 0-60 mph results and other insights you never knew about your car. You can always narrow your search down with a solid number of important features like transmission base, fuel type, gas mileage, drive type, torque, horsepower, safety, etc.</p>
<p>Another exciting rating tool is the 0-60 mph comparison. Find out how fast your car can reach the speed of 60 miles per hour in comparison to other autos. That’s really interesting! Watch the 0-60 mph videos and try to race one day for yourself.</p>
<p>And, of course, you want the best car for less money. Prices for cars vary a lot these days. When buying a vehicle you can only see dealer’s price tags, when in fact you also have to take into account the cost of ownership, service and maintenance of your auto. It may turn out that, in the long-term perspective a cheaper car can cost you more than an expensive competitor.</p>
<p>In order to check it, you may compare cars by fuel consumption rates in the city or on a highway, read consumer reviews and independent professional test-drives which are also very helpful. Design matters for many people as well, so you are welcome to estimate exteriors and interiors of various models in our gallery of auto photos.</p>
<p>If you already possess a car and your iron horse needs quick maintenance or repair we will help you find and buy all the necessary auto supplies and accessories. We answer questions on car specifications. By the way, do you know the tire size for your vehicle? What kind of wheels fit your car? No problem. We’ll tell you then!</p>
<p>You just have to specify your make, model, trim and year of production to see the tires and wheels your car needs. We will help you buy them right away!</p>
		</section>

		<!-- section 2 -->
		<?php $years = AutoModelYear::getYears();?>
		<section class="options">
			<p class="section-name">Select options</p>
			<div class="options__block">
				<div class="options__item">
					<strong>Year</strong>
					<select id="Filter_year">
						<option>-no select-</option>
						<?php foreach ($years as $year):?>
						<option value="<?=$year?>"><?=$year?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="options__item">
					<strong>Make</strong>
					<select id="Filter_make_id">
						<option>-no select-</option>
					</select>
				</div>
				<div class="options__item">
					<strong>Model</strong>
					<select id="Filter_model_id">
						<option>-no select-</option>
					</select>
				</div>
				<button style="display: none;" type="submit" class="btn btn_options" id="btn_submit_filter">GO</button>
			</div>
		</section>
		
<script>
$('#Filter_year').change(function(e) {
	$('#Filter_make_id').empty().append('<option value="">-no select-</option>');
	$('#Filter_model_id').empty().append('<option value="">-no select-</option>');
	$.post('/ajax/getMakesByYear', {'year': $(this).val()} , function(response) {
		$.each(response.items, function(value, lable){
			$('#Filter_make_id').append('<option value="'+value+'">'+lable+'</option>');
		});
	}, 'json');
});

$('#Filter_make_id').change(function(e) {
	$('#Filter_model_id').empty();
	$('#Filter_model_id').append('<option value="">-no select-</option>');
	$.post('/ajax/getModelsByMake', {'alias': $(this).val(), 'year': $('#Filter_year').val()} , function(response) {
		$.each(response.items, function(value, lable){
			$('#Filter_model_id').append('<option value="'+value+'">'+lable+'</option>');
		});
	}, 'json');
});

$('#Filter_model_id').change(function(e) {
	if ($(this).val() == '') {
		$('#btn_submit_filter').hide();
	} else {
		$('#btn_submit_filter').show();
	} 
});




$('#btn_submit_filter').click(function(e) {
	url = '/' + $('#Filter_make_id').val() + '/' + $('#Filter_model_id').val() + '/' + $('#Filter_year').val() + '/';
	window.location = url;
});
</script>	
		
		<!-- section 3 -->
		<!--
		<section class="parts">
			<h2 class="section-name">Automotive Parts &amp Accessories</h2>
	
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
				<ul>
					<li><a href="#">Brakes, Suspension</a></li>
					<li><a href="#">Electrical, Iqnition</a></li>
					<li><a href="#">Exhaust, Filters</a></li>
					<li><a href="#">Liqhting, Wiper Blades</a></li>
					<li><a href="#">Lift Supports</a></li>
					<li>
						<a href="#">Shocks &amp Struts</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts & Accessories</a></h2>
				<ul>
					<li><a href="#">Brake system</a></li>
					<li><a href="#">Exhaust system</a></li>
					<li><a href="#">Filters, Fuel system</a></li>
					<li><a href="#">Ignition Parts</a></li>
					<li><a href="#">Shocks &amp Struts</a></li>
					<li>
						<a href="#">Suspension &amp Chassis</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp Portable Power</a></h2>
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
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
				<ul>
					<li><a href="#">Brakes, Suspension</a></li>
					<li><a href="#">Electrical, Iqnition</a></li>
					<li><a href="#">Exhaust, Filters</a></li>
					<li><a href="#">Liqhting, Wiper Blades</a></li>
					<li><a href="#">Lift Supports</a></li>
					<li>
						<a href="#">Shocks &amp Struts</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts & Accessories</a></h2>
				<ul>
					<li><a href="#">Brake system</a></li>
					<li><a href="#">Exhaust system</a></li>
					<li><a href="#">Filters, Fuel system</a></li>
					<li><a href="#">Ignition Parts</a></li>
					<li><a href="#">Shocks &amp Struts</a></li>
					<li>
						<a href="#">Suspension &amp Chassis</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp Portable Power</a></h2>
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
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Replacement Parts</a></h2>
				<ul>
					<li><a href="#">Brakes, Suspension</a></li>
					<li><a href="#">Electrical, Iqnition</a></li>
					<li><a href="#">Exhaust, Filters</a></li>
					<li><a href="#">Liqhting, Wiper Blades</a></li>
					<li><a href="#">Lift Supports</a></li>
					<li>
						<a href="#">Shocks &amp Struts</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Performance Parts & Accessories</a></h2>
				<ul>
					<li><a href="#">Brake system</a></li>
					<li><a href="#">Exhaust system</a></li>
					<li><a href="#">Filters, Fuel system</a></li>
					<li><a href="#">Ignition Parts</a></li>
					<li><a href="#">Shocks &amp Struts</a></li>
					<li>
						<a href="#">Suspension &amp Chassis</a>
						<a href="#" class="btn btn_more">...</a>
					</li>
				</ul>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a href="#"><img src="img/parts.jpg" alt="parts"></a>
				</div>
				<h2><a href="#">Jump Starters, Battery Chargers &amp Portable Power</a></h2>
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
		

		
		<?php $this->widget('application.widgets.CatalogWidget', array('action' => 'MostVisitedModelYear')); ?>
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
		
		<!--
		<section class="reviews">
			<h2 class="section-name">Car reviews</h2>
			<ul class="reviews__tabs">
				<li data-block="#b1" class="is-active">
					<a href="javascript:;">Expert reviews</a>
				</li>
				<li data-block="#b2"><a href="javascript:;">Video reviews</a></li>
				<li data-block="#b3"><a href="javascript:;">Consumer reviews</a></li>
			</ul>
			<div id="b1" class="reviews__container active">
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
			<div id="b2" class="reviews__container">
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
			<div id="b3" class="reviews__container">
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
		
		<section class="news">
			<h2 class="section-name">Automotive news</h2>
			<div class="news__container">
				<ul class="news__list">
					<li class="is-active">
						<div class="news__image">
							<a href="#"><img src="img/reviews.jpg"></a>
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
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<section class="right-block">
			<h2 class="section-name">Car specs and dimensions</h2>
			<ul class="right-block__specs-list">
				<li class="speed"><a href="/0-60-times.html">0-60 times</a></li>
				<li class="engine"><a href="#">Engine specs</a></li>
				<li class="horsepower"><a href="#">Horsepower</a></li>
				<li class="gas"><a href="#">Gas mileage</a></li>
				<li class="towing"><a href="#">Towing capacity</a></li>
				<li class="length"><a href="#">Length</a></li>
				<li class="wheelbase"><a href="#">Wheelbase</a></li>
				<li class="clearance"><a href="#">Clearance</a></li>
				<li class="weight"><a href="#">Curb weight</a></li>
				<li class="cargo"><a href="#">Cargo space</a></li>
			</ul>
		</section>
		<!--<section class="right-block">
			<h2 class="section-name">Tires</h2>
			<div>
			<div class="right-block__image">
				<img src="img/tires.png">
			</div>
			<ul class="right-block__tires-list">
				<li><a href="#">tire size</a></li>
				<li><a href="#">tire pressure</a></li>
				<li><a href="#">bolt pattern</a></li>
				<li><a href="#">wheels</a></li>
				<li><a href="#">rims</a></li>
			</ul>
		</section>
		<section class="right-block">
			<h2 class="section-name">Car wallpapers</h2>
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
		</section>-->
	</div>
</main>