<?php
use app\models\Course;
use app\models\UserCourse;
use app\models\Category;
$directionAliasFlipList = Category::directionAliasFlipList();
$directionList = Category::directionList();

$levelList = Course::levelList();

?>
<html xmlns:wb="http://open.weibo.com/wb">
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
	<div class="col-lg-12">
		<ol class="breadcrumb">
		  <li><a href="/course/list"><?php echo Yii::t('app', 'Course')?></a></li>
		  <li><a href="/course/list?c=<?php echo $directionAliasFlipList[$categoryModel->direction];?>"><?php echo $directionList[$categoryModel->direction];?></a></li>
		  <li><a href='/course/list?c=<?php echo $categoryModel->alias;?>'><?php echo $categoryModel->name;?></a></li>
		  <li class="active"><?php echo $course->name;?></li>
		</ol>
	</div>

	<div class="col-lg-12 course-view-title">
		<h2><?php echo $course->name;?></h2>
	</div>

	<div class="col-lg-3 col-md-3 col-xs-3 course-view-class">

		<dl>
		  <h4><dt><?php echo $levelList[$course->difficulty_level]?></dt></h4>
		  <dd><?php echo Yii::t('app', 'Level');?></dd>
		</dl>
		<dl>
	</div>

	<div class="col-lg-3 col-md-3 col-xs-3 course-view-class">
		<dl>
		  <h4><dt><?php echo $course->learner_count;?></dt></h4>
		  <dd><?php echo Yii::t('app', 'Learner Count');?></dd>
		</dl>
		<dl>
	</div>

	<div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-4 course-view-share">
		<?php if (UserCourse::isFocus(Yii::$app->user->id, $course->id)) : ?>
			<span class="fa fa-heart fa-large" onclick="dropFocus(<?php echo $course->id;?>)"><?php echo Yii::t('app', 'Focused');?></span>
		<?php else : ?>
			<span class="fa fa-heart-o fa-large" onclick="addFocus(<?php echo $course->id;?>)"><?php echo Yii::t('app', 'Focus');?></span>
		<?php endif;?>
		
		<span class="fa fa-share-alt fa-large" style="margin-left: 10px"><?php echo Yii::t('app', 'Share');?></span>
		<wb:share-button appkey="4209546553" addition="simple" type="icon" picture_search="false" ralateUid="2919453367" default_text="分享夏果的精彩课程----<?php echo $course->name?>。夏果，满满的都是干货！"></wb:share-button>
	</div>

<!-- 弹出提示框-->
  <div class="modal fade" id="modal"  tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">***</h4>
      </div>
      <div class="modal-body">
        <p>***</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>          
      </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
<script type="text/javascript">
	function addFocus(courseId)
	{
		focusByAjax('/user-course/add-focus', courseId);
	}

	function dropFocus(courseId)
	{
		focusByAjax('/user-course/drop-focus', courseId);
	}

	function focusByAjax(url, courseId)
	{
		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: {
				courseId: courseId,
			},
			success: function (json) {
				if (json) {
					window.location.reload();
				} else {
					alertModal('关注', "<div class='alert alert-danger' role='alert'>操作失败,请重试</div>");
				}
			},
			error: function () {
				alertModal('关注', "<div class='alert alert-danger' role='alert'>服务器连接失败,请重试</div>");
			}
		});
	}

	/*
	自定义弹出框
	 */
	function alertModal(title, body){
	  $('.modal-title').html("<strong>"+title+"</strong>");
	  $('.modal-body').html(body);
	  $("#modal").modal();
	}
</script>
