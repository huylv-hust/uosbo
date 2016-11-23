<?php echo \Fuel\Core\Asset::js('validate/person.js') ?>
<div class="container">
	<h3>
		応募者リスト
		<button type="button" class="btn btn-info btn-sm" name="add-btn"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
	</h3>
	<?php
	if (Session::get_flash('error'))
	{
		?>
		<div role="alert" class="alert alert-danger alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button">
				<span aria-hidden="true">×</span>
			</button>
			<?php echo Session::get_flash('error'); ?>
		</div>
		<?php
	}

	if (Session::get_flash('success'))
	{
		?>
		<div role="alert" class="alert alert-success alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button">
				<span aria-hidden="true">×</span>
			</button>
			<?php echo Session::get_flash('success'); ?>
		</div>
		<?php
	}
	?>

	<form class="form-inline" id="list-persons" action="" method="get">
		<input type="hidden" value="" name="person_id" id="form-person_id" />
		<input type="hidden" value="" name="person_status" id="form-person_status" />
		<input type="hidden" value="" name="detail_status" />
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">
						<label class="control-label">応募日</label>
					</div>
					<div class="col-md-10">
						<?php echo Form::input('from_date', Input::get('from_date', isset($get) ? $get->from_date : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
						～
						<?php echo Form::input('to_date', Input::get('to_date', isset($get) ? $get->to_date : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label class="control-label">都道府県</label>
					</div>
					<div class="col-md-4">
						<?php echo Form::select('addr1', Input::get('addr1'), Constants::$address_1, array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-2">
						<label class="control-label">市区町村など</label>
					</div>
					<div class="col-md-4">
						<?php echo Form::input('addr2', Input::get('addr2'), array('class' => 'form-control', 'size' => 20, 'placeholder' => "市区町村 or 以降の住所")); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label class="control-label">メールアドレス</label>
					</div>
					<div class="col-md-4">
						<?php echo Form::input('email', Input::get('email', isset($get) ? $get->email : ''), array('class' => 'form-control', 'size' => 20)); ?>
					</div>
					<div class="col-md-2">
						<label class="control-label">氏名</label>
					</div>
					<div class="col-md-4">
						<?php echo Form::input('name', Input::get('name', isset($get) ? $get->name : ''), array('class' => 'form-control', 'size' => 20, 'placeholder' => "漢字 or かな")); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label class="control-label">電話番号</label>
					</div>
					<div class="col-md-4">
						<?php echo Form::input('phone', Input::get('phone', isset($get) ? $get->phone : ''), array('class' => 'form-control', 'size' => 20)); ?>
					</div>
					<div class="col-md-2">
						<label class="control-label">媒体名</label>
					</div>
					<div class="col-md-4">
						<?php echo Form::input('media_name', Input::get('media_name', isset($get) ? $get->media_name : ''), array('class' => 'form-control', 'size' => 20)); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label class="control-label">取引先(受注先)</label>
					</div>
					<div class="col-md-10">
						<select class="form-control" name="group_id">
							<option value="">全て</option>
							<?php foreach ($groups as $group_id => $name)
							{ ?>
								<option value="<?php echo $group_id ?>"<?php echo Fuel\Core\Input::get('group_id') == $group_id ? ' selected' : '' ?>><?php echo htmlspecialchars($name) ?>
<?php } ?>
						</select>
						-
						<select class="form-control" name="partner_code">
							<option value="">全て</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label class="control-label">SS</label>
					</div>
					<div class="col-md-10">
						<select class="form-control" name="ss_id">
							<option value="">全て</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label class="control-label">登録部門</label>
					</div>
					<div class="col-md-10">
						<div class="input-group">
							<div class="input-group-addon">部門</div>
<?php echo Form::select('department', Input::get('department', isset($get) ? $get->department : ''), \Constants::get_search_department(), array('class' => 'form-control')); ?>
						</div>
						<div class="input-group">
							<div class="input-group-addon">担当者</div>
<?php echo Form::select('user_id', Input::get('user_id', isset($get) ? $get->user_id : ''), array('' => '全て'), array('class' => 'form-control')); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label class="control-label">売上形態</label>
					</div>
					<div class="col-md-4">
<?php echo Form::select('sale_type', Input::get('sale_type', isset($get) ? $get->sale_type : ''), Constants::$sale_type, array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-2">
						<label class="control-label">状態</label>
					</div>
					<div class="col-md-4">
						<label class="checkbox-inline">
							<?php
							if (\Fuel\Core\Input::get('status') == '0')
								$checked = true;
							else
								$checked = false;
							echo \Fuel\Core\Form::checkbox('status', 0, $checked);
							?>
							承認待ち</label>
					</div>
				</div>

				<div class="row text-center">
					<a href="#" id="open-detail-filter">[+詳細]</a>
				</div>

				<div id="detail-filter">
					<div class="row">
						<div class="col-md-2">
							<label class="control-label">面接結果</label>
						</div>
						<div class="col-md-4">
							<label class="checkbox-inline"><input type="checkbox" name="review_result[0]" value="0" <?php if (isset($_GET['review_result'][0]))
							{
								echo 'checked';
							} ?>>済</label>
							<label class="checkbox-inline"><input type="checkbox" name="review_result[1]" value="1" <?php if (isset($_GET['review_result'][1]))
						{
							echo 'checked';
						} ?>>未済(済以外)</label>
						</div>
						<div class="col-md-2">
							<label class="control-label">登録ランク</label>
						</div>
							<?php
							$rank = \Constants::$_rank;
							$contract_result = \Constants::$_contract_result;
							$adoption_result = \Constants::$_adoption_result;
							?>
						<div class="col-md-4">
<?php foreach ($rank as $key => $value)
{ ?>
								<?php if ($key != 0)
								{ ?>
									<label class="checkbox-inline"><input type="checkbox" name="rank[<?php echo $key ?>]" value="<?php echo $key ?>" <?php if (isset($_GET['rank'][$key]))
							{
								echo 'checked';
							} ?>><?php echo $value ?></label>
	<?php } ?>
<?php } ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<label class="control-label">契約結果</label>
						</div>
						<div class="col-md-4">
<?php foreach ($contract_result as $key => $value)
{ ?>
								<label class="checkbox-inline"><input type="checkbox" name="contract_result[<?php echo $key ?>]" value="<?php echo $key ?>" <?php if (isset($_GET['contract_result'][$key]))
	{
		echo 'checked';
	} ?>><?php echo $value ?></label>
<?php } ?>
						</div>
						<div class="col-md-2">
							<label class="control-label">採用結果</label>
						</div>
						<div class="col-md-4">
							<?php foreach ($adoption_result as $key => $value)
							{ ?>
								<label class="checkbox-inline"><input type="checkbox" name="adoption_result[<?php echo $key ?>]" value="<?php echo $key ?>" <?php if (isset($_GET['adoption_result'][$key]))
							{
								echo 'checked';
							} ?>><?php echo $value ?></label>
<?php } ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<label class="control-label">性別</label>
						</div>
						<div class="col-md-4">
							<label class="checkbox-inline"><input type="checkbox" name="gender[0]" value="0" <?php if (isset($_GET['gender'][0]))
{
	echo 'checked';
} ?>>男性</label>
							<label class="checkbox-inline"><input type="checkbox" name="gender[1]" value="1" <?php if (isset($_GET['gender'][1]))
{
	echo 'checked';
} ?>>女性</label>
						</div>
						<div class="col-md-2">
							<label class="control-label">現在年齢</label>
						</div>
						<div class="col-md-4">
	<?php echo Form::input('age_from', Input::get('age_from', isset($get) ? $get->age_from : ''), array('class' => 'form-control', 'size' => 5)); ?>
							～
<?php echo Form::input('age_to', Input::get('age_to', isset($get) ? $get->age_to : ''), array('class' => 'form-control', 'size' => 5)); ?>
						</div>
					</div>

		<?php foreach (\Constants::$person_licenses as $key => $value)
		{ ?>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">保有資格<?php echo htmlspecialchars($key) ?></label>
							</div>
							<div class="col-md-10">
	<?php foreach ($value as $key1 => $value1)
	{ ?>
									<label class="checkbox-inline"><input type="checkbox" name="license<?php echo $key; ?>[<?php echo $key1; ?>]" value="<?php echo $key1; ?>" <?php if (isset($_GET['license' . $key][$key1]))
		{
			echo 'checked';
		} ?>><?php echo $value1 ?></label>
	<?php } ?>
							</div>
						</div>

<?php } ?>


				</div>
				<div class="row text-center">
					<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
					<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
					<a class="btn btn-warning btn-sm" id="btn_down_csv" href="<?php echo \Uri::base() . 'job/persons/index/' . (\Uri::segment(4) ? \Uri::segment(4) : 1) . '?' . http_build_query(\Input::get()) . '&export=true' ?>"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</a>
				</div>
			</div>
		</div>

		<?php if (count($listPerson) == 0)
		{ ?>
		<div role="alert" class="alert alert-danger alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button">
				<span aria-hidden="true">×</span>
			</button>
			<?php echo "該当するデータがありません"; ?>
		</div>
		<?php } ?>
		<?php if (count($listPerson) > 0)
		{ ?>
		<div class="row form-inline">
			<div class="col-md-4">
				<?php echo Pagination::instance('mypagination'); ?>
			</div>
			<div style="margin: 20px 0; padding-left: 15px;">
				<select class="form-control" id="limit" name="limit">
					<option value="10" <?php if(Fuel\Core\Input::get('limit') == '10') echo 'selected'?>>10件</option>
					<option value="50" <?php if(Fuel\Core\Input::get('limit') == '50') echo 'selected'?>>50件</option>
					<option value="100" <?php if(Fuel\Core\Input::get('limit') == '100') echo 'selected'?>>100件</option>
				</select>
			</div>
		</div>

		<table class="table table-bordered table-striped">
			<tr>
				<th class="text-center">応募日時</th>
				<th class="text-center">応募者氏名</th>
				<th class="text-center">メールアドレス</th>
				<th class="text-center">電話番号</th>
				<th class="text-center">取引先グループ</th>
				<th class="text-center">取引先(支店)</th>
				<th class="text-center">対象SS</th>
				<th class="text-center">担当者氏名</th>
				<th class="text-center">求人情報</th>
				<th class="text-center">状態</th>
				<th class="text-center">管理</th>
			</tr>
	<?php foreach ($listPerson as $key => $value)
	{ ?>
				<td><?php echo $value['application_date'] ?></td>
				<td><a href="<?php echo Uri::base() ?>job/person?person_id=<?php echo $value['person_id']; ?>"><?php echo $value['p_name'] ?></a></td>
		<?php if (!empty($value['mail_addr1']) && !empty($value['mail_addr2']))
		{ ?>
					<td><?php echo $value['mail_addr1'] . ' / ' . $value['mail_addr2'] ?></td>
							<?php }
							elseif (!empty($value['mail_addr1']))
							{ ?>
					<td><?php echo $value['mail_addr1'] ?></td>
							<?php }
							else
							{ ?>
					<td><?php echo $value['mail_addr2'] ?></td>
							<?php } ?>
							<?php if (!empty($value['mobile']) && !empty($value['tel']))
							{ ?>
					<td><?php echo $value['tel'] . ' / ' . $value['mobile'] ?></td>
		<?php }
		elseif (!empty($value['tel']))
		{ ?>
					<td><?php echo $value['tel'] ?></td>
		<?php }
		else
		{ ?>
					<td><?php echo $value['mobile'] ?></td>
				<?php } ?>
				<td><?php echo $value['g_name'] ?></td>
				<td><?php echo $value['branch_name'] ?></td>
				<td><?php echo $value['ss_name'] ?></td>
				<td><?php echo $value['name'] ?></td>
				<td>
		<?php if ($value['job_id'])
		{ ?>
						<a href="<?php echo Uri::base(true) ?>job?job_id=<?php echo $value['job_id'] ?>"><?php echo $value['job_ss_name'] ?> <?php echo $value['job_sale_name'] ?></a>
		<?php } ?>
				</td>
				<td>
		<?php
		if (isset($value['status']) && $value['status'] == 0)
		{
			echo '<span class="label label-danger">承認待ち</span>';
		}
		else
		{
			echo '<span class="label label-success">承認済み</span>';
		}
		?>
				</td>
				<td>
					<div class="btn-group">
						<a style="cursor: pointer" data-toggle="dropdown" class="btn dropdown-toggle btn-sm btn-success">
							処理
							<span class="caret"></span>
						</a>
						<ul name="add-pulldown" class="dropdown-menu">
							<li><a href="<?php echo Uri::base(true) ?>job/person?person_id=<?php echo $value['person_id']; ?>" name="edit-btn"><i class="glyphicon glyphicon-pencil"></i> 編集</a></li>
		<?php
		$login_info = \Fuel\Core\Session::get('login_info');
		if ($login_info['division_type'] != 3)
		{
			if (isset($value['status']) && $value['status'] == 0)
			{
				echo '<li><a class="person-agree" href="#" value="' . $value['person_id'] . '"><i class="glyphicon glyphicon-thumbs-up"></i> 承認</a></li>';
			}
			else
			{
				echo '<li class="disabled"><a><i class="glyphicon glyphicon-thumbs-up"></i> 承認</a></li>';
			}
		}
		?>
							<li><a href="<?php echo Uri::base(true) ?>job/employment?person_id=<?php echo $value['person_id']; ?>" name="employment-btn"><i class="glyphicon glyphicon-user"></i> 採用管理</a></li>
							<li><a href="<?php echo Uri::base(true) ?>job/personfile?person_id=<?php echo $value['person_id']; ?>" name="file-btn"><i class="glyphicon glyphicon-file"></i> 本人確認書類</a></li>
							<li><a name="interviewusami-btn" href="<?php echo Uri::base(true) ?>job/interviewusami?person_id=<?php echo $value['person_id']; ?>"><i class="glyphicon glyphicon-file"></i> 面接票</a></li>
							<li><a href="<?php echo Uri::base(true) ?>job/emcall?person_id=<?php echo $value['person_id']; ?>"><i class="glyphicon glyphicon-file"></i> 緊急連絡先</a></li>
						</ul>
					</div>
				</td>
				</tr>
	<?php } ?>
		</table>
<?php } ?>
	</form>

</div>

<script>
	$(function (e)
	{
		var department_id = $(this).val();
		get_list_user(department_id);
		$('.dateform').datepicker();

		$('[name=add-btn]').on('click', function ()
		{
			location.href = '<?php echo Uri::base(true) ?>job/person';
		});
		$('#detail-filter').hide();

		$('#open-detail-filter').click(function ()
		{
			if ($('#detail-filter:visible').size() > 0)
			{
				$(this).text('[+詳細]');
			} else {
				$(this).text('[-閉じる]');
			}

			$('#detail-filter').toggle(500);
			return false;
		});
		<?php if (\Input::get('detail_status') == 'open') { ?>
			$('#open-detail-filter').text('[-閉じる]');
			$('#detail-filter').show();
		<?php } ?>

		$('#list-persons').on('submit', function()
		{
			if (
				$('#detail-filter input:checkbox:checked').size() > 0
			) {
				$('input[name=detail_status]').val('open');
			}
		});

		$('#form_department').change(function () {
			var department_id = $(this).val();
			get_list_user(department_id);
		});
<?php if (\Input::get('department'))
{ ?>
			var department_id = '<?php echo \Input::get('department'); ?>';
			get_list_user(department_id);
<?php } ?>


		$('#btn_down_csv').off('click').on('click', function () {
			if (confirm('ダウンロード開始してよろしいですか？\n(実行ログが記録されます)') == false) {
				return false;
			}
		});
	});
	//get list user by department
	function get_list_user(department_id) {
		var strString = '<option value="">全て</option>';
		if (department_id == '' || department_id == 0) {
			$('select[name=user_id]').html(strString);
			return false;
		}
		$.post(baseUrl + 'job/order/get_users', {
			department_id: department_id
		}, function (result) {
			var data = jQuery.parseJSON(result);
			for (var i = 0; i < data['list_user'].length; i++) {
				strString += '<option value=' + data['list_user'][i].user_id + '>' + data['list_user'][i].name + '</option>';
			}
			$('select#form_user_id').html(strString);
<?php if (\Input::get('user_id'))
{ ?>
				$('select#form_user_id').val('<?php echo \Input::get('user_id'); ?>');
<?php } ?>
		});
	}

	$('select[name=group_id]').on('change', function ()
	{
		$.getJSON(
				'<?php echo Fuel\Core\Uri::base() ?>ajax/common/get_partners',
				{
					type: '1', 'group_id': $(this).val(
				)}
		).done(function (response)
		{
			$("select[name=partner_code] option[value!='']").remove();
			$.each(response, function ()
			{
				var opt = $('<option></option>')
						.attr('value', this.partner_code)
						.text(this.branch_name)
						;

				if (this.partner_code == '<?php echo \Fuel\Core\Input::get('partner_code') ?>')
				{
					opt.prop('selected', true);
				}

				$("select[name=partner_code]").append(opt);
			});
			$("select[name=partner_code]").trigger('change');
		});
	}).trigger('change');

	$('select[name=partner_code]').on('change', function ()
	{
		$.getJSON(
				'<?php echo Fuel\Core\Uri::base() ?>ajax/common/get_ss',
				{
					'group_id': $('select[name=group_id]').val(), 'partner_code': $(this).val(
				)}
		).done(function (response)
		{
			$("select[name=ss_id] option[value!='']").remove();
			$.each(response, function ()
			{
				var opt = $('<option></option>')
						.attr('value', this.ss_id)
						.text(this.ss_name)
						;

				if (this.ss_id == '<?php echo \Fuel\Core\Input::get('ss_id') ?>')
				{
					opt.prop('selected', true);
				}

				$("select[name=ss_id]").append(opt);
			});
		});
	});
	$("#limit").on('change',function(){
		$("#list-persons").submit();
	});
</script>
