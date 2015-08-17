<div class="control-group ">
	<label class="control-label required" for="Config_seo_wheels_title"><?=Yii::t('admin', 'Title')?></label>
	<div class="controls">
		<?php echo CHtml::textField('Config[seo_wheels_title]',isset($values['seo_wheels_title']) ? $values['seo_wheels_title'] : '', array('class'=>'span6'));?>
	</div>
</div>

<div class="control-group ">
	<label class="control-label required" for="Config_seo_wheels_meta_keywords"><?=Yii::t('admin', 'Meta Keywords')?></label>
	<div class="controls">
		<?php echo CHtml::textField('Config[seo_wheels_meta_keywords]',isset($values['seo_wheels_meta_keywords']) ? $values['seo_wheels_meta_keywords'] : '', array('class'=>'span6'));?>
	</div>
</div>

<div class="control-group ">
	<label class="control-label required" for="Config_seo_wheels_meta_description"><?=Yii::t('admin', 'Meta Description')?></label>
	<div class="controls">
		<?php echo CHtml::textArea('Config[seo_wheels_meta_description]',isset($values['seo_wheels_meta_description']) ? $values['seo_wheels_meta_description'] : '', array('class'=>'span6'));?>
	</div>
</div>

<div class="control-group ">
	<label class="control-label required" for="Config_wheels_header_text_block"><?=Yii::t('admin', 'Header Text Block')?></label>
	<div class="controls">
		<?php echo CHtml::textArea('Config[wheels_header_text_block]',isset($values['wheels_header_text_block']) ? $values['wheels_header_text_block'] : '', array('class'=>'ckeditor'));?>
	</div>
</div>

<div class="control-group ">
	<label class="control-label required" for="Config_wheels_footer_text_block"><?=Yii::t('admin', 'Footer Text Block')?></label>
	<div class="controls">
		<?php echo CHtml::textArea('Config[wheels_footer_text_block]',isset($values['wheels_footer_text_block']) ? $values['wheels_footer_text_block'] : '', array('class'=>'ckeditor'));?>
	</div>
</div>