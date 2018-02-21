<?php echo \Fuel\Core\Asset::js('validate/employment.js')?>

<div class="container">
	<h3>
		採用管理
		<div class="text-right">
			<a class="btn btn-warning btn-sm" href="<?php if(\Fuel\Core\Cookie::get('person_url')) echo \Fuel\Core\Cookie::get('person_url'); else echo Uri::base(true).'job/persons'?>"/>
					<i class="glyphicon glyphicon-arrow-left icon-white"></i>
					戻る
			</a>
		</div>
	</h3>

	<p class="text-center">
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/person?person_id=<?php echo $person_id; ?>">応募者</a>
		|
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/employment?person_id=<?php echo $person_id; ?>">採用管理</a>
        <!--
		|
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/personfile?person_id=<?php echo $person_id; ?>">本人確認書類</a>
		|
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/interviewusami?person_id=<?php echo $person_id; ?>">面接票</a>
		|
		<a href="<?php echo \Fuel\Core\Uri::base()?>job/emcall?person_id=<?php echo $person_id; ?>">緊急連絡先</a>
		-->
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

	<?php if(Session::get_flash('success')){?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<?php echo Session::get_flash('success');?>
	</div>
	<?php } ?>
	<?php if(Session::get_flash('lock')){?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<?php echo Session::get_flash('lock');?>
		</div>
	<?php } ?>
	<input type="hidden" value="<?php echo $person_id;?>" id="person_id">
	<form class="form-inline" method="POST" action="" id="employment">

		<table class="table table-striped">
			<tr>
				<th class="text-right">連絡結果</th>
				<td>
					<?php echo Form::select('contact_result', Input::post('contact_result', isset($post) ? $post->contact_result : isset($contact_result)? $contact_result:''), \Constants::$_contact_result, array('class'=>'form-control', isset($disabled) ? $disabled : '')); ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">面接日</th>
				<td>
					<?php echo Form::input('review_date', Input::post('review_date', isset($post) ? $post->review_date :isset($review_date)? $review_date:''), array('class' => 'form-control dateform', 'size' => 12, isset($disabled) ? $disabled : '')); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">面接結果</th>
				<td>
					<?php echo Form::select('review_result', Input::post('review_result', isset($post) ? $post->review_result :isset($review_result)? $review_result:''), \Constants::$_review_result, array('class'=>'form-control', isset($disabled) ? $disabled : '')); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">採否結果</th>
				<td>
					<?php echo Form::select('adoption_result', Input::post('adoption_result', isset($post) ? $post->adoption_result :isset($adoption_result)? $adoption_result:''), \Constants::$_adoption_result, array('class'=>'form-control', isset($disabled) ? $disabled : '')); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">登録有効期限</th>
				<td>
					<?php echo Form::input('registration_expiration', Input::post('registration_expiration', (isset($registration_expiration) ? $registration_expiration : (isset($reg_expiration) ? $reg_expiration : ''))), array('class' => 'form-control dateform', 'size' => '12', isset($disabled) ? $disabled : '')); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">登録ランク</th>
				<td>
					<?php echo Form::select('rank', Input::post('rank', isset($post) ? $post->rank : isset($rank)? $rank:''), \Constants::$_rank, array('class'=>'form-control')); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">登録更新日</th>
				<td>
					<?php echo Form::input('register_date', Input::post('register_date', isset($post) ? $post->register_date :isset($register_date)? $register_date:''), array('class' => 'form-control dateform', 'size' => 12)); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">契約締結日</th>
				<td>
					<?php echo Form::input('contract_date', Input::post('contract_date', isset($post) ? $post->contract_date :isset($contract_date)? $contract_date:''), array('class' => 'form-control dateform', 'size' => 12)); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">契約結果</th>
				<td>
					<?php echo Form::select('contract_result', Input::post('contract_result', isset($post) ? $post->contract_result :isset($contract_result)? $contract_result:''), \Constants::$_contract_result, array('class'=>'form-control')); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">入社日</th>
				<td>
					<?php echo Form::input('hire_date', Input::post('hire_date', isset($post) ? $post->hire_date :isset($hire_date)? $hire_date:''), array('class' => 'form-control dateform', 'size' => 12)); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">勤務確認</th>
				<td>
					<?php echo Form::select('work_confirmation', Input::post('work_confirmation', isset($post) ? $post->work_confirmation : isset($work_confirmation)? $work_confirmation:''), \Constants::$_work_confirmation, array('class'=>'form-control')); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">社員コード</th>
				<td>
					<?php echo Form::input('employee_code', Input::post('employee_code', isset($post) ? $post->employee_code : isset($employee_code)? $employee_code:''), array('class' => 'form-control', 'size' => 12, 'maxlength' => 8)); ?>
<!--					<button type="button" class="btn btn-sm btn-success" name="get-code-btn" <?php echo isset($disabled) ? $disabled : ''?>>
						配属支店の最新社員コードをセット
					</button>-->
                    <label id="form_employee_code-error" class="error" for="form_employee_code"></label>
				</td>
			</tr>

			<tr>
				<th class="text-right">社員コード登録日</th>
				<td>
					<?php echo Form::input('code_registration_date', Input::post('code_registration_date', isset($post) ? $post->code_registration_date : isset($code_registration_date)? $code_registration_date:''), array('class' => 'form-control dateform', 'size' => 12)); ?>
				</td>
			</tr>
			<tr class="hide">
				<th class="text-right">OBIC7インポート</th>
				<td>
					<label class="checkbox-inline">
						<?php
						echo Form::checkbox('obic7_flag', 1, Input::post('obic7_flag', isset($post) ? $post->obic7_flag : isset($obic7_flag) ? $obic7_flag : '') == 1 ? true : false);
						?>
						可能
					</label>
					<label for="form_obic7_flag" class="error" id="form_obic7_flag-error"></label>
				</td>
			</tr>
		</table>

		<div class="text-center">
			<button type="submit" class="btn btn-primary btn-sm">
				<i class="glyphicon glyphicon-pencil icon-white"></i>
				保存
			</button>
		</div>

	</form>

</div>

<script>
	$(function()
	{
		$('button[name=get-code-btn]').on('click', function()
		{
			$.get(
				'<?php echo \Fuel\Core\Uri::base()?>ajax/common/employee_code',
				{ person_id : <?php echo $person_id ?> }
			).done(function(response)
			{
				var json = $.parseJSON(response);
				if (json.code === null)
				{
					alert(json.error);
					return false
				}

				$('input[name=employee_code]').val(json.code);
			});
		});

        var lock = function() {
            $('input').prop('readonly', true);
            $('input:checkbox').on('change', function() {
                $(this).prop('checked', !$(this).prop('checked'));
            });
            $('input.dateform').datepicker('destroy');
            $('select').disableSelection();
        };

        var unLock = function() {
            $('input').prop('readonly', false);
            $('input:checkbox').off('change');
            $('input.dateform').datepicker();
            $('select').enableSelection();
        };

        $('select[name=contact_result]').on('change', function() {
            if ($(this).val() == '2') {
                $('select[name=adoption_result]').val('2');
                lock();
                $(this).enableSelection();
            } else {
                unLock();
            }
        }).trigger('change');

        $('select[name=review_result]').on('change', function() {
            if ($(this).val() > '1') {
                $('select[name=adoption_result]').val('2');
                lock();
                $(this).enableSelection();
            } else {
                unLock();
            }
        }).trigger('change');

        $('select[name=adoption_result]').on('change', function() {
            if ($(this).val() == '2') {
                lock();
                $(this).enableSelection();
            } else {
                unLock();
            }
        }).trigger('change');
	});
</script>
