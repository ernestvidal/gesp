<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Informes';
?>

<div class="panel panel-default">
  <div class="panel-heading"><h1><?= Html::encode($this->title) ?></h1></div>
  <div class="panel-body">
    <?= Html::a('Clientes / compras', 'report/cliente_compras') ?>
  </div>
</div>

