<?php
namespace Job;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Controller_Emcall
 * @package Job
 */
class Controller_Emcall extends \Controller_Uosbo
{
    /**
     * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
     * action create/update emcall
     */
    public function action_index()
    {
        $data['person_id'] = Input::get('person_id');
        $emcall = new \Model_Emcall();

        if (!isset($data['person_id']) || !($data_person = \Model_Person::find($data['person_id']))) {
            Session::set_flash('error', '緊急連絡先は存在しません');
            return Response::redirect('/job/persons');
        }

        Session::set('emcall_url', Uri::current() . '?person_id=' . $data['person_id']);
        if (Input::method() == 'POST') {
            $emcall_id = Input::post('sssale_id', null);
            if ($emcall_id and !$emcall = \Model_Emcall::find_by_pk($emcall_id)) {
                Session::set_flash('error', '緊急連絡先は存在しません');
                return Response::redirect(Session::get('emcall_url'));
            }

            $fields = $emcall->set_data($emcall, Input::post());
            $message = \Constants::$message_create_error;
            if ($emcall->save_data($fields)) {
                Session::set_flash('success', \Constants::$message_create_success);
                return Response::redirect(Session::get('emcall_url'));
            }

            if (!isset($emcall_id))
                $data['action'] = 'add';

            Session::set_flash('error-' . Input::post('panel_index'), $message);
        }

        //ticket 1065 (show group name, branch name, ss name, person name)
        $data['person'] = $data_person;
        $sssale_obj = \Model_Sssale::find_by_pk($data_person['sssale_id']);
        $ss_obj = new \Model_Mss();
        $ss = $ss_obj->get_list_all_ss(['ss_id' => $sssale_obj->ss_id ? $sssale_obj->ss_id : 0]);
        $data['ss_info'] = !empty($ss) ? $ss[0]['name'] . ' ' . $ss[0]['branch_name'] . ' ' . $ss[0]['ss_name'] : '';

        $data['emcalls'] = $emcall->get_data(['person_id' => $data['person_id']]);
        $this->template->title = 'UOS求人システム';
        $this->template->content = View::forge('emcall/index', $data);
    }

    /**
     * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
     * delete emcall
     */
    public function action_delete()
    {
        if (Input::method() == 'POST') {
            $emcall_id = Input::post('emcall_id');
            $result = 'error-' . Input::post('panel_index');
            $message = \Constants::$message_delete_error;
            if (isset($emcall_id) && $emcall = \Model_Emcall::find_by_pk($emcall_id)) {
                if ($emcall->delete_data()) {
                    $result = 'success';
                    $message = \Constants::$message_delete_success;
                }
            }

            Session::set_flash($result, $message);
        }

        $url = (Session::get('emcall_url') ? Session::get('emcall_url') : Uri::base() . 'job/persons');
        return Response::redirect($url);
    }
}