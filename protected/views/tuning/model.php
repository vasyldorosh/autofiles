<main>
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?> <?=$model['title']?> tuning</h2>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
	</div>
	<div class="text_size">
		<?=$description?>	
	</div>
</section>


<section class="section_tabs">
				<section class="reviews">
					<h4 class="title_tire pt20">Modified <?=$make['title']?> <?=$model['title']?> models</h4>
						<p><?=$countProjects?> projects</p>
						<div class="options">
						<form id="form-filter" onsubmit="submitFilterForm();return false;">
							<div class="options__block">
								<div class="options__item">
									<strong>Diameter</strong>
									<select name="filter[rim_diameter_id]">
										<option value="">-no select-</option>
										<?php foreach(TireRimDiameter::getListByModelProject($model['id']) as $k=>$v):?>
										<option <?=(isset($filter['rim_diameter_id']) && $filter['rim_diameter_id']==$k)?'selected="selected"':''?> value="<?=$k?>"><?=$v?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="options__item">
									<strong>Width</strong>
									<select name="filter[rim_width_id]">
										<option value="">-no select-</option>
										<?php foreach(RimWidth::getListByModelProject($model['id']) as $k=>$v):?>
										<option <?=(isset($filter['rim_width_id']) && $filter['rim_width_id']==$k)?'selected="selected"':''?> value="<?=$k?>"><?=$v?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="options__item">
									<strong>Tire</strong>
									<select name="filter[tire_section_width_id]">
										<option value="">-no select-</option>
										<?php foreach(TireSectionWidth::getListByModelProject($model['id']) as $k=>$v):?>
										<option value="<?=$k?>"><?=$v?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="options__item">
									<strong>Offset</strong>
									<select name="filter[rim_offset_range_id]">
										<option value="">-no select-</option>
										<?php foreach(RimOffsetRange::getListByModelProject($model['id']) as $k=>$v):?>
										<option value="<?=$k?>"><?=$v?></option>
										<?php endforeach;?>
									</select>
								</div>
								
								<button type="submit" class="btn btn_options" id="btn_submit_filter">GO</button>
							</div>
						</form>	
						</div>
					
				</section>
			</section>

<section class="make">
	<ul class="make__vehicle" id="list_update">	
			<?php $this->renderPartial('application.views.tuning._projects', array(
				'projects'=>$projects,
				'make' => $make,
				'model' => $model,				
			))?>
	</ul>
	
	<br>

	<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
</section>

</div>

	<div class="l-col2">

			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
			
			<?php $this->renderPartial('application.views.specs._right_model', array(
				'lastModelYear'=>$lastModelYear,
				'make'=>$make,
				'model'=>$model,
			))?>

			<section class="right-block w78">
			
			<?php $popularRimSizes = Project::getMostPopularRimSizesModel($model['id']);?>
			
			<h4 class="title_tire">The Most Popular Rim Sizes in <?=$make['title']?> <?=$model['title']?> Tuning</h4>
			<table class="right-block__specs-list">
				<tbody>
					<?php foreach ($popularRimSizes as $size):?>
					<tr>
						<td width="180">
							<?=$size['rim_diameter']?> <?php if(!empty($size['rim_width'])):?>x <?=$size['rim_width']?><?php else:?> - inch<?php endif;?> <?php if ($size['is_staggered_wheels']):?>&ndash; <?=$size['rear_rim_diameter']?> x <?=$size['rear_rim_width']?><?php endif;?>
						</td>
						<td class="spec-value">
							<?=(int)($size['c']/$countProjects*100)?>%
						</td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</section>
		<section class="right-block w78">
		
			<?php $popularTireSizes = Project::getMostPopularTireSizesModel($model['id']);?>
			<h4 class="title_tire">The Most Popular Tire Sizes in <?=$make['title']?> <?=$model['title']?> Tuning</h4>
			<table class="right-block__specs-list">
				<tbody>
				<?php foreach ($popularTireSizes as $size):?>
					<tr>
						<td width="180">
							<?=Tire::format(array(
								'section_width' => $size['tire_section_width'],
								'aspect_ratio' 	=> $size['tire_aspect_ratio'],
								'rim_diameter' 	=> $size['rim_diameter'],
								'vehicle_class'	=> $size['tire_vehicle_class'],
							), true)?><?php if ($size['is_staggered_tires']):?> &ndash; 
							<?=Tire::format(array(
								'section_width' => $size['rear_tire_section_width'],
								'aspect_ratio' 	=> $size['rear_tire_aspect_ratio'],
								'rim_diameter' 	=> $size['rear_rim_diameter'],
								'vehicle_class'	=> $size['rear_tire_vehicle_class'],
							), true)?><?php endif;?>
						</td>
						<td class="spec-value">
							<?=(int)($size['c']/$countProjects*100)?>%
						</td>
					</tr>
				<?php endforeach;?>
			</tbody>
			</table>
			<br/>
		</section>
			
			

	</div>
</main>

<script src="/js/lib/jquery.js"></script>
<script>
function submitFilterForm() {
	$.post('<?=Yii::app()->request->requestUri?>', $('#form-filter').serialize(), function(html) {
		$('#list_update').html(html);
		sendScrolingRequest=false;
	}, 'html');
}

function element_in_scroll(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();



    if($(elem).length) {
        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    } else {
        return false
    }

}


var sendScrolingRequest = false
$(document).scroll(function(e){
	if (element_in_scroll(".js-scrolling-ajax-item:last") && !sendScrolingRequest) {
		sendScrolingRequest = true;
		offset = $('.js-scrolling-ajax-item').size();
		$.post('/tuning/<?=$make['alias']?>/<?=$model['alias']?>/', $('#form-filter').serialize()+'&offset='+offset, function(response){
			html = $.trim(response);
			if (html != '') {
				$('#list_update').append(response);
				sendScrolingRequest=false;
			} 
		}, 'text');			
    };
});
</script>