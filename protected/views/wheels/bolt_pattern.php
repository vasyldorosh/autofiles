<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h2 class="section-name pb18">Bolt pattern - PCD main</h2>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=SiteConfig::getInstance()->getValue('wheels_bolt_pattern_header_text_block')?>
			</div>
		</section>
			
		<h4 class="title_tire">The list of bolt patterns</h4><br>
		
		<section class="table-container">
			<table>
			<tbody>
				<tr>
					<td><b>Millimeters</b></td>
					<td><b>Inches</b></td>
					<td><b>Popularity</b></td>
				</tr>
				<?php foreach ($list as $item):?>
				<tr>
					<td><a href="/wheels/bolt-pattern/<?=$item['value']?>/"><?=$item['value']?></td>
					<td><?=$item['value_inches']?></td>
					<td><?=$item['percent']?>%</td>
				</tr>
				<?php endforeach;?>
			</tbody>
			</table>
			
		</section>
		
<section class="section_tabs">
				<section class="reviews">
					
					
					<script src="http://autofiles.com/js/lib/jquery.js"></script>	
					<div id="b1" class="reviews__container active vehickle">
						<div class="vehicle_div_img p_rel">
								  					</div>
						<h4 class="title_tire pt20">Find your car's bolt pattern:</h4>
												<div class="options">
							<div class="options__block">
										<div class="options__item">
									<strong>Year</strong>
									<select id="Filter_model_id">
										<option>-no select-</option>
									</select>
								</div>
								<div class="options__item">
									<strong>Make</strong>
									<select id="Filter_make_id">
										<option value="">-no select-</option>					
									</select>
								</div>
								<div class="options__item">
									<strong>Model</strong>
									<select id="Filter_model_id">
										<option>-no select-</option>
									</select>
								</div>
						
								
								<button style="display: none;" type="submit" class="btn btn_options" data-url="" id="btn_submit_filter_make">GO</button>
							</div>
							<br><h2>It's <a href="/wheels/bolt-pattern/4x100/">4x100</h2></a>
						</div>
					</div>
					
				</section>
			</section>
			
	</div>
	<div class="l-col2">
		<section class="">
			
					<div class="banner-ver">
		  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- autofiles300x600 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-3243264408777652"
     data-ad-slot="2443588454"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		</div>

		</section>

	</div>
</main>