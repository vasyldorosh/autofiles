	<div class="l-col1">
		<!-- section 1 -->
		
		<section class="times clearfix">
			<h2 class="section-name pb18">Car tuning and modifications</h2>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=SiteConfig::getInstance()->getValue('tuning_header_text_block')?>
			</div>
		</section>
		
		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Car tuning by makes</h2>
			<ul>
				<?php $key=1;foreach ($makes as $make):?>
					<li><a title="<?=$make['title']?> tuning" href="/tuning/<?=$make['alias']?>/"><?=$make['title']?> <?php if($make['projects']):?>(<?=$make['projects']?>)<?php endif;?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
			</ul>														
		</section>
		
		<section class="make">
			<h2 class="section-name_2 mb30">Most popular projects</h2>
			<ul class="make__vehicle">
			<?php foreach ($projects as $project):?>  
			  <li>
				<?php if (!empty($project['photo'])):?>
					<div class="make__vehicle-image">
					<a title="<?=$project['year']?> <?=$project['make_title']?> <?=$project['model_title']?> project" href="/<?=$project['make_alias']?>/<?=$project['model_alias']?>/<?=$project['year']?>/"><img src="<?=$project['photo']?>"></a>
					</div>
				<?php endif;?>	
					<h3><a title="<?=$project['year']?> <?=$project['make_title']?> <?=$project['model_title']?> project" href="/tuning/<?=$project['make_alias']?>/<?=$project['model_alias']?>/<?=$project['id']?>/"><?=$project['year']?> <?=$project['make_title']?> <?=$project['model_title']?></a></h3>
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
			</ul>
			
			<br>
		</section>
	
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
	
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('tuning_footer_text_block')?>
		</section>	
		<br clear="all">		
		
		
	</div>
	<div class="l-col2">
	
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<section class="right-block">				
			<?php $this->renderPartial('application.views.specs._right_index')?>		
		</section>	
		
	</div>