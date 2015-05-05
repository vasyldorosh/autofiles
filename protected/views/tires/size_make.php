<main>
<div class="l-col1">
	<!-- section 1 -->
	<section class="times clearfix">
		<h2 class="section-name pb18"><?=$make['title']?> <?=Tire::format($tire)?></h2>
		<div class="google_links f_left p_rel">
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
		</div>
		<div class="text_size">
			<?=$header_text_block?>
		</div>
	</section>


<section class="make">
	<h2 class="section-name_2"><?=Tire::format($tire)?> tire size across the models</h2>
	<ul class="make__vehicle">
	<?php foreach ($modelYears as $modelYear):$years=AutoModel::getYears($modelYear['id'])?>
		<li>
			<div class="make__vehicle-image">
				<a title="<?=$make['title']?> <?=$modelYear['title']?> tires" href="/tires/<?=$make['alias']?>/<?=$modelYear['alias']?>/">
					<img src="<?=$modelYear['photo']?>">
				</a>
			</div>
			<h3>
				<a href="/tires/<?=$make['alias']?>/<?=$modelYear['alias']?>/" title="<?=$make['title']?> <?=$modelYear['title']?> tires"><?=$make['title']?> <?=$modelYear['title']?> tire size</a>
			</h3>
			<ul class="make__vehicle-years">
			<?php foreach ($years as $year):?>
				<li <?=(!isset($modelYear['years'][$year['id']]))?'class="no_active"':''?>>
					<a title="<?=$year['year']?> <?=$make['title']?> <?=$modelYear['title']?> tire size" href="/tires/<?=$make['alias']?>/<?=$modelYear['alias']?>/<?=$year['year']?>/"><?=$year['year']?></a>
				</li>
			<?php endforeach;?>	
			</ul>
		</li>
	<?php endforeach;?>	
	</ul>
</section>

		<section class="make">
			<h2 class="section-name_2">Cheap <a href="<?=Tire::url($tire)?>"><?=Tire::format($tire, false)?></a> tires for sale online</h2>	
			<br>		
			<?php $this->widget('application.widgets.AmazonWidget', array(
				'action' => 'products',
				'params' => array(
					'tire' => Tire::format($tire, false),
				),
			)); ?>
		</section>	

</div>
<div class="l-col2">

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

		<section class="right-block">
			<?php $this->renderPartial('application.views.specs._right_make', array('make'=>$make))?>
		</section>
		<section class="right-block">
			<h2 class="section-name"><a href="<?=Tire::url($tire)?>"><?=Tire::format($tire, false)?> specs</a></h2>
			<?php $this->renderPartial('_specs', array('tire'=>$tire))?>
		</section>
	</div>
</main>