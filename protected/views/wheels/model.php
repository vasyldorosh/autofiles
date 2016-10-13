<main>
	<div class="l-col1">
		<section class="years_box make">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> wheel bolt pattern. Select the year</h2>
			<ul class="years_list">
			<?php foreach ($wheelsDataItems as $wheelsDataItem):?>
				<?php foreach ($wheelsDataItem['years'] as $y):?>
					<li class="years_list_item"><a href="#<?=$y?>" class="btn years_list_link"><?=$y?></a></li>
				<?php endforeach;?>
			<?php endforeach;?>
			</ul>
		</section>
			
		<section class="times clearfix">

			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>
		
		<?php foreach ($wheelsDataItems as $wheelsDataItem):?>
		<section class="table-container">
			<a name="2015"></a><img alt="<?=$make['title']?> <?=$model['title']?> wheels bolt pattern" src="<?=AutoModelYear::thumb($wheelsDataItem['ids'][0], 150, null, 'resize')?>"><h4 class="title_tire"><?=$make['title']?> <?=$model['title']?> wheels info</h4>
			<?php foreach ($wheelsDataItem['years'] as $y):?>
			<a name="<?=$y?>" style="color:#000;"><small><?=$y?></small></a>
			<?php endforeach;?>
			
			<table>
			<tbody>
				<?php if (!empty($wheelsDataItem['bolt_pattern'])):?>
				<tr>
					<td><h3><?=$model['title']?> Bolt Pattern</h3>Pitch Circle Diameter (PCD) defines the diameter of the imaginary circle drawn by the centers of the wheel lugs and describes the number of the lug holes incorporated by the rim. How to change bolt pattern? <a target="_blank" rel="nofollow" href="http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=automotive&keywords=wheel%20adapters&linkCode=ur2&tag=auto036-20&linkId=SAMMREJTPRAVTXQ4"><b>Use Adapters</b></a><img src="http://ir-na.amazon-adsystem.com/e/ir?t=auto036-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
</td>
					<td><h3>PCD <?=$wheelsDataItem['bolt_pattern']?></h3></td>
					
				</tr>
				<?php endif;?>
				
				<?php 
					$stockWheelOffset = array();
					if (!empty($wheelsDataItem['y_ror_min'])) $stockWheelOffset[] = $wheelsDataItem['y_ror_min'];
					if (!empty($wheelsDataItem['y_ror_max']) && $wheelsDataItem['y_ror_min'] != $wheelsDataItem['y_ror_max']) $stockWheelOffset[] = $wheelsDataItem['y_ror_max'];
				
				?>
				
				<?php if (!empty($stockWheelOffset)):?>
				<tr>
					<td><h3>Stock wheel offset</h3>The space between the hub mounting surface and the wheel center of <?=$model['title']?> wheels. If you need a different offset use <a target="_blank" rel="nofollow" href="http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=automotive&keywords=wheel%20spacers&linkCode=ur2&tag=auto036-20&linkId=SAMMREJTPRAVTXQ4"><b>Wheel Spacers</b></a><img src="http://ir-na.amazon-adsystem.com/e/ir?t=auto036-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></td>
					<td><h3><?=implode(' to ', $stockWheelOffset)?> mm</h3></td>
				</tr>
				<?php endif;?>
				
				<?php 
					$customOffsetRange = array();
					
					if (is_numeric($wheelsDataItem['p_ror_min']) || is_numeric($wheelsDataItem['p_rear_ror_min'])) {
						if (is_numeric($wheelsDataItem['p_ror_min']) && is_numeric($wheelsDataItem['p_rear_ror_min'])) {
						 $customOffsetRange[] = min($wheelsDataItem['p_ror_min'], $wheelsDataItem['p_rear_ror_min']);
						} else if (is_numeric($wheelsDataItem['p_ror_min'])) {
							$customOffsetRange[] = $wheelsDataItem['p_ror_min'];
						} else if (is_numeric($wheelsDataItem['p_rear_ror_min'])) {
							$customOffsetRange[] = $wheelsDataItem['p_rear_ror_min'];
						}
					}
					if (is_numeric($wheelsDataItem['p_ror_max']) || is_numeric($wheelsDataItem['p_rear_ror_max'])) {
						if (is_numeric($wheelsDataItem['p_ror_max']) && is_numeric($wheelsDataItem['p_rear_ror_max'])) {
							$customOffsetRange[] = max($wheelsDataItem['p_ror_max'], $wheelsDataItem['p_rear_ror_max']);
						} else if (is_numeric($wheelsDataItem['p_ror_max'])) {
							$customOffsetRange[] = $wheelsDataItem['p_ror_max'];
						} else if (is_numeric($wheelsDataItem['p_rear_ror_max'])) {
							$customOffsetRange[] = $wheelsDataItem['p_rear_ror_max'];
						}
					}
				?>
				
				<?php if (!empty($customOffsetRange)):?>
				<tr>
					<td><h3>Custom Offset Range</h3>Is calculated from the data of modified <?=$make['title']?> <?=$model['title']?> that switched to custom wheel size preserving the proper driving capabilities of the vehicle</td>
					<td><h3><a title="Custom, modified <?=$make['title']?> <?=$model['title']?>" href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/"><?=implode(' to ', $customOffsetRange)?> mm</a></h3></td>
					
				</tr>
				<?php endif;?>

				<?php if (!empty($wheelsDataItem['center_bore'])):?>
				<tr>
					<td><h3>Center bore (hub bore)</h3>The hole in the middle of a rim that exactly matches the hub diameter. It is located at the back of the wheel and as the car's hub goes into this hole it ensures the wheel gets centered correctly. Stock <?=$model['title']?> wheels have a perfect centerbore fit with the hub. How to fit rims with larger centre bore? <a target="_blank" rel="nofollow" href="http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=automotive&keywords=Hub%20Centric%20Rings&linkCode=ur2&tag=auto036-20&linkId=SAMMREJTPRAVTXQ4"><b>Use Hub Centric Rings</b></a><img src="http://ir-na.amazon-adsystem.com/e/ir?t=auto036-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
</td>
					<td><h3><?=$wheelsDataItem['center_bore']?></h3></td>
				</tr>
				<?php endif;?>	
				
				<?php if (!empty($wheelsDataItem['thread_size'])):?>
				<tr>
					<td><h3>Thread size</h3><a target="_blank" rel="nofollow" href="http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=automotive&keywords=Lug%20Nuts&linkCode=ur2&tag=auto036-20&linkId=SAMMREJTPRAVTXQ4"><b>Lug Nuts</b></a><img src="http://ir-na.amazon-adsystem.com/e/ir?t=auto036-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
 size. Measures the thread diameter, the thread pitch, and the thread length. In the metric system, the diameter of the thread, the first digit, is described in millimeters. </td>
					<td><h3><?=$wheelsDataItem['thread_size']?></h3></td>					
				</tr>
				<?php endif;?>				
				
				<tr>
					<td><h3>Stock Rim Sizes Range</h3>Gives an idea about the maximum and minimum allowable limits of the wheels diameter and width matching the specific vehicle. <a target="_blank" rel="nofollow" href="http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=automotive&keywords=hubcaps&linkCode=ur2&tag=auto036-20&linkId=SAMMREJTPRAVTXQ4"><b>Try Hubcaps</b></a><img src="http://ir-na.amazon-adsystem.com/e/ir?t=auto036-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />  to change the look of your wheels</td>
					<td><h3><?=$wheelsDataItem['tire_rim_diameter_from']?>x<?=$wheelsDataItem['rim_width_from']?> &ndash; <?=$wheelsDataItem['tire_rim_diameter_to']?>x<?=$wheelsDataItem['rim_width_to']?></h3></td>					
				</tr>
				
				<?php if (!empty($wheelsDataItem['custom_rim_sizes_range'])):?>
				<tr>
					<td><h3>Custom rim sizes range</h3> Shows the lower and upper limits of the rims the vehicle can incorporate in contrast to the manufacturer's specs</td>
					<td><h3><a title="Custom <?=$make['title']?> <?=$model['title']?>" href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$wheelsDataItem['custom_rim_sizes_range']?></a></h3></td>
				</tr>
				<?php endif;?>	
					
				<?php $rangeTire = array();
				if (!empty($wheelsDataItem['tires_range_from'])) $rangeTire[] = $wheelsDataItem['tires_range_from'];
				if (!empty($wheelsDataItem['tires_range_to'])) $rangeTire[] = $wheelsDataItem['tires_range_to'];
				?>	
					
				<?php if (!empty($rangeTire)):?>	
				<tr>
					<td><h3>Tire sizes</h3>Scale from the minimum to the maximum available options of the wheel dimensions that may fit <?=$make['title']?> <?=$model['title']?></td>
					<td><h3><a title="<?=$make['title']?> <?=$model['title']?> tire size" href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/<?=$wheelsDataItem['years'][0]?>/"><?=implode(' &ndash; ', $rangeTire)?></a></h3></td>
				</tr>
				<?php endif;?>
				
			</tbody>
			</table>

<br>
<h2 class="section-name_2">Tire Pressure importance</h2><br>

<p>
A digital <a href="http://amzn.to/2cKo1bP"><b>tire pressure gauge</b></a> is a must-have tool for checking the tire pressure and keeping it within a permissible range. You can quickly measure the pressure once the visual examination of the wheel evoked a shade of doubt. Still don't have one? Review the best digital tire pressure gauges forming a perfect seal with the valve stem without leaking air, even at night times. Find a perfect combination by choosing the right car air compressor to regulate the pressure in deflated or over-inflated tires. 
</p>

		</section>
		
		<?php if (!empty($wheelsDataItem['custom_rim_sizes'])):?>
		<section class="table-container">
			<h2 class="section-name_2"><a name="r17"></a>Custom wheels for a <?=$make['title']?> <?=$model['title']?> <?=$wheelsDataItem['years'][0]?><?php if (end($wheelsDataItem['years'])!=$wheelsDataItem['years'][0]):?>-<?=end($wheelsDataItem['years'])?><?php endif;?></h2>
			     <table>
				<tbody>
					<tr>
						<td><b>Rim size</b></td>
						<td><b>Offset</b></td>
						<td><b>Projects</b></td>
						
					</tr>
					<?php foreach ($wheelsDataItem['custom_rim_sizes'] as $item):?>
					<tr>
						<td><a href="/wheels/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['rim_diameter']?>x<?=TextHelper::f($item['rim_width'])?>/<?php if ($item['is_staggered'] && ($item['rear_rim_diameter']!=$item['rim_diameter'] || $item['rear_rim_width']!=$item['rim_width'])):?><?=(!empty($item['rear_rim_diameter']))?$item['rear_rim_diameter']:$item['rim_diameter']?>x<?=(!empty($item['rear_rim_width']))?TextHelper::f($item['rear_rim_width']):TextHelper::f($item['rim_width'])?>/<?php endif;?>"><?=$item['rim_diameter']?>x<?=TextHelper::f($item['rim_width'])?><?php if ($item['is_staggered'] && ($item['rear_rim_diameter']!=$item['rim_diameter'] || $item['rear_rim_width']!=$item['rim_width'])):?> / <?=(!empty($item['rear_rim_diameter']))?$item['rear_rim_diameter']:$item['rim_diameter']?>x<?=(!empty($item['rear_rim_width']))?TextHelper::f($item['rear_rim_width']):TextHelper::f($item['rim_width'])?><?php endif;?></a></td>
						<td><?=$item['ror_min']?>-<?=$item['ror_max']?></td>
						<td><h3><a href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/wheels-<?=$item['rim_diameter']?>x<?=TextHelper::f($item['rim_width'])?>/"><?=$item['c']?></a></h3></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table><br>
<p>Sometimes it happens that you are not happy with your stock wheels and would like to have something else. Choosing the right <a target="_blank" rel="nofollow" href="http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=automotive&keywords=aftermarket%20wheels&linkCode=ur2&tag=auto036-20&linkId=SAMMREJTPRAVTXQ4"><b>aftermarket wheels</b></a><img src="http://ir-na.amazon-adsystem.com/e/ir?t=auto036-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /> is not an easy thing to do, but we will try to help you get things straight. We have gathered the modified <?=$make['title']?> <?=$model['title']?> cars, in which the owners tried to find the balance between wheel size, rims width, backspacing, wheels offset and suspension height. It has to appeal to the car owner too. Have a look around and pick your option out of projects with custom wheels.</p>
                        
		</section>
		<?php endif;?>
		
		<?php endforeach;?>
		
<br><br>		
 <?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>

	</div>
	<div class="l-col2">
		<br>		
		<?php $this->renderPartial('application.views.specs._right_model', array(
			'make'=>$make,
			'model'=>$model,
			'lastModelYear'=>$lastModelYear,
		))?>
<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

	</div>
</main>