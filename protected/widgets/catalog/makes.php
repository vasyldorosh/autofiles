		<section class="all-makes">
				<h2 class="section-name">All makes</h2>
				<ul>
				<?php $key=1;foreach ($makes as $makeUrl=>$makeTitle):?>
					<li><a href="<?=$makeUrl?>"><?=$makeTitle?></a></li>
					<?php if ($key%7 ==0):?>
					</ul><ul>
					<?php endif;?>
				<?php $key++;endforeach;?>
				</ul>
		</section>