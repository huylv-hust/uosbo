<?php
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_Users
 * @package Master
 */
class Controller_Users extends \Controller_Uosbo
{
	/**
	 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
	 * action list user
	 */
	public function action_index()
	{
		$filters = Input::get();
        unset($filters['export']);
		$query_string = empty($filters) ? '' : '?'.http_build_query($filters);
		Session::set('users_url', Uri::base().'master/users'.$query_string);

		$m_user = new \Model_Muser();
		$data = array();
        unset($filters['limit']);
        // Export CSV
        if(Input::get('export'))
        {
            $download_his = new \Model_Downloadhis();
            $download = array(
                'param'   => json_encode($filters),
                'content' => json_encode(Input::server()),
            );
            $download_his->set_data($download);
            if($download_his->save_data())
            {
                $this->export($m_user->get_data_array($filters));
            }
        }

		$data['count_user'] = $m_user->count_data($filters);
		$pagination = \Uospagination::forge('pagination', array(
			'pagination_url' => Uri::base().'master/users'.$query_string,
			'total_items'    => $data['count_user'],
			'per_page'       => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
			'num_links'      => \Constants::$default_num_links,
			'uri_segment'    => 'page',
			'show_last'      => true,
		));

		$filters['offset'] = $pagination->offset;
		$filters['limit'] = $pagination->per_page;

		$data['filters'] = $filters;
		$data['pagination'] = $pagination;
		$data['department'] = \Constants::get_search_department();
		$data['division_type'] = \Constants::$division_type;
		$data['users'] = $m_user->get_data($filters);
		$data['users_autocomplete'] = $m_user->get_list_users();
		$this->template->title = 'UOS求人システム';
		$this->template->content = View::forge('users',$data);
	}

    /**
     * author HuyLV6635
     * action Export user
     * @param $data
     */
    private function export($data)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=user_list_'.date('Ymd').'.csv');

        $fp = fopen('php://output', 'w');
        fputs($fp, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));

        fputcsv($fp, \Exportuser::title());
        foreach($data as $row)
        {
            $fields = \Exportuser::set_data($row);
            fputcsv($fp, $fields);
        }

        fclose($fp);
        exit();
    }
}
