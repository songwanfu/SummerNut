<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
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
            'signature',
            [
                'attribute' => 'sex',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'sex', User::sexList(User::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = User::sexList();
                    return $list[$model->sex];
                },
                'headerOptions' => ['width' => '100px'],
            ],
            // 'phone_number',
            // 'faculty',
            
            [
                'attribute' => 'type',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'type', User::typeList(User::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = User::typeList();
                    return $list[$model->type];
                },
                'headerOptions' => ['width' => '100px'],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'status', User::statusList(User::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = User::statusList();
                    return $list[$model->status];
                },
                'headerOptions' => ['width' => '100px'],
            ],
            'login_ip',
            [
                'attribute' => 'head_picture',
                'format' => ['image', ['width' => '70px', 'class' => 'img-circle']],
            ],
            'register_time',
            'login_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{update}"
            ],
        ],
    ]); ?>

</div>
