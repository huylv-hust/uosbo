<?php

/**
 * List sssale ajax
 *
 * @author <thuanth6589@seta-asia.com.vn>
 * @date 03/02/2016
 */

namespace Ajax;

use Fuel\Core\Input;

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

	/**
	 * @author <thuanth6589@seta-asia.com.vn>
	 * get ss modal
	 */
	public function action_searchSs()
	{
		if (Input::method() == 'POST')
		{
            $login_info = \Fuel\Core\Session::get('login_info');
            $keyword = Input::post('keyword');
            $filters = [];
            $filters['keyword_modal'] = $keyword;
            /*Check is admin*/
            if($login_info['division_type'] != 1){
                $filters['is_hidden'] = 0;
                $filters['is_hidden_partner'] = 0;
            }

            $ss_list = '';
            if ($order_id = Input::post('order_id')) {
                $data = \Model_Orders::find_by_pk($order_id);
                $ss_list = $data->ss_id.rtrim($data->ss_list, ',');
                $ss_list = explode(',', $ss_list);
                $filters['ss_id_in'] = $ss_list;
            }

            $ss_obj = new \Model_Mss();
            $result = $ss_obj->get_list_all_ss($filters);

            foreach ($result as $key => $val) {
                if ($val['addr1']) {
                    $result[$key]['addr1name'] = \Constants::$address_1[$val['addr1']];
                }
            }

			return new \Response(json_encode($result), 200, array());
		}
	}
}
