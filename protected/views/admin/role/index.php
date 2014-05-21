<?php $this->pageTitle = Yii::app()->name.' - ' . Yii::t('admin', 'Roles');?>

<div class="container inner-page white img-rounded">
    <div class="page-header">
        <h3><?=Yii::t('admin', 'Roles')?></h3>
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
	
		<?php if (Access::is('role.create')):?>
			<? $this->widget("bootstrap.widgets.TbButtonGroup", array(
				'type' => 'success',
				'buttons' => array(
					array('label' => Yii::t('admin', 'Create'), 'url' => Yii::app()->createUrl("admin/role/create"), 'icon' => 'file white'),
				),
			))?>
		<?php endif;?>
		
        <div class="btn clear-filter"><?=Yii::t('admin', 'Clear Search')?></div>
    </div>
	
	
    <div class="grid">
        <?php 
		
		$columns = array(
			'id',
            'title',
        );
		
		if (Access::is('role.update') || Access::is('role.delete')) {
			$template = array();
			if (Access::is('role.update')) $template[] = '{update}';
			if (Access::is('role.delete')) $template[] = '{delete}';
			
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
        ))?>
    </div>
</div>