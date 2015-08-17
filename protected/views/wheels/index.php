	<div>
		<div class="l-col1 brdtop_col">
			<!-- section 1 -->
			<section class="times clearfix">
				<h2 class="section-name pb18">Car wheels</h2>
				<div class="google_links f_left p_rel">
					<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
				</div>

				<div class="text_size">
					<?=SiteConfig::getInstance()->getValue('wheels_header_text_block')?>
				</div>
			</section>
			<script src="http://autofiles.com/js/lib/jquery.js"></script>	
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
								By rim size
								<br>
								<span class="text_tabs">what vehicles use this wheel size</span>
							</a>
						</li>
					</ul>
					
					<script src="/js/lib/jquery.js"></script>	
					<div id="b1" class="reviews__container active vehickle">
						<div class="vehicle_div_img p_rel">
							<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
						</div>
						<h4 class="title_tire pt20">Specify make and model to find matching wheels:</h4>
												<div class="options">
							<div class="options__block">
								<div class="options__item">
									<strong>Make</strong>
									<select id="Filter_make_id">
										<option value="">-no select-</option>
										<?php $key=1;foreach (AutoMake::getAllFrontFull() as $make_id=>$make):?>
											<option value="<?=$make['alias']?>"><?=$make['title']?></option>
										<?php $key++;endforeach;?>										
									</select>
								</div>
								<div class="options__item">
									<strong>Model</strong>
									<select id="Filter_model_id">
										<option>-no select-</option>
									</select>
								</div>
								<button style="display: none;" type="submit" class="btn btn_options" data-url="" id="btn_submit_filter_make">GO</button>
							</div>
						</div>
					</div>
					<div id="b2" class="reviews__container">
						
						<div class="reviews_container_col_right select_tire options">
							<h4 class="title_tire">Find your wheels, select any filter</h4>
							<div class="options__block wrapper">
								<div class="select_box wrapper">
									<div class="options__item clearfix">
										<strong>Rim Diameter</strong>
										<select id="Filter_rim_diameter" class="js-filter-tire-size">
											<option value="">-no select-</option>
											<?php foreach (TireRimDiameter::getListFront() as $r):?>	
												<option value="<?=$r?>"><?=$r?></option>
											<?php endforeach?>
										</select>										
									</div>
									<div class="options__item clearfix">
										<strong>Rim Width</strong>
										<select id="Filter_section_width" class="js-filter-tire-size">
											<option value="">-no select-</option>
											<?php foreach (RimWidth::getAll() as $v):?>	
												<option value="<?=$v?>"><?=$v?></option>
											<?php endforeach?>
																						
										</select>										
									</div>
									<div class="options__item clearfix">
										<strong>Bolt Pattern</strong>
										<select id="Filter_bolt_pattern" class="js-filter-tire-size">
											<option value="">-no select-</option>
											<?php foreach (RimBoltPattern::getAll() as $v):?>	
												<option value="<?=$v?>"><?=$v?></option>
											<?php endforeach?>											
										</select>
									</div>
									
								</div>
								<div class="btn_box f_right" id="search_tire_size_results" style="display: none;">
									<button type="submit" class="btn btn_options" id="btn_submit_filter_tire_size" data-url="">Find now</button>
								</div>
							</div>
						</div>
					</div>
				</section>
			</section>

		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Search rim size by vehicle</h2>
				<ul>
				<?php $key=1;foreach (AutoMake::getAllFront() as $makeUrl=>$makeTitle):?>
					<li><a title="<?=$makeTitle?> wheels" href="/wheels<?=$makeUrl?>"><?=$makeTitle?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
				</ul>			
		</section>
		
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('wheels_footer_text_block')?>
		</section>
	</div>
	
	<div class="l-col2">
		<section class="">
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		</section>
		
		<section class="right-block">				
			<?php $this->renderPartial('application.views.specs._right_index')?>				
		</section>		
		
	</div>
	
</div>

<script src="http://autofiles.com/js/owl.carousel.js"></script>
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
$('#Filter_make_id').change(function(e) {
	$('#Filter_model_id').empty();
	$('#Filter_model_id').append('<option value="">-no select-</option>');
	$.post('/ajax/getModelsMake', {'alias': $(this).val()} , function(response) {
		$.each(response.items, function(value, label){
			$('#Filter_model_id').append('<option value="'+value+'">'+label+'</option>');
		});
	}, 'json');
	
	$('#btn_submit_filter_make').css('display', $(this).val()==''?'none':'block');
	setSubmitUrlMake();
});

$('#Filter_model_id').change(function(e) {
	setSubmitUrlMake();
});

function setSubmitUrlMake() {
	url = '/wheels/' + $('#Filter_make_id').val() + '/';
	if ($('#Filter_model_id').val() != '') {
		url += $('#Filter_model_id').val() + '/';
	}
	$('#btn_submit_filter_make').attr('data-url', url);url
}

$('#btn_submit_filter_make').click(function(e) {
	e.preventDefault();
	window.location = $(this).data('url');
})

$('.js-filter-tire-size').change(function(e) {
	rd = $('#Filter_rim_diameter').val();
	sw = $('#Filter_section_width').val();
	bp = $('#Filter_bolt_pattern').val();	
	
	url = '/wheels';
	if (rd!='' || sw!='' || bp!='') {
		if (rd!='') {
			url = url +'/'+rd;
		}
		if (sw!='') {
			url = url + '/'+sw;
		}
		if (bp!='') {
			url = url +'/'+bp;
		}
		
		$('#search_tire_size_results').show();
	} else {
		$('#search_tire_size_results').hide();
	}
	url+= '.html';
	
	$('#btn_submit_filter_tire_size').attr('data-url', url);
});


$('#btn_submit_filter_tire_size').click(function(e) {
	window.location = $(this).data('url');
});


</script>	
