<?php

class ExportMedia
{
    static public function get_title($total_post)
    {
        $arr_title = array(
            '媒体ID',
            '取引先コード',
            '媒体名',
            '版名',
            '自他区分',
            '予算区分',
            '分類',
            'WEB転載',
            '掲載・公開について',
            '締め切り'
        );
        for ($i = 1; $i <= $total_post; ++$i) {
            array_push($arr_title, '掲載枠' . $i . '名称');
            array_push($arr_title, '掲載枠' . $i . '拠点数');
            array_push($arr_title, '掲載枠' . $i . '単価');
            array_push($arr_title, '掲載枠' . $i . '備考');
        }
        return $arr_title;
    }

    static public function field($data)
    {
        $data = get_object_vars($data);
        $m_post = new Model_Mpost();
        $list_post = $m_post->get_list_by_media($data['m_media_id']);
        $arr_data = array(
            '0' => $data['m_media_id'],
            '1' => $data['partner_code'],
            '2' => $data['media_name'],
            '3' => $data['media_version_name'],
            '4' => $data['type'] == 1 ? '自力' : '他力',
            '5' => $data['budget_type'] == 1 ? '求人費' : '販促費',
            '6' => isset(Constants::$media_classification[$data['classification']]) ? Constants::$media_classification[$data['classification']] : '',
            '7' => $data['is_web_reprint'] == 1 ? 'あり' : 'なし',
            '8' => $data['public_description'],
            '9' => $data['deadline_description'],
        );

        if (count($list_post)) {
            foreach ($list_post as $post) {
                array_push($arr_data, $post['name']);
                array_push($arr_data, $post['count']);
                array_push($arr_data, $post['price']);
                array_push($arr_data, $post['note']);
            }
        }

        return $arr_data;
    }
}
