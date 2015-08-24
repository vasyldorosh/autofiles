<main>
	<div class="l-col1">
		<section class="years_box make">
			<h2 class="section-name_2"><?=$make['title']?> <?=$model['title']?> wheel bolt pattern. Select the year</h2>
			<ul class="years_list">
			<?php foreach ($wheelsDataItems as $wheelsDataItem):?>
				<?php foreach ($wheelsDataItem['years'] as $y):?>
					<li class="years_list_item"><a href="#<?=$y?>" class="btn years_list_link"><?=$y?></a></li>
				<?php endforeach;?>
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
		
		<?php foreach ($wheelsDataItems as $wheelsDataItem):?>
		<section class="table-container">
			<a name="2015"></a><img src="http://autofiles.com/photos/model_year_item/150/honda-accord-2015.jpg"><h4 class="title_tire"><?=$make['title']?> <?=$model['title']?> wheels</h4>  
			<?php foreach ($wheelsDataItem['years'] as $y):?>
			<a name="<?=$y?>" style="color:#000;"><small><?=$y?></small></a>
			<?php endforeach;?>
			
			<table>
			<tbody>
				<?php if (!empty($wheelsDataItem['bolt_pattern'])):?>
				<tr>
					<td>Bolt pattern</td>
					<td><?=$wheelsDataItem['bolt_pattern']?></td>
					
				</tr>
				<?php endif;?>
				<tr>
					<td>Stock wheel offset</td>
					<td>35 to 50 mm</td>
				</tr>
				<tr>
					<td>Custom offset range</td>
					<td><a href="/tuning/honda/accord/">10 to 45 mm</a></td>
					
				</tr>

				<?php if (!empty($wheelsDataItem['center_bore'])):?>
				<tr>
					<td>Center bore</td>
					<td><?=$wheelsDataItem['center_bore']?></td>
				</tr>
				<?php endif;?>	
				
				<?php if (!empty($wheelsDataItem['thread_size'])):?>
				<tr>
					<td>Thread size</td>
					<td><?=$wheelsDataItem['thread_size']?></td>					
				</tr>
				<?php endif;?>				
				
				<tr>
					<td>Stock rim sizes range</td>
					<td><?=$wheelsDataItem['tire_rim_diameter_from']?>x<?=$wheelsDataItem['rim_width_from']?> &ndash; <?=$wheelsDataItem['tire_rim_diameter_to']?>x<?=$wheelsDataItem['rim_width_to']?></td>					
				</tr>
				
				<?php if (!empty($wheelsDataItem['custom_rim_sizes_range'])):?>
				<tr>
					<td>Custom rim sizes range</td>
					<td><a href="/tuning/<?=$make['alias']?>/<?=$model['alias']?>/"><?=$wheelsDataItem['custom_rim_sizes_range']?></a></td>
				</tr>
				<?php endif;?>	
					
				<tr>
					<td>Tire sizes</td>
					<td><a href="/tires/honda/accord/">205/70 R15 &ndash; 245/35 R20</a></td>
					
				</tr>
				
			</tbody>
			</table>
		</section>
 
		<section class="table-container">
			<h4 class="title_tire"><a name="r17"></a>Custom rim sizes for a Honda Accord 2011-2015</h4>
			<table>
				<tbody>
					<tr>
						<td><b>Rim size</b></td>
						<td><b>Offset</b></td>
						<td><b>Projects</b></td>
						
					</tr>
					<tr>
						<td><a href="/wheels/honda/accord/17x7.0/">17x7.0</a></td>
						<td>25-34</td>
						<td><a href="/tuning/honda/accord/">7</a></td>
					</tr>
					<tr>
						<td><a href="/wheels/honda/accord/17x7.5/">17x7.5</a></td>
						<td>16-40</td>
						<td><a href="/tuning/honda/accord/">4</a></td>
					</tr>
					<tr>
						<td><a href="/wheels/honda/accord/17x8.0/">17x8.0</a> <small>(popular)</small></td>
						<td>28-33</td>
						<td><a href="/tuning/honda/accord/">23</a></td>
					</tr>
					
					<tr>
						<td><a href="/wheels/honda/accord/17x9.0/">17x9.0</a></td>
						<td>36</td>
						<td><a href="/tuning/honda/accord/">1</a></td>
					</tr>
					
					<tr>
						<td><a href="/wheels/honda/accord/18x7.0/">18x7.0</a></td>
						<td>25-34</td>
						<td><a href="/tuning/honda/accord/">7</a></td>
					</tr>
					<tr>
						<td><a href="/wheels/honda/accord/18x7.5/">18x7.5</a></td>
						<td>16-40</td>
						<td><a href="/tuning/honda/accord/">4</a></td>
					</tr>
					
				</tbody>
			</table>
		</section>
		<?php endforeach;?>
		
<br><br>		
<hr>

	</div>
	<div class="l-col2">
		<?php $this->widget('application.widgets.BannerWidget', array('banner' => 'vertical')); ?>

		<?php $this->renderPartial('application.views.specs._right_model', array(
			'make'=>$make,
			'model'=>$model,
			'lastModelYear'=>$lastModelYear,
		))?>
	</div>
</main>