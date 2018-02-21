<?php

/**
 * List function
 *
 * @author NamDD <namdd6566@seta-asia.com.vn>
 * @date 2/06/2015
 */
namespace Ajax;

use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Model;
use Fuel\Core\Response;
use Fuel\Core\Session;


class Controller_Common extends \Controller_Uosbo
{
    /**
     * @author NamDD <namdd6566@seta-asia.com.vn>
     * get info car
     * @return \Response
     */
    public function action_get_ss()
    {
        $group_id = null;
        $partner_code = null;
        if (\Fuel\Core\Input::method() == 'POST') {
            $group_id = \Fuel\Core\Input::post('group_id', null);
            $partner_code = \Fuel\Core\Input::post('partner_code', null);
        } else {
            $group_id = \Fuel\Core\Input::get('group_id', null);
            $partner_code = \Fuel\Core\Input::get('partner_code', null);
        }

        $data = (new \Model_Mss())->get_data(array(
            'group_id' => $group_id,
            'partner_code' => $partner_code
        ))->as_array();

        $res = array();
        if (count($data)) {
            $i = 0;
            foreach ($data as $row) {
                $res[$i]['ss_id'] = $row->ss_id;
                $res[$i]['ss_name'] = $row->ss_name;
                ++$i;
            }
        }

        return new \Response(json_encode($res), 200, array());
    }

    public function action_approved()
    {
        $job_obj = new \Model_Job();
        $job_id = \Fuel\Core\Input::post('job_id');
        $status = \Fuel\Core\Input::post('status');
        $res = $job_obj->approve_data($job_id);
        Session::set_flash('class', 'alert-danger');
        if ($res === true) {
            \Fuel\Core\Session::set_flash('report', '承認しました。');
            Session::set_flash('class', 'alert-success');
        } elseif ($res === 0)
            \Fuel\Core\Session::set_flash('report', '登録データが正しくありません');
        else
            \Fuel\Core\Session::set_flash('report', '承認に失敗しました。');

        return new \Response($res, 200, array());

    }

    public function action_deletejob()
    {
        $job_obj = new \Model_Job();
        $person = new \Model_Person();
        $job_add = new \Model_Jobadd();
        $job_add_recruit = new \Model_Jobrecruit();
        $job_id = \Fuel\Core\Input::post('job_id');
        $check_data = $person->get_filter_person(['job_id' => $job_id]);

        if (count($check_data)) {
            \Fuel\Core\Session::set_flash('report', '関連する応募者データが存在するため削除できません');
            Session::set_flash('class', 'alert-danger');
            return new \Response(1, 200, array());
        }
        DB::start_transaction();
        $res_add = $job_add->delete_data($job_id);
        $res_recruit = $job_add_recruit->delete_data($job_id);
        $res = $job_obj->delete_data($job_id);
        if ($res && $res_add >= 0 && $res_recruit >= 0) {
            DB::commit_transaction();
        } else {
            $res == false;
            DB::rollback_transaction();
        }
        if ($res) {
            \Fuel\Core\Session::set_flash('report', '削除しました。');
            Session::set_flash('class', 'alert-success');
        } else {
            \Fuel\Core\Session::set_flash('report', '削除に失敗しました。');
            Session::set_flash('class', 'alert-danger');
        }
        return new \Response($res, 200, array());
    }

    public function action_deleteperson()
    {

        $person = new \Model_Person();
        $person_id = \Fuel\Core\Input::post('person_id');
        $res = $person->delete_data($person_id);
        if ($res) {
            \Fuel\Core\Session::set_flash('success', '削除しました。');
            Session::set_flash('class', 'alert-success');
        } else {
            \Fuel\Core\Session::set_flash('error', '削除に失敗しました。');
            Session::set_flash('class', 'alert-danger');
        }
        return new \Response(1, 200, array());
    }

    public function action_available()
    {
        $job_obj = new \Model_Job();
        $job_id = \Fuel\Core\Input::post('job_id');
        $is_available = \Fuel\Core\Input::post('is_available');
        Session::set_flash('class', 'alert-danger');
        //check status ss, partner
        if (($job = $job_obj->find_by_pk($job_id)) && $is_available) {
            $ss_id = $job->ss_id;
            $ss = \Model_Mss::find_by_pk($ss_id);
            if (!$ss || !$ss->status) {
                \Fuel\Core\Session::set_flash('report', '指定SSが承認待ちのため公開できません。');
                return new \Response('', 200, array());
            } elseif (!$ss->is_available) {
                \Fuel\Core\Session::set_flash('report', '指定SSが無効のため公開できません。');
                return new \Response('', 200, array());
            }

            $partner_code = $ss->partner_code;
            $partner = \Model_Mpartner::find_by_pk($partner_code);
            if ($partner->status) {
                \Fuel\Core\Session::set_flash('report', '指定取引先が承認待ちのため公開できません。');
                return new \Response('', 200, array());
            }
        }

        $data = array('is_available' => $is_available);
        $res = $job_obj->save_data($data, $job_id);
        \Fuel\Core\Session::set_flash('report', '承認に失敗しました。');
        if ($res) {
            Session::set_flash('class', 'alert-success');
            \Fuel\Core\Session::set_flash('report', $is_available == 0 ? '非公開しました' : '公開しました');
        }

        return new \Response($res, 200, array());
    }

    public function action_webtoku()
    {
        $job_obj = new \Model_Job();
        $job_id = \Fuel\Core\Input::post('job_id');
        $is_webtoku = \Fuel\Core\Input::post('is_webtoku');
        $data = array('is_webtoku' => $is_webtoku);

        $res = $job_obj->save_data($data, $job_id);
        \Fuel\Core\Session::set_flash('report', '失敗しました。');
        if ($res) {
            \Fuel\Core\Session::set_flash('report', $is_webtoku == 0 ? 'WEB得OFFにしました' : 'WEB得ONにしました');
        }

        return new \Response($res, 200, array());
    }

    public function action_changelinkjob()
    {
        $job_id = \Fuel\Core\Input::post('job_id');
        return new \Response(\Utility::encrypt($job_id . ':' . time()) . '||' . $job_id, 200, array());
    }

    public function action_upload_img()
    {
        $order_id = \Fuel\Core\Input::post('order_id');
        $model_order = \Model_Orders::find_by_pk($order_id);
        if (!$model_order) {
            return 'failed';
        }

        $data = array(
            'image_content' => base64_decode(\Fuel\Core\Input::post('content_image', null)),
            'width' => \Fuel\Core\Input::post('width', null),
            'height' => \Fuel\Core\Input::post('height', null),
            'mine_type' => \Fuel\Core\Input::post('mine_type', null),
        );

        $obj_order = new \Model_Orders();
        if ($res = $obj_order->order_update($data, $order_id)) {
            \Fuel\Core\Session::set_flash('success', '媒体画像を登録しました。');
        } else {
            \Fuel\Core\Session::set_flash('error', '媒体画像登録は失敗しました。');
        }

        return new \Response($res, 200, array());
    }

    public function action_get_m_ss_access()
    {
        $ss_id = \Fuel\Core\Input::post('ss_id');
        $model_ss = new \Model_Mss();
        $info_ss = $model_ss->get_ss_info($ss_id);
        return new \Response($info_ss['0']['access'], 200, array());

    }

    public function action_get_partners()
    {
        $group_id = \Fuel\Core\Input::get('group_id');
        $type = \Fuel\Core\Input::get('type');
        $model_partner = new \Model_Mpartner();
        $partners = $model_partner->get_filter_partner(array('group_id' => $group_id, 'type' => $type));

        $response = array();
        foreach ($partners as $partner) {
            $response[$partner['partner_code']] = $partner;
        }

        return new \Response(json_encode($response), 200, array());
    }

    public function get_employee_code()
    {
        $person_id = \Fuel\Core\Input::get('person_id');
        $model_employment = new \Model_Employment();

        $response = array();

        try {
            $response['code'] = $model_employment->get_new_code($person_id);
        } catch (\Exception $ex) {
            $response['code'] = null;
            $response['error'] = $ex->getMessage();
        }

        return new \Response(json_encode($response), 200, array());
    }

    /**
     * set hidden screen job,media,ss,partner
     * @return \Response|void
     */

    public function action_set_hidden()
    {
        $url = Session::get('url_job_redirect');
        $ujob = new \Model_Ujob();
        $type = Input::post('type');
        $table = Input::post('table');
        $name_field = Input::post('name_field');
        $ids = Input::post('ids');
        Session::set_flash('class', 'alert-danger');
        Session::set_flash('report', '最低一つレコードを選んでください。');
        $result = 0;
        if (count($ids)) {
            if ($result = $ujob->set_hidden($table, $name_field, $ids, $type)) {
                Session::set_flash('class', 'alert-success');
                Session::set_flash('report', '完了しました。');
            } else {
                Session::set_flash('report', '失敗しました。');
            }
        }

        if ($table == 'job') {
            return Response::redirect($url);
        }

        return new \Response($result, 200, array());
    }

    /**
     * author HuyLV6635
     * get list address_2 with input is address_1
     * @return Response
     */
    public function action_get_addr2()
    {
        $addr1 = Input::post('addr1');
        $model_ss = new \Model_Mss();
        $addr2 = $model_ss->get_list_addr2(['addr1' => $addr1]);
        $addr2 = array_column($addr2, 'addr2', 'addr2');

        return new Response(json_encode($addr2), 200, array());
    }

    /**
     * @author <thuanth6589@seta-asia.com.vn>
     * get user modal
     */
    public function action_searchUser()
    {
        if (Input::method() == 'POST') {
            $keyword = Input::post('keyword');
            $user_obj = new \Model_Muser();
            $result = $user_obj->get_data_array(['keyword_modal' => $keyword]);
            return new \Response(json_encode($result), 200, array());
        }
    }

    /**
     * @author <thuanth6589@seta-asia.com.vn>
     * get partner modal
     */
    public function action_searchPartner()
    {
        if (Input::method() == 'POST') {
            $filters = Input::all();
            $partner_obj = new \Model_Mpartner();
            $result = $partner_obj->get_filter_partner($filters);
            return new \Response(json_encode($result), 200, array());
        }
    }

    /**
     * @author <thuanth6589@seta-asia.com.vn>
     * get group modal
     * @return \Response
     */
    public function action_searchGroup()
    {
        if (Input::method() == 'POST') {
            $keyword = Input::post('keyword');
            $group_obj = new \Model_Mgroups();
            $result = $group_obj->get_all(null, null, null, 'updated_at', $keyword);
            return new \Response(json_encode($result), 200, array());
        }
    }

    /**
     * @author <thuanth6589@seta-asia.com.vn>
     * get list job for person
     * @return \Response
     */
    public function action_searchJobPerson()
    {
        if (Input::method() == 'POST') {
            $filters = Input::all();
            $job_obj = new \Model_Job();
            $result = $job_obj->get_job_for_person($filters);
            return new \Response(json_encode($result), 200, array());
        }
    }

    /**
     * author HuyLv6635
     * action change is_read
     * @return string
     */
    public function action_updateIsRead () {
        if (Input::method() == 'POST') {
            $id = Input::post('id');
            $result = \Model_Person::update_isread($id, \Constants::$is_read[0]);

            if (!$result) {
                Session::set_flash('error', 'エーラーに発生しました');
            }
            return json_encode($result);
        }
    }

    public function post_clearSavedQuery()
    {
        $result = Session::delete('savedQuery-' . Input::post('uri'));
        return new \Response(json_encode($result), 200, array());
    }
}
