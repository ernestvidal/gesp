<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FacturaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proforma-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'proforma_id') ?>

    <?= $form->field($model, 'proforma_num') ?>

    <?= $form->field($model, 'facturador_id') ?>

    <?= $form->field($model, 'cliente_id') ?>

    <?= $form->field($model, 'proforma_fecha') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
