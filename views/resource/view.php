<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Resource;
use app\models\Course;
/* @var $this yii\web\View */
/* @var $model app\models\Resource */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Resources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$statusList = Resource::statusList();
$typeList = Resource::typeList();
?>
<div class="resource-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'icon',
            'extension',
            'url:url',
            'size',
            'duration',
            [
                'attribute' => 'status',
                'value' => $statusList[$model->status],
            ],
            [
                'attribute' => 'resource_type',
                'value' => $typeList[$model->resource_type],
            ],
            [
                'attribute' => 'course_id',
                'label' => Yii::t('app', 'Chapter'),
                'value' => Course::findModel($model->course_id)->name,
            ],
            [
                'attribute' => 'course_id',
                'label' => Yii::t('app', 'Course'),
                'value' => Course::findRoot($model->course_id)->name,
            ],
            'play_count',
            'download_count',
            'create_time',
            'update_time',
        ],
    ]) ?>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
