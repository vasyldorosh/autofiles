<p class="help-block">used: [make] </p>

<div class="control-group ">
	<label class="control-label required" for="Config_seo_make_title"><?=Yii::t('admin', 'Title')?></label>
	<div class="controls">
		<?php echo CHtml::textField('Config[seo_make_title]',isset($values['seo_make_title']) ? $values['seo_make_title'] : '', array('class'=>'span6'));?>
	</div>
</div>

<div class="control-group ">
	<label class="control-label required" for="Config_seo_make_meta_keywords"><?=Yii::t('admin', 'Meta Keywords')?></label>
	<div class="controls">
		<?php echo CHtml::textField('Config[seo_make_meta_keywords]',isset($values['seo_make_meta_keywords']) ? $values['seo_make_meta_keywords'] : '', array('class'=>'span6'));?>
	</div>
</div>

<div class="control-group ">
	<label class="control-label required" for="Config_seo_make_meta_description"><?=Yii::t('admin', 'Meta Description')?></label>
	<div class="controls">
		<?php echo CHtml::textArea('Config[seo_make_meta_description]',isset($values['seo_make_meta_description']) ? $values['seo_make_meta_description'] : '', array('class'=>'span6'));?>
	</div>
</div>