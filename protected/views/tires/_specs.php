			<table class="right-block__specs-list">
				<tbody>

					<tr>
						<td>
							<span>Section Width<br>Soon to be explained.</span>
						</td>
						<td class="spec-value">
							<?=$tire['section_width']?> mm
						</td>
					</tr>

					<tr>
						<td>
							<span>Rim Diameter</span>
						</td>
						<td class="spec-value">
							<a href="/tires/r<?=$tire['rim_diameter']?>.html"><?=$tire['rim_diameter']?>"</a>
						</td>
					</tr>

					<?php $rimWidth = TireRimWidth::getRangeWidth($tire['section_width']);?>
					<?php if (!empty($rimWidth)):?>
					<tr>
						<td>
							<span>Rim Width Range</span>
						</td>
						<td class="spec-value">
						<?php $rimWidthRange=array(); for($v=$rimWidth['min'];$v<=$rimWidth['max']; $v=$v+0.5):
							$dw = $tire['rim_diameter'] . 'x' . $v;
							$title = str_replace(array('[diametr]', '[width]'), array($tire['rim_diameter'], $v), SiteConfig::getInstance()->getValue('seo_wheels_diametr_width_title'));
							$rimWidthRange[] = sprintf('<a href="/wheels/%s/" title="%s">%s</a>', $dw, $title, $dw);
						endfor;?>
						<?= implode(', ', $rimWidthRange)?>
						</td>
					</tr>					
					<?php endif;?>					
					
					<?php $overallDiameter = Tire::diameter($tire);?>
					<tr>
						<td>
							<span>Overall Diameter</span>
						</td>
						<td class="spec-value">
							<?=$overallDiameter?>"
						</td>
					</tr>	
					
					<?php $sidewallHeight = Tire::sidewallHeight($tire)?>
					<tr>
						<td>
							<span>Sidewall Height</span>
						</td>
						<td class="spec-value">
							<?=$sidewallHeight?>"
						</td>
					</tr>
						
					<?php $circumference = Tire::circumference($overallDiameter)?>	
					<tr>
						<td>
							<span>Circumference</span>
						</td>
						<td class="spec-value">
							<?=$circumference?> "
						</td>
					</tr>

					<tr>
						<td>
							<span>Revs per Mile</span>
						</td>
						<td class="spec-value">
							<?=Tire::revsPerMile($circumference)?>/mi
						</td>
					</tr>

				</tbody>
			</table>