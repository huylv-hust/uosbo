<?php echo \Fuel\Core\Asset::js('validate/user.js')?>
<?php
if(isset($user))
{
	echo '<script type="text/javascript">$(function(){$("#form_pass").rules( "remove","required" );});</script>';
}
?>
<?php
if(Session::get_flash('error'))
{
?>
	<div role="alert" class="alert alert-danger alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<?php echo Session::get_flash('error');?>
	</div>
<?php
}
?>
<h3>
	ログインアカウント
</h3>
<div class="panel-warning">
	<div class="panel-heading" id="media_error" style="display: none"></div>
</div>

	<form action="<?php echo \Fuel\Core\Uri::base(); ?>master/user/delete" method="post">
		<p class="text-right">
			<a href="<?php echo (\Fuel\Core\Session::get('users_url')) ?  \Fuel\Core\Session::get('users_url') :  \Fuel\Core\Uri::base().'master/users';?>" class="btn btn-warning btn-sm right">
				<i class="glyphicon glyphicon-arrow-left icon-white"></i>
				戻る
			</a>
			<?php
			if(isset($user))
			{
			?>
			<input type="hidden" name="user_id" value="<?php echo $user->user_id;?>">
			<button class="btn btn-danger btn-sm" type="button" id="btn_users_back">
				<i class="glyphicon glyphicon-trash icon-white"></i>
				削除
			</button>
			<?php
			}
			?>
		</p>
	</form>

<?php echo Form::open(array('class' => 'form-inline', 'id' => 'user_form'));?>
	<?php if(isset($user)) {?><input type="hidden" name="user_id" value="<?php echo $user->user_id;?>"> <?php } ?>
	<table class="table table-striped">
		<tbody>
		<tr>
			<th class="text-right">所属</th>
			<td>
				<?php echo Form::select('department_id', Input::post('department_id') ? Input::post('department_id') : (isset($user) ? $user->department_id : ''), $department, array('class' => 'form-control')); ?>
				<span class="text-info">※必須</span>
				<label id="form_department_id-error" class="error" for="form_department_id"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">権限区分</th>
			<td>
				<label class="radio-inline"><?php echo Form::radio('division_type', 1, (Input::post('division_type') && Input::post('division_type') == 1) ? true : (isset($user) && $user->division_type == 1 ? true : false)); ?>管理者</label>
				<label class="radio-inline"><?php echo Form::radio('division_type', 2, (Input::post('division_type') && Input::post('division_type') == 2) ? true : (isset($user) && $user->division_type == 2 ? true : false)); ?>承認者</label>
				<label class="radio-inline"><?php echo Form::radio('division_type', 3, (Input::post('division_type') && Input::post('division_type') == 3) ? true : (isset($user) && $user->division_type == 3 ? true : false)); ?>一般</label>
				<label class="radio-inline"><?php echo Form::radio('division_type', 4, (Input::post('division_type') && Input::post('division_type') == 4) ? true : (isset($user) && $user->division_type == 4 ? true : false)); ?>宇佐美鉱油</label>
				<span class="text-info">※いずれか必須</span>
				<label id="division_type-error" class="error" for="division_type"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">氏名</th>
			<td>
				<?php echo Form::input('name', Input::post('name') ? Input::post('name') : (isset($user) ? $user->name : ''), array('class' => 'form-control', 'size' => 50));?>
				<span class="text-info">※必須</span>
				<label id="form_name-error" class="error" for="form_name"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">ログインID</th>
			<td>
				<?php echo Form::input('login_id', Input::post('login_id') ? Input::post('login_id') : (isset($user) ? $user->login_id : ''), array('class' => 'form-control', 'size' => 50));?>
				<span class="text-info">※必須</span>
				<label id="form_login_id-error" class="error" for="form_login_id"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">パスワード</th>
			<td>
				<?php echo Form::input('pass','', array('class' => 'form-control', 'size' => 50, 'type' => 'password', 'placeholder' => '******'));?>
				<span class="text-info">※必須</span>
				<label id="form_pass-error" class="error" for="form_pass"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">
				メールアドレス
				<button name="add-email-btn" class="btn btn-success btn-sm" type="button">
					<i class="glyphicon glyphicon-plus icon-white"></i>
				</button>
			</th>
			<td id="emails">
				<?php
				isset($user) ? $email = explode(',', $user->mail) : $email = array('');
				foreach($email as $k=>$mail){

				?>
				<div class="email_div" >
					<input index="<?php echo $k;?>" type="text" size="50" class="form-control list_email" name="mail[<?php echo $k; ?>]" value="<?php echo $mail?>">
					<button name="remove-email-btn" class="btn btn-danger btn-sm" type="button">
						<i class="glyphicon glyphicon-trash icon-white"></i>
					</button>
					<label id="mail[<?php echo $k?>]-error" class="error" for="mail[<?php echo $k?>]"></label>
				</div>
				<?php }?>
			</td>
		</tr>
		</tbody>
	</table>

	<div class="text-center">
		<button class="btn btn-primary btn-sm" type="submit">
			<i class="glyphicon glyphicon-pencil icon-white"></i>
			保存
		</button>
	</div>
<?php
	echo Form::close();
?>
