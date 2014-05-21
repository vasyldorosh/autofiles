<div>
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'type' => 'horizontal',
        'id' => 'cityForm',
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),		
    ))?>
    <div class="form-actions">
        <?php echo $form->dropDownListRow($model, 'make_id', AutoMake::getAll(),array('empty'=>''))?>
		<?php echo $form->textFieldRow($model, 'title')?>
        <?php echo $form->textFieldRow($model, 'alias')?>
		<?php echo $form->fileFieldRow($model, 'file')?>
		<br/>
		
		<?php if (!$model->isNewRecord):?>
			<img id="image_preview" src="<?=$model->image_preview?>"/>
		<?php endif;?>
		<br>
		
		
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $model->isNewRecord ? Yii::t('admin', 'Add') : Yii::t('admin', 'Save')))?>
    </div>
    <?php $this->endWidget()?>
</div>
