<?php $model->post_competitors = $model->getDataCompetitors();?>


    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        //'type' => 'horizontal',
        'id' => 'cityForm',
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),		
    ))?>


	<div class="control-group">
			<label class="control-label required" for="Contractor_post_competitors"><?php echo $model->getAttributeLabel('post_competitors')?></label>
			<div class="controls">
			<?php $this->widget('ext.chosen.Chosen',array(
				'model' => $model, 
				'attribute' => 'post_competitors', 
				'data' => AutoModelYear::getAll(),
				'multiple' => true,
				'itemUrl' => '/admin/modelYear/update?id=',
				'noResults' => Yii::t('admin', 'Not found'),
				'placeholderMultiple'=>$model->getAttributeLabel('post_competitors'),
				'htmlOptions'=>array(
					'style' => 'width:800px;'
				),		   
			));?>
			</div>
	</div>	

	<?php echo $form->dropDownListRow($model, 'model_id', AutoModel::getAllWithMake(),array('empty'=>''))?>
		
	<?php echo $form->textFieldRow($model, 'year')?>

	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'htmlOptions'=>array('name'=>'yt0'),
		'type'=>'success',
		'label'=>$model->isNewRecord ? Yii::t('admin', 'Add') : Yii::t('admin', 'Save'))); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'buttonType'=>'submit',
		'htmlOptions'=>array('name'=>'apply', 'class'=>'btn-apply'),
		'label'=>Yii::t('admin', 'Apply'))); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'reset',
		'htmlOptions'=>array('name'=>'yt1', 'class'=>'btn-cancel'),
		'label'=>Yii::t('admin', 'Cancel'))); ?>
	</div>	
	
	
    <?php $this->endWidget()?>

<style>
#page .tab-content {
	overflow: hidden;
}
</style>
