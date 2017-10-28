<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
?>

<?php
if ($modo_vista == 'Imprimir') {
    echo "<style>";
    echo "td,th{font-family: 'futuraltcondensedlight';}";
    echo "</style>";
}
?>
<style>
    #content td, th{
        height: 25px;
        padding: 5px;
    }

</style>
<div class="pedido-view">

    <table id="head" style="width: 100%; margin-bottom: 25px;">
        <tr>
            <td style="width: 50%; text-align: center">
                <?= Html::img('@web/img/logo_factura.jpg', ['width' => 200, 'heigth' => 150, 'alt' => 'logo']); ?>
            </td>
            <td style="width: 1%; border-left: 1px solid #DDD;"></td>
            <td style="width: 49%; padding-left: 15px;">
                <h4>Pedido a:</h4>
                <h4><strong><?= $model['cliente']['identidad_nombre'] ?></strong></h4>
                <h5><?= $model['cliente']['identidad_direccion'] ?></h5>
                <h5><?= $model['cliente']['identidad_poblacion'] ?></h5>
                <h5><?= 'Nif. / Cif. ' . $model['cliente']['identidad_nif'] ?></h5>
            </td>
        </tr>

    </table>

    <?php $modelItems = $model['pedidoitems']; ?>

    <table class="table table-bordered">
        <tr>
            <td style="width:50%; padding: 10px"><h4><?= 'FECHA : ' . Yii::$app->formatter->asDate($model['pedido_fecha'], 'php:d-m-Y'); ?></h4></td>
            <td style="width:50%; padding: 10px; text-align: right"><h4><strong><?= 'PEDIDO : ' . $model['pedido_num'] ?></strong></h4></td>
        </tr>
    </table>

    <table id="content" class="table table-bordered">
        <thead>

            <tr>
                <th class="text-center" style="width: 16%; padding: 10px">CANTIDAD</th>
                <th class="text-center" style="width: 52%; padding: 10px">CONCEPTO</th>
                <th class="text-center" style="width: 16%; padding: 10px">PRECIO</th>
                <th class="text-center" style="width: 16%; padding: 10px">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $base_imponible = 0;
            $total_linea = 0;
            ?>
            <?php foreach ($modelItems as $items) { ?>

                <tr>
                    <td class="text-right" style="vertical-align: top"><?= $items['item_cantidad'] != 0 ? number_format($items['item_cantidad'], 2, ',', '.') : '' ?></td>
                    <td style="padding-left: 15px; padding-right: 10px"><?= Yii::$app->formatter->asNtext($items['item_descripcion']) ?></td>
                    <td class="text-right" style="vertical-align: top"><?= $items['item_precio'] != 0 ? $items['item_precio'] : '' ?></td>
                    <td class="text-right" style="vertical-align: top"><?php
                        if ($items['item_cantidad'] * $items['item_precio'] != 0) {
                            echo number_format($items['item_cantidad'] * $items['item_precio'], 2, ',', '.');
                        }
                        ?></td>
                </tr>

                <?php
                $total_linea = ($items['item_cantidad'] * $items['item_precio']);
                $base_imponible = $base_imponible + $total_linea;
            }

            $importe_descuento = $base_imponible * ($model['pedido_rate_descuento'] / 100);
            $importe_iva = $base_imponible * ($model['pedido_rate_iva'] / 100);
            $importe_irpf = $base_imponible * ($model['pedido_rate_irpf'] / 100);
            ?>

        </tbody>
    </table>
    <table id="totales" class="table table-bordered">

        <tr>
            <td style="border-color: white; width: 29%;"></td>
            <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
            <td style="width: 25%; padding: 5px">B. Imponible</td>
            <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($base_imponible, 2, ',', '.') ?></td>
        </tr>
        <?php if ($model['pedido_rate_descuento'] <> 0) { ?>
            <tr>
                <td style="border-color: white;"></td>
                <td style="border-bottom-color: white;"></td>
                <td style="padding: 5px">Dto.<?= " " . $model['pedido_rate_descuento'] . "%"; ?></td>
                <td style="padding: 5px" class="text-right"><?= number_format($importe_descuento, 2, ',', '.') ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td style="border-color: white;"></td>
            <td style="border-bottom-color: white;"></td>
            <td style="padding: 5px" >Iva<?= " " . $model['pedido_rate_iva'] . "%"; ?></td>
            <td style="padding: 5px" class="text-right"><?= number_format($importe_iva, 2, ',', '.') ?></td>
        </tr>
        <?php if ($model['pedido_rate_irpf'] <> 0) { ?>
            <tr>
                <td style="border-color: white;"></td>
                <td style="border-bottom-color: white;"></td>
                <td style="padding: 5px">Irpf<?= " " . $model['pedido_rate_irpf'] . "%"; ?></td>
                <td style="padding: 5px" class="text-right"><?= number_format($importe_irpf, 2, ',', '.') ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td style="border-color: white;"></td>
            <td style="border-bottom-color: white;"></td>
            <td style="padding: 5px"><strong>Total Pedido</strong></td>
            <td style="padding: 5px" class="text-right"><strong><?= number_format($base_imponible - $importe_descuento + $importe_iva - $importe_irpf, 2, ',', '.') ?></strong></td>
        </tr>
        </tfoot>
    </table>

</div>

<?php if ($model['pedido_img']) { ?>
    <div id="imagen" style="margin-top: 5px">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr style="text-align:center">
                <td style="width: 100%; padding: 10px"> <?= Html::img('@web/clientes/' . $model['pedido_img'], ['alt' => 'logo']); ?></td>
            </tr>
        </table>
    </div>
<?php } ?>

<?php if ($model['forma_pago']) { ?>
    <div id="forma-de-pago" style="margin-top: 55px">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 25%; padding: 20px"><strong>Forma de pago:</strong></td>
                <td style="width: 75%; padding: 20px"><?= $model['forma_pago'] ?></td>
            </tr>
        </table>
    </div>
<?php } ?>   

<?php if ($model['pedido_plazo_entrega']) { ?>
    <div id="plazo-entrega">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 25%; padding: 20px"><strong>Plazo entrega:</strong></td>
                <td style="width: 75%; padding: 20px"><?= $model['pedido_plazo_entrega'] ?></td>
            </tr>
        </table>
    </div>
<?php } ?>

<?php if ($model['pedido_free_one']) { ?>
    <div id="free-one">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 100%; padding: 20px"><?= $model['pedido_free_one'] ?></td>
            </tr>
        </table>
    </div>
<?php } ?>
<?php if ($model['pedido_free_two']) { ?>
    <div id="free-two">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 100%; padding: 20px"><?= $model['pedido_free_two'] ?></td>
            </tr>
        </table>
    </div>
<?php } ?>
<?php if ($model['pedido_validez']) { ?>
    <div id="validez">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 25%; padding: 20px"><strong>Validez:</strong></td>
                <td style="width: 75%; padding: 20px"><?= $model['pedido_validez'] ?></td>
            </tr>
        </table>
    </div>
<?php } ?>

<?php
/*
 * En la vista del modelo se ha puesto un boton para no tener que salir a otra
 * pantalla para imprimir y no se tengan dos vistas una con boton y otra sin
 * boton de imprimir. Desde la vista ahora se puede y para ocultar el boton
 * cuando se genere. Si no le damos a imprimir el valor de $modo_vista siempre
 * sera null y el botón se verá en la vista. Si le damos a imprimir enviaremos
 * a la acción la variable $modo_vista con el valor 'Imprimir', para que lo 
 * oculte y no lo muestre cuando se genere el pdf. 
 */


if ($modo_vista == NULL) {
    echo "<div class='row'>";
    echo "<div class='col-md-2'>";
    echo Html::a('Imprimir', ['printpedido',
        'id' => $id,
        'num' => $model->pedido_num,
        'name' => $model->cliente->identidad_nombre,
        'modo_vista' => 'Imprimir'], ['class' => ['class' => 'btn btn-sm btn-primary']
    ]);
    echo "</div>";
    echo "</div>";
}
?>



