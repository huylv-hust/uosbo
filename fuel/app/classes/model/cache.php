<?php

/**
 * author Namdd6566
 */
class Model_Cache extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'cache';
    protected static $_primary_key = 'cache_key';

    /**
     * select condition
     * @param $filters
     * @param $select
     * @return $this
     */
    private function get_where($filters, $select = 'cache.*')
    {
        $query = \Fuel\Core\DB::select($select)->from(self::$_table_name);
        if (isset($filters['limit']) && $filters['limit']) {
            $query->limit($filters['limit']);
        }

        if (isset($filters['offset']) && $filters['offset']) {
            $query->offset($filters['offset']);
        }

        $query->order_by('cache.updated_at', 'desc');
        return $query;
    }

    /**
     * get data
     * @param array $filters
     * @param string $select
     * @return mixed
     */
    public function get_data($filters = [], $select = 'cache.*')
    {
        $query = $this->get_where($filters, $select);
        return $query->execute()->as_array();
    }

    /**
     * @param $obj
     * @param array $data
     */
    public function save_data($data, $id = '')
    {
        if ($id === '') {
            $data['created_at'] = date('Y-m-d H:i');
            $data['updated_at'] = date('Y-m-d H:i');
            $obj = static::forge();
            $obj->set($data);
            $res = $obj->save();
            return $res['0'];
        }
        $obj = static::forge()->find_by_pk($id);
        if (count($obj)) {
            $data['updated_at'] = date('Y-m-d H:i');
            $obj->set($data);
            $obj->is_new(false);
            return (boolean)$obj->save();
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete_data($id)
    {
        $obj = static::forge()->find_by_pk($id);
        if (count($obj)) {
            return $obj->delete();
        }

        return false;
    }
    /**
     *
     * @param type $id
     * @return type
     */
    public function get_info_data($id)
    {
        $obj = static::forge()->find_by_pk($id);
        if ($obj !== null) {
            return json_decode($obj->_data['cache_value'],true);
        }

        return false;
    }
}
