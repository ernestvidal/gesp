<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Albaran */

$this->title = 'Update Albaran: ' . ' ' . $model->albaran_num;
$this->params['breadcrumbs'][] = ['label' => 'Albarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->albaran_num, 'url' => ['view', 'id' => $model->albaran_num]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="albaran-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('albaran', [
        'model' => $model,
    ]) ?>

</div>
