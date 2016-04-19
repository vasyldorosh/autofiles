<main>
	<div class="l-col1">
		<!-- section 1 -->
		<?d($project,0);?>
			
		<section class="table-container">
		<h2 class="section-name_2 mb30"><?=$project['year']?> <?=$make['title']?> <?=$model['title']?> aftermarket wheels</h2>
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
		
		<?php if (isset($photos[0])):?>
		<img src="<?=$photos[0]?>" alt="photo 1 <?=$this->pageTitle?>">
		<?php endif;?>

		<?php if (isset($photos[1])):?>
		<img src="<?=$photos[1]?>" alt="photo 2 <?=$this->pageTitle?>">
		<?php endif;?>		


<br><br>


<h2 class="section-name_2 mb30">Custom wheels & tires for <?=$make['title']?> <?=$model['title']?></h2>
	<table>
	<tbody>
		
		<?php //есть Staggered Tires, но нет Staggered Wheels
		if ($project['is_staggered_tires'] && !$project['is_staggered_wheels']):?>

			<tr>
				<td>Front rim size</td>
				<td><h3><?=$project['rim_diameter']?><?=(!empty($project['rim_width']))?'x'.$project['rim_width']:' inch'?></a></td>		
			</tr>
			<?php if (!empty($project['rim_offset_range'])):?>
			<tr>
				<td>Front rim offset</td>
				<td><h3><?=($project['rim_offset_range']>0?'+':'')?><?=$project['rim_offset_range']?></h3></td>
			</tr>
			<?php endif;?>
			
			<?php if (!empty($project['tire_section_width']) && !empty($project['tire_aspect_ratio']) && !empty($project['rim_diameter'])):?>
			<tr>
				<td>Front tire size</td>
				<td><h3><a href="<?=Tire::url(array(
					'section_width' => $project['tire_section_width'],
					'aspect_ratio' 	=> $project['tire_aspect_ratio'],
					'rim_diameter' 	=> $project['rim_diameter'],
					'vehicle_class'	=> $project['tire_vehicle_class'],
				))?>"><?=Tire::format(array(
					'section_width' => $project['tire_section_width'],
					'aspect_ratio' 	=> $project['tire_aspect_ratio'],
					'rim_diameter' 	=> $project['rim_diameter'],
					'vehicle_class'	=> $project['tire_vehicle_class'],
				), true)?></a></h3></td>	
			</tr>
			<?php endif;?>
			
			<?php if (!empty($project['rim_width']) && !empty($project['rim_offset_range'])):?>
			<tr><td>Wheel backspacing</td><td><h3><?= Project::getWheelBackspacing($project['rim_width'], $project['rim_offset_range'])?>”</h3></td></tr>
			<?php endif;?>
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>			
			</tr>
			
			<tr>
				<td>Rear rim size</td>
				<td><h3><?=$project['rim_diameter']?><?=(!empty($project['rim_width']))?'x'.$project['rim_width']:' inch'?></h3></td>
			</tr>
			
			<?php if (!empty($project['rim_offset_range'])):?>
			<tr>
				<td>Rear rim offset</td>
				<td><h3><?=($project['rim_offset_range']>0?'+':'')?><?=$project['rim_offset_range']?></h3></td>	
			</tr>
			<?php endif;?>
		
			<?php if (!empty($project['rear_tire_section_width']) && !empty($project['rear_tire_aspect_ratio']) && !empty($project['rim_diameter'])):?>
			<tr>
				<td>Rear tire size</td>
				<td><h3><a href="<?=Tire::url(array(
					'section_width' => $project['rear_tire_section_width'],
					'aspect_ratio' 	=> $project['rear_tire_aspect_ratio'],
					'rim_diameter' 	=> $project['rim_diameter'],
					'vehicle_class'	=> $project['tire_vehicle_class'],
				))?>"><?=Tire::format(array(
					'section_width' => $project['rear_tire_section_width'],
					'aspect_ratio' 	=> $project['rear_tire_aspect_ratio'],
					'rim_diameter' 	=> $project['rim_diameter'],
					'vehicle_class'	=> $project['tire_vehicle_class'],
				), true)?></a></h3></td>	
			</tr>
			
			<?php if (!empty($project['rear_rim_width']) && !empty($project['rear_rim_offset_range'])):?>
			<tr><td>Wheel backspacing</td><td><h3><?= Project::getWheelBackspacing($project['rear_rim_width'], $project['rear_rim_offset_range'])?>”</h3></td></tr>
			<?php endif;?>			
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				
			</tr>
			<?php endif;?>
					
		
		<?php else:?>		
			<tr>
				<td><?=($project['is_staggered_wheels'])?'Front rim size':'Front & rear rim size'?></td>
				<td><h3><?=$project['rim_diameter']?><?=(!empty($project['rim_width']))?'x'.$project['rim_width']:' inch'?></h3></td>		
			</tr>
			<?php if (!empty($project['rim_offset_range'])):?>
			<tr>
				<td><?=($project['is_staggered_wheels'])?'Front rim offset':'Front & rear rim offset'?></td>
				<td><h3><?=($project['rim_offset_range']>0?'+':'')?><?=$project['rim_offset_range']?></h3></td>
			</tr>
			<?php endif;?>
			
			<?php if (!empty($project['tire_section_width']) && !empty($project['tire_aspect_ratio']) && !empty($project['rim_diameter'])):?>
			<tr>
				<td><?=($project['is_staggered_wheels'])?'Front tire size':'Front & rear tire size'?></td>
				<td><h3><a href="<?=Tire::url(array(
					'section_width' => $project['tire_section_width'],
					'aspect_ratio' 	=> $project['tire_aspect_ratio'],
					'rim_diameter' 	=> $project['rim_diameter'],
					'vehicle_class'	=> $project['tire_vehicle_class'],
				))?>"><?=Tire::format(array(
					'section_width' => $project['tire_section_width'],
					'aspect_ratio' 	=> $project['tire_aspect_ratio'],
					'rim_diameter' 	=> $project['rim_diameter'],
					'vehicle_class'	=> $project['tire_vehicle_class'],
				), true)?></a></h3></td>	
			</tr>
			<?php endif;?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>			
			</tr>
			
			<?php if ($project['is_staggered_wheels']):?>
			<tr>
				<td>Rear rim size</td>
				<td><h3><?=$project['rear_rim_diameter']?>x<?=$project['rear_rim_width']?></h3></td>
			</tr>
			
				<?php if (!empty($project['rear_rim_offset_range'])):?>
				<tr>
					<td>Rear rim offset</td>
					<td><h3><?=($project['rear_rim_offset_range']>0?'+':'')?><?=$project['rear_rim_offset_range']?></h3></td>			
				</tr>
				<?php endif;?>
				
			<?php endif;?>
		
			<?php if (!empty($project['rear_tire_section_width']) && !empty($project['rear_tire_aspect_ratio']) && !empty($project['rear_rim_diameter']) && $project['is_staggered_tires']):?>
			<tr>
				<td>Rear tire size</td>
				<td><h3><a href="<?=Tire::url(array(
					'section_width' => $project['rear_tire_section_width'],
					'aspect_ratio' 	=> $project['rear_tire_aspect_ratio'],
					'rim_diameter' 	=> $project['rear_rim_diameter'],
					'vehicle_class'	=> $project['tire_vehicle_class'],
				))?>"><?=Tire::format(array(
					'section_width' => $project['rear_tire_section_width'],
					'aspect_ratio' 	=> $project['rear_tire_aspect_ratio'],
					'rim_diameter' 	=> $project['rear_rim_diameter'],
					'vehicle_class'	=> $project['tire_vehicle_class'],
				), true)?></a></h3></td>	
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				
			</tr>
			<?php endif;?>
		<?php endif;?>
		
		
		
		<?php if (!empty($project['wheel_manufacturer']) || !empty($project['wheel_model'])):?>
		<tr>
			<td>Rims brand</td>
			<td><h3><?=$project['wheel_manufacturer']?> <?=$project['wheel_model']?></h3></td>
		</tr>
                <tr>
			<td>Wheel weight</td>
			<td>To be added soon</td>
		</tr>		
		<?php endif;?>

		<?php if (!empty($project['tire_manufacturer']) || !empty($project['tire_model'])):?>
		<tr>
			<td>Tire brand</td>
			<td><h3><?=$project['tire_manufacturer']?> <?=$project['tire_model']?></h3></td>	
		</tr>	
		<?php endif;?>		
		
	</tbody>
	</table>
	</section>	
	
	
	

		    <?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
		<?php if (!empty($project['description']) || !empty($project['source'])):?>
			<section class="seo-text">
			<h2 class="section-name_2">Details of modified <?=$project['year']?> <?=$make['title']?> <?=$model['title']?></h2>
				<?=$project['description']?>
				
                            
				
                                <?php if (!empty($project['source'])):?>
					<p><a href="<?=$project['source']?>" target="_blank" rel="nofollow">Source</a></p>
				<?php endif;?>				
			</section>
		<?php endif;?>
	

<script type="text/javascript">
amzn_assoc_placement = "adunit0";
amzn_assoc_enable_interest_ads = "true";
amzn_assoc_tracking_id = "auto036-20";
amzn_assoc_ad_mode = "auto";
amzn_assoc_ad_type = "smart";
amzn_assoc_marketplace = "amazon";
amzn_assoc_region = "US";
amzn_assoc_textlinks = "";
amzn_assoc_linkid = "097767456ffb915dae33a786dd7ba913";
amzn_assoc_emphasize_categories = "15684181";
</script>
<script src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US"></script>


                <?php if (isset($photos[2])):?>
		<img src="<?=$photos[2]?>" alt="photo 3 <?=$this->pageTitle?>">
		<?php endif;?>

		<?php if (isset($photos[3])):?>
		<img src="<?=$photos[3]?>" alt="photo 4 <?=$this->pageTitle?>">
		<?php endif;?>		
		
		<?php if (isset($photos[4])):?>
		<img src="<?=$photos[4]?>" alt="photo 5 <?=$this->pageTitle?>">
		<?php endif;?>

		<?php if (isset($photos[5])):?>
		<img src="<?=$photos[5]?>" alt="photo 6 <?=$this->pageTitle?>">
		<?php endif;?>	
	
		<?php if (isset($photos[6])):?>
		<img src="<?=$photos[6]?>" alt="photo 7 <?=$this->pageTitle?>">
		<?php endif;?>	
	
	<?php if (!empty($nextProject)):?>
	<section class="all-models">
<p>Send your car project to autotkcom@gmail.com</p>
		<h2 class="section-name_2">Next project</h2><br>
		<div>
			<a href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/<?=$nextProject['id']?>/" title="<?=$nextProject['year']?> <?=$make['title']?> <?=$model['title']?> <?=$nextProject['rim_diameter']?>x<?=$nextProject['rim_width']?> <?=($nextProject['rim_offset_range']>0)?'+':''?><?=$nextProject['rim_offset_range']?><?php if($nextProject['is_staggered_wheels']):?>, <?=$nextProject['rear_rim_diameter']?>x<?=$nextProject['rear_rim_width']?> <?=($nextProject['rear_rim_offset_range']>0)?'+':''?><?=$nextProject['rear_rim_offset_range']?><?php endif;?>">
				<img src="<?=$nextProject['photo']?>">
				<h3><?=$nextProject['year']?> <?=$make['title']?> <?=$model['title']?> <?=$nextProject['rim_diameter']?>x<?=$nextProject['rim_width']?> <?=($nextProject['rim_offset_range']>0)?'+':''?><?=$nextProject['rim_offset_range']?><?php if($nextProject['is_staggered_wheels']):?>, <?=$nextProject['rear_rim_diameter']?>x<?=$nextProject['rear_rim_width']?> <?=($nextProject['rear_rim_offset_range']>0)?'+':''?><?=$nextProject['rear_rim_offset_range']?><?php endif;?></h3>	
			</a>
		</div>
	</section>
	<?php endif;?>
		
		<?php foreach ($photos as $k=>$photo): if ($k<=6) {continue;}?>
		<img src="<?=$photo?>" alt="photo <?=($k+1)?> <?=$this->pageTitle?>">
		<?php endforeach;?>
		
	</div>
	
	<div class="l-col2">
		<br>
				
		<?php if (!empty($modelYear)):?>
			<?php $this->renderPartial('application.views.specs._right_model_year', array(
				'make'=>$make,
				'model'=>$model,
				'modelYear'=>$modelYear,
			))?>		
		<?php endif;?>
<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

	</div>
</main>