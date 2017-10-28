<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->registerJsFile('@web/js/etiquetas.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="etiquetas-form">
    <div class="container">
        <div class="page-header">
            <h1>Tarificación etiquetas<small>Subtext for header</small></h1>
        </div>

        <?php $form = ActiveForm::begin(['action'=>'valorar', 'method'=>'post']); ?>
        
        <div class="row">
            <div class="col-lg-2 col-sm-2"><h3>Sistema Impresión</h3></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'sistema_impresion')->dropDownList([
                'offset'=>'Offset',
                'toner'=>'Laser toner',
                'serigrafia'=>'Serigrafia'],
                ['id'=>'sistema_impresion',
                    'prompt'=>'Select ....',
                 'onchange'=>'$.get( "'.Url::toRoute('etiquetas/dataprinting').'", { tipoImpresion: $(this).val() })
                                        .done(function( data ) { 
                                        data
                                        $( "#tipo_material" ).html(data);} );'
                    
                
            ])?></div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-sm-2"><h3>Etiquetas</h3></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'tipo_material')->dropDownList([
                ],
                [
                'id'=>'tipo_material',
                'prompt'=>'Select',
                'onchange'=>'$.get( "'.Url::toRoute('etiquetas/tipomaterial').'", { tipo_material: $(this).val(), tipo_impresion: $(this.form.sistema_impresion).val() })
                                        .done(function( data ) { 
                                        $("#ancho_soporte" ).val( data.ancho );
                                        $("#largo_soporte" ).val( data.largo );
                                        $("#coste_impresion" ).val( data.coste );
                                        
                                        
                                        } );'
                ]) ?></div>

        </div>
        
        <div class="row">
            <div class="col-lg-2 col-sm-2"><h3>Etiquetas</h3></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'ancho_etiqueta')->textInput(['id' => 'ancho_etiqueta','value'=>0])->label('Ancho mm.') ?></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'largo_etiqueta')->textInput(['id' => 'largo_etiqueta','value'=>0])->label('Largo mm.') ?></div>

        </div>

        <div class="row">
            <div class="col-lg-2 col-sm-2"><h3>Soporte</h3></div>
            <div class="col-lg-2 col-sm-2"><?=  $form->field($model, 'ancho_soporte')->textInput(['id' => 'ancho_soporte'])->label('Ancho mm') ?></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'largo_soporte')->textInput(['id' => 'largo_soporte'])->label('Largo mm') ?></div>

        </div>

        <div class="row">
            <div class="col-lg-2 col-sm-2"><h3>Costes</h3></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'coste_impresion')->textInput(['id' => 'coste_impresion', 'value' => 0])->label('Impresión') ?></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'precio_soporte')->textInput(['id' => 'precio_soporte', 'value' => 0])->label('Soporte M2') ?></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'coste_corte')->textInput(['id' => 'coste_corte', 'value' => 0.00])->label('Corte ml') ?></div>
            <div class="col-lg-2 col-sm-2"><?= $form->field($model, 'coste_transporte')->textInput(['id' => 'coste_transporte', 'value'=>0])->label('Transporte') ?></div>

        </div>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

        <section id="resultados">
            <div class="page-header">
                <h1>Resultado Tarificación<small> etiquetas</small></h1>
            </div>
            <div class="row">
                <span class="col-lg-2">Núm. uds.</span>
                <span class="col-lg-1">Impresión</span>
                <span class="col-lg-1">Soporte</span>
                <span class="col-lg-1">Corte</span>
                <span class="col-lg-1">Total</span>
            </div>
            <hr>
            <div class="row">
                <span class="col-lg-2">Tarifa 500 uds.</span>
                <span id="500costeUnidadImpresion" class="col-lg-1"></span>
                <span id="500costeUnidadSoporte" class="col-lg-1"></span>
                <span id="500costeUnidadCorte" class="col-lg-1"></span>
                <span id="500coste" class="col-lg-1"></span>
            </div>
            <hr>
            <div class="row">
                <span class="col-lg-2">Tarifa 1.000 uds.</span>
                <span id="1000costeUnidadImpresion" class="col-lg-1"></span>
                <span id="1000costeUnidadSoporte" class="col-lg-1"></span>
                <span id="1000costeUnidadCorte" class="col-lg-1"></span>
                <span id="1000coste" class="col-lg-1"></span>
            </div>
            <hr>
            <div class="row">
                <span class="col-lg-2">Tarifa 2.000 uds.</span>
                <span id="2000costeUnidadImpresion" class="col-lg-1"></span>
                <span id="2000costeUnidadSoporte" class="col-lg-1"></span>
                <span id="2000costeUnidadCorte" class="col-lg-1"></span>
                <span id="2000coste" class="col-lg-1"></span>
            </div>
            <hr>
            <div class="row">
            <span class="col-lg-2">Tarifa 5.000 uds.</span>
            <span id="5000costeUnidadImpresion" class="col-lg-1"></span>
            <span id="5000costeUnidadSoporte" class="col-lg-1"></span>
            <span id="5000costeUnidadCorte" class="col-lg-1"></span>
            <span id="5000coste" class="col-lg-1"></span>
            </div>
            <hr>
            <div class="row">
                <span class="col-lg-2">Tarifa 10.000 uds.</span>
                <span id="10000costeUnidadImpresion" class="col-lg-1"></span>
                <span id="10000costeUnidadSoporte" class="col-lg-1"></span>
                <span id="10000costeUnidadCorte" class="col-lg-1"></span>
                <span id="10000coste" class="col-lg-1"></span>
            </div>
            <hr>

        </section>    
    </div>
</div><!-- form -->

