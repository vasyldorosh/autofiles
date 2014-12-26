<main class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h2 class="section-name pb18"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> tires</h2>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '300x250')); ?>	
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>
		
		<?php if (!empty($tires)):?>
		<section class="product_photo_box make">
			<h2 class="section-name_2 mb30">All tire sizes for <?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?></h2>
			
			<?php foreach ($tires as $tire):?>
			<?php $tireText = Tire::format($tire);?>
			
			<div class="product_photo_item">
				<div class="product_photo_item_top">
					<a href="<?=Tire::url($tire)?>" class="product_photo_name"><?=$tire['is_rear']?'Front tires ':''?><?=$tireText?></a>
					<ul class="make__vehicle-specs">
						<li><a type="amzn" search="<?=$tireText?>" category="automotive">Buy on Amazon</a></li>
						<?php $rimWidth = TireRimWidth::getRangeWidth($tire['section_width']);?>
						<?php if (!empty($rimWidth)):?>
						<li>Rim width <?=$rimWidth['min']?><?php if($rimWidth['min']!=$rimWidth['max']):?> - <?=$rimWidth['max']?><?php endif;?>"</li>
						<?php endif;?>
						<li>Diameter <?=Tire::diameter($tire)?>"</li>
						<li>Sidewall height <?=Tire::sidewallHeight($tire)?>"</li>
					</ul>
				</div>				
				
				<?php if ($tire['is_rear']):?>
				<?php $tireRearAttr = array(
					'aspect_ratio' => $tire['rear_aspect_ratio'],
					'section_width' => $tire['rear_section_width'],
					'rim_diameter' => $tire['rear_rim_diameter'],
					'vehicle_class' => $tire['vehicle_class'],
				);?>
				<?php $tireRearText = Tire::format($tireRearAttr, false);?>
				<div class="product_photo_item_top">
					<a href="#" class="product_photo_name">Rear tires <?=$tireRearText?></a>
					<ul class="make__vehicle-specs">
						<li><a type="amzn" search="<?=$tireRearText?>" category="automotive">Buy on Amazon</a></li>
						<?php $rimWidth = TireRimWidth::getRangeWidth($tireRearAttr['section_width']);?>
						<?php if (!empty($rimWidth)):?>
						<li>Rim width <?=$rimWidth['min']?><?php if($rimWidth['min']!=$rimWidth['max']):?> - <?=$rimWidth['max']?><?php endif;?>"</li>
						<?php endif;?>
						<li>Diameter <?=Tire::diameter($tireRearAttr)?>"</li>
						<li>Sidewall height <?=Tire::sidewallHeight($tireRearAttr)?>"</li>
					</ul>
				</div>
				<?php endif;?>
			</div>
			
			
			<?php endforeach;?>
		</section>
		<?php endif;?>
		
		<?php if (!empty($competitors)):?>
		<section class="make">
			<h2 class="section-name_2">Competitors' tire sizes</h2>

			<ul class="make__vehicle">
			<?php foreach ($competitors as $competitor):?>
				<li>
					<div class="make__vehicle-image">
						<a title="<?=$competitor['year']?> <?=$competitor['make']?> <?=$competitor['model']?> tire size" href="/tires/<?=$competitor['make_alias']?>/<?=$competitor['model_alias']?>/<?=$competitor['year']?>/">
							<img src="<?=$competitor['photo']?>">
						</a>
					</div>
					<h3>
						<a href="/tires/<?=$competitor['make_alias']?>/<?=$competitor['model_alias']?>/<?=$competitor['year']?>/"><?=$competitor['year']?> <?=$competitor['make']?>  <?=$competitor['model']?> tire size</a>
					</h3>

					<?php $rangeTireSize = AutoModel::getMinMaxTireSizeYear($competitor['id']);?>
					<?php if (!empty($rangeTireSize)):?>
					<ul class="make__vehicle-specs">
						<li>
							<?=$rangeTireSize['min']?> 
							<?php if ($rangeTireSize['min'] != $rangeTireSize['max']):?> - <?=$rangeTireSize['max']?><?php endif;?>
						</li>
					</ul>
					<?php endif;?>					
					
				</li>
			<?php endforeach;?>
			</ul>
		</section>
		<?php endif;?>
		
		<!-- years -->
		<section class="years_box make">
			<h2 class="section-name_2">Years</h2>
			<ul class="years_list">
			<?php foreach ($modelYears as $item):?>
				<li class="years_list_item <?php if($item['year']==$modelYear['year']):?>current<?php endif;?>"><a href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/" class="btn years_list_link" title="<?=$item['year']?> <?=$make['title']?> <?=$model['title']?> tires"><?=$item['year']?></a></li>
			<?php endforeach;?>
			</ul>
		</section>
		
		<?php if (!empty($otherModels)):?>
		<section class="all-models">
			<h2 class="section-name_2">Other <?=$modelYear['year']?> <?=$make['title']?> models</h2>
			<div class="model__block-box model__block-box_all-models">
			<?php foreach ($otherModels as $otherModel):?>	
				<a href="/tires/<?=$make['alias']?>/<?=$otherModel['model_alias']?>/<?=$otherModel['year']?>/" class="model__block model__block_all-models" title="<?=$otherModel['year']?> <?=$make['title']?> <?=$otherModel['model']?> tire size">
					<img src="<?=$otherModel['photo']?>">
					<div class="model__block-name"><h3><?=$otherModel['year']?> <?=$make['title']?> <?=$otherModel['model']?></h3></div>
					<?php $rangeTireSize = AutoModel::getMinMaxTireSizeYear($otherModel['id']);?>
					<?php if (!empty($rangeTireSize)):?>
					<span class="model__block-cost">
						<?=$rangeTireSize['min']?> 
						<?php if ($rangeTireSize['min'] != $rangeTireSize['max']):?> - <?=$rangeTireSize['max']?><?php endif;?>
					</span>
					<?php endif;?>	
				</a>
			<?php endforeach;?>
			</div>
		</section>
		<?php endif;?>
		
	</div>
	<div class="l-col2">
		<section class="">
			
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
			
			<section class="right-block w78">
				<h2 class="section-name"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> specs</h2>
		
				<a href="/<?=$make['alias']?>/<?=$model['alias']?>/<?=$modelYear['year']?>/" title="<?=$make['title']?> <?=$model['title']?> <?=$modelYear['year']?> info ">
					<img src="<?=$modelYear['photo']?>">
				</a>				
				
				<table class="right-block__specs-list">
					<tbody>
					
					<?php if (!empty($carSpecsAndDimensions['0_60_times']['mmin'])):?>
					<tr>
						<td><a class="speed" title="<?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> 0-60" href="/0-60-times/<?=$make['alias']?>/<?=$model['alias']?>/">0-60 times</a></td>
						<td class="spec-value">
						<?php if ($carSpecsAndDimensions['0_60_times']['mmin'] != $carSpecsAndDimensions['0_60_times']['mmax']):?>
							<?=(float)$carSpecsAndDimensions['0_60_times']['mmin']?> - <?=(float)$carSpecsAndDimensions['0_60_times']['mmax']?>
						<?php else:?>
							<?=(float)$carSpecsAndDimensions['0_60_times']['mmin']?>
						<?php endif;?>
						sec
						</td>
					</tr>
					<?php endif;?>

					<?php $rangeTireSize = AutoModel::getMinMaxTireSizeYear($modelYear['id']);?>
					<?php if (!empty($rangeTireSize)):?>
					<tr>
						<td><a class="tires" title="<?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> Tire size" href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/<?=$modelYear['year']?>/">Tire size</a></td>
						<td class="spec-value">
							<?=$rangeTireSize['min']?> ...
						</td>
					</tr>
					<?php endif;?>			
						
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
					
					<?php if (!empty($carSpecsAndDimensions['towing_capacity']['mmin'])):?>
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
					<?php endif;?>	
					
					<?php if (!empty($carSpecsAndDimensions['length']['mmin'])):?>
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
					<?php endif;?>	
					
					<?php if (!empty($carSpecsAndDimensions['wheelbase']['mmin'])):?>
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
					<?php endif;?>	
					
					<?php if (!empty($carSpecsAndDimensions['clearance']['mmin'])):?>
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
					<?php endif;?>
					
					<?php if (!empty($carSpecsAndDimensions['curb_weight']['mmin'])):?>
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
					<?php endif;?>
					
					<?php if (!empty($carSpecsAndDimensions['cargo_space']['mmin'])):?>
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
					<?php endif;?>
					
				</tbody>
				</table>
			</section>
		</section>
	</div>
</main>

<?php $this->renderPartial('_amazon_script');?>