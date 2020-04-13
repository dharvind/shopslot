<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comments')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_per_slot')->textInput() ?>

    <?= $form->field($model, 'mon_alpha_csv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tue_alpha_csv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wed_alpha_csv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thu_alpha_csv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fri_alpha_csv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sat_alpha_csv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sun_alpha_csv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'open_time')->textInput() ?>

    <?= $form->field($model, 'close_time')->textInput() ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_verified')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
