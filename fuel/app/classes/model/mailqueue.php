<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Model_Mailqueue
 */
class Model_Mailqueue extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'mail_queue';
    protected static $_primary_key = 'queue_id';

    /**
     * create query
     * @param string $select
     * @param array $filters
     * @return $this
     */
    private function get_where($filters = [], $select = '*')
    {
        $query = \Fuel\Core\DB::select($select)->from('mail_queue');

        if (isset($filters['now']) && $filters['now']) {
            $query->where('send_time', '<=', $filters['now']);
        }
        return $query;
    }

    /**
     * get data
     * @param $select
     * @param $filters
     * @return mixed
     */
    public function get_data($filters = [], $select = '*')
    {
        $query = $this->get_where($filters, $select);
        return $query->execute()->as_array();
    }

    /**
     * delete by id
     * @param array $id
     * @return int|object
     */
    public function delete_by_id($id = [])
    {
        $delete = 0;
        if (!empty($id)) {
            $delete = \Fuel\Core\DB::query('DELETE FROM mail_queue where queue_id IN :queue_id')->bind('queue_id', $id)->execute();
        }
        return $delete;
    }
}
