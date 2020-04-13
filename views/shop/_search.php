<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ShopSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'comments') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'max_per_slot') ?>

    <?php // echo $form->field($model, 'mon_alpha_csv') ?>

    <?php // echo $form->field($model, 'tue_alpha_csv') ?>

    <?php // echo $form->field($model, 'wed_alpha_csv') ?>

    <?php // echo $form->field($model, 'thu_alpha_csv') ?>

    <?php // echo $form->field($model, 'fri_alpha_csv') ?>

    <?php // echo $form->field($model, 'sat_alpha_csv') ?>

    <?php // echo $form->field($model, 'sun_alpha_csv') ?>

    <?php // echo $form->field($model, 'open_time') ?>

    <?php // echo $form->field($model, 'close_time') ?>

    <?php // echo $form->field($model, 'key') ?>

    <?php // echo $form->field($model, 'email_verified') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
