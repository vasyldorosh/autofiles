<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h2 class="section-name pb18"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> tires</h2>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>
		
		<?php if (!empty($tires)):?>
		<section class="product_photo_box make">
			<h2 class="section-name_2 mb30">All tire sizes for <?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?></h2>
			
			
			<?php 
				$vc=array(); 
				foreach ($tires as $tire) {
					$vc[$tire['vehicle_class']]=$tire['vehicle_class']; 
				}
				$pVC = (count($vc)>1);
			?>
			
			
			<?php foreach ($tires as $tire):?>
			<?php $tireText = Tire::format($tire, $pVC);?>
			<?php $tireTextProfile = Tire::formatProfile($tire, $pVC);?>
			
			<?php $rimWidth = TireRimWidthRange::getRangeTire($tire['id']);?>
			<div class="product_photo_item">
				<div class="product_photo_item_top">
					<a href="<?=Tire::url($tire)?>" class="product_photo_name"><?=$tire['is_rear']?'Front tires ':''?><?=$tireTextProfile?></a>
					<ul class="make__vehicle-specs">
						<li><a type="amzn" search="<?=Tire::format($tire, false)?>" category="automotive">Buy on Amazon</a></li>
						
						<?php if (!empty($rimWidth['front'])):?>
						<li>Rim width <?=$rimWidth['front']['from']?> - <?=$rimWidth['front']['to']?>"</li>
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
				<?php $tireRearTextProfile = Tire::formatProfile($tireRearAttr, false);?>
				<div class="product_photo_item_top">
					<a href="<?=Tire::url($tire)?>" class="product_photo_name">Rear tires <?=$tireRearTextProfile?></a>
					<ul class="make__vehicle-specs">
						<li><a type="amzn" search="<?=$tireRearText?>" category="automotive">Buy on Amazon</a></li>
						<?php if (!empty($rimWidth['rear'])):?>
						<li>Rim width <?=$rimWidth['rear']['from']?> - <?=$rimWidth['rear']['to']?>"</li>
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
		
                <?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>

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
		
               <?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>

		<!-- years -->
		<section class="years_box make">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> by years</h2>
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
		
		<?php $this->renderPartial('application.views.site._reviews', array(
			'items' => ReviewVsModelYear::getTextModelYear(ReviewVsModelYear::MARKER_TIRES, $modelYear['id']),
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

<?php $this->renderPartial('_amazon_script');?>