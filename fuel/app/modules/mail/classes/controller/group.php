<?php

namespace Mail;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;

/**
 * author thuanth6589
 * Class Controller_Group
 * @package Mail
 */
class Controller_Group extends \Controller_Uosbo
{
    /**
     * action create/update mail group
     */
    public function action_index()
    {
        $mail_group = new \Model_Mailgroup();
        $mail_group_id = Input::get('mail_group_id');
        //edit
        if ($mail_group_id) {
            if (!$mail_group = \Model_Mailgroup::find_by_pk($mail_group_id)) {
                Session::set_flash('error', 'メールグループは存在しません');
                return Response::redirect(Uri::base() . 'mail/groups');
            }
        }

        //save data
        if (Input::method() == 'POST') {
            $url = Session::get('url_mail_group_list') ? Session::get('url_mail_group_list') : Uri::base() . 'mail/groups';
            $users = Input::post('users', []);
            $save['users'] = !empty($users) ? ',' . implode(',', array_unique($users)) . ',' : '';
            $partner_code = Input::post('partner_code', []);
            $sale_type = Input::post('sale_type');
            $partner_sales = [];
            if (!empty($partner_code)) {
                $partner_sales = [];
                foreach ($partner_code as $k => $v) {
                    $partner_sales[] = $v . '-' . $sale_type[$k];
                }
            }
            $save['partner_sales'] = !empty($partner_sales) ? ',' . implode(',', array_unique($partner_sales)) . ',' : '';
            $save['mail_group_name'] = Input::post('mail_group_name');
            $save['updated_at'] = date('Y-m-d H:i:s');
            $mail_group->is_new(false);
            if (!isset($mail_group_id)) {
                $save['created_at'] = date('Y-m-d H:i:s');
                $mail_group->is_new(true);
            }
            $mail_group->set($save);
            if ($mail_group->save()) {
                Session::set_flash('success', \Constants::$message_create_success);
                return Response::redirect($url);
            }
            Session::set_flash('error', \Constants::$message_create_error);
        }

        $this->template->title = 'UOS求人システム';
        $this->template->content = \View::forge('group/index', compact('mail_group'));
    }
}
