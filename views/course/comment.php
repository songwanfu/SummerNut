<?php
use yii\widgets\LinkPager;
use kartik\markdown\MarkdownEditor;
use app\assets\CommentEmoji;
use app\models\CourseComment;
use app\models\Common;
use app\models\user;
use app\models\Resource;

CommentEmoji::register($this);
$this->title = Yii::t('app', 'Comment');

// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = 'HTML/CSS';
// $this->params['breadcrumbs'][] = 'CSS深入理解之relative';
?>

<div class="wrap">
	<div class="row course-view-infos">
		<?= $this->render('course-top', ['course' => $course, 'categoryModel' => $categoryModel])?>
	</div>

	<div class="row learn-body">
		<div class="col-lg-9 course-learn-body">
			<div class="learn-progress progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $learnPersent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $learnPersent?>%;">
          <span>已学<?php echo $learnPersent . '%'?> 用时 <?php echo $learnTimeToal?></span>
        </div>
      </div>
			<div class="col-lg-12 course-menu">
				<ul class="list-inline">
				  <li class="col-lg-4"><a href="/course/learn?cid=<?php echo $course->id;?>"><h4>章节</h4></li></a>
				  <li class="col-lg-4 menu-active"><a href="/course/comment?cid=<?php echo $course->id;?>"><h4>评论</h4></a></li>
				  <li class="col-lg-4"><a href="/course/qa?cid=<?php echo $course->id;?>"><h4>问答</h4></a></li>
				</ul>
			</div>

			<div class="col-lg-12 course-comment">

	      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-input">
          <textarea class="form-control" placeholder="扯淡、吐槽、表扬、鼓励……想说啥就说啥！" id="comment" rows="3"></textarea>
          <button class="btn btn-info emotion" type="button"><span class="fa fa-smile-o">&nbsp;添加表情</span></button>
        	<button class="btn btn-success comment-send" type="button" id="addCommentSubmit" onclick="addComment(<?php echo $course->id?>)"><span class="fa fa-send">&nbsp;发表评论</span></button>
        </div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-detail">

					<?php $i = 1; foreach (CourseComment::commentList($course->id) as $comment): ?>
						<div class="media col-lg-12 evaluation-con">
						  <div class="media-left media-middle">
						    <a href="#">
						      <img class="media-object img-circle" src="<?php echo User::findModel($comment->user_id)->head_picture?>" alt="" width="60px">
						    </a>
						  </div>
						  <div class="media-body">
						  	<span class="evaluation-name"><?php echo User::findModel($comment->user_id)->username?></span>
						    <h5 class="media-heading evaluation-content" id="comment-content-<?php echo $i?>"><?php echo $comment->content?></h5>
						    <?php if ($comment->course_id == $comment->root_id): ?>
						    	<span class="evaluation-time">时间：<?php echo Common::getAwayTime($comment->comment_time)?></span>
								<?php else: ?>
						    	<span class="evaluation-time">时间：<?php echo Common::getAwayTime($comment->comment_time)?>&nbsp;<a href="/resource/play?id=<?php echo Resource::getVideo($comment->course_id)->url?>">源自:<?php Course::findModel($comment->course_id)->name?></a></span>
						    <?php endif ?>
						    <span class="fa fa-thumbs-o-down comment-down" onclick="commentDown(<?php echo $comment->id?>)"><?php echo $comment->down_count?></span>
						    <span class="fa fa-thumbs-o-up comment-up" onclick="commentUp(<?php echo $comment->id?>)"><?php echo $comment->up_count?></span>
						  </div>
						</div>
					<?php $i++;endforeach ?>
					

					

				</div>

			</div>


		</div>

		<div class="col-lg-3  course-view-right">
			<?= $this->render('course-right', ['isLearn' => true, 'course' => $course])?>
		</div>

	</div>


</div>

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript">

	$(function(){
		$('.emotion').qqFace({
		  id : 'facebox', 
		  assign:'comment', 
		  path:'/img/face/'  
    });
  });

  //解析表情
  function replace_em(str){
    str = str.replace(/\</g,'&lt;');
    str = str.replace(/\>/g,'&gt;');
    str = str.replace(/\n/g,'<br/>');
    str = str.replace(/\[em_([0-9]*)\]/g,'<img src="/img/face/$1.gif" border="0" />');
    return str;
  }

  function addComment(courseId)
  {
  	var content = $('#comment').val();
  	if (content != '' && content.length <= 255) {
  		$.ajax({
  			url: '/course-comment/add-comment',
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
  				alert('失败');
  			}
  		});
  	}
  }

  $(document).ready(function(){
  	for (var i = 1; i <= 100; i++) {
  		$('#comment-content-' + i).html(replace_em($('#comment-content-' + i).text()));
  	}
  });


  function commentUp(commentId)
  {
  	// $('.comment-up').text(parseInt($('.comment-up').text()) + 1);
  	$.ajax({
  		url: '/course-comment/comment-up',
  		type: 'post',
  		dataType: 'json',
  		data: {
  			commentId: commentId
  		},
  		success: function () {
  			window.location.reload();
  		},
  		error: function () {
  			window.location.href = '/site/login';
  		}
  	});
  }

  function commentDown(commentId)
  {

  	// $('.comment-down').text(parseInt($('.comment-down').text()) + 1);
  	$.ajax({
  		url: '/course-comment/comment-down',
  		type: 'post',
  		dataType: 'json',
  		data: {
  			commentId: commentId
  		},
  		success: function () {
  			window.location.reload();
  		},
  		error: function () {
  			window.location.href = '/site/login';
  		}
  	});
  }


</script>