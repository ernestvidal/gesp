<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Albaran */

?>
<style>
    #content td, th{
        height: 25px;
        padding: 5px;
    }
    
</style>
<div class="albaran-view">
    
   <table id="head" style="width: 100%; margin-bottom: 25px;">
        <tr>
            <td style="width: 50%; text-align: center">
                <?= Html::img('@web/img/logo_factura.jpg', ['width' => 200, 'heigth' => 150, 'alt' => 'logo']); ?>
            </td>
            <td style="width: 1%; border-left: 1px solid #DDD;"></td>
            <td style="width: 49%; padding-left: 15px;">
                <h4>Albaran a:</h4>
                <h4><?=  $model['cliente']['identidad_razon_social'] ? $model['cliente']['identidad_razon_social'] : $model['cliente']['identidad_nombre'] ?></h4>
                <h5><?= $model['cliente']['identidad_direccion'] ?></h5>
                <h5><?= $model['cliente']['identidad_cp'] .' '.$model['cliente']['identidad_poblacion'] ?></h5>
                <h5><?= $model['cliente']['identidad_provincia'] ?></h5>
                <h5><?= 'Nif. / Cif. ' . $model['cliente']['identidad_nif'] ?></h5>
                <h5><?= 'Telf.: ' . $model['cliente']['identidad_phone'] ?> - <?= $model['cliente']['identidad_mobile_phone'] ?></h5>
            </td>
        </tr>

    </table>
    
    <?php $modelItems = $model['albaranitems']; ?>
        
    <table class="table table-bordered">
        <tr>
            <td style="width:50%; padding: 10px"><h4><?= 'FECHA : ' . Yii::$app->formatter->asDate($model['albaran_fecha'], 'php:d-m-Y'); ?></h4></td>
            <td style="width:50%; padding: 10px;  text-align: right"><h4><strong><?= 'ALBARAN : ' . $model['albaran_num'] ?></strong></h4></td>
        </tr>
    </table>
    
    <table id="content" class="table table-bordered">    
        <thead>
            <tr>
                <th class="text-center" style="width: 12%">cantidad</th>
                <th class="text-center" style="width: 52%">descripción</th>
                <th class="text-center" style="width: 18%">precio</th>
                <th class="text-center" style="width: 18%">total</th>
            </tr>
        </thead>
        <tbody>
            
            <?php if ($model['albaran_pedido_cliente_num']){ ?>
            <tr>
                <td></td>
                <td style="padding-left: 15px;"><?= 'S/Núm. Pedido :' .' '.  $model['albaran_pedido_cliente_num']?></td>
                <td></td>
                <td></td>
                </tr>
            <?php } ?>    
            <?php
            
            $base_imponible = 0;
            $total = 0;
            $total_linea = 0;
            
            ?>
            <?php foreach ($modelItems as $items){ ?>

                <tr>
                    <td class="text-right"><?php if ($items['item_cantidad']<>0){ echo (number_format($items['item_cantidad'],2,',','.'));} ?></td>
                    <td style="padding-left: 15px; padding-right: 10px"><?= Yii::$app->formatter->asNtext($items['item_descripcion']) ?></td>
                    <td class="text-right"><?php // if($items['item_precio']<>0){ echo number_format($items['item_precio'],3,',','.');} ?></td>
                    <td class="text-right"><?php // if(($items['item_cantidad'] * $items['item_precio']<>0)){ echo (number_format($items['item_cantidad'] * $items['item_precio'], 2,',','.'));} ?></td>
                </tr>

            <?php

                $total_linea = ($items['item_cantidad'] * $items['item_precio']);
                $total = $total + $total_linea;
                
            
            }
            
            $importe_descuento = $total * ($model['albaran_rate_descuento'] / 100);
            $base_imponible = $total - $importe_descuento;
            $importe_iva = $base_imponible * ($model['albaran_rate_iva'] / 100);
            $importe_irpf = $base_imponible * ($model['albaran_rate_irpf'] / 100);
            
          
            
            ?>
                
        </tbody>
    </table>
    <?php if ($base_imponible<>0){ ?>
        
        <table class="table table-bordered">
                <tr>
                    <td style="border-color: white; width: 29%"></td>
                    <td style="border-bottom-color: white; border-top-color: white; width: 30%"></td>
                    <td style="width: 25%; padding: 5px">Total</td>
                    <td style="width: 16%; padding: 5px" class="text-right"><?php // number_format($total, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="border-color: white; width: 29%"></td>
                    <td style="border-bottom-color: white;  border-top-color: white; width: 30%"></td>
                    <td style="width: 25%; padding: 5px">B. Imponible</td>
                    <td style="width: 16%; padding: 5px" class="text-right"><?php // number_format($base_imponible, 2,',','.') ?></td>
                </tr>
                <?php if ($importe_descuento > 0){ ?>
                <tr>
                    <td style="border-color: white; width: 29%"></td>
                    <td style="border-bottom-color: white; width: 30%"></td>
                    <td style="width: 25%; padding: 5px">Dto.<?= " " . $model['albaran_rate_descuento']. "%"; ?></td>
                    <td style="width: 16%; padding: 5px" class="text-right"><?php // number_format($importe_descuento, 2,',','.') ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td style="border-color: white; width: 29%"></td>
                    <td style="border-bottom-color: white; width: 30%"></td>
                    <td style="width: 25%; padding: 5px">Iva<?= " " . $model['albaran_rate_iva']. "%"; ?></td>
                    <td style="width: 16%; padding: 5px" class="text-right"><?php //  number_format($importe_iva, 2,',','.') ?></td>
                </tr>
                <tr>
                    <td style="border-color: white; width: 29%"></td>
                    <td style="border-bottom-color: white; width: 30%"></td>
                    <td style="width: 25%; padding: 5px"><strong>Total Albaran</strong></td>
                    <td style="width: 16%; padding: 5px" class="text-right"><strong><?php // number_format($base_imponible  + $importe_iva - $importe_irpf, 2, ',','.')  ?></strong></td>
                </tr>
        </table>
    
    <?php } ?>
<?php if ($model['forma_pago']){ ?>
<div id="forma-de-pago" style="margin-top: 55px">
    <table class="table table-bordered" style="width: 100%; vertical-align: middle">
         <tr>
             <td style="width: 35%; padding: 10px"><strong>FORMA DE PAGO</strong></td>
             <td style="width: 65%; padding: 10px"><?= $model['forma_pago'] ?></td>
         </tr>
     </table>
</div>
<?php } ?>

<?php if ($model['albaran_plazo_entrega']){ ?>
    <div id="plazo-entrega">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
             <tr>
                 <td style="width: 35%; padding: 10px"><strong>PLAZO ENTREGA</strong></td>
                 <td style="width: 65%; padding: 10px"><?= $model['albaran_plazo_entrega'] ?></td>
             </tr>
         </table>
    </div>
<?php } ?>
<?php if ($model['albaran_validez']){ ?>
    <div id="validez">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
             <tr>
                  <td style="width: 35%; padding: 10px"><strong>VALIDEZ PRESUPUESTO</strong></td>
                 <td style="width: 65%; padding: 10px"><?= $model['albaran_validez'] ?></td>
             </tr>
         </table>
    </div>
<?php } ?>

<?php if ($model['albaran_free_one']){ ?>
    <div id="free-one">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
             <tr>
                 <td style="width: 100%; padding: 10px"><?= $model['albaran_free_one'] ?></td>
             </tr>
         </table>
    </div>
<?php } ?>
<?php if ($model['albaran_free_two']){ ?>
    <div id="free-two">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
             <tr>
                 <td style="width: 100%; padding: 10px"><?= $model['albaran_free_two'] ?></td>
             </tr>
         </table>
    </div>
<?php } ?>

<?php

    $docFooter = "
    <div id='data-company'>
        <table style='width: 100%; text-align: center'>
            <tr>
                <td> " .
                     ucfirst(strtolower($model['facturador']['identidad_nombre'])) . " 
                </td>
            </tr>
                <td> " .
                     ucfirst(strtolower($model['facturador']['identidad_direccion'])) . ' ' .
                     ucfirst(strtolower($model['facturador']['identidad_poblacion'])) . ' ' .
                     'Nif. / Cif. ' . $model['facturador']['identidad_nif'] . " 
                </td>
            </tr>
        </table>
    </div> "
?>

  