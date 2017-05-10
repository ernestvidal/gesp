<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\presupuestoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presupuestos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presupuesto-index">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><strong>Listado de presupuestos / </strong></span>
                    <span>
                        <?= Html::a('2017', ['index', 'year' => 2017]) ?>
                        /
                    </span>
                    <span>
                        <?= Html::a('2016', ['index', 'year' => 2016]) ?>
                    </span>
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
                            <?php $año_presupuesto = substr($model[0]->presupuesto_fecha, 0, 4); ?>
                            <?php $currentMonth = date("m", strtotime($model[0]->presupuesto_fecha)); ?>
                            <?php $currentQuarter = ceil($currentMonth / 3); ?>
             <!--<h3><?= $año_presupuesto . '-' . $facturador; ?></h3>-->
                            <?php
                            for ($i = 0; $i < count($model); $i++) {

                                if ($facturador <> $model[$i]->facturador->identidad_nombre || $año_presupuesto <> substr($model[$i]->presupuesto_fecha, 0, 4) || $currentQuarter <> ceil(date("m", strtotime($model[$i]->presupuesto_fecha)) / 3)) {
                                    $facturador = $model[$i]->facturador->identidad_nombre;
                                    $año_presupuesto = substr($model[$i]->presupuesto_fecha, 0, 4);
                                    $currentQuarter = ceil(date("m", strtotime($model[$i]->presupuesto_fecha)) / 3);
                                    //echo '<h3>' . $año_presupuesto . '-' . $facturador . '</h3>';
                                }
                                $baseImponible = 0;
                                $totalIva = 0;
                                $totalPresupuesto = 0;
                                foreach ($model[$i]->presupuestoitems as $presupuestoDetalle) {
                                    $totalLinea = $presupuestoDetalle->item_cantidad * $presupuestoDetalle->item_precio;
                                    $baseImponible += $totalLinea;
                                    $totalDto = $baseImponible * $model[$i]->presupuesto_rate_descuento / 100;
                                    $totalIva = $baseImponible * $model[$i]->presupuesto_rate_iva / 100;
                                    $totalIrpf = $baseImponible * $model[$i]->presupuesto_rate_irpf / 100;
                                    $totalPresupuesto = $baseImponible + $totalIva - $totalIrpf;
                                }
                                ?>

                                <tr>
                                    <td><?= Yii::$app->formatter->asDate($model[$i]->presupuesto_fecha, 'php:d-m-Y') ?></td>
                                    <td> <?=
                                        Html::a($model[$i]->presupuesto_num, [
                                            'view',
                                            'id' => $model[$i]->presupuesto_id
                                        ]);
                                        ?>
                                    </td>
                                    <td><?= $model[$i]->cliente->identidad_nombre; ?></td>
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($baseImponible, 2) ?></td>
                                    <!-- <td class="text-right"><?= $model[$i]->presupuesto_rate_iva ?></td> -->
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIva, 2) ?>
                                    <!--<td class="text-right"><?= $model[$i]->presupuesto_rate_descuento ?></td>-->
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalDto, 2) ?></td>
                                    <!--<td class="text-right"><?= $model[$i]->presupuesto_rate_irpf ?></td>-->
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalIrpf, 2) ?></td>
                                    <td class="text-right"><?= Yii::$app->formatter->asDecimal($totalPresupuesto, 2) ?></td>

                                    <td><?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model[$i]->presupuesto_id], ['title' => 'editar'])
                                    ?></td>
                                    <td><?=
                                        Html::a('<i class="glyphicon glyphicon-print"></i>', ['printpresupuesto',
                                            'id' => $model[$i]->presupuesto_id,
                                            'num' => $model[$i]->presupuesto_num,
                                            'name' => $model[$i]->cliente->identidad_nombre],
                                            ['title' => 'imprimir'])
                                        ?>
                                    </td>
                                    <td><?= Html::a('<i class="glyphicon glyphicon-envelope"></i>', ['modalsendpresupuesto', 'id' => $model[$i]->presupuesto_id], ['title' => 'enviar por mail'])
                                    ?>
                                    </td>
                                    <td><?=
                                            Html::a('<i class="glyphicon glyphicon-duplicate"></i>', '#', [
                                                'id' => 'copy-presupuesto',
                                                'title' => 'duplicar presupuesto',
                                                'data-url' => Url::to(['copiarpresupuesto', 'id' => $model[$i]->presupuesto_id,
                                                    'documento_destino' => 'presupuesto']),
                                                'data-pjax' => '0',
                                            ])
                                            ?>
                                        </td>
                                    <td><?=
                                            Html::a('<i class="glyphicon glyphicon-duplicate"></i>', '#', [
                                                'id' => 'copyToOrder',
                                                'title' => 'crear pedido cliente',
                                                'data-url' => Url::to(['copiarpresupuesto', 'id' => $model[$i]->presupuesto_id,
                                                    'documento_destino' => 'pedidoCliente']),
                                                'data-pjax' => '0',
                                            ])
                                            ?>
                                    </td>    
                                    <td>
                                        <?=
                                        Html::a('<i class="glyphicon glyphicon-file"></i>', '#', [
                                            'id' => 'modal-facturar-link',
                                            'title' => 'proforma',
                                            //'class' => 'btn btn-success',
                                            //'data-toggle' => 'modal',
                                            //'data-target' => '#modal',
                                            'data-url' => Url::to(['modalfacturar', 'id' => $model[$i]->presupuesto_id]),
                                            'data-pjax' => '0',])
                                        ?>
                                    </td>
                                    <td><?=
                                    Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model[$i]->presupuesto_id],[
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
// Ventana modal para introducir los datos para enviar la presupuesto por correo
Modal::begin([
    'header' => '<h2>Enviar Presupuesto</h2>',
    'id' => 'modalSendPresupuesto',
]);
echo "<div id='modalContent'></div>";

Modal::end();
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
<?php
 /*
         * Javascript y ventana modal donde mostramos la vista llamada desde el
         * link #copiar-proforma y #copy-factura
         */
        
        $this->registerJs(
                "$(document).on('click', '#copy-presupuesto , #copy-factura, #copyToOrder', (function() {
                $.get(
                    $(this).data('url'),
                    function (data) {
                        $('.modal-body').html(data);
                        $('#modal-presupuesto').modal();
                    }
                );
            }));"
        );

        Modal::begin([
            'header' => '<h2>Copiar Presupuesto</h2>',
            'id' => 'modal-presupuesto',
        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
        ?>