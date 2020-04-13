<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $key
 * @property string|null $qr
 * @property string $surname
 * @property string|null $nic
 * @property string $email
 * @property string|null $status
 * @property int $timeslot_id
 * @property int $email_verified
 *
 * @property Timeslot $timeslot
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'surname', 'email', 'timeslot_id', 'email_verified', 'nic'], 'required'],
            [['timeslot_id', 'email_verified'], 'integer'],
            [['key', 'qr', 'surname', 'email'], 'string', 'max' => 255],
            [['nic', 'status'], 'string', 'max' => 45],
            [['timeslot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Timeslot::className(), 'targetAttribute' => ['timeslot_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'qr' => 'Qr',
            'surname' => 'Surname',
            'nic' => 'NIC',
            'email' => 'Email',
            'status' => 'Status',
            'timeslot_id' => 'Timeslot',
            'email_verified' => 'Email Verified',
        ];
    }

    public function getSubject() {
        return $this->surname . ' ' . 
        date('Y-m-d H:i',strtotime($this->timeslot->start_timestamp)) . 
        '-' . 
        date('H:i',strtotime($this->timeslot->end_timestamp)) . 
        ' @' . 
        $this->timeslot->shop->name;
    }

    public function getVerificationLink() {
        return Yii::$app->params['baseurl'] . 'ticket/verify/?key=' . $this->key;
    }

    public function getShopVerificationLink() {
        return Yii::$app->params['baseurl'] . 'ticket/shop-verify/?key=' . $this->key;
    }

    /**
     * Gets query for [[Timeslot]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimeslot()
    {
        return $this->hasOne(Timeslot::className(), ['id' => 'timeslot_id']);
    }

    /**
     * Check Surname against _alpha_csv
     */
    public function surnameIsAllowed() {
        $firstLetter = strtolower(substr($this->surname,0,1));
        switch (date('D',strtotime($this->timeslot->start_timestamp))) {
            case "Mon":
                if ( strpos(strtolower($this->timeslot->shop->mon_alpha_csv), $firstLetter) !== false ) {
                    return true;
                }
                else {
                    return false;
                }
                break;
            case "Tue":
                if ( strpos(strtolower($this->timeslot->shop->tue_alpha_csv), $firstLetter) !== false ) {
                    return true;
                }
                else {
                    return false;
                }
                break;
            case "Wed":
                if ( strpos(strtolower($this->timeslot->shop->wed_alpha_csv), $firstLetter) !== false ) {
                    return true;
                }
                else {
                    return false;
                }
                break;
            case "Thu":
                if ( strpos(strtolower($this->timeslot->shop->thu_alpha_csv), $firstLetter) !== false ) {
                    return true;
                }
                else {
                    return false;
                }
                break;
            case "Fri":
                if ( strpos(strtolower($this->timeslot->shop->fri_alpha_csv), $firstLetter) !== false ) {
                    return true;
                }
                else {
                    return false;
                }
                break;
            case "Sat":
                if ( strpos(strtolower($this->timeslot->shop->sat_alpha_csv), $firstLetter) !== false ) {
                    return true;
                }
                else {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
        return false;
    }
}
