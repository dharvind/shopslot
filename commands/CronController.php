<?php

namespace app\commands;

use Yii;
use app\models\Shop;
use app\models\Timeslot;
use app\models\Ticket;
use app\models\ShopSearch;
use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * ShopController implements the CRUD actions for Shop model.
 */
class CronController extends Controller
{
    public function actionIndex() {
        echo "cron service runnning";
    }

    /**
     * Run once every 5 minutes, for every shop that is newly added with email_verified 0, it will initialise 7 days
     */
    public function actionInitialiseTimeslots() {
        $unvShops = Shop::find()->where(['email_verified' => 0])->all();
        foreach ($unvShops as $shop) {
            $shop->generateTimeslots(7);
            $shop->email_verified=1;
            $shop->save();
        }
    }

    /**
     * Run once every 5 minutes to inactivate expired records by time
     */
    public function actionInactivateTimeslots() {
        $activeSlots = Timeslot::find()->where(['status' => 'active'])->andWhere('end_timestamp < CONVERT_TZ(NOW(),"SYSTEM","'.Yii::$app->params['tzmysql'].'")')->all();
        foreach ($activeSlots as $slot) {
            $slot->status='inactive';
            $slot->save();
            $activeTickets = Ticket::find()->where(['timeslot_id' => $slot['id'] ])->andWhere(['status' => 'active'])->all();
            foreach ($activeTickets as $ticket) {
                $ticket->status='inactive';
                $ticket->save();
            }
        }
    }

    /**
     * Run once every 10 minutes to delete inactive records
     */
    public function actionDeleteInactiveRecords() {
        Ticket::deleteAll('status = :status', [':status' => 'inactive']);
        Timeslot::deleteAll('status = :status', [':status' => 'inactive']);
    }

    /**
     * Run once per day - if initial generates for 7days, select 7 and 8
     */
    public function actionGenerateNextTimeslots() {
        $unvShops = Shop::find()->where(['email_verified' => 1])->all();
        foreach ($unvShops as $shop) {
            $shop->generateNextDayTimeslots(7,8);
        }
    }

}
