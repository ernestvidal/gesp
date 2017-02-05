<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchCargo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cargo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cargo_id') ?>

    <?= $form->field($model, 'cargo_identidad_id') ?>

    <?= $form->field($model, 'cargo_nombre') ?>

    <?= $form->field($model, 'cargo_phone') ?>

    <?= $form->field($model, 'cargo_cargo') ?>

    <?php // echo $form->field($model, 'cargo_mail') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
