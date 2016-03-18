<?php
use yii\widgets\LinkPager;
use kartik\markdown\MarkdownEditor;
use kartik\markdown\Markdown;
use app\models\Question;
use app\models\Common;
use app\models\User;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'QA');

?>

<div class="wrap">
	<div class="row course-view-infos">
		<?= $this->render('course-top', ['course' => $course, 'categoryModel' => $categoryModel])?>
	</div>

	<div class="row learn-body">
		<div class="col-lg-9 course-learn-body">
			<div class="learn-progress progress">
			  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
			    已学60%用时0小时49分
			  </div>
			</div>
			<div class="col-lg-12 course-menu">
				<ul class="list-inline">
				  <li class="col-lg-4"><a href="/course/learn?cid=<?php echo $course->id;?>"><h4>章节</h4></a></li>
				  <li class="col-lg-4"><a href="/course/comment?cid=<?php echo $course->id;?>"><h4>评论</h4></a></li>
				  <li class="col-lg-4  menu-active"><a href="/course/qa?cid=<?php echo $course->id;?>"><h4>问答</h4></a></li>
				</ul>
			</div>

			<div class="col-lg-12 course-qa">
				<div class="qa-input">
					<?php
						echo MarkdownEditor::widget([
						    'name' => 'markdown', 
						    'options' => ['placeholder' => '求大神！', 'id' => 'input-question'],
						    'height' => 150,
						]);
					?>
					<button class="btn btn-info qa-add-question-btn" onclick="addQuestion(<?php echo $course->id?>)">求答</button>
				</div>

				<div class="qa-detail">
					<?php foreach (Question::getQuestionList($course->id) as $question): ?>
						<div class="media col-lg-12">
						  <div class="media-left media-middle col-lg-2">
						    <a href="#">
						      <img class="media-object img-circle" src="<?php echo User::findModel($question->user_id)->head_picture?>" alt="" width="60px">
						    </a>
						    <span class="qa-name"><?php echo User::findModel($question->user_id)->username?></span>
						  </div>
						  <div class="media-body">
						  	<span class="fa fa-question-circle fa-lg"></span>
						    <span class="media-heading qa-content"><?php echo Markdown::convert($question->content)?></span>
						    <div class="qa-new">
						    	<span class="fa fa-comment fa-lg"></span>
						    	<span>[最新回答]</span>
						    	<span><a href="">lejsure: </a></span>
						    	<span>找到答案了，不妥之处欢迎指正$( "selector" ).eq( index );//等价于$( "selector:eq(index)" );</span>
						    </div>
						    <span class="evaluation-time">时间：<?php echo Common::getAwayTime($question->create_time)?></span>
						    <a href="/course/qadetail?qid=<?php echo $question->id?>"><span class="fa fa-comments comment-down">1</span></a>
						    <a href="/course/qadetail?qid=<?php echo $question->id?>"><span class="fa fa-eye comment-up">10</span></a>
						  </div>
						</div>
					<?php endforeach ?>

			</div>


		</div>

		<div class="col-lg-3  course-view-right">
			<?= $this->render('course-right', ['isLearn' => true, 'course' => $course])?>
		</div>

	</div>


</div>

<script type="text/javascript">
	function addQuestion(courseId)
	{
		var content = $('#input-question').val();
		if (content != '') {
			$.ajax({
				url: '/question/add-question',
				type: 'post',
				dataType: 'json',
				data: {
					courseId: courseId,
					content: content,
				},
				success: function (json) {
					window.location.reload();
				},
				error: function () {
					alert('lianjiehsibai');
				}
			});
		}
	}
</script>