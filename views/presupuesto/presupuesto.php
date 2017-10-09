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
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto */
/* @var $form yii\widgets\ActiveForm */

/* Cargamos pedido.js solamente para esta vista después de que se cargue Jquery
 * Lo había puesto en AppAsset, pero como tiene funciones comunes con factura.js 
 * y prespuesto.js algunas de las funciones eran ejecutadas varias veces 
 */
$this->registerJsFile('@web/js/presupuesto.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Nuevo';
$this->params['breadcrumbs'][] = ['label' => 'Presupuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="presupuesto-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
    
    <div id="presupuesto_cap">
        <div>
            <div id="presupuestador" class="col-md-6 well">
                <div class="col-md-12">
                    <?= $form->field($model, 'facturador_id')->dropDownList(
                            ArrayHelper::map(Identidad::findAll(['identidad_role' => 'FACTURADOR']), 'identidad_id', 'identidad_nombre'),
                            ['options' => [ 5 => ['selected ' => true]]],
                            ['prompt'=>'Quien va a facturar...', 'id'=>'facturador_id', 'class'=>'form-control',
                            'onchange'=> '$("#'.Html::getInputId($model, 'forma_pago').'").val())'
                            ]) ?>
                </div>
            </div>
            <div id="cliente" class="col-md-6 well">
                <div class="col-md-12">
                    <?=
                            //$form->field($model, 'cliente_id')->dropDownList(
                            //ArrayHelper::map(Identidad::findAll(['identidad_role'=>['CLIENTE','CAPTACION']]), 'identidad_id', 'identidad_nombre'),
                            //['prompt'=>'A quien se va a facturar...', 'id'=>'cliente_id', 'class'=>'form-control'])
            
                            $form->field($model, 'cliente_id')->widget(Select2::className(),[
                            'data'=> ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'),
                            'options'=>['placeholder'=>'Seleccionar'],
                            'pluginOptions'=>[
                            'allowClear'=>true
                            ],
                            'id' => 'item_identidad_id',
                            'class' => 'form-control'
                             ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="well">
            <div class="row">
                <div class="col-md-3 col-md-offset-9">
                    <?= $form->field($model, 'presupuesto_num')->textInput(['maxlength' => true, 'id'=>'presupuesto_num',
                        'value'=>'2017.'. substr('000'.(substr($model->find()->max('presupuesto_num'), 5)+1),-3,3)
                        ]) ?>
                </div>
              </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-9">
                     <?= $form->field($model, 'presupuesto_fecha')->textInput(['maxlength' => true, 'type'=>'date', 'value'=>Yii::$app->formatter->asDate('now', 'yyyy-MM-dd')]) ?>
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
            <div id="line_0" class="row presupuesto_line">
                <div class="col-md-2">
                    <input type="text" name="PresupuestoItem[0][item_cantidad]" id="item_cantidad_0" class="form-control text-right" value="0.00" required/>
                </div>
                <div class="col-md-5">
                    <textarea name="PresupuestoItem[0][item_descripcion]" id="item_descripcion_0" class="form-control" required></textarea>
                </div>
                <div class="col-md-2">
                    <input type="text" name="PresupuestoItem[0][item_precio]" id="item_precio_0" class="form-control text-right" value="0.00" required/>
                </div>
                <div class="col-md-2">
                     <input type="text" name="item_total_0" id="item_total_0" class="form-control text-right item_total" value="0.00" readonly>
                </div>
                <div class="col-md-1">
                    <input type="hidden" name="PresupuestoItem[0][presupuesto_num]" id="presupuesto_item_num_0">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <h3 id="add_item_line"> [ + ]</h3>
            </div>
        </div>
    </div>

    <div id="presupuesto_calculs">
        <div class="row">
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                    <label for="presupuesto_base_imponible">Base imponible</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="presupuesto_base_imponible" id="presupuesto_base_imponible" class="form-control text-right" readonly>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4">
                     <label for="presupuesto_rate_descuento">Descuento %</label>
                </div>
                <div class="col-md-3">
                     <?= $form->field($model, 'presupuesto_rate_descuento')->textInput(['maxlength' => true, 'value'=>'0.00', 'id'=>'presupuesto_rate_descuento'])->label(false) ?>
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
                    <?= $form->field($model, 'presupuesto_rate_iva')->textInput(['maxlength' => true, 'value'=>'0.00', 'id'=>'presupuesto_rate_iva'])->label(false) ?>
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
                    <?= $form->field($model, 'presupuesto_rate_irpf')->textInput(['maxlength' => true, 'value'=>'0.00', 'id'=>'presupuesto_rate_irpf'])->label(false) ?>
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
           <?= $form->field($model, 'forma_pago')->textInput(['maxlength' =>true, 'id'=>'presupuesto-forma_pago', 'value'=>'TRANSFERENCIA CTA. ES39 1465 0100 9619 0045 6354 ING DIRECT'])->label(false) ?>
        </div>
   
        <div class="row">
           <?= $form->field($model, 'presupuesto_plazo_entrega')->textInput(['maxlength' =>true, 'id'=>'presupuesto_plazo_entrega', 'value'=>'10 días aprobación boceto y realizado el pago'])->label(false) ?>
        </div>
   
        <div class="row">
           <?= $form->field($model, 'presupuesto_validez')->textInput(['maxlength' =>true, 'id'=>'presupuesto_validez', 'value'=>'30 días'])->label(false) ?>
        </div>
    
        <div class="row">
           <?= $form->field($model, 'presupuesto_free_one')->textInput(['maxlength' =>true, 'id'=>'presupuesto_free_one', 'placeholder'=>'introducir cualquier anotación u observación'])->label(false) ?>
        </div>
    
        <div class="row">
           <?= $form->field($model, 'presupuesto_free_two')->textInput(['maxlength' =>true, 'id'=>'presupuesto_free_two', 'placeholder'=>'introducir cualquier anotación u observación'])->label(false) ?>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>
