<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Factura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proforma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'proforma_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proforma_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'facturador_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cliente_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proforma_fecha')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
