<?php $carSpecsAndDimensions = AutoModelYear::getCarSpecsAndDimensions($modelYear['id']);?>
			
			<section class="right-block w78">
				<h2 class="section-name"><?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> specs</h2>
		
				<a href="/<?=$make['alias']?>/<?=$model['alias']?>/<?=$modelYear['year']?>/" title="<?=$make['title']?> <?=$model['title']?> <?=$modelYear['year']?> info ">
					<img src="<?=$modelYear['photo']?>">
				</a>				
				
				<table class="right-block__specs-list">
					<tbody>
					
					<?php if (!empty($carSpecsAndDimensions['0_60_times']['mmin'])):?>
					<tr>
						<td><a class="speed" title="<?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> 0-60" href="/0-60-times/<?=$make['alias']?>/<?=$model['alias']?>/">0-60 times</a></td>
						<td class="spec-value">
						<?php if ($carSpecsAndDimensions['0_60_times']['mmin'] != $carSpecsAndDimensions['0_60_times']['mmax']):?>
							<?=(float)$carSpecsAndDimensions['0_60_times']['mmin']?> - <?=(float)$carSpecsAndDimensions['0_60_times']['mmax']?>
						<?php else:?>
							<?=(float)$carSpecsAndDimensions['0_60_times']['mmin']?>
						<?php endif;?>
						sec
						</td>
					</tr>
					<?php endif;?>
		
						
					
					<?php if (!empty($carSpecsAndDimensions['hp']['mmin'])):?>
					<tr>
						<td><a class="horsepower" href="/horsepower/<?=$make['alias']?>/<?=$model['alias']?>/<?=$modelYear['year']?>/">Horsepower</a></td>
						<td class="spec-value">
						<?php if ($carSpecsAndDimensions['hp']['mmin'] != $carSpecsAndDimensions['hp']['mmax']):?>
							<?=(float)$carSpecsAndDimensions['hp']['mmin']?> - <?=(float)$carSpecsAndDimensions['hp']['mmax']?>
						<?php else:?>
							<?=(float)$carSpecsAndDimensions['hp']['mmin']?>
						<?php endif;?>	
						hp</td>
					</tr>
					<?php endif;?>
					
					<tr>
						<td><a class="dim" title="<?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> dimensions" href="/dimensions/<?=$make['alias']?>/<?=$model['alias']?>/<?=$modelYear['year']?>/">Dimensions</a></td>
						<td class="spec-value">...</td>
					</tr>						
					
 
					<?php $rangeTireSize = AutoModel::getMinMaxTireSizeYear($modelYear['id']);?>
					<?php if (!empty($rangeTireSize)):?>
					<tr>
						<td><a class="tire" title="<?=$modelYear['year']?> <?=$make['title']?> <?=$model['title']?> Tire size" href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/<?=$modelYear['year']?>/">Tire size</a></td>
						<td class="spec-value">
							<?=$rangeTireSize['min']?> ...
						</td>
					</tr>
					<?php endif;?>	                  
					
					
				</tbody>
				</table>
   <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- autof_250 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3243264408777652"
     data-ad-slot="2242919653"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

			</section>