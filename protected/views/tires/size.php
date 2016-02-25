<main>
	<div class="l-col1">
   			
        
		<section class="make">
<h2 class="section-name_2"><?=Tire::format($tire)?> tires</h2>
			<?php $this->renderPartial('_specs', array('tire'=>$tire))?>
<br>
			<h2 class="section-name_2">List of cars with <?=Tire::format($tire)?> tire size</h2>
			<p><br>Explore the collection of vehicles riding on <?=Tire::format($tire)?> tire size which turns them into competitors to some extent. The list of cars below is compiled assuming <?=Tire::format($tire)?> is their factory tire size.</p>
                        <ul class="make__vehicle">
			<?php foreach ($makeModels as $makeModel):?>
				<li>
					<div class="make__vehicle-image">
						<a title="All <?=$makeModel['title']?> tire sizes" href="/tires/<?=$makeModel['alias']?>/">
							<img src="<?=$makeModel['image']?>">
						</a>
					</div>
					<h3>
						<a href="/tires/<?=$makeModel['alias']?>/<?=Tire::url($tire, true)?>" title="<?=$makeModel['title']?> <?=Tire::format($tire)?> tires"><?=$makeModel['title']?> tire size</a>
					</h3>
					<ul class="make__vehicle-years">
					<?php foreach ($makeModel['models'] as $item):?>
						<li>
							<?php $yearRange = Tire::getYearRangeModel($item['id'], $tire['id'])?>
							<a title="<?=$makeModel['title']?> <?=$item['title']?> tire size" href="/tires/<?=$makeModel['alias']?>/<?=$item['alias']?>/"><?=$item['title']?> <?php if (is_array($yearRange) && !empty($yearRange['mmin'])):?>(<?=$yearRange['mmin']?><?php if ($yearRange['mmin']!=$yearRange['mmax']):?>-<?=$yearRange['mmax']?><?php endif;?>)<?php endif;?></a>
						</li>
					<?php endforeach;?>
					</ul>
				</li>
			<?php endforeach;?>
			</ul>
                        <br>
		
<h2 class="section-name_2">Similar tire sizes (might fit)</h2>
<p><br>We also suggest going over the similar tire sizes that have slightly different parameters but still might be even a better fit for your vehicle with many of the combinations already applied by car enthusiasts. 
</p><p><br>
Below is the list of all possible alternatives to <?=Tire::format($tire)?> within delta of no more than three percent which means you can shift to wider wheels with smaller aspect ratio and vice versa. Wheel experts do not recommend to decrease the diameter of the wheel. So if you are not sure what other tire sizes would match your ride simply stick to the factory wheels. </p>
			<table class="right-block__specs-list">
				<tbody>
				<?php foreach ($similarSizes as $similarSize):?>
					<tr>
						<td>
							<a class="link1" href="<?=Tire::url($similarSize)?>" title="<?=Tire::format($similarSize)?> tires"><?=Tire::format($similarSize)?></a>
						</td>
						<td class="spec-value">
							<?=($similarSize['percent']>0)?'+':''?><?=$similarSize['percent']?>%
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
</section>

				
				
				
            
			
			<?php if (!empty($projects)):?>
			<section class="make">
				<h2 class="section-name_2">Modified cars that use <?=Tire::format($tire)?> tire size</h2>
<p><br>We keep an updated collection of cars that gave up factory wheels and installed <?=Tire::format($tire)?> instead as their aftermarket tire size. Each project is a unique experience with details on P 235/55 R18 installation issues or subsequent changes while driving.
</p>
				<ul class="make__vehicle" id="list_update">	
						<?php $this->renderPartial('application.views.tires._projects', array(
							'projects'=>$projects,				
						))?>
				</ul>
				
				<br>

				<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
			</section>		
			<?php endif;?>
	</div>
	
	<div class="l-col2">
		<section class="">
			
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
			
			  
		
			
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
		$.post('<?=Yii::app()->request->requestUri?>', $('#form-filter').serialize()+'&offset='+offset, function(response){
			html = $.trim(response);
			if (html != '') {
				$('#list_update').append(response);
				sendScrolingRequest=false;
			} 
		}, 'text');			
    };
});
</script>