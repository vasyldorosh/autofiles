<main>
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?>  <?=$model['title']?> horsepower</h2>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
	</div>
	<div class="text_size">
		<?=$header_text_block?>
	</div>
</section>
<section class="make">
	<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> horsepower by years</h2>
	<ul class="make__vehicle">
	<?php foreach ($modelByYears as $item):?>	
		<li>
			<div class="make__vehicle-image">
				<a title="<?=$item['year']?> <?=$make['title']?>  <?=$model['title']?> horsepower and torque" href="/horsepower/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/">
					<img src="<?=$item['photo']?>">
				</a>
			</div>
			<h3>
				<a href="/horsepower/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/"><?=$item['year']?> <?=$make['title']?>  <?=$model['title']?> horsepower</a>
			</h3>
			
			<ul class="make__vehicle-specs">
				<?php $hps = AutoModelYear::getHps($item['id']);?>				
				<li>
					<?php $links = array();
					$size = count($hps);
					foreach ($hps as $k=>$hp) {
						$p = ($k==$size-1)?' hp':'';
						$links[] = "<a href='/horsepower/{$hp}/'>{$hp}{$p}</a>";
					}
					?>
					<?php if (!empty($links)):?>
						<?=implode(', ', $links)?>
					<?php endif;?>
				</li>
				
				<?php $rangeTimes = AutoModelYear::getMinMaxSpecs('0_60mph__0_100kmh_s_', $item['id']);?>	
				
				<?php if (!empty($rangeTimes)):?>	
					<li>
						<a href="/0-60-times/<?=$make['alias']?>/<?=$model['alias']?>" title="<?=$make['title']?> <?=$model['title']?> 0-60 times acceleration">
						0-60 times 
						<?=$rangeTimes['mmin']?> 
						<?php if ($rangeTimes['mmin'] != $rangeTimes['mmax']):?> - <?=$rangeTimes['mmax']?><?php endif;?>
						sec
						</a>
					</li>
				<?php endif;?>
			</ul>						
		</li>
	<?php endforeach;?>
	</ul>
</section>

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