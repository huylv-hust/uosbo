<?php
namespace job;
use Fuel\Core\Input;

class Controller_Jobs extends \Controller_Uosbo
{
	public function action_index()
	{
		$this->template->title = 'UOS求人システム';
		$data = array();
		$group = new \Model_Mgroups();
		$data['search_group'] = $group->get_type(1);
		$ujob_obj = new \Model_Ujob();
		$data['search_partner'] = $ujob_obj->get_list_partner();
		$where = Input::get('partner_search') != '' ? 'partner_code = "'.Input::get('partner_search').'"' : '';
		$data['search_ss_list'] = $ujob_obj->get_list_ss($where);
		$data['search_media'] = $ujob_obj->get_list_media();
		$data['start_date'] = \Fuel\Core\Input::get('start_date');
		$data['end_date'] = \Fuel\Core\Input::get('end_date');

		if(Input::get('export',false))
		{
			$res = $ujob_obj->get_search_data(true);
			$this->export($res['res']);
		}
		else
		{
			$res = $ujob_obj->get_search_data(false);
		}

		$data['res'] = $res;
		\Session::set('url_job_redirect',\Uri::base().'job/jobs/index/'.(\Uri::segment(4) ? \Uri::segment(4) : 1).'?'.http_build_query(\Input::get()));
		$this->template->content = \Fuel\Core\View::forge('jobs/index',$data);
	}

	private function export($res)
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=job_list_'.date('Ymd').'.csv');
		$contents = array();
		$title = array();
		$fp = fopen('php://output', 'w');
		fputs($fp, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));
		$k = 0 ;
		foreach(\Utility::object_to_array($res) as $row)
		{
			$fields = \Export::field($row);
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
