<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\ViewKegiatan;
use app\models\User;

/**
 * SearchUser represents the model behind the search form about `app\models\User`.
 */
// class SearchKegiatan extends ViewKegiatan
class SearchKegiatan extends ViewKegiatan
{
    public $username, $fullname, $start_date, $end_date, $date_range, $month, $year, $penyebarluasan, $konsolidasi, $pendataan;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'fullname', 'kegiatan', 'created_by', 'lokasi', 'tanggal_entri', 'date_range', 'start_date', 'end_date', 'month', 'year'], 'safe'],
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
        $this->load($params);
        $start_date = $this->start_date ? $this->start_date : date('Y-m-d');
        $end_date = $this->end_date ? $this->end_date : date('Y-m-d');
        $filterUsername = $this->username ? 'AND user.username LIKE "%'.$this->username.'%" OR profile.fullname like "%'.$this->username.'%"' : '';

        $sql = 'SELECT user.id, user.username, profile.fullname, user.email,
            (SELECT count(penyebarluasan.id) FROM penyebarluasan 
            WHERE user.id=penyebarluasan.created_by AND DATE(penyebarluasan.tanggal_entri) BETWEEN :start_date AND :end_date) AS penyebarluasan,
            (SELECT count(konsolidasi.id) FROM konsolidasi 
            WHERE user.id=konsolidasi.created_by AND DATE(konsolidasi.tanggal_entri) BETWEEN :start_date AND :end_date) AS konsolidasi,
            (SELECT count(pendataan.id) FROM pendataan 
            WHERE user.id=pendataan.created_by AND DATE(pendataan.tanggal_entri) BETWEEN :start_date AND :end_date) AS pendataan
            FROM user
            LEFT JOIN profile ON profile.user_id = user.id
            WHERE user.group = 40 ' .
            $filterUsername .
            'ORDER BY user.username ASC
        ';
        
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [
                ':start_date' => date('Y-m-d', strtotime($start_date)),
                ':end_date' => date('Y-m-d', strtotime($end_date))
            ]
        ]);

        return $dataProvider;
    }

    public function searchByPenggiat($params)
    {
        $query = User::find();
        $query->where(['group' => 40]);
        $query->joinWith('profiles');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'username' => SORT_ASC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
                ->orFilterWhere(['like', 'username', $this->fullname]);

        
        return $dataProvider;
    }

    public function searchReportByPenggiat($params)
    {
        $this->load($params);
        $userid = Yii::$app->user->identity->id;
        
        $sql = 'SELECT penyebarluasan.tanggal_entri,"penyebarluasan" AS kegiatan,
            penyebarluasan.created_by,penyebarluasan.tema AS obyek,penyebarluasan.topik AS topik,
            penyebarluasan.kecamatan 
            FROM penyebarluasan 
            WHERE penyebarluasan.created_by= :created_by AND
            YEAR(penyebarluasan.tanggal_entri) =:year AND MONTH(penyebarluasan.tanggal_entri) =:month
            UNION ALL 
            SELECT konsolidasi.tanggal_entri,"konsolidasi" AS kegiatan,
            konsolidasi.created_by,konsolidasi.metode AS obyek, konsolidasi.sub_metode AS topik,
            konsolidasi.kecamatan 
            FROM konsolidasi 
            WHERE konsolidasi.created_by= :created_by AND 
            YEAR(konsolidasi.tanggal_entri) =:year AND MONTH(konsolidasi.tanggal_entri) =:month
            UNION ALL 
            SELECT pendataan.tanggal_entri,"pendataan" AS kegiatan,
            pendataan.created_by,pendataan.obyek AS obyek, pendataan.name AS topik,
            pendataan.kecamatan 
            FROM pendataan 
            WHERE pendataan.created_by= :created_by AND 
            YEAR(pendataan.tanggal_entri) =:year AND MONTH(pendataan.tanggal_entri) =:month
            ORDER BY tanggal_entri ASC

        ';

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [
                'created_by' => $userid,
                ':year' => $this->year ? $this->year : date('Y'),
                ':month' => $this->month ? $this->month : date('m')
            ]
        ]);

        return $dataProvider;
    }

    public function searchReportByPenggiatOneMonth($params)
    {
        // $query = ViewKegiatan::find();
        // $query->select([
        //     'userid', 'tanggal_entri', 'kegiatan', 'obyek', 'topik', 'kecamatan'
        // ]);
        // $userid = Yii::$app->request->get('id');
        // // print_r($userid);die();
        // if(isset($userid)) {
        //     $query->where(['created_by' => $userid]);
        // }
        // // $query->groupBy('tanggal_entri', 'kegiatan');
        
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'sort' => [
        //         'defaultOrder' => [
        //             'tanggal_entri' => SORT_ASC,
        //         ]
        //     ]
        // ]);

        // $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        // if(!empty($this->year) && !empty($this->month)) {
        //     $month_period = $this->year . '-' . $this->month;
        // } else {
        //     $month_period = date('Y-m');
        // }
        
        // $query->andFilterWhere(['like', 'tanggal_entri', $month_period]);
        // // print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        // return $dataProvider;

        $this->load($params);
        $userid = Yii::$app->request->get('id');
        if(!empty($this->year) && !empty($this->month)) {
            $month_period = $this->year . '-' . $this->month;
        } else {
            $month_period = date('Y-m');
        }

        // $sql = 'SELECT view_master.created_by AS userid, view_master.tanggal_entri, view_master.kegiatan,
        //     view_master.obyek, view_master.topik, view_master.kecamatan 
        //     FROM view_master
        //     LEFT JOIN user ON user.id = view_master.created_by
        //     LEFT JOIN profile ON user.id = profile.user_id
        //     WHERE view_master.created_by =:created_by AND
        //     YEAR(view_master.tanggal_entri) =:year AND MONTH(view_master.tanggal_entri) =:month 
        //     ORDER BY view_master.tanggal_entri ASC
        // ';

        $sql = 'SELECT penyebarluasan.tanggal_entri,"penyebarluasan" AS kegiatan,
            penyebarluasan.created_by,penyebarluasan.tema AS obyek,penyebarluasan.topik AS topik,
            penyebarluasan.kecamatan 
            FROM penyebarluasan 
            WHERE penyebarluasan.created_by= :created_by AND
            YEAR(penyebarluasan.tanggal_entri) =:year AND MONTH(penyebarluasan.tanggal_entri) =:month
            UNION ALL 
            SELECT konsolidasi.tanggal_entri,"konsolidasi" AS kegiatan,
            konsolidasi.created_by,konsolidasi.metode AS obyek, konsolidasi.sub_metode AS topik,
            konsolidasi.kecamatan 
            FROM konsolidasi 
            WHERE konsolidasi.created_by= :created_by AND 
            YEAR(konsolidasi.tanggal_entri) =:year AND MONTH(konsolidasi.tanggal_entri) =:month
            UNION ALL 
            SELECT pendataan.tanggal_entri,"pendataan" AS kegiatan,
            pendataan.created_by,pendataan.obyek AS obyek, pendataan.name AS topik,
            pendataan.kecamatan 
            FROM pendataan 
            WHERE pendataan.created_by= :created_by AND 
            YEAR(pendataan.tanggal_entri) =:year AND MONTH(pendataan.tanggal_entri) =:month
            ORDER BY tanggal_entri ASC

        ';

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [
                'created_by' => $userid,
                ':year' => $this->year ? $this->year : date('Y'),
                ':month' => $this->month ? $this->month : date('m')
            ]
        ]);

        return $dataProvider;
    }

    public function searchTest($params)
    {
        $this->load($params);
        $start_date = $this->start_date ? $this->start_date : date('Y-m-d');
        $end_date = $this->end_date ? $this->end_date : date('Y-m-d');

        $sqlPenyebarluasan = 'SELECT user.id, user.username, user.email,
            (SELECT count(penyebarluasan.id) FROM penyebarluasan 
            WHERE user.id=penyebarluasan.created_by AND penyebarluasan.tanggal_entri BETWEEN :start_date AND :end_date) AS penyebarluasan,
            (SELECT count(konsolidasi.id) FROM konsolidasi 
            WHERE user.id=konsolidasi.created_by AND konsolidasi.tanggal_entri BETWEEN :start_date AND :end_date) AS konsolidasi,
            (SELECT count(pendataan.id) FROM pendataan 
            WHERE user.id=pendataan.created_by AND pendataan.tanggal_entri BETWEEN :start_date AND :end_date) AS pendataan
            FROM user
            WHERE user.group = 40
            ORDER BY user.username ASC
        ';
        
        $dataProviderPenyebarluasan = new SqlDataProvider([
            'sql' => $sqlPenyebarluasan,
            'params' => [
                ':start_date' => date('Y-m-d', strtotime($start_date)),
                ':end_date' => date('Y-m-d', strtotime($end_date))
            ]
        ]);

        return $dataProviderPenyebarluasan;
    }
}
