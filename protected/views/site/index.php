<main>
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
                <?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
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
	<script src="/js/lib/jquery.js"></script>		
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

			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- autof_250 -->
			<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-client="ca-pub-3243264408777652"
				 data-ad-slot="2242919653"
				 data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</section>
		
	</div>
</main>



<script src="/js/owl.carousel.js"></script>
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