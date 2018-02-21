<?php echo \Fuel\Core\Asset::js('validate/emcall.js')?>
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
	緊急連絡先
	<button type="button" class="btn btn-success btn-sm" name="add-btn" id="add_btn">
		<i class="glyphicon glyphicon-plus icon-white"></i>
		入力欄追加
	</button>
	<div class="text-right">
		<a href="<?php if(\Fuel\Core\Cookie::get('person_url')) echo \Fuel\Core\Cookie::get('person_url'); else echo Uri::base(true).'job/persons'?>" class="btn btn-warning btn-sm" name="back-btn">
			<i class="glyphicon glyphicon-step-backward icon-white"></i>
			戻る
		</a>
	</div>
</h3>

<p class="text-center">
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/person?person_id=<?php echo $person_id;?>">応募者</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/employment?person_id=<?php echo $person_id;?>">採用管理</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/personfile?person_id=<?php echo $person_id;?>">本人確認書類</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/interviewusami?person_id=<?php echo $person_id;?>">面接票</a>
	|
	<a href="#">緊急連絡先</a>
</p>

<!-- ticket 1065 (thuanth6589) -->
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>対象SS</label>
					<input class="form-control" value="<?php echo $ss_info;?>" disabled type="text">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>氏名（漢字）</label>
					<input class="form-control" value="<?php echo $person['name'];?>" disabled type="text">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>氏名（かな）</label>
					<input class="form-control" value="<?php echo $person['name_kana'];?>" disabled type="text">
				</div>
			</div>
		</div>
	</div>
</div>

<?php if (Session::get_flash('success')): ?>
	<div role="alert" class="sssale_message alert alert-success alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
		<?php echo Session::get_flash('success');?>
	</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
	<div role="alert" class="sssale_message alert alert-danger alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
		<?php echo Session::get_flash('error');?>
	</div>
<?php endif; ?>

<div id="sales">
	<?php
	$i = 0;
	foreach ($emcalls as $k => $emcall)
	{
	?>
	<div class="panel panel-warning">
		<div class="panel-heading text-right">
			<?php if (Session::get_flash('error-'.$k)): ?>
				<span style="float:left"><?php echo Session::get_flash('error-'.$k);?></span>
			<?php endif; ?>
			<form action="<?php echo \Fuel\Core\Uri::base();?>job/emcall/delete" method="POST">
				<input type="hidden" name="panel_index" value="<?php echo $k;?>">
				<input type="hidden" name="emcall_id" value="<?php echo $emcall->emcall_id;?>">
				<button name="delete-btn" class="btn btn-danger btn-sm delete_btn" type="button">
					<i class="glyphicon glyphicon-trash icon-white"></i>
					削除
				</button>
			</form>
		</div>
		<div class="panel-body">
			<?php echo Form::open(array('class' => 'form-inline emcall_form', 'action' => \Fuel\Core\Uri::base() . 'job/emcall?person_id=' . $person_id));?>
				<input type="hidden" name="panel_index" value="<?php echo $k;?>">
				<input type="hidden" name="emcall_id" value="<?php echo $emcall->emcall_id;?>">
				<input type="hidden" name="person_id" value="<?php echo $person_id;?>">
				<div class="input-group">
					<div class="input-group-addon">続柄</div>
					<?php echo Form::select('relationship', $emcall->relationship, Constants::$relationship, array('class' => 'form-control')); ?>
				</div>
				<span class="text-info">※必須</span>
				<label id="form_relationship-error" class="error" for="form_relationship"></label>
				<div class="input-group">
					<div class="input-group-addon">氏名</div>
					<?php echo Form::input('name', $emcall->name, array('class' => 'form-control', 'size' => 20, 'maxlength' => '20'));?>
				</div>
				<span class="text-info">※必須</span>
				<label id="form_name-error" class="error" for="form_name"></label>
				<div class="input-group">
					<div class="input-group-addon">氏名かな</div>
					<?php echo Form::input('name_kana', $emcall->name_kana, array('class' => 'form-control', 'size' => 20, 'maxlength' => '20'));?>
				</div>
				<span class="text-info">※必須</span>
				<label id="form_name_kana-error" class="error" for="form_name_kana"></label>
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">電話番号</div>
					<?php echo Form::input('tel_1', $emcall->tel ? (substr_count($emcall->tel, '-') ? explode('-', $emcall->tel)[0] : substr($emcall->tel,0,4)) : '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
				</div>
				-
				<?php echo Form::input('tel_2', $emcall->tel ? (substr_count($emcall->tel, '-') ? explode('-', $emcall->tel)[1] : substr($emcall->tel,4,4)) : '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
				-
				<?php echo Form::input('tel_3', $emcall->tel ? (substr_count($emcall->tel, '-') ? explode('-', $emcall->tel)[2] : substr($emcall->tel,8,4)) : '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
				<label id="tel-error" class="error" for="tel"></label>
				<div class="input-group">
					<div class="input-group-addon">〒</div>
					<?php echo Form::input('zipcode_first', $emcall->zipcode ? substr($emcall->zipcode,0,3) : '', array('class' => 'form-control', 'size' => 3, 'maxlength' => '3'));?>
				</div>
				-
				<?php echo Form::input('zipcode_last', $emcall->zipcode ? substr($emcall->zipcode,3,4) : '', array('class' => 'form-control', 'size' => 3, 'maxlength' => '4'));?>
				<label id="zipcode-error" class="error" for="zipcode"></label>
				<div class="input-group">
					<div class="input-group-addon">都道府県</div>
					<?php echo Form::select('add1', $emcall->add1, Constants::get_create_address(), array('class' => 'form-control')); ?>
				</div>
				<p></p>
			<?php echo Form::input('add2', $emcall->add2, array('class' => 'form-control', 'size' => 20, 'maxlength' => '20', 'placeholder' => '市区町村'));?>
			<?php echo Form::input('add3', $emcall->add3, array('class' => 'form-control', 'size' => 50, 'maxlength' => '50', 'placeholder' => '以降の住所'));?>

				<p></p>

				<div class="text-center">
					<button type="submit" class="btn btn-primary btn-sm" name="save-btn">
						<i class="glyphicon glyphicon-pencil icon-white"></i>
						保存
					</button>
				</div>

			<?php echo Form::close();?>
		</div>
	</div>
	<?php
		$i++;
	} ?>


<?php if($i == 0 && !isset($action)) { ?>
	<div class="panel panel-warning">
		<?php if (Session::get_flash('error-0')): ?>
			<div class="panel-heading text-right">
				<div style="text-align:left"><?php echo Session::get_flash('error-0'); ?></div>
			</div>
		<?php endif; ?>

		<div class="panel-body">
			<?php echo Form::open(array('class' => 'form-inline emcall_form', 'action' => \Fuel\Core\Uri::base() . 'job/emcall?person_id=' . $person_id));?>
			<input type="hidden" name="panel_index" value="0">
			<input type="hidden" name="person_id" value="<?php echo $person_id;?>">
			<div class="input-group">
				<div class="input-group-addon">続柄</div>
				<?php echo Form::select('relationship', '', Constants::$relationship, array('class' => 'form-control')); ?>
			</div>
			<span class="text-info">※必須</span>
			<label id="form_relationship-error" class="error" for="form_relationship"></label>
			<div class="input-group">
				<div class="input-group-addon">氏名</div>
				<?php echo Form::input('name', '', array('class' => 'form-control', 'size' => 20, 'maxlength' => '20'));?>
			</div>
			<span class="text-info">※必須</span>
			<label id="form_name-error" class="error" for="form_name"></label>
			<div class="input-group">
				<div class="input-group-addon">氏名かな</div>
				<?php echo Form::input('name_kana','', array('class' => 'form-control', 'size' => 20, 'maxlength' => '20'));?>
			</div>
			<span class="text-info">※必須</span>
			<label id="form_name_kana-error" class="error" for="form_name_kana"></label>
			<p></p>
			<div class="input-group">
				<div class="input-group-addon">電話番号</div>
				<?php echo Form::input('tel_1', '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
			</div>
			-
			<?php echo Form::input('tel_2', '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
			-
			<?php echo Form::input('tel_3', '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
			<label id="tel-error" class="error" for="tel"></label>
			<div class="input-group">
				<div class="input-group-addon">〒</div>
				<?php echo Form::input('zipcode_first',  '', array('class' => 'form-control', 'size' => 3, 'maxlength' => '3'));?>
			</div>
			-
			<?php echo Form::input('zipcode_last', '', array('class' => 'form-control', 'size' => 3, 'maxlength' => '4'));?>
			<label id="zipcode-error" class="error" for="zipcode"></label>
			<div class="input-group">
				<div class="input-group-addon">都道府県</div>
				<?php echo Form::select('add1', '', Constants::get_create_address(), array('class' => 'form-control')); ?>
			</div>
			<p></p>
			<?php echo Form::input('add2', '', array('class' => 'form-control', 'size' => 20, 'maxlength' => '20', 'placeholder' => '市区町村'));?>
			<?php echo Form::input('add3', '', array('class' => 'form-control', 'size' => 50, 'maxlength' => '50', 'placeholder' => '以降の住所'));?>

			<p></p>

			<div class="text-center">
				<button type="submit" class="btn btn-primary btn-sm" name="save-btn">
					<i class="glyphicon glyphicon-pencil icon-white"></i>
					保存
				</button>
			</div>

			<?php echo Form::close();?>
		</div>
	</div>

<?php } ?>

	<?php if(isset($action)) { ?>
		<div class="panel panel-warning">
			<?php if (Session::get_flash('error-'.Input::post('panel_index'))): ?>
				<div class="panel-heading text-right">
					<div style="text-align:left"><?php echo Session::get_flash('error-'.Input::post('panel_index')); ?></div>
				</div>
			<?php endif; ?>

			<div class="panel-body">
				<?php echo Form::open(array('class' => 'form-inline emcall_form', 'action' => \Fuel\Core\Uri::base() . 'job/emcall?person_id=' . $person_id));?>
				<input type="hidden" name="panel_index" value="<?php echo Input::post('panel_index');?>">
				<input type="hidden" name="person_id" value="<?php echo $person_id;?>">
				<div class="input-group">
					<div class="input-group-addon">続柄</div>
					<?php echo Form::select('relationship', \Fuel\Core\Input::post('relationship'), Constants::$relationship, array('class' => 'form-control')); ?>
				</div>
				<span class="text-info">※必須</span>
				<label id="form_relationship-error" class="error" for="form_relationship"></label>
				<div class="input-group">
					<div class="input-group-addon">氏名</div>
					<?php echo Form::input('name', Input::post('name'), array('class' => 'form-control', 'size' => 20, 'maxlength' => '20'));?>
				</div>
				<span class="text-info">※必須</span>
				<label id="form_name-error" class="error" for="form_name"></label>
				<div class="input-group">
					<div class="input-group-addon">氏名かな</div>
					<?php echo Form::input('name_kana',Input::post('name_kana'), array('class' => 'form-control', 'size' => 20, 'maxlength' => '20'));?>
				</div>
				<span class="text-info">※必須</span>
				<label id="form_name_kana-error" class="error" for="form_name_kana"></label>
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">電話番号</div>
					<?php echo Form::input('tel_1', Input::post('tel_1'), array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
				</div>
				-
				<?php echo Form::input('tel_2', Input::post('tel_2'), array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
				-
				<?php echo Form::input('tel_3', Input::post('tel_3'), array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
				<label id="tel-error" class="error" for="tel"></label>
				<div class="input-group">
					<div class="input-group-addon">〒</div>
					<?php echo Form::input('zipcode_first',  Input::post('zipcode_first'), array('class' => 'form-control', 'size' => 3, 'maxlength' => '3'));?>
				</div>
				-
				<?php echo Form::input('zipcode_last', Input::post('zipcode_last'), array('class' => 'form-control', 'size' => 3, 'maxlength' => '4'));?>
				<label id="zipcode-error" class="error" for="zipcode"></label>
				<div class="input-group">
					<div class="input-group-addon">都道府県</div>
					<?php echo Form::select('add1', Input::post('add1'), Constants::get_create_address(), array('class' => 'form-control')); ?>
				</div>
				<p></p>
				<?php echo Form::input('add2', Input::post('add2'), array('class' => 'form-control', 'size' => 20, 'maxlength' => '20', 'placeholder' => '市区町村'));?>
				<?php echo Form::input('add3', Input::post('add3'), array('class' => 'form-control', 'size' => 50, 'maxlength' => '50', 'placeholder' => '以降の住所'));?>

				<p></p>

				<div class="text-center">
					<button type="submit" class="btn btn-primary btn-sm" name="save-btn">
						<i class="glyphicon glyphicon-pencil icon-white"></i>
						保存
					</button>
				</div>

				<?php echo Form::close();?>
			</div>
		</div>

	<?php } ?>
</div>

<div class="hide" id="panel_hidden">
	<div class="panel panel-warning">
		<div class="panel-body">
			<?php echo Form::open(array('class' => 'form-inline emcall_form', 'action' => \Fuel\Core\Uri::base() . 'job/emcall?person_id=' . $person_id));?>
			<input type="hidden" name="panel_index" value="">
			<input type="hidden" name="person_id" value="<?php echo $person_id;?>">
			<div class="input-group">
				<div class="input-group-addon">続柄</div>
				<?php echo Form::select('relationship', '', Constants::$relationship, array('class' => 'form-control')); ?>
			</div>
			<span class="text-info">※必須</span>
			<label id="form_relationship-error" class="error" for="form_relationship"></label>
			<div class="input-group">
				<div class="input-group-addon">氏名</div>
				<?php echo Form::input('name', '', array('class' => 'form-control', 'size' => 20, 'maxlength' => '20'));?>
			</div>
			<span class="text-info">※必須</span>
			<label id="form_name-error" class="error" for="form_name"></label>
			<div class="input-group">
				<div class="input-group-addon">氏名かな</div>
				<?php echo Form::input('name_kana','', array('class' => 'form-control', 'size' => 20, 'maxlength' => '20'));?>
			</div>
			<span class="text-info">※必須</span>
			<label id="form_name_kana-error" class="error" for="form_name_kana"></label>
			<p></p>
			<div class="input-group">
				<div class="input-group-addon">電話番号</div>
				<?php echo Form::input('tel_1', '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
			</div>
			-
			<?php echo Form::input('tel_2', '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
			-
			<?php echo Form::input('tel_3', '', array('class' => 'form-control', 'size' => 4, 'maxlength' => '4'));?>
			<label id="tel-error" class="error" for="tel"></label>
			<div class="input-group">
				<div class="input-group-addon">〒</div>
				<?php echo Form::input('zipcode_first',  '', array('class' => 'form-control', 'size' => 3, 'maxlength' => '3'));?>
			</div>
			-
			<?php echo Form::input('zipcode_last', '', array('class' => 'form-control', 'size' => 3, 'maxlength' => '4'));?>
			<label id="zipcode-error" class="error" for="zipcode"></label>
			<div class="input-group">
				<div class="input-group-addon">都道府県</div>
				<?php echo Form::select('add1', '', Constants::get_create_address(), array('class' => 'form-control')); ?>
			</div>
			<p></p>
			<?php echo Form::input('add2', '', array('class' => 'form-control', 'size' => 20, 'maxlength' => '20', 'placeholder' => '市区町村'));?>
			<?php echo Form::input('add3', '', array('class' => 'form-control', 'size' => 50, 'maxlength' => '50', 'placeholder' => '以降の住所'));?>

			<p></p>

			<div class="text-center">
				<button type="submit" class="btn btn-primary btn-sm" name="save-btn">
					<i class="glyphicon glyphicon-pencil icon-white"></i>
					保存
				</button>
			</div>

			<?php echo Form::close();?>
		</div>
	</div>
</div>