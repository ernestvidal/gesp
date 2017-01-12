<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\proformaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facturas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="proforma-index">

    <?php $facturador = $model[0]->facturador->identidad_nombre; ?>
    <?php $año_proforma = substr($model[0]->proforma_fecha, 0,4); ?>
    <?php $currentMonth = date("m", strtotime($model[0]->proforma_fecha)); ?>
    <?php $currentQuarter = ceil($currentMonth/3); ?>
    <h3 class="page-header"><?= $model[0]->cliente->identidad_nombre ?></h3>
    <?php for ($i = 0; $i < count($model); $i++) {
        

        if ($facturador <> $model[$i]->facturador->identidad_nombre || $año_proforma <> substr($model[$i]->proforma_fecha, 0,4)
                || $currentQuarter <> ceil(date("m", strtotime($model[$i]->proforma_fecha))/3))
        {
            $facturador = $model[$i]->facturador->identidad_nombre;
            $año_proforma = substr($model[$i]->proforma_fecha, 0,4);
            $currentQuarter = ceil(date("m", strtotime($model[$i]->proforma_fecha))/3);
            //echo '<h3>'. $año_proforma . '-'. $facturador . '</h3>';
        }
        $baseImponible = 0;
        $totalIva = 0;
        $totalFactura = 0;
        foreach ($model[$i]->proformaitems as $proformaDetalle) {
           $totalLinea = $proformaDetalle->item_cantidad * $proformaDetalle->item_precio;
           $baseImponible += $totalLinea;
           $totalDto = $baseImponible * $model[$i]->proforma_rate_descuento/100;
           $totalIva = $baseImponible * $model[$i]->proforma_rate_iva/100;
           $totalIrpf = $baseImponible * $model[$i]->proforma_rate_irpf/100;
           $totalFactura = $baseImponible + $totalIva - $totalIrpf - $totalDto;
        } ?>
        <div class="row">
            <div class="col-lg-3"><h5><strong> Factura núm.: <?= $model[$i]->proforma_num; ?></strong></h5></div>
            <div class="col-lg-2"><h5><strong><?= Yii::$app->formatter->asDate($model[$i]->proforma_fecha, 'php:d-m-Y') ?></strong></h5></div>
            
            
            <!--<div class="col-md-3"><?= Yii::$app->formatter->asDecimal($baseImponible, 2); ?></div> -->
            <!--<div class="col-md-3"><?= Yii::$app->formatter->asDecimal($totalFactura, 2); ?></div> -->           
        </div>
         <?php     foreach ($model[$i]['proformaitems'] as $itemproforma) { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1"><?= $itemproforma->item_cantidad ?></div>
                        <div class="col-lg-9"><?= Yii::$app->formatter->asNtext($itemproforma->item_descripcion) ?></div>
                        <div class="col-lg-2"><?= $itemproforma->item_precio ?></div>
                    </div>
                    <hr>
                </div>
            <?php } ?>
   
    <?php

    $this->registerJs(

        "$(document).on('click', '#enviar-proforma', (function() {
            $.get(
                $(this).data('url'),
                function (data) {
                    $('.modal-body').html(data);
                    $('#modalSendFactura').modal();
                }
            );
        }));"

    ); ?>

    <?php
        // Ventana modal donde mostramos la vista modalSendFactura.php
        Modal::begin([
            'header' => '<h2>Enviar Factura</h2>',
            'id'     => 'modalSendFactura',

        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        } ?>
</div>
