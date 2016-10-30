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
    <h3><?=  $año_factura .'-'. $facturador; ?></h3>
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
           $totalIva = $baseImponible * $model[$i]->factura_rate_iva/100;
           $totalIrpf = $baseImponible * $model[$i]->factura_rate_irpf/100;
           $totalFactura = $baseImponible + $totalIva - $totalIrpf;
        } ?>
        <div class="row">
            <div class="col-md-2"><?= Yii::$app->formatter->asDate($model[$i]->factura_fecha, 'php:d-m-Y').'&nbsp &nbsp '.$model[$i]->factura_num; ?></div>
            <div class="col-md-3"><?= $model[$i]->cliente->identidad_nombre; ?></div>
            <div class="col-md-1"><?= Yii::$app->formatter->asDecimal($baseImponible, 2); ?></div>
            <div class="col-md-3"><?= $model[$i]->factura_rate_iva .' % &nbsp &nbsp'. Yii::$app->formatter->asDecimal($totalIva, 2). '&nbsp &nbsp '.$model[$i]->factura_rate_irpf .' % &nbsp &nbsp'. Yii::$app->formatter->asDecimal($totalIrpf, 2); ?></div>
            <div class="col-md-1"><?= Yii::$app->formatter->asDecimal($totalFactura, 2); ?></div>
            <div class="col-md-2">
                <!-- Split button -->
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle btn-sm" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                       <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                       opciones
                    </button>

                  <ul class="dropdown-menu">
                    <li><a href="view/<?= $model[$i]->factura_id; ?>"><i class="glyphicon glyphicon-search" aria-hidden="true"> ver factura </i></a></li>
                    <li><a href="update/<?= $model[$i]->factura_id; ?>"><i class="glyphicon glyphicon-search" aria-hidden="true"> editar </i></a></li>
                    <li><a  href="printfactura/<?= $model[$i]->factura_id; ?>"><i class="glyphicon glyphicon-print" aria-hidden="true"> Imprimir factura pdf </i></a></li>
                    <li><a id="modal_link" class="sendFacturaButton" href="modalsendfactura/<?= $model[$i]->factura_id; ?>" value="modalsendfactura/<?= $model[$i]->factura_id; ?>"><i class="glyphicon glyphicon-envelope" aria-hidden="true"> Enviar factura </i></a></li>
                    <li>
                        <?= Html::a('<i class="glyphicon glyphicon-envelope"></i> Enviar factura', '#', [

                            'id' => 'enviar-factura',
                            'class' => 'btn btn-success',
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'data-url' => Url::to(['modalsendfactura', 'id'=>$model[$i]->factura_id]),
                            'data-pjax' => '0',
                        ]); ?>
                        
                       
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><?= Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', ['delete', 'id' => $model[$i]->factura_id], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                    </li>
                  </ul>
                </div>
            </div>
        </div>
    
   
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
        // Ventana modal para introducir los datos para enviar la factura por correo
        Modal::begin([
            'header' => '<h2>Enviar Factura</h2>',
            'id'     => 'modalSendFactura',

        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        } ?>
</div>
