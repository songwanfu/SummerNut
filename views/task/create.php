<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
use app\models\Task;
use kartik\markdown\MarkdownEditor;
// use \Michelf\Markdown, \Michelf\SmartyPants;
/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = Yii::t('app', 'Create Task');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="task-create">

	<div class="task-form">

	    <?php $form = ActiveForm::begin([
	        'options' => [
	            'class' => 'form-horizontal',
	            'enctype' => 'multipart/form-data',
	        ],
		]); ?>

	    <?= $form->field($model, 'course_id')->textInput() ?>

	    <?= $form->field($model, 'task_type')->dropdownList(Task::typeList()) ?>

	    <?= $form->field($model, 'title')->textarea(['rows' => 2]) ?>

	 	<?= $form->field($model, 'option_json')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'answer_json')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

	    <?= $form->field($model, 'score')->dropdownList(Task::scoreList()) ?>

	    <?= $form->field($model, 'is_timing')->dropdownList(Task::timingList()) ?>

	    <?= $form->field($model, 'complete_time')->dropdownList(Task::timeList()) ?>

	    <?php //echo $form->field($model, 'option_json')->widget(MarkdownEditor::classname(), ['height' => 260, 'encodeLabels' => true, 'smarty' => true, 'previewAction' => Url::to(['task/preview']),]); ?>

	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>
