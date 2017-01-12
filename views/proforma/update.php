<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Factura */

$this->title = 'Update Factura: ' . ' ' . $model->proforma_num;
$this->params['breadcrumbs'][] = ['label' => 'Facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proforma_num, 'url' => ['view', 'id' => $model->proforma_num]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proforma-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('proforma', [
        'model' => $model,
    ]) ?>

</div>
