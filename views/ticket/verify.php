<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Ticket */

$this->title = 'Ticket verification';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ticket-view">

    <h3>
    <?php 
        if($success==1) {
            echo '<h3>Booking confirmed! Please check your email or snapshot below for the ticket!</h3>';
            $qrCode = (new QrCode($model->getShopVerificationLink()))
                ->setSize(250)
                ->setMargin(5)
                ->useForegroundColor(51, 153, 255);
                $body='';
                $body.='<h3>Confirmed: '.$model->getSubject().'</h3>';
                $body.='<h4>Shop: '.$model->timeslot->shop->name.'</h4>';
                $body.='<h4>Key: '.$model->key.'</h4>';
                $body.='<h4>Surname: '.$model->surname.'</h4>';
                $body.='<h4>Start: '.$model->timeslot->start_timestamp.'</h4>';
                $body.='<h4>End: '.$model->timeslot->end_timestamp.'</h4>';
                $body.='<img src="' . $qrCode->writeDataUri() . '" />';
                $body.='<p>'.'<a href="'.$model->getShopVerificationLink().'">Verify Validity</a>'.'</p>';
                echo $body;

        }
        else{
            echo '<h3>Invalid booking!</h3>';
        }
    ?>
    </h3>

</div>
