<main>
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?> tuning</h2>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
    </div>
	<div class="text_size">
		<?=$description?>
	</div>
</section>

<section class="make">
	<h2 class="section-name_2">Modified <?=$make['title']?> models</h2>

	<ul class="make__vehicle">
	<?php foreach ($models as $model):d($model);?>	
		<li>
			<?php $photo = Project::model()->getPhotoMostPopularModel($model['id'])?>
			<?php if (!empty($photo)):?>
			 <div class="make__vehicle-image">
				<a title="<?=$make['title']?> <?=$model['title']?> tuning" href="/tuning<?=$model['url']?>">
					<img alt="<?=$make['title']?> <?=$model['title']?> tuning" src="<?=$photo?>"> 
                </a>
			</div>			
			<?php endif;?>
			<h3>
				<a href="/tuning<?=$model['url']?>"><?=$make['title']?> <?=$model['title']?> tuning</a>
			</h3>
			<ul class="make__vehicle-specs">
				<li><?=$model['projects']?> projects</li>
			</ul>
					
		</li>
	<?php endforeach;?>
	</ul>

<br>

	<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
	
</section>

	
</div>

	<div class="l-col2">

		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

		<section class="right-block">
			<?php $this->renderPartial('application.views.specs._right_make', array('make'=>$make))?>
		</section>			
		
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

	</div>
</main>