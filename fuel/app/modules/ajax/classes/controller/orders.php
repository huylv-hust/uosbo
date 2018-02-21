<?php

/**
 * List sssale ajax
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 23/10/2015
 */

namespace Ajax;

use Fuel\Core\Input;

class Controller_Orders extends \Controller_Uosbo
{
    public function action_index()
    {
        if (\Input::method() != 'POST') {
            return false;
        }

        $ss_id = \Input::post('ss_id');
        $model = new \Model_Sssale();
        $data['list_sales'] = $model->get_sssale_ss($ss_id);

        $content_type = array(
            'Content-type' => 'application/json',
            'SUCCESS' => 0,
        );
        echo new \Response(json_encode($data), 200, $content_type);

        return false;
    }

    public function action_ssinfo()
    {
        if (\Input::method() != 'POST') {
            return false;
        }

        $ss_id = \Input::post('ss_id');
        $data['ssinfo'] = \Model_Mss::get_ss_info($ss_id);
        $data['addr1'] = null;
        if ($data['ssinfo']) {
            $addr1 = $data['ssinfo'][0]['addr1'];
            $data['addr1'] = isset(\Constants::$address_1[$addr1]) ? \Constants::$address_1[$addr1] : null;
        }

        $content_type = array(
            'Content-type' => 'application/json',
            'SUCCESS' => 0,
        );

        echo new \Response(json_encode($data), 200, $content_type);

        return false;
    }

    public function action_postinfo()
    {
        if (\Input::method() != 'POST') {
            return false;
        }

        $post_id = \Input::post('post_id');
        $data['postcount'] = \Model_Mpost::get_count_by_id($post_id);

        $content_type = array(
            'Content-type' => 'application/json',
            'SUCCESS' => 0,
        );

        echo new \Response(json_encode($data), 200, $content_type);

        return false;
    }

    public function action_worktype()
    {
        if (\Input::method() != 'POST') {
            return false;
        }

        $sssale_id = \Input::post('sssale_id');
        $work_type = trim(\Input::post('work_type'), ',');
        $agreement_type = trim(\Input::post('agreement_type'));
        $status = \Input::post('status');
        $action = \Input::post('action');

        $work_active = array();
        if ($work_type != null) {
            $work_active = explode(',', $work_type);
        }

        $model = new \Model_Sssale();
        $sssale_info = $model->get_sssale_info($sssale_id);

        if ($sssale_info && $agreement_type) {
            echo '<div class="row">
						<div class="col-md-3">
							<label class="checkbox-inline"><input name="work_type[]" value="1" type="checkbox" ';
            if (($status == 2 || $status == 3) && $action != 'copy') {
                echo 'disabled ';
            }

            if ($agreement_type == $sssale_id && in_array(1, $work_active)) {
                echo 'checked';
            }

            echo '>時間フリー</label>
						</div>
						<div class="col-md-3">';
            if ($sssale_info['free_hourly_wage']) {
                echo number_format($sssale_info['free_hourly_wage']) . '円';
            }

            echo '</div>
						<div class="col-md-3">' . $sssale_info['free_recruit_attr'] . '</div>
						<div class="col-md-3">' . \Utility::sssale_start_end_time($sssale_info['free_start_time'], $sssale_info['free_end_time']) . '<input type="text" name="worktype" size="5" style="width:1px;border:none" readonly="readonly" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label class="checkbox-inline"><input name="work_type[]" value="2" type="checkbox" ';
            if (($status == 2 || $status == 3) && $action != 'copy') {
                echo 'disabled ';
            }

            if ($agreement_type == $sssale_id && in_array(2, $work_active)) {
                echo 'checked';
            }

            echo '>時間制約</label>
						</div>
						<div class="col-md-3">';
            if ($sssale_info['constraint_hourly_wage']) {
                echo number_format($sssale_info['constraint_hourly_wage']) . '円';
            }

            echo '</div>
						<div class="col-md-3">' . $sssale_info['constraint_recruit_attr'] . '</div>
						<div class="col-md-3">' . \Utility::sssale_start_end_time($sssale_info['constraint_start_time'], $sssale_info['constraint_end_time']) . '</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label class="checkbox-inline"><input name="work_type[]" value="3" type="checkbox" ';
            if (($status == 2 || $status == 3) && $action != 'copy') {
                echo 'disabled ';
            }

            if ($agreement_type == $sssale_id && in_array(3, $work_active)) {
                echo 'checked';
            }

            echo '>年少者・高校生</label>
						</div>
						<div class="col-md-3">';
            if ($sssale_info['minor_hourly_wage']) {
                echo number_format($sssale_info['minor_hourly_wage']) . '円';
            }

            echo '</div>
						<div class="col-md-3">' . $sssale_info['minor_recruit_attr'] . '</div>
						<div class="col-md-3">' . \Utility::sssale_start_end_time($sssale_info['minor_start_time'], $sssale_info['minor_end_time']) . '</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label class="checkbox-inline"><input name="work_type[]" value="4" type="checkbox" ';
            if (($status == 2 || $status == 3) && $action != 'copy') {
                echo 'disabled ';
            }

            if ($agreement_type == $sssale_id && in_array(4, $work_active)) {
                echo 'checked';
            }

            echo '>夜勤</label>
						</div>
						<div class="col-md-3">';
            if ($sssale_info['night_hourly_wage']) {
                echo number_format($sssale_info['night_hourly_wage']) . '円';
            }

            echo '</div>
						<div class="col-md-3">' . $sssale_info['night_recruit_attr'] . '</div>
						<div class="col-md-3">' . \Utility::sssale_start_end_time($sssale_info['night_start_time'], $sssale_info['night_end_time']) . '</div>
					</div>';
        }

        return false;
    }

    public function get_balance()
    {
        $model = new \Model_Orders();
        $price = $model->calc_balance(\Input::get('date'), \Input::get('ss_id'), \Input::get('exclude_order_id'));
        $result = [
            'price' => $price
        ];

        return new \Response(json_encode($result), 200, ['Content-type' => 'application/json']);
    }

    public function get_cost()
    {
        $ss_list = \Input::get('ss_list');
        $ss_list = trim($ss_list, ',');
        if($ss_list)
            $ss_list = explode(',', $ss_list);
        else
            $ss_list = array();
        $price = \Model_Orders::calc_cost(\Input::get('ss_id'), \Input::get('price'), $ss_list);
        $result = [
            'price' => $price
        ];

        return new \Response(json_encode($result), 200, ['Content-type' => 'application/json']);
    }

    /*Search SS modal*/
    public function action_searchss()
    {

        if (Input::method() != 'POST') {
            return false;
        }
        $login_info = \Fuel\Core\Session::get('login_info');
        $keyword = Input::post('keyword');
        $filters['keyword_modal'] = $keyword;
        /*Check is admin*/
        if($login_info['division_type'] != 1){
            $filters['is_hidden'] = 0;
            $filters['is_hidden_partner'] = 0;
        }

        $ss_obj = new \Model_Mss();
        $result = $ss_obj->get_list_all_ss($filters);
        $arr_data = array();
        $k = 0;
        foreach ($result as $row) {
            $arr_data[$k]['ss_id'] = $row['ss_id'];
            $arr_data[$k]['ss_name'] = $row['ss_name'];
            $arr_data[$k]['name'] = $row['name'];
            $arr_data[$k]['branch_name'] = $row['branch_name'];
            ++$k;
        }
        $content_type = array(
            'Content-type' => 'application/json',
            'SUCCESS' => 0,
        );
        echo new \Response(json_encode($arr_data), 200, $content_type);
        return false;
    }

    /*Seearch Media modal*/
    public function action_searchmedia()
    {
        if (Input::method() != 'POST') {
            return false;
        }
        $login_info = \Fuel\Core\Session::get('login_info');
        $keyword = Input::post('keyword');
        $filters['keyword_modal'] = $keyword;
        /*Check is admin*/
        if($login_info['division_type'] != 1){
            $filters['is_hidden'] = 0;
            $filters['is_hidden_partner'] = 0;
        }
        $media_obj = new \Model_Mmedia();
        $result = $media_obj->get_data($filters);
        $arr_data = array();
        $k = 0;
        foreach ($result as $row) {
            $arr_data[$k]['m_media_id'] = $row->m_media_id;
            $arr_data[$k]['media_name'] = $row->media_name;
            $arr_data[$k]['group_name'] = $row->name;
            $arr_data[$k]['branch_name'] = $row->branch_name;
            $arr_data[$k]['media_version_name'] = $row->media_version_name;
            ++$k;
        }
        $content_type = array(
            'Content-type' => 'application/json',
            'SUCCESS' => 0,
        );
        echo new \Response(json_encode($arr_data), 200, $content_type);
        return false;
    }

}
