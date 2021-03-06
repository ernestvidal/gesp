<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


?>
<div class="factura-send">
    <h1><?= Html::encode($this->title) ?></h1>

    <h5>
        Rellenar los campos con los datos del destinatario.
    </h5>
   
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <?php $form = ActiveForm::begin([
                'id' => 'mailRecipient-form',
                //'action' =>'@web/pedido/sendpedido/'.$idPedido
                'action' => Url::to(['pedido/sendpedido', 'id'=>$idPedido, 'num'=>$numPedido, 'name'=>$name])
                ]); ?>

                <?= $form->field($model, 'mail')->textInput(['value'=>$model->identidad_mail, 'size'=>'250']) ?>

                <?= $form->field($model, 'asunto')->textInput(['value' => 'Pedido num.' . $numPedido ]) ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6,
                        'value' => 'Adjunto le remitimos nuestro pedido.',
                    ]) ?>
         

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-1"></div>
    </div>
    
</div>
