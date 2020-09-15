<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\db\Legislature */

$this->title = Yii::t('app', 'Create legislature');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Legislatures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="legislature-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
