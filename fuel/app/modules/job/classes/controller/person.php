<?php
namespace Job;

use Fuel\Core\Input;
use Fuel\Core\Uri;
use Fuel\Core\Session;
use Fuel\Core\Response;

/**
 * @author NamNT
 * Class Controller_Persons
 * @package Persons
 */
class Controller_Person extends \Controller_Uosbo
{
    /**
     * @author NamNT
     * action index
     */
    public function action_index()
    {
        $data = array();
        $is_view = array();
        $model = new \Model_Person();
        $employment = new \Model_Employment();
        $model_job = new \Model_Job();
        $model_order = new \Model_Orders();
        $model_user = new \Model_Muser();
        $sssale_id = null;
        $sssale_id_view = null;
        $order_id = null;
        $post_id = null;

        $url = \Fuel\Core\Cookie::get('person_url') ? \Fuel\Core\Cookie::get('person_url') : Uri::base() . 'job/persons';

        $data['url_persons'] = $url;
        $data['person_info'] = null;
        $data['edit_person'] = null;
        $data['post_id'] = null;
        $data['job_id'] = $model_job->get_list_id();
        $data['person_id'] = (\Input::get('person_id'));
        $data['login_info'] = \Fuel\Core\Session::get('login_info');
        $data['listusers_interview'] = array();
        $data['listusers_agreement'] = array();
        $data['listusers_training'] = array();
        $data['listusers_business'] = array();
        $data['order_default']['ss_name'] = '';
        $data['order_default']['media_order']['media_name'] = '';
        if ((\Input::get('order_id'))) {
            $order_id = \Input::get('order_id');
            $od = $model_order->get_order_info($order_id);
            $post_id = $od['post_id'];
            $data['post_id'] = $post_id;

            $data['order'] = $od;
            $data['order']['listusers_interview'] = array();
            $data['order']['listusers_agreement'] = array();
            $data['order']['listusers_training'] = array();
            $data['order']['interview_department_id'] = '';
            $data['order']['agreement_department_id'] = '';
            $data['order']['training_department_id'] = '';
            $data['order'] = $model_user->get_user_info_path($od['interview_user_id'], 'interview', $data['order']);
            $data['order'] = $model_user->get_user_info_path($od['agreement_user_id'], 'agreement', $data['order']);
            $data['order'] = $model_user->get_user_info_path($od['training_user_id'], 'training', $data['order']);
            /*Ticket 1258*/
            $ss_obj_default = new \Model_Mss();
            $media_obj_default = new \Model_Mmedia();
            $ss_info = current($ss_obj_default->get_list_all_ss(array('ss_id' => $od['ss_id'])));
            $data['order_default']['ss_name'] = $ss_info['name'] . ' ' . $ss_info['branch_name'] . ' ' . $ss_info['ss_name'];
            $sssale_obj = new \Model_Sssale();

            $data['order_default']['sssale_ss'] = $sssale_obj->get_sssale_ss($od['ss_id']);
            foreach ($data['order_default']['sssale_ss'] as $key => &$val) {
                if (isset(\Constants::$sale_type[$val['sale_type']]))
                    $val['sale_name'] = \Constants::$sale_type[$val['sale_type']] .' '. $val['sale_name'];
            }
            $data['order_default']['sssale_ss'] = array_column($data['order_default']['sssale_ss'], 'sale_name', 'sssale_id');
            $post_order = \Model_Mpost::find_by_pk($od['post_id']);
            $data['order_default']['post_order'] = $post_order;
            $media_default = $media_obj_default->get_data(array('m_media_id' => $post_order['m_media_id']));
            $data['order_default']['media_order']['media_name'] = $media_default['0']->name . ' ' . $media_default['0']->branch_name . ' ' . $media_default['0']->media_name . ' ' . $media_default['0']->media_version_name;
            $post_obj = new \Model_Mpost();
            $data['order_default']['post_list_order'] = array_column($post_obj->get_list_by_media($post_order['m_media_id']), 'name', 'post_id');
            foreach ($data['order_default']['post_list_order'] as $key => &$val) {
                $val = $media_default['0']->media_name . $val;
            }

        }

        //ticket 1135
        $data['sssale_edit'] = [];
        $data['workplace_sssale_edit'] = [];
        $data['post_edit'] = [];
        if ($person_id = Input::get('person_id')) {
            // Check isset person
            if (!$person_info = \Model_Person::find($person_id)) {
                Session::set_flash('error', 'エーラーに発生しました');
                return Response::redirect($url);
            }
            // Update is_read = 1
            if (!\Model_Person::update_isread($person_id, \Constants::$is_read[1])) {
                Session::set_flash('error', 'エーラーに発生しました');
                return Response::redirect($url);
            }
            $data['edit_person'] = $person_info;
            $data['edit_person']['interview_department_id'] = '';
            $data['edit_person']['agreement_department_id'] = '';
            $data['edit_person']['training_department_id'] = '';
            $data['edit_person']['business_department_id'] = '';
            $data['edit_person']['listusers_interview'] = array();
            $data['edit_person']['listusers_agreement'] = array();
            $data['edit_person']['listusers_training'] = array();
            $data['edit_person']['listusers_business'] = array();
            $data['edit_person'] = $model_user->get_user_info_path($person_info->interview_user_id, 'interview', $data['edit_person']);
            $data['edit_person'] = $model_user->get_user_info_path($person_info->agreement_user_id, 'agreement', $data['edit_person']);
            $data['edit_person'] = $model_user->get_user_info_path($person_info->training_user_id, 'training', $data['edit_person']);
            $data['edit_person'] = $model_user->get_user_info_path($person_info->business_user_id, 'business', $data['edit_person']);
            $data['person_info'] = $data['edit_person'];

            /*if ($edit_data = $person_info->edit_data) {
                $person_info['application_date'] = substr($person_info['application_date'], 0, 16);
                $data['edit_person'] = json_decode($edit_data, true);
                $data['edit_person']['interview_user_id'] = isset($data['edit_person']['interview_user_id']) ? $data['edit_person']['interview_user_id'] : '';
                $data['edit_person']['agreement_user_id'] = isset($data['edit_person']['agreement_user_id']) ? $data['edit_person']['agreement_user_id'] : '';
                $data['edit_person']['training_user_id'] = isset($data['edit_person']['training_user_id']) ? $data['edit_person']['training_user_id'] : '';
                $data['edit_person']['business_user_id'] = isset($data['edit_person']['business_user_id']) ? $data['edit_person']['business_user_id'] : '';
                $data['edit_person']['interview_department_id'] = '';
                $data['edit_person']['agreement_department_id'] = '';
                $data['edit_person']['business_department_id'] = '';
                $data['edit_person']['training_department_id'] = '';
                $data['edit_person']['listusers_interview'] = array();
                $data['edit_person']['listusers_agreement'] = array();
                $data['edit_person']['listusers_training'] = array();
                $data['edit_person']['listusers_business'] = array();
                $data['edit_person'] = $model_user->get_user_info_path($data['edit_person']['interview_user_id'], 'interview', $data['edit_person']);
                $data['edit_person'] = $model_user->get_user_info_path($data['edit_person']['agreement_user_id'], 'agreement', $data['edit_person']);
                $data['edit_person'] = $model_user->get_user_info_path($data['edit_person']['training_user_id'], 'training', $data['edit_person']);
                $data['edit_person'] = $model_user->get_user_info_path($data['edit_person']['business_user_id'], 'business', $data['edit_person']);
                $data['is_view'] = \Utility::compare_json_data($person_info, $edit_data);
            }*/
            //ticket 1135 (thuanth)
            $sssale_obj = new \Model_Sssale();
            $ss_obj = new \Model_Mss();
            $sssale_old = \Model_Sssale::find_by_pk($person_info['sssale_id']);

            //get sssale list for edit
            $sssale_edit = $sssale_obj->get_sssale_ss($sssale_old->ss_id);
            foreach ($sssale_edit as $k => $v) {
                $data['sssale_edit'][$v['sssale_id']] = \Constants::$sale_type[$v['sale_type']] . ' ' . $v['sale_name'];
            }
            //get ss name old (groupname branchname ssname)
            $ss_old = $ss_obj->get_list_all_ss(['ss_id' => $sssale_old->ss_id]);
            $data['ss_name_old'] = !empty($ss_old) ? $ss_old[0]['name'] . ' ' . $ss_old[0]['branch_name'] . ' ' . $ss_old[0]['ss_name'] : '';

            //workplace
            if ($person_info['workplace_sssale_id'] == $person_info['sssale_id']) {
                $data['workplace_ss_name_old'] = $data['ss_name_old'];
                $data['workplace_sssale_edit'] = $data['sssale_edit'];
            } else {
                $workplace_sssale_old = \Model_Sssale::find_by_pk($person_info['workplace_sssale_id']);
                //get sssale list for edit
                $data['workplace_ss_name_old'] = '';
                if ($workplace_sssale_old) {
                    $workplace_sssale_edit = $sssale_obj->get_sssale_ss($workplace_sssale_old->ss_id);
                    foreach ($workplace_sssale_edit as $k => $v) {
                        $data['workplace_sssale_edit'][$v['sssale_id']] = \Constants::$sale_type[$v['sale_type']] . ' ' . $v['sale_name'];
                    }
                    //get ss name old (groupname branchname ssname)
                    $workplace_ss_old = $ss_obj->get_list_all_ss(['ss_id' => $workplace_sssale_old->ss_id]);
                    $data['workplace_ss_name_old'] = !empty($workplace_ss_old) ? $workplace_ss_old[0]['name'] . ' ' . $workplace_ss_old[0]['branch_name'] . ' ' . $workplace_ss_old[0]['ss_name'] : '';
                }


            }

            //media
            if ($person_info['post_id']) {
                $post_obj = new \Model_Mpost();
                $media_obj = new \Model_Mmedia();
                $post_old = \Model_Mpost::find_by_pk($person_info['post_id']);
                //get media name (groupname branchnam medianame)
                $media_old = $media_obj->get_data(['m_media_id' => $post_old->m_media_id]);
                $data['media_name_old'] = $media_old[0]->name . ' ' . $media_old[0]->branch_name . ' ' . $media_old[0]->media_name . ' ' . $media_old[0]->media_version_name;
                $post_edit = $post_obj->get_list_by_media($post_old->m_media_id);
                foreach ($post_edit as $k => $v) {
                    $data['post_edit'][$v['post_id']] = $media_old[0]->media_name . ' ' . $v['name'];
                }
            }
        } else if (Input::method() == 'GET') {
            if (Input::post('application_date_d') == null) {
                $_POST['application_date_d'] = date('Y-m-d');
            }
            if (Input::post('gender') === null) {
                $_POST['gender'] = 0;
            }
        }

        if ($data['edit_person'])
            $sssale_id = $data['edit_person']['sssale_id'];
        if ($data['person_info'])
            $sssale_id_view = $data['person_info']['sssale_id'];

        $data['fixedOrder'] = false;
        if (isset($person_info) && $person_info['order_id']) {
            $_order = $model_order->get_order_info($person_info['order_id']);
            $_employment = $employment->get_data_detail(\Input::get('person_id'));
            if (
                ($_order['status'] == 2 || $_order['status'] == 3) &&
                (isset($_employment['adoption_result']) && (int)$_employment['adoption_result'] > 0)
            ) {
                $data['fixedOrder'] = true;
            }
        }

        if (\Input::method() == 'POST') {
            $datas = array();
            $dataPost = \Input::post();
            $datas = $model->get_person_data($dataPost);

            $action = 'add';

            foreach (\Input::post() as $key => $value) {
                if (\Input::post($key) == '') {
                    $datas[$key] = null;
                }
            }
            $datas['workplace_sssale_id'] = !$datas['workplace_sssale_id'] ? $datas['sssale_id'] : $datas['workplace_sssale_id'];
            $datas['addr1'] = !$datas['addr1'] ? 0 : $datas['addr1'];

            if (!\Model_Sssale::find_by_pk($datas['sssale_id'])) {
                Session::set_flash('error', '売上形態は存在しません');
                return Response::redirect($url);
            }
            if ((\Input::get('person_id'))) {
                $action = 'edit';
                if (!$model = $model->find(\Input::get('person_id'))) {
                    Session::set_flash('error', '応募者は存在しません');
                    return Response::redirect('job/persons');
                }

                /*$model->status = \Constants::$_status_person['pending'];
                $data_temp = Input::post();
                if( ! $data_temp['business_user_id'])
                    $data_temp['business_user_id'] = $this->get_default_business_user_id($data_temp['sssale_id']);

                if( ! $data_temp['interview_user_id'])
                    $data_temp['interview_user_id'] = $this->get_default_business_user_id($data_temp['sssale_id']);

                if( ! $data_temp['agreement_user_id'])
                    $data_temp['agreement_user_id'] = $this->get_default_business_user_id($data_temp['sssale_id']);

                $model->edit_data = json_encode($model->get_person_data($data_temp));*/

                if (!$datas['business_user_id']) {
                    $datas['business_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
                }

                if (!$datas['interview_user_id']) {
                    $datas['interview_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
                }

                if (!$datas['agreement_user_id']) {
                    $datas['agreement_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
                }

                //Default status is approved
                $datas['status'] = \Constants::$_status_person['approval'];
                $model->set($datas);
                if ($model->save()) {
                    Session::set_flash('success', \Constants::$message_create_success);
                    return Response::redirect($url);
                }
            } else {
                $datas['created_at'] = date('Y-m-d H:i:s');
                //Default status is approved
                $datas['status'] = \Constants::$_status_person['approval'];
                if (!$datas['business_user_id']) {
                    $datas['business_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
                }

                if (!$datas['interview_user_id']) {
                    $datas['interview_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
                }

                if (!$datas['agreement_user_id']) {
                    $datas['agreement_user_id'] = $this->get_default_business_user_id($datas['sssale_id']);
                }

                $model->set($datas);
                if ($model->save()) {
                    if ($action == 'add') {
                        $person_obj = $model->find($model->person_id);
                        $sssale_id_mail = $person_obj->sssale_id != '' ? $person_obj->sssale_id : 0;
                        $person_data = $model->get_data_for_mail($sssale_id_mail);
                        if (count($person_data)) {
                            //send mail
                            $model_user = new \Model_Muser();
                            $department_id = ($person_data['0']['department_id']) ? $person_data['0']['department_id'] : 0;
                            $list_email_department = $model_user->get_list_mail_department($department_id);

                            if ($datas['post_id']) {
                                $post = \Model_Mpost::find_by_pk($datas['post_id']);
                                $media = \Model_Mmedia::find_by_pk($post->m_media_id);
                                $partner = \Model_Mpartner::find_by_pk($media->partner_code);
                                $group = \Model_Mgroups::find_by_pk($partner->m_group_id);
                            } else if ($datas['order_id']) {
                                $order = \Model_Orders::find_by_pk($datas['order_id']);
                                $post = \Model_Mpost::find_by_pk($order->post_id);
                                $media = \Model_Mmedia::find_by_pk($post->m_media_id);
                                $partner = \Model_Mpartner::find_by_pk($media->partner_code);
                                $group = \Model_Mgroups::find_by_pk($partner->m_group_id);
                            }
                            $datamail_department = array(
                                'm_group_media' => isset($group) ? $group->name : '',
                                'branch_name_media' => isset($partner) ? $partner->branch_name : '',
                                'application_date' => date('Y-m-d H:i', strtotime($datas['application_date'])),
                                'name_kana' => $datas['name_kana'],
                                'age' => isset($datas['age']) ? $datas['age'] : (isset($datas['birthday']) ? \Utility::calcAge($datas['birthday']) : ''),
                                'gender' => $datas['gender'] == 1 ? '女性' : '男性',
                                'media_name' => isset($media) ? $media->media_name : 'しごさが',
                                'addr1' => $datas['addr1'] ? \Constants::$address_1[$datas['addr1']] : '',
                                'addr2' => $datas['addr2'],
                                'addr3' => $datas['addr3'],
                                'tel' => $datas['tel'],
                                'mobile' => $datas['mobile'],
                                'mail_addr1' => $datas['mail_addr1'],
                                'mail_addr2' => $datas['mail_addr2'],
                                'occupation_now' => $datas['occupation_now'] ? \Constants::$occupation_now[$datas['occupation_now']] : '',
                                'notes' => isset($datas['notes']) ? $datas['notes'] : '',
                                'm_group' => isset($person_data['0']['name']) ? $person_data['0']['name'] : '',
                                'branch_name' => isset($person_data['0']['branch_name']) ? $person_data['0']['branch_name'] : '',
                                'ss_name' => isset($person_data['0']['ss_name']) ? $person_data['0']['ss_name'] : '',
                                'sale_type' => isset($person_data['0']['sale_type']) ? \Constants::$sale_type[$person_data['0']['sale_type']] : '',
                                'sale_name' => isset($person_data['0']['sale_name']) ? $person_data['0']['sale_name'] : '',
                                'list_emails' => $list_email_department,
                                'last_id' => $model->person_id,
                            );
                            $model->sendmail_department($datamail_department);
                        }
                    }

                    Session::set_flash('success', \Constants::$message_create_success);
                } else {
                    Session::set_flash('error', \Constants::$message_create_error);
                }
            }
            return Response::redirect($url);
        }

        $this->template->title = 'UOS求人システム';
        $this->template->content = \View::forge('persons/person', $data);
        //$this->template->content->filtergroup = \Presenter::forge('group/filter')->set('custom', $data_filter);
    }

    /**
     * @author Thuanth6589
     * @return Response
     */
    public function action_check_order()
    {
        $order_id = Input::post('order_id', 0);
        $result = array('message' => false);
        if (\Model_Orders::find_by_pk($order_id))
            $result = array('message' => true);
        return Response::forge(json_encode($result));
    }

    public function action_approval()
    {
        if ($value = Input::post()) {
            $person = new \Model_Person();
            $person_id = $value['person_id'];
            if ($person->approval_person($person_id)) {
                $return = 'success';
                $messege = \Constants::$message_approval_success;
            } else {
                $return = 'error';
                $messege = \Constants::$message_approval_error;
            }
            Session::set_flash($return, $messege);
            Response::redirect(Uri::base() . 'job/persons?' . \Session::get('url_filter_persons'));
        }
        Response::redirect(Uri::base() . 'job/persons');
    }

    public function get_default_business_user_id($sssale_id)
    {
        $business_user_id = 0;
        $sssale_obj = new \Model_Sssale();
        $ss_obj = new \Model_Mss();
        $partner_obj = new \Model_Mpartner();
        $sssale_info = $sssale_obj->get_sssale_info($sssale_id);
        $ss_id = $sssale_info['ss_id'];
        $ss_info = current($ss_obj->get_ss_info($ss_id));
        $partner_code = $ss_info['partner_code'];
        if ($partner_code) {
            $partner_info = $partner_obj->get_list_partner('partner_code ="' . $partner_code . '"');
            $partner_info = $partner_info->as_array();
            $partner_info = current($partner_info);
            $business_user_id = $partner_info['user_id'];
        }

        return $business_user_id;
    }
}
