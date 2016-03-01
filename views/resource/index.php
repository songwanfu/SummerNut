<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ResourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Resources');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resource-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create Resource'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'icon',
            'extension',
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name . '.' . $model->extension, ["play?id=$model->id"]);
                }
            ],
            'size',
            'duration',
            'status',
            'resource_type',
            'course_id',
            'play_count',
            'download_count',
            // 'create_time',
            // 'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?= $this->render('/views/_form', [
        'model' => 's',
]) ?>
