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
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><strong>Listado de facturas | </strong></span>
                    <span>
                        <?= Html::a('Nueva', ['create']) ?>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="grid-view">
                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Núm.</th>
                                    <th>Cliente</th>
                                    <th>B.I.</th>
                                    <th>% IVA</th>
                                    <th>I.IVA</th>
                                    <th>% DTO</th>
                                    <th>I dto</th>
                                    <th>% irpf</th>
                                    <th>I irpf</th>
                                    <th>Total</th>
                                    <th>CRF</th>
                                    <th>CRP</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php $facturador = $model[0]->facturador->identidad_nombre; ?>
                            <?php $año_factura = substr($model[0]->factura_fecha, 0, 4); ?>
                            <?php $currentMonth = date("m", strtotime($model[0]->factura_fecha)); ?>
                            <?php $currentQuarter = ceil($currentMonth / 3); ?>
                            <?php
                            for ($i = 0; $i < count($model); $i++) {

                                if ($facturador <> $model[$i]->facturador->identidad_nombre || $año_factura <> substr($model[$i]->factura_fecha, 0, 4) || $currentQuarter <> ceil(date("m", strtotime($model[$i]->factura_fecha)) / 3)) {
                                    $facturador = $model[$i]->facturador->identidad_nombre;
                                    $año_factura = substr($model[$i]->factura_fecha, 0, 4);
                                    $currentQuarter = ceil(date("m", strtotime($model[$i]->factura_fecha)) / 3);
                                    //echo '<h3>'. $año_factura . '-'. $facturador . '</h3>';
                                }
                                $baseImponible = 0;
                                $totalIva = 0;
                                $totalFactura = 0;
                                foreach ($model[$i]->facturaitems as $facturaDetalle) {
                                    $totalLinea = $facturaDetalle->item_cantidad * $facturaDetalle->item_precio;
                                    $baseImponible += $totalLinea;
                                    $totalDto = $baseImponible * $model[$i]->factura_rate_descuento / 100;
                                    $totalIva = $baseImponible * $model[$i]->factura_rate_iva / 100;
                                    $totalIrpf = $baseImponible * $model[$i]->factura_rate_irpf / 100;
                                    $totalFactura = $baseImponible + $totalIva - $totalIrpf - $totalDto;
                                }
                                ?>
                            <tbody>
                                <?php if ($model[$i]->factura_fecha_envio == NULL){
                                    echo "<tr class='bg-danger'>";
                                }else{
                                    echo "<tr>";
                                } ?>
                                    <td><?= Yii::$app->formatter->asDate($model[$i]->factura_fecha, 'php:d-m-Y') ?></td>
                                    <td><?= Html::a($model[$i]->factura_num, ['view', 'id' => $model[$i]->factura_id]) ?></td>
                                    <td><?= Html::a($model[$i]->cliente->identidad_nombre, ['reportfacturascliente', 'id' => $model[$i]->cliente->identidad_id]) ?></td>
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($baseImponible, 2); ?></td>
                                    <td class="text-right"><?= $model[$i]->factura_rate_iva ?> %</td>
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIva, 2) ?></td>
                                    <td class="text-right"><?= $model[$i]->factura_rate_irpf ?> %</td>
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIrpf, 2) ?></td>
                                    <td class="text-right"><?= $model[$i]->factura_rate_descuento ?> %</td>
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalDto, 2) ?></td>
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalFactura, 2); ?></td>
                                    <td class="text-center"><?php if ($model[$i]->factura_fecha_recepcion==NULL){
                                            echo Html::a('<i class="glyphicon glyphicon-remove text-danger"></i>',['confirmacionrecepcion', 'id'=>$model[$i]->factura_id]);
                                            } else{
                                            echo Html::a('<i class="glyphicon glyphicon-ok text-success"></i>',['confirmacionrecepcion', 'id'=>$model[$i]->factura_id]);;   
                                            } ?></td>
                                    
                                      <td class="text-center"><?php if ($model[$i]->factura_pago_recibido==NULL){
                                            echo '<i class="glyphicon glyphicon-remove text-danger"></i>';
                                            } else{
                                            echo  '<i class="glyphicon glyphicon-ok green text-success"></i>';   
                                            } ?></td>
                                    
                                   
                                    <td><?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model[$i]->factura_id]) ?></td>
                                    <td><?= Html::a('<i class="glyphicon glyphicon-print"></i>', ['printfactura',
                                        'id' => $model[$i]->factura_id,
                                        'num' => $model[$i]->factura_num,
                                        'name' => $model[$i]->cliente->identidad_nombre,
                                        'modo_vista'=> 'Imprimir'
                                         ]) ?></td>
                                    <td><?=
                                        Html::a('<i class="glyphicon glyphicon-envelope"></i>', '#', [
                                            'id' => 'enviar-factura',
                                            //'class' => 'btn btn-success',
                                            //'data-toggle' => 'modal',
                                            //'data-target' => '#modal',
                                            'data-url' => Url::to(['modalsendfactura',
                                             'id' => $model[$i]->factura_id,
                                             'num' => $model[$i]->factura_num,
                                             'name' => $model[$i]->cliente->identidad_nombre,
                                                ]),
                                             'data-pjax' => '0',
                                        ]);
                                        ?></td>
                                    <td><?=
                                        Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model[$i]->factura_id], [
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
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
    
