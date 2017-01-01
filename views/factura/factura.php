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
 * Lo había puesto en AppAsset, pero como tiene funciones comunes con factura.js 
 * y prespuesto.js algunas de las funciones eran ejecutadas varias veces 
 */
$this->registerJsFile('@web/js/factura.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Nueva Factura';
$this->params['breadcrumbs'][] = ['label' => 'Facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="factura-form">

<?php $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>
    <div id="factura_cap">
        <div>
            <div id="facturador" class="col-md-6 well">
                <div class="col-md-12">

<?=
$form->field($model, 'facturador_id')->dropDownList(
        ArrayHelper::map(Identidad::findAll(['identidad_role' => 'FACTURADOR']), 'identidad_id', 'identidad_nombre'), ['options' => [ 5 => ['selected ' => true]]], ['prompt' => 'Quien va a facturar...', 'id' => 'facturador_id', 'class' => 'form-control',
    'onchange' => '$("#' . Html::getInputId($model, 'forma_pago') . '").val())'
])
?>
                </div>
            </div>
            <div id="cliente" class="col-md-6 well">
                <div class="col-md-12">
<?=
$form->field($model, 'cliente_id')->dropDownList(
        ArrayHelper::map(Identidad::findAll(['identidad_role' => ['CLIENTE', 'AMBOS']]), 'identidad_id', 'identidad_nombre'), ['prompt' => 'A quien se va a facturar...', 'id' => 'cliente_id', 'class' => 'form-control'])
?>
                </div>
            </div>
        </div>
        <div class="well">
            <div class="row">
                <div class="col-md-3 col-md-offset-9">
<?= $form->field($model, 'factura_num')->textInput(['maxlength' => true, 'id' => 'factura_num']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-9">
<?= $form->field($model, 'factura_fecha')->textInput(['maxlength' => true, 'type' => 'date', 'value' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd')]) ?>
                </div>
            </div>
        </div>

    </div>
    <div id="factura_cos" class="well">
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
            <div id="line_0" class="row factura_line">
                <div class="col-md-2">
                    <input type="text" name="FacturaItem[0][item_cantidad]" id="item_cantidad_0" class="form-control text-right" value="0.00" required>
                </div>
                <div class="col-md-5">
                    <textarea name="FacturaItem[0][item_descripcion]" id="item_descripcion_0" class="form-control" data-autoresize rows="2"></textarea>
                </div>
                <div class="col-md-2">
                    <input type="text" name="FacturaItem[0][item_precio]" id="item_precio_0" class="form-control text-right" value="0.00">
                </div>
                <div class="col-md-2">
                    <input type="text" name="item_total_0" id="item_total_0" class="form-control text-right item_total" value="0.00" readonly>
                </div>
                <div class="col-md-1">
                    <input type="hidden" name="FacturaItem[0][factura_num]" id="factura_item_num_0">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <h3 id="add_item_line"> [ + ]</h3>
            </div>
        </div>
    </div>

    <div id="factura_calculs" class="well">
        <div class="row">
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="factura_subtotal">Total</label>
                </div>
                <div class="col-md-8">
                    <?=
                    Html::textInput('factura_subtotal', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'factura_subtotal',
                        'readonly' => true]
                    )
                    ?>
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="factura_rate_descuento">Descuento %</label>
                </div>
                <div class="col-md-3">
                    <?=
                    $form->field($model, 'factura_rate_descuento')->textInput([
                        'maxlength' => true,
                        'value' => '0.00',
                        'id' => 'factura_rate_descuento',
                        ])->label(false)
                    ?>
                </div>
                <div class="col-md-5">
                    <?=
                    Html::textInput('factura_importe_descuento', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'factura_importe_descuento',
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
                    Html::textInput('factura_base_imponible', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'factura_base_imponible',
                        'readonly' => true]
                    )
                    ?>
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="factura_rate_iva">IVA %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'factura_rate_iva')->textInput(['maxlength' => true, 'value' => '0.00', 'id' => 'factura_rate_iva'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?=
                    Html::textInput('factura_importe_iva', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'factura_importe_iva',
                        'readonly' => true]
                    )
                    ?>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="factura_rate_irpf">IRPF %</label>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'factura_rate_irpf')->textInput(['maxlength' => true, 'value' => '0.00', 'id' => 'factura_rate_irpf'])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?=
                    Html::textInput('factura_importe_irpf', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'factura_importe_irpf',
                        'readonly' => true]
                    )
                    ?>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="factura_total">Total factura</label>
                </div>
                <div class="col-md-8">
                    <?=
                    Html::textInput('factura_total', '0.00', [
                        'class' => 'form-control text-right',
                        'id' => 'factura_total',
                        'readonly' => true]
                    )
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="well">
        <div class="row">
            <div class="col-lg-12">
                <?=
                $form->field($model, 'forma_pago')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'factura-forma_pago',
                            'placeholder' => 'forma de pago'
                ])->label(false)
                ?>
            </div>

        </div>
   
   
        <div class="row">
            <div class="col-lg-6"><?=
                $form->field($model, 'factura_vto')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'factura-vto',
                            'placeholder' => 'vencimiento factura'
                ])->label(false)
                ?>
            </div>
            <div class="col-lg-6"><?=
                $form->field($model, 'factura_vto_importe')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'factura-vto-importe',
                            'placeholder' => 'importe'
                ])->label(false)
                ?></div>
        </div>
   
    
        <div class="row">
            <div class="col-lg-6"><?=
                $form->field($model, 'factura_vto_dos')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'factura-vto-dos',
                            'placeholder' => 'vencimiento factura',
                ])->label(false)
                ?></div>
            <div class="col-lg-6"><?=
                $form->field($model, 'factura_vto_dos_importe')->textInput(
                        [
                            'maxlength' => true,
                            'id' => 'factura-vto-dos-importe',
                            'placeholder' => 'importe vencimiento'
                ])->label(false)
                ?></div>
        </div>
    </div>
</div>
<div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
