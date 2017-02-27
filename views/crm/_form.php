<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Identidad;

/* @var $this yii\web\View */
/* @var $model app\models\Crm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha')->textInput(['type' => 'date-time', 'value' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd hh:mm')]) ?>


    <?=
    $form->field($model, 'identidad_id')->dropDownList(
            ArrayHelper::map(Identidad::findAll(['identidad_role' => 'CLIENTE']), 'identidad_id', 'identidad_nombre'), ['prompt' => 'A quien se va a facturar...', 'id' => 'identidad_id', 'class' => 'form-control'])
    ?>

    <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'conclusion')->textarea() ?>

    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
