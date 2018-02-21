<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace obic7;
use Fuel\Core\Debug;
use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Oil\Exception;

class Controller_Persons extends \Controller_Uosbo
{
	public function action_index()
	{
		$model = new \Model_Person();
		$filter = array();
		$data   = array();

		if(Input::get())
		{
			$filter = Input::get();
			$query_string = http_build_query($filter);
			\Session::set('url_filter_persons',$query_string);
			$person_url = ($query_string) ? '?'.$query_string : '';
		}
		else
		{
			$person_url = '';
		}
		$filter['obic7_flag'] = 1;
        unset($filter['limit']);
		$config = ['pagination_url' => \Uri::base().'obic7/persons/index'.$person_url,
			'total_items'    => $model->count_data($filter),
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'uri_segment'    => 'page',
			'num_links'      => \Constants::$default_num_links,
			'show_last'      => true,
			];

		\Fuel\Core\Cookie::set('person_url',\Uri::main().$person_url, 30 * 60);

		$pagination = \Uospagination::forge('mypagination', $config);
		$filter['offset'] = $pagination->offset;
		$filter['limit']  = $pagination->per_page;
		$data['filters'] = $filter;
		if(Input::get('export',false))
		{
			$download_his = new \Model_Downloadhis();
			$download = array(
				'param'   => json_encode($filter),
				'content' => json_encode(Input::server()),
			);

			$download_his->set_data($download);
			if($download_his->save_data())
			{
				$data['listPerson'] = $model->get_filter_person($filter);
				$arr_file = array();
				for($i = 1; $i < 11; ++$i)
				{
					$arr_file[$i] = \ExportPerson::export($data['listPerson'], $i);
				}

				\ExportPerson::zip_file($arr_file);
			}
		}
		else
		{
			$data['listPerson'] = $model->get_filter_person($filter);
		}
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('persons',$data);
	}
	
	public function action_total()
	{
		$model = new \Model_Person();
		$filter = Input::post();
		$total = $model->count_data($filter);
		return new \Response($total, 200,array());
	}

}