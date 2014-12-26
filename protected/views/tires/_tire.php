				<?php $tireText = Tire::format($tire);?>
				<div class="product_photo_item">
					<div class="product_photo_item_top">
						<a href="<?=Tire::url($tire)?>" class="product_photo_name"><?=$tireText?></a>
						<ul class="make__vehicle-specs">
							<li><a type="amzn" search="<?=$tireText?>" category="automotive">Buy on Amazon</a></li>
							<?php $rimWidth = TireRimWidth::getRangeWidth($tire['section_width']);?>
							<?php if (!empty($rimWidth)):?>
							<li>Rim width <?=$rimWidth['min']?><?php if($rimWidth['min']!=$rimWidth['max']):?> - <?=$rimWidth['max']?><?php endif;?>"</li>
							<?php endif;?>
							<li>Diameter <?=Tire::diameter($tire)?>"</li>
							<li>Sidewall height <?=Tire::sidewallHeight($tire)?>"</li>
						</ul>
					</div>				
				</div>