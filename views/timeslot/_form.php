<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Timeslot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timeslot-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'start_timestamp')->textInput() ?>

    <?= $form->field($model, 'end_timestamp')->textInput() ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shop_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
