<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Crm */

$this->title = 'Update Crm: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Crms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="crm-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
