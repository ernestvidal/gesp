<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IdentidadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="identidad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'identidad_id') ?>

    <?= $form->field($model, 'identidad_nombre') ?>

    <?= $form->field($model, 'identidad_direccion') ?>

    <?= $form->field($model, 'identidad_poblacion') ?>

    <?= $form->field($model, 'identidad_nif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
