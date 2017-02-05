<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cargo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cargo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cargo_identidad_id')->textInput() ?>

    <?= $form->field($model, 'cargo_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo_cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo_mail')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
