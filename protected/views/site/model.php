<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="model">
			<h1 class="section-name_2"><?=$make['title']?> <?=$model['title']?> vehicles</h1>
			<p class="model__about">
				<?=$model['description']?>
			</p>
			
			<h2><a title="<?=$completion['year']?> <?=$make['title']?> <?=$model['title']?>" href="<?=$model['url']?><?=$completion['year']?>/"><?=$completion['year']?> <?=$make['title']?> <?=$model['title']?></a></h2>
			
			<div class="model__specs">
				<div class="model__specs-image">
				<?php if (isset($lastModelYear['photo'])):?>
				<a href="<?=$model['url']?><?=$completion['year']?>/"><img alt="Photo <?=$completion['year']?> <?=$make['title']?> <?=$model['title']?>" src="<?=$lastModelYear['photo']?>"></a></div>
				<?php endif;?>
				<?php $this->renderPartial('_model_specs', array('completion'=>$completion))?>
			</div>		
			<?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
			<div>
			<?php foreach ($modelByYears as $modelByYear): if ($lastModelYear['year'] == $modelByYear['year']) {continue;}?>
				<a title="<?=$modelByYear['year']?> <?=$make['title']?> <?=$model['title']?>" href="<?=$model['url']?><?=$modelByYear['year']?>/" class="model__block"><span><?=$modelByYear['year']?></span><img src="<?=$modelByYear['photo']?>"></a>
			<?php endforeach;?>	
			</div>
<br><br>
		</section>
		<!-- section 2 -->
		<!--<section class="all-models">
			<h2 class="section-name">All <?=$make['title']?> models</h2>
			<p><strong><?=$make['title']?>:</strong>
			<?php foreach ($models as $item):?>
				<a title="<?=$make['title']?> <?=$item['title']?>" href="<?=$item['url']?>"><?=$item['title']?></a>,
			<?php endforeach;?>
			</p>
		</section>-->
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		
		
		<?php $this->renderPartial('application.views.specs._right_model', array(
			'lastModelYear'=>$lastModelYear,
			'make'=>$make,
			'model'=>$model,
		))?>			
		
<iframe src="//z-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetAdHtml&ID=OneJS&OneJS=1&banner_type=setandforget&campaigns=holsetforget2016&placement=assoc_banner_placement_default&region=US&marketplace=amazon&ad_type=banner&height=250&width=300&f=ifr&linkID=7b34fae1f68b86837e762f842102820a&t=auto036-20&tracking_id=auto036-20" width="300" height="250" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
		
	</div>
</main>