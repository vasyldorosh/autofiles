<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Авторизация';
?>
<div>
<?php //    <div class="popUp-header-in">Вас приветствует LadyBonus!</div> ?>
    <div class="close-button"></div>
    <p class='loghead' style="text-align: center">Вход</p>
    <hr>
<div style="text-align: center">
    <?
    $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
            'type' => 'horizontal',
    'htmlOptions'=>array('class'=>'loginForm'),
    'action' => Yii::app()->createUrl('site/login')
    )
    )?>
<!--    <p>--><?//= CHtml::link('Зарегистрироваться', Yii::app()->createUrl('user/registerUser'))?><!--</p>-->
    <p><?= CHtml::activeTextField($model, 'username',array('placeholder'=>'Телефон или e-mail'))?></p>
    <p><?= CHtml::activePasswordField($model, 'password',array('placeholder'=>'Пароль'))?></p>
    <p><?= CHtml::activeCheckBox($model, 'rememberMe')?>Запомнить меня <a class="remind-button make-popUp" data="remindC-popUp">Забыли пароль?</a></p>

    <input type="hidden" name="ajax" value="login-form">
    <div class="center-block">
    <? $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Войти', 'htmlOptions'=>array('class'=>'btn-success')))?>
    </div>
        <? $this->endWidget()?>
</div>
</div>