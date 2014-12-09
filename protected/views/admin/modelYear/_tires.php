	<div class="control-group">
		<?php $model->post_tires = $model->getPost_tires()?>
			<label class="control-label required" for="AutoModelYear_post_tires"><?php echo $model->getAttributeLabel('post_tires')?></label>
			<div class="controls">
			<?php $this->widget('ext.chosen.Chosen',array(
				'model' => $model, 
				'attribute' => 'post_tires', 
				'data' => Tire::model()->getList(),
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
			<?php 	
				$modelYearTires = $model->getPost_tires(false); 
				foreach (AutoModelYear::getListYears($model->model_id) as $item): if($item['id']==$model->id){continue;}?>
				<label><input type="checkbox" name="AutoModelYear[post_tires_related][]" value="<?=$item['id']?>" <?=in_array($item['id'], $model->post_tires_related)?'checked="checked"':''?>> <span <?=($modelYearTires==$item['tires'])?'style="font-weight: bold;"':''?>><?=$item['year']?></span> <?=(count($item['tires'])>0)?'('.count($item['tires']).')':''?></label>
			<?php endforeach;?>
			</div>
	</div>
	<?php endif;?>