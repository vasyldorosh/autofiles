<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form TbActiveForm */

$this->pageTitle = Yii::app()->name . ' - Авторизация';
?>

<script type="text/javascript">
	$(document).ready(function () {
		$('#caLogin').click(function() {
			$('.popUp').css('display', 'none');
		});
		})
</script>

<div>
<?php //    <div class="popUp-header-in">Вас приветствует LadyBonus!</div> ?>
    <div class="close-button"></div>
    <p class='loghead' style="text-align: center">Вход для партнеров</p>
    <hr>
    <div style="text-align: center">
        <?php
        $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
                    'type' => 'horizontal',
                    'htmlOptions' => array('class'=>'loginForm'),
                    'action' => Yii::app()->createUrl('site/ca_login')
                )
            )?>
    <!--    <p>--><?//= CHtml::link('Зарегистрироваться', Yii::app()->createUrl('user/registerUser'))?><!--</p>-->
        <p><?php echo CHtml::activeTextField($model, 'username',
        array('placeholder' => 'Телефон или e-mail')) ?></p>
        <p><?php echo CHtml::activePasswordField($model, 'password',
                    array('placeholder' => 'Пароль')) ?></p>
        <p><?php echo CHtml::activeCheckBox($model, 'rememberMe') ?> Запомнить меня <a class="remind-button make-popUp" data="remindU-popUp" id="caLogin" >Забыли пароль?</a></p>
        <div class="center-block">
            <?php $this->widget('bootstrap.widgets.TbButton', 
                        array('buttonType' => 'submit', 
                              'label' => 'Войти', 
                              'htmlOptions'=>array('class'=>'btn-success')));?>
        </div>
        <?php $this->endWidget();?>
    </div>
</div>
