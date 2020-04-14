<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TimeslotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Timeslots';

?>
<div class="timeslot-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute' => 'name',
            'format' => 'raw',
            'label' => 'Date/Time',
            'value' => function ($model) {
                    if($model->count < $model->shop->max_per_slot && $model->status == 'active') {
                        return '<a href="/ticket/book?timeslot='.$model->id.'">'.$model->shop->name.': '.date('Y-m-d H:i',strtotime($model->start_timestamp)).' to '.date('H:i',strtotime($model->end_timestamp)).'</a>';
                    }
                    else {
                        return $model->shop->name.': '.date('Y-m-d H:i',strtotime($model->start_timestamp)).' to '.date('H:i',strtotime($model->end_timestamp));
                    }
                },
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'label' => 'Day',
                'value' => function ($model) {
                        return $model->getDayAlpha();
                    },
                ],
            'count',
            'status',
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
