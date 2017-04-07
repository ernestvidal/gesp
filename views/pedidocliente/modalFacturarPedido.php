<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="pedido-send">
    <h1><?= Html::encode($this->title) ?></h1>

    <h5>
        Rellenar los campos con los datos del destinatario de la pedido.
    </h5>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <?php
            $form = ActiveForm::begin([
                        'id' => 'mailRecipient-form',
                        'action' => '@web/pedido/facturarpedido/'
            ]);
            ?>

             <?= Html::textInput('num_factura','',[
                    'class'=>'form-control',
                    'placeholder' => 'Introducir número de factura' ]) ?>
                <br />
                               
                <?= Html::Input('hidden','pedido_id', $numPedido) ?>
                   
              
                <div class="form-group">
                    <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
                </div>


            

<?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-1"></div>
    </div>

</div>



