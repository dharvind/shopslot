<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ticket */

$this->title = 'Ticket verification';

\yii\web\YiiAsset::register($this);
?>
<div class="ticket-view">

    <h3>
    <?php 
        if($success==1) {
            echo '<h3 class="success-summary">Valid!</h3>';
        }
        else{
            echo '<h3 class="error-summary">Invalid!</h3>';
        }
    ?>
    </h3>

</div>
