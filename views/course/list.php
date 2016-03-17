<?php
use yii\widgets\LinkPager;
use app\models\Category;
use app\models\Course;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Course List');
$directionAliasList = Category::directionAliasList();
$directionList = Category::directionList();
?>

<div class="row">
	<h4><?php echo Yii::t('app', 'All Courses');?></h4>
</div>
<hr>
<div class="list-query">
	<div class="row">
		<p class="col-lg-1 col-md-1 col-sm-2 list-query-type"><?php echo Yii::t('app', 'Direction');?>:</p>
		<ul class="col-lg-11 col-md-11 col-sm-10 nav nav-pills">
			<?php if ($c == '') : ?>
		  	<li role="menu" ><a href="/course/list" class="gray"><?php echo Yii::t('app', 'All');?></a></li>
		  <?php else : ?>
		  	<li role="menu" ><a href="/course/list" ><?php echo Yii::t('app', 'All');?></a></li>
		  <?php endif;?>

		  <?php foreach ($directionAliasList as $k => $v) : ?>
		  	<?php if ($k == $activeDirection) : ?>
		  		<li role="menu" ><a href="/course/list?c=<?php echo $k;?>" class="gray"><?php echo $directionList[$v];?></a></li>
				<?php else : ?>
					<li role="menu" ><a href="/course/list?c=<?php echo $k;?>"><?php echo $directionList[$v];?></a></li>
				<?php endif;?>
			<?php endforeach;?>
		</ul>
		<hr>
	</div>

	<div class="row">
		<p class="col-lg-1 col-md-1 col-sm-2 list-query-type"><?php echo Yii::t('app', 'Category');?>:</p>
		<ul class="col-lg-11 col-md-11 col-sm-10 nav nav-pills">
			<?php if ($activeCategory == '') : ?>
		  	<li role="menu" ><a href="/course/list?c=<?php echo $activeDirection;?>&is_easy=<?php echo $is_easy?>" class="gray"><?php echo Yii::t('app', 'All');?></a></li>
		  <?php else : ?>
		  	<li role="menu" ><a href="/course/list?c=<?php echo $activeDirection;?>&is_easy=<?php echo $is_easy?>"><?php echo Yii::t('app', 'All');?></a></li>
			<?php endif;?>

				<?php foreach ($showCategoryList as $category) : ?>
					<?php if ($category->alias == $activeCategory) :?>
						<li role="menu" ><a href="/course/list?c=<?php echo $category->alias;?>&is_easy=<?php echo $is_easy?>" class="gray"><?php echo $category->name;?></a></li>
					<?php else : ?>
						<li role="menu" ><a href="/course/list?c=<?php echo $category->alias;?>&is_easy=<?php echo $is_easy?>"><?php echo $category->name;?></a></li>
					<?php endif;?>
		  	<?php endforeach;?>
		</ul>
		<hr>
	</div>

	<div class="row">
		<p class="col-lg-1 col-md-1 col-sm-2 list-query-type"><?php echo Yii::t('app', 'Level');?>:</p>
		<ul class="col-lg-11 col-md-11 col-sm-10 nav nav-pills">
			<?php if ($activeDifficulty == '') : ?>
		  	<li role="menu" ><a href="/course/list?c=<?php echo $c;?>" class="gray"><?php echo Yii::t('app', 'All');?></a></li>
		  <?php else : ?>
				<li role="menu" ><a href="/course/list?c=<?php echo $c;?>" ><?php echo Yii::t('app', 'All');?></a></li>
			<?php endif;?>
			<?php foreach (Course::levelList() as $k => $v) : ?>
				<?php if ($k == $activeDifficulty) : ?>
		  		<li role="menu" ><a href="/course/list?c=<?php echo $c;?>&is_easy=<?php echo $k;?>" class="gray"><?php echo $v;?></a></li>
				<?php else : ?>
		  		<li role="menu" ><a href="/course/list?c=<?php echo $c;?>&is_easy=<?php echo $k;?>"><?php echo $v;?></a></li>
				<?php endif;?>
			<?php endforeach;?>
		</ul>
		<hr>
	</div>
</div>


	<div class="row">
		<div class="col-lg-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#new" data-toggle="tab"><?php echo Yii::t('app', 'New');?></a></li>
				<li><a href="#hot" data-toggle="tab"><?php echo Yii::t('app', 'Hot');?></a></li>
			</ul>
			<div class="tab-content">
				
				<div class="tab-pane active" id="new">
					<div class="row list-preivew">
						<?php if (empty($newCourseList)) : ?>
							<div class="col-lg-12">
								<div class="alert alert-warning" role="alert"><?php echo Yii::t('app', 'More wonderful courses are creating, to be continued!');?></div>
							</div>
						<?php else : ?>
							<?php foreach ($newCourseList as $courseList) : ?>
								<?php foreach ($courseList as $course) : ?>
									<div class="col-lg-3 col-md-3 ">
										<a href="/course/view?cid=<?php echo $course->id;?>"><img src="<?php echo $course->icon;?>" class="img-rounded blur"></a>
										<h5 style="text-align: left"><?php echo $course->name;?></h5>
										<h6 class="course-tips"><?php echo $course->introduction?></h6>
										<span class="course-leaner">更新完毕</span>
										<span class="course-status">9773人学习</span>
									</div>
								<?php endforeach;?>
							<?php endforeach;?>
						<?php endif;?>
					</div>
				</div>

				<div class="tab-pane" id="hot">
					<div class="row list-preivew">
						<?php if (empty($hotCourseList)) : ?>
							<div class="col-lg-12">
								<div class="alert alert-warning" role="alert"><?php echo Yii::t('app', 'More wonderful courses are creating, to be continued!');?></div>
							</div>
						<?php else : ?>
							<?php foreach ($hotCourseList as $courseList) : ?>
								<?php foreach ($courseList as $course) : ?>
									<div class="col-lg-3 col-md-3 ">
										<a href="/course/view?cid=<?php echo $course->id;?>"><img src="<?php echo $course->icon;?>" class="img-rounded blur"></a>
										<h5 style="text-align: left"><?php echo $course->name;?></h5>
										<h6 class="course-tips"><?php echo $course->introduction?></h6>
										<span class="course-leaner">更新完毕</span>
										<span class="course-status">9773人学习</span>
									</div>
								<?php endforeach;?>
							<?php endforeach;?>
						<?php endif;?>
					</div>
				</div>
	
			</div>
		</div>
	</div>

<?php 
// echo LinkPager::widget([
//     'pagination' => 6,
// ]);
?>
