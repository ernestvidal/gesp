<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'item_descripcion') ?>

    <?= $form->field($model, 'item_referencia') ?>

    <?= $form->field($model, 'item_long_descripcion') ?>

    <?= $form->field($model, 'item_modelo') ?>

    <?php // echo $form->field($model, 'item_tamaño') ?>

    <?php // echo $form->field($model, 'item_identidad_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
