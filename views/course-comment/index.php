<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Course Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Course Comment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'course_id',
            'content',
            'score',
            // 'up_count',
            // 'down_count',
            // 'comment_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
