<?php echo \Fuel\Core\Asset::js('validate/ss.js')?>
<h3>
	<?php echo $ss_name?>の売上形態
	<button class="btn btn-success btn-sm" type="button" id="sssale_add_btn">
		<i class="glyphicon glyphicon-plus icon-white"></i>
		入力欄追加
	</button>
	<span style="float:right">
		<a href="<?php echo (\Fuel\Core\Session::get('sslist_url')) ?  \Fuel\Core\Session::get('sslist_url') :  \Fuel\Core\Uri::base().'master/sslist';?>" class="btn btn-warning btn-sm right">
			<i class="glyphicon glyphicon-arrow-left icon-white"></i>
			戻る
		</a>
	</span>
</h3>
<p class="text-center">
	<a href="<?php echo \Fuel\Core\Uri::base().'master/ss?ss_id='.$ss_id ?>">SS基本情報</a>
	|
	<a href="#">売上形態</a>
</p>
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
		foreach ($sssales as $k => $sssale)
		{
	?>
		<div class="panel panel-warning">
			<div class="panel-heading text-right">
				<?php if (Session::get_flash('error-'.$k)): ?>
					<span style="float:left"><?php echo Session::get_flash('error-'.$k);?></span>
				<?php endif; ?>
				<form action="<?php echo \Fuel\Core\Uri::base();?>master/sssale/delete" method="POST">
					<input type="hidden" name="panel_index" value="<?php echo $k;?>">
					<input type="hidden" name="sssale_id" value="<?php echo $sssale->sssale_id;?>">
					<button name="delete-btn" class="btn btn-danger btn-sm sssale_data_delete_btn" type="button">
						<i class="glyphicon glyphicon-trash icon-white"></i>
						削除
					</button>
				</form>
			</div>
			<div class="panel-body">
				<?php echo Form::open(array('class' => 'form-inline sssale_form', 'action' => \Fuel\Core\Uri::base().'master/sssale?ss_id='.$ss_id.'&ss_name='.$ss_name));?>
				<input type="hidden" name="sssale_id" value="<?php echo $sssale->sssale_id;?>">
				<input type="hidden" name="panel_index" value="<?php echo $k;?>">
				<table class="table table-striped">
					<tbody>
					<tr>
						<th class="text-right">売上形態</th>
						<td>
							<?php echo Form::select('sale_type', $sssale->sale_type, $sale_type, array('class' => 'form-control')); ?>
							<?php echo Form::input('sale_name', $sssale->sale_name, array('class' => 'form-control', 'size' => 30, 'placeholder' => '形態管理名称'));?>
						</td>
					</tr>
					<tr>
						<th class="text-right">時間フリー</th>
						<td>
							<div class="input-group">
								<div style="width:80px" class="input-group-addon">時給</div>
								<?php echo Form::input('free_hourly_wage', $sssale->free_hourly_wage, array('class' => 'form-control', 'size' => 5));?>
								<div class="input-group-addon">円</div>
							</div>
							<label id="form_free_hourly_wage-error" class="error" for="form_free_hourly_wage"></label>
							<div class="input-group">
								<div class="input-group-addon">募集属性</div>
								<?php echo Form::input('free_recruit_attr', $sssale->free_recruit_attr, array('class' => 'form-control', 'size' => 30));?>
							</div>
							<label id="form_free_recruit_attr-error" class="error" for="form_free_recruit_attr"></label>
							<p></p>
							<?php
							$free_start_time = explode(':', $sssale->free_start_time);
							$free_start_time_hour = isset($free_start_time[0]) ? $free_start_time[0] : '';
							$free_start_time_minute = isset($free_start_time[1]) ? $free_start_time[1] : '';
							$free_end_time = explode(':', $sssale->free_end_time);
							$free_end_time_hour = isset($free_end_time[0]) ? $free_end_time[0] : '';
							$free_end_time_minute = isset($free_end_time[1]) ? $free_end_time[1] : '';

							$constraint_start_time = explode(':', $sssale->constraint_start_time);
							$constraint_start_time_hour = isset($constraint_start_time[0]) ? $constraint_start_time[0] : '';
							$constraint_start_time_minute = isset($constraint_start_time[1]) ? $constraint_start_time[1] : '';
							$constraint_end_time = explode(':', $sssale->constraint_end_time);
							$constraint_end_time_hour = isset($constraint_end_time[0]) ? $constraint_end_time[0] : '';
							$constraint_end_time_minute = isset($constraint_end_time[1]) ? $constraint_end_time[1] : '';

							$minor_start_time = explode(':', $sssale->minor_start_time);
							$minor_start_time_hour = isset($minor_start_time[0]) ? $minor_start_time[0] : '';
							$minor_start_time_minute = isset($minor_start_time[1]) ? $minor_start_time[1] : '';
							$minor_end_time = explode(':', $sssale->minor_end_time);
							$minor_end_time_hour = isset($minor_end_time[0]) ? $minor_end_time[0] : '';
							$minor_end_time_minute = isset($minor_end_time[1]) ? $minor_end_time[1] : '';

							$night_start_time = explode(':', $sssale->night_start_time);
							$night_start_time_hour = isset($night_start_time[0]) ? $night_start_time[0] : '';
							$night_start_time_minute = isset($night_start_time[1]) ? $night_start_time[1] : '';
							$night_end_time = explode(':', $sssale->night_end_time);
							$night_end_time_hour = isset($night_end_time[0]) ? $night_end_time[0] : '';
							$night_end_time_minute = isset($night_end_time[1]) ? $night_end_time[1] : '';
							?>
							<div>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時間帯</div>
									<?php echo Form::select('free_start_time_hour', $free_start_time_hour, $hours, array('class' => 'form-control')); ?>
								</div>
								:
								<?php echo Form::select('free_start_time_minute', $free_start_time_minute, $minutes, array('class' => 'form-control')); ?>
								～
								<?php echo Form::select('free_end_time_hour', $free_end_time_hour, $hours, array('class' => 'form-control')); ?>
								:
								<?php echo Form::select('free_end_time_minute', $free_end_time_minute, $minutes, array('class' => 'form-control')); ?>
								<label id="free-error" class="error" for="free"></label>
								<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">時間制約</th>
						<td>
							<div class="input-group">
								<div style="width:80px" class="input-group-addon">時給</div>
								<?php echo Form::input('constraint_hourly_wage', $sssale->constraint_hourly_wage, array('class' => 'form-control', 'size' => 5));?>
								<div class="input-group-addon">円</div>
							</div>
							<label id="form_constraint_hourly_wage-error" class="error" for="form_constraint_hourly_wage"></label>
							<div class="input-group">
								<div class="input-group-addon">募集属性</div>
								<?php echo Form::input('constraint_recruit_attr', $sssale->constraint_recruit_attr, array('class' => 'form-control', 'size' => 30));?>
							</div>
							<label id="form_constraint_recruit_attr-error" class="error" for="form_constraint_recruit_attr"></label>
							<p></p>

							<div>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時間帯</div>
									<?php echo Form::select('constraint_start_time_hour', $constraint_start_time_hour, $hours, array('class' => 'form-control')); ?>
								</div>
								:
								<?php echo Form::select('constraint_start_time_minute', $constraint_start_time_minute, $minutes, array('class' => 'form-control')); ?>
								～
								<?php echo Form::select('constraint_end_time_hour', $constraint_end_time_hour, $hours, array('class' => 'form-control')); ?>
								:
								<?php echo Form::select('constraint_end_time_minute', $constraint_end_time_minute, $minutes, array('class' => 'form-control')); ?>
								<label id="constraint-error" class="error" for="constraint"></label>
								<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">年少者・高校生</th>
						<td>
							<div class="input-group">
								<div style="width:80px" class="input-group-addon">時給</div>
								<?php echo Form::input('minor_hourly_wage', $sssale->minor_hourly_wage, array('class' => 'form-control', 'size' => 5));?>
								<div class="input-group-addon">円</div>
							</div>
							<label id="form_minor_hourly_wage-error" class="error" for="form_minor_hourly_wage"></label>
							<div class="input-group">
								<div class="input-group-addon">募集属性</div>
								<?php echo Form::input('minor_recruit_attr', $sssale->minor_recruit_attr, array('class' => 'form-control', 'size' => 30));?>
							</div>
							<label id="form_minor_recruit_attr-error" class="error" for="form_minor_recruit_attr"></label>
							<p></p>

							<div>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時間帯</div>
									<?php echo Form::select('minor_start_time_hour', $minor_start_time_hour, $hours, array('class' => 'form-control')); ?>
								</div>
								:
								<?php echo Form::select('minor_start_time_minute', $minor_start_time_minute, $minutes, array('class' => 'form-control')); ?>
								～
								<?php echo Form::select('minor_end_time_hour', $minor_end_time_hour, $hours, array('class' => 'form-control')); ?>
								:
								<?php echo Form::select('minor_end_time_minute', $minor_end_time_minute, $minutes, array('class' => 'form-control')); ?>
								<label id="minor-error" class="error" for="minor"></label>
								<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">夜勤</th>
						<td>
							<div class="input-group">
								<div style="width:80px" class="input-group-addon">時給</div>
								<?php echo Form::input('night_hourly_wage', $sssale->night_hourly_wage, array('class' => 'form-control', 'size' => 5));?>
								<div class="input-group-addon">円</div>
							</div>
							<label id="form_night_hourly_wage-error" class="error" for="form_night_hourly_wage"></label>
							<div class="input-group">
								<div class="input-group-addon">募集属性</div>
								<?php echo Form::input('night_recruit_attr', $sssale->night_recruit_attr, array('class' => 'form-control', 'size' => 30));?>
							</div>
							<label id="form_night_recruit_attr-error" class="error" for="form_night_recruit_attr"></label>
							<p></p>

							<div>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時間帯</div>
									<?php echo Form::select('night_start_time_hour', $night_start_time_hour, $hours, array('class' => 'form-control')); ?>
								</div>
								:
								<?php echo Form::select('night_start_time_minute', $night_start_time_minute, $minutes, array('class' => 'form-control')); ?>
								～
								<?php echo Form::select('night_end_time_hour', $night_end_time_hour, $hours, array('class' => 'form-control')); ?>
								:
								<?php echo Form::select('night_end_time_minute', $night_end_time_minute, $minutes, array('class' => 'form-control')); ?>
								<label id="night-error" class="error" for="night"></label>
								<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">適用期間</th>
						<td>
							<input name="apply_start_date" type="text" class="form-control dateform"
							       value="<?php echo $sssale->apply_start_date;?>">
							～
							<input name="apply_end_date" type="text" class="form-control dateform"
							       value="<?php echo $sssale->apply_end_date;?>">
							<span class="text-info">※入力が無い場合は無制限、期間を過ぎると自動削除されます</span>
							<label id="apply_date-error" class="error" for="apply_date"></label>
						</td>
					</tr>
					</tbody>
				</table>

				<div class="text-center">
					<span class="text-info">※保存ボタンを押下しても未入力の場合は登録されません</span>
				</div>

				<div class="text-center">
					<button name="submit" class="btn btn-primary btn-sm" type="submit">
						<i class="glyphicon glyphicon-pencil icon-white"></i>
						保存
					</button>
				</div>
				<?php echo Form::close();?>
			</div>
		</div>
	<?php
			$i++;
		}
		if($i == 0 && ! isset($action)) {
			?>
			<div class="panel panel-warning">
				<?php if (Session::get_flash('error-0')): ?>
					<div class="panel-heading text-right">
						<div style="text-align:left"><?php echo Session::get_flash('error-0'); ?></div>
					</div>
				<?php endif; ?>
				<div class="panel-body">
					<?php echo Form::open(array('class' => 'form-inline sssale_form', 'action' => \Fuel\Core\Uri::base() . 'master/sssale?ss_id=' . $ss_id . '&ss_name=' . $ss_name));?>
					<input type="hidden" name="ss_id" value="<?php echo $ss_id;?>">
					<input type="hidden" name="panel_index" value="0">
					<table class="table table-striped">
						<tbody>
						<tr>
							<th class="text-right">売上形態</th>
							<td>
								<?php echo Form::select('sale_type', '', $sale_type, array('class' => 'form-control')); ?>
								<?php echo Form::input('sale_name', '', array('class' => 'form-control', 'size' => 30, 'placeholder' => '形態管理名称'));?>
							</td>
						</tr>
						<tr>
							<th class="text-right">時間フリー</th>
							<td>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時給</div>
									<?php echo Form::input('free_hourly_wage', '', array('class' => 'form-control', 'size' => 5));?>
									<div class="input-group-addon">円</div>
								</div>
								<label id="form_free_hourly_wage-error" class="error"
								       for="form_free_hourly_wage"></label>

								<div class="input-group">
									<div class="input-group-addon">募集属性</div>
									<?php echo Form::input('free_recruit_attr', '', array('class' => 'form-control', 'size' => 30));?>
								</div>
								<label id="form_free_recruit_attr-error" class="error"
								       for="form_free_recruit_attr"></label>

								<p></p>

								<div>
									<div class="input-group">
										<div style="width:80px" class="input-group-addon">時間帯</div>
										<?php echo Form::select('free_start_time_hour', '', $hours, array('class' => 'form-control')); ?>
									</div>
									:
									<?php echo Form::select('free_start_time_minute', '', $minutes, array('class' => 'form-control')); ?>
									～
									<?php echo Form::select('free_end_time_hour', '', $hours, array('class' => 'form-control')); ?>
									:
									<?php echo Form::select('free_end_time_minute', '', $minutes, array('class' => 'form-control')); ?>
									<label id="free-error" class="error" for="free"></label>
									<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-right">時間制約</th>
							<td>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時給</div>
									<?php echo Form::input('constraint_hourly_wage', '', array('class' => 'form-control', 'size' => 5));?>
									<div class="input-group-addon">円</div>
								</div>
								<label id="form_constraint_hourly_wage-error" class="error"
								       for="form_constraint_hourly_wage"></label>

								<div class="input-group">
									<div class="input-group-addon">募集属性</div>
									<?php echo Form::input('constraint_recruit_attr', '', array('class' => 'form-control', 'size' => 30));?>
								</div>
								<label id="form_constraint_recruit_attr-error" class="error"
								       for="form_constraint_recruit_attr"></label>

								<p></p>

								<div>
									<div class="input-group">
										<div style="width:80px" class="input-group-addon">時間帯</div>
										<?php echo Form::select('constraint_start_time_hour', '', $hours, array('class' => 'form-control')); ?>
									</div>
									:
									<?php echo Form::select('constraint_start_time_minute', '', $minutes, array('class' => 'form-control')); ?>
									～
									<?php echo Form::select('constraint_end_time_hour', '', $hours, array('class' => 'form-control')); ?>
									:
									<?php echo Form::select('constraint_end_time_minute', '', $minutes, array('class' => 'form-control')); ?>
									<label id="constraint-error" class="error" for="constraint"></label>
									<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-right">年少者・高校生</th>
							<td>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時給</div>
									<?php echo Form::input('minor_hourly_wage', '', array('class' => 'form-control', 'size' => 5));?>
									<div class="input-group-addon">円</div>
								</div>
								<label id="form_minor_hourly_wage-error" class="error"
								       for="form_minor_hourly_wage"></label>

								<div class="input-group">
									<div class="input-group-addon">募集属性</div>
									<?php echo Form::input('minor_recruit_attr', '', array('class' => 'form-control', 'size' => 30));?>
								</div>
								<label id="form_minor_recruit_attr-error" class="error"
								       for="form_minor_recruit_attr"></label>

								<p></p>

								<div>
									<div class="input-group">
										<div style="width:80px" class="input-group-addon">時間帯</div>
										<?php echo Form::select('minor_start_time_hour', '', $hours, array('class' => 'form-control')); ?>
									</div>
									:
									<?php echo Form::select('minor_start_time_minute', '', $minutes, array('class' => 'form-control')); ?>
									～
									<?php echo Form::select('minor_end_time_hour', '', $hours, array('class' => 'form-control')); ?>
									:
									<?php echo Form::select('minor_end_time_minute', '', $minutes, array('class' => 'form-control')); ?>
									<label id="minor-error" class="error" for="minor"></label>
									<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-right">夜勤</th>
							<td>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時給</div>
									<?php echo Form::input('night_hourly_wage', '', array('class' => 'form-control', 'size' => 5));?>
									<div class="input-group-addon">円</div>
								</div>
								<label id="form_night_hourly_wage-error" class="error"
								       for="form_night_hourly_wage"></label>

								<div class="input-group">
									<div class="input-group-addon">募集属性</div>
									<?php echo Form::input('night_recruit_attr', '', array('class' => 'form-control', 'size' => 30));?>
								</div>
								<label id="form_night_recruit_attr-error" class="error"
								       for="form_night_recruit_attr"></label>

								<p></p>

								<div>
									<div class="input-group">
										<div style="width:80px" class="input-group-addon">時間帯</div>
										<?php echo Form::select('night_start_time_hour', '', $hours, array('class' => 'form-control')); ?>
									</div>
									:
									<?php echo Form::select('night_start_time_minute', '', $minutes, array('class' => 'form-control')); ?>
									～
									<?php echo Form::select('night_end_time_hour', '', $hours, array('class' => 'form-control')); ?>
									:
									<?php echo Form::select('night_end_time_minute', '', $minutes, array('class' => 'form-control')); ?>
									<label id="night-error" class="error" for="night"></label>
									<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-right">適用期間</th>
							<td>
								<input name="apply_start_date" type="text" class="form-control dateform">
								～
								<input name="apply_end_date" type="text" class="form-control dateform">
								<span class="text-info">※入力が無い場合は無制限、期間を過ぎると自動削除されます</span>
								<label id="apply_date-error" class="error" for="apply_date"></label>
							</td>
						</tr>
						</tbody>
					</table>

					<div class="text-center">
						<span class="text-info">※保存ボタンを押下しても未入力の場合は登録されません</span>
					</div>

					<div class="text-center">
						<button name="submit" class="btn btn-primary btn-sm" type="submit">
							<i class="glyphicon glyphicon-pencil icon-white"></i>
							保存
						</button>
					</div>
					<?php echo Form::close();?>
				</div>
			</div>
		<?php
		}
		if(isset($action))
		{
	?>
			<div class="panel panel-warning">
				<?php if (Session::get_flash('error-'.Input::post('panel_index'))): ?>
				<div class="panel-heading text-right">
					<div style="text-align:left"><?php echo Session::get_flash('error-'.Input::post('panel_index'));?></div>
				</div>
				<?php endif; ?>
				<div class="panel-body">
					<?php echo Form::open(array('class' => 'form-inline sssale_form', 'action' => \Fuel\Core\Uri::base().'master/sssale?ss_id='.$ss_id.'&ss_name='.$ss_name));?>
					<input type="hidden" name="ss_id" value="<?php echo $ss_id;?>">
					<input type="hidden" name="panel_index" value="<?php echo Input::post('panel_index');?>">
					<table class="table table-striped">
						<tbody>
						<tr>
							<th class="text-right">売上形態</th>
							<td>
								<?php echo Form::select('sale_type', Input::post('sale_type'), $sale_type, array('class' => 'form-control')); ?>
								<?php echo Form::input('sale_name', Input::post('sale_name'), array('class' => 'form-control', 'size' => 30, 'placeholder' => '形態管理名称'));?>
							</td>
						</tr>
						<tr>
							<th class="text-right">時間フリー</th>
							<td>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時給</div>
									<?php echo Form::input('free_hourly_wage', Input::post('free_hourly_wage'), array('class' => 'form-control', 'size' => 5));?>
									<div class="input-group-addon">円</div>
								</div>
								<label id="form_free_hourly_wage-error" class="error" for="form_free_hourly_wage"></label>
								<div class="input-group">
									<div class="input-group-addon">募集属性</div>
									<?php echo Form::input('free_recruit_attr', Input::post('free_recruit_attr'), array('class' => 'form-control', 'size' => 30));?>
								</div>
								<label id="form_free_recruit_attr-error" class="error" for="form_free_recruit_attr"></label>
								<p></p>
								<div>
									<div class="input-group">
										<div style="width:80px" class="input-group-addon">時間帯</div>
										<?php echo Form::select('free_start_time_hour', Input::post('free_start_time_hour'), $hours, array('class' => 'form-control')); ?>
									</div>
									:
									<?php echo Form::select('free_start_time_minute', Input::post('free_start_time_minute'), $minutes, array('class' => 'form-control')); ?>
									～
									<?php echo Form::select('free_end_time_hour', Input::post('free_end_time_hour'), $hours, array('class' => 'form-control')); ?>
									:
									<?php echo Form::select('free_end_time_minute', Input::post('free_end_time_minute'), $minutes, array('class' => 'form-control')); ?>
									<label id="free-error" class="error" for="free"></label>
									<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-right">時間制約</th>
							<td>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時給</div>
									<?php echo Form::input('constraint_hourly_wage', Input::post('constraint_hourly_wage'), array('class' => 'form-control', 'size' => 5));?>
									<div class="input-group-addon">円</div>
								</div>
								<label id="form_constraint_hourly_wage-error" class="error" for="form_constraint_hourly_wage"></label>
								<div class="input-group">
									<div class="input-group-addon">募集属性</div>
									<?php echo Form::input('constraint_recruit_attr', Input::post('constraint_recruit_attr'), array('class' => 'form-control', 'size' => 30));?>
								</div>
								<label id="form_constraint_recruit_attr-error" class="error" for="form_constraint_recruit_attr"></label>
								<p></p>

								<div>
									<div class="input-group">
										<div style="width:80px" class="input-group-addon">時間帯</div>
										<?php echo Form::select('constraint_start_time_hour', Input::post('constraint_start_time_hour'), $hours, array('class' => 'form-control')); ?>
									</div>
									:
									<?php echo Form::select('constraint_start_time_minute', Input::post('constraint_start_time_minute'), $minutes, array('class' => 'form-control')); ?>
									～
									<?php echo Form::select('constraint_end_time_hour', Input::post('constraint_end_time_hour'), $hours, array('class' => 'form-control')); ?>
									:
									<?php echo Form::select('constraint_end_time_minute', Input::post('constraint_end_time_minute'), $minutes, array('class' => 'form-control')); ?>
									<label id="constraint-error" class="error" for="constraint"></label>
									<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-right">年少者・高校生</th>
							<td>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時給</div>
									<?php echo Form::input('minor_hourly_wage', Input::post('minor_hourly_wage'), array('class' => 'form-control', 'size' => 5));?>
									<div class="input-group-addon">円</div>
								</div>
								<label id="form_minor_hourly_wage-error" class="error" for="form_minor_hourly_wage"></label>
								<div class="input-group">
									<div class="input-group-addon">募集属性</div>
									<?php echo Form::input('minor_recruit_attr', Input::post('minor_recruit_attr'), array('class' => 'form-control', 'size' => 30));?>
								</div>
								<label id="form_minor_recruit_attr-error" class="error" for="form_minor_recruit_attr"></label>
								<p></p>

								<div>
									<div class="input-group">
										<div style="width:80px" class="input-group-addon">時間帯</div>
										<?php echo Form::select('minor_start_time_hour', Input::post('minor_start_time_hour'), $hours, array('class' => 'form-control')); ?>
									</div>
									:
									<?php echo Form::select('minor_start_time_minute', Input::post('minor_start_time_minute'), $minutes, array('class' => 'form-control')); ?>
									～
									<?php echo Form::select('minor_end_time_hour', Input::post('minor_end_time_hour'), $hours, array('class' => 'form-control')); ?>
									:
									<?php echo Form::select('minor_end_time_minute', Input::post('minor_end_time_minute'), $minutes, array('class' => 'form-control')); ?>
									<label id="minor-error" class="error" for="minor"></label>
									<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-right">夜勤</th>
							<td>
								<div class="input-group">
									<div style="width:80px" class="input-group-addon">時給</div>
									<?php echo Form::input('night_hourly_wage', Input::post('night_hourly_wage'), array('class' => 'form-control', 'size' => 5));?>
									<div class="input-group-addon">円</div>
								</div>
								<label id="form_night_hourly_wage-error" class="error" for="form_night_hourly_wage"></label>
								<div class="input-group">
									<div class="input-group-addon">募集属性</div>
									<?php echo Form::input('night_recruit_attr', Input::post('night_recruit_attr'), array('class' => 'form-control', 'size' => 30));?>
								</div>
								<label id="form_night_recruit_attr-error" class="error" for="form_night_recruit_attr"></label>
								<p></p>

								<div>
									<div class="input-group">
										<div style="width:80px" class="input-group-addon">時間帯</div>
										<?php echo Form::select('night_start_time_hour', Input::post('night_start_time_hour'), $hours, array('class' => 'form-control')); ?>
									</div>
									:
									<?php echo Form::select('night_start_time_minute', Input::post('night_start_time_minute'), $minutes, array('class' => 'form-control')); ?>
									～
									<?php echo Form::select('night_end_time_hour', Input::post('night_end_time_hour'), $hours, array('class' => 'form-control')); ?>
									:
									<?php echo Form::select('night_end_time_minute', Input::post('night_end_time_minute'), $minutes, array('class' => 'form-control')); ?>
									<label id="night-error" class="error" for="night"></label>
									<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-right">適用期間</th>
							<td>
								<input name="apply_start_date" type="text" class="form-control dateform"
								       value="<?php echo Input::post('apply_start_date');?>">
								～
								<input name="apply_end_date" type="text" class="form-control dateform"
								       value="<?php echo Input::post('apply_end_date');?>">
								<span class="text-info">※入力が無い場合は無制限、期間を過ぎると自動削除されます</span>
								<label id="apply_date-error" class="error" for="apply_date"></label>
							</td>
						</tr>
						</tbody>
					</table>

					<div class="text-center">
						<span class="text-info">※保存ボタンを押下しても未入力の場合は登録されません</span>
					</div>

					<div class="text-center">
						<button name="submit" class="btn btn-primary btn-sm" type="submit">
							<i class="glyphicon glyphicon-pencil icon-white"></i>
							保存
						</button>
					</div>
					<?php echo Form::close();?>
				</div>
			</div>
	<?php
		}
	?>
</div>
<div class="hide" id="panel_hidden">
	<div class="panel panel-warning">
		<div class="panel-body">
			<?php echo Form::open(array('class' => 'form-inline sssale_form', 'action' => \Fuel\Core\Uri::base().'master/sssale?ss_id='.$ss_id.'&ss_name='.$ss_name));?>
			<input type="hidden" name="ss_id" value="<?php echo $ss_id;?>">
			<input type="hidden" name="panel_index" value="">
			<table class="table table-striped">
				<tbody>
				<tr>
					<th class="text-right">売上形態</th>
					<td>
						<?php echo Form::select('sale_type', '', $sale_type, array('class' => 'form-control')); ?>
						<?php echo Form::input('sale_name', '', array('class' => 'form-control', 'size' => 30, 'placeholder' => '形態管理名称'));?>
					</td>
				</tr>
				<tr>
					<th class="text-right">時間フリー</th>
					<td>
						<div class="input-group">
							<div style="width:80px" class="input-group-addon">時給</div>
							<?php echo Form::input('free_hourly_wage', '', array('class' => 'form-control', 'size' => 5));?>
							<div class="input-group-addon">円</div>
						</div>
						<label id="form_free_hourly_wage-error" class="error" for="form_free_hourly_wage"></label>
						<div class="input-group">
							<div class="input-group-addon">募集属性</div>
							<?php echo Form::input('free_recruit_attr', '', array('class' => 'form-control', 'size' => 30));?>
						</div>
						<label id="form_free_recruit_attr-error" class="error" for="form_free_recruit_attr"></label>
						<p></p>

						<div>
							<div class="input-group">
								<div style="width:80px" class="input-group-addon">時間帯</div>
								<?php echo Form::select('free_start_time_hour', '', $hours, array('class' => 'form-control')); ?>
							</div>
							:
							<?php echo Form::select('free_start_time_minute', '', $minutes, array('class' => 'form-control')); ?>
							～
							<?php echo Form::select('free_end_time_hour', '', $hours, array('class' => 'form-control')); ?>
							:
							<?php echo Form::select('free_end_time_minute', '', $minutes, array('class' => 'form-control')); ?>
							<label id="free-error" class="error" for="free"></label>
							<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="text-right">時間制約</th>
					<td>
						<div class="input-group">
							<div style="width:80px" class="input-group-addon">時給</div>
							<?php echo Form::input('constraint_hourly_wage', '', array('class' => 'form-control', 'size' => 5));?>
							<div class="input-group-addon">円</div>
						</div>
						<label id="form_constraint_hourly_wage-error" class="error" for="form_constraint_hourly_wage"></label>
						<div class="input-group">
							<div class="input-group-addon">募集属性</div>
							<?php echo Form::input('constraint_recruit_attr', '', array('class' => 'form-control', 'size' => 30));?>
						</div>
						<label id="form_constraint_recruit_attr-error" class="error" for="form_constraint_recruit_attr"></label>
						<p></p>

						<div>
							<div class="input-group">
								<div style="width:80px" class="input-group-addon">時間帯</div>
								<?php echo Form::select('constraint_start_time_hour', '', $hours, array('class' => 'form-control')); ?>
							</div>
							:
							<?php echo Form::select('constraint_start_time_minute', '', $minutes, array('class' => 'form-control')); ?>
							～
							<?php echo Form::select('constraint_end_time_hour', '', $hours, array('class' => 'form-control')); ?>
							:
							<?php echo Form::select('constraint_end_time_minute', '', $minutes, array('class' => 'form-control')); ?>
							<label id="constraint-error" class="error" for="constraint"></label>
							<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="text-right">年少者・高校生</th>
					<td>
						<div class="input-group">
							<div style="width:80px" class="input-group-addon">時給</div>
							<?php echo Form::input('minor_hourly_wage','', array('class' => 'form-control', 'size' => 5));?>
							<div class="input-group-addon">円</div>
						</div>
						<label id="form_minor_hourly_wage-error" class="error" for="form_minor_hourly_wage"></label>
						<div class="input-group">
							<div class="input-group-addon">募集属性</div>
							<?php echo Form::input('minor_recruit_attr', '', array('class' => 'form-control', 'size' => 30));?>
						</div>
						<label id="form_minor_recruit_attr-error" class="error" for="form_minor_recruit_attr"></label>
						<p></p>

						<div>
							<div class="input-group">
								<div style="width:80px" class="input-group-addon">時間帯</div>
								<?php echo Form::select('minor_start_time_hour', '', $hours, array('class' => 'form-control')); ?>
							</div>
							:
							<?php echo Form::select('minor_start_time_minute', '', $minutes, array('class' => 'form-control')); ?>
							～
							<?php echo Form::select('minor_end_time_hour', '', $hours, array('class' => 'form-control')); ?>
							:
							<?php echo Form::select('minor_end_time_minute', '', $minutes, array('class' => 'form-control')); ?>
							<label id="minor-error" class="error" for="minor"></label>
							<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="text-right">夜勤</th>
					<td>
						<div class="input-group">
							<div style="width:80px" class="input-group-addon">時給</div>
							<?php echo Form::input('night_hourly_wage', '', array('class' => 'form-control', 'size' => 5));?>
							<div class="input-group-addon">円</div>
						</div>
						<label id="form_night_hourly_wage-error" class="error" for="form_night_hourly_wage"></label>
						<div class="input-group">
							<div class="input-group-addon">募集属性</div>
							<?php echo Form::input('night_recruit_attr', '', array('class' => 'form-control', 'size' => 30));?>
						</div>
						<label id="form_night_recruit_attr-error" class="error" for="form_night_recruit_attr"></label>
						<p></p>

						<div>
							<div class="input-group">
								<div style="width:80px" class="input-group-addon">時間帯</div>
								<?php echo Form::select('night_start_time_hour', '', $hours, array('class' => 'form-control')); ?>
							</div>
							:
							<?php echo Form::select('night_start_time_minute', '', $minutes, array('class' => 'form-control')); ?>
							～
							<?php echo Form::select('night_end_time_hour', '', $hours, array('class' => 'form-control')); ?>
							:
							<?php echo Form::select('night_end_time_minute', '', $minutes, array('class' => 'form-control')); ?>
							<label id="night-error" class="error" for="night"></label>
							<span class="text-info">※24時間・時間帯指定無の場合は00:00～00:00で保存</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="text-right">適用期間</th>
					<td>
						<input name="apply_start_date" type="text" class="form-control dateform">
						～
						<input name="apply_end_date" type="text" class="form-control dateform">
						<span class="text-info">※入力が無い場合は無制限、期間を過ぎると自動削除されます</span>
						<label id="apply_date-error" class="error" for="apply_date"></label>
					</td>
				</tr>
				</tbody>
			</table>

			<div class="text-center">
				<span class="text-info">※保存ボタンを押下しても未入力の場合は登録されません</span>
			</div>

			<div class="text-center">
				<button class="btn btn-primary btn-sm" type="submit">
					<i class="glyphicon glyphicon-pencil icon-white"></i>
					保存
				</button>
			</div>
			<?php echo Form::close();?>
		</div>
	</div>
</div>

