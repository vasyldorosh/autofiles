<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h1 class="section-name_1">Car weight</h1>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=SiteConfig::getInstance()->getValue('weight_header_text_block')?>
			</div>
		</section>
		
		<section class="all-makes cars_ul bdb_1">
			<h2 class="section-name_2">Select make and model to view its curb weight</h2>
		
			<ul>
				<?php $key=1;foreach ($makes as $make):?>
					<li><a title="<?=$make['title']?> weight" href="/weight/<?=$make['alias']?>/"><?=$make['title']?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
			</ul>														
		
		</section>	

		<section class="product_photo_box make">
			<h2 class="section-name_2">5 easiest cars in our database</h2>
			<ul class="make__vehicle">
				
				<li>
					<div class="make__vehicle-image"><a title="Ferrari F12berlinetta weight" href="/weight/ferrari/f12berlinetta/"><img src="http://autotk.com/photos/model_year_item/150/ferrari-f12berlinetta-2013.jpg"></a></div>
					<h3><a title="Ferrari F12berlinetta weight" href="/weight/ferrari/f12berlinetta/">Ferrari F12berlinetta</a></h3>
					<h3>LT w/2LT 4dr Sedan</h3>
					<ul class="make__vehicle-specs">
											<li>Car weight 2998 lbs.</li>
							
						
					</ul>
				</li>
				
				<li>
					<div class="make__vehicle-image"><a title="Ferrari F12berlinetta weight" href="/weight/ferrari/f12berlinetta/"><img src="http://autotk.com/photos/model_year_item/150/ferrari-f12berlinetta-2013.jpg"></a></div>
					<h3><a title="Ferrari F12berlinetta weight" href="/weight/ferrari/f12berlinetta/">2013 Ferrari F12berlinetta</a></h3>
					<h3>LT w/2LT 4dr Sedan</h3>
					<ul class="make__vehicle-specs">
													<li>Car weight 2998 lbs.</li>
							
						
					</ul>
				</li>
				
				
			</ul>
		</section>
		
		
			<section class="product_photo_box make">
			<h2 class="section-name_2">5 heaviest cars in our database</h2>
			<ul class="make__vehicle">
				
				<li>
					<div class="make__vehicle-image"><a title="Ferrari F12berlinetta weight" href="/weight/ferrari/f12berlinetta/"><img src="http://autotk.com/photos/model_year_item/150/ferrari-f12berlinetta-2013.jpg"></a></div>
					<h3><a title="Ferrari F12berlinetta weight" href="/weight/ferrari/f12berlinetta/">Ferrari F12berlinetta</a></h3>
					<h3>LT w/2LT 4dr Sedan</h3>
					<ul class="make__vehicle-specs">
											<li>Car weight 2998 lbs.</li>
							
						
					</ul>
				</li>
				
				<li>
					<div class="make__vehicle-image"><a title="Ferrari F12berlinetta weight" href="/weight/ferrari/f12berlinetta/"><img src="http://autotk.com/photos/model_year_item/150/ferrari-f12berlinetta-2013.jpg"></a></div>
					<h3><a title="Ferrari F12berlinetta weight" href="/weight/ferrari/f12berlinetta/">2013 Ferrari F12berlinetta</a></h3>
					<h3>LT w/2LT 4dr Sedan</h3>
					<ul class="make__vehicle-specs">
													<li>Car weight 2998 lbs.</li>
							
						
					</ul>
				</li>
				
				
			</ul>
		</section>
		
		
		
		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('weight_footer_text_block')?>
		</section>
	</div>
	
	
	<div class="l-col2">
		
		<br>	
		
		<section class="right-block">				
			<?php $this->renderPartial('application.views.specs._right_index')?>		
		</section>	
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
	</div>
</main>