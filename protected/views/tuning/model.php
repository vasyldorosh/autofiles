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
									<select id="filter_diameter">
										<option value="">-no select-</option>
										<?php foreach(TireRimDiameter::getListByModelProject($model['id']) as $k=>$v): $val=FilterHelper::getFirstExpl('(', $v); ?>
										<?php //foreach(TireRimDiameter::getList() as $k=>$v):?>
										<option <?=(isset($filter['diameter']) && $filter['diameter']==$val)?'selected="selected"':''?> value="<?=$val?>"><?=$v?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="options__item">
									<strong>Width</strong>
									<select id="filter_width">
										<option value="">-no select-</option>
										<?php foreach(RimWidth::getListByModelProject($model['id']) as $k=>$v): $val=FilterHelper::getFirstExpl('(', $v); ?>
										<?php //foreach(RimWidth::getAll() as $k=>$v):?>
										<option <?=(isset($filter['width']) && $filter['width']==$val)?'selected="selected"':''?> value="<?=$val?>"><?=$v?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="options__item">
									<strong>Tire</strong>
									<select id="filter_tire">
										<option value="">-no select-</option>
										<?php foreach(TireSectionWidth::getListByModelProject($model['id']) as $k=>$v): $val=FilterHelper::getFirstExpl('(', $v); ?>
										<?php //foreach(TireSectionWidth::getList() as $k=>$v):?>
										<option <?=(isset($filter['tire']) && $filter['tire']==$val)?'selected="selected"':''?> value="<?=$val?>"><?=$v?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="options__item">
									<strong>Offset</strong>
									<select id="filter_offset">
										<option value="">-no select-</option>
										<?php foreach(RimOffsetRange::getListByModelProject($model['id']) as $k=>$v): $val=FilterHelper::getFirstExpl('(', $v); ?>
										<?php //foreach(RimOffsetRange::getAll() as $k=>$v):?>
										<option <?=(isset($filter['offset']) && $filter['offset']==$val)?'selected="selected"':''?> value="<?=$val?>"><?=$v?></option>
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

				<br>		
			<?php $this->renderPartial('application.views.specs._right_model', array(
				'lastModelYear'=>$lastModelYear,
				'make'=>$make,
				'model'=>$model,
			))?>

			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

			<?php if ($countProjects > 0):?>
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
			<?php endif;?>
			
		<?php if ($countProjects < 0):?>
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
								'vehicle_class'	=> $size['tire_vehicle_class'],
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
		<?php endif;?>
			
			

	</div>
</main>

<script src="/js/lib/jquery.js"></script>
<script>

var sendScrolingRequest = false;

function submitFilterForm() {
	getProjects(0, false);
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

$(document).scroll(function(e){
	if (element_in_scroll(".js-scrolling-ajax-item:last") && !sendScrolingRequest) {
		sendScrolingRequest = true;
		getProjects($('.js-scrolling-ajax-item').size(), true);		
    };
});

function getProjects(offset, append) {
		var url = '/tuning/<?=$make['alias']?>/<?=$model['alias']?>/';
		var f_diameter = $('#filter_diameter').val();
		var f_width = $('#filter_width').val();
		var f_tire = $('#filter_tire').val();
		var f_offset = $('#filter_offset').val();
		
		if (f_diameter != '' && f_width != '') {
			url += 'wheels-'+f_diameter + 'x' + f_width + '/';
		} else {
			if (f_diameter != '' && f_width == '') {
				url += 'wheels-'+f_diameter + '/';
			}
			if (f_diameter == '' && f_width != '') {
				url += 'wheels-'+f_width + '-width/';
			}
		}
		
		if (f_tire != '') {
			url += 'tire-' + f_tire + '/';
		}
		
		if (f_offset != '') {
			url += 'offset' + f_offset + '/';
		}
		
		$.post(url, 'offset='+offset, function(response){
			html = $.trim(response);
			if (append)
				$('#list_update').append(response);
				else 
			$('#list_update').html(response);
				
			if (html != '') {	
				sendScrolingRequest=false;
			} 
			history.pushState(null, '', url);
		}, 'text');		
}
</script>