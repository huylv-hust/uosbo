<?php
use Fuel\Core\DB;

class Model_Orders extends \Fuel\Core\Model_Crud
{
    protected static $_primary_key = 'order_id';
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    protected static $_table_name = 'orders';
    public $data_default;

    public function __construct()
    {
        $this->data_default = Utility::get_default_data(self::$_table_name);
    }

    /*
     * Get cost of order
     *
     * @since 21/10/2015
     * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
     */
    public static function cost_of_order($order, $list_ss_id = array(), $check = false)
    {
        $order_ss_list = trim($order['ss_list'], ',');
        if ($order['post_id']) {
            $price_media = \Model_Mpost::get_sum_price($order['post_id']);
        } else {
            return 0;
        }

        if ($order_ss_list && $check == true) {
            $ss_list = explode(',', $order_ss_list);
            $total_ss = count($ss_list) + 1;
            $total = $price_media / $total_ss;
            $base_cost = (int)$total;
            $total_round = $base_cost;
            $balance = $price_media % $total_ss;

            $num = 0;
            if (in_array($order['ss_id'], $list_ss_id)) {
                $total_round = $total_round + $balance; // is login + %
                $num = 1;
            }

            //if ss in department logging
            foreach ($ss_list as $key => $val) {
                if (in_array($val, $list_ss_id)) {
                    if ($num > 0) {
                        $total_round = $total_round + $base_cost;
                    }

                    $num++;
                }
            }

            $total_price = $total_round;
        } else {
            $total_price = $price_media;
        }

        return $total_price;
    }

    /*
     * Get orders in list ss_id
     *
     * @since 20/10/2015
     * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
     */
    public static function get_list_order_in_listss($list_ss_primary, $apply_date)
    {
        if (empty($list_ss_primary)) {
            return array();
        }

        $list_ss_str = implode(',', $list_ss_primary);
        $or_where = null;
        $i = 0;
        foreach ($list_ss_primary as $key => $value) {
            //$value = ','.$value.',';
            if ($i > 0) {
                $or_where .= ' OR Find_in_set(' . $value . ',ss_list) > 0';
            } else {
                $or_where .= 'Find_in_set(' . $value . ',ss_list) > 0';
            }

            $i++;
        }

        $where = null;
        if ($or_where) {
            $where = ' OR (' . $or_where . ')';
        }

        $apply_month = date('m', strtotime($apply_date));
        $apply_year = date('Y', strtotime($apply_date));

        $last_year = $apply_year - 1;
        $next_year = $apply_year + 1;
        if ($apply_month < 10) {
            $start_date = $last_year . '-10-01';
            $end_date = $apply_year . '-09-30';
        } else {
            $start_date = $apply_year . '-10-01';
            $end_date = $next_year . '-09-30';
        }

        return DB::select('*')
            ->from(self::$_table_name)
            ->where('status', 2)
            ->where(DB::expr('(apply_date >= "' . $start_date . '" AND apply_date <= "' . $end_date . '")'))
            ->where(DB::expr('(ss_id IN (' . $list_ss_str . ')' . $where . ')'))
            ->execute()
            ->as_array();
    }

    public static function find_ss_list($object, $flag = false)
    {
        $model_ss = new Model_Mss();
        $model_partner = new Model_Mpartner();
        $list_partner_code = array();
        if ($flag) {
            $list_partner = \Model_Mpartner::forge()->find($object);
        } else {
            $list_partner = $model_partner->get_info_by_userid($object);
        }

        $list_ss_id = array();
        foreach ($list_partner as $item) {
            $list_partner_code[] = $item['partner_code'];
        }

        if ($list_partner_code) {
            $config_partner['where'][] = array(
                'partner_code',
                'IN',
                $list_partner_code,
            );

            $list_ss = \Model_Mss::forge()->find($config_partner);
            if ($list_ss) {
                foreach ($list_ss as $key => $val) {
                    $list_ss_id[] = $val->ss_id;
                }
            }
        }

        return $list_ss_id;
    }

    /*
     * Get order info by order_id
     *
     * @since 04/09/2015
     * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
     */
    public function get_order_info($order_id)
    {
        $result = DB::select('*')
            ->from(self::$_table_name)
            ->where('order_id', $order_id)
            ->execute()
            ->as_array();
        if ($result) {
            return $result[0];
        }

        return $this->data_default;
    }

    /*
     * Update status
     *
     * @since 25/09/2015
     * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
     */
    public function order_update($data, $order_id)
    {
        return DB::update(self::$_table_name)
            ->set($data)
            ->where('order_id', $order_id)
            ->execute();
    }

    /*
     * Save data
     *
     * @since 11/05/2015
     * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
     */
    public function order_save($postarr, $action, $order_id = null)
    {
        if (empty($postarr)) {
            return false;
        }

        $post = Utility::set_null_data($postarr);
        $data = array(
            'apply_date' => $post['apply_date'],
            'ss_id' => $post['ss_id'],
            'location' => $post['location'],
            'access' => $post['access'],
            'request_date' => $post['request_date'],
            'apply_reason' => $post['apply_reason'],
            'apply_detail' => $post['apply_detail'],
            'request_people_num' => $post['request_people_num'],
            'work_date' => $post['work_date'],
            'work_time_of_month' => $post['work_time_of_month'],
            'work_days_of_week' => $post['work_days_of_week'],
            'is_insurance' => $post['is_insurance'],
            'holiday_work' => $post['holiday_work'],
            'require_des' => $post['require_des'] != null ? $post['require_des'] : null,
            'require_experience' => $post['require_experience'],
            'require_other' => $post['require_other'],
            'require_age' => $post['require_age'],
            'require_gender' => $post['require_gender'],
            'require_w' => $post['require_w'],
            'price' => (int)$post['price'],
        );

        if (array_key_exists('post_date', $post)) {
            $data['post_date'] = $post['post_date'] ? $post['post_date'] : null;
        }
        if (array_key_exists('close_date', $post)) {
            $data['close_date'] = $post['close_date'] ? $post['close_date'] : null;
        }

        $data['agreement_type'] = null;
        if (isset($post['agreement_type'])) {
            $data['agreement_type'] = $post['agreement_type'];
        }

        $data['work_type'] = null;
        if (isset($post['work_type'])) {
            $data['work_type'] = ',' . implode(',', $post['work_type']) . ',';
        }

        $data['post_id'] = null;
        if (isset($post['list_post']) && $post['list_post'] != null) {
            $data['post_id'] = $post['list_post'];
        }

        $data['ss_list'] = null;
        if (isset($post['ss_list']) && !empty(array_filter($post['ss_list']))) {
            $data['ss_list'] = ',' . implode(',', $post['ss_list']) . ',';
        }

        $data['notes'] = $post['notes'];
        $data['author_user_id'] = $post['author_user_id'];
        $data['interview_user_id'] = $post['interview_user_id'];
        $data['agreement_user_id'] = $post['agreement_user_id'];
        $data['training_user_id'] = $post['training_user_id'];
        $data['updated_at'] = date('Y-m-d H:i:s', time());

        if ($order_id && $action != 'copy') //update
        {
            return DB::update(self::$_table_name)->set($data)->where('order_id', $order_id)->execute();
        } else //insert
        {
            //copy image
            if ($order_id) {
                $order = self::find_by_pk($order_id);
                $data['image_content'] = $order->image_content;
                $data['width'] = $order->width;
                $data['height'] = $order->height;
                $data['mine_type'] = $order->mine_type;
            }

            $data['status'] = 0;
            $user_login = \Fuel\Core\Session::get('login_info');
            $data['created_at'] = date('Y-m-d H:i:s', time());
            $data['create_id'] = $user_login['user_id'];
            return DB::insert(self::$_table_name)->set($data)->execute();
        }
    }

    /*
     * Send mail confirm
     *
     * @since 28/09/2015
     * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
     */
    public function sendmail($status, $data, $user_id)
    {
        //status = 99 create order
        //status = 1 order approved
        //status = -1 order noapproved
        $mailto = array();
        if ($user_id) {
            $user_info = Model_Muser::find_by_pk($user_id);
            if ($user_info) {
                $mailto[] = $user_info->mail;
            }
        }

        if ($data['list_emails']) {
            foreach ($data['list_emails'] as $email) {
                if ($email['mail']) {
                    $mailto[] = $email['mail'];
                }
            }
        }

        //remove duplicate email
        if ($mailto) {
            array_unique($mailto);
        }

        $subject = null;
        if ($status == 99) {
            $subject = '媒体掲載オーダーが登録されました';
        }

        if ($status == 1) {
            $subject = '媒体掲載オーダーが承認されました';
        }

        if ($status == -1) {
            $subject = '媒体掲載オーダーが非承認になりました';
        }

        $data['status'] = $status;

        return \Utility::sendmail($mailto, $subject, $data, 'email/order');
    }

    public function get_order_id_list($post_id_list)
    {
        $is_where = DB::select('order_id')->from('orders');
        $is_where->where('post_id', 'in', $post_id_list);

        return Fuel\Core\DB::query($is_where)->execute()->as_array();
    }

    /**
     * @author thuanth6589 <thuanth6589@seta-asia.com.vn>
     * count person for export result csv
     * @param $filters
     * @return mixed
     */
    public function count_person($filters)
    {
        $query = \Fuel\Core\DB::select('employment.review_result', 'employment.contact_result', 'employment.adoption_result')->from('orders');
        $query->join('person', 'left')->on('orders.order_id', '=', 'person.order_id');
        $query->join('employment', 'left')->on('person.person_id', '=', 'employment.person_id');

        if (isset($filters['person_id'])) {
            $filters['person_id'] = empty($filters['person_id']) ? array(0) : $filters['person_id'];
            $query->where('person.person_id', 'in', $filters['person_id']);
        }

        if (array_key_exists('reprinted_via', $filters)) {
            $query->where('person.reprinted_via', '=', $filters['reprinted_via']);
        }

        return $query->execute();
    }

    public function get_list_data($config)
    {
        $obj = static::forge()->find($config);
        if (count($obj)) {
            return $obj;
        }

        return array();
    }

    public function csv_process($list_orders)
    {
        if (empty($list_orders)) {
            return array();
        }

        $csv_all_data = array();
        $stt = 0;
        foreach ($list_orders as $order) {
            $csv_data = array();
            $total_price = 0;
            $order_ss_list = trim($order['ss_list'], ',');
            $ss_list = strlen($order_ss_list) ? explode(',', $order_ss_list) : [];
            //get media info
            $price_int = $price_blance = '';
            if ($order['post_id']) {
                $post = \Model_Mpost::find_by_pk($order['post_id']);
                if ($post) {
                    $media = \Model_Mmedia::find_by_pk($post->m_media_id);
                    if ($media) {
                        if ($media->type == 1) {
                            $type = '自力';
                        }

                        if ($media->type == 2) {
                            $type = '他力';
                        }

                        if ($media->budget_type == 1) {
                            $budget_type = '求人費';
                        }

                        if ($media->budget_type == 2) {
                            $budget_type = '販促費';
                        }

                        if ($media->is_web_reprint == 1) {
                            $is_web_reprint = 'あり';
                        }

                        if ($media->is_web_reprint == 0) {
                            $is_web_reprint = 'なし';
                        }

                        $classification = isset(\Constants::$media_classification[$media->classification]) ? \Constants::$media_classification[$media->classification] : '';
                        $partner = \Model_Mpartner::find_by_pk($media->partner_code);
                        $media_name = $media->media_name;

                        $total_ss = 1 + count($ss_list);
                        if ($media->is_web_reprint == 1) {
                            $total_ss = (1 + (count($ss_list))) * 2;
                        }


                        $post_price = (int)$order['price'];
                        $price = $post_price / $total_ss;
                        $price_int = (int)$price;
                        $price_blance = $price_int + ($post_price % $total_ss);
                    }
                }
            }

            //get partner and group by ss_id
            $data_ss = $this->get_ss_info($order['ss_id']);

            //ss_sale info
            if ($order['agreement_type']) {
                $ss_sale = \Model_Sssale::find_by_pk($order['agreement_type']);
                if ($ss_sale) {
                    $sale_name = isset(\Constants::$sale_type[$ss_sale->sale_type]) ? \Constants::$sale_type[$ss_sale->sale_type] : '';
                }
            }

            $csv_data[$order['order_id']][] = array(
                $order['order_id'],
                $data_ss['group_info_name'],
                $data_ss['ss_partner_name'],
                $data_ss['ss_info_ss_name'],
                $data_ss['department_name'],
                $data_ss['department_id'],
                $data_ss['user_info_name'],
                isset($sale_name) ? $sale_name : '',
                $order['request_date'] != null ? date('Y/m/d', strtotime($order['request_date'])) : '',
                $order['post_date'] != null ? date('Y/m/d', strtotime($order['post_date'])) : '',
                isset($type) ? $type : '',
                isset($budget_type) ? $budget_type : '',
                isset($classification) ? $classification : '',
                isset($is_web_reprint) ? $is_web_reprint : '',
                isset($media->m_media_id) ? $media->m_media_id : '',
                'media_name' => isset($media_name) ? $media_name : '',
                isset($media->media_version_name) ? $media->media_version_name : '',
                isset($post->name) ? $post->name : '',
                isset($partner->branch_name) ? $partner->branch_name : '',
                'price' => $stt == 0 ? $price_blance : $price_int,
                'total' => isset($post_price) ? $post_price : 0,
                $order['notes'],
            );

            //if ss_list
            if ($order['ss_list']) {
                $order_ss_list = trim($order['ss_list'], ',');
                $ss_list = explode(',', $order_ss_list);
                foreach ($ss_list as $ss_key => $ss_item_id) {
                    $data_ss_id = $this->get_ss_info($ss_item_id);
                    $csv_data[$order['order_id']][] = array(
                        $order['order_id'],
                        $data_ss_id['group_info_name'],
                        $data_ss_id['ss_partner_name'],
                        $data_ss_id['ss_info_ss_name'],
                        $data_ss_id['department_name'],
                        $data_ss_id['department_id'],
                        $data_ss_id['user_info_name'],
                        isset($sale_name) ? $sale_name : '',
                        $order['request_date'] != null ? date('Y/m/d', strtotime($order['request_date'])) : '',
                        $order['post_date'] != null ? date('Y/m/d', strtotime($order['post_date'])) : '',
                        isset($type) ? $type : '',
                        isset($budget_type) ? $budget_type : '',
                        isset($classification) ? $classification : '',
                        isset($is_web_reprint) ? $is_web_reprint : '',
                        isset($media->m_media_id) ? $media->m_media_id : '',
                        'media_name' => isset($media_name) ? $media_name : '',
                        isset($media->media_version_name) ? $media->media_version_name : '',
                        isset($post->name) ? $post->name : '',
                        isset($partner->branch_name) ? $partner->branch_name : '',
                        'price' => isset($price_int) ? $price_int : '',
                        'total' => '',
                        $order['notes'],
                    );
                }
            }

            if (isset($media->is_web_reprint) && $media->is_web_reprint == 1) {
                foreach ($csv_data as $key => $val) {
                    foreach ($val as $k => $v) {
                        $v['media_name'] = $v['media_name'] . '(WEB転載)';
                        $v['total'] = '';
                        $csv_data[$key][] = $v;
                    }
                }

                foreach ($csv_data as $key => $val) {
                    $blance_2 = (count($val) / 2);
                    $csv_data[$key][$blance_2]['price'] = $price_int;
                }
            }

            $csv_all_data[$order['order_id']] = $csv_data;
            $stt++;
        }

        return $csv_all_data;
    }


    /*
     * Export to csv
     *
     * @since 07/12/2015
     * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
     */
    public static function export($csv_data)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=order_list_' . date('Ymd') . '.csv');
        $contents = array();
        $title = array();
        $fp = fopen('php://output', 'w');
        fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
        fputcsv($fp, \Constants::$order_title);
        foreach ($csv_data as $order_ids => $order_id) {
            foreach ($order_id as $key => $val) {
                foreach ($val as $v) {
                    fputcsv($fp, $v);
                }
            }
        }

        fclose($fp);
        exit();
    }

    public function get_ss_info($ss_id, $get_partner = false)
    {
        //get partner and group by ss_id
        $ss_info = \Model_Mss::find_by_pk($ss_id);
        if ($ss_info) {
            $ss_partner = \Model_Mpartner::find_by_pk($ss_info->partner_code);
            if ($ss_partner) {
                $group_info = \Model_Mgroups::find_by_pk($ss_partner->m_group_id);
                $user_info = \Model_Muser::find_by_pk($ss_partner->user_id);
                $department = isset(\Constants::$department[$ss_partner->department_id]) ? \Constants::$department[$ss_partner->department_id] : '';
                if ($get_partner) {
                    return $ss_partner;
                }
            }
        }

        return array(
            'group_info_name' => isset($group_info->name) ? $group_info->name : '',
            'ss_partner_name' => isset($ss_partner->branch_name) ? $ss_partner->branch_name : '',
            'ss_info_ss_name' => isset($ss_info->ss_name) ? $ss_info->ss_name : '',
            'department_name' => isset($department) ? $department : '',
            'department_id' => isset($ss_partner->department_id) ? $ss_partner->department_id : '',
            'user_info_name' => isset($user_info->name) ? $user_info->name : '',
        );
    }

    public function get_list_oders_login($user_id)
    {
        $sql = 'SELECT person_id FROM person WHERE  interview_user_id = ' . $user_id . ' OR business_user_id = ' . $user_id . ' OR training_user_id =' . $user_id . ' OR agreement_user_id =' . $user_id;
        $result = Fuel\Core\DB::query($sql)->execute();
        return $result;
    }

    public function count_data()
    {
        $result = DB::select('*')->from(self::$_table_name)->execute();
        return count($result);
    }

    public function get_data_for_autocomplete()
    {
        $sql = 'select m_ss.ss_name,m_partner.branch_name,sssale.sale_name,m_media.media_name from orders
				inner join m_ss on (orders.ss_id = m_ss.ss_id)
				inner join m_partner on (m_ss.partner_code = m_partner.partner_code)
				inner join sssale on (orders.agreement_type = sssale.sssale_id)
				left join m_post on (m_post.post_id = orders.post_id)
				left join m_media on (m_media.m_media_id = m_post.m_media_id)';
        $rs = \Fuel\Core\DB::query($sql)->execute();
        return $rs;
    }

    /**
     * 残予算計算(対象SSの管轄部門の予算計算)
     * @param string $date 対象年月日
     * @param int $ss_id 対象SSID
     * @param int $exclude_order_id 計算除外オーダーID
     * @return int 消化予算
     */
    public static function calc_balance($date, $ss_id, $exclude_order_id = 0)
    {
        // 申請日付対象期間計算
        $time = strtotime($date);
        $year = (int)date('Y', $time);
        $month = (int)date('m', $time);
        $day = (int)date('d', $time);

        if (
            $month < (int)Constants::$plan_between_date['month'] || (
                $month == (int)Constants::$plan_between_date['month'] &&
                $day < (int)Constants::$plan_between_date['day']
            )
        ) {
            $year--;
        }

        $start_date = sprintf(
            '%04d-%02d-%02d',
            $year,
            Constants::$plan_between_date['month'],
            Constants::$plan_between_date['day']
        );

        $end_date = sprintf(
            '%04d-%02d-%02d',
            $year + 1,
            Constants::$plan_between_date['month'],
            Constants::$plan_between_date['day']
        );
        $end_date = date(
            'Y-m-d',
            strtotime($end_date) - 86400
        );

        // 対象部門
        $array =
            DB::query('
				SELECT p.department_id FROM m_ss AS s
				INNER JOIN m_partner AS p ON (s.partner_code = p.partner_code)
				WHERE s.ss_id = :ss_id
			')->bind('ss_id', $ss_id)
                ->execute()->as_array();;

        if (isset($array[0]['department_id']) == false) {
            throw new Exception('wrong ss_id:' . $ss_id);
        }

        $department_id = $array[0]['department_id'];

        // 同一部門SS
        $sslist =
            DB::query('
				SELECT s.ss_id FROM m_ss AS s
				INNER JOIN m_partner AS p ON (s.partner_code = p.partner_code)
				WHERE p.department_id = :department_id
			')->bind('department_id', $department_id)
                ->execute()->as_array();;

        // 対象オーダーの抽出
        $or_wheres = [];
        foreach ($sslist as $ss) {
            $or_wheres[] = 'o.ss_id = :ss' . $ss['ss_id'];
            $or_wheres[] = 'FIND_IN_SET(:fis' . $ss['ss_id'] . ', o.ss_list)';
        }

        $or_sql = implode(' OR ', $or_wheres);

        $sql = "
			SELECT
				o.order_id,
				o.ss_list,
				o.price,
				pt.department_id
			FROM orders AS o
			INNER JOIN m_ss AS s ON (o.ss_id = s.ss_id)
			INNER JOIN m_partner AS pt ON (s.partner_code = pt.partner_code)
			WHERE
				o.status = 1 AND
				o.order_id <> :exclude_order_id AND
				apply_date >= :start_date AND
				apply_date <= :end_date AND (
					$or_sql
				)
		";

        $exclude_order_id = (int)$exclude_order_id;
        $query = DB::query($sql)
            ->bind('exclude_order_id', $exclude_order_id)
            ->bind('start_date', $start_date)
            ->bind('end_date', $end_date);

        foreach ($sslist as $ss) {
            $query->bind('ss' . $ss['ss_id'], $ss['ss_id']);
            $query->bind('fis' . $ss['ss_id'], $ss['ss_id']);
        }

        $cost = 0;
        foreach ($query->execute()->as_array() as $row) {
            $row['ss_list'] = trim($row['ss_list'], ',');
            $order_ss_list = strlen($row['ss_list']) ? explode(',', $row['ss_list']) : [];
            $sscount = count($order_ss_list) + 1;

            // 基本SSの計算
            if ($department_id == $row['department_id']) {
                $cost += floor($row['price'] / $sscount) + $row['price'] % $sscount;
            }

            // 同募SS計算
            if (count($order_ss_list) > 0) {
                $query_sslist = DB::select('m_partner.department_id')->from('m_ss')
                    ->join('m_partner')->on('m_ss.partner_code', '=', 'm_partner.partner_code')
                    ->where('m_ss.ss_id', 'IN', $order_ss_list);


                foreach ($query_sslist->execute()->as_array() as $order_ss) {
                    if ($department_id == $order_ss['department_id']) {
                        $cost += floor($row['price'] / $sscount);
                    }
                }

            }
        }

        $plan_cost = \Model_Plan::get_info_by_startdate($date, $department_id);

        return $plan_cost - $cost;
    }

    /**
     * 消化予算配分計算
     * @param int $ss_id 対象SSID
     * @param int $price オーダー金額
     * @param array $ss_list 同募SSのリスト
     * @return int 消化予算
     */
    public static function calc_cost($ss_id, $price, $ss_list)
    {
        if (count($ss_list) == 0) {
            return $price;
        }

        // 対象部門
        $array =
            DB::query('
				SELECT p.department_id FROM m_ss AS s
				INNER JOIN m_partner AS p ON (s.partner_code = p.partner_code)
				WHERE s.ss_id = :ss_id
			')->bind('ss_id', $ss_id)
                ->execute()->as_array();;

        if (isset($array[0]['department_id']) == false) {
            throw new Exception('wrong ss_id:' . $ss_id);
        }

        $department_id = $array[0]['department_id'];

        $sscount = count($ss_list) + 1;
        $cost = floor($price / $sscount) + $price % $sscount;

        $query = DB::select('m_partner.department_id')->from('m_ss')
            ->join('m_partner')->on('m_ss.partner_code', '=', 'm_partner.partner_code')
            ->where('m_ss.ss_id', 'IN', $ss_list);

        foreach ($query->execute()->as_array() as $row) {
            if ($department_id == $row['department_id']) {
                $cost += floor($price / $sscount);
            }
        }

        return $cost;
    }

    public static function countFilter($filter)
    {
        $built = self::buildFilterQuery($filter);
        $sql = 'SELECT COUNT(*) AS num FROM (' . $built['sql'] . ') AS __counter__';
        $rows = DB::query($sql)->parameters($built['parameters'])->execute()->as_array();
        if (is_array($rows) == false) {
            return 0;
        } else {
            return $rows[0]['num'];
        }
    }

    public static function filter($filter, $limit, $offset)
    {
        $built = self::buildFilterQuery($filter);
        if ($limit) {
            $built['sql'] .= " LIMIT $limit";
        }
        if ($offset) {
            $built['sql'] .= " OFFSET $offset";
        }
        return DB::query($built['sql'])->parameters($built['parameters'])->execute()->as_array();
    }

    private static function buildFilterQuery($filter)
    {
        $wheres = $parameters = [];

        if (@strlen($filter['start_id'])) {
            $wheres[] = 'o.order_id >= :start_id';
            $parameters['start_id'] = $filter['start_id'];
        }

        if (@strlen($filter['end_id'])) {
            $wheres[] = 'o.order_id <= :end_id';
            $parameters['end_id'] = $filter['end_id'];
        }

        if (@strlen($filter['user_id'])) {
            $wheres[] = 'ss.user_id = :user_id';
            $parameters['user_id'] = $filter['user_id'];
        }

        if (@strlen($filter['department_id'])) {
            $wheres[] = 'p.department_id = :department_id';
            $parameters['department_id'] = $filter['department_id'];
        }

        if (@strlen($filter['department'])) {
            $wheres[] = 'ss_user.department_id = :department';
            $parameters['department'] = $filter['department'];
        }

        if (@strlen($filter['order_user_id'])) {
            $wheres[] = 'o.order_user_id = :order_user_id';
            $parameters['order_user_id'] = $filter['order_user_id'];
        }

        if (@strlen($filter['order_department'])) {
            $wheres[] = 'order_user.department_id = :order_department';
            $parameters['order_department'] = $filter['order_department'];
        }

        if (@strlen($filter['ssid'])) {
            $wheres[] = '(o.ss_id = :ssid OR o.ss_list LIKE :ssidlike)';
            $parameters['ssid'] = $filter['ssid'];
            $parameters['ssidlike'] = '%,' . $filter['ssid'] . ',%';
        }

        if (@strlen($filter['partner'])) {
            $wheres[] = 'ss.partner_code = :partner';
            $parameters['partner'] = $filter['partner'];
        }

        if (@strlen($filter['group'])) {
            $wheres[] = 'p.m_group_id = :group';
            $parameters['group'] = $filter['group'];
        }

        if (@strlen($filter['addr1'])) {
            $wheres[] = 'ss.addr1 = :addr1';
            $parameters['addr1'] = $filter['addr1'];
        }

        if (@strlen($filter['maddr2'])) {
            $wheres[] = 'ss.addr2 = :maddr2';
            $parameters['maddr2'] = $filter['maddr2'];
        }

        if (@strlen($filter['apply_date1'])) {
            $wheres[] = 'o.apply_date >= :apply_date1';
            $parameters['apply_date1'] = $filter['apply_date1'];
        }

        if (@strlen($filter['apply_date2'])) {
            $wheres[] = 'o.apply_date <= :apply_date2';
            $parameters['apply_date2'] = $filter['apply_date2'];
        }

        if (@strlen($filter['post_date1'])) {
            $wheres[] = 'o.post_date >= :post_date1';
            $parameters['post_date1'] = $filter['post_date1'];
        }

        if (@strlen($filter['post_date2'])) {
            $wheres[] = 'o.post_date <= :post_date2';
            $parameters['post_date2'] = $filter['post_date2'];
        }

        if (@strlen($filter['media_id'])) {
            $wheres[] = 'post.m_media_id = :media_id';
            $parameters['media_id'] = $filter['media_id'];
        }

        if (@is_array($filter['status']) && count($filter['status'])) {
            $wheres[] = 'o.status IN :status';
            $parameters['status'] = $filter['status'];
        }

        if (@is_array($filter['sale_type']) && count($filter['sale_type'])) {
            $wheres[] = 'sss.sale_type IN :sale_type';
            $parameters['sale_type'] = $filter['sale_type'];
        }

        if (@strlen($filter['keyword'])) {
            $keywords = array_filter(preg_split('/\s|\s+|　/', trim($filter['keyword'])));
            foreach ($keywords as $key => $val) {
                $or = [];
                $keyName = 'keyword' . $key;
                $or[] = "CONCAT(g.name, p.branch_name, ss.ss_name, m.media_name, m.media_version_name, ifnull(sss.sale_name, '')) LIKE :$keyName";
                $parameters[$keyName] = '%' . $val . '%';
                foreach (self::filterPlace($val) as $ssId) {
                    $_keyName = 'ssid' . $ssId;
                    $or[] = "o.ss_list LIKE :$_keyName";
                    $parameters[$_keyName] = '%,' . $ssId . ',%';
                }
                $wheres[] = '(' . implode(' OR ', $or) . ')';
            }
        }

        $where = count($wheres) ? "WHERE " . implode(' AND ', $wheres) : '';

        $sql = "
            SELECT
                o.*,
                m.media_name,
                m.media_version_name,
                CONCAT(
                    g.name, p.branch_name, ss.ss_name
                ) AS place,
                sss.sale_type,
                create_user.name AS create_user_name,
                order_user.name AS order_user_name,
                COUNT(person.person_id) AS application_count,
                COUNT(e.person_id) AS employment_count
            FROM orders AS o
            LEFT JOIN sssale AS sss ON (o.agreement_type = sss.sssale_id)
            LEFT JOIN m_post AS post ON (o.post_id = post.post_id)
            LEFT JOIN m_media AS m ON (post.m_media_id = m.m_media_id)
            LEFT JOIN m_ss AS ss ON (o.ss_id = ss.ss_id)
            LEFT JOIN m_user AS ss_user ON (ss.user_id = ss_user.user_id)
            LEFT JOIN m_partner AS p ON (ss.partner_code = p.partner_code)
            LEFT JOIN m_group AS g ON (p.m_group_id = g.m_group_id)
            LEFT JOIN m_user AS create_user ON (o.create_id = create_user.user_id)
            LEFT JOIN m_user AS order_user ON (o.order_user_id = order_user.user_id)
            LEFT JOIN person ON (o.order_id = person.order_id)
            LEFT JOIN employment AS e ON (
                person.person_id = e.person_id AND
                e.adoption_result = 1
            )
            $where
            GROUP BY o.order_id
            ORDER BY o.order_id DESC
        ";

        return ['sql' => $sql, 'parameters' => $parameters];
    }

    public static function ssPlaces($sslist)
    {
        if (!$sslist) { return []; }
        $list = explode(',', trim($sslist, ','));

        $sql = "
            SELECT
                CONCAT(
                    g.name, p.branch_name, ss.ss_name
                ) AS place
            FROM
                m_ss AS ss
                INNER JOIN m_partner AS p ON (ss.partner_code = p.partner_code)
                INNER JOIN m_group AS g ON (p.m_group_id = g.m_group_id)
            WHERE
                ss.ss_id IN :sslist
        ";

        $rows = DB::query($sql)->bind('sslist', $list)->execute()->as_array();
        $result = [];
        foreach ($rows as $row) {
            $result[] = $row['place'];
        }

        return $result;
    }

    private static function filterPlace($keyword)
    {
        $results = [];

        if (strlen($keyword) == 0 || $keyword == '%') {
            return $results;
        }

        $sql = "
            SELECT ss.ss_id FROM m_ss AS ss
            INNER JOIN m_partner AS p ON (ss.partner_code = p.partner_code)
            INNER JOIN m_group AS g ON (p.m_group_id = g.m_group_id)
            WHERE CONCAT(g.name, p.branch_name, ss.ss_name) LIKE :keyword
        ";

        $rows = DB::query($sql)->parameters(['keyword' => '%' . $keyword . '%'])->execute()->as_array();
        foreach ($rows as $row) {
            $results[] = $row['ss_id'];
        }

        return $results;
    }
}
