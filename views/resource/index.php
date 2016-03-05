<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Resource;
use app\models\Course;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ResourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Resources');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resource-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'id',

            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'status', Resource::statusList(Resource::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = Resource::statusList();
                    return $list[$model->status];
                },
                'headerOptions' => ['width' => '100px'],
            ],

            [
               'attribute' => 'resource_type',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'resource_type', Resource::typeList(Resource::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = Resource::typeList();
                    return $list[$model->resource_type];
                },
                'headerOptions' => ['width' => '100px'],
            ],

            'name',
            // 'icon',
            'extension',
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name . '.' . $model->extension, ["play?id=$model->id"]);
                }
            ],
            'size',
            // 'duration',
            
            
            [
                'label' => Yii::t('app', 'Chapter'),
                'value' => function ($model) {
                    return Course::findModel($model->course_id)->name;
                }   
            ],

            [
                'label' => Yii::t('app', 'Course'),
                'attribute' => 'course_id',
                'value' => function ($model) {
                    return Course::findRoot($model->course_id)->name;
                }   
            ],
            'play_count',
            'download_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

