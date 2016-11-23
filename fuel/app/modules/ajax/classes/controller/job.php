<?php

/**
 * List sssale ajax
 *
 * @author <thuanth6589@seta-asia.com.vn>
 * @date 03/02/2016
 */

namespace Ajax;

class Controller_Job extends \Controller_Uosbo
{
	public function action_worktype()
	{
		if (\Input::method() != 'POST')
		{
			echo '';
			die;
		}

		$sssale_id = \Input::post('sssale_id');

		$model = new \Model_Sssale();
		$sssale_info = $model->get_sssale_info($sssale_id);

		if ($sssale_info)
		{
			echo '<div class="row">
						<div class="col-md-3">
							<label class="checkbox-inline">時間フリー</label>
						</div>
						<div class="col-md-3">';
			if ($sssale_info['free_hourly_wage'])
			{
				echo number_format($sssale_info['free_hourly_wage']).'円';
			}

			echo '</div>
						<div class="col-md-3">'.$sssale_info['free_recruit_attr'].'</div>
						<div class="col-md-3">'.\Utility::sssale_start_end_time($sssale_info['free_start_time'], $sssale_info['free_end_time']).'</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label class="checkbox-inline">時間制約</label>
						</div>
						<div class="col-md-3">';
			if ($sssale_info['constraint_hourly_wage'])
			{
				echo number_format($sssale_info['constraint_hourly_wage']).'円';
			}

			echo '</div>
						<div class="col-md-3">'.$sssale_info['constraint_recruit_attr'].'</div>
						<div class="col-md-3">'.\Utility::sssale_start_end_time($sssale_info['constraint_start_time'], $sssale_info['constraint_end_time']).'</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label class="checkbox-inline">年少者・高校生</label>
						</div>
						<div class="col-md-3">';
			if ($sssale_info['minor_hourly_wage'])
			{
				echo number_format($sssale_info['minor_hourly_wage']).'円';
			}

			echo '</div>
						<div class="col-md-3">'.$sssale_info['minor_recruit_attr'].'</div>
						<div class="col-md-3">'.\Utility::sssale_start_end_time($sssale_info['minor_start_time'], $sssale_info['minor_end_time']).'</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label class="checkbox-inline">夜勤</label>
						</div>
						<div class="col-md-3">';
			if ($sssale_info['night_hourly_wage']) {
				echo number_format($sssale_info['night_hourly_wage']).'円';
			}

			echo '</div>
						<div class="col-md-3">'.$sssale_info['night_recruit_attr'].'</div>
						<div class="col-md-3">'.\Utility::sssale_start_end_time($sssale_info['night_start_time'], $sssale_info['night_end_time']).'</div>
					</div>';
		}

		echo '';
		die;
	}
}