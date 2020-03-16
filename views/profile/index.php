<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Profile', ['manual-create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'label' => 'Email',
                'value' => 'user.email'
            ],
            'fullname',
            // 'birthdate',
            // 'photo:ntext',
            // 'address:ntext',
            // 'user_id',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{manual-view} {manual-update}',
                'buttons' => [
                    'manual-view' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    },
                    'manual-update' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    },
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
