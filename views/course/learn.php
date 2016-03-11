<?php
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'View');

// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = 'HTML/CSS';
// $this->params['breadcrumbs'][] = 'CSS深入理解之relative';
?>

<div class="wrap">
	<div class="row course-view-infos">
			<div class="col-lg-12">
				<ol class="breadcrumb">
				  <li><a href="#">课程</a></li>
				  <li><a href="#">前端开发</a></li>
				  <li><a href='#'>HTML/CSS</a></li>
				  <li class="active">CSS深入理解之relative</li>
				</ol>
			</div>

			<div class="col-lg-12 course-view-title">
				<h2>CSS深入理解之relative</h2>
			</div>
		
			<div class="col-lg-3 col-md-3 col-xs-3 course-view-class">

				<dl>
				  <h4><dt>高级</dt></h4>
				  <dd>难度</dd>
				</dl>
				<dl>
			</div>

			<div class="col-lg-3 col-md-3 col-xs-3 course-view-class">
				<dl>
				  <h4><dt>9934</dt></h4>
				  <dd>学习人数</dd>
				</dl>
				<dl>
			</div>

			<div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-4 course-view-share">
				 
				<span class="icon-heart-empty icon-large">关注</span>
				<span class="icon-share-alt icon-large" style="margin-left: 10px">分享</span>
				<span class="icon-weibo icon-large"></span>
			</div>

	</div>

	<div class="row learn-body">
		<div class="col-lg-9 course-learn-body">

			<div class="col-lg-12 progress">
			  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
			    60%
			  </div>
			</div>


		</div>

		<div class="col-lg-3  course-view-right">
			<div class="lear-start">
				<button class="btn btn-info btn-start col-lg-12">继续学习</button>
			</div>
			<div class="teacher-info">
					<h4 class="teacher-word">讲师提示</h4>
					<div class="media-left media-middle">
				    <a href="#">
				      <img class="media-object img-circle" src="http://img.mukewang.com/user/549beab90001be9037445616-80-80.jpg" alt="..." width="80px">
				    </a>
				  </div>
				  <div class="media-body">
				  	<h5>张鑫旭</h5>
				    <h6 class="teacher-job">页面重构设计</h6>
				  </div>

				  <div class="col-lg-12 course-notice">
				  	<h5>课程须知</h5>
				  	<p>熟悉html代码，了解css属性</p>
				  	<h5>老师告诉你能学到什么？</h5>
				  	<ol>
						  <li>relative与absolute；</li>
						  <li>relative与z-index；</li>
						  <li>relative的最小化影响准则</li>
						</ol>
				  </div>


			</div>

		</div>

	</div>


</div>