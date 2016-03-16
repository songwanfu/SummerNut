<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = Yii::t('app', 'View ', [
    'modelClass' => 'Category',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $model->name);
$this->params['breadcrumbs'][] = Yii::t('app', 'Course');
?>

<div class="container row">
	<?php if (!empty($courseList)) : ?>
		<ul class="list-unstyled category-view">
			<?php 
				$i = 1;
				foreach ($courseList as $course) : 
			?>
			  <li class="col-lg-12">
			  	<div class="col-lg-1 course-view-badge">
			  		<span class="badge hot-<?php echo $i;?>"><?php echo $i;?></span>
			  	</div>
					<div class="col-lg-3 course-view-img">
						<img src="<?php echo $course->icon?>" alt="" class="img-rounded">
					</div>
					<div class="col-lg-5 course-view-introduction">
						<h3><?php echo $course->name?></h3>
						<h5><?php echo $course->introduction?></h5>
						<h5><span>更新完毕</span><span>9773人学习</span></h5>
					</div>
			  </li>
			<?php endforeach;?>
	</ul>

	<?php else : ?>
		<div class="col-lg-12">
			<div class="alert alert-warning" role="alert"><?php echo $model->name;?> 分类下暂时没有相关的课程。️<a href="/category/index" class="alert-link">&lt;&lt;&lt;点此返回</a></div>
		</div>
	<?php endif;?>
	
</div>