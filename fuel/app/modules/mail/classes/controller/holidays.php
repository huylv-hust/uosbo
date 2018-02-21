<?php

namespace Mail;

use Fuel\Core\Cache;
use Fuel\Core\Input;
use Fuel\Core\Model;
use Oil\Exception;

/**
 * author namdd6566
 * Class Controller_Holidays
 * @package Mail
 */
class Controller_Holidays extends \Controller_Uosbo
{

    /**
     * list holidays
     */
    private $cache_key = 'uos-holidays';

    public function action_index()
    {
        $this->template->title = 'UOS求人システム';
        $cache = new \Model_Cache();
        $data['holidays'] = $cache->get_info_data($this->cache_key);
        if ($data['holidays'] !== false) {
            //Remove day pass
            if (count($data['holidays'])) {
                foreach ($data['holidays'] as $key => $holidays_date) {
                    if (strtotime($holidays_date) < time() && date('d', strtotime($holidays_date)) != date('d')) { // day pass
                        unset($data['holidays'][$key]);
                    }
                }
                $data['holidays'] = array_values($data['holidays']);
                sort($data['holidays']);
                //Save
                $data_save = array('cache_key' => $this->cache_key, 'cache_value' => json_encode($data['holidays']));
                $cache->save_data($data_save, $this->cache_key);
            }
        }
        $data['holidays'] = $data['holidays'] == false ? [] : $data['holidays'];
        $this->template->content = \View::forge('holidays/index', $data);
    }

    /**
     * @return \Response
     */
    public function action_remove()
    {
        $holiday_remove = Input::post('key');
        $cache = new \Model_Cache();
        $holidays = $cache->get_info_data($this->cache_key);
        $key = array_search($holiday_remove, $holidays);
        unset($holidays[$key]);
        $holidays = array_values($holidays);
        sort($holidays);
        $data_save = array('cache_key' => $this->cache_key, 'cache_value' => json_encode($holidays));
        $cache->save_data($data_save, $this->cache_key);
        \Fuel\Core\Session::set_flash('delete_success', '削除しました');
        return new \Response(1, 200, array());
    }

    /**
     * @return \Response
     */
    public function action_save()
    {
        $holidays_date = Input::post('date_holiday');
        $cache = new \Model_Cache();
        $holidays = $cache->get_info_data($this->cache_key);
        $is_new = false;
        if ($holidays === false) {
            $is_new = true;
            $holidays = [];
        }
        // Check date
        if (array_search($holidays_date, $holidays) !== false) {
            \Fuel\Core\Session::set_flash('add_error', '登録済み日付は登録できません');
        } elseif (\Utility::validate_date($holidays_date) == false) {
            \Fuel\Core\Session::set_flash('add_error', '日付が正しくありません');
        } elseif (strtotime($holidays_date) < time() && date('d', strtotime($holidays_date)) != date('d')) {
            \Fuel\Core\Session::set_flash('add_error', '過去日付は登録できません');
        } else {
            $holidays[] = $holidays_date;
            sort($holidays);
            $data_save = array('cache_key' => $this->cache_key, 'cache_value' => json_encode($holidays));
            if ($is_new) {
                $cache->save_data($data_save);
            } else {
                $cache->save_data($data_save, $this->cache_key);
            }

            \Fuel\Core\Session::set_flash('add_success', '保存しました');
        }
        return new \Response(1, 200, array());
    }
}
