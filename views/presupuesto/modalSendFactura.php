<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="presupuesto-send">
    <h1><?= Html::encode($this->title) ?></h1>

    <h5>
        Rellenar los campos con los datos del destinatario de la presupuesto.
    </h5>
   
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <?php $form = ActiveForm::begin([
                'id' => 'mailRecipient-form',
                'action' => 'sendpresupuesto/' . $numPresupuesto
                ]); ?>

                <?= $form->field($model, 'mail')->textInput(['value'=>$model->identidad_mail, 'size'=>'250']) ?>

                <?= $form->field($model, 'asunto')->textInput(['value' => 'Presupuesto num.' . $numPresupuesto ]) ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6,
                        'value' => 'Adjunto le remitimos presupuesto para su abono',
                    ]) ?>
         

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-1"></div>
    </div>
    
</div>



