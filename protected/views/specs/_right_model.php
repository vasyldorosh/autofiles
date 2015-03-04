<section class="right-block">
	<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> specs</h2>
	
	<?php if (isset($lastModelYear)):?>
	<a href="/<?=$make['alias']?>/<?=$model['alias']?>/" title="<?=$make['title']?> <?=$model['title']?> info ">
		<img src="<?=$lastModelYear['photo_270']?>">
	</a>
	<?php endif;?>
	
	<table class="right-block__specs-list">
					<tbody>
						<tr>
							<td>
								<a class="speed" title="<?=$make['title']?> <?=$model['title']?> 0-60 acceleration times, ¼ mile" href="/0-60-times/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$make['title']?> <?=$model['title']?> 0-60 times</a>
							</td>
						</tr>
						<tr>
							<td>
								<a class="horsepower" href="/horsepower/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$make['title']?> <?=$model['title']?> horsepower</a>
							</td>						
						</tr>						
						<tr>
							<td>
								<a class="tire" href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$make['title']?> <?=$model['title']?> tires</a>
							</td>						
						</tr>
					</tbody>
	</table>
	

</section>				