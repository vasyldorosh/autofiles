<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h1 class="section-name_2"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> dimensions</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>
		
		<section class="table-container">
			<h2 class="section-name_2"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> exterior dimensions</h2>
			<table>
			<?php $tableMap = array(
				'exterior_length' => 'Overall Length',
				'exterior_body_width' => 'Overall Body Width',
				'exterior_height' => 'Overall Body Height',
				'wheelbase' => 'Wheelbase',
				'turning_radius' => 'Turning Radius',
				'ground_clearance' => 'Ground Clearance',
				'drag_coefficient' => 'Drag coefficient (Cd)',
				'front_track' => 'Front Track',
				'rear_track' => 'Rear Track',
			);
			?>
			
			<?php foreach ($tableMap as $attribute=>$spec_title): $range=AutoModelYear::getMinMaxSpecs($attribute, $modelYear['id']);?>
				<tr>
					<td><?=$spec_title?></td>
					<td><?php if (!empty($range) && $range['mmax']>0):?>
							<?=$range['mmin']?><?php if ($range['mmin'] != $range['mmax']):?> - <?=$range['mmax']?><?php endif;?><?=($attribute!='drag_coefficient')?'"':''?>
						<?php else:?>	
							&mdash;
						<?php endif;?>
	
					</td>		
				</tr>	
			<?php endforeach;?>
			</table>
		</section>
		
		<section class="seo-text">
			
                         <div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
			</div>
                        <br><?=$content_text_1?>
		</section>
		
		<div class="banner-ver">
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
		</div>	
		
		<section class="table-container">
			<h2 class="section-name_2"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> interior dimensions</h2>
			<table>
			<?php $tableMap = array(
				'front_headroom' => 'Head Room - Front',
				'rear_headroom' => 'Head Room - Rear',
				'third_row_headroom' => 'Head Room - Third Row',
				'front_hip_room' => 'Hip Room - Front',
				'rear_hip_room' => 'Hip Room - Rear',
				'third_row_hip_room' => 'Hip Room - Third Row',
				'front_legroom' => 'Leg Room - Front',
				'rear_legroom' => 'Leg Room - Rear',
				'third_row_legroom' => 'Leg Room - Third Row',
				'front_shoulder_room' => 'Shoulder Room - Front',
				'rear_shoulder_room' => 'Shoulder Room - Rear',
				'third_row_shoulder_room' => ' Shoulder Room - Third Row',
			);?>	
			<?php foreach ($tableMap as $attribute=>$spec_title): $range=AutoModelYear::getMinMaxSpecs($attribute, $modelYear['id'])?>
				<?php if (in_array($attribute, array('third_row_headroom','third_row_hip_room','third_row_legroom','third_row_shoulder_room'))) {
					$rangeHeadroom=AutoModelYear::getMinMaxSpecs('third_row_headroom', $modelYear['id']);
					$rangeHiproom=AutoModelYear::getMinMaxSpecs('third_row_hip_room', $modelYear['id']);
					$rangeLegroom=AutoModelYear::getMinMaxSpecs('third_row_legroom', $modelYear['id']);
					$rangeShoulderroom=AutoModelYear::getMinMaxSpecs('third_row_shoulder_room', $modelYear['id']);
					
					if (emm($rangeHeadroom) && emm($rangeHiproom) && emm($rangeLegroom) && emm($rangeShoulderroom)) {
						continue;
					} 
				}
				?>
			
				<tr>
					<td><?=$spec_title?></td>
					<td><?php if (!empty($range) && $range['mmax']>0):?>
							<?=$range['mmin']?><?php if ($range['mmin'] != $range['mmax']):?> - <?=$range['mmax']?><?php endif;?>"
						<?php else:?>	
							&mdash;
						<?php endif;?>
	
					</td>		
				</tr>	
			<?php endforeach;?>
			</table>
			
		</section>
		
		<section class="seo-text">
                        
			<br><?=$content_text_2?>
		</section>
		<br clear="all">
		<?php if (!empty($competitors)):?>
		<section class="make">
			<h2 class="section-name_2">Competitors' dimensions</h2>
				
			<ul class="make__vehicle">
			<?php foreach ($competitors as $competitor):?>
				<li>
					<div class="make__vehicle-image">
						<a title="<?=$competitor['year']?> <?=$competitor['make']?> <?=$competitor['model']?> dimensions, length, clearance" href="/dimensions/<?=$competitor['make_alias']?>/<?=$competitor['model_alias']?>/<?=$competitor['year']?>/">
							<img src="<?=$competitor['photo']?>">
						</a>
					</div>
					<h3>
						<a href="/dimensions/<?=$competitor['make_alias']?>/<?=$competitor['model_alias']?>/<?=$competitor['year']?>/"><?=$competitor['year']?> <?=$competitor['make']?>  <?=$competitor['model']?> dimensions</a>
					</h3>			
				</li>
			<?php endforeach;?>								
			</ul>
		</section>
		<?php endif;?>
		
		<!-- years -->
		<section class="years_box make">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> dimensions by years</h2>
			<ul class="years_list">
			<?php foreach ($modelYears as $item):?>
				<li class="years_list_item <?php if($item['year']==$modelYear['year']):?>current<?php endif;?>"><a href="/dimensions/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/" class="btn years_list_link" title="<?=$item['year']?> <?=$make['title']?> <?=$model['title']?> dimensions"><?=$item['year']?></a></li>
			<?php endforeach;?>
			</ul>
		</section>		
		
		
		<?php if (!empty($otherModels)):?>
		<section class="all-models">
			<h2 class="section-name_2">Other <?=$modelYear['year']?> <?=$make['title']?> models</h2>
			<div class="model__block-box model__block-box_all-models">
			<?php foreach ($otherModels as $otherModel):?>	
				<a href="/dimensions/<?=$make['alias']?>/<?=$otherModel['model_alias']?>/<?=$otherModel['year']?>/" class="model__block model__block_all-models" title="<?=$otherModel['year']?> <?=$make['title']?> <?=$otherModel['model']?> dimensions">
					<img src="<?=$otherModel['photo']?>">
					<div class="model__block-name"><h3><?=$otherModel['year']?> <?=$make['title']?> <?=$otherModel['model']?></h3></div>	
				</a>
			<?php endforeach;?>
			</div>
		</section>
		<?php endif;?>		
		
		<?php $this->renderPartial('application.views.site._reviews', array(
			'items' => ReviewVsModelYear::getTextModelYear(ReviewVsModelYear::MARKER_DIMENSIONS, $modelYear['id']),
		)); ?>
		
	</div>
	<div class="l-col2">
		<section class="">
					
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
						
			<?php $this->renderPartial('application.views.specs._right_model_year', array(
				'make'=>$make,
				'model'=>$model,
				'modelYear'=>$modelYear,
			))?>
						
		</section>
		
	</div>
</main>