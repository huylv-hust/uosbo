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
		$login_info = \Fuel\Core\Session::get('login_info');
		//Get value from form search
		if($filter = Input::get())
		{
		    unset($filter['export']);
			Session::set('url_filter_partner',http_build_query($filter));//Set url filter
		}
		if($login_info['division_type'] != 1){
			$filter['is_hidden'] = 0;
		}
        $query_string = empty($filter) ? '' : '?'.http_build_query($filter);

		unset($filter['limit']);
        if(Input::get('export'))
        {
            $download_his = new \Model_Downloadhis();
            $download = array(
                'param'   => json_encode($filter),
                'content' => json_encode(Input::server()),
            );
            $download_his->set_data($download);
            if($download_his->save_data())
            {
                $this->export($partner->get_filter_partner($filter));
            }
        }

		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => Uri::base().'master/partners'.$query_string,
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

    private function export($res)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=partner_list_'.date('Ymd').'.csv');

        $fp = fopen('php://output', 'w');
        fputs($fp, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));

        fputcsv($fp, \Exportpartner::title());
        foreach($res as $row)
        {
            $fields = \Exportpartner::set_data($row);
            fputcsv($fp, $fields);
        }

        fclose($fp);
        exit();
    }
}
