<?php
use yii\widgets\LinkPager;
use kartik\markdown\MarkdownEditor;
use app\assets\CommentEmoji;

CommentEmoji::register($this);
$this->title = Yii::t('app', 'Comment');

// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = 'HTML/CSS';
// $this->params['breadcrumbs'][] = 'CSS深入理解之relative';
?>

<div class="wrap">
	<div class="row course-view-infos">
		<?= $this->render('course-top')?>
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
				  <li class="col-lg-4"><h4>章节</h4></li>
				  <li class="col-lg-4 menu-active"><h4>评论</h4></li>
				  <li class="col-lg-4"><h4>问答</h4></li>
				</ul>
			</div>

			<div class="col-lg-12 course-comment">

	      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-input">
          <textarea class="form-control" placeholder="扯淡、吐槽、表扬、鼓励……想说啥就说啥！" id="comment" rows="3"></textarea>
          <button class="btn btn-info emotion" type="button"><span class="fa fa-smile-o">&nbsp;添加表情</span></button>
        	<button class="btn btn-success comment-send" type="button" id="addCommentSubmit"><span class="fa fa-send">&nbsp;发表评论</span></button>
        </div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-detail">

					<div class="media col-lg-12 evaluation-con">
					  <div class="media-left media-middle">
					    <a href="#">
					      <img class="media-object img-circle" src="http://img.mukewang.com/user/545868f30001886f02200220-40-40.jpg" alt="..." width="60px">
					    </a>
					  </div>
					  <div class="media-body">
					  	<span class="evaluation-name">黎丶小小小陌</span>
					    <h5 class="media-heading evaluation-content">挺棒的 支持。</h5>
					    <span class="evaluation-time">时间：1天前</span>
					    <span class="fa fa-thumbs-o-down comment-down">1</span>
					    <span class="fa fa-thumbs-up comment-up">10</span>
					  </div>
					</div>
					<div class="media col-lg-12 evaluation-con">
					  <div class="media-left media-middle">
					    <a href="#">
					      <img class="media-object img-circle" src="http://img.mukewang.com/user/56dc4a6c0001dbb202000200-40-40.jpg" alt="..." width="60px">
					    </a>
					  </div>
					  <div class="media-body">
					  	<span class="evaluation-name">programme</span>
					    <h5 class="media-heading evaluation-content">在项目中很实用</h5>
					    <span class="evaluation-time">时间：1天前</span>
					    <span class="fa fa-thumbs-o-down comment-down">1</span>
					    <span class="fa fa-thumbs-up comment-up">10</span>
					  </div>
					</div>

				</div>

			</div>


		</div>

		<div class="col-lg-3  course-view-right">
			<?= $this->render('course-right')?>
		</div>

	</div>


</div>

<script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.2.0/jquery.js"></script>
<!-- <script type="text/javascript" src="/js/jquery.qqFace.js"></script> -->
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



</script>