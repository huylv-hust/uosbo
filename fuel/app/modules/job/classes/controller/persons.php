<?php
namespace Job;
use Fuel\Core\Response;
use Fuel\Core\Uri;
use Fuel\Tasks\Session;
use \Model\Person;
use Fuel\Core\Input;
use Fuel\Core\Pagination;


/**
 * @author NamNT
 * Class Controller_Persons
 * @package Persons
 */
class Controller_Persons extends \Controller_Uosbo
{
	public function __construct()
	{
		parent::__construct();
		\Session::set('url_filter_persons',http_build_query(\Input::get()));
	}

	/**
	 * @author NamNT
	 * action index
	 */
	public function action_index()
	{
		$model = new \Model_Person();
		$filter = array();
		$data   = array();

		$data['prefectures'] = \Constants::$address_1;
		$data['prefectures'][''] = '全て';
		ksort($data['prefectures']);
        $data['login_info'] = \Fuel\Core\Session::get('login_info');

        if (Input::get('start_id')) {
            $_GET['start_id'] = mb_convert_kana($_GET['start_id'], 'n', 'utf-8');
        }
        if (Input::get('end_id')) {
            $_GET['end_id'] = mb_convert_kana($_GET['end_id'], 'n', 'utf-8');
        }

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

		unset($filter['limit']);

		if(Input::get('export',false))
		{
			$filter['per_page']  = 100000;
			$download_his = new \Model_Downloadhis();
			$download = array(
				'param'   => json_encode($filter),
				'content' => json_encode(Input::server()),
			);

			$download_his->set_data($download);
			if($download_his->save_data())
				$this->export($model->get_filter_person($filter));
		}

		$config = ['pagination_url' => \Uri::base().'job/persons/index'.$person_url,
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
		$data['listPerson'] = $model->get_filter_person($filter);
		$data['groups'] = (new \Model_Mgroups())->get_type(1);
		$m_media = new \Model_Mmedia();
		$data['media_autocomplete'] = $m_media->get_list_media('media_name');
		$data['person_autocomplete'] = $model->get_filter_person(array(),'autocomplete');
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('persons/persons',$data);
	}

	private function export($res)
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=persons_list_'.date('Ymd').'.csv');
		$contents = array();
		$title = array();
		$fp = fopen('php://output', 'w');
		fputs($fp, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));
		$k = 0 ;

            foreach($res as $row)
            {
                $fields = \Export::person_field($row);
                foreach($fields as $field => $val)
			{
				$title[$k][] = preg_replace('/_[0-9]+$/','',$field);
				$contents[$k][] = $val;
			}

			if($k == 0)
			{
				fputcsv($fp, $title[$k]);
			}

			fputcsv($fp, $contents[$k]);
			++$k;

		}

		fclose($fp);
		exit();
	}
}
