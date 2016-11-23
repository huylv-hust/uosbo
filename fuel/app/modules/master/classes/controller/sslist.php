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
		$filters = Input::get();
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
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('sslist',$data);
	}
}