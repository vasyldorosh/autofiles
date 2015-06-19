<?php $this->pageTitle = Yii::app()->name.' - ' . Yii::t('admin', 'Projects');?>

<div class="container inner-page white img-rounded">
    <div class="page-header">
        <h3><?=Yii::t('admin', 'Projects')?></h3>
    </div>
    
	<?php $this->widget('AdminTbAlert', array(
        'block'=>true, 
        'fade'=>true,
        'closeText'=>'&times;',
        'alerts'=>array(
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
        ))); 
	?> 	
	
	<div class="button">
		<?php if (Access::is('project.create')):?>
			<? $this->widget("bootstrap.widgets.TbButtonGroup", array(
				'type' => 'success',
				'buttons' => array(
					array('label' => Yii::t('admin', 'Create'), 'url' => Yii::app()->createUrl("admin/project/create"), 'icon' => 'file white'),
				),
			))?>
		<?php endif;?>
        <div class="btn clear-filter"><?=Yii::t('admin', 'Clear Search')?></div>
    </div>
	
	
    <div class="grid">
        <?php 
		
		$columns = array(
				array(
					'name'=>'id',
					'value'=>'$data->id',
					'htmlOptions' => array(
						'width' => 40, 
					),					
				),
				array(
					'name' => 'make_id',
					'value' => 'CHtml::link(isset($data->Make)?$data->Make->title:"-", "/admin/project/update?id=".$data->id."")',	
					'filter' => AutoMake::getAll(),
					'type'=>'raw',
				),									
				array(
					'name' => 'model_id',
					'value' => 'isset($data->Model)?$data->Model->title:"-"',	
					'filter' => AutoModel::getAllWithMake(),
				),									
				array(
					'name' => 'model_year_id',
					'value' => 'isset($data->ModelYear)?$data->ModelYear->year:"-"',	
				),
				'wheel_manufacturer',
				'wheel_model',
				array(
					'name' => 'rim_diameter_id',
					'value' => 'isset($data->TireRimDiameter)?$data->TireRimDiameter->value:"-"',	
					'filter' => TireRimDiameter::getList(),
				),				
				array(
					'name' => 'rim_width_id',
					'value' => 'isset($data->RimWidth)?$data->RimWidth->value:"-"',	
					'filter' => RimWidth::getAll(),
				),				
				array(
					'name' => 'rim_offset_range_id',
					'value' => 'isset($data->RimOffsetRange)?$data->RimOffsetRange->value:"-"',	
					'filter' => RimOffsetRange::getAll(),
				),	
				array(
					'name' => 'is_staggered_wheels',
					'value' => '$data->is_staggered_wheels ? "Да" : "Нет"',
					'filter' => HtmlHelper::getYesNoFilter(),
				),
				/*
				array(
					'name' => 'rear_rim_diameter_id',
					'value' => 'isset($data->RearTireRimDiameter)?$data->RearTireRimDiameter->value:"-"',	
					'filter' => TireRimDiameter::getList(),
				),				
				array(
					'name' => 'rear_rim_width_id',
					'value' => 'isset($data->RearRimWidth)?$data->RearRimWidth->value:"-"',	
					'filter' => RimWidth::getAll(),
				),				
				array(
					'name' => 'rear_rim_offset_range_id',
					'value' => 'isset($data->RearRimOffsetRange)?$data->RearRimOffsetRange->value:"-"',	
					'filter' => RimOffsetRange::getAll(),
				),		
				*/
				'tire_manufacturer',
				'tire_model',
				array(
					'name' => 'tire_section_width_id',
					'value' => 'isset($data->TireSectionWidth)?$data->TireSectionWidth->value:"-"',	
					'filter' => TireSectionWidth::getList(),
				),
				array(
					'name' => 'tire_aspect_ratio_id',
					'value' => 'isset($data->TireAspectRatio)?$data->TireAspectRatio->value:"-"',	
					'filter' => TireAspectRatio::getList(),
				),	
				array(
					'name' => 'is_staggered_tires',
					'value' => '$data->is_staggered_tires ? "Да" : "Нет"',
					'filter' => HtmlHelper::getYesNoFilter(),
				),				
            );
			
		if (Access::is('project.update') || Access::is('project.delete')) {
			$template = array();
			if (Access::is('project.update')) $template[] = '{update}';
			if (Access::is('project.delete')) $template[] = '{delete}';
			
			$columns[] = array(
				'htmlOptions' => array('nowrap'=>'nowrap', 'style' => 'text-align: center;'),
                 'class'=>'bootstrap.widgets.TbButtonColumn',
                 'template' => implode('', $template),
            );
		}
		
		$this->widget('bootstrap.widgets.TbGridView', array(
            'dataProvider' => $model->search(),
            'filter' => $model,
            'type' => 'striped bordered condensed',
            'columns' => $columns,
			'id' => 'list-grid',
			'pager' => array(
				  'class' => 'bootstrap.widgets.TbPager',
				  'displayFirstAndLast' => true,
			),			
			'template'=>'{summary}{items}<div style="float:left">{pager}</div> <div style="float:right;margin-top:15px;"><span style="color:#666;">per page:</span> '.
			CHtml::dropDownList(
				'pageSize',
				$pageSize,
				Yii::app()->params->perPages,
				array('class'=>'change-pageSize', 'style'=>'width: 70px;')) . '</div>',			
        ))?>
    </div>

</div>

<?php Yii::app()->clientScript->registerScript('initPageSize',<<<EOD
    $('.change-pageSize').live('change', function() {
        $.fn.yiiGridView.update('list-grid',{ data:{ pageSize: $(this).val() }})
    });
EOD
,CClientScript::POS_READY); ?>