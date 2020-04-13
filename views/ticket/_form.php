<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3><?= 'Book ' . date('Y-m-d H:i', strtotime($model->timeslot->start_timestamp)) . ' to ' . date('H:i', strtotime($model->timeslot->end_timestamp)) . ' @ ' . $model->timeslot->shop->name ?></h3>

    <?= $form->field($model, 'timeslot_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Book', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
