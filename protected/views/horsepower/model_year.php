<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h1 class="section-name_2"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> horsepower</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>
			
		<?php if (!empty($completions)):?>	
		<section class="product_photo_box make">
			<ul class="make__vehicle"><h2 class="section-name_2 mb30">How much horsepower does the <?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> have?</h2>
			<?php foreach ($completions as $completion):?>	
				<?php $image = !empty($completion['image']) ? $completion['image']: $modelYear['photo'] ?>
				<li>
					<div class="make__vehicle-image">
						<a title="<?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?>" href="/<?=$make['alias']?>/<?=$model['alias']?>/<?=$modelYear['year']?>/">
							<img src="<?=$image?>" width="150"> 
						</a>
					</div>
					<h3><?=$completion['title']?></h3>	
					<h3><?=$completion['horsepower']?></h3>
					<ul class="make__vehicle-specs">
						<?php if (!empty($completion['0_60_mph'])):?>
						<li><a href="/0-60-times/<?=$make['alias']?>/<?=$model['alias']?>/" title="<?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> 0-60 times <?=$completion['0_60_mph']?> sec">0-60 <?=$completion['0_60_mph']?> sec</a></li>
						<?php endif;?>
						<?php if (!empty($completion['torque'])):?>
							<li>Torque <?=(float)$completion['torque']?> lb.-ft.</a></li>
						<?php endif;?>
						<?php if (!empty($completion['mile_time']) || !empty($completion['mile_speed'])):?>
							<li>
								<?php if (!empty($completion['mile_time'])):?>1/4 mile <?=$completion['mile_time']?> sec @ <?php endif;?>
								<?php if (!empty($completion['mile_speed'])):?> <?=$completion['mile_speed']?> mph<?php endif;?>
							</li>
						<?php endif;?>
						<?php if (!empty($completion['msrp'])):?>
							<li>Price <?=HtmlHelper::price($completion['msrp']);?></li>
						<?php endif;?>
						<?php if (!empty($completion['curb_weight'])):?>
							<li><a href="/weight/<?=$make['alias']?>/<?=$model['alias']?>/">Weight <?=(float)$completion['curb_weight']?> lbs.</a></li>
						<?php endif;?>						
						<?php if (!empty($completion['fuel_economy_city']) || !empty($completion['fuel_economy_highway'])):?>
							<li>MPG <?=$completion['fuel_economy_city']?><?php if(!empty($completion['fuel_economy_city']) && !empty($completion['fuel_economy_highway'])):?>/<?php endif;?><?=$completion['fuel_economy_highway']?></a></li>
						<?php endif;?>	
						
					</ul>
				</li>
			<?php endforeach;?>
			</ul>
		</section>	
		<?php endif;?>
		
		<?php if (!empty($competitors)):?>
		<section class="make">
			<h2 class="section-name_2">Competitors' horsepower</h2>
<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
			<ul class="make__vehicle">
			<?php foreach ($competitors as $competitor):?>
				<li>
					<div class="make__vehicle-image">
						<a title="<?=$competitor['year']?> <?=$competitor['make']?> <?=$competitor['model']?> horsepower" href="/horsepower/<?=$competitor['make_alias']?>/<?=$competitor['model_alias']?>/<?=$competitor['year']?>/">
							<img src="<?=$competitor['photo']?>">
						</a>
					</div>
					<h3>
						<a href="/horsepower/<?=$competitor['make_alias']?>/<?=$competitor['model_alias']?>/<?=$competitor['year']?>/"><?=$competitor['year']?> <?=$competitor['make']?>  <?=$competitor['model']?> horsepower</a>
					</h3>

					<ul class="make__vehicle-specs">
						<?php $rangeHp = AutoModelYear::getRangeHp($competitor['id']);?>
						<?php if (!empty($rangeHp)):?>					
						<li>
							<?=$rangeHp['min']?> 
							<?php if ($rangeHp['min'] != $rangeHp['max']):?> - <?=$rangeHp['max']?><?php endif;?> hp
						</li>
						<?php endif;?>		
						<?php $range060 = AutoModelYear::getMinMaxSpecs('0_60mph__0_100kmh_s_', $competitor['id']);?>
						<?php if (!empty($range060)):?>
						<li>
							<a title="<?=$competitor['year']?> <?=$competitor['make']?>  <?=$competitor['model']?> 0-60 time" href="/0-60-times/<?=$competitor['make_alias']?>/<?=$competitor['model_alias']?>/">
							<?=$range060['mmin']?> 
							<?php if ($range060['mmin'] != $range060['mmax']):?> - <?=$range060['mmax']?><?php endif;?> sec
							</a>
						</li>
						<?php endif;?>
					</ul>
								
					
				</li>
			<?php endforeach;?>
			</ul>
		</section>
		<?php endif;?>
		
		<!-- years -->
		<section class="years_box make">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> horsepower by years</h2>
			<ul class="years_list">
			<?php foreach ($modelYears as $item):?>
				<li class="years_list_item <?php if($item['year']==$modelYear['year']):?>current<?php endif;?>"><a href="/horsepower/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>/" class="btn years_list_link" title="<?=$item['year']?> <?=$make['title']?> <?=$model['title']?> horsepower"><?=$item['year']?></a></li>
			<?php endforeach;?>
			</ul>
		</section>
		
		<?php if (!empty($otherModels)):?>
		<section class="all-models">
			<h2 class="section-name_2">Other <?=$modelYear['year']?> <?=$make['title']?> models</h2>
			<div class="model__block-box model__block-box_all-models">
			<?php foreach ($otherModels as $otherModel):?>	
				<a href="/horsepower/<?=$make['alias']?>/<?=$otherModel['model_alias']?>/<?=$otherModel['year']?>/" class="model__block model__block_all-models" title="<?=$otherModel['year']?> <?=$make['title']?> <?=$otherModel['model']?> horsepower">
					<img src="<?=$otherModel['photo']?>">
					<div class="model__block-name"><h3><?=$otherModel['year']?> <?=$make['title']?> <?=$otherModel['model']?></h3></div>
					<?php $rangeHp = AutoModelYear::getRangeHp($otherModel['id']);?>
					<?php if (!empty($rangeHp)):?>
					<span class="model__block-cost">
						<?=$rangeHp['min']?> 
						<?php if ($rangeHp['min'] != $rangeHp['max']):?> - <?=$rangeHp['max']?><?php endif;?> hp
					</span>
					<?php endif;?>	
				</a>
			<?php endforeach;?>
			</div>
		</section>
		<?php endif;?>
		
		<?php $this->renderPartial('application.views.site._reviews', array(
			'items' => ReviewVsModelYear::getTextModelYear(ReviewVsModelYear::MARKER_HP, $modelYear['id']),
		)); ?>		
		
	</div>
	<div class="l-col2">
		<section class="">
			<br>
			<?php $this->renderPartial('application.views.specs._right_model_year', array(
				'make'=>$make,
				'model'=>$model,
				'modelYear'=>$modelYear,
			))?>
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

		</section>
		
	</div>
</main>
