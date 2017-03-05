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
/* @var $model app\models\Factura */
/* @var $form yii\widgets\ActiveForm */

/* Cargamos pedido.js solamente para esta vista después de que se cargue Jquery
 * Lo había puesto en AppAsset, pero como tiene funciones comunes con proforma.js 
 * y prespuesto.js algunas de las funciones eran ejecutadas varias veces 
 */
$this->registerJsFile('@web/js/proforma.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Editar Factura';
$this->params['breadcrumbs'][] = ['label' => 'Facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="proforma-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
    <div id="proforma_cap">
        <div>
            <div id="facturador" class="col-md-6 well">
                <div class="col-md-12">
                    <?=
                    $form->field($model, 'facturador_id')->dropDownList(
                            ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'), [
                        'prompt' => 'Quien va a facturar...',
                        'id' => 'facturador_id',
                        'class' => 'form-control',
                        'onchange' => '$("#' . Html::getInputId($model, 'proforma_forma_pago') . '").val())'
                    ])
                    ?>
                </div>
            </div>
            <div id="cliente" class="col-md-6 well">
                <div class="col-md-12">
                    <?=
                    $form->field($model, 'cliente_id')->dropDownList(
                            ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'), ['prompt' => 'A quien se va a facturar...', 'id' => 'cliente_id', 'class' => 'form-control'])
                    ?>
                </div>
            </div>
        </div>
        <div class="well">
            <div class="row">
                <div class="col-lg-2 col-xs-2">
                    <span class="form-control text-center">Factura num.</span>
                </div>
                <div class="col-lg-4 col-xs-4">
                    <?= $form->field($model, 'proforma_num')->textInput(['maxlength' => true, 'id' => 'proforma_num'])->label(false) ?>
                </div>

                <div class="col-lg-2 col-xs-2">
                    <span class="form-control text-center">Fecha</span>
                </div>
                <div class="col-lg-4 col-xs-4">
                    <?= $form->field($model, 'proforma_fecha')->textInput(['maxlength' => true, 'type' => 'date'])->label(false) ?>
                </div>
            </div>
        </div>

    </div>
    <div id="proforma_cos" class="well">
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
            $count = count($model['proformaitems']);
            //var_dump($model['proformaitems']);

            for ($i = 0; $i < $count; $i++) {
                echo "<div id='line_$i' class='row proforma_line'>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='ProformaItem[$i][item_cantidad]' id='item_cantidad_" . $i . "' class='form-control text-right' value='" . $model['proformaitems'][$i]['item_cantidad'] . "'  >";
                echo "</div>";

                echo "<div class='col-md-5'>";
                echo "<textarea name='ProformaItem[$i][item_descripcion]' id='item_descripcion_" . $i . "' class='form-control'>" . $model['proformaitems'][$i]['item_descripcion'] . "</textarea>";
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='ProformaItem[$i][item_precio]' id='item_precio_" . $i . "' class='form-control text-right' value=" . $model['proformaitems'][$i]['item_precio'] . " >";
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo "<input type='text' name='ProformaItem[$i][item_total]' id='item_total_" . $i . "' class='form-control text-right'  readonly >";
                echo "</div>";


                /*
                  echo " <div class='col-md-1'>";
                  echo "<a href='javascript:borrar($i)'>[ x ]</a>";
                  echo " </div> ";
                 */


                echo " <div class='col-md-1'>";



                echo Html::a('[ x ]',['proformaitem/delete',
                    'id' => $model['proformaitems'][$i]['proforma_id'],'num_factura'=>$model['proformaitems'][$i]['proforma_num'],'id_proforma'=>$model['proforma_id']],
                    [
                    'title' => 'delete',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);


                echo " </div> ";

                /* Este campo es necesario. Se pasa junto con los demás al controlador.
                 * El controlador lo utiliza para conocer el número de proforma utilizado en la cabecera
                 * y guardar - editar  el mismo en el cuerpo de la misma para que queden relacionados.
                 */
                echo " <input type='hidden' name='ProformaItem[$i][proforma_id]'  id='proforma_item_id_" . $i . "' value='" . $model['proformaitems'][$i]['proforma_id'] . "' >";
                echo " <input type='hidden' name='ProformaItem[$i][proforma_num]'  id='proforma_item_num_" . $i . "'>";

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

    <div id="proforma_calculs" class="well">
        <div class="row">
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="proforma_subtotal">Taotal</label>
                </div>
                <div class="col-md-8">
                    <?=
                    Html::textInput('proforma_subtotal', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'proforma_subtotal',
                        'readonly' => true])
                    ?>
                    <div class="help-block"></div>
                </div>
            </div>

            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="proforma_rate_descuento">Descuento %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'proforma_rate_descuento')->textInput(['maxlength' => true, 'id' => 'proforma_rate_descuento'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?=
                    Html::textInput('proforma_importe_descuento', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'proforma_importe_descuento',
                        'readonly' => true]
                    )
                    ?>

                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="factura_base_imponible">Base imponible</label>
                </div>
                <div class="col-md-8">
                    <?=
                    Html::textInput('proforma_base_imponible', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'proforma_base_imponible',
                        'readonly' => true]
                    )
                    ?>
                    <div class="help-block"></div>

                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="proforma_rate_iva">IVA %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'proforma_rate_iva')->textInput(['maxlength' => true, 'id' => 'proforma_rate_iva'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?=
                    Html::textInput('proforma_importe_iva', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'proforma_importe_iva',
                        'readonly' => true]
                    )
                    ?>

                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="proforma_rate_irpf">IRPF %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'proforma_rate_irpf')->textInput(['maxlength' => true, 'id' => 'proforma_rate_irpf'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?=
                    Html::textInput('proforma_importe_irpf', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'proforma_importe_irpf',
                        'readonly' => true]
                    )
                    ?>

                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="proforma_total">Total proforma</label>
                </div>
                <div class="col-md-8">
                    <?=
                    Html::textInput('proforma_total', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'proforma_total',
                        'readonly' => true]
                    )
                    ?>

                </div>
            </div>
        </div>
    </div>
    <div class="well">
        <div class="row">
             <div class="row">
             <div class="col-lg-12">
           <?= $form->field($model, 'proforma_plazo_entrega')->textInput(['maxlength' =>true, 'id'=>'proforma_plazo_entrega', 'placeholder'=>'introduce .....'])->label(false) ?>
             </div>
        </div>
   <div class="col-lg-12">
        <div class="row">
            
           <?= $form->field($model, 'proforma_validez')->textInput(['maxlength' =>true, 'id'=>'proforma_validez', 'placeholder'=>'introduce .....'])->label(false) ?>
        </div>
        </div>
            <div class="col-lg-12">
                <?=
                $form->field($model, 'proforma_forma_pago')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'proforma_forma_pago',
                            'placeholder' => 'forma de pago'
                ])->label(false)
                ?>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <span class="form-control text-center">vto.factura</span>
            </div>
            <div class="col-lg-4 col-xs-4">

                <?=
                $form->field($model, 'proforma_vto')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'proforma-vto',
                            'type' => 'date'
                ])->label(false)
                ?>
            </div>
            <div class="col-lg-6 col-xs-6"><?=
                $form->field($model, 'proforma_vto_importe')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'proforma-vto-importe',
                            'placeholder' => 'importe'
                ])->label(false)
                ?></div>
        </div>


        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <span class="form-control text-center">vto.factura</span>
            </div>
            <div class="col-lg-4 col-xs-4"><?=
                $form->field($model, 'proforma_vto_dos')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'proforma-vto-dos',
                            'type' => 'date'
                ])->label(false)
                ?></div>
            <div class="col-lg-6 col-xs-6"><?=
                $form->field($model, 'proforma_vto_dos_importe')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'proforma-vto-dos-importe',
                            'placeholder' => 'importe vencimiento'
                ])->label(false)
                ?></div>

        </div>


        <div class="row">
            <div class="col-lg-12">
                <?=
                $form->field($model, 'proforma_cta')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'proforma_cta',
                            'placeholder' => 'nu. cta.'
                ])->label(false)
                ?>

            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
