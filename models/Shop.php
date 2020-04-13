<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shop".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string|null $comments
 * @property string $email
 * @property int $max_per_slot
 * @property string|null $mon_alpha_csv
 * @property string|null $tue_alpha_csv
 * @property string|null $wed_alpha_csv
 * @property string|null $thu_alpha_csv
 * @property string|null $fri_alpha_csv
 * @property string|null $sat_alpha_csv
 * @property string|null $sun_alpha_csv
 * @property string $open_time
 * @property string $close_time
 * @property string $key
 * @property int $email_verified
 *
 * @property Timeslot[] $timeslots
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'email', 'max_per_slot', 'open_time', 'close_time', 'key', 'email_verified'], 'required'],
            [['max_per_slot', 'slot_duration_min', 'email_verified'], 'integer'],
            [['open_time', 'close_time'], 'safe'],
            [['name', 'address', 'comments', 'email', 'mon_alpha_csv', 'tue_alpha_csv', 'wed_alpha_csv', 'thu_alpha_csv', 'fri_alpha_csv', 'sat_alpha_csv', 'sun_alpha_csv', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'comments' => 'Comments',
            'email' => 'Email',
            'max_per_slot' => 'Max Per Slot',
            'slot_duration_min' => 'Slot Duration',
            'mon_alpha_csv' => 'Mon Alpha Csv',
            'tue_alpha_csv' => 'Tue Alpha Csv',
            'wed_alpha_csv' => 'Wed Alpha Csv',
            'thu_alpha_csv' => 'Thu Alpha Csv',
            'fri_alpha_csv' => 'Fri Alpha Csv',
            'sat_alpha_csv' => 'Sat Alpha Csv',
            'sun_alpha_csv' => 'Sun Alpha Csv',
            'open_time' => 'Open Time',
            'close_time' => 'Close Time',
            'key' => 'Key',
            'email_verified' => 'Email Verified',
        ];
    }

    /**
     * Gets query for [[Timeslots]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimeslots()
    {
        return $this->hasMany(Timeslot::className(), ['shop_id' => 'id']);
    }

    private function returnDates($fromdate, $todate) {
        $fromdate = \DateTime::createFromFormat('d-m-Y H:i', $fromdate);
        $todate = \DateTime::createFromFormat('d-m-Y H:i', $todate);
        return new \DatePeriod(
            $fromdate,
            new \DateInterval('P1D'),
            $todate->modify('+1 day')
        );
    }

    /**
     * Generate Timeslots Initially for x days
     */
    public function generateTimeslots($days) {

        $globStartTime=$this->open_time;
        $globEndTime=$this->close_time;

        $start = new \DateTime('now', new \DateTimeZone(Yii::$app->params['timezone']));
        $end = new \DateTime('now', new \DateTimeZone(Yii::$app->params['timezone']));
        $end->modify('+'.$days.' day');
        $start_time = $start->format('d-m-Y H:i');
        $end_time = $end->format('d-m-Y H:i');
        $duration=$this->slot_duration_min;

        $datePeriod = $this->returnDates($start_time, $end_time);
        foreach($datePeriod as $date) {
            if($date->format('D') != 'Sun') {
                $start_time = $date->format('d-m-Y') . $globStartTime;
                $end_time = $date->format('d-m-Y') . $globEndTime;
                while(strtotime($start_time) < strtotime($end_time)){
                    $s = new \DateTime($start_time, new \DateTimeZone(Yii::$app->params['timezone']));
                    $timeStart = $s->format('Y-m-d H:i');
                    $s->modify('+'.$duration.' minutes');
                    $timeEnd = $s->format('Y-m-d H:i');
                    $start_time = $s->format('d-m-Y H:i');
                    $ts = new Timeslot;
                    $ts->start_timestamp=$timeStart;
                    $ts->end_timestamp=$timeEnd;
                    $ts->count=0;
                    $ts->status='active';
                    $ts->shop_id=$this->id;
                    $ts->save();
                }
            }
        }
    }

    /**
     * Generate Timeslots for next day
     */
    public function generateNextDayTimeslots($sDay, $eDay) {

        $globStartTime=$this->open_time;
        $globEndTime=$this->close_time;

        $start = new \DateTime('now', new \DateTimeZone(Yii::$app->params['timezone']));
        $end = new \DateTime('now', new \DateTimeZone(Yii::$app->params['timezone']));
        $start->modify('+'.$sDay.' day');
        $end->modify('+'.$eDay.' day');
        $start_time = $start->format('d-m-Y H:i');
        $end_time = $end->format('d-m-Y H:i');
        $duration=$this->slot_duration_min;

        $datePeriod = $this->returnDates($start_time, $end_time);
        foreach($datePeriod as $date) {
            if($date->format('D') != 'Sun') {
                $start_time = $date->format('d-m-Y') . $globStartTime;
                $end_time = $date->format('d-m-Y') . $globEndTime;
                while(strtotime($start_time) < strtotime($end_time)){
                    $s = new \DateTime($start_time, new \DateTimeZone(Yii::$app->params['timezone']));
                    $timeStart = $s->format('Y-m-d H:i');
                    $s->modify('+'.$duration.' minutes');
                    $timeEnd = $s->format('Y-m-d H:i');
                    $start_time = $s->format('d-m-Y H:i');
                    $ts = new Timeslot;
                    $ts->start_timestamp=$timeStart;
                    $ts->end_timestamp=$timeEnd;
                    $ts->count=0;
                    $ts->status='active';
                    $ts->shop_id=$this->id;
                    $ts->save();
                }
            }
        }
    }

}
