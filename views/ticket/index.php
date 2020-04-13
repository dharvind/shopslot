<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';

?>
<div class="ticket-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'key',
            'surname',
            'nic',
            'status',
            [
            'attribute' => 'id',
            'label' => 'Start',
            'value' => function ($model) {
                    return date('Y-m-d H:i',strtotime($model->timeslot->start_timestamp));
                },
            ],
            [
            'attribute' => 'id',
            'label' => 'End',
            'value' => function ($model) {
                    return date('Y-m-d H:i',strtotime($model->timeslot->end_timestamp));
                },
            ],

        ],
    ]); ?>


</div>
