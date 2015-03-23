	<div>
		<div class="l-col1 brdtop_col">
			<!-- section 1 -->
			<section class="times clearfix">
				<h2 class="section-name pb18">Car tires</h2>
				<div class="google_links f_left p_rel">
					<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
				</div>

				<div class="text_size">
					<?=SiteConfig::getInstance()->getValue('tires_header_text_block')?>
				</div>
			</section>
			<section class="section_tabs">
				<section class="reviews">
					<ul class="reviews__tabs">
						<li data-block="#b1" class="is-active">
							<a href="javascript:;">
								By vehicle
								<br>
								<span class="text_tabs">what wheels will fit your car</span>
							</a>
						</li>
						<li data-block="#b2">
							<a href="javascript:;">
								By tire size
								<br>
								<span class="text_tabs">what vehicles use this tire size</span>
							</a>
						</li>
					</ul>
					<div id="b1" class="reviews__container active vehickle">
						<div class="vehicle_div_img p_rel">
							<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
						</div>
						<h4 class="title_tire pt20">Specify make, year and model to find matching wheels:</h4>
						<?php $years = AutoModelYear::getYears();?>
						<div class="options">
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
						</div>
					</div>
					<div id="b2" class="reviews__container">
						<div class="f_left reviews_container_col_left">
							<img class="tire_tabs_img" src="/img/tire_tabs.jpg"alt=""></div>
						<div class="reviews_container_col_right select_tire options">
							<h4 class="title_tire">Get the right tires for your ride</h4>
							<div class="options__block wrapper">
								<div class="select_box wrapper">
									<div class="options__item clearfix">
										<?php $activeVehicleClassId = 1;?>
										<strong>Vehicle Class</strong>
										<select id="Filter_vehicle_class" class="js-filter-tire-size">
											<option value="">-no select-</option>
											<?php foreach (TireVehicleClass::getListFront() as $k=>$v):?>
											<option value="<?=$k?>" <?=($activeVehicleClassId==$k)?'selected="selected"':''?>><?=$v?></option>
											<?php endforeach;?>
										</select>										
									</div>
									<div class="options__item clearfix">
										<strong>Section Width</strong>
										<select id="Filter_section_width" class="js-filter-tire-size">
											<option value="">-no select-</option>
											<?php foreach (TireSectionWidth::getListFront(array('vehicle_class_id'=>$activeVehicleClassId)) as $k=>$v):?>
											<option value="<?=$k?>"><?=$v?></option>
											<?php endforeach;?>											
										</select>										
									</div>
									<div class="options__item clearfix">
										<strong>Tire Aspect Ratio</strong>
										<select id="Filter_aspect_ratio" class="js-filter-tire-size">
											<option value="">-no select-</option>
										</select>
									</div>
									<div class="options__item clearfix">
										<strong>Rim Size</strong>
										<select id="Filter_rim_diameter" class="js-filter-tire-size">
											<option value="">-no select-</option>
										</select>
									</div>
								</div>
								<div class="btn_box f_right" id="search_tire_size_results" style="display: none;">
									<span class="result_select">
										<strong>22.485 results</strong>
									</span>
									<button type="submit" class="btn btn_options" id="btn_submit_filter_tire_size" data-url="">Find now</button>
								</div>
							</div>
						</div>
					</div>
				</section>
			</section>

		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Search tire size by vehicle</h2>
				<ul>
				<?php $key=1;foreach (AutoMake::getAllFront() as $makeUrl=>$makeTitle):?>
					<li><a title="<?=$makeTitle?> tires" href="/tires<?=$makeUrl?>"><?=$makeTitle?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
				</ul>			
		</section>			
	
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('tires_footer_text_block')?>			
		</section>
		
		<section class="product_photo_box make">				
			<div class="product_photo_item">
				<div class="product_photo_item_top">
					<h3>All tire diameters</h3>
					<ul class="make__vehicle-specs">
					<?php foreach (TireRimDiameter::getListFront() as $r):?>	
						<li><a href="/tires/r<?=$r?>.html" title="<?=$r?> inch wheels">R<?=$r?></a></li>
					<?php endforeach?>
					</ul>
				</div>
			</div>
			<div class="product_photo_item">
				<div class="product_photo_item_top">
						<h3>Popular tire sizes</h3>
					<ul class="make__vehicle-specs">
					<?php foreach (Tire::getPopolar() as $tire):?>
						<?php $tireTitle = Tire::format($tire);?>
						<li><a href="<?=Tire::url($tire)?>" title="<?=$tireTitle?> tires"><?=$tireTitle?></a></li>
					<?php endforeach?>
					</ul>
				</div>
			</div>
		</section>
		

	</div>
	
	<div class="l-col2">
		<section class="">
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		</section>
	</div>
	
</div>

<script src="js/owl.carousel.js"></script>
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


<script>
$('#Filter_year').change(function(e) {
	$('#Filter_make_id').empty().append('<option value="">-no select-</option>');
	$('#Filter_model_id').empty().append('<option value="">-no select-</option>');
	$.post('/ajax/getMakesByYear', {'year': $(this).val()} , function(response) {
		$.each(response.items, function(value, label){
			$('#Filter_make_id').append('<option value="'+value+'">'+label+'</option>');
		});
	}, 'json');
});

$('#Filter_make_id').change(function(e) {
	$('#Filter_model_id').empty();
	$('#Filter_model_id').append('<option value="">-no select-</option>');
	$.post('/ajax/getModelsByMake', {'alias': $(this).val(), 'year': $('#Filter_year').val()} , function(response) {
		$.each(response.items, function(value, label){
			$('#Filter_model_id').append('<option value="'+value+'">'+label+'</option>');
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


$('#Filter_rim_diameter').change(function(e) {
	val_sw = $('#Filter_section_width').val();
	val_ar = $('#Filter_aspect_ratio').val();
	val_rm = $('#Filter_rim_diameter').val();
	
	_block = $('#search_tire_size_results');
	
	if (val_sw != '' && val_rm != '' && val_ar != '') {
		data = {
			'section_width_id': val_sw,
			'rim_diameter_id': val_rm,
			'aspect_ratio_id': val_ar
		};
	
		$.post('/ajax/getCountTireSize', data , function(response) {
			_block.show();
			_block.find('strong').text(response.text);
			url = '/tires/' + $('#Filter_vehicle_class option:selected').text() + '-' + $('#Filter_section_width option:selected').text() + '-' +  $('#Filter_aspect_ratio option:selected').text() + 'r' + $('#Filter_rim_diameter option:selected').text() + '.html';
			$('#btn_submit_filter_tire_size').attr('data-url', url);
			
		}, 'json');		
	} else {
		_block.hide();
	}
});

//$('#Filter_vehicle_class option[value=1]').attr('selected', 'selected');

$('#Filter_vehicle_class').change(function(e) {
	$('#Filter_section_width').empty().append('<option value="">-no select-</option>');
	$('#Filter_aspect_ratio').empty().append('<option value="">-no select-</option>');
	$('#Filter_rim_diameter').empty().append('<option value="">-no select-</option>');
	$.post('/ajax/getTireSectionWidthByAttributes', {'vehicle_class_id': $(this).val()} , function(response) {
		$.each(response.items, function(value, data){
			$('#Filter_section_width').append('<option value="'+data.value+'">'+data.label+'</option>');
		});
	}, 'json');
});

$('#Filter_section_width').change(function(e) {
	$('#Filter_aspect_ratio').empty().append('<option value="">-no select-</option>');
	$('#Filter_rim_diameter').empty().append('<option value="">-no select-</option>');
	
	var data = {};
		data['vehicle_class_id'] = $('#Filter_vehicle_class').val();
		data['section_width_id'] = $('#Filter_section_width').val();
	
	$.post('/ajax/getTireAspectRatioByAttributes', data , function(response) {
		$.each(response.items, function(value, data){
			$('#Filter_aspect_ratio').append('<option value="'+data.value+'">'+data.label+'</option>');
		});
	}, 'json');
});

$('#Filter_aspect_ratio').change(function(e) {
	$('#Filter_rim_diameter').empty().append('<option value="">-no select-</option>');
	var data = {};
		data['vehicle_class_id'] = $('#Filter_vehicle_class').val();
		data['section_width_id'] = $('#Filter_section_width').val();
		data['aspect_ratio_id'] = $('#Filter_aspect_ratio').val();
		
	$.post('/ajax/getTireRimDiameterByAttributes', data , function(response) {
		$.each(response.items, function(value, data){
			$('#Filter_rim_diameter').append('<option value="'+data.value+'">'+data.label+'</option>');
		});
	}, 'json');
});


$('#btn_submit_filter_tire_size').click(function(e) {
	window.location = $(this).data('url');
});

$('#btn_submit_filter').click(function(e) {
	url = '/tires/' + $('#Filter_make_id').val() + '/' + $('#Filter_model_id').val() + '/' + $('#Filter_year').val() + '/';
	window.location = url;
});


</script>	