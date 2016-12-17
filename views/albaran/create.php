<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Albaran */

$this->title = 'Create Albaran';
$this->params['breadcrumbs'][] = ['label' => 'Albarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
