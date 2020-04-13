<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shop;

/**
 * ShopSearch represents the model behind the search form of `app\models\Shop`.
 */
class ShopSearch extends Shop
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'max_per_slot', 'email_verified'], 'integer'],
            [['name', 'address', 'comments', 'email', 'mon_alpha_csv', 'tue_alpha_csv', 'wed_alpha_csv', 'thu_alpha_csv', 'fri_alpha_csv', 'sat_alpha_csv', 'sun_alpha_csv', 'open_time', 'close_time', 'key'], 'safe'],
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
        $query = Shop::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'max_per_slot' => $this->max_per_slot,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
            'email_verified' => $this->email_verified,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mon_alpha_csv', $this->mon_alpha_csv])
            ->andFilterWhere(['like', 'tue_alpha_csv', $this->tue_alpha_csv])
            ->andFilterWhere(['like', 'wed_alpha_csv', $this->wed_alpha_csv])
            ->andFilterWhere(['like', 'thu_alpha_csv', $this->thu_alpha_csv])
            ->andFilterWhere(['like', 'fri_alpha_csv', $this->fri_alpha_csv])
            ->andFilterWhere(['like', 'sat_alpha_csv', $this->sat_alpha_csv])
            ->andFilterWhere(['like', 'sun_alpha_csv', $this->sun_alpha_csv])
            ->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
