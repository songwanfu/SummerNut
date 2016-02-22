<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Videos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Video'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'status',
            'icon',
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name . '.' . $model->extension, ["play?id=$model->id"]);
                }
            ],
            'size',
            'duration',
            'play_count',
            'download_count',
            'create_time',
            'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
