<main>
	<div class="l-col1">
                 <section class="make">
			<h2 class="section-name_2">Cheap <?=Tire::format($tire, false)?> tires for sale online</h2>	
			<br>		
			<?php $this->widget('application.widgets.AmazonWidget', array(
				'action' => 'products',
				'params' => array(
					'tire' => Tire::format($tire, false),
				),
			)); ?>
		</section>			
                <section class="make">
			<h2 class="section-name">List of cars with <?=Tire::format($tire)?> tire size</h2>
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
							<a title="<?=$makeModel['title']?> <?=$item['title']?> tire size" href="/tires/<?=$makeModel['alias']?>/<?=$item['alias']?>/"><?=$item['title']?></a>
						</li>
					<?php endforeach;?>
					</ul>
				</li>
			<?php endforeach;?>
			</ul>
		</section>
		
	</div>
	
	<div class="l-col2">
		<section class="">
			
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
			
			<section class="right-block w78">
			<h2 class="section-name">Similar tire sizes (might fit)</h2>
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

		<section class="right-block w78">
			<h2 class="section-name"><?=Tire::format($tire)?> specs</h2>
			<?php $this->renderPartial('_specs', array('tire'=>$tire))?>
		</section>
			
		</section>
	</div>
</main>