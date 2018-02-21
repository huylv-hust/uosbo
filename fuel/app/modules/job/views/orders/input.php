<style>
    div.ss-block {
        margin-bottom: 5px;
    }
    button[name=remove-ss-btn] {
        margin-left: 10px;
    }
</style>
<?php
if (isset($info)) {
    $orderinfo = $info;
} else {
    $orderinfo = $properties;
}
?>
<h3>オーダー<?php //echo $orderinfo['status'];?></h3>
<?php if (\Session::get_flash('error')) { ?>
    <div role="alert" class="alert alert-danger alert-dismissible">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo \Session::get_flash('error'); ?>
    </div>
<?php } ?>
<div class="text-right" style="padding-bottom: 5px;">

    <a class="btn btn-warning btn-sm"
       href="<?php echo \Fuel\Core\Cookie::get('return_url_search') ? \Fuel\Core\Cookie::get('return_url_search') : \Fuel\Core\Uri::base() . 'job/orders'; ?>">
        <i class="glyphicon glyphicon-arrow-left icon-white"></i>
        戻る
    </a>
</div>
<?php $user_login = \Fuel\Core\Session::get('login_info'); ?>
<script>
    //set order_id and status for validate post_date
    var order_id = '<?php echo \Input::get('order_id'); ?>';
    var order_status = '<?php echo isset($orderinfo['status']) ? $orderinfo['status'] : ''; ?>';
    var division_type = '<?php echo $user_login['division_type']; ?>';
    var action = '<?php echo \Input::get('action'); ?>';
</script>
<?php //echo Form::open(array('id' => 'order-input', 'method' => 'post', 'class' => 'form-inline')); ?>
<form method="post" id="order-input" class="form-inline">
    <table class="table table-striped">
        <tbody>
        <tr>
            <th class="text-right">申請日</th>
            <td>
                <?php echo Form::input('apply_date', Input::post('apply_date', isset($post) ? $post->apply_date : $orderinfo['apply_date']), array('class' => 'form-control dateform', 'size' => 12, 'onchange' => 'get_remaining_cost(' . \Fuel\Core\Input::get('order_id', '') . ')')); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">掲載期間</th>
            <td>
                <?php
                $postdateArr = array('class' => 'form-control dateform', 'size' => 12);
                if ($user_login['division_type'] != 1) {
                    $postdateArr['disabled'] = 'disabled ';
                }
                ?>
                <?php echo Form::input('post_date', Input::post('post_date', isset($post) ? $post->post_date : $orderinfo['post_date']), $postdateArr); ?>
                ～
                <?php echo Form::input('close_date', Input::post('close_date', isset($post) ? $post->close_date : $orderinfo['close_date']), $postdateArr); ?>
                <span class="text-info">※管理者のみ入力可、確定処理の場合必須</span>
                <label id="form_post_date-error" class="error" for="form_post_date"></label>
            </td>
        </tr>
        <tr>
            <th class="text-right">
                対象SS
                <button type="button" class="btn btn-sm btn-success" name="findss-btn">
                    <i class="glyphicon glyphicon-search icon-white"></i>
                </button>
            </th>
            <td>
                <span id="ss-name">
                     <?php
                     if (\Fuel\Core\Input::get('order_id')) {
                         echo $ss['name'].' '.$ss['branch_name'].' '.$ss['ss_name'];
                     } else
                         echo '※未選択';
                     ?>
                </span>
                <input type="hidden" name="ss_id" id="ss_id"
                       value="<?php if (\Fuel\Core\Input::get('order_id', '')) echo $orderinfo['ss_id']; else echo '';; ?>"/>
                <button type="button" class="btn btn-danger btn-sm hide" name="add-delete-btn">
                    <i class="glyphicon glyphicon-trash icon-white"></i>
                </button>
            </td>
        </tr>
        <tr id="show-work" style="<?php echo \Fuel\Core\Input::get('order_id', 0) ? '' : 'display:none'; ?>">
            <th class="text-right text-work">売上形態</th>
            <td>
                <div id="agreement">
                    <?php
                    //echo Form::select('agreement_type', Input::post('agreement_type', isset($post) ? $post->agreement_type : $orderinfo['agreement_type']), Constants::$sale_type, array('class'=>'form-control'));
                    ?>
                </div>
                <p></p>
                <div class="panel panel-info" style="min-height:140px">
                    <div class="panel-body"
                         style="display:<?php echo \Fuel\Core\Input::get('order_id', 0) ? 'block' : 'none'; ?>;">
                    </div>
                </div>

            </td>
        </tr>

        <tr>
            <th class="text-right">所在地</th>
            <td>
                <?php echo Form::input('location', Input::post('location', isset($post) ? $post->location : $orderinfo['location']), array('class' => 'form-control', 'size' => 80, 'readonly' => 'readonly')); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">アクセス</th>
            <td>
                <?php echo Form::input('access', Input::post('access', isset($post) ? $post->access : $orderinfo['access']), array('class' => 'form-control', 'size' => 80, 'readonly' => 'readonly')); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">要請日</th>
            <td>
                <?php echo Form::input('request_date', Input::post('request_date', isset($post) ? $post->request_date : $orderinfo['request_date']), array('class' => 'form-control dateform', 'size' => 12)); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">申請理由</th>
            <td>
                <?php $apply_reason = array('', '新規受注', '前回の募集で集まらなかった', 'スタッフ退職の為', 'その他'); ?>
                <?php echo Form::select('apply_reason', Input::post('apply_reason', isset($post) ? $post->apply_reason : $orderinfo['apply_reason']), $apply_reason, array('class' => 'form-control')); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">申請詳細</th>
            <td>
                <?php echo Form::input('apply_detail', Input::post('apply_detail', isset($post) ? $post->apply_detail : $orderinfo['apply_detail']), array('class' => 'form-control', 'size' => 80)); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">要請人数</th>
            <td class="parent">
                <div class="input-group">
                    <?php echo Form::input('request_people_num', Input::post('request_people_num', isset($post) ? $post->request_people_num : $orderinfo['request_people_num']), array('class' => 'form-control', 'size' => 5)); ?>
                    <div class="input-group-addon">人</div>
                </div>
            </td>
        </tr>
        <tr>
            <th class="text-right">勤務時間</th>
            <td>
                <?php echo Form::textarea('work_date', Input::post('work_date', isset($post) ? $post->work_date : $orderinfo['work_date']), array('class' => 'form-control', 'cols' => 77, 'rows' => 5)); ?>
                <p></p>
                <div>
                    <div class="input-group">
                        <div class="input-group-addon">月</div>
                        <?php echo Form::input('work_time_of_month', Input::post('work_time_of_month', isset($post) ? $post->work_time_of_month : $orderinfo['work_time_of_month']), array('class' => 'form-control', 'size' => 5)); ?>
                        <div class="input-group-addon">時間程度</div>
                    </div>
                    <label id="form_work_time_of_month" class="error" for="form_work_time_of_month"></label>
                    　
                    <div class="input-group">
                        <div class="input-group-addon">週</div>
                        <?php echo Form::input('work_days_of_week', Input::post('work_days_of_week', isset($post) ? $post->work_days_of_week : $orderinfo['work_days_of_week']), array('class' => 'form-control', 'size' => 2)); ?>
                        <div class="input-group-addon">日程度</div>
                    </div>
                    <label id="form_work_days_of_week-error" class="error" for="form_work_days_of_week"></label>
                </div>
            </td>
        </tr>
        <tr>
            <th class="text-right">社会保険</th>
            <td>
                <label class="radio-inline"><input type="radio" name="is_insurance" value="1"
                                                   checked="checked"/>あり</label>
                <label class="radio-inline"><input type="radio" name="is_insurance"
                                                   value="0" <?php if ($orderinfo['is_insurance'] == 0) {
                        echo 'checked="checked"';
                    } ?>/>なし</label>
                <span class="text-info">※いずれか必須</span>
            </td>
        </tr>
        <tr>
            <th class="text-right">土日の勤務</th>
            <td>
                <?php $holiday_work = array('', '土日祝すべて勤務', '土日祝いずれか勤務', '土日祝休みの相談ＯＫ'); ?>
                <?php echo Form::select('holiday_work', Input::post('holiday_work', isset($post) ? $post->holiday_work : $orderinfo['holiday_work']), $holiday_work, array('class' => 'form-control')); ?>
            </td>
        </tr>

        <tr>
            <th class="text-right">必要資格</th>
            <td>
                <?php echo Form::input('require_des', Input::post('require_des', isset($post) ? $post->require_des : $orderinfo['require_des']), array('class' => 'form-control', 'size' => 80)); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">優遇資格</th>
            <td>
                <?php echo Form::input('require_experience', Input::post('require_experience', isset($post) ? $post->require_experience : $orderinfo['require_experience']), array('class' => 'form-control', 'size' => 80)); ?>
            </td>
        </tr>
        <tr class="hide">
            <th class="text-right">資格(メリット他)</th>
            <td>
                <?php echo Form::input('require_other', Input::post('require_other', isset($post) ? $post->require_other : $orderinfo['require_other']), array('class' => 'form-control', 'size' => 80)); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">年齢</th>
            <td>
                <?php echo Form::input('require_age', Input::post('require_age', isset($post) ? $post->require_age : $orderinfo['require_age']), array('class' => 'form-control', 'size' => 80)); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">性別</th>
            <td>
                <?php echo Form::input('require_gender', Input::post('require_gender', isset($post) ? $post->require_gender : $orderinfo['require_gender']), array('class' => 'form-control', 'size' => 80)); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">資格(Ｗワーク)</th>
            <td>
                <input type="hidden" name="total_ss" id="total_ss"
                       value="<?php if (\Fuel\Core\Input::get('order_id', 0)) echo $post_info['count']; else echo 0; ?>"
                       readonly="readonly"/>
                <?php echo Form::input('require_w', Input::post('require_w', isset($post) ? $post->require_w : $orderinfo['require_w']), array('class' => 'form-control', 'size' => 80)); ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">
                掲載媒体
                <button type="button" class="btn btn-sm btn-success" name="findmedia-btn">
                    <i class="glyphicon glyphicon-search icon-white"></i>
                </button>
            </th>
            <td id="medias">
                <div id="media-name">
                    <?php
                    if (\Fuel\Core\Input::get('order_id', 0))
                        echo $group_edit['name'].' '.$partner_edit['branch_name'].' '.$media['media_name'].' '.$media['media_version_name'];
                    else
                        echo '※未選択';
                    ?>

                </div>
                <p></p>
                <div class="media">
                    <div class="input-group">
                        <div class="input-group-addon">掲載枠</div>
                        <select name="list_post" class="form-control post-item post-item0 valid" datastt="0"
                                aria-required="true" aria-invalid="false">
                            <?php
                            if (\Fuel\Core\Input::get('order_id', 0)) {
                                echo '<option value="">掲載枠を選択して下さい</option>';
                                foreach ($post_same_media as $post_same) {
                                    if ($post_same['post_id'] == $orderinfo['post_id'])
                                        echo '<option selected="selected" data-price = "' . $post_same['price'] . '" value="' . $post_same['post_id'] . '">' . $media['media_name'] . $post_same['name'] . '</option>';
                                    else
                                        echo '<option data-price = "' . $post_same['price'] . '" value="' . $post_same['post_id'] . '">' . $media['media_name'] . $post_same['name'] . '</option>';
                                }
                            } else echo '<option value="">掲載枠を選択して下さい</option>';
                            ?>

                        </select>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">掲載金額</div>
                        <input value="<?php echo \Fuel\Core\Input::get('order_id', 0) ? $orderinfo['price'] : ''; ?>"
                               name="price" class="form-control post_price_item" size="10" type="text">
                        <div class="input-group-addon">円</div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th class="text-right">
                一緒に掲載する勤務地
                <button type="button" class="btn btn-success btn-sm" name="add-ss-btn"
                        id="button_ss_list" <?php if (!\Fuel\Core\Input::get('order_id', 0)) echo 'disabled' ?>>
                    <i class="glyphicon glyphicon-plus icon-white"></i>
                </button>
                <input type="hidden" name="ss_list"
                       value="<?php echo \Fuel\Core\Input::get('order_id', 0) ? $orderinfo['ss_list'] : ''; ?>"
                       id="ss_list"/>
                <div>
                    <span class="text-info">あと<strong
                            id="total-ss"><?php if (\Fuel\Core\Input::get('order_id', 0)) echo $post_info['count']; else echo 0; ?></strong>個可能</span>
                </div>
            </th>
            <td id="copy-ss">
                <?php
                if (\Fuel\Core\Input::get('order_id', 0)) {
                    foreach ($list_ss_edit as $ss_temp) {
                        echo '<div class="ss-block">';
                        echo '<span id="' . $ss_temp['ss_id'] . '">' .$ss_temp['name'].' '.$ss_temp['branch_name'].' '. $ss_temp['ss_name'] . '</span>';
                        echo '<button type="button" class="btn btn-danger btn-sm" name="remove-ss-btn">
                                <i class="glyphicon glyphicon-trash icon-white"></i>
                            </button>';
                        echo '</div>';
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <th class="text-right">備考</th>
            <td>
                <?php echo Form::textarea('notes', Input::post('notes', isset($post) ? $post->notes : $orderinfo['notes']), array('rows' => 5, 'cols' => 77, 'class' => 'form-control')); ?>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="alert alert-danger text-center" role="alert">
        本オーダー発注後の今期残り予算はあと<strong class="show-price"><?php echo number_format(round($remaining_cost)); ?>円</strong>です。
    </div>
    <?php
    $list_author = \Utility::create_array_users($listusers_author);
    $list_sales = \Utility::create_array_users($listusers_sales);
    $list_interview = \Utility::create_array_users($listusers_interview);
    $list_agreement = \Utility::create_array_users($listusers_agreement);
    $list_training = \Utility::create_array_users($listusers_training);
    if (!isset($author_department_id)) {
        $author_department_id = null;
    }
    if (!isset($sales_department_id)) {
        $sales_department_id = null;
    }
    if (!isset($interview_department_id)) {
        $interview_department_id = null;
    }
    if (!isset($agreement_department_id)) {
        $agreement_department_id = null;
    }
    if (!isset($training_department_id)) {
        $training_department_id = null;
    }
    ?>
    <table class="table table-striped">
        <tbody>
        <tr>
            <th class="text-right">作成者</th>
            <td>
                <?php $userDefault = '部門を選択してください'; ?>
                <div class="input-group">
                    <div class="input-group-addon">部門</div>
                    <?php echo Form::select('select_author_user_id', Input::post('select_author_user_id', isset($post) ? $post->select_author_user_id : $author_department_id), \Constants::get_search_department($userDefault), array('class' => 'form-control user_id', 'data-type' => 'author')); ?>
                </div>
                <div class="input-group">
                    <div class="input-group-addon">担当者</div>
                    <?php echo Form::select('author_user_id', Input::post('author_user_id', isset($post) ? $post->author_user_id : $orderinfo['author_user_id']), $list_author, array('class' => 'form-control')); ?>
                </div>
            </td>
        </tr>
        <tr>
            <th class="text-right">面接</th>
            <td>
                <div class="input-group">
                    <div class="input-group-addon">部門</div>
                    <?php echo Form::select('select_interview_user_id', Input::post('select_interview_user_id', isset($post) ? $post->select_interview_user_id : $interview_department_id), \Constants::get_search_department($userDefault), array('class' => 'form-control user_id', 'data-type' => 'interview')); ?>
                </div>
                <div class="input-group">
                    <div class="input-group-addon">担当者</div>
                    <?php echo Form::select('interview_user_id', Input::post('interview_user_id', isset($post) ? $post->interview_user_id : $orderinfo['interview_user_id']), $list_interview, array('class' => 'form-control')); ?>
                </div>
                <span class="text-info">※必須</span>
            </td>
        </tr>
        <tr>
            <th class="text-right">契約</th>
            <td>
                <div class="input-group">
                    <div class="input-group-addon">部門</div>
                    <?php echo Form::select('select_agreement_user_id', Input::post('select_agreement_user_id', isset($post) ? $post->select_agreement_user_id : $agreement_department_id), \Constants::get_search_department($userDefault), array('class' => 'form-control user_id', 'data-type' => 'agreement')); ?>
                </div>
                <div class="input-group">
                    <div class="input-group-addon">担当者</div>
                    <?php echo Form::select('agreement_user_id', Input::post('agreement_user_id', isset($post) ? $post->agreement_user_id : $orderinfo['agreement_user_id']), $list_agreement, array('class' => 'form-control')); ?>
                </div>
                <span class="text-info">※必須</span>
            </td>
        </tr>
        <tr>
            <th class="text-right">研修</th>
            <td>
                <div class="input-group">
                    <div class="input-group-addon">部門</div>
                    <?php echo Form::select('select_training_user_id', Input::post('select_training_user_id', isset($post) ? $post->select_training_user_id : $training_department_id), \Constants::get_search_department($userDefault), array('class' => 'form-control user_id', 'data-type' => 'training')); ?>
                </div>
                <div class="input-group">
                    <div class="input-group-addon">担当者</div>
                    <?php echo Form::select('training_user_id', Input::post('training_user_id', isset($post) ? $post->training_user_id : $orderinfo['training_user_id']), $list_training, array('class' => 'form-control')); ?>
                </div>
            </td>
        </tr>

        </tbody>
    </table>

    <div class="text-center">
        <?php
        $show_submit = true;
        $show_date = false;
        if (($orderinfo['status'] == 2 || $orderinfo['status'] == 3) && \Input::get('action') != 'copy') {
            $show_submit = false;
            $show_date = true;
        }
        ?>
        <?php if ($show_submit) { ?>
            <button type="<?php echo $show_date == true ? 'button' : 'submit'; ?>"
                    class="btn btn-primary btn-sm show-post" <?php echo $show_date == true ? 'id="date-only"' : ''; ?>>
                <i class="glyphicon glyphicon-pencil icon-white"></i>
                保存
            </button>
        <?php } ?>
        <?php $user_login = Session::get('login_info'); ?>
        <?php if (\Input::get('order_id') && \Input::get('action') != 'copy' && $orderinfo['status'] != 2 && $orderinfo['status'] != 3 && $orderinfo['status'] != 1 && ($user_login['division_type'] == 1 || $user_login['division_type'] == 2)) { ?>
            <button type="button" class="btn btn-primary btn-sm popup" data-status="1">
                <i class="glyphicon glyphicon-thumbs-up icon-white"></i>
                承認
            </button>
            <?php if ($orderinfo['status'] != -1) { ?>
                <button type="button" class="btn btn-primary btn-sm popup" data-status="-1">
                    <i class="glyphicon glyphicon-thumbs-down icon-white"></i>
                    非承認
                </button>
            <?php }
        } ?>
    </div>
</form>

<style type="text/css">
    #dialog {
        text-align: center
    }

    #dialog button {
        margin: 10px;
        padding: 0px 4px
    }
</style>

<div id="dialog" title="オーダーの承認">
</div>
<div class="hide">
    <div class="ss-block">
        <span class="ss-name"></span>
        <button type="button" class="btn btn-danger btn-sm" name="remove-ss-btn">
            <i class="glyphicon glyphicon-trash icon-white"></i>
        </button>
    </div>
</div>
<div id="ssfinder_multi" class="modal fade in" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title">SS検索</h4>
            </div>
            <div class="modal-body">
                <form mehod="get">
                    <div class="form-group">
                        <label>法人名/支店名/SS名/SS住所</label>
                        <div class="form-inline">
                            <input class="form-control" placeholder="法人名/支店名/SS名/SS住所" type="text" id="keyword_search_ss_multi" size="100">
                            <button type="button" class="btn btn-primary btn-sm" id="search_ss_multi">
                                <i class="glyphicon glyphicon-search icon-white"></i>
                            </button>
                        </div>
                        <div class="text-info">※複数指定はスペース区切り(AND検索)</div>
                    </div>

                    <div class="row container-fluid">
                        <div class="list-group" id="search_ss_multi_result">
                            <span class="list-group-item disabled">検索結果</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="ssfinder" class="modal fade in" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title">SS検索</h4>
            </div>
            <div class="modal-body">
                <form mehod="get">
                    <div class="form-group">
                        <label>法人名/支店名/SS名/SS住所</label>
                        <div class="form-inline">
                            <input class="form-control" placeholder="法人名/支店名/SS名/SS住所" type="text" id="keyword_search_ss" size="100">
                            <button type="button" class="btn btn-primary btn-sm" id="search_ss">
                                <i class="glyphicon glyphicon-search icon-white"></i>
                            </button>
                        </div>
                        <div class="text-info">※複数指定はスペース区切り(AND検索)</div>
                    </div>

                    <div class="row container-fluid">
                        <div class="list-group" id="search_ss_result">
                            <span class="list-group-item disabled">検索結果</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="mediafinder" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title">媒体検索</h4>
            </div>
            <div class="modal-body">
                <form mehod="get">
                    <div class="form-group">
                        <label>法人名/支店名/媒体名</label>
                        <div class="form-inline">
                            <input class="form-control" placeholder="法人名/支店名/媒体名" type="text" id="keyword_search_media" size="100">
                            <button type="button" class="btn btn-primary btn-sm" id="search_media">
                                <i class="glyphicon glyphicon-search icon-white"></i>
                            </button>
                        </div>
                        <div class="text-info">※複数指定はスペース区切り(AND検索)</div>
                    </div>

                    <div class="row container-fluid">
                        <div class="list-group" id="search_media_result">
                            <span class="list-group-item disabled" datatype="0">検索結果</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo Asset::js('validate/order-input.js'); ?>
<script type="text/javascript">
    function get_remaining_cost(order_id) {
        var apply_date = $('#form_apply_date').val();
        var ss_id = $('#ss_id').val();
        var object = $('.show-price');
        if (apply_date == '' || ss_id == '') {
            object.html('0円');
            return false;
        }
        var order_price = parseInt($('input[name=price]').val());
        if (isNaN(order_price)) {
            order_price = 0;
        }
        var ss_list = $('#ss_list').val();
        $.getJSON(
            baseUrl + 'ajax/orders/cost',
            {
                ss_id: ss_id,
                ss_list: ss_list,
                price: order_price
            }
        ).done(function (response) {
            var ss_cost = response['price'];
            $.getJSON(
                baseUrl + 'ajax/orders/balance',
                {
                    date: apply_date,
                    ss_id: ss_id,
                    exclude_order_id: order_id
                }
            ).done(function (response) {
                object.text((response['price'] - ss_cost) + '円');
            });
        });
    }
    function get_local_access(ss_id) {
        var location = $('input[name=location]');
        var access = $('input[name=access]');
        if (ss_id == '' || ss_id == null) {
            location.val('');
            access.val('');
            return false;
        }
        $.post(baseUrl + 'ajax/orders/ssinfo', {ss_id: ss_id}, function (result) {
            var data = jQuery.parseJSON(result);
            var info = data['ssinfo'];
            var addr1 = data['addr1'];
            var addr2 = info[0]['addr2'] != null ? info[0]['addr2'] + ' ' : '';
            var addr3 = info[0]['addr3'] != null ? info[0]['addr3'] : '';
            location.val(addr1 + ' ' + addr2 + ' ' + addr3);
            access.val(info[0]['access']);
        });
    }
    function get_agreement_type(ss_id, agreement_type) {
        var string = '<select class="form-control" name="agreement_type" id="form_agreement_type"><option value=""></option>';
        var agreement_obj = $('#agreement');
        var work_obj = $('#show-work');
        $('.panel-body').html('');
        work_obj.show();
        if (ss_id == '') {
            work_obj.hide();
            return false;
        }
        $.post(baseUrl + 'ajax/orders', {ss_id: ss_id}, function (result) {
            var sale_type_obj = {'1': '直接雇用', '2': '職業紹介', '3': '派遣', '4': '紹介予定派遣', '5': '請負', '6': '求人代行'};
            var data = jQuery.parseJSON(result);
            var agreement = data['list_sales'];
            for (var i = 0; i < agreement.length; i++) {
                sale_type_id = agreement[i].sale_type;
                sale_name = '';
                if (agreement[i].sale_name != null) {
                    sale_name = agreement[i].sale_name;
                }
                if (sale_type_id == null != sale_type_id == '') {
                    sale_type = '';
                } else {
                    sale_type = sale_type_obj[sale_type_id] != undefined ? sale_type_obj[sale_type_id] : '';
                }
                if (agreement_type == agreement[i].sssale_id) {
                    string += '<option value=' + agreement[i].sssale_id + ' selected="selected">' + sale_type + sale_name + '</option>';
                } else {
                    string += '<option value=' + agreement[i].sssale_id + '>' + sale_type + sale_name + '</option>';
                }
            }
            string += '</select>';
            agreement_obj.html(string);

            if ((order_status == 2 || order_status == 3) && action != 'copy') {
                $('#order-input input').prop('disabled', true);
                $('#form_agreement_type').prop('disabled', true);
            }
        });
    }
    function get_work_type(sssale_id, agreement_type, work_type) {
        var panel_body = $('.panel-body');
        panel_body.show();
        if (sssale_id == '') {
            panel_body.html('');
            return false;
        }
        $.post(baseUrl + 'ajax/orders/worktype', {
            sssale_id: sssale_id,
            work_type: work_type,
            agreement_type: agreement_type,
            status: order_status,
            action: action
        }, function (result) {
            panel_body.html(result);
        });

        if ((order_status == 2 || order_status == 3 ) && action != 'copy') {
            $('#order-input input').attr('disabled', 'disabled');
        }
    }
    function total_ss() {
        var post_id = $('select.post-item').val();
        if (post_id == '') {
            $('input[name=total_ss]').val(0);
            $('#total-ss').html(0);
            return false;
        }
        $.post(baseUrl + 'ajax/orders/postinfo', {post_id: post_id}, function (data) {
            var result = jQuery.parseJSON(data);
            var postcount = result['postcount'];
            var total_ss = postcount - 1;
            var sslength = $('td#copy-ss div.ss-block').length;
            total_ss = total_ss - sslength;
            if (total_ss < 0) {
                total_ss = 0;
            }
            $('input[name=total_ss]').val(total_ss);
            $('#total-ss').html(total_ss);
        });
    }
    $(document).ready(function () {
        $('select.user_id').change(function () {
            var type = $(this).attr('data-type');
            var department_id = $(this).val();
            strString = '<option value=""></option>';
            if (department_id == '' || department_id == 0) {
                $('select#form_' + type + '_user_id').html(strString);
                return false;
            }
            $.post(baseUrl + 'job/order/get_users', {department_id: department_id}, function (result) {
                var data = jQuery.parseJSON(result);
                for (var i = 0; i < data['list_user'].length; i++) {
                    strString += '<option value=' + data['list_user'][i].user_id + '>' + data['list_user'][i].name + '</option>';
                }
                $('select#form_' + type + '_user_id').html(strString);
            });
        });
        $("#dialog").dialog({
            autoOpen: false,
            minWidth: 350
        });
        $('button.popup').click(function () {
            var status = $(this).attr('data-status');
            var order_id = '<?php echo \Input::get('order_id'); ?>';
            var html = '<button type="button" data-id="' + order_id + '" class="statubtn" value="1">承認済</button><button class="statubtn" data-id="' + order_id + '" value="0" type="button" class="popupclose">キャンセル</button>';
            if (status == -1) {
                html = '<button type="button" class="statubtn" data-id="' + order_id + '" value="-1">非承認</button><button class="statubtn" data-id="' + order_id + '" value="0" type="button" class="popupclose">キャンセル</button>';
            }
            $("#dialog").html(html);
            $("#dialog").dialog("open");
        });
        $(document).on('click', '#dialog button.statubtn', function () {
            var status = $(this).val();
            var order_id = $(this).attr('data-id');
            if (status == 0) { //hide popup
                $("#dialog").dialog('close');
                return false;
            }
            if (status == 1) { //approved
                if (!confirm('承認します、よろしいですか？')) {
                    return false;
                }
                var imgLoad = '<br /><img src="<?php echo \Uri::base(); ?>assets/img/loading.gif"/>';
                $(this).parent().append(imgLoad);
                $.post(baseUrl + 'job/orders/update_status', {status: status, order_id: order_id}, function (result) {
                    if (result == 'failed') {
                        window.location.href = '<?php echo \Uri::base(); ?>job/orders?lost=true';
                        return false;
                    }
                    if (result == 'true') {
                        window.location.href = '<?php echo \Uri::base(); ?>job/orders';
                    }
                });
            }
            if (status == -1) { //noapproved
                var object = $('.popup_box_' + order_id);
                var html = '<p>非承認の理由</p><form><textarea class="reason_info' + order_id + '" data-stt="' + order_id + '" cols="30" rows="4"></textarea><br /><button type="button" style="float:left" data-stt="' + order_id + '" name="reason">送信</button><div style="float:left" class="loading"></div></form>';
                $("#dialog").html(html);
                $("#dialog").dialog("open");
            }
        });
        $(document).on('click', 'button[name=reason]', function () {
            var order_id = $(this).attr('data-stt');
            var reason = $('textarea.reason_info' + order_id);
            if (reason.val() == '') {
                reason.focus().css('border', '1px solid #F00');
                return false;
            }
            if (!confirm('非承認します。よろしいですか？')) {
                return false;
            }
            var imgLoad = '<br /><img src="<?php echo \Uri::base(); ?>assets/img/loading.gif"/>';
            $('div.loading').html(imgLoad);
            $.post(baseUrl + 'job/orders/update_status', {
                status: -1,
                order_id: order_id,
                reason: reason.val()
            }, function (result) {
                if (result == 'failed') {
                    window.location.href = '<?php echo \Uri::base(); ?>job/orders?lost=true';
                    return false;
                }
                if (result == 'true') {
                    window.location.href = '<?php echo \Uri::base(); ?>job/orders';
                }
            });
        });
        //status = 2, view only
        if ((order_status == 2 || order_status == 3) && action != 'copy') {
            $('#order-input select').prop('disabled', true);
            $('#order-input button').prop('disabled', true);
            $('#order-input input').prop('disabled', true);
            $('#order-input textarea').prop('disabled', true);
            $('#form_agreement_type').prop('disabled', true);
        }
        //update post_date when status = 2
        $(document).on('click', '#date-only', function () {
            var post_date = $('#form_post_date').val();
            if (order_status == 2 && post_date == '') {
                $("#form_post_date-error").html('必須です');
                return false;
            }
            var order_id = '<?php echo \Input::get('order_id'); ?>';
            if (!confirm('保存します、よろしいですか？')) {
                return false;
            }
            $.post(baseUrl + 'job/order/post_date', {post_date: post_date, order_id: order_id}, function (result) {
                if (result == 'true') {

                    var return_url_search = '<?php echo \Cookie::get('return_url_search'); ?>';
                    if (return_url_search) {
                        window.location.href = return_url_search;
                        return false;
                    }
                    window.location.href = '<?php echo \Uri::base(); ?>job/orders';
                }
            });
        });

        // add media
        $('button[name=add-media-btn]').on('click', function () {
            $('#medias').append($('div.media:first').clone());
        });
        // remove media
        $('#medias').on('click', 'button[name=remove-media-btn]', function () {
            if ($('div.media').size() < 2) {
                alert('全てを削除は出来ません');
                return;
            }
            $(this).parents('div.media:first').remove();
        });
        var findss_mode = null;
        $('button[name=findss-btn]').on('click', function () {
            findss_mode = 'single';
            $('#ssfinder').modal();
            return false;
        });
        $('button[name=add-ss-btn]').on('click', function () {
            findss_mode = 'multi';
            $('#ssfinder_multi').modal();
            return false;
        });
        // select ss
        $(document).on('click', '#ssfinder .list-group .list-group-item', function () {
            var ss_id = $(this).attr('id');
            var ss_list = $('#ss_list').val();
            var total_ss = parseInt($("#total-ss").text());
            $("#ss_id").val(ss_id);
            $('#ss-name').text($(this).text());
            get_local_access(ss_id);
            get_agreement_type(ss_id, null);
            get_remaining_cost(<?php echo \Fuel\Core\Input::get('order_id', '')?>);
            $('#ssfinder').modal('hide');
            return false;
        });

        //select ss multi
        $(document).on('click', '#ssfinder_multi .list-group .list-group-item', function () {
            var ss_id = $(this).attr('attr-id');
            var ss_list = $('#ss_list').val();
            var total_ss = parseInt($("#total-ss").text());
            if (ss_list == '' || ss_list == null) ss_list = ',';
            if (total_ss == 0) {
                $('#ssfinder_multi').modal('hide');
                return false;
            }
            var clone = $('div.hide div.ss-block').clone();
            clone.find('.ss-name').text($(this).text()).attr('id', ss_id);
            $('#copy-ss').append(clone);
            $('#ss_list').val(ss_list + ss_id + ',');
            $("#total-ss").html(total_ss - 1);
            get_remaining_cost(<?php echo \Fuel\Core\Input::get('order_id', '')?>);
            $('#ssfinder_multi').modal('hide');
            return false;
        });

        // remove ss
        $('#copy-ss').on('click', 'button[name=remove-ss-btn]', function () {
            var total_ss = $("#total-ss").text();
            var ss_list = $("#ss_list").val();
            var ss_id_remove = $(this).parent('div.ss-block').find('span').attr('id');
            $("#ss_list").val(ss_list.replace(',' + ss_id_remove + ',', ','));
            $(this).parent('div.ss-block').remove();
            get_remaining_cost(<?php echo \Fuel\Core\Input::get('order_id', '')?>);
            total_ss = parseInt(total_ss) + 1;
            $("#total-ss").text(total_ss);
        });
        $('button[name=findmedia-btn]').on('click', function () {
            $('#mediafinder').modal();
            return false;
        });
        // select media
        $(document).on('click', '#mediafinder .list-group .list-group-item', function () {
            var media_id = $(this).attr('datatype');
            if (media_id == '0') {
                return false
            }

            var stt = 0;
            $('#media-name').text($(this).text());
            var media_name = $(this).attr('attr-media-name');
            $('#ss_list').val(''); //remove ss_list when choose media
            $.post(baseUrl + 'filtergroups/post_list', {media_id: media_id}, function (data) {
                var result = jQuery.parseJSON(data);
                var post = result['list_post'];
                var strString = '<option value="">掲載枠を選択して下さい</option>';
                for (var i = 0; i < post.length; i++) {
                    var name = media_name + post[i].name;
                    if (post[i].name == null) {
                        name = media_name + '';
                    }
                    //add price for post (data-price)
                    var price = !post[i].price ? 0 : post[i].price;
                    strString += '<option data-price="' + price + '" value=' + post[i].post_id + '>' + name + '</option>';
                }
                $('select.post-item' + stt + ':enabled').html(strString);
                $('select.post-item').trigger('change');
            });
            $('#mediafinder').modal('hide');
            return false;
        });
        //get work type follow agreement_type
        $(document).on('change', '#form_agreement_type', function () {
            var sssale_id = $(this).val();
            var work_type = '<?php echo $orderinfo['work_type']; ?>';
            var agreement_type = sssale_id;
            <?php if(\Input::get('order_id')){ ?>
            var agreement_type = '<?php echo $orderinfo['agreement_type']; ?>';
            if (agreement_type == '') {
                agreement_type = sssale_id;
            }
            <?php } ?>
            get_work_type(sssale_id, agreement_type, work_type);
        });
        //if is edit
        <?php if(\Input::get('order_id')){ ?>
        var ss_id = $('#ss_id').val();
        if (ss_id != '') {
            var sssale_id = '<?php echo $orderinfo['agreement_type']; ?>';
            var work_type = '<?php echo $orderinfo['work_type']; ?>';
            get_work_type(sssale_id, sssale_id, work_type);
        }
        <?php } ?>
        //if is edit
        <?php if(\Input::get('order_id')){ ?>
        var ss_id = $('#ss_id').val();
        var agreement_type = '<?php echo $orderinfo['agreement_type']; ?>';
        get_agreement_type(ss_id, agreement_type);
        //get_local_access(ss_id);
        <?php } ?>

        $('#search_ss').on('click', function () {
            var keyword = $('#keyword_search_ss').val();
            $.post(baseUrl + 'ajax/orders/searchss', {keyword: keyword}, function (result) {
                var data = jQuery.parseJSON(result);
                var result = '<span class="list-group-item disabled">検索結果</span>';
                $.each(data, function (key, val) {
                    result += '<span style="cursor: pointer" id="' + val.ss_id + '" class="list-group-item">' + val.name + ' ' + val.branch_name + ' ' + val.ss_name + '</span>';
                })
                $("#search_ss_result").html(result);
				if (data.length == 0) {
					alert('見つかりませんでした');
				}
            });

        });

        $('#search_ss_multi').on('click', function () {
            var keyword = $('#keyword_search_ss_multi').val();
            $.post(baseUrl + 'ajax/orders/searchss', {keyword: keyword}, function (result) {
                var data = jQuery.parseJSON(result);
                var result = '<span class="list-group-item disabled">検索結果</span>';
                $.each(data, function (key, val) {
                    result += '<span style="cursor: pointer" attr-id="' + val.ss_id + '" class="list-group-item">' + val.name + ' ' + val.branch_name + ' ' + val.ss_name + '</span>';
                });
                $("#search_ss_multi_result").html(result);
            });

        });

        $('#search_media').on('click', function () {
            var keyword = $('#keyword_search_media').val();
            $.post(baseUrl + 'ajax/orders/searchmedia', {keyword: keyword}, function (result) {
                var data = jQuery.parseJSON(result);
                var result = '<span class="list-group-item disabled" datatype="0">検索結果</span>';
                $.each(data, function (key, val) {
                    result += '<span attr-media-name="' + val.media_name + '" style="cursor: pointer" id="media_' + val.m_media_id + '" datatype="' + val.m_media_id + '" class="list-group-item">' + val.group_name + ' ' + val.branch_name + ' ' + val.media_name + ' ' + val.media_version_name + '</span>';
                })
                $("#search_media_result").html(result);
				if (data.length == 0) {
					alert('見つかりませんでした');
				}
            });

        });

		$('div.modal-body form').on('submit', function() {
			$(this).find('button:first').trigger('click');
			return false;
		});

        $(document).on('change', 'select.post-item', function () {
            total_ss();
            $("#ss_list").val('');
            $('#copy-ss').html('');
            if($(this).val())
                $("#button_ss_list").removeAttr('disabled');
            else{
                $("#button_ss_list").attr('disabled','disabled');
            }
            var price = !$('select.post-item option:selected').attr('data-price') ? 0 : $('select.post-item option:selected').attr('data-price');
            $('.post_price_item').val(price);
            get_remaining_cost(<?php echo \Fuel\Core\Input::get('order_id', '')?>);
        });

        if ($('.post_price_item').length > 0) {
            $('.post_price_item').on('change', function () {
                get_remaining_cost(<?php echo \Fuel\Core\Input::get('order_id', '')?>);
            });
        }
    });
</script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
