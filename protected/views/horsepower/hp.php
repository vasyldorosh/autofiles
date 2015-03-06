<main class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times">
			<h2 class="section-name pb18"><?=$hp?> horsepower to watts conversion</h2>
		
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
			
			<br clear="all">
			<p>&nbsp;</p>
			<p>If you want to convert <b><?=$hp?> hp</b> to watts it will be <b><?=(int)($hp*0.746)?> kW</b>.</p>
					
		</section>
		
		<section class="make">
			<ul class="make__vehicle">
				<h2 class="section-name_2 mb30">Cars with <?=$hp?> hp, page <?=$page?></h2>
				
				<?php foreach ($modelYears as $modelYear):?>
				<li>
					<div class="make__vehicle-image">
						<a title="<?=$modelYear['model_year']?> <?=$modelYear['make_title']?> <?=$modelYear['model_title']?>" href="/horsepower/<?=$modelYear['make_alias']?>/<?=$modelYear['model_alias']?>/"><img src="<?=$modelYear['image']?>"></a>
					</div>
					<h3><a title="<?=$modelYear['model_year']?> <?=$modelYear['make_title']?> <?=$modelYear['model_title']?>" href="/<?=$modelYear['make_alias']?>/<?=$modelYear['model_alias']?>/<?=$modelYear['model_year']?>/"><?=$modelYear['model_year']?> <?=$modelYear['make_title']?> <?=$modelYear['model_title']?></a> <?=$modelYear['completion_title']?></h3>
					<ul class="make__vehicle-specs">
						<li>HP <a title="<?=$modelYear['model_year']?> <?=$modelYear['make_title']?> <?=$modelYear['model_title']?> <?=$hp?> hp" href="/horsepower/<?=$modelYear['make_alias']?>/<?=$modelYear['model_alias']?>/"><?=$modelYear['horsepower']?></a></li>
						<li>Torque <?=$modelYear['torque']?> lb.-ft.</a></li>
						<?php if (!empty($modelYear['0_60_mph'])):?>
							<li>0-60 times <a href="/0-60-times/<?=$modelYear['make_alias']?>/<?=$modelYear['model_alias']?>/" title="<?=$modelYear['model_year']?> <?=$modelYear['make_title']?> <?=$modelYear['model_title']?> 0-60 performance data"><?=$modelYear['0_60_mph']?> sec</a></li>
						<?php endif;?>
						<?php if (!empty($modelYear['mile_time']) || !empty($modelYear['mile_speed'])):?>
							<li>
								<?php if (!empty($modelYear['mile_time'])):?>1/4 mile <?=$modelYear['mile_time']?> sec @ <?php endif;?>
								<?php if (!empty($modelYear['mile_speed'])):?> <?=$modelYear['mile_speed']?> mph<?php endif;?>
							</li>
						<?php endif;?>							
						
						<?php if (isset($modelYear['engine'])):?>
						<li>Engine <?=$modelYear['engine']?></li>
						<?php endif;?>
						
						<?php if (!empty($modelYear['curb_weight'])):?>
							<li>Weight <?=(float)$modelYear['curb_weight']?> lbs.</a></li>
						<?php endif;?>						
						<?php if (!empty($modelYear['fuel_economy_city']) || !empty($modelYear['fuel_economy_highway'])):?>
							<li>MPG <?=$modelYear['fuel_economy_city']?><?php if(!empty($modelYear['fuel_economy_city']) && !empty($modelYear['fuel_economy_highway'])):?>/<?php endif;?><?=$modelYear['fuel_economy_highway']?></a></li>
						<?php endif;?>							
						
						<?php if (isset($modelYear['msrp'])):?>
						<li>Price <?=HtmlHelper::price($modelYear['msrp'])?></li>
						<?php endif;?>						
					</ul>
				</li>
				<?php endforeach;?>		
			</ul>
		</section>
				
			<?php if ($countPage > 1):?>	
			<section class="years_box make">
				<ul class="years_list">
				<?php for($i=1; $i<=$countPage; $i++):?>
					<li class="years_list_item <?=($i==$page)?'current':''?>"><a href="/horsepower/<?=$hp?>/<?php if($i>1):?><?=$i?>/<?php endif;?>" class="btn years_list_link" title="<?=$hp?> hp page <?=$i?>"><?=$i?></a></li>
				<?php endfor;?>
				</ul>
			</section>
			<?php endif;?>
		
		<div class="banner-ver">
			 <?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
		</div>	
       
		<br clear="all">		
		<section class="years_box make">
			<h2 class="section-name_2">Navigation</h2>
			<ul class="years_list">
				<?php foreach ($currentHps as $currentHp):?>
					<li class="years_list_item <?=($currentHp==$hp)?'current':''?> "><a href="/horsepower/<?=$currentHp?>/" class="btn years_list_link" title="<?=$currentHp?> hp cars"><?=$currentHp?> hp</a></li>
				<?php endforeach;?>
			</ul>
		</section>
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
	
	</div>
</main>