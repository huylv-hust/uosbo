<?php

/**
 * author thuanth6589
 * Class Model_Mailgroup
 */
class Model_Mailgroup extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'mail_group';
    protected static $_primary_key = 'mail_group_id';

    /**
     * select condition
     * @param $filters
     * @param $select
     * @return $this
     */
    private function get_where($filters, $select = 'mail_group.*')
    {
        $query = \Fuel\Core\DB::select($select)->from(self::$_table_name);
        if (isset($filters['limit_group']) && $filters['limit_group']) {
            $query->limit($filters['limit_group']);
        }

        if (isset($filters['offset']) && $filters['offset']) {
            $query->offset($filters['offset']);
        }

        $query->order_by('mail_group.mail_group_id', 'desc');
        return $query;
    }

    /**
     * get data
     * @param array $filters
     * @param string $select
     * @return mixed
     */
    public function get_data($filters = [], $select = 'mail_group.*')
    {
        $query = $this->get_where($filters, $select);
        return $query->execute()->as_array();
    }

    /**
     * count data
     * @param array $filters
     * @return int
     */
    public function count_data($filters = array())
    {
        $query = $this->get_where($filters);
        return count($query->execute());
    }

    /**
     * get all partner sale in mail group
     * @return mixed
     */
    public function get_all_partner_sale()
    {
        return $this->get_data([], 'mail_group.partner_sales');
    }
}
