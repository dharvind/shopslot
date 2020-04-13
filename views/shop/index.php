<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shops';
?>
<div class="shop-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute' => 'name',
            'format' => 'raw',
            'label' => 'Shop',
            'value' => function ($model) {
                    return '<a href="/timeslot/?shop_id='.$model->id.'">'.$model->name.'</a>';
                },
            ],
            'address',
        ],
    ]); ?>


</div>
