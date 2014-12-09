<main class="l">
<div class="l-col1">
<!-- section 1 -->
<section class="times clearfix">
	<h2 class="section-name pb18"><?=$make['title']?> <?=$model['title']?> tire size</h2>
	<div class="google_links f_left p_rel">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => '300x250')); ?>	
	</div>
	<div class="text_size">
		<?=$header_text_block?>
	</div>
</section>
<section class="make">
	<h2 class="section-name_2">Search tire size by <?=$make['title']?> models</h2>
	<ul class="make__vehicle">
	<?php foreach ($modelByYears as $item):?>
		<li>
			<div class="make__vehicle-image">
				<a title="<?=$item['year']?> <?=$make['title']?> <?=$model['title']?> tire size" href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>">
					<img src="<?=$item['photo']?>">
				</a>
			</div>
			<h3>
				<a href="/tires/<?=$make['alias']?>/<?=$model['alias']?>/<?=$item['year']?>"><?=$item['year']?> <?=$make['title']?> <?=$model['title']?> tires</a>
			</h3>
			
			<?php $rangeTireSize = AutoModel::getMinMaxTireSizeYear($item['id']);?>
			<?php if (!empty($rangeTireSize)):?>
			<ul class="make__vehicle-specs">
				<li>
					<?=$rangeTireSize['min']?> 
					<?php if ($rangeTireSize['min'] != $rangeTireSize['max']):?> - <?=$rangeTireSize['max']?><?php endif;?>
				</li>
			</ul>
			<?php endif;?>
			
		</li>
	<?php endforeach;?>	
	</ul>
</section>

</div>
<div class="l-col2">

<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

<section class="right-block">
	<h2 class="section-name"><?=$make['title']?> <?=$model['title']?> specs</h2>
	<table class="right-block__specs-list">
					<tbody>
						<tr>
							<td>
								<a class="speed" title="<?=$make['title']?> <?=$model['title']?> 0-60 acceleration times, ¼ mile" href="/0-60-times/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$make['title']?> <?=$model['title']?> 0-60 times</a>
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

</div>
</main>