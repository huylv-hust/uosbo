<?php
/**
 * Author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * Copyright: SETA- Asia
 * File Class/Controler
 **/
namespace Master;
use Constants;
use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Response;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Fuel\Core\Router;
use Model\Mediate;
use Fuel\Core\Pagination;

class Controller_Partners extends \Controller_Uosbo
{
	public function __construct()
	{
		parent::__construct();
		Session::set('url_filter_partner',http_build_query(\Input::get()));
	}
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: List partner
	 **/
	public function action_index()
	{
		$data = array();
		$partner = new \Model_Mpartner();
		//Get value from form search
		if($filter = Input::get())
		{
			Session::set('url_filter_partner',http_build_query($filter));//Set url filter
		}
        unset($filter['limit']);
		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => Uri::base().'master/partners?'.http_build_query($filter),
			'total_items'    => $partner->count_data($filter),
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'num_links'      => \Constants::$default_num_links,
			'uri_segment'    => 'page',
			'show_last'      => true,
		));
		$filter['offset'] = $pagination->offset;
		$filter['limit'] = $pagination->per_page;

		$data['pagination'] = $pagination;
		$data['filter'] = $filter;
		$data['partners'] = $partner->get_filter_partner($filter);
		$data['partner_autocomplete'] = $partner->get_filter_partner(array(),'autocomplete');
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('partners/index',$data);
	}


}