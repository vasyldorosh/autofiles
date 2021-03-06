<main>
	<div class="l-col1">
		<section class="years_box make">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> Curb Weight. Select the year</h2>
	
			<ul class="years_list">
			<?php foreach ($years as $yearItem):?>
				<li class="years_list_item"><a href="#<?=$yearItem['year']?>" class="btn years_list_link"><?=$yearItem['year']?></a></li>
			<?php endforeach;?>
			</ul>
	
		
		</section>
			
		<section class="times clearfix">

			<div class="google_links f_left p_rel">
				<?php $this->widget('application.widgets.BannerWidget', array('banner' => '336x280')); ?>	
			</div>
			<div class="text_size">
				<?=$header_text_block?>
			</div>
		
		</section>
		
	
	<?php if (!empty($lastYearCompletions)):?>	
	<section class="table-container">

					<a name="<?=$lastModelYear['year']?>"><img alt="Photo <?=$lastModelYear['year']?> <?= $make['title']?> <?= $model['title']?>" src="<?=$lastModelYear['photo']?>"></a>				
						
					<table>
					
						<tbody>
						<tr>
							<td class="model-year__trim-levels"><b><?=$lastModelYear['year']?> <?= $make['title']?> <?= $model['title']?> weight by trims </b></td>
							<td><b>Curb weight</b></td>
							<td><b>Gross weight</b></td>
						</tr>
						<?php foreach ($lastYearCompletions as $lastYearcompletion):?>
						<tr>
							<td class="model-year__trim-levels"><?= $lastYearcompletion['title']?></td>
							<td>
							<?php if (!empty($lastYearcompletion['specs_curb_weight'])):?>	
								<?= (int) $lastYearcompletion['specs_curb_weight']?> lbs. (<?= (int) ($lastYearcompletion['specs_curb_weight']*0.453592)?> kg)
							<?php else:?>
								&ndash;
							<?php endif;?>
							</td>
							<td>
							<?php if (!empty($lastYearcompletion['specs_gross_vehicle_weight_rating_gvwr_'])):?>	
								<?= (int)$lastYearcompletion['specs_gross_vehicle_weight_rating_gvwr_']?> lbs. (<?= (int) ($lastYearcompletion['specs_gross_vehicle_weight_rating_gvwr_']*0.453592)?> kg)
							<?php else:?>
								&ndash;
							<?php endif;?>							
							</td>
						</tr>
						<?php endforeach;?>
						</tbody>
					</table>
	</section>		
	<?php endif;?>	
			
	<?php if (!empty($competitors)):?>
	<section class="make">
			<h2 class="section-name_2">Competitors' weight</h2>
	  			<ul class="make__vehicle">
				<?php foreach ($competitors as $competitor):?>
				<li>
					<div class="make__vehicle-image">
						<a title="<?= $competitor['make']?> <?= $competitor['model']?> weight" href="/weight/<?= $competitor['make_alias']?>/<?= $competitor['model_alias']?>/">
							<img src="<?= $competitor['year']['photo_270']?>">
						</a>
					</div>
					<h3>
						<a href="/weight/<?= $competitor['make_alias']?>/<?= $competitor['model_alias']?>/"><?= $competitor['make']?>  <?= $competitor['model']?></a>
					</h3>

					<ul class="make__vehicle-specs">
					<?php if ($competitor['curb_weight']['mmax'] != $competitor['curb_weight']['mmin']):?>	
						<li>
							<?= $competitor['curb_weight']['mmin']?> &ndash; <?= $competitor['curb_weight']['mmax']?> lbs.
						</li>
						<li>
							<?= (int)($competitor['curb_weight']['mmin']*0.453592)?> &ndash; <?= (int)($competitor['curb_weight']['mmax']*0.453592)?> kg.
						</li>
					<?php else:?>
						<li>
							<?= $competitor['curb_weight']['mmin']?> lbs.
						</li>
						<li>
							<?= (int)($competitor['curb_weight']['mmin']*0.453592)?> kg.
						</li>

					<?php endif;?>
					</ul>
				</li>
			<?php endforeach;?>			
			</ul>
		</section>				
<?php endif;?>			


<?php $i=0;foreach ($otherYearsCompletions as $otherYearsCompletion):?>
			<section class="table-container">
				<?php if ($i++==0):?>
					<h2 class="section-name_2"><?= $make['title']?> <?= $model['title']?> models weight across years</h2>
				<?php endif;?>
				
				<a name="<?= $otherYearsCompletion['year']['year']?>"><img alt="Photo <?= $otherYearsCompletion['year']['year']?> <?= $make['title']?> <?= $model['title']?>" src="<?= $otherYearsCompletion['year']['photo']?>" width="150"></a>				
				
				<table>
					<tbody>
						<tr>
							<td class="model-year__trim-levels"><b><?= $otherYearsCompletion['year']['year']?> <?= $make['title']?> <?= $model['title']?> weight by trims </b></td>
							<td><b>Curb weight</b></td>
							<td><b>Gross weight</b></td>
						</tr>
						
						<?php foreach ($otherYearsCompletion['completions'] as $i=>$completion):?>
						<tr <?= ($i>4)?'class="js-completion-hide hide"':''?>>
							<td class="model-year__trim-levels"><?= $completion['title']?></td>
							<td class="model-year__cost">
							<?php if (!empty($completion['specs_curb_weight'])):?>	
								<?= (int)$completion['specs_curb_weight']?> lbs. (<?= (int) ($completion['specs_curb_weight']*0.453592)?> kg)
							<?php else:?>
								&ndash;
							<?php endif;?>
							</td>
							<td class="model-year__cost">
							<?php if (!empty($completion['specs_gross_vehicle_weight_rating_gvwr_'])):?>	
								<?= (int)$completion['specs_gross_vehicle_weight_rating_gvwr_']?> lbs. (<?= (int) ($completion['specs_gross_vehicle_weight_rating_gvwr_']*0.453592)?> kg)
							<?php else:?>
								&ndash;
							<?php endif;?>
							</td>
						</tr>
						<?php endforeach;?>
						
					</tbody>
				</table>
				
				<?php if (count($otherYearsCompletion['completions']) > 5):?>
				<br>
				<a href="#" class="link-completions-show-more">show more</a>
				<?php endif;?>
							
		</section>
	<?php endforeach;?>		

	<br><br>		
	<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'horizontal')); ?>

</div>
	
	
	<div class="l-col2">
		<br>		
		<?php $this->renderPartial('application.views.specs._right_model', array(
			'make'=>$make,
			'model'=>$model,
			'lastModelYear'=>$lastModelYear,
		))?>
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

	</div>

</main>


<style>
.hide {display: none;}
</style>
<script src="/js/lib/jquery.js"></script>	
<script>
$('.link-completions-show-more').click(function(e){
	e.preventDefault();
	if ($(this).text() == 'show more') {
		$('.js-completion-hide', $(this).closest('section')).removeClass('hide');
		$(this).text('show less');
	} else {
		$('.js-completion-hide', $(this).closest('section')).addClass('hide');
		$(this).text('show more');	
	}
})
</script>
