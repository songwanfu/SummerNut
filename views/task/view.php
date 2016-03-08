<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Course;
use app\models\Task;
use app\models\Common;
use kartik\markdown\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

// $content = '### Heading 3 ###';
// echo Markdown::process($content); 
// die;

$this->title = $model->title;
$title = mb_substr(strip_tags($this->title), 0, 60);
$title .= '......';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $title;

$timingList = Task::timingList();
$typeList = Task::typeList();

//将选项json解析为字符串
$htmlStr = '';
if ($model->task_type == $model::TYPE_CHOICE) {
    $htmlStr = Common::parseJsonToStr($model->option_json);
}

//将答案json解析为字符串
$answerStr = '';
if ($model->task_type == Task::TYPE_CHOICE) {
    $answerStr = implode(',', json_decode($model->answer_json));
}

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
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => Markdown::convert($model->title),
            ],
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
                'value' => $model->task_type == Task::TYPE_CHOICE ? $answerStr : Markdown::convert($model->answer_json),
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
                'value' => $model->complete_time,
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
