<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <link rel="shortcut icon" href="/site/img/favicon.ico" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<style>	
body {
    background: #ffffff;
}

#page {
    padding: 10px;
    border: 0px solid #dddddd;
	min-height:800px;
}

.page-header h3,.page-header h2,.page-header h1 {
    font-size:17px;
    line-height: 20px;
    margin: 0;
}

.fileUpload {
	position: relative;
	overflow: hidden;
}
.fileUpload input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}

.row-invisible, .row-invisible a {
	color: #f89406;
}
.row-visible, .row-visible a {
	color: #51a351;
}
.underline {
	text-decoration: underline;
}
    .salon-form .form-actions {
        float:left;
        width: 43%;
        padding-left: 50px;
        border-top:none;
    }
    .salon-form .map {
        height: 400px;
        margin-top: 40px;
        float:left;
        width: 48%;
        border: 1px solid #bfbfbf;
    }
    .salon-form{
        overflow: hidden;
        background-color: #fff;
    }
    .popUpSalon {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: 100;
    }
    .popUpSalon .message {
        margin: 200px auto;
        width: 200px;
        padding: 20px;
        background-color: whitesmoke;
    }
</style>	
	
</head>
<body>

<div class="container" id="page">

<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    //'type'=>'inverse', // null or 'inverse'
    'brand'=>'',
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(

				array('label' => Yii::t('admin', 'Users'), 'visible'=>(Access::is('admin') || Access::is('user')), 'items' => array(
					array('label' => Yii::t('admin', 'Admins'), 'url' => Yii::app()->createUrl('admin/admin/index'), 'visible'=>Access::is('admin')),
					array('label' => Yii::t('admin', 'Users'), 'url' => Yii::app()->createUrl('admin/user/index'), 'visible'=>Access::is('user')),
					array('label' => Yii::t('admin', 'Roles'), 'url' => Yii::app()->createUrl('admin/role'), 'visible'=>Access::is('role')),
				)),	
				array('label' => Yii::t('admin', 'Body Style'), 'url' => Yii::app()->createUrl('admin/bodyStyle'), 'visible'=>(Access::is('bodyStyle'))),
				
				
				array('label' => Yii::t('admin', 'Makes'), 'visible'=>(Access::is('make')), 'items' => array(
					array('label' => Yii::t('admin', 'Makes'), 'url' => Yii::app()->createUrl('admin/make'), 'visible'=>(Access::is('make'))),
					array('label' => Yii::t('admin', 'Basket'), 'url' => Yii::app()->createUrl('admin/make/basket'), 'visible'=>Access::is('make.basket')),
				)),		

				array('label' => Yii::t('admin', 'Models'), 'visible'=>(Access::is('model')), 'items' => array(
					array('label' => Yii::t('admin', 'Models'), 'url' => Yii::app()->createUrl('admin/model'), 'visible'=>(Access::is('model'))),
					array('label' => Yii::t('admin', 'Basket'), 'url' => Yii::app()->createUrl('admin/model/basket'), 'visible'=>Access::is('model.basket')),
				)),				
				
				array('label' => Yii::t('admin', 'Models by Year'), 'visible'=>(Access::is('modelYear')), 'items' => array(
					array('label' => Yii::t('admin', 'Models by Year'), 'url' => Yii::app()->createUrl('admin/modelYear'), 'visible'=>(Access::is('modelYear'))),
					array('label' => Yii::t('admin', 'Basket'), 'url' => Yii::app()->createUrl('admin/modelYear/basket'), 'visible'=>Access::is('modelYear.basket')),
					array('label' => Yii::t('admin', 'Empty competitors'), 'url' => Yii::app()->createUrl('admin/modelYear/emptyCompetitors'), 'visible'=>Access::is('modelYear')),
					array('label' => Yii::t('admin', 'Empty photos'), 'url' => Yii::app()->createUrl('admin/modelYear/emptyPhotos'), 'visible'=>Access::is('modelYear')),
				)),				
				
				array('label' => Yii::t('admin', 'Completions'), 'visible'=>(Access::is('completion')), 'items' => array(
					array('label' => Yii::t('admin', 'Completions'), 'url' => Yii::app()->createUrl('admin/completion'), 'visible'=>(Access::is('completion'))),
					array('label' => Yii::t('admin', 'Basket'), 'url' => Yii::app()->createUrl('admin/completion/basket'), 'visible'=>Access::is('completion.basket')),
				)),				
					
				array('label' => Yii::t('admin', 'Specs'), 'visible'=>(Access::is('specs') || Access::is('specsGroup')), 'items' => array(
					array('label' => Yii::t('admin', 'Specs'), 'url' => Yii::app()->createUrl('admin/specs'), 'visible'=>Access::is('specs')),
					array('label' => Yii::t('admin', 'Specs Group'), 'url' => Yii::app()->createUrl('admin/specsGroup'), 'visible'=>Access::is('specsGroup')),
				)),	
				
				array('label' => Yii::t('admin', 'Settings'), 'url' => Yii::app()->createUrl('admin/settings'), 'visible'=>(Access::is('settings'))),
				array('label' => Yii::t('admin', 'Parsing'), 'url' => Yii::app()->createUrl('admin/parsing'), 'visible'=>(Access::is('parsing')), 'items' => array(
					array('label' => Yii::t('admin', 'Worldcarfans Photos'), 'url' => Yii::app()->createUrl('admin/parsing/worldcarfans')),
				)),
	        
				
			
			),
        ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
				array('label'=>Yii::t('admin', 'Profile'), 'url'=>Yii::app()->createUrl('admin/admin/update'),'itemOptions' => array('class' => 'underline')),
                array('label'=>Yii::t('admin', 'Logout'), 'url'=>Yii::app()->createUrl('admin/admin/logout')),
            ),
        ),
    ),
)); ?>

	<div style="height: 30px;" class="clear"></div>
	<?php echo $content; ?>
	<div class="clear"></div>
</div>
<script src="/ckeditor/ckeditor.js"></script>
<script>
$(document).ready(function(){
	
	$(document).on('click', '.clear-filter', function() {
		$('.filters select').val('');
		$('.filters input').val('');
        $('.filters input').trigger('change', '');
    })
	
});
</script>

<?php if (YII_DEBUG):?>
<div style="position:fixed;right:0;top:0;color:green;margin-right:5px;z-index:10000;">
  <?php $stat = Yii::app()->db->getStats();?>
  <?=$stat[0]?> / <?=round($stat[1],5)?>
</div> 
<?php endif;?>


</body>
</html>
