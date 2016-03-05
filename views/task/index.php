<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $courseName;
$this->params['breadcrumbs'][] = $chapterName;
?>
<div class="task-index">
    <p>
        <?= Html::a(Yii::t('app', 'Create Task'), ['create?course_id=' . $courseId], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'course_id',
            'title:ntext',
            'option_json:ntext',
            'answer_json',
            'score',
            'task_type',
            'is_timing',
            'complete_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
        

</div>
