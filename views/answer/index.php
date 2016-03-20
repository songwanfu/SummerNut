<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Answers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'question_id',
            'content:ntext',
            [
                'attribute' => 'answer_user_id',
                'label' => Yii::t('app', 'Answer User'),
                'value' => function ($model) {
                    return User::findModel($model->answer_user_id)->username;
                }
            ],
            [
                'attribute' => 'answered_user_id',
                'label' => Yii::t('app', 'Answered User'),
                'value' => function ($model) {
                    return User::findModel($model->answered_user_id)->username;
                }
            ],
            // 'asker_status',
            // 'reply_status',
            'create_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{delete}"
            ],
        ],
    ]); ?>

</div>
