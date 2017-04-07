<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = 'Update Pedido: ' . ' ' . $model->pedido_num;
$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pedido_num, 'url' => ['view', 'id' => $model->pedido_num]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="presupuesto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('pedidocliente', [
        'model' => $model,
    ]) ?>

</div>
