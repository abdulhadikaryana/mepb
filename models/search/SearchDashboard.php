<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ViewKegiatan;

/**
 * SearchUser represents the model behind the search form about `app\models\User`.
 */
class SearchDashboard extends ViewKegiatan
{
    public $fullname, $start_date, $end_date, $date_range, $month, $year;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname', 'kegiatan', 'created_by', 'lokasi', 'tanggal_entri', 'date_range', 'start_date', 'end_date', 'month', 'year'], 'safe'],
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
        $query = ViewKegiatan::find();
        $query->select([
            'tanggal_entri',
            'SUM(CASE WHEN kegiatan=\'penyebarluasan informasi\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS penyebarluasan',
            'SUM(CASE WHEN kegiatan=\'konsolidasi masalah\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS konsolidasi',
            'SUM(CASE WHEN kegiatan=\'pendataan\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS pendataan',
        ]);
        
        $query->groupBy('userid');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'sort' => [
            //     'defaultOrder' => [
            //         'id' => SORT_ASC,
            //     ]
            // ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       if (!is_null($this->date_range) && strpos($this->date_range, ' TO ') !== false ) {
            list($start_date, $end_date) = explode(' TO ', $this->date_range);
            $query->andFilterWhere(['between', 'tanggal_entri', date('Y-m-d', strtotime($this->start_date)), date('Y-m-d', strtotime($this->end_date))]);
            $query->orWhere(['tanggal_entri' => NULL]);
            $this->date_range = null;
        }

        // grid filtering conditions
        $query->orFilterWhere([
            // 'IS', 'tanggal_entri', NULL
        ]);
        
        $query->andFilterWhere(['like', 'fullname', $this->fullname])
                ->orFilterWhere(['like', 'username', $this->fullname]);

        // print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        return $dataProvider;
    }

    public function searchByPenggiat($params)
    {
        $query = ViewKegiatan::find();
        $query->select([
            'userid', 'created_by', 'tanggal_entri', 'fullname', 'obyek', 'kegiatan',
            // 'SUM(CASE WHEN kegiatan=\'penyebarluasan informasi\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS penyebarluasan',
            // 'SUM(CASE WHEN kegiatan=\'konsolidasi masalah\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS konsolidasi',
            // 'SUM(CASE WHEN kegiatan=\'pendataan\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS pendataan',
        ]);
        // $query->where(['created_by' => Yii::$app->user->identity->id]);
        $query->groupBy('userid');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'sort' => [
            //     'defaultOrder' => [
            //         'id' => SORT_ASC,
            //     ]
            // ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!is_null($this->date_range) && strpos($this->date_range, ' TO ') !== false ) {
            list($start_date, $end_date) = explode(' TO ', $this->date_range);
            $query->andFilterWhere(['between', 'tanggal_entri', date('Y-m-d', strtotime($this->start_date)), date('Y-m-d', strtotime($this->end_date))]);
            $query->orWhere(['tanggal_entri' => NULL]);
            $this->date_range = null;
        }

        // grid filtering conditions
        $query->orFilterWhere([
            // 'IS', 'tanggal_entri', NULL
        ]);
        
        $query->andFilterWhere(['like', 'fullname', $this->fullname])
                ->orFilterWhere(['like', 'username', $this->fullname]);

        // print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        return $dataProvider;
    }

    public function searchReportByPenggiat($params)
    {
        $query = ViewKegiatan::find();
        $query->select([
            'userid', 'tanggal_entri', 'kegiatan', 'obyek',
        ]);
        $query->where(['created_by' => Yii::$app->user->identity->id]);
        $query->groupBy('tanggal_entri', 'kegiatan');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tanggal_entri' => SORT_ASC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        
        $month_period = $this->year . '-' . $this->month;
        $query->andFilterWhere(['like', 'tanggal_entri', $month_period]);
        // print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        return $dataProvider;
    }
}
