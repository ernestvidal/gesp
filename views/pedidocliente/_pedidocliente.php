<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Identidad;


/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */

/* Cargamos pedido.js solamente para esta vista después de que se cargue Jquery
 * Lo había puesto en AppAsset, pero como tiene funciones comunes con factura.js 
 * y prespuesto.js algunas de las funciones eran ejecutadas varias veces 
 */
$this->registerJsFile('@web/js/pedido.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Editar Pedido';
$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="pedido-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
    <div id="pedido_cap">
        <div>
            <div id="facturador" class="col-md-6 well">
                <div class="col-md-12">
                    <?= $form->field($model, 'facturador_id')->dropDownList(
                            ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'),
                            ['prompt'=>'Quien va a facturar...', 'id'=>'facturador_id', 'class'=>'form-control',
                            'onchange'=> '$("#'.Html::getInputId($model, 'forma_pago').'").val())'
                            ]) ?>
                </div>
            </div>
            <div id="cliente" class="col-md-6 well">
                <div class="col-md-12">
                    <?= $form->field($model, 'cliente_id')->dropDownList(
                            ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'),
                            ['prompt'=>'A quien se va a facturar...', 'id'=>'cliente_id', 'class'=>'form-control']) ?>
                </div>
            </div>
        </div>
        <div class="well">
             <div class="row">
                <div class="col-md-3">
                     <?= $form->field($model, 'pedido_fecha')->textInput(['maxlength' => true, 'type'=>'date']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'pedido_num')->textInput(['maxlength' => true, 'id'=>'pedido_num']) ?>
                </div>
                <div class="col-md-3">
                     <?= $form->field($model, 'pedido_fecha_entrega')->textInput(['maxlength' => true, 'type'=>'date']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'pedido_cliente_num')->textInput(['maxlength' => true, 'id'=>'pedido_num']) ?>
                </div>
             </div>
        </div>
        
    </div>
    <div id="pedido_cos" class="well">
        <div class="row">
            <div class="col-md-2">
                <label for="item_cantidad">Cantidad</label>
            </div>
            <div class="col-md-5">
                <label for="item_descripcion">Descripción</label>
            </div>
            <div class="col-md-2">
                <label for="item_precio">Precio</label>
            </div>
            <div class="col-md-2">
                <label for="item_total">Total</label>
            </div>
            <div class="col-md-1">
                <p>#</p>
            </div>
        </div>
        <div id="item_line">

              <?php

              $count = count($model['pedidoitemclientes']);
              //var_dump($model['pedidoitems']);

               for ($i = 0; $i < $count ; $i++)
              {
                echo "<div id='line_" . $i . "'class='row pedido_line'>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='PedidoItem[$i][item_cantidad]' id='item_cantidad_" . $i . "'class='form-control text-right' value='" . $model['pedidoitemclientes'][$i]['item_cantidad'] . "'  >";
                echo "</div>";

                echo "<div class='col-md-5'>";
                echo "<textarea name='PedidoItem[$i][item_descripcion]' id='item_descripcion_" . $i . "' class='form-control'>" . $model['pedidoitemclientes'][$i]['item_descripcion'] . "</textarea>";
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='PedidoItem[$i][item_precio]' id='item_precio_" . $i . "' class='form-control text-right' value=" . $model['pedidoitemclientes'][$i]['item_precio'] . " >";
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='PedidoItem[$i][item_total]' id='item_total_" . $i . "' class='form-control text-right'  readonly >";
                echo "</div>";

                /* Este campo es necesario. Se pasa junto con los demás al controlador.
                 * El controlador lo utiliza para conocer el número de pedido utilizado en la cabecera
                 * y guardar - editar  el mismo en el cuerpo de la misma para que queden relacionados.
                */
                echo " <div class='col-md-1'>";
                echo Html::a('<i class="glyphicon glyphicon-trash"></i>', 'delete');
                echo " </div> ";

                echo " <input type='hidden' name='PedidoItem[$i][pedido_num]'  id='pedido_item_num_" . $i . "'>";

                echo "</div>";
                echo "<br>";
              }
              ?>
        </div>
        <div class="row">
            <div class="col-md-1">
                <h3 id="add_item_line"> [ + ]</h3>
            </div>
        </div>
    </div>

    <div id="pedido_calculs" class="well">
        <div class="row">
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="pedido_base_imponible">Base imponible</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="pedido_base_imponible" id="pedido_base_imponible" class="form-control text-right" readonly>
                </div>
            </div>

            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                     <label for="pedido_rate_descuento">Descuento %</label>
                </div>
                <div class="col-md-3">
                     <?= $form->field($model, 'pedido_rate_descuento')->textInput(['maxlength' => true, 'id'=>'pedido_rate_descuento'])->label(false) ?>
                   </div>
                <div class="col-md-5">
                    <input type="text" name="pedido_importe_descuento" id="pedido_importe_descuento" class="form-control text-right" value="0.00" readonly>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="pedido_rate_iva">IVA %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'pedido_rate_iva')->textInput(['maxlength' => true,  'id'=>'pedido_rate_iva'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <input type="text" name="pedido_importe_iva" id="pedido_importe_iva" class="form-control text-right" value="0.00" readonly>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="pedido_rate_irpf">IRPF %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'pedido_rate_irpf')->textInput(['maxlength' => true,  'id'=>'pedido_rate_irpf'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <input type="text" name="pedido_importe_irpf" id="pedido_importe_irpf" class="form-control text-right" value="0.00" readonly>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="pedido_total">Total pedido</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="pedido_total" id="pedido_total" class="form-control text-right" value="0.00" readonly>
                </div>
            </div>
        </div>
        <div class="well">
          <div class="row">
            <?= $form->field($model, 'forma_pago')->textInput(['maxlength' =>true, 'id'=>'pedido-forma_pago']) ?>
          </div>
           <div class="row">
            <?= $form->field($model, 'pedido_plazo_entrega')->textInput(['maxlength' =>true, 'id'=>'pedido_plazo_entrega']) ?>
          </div> 
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>
