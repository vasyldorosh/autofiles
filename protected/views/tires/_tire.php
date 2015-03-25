				<?php $tireText = Tire::format($tire);?>
				<div class="product_photo_item">
					<div class="product_photo_item_top">
						<a href="<?=Tire::url($tire)?>" class="product_photo_name"><?=$tireText?></a>
						<ul class="make__vehicle-specs">
							<?php $tTire = $tire;
							if ($tire['is_rear']) {
								$tTire['section_width'] = $tire['rear_section_width'];
								$tTire['aspect_ratio'] = $tire['rear_aspect_ratio'];
								$tTire['rim_diameter'] = $tire['rear_rim_diameter'];
							}
							?>
							
							<li><a type="amzn" search="<?=Tire::format($tTire, false)?>" category="automotive">Buy on Amazon</a></li>
							<?php $rimWidth = TireRimWidth::getRangeWidth($tTire['section_width']);?>
							<?php if (!empty($rimWidth)):?>
							<li>Rim width <?=$rimWidth['min']?><?php if($rimWidth['min']!=$rimWidth['max']):?> - <?=$rimWidth['max']?><?php endif;?>"</li>
							<?php endif;?>
							<li>Diameter <?=Tire::diameter($tTire)?>"</li>
							<li>Sidewall height <?=Tire::sidewallHeight($tTire)?>"</li>
						</ul>
					</div>				
				</div>