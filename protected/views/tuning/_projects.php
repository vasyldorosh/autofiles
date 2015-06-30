<?php foreach ($projects as $project):?>
			  <li class="js-scrolling-ajax-item">
				<?php if (!empty($project['photo'])):?>
					<div class="make__vehicle-image">
					<a title="<?=$project['year']?> <?=$make['title']?> <?=$model['title']?> project" href="/<?=$make['alias']?>/<?=$model['alias']?>/<?=$project['year']?>/"><img src="<?=$project['photo']?>"></a>
					</div>
				<?php endif;?>	
					<h3><a title="<?=$project['year']?> <?=$make['title']?> <?=$model['title']?> project" href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/<?=$project['id']?>/"><?=$project['year']?> <?=$make['title']?> <?=$model['title']?></a></h3>
					<ul class="make__vehicle-specs">
						<li><?=$project['wheel_manufacturer']?> <?=$project['wheel_model']?> <?=$project['rim_diameter']?>x<?=$project['rim_width']?> <?=($project['rim_offset_range']>0)?'+':''?><?=$project['rim_offset_range']?><?php if($project['is_staggered_wheels']):?>, <?=$project['rear_rim_diameter']?>x<?=$project['rear_rim_width']?> <?=($project['rear_rim_offset_range']>0)?'+':''?><?=$project['rear_rim_offset_range']?><?php endif;?></li>
						<li><?=Tire::format(array(
								'section_width' => $project['tire_section_width'],
								'aspect_ratio' 	=> $project['tire_aspect_ratio'],
								'rim_diameter' 	=> $project['rim_diameter'],
								'vehicle_class'	=> $project['tire_vehicle_class'],
							), true)?><?php if ($project['is_staggered_tires']):?>, rear 
							<?=Tire::format(array(
								'section_width' => $project['rear_tire_section_width'],
								'aspect_ratio' 	=> $project['rear_tire_aspect_ratio'],
								'rim_diameter' 	=> $project['rear_rim_diameter'],
								'vehicle_class'	=> $project['rear_tire_vehicle_class'],
							), true)?>
							<?php endif;?>
						</li>		
						<li><?=$project['view_count']?> views</li>
					</ul>
				</li>		
<?php endforeach;?>		