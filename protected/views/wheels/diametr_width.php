<main>
	<div class="l-col1">
		<!-- section 1 -->
		<section class="times clearfix">
			<h2 class="section-name pb18"><?=$rim?> wheels tire size</h2>
			<div class="google_links f_left p_rel"><?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?></div>
			<div class="text_size"><?=$header_text_block?></div>
		</section>
		
		<?php if (!empty($possibleTireSizes)):?>
		<section class="table-container">
			<h4 class="title_tire">Possible tire sizes for a <?=$rim?> rim</h4>
			<table>
				<tbody>
					<tr>
						<td><b>Tire size</b></td>
						<td><b>Recom. width</b></td>
						<td><b>Projects</b></td>
						
					</tr>
					<?php foreach ($possibleTireSizes as $item):?>	
					<tr>
						<?php $tire = array(
							'section_width' => $item['tire_section_width'],
							'aspect_ratio' => $item['tire_aspect_ratio'],
							'vehicle_class' => $item['tire_vehicle_class'],
							'rim_diameter' => $diametr,
						);?>
						<td><a href="/wheels/<?=$rim?>/<?=Tire::url($tire)?>/"><?=Tire::format($tire)?></a></td>
						<td>7.0 - 8.0"</td>
						<td><?=$item['c']?></td>
					</tr>
					<?php endforeach;?>						
				</tbody>
			</table>
		</section>
		<?php endif;?>
		
	
	<section class="table-chart">
		<h4 class="title_tire">Recommended tire sizes that fit <?=$rim?> rim</h4>
		<br>
		<table>
			<tbody>
				<tr><td>%<br>Width</td><td>35</td><td>40</td><td>45</td><td>50</td><td>55</td><td>60</td><td>65</td><td>70</td><tr>
				<tr><td>185</td>
				
				<td style="cursor:pointer" onClick="document.location='#'"><a href="#">15</a></td>	
				<td></td><td></td><td></td><td></td><td></td><td></td><td></td><tr>
				<tr><td>195</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><tr>
				<tr><td>205</td><td></td><td bgcolor="#FFC37A" style="cursor:pointer" onClick="document.location='#'"><a href="#">27</a></td><td></td><td></td><td></td><td></td><td></td><td></td><tr>
				<tr><td>215</td><td></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td style="cursor:pointer" onClick="document.location='#'"><a href="#">8</a></td><td></td><td bgcolor="#FFC37A"></td><td></td><td></td><tr>
				<tr><td>225</td><td></td><td></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td></td><tr>
				<tr><td>235</td><td></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td></td><tr>
				<tr><td>245</td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td></td><td></td><td bgcolor="#FFC37A"></td><td></td><tr>
				<tr><td>255</td><td></td><td></td><td></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td></td><tr>
				<tr><td>265</td><td></td><td></td><td></td><td></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><tr>
				<tr><td>275</td><td></td><td></td><td></td><td></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td></td><td></td><tr>
				<tr><td>285</td><td></td><td></td><td></td><td></td><td></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><td bgcolor="#FFC37A"></td><tr>
				
			</tbody>
		</table><br>
		<p>Recommended tire sizes are marked with <font color="#FFC37A"><b>orange color</b></font>.</p>
		<p>Square boxes with numbers (<font color="#2fa4e7"><b>12</b></font>) stand for custom car projects. Click the number to browse them.</p>
	</section>
	
	<section class="make">
	<h4 class="title_tire">Modified cars with <?=$rim?> wheels</h4>
	<ul class="make__vehicle">	
		<li>
			<div class="make__vehicle-image">
				<a title="Acura RDX tire size" href="/tuning/honda/civic/1158/">
					<img alt="Acura RDX tire size" src="http://autofiles.com/photos/project/2067/11880/resize_w300_h200.jpg"> 
                 </a>
			</div>	
			<h3>
				<a href="/tuning/honda/civic/1158/">2005 Acura TL <?=$rim?></a>
			</h3>
			<ul class="make__vehicle-specs">
				<li>245/35 R17</li><li>17 views</li>
			</ul>
		</li>
		
		<li>
			<div class="make__vehicle-image">
				<a title="Acura ILX tire size" href="/tuning/honda/civic/1158/">
					<img alt="Acura ILX tire size" src="http://autofiles.com/photos/project/2066/11882/resize_w300_h200.jpg"> 
                </a>
			</div>	
			<h3>
				<a href="/tuning/honda/civic/1158/">2006 Acura TL <?=$rim?>, 18x10</a>
			</h3>
			
			<ul class="make__vehicle-specs">
				<li>215/40 R17, rear 225/40 R17</li><li>53 views</li>
			</ul>		
		</li>
		<li>
			<div class="make__vehicle-image">
				<a title="Acura RDX tire size" href="/tuning/honda/civic/1158/">
					<img alt="Acura RDX tire size" src="http://autofiles.com/photos/project/2067/11880/resize_w300_h200.jpg"> 
                 </a>
			</div>	
			<h3>
				<a href="/tuning/honda/civic/1158/">2005 Honda Accord <?=$rim?></a>
			</h3>
			<ul class="make__vehicle-specs">
				<li>245/35 R17</li><li>127 views</li>
			</ul>
		</li>
	</ul>
	<br>
	<p><a href="#">See all 168 car projects with</a> <?=$rim?> rims</p>
<br>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- autof_580_adapt -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3243264408777652"
     data-ad-slot="9538761250"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</section>


<section class="years_box make">
			<h2 class="section-name_2">Rims navigation</h2>
			<ul class="years_list">
							<li class="years_list_item"><a href="/tires/honda/accord/2015/" class="btn years_list_link" title="2015 Honda Accord tires">17x7.5 - Narrower rim</a></li>
							<li class="years_list_item"><a href="/tires/honda/accord/2013/" class="btn years_list_link" title="2013 Honda Accord tires"><?=$rim?>.5 - Wider rim</a></li>
							<li class="years_list_item"><a href="/tires/honda/accord/2013/" class="btn years_list_link" title="2013 Honda Accord tires">16x8.0 - Smaller rim</a></li>
							<li class="years_list_item"><a href="/tires/honda/accord/2012/" class="btn years_list_link" title="2012 Honda Accord tires">18x8.0 - Larger rim</a></li>
						</ul>
		</section>
	
	</div>
	
	<div class="l-col2">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>
	</div>
</main>