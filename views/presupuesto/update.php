<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto */

$this->title = 'Update Presupuesto: ' . ' ' . $model->presupuesto_num;
$this->params['breadcrumbs'][] = ['label' => 'Presupuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->presupuesto_num, 'url' => ['view', 'id' => $model->presupuesto_num]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="presupuesto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('presupuesto', [
        'model' => $model,
    ]) ?>

</div>
