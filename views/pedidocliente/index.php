<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\pedidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pedidos Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="pedido-index">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>Listado pedidos | <?= Html::a('Todos los pedidos', ['index', 'pedidos' => 'todos']) ?> | <?= Html::a('Create', ['create']) ?> </span>
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
                                    <th>IVA</th>
                                    <th>DTO</th>
                                    <th>IRPF</th>
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
                            <?php $año_pedido = substr($model[0]->pedido_fecha, 0, 4); ?>
                            <?php $currentMonth = date("m", strtotime($model[0]->pedido_fecha)); ?>
                            <?php $currentQuarter = ceil($currentMonth / 3); ?>
    <!-- <h3><?= $año_pedido . '-' . $facturador; ?></h3> -->
                            <?php
                            for ($i = 0; $i < count($model); $i++) {

                                if ($facturador <> $model[$i]->facturador->identidad_nombre || $año_pedido <> substr($model[$i]->pedido_fecha, 0, 4) || $currentQuarter <> ceil(date("m", strtotime($model[$i]->pedido_fecha)) / 3)) {
                                    $facturador = $model[$i]->facturador->identidad_nombre;
                                    $año_pedido = substr($model[$i]->pedido_fecha, 0, 4);
                                    $currentQuarter = ceil(date("m", strtotime($model[$i]->pedido_fecha)) / 3);
                                    //echo '<h3>'. $año_pedido . '-'. $facturador . '</h3>';
                                }
                                $baseImponible = 0;
                                $totalIva = 0;
                                $totalPedido = 0;
                                foreach ($model[$i]->pedidoitemclientes as $pedidoDetalle) {
                                    $totalLinea = $pedidoDetalle->item_cantidad * $pedidoDetalle->item_precio;
                                    $baseImponible += $totalLinea;
                                    $totalDto = $baseImponible * $model[$i]->pedido_rate_descuento / 100;
                                    $totalIva = $baseImponible * $model[$i]->pedido_rate_iva / 100;
                                    $totalIrpf = $baseImponible * $model[$i]->pedido_rate_irpf / 100;
                                    $totalPedido = $baseImponible + $totalIva - $totalIrpf;
                                }
                                ?>
                                
                                    <tr>

                                        <td class="text-right"><?= Yii::$app->formatter->asDate($model[$i]->pedido_fecha, 'php:d-m-Y') ?>
                                        <td class="text-right"><?= Html::a($model[$i]->pedido_num, ['view', 'id' => $model[$i]->pedido_id]) ?></td>
                                        <td><?= Html::a($model[$i]->cliente->identidad_nombre, ['reportfacturasproveedor', 'id' => $model[$i]->cliente->identidad_id]) ?></td>
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($baseImponible, 2); ?></td>
                                        <!--<td class="text-right"><?= $model[$i]->pedido_rate_iva ?></td>-->
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIva, 2) ?>
                                        <!--<td class="text-right"><?= $model[$i]->pedido_rate_descuento ?></td>-->
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalDto, 2) ?> 
                                        <!--<td class="text-right"><?= $model[$i]->pedido_rate_irpf ?></td>-->
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIrpf, 2); ?></td>
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalPedido, 2); ?></td>
                                        <!--<td><?= Html::a('<i class="glyphicon glyphicon-eye-open"></i>', ['view', 'id' => $model[$i]->pedido_id]) ?></td> -->
                                        <td><?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model[$i]->pedido_id]) ?></td>
                                        <td><?= Html::a('<i class="glyphicon glyphicon-print"></i>', ['printpedido',
                                            'id' => $model[$i]->pedido_id,
                                            'num' => $model[$i]->pedido_num,
                                            'name' => $model[$i]->cliente->identidad_nombre]) ?></td>
                                         
                                        <td><?= Html::a('<i class="glyphicon glyphicon-envelope"></i>', ['modalsendpedido', 'id' => $model[$i]->pedido_id]) ?></td>
                                        <td><?=
                                            Html::a('<i class="glyphicon glyphicon-file"></i>', '#', [
                                                'id' => 'modal-window',
                                                //'class' => 'btn btn-success',
                                                //'data-toggle' => 'modal',
                                                //'data-target' => '#modal',
                                                'data-url' => Url::to(['modalfacturarpedido', 'id' => $model[$i]->pedido_id]),
                                                'data-pjax' => '0',])
                                            ?></td>
                                         <td><?=
                                            Html::a('<i class="glyphicon glyphicon-copy"></i>', '#', [
                                                'id' => 'copy-pedido',
                                                'title' => 'Make albarán',
                                                'data-url' => Url::to(['copiarpedido', 'id' => $model[$i]->pedido_id,
                                                    'documento_destino' => 'albaran']),
                                                'data-pjax' => '0',
                                            ])
                                            ?>
                                        </td>
                                        <td><?=
                                            Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model[$i]->pedido_id], [
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ])
                                            ?>
                                        </td>
                                    </tr>
                                
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
                "$(document).on('click', '#modal-window', (function() {
            $.get(
                $(this).data('url'),
                function (data) {
                    $('.modal-body').html(data);
                    $('#modal-facturar-pedido').modal();
                }
            );
        }));"
        );
        ?>

        <?php
        // Ventana modal para introducir los datos para enviar la pedido por correo
        Modal::begin([
            'header' => '<h2>Facturar Pedido</h2>',
            'id' => 'modal-facturar-pedido',
        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        ?>


     <?php
        
        /*
         * Javascript y ventana modal donde mostramos la vista llamada desde el
         * link #copiar-pedido
         */
        
        $this->registerJs(
                "$(document).on('click', '#copy-pedido', (function() {
                $.get(
                    $(this).data('url'),
                    function (data) {
                        $('.modal-body').html(data);
                        $('#modal-pedido').modal();
                    }
                );
            }));"
        );

        Modal::begin([
            'header' => '<h2>Copiar Pedido</h2>',
            'id' => 'modal-pedido',
        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        ?>
