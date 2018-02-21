<?php
namespace job;

use Fuel\Core\Input;
use Fuel\Core\Log;
use Fuel\Core\Response;
use Fuel\Core\Session;

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
        $where = Input::get('partner_search') != '' ? 'partner_code = "' . Input::get('partner_search') . '"' : '';
        $data['search_ss_list'] = $ujob_obj->get_list_ss($where);
        $data['search_media'] = $ujob_obj->get_list_media();
        $data['start_date'] = \Fuel\Core\Input::get('start_date');
        $data['end_date'] = \Fuel\Core\Input::get('end_date');

        if (Input::get('export', false)) {
            set_time_limit(0);
            $statement = $ujob_obj->get_search_data(true);
            if ($statement->rowCount() > 0) {
                $this->export($statement);
            }
        }

        if (Input::get('start_id')) {
            $_GET['start_id'] = mb_convert_kana($_GET['start_id'], 'n', 'utf-8');
        }
        if (Input::get('end_id')) {
            $_GET['end_id'] = mb_convert_kana($_GET['end_id'], 'n', 'utf-8');
        }

        $res = $ujob_obj->get_search_data(false);
        $data['total'] = 0;
        if (isset($res['paging'])) {
            $data['total'] = $res['paging']->total_items;
        }

        $data['res'] = $res;
        $filters = \Input::get();
        unset($filters['sort_ss_name']);
        unset($filters['sort_sale_type']);
        $query_string = empty($filters) ? '' : http_build_query($filters);
        \Session::set('url_job_redirect', \Uri::base() . 'job/jobs/index/' . (\Uri::segment(4) ? \Uri::segment(4) : 1) . '?' .$query_string);
        $this->template->content = \Fuel\Core\View::forge('jobs/index', $data);
    }

    private function export($statement)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=job_list_' . date('Ymd') . '.csv');
        $fp = fopen('php://output', 'w');
        fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
        $k = 0;

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $contents = array();
            $title = array();
            $fields = \Export::field($row);
            foreach ($fields as $field => $val) {
                $title[] = preg_replace('/_[0-9]+$/', '', $field);
                $contents[] = $val;
            }

            if ($k == 0) {
                fputcsv($fp, $title);
            }

            fputcsv($fp, $contents);
            ++$k;

        }

        fclose($fp);
        exit();
    }

    public function action_approve_all()
    {
        $url = Session::get('url_job_redirect');
        Session::set_flash('class', 'alert-danger');
        Session::set_flash('report', '最低一つレコードを選んでください。');
        if ($job_id = Input::post('ids')) {
            $ujob = new \Model_Ujob();
            if ($ujob->approve_all($job_id)) {
                Session::set_flash('class', 'alert-success');
                Session::set_flash('report', '承認しました。');
            } else {
                Session::set_flash('report', '承認に失敗しました。');
            }
        };

        return Response::redirect($url);
    }

    /**
     * @author HuyLv6635
     * @content Change is_hidden field with input are $job_id and $type
     */
    public function action_visible_hidden_all()
    {
        $url = Session::get('url_job_redirect');
        Session::set_flash('class', 'alert-danger');
        Session::set_flash('report', '最低一つレコードを選んでください。');
        if ($job_id = Input::post('job_id')) {
            $type = Input::post('type-hidden');
            $ujob = new \Model_Ujob();
            if ($ujob->set_hidden('job', 'job_id', $job_id, $type)) {
                Session::set_flash('class', 'alert-success');
                Session::set_flash('report', '完了しました。');
            } else {
                Session::set_flash('report', '失敗しました。');
            }
        };

        return Response::redirect($url);
    }
}
