        <?php $this->widget('bootstrap.widgets.TbTabs', array(
            'placement'=>'left',
            'tabs'=>array(
                array(
					'label'=>Yii::t('admin', 'Home'), 
					'active'=>true, 
					'content' => $this->renderPartial('_home_page', array(
						'form'=>$form,
						'values'=>$values,
					), 
					true
				)),
                array(
					'label'=>Yii::t('admin', 'Make'),
					'content' => $this->renderPartial('_make_page', array(
						'form'=>$form,
						'values'=>$values,
					), 
					true
				)),
                array(
					'label'=>Yii::t('admin', 'Model'),
					'content' => $this->renderPartial('_model_page', array(
						'form'=>$form,
						'values'=>$values,
					), 
					true
				)),
                array(
					'label'=>Yii::t('admin', 'Model by Year'),
					'content' => $this->renderPartial('_model_year_page', array(
						'form'=>$form,
						'values'=>$values,
					), 
					true
				)),
                array(
					'label'=>Yii::t('admin', 'Completion'),
					'content' => $this->renderPartial('_completion_page', array(
						'form'=>$form,
						'values'=>$values,
					), 
					true
				)),
			)
		));?>

