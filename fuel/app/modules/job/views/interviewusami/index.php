<?php echo \Fuel\Core\Asset::js('validate/interviewusami.js')?>
<h3>
	面接票
	<div class="text-right">
		<a class="btn btn-warning btn-sm" name="back-btn" href="<?php echo \Fuel\Core\Uri::base().'job/persons';?>">
			<i class="glyphicon glyphicon-step-backward icon-white"></i>
			戻る
		</a>
	</div>
</h3>

<p class="text-center">
	<a href="<?php echo \Fuel\Core\Uri::base().'job/person?person_id='.$person_id;?>">応募者</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base().'job/employment?person_id='.$person_id;?>">採用管理</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base().'job/personfile?person_id='.$person_id;?>">本人確認書類</a>
	<!--
	<a href="<?php echo \Fuel\Core\Uri::base().'job/interview?person_id='.$person_id;?>">面接票(UOS・その他)</a>
	-->
	|
	<a href="<?php echo \Fuel\Core\Uri::base().'job/interviewusami?person_id='.$person_id;?>">面接票</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base().'job/emcall?person_id='.$person_id;?>">緊急連絡先</a>
</p>
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
<?php
if(Session::get_flash('success'))
{
	?>
	<div role="alert" class="alert alert-success alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<?php echo Session::get_flash('success');?>
	</div>
<?php
}
?>

<?php
echo Presenter::forge('module/personinfo')->set('person_id',$person_id);
?>


<form class="form-inline" id="interviewusami_form" method="post">
	<input type="hidden" name="data[person_id]" value="<?php echo $person_id;?>">
	<?php
		if(isset($inteview_usami))
		{
			echo '<input type="hidden" name="data[id]" value="'.$inteview_usami->id.'">';
		}
	?>
	<table class="table table-striped">
		<tr>
			<th class="text-right">面接日</th>
			<td>
				<?php echo Form::input('data[interview_day]', Input::post('data[interview_day]') ? Input::post('data[interview_day]') : (isset($inteview_usami) ? $inteview_usami->interview_day : ''), array('id' => 'interview_day', 'class' => 'form-control dateform', 'size' => 12));?>
			</td>
		</tr>
		<tr>
			<th class="text-right">親権者承諾</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[parental_authority]', 1, Input::post('data[parental_authority]',0) == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->parental_authority == 1 ? true : 'false'));?>
					済
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[parental_authority]', 2, Input::post('data[parental_authority]',0) == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->parental_authority == 2 ? true : 'false'));?>
					未
				</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">通勤手段</th>
			<td>
				<?php
					$commuting_mean = array();
					if(isset($inteview_usami) && $inteview_usami->commuting_means != '')
						$commuting_mean = explode(',', $inteview_usami->commuting_means);
					foreach(Constants::$_commuting_means as $k => $v)
					{
						$bus_train = ($k == 5) ? 'commuting_means_bus' : 'commuting_means_train';
						echo '<label class="checkbox-inline">';
						echo Form::checkbox('data[commuting_means]['.$k.']', $k, in_array($k,Input::post('data[commuting_means]',array())) ? true : (in_array($k, $commuting_mean) ? true : false), array('id' => 'commuting'.$k)).$v;
						echo '</label>';
						if($k == 4) echo '<p></p>';
						if($k == 5 || $k == 6)
						{
							echo '<div class="input-group">';
							echo '<div class="input-group-addon">'.$v.'</div>';
							echo Form::input('data['.$bus_train.']', Input::post('data['.$bus_train.']') ? Input::post('data['.$bus_train.']') : (isset($inteview_usami) ? $inteview_usami->$bus_train : ''), array('id' => $bus_train, 'class' => 'form-control', 'size' => 5));
							echo '<div class="input-group-addon">円/片道</div>';
							echo '</div>';
							echo '<label id="'.$bus_train.'-error" class="error" for="'.$bus_train.'"></label>';
						}
						if($k == 5) echo '  ';
					}
				?>
				<div class="text-info">
					※必須、バス・電車が選択された場合それぞれの運賃も必須
				</div>
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">通勤距離</div>
					<?php echo Form::input('data[commute_dis]', Input::post('data[commute_dis]') ? Input::post('data[commute_dis]') : (isset($inteview_usami) ? $inteview_usami->commute_dis : ''), array('class' => 'form-control', 'size' => 5,'id'=>'commute_dis'));?>
					<div class="input-group-addon">km/片道</div>
				</div>
				<label id="commute_dis-error" class="error" for="commute_dis"></label>
				<span class="text-info">※必須</span>
			</td>
		</tr>
		<tr>
			<th class="text-right">希望職種</th>
			<td>
				SS(
				<?php
					$ss_match = array();
				if(isset($inteview_usami) && $inteview_usami->ss_match != '')
					$ss_match = explode(',', $inteview_usami->ss_match);
					foreach(Constants::$_ss_match as $k => $v)
					{
						if ($k == '91') {
							echo ')';
						}
						echo '<label class="checkbox-inline">';
						echo Form::checkbox('data[ss_match]['.$k.']', $k, in_array($k,Input::post('data[ss_match]',array())) ? true : (in_array($k, $ss_match) ? true : false), array('id' => 'ss_match'.$k)).$v;
						echo '</label>';
					}
				?>
				<p></p>
				<?php
					echo Form::input('data[ss_match_other]', Input::post('data[ss_match_other]') ? Input::post('data[ss_match_other]') : (isset($inteview_usami) ? $inteview_usami->ss_match_other : ''), array('class' => 'form-control', 'size' => 30, 'maxlength' => 50, 'placeHolder' => 'その他の場合'));
				?>
				<span class="text-info">
					※その他を選択した場合必須
				</span>
			</td>
		</tr>
		<tr>
			<th class="text-right">勤務地</th>
			<td>
				<div class="input-group">
					<div class="input-group-addon">希望①</div>
					<?php
					echo Form::input('data[work_location_hope1]', Input::post('data[work_location_hope1]') ? Input::post('data[work_location_hope1]') : (isset($inteview_usami) ? $inteview_usami->work_location_hope1 : ''), array('class' => 'form-control', 'size' => 30, 'maxlength' => 30));
					?>
				</div>
				<label id="form_data[work_location_hope1]-error" class="error" for="form_data[work_location_hope1]"></label>
				<div class="input-group">
					<div class="input-group-addon">片道</div>
					<?php
					echo Form::input('data[work_location_hope1_time]', Input::post('data[work_location_hope1_time]') ? Input::post('data[work_location_hope1_time]') : (isset($inteview_usami) ? $inteview_usami->work_location_hope1_time : ''), array('id' => 'work_location_hope1_time', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">分</div>
				</div>
				<label id="work_location_hope1_time-error" class="error" for="work_location_hope1_time"></label>
				<span class="text-info">※①は必須</span>
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">希望②</div>
					<?php
					echo Form::input('data[work_location_hope2]', Input::post('data[work_location_hope2]') ? Input::post('data[work_location_hope2]') : (isset($inteview_usami) ? $inteview_usami->work_location_hope2 : ''), array('class' => 'form-control', 'size' => 30, 'maxlength' => 30));
					?>
				</div>
				<div class="input-group">
					<div class="input-group-addon">片道</div>
					<?php
					echo Form::input('data[work_location_hope2_time]', Input::post('data[work_location_hope2_time]') ? Input::post('data[work_location_hope2_time]') : (isset($inteview_usami) ? $inteview_usami->work_location_hope2_time : ''), array('id' => 'work_location_hope1_time', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">分</div>
				</div>
				<label id="work_location_hope2_time-error" class="error" for="work_location_hope2_time"></label>
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">備考</div>
					<?php echo Form::textarea('data[work_location_remarks]', Input::post('data[work_location_remarks]') ? Input::post('data[work_location_remarks]') : (isset($inteview_usami) ? $inteview_usami->work_location_remarks : ''), array('rows' => 5, 'cols' => 80, 'class' => 'form-control'));?>
				</div>
			</td>
		</tr>

		<tr>
			<th class="text-right">勤務形態</th>
			<td>
				<div>
					<label class="checkbox-inline">
					<?php
					echo Form::checkbox('data[working_arrangements_shift_free]', 1, Input::post('data[working_arrangements_shift_free]') ? true : (isset($inteview_usami) && $inteview_usami->{'working_arrangements_shift_free'} == 1 ? true : false), array('id' => 'working_arrangements_shift_free'));
					?>
					シフトフリー
					</label>
					<span class="text-info">※曜日も時間帯も指定なしの場合はチェック</span>
				</div>

				<?php
					for($i = 1; $i < 8; $i ++)
					{
						if(isset($inteview_usami))
						{
							${'start_hour'.$i} = ($inteview_usami->{'working_arrangements'.$i.'_start_time'}) ? explode(':',$inteview_usami->{'working_arrangements'.$i.'_start_time'})[0] : '';
							${'end_hour'.$i} = ($inteview_usami->{'working_arrangements'.$i.'_end_time'}) ? explode(':',$inteview_usami->{'working_arrangements'.$i.'_end_time'})[0] : '';
							${'start_minute'.$i} = ($inteview_usami->{'working_arrangements'.$i.'_start_time'}) ? explode(':',$inteview_usami->{'working_arrangements'.$i.'_start_time'})[1] : '';
							${'end_minute'.$i} = ($inteview_usami->{'working_arrangements'.$i.'_end_time'}) ? explode(':',$inteview_usami->{'working_arrangements'.$i.'_end_time'})[1] : '';
						}
				?>
					<div id ="<?php echo 'div_working_arrangements'.$i?>">
						<label class="checkbox-inline">
							<span class="text-success"><?php echo Constants::$_day_in_week[$i]?></span>
							(
							<label class="radio-inline">
							<?php echo Form::radio('data[working_arrangements'.$i.']', 1, Input::post('data[working_arrangements'.$i.']') ? true : (isset($inteview_usami) && $inteview_usami->{'working_arrangements'.$i} == 1 ? true : false), array('class'=>'working_arrangements_check','id' => 'working_arrangements'.$i));?>
							夜勤可
							</label>
							<label class="radio-inline">
							<?php echo Form::radio('data[working_arrangements'.$i.']', 0, Input::post('data[working_arrangements'.$i.']') ? true : (isset($inteview_usami) && $inteview_usami->{'working_arrangements'.$i} != '' && $inteview_usami->{'working_arrangements'.$i} == 0 ? true : false), array('class'=>'working_arrangements_check','id' => 'working_arrangements'.$i));?>
							夜勤不可
							</label>
							<span class="text-info">※いずれか必須</span>
							)

						</label>
						<?php
						echo Form::input('data[start_hour'.$i.']', Input::post('data[start_hour'.$i.']') ? Input::post('data[start_hour'.$i.']') : (isset(${'start_hour'.$i}) ? ${'start_hour'.$i} : ''), array('id' => 'start_hour'.$i, 'class' => 'form-control', 'size' => 2, 'maxlength' => 2, 'placeholder' => 'HH'));
						?>
						:
						<?php
						echo Form::input('data[start_minute'.$i.']', Input::post('data[start_minute'.$i.']') ? Input::post('data[start_minute'.$i.']') : (isset(${'start_minute'.$i}) ? ${'start_minute'.$i} : ''), array('id' => 'start_minute'.$i, 'class' => 'form-control', 'size' => 2, 'maxlength' => 2, 'placeholder' => 'MM'));
						?>
						～
						<?php
						echo Form::input('data[end_hour'.$i.']', Input::post('data[end_hour'.$i.']') ? Input::post('data[end_hour'.$i.']') : (isset(${'end_hour'.$i}) ? ${'end_hour'.$i} : ''), array('id' => 'end_hour'.$i, 'class' => 'form-control', 'size' => 2, 'maxlength' => 2, 'placeholder' => 'HH'));
						?>
						:
						<?php
						echo Form::input('data[end_minute'.$i.']', Input::post('data[end_minute'.$i.']') ? Input::post('data[end_minute'.$i.']') : (isset(${'end_minute'.$i}) ? ${'end_minute'.$i} : ''), array('id' => 'end_minute'.$i, 'class' => 'form-control', 'size' => 2, 'maxlength' => 2, 'placeholder' => 'MM'));
						?>
						<label class="checkbox-inline">
							<?php echo Form::checkbox('data[working_arrangements'.$i.'_check]', 1, Input::post('data[working_arrangements'.$i.'_check]') ? true : (isset($inteview_usami) && $inteview_usami->{'working_arrangements'.$i.'_check'} == 1 ? true : false), array('id' => 'working_arrangements_check'.$i));?>
							時間フリー
						</label>
						<label for="time<?php echo $i?>" class="error" id="time<?php echo $i?>-error"></label>
						<label id="data[working_arrangements<?php echo $i?>]-error" class="error" for="data[working_arrangements<?php echo $i?>]"></label>
						<p></p>
				</div>

				<?php

				}
				?>


				<div class="text-info">※シフトフリー以外の場合、月曜日～日・祝のうち1個以上の記入は必須</div>
			</td>
		</tr>
		<tr>
			<th class="text-right">希望勤務日数</th>
			<td>
				<div class="input-group">
					<div class="input-group-addon">週</div>
					<?php
					echo Form::input('data[work_day_week_min]', Input::post('data[work_day_week_min]') ? Input::post('data[work_day_week_min]') : (isset($inteview_usami) ? $inteview_usami->work_day_week_min : ''), array('id' => 'work_day_week_min', 'class' => 'form-control', 'size' => 3));
					?>
					<div class="input-group-addon">日</div>
				</div>
				～
				<div class="input-group">
					<div class="input-group-addon">週</div>
					<?php
					echo Form::input('data[work_day_week_max]', Input::post('data[work_day_week_max]') ? Input::post('data[work_day_week_max]') : (isset($inteview_usami) ? $inteview_usami->work_day_week_max : ''), array('id' => 'work_day_week_max', 'class' => 'form-control', 'size' => 3));
					?>
					<div class="input-group-addon">日</div>
				</div>
				<label id="day_min_max-error" class="error" for="day_min_max"></label>
				<div class="input-group">
					<div class="input-group-addon">月</div>
					<?php
					echo Form::input('data[work_day_month_min]', Input::post('data[work_day_month_min]') ? Input::post('data[work_day_month_min]') : (isset($inteview_usami) ? $inteview_usami->work_day_month_min : ''), array('id' => 'work_day_month_min', 'class' => 'form-control', 'size' => 3));
					?>
					<div class="input-group-addon">H</div>
				</div>
				～
				<div class="input-group">
					<div class="input-group-addon">月</div>
					<?php
					echo Form::input('data[work_day_month_max]', Input::post('data[work_day_month_max]') ? Input::post('data[work_day_month_max]') : (isset($inteview_usami) ? $inteview_usami->work_day_month_max : ''), array('id' => 'work_day_month_max', 'class' => 'form-control', 'size' => 3));
					?>
					<div class="input-group-addon">H</div>
				</div>
				<label id="hour_min_max-error" class="error" for="hour_min_max"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">大型連休勤務</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[work_holiday]', 1, Input::post('data[work_holiday]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->work_holiday == 1 ? true : 'false'));?>
					可
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[work_holiday]', 2, Input::post('data[work_holiday]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->work_holiday == 2 ? true : 'false'));?>
					不可
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[work_holiday]', 3, Input::post('data[work_holiday]','') == 3 ? true : (isset($inteview_usami) &&  $inteview_usami->work_holiday == 3 ? true : 'false'));?>
					要相談
				</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">月収希望額</th>
			<td>
				<div class="input-group">
					<?php
					echo Form::input('data[month_wage]', Input::post('data[month_wage]') ? Input::post('data[month_wage]') : (isset($inteview_usami) ? $inteview_usami->month_wage : ''), array('id' => 'month_wage', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">万円位</div>
				</div>
				<label id="month_wage-error" class="error" for="month_wage"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">その他希望</th>
			<td>
				<?php echo Form::textarea('data[month_wage_other]', Input::post('data[month_wage_other]') ? Input::post('data[month_wage_other]') : (isset($inteview_usami) ? $inteview_usami->month_wage_other : ''), array('rows' => 5, 'cols' => 80));?>
			</td>
		</tr>
		<tr>
			<th class="text-right">勤務期間</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[time_of_service]', 1, Input::post('data[time_of_service]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->time_of_service == 1 ? true : false));?>
					3～6ヶ月
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[time_of_service]', 2, Input::post('data[time_of_service]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->time_of_service == 2 ? true : false));?>
					6ヶ月～1年未満
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[time_of_service]', 3, Input::post('data[time_of_service]','') == 3 ? true : (isset($inteview_usami) &&  $inteview_usami->time_of_service == 3 ? true : false));?>
					1年以上
				</label>
				<label id="data[time_of_service]-error" class="error" for="data[time_of_service]"></label>
				<span class="text-info">※いずれか必須</span>
			</td>
		</tr>
		<tr>
			<th class="text-right">就労希望日</th>
			<td>
				<div class="input-group">
					<?php
					echo Form::input('data[employment_month]', Input::post('data[employment_month]') ? Input::post('data[employment_month]') : (isset($inteview_usami) ? $inteview_usami->employment_month : ''), array('id' => 'employment_month', 'class' => 'form-control', 'size' => 2));
					?>
					<div class="input-group-addon">月</div>
				</div>
				<label id="employment_month-error" class="error" for="employment_month"></label>
				<div class="input-group">
					<?php
					echo Form::input('data[employment_day]', Input::post('data[employment_day]') ? Input::post('data[employment_day]') : (isset($inteview_usami) ? $inteview_usami->employment_day : ''), array('id' => 'employment_day', 'class' => 'form-control', 'size' => 2));
					?>
					<div class="input-group-addon">日以降</div>
				</div>
				<label id="employment_day-error" class="error" for="employment_day"></label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('data[employment_possible]', 1, Input::post('data[employment_possible]',0) == 1 ? true : (isset($inteview_usami) ? $inteview_usami->employment_possible : false));
					?>
					即可能
				</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">応募媒体</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[media_app]', 1, Input::post('data[media_app]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->media_app == 1 ? true : false));?>
					ネット
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[media_app]', 2, Input::post('data[media_app]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->media_app == 2 ? true : false));?>
					紙媒体
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[media_app]', 3, Input::post('data[media_app]','') == 3 ? true : (isset($inteview_usami) &&  $inteview_usami->media_app == 3 ? true : false));?>
					紹介
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[media_app]', 4, Input::post('data[media_app]','') == 4 ? true : (isset($inteview_usami) &&  $inteview_usami->media_app == 4 ? true : false), array('id' => 'media_app_4'));?>
					他
				</label>
				<span class="text-info">※いずれか必須</span>
				<?php
				echo Form::input('data[media_app_other]', Input::post('data[media_app_other]') ? Input::post('data[media_app_other]') : (isset($inteview_usami) ? $inteview_usami->media_app_other : ''), array('maxlength' => 30, 'class' => 'form-control', 'size' => 25, 'placeholder' => '名称(ネット/紙媒体/紹介など)'));
				?>
				<span class="text-info">※必須</span>
				<label id="data[media_app]-error" class="error" for="data[media_app]"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">SSでの職務経験</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[experience]', 0, Input::post('data[experience]') != '' && Input::post('data[experience]') == 0 ? true : (isset($inteview_usami) &&  $inteview_usami->experience == 0 ? true : false), array('id' => 'experience0'));?>
					無
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[experience]', 1, Input::post('data[experience]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->experience == 1 ? true : false), array('id' => 'experience1'));?>
					有
				</label>
				<div id="experience-block">
					<div class="input-group">
						<?php
						echo Form::input('data[experience_year_position_before]', Input::post('data[experience_year_position_before]') ? Input::post('data[experience_year_position_before]') : (isset($inteview_usami) ? $inteview_usami->experience_year_position_before : ''), array('class' => 'form-control', 'size' => 3, 'id' => 'experience_year_position_before'));
						?>
						<div class="input-group-addon">年位前</div>
					</div>
					<label id="experience_year_position_before-error" class="error" for="experience_year_position_before"></label>
					<div class="input-group">
						<?php
						echo Form::input('data[experience_year]', Input::post('data[experience_year]') ? Input::post('data[experience_year]') : (isset($inteview_usami) ? $inteview_usami->experience_year : ''), array('class' => 'form-control', 'size' => 3, 'id' => 'experience_year'));
						?>
						<div class="input-group-addon">年</div>
						<?php
						echo Form::input('data[experience_month]', Input::post('data[experience_month]') ? Input::post('data[experience_month]') : (isset($inteview_usami) ? $inteview_usami->experience_month : ''), array('class' => 'form-control', 'size' => 3, 'id' => 'experience_month'));
						?>
						<div class="input-group-addon">ヶ月程度</div>
					</div>
					<label id="experience_year_month-error" class="error" for="experience_year_month" style="display: inline-block;"></label>
					<?php
					echo Form::input('data[experience_other]', Input::post('data[experience_other]') ? Input::post('data[experience_other]') : (isset($inteview_usami) ? $inteview_usami->experience_other : ''), array('class' => 'form-control', 'size' => 30, 'maxlength' => 50, 'placeholder' => '会社名'));
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th class="text-right">運転免許</th>
			<td>
				<?php
					$driver_license = (isset($inteview_usami) && $inteview_usami->driver_license != '') ? explode(',', trim($inteview_usami->driver_license, ',')) : array();
					foreach(Constants::$_driver_license as $k => $v)
					{
				?>
				<div class="col-md-6" style="padding-left: 0px;">
							<label style="width:110px" class="checkbox-inline">
								<?php echo Form::checkbox('data[driver_license]['.$k.']', $k, in_array($k,Input::post('data[driver_license]',array())) ? true : (in_array($k, $driver_license) ? true : false),array('rel="driver_license_'.$k.'"')).$v; ?>
							</label>
							<div class="input-group">
								<div class="input-group-addon">取得日</div>
								<?php
									$name = 'driver_license_date'.$k;
									echo Form::input('data[driver_license_date'.$k.']', Input::post('data[driver_license_date'.$k.']') ? Input::post('data[driver_license_date'.$k.']') : (isset($inteview_usami) ? $inteview_usami->$name : ''), array('class' => 'form-control dateform', 'size' => 10, 'maxlength' => 10));
								?>
								<div class="input-group-addon" style="background-color: #f9f9f9; border: none;">
									<label for="form_data[driver_license_date<?php echo $k?>]" class="error" id="form_data[driver_license_date<?php echo $k ?>]-error"></label>
								</div>
							</div>

						</div>
				<?php
					}
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">危険物資格他</th>
			<td>
				<?php
				$qualification = (isset($inteview_usami) && $inteview_usami->qualification != '') ? explode(',', trim($inteview_usami->qualification, ',')) : array();
				foreach(Constants::$_qualification as $k => $v)
				{
					if($k == 4) $class = '6';
					else $class = '4';
					?>

					<div class="col-md-<?php echo $class?>" style="padding: 0px;">
					<label class="checkbox-inline">
						<?php echo Form::checkbox('data[qualification]['.$k.']', $k, in_array($k,Input::post('data[qualification]',array())) ? true : (in_array($k, $qualification) ? true : false), array('id' => 'qualification'.$k,'rel' =>'qualification_date_'.$k)).$v; ?>
					</label>
					<div class="input-group">
						<div class="input-group-addon">取得日</div>
						<?php
						$name = 'qualification_date'.$k;
						echo Form::input('data[qualification_date'.$k.']', Input::post('data[qualification_date'.$k.']') ? Input::post('data[qualification_date'.$k.']') : (isset($inteview_usami) ? $inteview_usami->$name : ''), array('class' => 'form-control dateform', 'size' => 10, 'maxlength' => 10));?>
						<div class="input-group-addon" style="background-color: #f9f9f9; border: none;">
							<label for="form_data[qualification_date<?php echo $k?>]" class="error" id="form_data[qualification_date<?php echo $k ?>]-error"></label>
						</div>
					</div>
					</div>
				<?php
				}
				?>
				<div class="col-md-6">
				<div class="input-group" tyle="width:200px">
					<div class="input-group-addon">乙保有の場合</div>
					<?php
					echo Form::select('data[qualification_b]', Input::post('data[qualification_b]') ? Input::post('data[qualification_b]') : (isset($inteview_usami) ? $inteview_usami->qualification_b : ''), Constants::$_qualification_b, array('class' => 'form-control'));
					?>
					<div class="input-group-addon">種</div>
				</div>
				<label id="form_data[qualification_b]-error" class="error" for="form_data[qualification_b]"></label>
				</div>
			</td>
		</tr>
		<tr>
			<th class="text-right">整備士資格</th>
			<td>
				<?php
				$qualification_mechanic = (isset($inteview_usami) && $inteview_usami->qualification_mechanic != '') ? explode(',', trim($inteview_usami->qualification_mechanic, ',')) : array();
				foreach(Constants::$_qualification_mechanic as $k => $v)
				{
					?>
				<div class="col-md-6" style="padding: 0px;">
					<label class="checkbox-inline" style="width:140px">
						<?php echo Form::checkbox('data[qualification_mechanic]['.$k.']', $k, in_array($k,Input::post('data[qualification_mechanic]',array())) ? true : (in_array($k, $qualification_mechanic) ? true : false),array('rel' => 'qualification_mechanic_date_'.$k)).$v; ?>
					</label>
					<div class="input-group">
						<div class="input-group-addon">取得日</div>
						<?php
						$name = 'qualification_mechanic_date'.$k;
						echo Form::input('data[qualification_mechanic_date'.$k.']', Input::post('data[qualification_mechanic_date'.$k.']') ? Input::post('data[qualification_mechanic_date'.$k.']') : (isset($inteview_usami) ? $inteview_usami->$name : ''), array('class' => 'form-control dateform', 'size' => 8, 'maxlength' => 10));?>
						<div class="input-group-addon" style="background-color: #f9f9f9; border: none;">
							<label for="form_data[qualification_mechanic_date<?php echo $k?>]" class="error" id="form_data[qualification_mechanic_date<?php echo $k ?>]-error"></label>
						</div>
					</div>
					</div>
				<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">PC技能</th>
			<td>
				<?php
				$pc_skills = (isset($inteview_usami) && $inteview_usami->pc_skills != '') ? explode(',', trim($inteview_usami->pc_skills, ',')) : array();
				foreach(Constants::$_pc_skills as $k => $v)
				{
					?>
					<label class="checkbox-inline">
						<?php echo Form::checkbox('data[pc_skills]['.$k.']', $k, in_array($k,Input::post('data[pc_skills]',array())) ? true : (in_array($k, $pc_skills) ? true : false), array('id' => 'pc_skill'.$k)).$v; ?>
					</label>
				<?php
				}
				?>
				<?php
				echo Form::input('data[pc_skin_other]', Input::post('data[pc_skin_other]') ? Input::post('data[pc_skin_other]') : (isset($inteview_usami) ? $inteview_usami->pc_skin_other : ''), array('class' => 'form-control', 'size' => 30, 'maxlength' => 30, 'placeholder' => 'その他の場合'));
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">職業</th>
			<td>
				<?php
				echo Form::select('data[occupation]', Input::post('data[occupation]') ? Input::post('data[occupation]') : (isset($inteview_usami) ? $inteview_usami->occupation : ''), Constants::$_occupation_interview, array('class' => 'form-control', 'id' => 'occupation'));
				?>
				<span class="text-info">※いずれか必須</span>
				<?php
				echo Form::input('data[occupation_company_name]', Input::post('data[occupation_company_name]') ? Input::post('data[occupation_company_name]') : (isset($inteview_usami) ? $inteview_usami->occupation_company_name : ''), array('class' => 'form-control', 'size' => 20, 'maxlength' => 50, 'placeholder' => '会社名'));
				?>
				<span class="text-info">※会社員を選んだ場合必須</span>
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">学生の場合</div>
					<?php
					echo Form::input('data[occupation_student_year]', Input::post('data[occupation_student_year]') ? Input::post('data[occupation_student_year]') : (isset($inteview_usami) ? $inteview_usami->occupation_student_year : ''), array('id' => 'occupation_student_year', 'class' => 'form-control', 'size' => 2));
					?>
					<div class="input-group-addon">年制の</div>
					<?php
					echo Form::input('data[occupation_student_grade]', Input::post('data[occupation_student_grade]') ? Input::post('data[occupation_student_grade]') : (isset($inteview_usami) ? $inteview_usami->occupation_student_grade : ''), array('id' => 'occupation_student_grade', 'class' => 'form-control', 'size' => 2));
					?>
					<div class="input-group-addon">年生</div>
				</div>
				<label id="student-error" class="error" for="student"></label>
				<span class="text-info">※学生を選んだ場合必須</span>
			</td>
		</tr>
		<tr>
			<th class="text-right">パート区分</th>
			<td>
				<?php echo Form::select('data[part_type]', Input::post('data[part_type]') ? Input::post('data[part_type]') : (isset($inteview_usami) ? $inteview_usami->part_type : ''), Constants::$part_type, array('class' => 'form-control')); ?>
			</td>
		</tr>
		<tr>
			<th class="text-right">現在の健康状態</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[health_status]', 1, Input::post('data[health_status]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->health_status == 1 ? true : false));?>
					頑健
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[health_status]', 2, Input::post('data[health_status]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->health_status == 3 ? true : false));?>
					普通
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[health_status]', 3, Input::post('data[health_status]','') == 3 ? true : (isset($inteview_usami) &&  $inteview_usami->health_status == 4 ? true : false));?>
					病弱
				</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">既往症</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[anamnesis]', 1, Input::post('data[anamnesis]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->anamnesis == 1 ? true : false));?>
					無
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[anamnesis]', 2, Input::post('data[anamnesis]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->anamnesis == 2 ? true : false), array('id' => 'anamnesis2'));?>
					有
				</label>
				<div class="input-group">
					<div class="input-group-addon">病名</div>
					<?php
					echo Form::input('data[disease_name]', Input::post('data[disease_name]') ? Input::post('data[disease_name]') : (isset($inteview_usami) ? $inteview_usami->disease_name : ''), array('maxlength' => 50, 'class' => 'form-control', 'size' => 50));
					?>
				</div>
				<span class="text-info">※有の場合必須</span>
				<label id="form_data[disease_name]-error" class="error" for="form_data[disease_name]"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">雇用保険</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[insurance_employment]', 1, Input::post('data[insurance_employment]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->insurance_employment == 1 ? true : false));?>
					対象
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[insurance_employment]', 2, Input::post('data[insurance_employment]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->insurance_employment == 2 ? true : false));?>
					対象外
				</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">社会保険</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[insurance_social]', 1, Input::post('data[insurance_social]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->insurance_social == 1 ? true : false));?>
					対象
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[insurance_social]', 2, Input::post('data[insurance_social]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->insurance_social == 2 ? true : false));?>
					対象外
				</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">配偶者</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[partner]', 1, Input::post('data[partner]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->partner == 1 ? true : false));?>
					無
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[partner]', 2, Input::post('data[partner]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->partner == 2 ? true : false), array('id' => 'partner2'));?>
					有
				</label>
				<div class="input-group">
					<div class="input-group-addon">配偶者以外の扶養人数</div>
					<?php
					echo Form::input('data[partner_dependents_person]', Input::post('data[partner_dependents_person]') ? Input::post('data[partner_dependents_person]') : (isset($inteview_usami) ? $inteview_usami->partner_dependents_person : 0), array('id' => 'partner_dependents_person', 'class' => 'form-control', 'size' => 3));
					?>
					<div class="input-group-addon">人</div>
				</div>
				<label id="partner_dependents_person-error" class="error" for="partner_dependents_person"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">制服貸与</th>
			<td>
				<div class="input-group">
					<div class="input-group-addon">身長</div>
					<?php
					echo Form::input('data[uniform_rental_h]', Input::post('data[uniform_rental_h]') ? Input::post('data[uniform_rental_h]') : (isset($inteview_usami) ? $inteview_usami->uniform_rental_h : ''), array('id' => 'uniform_rental_h', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">cm</div>
				</div>
				<label id="uniform_rental_h-error" class="error" for="uniform_rental_h"></label>
				<div class="input-group">
					<div class="input-group-addon">靴サイズ</div>
					<?php
					echo Form::input('data[uniform_rental_shoe_size]', Input::post('data[uniform_rental_shoe_size]') ? Input::post('data[uniform_rental_shoe_size]') : (isset($inteview_usami) ? $inteview_usami->uniform_rental_shoe_size : ''), array('id' => 'uniform_rental_shoe_size', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">cm</div>
				</div>
				<label id="uniform_rental_shoe_size-error" class="error" for="uniform_rental_shoe_size"></label>
				<p></p>
				服のサイズ(S・M・L等)：
				<div class="input-group">
					<div class="input-group-addon">上</div>
					<?php
					echo Form::input('data[uniform_rental_up]', Input::post('data[uniform_rental_up]') ? Input::post('data[uniform_rental_up]') : (isset($inteview_usami) ? $inteview_usami->uniform_rental_up : ''), array('id' => 'uniform_rental_up', 'class' => 'form-control', 'size' => 5, 'maxlength' => 2));
					?>
				</div>
				<label id="uniform_rental_up-error" class="error" for="uniform_rental_up"></label>
				<div class="input-group">
					<div class="input-group-addon">下</div>
					<?php
					echo Form::input('data[uniform_rental_under]', Input::post('data[uniform_rental_under]') ? Input::post('data[uniform_rental_under]') : (isset($inteview_usami) ? $inteview_usami->uniform_rental_under : ''), array('id' => 'uniform_rental_under', 'class' => 'form-control', 'size' => 5, 'maxlength' => 2));
					?>
				</div>
				<label id="uniform_rental_under-error" class="error" for="uniform_rental_under"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">給与</th>
			<td>
				<div class="input-group">
					<div class="input-group-addon">①契約(基本)時給</div>
					<?php
					echo Form::input('data[salary_hour_wage]', Input::post('data[salary_hour_wage]') ? Input::post('data[salary_hour_wage]') : (isset($inteview_usami) ? $inteview_usami->salary_hour_wage : ''), array('id' => 'salary_hour_wage', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">円</div>
				</div>
				<label id="salary_hour_wage-error" class="error" for="salary_hour_wage"></label>
				＋
				<div class="input-group">
					<div class="input-group-addon">②役割(研修)時給</div>
					<?php
					echo Form::input('data[salary_role_wage]', Input::post('data[salary_role_wage]') ? Input::post('data[salary_role_wage]') : (isset($inteview_usami) ? $inteview_usami->salary_role_wage : 0), array('id' => 'salary_role_wage', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">円</div>
				</div>
				<label id="salary_role_wage-error" class="error" for="salary_role_wage"></label>
				＋
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">③評価時給</div>
					<?php
					echo Form::input('data[salary_evaluation_wage]', Input::post('data[salary_evaluation_wage]') ? Input::post('data[salary_evaluation_wage]') : (isset($inteview_usami) ? $inteview_usami->salary_evaluation_wage : 0), array('id' => 'salary_evaluation_wage', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">円</div>
				</div>
				<label id="salary_evaluation_wage-error" class="error" for="salary_evaluation_wage"></label>
				＋
				<div class="input-group">
					<div class="input-group-addon">④特別時給</div>
					<?php
					echo Form::input('data[salary_special_wage]', Input::post('data[salary_special_wage]') ? Input::post('data[salary_special_wage]') : (isset($inteview_usami) ? $inteview_usami->salary_special_wage : 0), array('id' => 'salary_special_wage', 'class' => 'form-control', 'size' => 5));
					?>
					<div class="input-group-addon">円</div>
				</div>
				<label id="salary_special_wage-error" class="error" for="salary_special_wage"></label>
				＝
				<span class="text-success" id="sum_salary">0円</span>

				<span class="text-info">※全て入力必須、③と④は支店承認が必要</span>
			</td>
		</tr>
		<tr>
			<th class="text-right">採用ランク</th>
			<td>
				<label class="radio-inline">
					<?php echo Form::radio('data[adoption_rank]', 1, Input::post('data[adoption_rank]','') == 1 ? true : (isset($inteview_usami) &&  $inteview_usami->adoption_rank == 1 ? true : false));?>
					マスター
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[adoption_rank]', 2, Input::post('data[adoption_rank]','') == 2 ? true : (isset($inteview_usami) &&  $inteview_usami->adoption_rank == 2 ? true : false));?>
					レギュラー
				</label>
				<label class="radio-inline">
					<?php echo Form::radio('data[adoption_rank]', 3, Input::post('data[adoption_rank]','') == 3 ? true : (isset($inteview_usami) &&  $inteview_usami->adoption_rank == 3 ? true : false));?>
					ビギナー
				</label>
				<span class="text-info">※いずれか必須</span>
				<label id="data[adoption_rank]-error" class="error" for="data[adoption_rank]"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">担当者記入欄</th>
			<td>
				<?php echo Form::textarea('data[adoption_person_des]', Input::post('data[adoption_person_des]') ? Input::post('data[adoption_person_des]') : (isset($inteview_usami) ? $inteview_usami->adoption_person_des : ''), array('rows' => 5, 'cols' => 80));?>
				<p></p>
				<?php
					foreach(Constants::$_adoption_person_type as $k => $v)
					{
				?>
						<label class="radio-inline">
						<?php echo Form::radio('data[adoption_person_type]', $k, Input::post('data[adoption_person_type]','') == $k ? true : (isset($inteview_usami) &&  $inteview_usami->adoption_person_type == $k ? true : false)).$v;?>
						</label>
				<?php
					}
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">UOS担当者</th>
			<td>
				<?php
				$user = \Fuel\Core\Session::get('login_info');
				echo Form::input('data[uos_person]', Input::post('data[uos_person]') ? Input::post('data[uos_person]') : (isset($inteview_usami) ? $inteview_usami->uos_person : $user['name']), array('class' => 'form-control', 'size' => 20, 'maxlength' => 100));
				?>
				<span class="text-info">※初期値はログイン者氏名が入ります</span>
			</td>
		</tr>
		<tr>
			<th class="text-right">店側の確認</th>
			<td>
				<div class="input-group">
					<div class="input-group-addon">名前</div>
					<?php
					echo Form::input('data[confirmation_shop_name]', Input::post('data[confirmation_shop_name]') ? Input::post('data[confirmation_shop_name]') : (isset($inteview_usami) ? $inteview_usami->confirmation_shop_name : ''), array('class' => 'form-control', 'size' => 20, 'maxlength' => 20));
					?>
				</div>
				<div class="input-group">
					<div class="input-group-addon">確認日</div>
					<?php
					echo Form::input('data[confirmation_shop_date]', Input::post('data[confirmation_shop_date]') ? Input::post('data[confirmation_shop_date]') : (isset($inteview_usami) ? $inteview_usami->confirmation_shop_date : ''), array('id' => 'confirmation_shop_date', 'class' => 'form-control dateform', 'size' => 12));
					?>
				</div>
				<label id="confirmation_shop_date-error" class="error" for="confirmation_shop_date"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">採用勤務地</th>
			<td>
				<?php
				echo Form::input('data[location_ss]', Input::post('data[location_ss]') ? Input::post('data[location_ss]') : (isset($inteview_usami) ? $inteview_usami->location_ss : ''), array('maxlength' => '50', 'placeholder'=> 'SS名','class' => 'form-control', 'size' => 50));
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">勤務開始日</th>
			<td>
				<?php
					$date = '';
					$hour = '';
					$minute = '';
					if(isset($inteview_usami) && $inteview_usami->work_starttime != '')
					{
						$arr= explode(' ',$inteview_usami->work_starttime);
						$date = $arr[0];
						$time = $arr[1];
						$hour = explode(':',$arr[1])[0];
						$minute = explode(':',$arr[1])[1];
					}
				?>
				<div class="input-group">
					<div class="input-group-addon">開始日</div>
					<?php
					echo Form::input('data[work_starttime_date]', Input::post('data[work_starttime_date]') ? Input::post('data[work_starttime_date]') : $date, array('id' => 'work_starttime_date', 'class' => 'form-control dateform', 'size' => 12));
					?>
				</div>
				<div class="input-group">
					<div class="input-group-addon">出勤時間</div>
					<?php
					echo Form::input('data[work_starttime_hour]', Input::post('data[work_starttime_hour]') ? Input::post('data[work_starttime_hour]') : $hour, array('id' => 'work_starttime_hour', 'class' => 'form-control', 'size' => 2, 'maxlength' => 2, 'placeholder' => 'HH'));
					?>
					<div class="input-group-addon">:</div>
					<?php
					echo Form::input('data[work_starttime_minute]', Input::post('data[work_starttime_minute]') ? Input::post('data[work_starttime_minute]') : $minute, array('id' => 'work_starttime_minute', 'class' => 'form-control', 'size' => 2, 'maxlength' => 2, 'placeholder' => 'MM'));
					?>
					<div class="input-group-addon">から</div>
				</div>
				<label id="work_starttime-error" class="error" for="work_starttime"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">所得税について</th>
			<td>
				<?php
					foreach(Constants::$_income_tax as $k => $v)
					{
				?>
					<div><label class="radio-inline">
					<?php echo Form::radio('data[income_tax]', $k, Input::post('data[income_tax]','') == $k ? true : (isset($inteview_usami) &&  $inteview_usami->income_tax == $k ? true : false)).$v;?>
					</label></div>
				<?php
					}
				?>
				<span class="text-info">(*1)扶養控除（異動）申告書提出</span>
				　
				<span class="text-danger">(*2)扶養控除（異動）申告書不要</span>
			</td>
		</tr>
		<tr>
			<th class="text-right">源泉徴収票</th>
			<td>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('data[withholding]', 1, Input::post('data[withholding]') ? true : (isset($inteview_usami) && $inteview_usami->withholding == 1 ? true : false));
					?>
					本年度中に前職の会社から給与を支給されていた。
				</label>
				<span class="text-danger">
					⇒　源泉徴収票を提出する事
				</span>
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">備考</div>
					<?php
					echo Form::input('data[withholding_slip]', Input::post('data[withholding_slip]') ? Input::post('data[withholding_slip]') : (isset($inteview_usami) ? $inteview_usami->withholding_slip : ''), array('class' => 'form-control', 'size' => 50, 'maxlength' => 100));
					?>
				</div>
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
<script type="text/javascript">
			$(function()
			{
				$('#working_arrangements_shift_free').on('change', function()
				{
					if ($(this).prop('checked'))
					{
						$(this).parents('td:first').find('input').prop('disabled', true);
						$(this).prop('disabled', false);
					}
					else
					{
						$(this).parents('td:first').find('input').prop('disabled', false);
						$('input[id^=working_arrangements_check]').removeAttr('checked');
						$('input[name=time_free]');
					}
				});
				$('input[id^=working_arrangements_check]').on('change', function()
				{
					if ($(this).prop('checked'))
					{
						$(this).parents('div:first').find('input').prop('disabled', true);
						$(this).prop('disabled', false);
					}
					else
					{
						$(this).parents('div:first').find('input').prop('disabled', false);
					}
				});

				$('input[id^=working_arrangements_check]').each(function(){
					if( ! $('#working_arrangements_shift_free').prop('checked'))
					{

						if ($(this).prop('checked'))
						{
							$(this).parents('div:first').find('input').prop('disabled', true);
							$(this).prop('disabled', false);
						}
						else
						{
							$(this).parents('div:first').find('input').prop('disabled', false);
						}
					}
					else
					{
						$('#working_arrangements_shift_free').parents('td:first').find('input').prop('disabled', true);
						$('#working_arrangements_shift_free').prop('disabled', false);
					}
				})
			});
		</script>