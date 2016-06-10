<main>
<div class="l-col1">
	<!-- section 1 -->
	<section class="times clearfix">
		<h1 class="section-name_2">All <?=$make['title']?> models mpg</h1>
		<div class="google_links f_left p_rel">
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
		</div>
		<div class="text_size">
			<?= $header_text_block?>
		</div>
	</section>
	
	<section class="make">
	<h2 class="section-name_2"><?=$make['title']?> mpg by models</h2>

	<ul class="make__vehicle">
	<?php foreach ($dataModels as $item):?>	
		<li>
			<?php if (isset($item['photo'])):?>
			<div class="make__vehicle-image">
				<a title="<?= $make['title']?> <?= $item['title']?> mpg" href="/mpg/<?= $make['alias']?>/<?= $item['alias']?>/">
					<img src="<?= $item['photo']?>"> 
				</a>
			</div>
			<?php endif;?>
				
			<h3>
				<a href="/mpg/<?= $make['alias']?>/<?= $item['alias']?>/" title="<?= $make['title']?> <?= $item['title']?> mpg"><?= $make['title']?> <?= $item['title']?></a>
			</h3>

			<ul class="make__vehicle-specs">
				<li>
				City MPG
				<?php if ($item['mpg']['fuel_economy_city']['mmin'] != $item['mpg']['fuel_economy_city']['mmax']):?>	
					<?= $item['mpg']['fuel_economy_city']['mmin']?> &ndash; <?= $item['mpg']['fuel_economy_city']['mmax']?>
				<?php else:?>
					<?= $item['mpg']['fuel_economy_city']['mmin']?>
				<?php endif;?>
				</li>
				<li>
				Highway MPG
				<?php if ($item['mpg']['fuel_economy_highway']['mmin'] != $item['mpg']['fuel_economy_highway']['mmax']):?>	
					<?= $item['mpg']['fuel_economy_highway']['mmin']?> &ndash; <?= $item['mpg']['fuel_economy_highway']['mmax']?>
				<?php else:?>
					<?= $item['mpg']['fuel_economy_highway']['mmin']?>
				<?php endif;?>
				</li>
			</ul>
		</li>
		<?php endforeach;?>
	</ul>
	</section>

</div>

<div class="l-col2">
	<br>

	<section class="right-block">
		<?php $this->renderPartial('application.views.specs._right_make', array('make'=>$make))?>
	</section>

	<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>


</div>


</main>
