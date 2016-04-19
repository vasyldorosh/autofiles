	<div class="l-col1">
		<!-- section 1 -->
		
		<section class="times clearfix">
			<h1 class="section-name_2">Car tuning and modifications</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=SiteConfig::getInstance()->getValue('tuning_header_text_block')?>
			</div>
		</section>
		
		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Custom cars by Makes</h2>
			<ul>
				<?php $key=1;foreach ($makes as $make):?>
					<li><a title="<?=$make['title']?> tuning" href="/tuning/<?=$make['alias']?>/"><?=$make['title']?> <?php if($make['projects']):?>(<?=$make['projects']?>)<?php endif;?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
			</ul>														
		</section>
		
		<section class="make">
			<h2 class="section-name_2 mb30">Most popular car projects</h2>
			<ul class="make__vehicle">
			<?php foreach ($projects as $project):?>  
				<?php $this->renderPartial('application.views.tuning._item', array('project'=>$project));?>
			<?php endforeach;?>
			</ul>
			
			<br>
		</section>
	
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
	
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('tuning_footer_text_block')?>
		</section>	
		
		
		<section class="make">
			<h2 class="section-name_2 mb30">New car builds</h2>
			<ul class="make__vehicle">
			<?php foreach ($newProjects as $project):?>  
				<?php $this->renderPartial('application.views.tuning._item', array('project'=>$project));?>
			<?php endforeach;?>
			</ul>
			
			<br>
		</section>		
		
		<br clear="all">		
		
		
	</div>
	<div class="l-col2">
	
			<br>	
		<section class="right-block">				
			<?php $this->renderPartial('application.views.specs._right_index')?>		
		</section>	
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

	</div>