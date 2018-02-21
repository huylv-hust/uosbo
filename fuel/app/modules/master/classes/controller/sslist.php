<?php

namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_Sslist
 * @package Master
 */
class Controller_Sslist extends \Controller_Uosbo
{
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action list ss
	 */
	public function action_index()
	{
		$login_info = \Fuel\Core\Session::get('login_info');
		$filters = Input::get();
		if($login_info['division_type'] != 1){
			$filters['is_hidden'] = 0;
		}
		$query_string = empty($filters) ? '' : '?'.http_build_query($filters);
		Session::set('sslist_url', Uri::base().'master/sslist'.$query_string);

		$m_ss = new \Model_Mss();
		$data = array();
        unset($filters['limit']);
		$data['count_ss'] = $m_ss->count_data($filters);
		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => Uri::base().'master/sslist'.$query_string,
			'total_items'    => $data['count_ss'],
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'num_links'      => \Constants::$default_num_links,
			'uri_segment'    => 'page',
			'show_last' => true,
		));

		$filters['offset'] = $pagination->offset;
		$filters['limit'] = $pagination->per_page;
		$data['ss'] = $m_ss->get_data($filters);
		$data['ss_autocomplete'] = $m_ss->get_data(array(), 'autocomplete');
		$data['addr1'] = \Constants::get_search_address();
		$data['filters'] = $filters;
		$data['pagination'] = $pagination;
		$data['login_info'] = $login_info;
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('sslist',$data);
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action export csv
	 */
	public function action_export()
	{
		$filters = Input::get();
		unset($filters['limit']);
		unset($filters['offset']);
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=ss_list_'.date('Ymd').'.csv');
		$fp = fopen('php://output', 'w');
		$m_ss = new \Model_Mss();
		fputs($fp, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));
		fputcsv($fp, $m_ss->header_csv);
		$data = $this->create_data_export($m_ss,$filters);
		foreach ($data as $k => $v) {
			fputcsv($fp, $v);
		}

		fclose($fp);
		exit();
	}

	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * create data to exprot
	 * @param $m_ss
	 * @param $filters
	 * @return array
	 */
	private function create_data_export($m_ss,$filters)
	{
		$data = $m_ss->get_data($filters);
		$result = [];
		$k = 0;
		foreach($data as $obj)
		{
			$result[$k][] = $obj->ss_id;
			$result[$k][] = $obj->partner_code;
			$result[$k][] = $obj->ss_name;
			$result[$k][] = $obj->original_sale;
			$result[$k][] = $obj->base_code;
			$result[$k][] = $obj->zipcode;
			$result[$k][] = \Constants::$address_1[$obj->addr1];
			$result[$k][] = $obj->addr2;
			$result[$k][] = $obj->addr3;
			$result[$k][] = $obj->tel;
			$result[$k][] = $obj->access;
			$result[$k][] = $obj->station_name1;
			$result[$k][] = $obj->station_line1;
			$result[$k][] = $obj->station1;
			$result[$k][] = $obj->station_walk_time1;
			$result[$k][] = $obj->station_name2;
			$result[$k][] = $obj->station_line2;
			$result[$k][] = $obj->station2;
			$result[$k][] = $obj->station_walk_time2;
			$result[$k][] = $obj->station_name3;
			$result[$k][] = $obj->station_line3;
			$result[$k][] = $obj->station3;
			$result[$k][] = $obj->station_walk_time3;
            $result[$k][] = $obj->lat;
            $result[$k][] = $obj->lon;
			$result[$k][] = $obj->notes;
			$user = \Model_Muser::find_one_by('user_id', $obj->user_id);
			$result[$k][] = $user ? $user->name : '';
			$k++;
		}
		return $result;
	}
}
