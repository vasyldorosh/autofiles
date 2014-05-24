<div>
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'type' => 'horizontal',
        'id' => 'cityForm',
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),		
    ))?>
    <div class="form-actions">
		<?php echo $form->textFieldRow($model, 'title', array('class'=>'span6'))?>
		<?php echo $form->textFieldRow($model, 'rank', array('class'=>'span2'))?>
		
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $model->isNewRecord ? Yii::t('admin', 'Add') : Yii::t('admin', 'Save')))?>
    </div>
    <?php $this->endWidget()?>
</div>

<script>
<?=HtmlHelper::select($model, 'model_id', 'model_year_id', '/admin/modelYear/getByModel')?>
</script>

