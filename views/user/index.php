<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            'head_picture',
            'sex',
            'phone_number',
            'faculty',
            'signature',
            'type',
            'status',
            'login_ip',
            'register_time',
            'login_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
