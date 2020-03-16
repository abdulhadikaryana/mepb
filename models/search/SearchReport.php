<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * SearchUser represents the model behind the search form about `app\models\User`.
 */
class SearchReport extends User
{
    public $fullname, $start_date, $end_date, $date_range;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname', 'date_range', 'start_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = User::find();
        $query->joinWith('profiles');
        $query->joinWith('penyebarluasan')
                ->joinWith('konsolidasi')
                ->joinWith('pendataan');
        $query->where(['user.group' => 40]);
        $query->andWhere(['user.status' => 10]);
        // add conditions that should always apply here

        // $query->createCommand()->rawSql;
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // if (!is_null($this->date_range) && strpos($this->date_range, ' - ') !== false ) {
        //     list($start_date, $end_date) = explode(' - ', $this->date_range);
        //     $query->andFilterWhere(['between', 'penyebarluasan.tanggal_entri', $start_date, $end_date]);
        //     $this->date_range = null;
        // }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     // 'profile.fullname' => $this->fullname,
        // ]);

        $query->andFilterWhere(['between', 'penyebarluasan.tanggal_entri', date('Y-m-d', strtotime($this->start_date)), date('Y-m-d', strtotime($this->end_date))]);
        $query->orFilterWhere(['between', 'konsolidasi.tanggal_entri', date('Y-m-d', strtotime($this->start_date)), date('Y-m-d', strtotime($this->end_date))]);
        $query->orFilterWhere(['between', 'pendataan.tanggal_entri', date('Y-m-d', strtotime($this->start_date)), date('Y-m-d', strtotime($this->end_date))]);

        $query->andFilterWhere(['like', 'profile.fullname', $this->fullname])
            ->orFilterWhere(['like', 'user.email', $this->fullname]);

        // $date = explode('-', $this->date_range);
        // var_dump($this->start_date);

        // $query->andWhere(['>=', 'penyebarluasan.tanggal_entri', $this->start_date]);
        // $query->andWhere(['<=', 'penyebarluasan.tanggal_entri', $this->end_date]);

        // print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        return $dataProvider;
    }
}
