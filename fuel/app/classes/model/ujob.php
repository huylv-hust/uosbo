<?php
/**
 * Ujob class
 * @author NamDD <namdd6566@seta-asia.com.vn>
 * @date 03/09/2015
 */
use Fuel\Core\DB;
use Fuel\Core\Session;


class Model_Ujob
{
    private $validation;
    private $error = array();
    private $job_add;
    private $job_recruit;
    private $job;
    private $m_image;
    private $mpartner;
    private $mss;
    private $sssale;
    private $mmedia;
    private $mgroup;

    function __construct()
    {
        $this->validation = Validation::forge('ujob');
        $this->job = new Model_job();
        $this->job_add = new Model_jobadd();
        $this->job_recruit = new Model_Jobrecruit();
        $this->m_image = new Model_Mimage();
        $this->mpartner = new Model_Mpartner();
        $this->mss = new Model_Mss();
        $this->sssale = new Model_Sssale();
        $this->mmedia = new Model_Mmedia();
        $this->mgroup = new Model_Mgroups();
    }

    public function validate()
    {

    }

    public function get_errors()
    {
        return $this->error;
    }

    public function insert_image($data)
    {
        if (!isset($data['content']))
            return array();

        $data_image_content = $data['content'];
        $data_image_id = $data['m_image_id'];
        $data_image_alt = $data['alt'];
        $data_image_width = $data['width'];
        $data_image_height = $data['height'];
        $data_image_mine_type = $data['mine_type'];
        $res_image = array();
        $data_image = array();
        $res_image_insert = array();
        for ($i = 0; $i < count($data_image_id); ++$i) {
            if ($data_image_id[$i] == '') {
                $data_image[] = array(
                    'm_image_id' => hash('SHA256', base64_decode($data_image_content[$i])),
                    'content' => base64_decode($data_image_content[$i]),
                    'width' => $data_image_width[$i],
                    'height' => $data_image_height[$i],
                    'mine_type' => $data_image_mine_type[$i],
                    'alt' => $data_image_alt[$i],
                );
            } else {
                $res_image[$data_image_id[$i]] = $data_image_alt[$i];
            }
        }

        if (count($data_image)) {
            $res_image_insert = $this->m_image->insert_multi_data($data_image);
            if ($res_image_insert === false)
                return false;
        }

        return array_merge($res_image, $res_image_insert);
    }

    public function insert_data($data, $id)
    {
        $check = true;
        try {
            $res_image = array();
            \DB::start_transaction();

            if (isset($data['content'])) {
                $res_image = $this->insert_image($data);
                if ($res_image === false) {
                    $check = false;
                }
            }

            if ($check) {
                $data['image_list'] = json_encode($res_image);
                $res_job = $this->job->save_data($data, $id);

                if ($id && $res_job === true) // update data
                {
                    $job_id = $id;
                } elseif ($res_job > 0) // insert data
                {
                    $job_id = $res_job;
                } else {
                    $check = false;
                }

                if ($check) {
                    $data_job_add = Utility::set_data_job_add_recruit($data, $job_id);
                    if (count($data_job_add) && !$this->job_add->insert_multi_data($data_job_add, $this->job)) {
                        $check = false;
                    }

                    $data_job_recruit = Utility::set_data_job_add_recruit($data, $job_id, 'job_recruit_sub_title', 'job_recruit_text');
                    if (count($data_job_recruit) && !$this->job_recruit->insert_multi_data($data_job_recruit, $this->job)) {
                        $check = false;
                    }
                }
            }

            if ($check === false) {
                \DB::rollback_transaction();
            } else {
                \DB::commit_transaction();
            }

            // return query result
        } catch (Exception $e) {
            // rollback pending transactional queries
            \DB::rollback_transaction();
            throw $e;
        }

        return $check;
    }

    public function update_data($edit_data, $job_id)
    {

        $res_image = $this->insert_image($edit_data);

        if ($res_image === false)
            return false;

        $edit_data['image_list'] = json_encode($res_image);
        unset($edit_data['content']);
        unset($edit_data['width']);
        unset($edit_data['height']);
        unset($edit_data['mine_type']);
        unset($edit_data['alt']);
        $data['edit_data'] = json_encode($edit_data);
        $data['status'] = 0;
        return $this->job->save_data($data, $job_id);
    }

    public function save_data($data, $id)
    {
        if ($id === '')
            return $this->insert_data($data, $id);

        return $this->update_data($data, $id);
    }

    public function get_info_job($job_id)
    {
        return $this->job->get_info_data($job_id);
    }

    public function get_list_job_add($job_id)
    {
        $config['where'][] = array(
            'job_id',
            '=',
            $job_id,
        );
        return $this->job_add->get_list_data($config);
    }

    public function get_list_job_recruit($job_id)
    {
        $config['where'][] = array(
            'job_id',
            '=',
            $job_id,
        );
        return $this->job_recruit->get_list_data($config);
    }

    public function get_list_m_image($m_image)
    {
        $m_image_id = array();
        $m_image_alt = array();
        $m_image = json_decode($m_image, true);
        $arr_res = array();
        if (count($m_image)) {
            foreach ($m_image as $key => $val) {
                $m_image_id[] = $key;
                $m_image_alt[$key] = $val;
            }

            $config['where'][] = array(
                'm_image_id',
                'IN',
                $m_image_id,
            );

            $res = $this->m_image->get_list_data($config);
            $i = 0;
            foreach ($res as $row) {
                $arr_res[$i]['m_image_id'] = $row['m_image_id'];
                $arr_res[$i]['content'] = base64_encode($row['content']);
                $arr_res[$i]['width'] = $row['width'];
                $arr_res[$i]['height'] = $row['height'];
                $arr_res[$i]['mine_type'] = $row['mine_type'];
                $arr_res[$i]['alt'] = $m_image_alt[$row['m_image_id']];
                ++$i;
            }
        }

        //var_dump($arr_res);
        return $arr_res;
    }

    public function get_list_partner($where = 'type=1')
    {
        return $this->mpartner->get_list_partner($where);
    }

    public function get_list_ss($where)
    {
        return $this->mss->get_list_ss($where);
    }

    public function get_list_sssale($where)
    {
        return $this->sssale->get_list_sssale($where);
    }

    public function get_list_media()
    {
        return $this->mmedia->get_list_media();
    }

    public function get_search_data($export = false)
    {
        $config['where'] = array();
        $config_pagination = array();
        $rs = true;

        // huylv6635 ticket 1465 (get where ID)
        if (\Fuel\Core\Input::get('start_id')) {
            if (!Utility::check_number(\Fuel\Core\Input::get('start_id'))) {
                return array(
                    'res' => array(),
                    'res_ss' => array(),
                    'res_partner' => array(),
                    'res_sssale' => array(),
                );
            }
            $config['where'][] = array(
                'job_id',
                '>=',
                \Fuel\Core\Input::get('start_id'),
            );
        }

        if (\Fuel\Core\Input::get('end_id')) {
            $config['where'][] = array(
                'job_id',
                '<=',
                \Fuel\Core\Input::get('end_id'),
            );
        }

        if (\Fuel\Core\Input::get('media_search', null) != null) {
            $config['where'][] = array(
                'media_list',
                'LIKE',
                '%,' . \Fuel\Core\Input::get('media_search') . ',%',
            );
        }

        if (Fuel\Core\Input::get('group_search', null) != null) {
            $sql = 'select m_ss.ss_id from m_ss
				inner join m_partner on (m_ss.partner_code = m_partner.partner_code)
				where m_partner.m_group_id = :group_id';
            $group_id = Fuel\Core\Input::get('group_search');
            $_array = Fuel\Core\DB::query($sql)->bind('group_id', $group_id)->execute()->as_array();
            $ss_list_id[] = -1;
            foreach ($_array as $row) {
                $ss_list_id[] = $row['ss_id'];
            }

            $config['where'][] = array(
                'ss_id',
                'IN',
                $ss_list_id,
            );
        }

        if (Fuel\Core\Input::get('partner_search')) {
            $ss_list_id = array();
            $list_ss_search = $this->get_list_ss('partner_code="' . Fuel\Core\Input::get('partner_search') . '"');
            $ss_list_id[] = -1;
            foreach ($list_ss_search as $row) {
                $ss_list_id[] = $row['ss_id'];
            }

            $config['where'][] = array(
                'ss_id',
                'IN',
                $ss_list_id,
            );
        }

        if (\Fuel\Core\Input::get('address_1') || \Fuel\Core\Input::get('address_2')) {
            $filter = array(
                'addr_1' => \Fuel\Core\Input::get('address_1', 0),
                'addr_2' => \Fuel\Core\Input::get('address_2', ''),
            );
            $ss_list_id = $this->mss->get_list_ss_addr($filter);
            if (!empty($ss_list_id)) {
                $config['where'][] = array(
                    'ss_id',
                    'IN',
                    $ss_list_id,
                );
            } else {
                $config['where'][] = array(
                    'ss_id',
                    'IN',
                    array(-1),
                );
            }
        }

        if (Fuel\Core\Input::get('ss_search')) {
            $config['where'][] = array(
                'ss_id',
                '=',
                Fuel\Core\Input::get('ss_search'),
            );
        }

        if (\Fuel\Core\Input::get('public_type_1') && \Fuel\Core\Input::get('public_type_2')) {
            $config['where'][] = array(
                'public_type',
                '&9=',
                '9',
            );
        } else {
            if (\Fuel\Core\Input::get('public_type_1')) {
                $config['where'][] = array(
                    'public_type',
                    '&1=',
                    '1',
                );
            }

            if (\Fuel\Core\Input::get('public_type_2')) {
                $config['where'][] = array(
                    'public_type',
                    '&8=',
                    '8',
                );
            }
        }


        if (\Fuel\Core\Input::get('status', null) != null) {
            $config['where'][] = array(
                'status',
                '=',
                \Fuel\Core\Input::get('status'),
            );
        }

        if (\Fuel\Core\Input::get('start_date')) {
            $config['where'][] = array(
                'start_date',
                '>=',
                \Fuel\Core\Input::get('start_date'),
            );
        }

        if (\Fuel\Core\Input::get('end_date')) {
            $config['where'][] = array(
                'end_date',
                '<=',
                \Fuel\Core\Input::get('end_date'),
            );
        }

        if (\Fuel\Core\Input::get('is_available', null) != null) {
            $config['where'][] = array(
                'is_available',
                '=',
                \Fuel\Core\Input::get('is_available'),
            );
        }

        if (\Fuel\Core\Input::get('department_id', null) != null) {
            $sql = 'select m_ss.ss_id from m_ss
				inner join m_partner on (m_ss.partner_code = m_partner.partner_code)
				where m_partner.department_id = :department_id';
            $department_id = Fuel\Core\Input::get('department_id');
            $_array = Fuel\Core\DB::query($sql)->bind('department_id', $department_id)->execute()->as_array();
            $department_ss_list_id[] = -1;
            foreach ($_array as $row) {
                $department_ss_list_id[] = $row['ss_id'];
            }

            $config['where'][] = array(
                'ss_id',
                'IN',
                $department_ss_list_id,
            );
        }

        if ($sale_type = \Fuel\Core\Input::get('sale_type')) {
            $sql = 'select sssale_id from sssale where sale_type IN :sale_type';
            $_array = Fuel\Core\DB::query($sql)->bind('sale_type', $sale_type)->execute()->as_array();
            $sssale_id[] = -1;
            foreach ($_array as $row) {
                $sssale_id[] = $row['sssale_id'];
            }

            $config['where'][] = array(
                'sssale_id',
                'IN',
                $sssale_id,
            );
        }

        if ($updated_at_from = \Fuel\Core\Input::get('updated_at_from')) {
            $config['where'][] = array(
                'updated_at',
                '>=',
                $updated_at_from,
            );
        }

        if ($updated_at_to = \Fuel\Core\Input::get('updated_at_to')) {
            $config['where'][] = array(
                'updated_at',
                '<=',
                $updated_at_to . ' 23:59:59',
            );
        }

        if (($is_webtoku = \Fuel\Core\Input::get('is_webtoku')) != null) {
            $config['where'][] = array(
                'is_webtoku',
                '=',
                $is_webtoku,
            );
        }

        $time_target = \Fuel\Core\Input::get('time_target', array());
        if (!empty($time_target)) {
            $config['where'][] = array(
                'time_target',
                'in',
                $time_target,
            );
        }

        $person_target = \Fuel\Core\Input::get('person_target', array());
        if (!empty($person_target)) {
            $config['where'][] = array(
                'person_target',
                'in',
                $person_target,
            );
        }

        if (\Fuel\Core\Input::get('is_conscription', null) != null) {
            $config['where'][] = array(
                'is_conscription',
                '=',
                \Fuel\Core\Input::get('is_conscription'),
            );
        }

        if (\Fuel\Core\Input::get('is_pickup', null) != null) {
            $config['where'][] = array(
                'is_pickup',
                '=',
                \Fuel\Core\Input::get('is_pickup'),
            );
        }

        $login_info = Session::get('login_info');
        if (($is_hidden = \Fuel\Core\Input::get('is_hidden')) != null) {
            $config['where'][] = array(
                'is_hidden',
                '=',
                $is_hidden,
            );
        } elseif ($login_info['division_type'] != 1) {
            $config['where'][] = array(
                'is_hidden',
                '=',
                0,
            );
        }

        $config_pagination = $config['where'];
        $config_pagination = array(
            'pagination_url' => \Uri::base() . 'job/jobs/index?' . http_build_query(\Input::get()),
            'total_items' => $this->job->count('job_id', true, $config_pagination),
            'per_page' => \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : Constants::$default_limit_pagination,
            'uri_segment' => 'page',
            'num_links' => Constants::$default_num_links,
            'show_last' => true,
        );

        if ($export) {
            $query = \DB::select()->from('job')->where($config['where']);
            $lightdb = Databaselight::singleton();
            $statement = $lightdb->prepare($query->compile());
            $lightdb->execute($statement);
            return $statement;
        }

        $pagination = \Uospagination::forge('jobpage', $config_pagination);
        $config['limit'] = $pagination->per_page;
        $config['offset'] = $pagination->offset;
        $config['order_by'] = array('job_id' => 'desc');

        //order ss_name, sale_type ticket 1260 (author thuanth6589)
        $sort_ss_name = \Fuel\Core\Input::get('sort_ss_name');
        $sort_sale_type = \Fuel\Core\Input::get('sort_sale_type');
        if($sort_ss_name || $sort_sale_type) {
            $limit = $config['limit'];
            $offset = $config['offset'];
            $config['select'] = ['job_id'];
            $query = \DB::select('job_id')->from('job')->where($config['where']);
            $lightdb = Databaselight::singleton();
            $res = $lightdb->all($query);
            $job_id = [0];
            if (count($res)) {
                foreach ($res as $row) {
                    $job_id[] = $row['job_id'];
                }
            }

            $res = $this->job->find(function ($query) use($job_id, $limit, $offset, $sort_ss_name, $sort_sale_type)
            {
                $query = $query->join('m_ss', 'left')->on('m_ss.ss_id', '=', 'job.ss_id')
                    ->join('sssale', 'left')->on('job.sssale_id', '=', 'sssale.sssale_id')
                    ->where('job_id', 'in', $job_id)
                    ->limit($limit)
                    ->offset($offset);
                if ($sort_ss_name) {
                    $query->order_by('m_ss.ss_name', $sort_ss_name);
                }
                if ($sort_sale_type) {
                    $query->order_by(\Fuel\Core\DB::expr(
                    'CASE sssale.sale_type
                    WHEN  1 THEN "' . Constants::$sale_type["1"] .
                        '" WHEN  2 THEN "' . Constants::$sale_type["2"] .
                        '" WHEN  3 THEN "' . Constants::$sale_type["3"] .
                        '" WHEN  4 THEN "' . Constants::$sale_type["4"] .
                        '" WHEN  5 THEN "' . Constants::$sale_type["5"] .
                        '" WHEN  6 THEN "' . Constants::$sale_type["6"] .
                        '" ELSE "" END'), $sort_sale_type);
                }
                return $query;
            });
        } else {
            $res = $this->job->find($config);
        }

        $list_ss_id = '';
        $list_sssale_id = '';
        $list_partner_id = '';
        $_arr_res = $_arr_res = array(
            'res' => array(),
            'res_ss' => array(),
            'res_partner' => array(),
            'res_sssale' => array(),
        );

        if (count($res)) {
            foreach ($res as $row) {
                if ($row['ss_id'])
                    $list_ss_id .= $row['ss_id'] . ',';
                if ($row['sssale_id'])
                    $list_sssale_id .= $row['sssale_id'] . ',';
            }
            $list_sssale_id = trim($list_sssale_id, ',');
            $list_ss_id = trim($list_ss_id, ',');

            $res_ss = array();
            if ($list_ss_id) {
                $res_ss = $this->get_list_ss('ss_id IN (' . $list_ss_id . ')');

                foreach ($res_ss as $row) {
                    $list_partner_id .= '"' . $row['partner_code'] . '",';
                }

                $list_partner_id = trim($list_partner_id, ',');
            }

            $list_sssale = array();

            if ($list_sssale_id) {
                $list_sssale = $this->get_list_sssale('sssale_id IN (' . $list_sssale_id . ')');
            }

            $list_partner = array();
            $list_group = array();
            if ($list_partner_id) {
                $list_partner = $this->get_list_partner('partner_code IN (' . $list_partner_id . ')');
                /*Get group name */
                $list_group_id = array();
                foreach ($list_partner as $row) {
                    $list_group_id[] = $row['m_group_id'];
                }

                $list_group = $this->mgroup->get_list_by_partner($list_group_id);

            }


            $_arr_res = array(
                'res' => $res,
                'res_ss' => $this->array_key_value($res_ss, 'ss_id'),
                'res_partner' => $this->array_key_value($list_partner, 'partner_code'),
                'res_sssale' => $this->array_key_value($list_sssale, 'sssale_id'),
                'res_group' => $this->array_key_value($list_group, 'm_group_id'),
                'paging' => $pagination,
            );
        }

        return $_arr_res;

    }

    public function convert_job_add_recruit(&$data)
    {


        $data['job_add'] = array();
        $data['job_recruit'] = array();

        if (isset($data['job_add_sub_title'])) {
            $data['job_add_sub_title'] = explode(',', trim($data['job_add_sub_title']));
            $data['job_add_text'] = explode(',', trim($data['job_add_text']));
            $count = (count($data['job_add_sub_title']) > count($data['job_add_sub_title'])) ? count($data['job_add_text']) : count($data['job_add_text']);
            for ($i = 0; $i < $count; ++$i) {
                if (!isset($data['job_add_sub_title'][$i]) && !isset($data['job_add_text'][$i])) continue;

                $data['job_add'][$i]['sub_title'] = isset($data['job_add_sub_title'][$i]) ? $data['job_add_sub_title'][$i] : '';
                $data['job_add'][$i]['text'] = isset($data['job_add_text'][$i]) ? $data['job_add_text'][$i] : '';
            }
        }

        if (isset($data['job_recruit_sub_title'])) {
            $data['job_recruit_sub_title'] = explode(',', trim($data['job_recruit_sub_title']));
            $data['job_recruit_text'] = explode(',', trim($data['job_recruit_text']));
            $count = (count($data['job_recruit_text']) > count($data['job_recruit_sub_title'])) ? count($data['job_recruit_text']) : count($data['job_recruit_sub_title']);
            for ($i = 0; $i < $count; ++$i) {
                if (!isset($data['job_recruit_sub_title'][$i]) && !isset($data['job_recruit_text'][$i])) continue;

                $data['job_recruit'][$i]['sub_title'] = isset($data['job_recruit_sub_title'][$i]) ? $data['job_recruit_sub_title'][$i] : '';
                $data['job_recruit'][$i]['text'] = isset($data['job_recruit_text'][$i]) ? $data['job_recruit_text'][$i] : '';
            }
        }

    }

    public function array_key_value($obj, $key)
    {
        $result = array();
        if (count($obj)) {
            foreach ($obj as $_temp) {
                $result[$_temp[$key]] = $_temp;
            }
        }

        return $result;
    }

    public function approve_all($data)
    {
        DB::start_transaction();
        try {
            foreach ($data as $k => $v) {
                $res = $this->job->approve_data($k);
                if (!$res) {
                    DB::rollback_transaction();
                    return false;
                }
            }

            DB::commit_transaction();
            return true;
        } catch (Exception $e) {
            DB::rollback_transaction();
            return false;
        }
    }

    /**
     * @param $table
     * @param $name
     * @param $id
     * @param $type
     * @return mixed
     * @author HuyLv6635
     * @Content Update value of is_hidden field = $type
     */
    public function set_hidden($table, $name, $id, $type)
    {
        $query = DB::update($table);
        $query->set(['is_hidden' => $type, 'updated_at' => date('Y-m-d H:i:s', time())])->where($name, 'IN', $id);

        return $query->execute();
    }
}
