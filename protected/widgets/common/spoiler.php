			<?php $truncate = explode('[truncate]', $text)?>
			<div class="js-<?=$data['text']?>-0"><?=$truncate[0]?></div>
			<?php if (isset($truncate[1])):?>
				<div class="js-<?=$data['text']?>-1" style="display: none;"><?=$truncate[1]?></div>
				<div><a href="#" class="js-<?=$data['text']?>">show more</a></div>
				<script>
					$('.js-<?=$data['text']?>').click(function(e){
						e.preventDefault();
						if ($(this).text() == 'show more') {
							$('.js-<?=$data['text']?>-1').show();
							$(this).text('show less');
						} else {
							$('.js-<?=$data['text']?>-1').hide();
							$(this).text('show more');	
						}
					})				
				</script>
			<?php endif;?>