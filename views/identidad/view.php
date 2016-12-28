<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Identidad */

$this->title = $model->identidad_id;
$this->params['breadcrumbs'][] = ['label' => 'Identidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identidad-view">
    <div class="row">
        <div class="col-md-12">

            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->identidad_id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->identidad_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'identidad_id',
                    'identidad_nombre',
                    'identidad_direccion',
                    'identidad_poblacion',
                    'identidad_nif',
                    'identidad_mail',
                    'identidad_persona_contacto',
                    'identidad_cp',
                    'identidad_provincia',
                    'identidad_web',
                    'identidad_forma_pago',
                    'identidad_cta'
                ],
            ])
            ?>

        </div>
    </div>
</div>
