<?php

class Model_Person extends \Orm\Model
{
    protected static $_table_name = 'person';
    protected static $_primary_key = array('person_id');

    public static $_my_properties = array(
        'name',
        'name_kana',
        'birthday',
        'age',
        'gender',
        'zipcode',
        'addr1',
        'addr2',
        'addr3',
        'tel',
        'mobile',
        'mail_addr1',
        'mail_addr2',
        'occupation_now',
        'repletion',
        'transportation',
        'walk_time',
        'work_type',
        'license1',
        'license2',
        'license3',
        'employment_time',
        'job_career',
        'self_pr',
        'notes',
        'application_date',
        'job_id',
        'order_id',
        'sssale_id',
        'reprinted_via',
        'health',
        'is_failure_existence',
        'failure_existence',
        'memo_1',
        'memo_2',
        'is_country',
        'country',
        'post_id',
        'interview_user_id',
        'agreement_user_id',
        'training_user_id',
        'business_user_id'
    );

    public function count_data($filters = array())
    {
        $query = $this->_where($filters);
        return count($query->execute());
    }

    public function get_filter_person($filter, $condition = '')
    {
        $select = $this->_where($filter, $condition);
        return $select->execute();
    }

    public function _where($filter = array(), $condition = '')
    {
        if ($condition == 'autocomplete') {
            $is_where = DB::select(
                'person.mail_addr1',
                'person.mail_addr2',
                'person.tel',
                'person.mobile',
                'person.addr2',
                'person.addr3',
                'person.name',
                'person.name_kana'
            )->from('person')->join('job', 'LEFT')->on('job.job_id', '=', 'person.job_id');
        } else {
            $is_where = DB::select(
                'person.*',
                DB::expr('person.name as p_name'),
                'employment.contact_result',
                'employment.review_date',
                'employment.review_result',
                'employment.adoption_result',
                'employment.registration_expiration',
                'employment.rank',
                'employment.register_date',
                'employment.contract_date',
                'employment.contract_result',
                'employment.hire_date',
                'employment.work_confirmation',
                'employment.employee_code',
                'employment.obic7_date',
                'employment.code_registration_date',
                'm_ss.ss_name',
                'm_partner.branch_name',
                'job.job_id',
                DB::expr('m_group.name as g_name'),
                'm_partner.department_id',
                'm_user.name',
                'sssale.sale_name',
                'sssale.sale_type',
                array('m_group.name', 'm_group_name'),
                array('sssale2.sale_name', 'job_sale_name'),
                array('m_ss2.ss_name', 'job_ss_name')
            )->from('person')->join('job', 'LEFT')->on('job.job_id', '=', 'person.job_id');
        }

        $is_where->join('sssale', 'LEFT')->on('person.sssale_id', '=', 'sssale.sssale_id');
        $is_where->join('m_ss', 'LEFT')->on('m_ss.ss_id', '=', 'sssale.ss_id');
        $is_where->join('m_partner', 'LEFT')->on('m_partner.partner_code', '=', 'm_ss.partner_code');
        $is_where->join('m_group', 'LEFT')->on('m_partner.m_group_id', '=', 'm_group.m_group_id');
        $is_where->join('employment', 'LEFT')->on('employment.person_id', '=', 'person.person_id');
        $is_where->join('m_user', 'LEFT')->on('person.business_user_id', '=', 'm_user.user_id');
        $is_where->join(array('sssale', 'sssale2'), 'LEFT')->on('job.sssale_id', '=', 'sssale2.sssale_id');
        $is_where->join(array('m_ss', 'm_ss2'), 'LEFT')->on('sssale2.ss_id', '=', 'm_ss2.ss_id');
        $is_where->order_by('person.person_id', 'desc');
        $is_where->group_by('person.person_id');

        // huylv6635 ticket 1465 (get where id)
        if (isset($filter['start_id']) && $filter['start_id'] != '') {
            if (!Utility::check_number($filter['start_id'])) {
                // if start_id is character
                $filter['start_id'] = 9999999999;
            }
            $is_where->where('person.person_id', '>=', $filter['start_id']);
        }

        if (isset($filter['end_id']) && $filter['end_id'] != '') {
            $is_where->where('person.person_id', '<=', $filter['end_id']);
        }

        if (isset($filter['employee_code']) && $filter['employee_code'] != '') {
            $is_where->and_where('employment.employee_code', 'LIKE', '%' . $filter['employee_code'] . '%');
        }

        if (isset($filter['start_obic7_date']) && $filter['start_obic7_date'] != '') {
            $is_where->and_where('employment.obic7_date', '>=', $filter['start_obic7_date']);
        }

        if (isset($filter['end_obic7_date']) && $filter['end_obic7_date'] != '') {
            $is_where->and_where('employment.obic7_date', '<=', $filter['end_obic7_date']);
        }

        if (isset($filter['start_application_date']) && $filter['start_application_date'] != '') {
            $is_where->and_where('person.application_date', '>=', $filter['start_application_date']);
        }

        if (isset($filter['end_application_date']) && $filter['end_application_date'] != '') {
            $is_where->and_where('person.application_date', '<=', $filter['end_application_date'] . ' 23:59:59');
        }

        if (isset($filter['person_name']) && $filter['person_name'] != '') {
            $is_where->and_where(\Fuel\Core\DB::expr('CONCAT(person.name, person.name_kana)'), 'LIKE', '%' . $filter['person_name'] . '%');
        }

        if (isset($filter['obic7_flag']) && $filter['obic7_flag'] != '') {
            $is_where->and_where('employment.obic7_flag', '=', '1');
        }

        if (isset($filter['addr1']) && $filter['addr1'] != '') {
            $is_where->and_where('person.addr1', '=', $filter['addr1']);
        }

        if (isset($filter['addr2']) && $filter['addr2'] != '') {
            $arr_addr = array_filter(preg_split('/\s|\s+|　/', trim($filter['addr2'])));
            $is_where->and_where_open();
            $is_where->and_where_open();
            foreach ($arr_addr as $k => $v) {
                $is_where->where(\Fuel\Core\DB::expr('CONCAT(person.addr2, person.addr3)'), 'like', '%' . $v . '%');
            }

            $is_where->and_where_close();

            $is_where->and_where_close();
        }

        if (isset($filter['status']) && $filter['status'] != '') {
            $is_where->where('person.status', '=', $filter['status']);
        }

        if (isset($filter['email']) && $filter['email'] != '') {
            $is_where->and_where_open();
            $is_where->where('mail_addr1', 'LIKE', '%' . $filter['email'] . '%')
                ->or_where('mail_addr2', 'LIKE', '%' . $filter['email'] . '%');
            $is_where->and_where_close();
        }

        if (isset($filter['name']) && $filter['name'] != '') {
            $filter['name'] = preg_replace('/(?:\s|　)/', '', $filter['name']);
            $is_where->and_where_open();
            $is_where->where(
                \Fuel\Core\DB::expr("REPLACE(REPLACE(person.name, '　', ''), ' ', '')"),
                'LIKE', '%' . $filter['name'] . '%'
            );
            $is_where->or_where(
                \Fuel\Core\DB::expr("REPLACE(REPLACE(person.name_kana, '　', ''), ' ', '')"),
                'LIKE', '%' . $filter['name'] . '%'
            );
            $is_where->and_where_close();
        }

        if (isset($filter['phone']) && $filter['phone'] != '') {
            $is_where->and_where_open();
            $is_where->where('person.tel', 'LIKE', '%' . $filter['phone'] . '%')
                ->or_where('person.mobile', 'LIKE', '%' . $filter['phone'] . '%');
            $is_where->and_where_close();
        }

        if (isset($filter['group_id']) && $filter['group_id'] != '') {
            $is_where->and_where_open();
            $is_where->where('m_partner.m_group_id', '=', $filter['group_id']);
            $is_where->and_where_close();
        }

        if (isset($filter['partner_code']) && $filter['partner_code'] != '') {
            $is_where->and_where_open();
            $is_where->where('m_ss.partner_code', '=', $filter['partner_code']);
            $is_where->and_where_close();
        }

        if (isset($filter['ss_id']) && $filter['ss_id'] != '') {
            $is_where->and_where_open();
            $is_where->where('sssale.ss_id', '=', $filter['ss_id']);
            $is_where->and_where_close();
        }

        if (isset($filter['ss_name']) && $filter['ss_name'] != '') {
            $is_where->and_where_open();
            $is_where->where('ss_name', 'LIKE', '%' . $filter['ss_name'] . '%');
            $is_where->and_where_close();
        }

        if (isset($filter['branch_name']) && $filter['branch_name'] != '') {
            $is_where->and_where_open();
            $is_where->where('branch_name', 'LIKE', '%' . $filter['branch_name'] . '%');
            $is_where->and_where_close();
        }

        if (isset($filter['to_date']) && $filter['to_date'] != '') {
            $filter_date = strtotime($filter['to_date']) + 86399;
            $date_to = date('Y-m-d H:i:s', $filter_date);
        }

        if (isset($filter['from_date']) && isset($filter['to_date']) && $filter['from_date'] != '' && $filter['to_date'] == '') {
            $is_where->and_where_open();
            $is_where->where('application_date', '>=', $filter['from_date']);
            $is_where->and_where_close();
        }

        if (isset($filter['to_date']) && $filter['from_date'] == '' && $filter['to_date'] != '') {
            $is_where->and_where_open();
            $is_where->and_where('application_date', '<=', $date_to);
            $is_where->and_where_close();
        }

        if (isset($filter['from_date']) && $filter['from_date'] != '' && $filter['to_date'] != '') {
            $is_where->and_where_open();
            $is_where->where('application_date', '>=', $filter['from_date']);
            $is_where->and_where('application_date', '<=', $date_to);
            $is_where->and_where_close();
        }

        if (isset($filter['gender']) && $filter['gender'] != '') {
            $is_where->and_where_open();
            $is_where->where('gender', 'IN', $filter['gender']);
            $is_where->and_where_close();
        }

        if (isset($filter['age_from']) && $filter['age_from'] != '' && $filter['age_to'] != '' && isset($filter['age_to'])) {
            $is_where->and_where_open();
            $is_where->where(DB::expr("DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthday, '00-%m-%d'))"), '>=', $filter['age_from']);
            $is_where->where(DB::expr("DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthday, '00-%m-%d'))"), '<=', $filter['age_to']);
            $is_where->and_where_close();
        } elseif (isset($filter['age_from']) && $filter['age_from'] != '' && $filter['age_to'] == '') {
            $is_where->and_where_open();
            $is_where->where(DB::expr("DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthday, '00-%m-%d'))"), '>=', $filter['age_from']);
            $is_where->and_where_close();
        } elseif (isset($filter['age_to']) && $filter['age_to'] != '' && $filter['age_from'] == '') {
            $is_where->and_where_open();
            $is_where->where(DB::expr("DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthday, '00-%m-%d'))"), '<=', $filter['age_to']);
            $is_where->and_where_close();
        }

        $datas = array();
        for ($i = 1; $i <= 3; $i++) {
            $datas['license' . $i] = '';
            if (isset($filter['license' . $i])) {
                $is_where->and_where_open();
                foreach ($filter['license' . $i] as $key => $value) {
                    $datas['license' . $i] .= ',' . $value;
                }
                if (isset($datas['license' . $i]) && $datas['license' . $i] != '') {
                    $x = explode(',', $datas['license' . $i]);
                    unset($x[0]);
                    foreach ($x as $key => $value) {
                        $is_where->or_where(DB::expr('FIND_IN_SET("' . $value . '",license' . $i . ')'));
                    }
                }

                $is_where->and_where_close();
            }
        };

        if (isset($filter['review_result']) && $filter['review_result'] != '') {
            $is_where->and_where_open();
            if (isset($filter['review_result'][0]) && !isset($filter['review_result'][1])) {
                $is_where->where('review_result', '=', 1);
            } elseif (!isset($filter['review_result'][0]) && isset($filter['review_result'][1])) {
                $is_where->where('review_result', '<>', 1);
                $is_where->or_where('review_result', 'is', null);
            } else {
                $is_where->where(DB::expr(1, '=', 1));
            }

            $is_where->and_where_close();
        }

        if (isset($filter['rank']) && $filter['rank'] != '') {
            $is_where->and_where_open();
            $is_where->where('rank', 'IN', $filter['rank']);
            $is_where->and_where_close();
        }

        if (isset($filter['contract_result']) && $filter['contract_result'] != '') {
            $is_where->and_where_open();
            $is_where->where('contract_result', 'IN', $filter['contract_result']);
            if (in_array('0', $filter['contract_result'])) {
                $is_where->or_where('contract_result', 'is', null);
            }
            $is_where->and_where_close();
        }

        if (isset($filter['adoption_result']) && $filter['adoption_result'] != '') {
            $is_where->and_where_open();
            $is_where->where('adoption_result', 'IN', $filter['adoption_result']);
            if (in_array('0', $filter['adoption_result'])) {
                $is_where->or_where('adoption_result', 'is', null);
            }
            $is_where->and_where_close();
        }

        if (isset($filter['user_id']) && $filter['user_id'] != '') {
            $is_where->and_where_open();
            $is_where->where('person.business_user_id', '=', $filter['user_id']);
            $is_where->and_where_close();
        }

        if (isset($filter['department']) && $filter['department'] != '' && $filter['user_id'] == '') {
            $list_user_id = array();
            $model_user = new \Model_Muser();
            $list_users = $model_user->get_list_user_by_departmentid($filter['department']);
            foreach ($list_users as $key => $val) {
                $list_user_id[] = $val['user_id'];
            }

            if (count($list_user_id)) {
                $is_where->and_where_open();
                $is_where->where('m_partner.user_id', 'in', $list_user_id);
                $is_where->and_where_close();
            }
        }

        if (isset($filter['media_name']) && $filter['media_name'] != '') {
            $model_m_media = new \Model_Mmedia();
            $model_m_post = new \Model_Mpost();
            $model_order = new \Model_Orders();

            $media_id_list = $model_m_media->get_media_id_list_by_name($filter['media_name']);
            if (count($media_id_list) == 0) {
                $is_where->and_where_open();
                $is_where->where('person.order_id', '=', '-1');
                $is_where->and_where_close();
                return $is_where;
            }
            foreach ($media_id_list as $key => $value) {
                $media_id_list[$key] = $value['m_media_id'];
            }

            $post_id_list = $model_m_post->get_list_post_id($media_id_list);
            if (count($post_id_list) == 0) {
                $is_where->and_where_open();
                $is_where->where('person.order_id', '=', '-1');
                $is_where->and_where_close();
                return $is_where;
            }
            foreach ($post_id_list as $key => $value) {
                $post_id_list[$key] = $value['post_id'];
            }

            $order_id_list = $model_order->get_order_id_list($post_id_list);
            if (count($order_id_list) == 0) {
                $is_where->and_where_open();
                $is_where->where('person.order_id', '=', '-1');
                $is_where->and_where_close();
                return $is_where;
            }

            foreach ($order_id_list as $key => $value) {
                $order_id_list[$key] = $value['order_id'];
            }

            $is_where->and_where_open();
            $is_where->where('person.order_id', 'in', $order_id_list);
            $is_where->and_where_close();
        }

        if (isset($filter['job_id']) && !empty($filter['job_id'])) {
            $is_where->where('person.job_id', '=', $filter['job_id']);
        }

        if (isset($filter['order_id']) && $filter['order_id']) {
            $is_where->where('person.order_id', '=', $filter['order_id']);
        }

        if (isset($filter['array_person'])) {
            $filter['array_person'] = (empty($filter['array_person'])) ? array(0) : $filter['array_person'];
            $is_where->where('person.person_id', 'in', $filter['array_person']);
        }

        if (array_key_exists('reprinted_via', $filter)) {
            $is_where->where('person.reprinted_via', '=', $filter['reprinted_via']);
        }

        if (isset($filter['sale_type']) && $filter['sale_type']) {
            $sql = 'select sssale_id from sssale where sale_type = ' . $filter['sale_type'];
            $rs = \Fuel\Core\DB::query($sql)->execute();
            $sssale_id = [-1];
            foreach ($rs as $item) {
                $sssale_id[] = $item['sssale_id'];
            }

            $is_where->where('person.sssale_id', 'in', $sssale_id);
        }

        if (isset($filter['limit'])) {
            $is_where->limit($filter['limit']);
        }

        if (isset($filter['offset'])) {
            $is_where->offset($filter['offset']);
        }

        return $is_where;
    }

    public function get_person_data($datas)
    {
        $post = $datas;
        $datas['age'] = isset($datas['age']) ? $datas['age'] : null;
        $datas['birthday'] = isset($datas['birthday']) ? $datas['birthday'] : null;
        $datas['transportation'] = '';
        $datas['work_type'] = '';
        $datas['reprinted_via'] = null;
        $datas['is_failure_existence'] = null;
        $datas['is_country'] = null;
        $datas['application_date'] = null;
        $datas['post_id'] = null;
        $datas['updated_at'] = date('Y-m-d H:i:s');
        $datas['tel'] = $datas['tel_1'] != '' ? $datas['tel_1'] . '-' . $datas['tel_2'] . '-' . $datas['tel_3'] : '';
        $datas['mobile'] = $datas['mobile_1'] != '' ? $datas['mobile_1'] . '-' . $datas['mobile_2'] . '-' . $datas['mobile_3'] : '';
        for ($i = 1; $i <= 3; $i++) {
            $datas['license' . $i] = '';
            if (isset($post['license' . $i])) {
                foreach ($post['license' . $i] as $key => $value) {
                    $datas['license' . $i] .= ',' . $value;
                }

                $datas['license' . $i] .= ',';
            }
        }

        if (isset($post['transportation'])) {
            foreach ($post['transportation'] as $key => $value) {
                $datas['transportation'] .= ',' . $value;
            }

            $datas['transportation'] .= ',';
        }

        if (isset($post['work_type'])) {
            foreach ($post['work_type'] as $key => $value) {
                $datas['work_type'] .= ',' . $value;
            }

            $datas['work_type'] .= ',';
        }

        if (isset($post['reprinted_via'])) {
            $datas['reprinted_via'] = 1;
        }

        if (isset($post['is_failure_existence'])) {
            $datas['is_failure_existence'] = 1;
        }

        if (isset($post['is_country'])) {
            $datas['is_country'] = 1;
        }

        $datas['zipcode'] = $post['zipcode1'] . $post['zipcode2'];
        if ($post['application_date_d'] != '') {
            $datas['application_date'] = $post['application_date_d'] . ' ' . $post['application_date_h'] . ':' . $post['application_date_m'];
        }

        if (isset($post['list_post']) && $post['list_post'] != '') {
            $datas['post_id'] = $post['list_post'];
        }

        if ($post['job_id'] == 0) {
            $datas['job_id'] = null;
        }

        return $datas;
    }

    public function validate()
    {
        if (!$this->validation->input('name')) {
            $this->errors['name'] = '必須です';
        } else {
            if (!preg_match($this->validation->input('name'), '/^[一-龥]+$/')) {
                $this->errors['name'] = '漢字を入力してください';
            }
        }

        if (!$this->validation->input('name_kana')) {
            $this->errors['name_kana'] = '必須です';
        } else {
            if (!preg_match($this->validation->input('name_kana'), '/^[ぁ-ん]+$/')) {
                $this->errors['name_kana'] = 'カナを入力してください';
            }
        }

        if (!$this->validation->input('zipcode1')) {
            $this->errors['zipcode'] = '必須です';
        }

        if (!$this->validation->input('zipcode2')) {
            $this->errors['zipcode'] = '必須です';
        }

        if (strlen($this->validation->input('zipcode1')) != 3 && strlen($this->validation->input('zipcode2')) != 4) {
            $this->errors['zipcode'] = '郵便番号の指定が正しくありません';
        }

        if (!$this->validation->input('addr1')) {
            $this->errors['addr'] = '必須です';
        }

        if (!$this->validation->input('addr2')) {
            $this->errors['addr'] = '必須です';
        }

        if (!$this->validation->input('mobile') || !$this->validation->input('tel')) {
            $this->errors['phone'] = '必須です';
        }

        if ($this->errors) {
            return false;
        }

        return true;
    }

    /**
     * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
     * get person for export result csv
     * @return mixed
     */
    public function get_person_for_result_csv($filters)
    {
        $query = \Fuel\Core\DB::select('person.person_id', 'person.sssale_id', 'sssale.ss_id', 'person.post_id', 'person.reprinted_via', 'm_group.name', 'm_partner.branch_name', 'm_ss.ss_name', 'm_user.department_id', 'm_media.*')->from('person');
        $query->join('sssale', 'left')->on('person.sssale_id', '=', 'sssale.sssale_id');
        $query->join('m_ss', 'left')->on('sssale.ss_id', '=', 'm_ss.ss_id');
        $query->join('m_partner', 'left')->on('m_ss.partner_code', '=', 'm_partner.partner_code');
        $query->join('m_user', 'left')->on('m_user.user_id', '=', 'm_partner.user_id');
        $query->join('m_group', 'left')->on('m_partner.m_group_id', '=', 'm_group.m_group_id');
        $query->join('m_post', 'left')->on('m_post.post_id', '=', 'person.post_id');
        $query->join('m_media', 'left')->on('m_media.m_media_id', '=', 'm_post.m_media_id');
        if (isset($filters['start_date']) && $filters['start_date']) {
            $query->where('person.application_date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date']) && $filters['end_date']) {
            $query->where('person.application_date', '<=', date('Y-m-d 23:59:59', strtotime($filters['end_date'])));
        }

        $query->where('person.order_id', 'is', null);
        $query->where('person.job_id', 'is', null);
        $query->order_by('sssale.ss_id')->order_by('m_post.m_media_id');

        return $query->execute();
    }

    /**
     * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
     * count person for export result csv
     * @param $filters
     * @return mixed
     */
    public function count_person($filters)
    {
        $query = \Fuel\Core\DB::select('employment.review_result', 'employment.contact_result', 'employment.adoption_result')->from('person');
        $query->join('employment', 'left')->on('person.person_id', '=', 'employment.person_id');

        if (isset($filters['person_id'])) {
            $filters['person_id'] = empty($filters['person_id']) ? array(0) : $filters['person_id'];
            $query->where('person.person_id', 'in', $filters['person_id']);
        }

        return $query->execute();
    }

    /**
     * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
     * get list person for top(division = 2)
     * @param array $array_user
     * @return mixed
     */
    public function get_person_division_2($array_user = array())
    {
        $array_user = empty($array_user) ? array(0) : $array_user;
        $query = \Fuel\Core\DB::select('orders.interview_user_id', 'orders.agreement_user_id', 'orders.training_user_id', array('m_partner.user_id', 'partner_user_id'), 'employment.contact_result', 'employment.review_date', 'employment.review_result', 'employment.adoption_result', 'employment.contract_date', 'employment.contract_result', 'employment.hire_date', 'employment.employee_code', 'employment.work_confirmation')->from('person');
        $query->join('employment', 'left')->on('employment.person_id', '=', 'person.person_id');
        $query->join('orders', 'left')->on('person.order_id', '=', 'orders.order_id');
        $query->join('sssale', 'left')->on('sssale.sssale_id', '=', 'person.sssale_id');
        $query->join('m_ss', 'left')->on('sssale.ss_id', '=', 'm_ss.ss_id');
        $query->join('m_partner', 'left')->on('m_ss.partner_code', '=', 'm_partner.partner_code');

        $query->and_where_open();
        $query->where('orders.interview_user_id', 'in', $array_user);
        $query->or_where('orders.agreement_user_id', 'in', $array_user);
        $query->or_where('orders.training_user_id', 'in', $array_user);
        $query->or_where_open();
        $query->where('m_partner.user_id', 'in', $array_user);
        //$query->where('person.order_id', 'is', null);
        $query->or_where_close();
        $query->and_where_close();

        $query->and_where_open();
        $query->or_where('employment.contact_result', '=', null);
        $query->or_where('employment.contact_result', '<', 2);
        $query->and_where_close();

        $query->and_where_open();
        $query->or_where('employment.review_result', '=', null);
        $query->or_where('employment.review_result', '<', 2);
        $query->and_where_close();

        $query->and_where_open();
        $query->or_where('employment.adoption_result', '=', null);
        $query->or_where('employment.adoption_result', '<', 2);
        $query->and_where_close();

        $query->and_where_open();
        $query->or_where('employment.contract_result', '=', null);
        $query->or_where('employment.contract_result', '<', 2);
        $query->and_where_close();

        $query->and_where_open();
        $query->or_where('employment.work_confirmation', '=', null);
        $query->or_where('employment.work_confirmation', '<', 2);
        $query->and_where_close();

        return $query->execute();
    }

    public function get_person_division_3($array_ss_id, $array_person_id)
    {
        if (!count($array_person_id))
            return array();


        $wh = '';
        if (count($array_person_id))
            $wh .= 'person.person_id IN (' . implode(',', $array_person_id) . ')';

        /*if(count($array_ss_id))
            $wh .= ' OR ( person.sssale_id IN ('.implode(',',$array_ss_id).'))';

        $wh = trim($wh, ' OR');*/

        if ($wh) {
            $sql = 'SELECT person.* FROM person '
                . 'LEFT JOIN employment ON (person.person_id = employment.person_id) '
                . 'WHERE ('
                . '(employment.contact_result IS null OR employment.contact_result < 2) AND '
                . '(employment.review_result IS null OR employment.review_result < 2) AND '
                . '(employment.adoption_result IS null OR employment.adoption_result < 2) AND '
                . '(employment.contract_result IS null OR employment.contract_result < 2) AND '
                . '(employment.work_confirmation IS null OR employment.work_confirmation < 2)'
                . ') AND (' . $wh . ')';
            //if($_GET['debug']) echo $sql;
            return Fuel\Core\DB::query($sql)->execute();
        }

        return array();
    }

    /**
     * @param $data
     * @return bool
     */
    public function sendmail_department($data)
    {
        $subject = '【しごさが】新着応募/'. $data['m_group'] . $data['branch_name'] . $data['ss_name'];
        foreach ($data['list_emails'] as $email) {
            if ($email['mail']) {
                $mailto[] = $email['mail'];
            }
        }

        //remove duplicate email
        if (isset($mailto)) {
            array_unique($mailto);
        } else {
            return false;
        }

        return \Utility::sendmail($mailto, $subject, $data, 'email/person_admin');
    }

    public function get_data_for_mail($sssale_id)
    {
        $select = DB::select('m_ss.ss_name', 'm_partner.branch_name', 'sssale.sale_name', 'sssale.sale_type', 'm_group.name', 'm_partner.department_id')->from('sssale');
        $select->join('m_ss', 'INNER')->on('m_ss.ss_id', '=', 'sssale.ss_id');
        $select->join('m_partner', 'INNER')->on('m_partner.partner_code', '=', 'm_ss.partner_code');
        $select->join('m_group', 'INNER')->on('m_group.m_group_id', '=', 'm_partner.m_group_id');
        $select->where('sssale.sssale_id', $sssale_id);
        return $select->execute();
    }

    /**
     * @param $person_id
     * @return bool
     * Set null is value is empty
     */
    public function _set_data_update($data)
    {
        foreach ($data as $k => $v) {
            if ($v == '')
                $data[$k] = null;
        }
        return $data;
    }

    public function approval_person($person_id)
    {
        if (!isset($person_id) || !$person = Model_Person::find($person_id)) {
            Session::set_flash('error', '取引先は存在しません');
            Response::redirect(Uri::base() . 'job/persons?' . \Session::get('url_filter_persons'));
        }
        //Set array partner to save array field
        if ($edit_data = json_decode($person->edit_data, true)) {
            $edit_data = $this->_set_data_update($edit_data);
            $edit_data['status'] = \Constants::$_status_person['approval'];
            $edit_data['edit_data'] = null;
            $person->set($edit_data);
            if ($person->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            $edit_data['status'] = \Constants::$_status_person['approval'];
            $person->set($edit_data);
            if ($person->save()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $order_ids
     * @return object
     */
    public function get_person_ids($order_id)
    {
        $arr_person_id = array();
        $order_id = (int)$order_id;
        $sql = 'SELECT person_id FROM person WHERE order_id = ' . $order_id;
        $rs = Fuel\Core\DB::query($sql)->execute();
        foreach ($rs as $row) {
            $arr_person_id[] = $row['person_id'];
        }

        return $arr_person_id;
    }

    /**
     * @param $person_ids
     * @return object
     */
    public function count_employment_order_id($person_ids)
    {
        $person_ids_list = '-1';
        if (count($person_ids))
            $person_ids_list = implode(',', $person_ids);

        //adoption_result = 1 採用
        $sql = 'SELECT person_id FROM employment WHERE person_id IN(' . $person_ids_list . ') AND  adoption_result = 1';
        return count(Fuel\Core\DB::query($sql)->execute());

    }

    public function delete_data($id)
    {
        $obj = Model_Person::find($id);
        if (count($obj)) {
            return $obj->delete();
        }

        return false;
    }

    /**
     * author HuyLv6635
     * action Update is_read when open edit person
     * @param $id
     * @param $status
     * @return bool
     */
    static function update_isread($id, $status)
    {
        if ($entry = Model_Person::find($id)) {
            $entry->set(['is_read' => $status]);
            return $entry->save();
        }
        return false;
    }
}
