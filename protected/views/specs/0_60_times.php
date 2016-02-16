<div>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times">
		<h2 class="section-name_2">0-60 times acceleration stats</h2>
			<div class="times__container">
				<div class="google_links f_left p_rel">
					<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
				</div>
				<div class="text_size">
					<?=SiteConfig::getInstance()->getValue('0_60_times_header_text_block');?>
				</div>
			</div>
		</section>
		
		<!-- section 2 -->
		<section class="all-makes">
			<h2 class="section-name_2">Browse by make and check your car's 0-60 times</h2>	
			<ul>
				<?php $key=1;foreach ($makes as $makeUrl=>$makeTitle):?>
					<li><a title="<?=$makeTitle?> 0-60 times" href="/0-60-times<?=$makeUrl?>"><?=$makeTitle?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
			</ul>		
		</section>
		<!-- section 3 -->
                <?php $this->widget('application.widgets.BannerWidget', array('banner' => '580x400')); ?>
		<section class="make make_fastest-cars">
			<h2 class="section-name_2">The fastest cars in our database</h2>
			<ul class="make__vehicle">
			<?php foreach ($fastests as $fastest):?>
				<li>
					<div class="make__vehicle-image"><a title="<?=$fastest['make_title']?> <?=$fastest['model_title']?> 0-60 times" href="/0-60-times/<?=$fastest['make_alias']?>/<?=$fastest['model_alias']?>/"><img src="<?=$fastest['photo']?>"></a></div>
					<h3><a title="<?=$fastest['make_title']?> <?=$fastest['model_title']?> 0-60 times" href="/0-60-times/<?=$fastest['make_alias']?>/<?=$fastest['model_alias']?>/"><?=$fastest['year']?> <?=$fastest['make_title']?> <?=$fastest['model_title']?></a><span class="acceleration-time">0-60 <?=$fastest['speed']?> sec.</span></h3>
					<ul class="make__vehicle-specs">
						<li>1/4 mile <?=$fastest['mile_time']?> @ <?=$fastest['mile_speed']?> mph</li>
						<li>Engine <?=$fastest['engine']?></li>
						<li><?=$fastest['horsepower']?> hp</li>
						<li><?=$fastest['torque']?> ft. lbs.</li>
					</ul>
				</li>
			<?php endforeach;?>
			</ul>
<br>
	<br><p class="section-name_2">0-60 times Hot Trends</p><br>
<p><a title="Nissan Gtr 0-60 times" href="http://autotk.com/0-60-times/nissan/gt-r/">Gtr</a> / 
<a title="Scion Frs 0-60 times" href="http://autotk.com/0-60-times/scion/fr-s/">Frs</a> / 
<a title="Nissan 370z 0-60 times" href="http://autotk.com/0-60-times/nissan/370z/">370z</a> / 
<a title="Audi S4 0-60 times" href="http://autotk.com/0-60-times/audi/s4/">S4</a> / 
<a title="Tesla Model s 0-60 times" href="http://autotk.com/0-60-times/tesla/model-s/">Model s</a> / 
<a title="Mustang Mustang 0-60 times" href="http://autotk.com/0-60-times/ford/mustang/">Mustang</a> / 
<a title="Chevy Camaro ss 0-60 times" href="http://autotk.com/0-60-times/chevrolet/camaro/">Camaro ss</a> / 
<a title="Subaru Wrx 0-60 times" href="http://autotk.com/0-60-times/subaru/wrx/">Wrx</a> / 
<a title="Audi R8 0-60 times" href="http://autotk.com/0-60-times/audi/r8/">R8</a> / 
<a title="Subaru Brz 0-60 times" href="http://autotk.com/0-60-times/subaru/brz/">Brz</a> / 
<a title="Nissan 350z 0-60 times" href="http://autotk.com/0-60-times/nissan/350z/">350z</a> / 
<a title="Bmw M3 0-60 times" href="http://autotk.com/0-60-times/bmw/m3/">M3</a> / 
<a title="Audi S5 0-60 times" href="http://autotk.com/0-60-times/audi/s5/">S5</a> / 
<a title="Audi S3 0-60 times" href="http://autotk.com/0-60-times/audi/s3/">S3</a> / 
<a title="Bmw M5 0-60 times" href="http://autotk.com/0-60-times/bmw/m5/">M5</a> / 
<a title="Audi A4 0-60 times" href="http://autotk.com/0-60-times/audi/a4/">A4</a> / 
<a title="Bmw 328i 0-60 times" href="http://autotk.com/0-60-times/bmw/328-gran-turismo/">328i</a> / 
<a title="Chevy Corvette z06 0-60 times" href="http://autotk.com/0-60-times/chevrolet/corvette/">Corvette z06</a> / 
<a title="Hyundai Genesis coupe 0-60 times" href="http://autotk.com/0-60-times/hyundai/genesis-coupe/">Genesis coupe</a> / 
<a title="Honda Civic si 0-60 times" href="http://autotk.com/0-60-times/honda/civic/">Civic si</a> / 
<a title="Dodge Charger 0-60 times" href="http://autotk.com/0-60-times/dodge/charger/">Charger</a> / 
<a title="Scion Tc 0-60 times" href="http://autotk.com/0-60-times/scion/tc/">Tc</a> / 
<a title="Ferrari 458 0-60 times" href="http://autotk.com/0-60-times/ferrari/458-italia/">458</a> / 
<a title="Dodge Viper 0-60 times" href="http://autotk.com/0-60-times/dodge/srt-viper/">Viper</a> / 
<a title="Cadillac Cts-v 0-60 times" href="http://autotk.com/0-60-times/cadillac/cts-v/">Cts-v</a> / 
<a title="Mazda Mazda6 0-60 times" href="http://autotk.com/0-60-times/mazda/mazda6/">Mazda6</a> / 
<a title="Audi S6 0-60 times" href="http://autotk.com/0-60-times/audi/s6/">S6</a> / 
<a title="Infiniti G37 0-60 times" href="http://autotk.com/0-60-times/infiniti/m37/">G37</a> / 
<a title="Hyundai Genesis 0-60 times" href="http://autotk.com/0-60-times/hyundai/genesis-coupe/">Genesis</a> / 
<a title="Dodge Challenger rt 0-60 times" href="http://autotk.com/0-60-times/dodge/challenger/">Challenger rt</a> / 
<a title="Lotus Elise 0-60 times" href="http://autotk.com/0-60-times/lotus/elise/">Elise</a> / 
<a title="Fiat 500 abarth 0-60 times" href="http://autotk.com/0-60-times/fiat/500/">500 abarth</a> / 
<a Bmw M6 0-60 times" href="http://autotk.com/0-60-times/bmw/m6-gran-coupe/">M6</a> / 
<a Bmw 550i 0-60 times" href="http://autotk.com/0-60-times/bmw/550/">550i</a> / 
<a Infiniti G35 0-60 times" href="http://autotk.com/0-60-times/infiniti/g35x/">G35</a> / 
<a Honda Accord 0-60 times" href="http://autotk.com/0-60-times/honda/accord/">Accord</a> / 
<a Ford Fiesta st 0-60 times" href="http://autotk.com/0-60-times/ford/fiesta/">Fiesta st</a> / 
<a Acura Tl 0-60 times" href="http://autotk.com/0-60-times/acura/tl/">Tl</a> / 
<a Jaguar F type 0-60 times" href="http://autotk.com/0-60-times/jaguar/f-type/">F type</a> / 
<a Audi A5 0-60 times" href="http://autotk.com/0-60-times/audi/a5/">A5</a> / 
<a Ford Fusion 0-60 times" href="http://autotk.com/0-60-times/ford/fusion-energi/">Fusion</a> / 
<a Audi S7 0-60 times" href="http://autotk.com/0-60-times/audi/s7/">S7</a> / 
<a Nissan Maxima 0-60 times" href="http://autotk.com/0-60-times/nissan/maxima/">Maxima</a>
</p>

		</section>
		<!-- section 4 -->

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>

		<section class="seo-text">
			<?=SiteConfig::getInstance()->getValue('0_60_times_footer_text_block');?>
		</section>
		
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<section class="right-block">				
			<?php $this->renderPartial('application.views.specs._right_index')?>		
		</section>		

	</div>
</div>