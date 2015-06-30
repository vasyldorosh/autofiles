<main>
	<div class="l-col1">
		<!-- section 1 -->

			
		<section class="table-container">
		<h2 class="section-name_2 mb30"><?=$project['year']?> <?=$make['title']?> <?=$model['title']?></h2>
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
		
		<?php if (isset($photos[0])):?>
		<img src="<?=$photos[0]?>">
		<?php endif;?>

		<?php if (isset($photos[1])):?>
		<img src="<?=$photos[1]?>">
		<?php endif;?>		


<br><br>
<h2 class="section-name_2 mb30">Wheels & tires</h2>
	<table>
	<tbody>
		</tr>
		<tr>
			<td>Front rim size</td>
			<td><?=$project['rim_diameter']?>x<?=$project['rim_width']?></td>
			
		</tr>
		<tr>
			<td>Front rim offset</td>
			<td><?=($project['rim_offset_range']>0?'+':'')?><?=$project['rim_offset_range']?></td>
			
		</tr>
		<tr><?php $tire = Tire::format(array(
				'section_width' => $project['tire_section_width'],
				'aspect_ratio' 	=> $project['tire_aspect_ratio'],
				'rim_diameter' 	=> $project['rim_diameter'],
				'vehicle_class'	=> $project['tire_vehicle_class'],
			), true)?>
			<td>Front tire size</td>
			<td><a href="http://autofiles.com/tires/<?=$tire?>.html"><?=$tire?></a></td>	
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
		</tr>
		<?php if ($project['is_staggered_wheels']):?>
		<tr>
			<td>Rear rim size</td>
			<td><?=$project['rear_rim_diameter']?>x<?=$project['rear_rim_width']?></td>
		</tr>
		<tr>
			<td>Rear rim offset</td>
			<td><?=($project['rear_rim_offset_range']>0?'+':'')?><?=$project['rear_rim_offset_range']?></td>			
		</tr>
		<?php endif;?>
		<?php if ($project['is_staggered_tires']):?>
		<tr>
			<?php $tire = Tire::format(array(
				'section_width' => $project['rear_tire_section_width'],
				'aspect_ratio' 	=> $project['rear_tire_aspect_ratio'],
				'rim_diameter' 	=> $project['rear_rim_diameter'],
				'vehicle_class'	=> $project['rear_tire_vehicle_class'],
			), true)?>
			<td>Rear tire size</td>
			<td><a href="http://autofiles.com/tires/<?=$tire?>"><?=$tire?></a></td>	
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			
		</tr>
		<?php endif;?>
		<tr>
			<td>Rims brand</td>
			<td><?=$project['wheel_manufacturer']?> <?=$project['wheel_model']?></td>
			
		<tr>
			<td>Tire brand</td>
			<td><?=$project['tire_manufacturer']?> <?=$project['tire_model']?></td>	
		</tr>
		
	</tbody>
	</table>
	</section>	
	
	<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
	<br>

		<?php if (isset($photos[2])):?>
		<img src="<?=$photos[2]?>">
		<?php endif;?>

		<?php if (isset($photos[3])):?>
		<img src="<?=$photos[3]?>">
		<?php endif;?>		
		
		
	<section class="times clearfix">
	<h2 class="section-name_2">Details</h2>
		<?=$project['description']?>
	</section>
	
		<?php if (isset($photos[4])):?>
		<img src="<?=$photos[4]?>">
		<?php endif;?>

		<?php if (isset($photos[5])):?>
		<img src="<?=$photos[5]?>">
		<?php endif;?>	
	
		<?php if (isset($photos[6])):?>
		<img src="<?=$photos[6]?>">
		<?php endif;?>	
	
	<?php if (!empty($nextProject)):?>
	<section class="all-models">
		<h2 class="section-name_2">Next project</h2><br>
		<div>
			<a href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/<?=$nextProject['id']?>/" title="<?=$nextProject['year']?> <?=$make['title']?> <?=$model['title']?> <?=$nextProject['rim_diameter']?>x<?=$nextProject['rim_width']?> <?=($nextProject['rim_offset_range']>0)?'+':''?><?=$nextProject['rim_offset_range']?><?php if($nextProject['is_staggered_wheels']):?>, <?=$nextProject['rear_rim_diameter']?>x<?=$nextProject['rear_rim_width']?> <?=($nextProject['rear_rim_offset_range']>0)?'+':''?><?=$nextProject['rear_rim_offset_range']?><?php endif;?>">
				<img src="<?=$nextProject['photo']?>">
				<h3><?=$nextProject['year']?> <?=$make['title']?> <?=$model['title']?> <?=$nextProject['rim_diameter']?>x<?=$nextProject['rim_width']?> <?=($nextProject['rim_offset_range']>0)?'+':''?><?=$nextProject['rim_offset_range']?><?php if($nextProject['is_staggered_wheels']):?>, <?=$nextProject['rear_rim_diameter']?>x<?=$nextProject['rear_rim_width']?> <?=($nextProject['rear_rim_offset_range']>0)?'+':''?><?=$nextProject['rear_rim_offset_range']?><?php endif;?></h3>	
			</a>
		</div>
	</section>
	<?php endif;?>

	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<?php if (!empty($modelYear)):?>
			<?php $this->renderPartial('application.views.specs._right_model_year', array(
				'make'=>$make,
				'model'=>$model,
				'modelYear'=>$modelYear,
			))?>		
		<?php endif;?>
	</div>
</main>