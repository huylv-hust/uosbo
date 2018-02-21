<?php

/**
 * Author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * Copyright: SETA- Asia
 * File Class/Controler/Model
 **/
class Model_Mgroups extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'm_group';
    protected static $_primary_key = 'm_group_id';
    protected static $_properties = array(
        'm_group_id',
        'name',
        'obic7_name',
        'created_at',
        'updated_at',
    );

    public $header_csv = [
        'ID',
        '取引先法人名'
    ];
    private $error_import = array();

    /**
     * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
     * action check group name exits
     */
    public static function check_name($group_id = null, $group_name = null)
    {
        $select_group = \Fuel\Core\DB::select('*')->from(self::$_table_name);
        if (isset($group_id))
            $select_group->where('m_group_id', '!=', $group_id);
        if (isset($group_name))
            $select_group->where('name', '=', $group_name);

        return count($select_group->execute());
    }

    /**
     * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
     * action delete group
     */
    public function delete_group($id_group)
    {
        if (isset($id_group)) {
            try {
                $group = Model_Mgroups::find_by_pk($id_group);
                if ($group->delete()) {
                    return true;
                } else
                    return false;
            } catch (Exception $ex) {
                return false;
            }
        }
    }

    /**
     * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
     * action create and edit group
     * @return array
     */
    public function create_group($data = array())
    {
        if ($data['group_id'] and !\Model_Mgroups::find_by_pk($data['group_id'])) {
            Session::set_flash('error', '取引先グループは存在しません');
            return array('status' => \Constants::$_status_save['id_not_exist']);
        }
        if (isset($data['group_id'])) {
            $group = Model_Mgroups::find_by_pk($data['group_id']);
            $data['updated_at'] = date('Y-m-d H:i:s');
        } else {
            $group = new Model_Mgroups();
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $data['name'] = Utility::strip_tag_string($data['group_name']);

        $group->set($data);//Set data
        $is_name = self::check_name($data['group_id'], $data['group_name']);
        if ($is_name != 0) {
            return array('status' => \Constants::$_status_save['value_exist']);
        }

        if ($group AND $group->save() >= 0) {
            Session::set_flash('success', '保存しました ');
            return array(
                'group_id' => $group->m_group_id,
                'status' => \Constants::$_status_save['save_success'],
            );
        }
    }

    public function update_obic7($data, $id)
    {
        $obj = static::forge()->find_by_pk($id);
        if (count($obj)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $obj->set($data);
            $obj->is_new(false);
            return (boolean)$obj->save();
        }

        return false;
    }

    /**
     * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
     * action get all group
     * @return array
     */
    public function get_all($keywork = null, $offset = null, $limit = null, $order_by = 'updated_at', $keyword_modal = null)
    {
        $select = DB::select('m_group_id', 'name', 'obic7_name')->from(self::$_table_name);
        if (isset($keywork) and $keywork != '')
            $select->where('name', 'like', '%' . $keywork . '%');

        if (isset($keyword_modal) && $keyword_modal) {
            $arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($keyword_modal)));
            $select->and_where_open();
            foreach ($arr_keyword as $k => $v) {
                $select->where('name', 'like', '%' . $v . '%');
            }
            $select->and_where_close();
        }

        if ($offset)
            $select->offset($offset);

        if ($limit)
            $select->limit($limit);


        $select->order_by($order_by, 'desc');
        return $select->execute()->as_array();
    }

    /**
     * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
     * action get type
     * @return array
     */
    public static function get_type($type = null)
    {
        $select = DB::select('m_group.m_group_id', 'm_group.name')->from(self::$_table_name);
        $select->join('m_partner');
        $select->on('m_group.m_group_id', '=', 'm_partner.m_group_id');
        $select->where('m_partner.type', '=', $type);
        $select->order_by('name', 'asc');

        return array_column($select->execute()->as_array(), 'name', 'm_group_id');
    }

    /**
     * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
     * action get one group
     * @return array
     */
    public function get_one($id)
    {
        $select = DB::select('m_group_id', 'name', 'obic7_name')->from(self::$_table_name)->where('m_group_id', '=', $id);
        return $select->execute()->as_array();
    }

    /*
     * Get list by type
     *
     * @since 05/11/2015
     * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
     */
    public function get_list_by_partner($list_partner)
    {
        $list_m_group_id = implode(',', $list_partner);
        return DB::select('*')
            ->from(self::$_table_name)
            ->where(DB::expr('m_group_id IN (' . $list_m_group_id . ')'))
            ->execute()
            ->as_array();
    }

    /**
     * author thuanth6589
     * import csv
     * @param $file
     * @return array
     */
    public function save_import($file)
    {
        $header = fgetcsv($file);
        if (count($header) != 2) {
            $this->error_import[] = '1行目:CSVファイルのフォーマットが正しくありません。';
        }
        $line = 2;
        $error_save = 0;
        \Fuel\Core\DB::start_transaction();
        try {
            while (($data = fgetcsv($file)) !== false) {
                $validate = $this->validate_import($line, $data);
                if ($validate && !$this->save_data_import($data)) {
                        $error_save++;
                }
                $line++;
            }

            if ($error_save > 0 || (isset($validate) && !$validate)) {
                \Fuel\Core\DB::rollback_transaction();
                return ['import' => false, 'error' => $this->error_import];
            }

            \Fuel\Core\DB::commit_transaction();
        } catch (Exception $e) {
            \Fuel\Core\DB::rollback_transaction();
            $this->error_import[] = 'インポートができません。';
            Fuel\Core\Log::error('import group: ' . $e);
            return ['import' => false, 'error' => $this->error_import];
        }

        return ['import' => true, 'error' => $this->error_import];
    }

    /**
     * @param $data
     * @return bool
     */
    private function save_data_import($data)
    {
        if ($data[0]) {
            $obj = static::find_by_pk($data[0]);
            $obj->is_new(false);
        } else {
            $obj = new Model_Mgroups();
            $data['created_at'] = date('Y-m-d H:i:s');
            $obj->is_new(true);
        }

        $data['name'] = $data[1];
        $data['updated_at'] = date('Y-m-d H:i:s');
        $obj->set($data);
        if ($obj->save())
            return true;

        return false;
    }

    /**
     * author thuanth6589
     * @param $line
     * @param array $data
     * @return bool
     */
    public function validate_import($line, $data = array())
    {
        if (count($data) != 2) {
            $this->error_import[] = $line . '行目:CSVファイルのフォーマットが正しくありません。';
        } else {
            if ($data[0]) {
                $group = static::find_by_pk($data[0]);
                if (!$group) {
                    $this->error_import[] = $this->set_message_exist($line, $this->header_csv[0]);
                }
            }

            if (trim($data[1]) == '') {
                $this->error_import[] = $this->set_message_require($line, $this->header_csv[1]);
            } else {
                //check name unique
                if ($this->check_name($data[0] ? $data[0] : null, trim($data[1]))) {
                    $this->error_import[] = $this->set_message_existed($line, $this->header_csv[1]);
                }
            }

            if ($this->get_length($data[1]) > 100) {
                $this->error_import[] = $this->set_message_over_length($line, $this->header_csv[1], 100);
            }
        }

        if (empty($this->error_import)) {
            return true;
        }
        return false;
    }

    /**
     * @author ThuanTh6589
     * get length full size str
     */
    private function get_length($str)
    {
        return mb_strlen($str);
    }

    /**
     * @author ThuanTh6589
     * message for validate length
     */
    private function set_message_over_length($line, $column, $length)
    {
        return $line . '行目:' . $column . 'が' . $length . '文字以内を入力して下さい。';
    }

    /**
     * @author ThuanTh6589
     * message for validate require
     */
    private function set_message_require($line, $column)
    {
        return $line . '行目:' . $column . 'を入力して下さい。';
    }

    /**
     * @author ThuanTh6589
     * message for validate existed
     */
    private function set_message_exist($line, $column)
    {
        return $line . '行目:' . $column . 'が存在しません。';
    }

    /**
     * author thuanth6589
     * message check unique
     * @param $line
     * @param $column
     * @return string
     */
    private function set_message_existed($line, $column)
    {
        return $line . '行目:' . $column . 'は既に登録されています。';
    }
}
