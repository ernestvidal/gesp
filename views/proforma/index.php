<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\proformaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facturas Proforma';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="proforma-index">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Listado de proformas</h4>
                </div>
                <div class="panel-body">
                    <div class="grid-view">
                        <table class="table table-striped table-bordered">

                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Núm.</th>
                                    <th>Cliente</th>
                                    <th>B.I.</th>
                                    <th>I.IVA</th>
                                    <th>I dto</th>
                                    <th>I irpf</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php $facturador = $model[0]->facturador->identidad_nombre; ?>
                            <?php $año_proforma = substr($model[0]->proforma_fecha, 0, 4); ?>
                            <?php $currentMonth = date("m", strtotime($model[0]->proforma_fecha)); ?>
                            <?php $currentQuarter = ceil($currentMonth / 3); ?>
                            <?php
                            for ($i = 0; $i < count($model); $i++) {

                                if ($facturador <> $model[$i]->facturador->identidad_nombre || $año_proforma <> substr($model[$i]->proforma_fecha, 0, 4) || $currentQuarter <> ceil(date("m", strtotime($model[$i]->proforma_fecha)) / 3)) {
                                    $facturador = $model[$i]->facturador->identidad_nombre;
                                    $año_proforma = substr($model[$i]->proforma_fecha, 0, 4);
                                    $currentQuarter = ceil(date("m", strtotime($model[$i]->proforma_fecha)) / 3);
                                    //echo '<h3>'. $año_proforma . '-'. $facturador . '</h3>';
                                }
                                $baseImponible = 0;
                                $totalIva = 0;
                                $totalFactura = 0;
                                foreach ($model[$i]->proformaitems as $proformaDetalle) {
                                    $totalLinea = $proformaDetalle->item_cantidad * $proformaDetalle->item_precio;
                                    $baseImponible += $totalLinea;
                                    $totalDto = $baseImponible * $model[$i]->proforma_rate_descuento / 100;
                                    $totalIva = $baseImponible * $model[$i]->proforma_rate_iva / 100;
                                    $totalIrpf = $baseImponible * $model[$i]->proforma_rate_irpf / 100;
                                    $totalFactura = $baseImponible + $totalIva - $totalIrpf - $totalDto;
                                }
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?= Yii::$app->formatter->asDate($model[$i]->proforma_fecha, 'php:d-m-Y') ?></td>
                                        <td><?= Html::a($model[$i]->proforma_num, ['view', 'id' => $model[$i]->proforma_id]) ?></td>
                                        <td><?= Html::a($model[$i]->cliente->identidad_nombre, ['reportfacturascliente', 'id' => $model[$i]->cliente->identidad_id]) ?></td>
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($baseImponible, 2); ?></td>
                                        
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIva, 2) ?></td>
                                        
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIrpf, 2) ?></td>
                                        
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalDto, 2) ?></td>
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalFactura, 2); ?></td>

                                        <td><?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model[$i]->proforma_id], ['title' => 'editar'])?></td>
                                        <td><?= Html::a('<i class="glyphicon glyphicon-print"></i>', ['printproforma',
                                            'id' => $model[$i]->proforma_id,
                                            'num' => $model[$i]->proforma_num,
                                            'name' => $model[$i]->cliente->identidad_nombre],
                                            ['title' => 'imprimir'])?></td>
                                        <td><?=
                                            Html::a('<i class="glyphicon glyphicon-duplicate"></i>', '#', [
                                                'id' => 'copy-proforma',
                                                'title' => 'duplicar proforma',
                                                'data-url' => Url::to(['copiarproforma', 'id' => $model[$i]->proforma_id,
                                                    'documento_destino' => 'proforma']),
                                                'data-pjax' => '0',
                                            ])
                                            ?>
                                        </td>
                                        <td><?=
                                            Html::a('<i class="glyphicon glyphicon-copy"></i>', '#', [
                                                'id' => 'copy-factura',
                                                'title' => 'copiar factura',
                                                'data-url' => Url::to(['copiarproforma', 'id' => $model[$i]->proforma_id,
                                                    'documento_destino' => 'factura']),
                                                'data-pjax' => '0',
                                            ])
                                            ?>
                                        </td>
                                        <td><?=
                                            Html::a('<i class="glyphicon glyphicon-envelope"></i>', '#', [
                                                'id' => 'enviar-proforma',
                                                'title' => 'enviar',
                                                //'class' => 'btn btn-success',
                                                //'data-toggle' => 'modal',
                                                //'data-target' => '#modal',
                                                'data-url' => Url::to(['modalsendproforma', 'id' => $model[$i]->proforma_id]),
                                                'data-pjax' => '0',
                                            ]);
                                            ?></td>
                                        <td><?=
                                            Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model[$i]->proforma_id], [
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                                'title' => 'delete'
                                            ])
                                            ?></td>
                                    </tr>
                                </tbody>

                            <?php } ?>   

                        </table>
                    </div>
                </div>
            </div>
        </div>
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
        );
        ?>

        <?php
        // Ventana modal donde mostramos la vista modalSendFactura.php
        Modal::begin([
            'header' => '<h2>Enviar Factura</h2>',
            'id' => 'modalSendFactura',
        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        ?>       

        <?php
        
        /*
         * Javascript y ventana modal donde mostramos la vista llamada desde el
         * link #copiar-proforma y #copy-factura
         */
        
        $this->registerJs(
                "$(document).on('click', '#copy-proforma , #copy-factura', (function() {
                $.get(
                    $(this).data('url'),
                    function (data) {
                        $('.modal-body').html(data);
                        $('#modal-proforma').modal();
                    }
                );
            }));"
        );

        Modal::begin([
            'header' => '<h2>Copiar Proforma</h2>',
            'id' => 'modal-proforma',
        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        ?>
    </div>
