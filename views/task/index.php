<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Course;
use app\models\Task;
use app\models\Common;
use kartik\markdown\Markdown;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = $this->title;
if (!empty($courseName)) {
    $this->params['breadcrumbs'][] = $courseName;
    $this->params['breadcrumbs'][] = $chapterName;
} else {
   $this->params['breadcrumbs'][] = Yii::t('app', 'List All Tasks'); 
}



?>
<div class="task-index">
    <?php if (!empty($courseId)) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Task'), ['create?course_id=' . $courseId], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => Yii::t('app', 'Course'),
                'value' => function ($model) {
                    return Course::findRoot($model->course_id)->name;
                }
            ],
            [
                'attribute' => 'course_id',
                'label' => Yii::t('app', 'Chapter'),
                'value' => function ($model) {
                    return Course::findModel($model->course_id)->name;
                }
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model) {
                    return Markdown::convert($model->title);
                }
            ],
            [
                'attribute' => 'option_json',
                'label' => Yii::t('app', 'Options'),
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->task_type == $model::TYPE_CHOICE) {
                        $optionStr = '';
                        $optionStr = Common::parseJsonToStr($model->option_json);
                        return mb_substr($optionStr, 0, 400, 'utf-8');
                    } else {
                        return Yii::t('app', 'Null');
                    }
                }
            ],
            [
                'attribute' => 'answer_json',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->task_type == $model::TYPE_CHOICE) {
                        return implode(',', json_decode($model->answer_json));
                    }
                    return mb_substr(Markdown::convert($model->answer_json), 0, 400, 'utf-8');
                }
            ],
            [
                'attribute' => 'score',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'score', Task::scoreList(Task::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = Task::scoreList();
                    return $list[$model->score];
                },
                'headerOptions' => ['width' => '95px'],
            ],
            [
                'attribute' => 'task_type',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'task_type', Task::typeList(Task::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = Task::typeList();
                    return $list[$model->task_type];
                },
                'headerOptions' => ['width' => '95px'],
            ],
            [
                'attribute' => 'is_timing',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'is_timing', Task::timingList(Task::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = Task::timingList();
                    return $list[$model->is_timing];
                },
                'headerOptions' => ['width' => '95px'],
            ],
            [
                'attribute' => 'complete_time',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'complete_time', Task::timeList(Task::INCLUDE_ALL), ['class' => 'form-control']),
                'value' => function ($model) {
                    $list = Task::timeList();
                    return $list[$model->complete_time];
                },
                'headerOptions' => ['width' => '95px'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
        

</div>
