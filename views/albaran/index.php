<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\albaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Albaranes';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="albaran-index">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::a('Albaranes', ['index', 'albaranes'=>'todos']) ?>
                    <?= ' / ' ?>
                    <?= Html::a('Albaranes pendientes de facturar', ['index']) ?>
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
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                  
                                    <th></th>
                                    <th></th>
                                    <th></th>

                                </tr>
                            </thead>

                            <?php $facturador = $model[0]->facturador->identidad_nombre; ?>
                            <?php $año_albaran = substr($model[0]->albaran_fecha, 0, 4); ?>
                            <?php $currentMonth = date("m", strtotime($model[0]->albaran_fecha)); ?>
                            <?php $currentQuarter = ceil($currentMonth / 3); ?>
                            <!--<h3><?= $año_albaran . '-' . $facturador; ?></h3> -->
                            <?php
                            for ($i = 0; $i < count($model); $i++) {

                                if ($facturador <> $model[$i]->facturador->identidad_nombre || $año_albaran <> substr($model[$i]->albaran_fecha, 0, 4) || $currentQuarter <> ceil(date("m", strtotime($model[$i]->albaran_fecha)) / 3)) {
                                    $facturador = $model[$i]->facturador->identidad_nombre;
                                    $año_albaran = substr($model[$i]->albaran_fecha, 0, 4);
                                    $currentQuarter = ceil(date("m", strtotime($model[$i]->albaran_fecha)) / 3);
                                    //echo '<h3>'. $año_albaran . '-'. $facturador . '</h3>';
                                }
                                $baseImponible = 0;
                                $totalIva = 0;
                                $totalAlbaran = 0;
                                foreach ($model[$i]->albaranitems as $albaranDetalle) {
                                    $totalLinea = $albaranDetalle->item_cantidad * $albaranDetalle->item_precio;
                                    $baseImponible += $totalLinea;
                                    $totalIva = $baseImponible * $model[$i]->albaran_rate_iva / 100;
                                    $totalDto = $baseImponible * $model[$i]->albaran_rate_descuento / 100;
                                    $totalIrpf = $baseImponible * $model[$i]->albaran_rate_irpf / 100;
                                    $totalAlbaran = $baseImponible + $totalIva - $totalIrpf;
                                }
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?= Yii::$app->formatter->asDate($model[$i]->albaran_fecha, 'php:d-m-Y') ?></td>
                                        <td><?= Html::a($model[$i]->albaran_num, ['view', 'id' => $model[$i]->albaran_id]) ?></td>
                                        <td><?= Html::a($model[$i]->cliente->identidad_nombre, ['index', 'cliente'=>$model[$i]->cliente_id]) ?></td>
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($baseImponible, 2) ?></td>
                                        <!--<td class="text-right"><?= $model[$i]->albaran_rate_iva ?></td> -->
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIva, 2) ?></td>
                                        <!--<td class="text-right"><?= $model[$i]->albaran_rate_descuento ?></td> -->
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalDto, 2) ?></td>
                                        <!--<td class="text-right"><?= $model[$i]->albaran_rate_irpf ?></td> -->
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIrpf, 2) ?></td>
                                        <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalAlbaran, 2) ?></td>
                                        
                                        <td><?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model[$i]->albaran_id],['title' => 'editar']) ?></td>
                                        <td><?= Html::a('<i class="glyphicon glyphicon-print"></i>', ['printalbaran',
                                            'id' => $model[$i]->albaran_id,
                                            'num' => $model[$i]->albaran_num,
                                            'name' => $model[$i]->cliente->identidad_nombre], 
                                            ['title' => 'imprimir'])
                                        ?></td>
                                        <td><?= Html::a('<i class="glyphicon glyphicon-envelope"></i>', ['modalsendalbaran', 'id' => $model[$i]->albaran_id],['title' => 'enviar']) ?></td>
                                        <td><?=
                                            Html::a('<i class="glyphicon glyphicon-file"></i>', '#', [
                                                'id' => 'modal-facturar-link',
                                                'title' => 'facturar',
                                                //'class' => 'btn btn-success',
                                                //'data-toggle' => 'modal',
                                                //'data-target' => '#modal',
                                                'data-url' => Url::to(['modalfacturar', 'id' => $model[$i]->albaran_id]),
                                                'data-pjax' => '0',])
                                            ?>
                                        </td>
                                        <td><?=
                                            Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model[$i]->albaran_id], [
                                                'title' => 'delete',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ])
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <?php
            $this->registerJs(
                    "$(document).on('click', '#modal-facturar-link', (function() {
            $.get(
                $(this).data('url'),
                function (data) {
                    $('.modal-body').html(data);
                    $('#modal-facturar').modal();
                }
            );
        }));"
            );
            ?>

            <?php
            // Ventana modal donde mostramos la vista modalFacturarPedido.php
            Modal::begin([
                'header' => '<h2>Facturar albarán</h2>',
                'id' => 'modal-facturar',
            ]);
            echo "<div id='modalContent'>";
            echo "</div>";


            Modal::end();
            ?>

        </div>
