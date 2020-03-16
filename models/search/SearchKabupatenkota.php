<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kabupatenkota;

/**
 * SearchKabupatenkota represents the model behind the search form about `app\models\Kabupatenkota`.
 */
class SearchKabupatenkota extends Kabupatenkota
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama_kabkota', 'tipe', 'provinsi_id', 'kode_kabkota'], 'safe'],
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
        $query = Kabupatenkota::find();

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

        $query->joinWith('provinsi');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'nama_kabkota', $this->nama_kabkota])
            ->andFilterWhere(['like', 'kode_kabkota', $this->kode_kabkota])
            ->andFilterWhere(['like', 'provinsi.nama_provinsi', $this->provinsi_id])
            ->andFilterWhere(['like', 'tipe', $this->tipe]);

        return $dataProvider;
    }
}
