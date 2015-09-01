		<?php foreach ($projects as $project):?>
		<li>
			<div class="make__vehicle-image">
				<a title="<?=$project['make_title']?> RDX tire size" href="/tuning/<?=$project['make_alias']?>/<?=$project['model_alias']?>/1158/">
					<img alt="<?=$project['make_title']?> RDX tire size" src="<?=Project::thumb($project['id'], 300, 200, 'resize')?>"> 
                 </a>
			</div>	
			<h3>
				<a href="/tuning/<?=$project['make_alias']?>/<?=$project['model_alias']?>/1158/">2005 <?=$project['make_title']?> TL <?=$rim?></a>
			</h3>
			<ul class="make__vehicle-specs">
				<li>245/35 R17</li><li>17 views</li>
			</ul>
		</li>
		<?php endforeach;?>