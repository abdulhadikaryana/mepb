<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Konsolidasi;

/**
 * SearchKonsolidasi represents the model behind the search form about `app\models\Konsolidasi`.
 */
class SearchKonsolidasi extends Konsolidasi
{
    public $date_range, $start_date, $end_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_by', 'created_at', 'updated_at', 'setuju_tanggal', 'setuju_oleh', 'version', 'is_rev', 'rev_tanggal', 'rev_oleh', 'rev_no'], 'integer'],
            [['date_range', 'start_date', 'end_date', 'lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'metode', 'sub_metode', 'deskripsi', 'solusi', 'foto1', 'foto2', 'foto3', 'rev_komentar', 'setuju_status', 'setuju_status_upt', 'created_by'], 'safe'],
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
        // if(\Yii::$app->user->can('SuperAdmin') || \Yii::$app->user->can('Operator')) {
        //     $query = Konsolidasi::find();
        // } else {
        //     $query = Konsolidasi::find()->allWithChild();
        // }

        $query = Konsolidasi::find();
        $query->select([
            'konsolidasi.id',
            'konsolidasi.tanggal_entri',
            'konsolidasi.lokasi',
            'konsolidasi.created_by',
            'konsolidasi.desakel',
            'konsolidasi.metode',
            'konsolidasi.sub_metode',
            'konsolidasi.setuju_status',
            'konsolidasi.setuju_status_upt'
        ]);
        $query->joinWith('createdBy');
        $query->leftJoin('profile', 'user.id = profile.user_id');

        // $query->joinWith([
        //     'createdBy' => function($q) {
        //         $q->joinWith('profiles');
        //     }
        // ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tanggal_entri' => SORT_DESC,
                ]
            ]
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
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'setuju_status' => $this->setuju_status,
            'setuju_status_upt' => $this->setuju_status_upt,
            'setuju_tanggal' => $this->setuju_tanggal,
            'setuju_oleh' => $this->setuju_oleh,
            'version' => $this->version,
            'is_rev' => $this->is_rev,
            'rev_tanggal' => $this->rev_tanggal,
            'rev_oleh' => $this->rev_oleh,
            'rev_no' => $this->rev_no,
        ]);

        $query->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'desakel', $this->desakel])
            ->andFilterWhere(['like', 'kecamatan', $this->kecamatan])
            ->andFilterWhere(['like', 'kabupatenkota', $this->kabupatenkota])
            ->andFilterWhere(['like', 'provinsi', $this->provinsi])
            ->andFilterWhere(['like', 'metode', $this->metode])
            ->andFilterWhere(['like', 'sub_metode', $this->sub_metode])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'solusi', $this->solusi])
            ->andFilterWhere(['like', 'user.username', $this->created_by])
            ->orFilterWhere(['like', 'profile.fullname', $this->created_by]);

        if (!is_null($this->date_range) && strpos($this->date_range, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->date_range);
            $query->andFilterWhere(['between', 'DATE(tanggal_entri)', date('Y-m-d', strtotime($this->start_date)), date('Y-m-d', strtotime($this->end_date))]);
            $this->date_range = null;
        }

        // print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        return $dataProvider;
    }
}
