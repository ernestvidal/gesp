<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Pedido;
use app\models\Identidad;
use yii\helpers\ArrayHelper;

?>
<div class="pedido-send">
    <h1><?= Html::encode($this->title) ?></h1>

    <h5>
        Rellenar los campos.
    </h5>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

        <?php
        if($documento_destino == 'albaran')
        {
            $action = '@web/pedidocliente/copiar/';
        }elseif ($documento_destino == 'factura') {
             $action = '@web/proforma/copiarfactura/';
        }elseif ($documento_destino == 'pedido') {
             $action = '@web/pedidocliente/pedidoproveedor/';
        }
        $form = ActiveForm::begin([
                    'id' => 'mailRecipient-form',
                    'action' => $action
                ]);
        ?>

            <?=
            Html::input('text', 'numero_documento', '2017.'. substr('000'.(substr(Pedido::find()->max('pedido_num'), 5)+1),-3,3), [
                'class' => 'form-control',
                'placeholder' => 'Introducir número Pedido',
                ])
            ?>
            <br />
            <?= Html::input('date', 'fecha_documento', Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'), ['class' => 'form-control']) ?>

            <br />
      
            <?= Html::dropDownList('cliente_id','cliente_id', ArrayHelper::map(Identidad::findAll(['identidad_role' => ['PROVEEDOR', 'AMBOS']]), 'identidad_id', 'identidad_nombre'),
                    ['prompt' => 'A quien se va a facturar...', 'id' => 'cliente_id',
                        'class' =>'form-control'])
                    ?>
            <br />
            <?= Html::Input('hidden','pedido_id', $numPedido) ?>
            <?= Html::Input('hidden','documento_destino', $documento_destino) ?>
            
            <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
            </div>

<?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-1"></div>
    </div>

</div>






