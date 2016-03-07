<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Course;
use app\models\Task;
use kartik\markdown\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

// $content = '### Heading 3 ###';
// echo Markdown::process($content); 
// die;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$timingList = Task::timingList();
$typeList = Task::typeList();

$htmlStr = '';
if (!empty($model->option_json)) {
    $options = json_decode($model->option_json, true);
    $options = $options[0]; 
    foreach ($options as $k => $v) {
        $htmlStr .= $k . ':' . PHP_EOL . $v . '<br>';
    }
}
// echo Markdown::convert($model->answer_json);die;

?>
<div class="task-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'course_id',
                'label' => Yii::t('app', 'Course'),
                'value' => Course::findRoot($model->course_id)->name,
            ],
            [
                'attribute' => 'course_id',
                'label' => Yii::t('app', 'Chapter'),
                'value' => Course::findModel($model->course_id)->name,
            ],
            'title:ntext',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => empty($model->image) ? Yii::t('app', 'Null') : Html::img($model->image),
            ],
            [
                'attribute' => 'option_json',
                'label' => Yii::t('app', 'Options'),
                'format' => 'raw',
                'value' => empty($htmlStr) ? Yii::t('app', 'Null') : $htmlStr,
            ],
            [
                'attribute' => 'answer_json',
                'format' => 'raw',
                'value' => Markdown::convert($model->answer_json),
            ],
            'score',
            [
                'attribute' => 'task_type',
                'value' => $typeList[$model->task_type],
            ],
            [
                'attribute' => 'is_timing',
                'value' => $timingList[$model->is_timing],
            ],
            [
                'attribute' => 'complete_time',
                'value' => $model->is_timing == Task::IS_NOT_TIMING ? Yii::t('app', 'Null') : $model->complete_time,
            ],
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
