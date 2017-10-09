<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Cargo;
?>
<div class="factura-send">
    <h1><?= Html::encode($this->title) ?></h1>

    <h5>
        Rellenar los campos con los datos del destinatario de la factura.
    </h5>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <?php
            $form = ActiveForm::begin([
                        'id' => 'mailRecipient-form',
                        //'action' =>'@web/factura/sendfactura/'.$idFactura
                        'action' => Url::to(['factura/sendfactura', 'id' => $idFactura, 'num' => $numFactura, 'name' => $name])
            ]);
            ?>

            <?php
            $cargo_mails = ArrayHelper::map(Cargo::find()->where(['cargo_identidad_id' => $cliente_id])->all(), 'cargo_mail', 'cargo_mail', 'cargo_cargo');
            $identidad_mails = array('cargo' => [$model['identidad_mail'] => $model['identidad_mail']]);
            $mails = ArrayHelper::merge($cargo_mails, $identidad_mails);

            // print_r($mails);
            ?>


            <?=
            $form->field($model, 'identidad_mail')->dropDownList($mails, [
                'prompt' => 'Seleccionar ...',
                'class' => 'form-control'
            ]);
            ?>

            <?php //textInput(['value'=>$model->identidad_mail, 'size'=>'250']) ?>

            <?= $form->field($model, 'asunto')->textInput(['value' => 'Factura num.' . $numFactura]) ?>

            <?=
            $form->field($model, 'body')->textArea(['rows' => 6,
                'value' => 'Adjunto le remitimos factura para su abono',
            ])
            ?>


            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-1"></div>
    </div>

</div>



