<?php
namespace Master;

use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_Medias extends \Controller_Uosbo
{
    private $_partner_type = 2;
    private $_partners = array('' => '全て');

    /**
     * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
     * list media
     */
    public function action_index()
    {
        $login_info = \Fuel\Core\Session::get('login_info');

        $m_partner = new \Model_Mpartner();
        $m_media = new \Model_Mmedia();
        $m_post = new \Model_Mpost();
        $tmp = array('' => 'その他');
        $data['groups'] = $tmp + (new \Model_Mgroups())->get_type(2);
        $data['partners'] = $this->_partners;
        if (Input::get('start_id')) {
            $_GET['start_id'] = mb_convert_kana($_GET['start_id'], 'n', 'utf-8');
        }
        if (Input::get('end_id')) {
            $_GET['end_id'] = mb_convert_kana($_GET['end_id'], 'n', 'utf-8');
        }
        $filters = Input::get();
        if($login_info['division_type'] != 1){
            $filters['is_hidden'] = 0;
        }
        $query_string = empty($filters) ? '' : '?' . http_build_query($filters);
        Session::set('medias_url', Uri::base() . 'master/medias' . $query_string);

        if (isset($filters['m_group_id']) && $filters['m_group_id'])
            $data['partners'] += array_column($m_partner->get_partner_group($filters['m_group_id'], $this->_partner_type), 'branch_name', 'partner_code');


        unset($filters['limit']);
        $data['count_media'] = $m_media->count_data($filters);
        $pagination = \Uospagination::forge('pagination', array(
            'pagination_url' => Uri::base() . 'master/medias' . $query_string,
            'total_items' => $data['count_media'],
            'per_page' => Input::get('limit') ? Input::get('limit') : \Constants::$default_limit_pagination,
            'num_links' => \Constants::$default_num_links,
            'uri_segment' => 'page',
            'show_last' => true,
        ));

        $filters['offset'] = $pagination->offset;
        $filters['limit'] = $pagination->per_page;
        if (Input::get('export', false)) {
            Session::delete('medias_url');
            unset($filters['limit']);
            $medias = $m_media->get_data($filters);
            $this->export($medias);
        } else {
            $medias = $m_media->get_data($filters);
        }
        foreach ($medias as $media) {
            $media->count_post = $m_post->count_by_media_id($media->m_media_id);
        }

        $data['pagination'] = $pagination;
        $data['medias'] = $medias;
        $data['type'] = \Constants::$media_type;
        $data['classification'] = \Constants::get_search_media_classification();
        $data['filters'] = $filters;
        $data['media_autocomplete'] = $m_media->get_list_concat_media();
        $this->template->title = 'UOS求人システム';
        $this->template->content = View::forge('medias', $data);
    }

    /**
     * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
     * list media
     */
    public function action_get_partner()
    {
        $m_group_id = Input::post('m_group_id');
        if (!isset($m_group_id) || $m_group_id == '')
            exit(json_encode($this->_partners));

        $m_partner = new \Model_Mpartner();
        $partners = $this->_partners + array_column($m_partner->get_partner_group($m_group_id, $this->_partner_type), 'branch_name', 'partner_code');
        return Response::forge(json_encode($partners));
    }

    /**
     * @author Namdd6566 <namdd6566@seta-asia.com.vn>
     * export media
     */
    private function export($res)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=media_list_' . date('Ymd') . '.csv');
        $fp = fopen('php://output', 'w');
        fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
        fputcsv($fp, \ExportMedia::get_title(10));
        foreach ($res as $row) {
            $fields = \ExportMedia::field($row);
            fputcsv($fp, $fields);
        }

        fclose($fp);
        exit();
    }
}
