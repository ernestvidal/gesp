<?php
use yii\helpers\VarDumper;
$this->title = 'Pedidos facturados';
$this->params['breadcrumbs'][] = $this->title;

foreach($model as $linea){
    
    $facturas[] = $linea['pedido_factura_num'];
}
$facturas = array_unique($facturas);

foreach($model as $linea){
    
}

VarDumper::dump($facturas);