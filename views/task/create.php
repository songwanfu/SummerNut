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

		<span id="choice-a">
			<?= $form->field($model, 'option_A')->textInput(['maxlength' => true]) ?>
		</span>
		
		<span id="choice-b">
			<?= $form->field($model, 'option_B')->textInput(['maxlength' => true]) ?>
		</span>
		
		<span id="choice-c">
			<?= $form->field($model, 'option_C')->textInput(['maxlength' => true]) ?>
		</span>

		<span id="choice-d">
			<?= $form->field($model, 'option_D')->textInput(['maxlength' => true]) ?>
		</span>
		
		<span id="answer_json">
			<?= $form->field($model, 'answer_json')->textarea(['rows' => 2]) ?>
		</span>

		<span id="answer_choice">
	    	<?= $form->field($model, 'answer_choice')->checkboxList($model::answerList()) ?>
		</span>

	    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

	    <?= $form->field($model, 'score')->dropdownList(Task::scoreList()) ?>

	    <?= $form->field($model, 'is_timing')->dropdownList(Task::timingList()) ?>
		
		<span id="complete_time">
	    	<?= $form->field($model, 'complete_time')->dropdownList(Task::timeList()) ?>
		</span>
		

		<span id='code_test_one_input'>
			<div class="col-lg-3 form-group field-task-code_test_one_input">
				<label class="control-label" for="task-code_test_one_input">测试用例输入</label>
				<input type="text" id="task-code_test_one_input" class="form-control" name="Task[code_test_one_input]">

				<div class="help-block"></div>
			</div>
		</span>

		
		<span id='code_test_one_output'>
			<div class="col-lg-3 form-group field-task-code_test_one_output" style="margin-left: 50px">
				<label class="control-label" for="task-code_test_one_output">测试用例输出</label>
				<input type="text" id="task-code_test_one_output" class="form-control" name="Task[code_test_one_output]">

				<div class="help-block"></div>
			</div>
		</span>

		<span id='code_test_two_input'>
			<div class="col-lg-3 form-group field-task-code_test_two_input">
				<label class="control-label" for="task-code_test_two_input">测试用例输入</label>
				<input type="text" id="task-code_test_two_input" class="form-control" name="Task[code_test_two_input]">

				<div class="help-block"></div>
			</div>
		</span>
		
		<span id='code_test_two_output'>
			<div class="col-lg-3 form-group field-task-code_test_two_output">
				<label class="control-label" for="task-code_test_two_output">测试用例输出</label>
				<input type="text" id="task-code_test_two_output" class="form-control" name="Task[code_test_two_output]">

				<div class="help-block"></div>
			</div>
		</span>

		<span id='code_test_three_input'>
			<div class="col-lg-3 form-group field-task-code_test_three_input">
				<label class="control-label" for="task-code_test_three_input">测试用例输入</label>
				<input type="text" id="task-code_test_three_input" class="form-control" name="Task[code_test_three_input]">

				<div class="help-block"></div>
			</div>
		</span>

		<span id='code_test_three_output'>
			<div class="col-lg-3 form-group field-task-code_test_three_output">
				<label class="control-label" for="task-code_test_three_output">测试用例输出</label>
				<input type="text" id="task-code_test_three_output" class="form-control" name="Task[code_test_three_output]">

				<div class="help-block"></div>
			</div>
		</span>
	


	    <?php //echo $form->field($model, 'option_json')->widget(MarkdownEditor::classname(), ['height' => 260, 'encodeLabels' => true, 'smarty' => true, 'previewAction' => Url::to(['task/preview']),]); ?>

	    <div class="col-lg-3 form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>

<script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.2.0/jquery.js"></script>
<script type="text/javascript">

	var TYPE_CHOICE = 1;
	var TYPE_SHORT_ANSWER = 2;
	var TYPE_CALCULATION = 3;
	var TYPE_CODING = 4;
	var IS_TIMING = 1;
	var IS_NOT_TIMING =0;

	taskInit();

	$('#task-task_type').change(function(){
		var type = $(this).children('option:selected').val();
		if (type == TYPE_CHOICE) {
			taskInit();
		} else if (type == TYPE_CODING) {
			choiceClose();
			codeOpen();
			$('#answer_json').show();
		} else {
			choiceClose();
			codeClose();
		}
		
	});

	function taskInit()
	{
		choiceOpen();
		codeClose();
		$('#answer_json').hide();
		$('#complete_time').hide();
	}

	function choiceOpen()
	{
		$('#choice-a').show();
		$('#choice-b').show();
		$('#choice-c').show();
		$('#choice-d').show();
		$('#answer_choice').show();
	}

	function choiceClose()
	{
		$('#choice-a').hide();
		$('#choice-b').hide();
		$('#choice-c').hide();
		$('#choice-d').hide();
		$('#answer_choice').hide();
	}

	function codeOpen()
	{
		$('#code_test_one_input').show();
		$('#code_test_two_input').show();
		$('#code_test_three_input').show();
		$('#code_test_one_output').show();
		$('#code_test_two_output').show();
		$('#code_test_three_output').show();
	}

	function codeClose()
	{
		$('#code_test_one_input').hide();
		$('#code_test_two_input').hide();
		$('#code_test_three_input').hide();
		$('#code_test_one_output').hide();
		$('#code_test_two_output').hide();
		$('#code_test_three_output').hide();
	}

	$('#task-is_timing').change(function(){
		var type = $(this).children('option:selected').val();

		if (type == IS_TIMING) {
			$('#complete_time').show();
		} else {
			$('#complete_time').hide();
		}
		
	});

</script>
