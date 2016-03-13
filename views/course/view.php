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
		<?= $this->render('course-top')?>

	</div>

	<div class="row view-body">
		<div class="col-lg-9 course-view-body">
			<div class="col-lg-12 course-introduction">
				<span class="introduction-title">课程介绍</span>
				<p>relative和absolute的关系总让我们头疼。张鑫旭大大将在本次课程中给大家生动且深入的剖析二者的关系，以及relative与z-index层级的关系，同时给大家分享一些好的relative实践准则。小伙伴们还等什么？</p>
			</div>

			<div class="col-lg-12 course-outline">
				<ul class="course-outline-top list-inline">
					<li><span class="outline-title">课程提纲</span></li>
					<li><span class="fa fa-play-circle-o"></span><span class="badge">10</span></li>
					<li><span class="fa fa-list"></span><span class="badge">2</span></li>
				</ul>

				<ul class="outline-body list-unstyled outline-body">
					<li class="col-lg-12 outline-body-list">
						<span class="col-lg-1 fa fa-list fa-2x "></span>
						<h5 class="col-lg-11">第1章 relative和absolute相煎何太急</h5>
						<h6 class="col-lg-11">elative和absolute虽然同源，但是实际上是死对头。</h6>
					</li>
					<li class="col-lg-12 outline-body-list">
						<span class="col-lg-1 fa fa-list fa-2x"></span>
						<h5 class="col-lg-11">第2章 relative与定位</h5>
						<h6 class="col-lg-11">relative也能使用top/right/bottom/left定位，和absolute有什么区别，有什么特别的地方呢？</h6>
					</li>
				</ul>
				
			</div>

			<div class="col-lg-12 course-comment">
				<span class="comment-title">课程评价</span>
				<div class="evaluation-info col-lg-12">
					<span>满意度评分：8.2</span>
					<span class="fa fa-star"></span>
					<span class="fa fa-star"></span>
					<span class="fa fa-star"></span>
					<span class="fa fa-star"></span>
					<span class="fa fa-star-o"></span>
					<span class="comment-total">44位同学参与评价</span>
				</div>
				<div class="media col-lg-12 evaluation-con">
				  <div class="media-left media-middle">
				    <a href="#">
				      <img class="media-object img-circle" src="http://img.mukewang.com/56e01bb20001315f04500451-100-100.jpg" alt="..." width="60px">
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

				<div class="media col-lg-12 evaluation-con">
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
				</div>


			</div>

		</div>

		<div class="col-lg-3  course-view-right">
			<?= $this->render('course-right')?>

		</div>

	</div>


</div>