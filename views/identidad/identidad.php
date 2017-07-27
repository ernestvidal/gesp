<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Identidad;
use app\models\Cargo;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Identidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="identidad-form">
    <div class="row">
        <div class="tabbable">
            <ul class="nav nav-pills nav-stacked col-lg-3">
                <li class="active">
                    <a href="#identidad" aria-controls="identidad" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-dashboard"></span> &nbsp; Identidad
                    </a>
                </li>
                <li>
                    <a href="#cargos" aria-controls="cargos" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-credit-card"></span> &nbsp; Cargos 
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content col-lg-9">
            <!-- Tab Identidad -->
            <div class="tab-pane active" id="identidad">   
                <?php $form = ActiveForm::begin(['enableAjaxValidation'=>TRUE]);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?= $form->field($model, 'identidad_nombre')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?= $form->field($model, 'identidad_razon_social')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?= $form->field($model, 'identidad_actividad')->textInput(['maxlength' => true]) ?>
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
                    <div class="col-lg-4">
                        <?= $form->field($model, 'identidad_nif')->textInput(['maxlength' => true]) ?>
                    </div>
                     <div class="col-lg-4">
                        <?= $form->field($model, 'identidad_phone')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $form->field($model, 'identidad_mobile_phone')->textInput(['maxlength' => true]) ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'identidad_mail')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'identidad_persona_contacto')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

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
                        <?= $form->field($model, 'identidad_role')->dropDownList(['CLIENTE' => 'CLIENTE', 'PROVEEDOR' => 'PROVEEDOR', 'CAPTACION' => 'CAPTACION', 'AMBOS' => 'AMBOS'], ['prompt' => 'Seleccionar ...']) ?>

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

            <!-- Tab Cargos -->
            <div class="tab-pane" id="cargos">
                <div class="cargo-form">
                    <?php
                    if ($model->isNewRecord == FALSE) {
                        foreach ($modelCargo as $cargo) {
                            $formCargo = ActiveForm::begin();
                            ?>
                            <div class="row">

                                <div class="col-lg-12"><?= $formCargo->field($cargo, 'cargo_nombre')->textInput(['maxlength' => true]) ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <?= $formCargo->field($cargo, 'cargo_phone')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-lg-10">
                                    <?= $formCargo->field($cargo, 'cargo_cargo')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?= $formCargo->field($cargo, 'cargo_mail')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= Html::a('Update', ['cargo/update', 'id' => $cargo['cargo_id']], ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Delete', ['delete', 'id' => $cargo['cargo_id']], ['class' => 'btn btn-danger']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        <?php } ?>


                    <?php } ?>
                    <?= 
                     Html::a('<i class="glyphicon glyphicon-file"></i> Nuevo cargo', '#', [
                                                'id' => 'nuevo-cargo-link',
                                                'title' => 'Nuevo cargo',
                                                'class' => 'btn btn-success',
                                                'data-toggle' => 'modal',
                                                'data-target' => '#modal',
                                                'data-url' => Url::to(['cargo/create']),
                                                'data-pjax' => '1',])
                   ?>
                </div>
            </div>
        </div>   
    </div>
    
    
    <?php
    $this->registerJs(
            "$(document).on('click', '#nuevo-cargo-link', (function() {
            $.get(
                $(this).data('url'),
                function (data) {
                    $('#modalContent').html(data);
                    $('#modal').modal();
                }
            );
        }));"
    );

    // Ventana modal donde mostramos la vista modalFacturarPedido.php
    Modal::begin([
        'header' => '<h2>Crear nuevo cargo</h2>',
        'id' => 'modal',
    ]);
    echo "<div id='modalContent'>";
    echo "</div>";


    Modal::end();
    ?>
