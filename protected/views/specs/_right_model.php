
<section class="right-block">
	<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> specs</h2>
	
	<?php if (isset($lastModelYear['photo_270'])):?>
	<a href="/<?=$make['alias']?>/<?=$model['alias']?>/" title="<?=$make['title']?> <?=$model['title']?> specs">
		<img src="<?=$lastModelYear['photo_270']?>">
	</a>
	<?php endif;?>
	
	<table class="right-block__specs-list">
					<tbody>
						<tr>
							<td>
								<a class="speed" title="<?=$make['title']?> <?=$model['title']?> 0-60 times, quarter mile" href="/0-60-times/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> 0-60 times</a>
							</td>
						</tr>
						<tr>
							<td>
								<a class="horsepower" title="<?=$make['title']?> <?=$model['title']?> horsepower" href="/horsepower/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> horsepower</a>
							</td>						
						</tr>						
						<tr>
							<td>
								<a class="dim" title="<?=$make['title']?> <?=$model['title']?> dimensions" href="/dimensions/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> dimensions</a>
							</td>						
						</tr>
						<tr>
							<td>
								<a class="rim" title="<?=$make['title']?> <?=$model['title']?> wheels bolt pattern" href="/wheels/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> wheels</a>
							</td>						
						</tr>						
						<tr>
							<td>
								<a class="tire" title="<?=$make['title']?> <?=$model['title']?> tire size" href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> tire size</a>
							</td>						
						</tr>
						<tr>
							<td>
								<a title="Custom <?=$make['title']?> <?=$model['title']?>, tuning" class="tuning" href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/">Custom <?=$model['title']?></a>
							</td>
						</tr>						
					</tbody>
	</table>
	
  
</section>				