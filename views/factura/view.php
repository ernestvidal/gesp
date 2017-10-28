<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Factura */
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
<div class="factura-view">

    <table id="head" style="width: 100%; margin-bottom: 25px;">
        <tr>
            <td style="width: 50%; text-align: center">
                <?= Html::img('@web/img/logo_factura.jpg', ['width' => 200, 'heigth' => 150, 'alt' => 'logo']); ?>
            </td>
            <td style="width: 1%; border-left: 1px solid #DDD;"></td>
            <td style="width: 49%; padding-left: 15px;">
                <h4>Factura a:</h4>
                <?php
                if (!empty($model['cliente']['identidad_razon_social'])) {
                    echo '<h4><strong>'.$model['cliente']['identidad_razon_social'].'</strong></h4>';
                } else {
                    echo '<h4><strong>'.$model['cliente']['identidad_nombre'].'</strong></h4>';
                }
                ?>
                <h5><?= $model['cliente']['identidad_direccion'] ?></h5>
                <h5><?= $model['cliente']['identidad_cp'] . ' ' . $model['cliente']['identidad_poblacion'] ?></h5>
                <h5><?= $model['cliente']['identidad_provincia'] ?></h5>
                <h5><?= 'Nif. / Cif. ' . $model['cliente']['identidad_nif'] ?></h5>
            </td>
        </tr>

    </table>

    <?php $modelItems = $model['facturaitems']; ?>

    <table class="table table-bordered">
        <tr>
            <td style="width:50%; padding: 10px"><h4><?= 'FECHA : ' . Yii::$app->formatter->asDate($model['factura_fecha'], 'php:d-m-Y'); ?></h4></td>
            <td style="width:50%; padding: 10px;  text-align: right"><h4><strong><?= 'FACTURA : ' . $model['factura_num'] ?></strong></h4></td>
        </tr>
    </table>

    <table id="content" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 16%">cantidad</th>
                <th class="text-center" style="width: 52%">descripción</th>
                <th class="text-center" style="width: 16%">precio</th>
                <th class="text-center" style="width: 16%">total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $base_imponible = 0;
            $total = 0;
            $total_linea = 0;
            ?>
            <?php foreach ($modelItems as $items) { ?>

                <tr>
                    <td class="text-right" style="vertical-align: top"><?php
                        if ($items['item_cantidad'] <> 0) {
                            echo (number_format($items['item_cantidad'], 2, ',', '.'));
                        }
                        ?></td>
                    <td style="padding-left: 15px; padding-right: 10px">
                        <?php
                        if (preg_match('/Albarán/', $items['item_descripcion'])) {
                            echo '<strong>' . Yii::$app->formatter->asNtext($items['item_descripcion']) . '</strong>';
                        } else {
                            echo Yii::$app->formatter->asNtext($items['item_descripcion']);
                        }
                        ?></td>

                    <td class="text-right" style="vertical-align: top"><?php
                        if ($items['item_precio'] <> 0) {
                            echo (number_format($items['item_precio'], 5, ',', '.'));
                            ;
                        }
                        ?></td>
                    <td class="text-right" style="vertical-align: top"><?php
                        if ($items['item_cantidad'] <> 0 && $items['item_precio'] <> 0) {
                            echo (number_format($items['item_cantidad'] * $items['item_precio'], 2, ',', '.'));
                        }
                        ?></td>
                </tr>

                <?php
                $total_linea = ($items['item_cantidad'] * $items['item_precio']);
                $total = $total + $total_linea;
            }

            $importe_descuento = $total * ($model['factura_rate_descuento'] / 100);
            $base_imponible = $total - $importe_descuento;
            $importe_iva = $base_imponible * ($model['factura_rate_iva'] / 100);
            $importe_recargo_equivalencia = $base_imponible * ($model['factura_rate_recargo_equivalencia'] / 100);
            $importe_irpf = $base_imponible * ($model['factura_rate_irpf'] / 100);
            ?>
            <tr>
                <td style="border-color: white; height: 15px;"></td>
                <td style="border-color: white"></td>
                <td style="border-color: white;"></td>
                <td style="border-color: white;"></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <tr>
            <td style="border-color: white; width: 29%"></td>
            <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
            <td style="width: 25%; padding: 5px">Total</td>
            <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($total, 2, ',', '.') ?></td>
        </tr>

<?php if ($model['factura_rate_descuento'] <> 0) { ?>
            <tr>
                <td style="border-color: white; width: 29%"></td>
                <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
                <td style="width: 25%; padding: 5px">Dto.<?= " " . $model['factura_rate_descuento'] . "%"; ?></td>
                <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($importe_descuento, 2, ',', '.') ?></td>
            </tr>
<?php } ?>

        <tr>
            <td style="border-color: white; width: 29%"></td>
            <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
            <td style="width: 25%; padding: 5px">B. Imponible</td>
            <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($base_imponible, 2, ',', '.') ?></td>
        </tr>


        <tr>
            <td style="border-color: white; width: 29%"></td>
            <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
            <td style="width: 25%; padding: 5px">Iva<?= " " . $model['factura_rate_iva'] . "%"; ?></td>
            <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($importe_iva, 2, ',', '.') ?></td>
        </tr>
        
        <?php if ($model['factura_rate_recargo_equivalencia'] <> 0) { ?>
            <tr>
                <td style="border-color: white; width: 29%"></td>
                <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
                <td style="width: 25%; padding: 5px">R.E.<?= " " . $model['factura_rate_recargo_equivalencia'] . "%"; ?></td>
                <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($importe_recargo_equivalencia, 2, ',', '.') ?></td>
            </tr>
<?php } ?>

<?php if ($model['factura_rate_irpf'] <> 0) { ?>
            <tr>
                <td style="border-color: white; width: 29%"></td>
                <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
                <td style="width: 25%; padding: 5px">Irpf<?= " " . $model['factura_rate_irpf'] . "%"; ?></td>
                <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($importe_irpf, 2, ',', '.') ?></td>
            </tr>
<?php } ?>
        <tr>
            <td style="border-color: white; width: 29%"></td>
            <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
            <td style="width: 25%; padding: 5px"><strong>Total Factura</strong></td>
            <td style="width: 16%; padding: 5px" class="text-right"><strong><?= number_format( round($base_imponible,2) + round($importe_iva,2) + round($importe_recargo_equivalencia,2) - round($importe_irpf,2),2,',','.') ?></strong></td>
        </tr>
        </tfoot>
    </table>

</div>

<?php if ($model['forma_pago']) { ?>
    <div id="forma-de-pago" style="margin-top: 5px">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 35%; padding: 10px"><strong>FORMA DE PAGO</strong></td>
                <td style="width: 65%; padding: 10px"><?= $model['forma_pago'] ?></td>
            </tr>
        </table>
    </div>
<?php } ?>

<?php if ($model['factura_vto']) { ?>
    <div id="forma-de-pago" style="margin-top: 1px">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 35%; padding: 10px"><strong>VENCIMIENTO</strong></td>
                <td style="width: 65%; padding: 10px">
    <?= Yii::$app->formatter->asDate($model['factura_vto'], 'php:d-m-Y') . ' / Importe ' . number_format($model['factura_vto_importe'],2,',','.') ?> &euro;
                </td>
            </tr>
        </table>
    </div>
<?php } ?>

<?php if ($model['factura_vto_dos']) { ?>
    <div id="forma-de-pago" style="margin-top: 1px">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 35%; padding: 10px"><strong>VENCIMIENTO</strong></td>
                <td style="width: 65%; padding: 10px">
    <?= Yii::$app->formatter->asDate($model['factura_vto_dos'], 'php:d-m-Y') . ' / Importe ' . number_format($model['factura_vto_dos_importe'],2,',','.') ?> &euro;
                </td>
            </tr>
        </table>
    </div>
<?php } ?>

<?php if ($model['factura_cta']) { ?>
    <div id="forma-de-pago" style="margin-top: 5px">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
            <tr>
                <td style="width: 35%; padding: 10px"><strong>ENTIDAD/CTA</strong></td>
                <td style="width: 65%; padding: 10px"><?= $model['factura_cta'] ?></td>
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
    echo Html::a('Imprimir', ['printfactura',
        'id' => $id,
        'num' => $model->factura_num,
        'name' => $model->cliente->identidad_nombre,
        'modo_vista' => 'Imprimir'], ['class' => ['class' => 'btn btn-sm btn-primary']
    ]);
    echo "</div>";
    echo "</div>";
}
?>