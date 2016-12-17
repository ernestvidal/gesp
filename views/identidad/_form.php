<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Identidad;

/* @var $this yii\web\View */
/* @var $model app\models\Identidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="identidad-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'identidad_nombre')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'identidad_direccion')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'identidad_cp')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'identidad_poblacion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'identidad_provincia')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'identidad_nif')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'identidad_phone')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <?= $form->field($model, 'identidad_mail')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'identidad_forma_pago')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'identidad_cta')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'identidad_role')->dropDownList(['CLIENTE'=>'CLIENTE', 'CAPTACION'=>'CAPTACION']) ?>
                        
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'identidad_web')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
