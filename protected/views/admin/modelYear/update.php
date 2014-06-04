<?php $title = $model->year . ' ' . $model->Model->Make->title . ' ' . $model->Model->title . ' - ' . Yii::t('admin', 'Editing Model by Year');?>

<?php $this->pageTitle = Yii::app()->name.' - ' . $title;?>

<div class="container inner-page white img-rounded">
    <div class="page-header">
        <h3><?=$title?></h3>
    </div>
	
	<?php $this->widget('AdminTbAlert', array(
        'block'=>true, 
        'fade'=>true,
        'closeText'=>'&times;',
        'alerts'=>array(
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
        ))); 
	?> 		
	
	<?php
		$this->widget('bootstrap.widgets.TbTabs', array(
            'tabs'=> array(
				array(
					'label'=> Yii::t('admin', 'General'), 
					'active'=>true, 
					'content' => $this->renderPartial('_form', array(
						'model'=> $model, 
						'disabled' => false, 
					), 
					true
				)),
				
				array(
					'label'=>Yii::t('admin', 'Photos'), 'content' => $this->renderPartial('_photos', array(
                        'model'=> $model,
                    ), 
					true
				))
			)
		));	
	?>
</div>