<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Banners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Banner'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'img',
                'format' => ['image', ['width' => '370px', 'height' => '100px']],
            ],
            [
                'attribute' => 'jump_target',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->jump_target, $model->jump_target, ['target' => '_blank']);
                }
            ],
            'create_time',
            'update_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{update}{delete}"
            ],
        ],
    ]); ?>

</div>
