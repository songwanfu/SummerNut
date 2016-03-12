<?php
use yii\widgets\LinkPager;
use kartik\markdown\MarkdownEditor;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'QA');

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
				  <li class="col-lg-4"><h4>评论</h4></li>
				  <li class="col-lg-4  menu-active"><h4>问答</h4></li>
				</ul>
			</div>

			<div class="col-lg-12 course-qa">
				<div class="qa-input">
					<?php
						echo MarkdownEditor::widget([
						    'name' => 'markdown', 
						    'options' => ['placeholder' => '求大神！'],
						    'height' => 150,
						]);
					?>
				</div>

				<div class="qa-detail">
					<div class="media col-lg-12">
					  <div class="media-left media-middle col-lg-2">
					    <a href="#">
					      <img class="media-object img-circle" src="http://img.mukewang.com/user/545868f30001886f02200220-40-40.jpg" alt="..." width="60px">
					    </a>
					    <span class="qa-name">黎丶小小小陌</span>
					  </div>
					  <div class="media-body">
					  	<span class="fa fa-question-circle fa-lg"></span>
					    <span class="media-heading qa-content">$('input').eq(1)与$("input:eq(2)") 什么区别？</span>
					    <div class="qa-new">
					    	<span class="fa fa-comment fa-lg"></span>
					    	<span>[最新回答]</span>
					    	<span><a href="">lejsure: </a></span>
					    	<span>找到答案了，不妥之处欢迎指正$( "selector" ).eq( index );//等价于$( "selector:eq(index)" );</span>
					    </div>
					    <span class="evaluation-time">时间：1天前</span>
					    <span class="fa fa-comments comment-down">1</span>
					    <span class="fa fa-eye comment-up">10</span>
					  </div>
					</div>
					<div class="media col-lg-12">
					  <div class="media-left media-middle col-lg-2">
					    <a href="#">
					      <img class="media-object img-circle" src="http://img.mukewang.com/user/534d3a85000149d401000100-40-40.jpg" alt="..." width="60px">
					    </a>
					    <span class="qa-name"> Mr_Hs1ung</span>
					  </div>
					  <div class="media-body">
					  	<span class="fa fa-question-circle fa-lg"></span>
					    <span class="media-heading qa-content">绝对定位是拉伸没搞明白</span>
					    <div class="qa-new">
					    	<span class="fa fa-comment fa-lg"></span>
					    	<span><a href="">[我来回答]</a></span>
					    </div>
					    <span class="evaluation-time">时间：7小时前 </span>
					    <span class="fa fa-comments comment-down">1</span>
					    <span class="fa fa-eye comment-up">10</span>
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