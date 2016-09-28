<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="make">
			<h1 class="section-name_2"><?=$make['title']?> vehicles</h2>
			<div class="make__logo">
				<img src="<?=$make['photo']?>" alt="<?=$make['title']?> Logo">
			</div>
			<div class="make__history">
				<?=$make['description']?>
			</div>
			<ul class="make__vehicle">
			<?php foreach ($dataModels as $dataModel):?>
				<li>
				<div class="make__vehicle-image"><a title="<?=$make['title']?> <?=$dataModel['title']?>" href="<?=$dataModel['url']?>">
					<?php if (isset($dataModel['photo'])):?>
						<img src="<?=$dataModel['photo']?>"> 
					<?php endif;?>
				</a></div>
					<h2><a href="<?=$dataModel['url']?>"><?=$make['title']?> <?=$dataModel['title']?></a></h2>
					<ul class="make__vehicle-specs">
						<li>MSRP <?=HtmlHelper::price($dataModel['price']['min']);?>
							<?php if ($dataModel['price']['min'] != $dataModel['price']['max']):?>
								- <?=HtmlHelper::price($dataModel['price']['max']);?>
							<?php endif;?>
						</li>
						<li>Engine: <?=$dataModel['completion']['engine']?></li>
						<?php if (!empty($dataModel['completion']['fuel_economy_city']) && !empty($dataModel['completion']['fuel_economy_highway'])):?>
							<li>MPG: <?=$dataModel['completion']['fuel_economy_city']?> / <?=$dataModel['completion']['fuel_economy_highway']?></li>
						<?php endif;?>
						<?php if (!empty($dataModel['completion']['standard_seating'])):?>
							<li>Seating Capacity: <?=$dataModel['completion']['standard_seating']?></li>
						<?php endif;?>
					</ul>
					<ul class="make__vehicle-years">
					<?php foreach ($dataModel['years'] as $item):?>	
						<li><a title="<?=$item['year']?> <?=$make['title']?> <?=$dataModel['title']?>" href="<?=$dataModel['url']?><?=$item['year']?>/"><?=$item['year']?></a></li>
					<?php endforeach; ?>
					</ul>
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
		<iframe src="//z-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetAdHtml&ID=OneJS&OneJS=1&banner_type=setandforget&campaigns=holsetforget2016&placement=assoc_banner_placement_default&region=US&marketplace=amazon&ad_type=banner&height=250&width=300&f=ifr&linkID=7b34fae1f68b86837e762f842102820a&t=auto036-20&tracking_id=auto036-20" width="300" height="250" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
		
		
	</div>
</main>