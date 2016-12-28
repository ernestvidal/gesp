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

    <?php $pedido = $model[0]->pedido_num ?>
    <?php $factura = $model[0]->pedido_factura_num ?>
    <h3 class="page-header"><?= $model[0]->cliente->identidad_nombre ?></h3>

    <?php
    $i = 0;
    
    while ($i < count($model)) {
        $factura_total = 0;
        echo '<div class="row">';
        echo '<div class="col-lg-3"><h5><strong> Factura núm.: ' . $model[$i]->pedido_factura_num . '</strong></h5></div>';
        echo '</div>';

        while ($factura == $model[$i]->pedido_factura_num && $i<count($model)) {
           

     $pedido_total_linea = 0;
            $pedido_total_pedido = 0;
            while ($pedido == $model[$i]->pedido_num && $i<count($model)) {
                echo '<div class = "container">';
                echo '<div class = "row">';
                echo '<div class = "col-lg-2"><h5><strong>PEDIDO NUM.:' . $model[$i]->pedido_num . '</strong></h5></div>';
                echo'<div class="col-lg-2"><h5><strong>' . Yii::$app->formatter->asDate($model[$i]->pedido_fecha, "php:d-m-Y") . '</strong></h5></div>';
                echo'</div>';

                foreach ($model[$i]['pedidoitems'] as $itempedido) {

                    $pedido_total_linea = $itempedido->item_cantidad * $itempedido->item_precio;
                    $pedido_total_pedido += $pedido_total_linea;


                    echo'<div class="row">';
                    echo'<div class="col-lg-1">' . $itempedido->item_cantidad . '</div>';
                    echo'<div class="col-lg-9">' . Yii::$app->formatter->asNtext($itempedido->item_descripcion) . '</div>';
                    echo'<div class="col-lg-2">' . $itempedido->item_precio . '</div>';
                    echo'</div>';
                    echo'<hr>';
                    echo'</div>';
                }

                $factura_total += $pedido_total_pedido;
                $pedido_total_linea = 0;
                $pedido_total_pedido = 0;

                if ($i >= count($model)) {
                    
                } else {
                    $i++;
                    $pedido = $model[$i]->pedido_num;
                }
            }


            $factura_total = 0;
            if ($i >= count($model)) {
                
            } else {
                $i++;
                $factura = $model[$i]->pedido_factura_num;
            }
        }
    }
    ?>

</div>
