<?php
use yii\widgets\LinkPager;
use app\models\Course;
use app\models\CourseComment;
use app\models\User;
use app\models\Common;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'View');

$judgments = CourseComment::judgmentList($course->id);
$judgmentCount = count($judgments);

?>

<div class="wrap">
	<div class="row course-view-infos">
		<?= $this->render('course-top', ['course' => $course, 'categoryModel' => $categoryModel])?>

	</div>

	<div class="row view-body">
		<div class="col-lg-9 col-md-9 col-sm-9 course-view-body">
			<div class="col-lg-12 course-introduction">
				<span class="introduction-title"><?php echo Yii::t('app', 'Course Introduction')?></span>
				<p><?php echo $course->introduction;?></p>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 course-outline">
				<ul class="course-outline-top list-inline">
					<li><span class="outline-title"><?php echo Yii::t('app', 'Course Index')?></span></li>
					<li><span class="fa fa-play-circle-o"></span><span class="badge"><?php echo $videoCount;?></span></li>
					<!-- <li><span class="fa fa-list"></span><span class="badge">2</span></li> -->
				</ul>

				<ul class="outline-body list-unstyled outline-body">
					<?php foreach (Course::getChapterList($course->id) as $chapter): ?>
						<li class="col-lg-12 col-md-12 col-sm-12 outline-body-list">
							<span class="col-lg-1 col-md-1 col-sm-1 fa fa-list fa-2x "></span>
							<h5 class="col-lg-11 col-md-11 col-sm-11"><?php echo $chapter['chapterName'];?></h5>
							<?php if (!empty($chapter['chapterIntro'])): ?>
								<h6 class="col-lg-11 col-md-11 col-sm-11"><?php echo $chapter['chapterIntro'];?></h6>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
					
				</ul>
				
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 course-comment">
				<span class="comment-title"><?php echo Yii::t('app', 'Course Judgement')?></span>
				<?php if (!CourseComment::isCommented(Yii::$app->user->id, $course->id) && !empty(Yii::$app->user->id)): ?>
					<span class="fa fa-comment addComment" onclick="alertAddCommentMoal();"><?php echo Yii::t('app', 'Add Course Judgement')?></span>
				<?php endif ?>
				<div class="evaluation-info col-lg-12 col-md-12 col-sm-12">
					<span><?php echo Yii::t('app', 'satisfaction score')?>：<?php $arr = CourseComment::courseAvgScore($course->id);$score = ceil($arr[0]['avgScore']);echo $score;?></span>
					<?php for ($i = 1; $i <=5; $i++): ?>
						<?php if ($i <= $score) : ?>
							<span class="fa fa-star"></span>
						<?php else : ?>
							<span class="fa fa-star-o"></span>
						<?php endif;?>
					<?php endfor;?>
					
					<span class="comment-total"><?php echo $judgmentCount;?><?php echo Yii::t('app', 'students comment')?></span>
				</div>
				<?php foreach ($judgments as $judgment): ?>

					<div class="media col-lg-12 col-md-12 col-sm-12 evaluation-con">
					  <div class="media-left media-middle">
					    <a href="#">
				      	<img class="media-object img-circle" src="<?php echo User::findModel($judgment->user_id)->head_picture;?>" alt="..." width="60px">	
				      </a>
					  </div>
					  <div class="media-body">
					  	<span class="evaluation-name"><?php echo User::findModel($judgment->user_id)->username;?></span>
					  	<?php for ($i = 1; $i <=5; $i++): ?>
								<?php if ($i <= $judgment->score) : ?>
									<span class="fa fa-star"></span>
								<?php else : ?>
									<span class="fa fa-star-o"></span>
								<?php endif;?>
							<?php endfor;?>
					    <h5 class="media-heading evaluation-content"><?php echo $judgment->content;?></h5>
					    <h6 class="evaluation-time"><?php echo Yii::t('app', 'Time')?>：<?php echo Common::getAwayTime($judgment->comment_time);?></h6>
					  </div>
					</div>

				<?php endforeach ?>



			</div>

		</div>

		<div class="col-lg-3  col-md-3 col-sm-3 course-view-right">
			<?= $this->render('course-right', ['btn' => 'view', 'isLearn' => $isLearn, 'course' => $course])?>

		</div>

	</div>


</div>


<!-- 弹出提示框-->
  <div class="modal fade" id="commentModal"  tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header" style="background-color: rgba(91,192,222,1)">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="commentModal-title"><?php echo Yii::t('app', 'Add Comment')?></h4>
      </div>
      <div class="commentModal-body">

				<form class="form-horizontal">
				  <div class="form-group">
				    <label for="inputComment" class="col-sm-2 col-lg-1 control-label"><?php echo Yii::t('app', 'Comment')?></label>
				    <div class="col-sm-10 col-lg-10">
				      <input type="email" class="form-control" id="input-add-comment" placeholder="Comment">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputComment" class="col-sm-2 col-lg-1 control-label"><?php echo Yii::t('app', 'Star')?></label>
				    <div class="col-sm-10 col-lg-10">
				    	<span class="fa fa-heart-o fa-lg" id="star-1" onclick="addStar(1)"></span>
				    	<span class="fa fa-heart-o fa-lg" id="star-2" onclick="addStar(2)"></span>
				    	<span class="fa fa-heart-o fa-lg" id="star-3" onclick="addStar(3)"></span>
				    	<span class="fa fa-heart-o fa-lg" id="star-4" onclick="addStar(4)"></span>
				    	<span class="fa fa-heart-o fa-lg" id="star-5" onclick="addStar(5)"></span>
				    </div>
				  </div>
				</form>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" onclick="doAddComment(<?php echo $course->id;?>)"><?php echo Yii::t('app', 'Create')?></button> 
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app', 'Close')?></button>          
      </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript">
	function alertAddCommentMoal()
	{
		$("#commentModal").modal();
	}

	var score = 5;
	function addStar(id)
	{
		var i = 1;
		for (; i <= id; i++) {
			$('#star-' + i).attr('class', 'fa fa-heart fa-lg');
		};
		for (; i <= 5; i++) {
			$('#star-' + i).attr('class', 'fa fa-heart-o fa-lg');
		}
		score = id;
	}

	function doAddComment(courseId)
	{
		var content = $('#input-add-comment').val();
		if (content.length == 0 || content.length > 255) {
			alert('评论不能为空');
			return;
		} else {
			$.ajax({
				url: '/course-comment/add-jugement',
				type: 'post',
				dataType: 'json',
				data: {
					courseId: courseId,
					content: content,
					score: score,
				},
				success: function (json) {
					window.location.reload();
				},
				error: function () {
					window.location.href = '/site/login';
				}
			});
		}

	}

</script>
