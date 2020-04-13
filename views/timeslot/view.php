<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Timeslot */

$this->title = $model->id;

\yii\web\YiiAsset::register($this);
?>
<div class="timeslot-view">

<p>
        <?= Html::a('Book Slot', ['/ticket/book', 'timeslot' => $model->id], ['class' => 'btn btn-primary']) ?>
</p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'start_timestamp',
            'end_timestamp',
            'count',
            'status',
            [
            'label' => 'Shop',
            'value' => function ($model) {
                    return $model->shop->name;
                },
            ],
        ],
    ]) ?>

</div>
