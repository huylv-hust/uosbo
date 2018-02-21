<script type = "text/javascript" >
	history.pushState(null, null, 'login');
	window.addEventListener('popstate', function(event) {
		history.pushState(null, null, baseUrl + 'login');
	});
</script>

<h3></h3>

<div class="panel panel-primary">
	<div class="panel-heading">
		ログイン
	</div>
	<div class="panel-body">
		<div class="show-info">
			<?php
				echo render('showinfo');
			?>
		</div>
		<?php
			echo \Fuel\Core\Form::open(array('name' => 'formlogin', 'id' => 'formlogin', 'method' => 'post', 'class' => 'form-horizontal'));
		?>
			<div class="form-group">
				<label class="col-sm-4 control-label">ログインID</label>
				<div class="col-sm-6">
					<?php
						echo \Fuel\Core\Form::input('login_id',\Fuel\Core\Input::post('login_id'),array('class' => 'form-control', 'placeholder' => 'ログインID'));
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">パスワード</label>
				<div class="col-sm-6">
					<?php
					echo \Fuel\Core\Form::input('password','',array('type' => 'password', 'class' => 'form-control', 'placeholder' => 'パスワード'));
					?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-10">
					<?php
						echo \Fuel\Core\Form::submit('submit','ログイン',array('class' => 'btn btn-primary btn-sm', 'id' => 'btn-login'));
					?>
				</div>
			</div>
		<?php
			echo \Fuel\Core\Form::close();
		?>

	</div>
</div>
<script type = "text/javascript" >
	$(function(){
		$('#btn-login').click(function(){
			if($('#form_login_id').val() == '' && $('#form_password').val() == '')
			{
				$('.show-info').html('');
				$('.show-info').html('<div class="alert alert-danger" role="alert">ログインIDとパスワードを入力してください</div>');
				return false;
			}
			if($('#form_login_id').val() == '')
			{
				$('.show-info').html('');
				$('.show-info').html('<div class="alert alert-danger" role="alert">ログインIDを入力してください</div>');
				return false;
			}
			if($('#form_password').val() == '')
			{
				$('.show-info').html('');
				$('.show-info').html('<div class="alert alert-danger" role="alert">パスワードを入力してください</div>');
				return false;
			}

		});
	});

</script>
