<main>
	<div class="l-col1">
		<!-- section 1 -->
			<section class="times">
			<h2 class="section-name"><?=$make['title']?> 0-60 times</h2>
				<div class="times__container">
				<div class="google_links f_left p_rel">
					<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
				</div>
				<div class="text_size">
					<?=$description?>
				</div>
			</div>
		</section>

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>

		<section class="table-container">
			<h2 class="section-name_2">The fastest <?=$make['title']?> cars</h2>
			<table>
			<?php foreach ($models as $item):?>
				<tr>
					<td><a href="/0-60-times<?=$item['url']?>"> <?=$make['title']?> <?=$item['title']?> 0-60</a></td>
					<td>
					<?php if ($item['0_60_times']['mmax'] == $item['0_60_times']['mmin']):?>
						<?=$item['0_60_times']['mmin']?>
					<?php else:?>
						<?=$item['0_60_times']['mmin']?> - <?=$item['0_60_times']['mmax']?>
					<?php endif;?>	
						sec
					</td>
					<td>
						1/4 mile
						<?php if ($item['mile_time']['min'] == 0):?>
							-
						<?php else:?>
							<?php if ($item['mile_time']['min'] == $item['mile_time']['max']):?>
								<?=$item['mile_time']['min']?> @ <?=$item['mile_speed']['min']?> mph
							<?php else:?>
								<?=$item['mile_time']['min']?> @ <?=$item['mile_speed']['min']?> - <?=$item['mile_time']['max']?> @ <?=$item['mile_speed']['max']?> mph
							<?php endif;?>	
						<?php endif;?>
					</td>
				</tr>
			<?php endforeach;?>
			</table>
		</section>		

		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>
		
	</div>
	<div class="l-col2">	
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>		
		
		<section class="right-block">
			<?php $this->renderPartial('application.views.specs._right_make', array('make'=>$make))?>
		</section>	
		
	</div>
</main>