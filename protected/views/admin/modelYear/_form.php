<div>
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'type' => 'horizontal',
        'id' => 'cityForm',
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),		
    ))?>
    <div class="form-actions">
        <?php echo $form->dropDownListRow($model, 'model_id', AutoModel::getAllWithMake(),array('empty'=>''))?>
		<?php echo $form->textFieldRow($model, 'year')?>

        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $model->isNewRecord ? Yii::t('admin', 'Add') : Yii::t('admin', 'Save')))?>
    </div>
    <?php $this->endWidget()?>
</div>
