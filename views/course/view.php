<?php
use yii\widgets\LinkPager;
use app\models\Course;
use app\models\CourseComment;
use app\models\User;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'View');

$judgments = CourseComment::findModelsByCId($course->id);
$judgmentCount = count($judgments);
die;
?>

<div class="wrap">
	<div class="row course-view-infos">
		<?= $this->render('course-top', ['course' => $course, 'categoryModel' => $categoryModel])?>

	</div>

	<div class="row view-body">
		<div class="col-lg-9 course-view-body">
			<div class="col-lg-12 course-introduction">
				<span class="introduction-title"><?php echo Yii::t('app', 'Course Introduction')?></span>
				<p><?php echo $course->introduction;?></p>
			</div>

			<div class="col-lg-12 course-outline">
				<ul class="course-outline-top list-inline">
					<li><span class="outline-title"><?php echo Yii::t('app', 'Course Index')?></span></li>
					<li><span class="fa fa-play-circle-o"></span><span class="badge"><?php echo $videoCount;?></span></li>
					<!-- <li><span class="fa fa-list"></span><span class="badge">2</span></li> -->
				</ul>

				<ul class="outline-body list-unstyled outline-body">
					<?php foreach (Course::getChapterList($course->id) as $chapter): ?>
						<li class="col-lg-12 outline-body-list">
							<span class="col-lg-1 fa fa-list fa-2x "></span>
							<h5 class="col-lg-11"><?php echo $chapter['chapterName'];?></h5>
							<?php if (!empty($chapter['chapterIntro'])): ?>
								<h6 class="col-lg-11"><?php echo $chapter['chapterIntro'];?></h6>
							<?php endif; ?>
						</li>
					<?php endforeach ?>
					
				</ul>
				
			</div>

			<div class="col-lg-12 course-comment">
				<span class="comment-title"><?php echo Yii::t('app', 'Course Judgement')?></span>
				<span class="fa fa-comment addComment" onclick="alertAddCommentMoal();"><?php echo Yii::t('app', 'Add Course Judgement')?></span>
				<div class="evaluation-info col-lg-12">
					<span>满意度评分：<?php $arr = CourseComment::courseAvgScore($course->id);$score = ceil($arr[0]['avgScore']);echo $score;?></span>
					<?php for ($i = 1; $i <=5; $i++): ?>
						<?php if ($i <= $score) : ?>
							<span class="fa fa-star"></span>
						<?php else : ?>
							<span class="fa fa-star-o"></span>
						<?php endif;?>
					<?php endfor;?>
					
					<span class="comment-total"><?php echo $judgmentCount;?>位同学参与评价</span>
				</div>
				<?php foreach ($judgments as $judgment): ?>

					<div class="media col-lg-12 evaluation-con">
					  <div class="media-left media-middle">
					    <a href="#">
				      	<img class="media-object img-circle" src="<?php echo User::findOne($judgment->user_id)->head_picture;?>" alt="..." width="60px">	
				      </a>
					  </div>
					  <div class="media-body">
					  	<span class="evaluation-name">黎丶小小小陌</span>
					  	<span class="fa fa-star"></span>
							<span class="fa fa-star"></span>
							<span class="fa fa-star"></span>
							<span class="fa fa-star"></span>
							<span class="fa fa-star"></span>
					    <h5 class="media-heading evaluation-content">挺棒的 支持。</h5>
					    <h6 class="evaluation-time">时间：1天前</h6>
					  </div>
					</div>

				<?php endforeach ?>


<!-- 				<div class="media col-lg-12 evaluation-con">
				  <div class="media-left media-middle">
				    <a href="#">
				      <img class="media-object img-circle" src="http://img.mukewang.com/5642d3e20001c4d401360136-100-100.jpg" alt="..." width="60px">
				    </a>
				  </div>
				  <div class="media-body">
				  	<span class="evaluation-name">快要坏掉的小海</span>
				  	<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star-o"></span>
				    <h5 class="media-heading evaluation-content">老师真心讲的不错，感受到了满满的诚意和爱，感觉世界光明了许多</h5>
				    <h6 class="evaluation-time">时间：4天前</h6>
				  </div>
				</div> -->


			</div>

		</div>

		<div class="col-lg-3  course-view-right">
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
        <h4 class="commentModal-title">添加评价</h4>
      </div>
      <div class="commentModal-body">

				<form class="form-horizontal">
				  <div class="form-group">
				    <label for="inputComment" class="col-sm-2 col-lg-1 control-label">评价</label>
				    <div class="col-sm-10 col-lg-10">
				      <input type="email" class="form-control" id="input-add-comment" placeholder="Comment">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputComment" class="col-sm-2 col-lg-1 control-label">评星</label>
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
        <button type="button" class="btn btn-info" onclick="doAddComment(<?php echo $course->id;?>)">添加</button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>          
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
				url: '/course-comment/add-comment',
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
					alert('服务器连接失败,请重试');
				}
			});
		}

	}

</script>
