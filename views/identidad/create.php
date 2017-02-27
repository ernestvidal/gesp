<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Identidad */

$this->title = 'Create Identidad';
$this->params['breadcrumbs'][] = ['label' => 'Identidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identidad-create">

    <!--<h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
