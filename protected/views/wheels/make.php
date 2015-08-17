<main>
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?> wheels</h2>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
	</div>
	<div class="text_size">
		<?=$header_text_block?>
	</div>
</section>
<section class="make">
	<h2 class="section-name_2">Search rims specs, wheels info, bolt pattern, offset by vehicle</h2>

	<ul class="make__vehicle">
	<?php foreach ($dataModels as $dataModel):?>
		<li>
			<?php if (!empty($dataModel['photo'])):?>
			<div class="make__vehicle-image">
				<a title="<?=$make['title']?> <?=$dataModel['title']?> rims for sale, factory wheel size, bolt pattern, offset" href="/wheels<?=$dataModel['url']?>">
					<img src="<?=$dataModel['photo']?>" alt="<?=$make['title']?> <?=$dataModel['title']?> rims and wheels photo"> 
				</a>
			</div>
			<?php endif;?>	
			<h3>
				<a title="<?=$make['title']?> <?=$dataModel['title']?> rims for sale, factory wheel size, bolt pattern, offset" href="/wheels<?=$dataModel['url']?>"><?=$make['title']?> <?=$dataModel['title']?> wheels</a>
			</h3>
			<?php if (isset($dataModelsWheels[$dataModel['id']]) && $dataWheels=$dataModelsWheels[$dataModel['id']]):?>
					<ul class="make__vehicle-specs">
					<?php 
						$rwd_to = array();
						$rwd_from = array();
						$or = array();
						
						if (!empty($dataWheels['trd_min'])) { $rwd_from[] = $dataWheels['trd_min'];}
						if (!empty($dataWheels['trw_min'])) { $rwd_from[] = $dataWheels['trw_min'];}
						
						if (!empty($dataWheels['trd_max'])) { $rwd_to[] = $dataWheels['trd_max'];}
						if (!empty($dataWheels['trw_max'])) { $rwd_to[] = $dataWheels['trw_max'];}
						
						if (!empty($dataWheels['or_min'])) { $or[] = $dataWheels['or_min'];}
						if (!empty($dataWheels['or_max'])) { $or[] = $dataWheels['or_max'];}
					?>	
					<?php if (!empty($rwd_from) || !empty($rwd_to)):?>	
						<li>Stock rim width <?=implode('x', $rwd_from)?><?php if(!empty($rwd_to) && $rwd_to!==$rwd_from):?><?=(!empty($rwd_from) && !empty($rwd_to))?' &ndash; ':''?><?=implode('x', $rwd_to)?><?php endif;?></li>
					<?php endif;?>	
					
					<?php if (!empty($or)):?>
						<li>Offset range <?=implode(' &ndash; ', $or)?></li>
					</ul>
					<?php endif;?>
					<ul class="make__vehicle-specs">
						<li>Custom rim width 17x7.5 &ndash; 20x10.0</li>
						<li>Offset range 20 &ndash; 45</li>
					</ul>
			<?php endif;?>
		</li>
	<?php endforeach;?>	
	</ul>

	<?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
	
</section>

</div>

	<div class="l-col2">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

		<section class="right-block">
			<?php $this->renderPartial('application.views.specs._right_make', array('make'=>$make))?>
		</section>	
	</div>
</main>