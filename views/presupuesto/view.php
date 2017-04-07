<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto */

?>
<style>
    #content td, th{
        height: 25px;
        padding: 5px;
    }
    
</style>
<div class="presupuesto-view">
    
   <table id="head" style="width: 100%; margin-bottom: 25px;">
        <tr>
            <td style="width: 50%; text-align: center">
                <?= Html::img('@web/img/logo_factura.jpg', ['width' => 200, 'heigth' => 150, 'alt' => 'logo']); ?>
            </td>
            <td style="width: 1%; border-left: 1px solid #DDD;"></td>
            <td style="width: 49%; padding-left: 15px;">
                <h4>Presupuesto a:</h4>
                <h4><?= $model['cliente']['identidad_nombre'] ?></h4>
                <h5><?= $model['cliente']['identidad_direccion'] ?></h5>
                <h5><?= $model['cliente']['identidad_cp'] .' '.$model['cliente']['identidad_poblacion'] ?></h5>
                <h5><?= $model['cliente']['identidad_provincia'] ?></h5>
                <h5><?= 'Nif. / Cif. ' . $model['cliente']['identidad_nif'] ?></h5>
            </td>
        </tr>

    </table>
    
    <?php $modelItems = $model['presupuestoitems']; ?>
        
    <table class="table table-bordered">
        <tr>
            <td style="width:50%; padding: 10px"><h4><?= 'FECHA : ' . Yii::$app->formatter->asDate($model['presupuesto_fecha'], 'php:d-m-Y'); ?></h4></td>
            <td style="width:50%; padding: 10px;  text-align: right"><h4><strong><?= 'PRESUPUESTO : ' . $model['presupuesto_num'] ?></strong></h4></td>
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
            <?php
            
            $base_imponible = 0;
            $total_linea = 0;
            
            ?>
            <?php foreach ($modelItems as $items){ ?>

                <tr>
                    <td class="text-right"><?php if ($items['item_cantidad']<>0){echo Yii::$app->formatter->asDecimal($items['item_cantidad'], 2);} ?></td>
                    <td style="padding-left: 15px; padding-right: 10px"><?= Yii::$app->formatter->asNtext($items['item_descripcion']) ?></td>
                    <td class="text-right"><?php if ($items['item_precio']<>0){echo (number_format($items['item_precio'], 3,',','.'));} ?></td>
                    <td class="text-right"><?php if ($items['item_cantidad']<>0 && $items['item_precio']<>0){echo (number_format($items['item_cantidad'] * $items['item_precio'], 2,',','.'));} ?></td>
                </tr>

            <?php

                $total_linea = ($items['item_cantidad'] * $items['item_precio']);
                $base_imponible = $base_imponible + $total_linea;
            
            }
            
            $importe_descuento = $base_imponible * ($model['presupuesto_rate_descuento']);
            $importe_iva = $base_imponible * ($model['presupuesto_rate_iva'] / 100);
            $importe_irpf = $base_imponible * ($model['presupuesto_rate_irpf'] / 100);
            
            ?>
                
        </tbody>
    </table>
    <?php if($base_imponible <>0 && $importe_iva <> 0){ ?>
    <table class="table table-bordered">
            <tr>
                <td style="border-color: white; width: 29%"></td>
                <td style="border-bottom-color: white;  border-top-color: white; width: 30%"></td>
                <td style="width: 25%; padding: 5px">B. Imponible</td>
                <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($base_imponible, 2,',','.') ?></td>
            </tr>
            
            <?php if ($model['presupuesto_rate_descuento']<>0){ ?>
                <tr>
                    <td style="border-color: white; width: 29%"></td>
                    <td style="border-bottom-color: white; width: 30%"></td>
                    <td style="width: 25%; padding: 5px">Dto.<?= " " . $model['presupuesto_rate_descuento']. "%"; ?></td>
                    <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($importe_descuento, 2,',','.') ?></td>
                </tr>
            <?php } ?>
                
            <tr>
                <td style="border-color: white; width: 29%"></td>
                <td style="border-bottom-color: white; width: 30%"></td>
                <td style="width: 25%; padding: 5px">Iva<?= " " . $model['presupuesto_rate_iva']. "%"; ?></td>
                <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($importe_iva, 2,',','.') ?></td>
            </tr>
            
            <?php if($model['presupuesto_rate_irpf']<>0){ ?>
                <tr>
                    <td style="border-color: white; width: 29%"></td>
                    <td style="border-bottom-color: white; width: 30%"></td>
                    <td style="width: 25%; padding: 5px">Irpf<?= " " . $model['presupuesto_rate_irpf']. "%"; ?></td>
                    <td style="width: 16%; padding: 5px" class="text-right"><?= number_format($importe_irpf, 2,',','.')  ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td style="border-color: white; width: 29%"></td>
                <td style="border-bottom-color: white; width: 30%"></td>
                <td style="width: 25%; padding: 5px"><strong>Total Presupuesto</strong></td>
                <td style="width: 16%; padding: 5px" class="text-right"><strong><?= number_format($base_imponible - $importe_descuento + $importe_iva - $importe_irpf, 2, ',','.')  ?></strong></td>
            </tr>
    </table>
    <?php }?>
</div>


<?php if ($model['presupuesto_img']){ ?>
<div id="imagen" style="margin-top: 5px">
    <table class="table table-bordered" style="width: 100%; vertical-align: middle">
        <tr style="text-align:center">
             <td style="width: 100%; padding: 10px"> <?= Html::img('@web/clientes/' .$model['presupuesto_img'] , ['alt' => 'logo']); ?></td>
         </tr>
     </table>
</div>
<?php } ?>

<?php if ($model['forma_pago']){ ?>
<div id="forma-de-pago" style="margin-top: 5px">
    <table class="table table-bordered" style="width: 100%; vertical-align: middle">
         <tr>
             <td style="width: 35%; padding: 10px"><strong>FORMA DE PAGO</strong></td>
             <td style="width: 65%; padding: 10px"><?= $model['forma_pago'] ?></td>
         </tr>
     </table>
</div>
<?php } ?>

<?php if ($model['presupuesto_plazo_entrega']){ ?>
    <div id="plazo-entrega">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
             <tr>
                 <td style="width: 35%; padding: 10px"><strong>PLAZO ENTREGA</strong></td>
                 <td style="width: 65%; padding: 10px"><?= $model['presupuesto_plazo_entrega'] ?></td>
             </tr>
         </table>
    </div>
<?php } ?>
<?php if ($model['presupuesto_validez']){ ?>
    <div id="validez">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
             <tr>
                  <td style="width: 35%; padding: 10px"><strong>VALIDEZ PRESUPUESTO</strong></td>
                 <td style="width: 65%; padding: 10px"><?= $model['presupuesto_validez'] ?></td>
             </tr>
         </table>
    </div>
<?php } ?>

<?php if ($model['presupuesto_free_one']){ ?>
    <div id="free-one">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
             <tr>
                 <td style="width: 100%; padding: 10px"><?= $model['presupuesto_free_one'] ?></td>
             </tr>
         </table>
    </div>
<?php } ?>
<?php if ($model['presupuesto_free_two']){ ?>
    <div id="free-two">
        <table class="table table-bordered" style="width: 100%; vertical-align: middle">
             <tr>
                 <td style="width: 100%; padding: 10px"><?= $model['presupuesto_free_two'] ?></td>
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

  