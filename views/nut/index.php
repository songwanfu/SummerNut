<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Course;
use app\models\User;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Nuts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nut-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user_id',
                'label' => Yii::t('app', 'Username'),
                'value' => function ($model) {
                    return User::findModel($model->user_id)->username;
                }
            ],
            [
                'attribute' => 'course_id',
                'label' => Yii::t('app', 'Course'),
                'value' => function ($model) {
                    return Course::findOneById($model->course_id)->name;
                }
            ],
            'nut_count',
            'create_time',
            'update_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{delete}"
            ],
        ],
    ]); ?>

</div>
