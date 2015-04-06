<div>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="model-year">
			<h2 class="section-name section-name_regular"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?></h2>
			<div class="model-year__box">
				<div class="model-year__box-left">
					<div class="model-year__image">
						<img alt="Photo <?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?>" src="<?=$modelYear['photo']?>">
					</div>
					
				
					<ul class="model-year__links">
						<li><a title="<?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> photos" href="<?=$model['url']?><?=$modelYear['year']?>/photos.html">Photos</a></li>
						
						<!--
						<li><a href="#">Wallpapers</a></li>
						<li><a href="#">Colors</a></li>
						-->
					</ul>
					
				</div>
				<div class="model-year__box-right">
				
					<?php $this->renderPartial('_model_specs', array('completion'=>$lastCompletion))?>
				
					<h3><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> trim levels</h3>
					<?php if (!empty($completions)):?>
					<table>
						<tbody>
						<?php foreach ($completions as $key=>$completion):?>
						<tr <?=($key>4)?'class="js-completion-hide"':''?>>
							<td class="model-year__trim-levels"><?=$modelYear['year']?> <?=$model['title']?> <?=$completion['title']?>, Engine: <?=AutoSpecsOption::getV('engine', $completion['specs_engine']);?></td>
							<td class="model-year__cost">MSRP $<?=$completion['specs_msrp']?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
					</table>
					<?php if (sizeof($completions) > 5):?>
					<a href="#" id="link-completions-show-more">show more</a>
					<?php endif;?>
					
				
					<?php else:?>
						<p>Trims not found</p>
					<?php endif;?>

					<ul class="model-year__years">
						<?php foreach ($modelYears as $item):?>
							<li <?=($modelYear['year']==$item['year'])?'class="is-active"':''?>><a title="<?=$item['year']?> <?=$make['title']?> <?=$model['title']?>" href="<?=$model['url']?><?=$item['year']?>/"><?=$item['year']?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		</section>
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
		
		<section class="make">
			<div class="make__history">
				<?php $this->widget('application.widgets.CommonWidget', array('action'=>'spoiler', 'data'=>array('text'=>$modelYear['description'], 'class'=>'description'))); ?>
			</div>
		</section>
		
		<section class="parts">
			<h2 class="section-name_2"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> Parts &amp; Accessories on Amazon</h2>
		
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327565&rh=i%3Aautomotive%2Cn%3A15714131&tag=auto0a70-20&linkId=XQPA5UY34HTEUHIW"><img src="/img/Perffilter._V192201762_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327565&rh=i%3Aautomotive%2Cn%3A15714131&tag=auto0a70-20&linkId=XQPA5UY34HTEUHIW">Air Intakes &amp; Filters</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327800&rh=i%3Aautomotive%2Cn%3A15713821&tag=auto0a70-20&linkId=ARHZ6HUAHHZ3ONAO"><img src="/img/Perfexhaust._V192201762_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327800&rh=i%3Aautomotive%2Cn%3A15713821&tag=auto0a70-20&linkId=ARHZ6HUAHHZ3ONAO">Exhaust</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327864&rh=i%3Aautomotive%2Cn%3A2286884011&tag=auto0a70-20&linkId=6B5U7DGLISEWVHNS"><img src="/img/PerformanceChassis._V192201760_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327864&rh=i%3Aautomotive%2Cn%3A2286884011&tag=auto0a70-20&linkId=6B5U7DGLISEWVHNS">Suspension &amp; Chassis</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/mn/search/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327949&rh=i%3Aautomotive%2Cn%3A2286883011&tag=auto0a70-20&linkId=4RRLS7AW2OPT45XL"><img src="/img/PerformanceIgnition._V192201760_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/mn/search/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428327949&rh=i%3Aautomotive%2Cn%3A2286883011&tag=auto0a70-20&linkId=4RRLS7AW2OPT45XL">Ignition &amp; Electrical</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328048&rh=i%3Aautomotive%2Cn%3A15736321&tag=auto0a70-20&linkId=JYGBSO5SQ7IBN3V2"><img src="/img/LightingPerformanceOffRoad._V192201765_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328048&rh=i%3Aautomotive%2Cn%3A15736321&tag=auto0a70-20&linkId=JYGBSO5SQ7IBN3V2">Lighting</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328119&rh=i%3Aautomotive%2Cn%3A15710921&tag=auto0a70-20&linkId=SQNHVOLAJZR6VUJE"><img src="/img/Brake._V192201789_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328119&rh=i%3Aautomotive%2Cn%3A15710921&tag=auto0a70-20&linkId=SQNHVOLAJZR6VUJE">Brakes &amp; Brake Parts</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328173&rh=i%3Aautomotive%2Cn%3A15714351&tag=auto0a70-20&linkId=35D5WO2IVKBQ2DSQ"><img src="/img/PerformanceFuel._V192201767_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328173&rh=i%3Aautomotive%2Cn%3A15714351&tag=auto0a70-20&linkId=35D5WO2IVKBQ2DSQ">Fuel System</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328212&rh=i%3Aautomotive%2Cn%3A15712301&tag=auto0a70-20&linkId=JGOREEAMVZGAXK65"><img src="/img/EngineCooling._V192201762_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/s/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&qid=1428328212&rh=i%3Aautomotive%2Cn%3A15712301&tag=auto0a70-20&linkId=JGOREEAMVZGAXK65">Engine Cooling</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/b/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&node=15718791&pf_rd_i=B00EVQSX08&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=2040563602&pf_rd_r=142BC53VXET4PATT98DW&pf_rd_s=center-1&pf_rd_t=1601&tag=auto0a70-20&vehicleId=6&linkId=D6CFHIWVQL3O3JGM"><img src="/img/PerformanceOils._V192201760_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/b/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&node=15718791&pf_rd_i=B00EVQSX08&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=2040563602&pf_rd_r=142BC53VXET4PATT98DW&pf_rd_s=center-1&pf_rd_t=1601&tag=auto0a70-20&vehicleId=6&linkId=D6CFHIWVQL3O3JGM">Oil &amp; Lubricants</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
			<div class="parts__block">
				<div class="parts__image">
					<a rel="nofollow" href="http://www.amazon.com/b/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&node=15737011&pf_rd_i=B00EVQSX08&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=2040563602&pf_rd_r=142BC53VXET4PATT98DW&pf_rd_s=center-1&pf_rd_t=1601&tag=auto0a70-20&vehicleId=6&linkId=KPSIPO327YEAF2CB"><img src="/img/PerformanceAccessories._V192201766_.jpg"</a>
				</div>
				<h2><a rel="nofollow" target="_blank" href="http://www.amazon.com/b/?_encoding=UTF8&camp=1789&creative=390957&linkCode=ur2&node=15737011&pf_rd_i=B00EVQSX08&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=2040563602&pf_rd_r=142BC53VXET4PATT98DW&pf_rd_s=center-1&pf_rd_t=1601&tag=auto0a70-20&vehicleId=6&linkId=KPSIPO327YEAF2CB">Tuning Accessories</a><img src="https://ir-na.amazon-adsystem.com/e/ir?t=auto0a70-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" /></h2>
			</div>
		</section>
		
		<?php if (!empty($competitors)):?>
		<section class="make make_competitors">
			<h2 class="section-name section-name_regular"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> competitors</h2>
			<ul class="make__vehicle">
			<?php foreach ($competitors as $item):?>
				<li>
					<div class="make__vehicle-image"><a title="<?=$item['year']?> <?=$item['make']?> <?=$item['model']?>" href="/<?=$item['make_alias']?>/<?=$item['model_alias']?>/<?=$item['year']?>/"><img alt="Photo <?=$item['year']?> <?=$item['make']?> <?=$item['model']?>" src="<?=$item['photo']?>"></a></div>
					<h3><a href="/<?=$item['make_alias']?>/<?=$item['model_alias']?>/<?=$item['year']?>/"><?=$item['year']?> <?=$item['make']?> <?=$item['model']?></a></h3>
					<ul class="make__vehicle-specs">
						<li>MSRP <?=HtmlHelper::price($item['price']['min']);?>
							<?php if ($item['price']['min'] != $item['price']['max']):?>
								- <?=HtmlHelper::price($item['price']['max']);?>
							<?php endif;?>
						</li>
						<li>Engine: <?=$item['completion']['engine']?></li>
						<?php if (!empty($item['completion']['fuel_economy_city']) && !empty($item['completion']['fuel_economy_highway'])):?>
							<li>MPG: <?=$item['completion']['fuel_economy_city']?> / <?=$item['completion']['fuel_economy_highway']?></li>
						<?php endif;?>
						<?php if (!empty($item['completion']['standard_seating'])):?>
							<li>Seating Capacity: <?=$item['completion']['standard_seating']?></li>
						<?php endif;?>
					</ul>
					<!--<a href="#" class="compare">Compare</a>-->
					
				</li>
			<?php endforeach;?>	
			</ul>
		</section>
		<?php endif;?>
	
		<section class="all-models">
			<h2 class="section-name section-name_regular">Other <?=$modelYear['year']?> <?=$make['title']?> models</h2>
			<div class="model__block-box model__block-box_all-models">
			<?php foreach ($models as $item):?>
				<div class="model__block model__block_all-models">
				<a title="<?=$item['year']?> <?=$make['title']?> <?=$item['model']?>" href="/<?=$make['alias']?>/<?=$item['model_alias']?>/<?=$item['year']?>/">	
					<img alt="Photo <?=$item['year']?> <?=$make['title']?> <?=$item['model']?>" src="<?=$item['photo']?>">
					<div class="model__block-name"><h3><?=$item['year']?> <?=$make['title']?> <?=$item['model']?></h3></div>
					<span class="model__block-cost">MSRP <?=HtmlHelper::price($item['price']['min'])?> - <?=HtmlHelper::price($item['price']['max'])?></span>
				</a>
				</div>
			<?php endforeach;?>	
			</div>
		</section>
		
		<!--
		<section class="reviews">
			<h2 class="section-name section-name_regular"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> reviews</h2>
			<ul class="reviews__tabs">
				<li data-block="#b1" class="is-active">
					<a href="javascript:;">Expert reviews</a>
				</li>
				<li data-block="#b2"><a href="javascript:;">Video reviews</a></li>
				<li data-block="#b3"><a href="javascript:;">Consumer reviews</a></li>
			</ul>
			<div id="b1" class="reviews__container active">
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<a href="#" class="btn btn_reviews">More reviews</a>
			</div>
			<div id="b2" class="reviews__container">
				<div class="reviews__block">
					
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<a href="#" class="btn btn_reviews">More reviews</a>
			</div>
			<div id="b3" class="reviews__container">
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
				</div>
				<div class="reviews__block">
					<div class="reviews__image">
						<a href="#"><img src="/img/reviews.jpg"></a>
					</div>
					<h3><a href="#">2014 Cadillac ELR</a></h3>
					<p>The concept that wowed crowds at the 2009
					Detroit auto show is now beautiful production
					car.</p>
				</div>
				<a href="#" class="btn btn_reviews">More reviews</a>
			</div>
		</section>
		-->
		
		<!--
		<section class="write-review">
			<p class="section-name section-name_regular">Write your review about <?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?></p>
			<form action="">
				<div class="write-review__text"><textarea name="" id="" rows="6" placeholder="Add a review"></textarea></div>
				<div class="write-review__col">
					<div class="write-review__checkbox"><input name="notify" type="checkbox" checked=""> Notify me of follow-up comments</div>
					<div class="write-review__user-name"><span><i></i></span><input type="text" placeholder="Your Name"></div>
					<div class="write-review__user-email"><span><i></i></span><input type="text" placeholder="Email">
					<div class="write-review__captcha">
						<div class="write-review__captcha-image"><img src="/img/captcha.png"></div>
						<div class="write-review__captcha-input"><input type="text"></div>
					</div>
					<a class="write-review__captcha-reload" href="#">Try another image?</a>
					<button type="submit" class="btn btn_submit">Submit</button>
				</div>
			
		</div></form></section>
		-->
		
	</div>
	<div class="l-col2">
		
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
		
		<?php $this->renderPartial('application.views.specs._right_model_year', array(
			'make'=>$make,
			'model'=>$model,
			'modelYear'=>$modelYear,
		))?>
		
		<!--
		<section class="right-block">
			<h2 class="section-name">Acura wallpapers</h2>
			<ul class="right-block__wallpaper-list">
				<li><a href="#"></a></li>
				<li><a href="#">2015 Citroen DS3</a></li>
				<li><a href="#">2015 Citroen DS3 Cabrio</a></li>
				<li><a href="#">2015 Audi S7 Sportback</a></li>
				<li><a href="#">2015 Audi A7 Sportback</a></li>
				<li><a href="#">2015 GMC Sierra All Terrain</a></li>
				<li><a href="#">2015 Mercedes-Benz C-Class Estate</a></li>
				<li><a href="#">2014 Seat Ibiza Cupster Concept</a></li>
				<li><a href="#">2014 Nissan X-Trail</a></li>
				<li><a href="#">2015 Nissan Juke</a></li>
				<li><a href="#">2015 Nissan Pulsar</a></li>
			</ul>
		</section>
		-->
		
		
	</div>
</div>

<style>
.js-completion-hide {display: none;}
</style>

<script>
$('#link-completions-show-more').click(function(e){
	e.preventDefault();
	if ($(this).text() == 'show more') {
		$('.js-completion-hide').show();
		$(this).text('show less');
	} else {
		$('.js-completion-hide').hide();
		$(this).text('show more');	
	}
})
</script>