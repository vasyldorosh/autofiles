<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h2 class="section-name pb18">Horsepower</h2>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '300x250')); ?>
			</div>
			<div class="text_size">
				<?=SiteConfig::getInstance()->getValue('horsepower_header_text_block')?>
			</div>
		</section>
		
		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Select make and model to view its horsepower</h2>
				<ul>
				<?php $key=1;foreach (AutoMake::getAllFront() as $makeUrl=>$makeTitle):?>
					<li><a title="<?=$makeTitle?> horsepower" href="/horsepower<?=$makeUrl?>"><?=$makeTitle?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
				</ul>			
		</section>	

		<section class="product_photo_box make">
			<h2 class="section-name_2">20 high horsepower cars in our database</h2>
			<ul class="make__vehicle">
			<?php foreach (AutoCompletion::getHighHorsepower() as $modelYear):?>	
				<li>
					<div class="make__vehicle-image"><a title="<?=$modelYear['make_title']?> <?=$modelYear['model_title']?> horsepower" href="/horsepower/<?=$modelYear['make_alias']?>/<?=$modelYear['model_alias']?>/"><img src="<?=$modelYear['photo']?>"></a></div>
					<h3><a title="<?=$modelYear['make_title']?> <?=$modelYear['model_title']?> horsepower" href="/horsepower/<?=$modelYear['make_alias']?>/<?=$modelYear['model_alias']?>/"><?=$modelYear['model_year']?> <?=$modelYear['make_title']?> <?=$modelYear['model_title']?></a></h3>
					<h3><a href="/horsepower/<?=trim($modelYear['hp'])?>/"><?=$modelYear['horsepower']?></a></h3>
					<ul class="make__vehicle-specs">
						<?php if (!empty($modelYear['0_60_mph'])):?>
							<li><a href="/0-60-times/<?=$modelYear['make_alias']?>/<?=$modelYear['model_alias']?>/" title="<?=$modelYear['model_year']?> <?=$modelYear['make_title']?> <?=$modelYear['model_title']?> 0-60 times <?=(float)$modelYear['0_60_mph']?> sec">0-60 <?=(float)$modelYear['0_60_mph']?> sec</a></li>
						<?php endif;?>
						<?php if (!empty($modelYear['torque'])):?>
							<li>Torque <?=(float)$modelYear['torque']?> lb.-ft.</a></li>
						<?php endif;?>
						<?php if (!empty($modelYear['mile_time']) || !empty($modelYear['mile_speed'])):?>0_60_mph
							<li>
								<?php if (!empty($modelYear['mile_time'])):?>1/4 mile <?=$modelYear['mile_time']?> sec @ <?php endif;?>
								<?php if (!empty($modelYear['mile_speed'])):?> <?=$modelYear['mile_speed']?> mph<?php endif;?>
							</li>
						<?php endif;?>
						<?php if (!empty($modelYear['msrp'])):?>
							<li>Price <?=HtmlHelper::price($modelYear['msrp']);?></li>
						<?php endif;?>
						<?php if (!empty($modelYear['curb_weight'])):?>
							<li>Weight <?=(float)$modelYear['curb_weight']?> lbs.</a></li>
						<?php endif;?>						
						<?php if (!empty($modelYear['fuel_economy_city']) || !empty($modelYear['fuel_economy_highway'])):?>
							<li>MPG <?=$modelYear['fuel_economy_city']?><?php if(!empty($modelYear['fuel_economy_city']) && !empty($modelYear['fuel_economy_highway'])):?>/<?php endif;?><?=$modelYear['fuel_economy_highway']?></a></li>
						<?php endif;?>	
						
					</ul>
				</li>
			<?php endforeach;?>	
			</ul>
		</section>
		
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('horsepower_footer_text_block')?>
		</section>
	</div>
	
	
	<div class="l-col2">
		<section class="">
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		</section>
	</div>
</main>