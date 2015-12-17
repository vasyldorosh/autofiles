<section class="right-block">
	<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> specs</h2>
	
	<?php if (isset($lastModelYear['photo_270'])):?>
	<a href="/<?=$make['alias']?>/<?=$model['alias']?>/" title="<?=$make['title']?> <?=$model['title']?> info ">
		<img src="<?=$lastModelYear['photo_270']?>">
	</a>
	<?php endif;?>
	
	<table class="right-block__specs-list">
					<tbody>
						<tr>
							<td>
								<a class="speed" title="<?=$make['title']?> <?=$model['title']?> 0-60 acceleration times, ¼ mile" href="/0-60-times/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> 0-60 times</a>
							</td>
						</tr>
						<tr>
							<td>
								<a class="horsepower" href="/horsepower/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> horsepower</a>
							</td>						
						</tr>						
						<tr>
							<td>
								<a class="dim" href="/dimensions/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> dimensions</a>
							</td>						
						</tr>
						<tr>
							<td>
								<a class="rim" href="/wheels/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> wheels</a>
							</td>						
						</tr>						
						<tr>
							<td>
								<a class="tire" href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> tire size</a>
							</td>						
						</tr>
						<tr>
							<td>
								<a title="Souped up <?=$make['title']?> <?=$model['title']?>, tuning" class="tuning" href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$model['title']?> tuning</a>
							</td>
						</tr>						
					</tbody>
	</table>
	
  
</section>				