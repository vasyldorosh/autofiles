<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h2 class="section-name pb18"><?=$section_width?>/<?=$aspect_ratio?> on <?=$rim?> rim</h2>
			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		</section>
			
		<h4 class="title_tire">Will a <?=$tireTitle?> tire fit <?=$rim?> rim?</h4><br>
		<p><?=$answer?></p>

		<section class="table-container">
			<table>
			<tbody>
				<tr>
					<td>Rim width</td>
					<td><?=(int)(25.4*$width)?> mm</td>
				</tr>
				<tr>
					<td>Tire width</td>
					<td><?=$section_width?> mm</td>
				</tr>
				
				<tr>
					<td>Aspect ratio</td>
					<td><?=$aspect_ratio?>%</td>
					
				</tr>
				<tr>
					<td>Rim diameter</td>
					<td>R<?=$rim_diameter?></td>
					
				</tr>
				<?php if (!empty($range['front'])):?>
				<tr>
					<td>Recommended rim width</td>
					<td><?=$range['front']['from']?> - <?=$range['front']['to']?></td>
				</tr>
				<?php endif;?>
				<?php $popularTireSizes = Project::getMostPopularTireSizesRim($diametr_id, $width_id);?>
				<?php if (!empty($popularTireSizes)):?>
				<tr>
					<td>Popular tire sizes for a <?=$rim?> rim</td>
					<td>
					<?php $items = array();
					foreach ($popularTireSizes as $size) {
						$itemTitle = Tire::format(array(
							'section_width' => $size['tire_section_width'],
							'aspect_ratio' 	=> $size['tire_aspect_ratio'],
							'rim_diameter' 	=> $size['rim_diameter'],
							'vehicle_class'	=> $size['tire_vehicle_class'],
						), true);
							
						if ($size['is_staggered_tires']) {
							$itemTitle.= '&ndash;' . Tire::format(array(
								'section_width' => $size['rear_tire_section_width'],
								'aspect_ratio' 	=> $size['rear_tire_aspect_ratio'],
								'rim_diameter' 	=> $size['rear_rim_diameter'],
								'vehicle_class'	=> $size['rear_tire_vehicle_class'],
							), true);
						}
							
						$itemUrl = Tire::url(array(
							'section_width' => $size['tire_section_width'],
							'aspect_ratio' 	=> $size['tire_aspect_ratio'],
							'rim_diameter' 	=> $size['rim_diameter'],
							'vehicle_class'	=> $size['tire_vehicle_class'],
						));
						
						$items[] = '<a href="'.$itemUrl.'"><nobr>'.$itemTitle.'</nobr></a>';
					}
					?>
					<?=implode(', ', $items)?>
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<td>Popular rim widths for a <nobr><?=$tireTitle?></nobr> tire size</td>
					<td><a href="#">17x7.5</a>, <a href="#"><?=$rim?></a>, <a href="#"><?=$rim?>.5</a></td>
				</tr>
			</tbody>
			</table>
			
		</section>
	
	<br>

			<section class="make">
			<h2 class="section-name_2">See how a tire <?=$tireTitle?> looks on <?=$rim?>.0 rim</h2>
	<ul class="make__vehicle" id="list_update">	
						  <li class="js-scrolling-ajax-item">
									<div class="make__vehicle-image">
					<a title="2005 Toyota Corolla project" href="/tuning/toyota/corolla/736/"><img src="http://autofiles.com/photos/project/736/5065/resize_w300_h200.jpg"></a>
					</div>
					
					<h3><a title="2005 Toyota Corolla project" href="/tuning/toyota/corolla/736/">2005 Toyota Corolla</a></h3>
					<ul class="make__vehicle-specs">
						<li><?=$tireTitle?> on <?=$rim?>.0 rim</li>
												<li>36 views</li>
					</ul>
				</li>		
			  <li class="js-scrolling-ajax-item">
									<div class="make__vehicle-image">
					<a title="1986 Toyota Corolla project" href="/tuning/toyota/corolla/382/"><img src="http://autofiles.com/photos/project/382/2410/resize_w300_h200.jpg"></a>
					</div>
					
					<h3><a title="1986 Toyota Corolla project" href="/tuning/toyota/corolla/382/">1986 Toyota Corolla</a></h3>
					<ul class="make__vehicle-specs">
						<li><?=$tireTitle?> on <?=$rim?>.0 rim</li>
													
												<li>24 views</li>
					</ul>
				</li>				
			</ul>
	
	<br>
<p><a href="#">See all car projects</a></p>
		   <div class="banner-ver">
		<script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- autof_728_adapt -->
                <ins class="adsbygoogle" style="display: block; height: 90px;" data-ad-client="ca-pub-3243264408777652" data-ad-slot="6724895651" data-ad-format="auto" data-adsbygoogle-status="done"><ins id="aswift_1_expand" style="display:inline-table;border:none;height:90px;margin:0;padding:0;position:relative;visibility:visible;width:845px;background-color:transparent"><ins id="aswift_1_anchor" style="display:block;border:none;height:90px;margin:0;padding:0;position:relative;visibility:visible;width:845px;background-color:transparent"><iframe width="845" height="90" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no" allowfullscreen="true" onload="var i=this.id,s=window.google_iframe_oncopy,H=s&amp;&amp;s.handlers,h=H&amp;&amp;H[i],w=this.contentWindow,d;try{d=w.document}catch(e){}if(h&amp;&amp;d&amp;&amp;(!d.body||!d.body.firstChild)){if(h.call){setTimeout(h,0)}else if(h.match){try{h=s.upd(h,i)}catch(e){}w.location.replace(h)}}" id="aswift_1" name="aswift_1" style="left:0;position:absolute;top:0;"></iframe></ins></ins></ins>
                <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
              </script>
          </div></section>
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