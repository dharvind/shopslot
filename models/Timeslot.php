<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "timeslot".
 *
 * @property int $id
 * @property string $start_timestamp
 * @property string $end_timestamp
 * @property int $count
 * @property string $status
 * @property int $shop_id
 *
 * @property Ticket[] $tickets
 * @property Shop $shop
 */
class Timeslot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeslot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_timestamp', 'end_timestamp', 'count', 'status', 'shop_id'], 'required'],
            [['start_timestamp', 'end_timestamp'], 'safe'],
            [['count', 'shop_id'], 'integer'],
            [['status'], 'string', 'max' => 45],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_timestamp' => 'Start',
            'end_timestamp' => 'End',
            'count' => 'Count',
            'status' => 'Status',
            'shop_id' => 'Shop',
        ];
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['timeslot_id' => 'id']);
    }

    /**
     * Gets query for [[Shop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }



    /**
     * Return Day and Alpha string
     */
    public function getDayAlpha() {
        $day = date('D',strtotime($this->start_timestamp));
        $dayStr = "";
        switch ($day) {
            case "Mon":
                $dayStr = $day . '(' . $this->shop->mon_alpha_csv . ')';
                break;
            case "Tue":
                $dayStr = $day . '(' . $this->shop->tue_alpha_csv . ')';
                break;
            case "Wed":
                $dayStr = $day . '(' . $this->shop->wed_alpha_csv . ')';
                break;
            case "Thu":
                $dayStr = $day . '(' . $this->shop->thu_alpha_csv . ')';
                break;
            case "Fri":
                $dayStr = $day . '(' . $this->shop->fri_alpha_csv . ')';
                break;
            case "Sat":
                $dayStr = $day . '(' . $this->shop->sat_alpha_csv . ')';
                break;
            default:
                return $dayStr;
                break;
        }
        return $dayStr;
    }
}
