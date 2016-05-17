<main>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-3243264408777652",
    enable_page_level_ads: true
  });
</script>

	<div class="l-col1">
		<!-- section 1 -->

		<?php $this->widget('application.widgets.CatalogWidget', array('action' => 'makes')); ?>
	
		<section class="seo-text">
			<h2 class="section-name_2">Discovering your car’s secrets!</h2>
	

			<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			
                  <p>Autotk.com will guide you through the wide range of cars in the world.</p>
<p>The world’s auto market comprises more than 60 basic makes with hundreds of models and trims appearing every year. No wonder that sometimes it is quite difficult to select a vehicle meeting all your demands or find a specific detail fitting exactly into your car model. Autotk.com will help you choose from the variety of options providing tools to compare different makes, models and trims by years, price or body style.</p>
<p>Browse through the list of car makes, choose your model, a desired trim and body style and we will provide you with an extensive data on your car technical specifications and features, 0-60 mph results and other insights you never knew about your car. You can always narrow your search down with a solid number of important features like transmission base, fuel type, gas mileage, drive type, torque, horsepower, safety, etc.</p>
<p>Another exciting rating tool is the 0-60 mph comparison. Find out how fast your car can reach the speed of 60 miles per hour in comparison to other autos. That’s really interesting! Watch the 0-60 mph videos and try to race one day for yourself.</p>
<p>And, of course, you want the best car for less money. Prices for cars vary a lot these days. When buying a vehicle you can only see dealer’s price tags, when in fact you also have to take into account the cost of ownership, service and maintenance of your auto. It may turn out that, in the long-term perspective a cheaper car can cost you more than an expensive competitor.</p>
<p>In order to check it, you may compare cars by fuel consumption rates in the city or on a highway, read consumer reviews and independent professional test-drives which are also very helpful. Design matters for many people as well, so you are welcome to estimate exteriors and interiors of various models in our gallery of auto photos.</p>
<p>If you already possess a car and your iron horse needs quick maintenance or repair we will help you find and buy all the necessary auto supplies and accessories. We answer questions on car specifications. By the way, do you know the tire size for your vehicle? What kind of wheels fit your car? No problem. We’ll tell you then!</p>
<p>You just have to specify your make, model, trim and year of production to see the tires and wheels your car needs. We will help you buy them right away!</p>
		</section>
                <?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
		<!-- section 2 -->
		<?php $years = AutoModelYear::getYears();?>
		<section class="options">
			<h2 class="section-name_2">Select a car</h2>
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
			<br><br><br>
<p class="section-name_2">0-60 times Hot trends</p>
<p><a title="Nissan Gtr 0-60 times" href="http://autotk.com/0-60-times/nissan/gt-r/">Gtr</a> / 
<a title="Scion Frs 0-60 times" href="http://autotk.com/0-60-times/scion/fr-s/">Frs</a> / 
<a title="Nissan 370z 0-60 times" href="http://autotk.com/0-60-times/nissan/370z/">370z</a> / 
<a title="Audi S4 0-60 times" href="http://autotk.com/0-60-times/audi/s4/">S4</a> / 
<a title="Tesla Model s 0-60 times" href="http://autotk.com/0-60-times/tesla/model-s/">Model s</a> / 
<a title="Mustang Mustang 0-60 times" href="http://autotk.com/0-60-times/ford/mustang/">Mustang</a> / 
<a title="Chevy Camaro ss 0-60 times" href="http://autotk.com/0-60-times/chevrolet/camaro/">Camaro ss</a> / 
<a title="Subaru Wrx 0-60 times" href="http://autotk.com/0-60-times/subaru/wrx/">Wrx</a> / 
<a title="Audi R8 0-60 times" href="http://autotk.com/0-60-times/audi/r8/">R8</a> / 
<a title="Subaru Brz 0-60 times" href="http://autotk.com/0-60-times/subaru/brz/">Brz</a> / 
<a title="Nissan 350z 0-60 times" href="http://autotk.com/0-60-times/nissan/350z/">350z</a> / 
<a title="Bmw M3 0-60 times" href="http://autotk.com/0-60-times/bmw/m3/">M3</a> / 
<a title="Audi S5 0-60 times" href="http://autotk.com/0-60-times/audi/s5/">S5</a> / 
<a title="Audi S3 0-60 times" href="http://autotk.com/0-60-times/audi/s3/">S3</a> / 
<a title="Bmw M5 0-60 times" href="http://autotk.com/0-60-times/bmw/m5/">M5</a> / 
<a title="Audi A4 0-60 times" href="http://autotk.com/0-60-times/audi/a4/">A4</a> / 
<a title="Bmw 328i 0-60 times" href="http://autotk.com/0-60-times/bmw/328-gran-turismo/">328i</a> / 
<a title="Chevy Corvette z06 0-60 times" href="http://autotk.com/0-60-times/chevrolet/corvette/">Corvette z06</a> / 
<a title="Hyundai Genesis coupe 0-60 times" href="http://autotk.com/0-60-times/hyundai/genesis-coupe/">Genesis coupe</a> / 
<a title="Honda Civic si 0-60 times" href="http://autotk.com/0-60-times/honda/civic/">Civic si</a> / 
<a title="Dodge Charger 0-60 times" href="http://autotk.com/0-60-times/dodge/charger/">Charger</a> / 
<a title="Scion Tc 0-60 times" href="http://autotk.com/0-60-times/scion/tc/">Tc</a> / 
<a title="Ferrari 458 0-60 times" href="http://autotk.com/0-60-times/ferrari/458-italia/">458</a> / 
<a title="Dodge Viper 0-60 times" href="http://autotk.com/0-60-times/dodge/srt-viper/">Viper</a> / 
<a title="Cadillac Cts-v 0-60 times" href="http://autotk.com/0-60-times/cadillac/cts-v/">Cts-v</a> / 
<a title="Mazda Mazda6 0-60 times" href="http://autotk.com/0-60-times/mazda/mazda6/">Mazda6</a> / 
<a title="Audi S6 0-60 times" href="http://autotk.com/0-60-times/audi/s6/">S6</a> / 
<a title="Infiniti G37 0-60 times" href="http://autotk.com/0-60-times/infiniti/m37/">G37</a> / 
<a title="Hyundai Genesis 0-60 times" href="http://autotk.com/0-60-times/hyundai/genesis-coupe/">Genesis</a> / 
<a title="Dodge Challenger rt 0-60 times" href="http://autotk.com/0-60-times/dodge/challenger/">Challenger rt</a> / 
<a title="Lotus Elise 0-60 times" href="http://autotk.com/0-60-times/lotus/elise/">Elise</a> / 
<a title="Fiat 500 abarth 0-60 times" href="http://autotk.com/0-60-times/fiat/500/">500 abarth</a> / 
<a Bmw M6 0-60 times" href="http://autotk.com/0-60-times/bmw/m6-gran-coupe/">M6</a> / 
<a Bmw 550i 0-60 times" href="http://autotk.com/0-60-times/bmw/550/">550i</a> / 
<a Infiniti G35 0-60 times" href="http://autotk.com/0-60-times/infiniti/g35x/">G35</a> / 
<a Honda Accord 0-60 times" href="http://autotk.com/0-60-times/honda/accord/">Accord</a> / 
<a Ford Fiesta st 0-60 times" href="http://autotk.com/0-60-times/ford/fiesta/">Fiesta st</a> / 
<a Acura Tl 0-60 times" href="http://autotk.com/0-60-times/acura/tl/">Tl</a> / 
<a Jaguar F type 0-60 times" href="http://autotk.com/0-60-times/jaguar/f-type/">F type</a> / 
<a Audi A5 0-60 times" href="http://autotk.com/0-60-times/audi/a5/">A5</a> / 
<a Ford Fusion 0-60 times" href="http://autotk.com/0-60-times/ford/fusion-energi/">Fusion</a> / 
<a Audi S7 0-60 times" href="http://autotk.com/0-60-times/audi/s7/">S7</a> / 
<a Nissan Maxima 0-60 times" href="http://autotk.com/0-60-times/nissan/maxima/">Maxima</a> / 
</p>

</div>
		</section>
	<script src="http://autotk.com/js/lib/jquery.js"></script>		
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

		<?php $this->widget('application.widgets.CatalogWidget', array('action' => 'MostVisitedModelYear')); ?>
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
		
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<section class="right-block">
					
			<?php $this->renderPartial('application.views.specs._right_index')?>		

			
		</section>
		
	</div>
</main>



<script src="http://autotk.com/js/owl.carousel.js"></script>
<script>
 $(document).ready(function() {
 
   var owl = $("#owl_carusel");
 
  owl.owlCarousel({
     
      itemsCustom : [
        [0, 2],
        [450, 2],
        [600, 3],
        [700, 3],
        [1000, 4],
        [1200, 4],
        [1400, 4],
        [1600, 4]
      ],
      navigation : true
 
  });
  $('.reviews__tabs li').click(function(event) {
  $('.reviews__tabs li').removeClass('is-active');
  $(this).addClass('is-active');
  $('.reviews__container').removeClass('active');
  blocktoshow = $(this).data('block');
  $(blocktoshow).addClass('active');
  return false;
 })
 
});
</script>