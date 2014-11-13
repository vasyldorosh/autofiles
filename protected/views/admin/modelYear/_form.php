<?php $model->post_competitors = $model->getDataCompetitors();?>


    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        //'type' => 'horizontal',
        'id' => 'cityForm',
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),		
    ))?>

	<?php if (!$model->isNewRecord):?>
	<div class="control-group">
			<label class="control-label required" for="AutoModelYear_post_competitors"><?php echo $model->getAttributeLabel('post_competitors')?></label>
			<div class="controls">
			<?php $this->widget('ext.chosen.Chosen',array(
				'model' => $model, 
				'attribute' => 'post_competitors', 
				'data' => AutoModelYear::getAllByYear($model->year),
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
	<?php endif;?>
	
	<div class="control-group">
		<?php $model->post_tires = $model->getPost_tires()?>
			<label class="control-label required" for="AutoModelYear_post_tires"><?php echo $model->getAttributeLabel('post_tires')?></label>
			<div class="controls">
			<?php $this->widget('ext.chosen.Chosen',array(
				'model' => $model, 
				'attribute' => 'post_tires', 
				'data' => Tire::getList(),
				'multiple' => true,
				'itemUrl' => '/admin/tire/update?id=',
				'noResults' => Yii::t('admin', 'Not found'),
				'placeholderMultiple'=>$model->getAttributeLabel('post_tires'),
				'htmlOptions'=>array(
					'style' => 'width:800px;'
				),		   
			));?>
			</div>
	</div>
	
	<?php if (!$model->isNewRecord):?>
	<div class="control-group">
		<?php $model->post_tires_related = $model->getPost_tires_related()?>
			<label class="control-label required">Copy to</label>
			<div class="controls" style="margin-left: 30px;">
			<?php foreach (AutoModelYear::getListYears($model->model_id) as $id=>$year): if($id==$model->id){continue;}?>
				<label><input type="checkbox" name="AutoModelYear[post_tires_related][]" value="<?=$id?>" <?=in_array($id, $model->post_tires_related)?'checked="checked"':''?>> <?=$year?></label>
			<?php endforeach;?>
			</div>
	</div>
	<?php endif;?>
	
	<?php echo $form->dropDownListRow($model, 'model_id', AutoModel::getAllWithMake(),array('empty'=>''))?>
		
	<?php echo $form->textFieldRow($model, 'year')?>
	
	<?php echo $form->dropDownListRow($model, 'chassis_id', AutoModelYearChassis::getList(),array('empty'=>''))?>
	
	<?php echo $form->fileFieldRow($model, 'file')?>
		
	<?php if (!$model->isNewRecord):?>
		<img id="image_preview" src="<?=$model->getThumb(100, 60, 'crop')?>"/>
	
		<?php echo $form->checkBoxRow($model, 'is_delete_photo')?><br/>
	<?php endif;?>
	
	<?php echo $form->textAreaRow($model, 'description', array('class'=>'ckeditor'))?>		
		
	<?php $this->renderPartial('application.views.admin._form_actions', array('model'=>$model))?>
	
    <?php $this->endWidget()?>

<style>
#page .tab-content {
	overflow: hidden;
}
</style>
