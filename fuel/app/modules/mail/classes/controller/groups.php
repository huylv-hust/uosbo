<?php

namespace Mail;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;

/**
 * author thuanth6589
 * Class Controller_Groups
 * @package Mail
 */
class Controller_Groups extends \Controller_Uosbo
{

    /**
     * list mail group
     */
    public function action_index()
    {
        $filters = Input::get();
        $query_string = empty($filters) ? '' : '?' . http_build_query($filters);
        Session::set('url_mail_group_list', Uri::base() . 'mail/groups' . $query_string);
        $mail_group_obj = new \Model_Mailgroup();

        //list mail group
        $total_group = $mail_group_obj->count_data();
        $pagination_group = \Uospagination::forge('pagination', array(
            'pagination_url' => Uri::base() . 'mail/groups' . $query_string,
            'total_items' => $total_group,
            'per_page' => Input::get('limit_group') ? Input::get('limit_group') : \Constants::$default_limit_pagination,
            'num_links' => \Constants::$default_num_links,
            'uri_segment' => 'page_group',
            'show_last' => true,
        ));
        $filters['offset'] = $pagination_group->offset;
        $filters['limit_group'] = $pagination_group->per_page;
        $mail_groups = $mail_group_obj->get_data($filters);

        //list partner not in mail group
        $partner_sales = $mail_group_obj->get_all_partner_sale();
        $arr_partner_mail_group = [];
        foreach($partner_sales as $k => $v) {
            if($v['partner_sales']) {
                $arr_partner_mail_group = array_merge($arr_partner_mail_group, explode(',', trim($v['partner_sales'], ',')));
            }
        }
        $arr_partner_mail_group = array_unique($arr_partner_mail_group);
        $m_partner = new \Model_Mpartner();
        $limit_partner = Input::get('limit_partner') ? Input::get('limit_partner') : \Constants::$default_limit_pagination;
        $offset_partner = Input::get('page_partner') ? $limit_partner * (Input::get('page_partner') - 1) : 0;
        $list_partner_sales = $m_partner->get_partner_sale_not_in_group($arr_partner_mail_group, $limit_partner, $offset_partner);
        $pagination_partner = \Uospagination::forge('pagination_partner', array(
            'pagination_url' => Uri::base() . 'mail/groups' . $query_string,
            'total_items' => $list_partner_sales[0],
            'per_page' => $limit_partner,
            'num_links' => \Constants::$default_num_links,
            'uri_segment' => 'page_partner',
            'show_last' => true,
        ));

        $login_info = Session::get('login_info');

        $this->template->title = 'UOS求人システム';
        $this->template->content = \View::forge('groups/index', compact('mail_groups', 'pagination_group', 'total_group', 'pagination_partner', 'list_partner_sales', 'login_info'));
    }

    /**
     * delete mail group
     * @return mixed
     */
    public function action_delete()
    {
        if (Input::method() == 'POST') {
            $mail_group_id = Input::post('mail_group_id', null);
            $result = 'error';
            if (!$mail_group = \Model_Mailgroup::find_by_pk($mail_group_id)) {
                $message = 'メールグループは存在しません';
            } else {
                $message = \Constants::$message_delete_error;
                if ($mail_group->delete()) {
                    $result = 'success';
                    $message = \Constants::$message_delete_success;
                }
            }
            Session::set_flash($result, $message);
        }
        $url = Session::get('url_mail_group_list') ? Session::get('url_mail_group_list') : Uri::base() . 'mail/groups';
        return Response::redirect($url);
    }
}
