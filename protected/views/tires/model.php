<main>
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?> <?=$model['title']?> tires</h2>
	<div class="google_links f_left p_rel">
                <a href="http://www.tkqlhce.com/click-7797286-11724508-1425186322000" target="_top">
                <img src="http://www.tqlkg.com/image-7797286-11724508-1425186322000" width="300" height="250" alt="Tire Rack: Goodyear/Dunlop Get Rebates Up to $60" border="0"/></a>		
                <?php // $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
	</div>
	<div class="text_size">
		<?=$header_text_block?>
	</div>
</section>
<section class="make">
	<h2 class="section-name_2">Search tire size by <?=$make['title']?> <?=$model['title']?> models</h2>
	<ul class="make__vehicle">
	<?php foreach ($modelByYears as $item):?>
		<li>
			<div class="make__vehicle-image">
				<a title="<?=$item['year']?> <?=$make['title']?> <?=$model['title']?> tire size" href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/">
					<img src="<?=$item['photo']?>">
				</a>
			</div>
			<h3>
				<a href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/"><?=$item['year']?> <?=$make['title']?> <?=$model['title']?> tires</a>
			</h3>
			
			<?php $rangeTireSize = AutoModel::getMinMaxTireSizeYear($item['id']);?>
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

<a href="http://www.anrdoezrs.net/click-7797286-11912813-1426518599000" target="_top">
<img src="http://www.lduhtrp.net/image-7797286-11912813-1426518599000" width="728" height="90" alt="Pirelli Get a $60 Visa Prepaid Card and A Chance to Win a Trip to Amalfi Coast Italy" border="0"/></a>

</section>

</div>
<div class="l-col2">

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

<?php $this->renderPartial('application.views.specs._right_model', array(
	'make'=>$make,
	'model'=>$model,
	'lastModelYear'=>$lastModelYear,
))?>

<a href="http://www.kqzyfj.com/click-7797286-11912793-1428067094000" target="_top">
<img src="http://www.ftjcfx.com/image-7797286-11912793-1428067094000" width="160" height="600" alt="General Grab Up To $70" border="0"/></a>

</div>
</main>