<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\install\AppConfigModel */

Yii::$app->language = 'de-DE';
?>

<h1><?= Yii::t('app', 'Welcome')  ?></h1>
<div class="form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'adminMail') ?>
        <?= $form->field($model, 'senderMail') ?>
        <?= $form->field($model, 'senderName') ?>
        <?= $form->field($model, 'appName') ?>
        <?= $form->field($model, 'appId') ?>
        <?= $form->field($model, 'cookieValidationKey')->textInput(['placeholder' => '<random>']) ?>
        <?= $form->field($model, 'dbClass')->dropDownList($model->listDbClasses(true)) ?>
        <?= $form->field($model, 'dbEngine')->dropDownList($model->listDbEngines(true)) ?>
        <?= $form->field($model, 'dbHost')->textInput(['placeholder' => 'localhost']) ?>
        <?= $form->field($model, 'dbName') ?>
        <?= $form->field($model, 'dbPort')->input('number', ['value' => 3306]) ?>
        <?= $form->field($model, 'dbUser') ?>
        <?= $form->field($model, 'dbPassword')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- _formAppConfig -->
