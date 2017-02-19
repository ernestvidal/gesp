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
            <ul>
                <li><h1><?= $model->identidad_id . ' ' . $model->identidad_nombre ?></h1></li>
                <li><?= $model->identidad_razon_social ?></li>
                <li><?= $model->identidad_direccion ?></li>
                <li><?= $model->identidad_cp .' '. $model->identidad_poblacion .''. $model->identidad_provincia ?></li>
                <li><?= $model->identidad_nif ?></li>
                <li><?= $model->identidad_mail ?></li>
                <li><?= $model->identidad_persona_contacto ?></li>
                <li><?= $model->identidad_phone ?></li>
                <li><?= $model->identidad_web ?></li>
                <li><?= $model->identidad_forma_pago .' / '. $model->identidad_cta  ?></li>
                <li><?= $model->identidad_actividad ?></li>
            </ul>
        </div>
    </div>

        <?php
        $cargos = $model['cargos'];

        if (!empty($cargos)) {

            echo "<div class='row'>";
            echo "<div class='col-md-4'>Nombre</div>";
            echo "<div class='col-md-3'>Cargo</div>";
            echo "<div class='col-md-1'>Telf.</div>";
            echo "<div class='col-md-4'>Mail</div>";
            echo "</div>";
            echo "<hr>";


            foreach ($cargos as $cargo) {
                ?>
                <div class="row">
                    <div class="col-md-4"><?= $cargo['cargo_nombre'] ?></div>
                    <div class = "col-md-3"><?= $cargo['cargo_cargo'] ?></div>
                    <div class = "col-md-1"><?= $cargo['cargo_phone'] ?></div>
                    <div class = "col-md-4"><?= $cargo['cargo_mail'] ?></div>
                </div>

                <?php
            }
        }
        ?>




<div class="row">
    <div class="col-md-12">
        <br>
        <br>
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

</div>
</div>
</div>

