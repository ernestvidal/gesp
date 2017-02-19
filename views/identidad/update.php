<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Identidad */

$this->title = 'Update Identidad: ' . ' ' . $model->identidad_id;
$this->params['breadcrumbs'][] = ['label' => 'Identidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->identidad_id, 'url' => ['view', 'id' => $model->identidad_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="identidad-update">

   

    <?= $this->render('identidad', [
        'model' => $model,
        'modelCargo' => $modelCargo,
    ]) ?>

</div>
