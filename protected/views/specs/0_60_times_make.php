<main class="l">
	<div class="l-col1">
		<!-- section 1 -->
		<section class="make">
			<h2 class="section-name"><?=$make['title']?> 0-60 times</h2>
			<div class="make__history">
				<?=$make['description']?>
			</div>

		</section>

		<section class="table-container">
			<h2 class="section-name">All <?=$make['title']?> models 0-60 times</h2>
			<table>
			<?php foreach ($models as $model):?>
				<tr>
					<td><?=$make['title']?> <?=$model['title']?> 0-60</td>
					<td>
					<?php if ($model['0_60_times']['mmax'] == $model['0_60_times']['mmin']):?>
						<?=$model['0_60_times']['mmin']?>
					<?php else:?>
						<?=$model['0_60_times']['mmin']?> - <?=$model['0_60_times']['mmax']?>
					<?php endif;?>	
						sec
					</td>
					<td>1/4 mile <?=$model['mile_time']['min']?> @ <?=$model['mile_speed']['min']?> - <?=$model['mile_time']['max']?> @ <?=$model['mile_speed']['max']?></td>
				</tr>
			<?php endforeach;?>
			</table>
		</section>		
		
		
	</div>
	<div class="l-col2">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>		
	</div>
</main>