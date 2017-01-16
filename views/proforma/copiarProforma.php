<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="proforma-send">
    <h1><?= Html::encode($this->title) ?></h1>

    <h5>
        Rellenar los campos.
    </h5>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

        <?php
        $form = ActiveForm::begin([
                    'id' => 'mailRecipient-form',
                    'action' => '@web/proforma/copiar/'
                ]);
        ?>

            <?=
            Html::input('text', 'numero_proforma', '', [
                'class' => 'form-control',
                'placeholder' => 'Introducir número proforma'])
            ?>
            <br />
            <?= Html::input('date', 'fecha_proforma', '', ['class' => 'form-control']) ?>

            <br />
            <?= Html::Input('hidden','proforma_id', $numProforma) ?>
            
            <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
            </div>

<?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-1"></div>
    </div>

</div>



