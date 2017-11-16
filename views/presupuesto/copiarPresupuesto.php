<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Pedidocliente;
?>
<div class="proforma-send">
    <h1><?= Html::encode($this->title) ?></h1>

    <h5>
        Rellenar los campos.
    </h5>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

        <?php
        if($documento_destino == 'presupuesto')
        {
            $action = '@web/presupuesto/copiar/';
        } elseif ($documento_destino == 'pedidoCliente') {
            $action = '@web/presupuesto/copytoorder/';
        
}
        $form = ActiveForm::begin([
                    'id' => 'mailRecipient-form',
                    'action' => $action
                ]);
        ?>

           
             <?=
            Html::input('text', 'numero_documento', '2017.'. substr('000'.(substr(Pedidocliente::find()->max('pedido_num'), 5)+1),-3,3), [
                'class' => 'form-control',
                'placeholder' => 'Introducir número Pedido',
                ])
            ?>
            <br />
            <?= Html::input('date', 'fecha_documento', '', ['class' => 'form-control']) ?>

            <br />
            <?= Html::Input('hidden','presupuesto_id', $numPresupuesto) ?>
            <?= Html::Input('hidden','documento_destino', $documento_destino) ?>
            
            <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
            </div>

<?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-1"></div>
    </div>

</div>

