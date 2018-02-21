<?php

/**
 * Input order class
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 29/05/2015
 */

namespace Job;

use Fuel\Core\Session;

class Controller_Order extends \Controller_Uosbo
{
    /*
     * Input action
     *
     * @since 05/09/2015
     * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
     */
    public function action_index()
    {
        $this->template->title = 'UOS求人システム';

        $order_id = \Input::get('order_id');
        $action = \Input::get('action');

        //presenter group settings
        $datafilter['field'] = array(
            'step' => 3,
            'type' => 1,
            'label' => array(
                'group' => 'グループ',
                'partner' => '取引先(受注先)',
            ),
        );

        $model_orders = new \Model_Orders();
        $model_user = new \Model_Muser();
        $model_post = new  \Model_Mpost();
        $model_ss = new \Model_Mss();
        $data = array();
        $data['remaining_cost'] = 0;
        $data['listusers_sales'] = array();
        $data['listusers_interview'] = array();
        $data['listusers_agreement'] = array();
        $data['listusers_training'] = array();
        $data['listusers_author'] = array();

        $data['info'] = $model_orders->get_order_info($order_id);
        //user logging
        $user_login = Session::get('login_info');
        if ($order_id) {
            if (empty($data['info']['order_id'])) {
                \Response::redirect(\Uri::base() . 'job/orders?lost=true');
            }
            //permision
            /*
            if($action != 'copy' && $data['info']['status'] == 3)
            {
                \Response::redirect(\Uri::base().'job/orders?permission=false');
            }
            *
            */
            //$data = $model_user->get_user_info_path($data['info']['sales_user_id'],'sales',$data);
            $data = $model_user->get_user_info_path($data['info']['author_user_id'], 'author', $data);
            $data = $model_user->get_user_info_path($data['info']['interview_user_id'], 'interview', $data);
            $data = $model_user->get_user_info_path($data['info']['agreement_user_id'], 'agreement', $data);
            $data = $model_user->get_user_info_path($data['info']['training_user_id'], 'training', $data);
            /* Get SS*/
            $data['ss'] = current($model_ss->get_list_all_ss(array('ss_id' => $data['info']['ss_id'])));
            /* Get Post*/
            $data['media'] = array();
            $data['post_same_media'] = array();
            if ($data['info']['post_id']) {
                $data['post_info'] = \Model_Mpost::find_by_pk($data['info']['post_id']);
                if ($data['post_info']['count'])
                    $data['post_info']['count'] = $data['post_info']['count'] - count(explode(',', trim($data['info']['ss_list'], ','))) - 1;

                $data['media'] = \Model_Mmedia::find_by_pk($data['post_info']['m_media_id']);
                $data['partner_edit'] = \Model_Mpartner::find_by_pk($data['media']->partner_code);
                $data['group_edit'] = \Model_Mgroups::find_by_pk($data['partner_edit']->m_group_id);
                $data['post_same_media'] = $model_post->get_list_by_media($data['post_info']['m_media_id']);
            }

            $data['list_ss_edit'] = array();
            if (trim($data['info']['ss_list'], ',')) {
                $list_ss_order_by = explode(',', trim($data['info']['ss_list'], ','));
                $list_ss_edit = $model_ss->get_list_all_ss(array('ss_id_in' => $list_ss_order_by));
                $_arr_list_edit = [];
                /*Order SS*/
                foreach ($list_ss_edit as $_temp) {
                    $_arr_list_edit[$_temp['ss_id']] = $_temp;
                }

                foreach ($list_ss_order_by as $k => $value) {
                    $data['list_ss_edit'][] = $_arr_list_edit[$value];
                }
            }

            /*Get price*/
            $remaining_cost = \Model_Orders::calc_balance($data['info']['apply_date'], $data['info']['ss_id'], $data['info']['order_id']);

            /*Get cost*/
            $ss_list = trim($data['info']['ss_list'], ',');
            if ($ss_list) {
                $ss_list = explode(',', trim($ss_list, ','));
            } else {
                $ss_list = array();
            }
            $cost = \Model_Orders::calc_cost($data['info']['ss_id'], $data['info']['price'], $ss_list);
            $data['remaining_cost'] = $remaining_cost - $cost;

        }

        //get list ss
        $model_ss = new \Model_Mss();
        $data['listss'] = $model_ss->get_list_all_ss();

        $model_group = new \Model_Mgroups();
        $data['listgroup'] = $model_group->get_all();

        $result = 'error';
        $message = '保存に失敗しました。';
        if (\Input::method() == 'POST') {
            if ($order_id && !\Model_Orders::find_by_pk($order_id)) {
                \Session::set_flash($result, 'オーダーは存在しません');
                return \Response::redirect('job/orders');
            }

            $post = \Input::post();
            $check = true;
            $post['ss_list'] = explode(',', trim($post['ss_list'], ','));
            foreach ($post['ss_list'] as $k => $v) {
                if ($v != '' && !\Model_Mss::find_by_pk($v)) {
                    $message = 'SSは存在しません';
                    $check = false;
                    break;
                }
            }

            if (!\Model_Mpost::find_by_pk($post['list_post'])) {
                $message = '媒体は存在しません';
                $check = false;
            }

            if (!\Model_Mss::find_by_pk($post['ss_id'])) {
                $message = 'SSは存在しません';
                $check = false;
            }

            if ($check && $last = $model_orders->order_save($post, $action, $order_id)) {
                if ($order_id == null || $action == 'copy') //send mail when insert
                {
                    $user_id = $user_login['user_id'];
                    $user_info = $model_user->get_user_info($user_id);
                    $department_id = $user_login['department_id'];
                    if ($user_info) {
                        $department_id = $user_info['department_id'];
                    }

                    $list_emails = $model_user->get_list_email_by_departmentid($department_id, $user_id, 99);
                    $maildata = array(
                        'order_id' => $last[0],
                        'department_name' => isset($user_info['department_id']) ? \Constants::$department[$user_info['department_id']] : '',
                        'list_emails' => $list_emails,
                    );
                    $maildata['m_user_name'] = isset($user_info['name']) ? $user_info['name'] : '';
                    $model_orders->sendmail(99, $maildata, $user_id);
                }

                $result = 'success';
                $message = '保存しました';
                \Session::set_flash($result, $message);
                $return_url_search = \Cookie::get('return_url_search');
                if ($return_url_search) {
                    return \Fuel\Core\Response::redirect($return_url_search);
                }

                return \Response::redirect('job/orders');
            }

            \Session::set_flash($result, $message);
        }

        $data['post_id_isset'] = false;
        if ($data['info']['post_id']) {
            if (\Model_Mpost::find_by_pk($data['info']['post_id'])) {
                $data['post_id_isset'] = true;
            }
        }

        $data['properties'] = $model_orders->data_default;
        $this->template->content = \View::forge('orders/input', $data);
        $this->template->content->filtergroup = \Presenter::forge('group/filter')->set('custom', $datafilter);
    }

    public function action_post_date()
    {
        if (\Input::method() != 'POST') {
            return false;
        }

        $post_date = \Input::post('post_date');
        if (!$post_date) $post_date = '0000-00-00';
        $order_id = \Input::post('order_id');
        $data = array('post_date' => $post_date);
        $result = 'error';
        $message = '保存に失敗しました。';
        $model_orders = new \Model_Orders();
        if ($model_orders->order_update($data, $order_id)) {
            $result = 'success';
            $message = '保存しました。';
        }
        \Session::set_flash($result, $message);

        return 'true';

    }

    public function action_get_users()
    {
        if (\Input::method() != 'POST') {
            return false;
        }

        $department_id = \Input::post('department_id');
        $model_user = new \Model_Muser();
        $data['list_user'] = $model_user->get_list_user_by_departmentid($department_id, false, true);

        $content_type = array(
            'Content-type' => 'application/json',
            'SUCCESS' => 0,
        );
        echo new \Response(json_encode($data), 200, $content_type);

        return false;
    }

    public function get_list_ss_by_department($list_ss)
    {
        $list_all_ss = array();
        if ($list_ss) {
            $config['where'][] = array(
                'ss_id',
                'in',
                $list_ss,
            );
            $list_all_ss = \Model_Mss::find($config) ? \Model_Mss::find($config) : array();
        }

        $list_partner_code = array();
        foreach ($list_all_ss as $ss_item) {
            $list_partner_code[] = $ss_item->partner_code;
        }

        $list_all_ss_id = array();
        if ($list_partner_code) {
            $config_partner['where'][] = array(
                'partner_code',
                'in',
                $list_partner_code,
            );
            $list_all_ss_temp = \Model_Mss::find($config_partner);
            foreach ($list_all_ss_temp as $temp) {
                $list_all_ss_id[] = $temp->ss_id;
            }
        }

        return $list_all_ss_id;
    }
}

