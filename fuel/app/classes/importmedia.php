<?php

class ImportMedia
{
    public $error = array();
    public $no_update = array();

    function __construct()
    {
    }

    public function get_errors()
    {
        return $this->error;
    }

    static public function field_db()
    {
        return array(
            'm_media_id' => '媒体ID',
            'partner_code' => '取引先コード',
            'media_name' => '媒体名',
            'media_version_name' => '版名',
            'type' => '自他区分',
            'budget_type' => '予算区分',
            'classification' => '分類',
            'is_web_reprint' => 'WEB転載',
            'public_description' => '掲載・公開について',
            'deadline_description' => '締め切り',
            'name' => '掲載枠名称',
            'count' => '掲載枠拠点数',
            'price' => '掲載枠単価',
            'note' => '掲載枠備考',
        );
    }

    static public function field_db_media()
    {
        return array(
            'm_media_id' => '媒体ID',
            'partner_code' => '取引先コード',
            'media_name' => '媒体名',
            'media_version_name' => '版名',
            'type' => '自他区分',
            'budget_type' => '予算区分',
            'classification' => '分類',
            'is_web_reprint' => 'WEB転載',
            'public_description' => '掲載・公開について',
            'deadline_description' => '締め切り',
        );
    }

    static public function convert_utf8($file)
    {
        $data = file_get_contents($file);
        if (mb_detect_encoding($data, 'UTF-8', true) === false) {
            $encode_ary = array(
                'ASCII',
                'JIS',
                'eucjp-win',
                'sjis-win',
                'EUC-JP',
                'UTF-8',
            );
            $data = mb_convert_encoding($data, 'UTF-8', $encode_ary);
        }

        $fp = tmpfile();
        fwrite($fp, $data);
        rewind($fp);
        return $fp;
    }

    public function get_file_csv($file, &$total_field)
    {
        $fp = self::convert_utf8($file);
        $k = 0;
        $arr_data = array();
        while (($data = fgetcsv($fp, 10000, ',')) !== false) {
            if ($k > 0) {
                $arr_data[] = $data;
            } else {
                $total_field = count($data);
            }
            ++$k;
        }

        return $arr_data;
    }

    public function data_once_csv($data, $total_field)
    {
        $field_media = array_keys(self::field_db_media());
        $arr_media = array();
        $arr_post = array();
        $all_data = array();
        for ($i = 0; $i < 10; ++$i) {
            $arr_media[$field_media[$i]] = $data[$i];
        }
        // convert type
        if ($arr_media['type'] == '自力')
            $arr_media['type'] = 1;
        elseif ($arr_media['type'] == '他力')
            $arr_media['type'] = 2;
        elseif (trim($arr_media['type']) == '')
            $arr_media['type'] = null;
        else
            $arr_media['type'] = 0;
        // convert budget type
        if ($arr_media['budget_type'] == '求人費')
            $arr_media['budget_type'] = 1;
        elseif ($arr_media['budget_type'] == '販促費')
            $arr_media['budget_type'] = 2;
        elseif (trim($arr_media['budget_type']) == '')
            $arr_media['budget_type'] = null;
        else
            $arr_media['budget_type'] = 0;
        // convert web_reprint
        if ($arr_media['is_web_reprint'] == 'あり') {
            $arr_media['is_web_reprint'] = 1;
        } elseif ($arr_media['is_web_reprint'] == 'なし') {
            $arr_media['is_web_reprint'] = 0;
        } elseif (trim($arr_media['is_web_reprint']) == '')
            $arr_media['is_web_reprint'] = null;
        else
            $arr_media['is_web_reprint'] = -1;

        $media_classification_flip = array_flip(Constants::$media_classification);

        if ($arr_media['classification'])
            $arr_media['classification'] = isset($media_classification_flip[$arr_media['classification']]) ? $media_classification_flip[$arr_media['classification']] : 0;
        else
            $arr_media['classification'] = null;
        // get data post
        $data_post = array_slice($data, 10);
        $j = 0;
        for ($i = 0; $i < $total_field - 10; $i = $i + 4) {
            $arr_post[$j]['name'] = isset($data_post[$i]) ? $data_post[$i] : '';
            $arr_post[$j]['count'] = isset($data_post[$i + 1]) ? $data_post[$i + 1] : '';
            $arr_post[$j]['price'] = isset($data_post[$i + 2]) ? $data_post[$i + 2] : '';
            $arr_post[$j]['note'] = isset($data_post[$i + 3]) ? $data_post[$i + 3] : '';
            ++$j;
        }

        $all_data['media'] = $arr_media;
        $all_data['post'] = $arr_post;

        return $all_data;
    }

    private function get_length($str)
    {
        return mb_strlen($str);
    }

    static public function set_mes_overlength($field, $index, $num)
    {
        $field_db = self::field_db();
        return $index . '行目:' . $field_db[$field] . 'は' . $num . '文字以内で入力して下さい';

    }

    static public function set_mes_error_data($field, $index)
    {
        $field_db = self::field_db();
        return $index . '行目:' . $field_db[$field] . 'が正しくありません';
    }

    static public function set_mes_require($field, $index)
    {
        $field_db = self::field_db();
        return $index . '行目:' . $field_db[$field] . 'を入力して下さい';
    }

    public function validate($data, $data_post, $index)
    {

        $media_obj = new Model_Mmedia();
        $partner_obj = new  Model_Mpartner();
        // check media
		if ($data['m_media_id'])
		{
	        $media_check = $media_obj->find_by_pk($data['m_media_id']);
			if (!count($media_check)) {
				$this->error[$index]['m_media_id'] = $index . '行目:媒体IDを存在しません';
			}
		}

        // check partner
        if(trim($data['partner_code']) == '') {
            $this->error[$index]['partner_code'] = $index . '行目:取引先コードを入力して下さい';
        }else {
            $partner_check = $partner_obj->find_by_pk($data['partner_code']);
            if (!count($partner_check)) {
                $this->error[$index]['partner_code'] = $index . '行目:取引先コードが存在しません。';
            }
        }
        // validate media
        if ($this->get_length($data['media_name']) > 20) {
            $this->error[$index]['media_name'] = self::set_mes_overlength('media_name', $index, 20);
        }
        if (trim($data['media_name']) == '') {
            $this->error[$index]['media_name'] = self::set_mes_require('media_name', $index);
        }
        if (trim($data['media_version_name']) == '') {
            $this->error[$index]['media_version_name'] = self::set_mes_require('media_version_name', $index);
        }

        if ($this->get_length($data['media_version_name']) > 50) {
            $this->error[$index]['media_version_name'] = self::set_mes_overlength('media_version_name', $index, 50);
        }
        /*Type*/
        if ($data['type'] === 0) {
            $this->error[$index]['type'][] = self::set_mes_error_data('type', $index);
        }
        if ($data['type'] === null) {
            $this->error[$index]['type'][] = self::set_mes_require('type', $index);
        }
        /*Budget type*/
        if ($data['budget_type'] === 0) {
            $this->error[$index]['budget_type'] = self::set_mes_error_data('budget_type', $index);
        }
        if ($data['budget_type'] === null) {
            $this->error[$index]['budget_type'] = self::set_mes_require('budget_type', $index);
        }

        if ($data['classification'] === null) {
            $this->error[$index]['classification'] = self::set_mes_require('classification', $index);
        }
        if ($data['classification'] === 0) {
            $this->error[$index]['classification'] = self::set_mes_error_data('classification', $index);
        }
        if ($data['is_web_reprint'] === null) {
            $this->error[$index]['is_web_reprint'] = self::set_mes_require('is_web_reprint', $index);
        }
        if ($data['is_web_reprint'] == -1) {
            $this->error[$index]['is_web_reprint'] = self::set_mes_error_data('is_web_reprint', $index);
        }
        if ($this->get_length($data['public_description']) > 20) {
            $this->error[$index]['public_description'] = self::set_mes_overlength('public_description', $index, 20);
        }
        if ($this->get_length($data['deadline_description']) > 20) {
            $this->error[$index]['deadline_description'] = self::set_mes_overlength('deadline_description', $index, 20);
        }

        // validate post
        $k = 1;
        foreach ($data_post as $post) {
            if ($this->get_length($post['name']) > 20) {
                $this->error[$index]['name'] = self::set_mes_overlength('name', $index . '(掲載枠' . $k . '名称)', 20);
            }
            if ($post['count'] && !preg_match('/^[0-9]+$/', $post['count'])) {
                $this->error[$index]['count'] = self::set_mes_error_data('count', $index . '(掲載枠' . $k . '拠点数)');
            }

            if ((int)$post['count'] > 2147483647 || (int)$post['count'] < 0) {
                $this->error[$index]['count'] = self::set_mes_error_data('count', $index . '(掲載枠' . $k . '拠点数)');
            }
            if ($post['price'] && !preg_match('/^[0-9]+$/', $post['price'])) {
                $this->error[$index]['price'] = self::set_mes_error_data('price', $index . '(掲載枠' . $k . '単価)');
            }

            if ((int)$post['price'] > 2147483647 || (int)$post['price'] < 0) {
                $this->error[$index]['price'] = self::set_mes_error_data('price', $index . '(掲載枠' . $k . '単価)');
            }

            if ($this->get_length($post['note']) > 100) {
                $this->error[$index]['note'] = self::set_mes_overlength('note', $index . '(掲載枠' . $k . '備考)', 100);
            }

            ++$k;
        }

        if (count($this->error))
            return false;

        return true;
    }

    public function update_csv($file)
    {
        $m_media = new  Model_Mmedia();
        $m_post = new Model_Mpost();
        $total_field = 0;
        $data = $this->get_file_csv($file, $total_field);
        if (!count($data)) {
            return false;
        }
        $k = 2;
        foreach ($data as $row) {
            $data_one = self::data_once_csv($row, $total_field);
            $this->validate($data_one['media'], $data_one['post'], $k);
            ++$k;
        }

        if (count($this->get_errors())) {
            return false;
        }

        $k = 2;
        \DB::start_transaction();
        try {
            $check = true;
            foreach ($data as $row) {
                if (!$check) {
                    break;
                }
                $data_one = self::data_once_csv($row, $total_field);
                $check = $validate_field = $this->validate($data_one['media'], $data_one['post'], $k);
                if ($validate_field) {
                    $check = $res = $m_media->save_data($data_one['media']);
                    if ($res) {
						$media_id = null;
						if ($data_one['media']['m_media_id']) {
							$media_id = $data_one['media']['m_media_id'];
							$post_counter = 0;
							foreach ($m_post->get_list_by_media($media_id) as $post) {
								$data_one['post'][$post_counter]['post_id'] = $post['post_id'];
								$post_counter++;
							}
						} else {
							$media_id = (int)$res[0];
						}
                        $check = $m_post->save_multi_post($data_one['post'], $media_id);
                    }
                }
                ++$k;
            }

            if (!$check) {
                \DB::rollback_transaction();
            } else {
                \DB::commit_transaction();
            }
        } catch (Exception $e) {
            // rollback pending transactional queries
            \DB::rollback_transaction();
            throw $e;
        }

        return $check;
    }
}
