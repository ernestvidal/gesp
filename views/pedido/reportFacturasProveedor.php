<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\facturaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facturas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="factura-index">

    <?php $facturador = $model[0]->facturador->identidad_nombre; ?>
    <?php $año_factura = substr($model[0]->factura_fecha, 0,4); ?>
    <?php $currentMonth = date("m", strtotime($model[0]->factura_fecha)); ?>
    <?php $currentQuarter = ceil($currentMonth/3); ?>
    <h3 class="page-header"><?= $model[0]->cliente->identidad_nombre ?></h3>
    <?php for ($i = 0; $i < count($model); $i++) {
        

        if ($facturador <> $model[$i]->facturador->identidad_nombre || $año_factura <> substr($model[$i]->factura_fecha, 0,4)
                || $currentQuarter <> ceil(date("m", strtotime($model[$i]->factura_fecha))/3))
        {
            $facturador = $model[$i]->facturador->identidad_nombre;
            $año_factura = substr($model[$i]->factura_fecha, 0,4);
            $currentQuarter = ceil(date("m", strtotime($model[$i]->factura_fecha))/3);
            //echo '<h3>'. $año_factura . '-'. $facturador . '</h3>';
        }
        $baseImponible = 0;
        $totalIva = 0;
        $totalFactura = 0;
        foreach ($model[$i]->facturaitems as $facturaDetalle) {
           $totalLinea = $facturaDetalle->item_cantidad * $facturaDetalle->item_precio;
           $baseImponible += $totalLinea;
           $totalDto = $baseImponible * $model[$i]->factura_rate_descuento/100;
           $totalIva = $baseImponible * $model[$i]->factura_rate_iva/100;
           $totalIrpf = $baseImponible * $model[$i]->factura_rate_irpf/100;
           $totalFactura = $baseImponible + $totalIva - $totalIrpf - $totalDto;
        } ?>
        <div class="row">
            <div class="col-lg-3"><h5><strong> Factura núm.: <?= $model[$i]->factura_num; ?></strong></h5></div>
            <div class="col-lg-2"><h5><strong><?= Yii::$app->formatter->asDate($model[$i]->factura_fecha, 'php:d-m-Y') ?></strong></h5></div>
            
            
            <!--<div class="col-md-3"><?= Yii::$app->formatter->asDecimal($baseImponible, 2); ?></div> -->
            <!--<div class="col-md-3"><?= Yii::$app->formatter->asDecimal($totalFactura, 2); ?></div> -->           
        </div>
         <?php     foreach ($model[$i]['facturaitems'] as $itemfactura) { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1"><?= $itemfactura->item_cantidad ?></div>
                        <div class="col-lg-9"><?= Yii::$app->formatter->asNtext($itemfactura->item_descripcion) ?></div>
                        <div class="col-lg-2"><?= $itemfactura->item_precio ?></div>
                    </div>
                    <hr>
                </div>
            <?php } ?>
   
    <?php

    $this->registerJs(

        "$(document).on('click', '#enviar-factura', (function() {
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
