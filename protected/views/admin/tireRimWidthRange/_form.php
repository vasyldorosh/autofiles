<div>
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'type' => 'horizontal',
        'id' => 'cityForm',
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),		
    ))?>

		<?php echo $form->dropDownListRow($model, 'tire_id', Tire::model()->getList(), array('empty'=>'','class'=>'span6'))?>
		<?php echo $form->textFieldRow($model, 'from', array('class'=>'span6'))?>
		<?php echo $form->textFieldRow($model, 'to', array('class'=>'span2'))?>

		<?php $this->renderPartial('application.views.admin._form_actions', array('model'=>$model))?>
		
    <?php $this->endWidget()?>
</div>

