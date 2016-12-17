<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Factura */

$this->title = 'Update Factura: ' . ' ' . $model->factura_num;
$this->params['breadcrumbs'][] = ['label' => 'Facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->factura_num, 'url' => ['view', 'id' => $model->factura_num]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="factura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('factura', [
        'model' => $model,
    ]) ?>

</div>
