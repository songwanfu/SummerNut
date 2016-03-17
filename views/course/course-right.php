
	<div class="lear-start">
		<?php if ($isLearn) : ?>
			<a href="/course/learn?cid=<?php echo $course->id?>" class="btn btn-info btn-start col-lg-12"><?php echo Yii::t('app', 'Learn Continue');?></a>
		<?php else : ?>
			<a href="/course/learn?cid=<?php echo $course->id?>" class="btn btn-info btn-start col-lg-12"><?php echo Yii::t('app', 'Learn Start');?></a>
		<?php endif;?>
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
		  	<?php if ($course->notice): ?>
		  		<h5>课程须知</h5>
		  		<p><?php echo $course->notice;?></p>
		  	<?php endif; ?>
		  	
		  	<?php if ($course->gains) : ?>
					<h5>老师告诉你能学到什么？</h5>
					<p><?php echo $course->gains;?></p>
			  	<!-- <ol>
					  <li>relative与absolute；</li>
					  <li>relative与z-index；</li>
					  <li>relative的最小化影响准则</li>
					</ol> -->
		  	<?php endif; ?>
		  	
		  </div>


	</div>

