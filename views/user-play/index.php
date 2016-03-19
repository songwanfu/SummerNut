<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Plays');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-play-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User Play'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'chapter_id',
            'user_id',
            'learn_status',
            'learn_time_total:datetime',
            // 'learn_time',
            // 'learn_point',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
