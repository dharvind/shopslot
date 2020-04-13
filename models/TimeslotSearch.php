<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Timeslot;

/**
 * TimeslotSearch represents the model behind the search form of `app\models\Timeslot`.
 */
class TimeslotSearch extends Timeslot
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'count', 'shop_id'], 'integer'],
            [['start_timestamp', 'end_timestamp', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Timeslot::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            
            return $dataProvider;
        }
        $query->where(['shop_id' => $params['shop_id']]);
        // grid filtering conditions
        // $query->andFilterWhere([
        //     // 'id' => $this->id,
        //     // 'start_timestamp' => $this->start_timestamp,
        //     // 'end_timestamp' => $this->end_timestamp,
        //     // 'count' => $this->count,
        //     // 'shop_id' => $this->shop_id,
        // ]);

        $query->andFilterWhere(['like', 'status', 'active']);

        return $dataProvider;
    }
}
