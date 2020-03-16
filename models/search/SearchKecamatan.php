<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kecamatan;

/**
 * SearchKecamatan represents the model behind the search form about `app\models\Kecamatan`.
 */
class SearchKecamatan extends Kecamatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama_kecamatan', 'kabkota_id', 'provinsi_id', 'kode_kecamatan'], 'safe'],
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
        $query = Kecamatan::find();

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

        // $query->joinWith('kabkota');
        // $query->joinWith('provinsi');
        $query->leftjoin('kabupatenkota', 'kabupatenkota.id = kecamatan.kabkota_id')
                ->leftjoin('provinsi', 'provinsi.id = kabupatenkota.provinsi_id');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'kabupatenkota.nama_kabkota', $this->kabkota_id])
                ->andFilterWhere(['like', 'kode_kecamatan', $this->kode_kecamatan])
                ->andFilterWhere(['like', 'provinsi.nama_provinsi', $this->provinsi_id])
                ->andFilterWhere(['like', 'nama_kecamatan', $this->nama_kecamatan]);

        return $dataProvider;
    }
}
