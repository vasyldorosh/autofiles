<?php $this->pageTitle = Yii::app()->name.' - ' . Yii::t('admin', 'Editing Body style');?>

<div class="container inner-page white img-rounded">
    <div class="page-header">
        <h3><?=Yii::t('admin', 'Editing Body style')?></h3>
    </div>
    <? $this->renderPartial('_form', array(
        'model' => $model,
    ))?>
</div>