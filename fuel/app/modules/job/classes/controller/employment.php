<?php
namespace Job;

use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Response;


/**
 * @author NamNT
 * Class Controller_Persons
 * @package Persons
 */
class Controller_Employment extends \Controller_Uosbo
{


    /**
     * @author NamNT
     * action index
     */
    public function action_index()
    {
        $model = new \Model_Employment();
        $person = new \Model_Person();
        $order = new \Model_Orders();
        $person_id = \Input::get('person_id');
        $data = array();

        if (!$person_id) {
            Response::redirect('job/persons');
        }

        if (!$data_person = $person::find($person_id)) {
            Response::redirect('job/persons');
        }

        $data = $model->get_data_detail($person_id);
        //Disabled Employment
        //Ticket #1008
        if ($data && $data_person['order_id']) {
            $data_order = $order->get_order_info($data_person['order_id']);
            if ($data_order && ($data_order['status'] == 2 || $data_order['status'] == 3) && (int)$data['adoption_result'] > 0) {
                $data['disabled'] = 'disabled';
                Session::set_flash('lock', '当該オーダーが確定しているので情報の一部が変更できません。');
            }
        }

        $data['person_id'] = $person_id;
        $application_date = $data_person['application_date'];
        $get_date = getdate(strtotime($application_date));
        if ($get_date['mday'] == '29' and $get_date['mon'] == '2')
            $registration_expiration = date('Y-m-d', strtotime(date('Y-m-d', strtotime($application_date)) . ' + 1 year' . '-1 day'));
        else
            $registration_expiration = date('Y-m-d', strtotime(date('Y-m-d', strtotime($application_date)) . ' + 1 year'));

        $data['reg_expiration'] = $registration_expiration;

        if (\Input::method() == 'POST') {
            $datas = \Input::post();
            foreach ($datas as $key => $value) {
                if (\Input::post($key) == '') {
                    $datas[$key] = null;
                }
            }

            if ($model->find($person_id)) {
                $model = $model->find($person_id);
                $datas['obic7_flag'] = isset($datas['obic7_flag']) ? 1 : 0;
                if ($datas['obic7_flag'] == 1 && $model->obic7_flag != 1) {
                    $datas['obic7_date'] = date('Y-m-d', time());
                }
            } else {
                $datas['person_id'] = $person_id;
                $datas['created_at'] = date('Y-m-d H:i:s');
                if (isset($datas['obic7_flag'])) {
                    $datas['obic7_date'] = date('Y-m-d', time());
                }
            }

            $model->set($datas);
            if ($model->save()) {
                Session::set_flash('success', \Constants::$message_create_success);
                Response::redirect(\Fuel\Core\Uri::base() . 'job/employment?person_id=' . $person_id);
            }
        }

        //ticket 1065 (show group name, branch name, ss name, person name)
        $data['person'] = $data_person;
        $sssale_obj = \Model_Sssale::find_by_pk($data_person['sssale_id']);
        $ss_obj = new \Model_Mss();
        $ss = $ss_obj->get_list_all_ss(['ss_id' => $sssale_obj->ss_id ? $sssale_obj->ss_id : 0]);
        $data['ss_info'] = !empty($ss) ? $ss[0]['name'] . ' ' . $ss[0]['branch_name'] . ' ' . $ss[0]['ss_name'] : '';

        $this->template->title = 'UOS求人システム';
        $this->template->content = \View::forge('employment/index', $data);
    }

    /**
     * author thuanth6589
     */
    public function action_check_employee_code()
    {
        $employee_code = Input::post('employee_code');
        $person_id = Input::post('person_id');
        $model = new \Model_Employment();
        $data = $model->get_data_by_employee_code($employee_code);
        $result['status'] = false;
        if ((!empty($data) && $data[0]['person_id'] == $person_id) || empty($data)) {
            $result['status'] = true;
        }

        return Response::forge(json_encode($result));
    }

    public function action_check_interview_has_data()
    {
        $person_id = Input::post('person_id');
        $result['status'] = false;
        if (\Model_Interviewusami::find_one_by('person_id', $person_id)) {
            $result['status'] = true;
        }

        return Response::forge(json_encode($result));
    }

    public function action_check_emcall_has_data()
    {
        $person_id = Input::post('person_id');
        $result['status'] = false;
        if (\Model_Emcall::find_one_by('person_id', $person_id)) {
            $result['status'] = true;
        }

        return Response::forge(json_encode($result));
    }
}
