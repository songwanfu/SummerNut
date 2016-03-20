<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Course;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'content:ntext',
            [
                'attribute' => 'course_id',
                'label' => Yii::t('app', 'Chapter'),
                'value' =>  function ($model) {
                    return Course::findOneById($model->course_id)->name;
                }
            ],
            // [
            //     'attribute' => 'root_id',
            //     'label' => Yii::t('app', 'Chapter'),
            //     'value' =>  function ($model) {
            //         return Course::findOneById($model->root_id)->name;
            //     }
            // ],
            // 'root_id',
            'create_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{delete}"
            ],
        ],
    ]); ?>

</div>
