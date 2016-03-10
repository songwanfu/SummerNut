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
				<span class="icon-share-alt icon-large" style="margin-left: 20px">分享</span>
				<span class="icon-weibo icon-large"></span>
				<span class="icon-facebook-sign icon-large"></span>
			</div>

	</div>

	<div class="row view-body">
		<div class="col-lg-8 course-view-body">
			<div class="col-lg-12 course-introduction">
				<span class="introduction-title">课程介绍</span>
				<p>relative和absolute的关系总让我们头疼。张鑫旭大大将在本次课程中给大家生动且深入的剖析二者的关系，以及relative与z-index层级的关系，同时给大家分享一些好的relative实践准则。小伙伴们还等什么？</p>
			</div>

			<div class="col-lg-12 course-outline">
				<ul class="course-outline-top list-inline">
					<li><span class="outline-title">课程提纲</span></li>
					<li><span class="icon-play"></span><span class="badge">10</span></li>
					<li><span class="icon-list"></span><span class="badge">2</span></li>
				</ul>

				<ul class="outline-body list-unstyled">
					<li class="outline-body-list">
						<span class="icon-list-ul icon-3x col-lg-2"></span>
						<h5 class="col-lg-10">第1章 relative和absolute相煎何太急</h5>
						<h6 class="col-lg-10">elative和absolute虽然同源，但是实际上是死对头。</h6>
					</li>
					<li class="outline-body-list">
						<span class="icon-list-ul icon-3x col-lg-2"></span>
						<h5 class="col-lg-10">第2章 relative与定位</h5>
						<h6 class="col-lg-10">relative也能使用top/right/bottom/left定位，和absolute有什么区别，有什么特别的地方呢？</h6>
					</li>
				</ul>
				
			</div>

		</div>

	</div>


</div>