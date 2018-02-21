<?php echo \Fuel\Core\Asset::js('validate/mail_group.js');?>
<?php
if(Session::get_flash('error'))
{
    ?>
    <div role="alert" class="alert alert-danger alert-dismissible">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo Session::get_flash('error');?>
    </div>
    <?php
}
?>
<h3>
    メールグループ
</h3>
<?php
    $param = \Fuel\Core\Input::get('mail_group_id') ? '?mail_group_id='.\Fuel\Core\Input::get('mail_group_id') : '';
?>
<form id="mail_group_form" class="form-inline" method="post" action="<?php echo \Fuel\Core\Uri::base().'mail/group'.$param?>">

    <p class="text-right">
        <a href="<?php echo \Fuel\Core\Session::get('url_mail_group_list') ? \Fuel\Core\Session::get('url_mail_group_list') : \Fuel\Core\Uri::base().'mail/groups'?>" class="btn btn-warning btn-sm">
            <i class="glyphicon glyphicon-arrow-left icon-white"></i>
            戻る
        </a>
    </p>

    <table class="table table-striped">
        <tbody><tr>
            <th class="text-right">メールグループ名</th>
            <td>
                <?php echo Form::input('mail_group_name', Input::post('mail_group_name') ? Input::post('mail_group_name') : (isset($mail_group->mail_group_name) ? $mail_group->mail_group_name : ''), array('class' => 'form-control', 'size' => 80, 'maxlength' => 100));?>
            </td>
        </tr>
        <tr>
            <th class="text-right">
                送信先
                <button type="button" class="btn btn-sm btn-success" name="adduser-btn">
                    <i class="glyphicon glyphicon-search icon-white"></i>
                </button>
            </th>
            <td id="users">
                <?php
                    $users = [];
                    $user_obj = new Model_Muser();
                    if(isset($mail_group->users) && $mail_group->users) {
                        $users = explode(',', trim($mail_group->users, ','));
                    }
                    $username = !empty($users) ? array_column($user_obj->get_data_array(['arr_id' => $users]), 'name', 'user_id') : null;
                    foreach($users as $k => $v) {
                ?>
                        <div class="user-block">
                            <span class="user-name"><?php echo $username[$v];?></span>
                            <input name="users[]" value="<?php echo $v;?>" type="hidden">
                            <button type="button" class="btn btn-danger btn-sm" name="remove-user-btn">
                                <i class="glyphicon glyphicon-trash icon-white"></i>
                            </button>
                        </div>
                <?php
                    }
                ?>


            </td>
        </tr>
        <tr>
            <th class="text-right">
                取引先 勤務形態
                <button type="button" class="btn btn-sm btn-success" name="addpartner-btn">
                    <i class="glyphicon glyphicon-search icon-white"></i>
                </button>
            </th>
            <td id="partners">
                <?php
                    $partner_sales = [];
                    $arr_sale_type = Constants::$sale_type;
                    $arr_sale_type[''] = '選択して下さい';
                    if(isset($mail_group->partner_sales) && $mail_group->partner_sales) {
                        $partner_sales = explode(',', trim($mail_group->partner_sales, ','));
                    }

                    $partner_obj = new Model_Mpartner();
                    $arr_partner_code = [];
                    foreach($partner_sales as $k => $v) {
                        $arr_partner_code[] = explode('-', $v)[0];
                    }
                    $partners = !empty($arr_partner_code) ? $partner_obj->get_filter_partner(['arr_partner_code' => $arr_partner_code]) : [];
                    foreach($partners as $k => $v) {
                        $name[$v['partner_code']] = $v['group_name'] . ' ' . $v['branch_name'];
                    }

                    foreach($partner_sales as $k => $v) {
                        $partner_code = explode('-', $v)[0];
                ?>

                        <div class="partner-block" attr-index="<?php echo $k; ?>">
                            <input type="hidden" name="partner_code[<?php echo $k; ?>]" value="<?php echo $partner_code; ?>"/>
                            <span class="partner-name"><?php echo $name[$partner_code];?></span>
                            <div class="input-group">
                                <div class="input-group-addon">勤務形態</div>
                                <?php echo Form::select('sale_type['.$k.']', explode('-', $v)[1], $arr_sale_type, array('class' => 'form-control select_sale_type')); ?>
                                </div>
                            <button type="button" class="btn btn-danger btn-sm" name="remove-partner-btn">
                                <i class="glyphicon glyphicon-trash icon-white"></i>
                            </button>
                            <label id="form_sale_type[<?php echo $k; ?>]-error" class="error" for="form_sale_type[<?php echo $k; ?>]"></label>
                        </div>
                <?php
                    }
                ?>
            </td>
        </tr>

        </tbody></table>

    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="glyphicon glyphicon-pencil icon-white"></i>
            保存
        </button>
    </div>

</form>

<!-- MODAL SEARCH USER -->
<div id="userfinder" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">アカウント検索</h4>
			</div>
			<div class="modal-body">
				<form mehod="get">
					<div class="form-group">
						<label>氏名/メールアドレス</label>
						<div class="form-inline">
							<input class="form-control modal_keyword" placeholder="氏名/メールアドレス" type="text" size="100">
                            <button id="user_search" type="button" class="btn btn-primary btn-sm">
                                <i class="glyphicon glyphicon-search icon-white"></i>
                            </button>
						</div>
                        <div class="text-info">※複数指定はスペース区切り(AND検索)</div>
					</div>

					<div class="row container-fluid">
						<div class="list-group">
							<span class="list-group-item disabled">検索結果</span>
                            <div class="list_user"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- END MODAL SEARCH USER -->

<!-- MODAL SEARCH PARTNER -->
<div id="partnerfinder" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">取引先</h4>
            </div>
            <div class="modal-body">
                <form mehod="get">
                    <div class="form-group">
                        <label>キーワード</label>
                        <div class="form-inline">
                            <input class="form-control modal_keyword" placeholder="法人名/支店名" type="text" size="100">
                            <button id="partner_search" type="button" class="btn btn-primary btn-sm">
                                <i class="glyphicon glyphicon-search icon-white"></i>
                            </button>
                        </div>
                        <div class="text-info">※複数指定はスペース区切り(AND検索)</div>
                    </div>

                    <div class="row container-fluid">
                        <div class="list-group">
                            <span class="list-group-item disabled">検索結果</span>
                            <div class="list_partner"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL SEARCH PARTNER -->

<script>
    var sale_type = <?php echo json_encode(Constants::$sale_type); ?>;
    var count_sale_type = <?php echo count(Constants::$sale_type);?>;
</script>

