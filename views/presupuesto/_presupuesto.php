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
/* @var $model app\models\Presupuesto */
/* @var $form yii\widgets\ActiveForm */

/* Cargamos pedido.js solamente para esta vista después de que se cargue Jquery
 * Lo había puesto en AppAsset, pero como tiene funciones comunes con presupuesto.js 
 * y prespuesto.js algunas de las funciones eran ejecutadas varias veces 
 */
$this->registerJsFile('@web/js/presupuesto.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Editar Presupuesto';
$this->params['breadcrumbs'][] = ['label' => 'Presupuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="presupuesto-form">

<?php $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>
    <div id="presupuesto_cap">
        <div>
            <div id="facturador" class="col-md-6 well">
                <div class="col-md-12">
<?=
$form->field($model, 'facturador_id')->dropDownList(
        ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'), ['prompt' => 'Quien va a presupuestor...', 'id' => 'facturador_id', 'class' => 'form-control',
        //'onchange'=> '$("#'.Html::getInputId($model, 'forma_pago').'").val())'
])
?>
                </div>
            </div>
            <div id="cliente" class="col-md-6 well">
                <div class="col-md-12">
        <?=
        $form->field($model, 'cliente_id')->dropDownList(
        ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'), ['prompt' => 'A quien se va a presupuestor...', 'id' => 'cliente_id', 'class' => 'form-control'])
?>
                </div>
            </div>
        </div>
        <div class="well">
            <div class="row">
                <div class="col-md-3 col-md-offset-9">
                    <?= $form->field($model, 'presupuesto_num')->textInput(['maxlength' => true, 'id' => 'presupuesto_num']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-9">
                    <?= $form->field($model, 'presupuesto_fecha')->textInput(['maxlength' => true, 'type' => 'date']) ?>
                </div>
            </div>
        </div>

    </div>
    <div id="presupuesto_cos" class="well">
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
            $count = count($model['presupuestoitems']);
            //var_dump($model['presupuestoitems']);

            for ($i = 0; $i < $count; $i++) {
                echo "<div id='line_0' class='row presupuesto_line'>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='PresupuestoItem[$i][item_cantidad]' id='item_cantidad_" . $i . "' class='form-control text-right' value='" . $model['presupuestoitems'][$i]['item_cantidad'] . "'  >";
                echo "</div>";

                echo "<div class='col-md-5'>";
                echo "<textarea name='PresupuestoItem[$i][item_descripcion]' id='item_descripcion_" . $i . "' class='form-control'>" . $model['presupuestoitems'][$i]['item_descripcion'] . "</textarea>";
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='PresupuestoItem[$i][item_precio]' id='item_precio_" . $i . "' class='form-control text-right' value=" . $model['presupuestoitems'][$i]['item_precio'] . " >";
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='PresupuestoItem[$i][item_total]' id='item_total_" . $i . "' class='form-control text-right'  readonly >";
                echo "</div>";

                /* Este campo es necesario. Se pasa junto con los demás al controlador.
                 * El controlador lo utiliza para conocer el número de presupuesto utilizado en la cabecera
                 * y guardar - editar  el mismo en el cuerpo de la misma para que queden relacionados.
                 */
                echo " <div class='col-md-1'>";
                echo "<a href=''>[ x ]</a>";
                echo " </div> ";

                echo " <input type='hidden' name='PresupuestoItem[$i][presupuesto_num]'  id='presupuesto_item_num_" . $i . "'>";

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

    <div id="presupuesto_calculs" class="well">
        <div class="row">
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="presupuesto_base_imponible">Base imponible</label>
                </div>
                <div class="col-md-8">
                  <!--  <input type="text" name="presupuesto_base_imponible" id="presupuesto_base_imponible" class="form-control text-right" readonly> -->
                    <?= Html::textInput('presupuesto_base_imponible','0.00',[
                        'class'=>'form-control text-right',
                        'id'=>'presupuesto_base_imponible',
                            'readonly'=>true]
                            ) ?>
                </div>
            </div>
            
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="presupuesto_rate_descuento">Descuento %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'presupuesto_rate_descuento')->textInput(['maxlength' => true, 'id' => 'presupuesto_rate_descuento'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <input type="text" name="presupuesto_importe_descuento" id="presupuesto_importe_descuento" class="form-control text-right" value="0.00" readonly>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="presupuesto_rate_iva">IVA %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'presupuesto_rate_iva')->textInput(['maxlength' => true, 'id' => 'presupuesto_rate_iva'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <input type="text" name="presupuesto_importe_iva" id="presupuesto_importe_iva" class="form-control text-right" value="0.00" readonly>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="presupuesto_rate_irpf">IRPF %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'presupuesto_rate_irpf')->textInput(['maxlength' => true, 'id' => 'presupuesto_rate_irpf'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <input type="text" name="presupuesto_importe_irpf" id="presupuesto_importe_irpf" class="form-control text-right" value="0.00" readonly>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="presupuesto_total">Total presupuesto</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="presupuesto_total" id="presupuesto_total" class="form-control text-right" value="0.00" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="well">
        <div class="row">
            <?= $form->field($model, 'forma_pago')->textInput(['maxlength' => true, 'id' => 'presupuesto-forma_pago'])->label(false) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'presupuesto_plazo_entrega')->textInput(['maxlength' => true, 'id' => 'presupuesto_plazo_entrega'])->label(false) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'presupuesto_validez')->textInput(['maxlength' => true, 'id' => 'presupuesto_validez', 'value' => '30 días'])->label(false) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'presupuesto_free_one')->textInput(['maxlength' => true, 'id' => 'presupuesto_free_one', 'placeholder' => 'introducir cualquier anotación u observación'])->label(false) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'presupuesto_free_two')->textInput(['maxlength' => true, 'id' => 'presupuesto_free_two', 'placeholder' => 'introducir cualquier anotación u observación'])->label(false) ?>
        </div>
         <div class="row">
            <?= $form->field($model, 'presupuesto_img')->textInput(['maxlength' => true, 'id' => 'presupuesto_free_two', 'placeholder' => 'ruta imágen'])->label(false) ?>
        </div>
    </div>

</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>
