			<table class="right-block__specs-list">
				<tbody>

					<tr>
						<td>
							<span>Section Width</span>
						</td>
						<td class="spec-value">
							<?=$tire['section_width']?>"
						</td>
					</tr>

					<tr>
						<td>
							<span>Rim Diameter</span>
						</td>
						<td class="spec-value">
							<?=$tire['rim_diameter']?>"
						</td>
					</tr>

					<?php $rimWidth = TireRimWidth::getRangeWidth($tire['section_width']);?>
					<?php if (!empty($rimWidth)):?>
					<tr>
						<td>
							<span>Rim Width Range</span>
						</td>
						<td class="spec-value">
							<?=$rimWidth['min']?><?php if($rimWidth['min']!=$rimWidth['max']):?> - <?=$rimWidth['max']?><?php endif;?>""
						</td>
					</tr>					
					<?php endif;?>					
					
					<?php $overallDiameter = Tire::diameter($tire);?>
					<tr>
						<td>
							<span>Overall Daiameter</span>
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
							<?=$circumference?> cu.ft
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