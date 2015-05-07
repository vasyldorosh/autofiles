<?php $this->pageTitle = Yii::app()->name.' - ' . Yii::t('admin', 'Editing Rim Offset Range');?>

<div class="container inner-page white img-rounded">
    <div class="page-header">
        <h3><?=Yii::t('admin', 'Editing Rim Offset Range')?></h3>
    </div>
	
	<?php $this->renderPartial('_form', array('model'=>$model));?>
</div>