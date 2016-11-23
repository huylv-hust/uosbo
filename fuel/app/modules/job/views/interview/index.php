
<h3>
	面接票(UOS・その他)
	<div class="text-right">
		<a class="btn btn-warning btn-sm" href="<?php if(\Fuel\Core\Cookie::get('person_url')) echo \Fuel\Core\Cookie::get('person_url'); else echo Uri::base(true).'job/persons'?>"/>
		<i class="glyphicon glyphicon-arrow-left icon-white"></i>
		戻る
		</a>
	</div>
</h3>
<?php
	$person_id = \Fuel\Core\Input::get('person_id');
?>
<p class="text-center">
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/person?person_id=<?php echo $person_id; ?>">応募者</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/employment?person_id=<?php echo $person_id; ?>">採用管理</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/personfile?person_id=<?php echo $person_id; ?>">本人確認書類</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/interview?person_id=<?php echo $person_id; ?>">面接票(UOS・その他)</a>
	|
	<a href="<?php echo \Fuel\Core\Uri::base()?>job/interviewusami?person_id=<?php echo $person_id; ?>">面接票(宇佐美)</a>
</p>
<?php
echo render('showinfo');
?>

<?php
	echo Presenter::forge('module/personinfo')->set('person_id',$person_id);
?>

<?php
	echo \Fuel\Core\Form::open(array('method' => 'post','action' => \Fuel\Core\Uri::base().'job/interview?person_id='.\Fuel\Core\Input::get('person_id'), 'class' => 'form-inline', 'name' => 'form_interview', 'id' => 'form_interview'));
?>

	<table class="table table-striped">
		<tr>
			<?php
				echo \Fuel\Core\Form::input('interview_id',isset($interviews) ? $interviews->interview_id : '', array('type' => 'hidden'));
			?>
			<th class="text-right">面接日</th>
			<td>
				<?php
					echo \Fuel\Core\Form::input('interview_date',\Fuel\Core\Input::post('interview_date',isset($interviews) ? $interviews->interview_date : ''),array('class' => 'form-control dateform', 'size' => '12'));
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">緊急連絡先</th>
			<td>
				<div class="input-group">
					<div class="input-group-addon">氏名</div>
					<?php
					echo \Fuel\Core\Form::input('emergency_contact_name',\Fuel\Core\Input::post('emergency_contact_name',isset($interviews) ? $interviews->emergency_contact_name : ''),array('class' => 'form-control', 'size' => '20', 'maxlength' => '20'));
					?>
				</div>
				<div class="input-group">
					<div class="input-group-addon">続柄</div>
					<?php
					echo \Fuel\Core\Form::input('relationship',\Fuel\Core\Input::post('relationship', isset($interviews) ? $interviews->relationship : ''),array('class' => 'form-control', 'size' => '10', 'maxlength' => '10'));
					?>
				</div>
				<div class="input-group">
					<div class="input-group-addon">電話番号</div>
					<?php
					echo \Fuel\Core\Form::input('mobile',\Fuel\Core\Input::post('mobile', isset($interviews) ? $interviews->mobile : ''),array('class' => 'form-control', 'size' => '20', 'maxlength' => '11'));
					?>
				</div>
				<label id="emergency_contact-error" class="error" for="emergency_contact"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">通勤手段</th>
			<td>
				<label class="checkbox-inline">
					<?php
						echo \Fuel\Core\Form::checkbox('commuting_mean_walk','1', (isset($interviews) and $interviews->commuting_mean_walk == "1") ? true : false)
					?>
					徒歩</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('commuting_mean_bicycle','1', (isset($interviews) and $interviews->commuting_mean_bicycle == "1") ? true : false)
					?>
					自転車</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('commuting_mean_bike','1', (isset($interviews) and $interviews->commuting_mean_bike == "1") ? true : false)
					?>
					バイク</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('commuting_mean_car','1', (isset($interviews) and $interviews->commuting_mean_car == "1") ? true : false)
					?>

					車</label>
				<p></p>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('commuting_mean_bus','1', (isset($interviews) and $interviews->commuting_mean_bus == "1") ? true : false)
					?>
					バス</label>
				<div class="input-group">
					<div class="input-group-addon">バス</div>
					<?php
					echo \Fuel\Core\Form::input('commuting_mean_bus_cost',\Fuel\Core\Input::post('commuting_mean_bus_cost',isset($interviews) ? $interviews->commuting_mean_bus_cost : ''),array('class' => 'form-control', 'size' => '5'));
					?>
					<div class="input-group-addon">円/片道</div>
				</div>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('commuting_mean_train','1', (isset($interviews) and $interviews->commuting_mean_train == "1") ? true : false)
					?>
					電車</label>
				<div class="input-group">
					<div class="input-group-addon">電車</div>
					<?php
					echo \Fuel\Core\Form::input('commuting_mean_train_cost',\Fuel\Core\Input::post('commuting_mean_train_cost',isset($interviews) ? $interviews->commuting_mean_train_cost : ''),array('class' => 'form-control', 'size' => '5'));
					?>
					<div class="input-group-addon">円/片道</div>
				</div>
				<div class="text-info">
					※必須、バス・電車が選択された場合それぞれの運賃も必須
				</div>
				<label id="commuting_mean-error" class="error" for="commuting_mean"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">勤務地</th>
			<td>
				<div class="input-group">
					<div class="input-group-addon">場所</div>
					<?php
					echo \Fuel\Core\Form::input('work_location',\Fuel\Core\Input::post('work_location',isset($interviews) ? $interviews->work_location : ''),array('class' => 'form-control', 'size' => '20', 'maxlength' => '30'));
					?>
				</div>
				<span class="text-info">※必須</span>
				<label id="form_work_location-error" class="error" for="form_work_location"></label>
				<p></p>
				<div class="input-group">
					<div class="input-group-addon">往復</div>
					<?php
					echo \Fuel\Core\Form::input('round_trip',\Fuel\Core\Input::post('round_trip',isset($interviews) ? $interviews->round_trip : ''),array('class' => 'form-control', 'size' => '5'));
					?>
					<div class="input-group-addon">km</div>
				</div>
				<div class="input-group">
					<div class="input-group-addon">所要時間</div>
					<?php
					echo \Fuel\Core\Form::input('work_location_time',\Fuel\Core\Input::post('work_location_time',isset($interviews) ? $interviews->work_location_time : ''),array('class' => 'form-control', 'size' => '5'));
					?>
					<div class="input-group-addon">分くらい</div>
				</div>
				<label id="round_work-error" class="error" for="round_work"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">現在の健康状態</th>
			<td>

				<label class="radio-inline">
					<?php
					echo Form::radio('health_status', '1', (isset($interviews) and $interviews->health_status == 1) ? true : false);
					?>
					頑健</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('health_status', '2', (isset($interviews) and $interviews->health_status == 2) ? true : false);
					?>
					普通</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('health_status', '3', (isset($interviews) and  $interviews->health_status == 3) ? true : false);
					?>
					病弱</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">
				既往症(治療中)
				<button type="button" class="btn btn-success btn-sm" name="add-sicknow-btn">
					<i class="glyphicon glyphicon-plus icon-white"></i>
				</button>
			</th>
			<td id="sicknow">
				<?php
					if(isset($interviews) and $anamnesis = Model_Interview::json_convert($interviews->anamnesis))
					{
						foreach($anamnesis as $k => $v)
						{
				?>
							<div class="sicknow-block">
								<div class="input-group">
									<div class="input-group-addon">病名</div>
									<input type="text" name="anamnesis[<?php echo $k; ?>]" value="<?php echo $v ?>" class="anamnesis form-control" size="50" maxlength="100">
								</div>
								<button type="button" class="btn btn-danger btn-sm" name="remove-btn">
									<i class="glyphicon glyphicon-trash icon-white"></i>
								</button>
								<label id="anamnesis[<?php echo $k; ?>]-error" class="error" for="anamnesis[<?php echo $k; ?>]"></label>
								<p></p>
							</div>
				<?php
						}
					}
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">
				既往歴
				<button type="button" class="btn btn-success btn-sm" name="add-sickhistory-btn">
					<i class="glyphicon glyphicon-plus icon-white"></i>
				</button>
			</th>
			<td id="sickhistory">
				<?php
				if(isset($interviews) and $medical_history = Model_Interview::json_convert($interviews->medical_history))
				{
				foreach($medical_history as $k => $v)
				{
				?>
					<div class="sickhistory-block">
						<div class="input-group">
							<div class="input-group-addon">病名</div>
							<input type="text" name="medical_history[<?php echo $k ?>][name]" value="<?php echo $v['name']; ?>" class="name form-control" size="50" maxlength="100">
						</div>
						<div class="input-group">
							<input type="text" name="medical_history[<?php echo $k ?>][year]" value="<?php echo $v['year']; ?>"  class="year form-control" size="5">
							<div class="input-group-addon">年前</div>
						</div>
						<button type="button" class="btn btn-danger btn-sm" name="remove-btn">
							<i class="glyphicon glyphicon-trash icon-white"></i>
						</button>
						<label id="medical_history[<?php echo $k; ?>][year]-error" class="error" for="medical_history[<?php echo $k; ?>][year]"></label>
						<p></p>
					</div>
				<?php
				}
				}
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">
				手術歴
				<button type="button" class="btn btn-success btn-sm" name="add-opehistory-btn">
					<i class="glyphicon glyphicon-plus icon-white"></i>
				</button>
			</th>
			<td id="opehistory">
				<?php
				if(isset($interviews) and $surgical_history = Model_Interview::json_convert($interviews->surgical_history))
				{
				foreach($surgical_history as $k => $v)
				{
				?>
					<div class="opehistory-block">
						<div class="input-group">
							<div class="input-group-addon">病名</div>
							<input type="text" name="surgical_history[<?php echo $k; ?>][name]" value="<?php echo $v['name'] ?>" class="name form-control" size="50" maxlength="100">
						</div>
						<div class="input-group">
							<input type="text" name="surgical_history[<?php echo $k; ?>][year]"  value="<?php echo $v['year'] ?>"  class="year form-control" size="5">
							<div class="input-group-addon">年前</div>
						</div>
						<button type="button" class="btn btn-danger btn-sm" name="remove-btn">
							<i class="glyphicon glyphicon-trash icon-white"></i>
						</button>
						<label id="surgical_history[<?php echo $k; ?>][year]-error" class="error" for="surgical_history[<?php echo $k; ?>][year]"></label>
						<p></p>
					</div>
				<?php
				}
				}
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">勤務形態(平日)</th>
			<td>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('working_arrangements[]','1', (isset($interviews) and substr_count($interviews->working_arrangements,'1')) ? true : false)
					?>
					月</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('working_arrangements[]','2', (isset($interviews) and substr_count($interviews->working_arrangements,'2')) ? true : false)
					?>
					火</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('working_arrangements[]','3', (isset($interviews) and substr_count($interviews->working_arrangements,'3')) ? true : false)
					?>
					水</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('working_arrangements[]','4', (isset($interviews) and substr_count($interviews->working_arrangements,'4')) ? true : false)
					?>
					木</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('working_arrangements[]','5', (isset($interviews) and substr_count($interviews->working_arrangements,'5')) ? true : false)
					?>
					金</label>
				<span class="text-info">※平日と週末祝祭を合わせていずれか必須</span>
				<label id="working_arrangements[]-error" class="error" for="working_arrangements[]"></label>
				<p></p>
				(
				<label class="radio-inline">
					<?php
					echo Form::radio('night_shift_allowed', '1', (isset($interviews) and $interviews->night_shift_allowed == 1) ? true : false);
					?>
					夜勤可</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('night_shift_allowed', '2', (isset($interviews) and $interviews->night_shift_allowed == 2) ? true : false);
					?>
					夜勤不可</label>
				<span class="text-info">※いずれか必須</span>
				<label id="night_shift_allowed-error" class="error" for="night_shift_allowed"></label>
				)
				<?php

				echo \Fuel\Core\Form::input('start_time_hh',isset($interviews->start_time) ? Utility::explode_hh_mm($interviews->start_time)[0] : '',array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeholder' => 'HH'));
				?>
				:
				<?php
				echo \Fuel\Core\Form::input('start_time_mm',isset($interviews->start_time) ? Utility::explode_hh_mm($interviews->start_time)[1] : '',array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeholder' => 'MM'));
				?>
				～
				<?php
				echo \Fuel\Core\Form::input('end_time_hh',isset($interviews->end_time) ? Utility::explode_hh_mm($interviews->end_time)[0] : '',array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeholder' => 'HH'));
				?>
				:
				<?php
				echo \Fuel\Core\Form::input('end_time_mm',isset($interviews->end_time) ? Utility::explode_hh_mm($interviews->end_time)[1] : '',array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeholder' => 'MM'));
				?>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('normal_free_time','1',(isset($interviews) and $interviews->normal_free_time == 1) ? true : false, array('class' => 'time_free'));
					?>
					時間フリー
				</label>
				<label id="start_end_time-error" class="error" for="start_end_time" style="display: inline-block;">
				</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">勤務形態(週末祝祭)</th>
			<td>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('weekend[]','1',(isset($interviews) and substr_count($interviews->weekend,'1')) ? true : false)
					?>
					土</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('weekend[]','2',(isset($interviews) and substr_count($interviews->weekend,'2')) ? true : false)
					?>
					日</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::checkbox('weekend[]','3',(isset($interviews) and substr_count($interviews->weekend,'3')) ? true : false)
					?>
					祝祭</label>
				<span class="text-info">※平日と週末祝祭を合わせていずれか必須</span>
				<label id="weekend[]-error" class="error" for="weekend[]"></label>
				<p></p>
				(
				<label class="radio-inline">
					<?php
					echo Form::radio('weekend_is', '1',(isset($interviews) and $interviews->weekend_is == 1) ? true : false);
					?>
					夜勤可</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('weekend_is', '2',(isset($interviews) and $interviews->weekend_is == 2) ? true : false);
					?>
					夜勤不可</label>
				<span class="text-info">※いずれか必須</span>
				<label id="weekend_is-error" class="error" for="weekend_is"></label>
				)
				<?php
				echo \Fuel\Core\Form::input('weekend_start_time_hh',isset($interviews->weekend_start_time) ? Utility::explode_hh_mm($interviews->weekend_start_time)[0] : '',array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeholder' => 'HH'));
				?>
				:
				<?php
				echo \Fuel\Core\Form::input('weekend_start_time_mm',isset($interviews->weekend_start_time) ? Utility::explode_hh_mm($interviews->weekend_start_time)[1] : '',array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeholder' => 'MM'));
				?>
				～
				<?php
				echo \Fuel\Core\Form::input('weekend_end_time_hh',isset($interviews->weekend_end_time) ? Utility::explode_hh_mm($interviews->weekend_end_time)[0] : '',array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeholder' => 'HH'));
				?>
				:
				<?php
				echo \Fuel\Core\Form::input('weekend_end_time_mm',isset($interviews->weekend_end_time) ? Utility::explode_hh_mm($interviews->weekend_end_time)[1] : '',array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeholder' => 'MM'));
				?>
				<label class="checkbox-inline">
					<?php
						echo \Fuel\Core\Form::checkbox('holiday_free_time','1',(isset($interviews) and $interviews->holiday_free_time == 1) ? true : false, array('class' => 'time_free'));
					?>
					時間フリー
				</label>
				<label id="weekend_start_end-error" class="error" for="weekend_start_end" style="display: inline-block;">
				</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">勤務可能</th>
			<td>
				<div class="input-group">
					<?php
					echo \Fuel\Core\Form::input('work_possible_week_by_day',\Fuel\Core\Input::post('work_possible_week_by_day',isset($interviews) ? $interviews->work_possible_week_by_day : ''),array('class' => 'form-control', 'size' => '5'));
					?>
					<div class="input-group-addon">日/週</div>
				</div>
				<div class="input-group">
					<?php
					echo \Fuel\Core\Form::input('work_possible_week_by_time',\Fuel\Core\Input::post('work_possible_week_by_time',isset($interviews) ? $interviews->work_possible_week_by_time : ''),array('class' => 'form-control', 'size' => '5'));
					?>
					<div class="input-group-addon">時間(h)/週</div>
				</div>
				<label id="work_possible_week-error" class="error" for="work_possible_week"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">勤務期間</th>
			<td>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::radio('length_of_service','1',(isset($interviews) and $interviews->length_of_service == 1) ? true : false);
					?>
					3～6ヶ月</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::radio('length_of_service','2',(isset($interviews) and $interviews->length_of_service == 2) ? true : false);
					?>
					6ヶ月～1年未満</label>
				<label class="checkbox-inline">
					<?php
					echo \Fuel\Core\Form::radio('length_of_service','3',(isset($interviews) and $interviews->length_of_service == 3) ? true : false);
					?>
					1年以上</label>
				<span class="text-info">※いずれか必須</span>
				<label id="length_of_service-error" class="error" for="length_of_service"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">就労希望日</th>
			<td>
				<?php
					echo \Fuel\Core\Form::input('employment_date',\Fuel\Core\Input::post('employment_date',isset($interviews) ? $interviews->employment_date : ''),array('type' => 'hidden'));
				?>
				<?php
				echo \Fuel\Core\Form::input('employment_date_day',\Fuel\Core\Input::post('employment_date_day',isset($interviews) ? substr($interviews->employment_date,0,10) : ''),array('class' => 'form-control dateform', 'size' => '12'));
				?>
				<?php
				echo \Fuel\Core\Form::input('employment_date_hh',\Fuel\Core\Input::post('employment_date_hh',isset($interviews) ? substr($interviews->employment_date,11,2) : ''),array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeHolder' => 'HH'));
				?>
				:
				<?php
				echo \Fuel\Core\Form::input('employment_date_mm',\Fuel\Core\Input::post('employment_date_mm',isset($interviews) ? substr($interviews->employment_date,14,2) : ''),array('class' => 'form-control', 'size' => '2', 'maxlength' => '2', 'placeHolder' => 'MM'));
				?>
				頃
				<label id="form_employment_date-error" class="error" for="form_employment_date"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">応募媒体</th>
			<td>
				<label class="radio-inline">
					<?php
					echo Form::radio('applicants_media', '1',(isset($interviews) and $interviews->applicants_media == 1) ? true : false);
					?>
					HP</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('applicants_media', '2',(isset($interviews) and $interviews->applicants_media == 2) ? true : false);
					?>
					情報誌</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('applicants_media', '3',(isset($interviews) and $interviews->applicants_media == 3) ? true : false);
					?>
					他</label>
				<span class="text-info">※いずれか必須</span>
				<?php
				echo \Fuel\Core\Form::input('applicants_media_des',\Fuel\Core\Input::post('applicants_media_des',isset($interviews) ? $interviews->applicants_media_des : '' ),array('class' => 'form-control', 'size' => '20', 'maxlength' => '30', 'placeHolder' => '名称(HP/情報誌/その他の媒体名)'));
				?>
				<span class="text-info">※必須</span>
				<label id="applicants_media-error" class="error" for="applicants_media"></label>
				<label id="form_applicants_media_des-error" class="error" for="form_applicants_media_des"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">SSでの職務経験</th>
			<td>
				<label class="radio-inline">
					<?php
					if(isset($interviews))
					{
						echo Form::radio('experience_request', '0',($interviews->experience_request == 0) ? true : false);
					}
					else
					{
						echo Form::radio('experience_request', '0',true);
					}
					?>
					無</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('experience_request', '1',(isset($interviews) and $interviews->experience_request == 1) ? true : false);
					?>
					有</label>
				<div id="experience-block">
					<div class="input-group">
						<?php
						echo \Fuel\Core\Form::input('request_year_before',\Fuel\Core\Input::post('request_year_before',isset($interviews) ? $interviews->request_year_before : ''),array('class' => 'form-control', 'size' => '3'));
						?>
						<div class="input-group-addon">年位前</div>
					</div>
					<label id="form_request_year_before-error" class="error" for="form_request_year_before"></label>
					<div class="input-group">
						<?php
						echo \Fuel\Core\Form::input('request_year',\Fuel\Core\Input::post('request_year',isset($interviews) ? $interviews->request_year : ''),array('class' => 'form-control', 'size' => '3'));
						?>
						<div class="input-group-addon">年</div>
					</div>
					<label id="form_request_year-error" class="error" for="form_request_year"></label>
					<div class="input-group">
						<?php
						echo \Fuel\Core\Form::input('request_month',\Fuel\Core\Input::post('request_month',isset($interviews) ? $interviews->request_month : ''),array('class' => 'form-control', 'size' => '3'));
						?>
						<div class="input-group-addon">ヶ月程度</div>
					</div>
					<label id="form_request_month-error" class="error" for="form_request_month"></label>
					<div class="input-group">
						<?php
						echo \Fuel\Core\Form::input('request_company_name',\Fuel\Core\Input::post('request_company_name',isset($interviews) ? $interviews->request_company_name : ''),array('class' => 'form-control', 'size' => '30', 'maxlength' => '50', 'placeHolder' => '会社名'));
						?>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th class="text-right">普通免許</th>
			<td>
				<label class="radio-inline">
					<?php
					echo Form::radio('normal_license', '1',(isset($interviews) and $interviews->normal_license == 1) ? true : false);
					?>
					なし</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('normal_license', '2',(isset($interviews) and $interviews->normal_license == 2) ? true : false);
					?>
					MT</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('normal_license', '3',(isset($interviews) and $interviews->normal_license == 3) ? true : false);
					?>
					AT</label>
				<span class="text-info">※いずれか必須</span>
				<label id="normal_license-error" class="error" for="normal_license"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">特殊免許</th>
			<td>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('special_license[]', '1',(isset($interviews) and substr_count($interviews->special_license,'1')) ? true : false);
					?>
					大型</label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('special_license[]', '2',(isset($interviews) and substr_count($interviews->special_license,'2')) ? true : false);
					?>
					牽引</label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('special_license[]', '3',(isset($interviews) and substr_count($interviews->special_license,'3')) ? true : false);
					?>
					リフト</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">危険物資格他</th>
			<td>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('other[]', '1',(isset($interviews) and substr_count($interviews->other,'1')) ? true : false);
					?>
					丙</label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('other[]', '2',(isset($interviews) and substr_count($interviews->other,'2')) ? true : false);
					?>
					乙</label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('other[]', '3',(isset($interviews) and substr_count($interviews->other,'3')) ? true : false);
					?>
					甲</label>
				<div class="input-group">
					<div class="input-group-addon">乙保有の場合</div>
					<?php
						$value_other_b = array('' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6');
						echo \Fuel\Core\Form::select('other_b',\Fuel\Core\Input::post('other_b',isset($interviews) ? $interviews->other_b : ''),$value_other_b,array('class' => 'form-control'));
					?>
					<div class="input-group-addon">種</div>
				</div>
			</td>
		</tr>
		<tr>
			<th class="text-right">整備士資格</th>
			<td>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('mechanic_qualification[]', '1',(isset($interviews) and substr_count($interviews->mechanic_qualification,'1')) ? true : false);
					?>
					2級(GD)</label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('mechanic_qualification[]', '2',(isset($interviews) and substr_count($interviews->mechanic_qualification,'2')) ? true : false);
					?>
					3級(SGD)</label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('mechanic_qualification[]', '3',(isset($interviews) and substr_count($interviews->mechanic_qualification,'3')) ? true : false);
					?>
					自動車検査員</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">PC技能</th>
			<td>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('PC[]', '1',(isset($interviews) and substr_count($interviews->PC,'1')) ? true : false);
					?>
					EXCEL</label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('PC[]', '2',(isset($interviews) and substr_count($interviews->PC,'2')) ? true : false);
					?>
					WORD</label>
				<label class="checkbox-inline">
					<?php
					echo Form::checkbox('PC[]', '3',(isset($interviews) and substr_count($interviews->PC,'3')) ? true : false);
					?>
					他</label>
				<?php
				echo \Fuel\Core\Form::input('PC_other',\Fuel\Core\Input::post('PC_other',isset($interviews) ? $interviews->PC_other : ''),array('class' => 'form-control', 'size' => '30', 'maxlength' => '30', 'placeHolder' => 'その他の場合'));
				?>
			</td>
		</tr>
		<tr>
			<th class="text-right">職業</th>
			<td>
				<?php
					$value_occupation = array('' => '', '1' => '高校生', '2' => '大学生', '3' => '専門学校', '4' => '定時/通信制', '5' => 'フリーター', '6' => '主婦', '7' => '会社員', '8' => '自営業', '9' => 'その他');
					echo \Fuel\Core\Form::select('occupation',\Fuel\Core\Input::post('occupation',isset($interviews) ? $interviews->occupation : ''),$value_occupation,array('class' => 'form-control'));
				?>
				<span class="text-info">※いずれか必須</span>
				<?php
					echo \Fuel\Core\Form::input('occupation_other',\Fuel\Core\Input::post('occupation_other',isset($interviews) ? $interviews->occupation_other : ''),array('class' => 'form-control', 'size' => '20', 'placeHolder' => 'その他の場合'));
				?>
				<span class="text-info">※その他を選んだ場合必須</span>
				<label id="form_occupation_other-error" class="error" for="form_occupation_other" style="display: inline-block;"></label>
				<div class="text-info">※一般応募画面と選択項目が異なります</div>
			</td>
		</tr>
		<tr>
			<th class="text-right">募集時給</th>
			<td>
				<div class="input-group">
					<?php
						echo \Fuel\Core\Form::input('wanted_hourly_wage',\Fuel\Core\Input::post('wanted_hourly_wage',isset($interviews) ? $interviews->wanted_hourly_wage : ''),array('class' => 'form-control', 'size' => '5'));
					?>
					<div class="input-group-addon">円</div>
				</div>
				<span class="text-info">※必須</span>
				<label id="form_wanted_hourly_wage-error" class="error" for="form_wanted_hourly_wage"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">雇用保険</th>
			<td>
				<label class="radio-inline">
					<?php
					echo Form::radio('employment_insurance', '1',(isset($interviews) and $interviews->employment_insurance == 1) ? true : false);
					?>
					対象</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('employment_insurance', '2',(isset($interviews) and $interviews->employment_insurance == 2) ? true : false);
					?>
					対象外</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">社会保険</th>
			<td>
				<label class="radio-inline">
					<?php
					echo Form::radio('social_insurance', '1',(isset($interviews) and $interviews->social_insurance == 1) ? true : false);
					?>
					対象</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('social_insurance', '2',(isset($interviews) and $interviews->social_insurance == 2) ? true : false);
					?>
					対象外</label>
			</td>
		</tr>
		<tr>
			<th class="text-right">制服貸与</th>
			<td>
				<div class="input-group">
					<div class="input-group-addon">身長</div>
					<?php
					echo \Fuel\Core\Form::input('height',\Fuel\Core\Input::post('height',isset($interviews) ? $interviews->height : ''),array('class' => 'form-control', 'size' => '5'))
					?>
					<div class="input-group-addon">cm</div>
				</div>
				<label id="form_height-error" class="error" for="form_height"></label>
				<div class="input-group">
					<div class="input-group-addon">W</div>
					<?php
					echo \Fuel\Core\Form::input('weight',\Fuel\Core\Input::post('weight',isset($interviews) ? $interviews->weight : ''),array('class' => 'form-control', 'size' => '5'))
					?>
					<div class="input-group-addon">cm</div>
				</div>
				<label id="form_weight-error" class="error" for="form_weight"></label>
				<div class="input-group">
					<div class="input-group-addon">安全靴</div>
					<?php
					echo \Fuel\Core\Form::input('safety_boots',\Fuel\Core\Input::post('safety_boots',isset($interviews) ? $interviews->safety_boots : ''),array('class' => 'form-control', 'size' => '5'))
					?>
					<div class="input-group-addon">cm</div>
				</div>
				<label id="form_safety_boots-error" class="error" for="form_safety_boots"></label>
				<p></p>
				サイズ：
				<label class="radio-inline">
					<?php
					echo Form::radio('size', '1',(isset($interviews) and $interviews->size == 1) ? true : false);
					?>
					S</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('size', '2',(isset($interviews) and $interviews->size == 2) ? true : false);
					?>
					M</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('size', '3',(isset($interviews) and $interviews->size == 3) ? true : false);
					?>
					L</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('size', '4',(isset($interviews) and $interviews->size == 4) ? true : false);
					?>
					LL</label>
				<label class="radio-inline">
					<?php
					echo Form::radio('size', '5',(isset($interviews) and $interviews->size == 5) ? true : false);
					?>
					3L</label>
				<div class="input-group">
					<div class="input-group-addon">入社時貸出</div>
					<?php
						echo \Fuel\Core\Form::input('the_loan',\Fuel\Core\Input::post('the_loan',isset($interviews) ? $interviews->the_loan : ''),array('class' => 'form-control', 'size' => '5'));
					?>
					<div class="input-group-addon">枚</div>
				</div>
				<label id="form_the_loan-error" class="error" for="form_the_loan"></label>
			</td>
		</tr>
		<tr>
			<th class="text-right">担当者記入</th>
			<td>
				<?php
					echo \Fuel\Core\Form::textarea('notes',\Fuel\Core\Input::post('notes',isset($interviews) ? $interviews->notes : ''),array('class' => 'form-control', 'cols' => '80', 'rows' => '5'));
				?>
				<span class="text-info">※文字数無制限</span>
			</td>
		</tr>
	</table>

	<div class="text-center">
		<button type="submit" class="btn btn-primary btn-sm">
			<i class="glyphicon glyphicon-pencil icon-white"></i>
			保存
		</button>
	</div>
<?php
	echo \Fuel\Core\Form::close();
?>

<div class="hide">
	<div class="sicknow-block">
		<div class="input-group">
			<div class="input-group-addon">病名</div>
			<input type="text" name="anamnesis[1]" class="anamnesis form-control" size="50" maxlength="100">
		</div>
		<button type="button" class="btn btn-danger btn-sm" name="remove-btn">
			<i class="glyphicon glyphicon-trash icon-white"></i>
		</button>
		<label id="anamnesis[1]-error" class="error" for="anamnesis[1]"></label>
		<p></p>
	</div>
	<div class="sickhistory-block">
		<div class="input-group">
			<div class="input-group-addon">病名</div>
			<input type="text" name="medical_history[1][name]" class="name form-control" size="50" maxlength="100">
		</div>
		<div class="input-group">
			<input type="text" name="medical_history[1][year]" class="year form-control" size="5">
			<div class="input-group-addon">年前</div>
		</div>
		<button type="button" class="btn btn-danger btn-sm" name="remove-btn">
			<i class="glyphicon glyphicon-trash icon-white"></i>
		</button>
		<label id="medical_history[1][year]-error" class="error" for="medical_history[1][year]"></label>
		<p></p>
	</div>
	<div class="opehistory-block">
		<div class="input-group">
			<div class="input-group-addon">病名</div>
			<input type="text" name="surgical_history[1][name]" class="name form-control" size="50" maxlength="100">
		</div>
		<div class="input-group">
			<input type="text" name="surgical_history[1][year]" class="year form-control" size="5">
			<div class="input-group-addon">年前</div>
		</div>
		<button type="button" class="btn btn-danger btn-sm" name="remove-btn">
			<i class="glyphicon glyphicon-trash icon-white"></i>
		</button>
		<label id="surgical_history[1][year]-error" class="error" for="surgical_history[1][year]"></label>
		<p></p>
	</div>
</div>

<script>
	$().ready(function() {
			var count_1 = <?php echo (isset($interviews) and $interviews->anamnesis != '[]' and $interviews->anamnesis != '') ? Model_Interview::maxkey_array($interviews->anamnesis) : 0 ?>;
			var count_2 = <?php echo (isset($interviews) and $interviews->medical_history != '[]' and $interviews->medical_history != '') ? Model_Interview::maxkey_array($interviews->medical_history) : 0 ?>;
			var count_3 = <?php echo (isset($interviews) and $interviews->surgical_history != '[]' and $interviews->surgical_history != '') ? Model_Interview::maxkey_array($interviews->surgical_history) : 0 ?>;

			$('div.container').on('click', 'button[name=remove-btn]', function () {
				$(this).parents('div:first').remove();
			});

			$('button[name=add-sicknow-btn]').on('click', function () {
				count_1 = count_1 + 1;
				$('div.hide .sicknow-block:first input').attr('name', 'anamnesis[' + count_1 + ']');
				$('div.hide .sicknow-block:first label.error').attr('for', 'anamnesis[' + count_1 + ']').attr('id','anamnesis['+count_1+']-error');
				$('#sicknow').append(
					$('div.hide .sicknow-block:first').clone()
				);
				$('#form_interview input.anamnesis').each(function(){
					$(this).rules("add", {
						maxlength: 100,
						messages: {
							maxlength: '既往症(治療中)は100文字以内で入力して下さい'
						}
					});
				});
			});

			$('button[name=add-sickhistory-btn]').on('click', function () {
				count_2 = count_2 + 1;
				$('div.hide .sickhistory-block:first input.name').attr('name', 'medical_history[' + count_2 + '][name]');
				$('div.hide .sickhistory-block:first input.year').attr('name', 'medical_history[' + count_2 + '][year]');
				$('div.hide .sickhistory-block:first label.error').attr('id', 'medical_history[' + count_2 + '][year]-error').attr('for','medical_history[' + count_2 + '][year]');
				$('#sickhistory').append(
					$('div.hide .sickhistory-block:first').clone()
				);
				$('#form_interview .sickhistory-block input.year ').each(function(){
					$(this).rules("add", {
						digits :true,
						max: 100,
						messages: {
							digits :'数値のみで入力してください。',
							max: '範囲内の数値を入力してください'
						}
					});
				});
			});

			$('button[name=add-opehistory-btn]').on('click', function () {
				count_3 = count_3 + 1;
				$('div.hide .opehistory-block:first input.name').attr('name', 'surgical_history[' + count_3 + '][name]');
				$('div.hide .opehistory-block:first input.year').attr('name', 'surgical_history[' + count_3 + '][year]');
				$('div.hide .opehistory-block:first label.error').attr('id', 'surgical_history[' + count_3 + '][year]-error').attr('for','surgical_history[' + count_3 + '][year]');
				$('#opehistory').append(
					$('div.hide .opehistory-block:first').clone()
				);
				$('#form_interview .opehistory-block input.year ').each(function(){
					$(this).rules("add", {
						digits :true,
						max: 100,
						messages: {
							digits :'数値のみで入力してください。',
							max: '範囲内の数値を入力してください'
						}
					});
				});
			});

			//Check time free disable choice
			$('input[class=time_free]').on('change', function()
			{
				if ($(this).prop('checked'))
				{
					$(this).parents('td:first').find('input:not(:checkbox)').prop('checked', false);
					$(this).parents('td:first').find('input[type="text"]').prop('value', '');
					$(this).prop('checked', true);
					$(this).parents('td:first').find('input:not(:checkbox)').prop('disabled', true);
					$(this).prop('disabled', false);
				}
				else
				{
					$(this).parents('td:first').find('input').prop('disabled', false);
				}
			}).trigger('change');
		}
	)
</script>
<?php
	echo \Fuel\Core\Asset::js('validate/interview.js');
?>