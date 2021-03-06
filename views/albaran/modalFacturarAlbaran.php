<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Factura;


?>
<div class="factura-send">
   

    <h5>
        Rellenar los campos con los datos de la factura.
    </h5>  
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <?php $form = ActiveForm::begin([
                'action' =>'@web/albaran/facturar/'
                ]); ?>

                <?= Html::textInput('num_factura',  Factura::find()->max('factura_num')+1,[
                    'class'=>'form-control',
                    'placeholder' => 'Introducir número de factura' ]) ?>
                <br />
                <?= Html::Input('date','fecha_factura', Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'),[
                    'class'=>'form-control']) ?>
                <br />
                
                <?= Html::Input('hidden','albaran_id', $numAlbaran) ?>
                   
              
                <div class="form-group">
                    <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-1"></div>
    </div>
    
</div>