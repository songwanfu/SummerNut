<?php
use yii\helpers\Url;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\dialog\Dialog;

echo Dialog::widget([
   'options' => [], // default options
]);
?>

	<div class="row col-lg-8 col-md-8 col-sm-8 user-profile">

		<div class="input-group" id="profile-username">
		  <span class="input-group-addon" id="sizing-addon"><span class="fa fa-user"></span></span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon" value="<?php echo $model->username;?>" id="username">
		</div>

		<div class="input-group" id="profile-email">
		  <span class="input-group-addon" id="sizing-addon"><span class="fa fa-at"></span></span>
		  <input type="text" class="form-control" placeholder="Email" aria-describedby="sizing-addon" value="<?php echo $model->email;?>" id="email">
		</div>

		<div class="input-group" id="profile-signature">
		  <span class="input-group-addon" id="sizing-addon"><span class="fa fa-pencil-square"></span></span>
		  <input type="text" class="form-control" placeholder="Signature" aria-describedby="sizing-addon" value="<?php echo $model->signature;?>" id="signature">
		</div>

		<div class="user-sex">
			<?php $form = ActiveForm::begin([
	        'options' => [
	            'class' => 'form-horizontal',
	        ],
	        'fieldConfig' => [
	            'template' => "{label}\n<div class=\"col-lg-11\">{input}</div>\n",
	            'labelOptions' => ['class' => 'col-lg-1 control-label'],
	        ],
	    ]); ?>
	    	<?= $form->field($model, 'sex')->dropdownList($model->sexList())?>
			<?php ActiveForm::end(); ?>
		</div>
		
		<div class="user-head-pic">
			<label>头像</label>
			<img src="<?php echo $model->head_picture;?>" class="img-circle" width="80px" id="head_pic">
			<span class="fa fa-refresh" onclick="changeHeadPic()" id="refresh">换一换</span>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 upload-head-pic">
			<?php $form = ActiveForm::begin([
        		'options' => [
            	'class' => 'form-horizontal',
            	'enctype' => 'multipart/form-data',
        	],
	    ]); ?>

			<?= $form->field($model, 'head_picture')->label(Yii::t('app', 'Upload Head Picture'))->widget(FileInput::classname(), [
		    'pluginOptions' => [
		        'uploadUrl' => Url::to(['/user/upload-head-pic']),
		        'uploadAsync' => false,
		        'allowedPreviewTypes' => ['image'],
		        'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
		        'maxFileCount' => 1,
		        'maxFileSize' => 1000,
		        'uploadExtraData' => [
		            '_csrf' => Yii::$app->request->csrfToken,
		            'User[id]' => $model->id,
		        ] 
		    ]
	   		]); ?>

	   	<?php ActiveForm::end(); ?>
   	</div>

   	<div class="col-lg-2 col-lg-offset-5 col-md-2 col-md-offset-5 col-sm-2 col-sm-offset-2 profile-save">
   		<button class="btn btn-info" onclick="profileSave()" id="profile-save-btn"><span class="fa fa-spinner fa-pulse" style="display:none"></span>保存</button>
   	</div>
		
		
	</div>

<!-- 	<div class="mengceng">
		<span class="fa fa-refresh fa-spin fa-3x gif"></span>
	</div> -->

	<script type="text/javascript">

		$('#username').focus(function(){
			$('#alert-danger-username').hide();
		});

		$('#email').focus(function(){
			$('#alert-danger-email').hide();
		});

		function profileSave()
		{

			var username = $('#username').val();
			var email = $('#email').val();
			var signature = $('#signature').val();
			var sex = $('#user-sex').find("option:selected").val();

			if (!validateUsername(username)) {
				$('#profile-username').after(setWarning('用户名长度必须大于3个字符且小于16个字符', 'username'));
				return;
			}

			if (!validateEmail(email)) {
				$('#profile-email').after(setWarning('Email格式不正确', 'email'));
				return;
			}

			if (!validateSignature()) {
				return;
				$('#profile-signature').after(setWarning('签名不能多于255个字符', 'signature'));
			}

			$('.fa-pulse').show();

			$.ajax({
				type : 'post',
				url : '/user/update-profile',
				dataType : 'json',
				data : {
					username : username,
					email : email,
					signature : signature,
					sex : sex,
				},
				success : function (json) {
					if (json == 'true') {
						krajeeDialog.alert('修改成功');
						setTimeout(function(){$('.fa-pulse').hide();window.location.reload();}, 1000);
					} else {
						krajeeDialog.alert(json);
					}

					
				},
				error : function (){
					krajeeDialog.alert('服务器连接失败');
				}
			});

		}

		function setWarning(str, column)
		{
			$('#alert-danger-' + column).hide();
			return (
				"<div class='alert alert-danger alert-dismissible' role='alert' id='alert-danger-" + column + "'>"
				+  "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"
				+ "<strong>Oh snap!</strong> " + str
				+"</div>");
		}

</script>