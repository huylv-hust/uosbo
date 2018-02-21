<h3>
	求人情報リスト
	<a href="<?php echo Fuel\Core\Uri::base()?>job/job"><button name="add-btn" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button></a>
</h3>
<?php
$login_info = \Fuel\Core\Session::get('login_info');
if(\Fuel\Core\Session::get_flash('report'))
{
 ?>
 <div role="alert" class="alert <?php echo \Fuel\Core\Session::get_flash('class')?> alert-dismissible">
  <button aria-label="Close" data-dismiss="alert" class="close" type="button">
   <span aria-hidden="true">×</span>
  </button>
  <?php echo \Fuel\Core\Session::get_flash('report')?>
 </div>
<?php } ?>
<form class="form-inline" method="get" action="" id="list-jobs">
    <input type="hidden" name="export" value="">
				<div class="panel panel-default">
					<div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">ID</label>
                            </div>
                            <div class="col-md-4">
                                <?php echo Form::input('start_id', \Fuel\Core\Input::get('start_id', ''), array('class' => 'form-control', 'size' => '4'));?>
                                ～
                                <?php echo Form::input('end_id', \Fuel\Core\Input::get('end_id', ''), array('class' => 'form-control', 'size' => '4'));?>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">都道府県</label>
							</div>
							<div class="col-md-4">
								<?php echo Form::select('address_1',\Fuel\Core\Input::get('address_1'),  array('' => '全て') + Constants::$address_1, array('class' => 'form-control','style'=>'width:132px'));?>
							</div>
							<div class="col-md-2">
								<label class="control-label">市区町村</label>
							</div>
							<div class="col-md-4">
								<?php
								//get list ss
								$model_ss = new \Model_Mss();
                                $addr1 = \Fuel\Core\Input::get('address_1');
								$listss = $model_ss->get_list_addr2(['addr1' => $addr1]);
								$addr_2 = array('' => '全て') + array_column($listss,'addr2','addr2');
								echo \Fuel\Core\Form::select('address_2',\Fuel\Core\Input::get('address_2'),$addr_2,array('class' => 'form-control','style'=>'width:132px'))
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">UOS営業所</label>
							</div>
							<div class="col-md-4">
								<?php
								echo \Fuel\Core\Form::select('department_id',Fuel\Core\Input::get('department_id'), Constants::get_search_department(), array('class' => 'form-control'));
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">取引先（法人）</label>
							</div>
							<div class="col-md-10">
								<select class="form-control" id="group_search" name="group_search">
									<option value="">全て</option>
									<?php foreach ($search_group as $group_id => $name) { ?>
									<option value="<?php echo $group_id ?>" <?php if(Fuel\Core\Input::get('group_search') == $group_id) echo 'selected="selected"'?>><?php echo htmlspecialchars($name) ?>
									<?php } ?>
								</select>
								-
                                <div class="input-group">
                                    <div class="input-group-addon">取引先（支店）</div>
                                    <select class="form-control" id="partner_search" name="partner_search">
                                        <option value="">全て</option>
                                    </select>
                                </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<label class="control-label">取引先（勤務地）</label>
							</div>
							<div class="col-md-4">
								<select class="form-control" id="ss_search" name="ss_search">
									<option value="">全て</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<label class="control-label">掲載期間</label>
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control dateform" name="start_date" size="10" value="<?php echo $start_date?>">
								～
								<input type="text" class="form-control dateform" name="end_date" size="10" value="<?php echo $end_date?>">
							</div>
                            <div class="col-md-2">
                                <label class="control-label">最終更新日</label>
                            </div>
                            <div class="col-md-4">
                                <input name="updated_at_from" value="<?php echo \Fuel\Core\Input::get('updated_at_from')?>" type="text" size="10" class="form-control dateform">
                                ～
                                <input name="updated_at_to" value="<?php echo \Fuel\Core\Input::get('updated_at_to')?>" type="text" size="10" class="form-control dateform">
                            </div>
						</div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">勤務形態</label>
                            </div>
                            <div class="col-md-10">
                                <?php foreach(Constants::$sale_type as $key => $val) { if (!$key) { continue; } ?>
                                    <label class="checkbox-inline"><input type="checkbox" <?php echo @in_array($key, Input::get('sale_type')) ? ' checked' : '' ?> name="sale_type[]" value="<?php echo $key ?>"><?php echo $val ?></label>
                                <?php } ?>
                            </div>
                        </div>

						<div class="row">
                            <div class="col-md-2">
                                <label class="control-label">しごさが</label>
                            </div>
                            <div class="col-md-5">
                                <label class="checkbox-inline"><input id="is_available_1" type="checkbox" value="1" name="is_available" <?php if(Fuel\Core\Input::get('is_available') == '1') echo 'checked="checked"'?>>掲載中</label>
                                <label class="checkbox-inline"><input id="is_available_0" type="checkbox" value="0" name="is_available" <?php if(Fuel\Core\Input::get('is_available')== '0') echo 'checked="checked"'?>>掲載停止中</label>
                                <label class="checkbox-inline"><input type="checkbox" value="0" name="status" <?php if(Fuel\Core\Input::get('status') == '0') echo 'checked="checked"'?>>承認待ち</label>
                                <label class="checkbox-inline"><input type="checkbox" value="1" name="is_conscription" <?php if(Fuel\Core\Input::get('is_conscription') == '1') echo 'checked="checked"'?>>急募</label>
                                <label class="checkbox-inline"><input type="checkbox" value="1" name="is_pickup" <?php if(Fuel\Core\Input::get('is_pickup') == '1') echo 'checked="checked"'?>>PickUp</label>
                            </div>
							<div class="col-md-1">
								<label class="control-label">WEB得</label>
							</div>
							<div class="col-md-4">
								<label class="checkbox-inline"><input id="is_webtoku_1" name="is_webtoku" value="1" type="checkbox" <?php if(Fuel\Core\Input::get('is_webtoku') == '1') echo 'checked="checked"'?>>掲載中</label>
								<label class="checkbox-inline"><input id="is_webtoku_0" name="is_webtoku" value="0" type="checkbox" <?php if(Fuel\Core\Input::get('is_webtoku') == '0') echo 'checked="checked"'?>>掲載停止中</label>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">属性</label>
                            </div>
                            <div class="col-md-10">
                                <?php
                                foreach(Constants::$person_targets as $k => $v) {
                                    ?>
                                    <label class="checkbox-inline"><input name="person_target[]" value="<?php echo $k;?>" type="checkbox" <?php if(in_array($k, Fuel\Core\Input::get('person_target', []))) echo 'checked="checked"'?>><?php echo $v;?></label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">時間帯</label>
							</div>
							<div class="col-md-4">
								<?php
									foreach(Constants::$time_targets as $k => $v) {
								?>
										<label class="checkbox-inline"><input name="time_target[]" value="<?php echo $k;?>" type="checkbox" <?php if(in_array($k, Fuel\Core\Input::get('time_target', []))) echo 'checked="checked"'?>><?php echo $v;?></label>
								<?php
									}
								?>
							</div>
                            <?php if($login_info['division_type'] == 1) {?>
                            <div class="col-md-2">
                                <label class="control-label">非表示フラグ</label>
                            </div>
                            <div class="col-md-4">
                                <label class="checkbox-inline"><input id="is_hidden_1" name="is_hidden" value="1" type="checkbox" <?php if(Fuel\Core\Input::get('is_hidden') == '1') echo 'checked="checked"'?>>ON</label>
                                <label class="checkbox-inline"><input id="is_hidden_0" name="is_hidden" value="0" type="checkbox" <?php if(Fuel\Core\Input::get('is_hidden') == '0') echo 'checked="checked"'?>>OFF</label>
                            </div>
                            <?php }?>
						</div>
						<div class="row text-center">
							<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
							<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
							<button type="button" class="btn btn-warning btn-sm" name="download-btn"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</button>
						</div>
					</div>
				</div>
				<?php if( ! count($res['res']))
					{ ?>
				<div role="alert" class="alert alert-danger alert-dismissible">
				<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
					該当するデータがありません
				</div>
				<?php } ?>
				<?php
				if(count($res['res'])){
				?>
				<div class="row">
					<div class="col-md-4">
						<?php echo Pagination::instance('jobpage'); ?>
					</div>
                    <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
                    <div style="margin: 20px 0; padding-left: 15px;">
                        <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
                        <button class="btn btn-info" type="button">
                            ヒット件数 <span class="badge"><?php echo $total ?></span>
                        </button>
                    </div>
				</div>
</form>
<form method="post" action="" id="form-jobs" class="">
				<div class="alert alert-info">
					<span class="text-info">チェックした求人を</span>
					<button type="button" class="btn btn-sm btn-success" id="approve_btn">
						<i class="glyphicon glyphicon-thumbs-up"></i> 承認
					</button>
                    <?php if($login_info['division_type'] == 1) {?>
                    <button type="button" class="btn btn-sm btn-info" id="visible-btn">
                        <i class="glyphicon glyphicon-eye-open"></i> 再表示
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" id="hidden-btn">
                        <i class="glyphicon glyphicon-eye-close"></i> 非表示
                    </button>
                    <input type="hidden" name="table" value="job">
                    <input type="hidden" name="name_field" value="job_id">
                    <input name="type" value="" type="hidden">
                    <?php }?>
				</div>

                <?php
                $arr_label_ss = [
                    '' => 'SS名',
                    'desc' => '▼ SS名',
                    'asc' => '▲ SS名',
                ];
                $arr_label_sale_type = [
                    '' => '勤務形態',
                    'desc' => '▼ 勤務形態',
                    'asc' => '▲ 勤務形態',
                ];

                $link = \Session::get('url_job_redirect');
                $sort_ss_name = \Fuel\Core\Input::get('sort_ss_name','');
                $sort_sale_type = \Fuel\Core\Input::get('sort_sale_type','');
                $text_ss_name = isset($arr_label_ss[$sort_ss_name]) ? $arr_label_ss[$sort_ss_name] : $arr_label_ss[''];
                $text_sale_type = isset($arr_label_sale_type[$sort_sale_type]) ? $arr_label_sale_type[$sort_sale_type] : $arr_label_sale_type[''];

                $string_ss_name = $sort_ss_name == 'asc' ? '&sort_ss_name=desc' : '&sort_ss_name=asc';
                $string_sale_type = $sort_sale_type == 'asc' ? '&sort_sale_type=desc' : '&sort_sale_type=asc';

                $link_ss_name = $link . $string_ss_name . '&sort_sale_type=' . $sort_sale_type;
                $link_sale_type = $link . '&sort_ss_name=' . $sort_ss_name . $string_sale_type;

                ?>
				<table class="table table-bordered">
					<tbody><tr>
						<th class="text-center">
							<input name="all" type="checkbox">
						</th>
						<th class="text-center">ID</th>
						<th class="text-center">
                            <a href="<?php echo $link_ss_name; ?>"><?php echo $text_ss_name; ?></a>
                        </th>
						<th class="text-center">法人名</th>
						<th class="text-center">支店名</th>
						<th class="text-center">
                            <a href="<?php echo $link_sale_type; ?>"><?php echo $text_sale_type; ?></a>
                        </th>
						<th class="text-center">時間帯</th>
						<th class="text-center">属性</th>
						<th class="text-center">給与</th>
						<th class="text-center">掲載サイト</th>
						<th class="text-center">WEB得</th>
						<th class="text-center">状態</th>
						<th class="text-center">管理</th>
						<th class="text-center">最終更新日時</th>
					</tr>

					<?php

					$res_ss = $res['res_ss'];
					$res_partner = $res['res_partner'];
					$res_sssale = $res['res_sssale'];
					$res_group = $res['res_group'];
					?>
					<?php foreach($res['res'] as $row){
					    $row['login_info'] = $login_info;
					    ?>
                    <tr class='<?php echo $row['is_hidden'] ? 'bg-gray' : '' ?>'>
                        <td><input name="ids[<?php echo $row['job_id']; ?>]" value="<?php echo $row['job_id']; ?>"
                                   type="checkbox"></td>
                        <td><?php echo $row['job_id']; ?></td>
                        <td><?php echo isset($res_ss[$row['ss_id']]['ss_name']) ? $res_ss[$row['ss_id']]['ss_name'] : "" ?></td>
                        <td>
                            <?php
                            $partner_code = isset($res_ss[$row['ss_id']]['partner_code']) ? $res_ss[$row['ss_id']]['partner_code'] : "";
                            if ($partner_code) {
                                if (isset($res_partner[$partner_code]['m_group_id']))
                                    echo $res_group[$res_partner[$partner_code]['m_group_id']]['name'];
                                else
                                    echo '';
                            } else
                                echo '';


                            ?>
						</td>
						<td>
							<?php

								echo isset($res_partner[$partner_code]['branch_name']) ? $res_partner[$partner_code]['branch_name']:"";
							?>
						</td>
						<td>
							<?php if (isset($res_sssale[$row['sssale_id']])) { ?>
							<?php echo isset(Constants::$sale_type[$res_sssale[$row['sssale_id']]['sale_type']]) ?  Constants::$sale_type[$res_sssale[$row['sssale_id']]['sale_type']] : ''?>
							<?php echo $res_sssale[$row['sssale_id']]['sale_name'] ?>
							<?php } ?>
						</td>
						<td class="text-center">
                            <?php echo Constants::keys2values(Constants::$work_time_view, $row['work_time_view']) ?>
                        </td>
						<td class="text-center"><?php echo Constants::$person_targets[$row['person_target']]; ?></td>
						<td><?php echo $row['salary_des']?></td>
						<td><?php
							$text = '';
							if( ( $row['public_type']&1) == 1)
								$text .= 'UOS';
							if(($row['public_type']&8) == 8)
								$text .= ' , 宇佐美';
							echo trim($text,' ,');
						?></td>
						<td class="text-center">
							<?php
							if($row['is_webtoku'])
							{
								echo '<span class="label label-success">〇</span>';
							}
							else
							{
								echo '<span class="label label-default">×</span>';
							}
							?>
						</td>
						<td class="text-center" style="min-width: 155px;">
										<?php
											if($row['is_available'])
											{
												$text_a  =  '掲載中';
												$class_a = 'label-success';
											}
											else
											{
												$text_a  = '掲載停止中';
												$class_a = 'label-danger';
											}
										?>
							<span class="label <?php echo $class_a?>"><?php echo $text_a?></span>
							<?php
									if($row['status'])
									{$text = '承認済み'; $class="label-success";}
									else
									{$text = '承認待ち'; $class="label-danger";}
								?>
							<span class="label <?php echo $class?>" style="margin: 0px 0px 0px 5px"><?php echo $text?></span>
						</td>
						<td>
							<div class="btn-group">
								<a class="btn dropdown-toggle btn-sm btn-success" data-toggle="dropdown" style="cursor: pointer">
									処理
									<span class="caret"></span>
								</a>
								<?php echo Presenter::forge('privilege/job')->set('obj',$row); ?>
							</div>
						</td>
						<td style="min-width: 135px;"><?php echo $row['updated_at'];?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
                <div class="row form-inline">
                    <div class="col-md-4">
                        <?php echo Pagination::instance('jobpage'); ?>
                    </div>
                    <div style="margin: 20px 0; padding-left: 15px;">
                        <div style="margin: 20px 0;">
                            <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
                        </div>
                    </div>
                </div>
</form>
				<?php } ?>
<script>
$('.dateform').datepicker();

var getParams = {
    groupId : '<?php echo \Fuel\Core\Input::get('group_search') ?>',
    partnerCode : '<?php echo \Fuel\Core\Input::get('partner_search') ?>',
    ssid : '<?php echo \Fuel\Core\Input::get('ss_search') ?>'
};

$('select[name=group_search]').on('change', function()
{
    if (getParams.groupId != $(this).val()) {
        getParams.partnerCode = null;
        getParams.ssid = null;
    }
	$.getJSON(
		'<?php echo Fuel\Core\Uri::base()?>ajax/common/get_partners',
		{ type : '1', 'group_id' : $(this).val() }
	).done(function(response)
	{
		$("select[name=partner_search] option[value!='']").remove();
		$.each(response, function()
		{
			var opt = $('<option></option>')
				.attr('value', this.partner_code)
				.text(this.branch_name)
			;

			if (this.partner_code == getParams.partnerCode) {
				opt.prop('selected', true);
			}

			$("select[name=partner_search]").append(opt);
		});
		$("select[name=partner_search]").trigger('change');
	});
}).trigger('change');

$('select[name=partner_search]').on('change', function()
{
    if (getParams.partnerCode != $(this).val()) {
        getParams.ssid = null;
    }

	$.getJSON(
		'<?php echo Fuel\Core\Uri::base()?>ajax/common/get_ss',
		{ 'group_id' : $('select[name=group_search]').val(), 'partner_code' : $(this).val() }
	).done(function(response)
	{
		$("select[name=ss_search] option[value!='']").remove();
		$.each(response, function()
		{
			var opt = $('<option></option>')
				.attr('value', this.ss_id)
				.text(this.ss_name)
			;

			if (this.ss_id == getParams.ssid) {
				opt.prop('selected', true);
			}

			$("select[name=ss_search]").append(opt);
		});
    });
});

function approved(id,status)
{
	if(confirm('承認します、よろしいですか？'))
	{
	$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/approved',
				{
					'job_id':id,
					'status':status
				},
				function(data){

					window.location.reload();
				}
			);
	}
}
function delete_job(id)
{
	if(confirm('削除します、よろしいですか？'))
	{
		$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/deletejob',
			{
				'job_id':id,
			},
			function(data){

				window.location.reload();
			}
		);
	}
}
function is_available(id,is_available)
{
	if(is_available == '1')
		ok = confirm('掲載中にします、よろしいですか？');
	else
		ok =confirm('掲載停止中にします、よろしいですか？');
	if(ok)
	{
		$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/available',
				{
					'job_id':id,
					'is_available':is_available
				},
				function(data){
					window.location.reload();
				}
			);
	}
}
function is_webtoku(id,is_webtoku)
{
	if(is_webtoku == '1')
		ok = confirm('WEB得ONにします、よろしいですか？');
	else
		ok = confirm('WEB得OFFにします、よろしいですか？');
	if(ok)
	{
		$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/webtoku',
			{
				'job_id':id,
				'is_webtoku':is_webtoku
			},
			function(data){
				window.location.reload();
			}
		);
	}
}
$("#is_available_1").click(function(){

	$("#is_available_0").attr('checked',false);
});
$("#is_available_0").click(function(){

	$("#is_available_1").attr('checked',false);
});
$("#is_webtoku_1").click(function(){

	$("#is_webtoku_0").attr('checked',false);
});
$("#is_webtoku_0").click(function(){

	$("#is_webtoku_1").attr('checked',false);
});
$(".limit").on('change',function(){
    var val = $(this).val();
    $("input[name='limit']").val(val);
	$("#list-jobs").submit();
});
$('input[name=all]').on('click', function() {
	$('input[name^=ids]').prop('checked', $(this).prop('checked'));
});
$("#approve_btn").on('click',function(){
	if (confirm('承認します、よろしいですか？'))
	{
        $('#form-jobs').attr('action', '<?php echo Fuel\Core\Uri::base()?>job/jobs/approve_all');
		$("#form-jobs").submit();
	}
	return false;
});

$('select[name=address_1]').on('change', function() {
    var param = {
        addr1: $(this).val()
    };
    var request = $.ajax({
        type: 'post',
        data: param,
        url: baseUrl + 'ajax/common/get_addr2'
    });
    var response = request.done(function(data){
        $("select[name=address_2] option[value!='']").remove();
        data = jQuery.parseJSON(data);
        var option = '<option value="">'+ '全て' +'</option>';
        $.each(data, function(key, value){
            option += '<option value="' + value + '">' + value + '</option>';
        });
        $('select[name=address_2]').html(option);
    });
});

$("#visible-btn").on('click',function(){
    if (confirm('再表示します。よろしいですか？'))
    {
        $('input[name=type]').val('0');
        $('#form-jobs').attr('action', '<?php echo Fuel\Core\Uri::base()?>ajax/common/set_hidden');
        $("#form-jobs").submit();
    }
    return false;
});
$("#hidden-btn").on('click',function(){
    if (confirm('管理者以外には非表示にします。よろしいですか？'))
    {
        $('input[name=type]').val('1');
        $('#form-jobs').attr('action', '<?php echo Fuel\Core\Uri::base()?>ajax/common/set_hidden');
        $("#form-jobs").submit();
    }
    return false;
});
$("#is_hidden_1").click(function(){

    $("#is_hidden_0").attr('checked',false);
});
$("#is_hidden_0").click(function(){

    $("#is_hidden_1").attr('checked',false);
});

$('[name=download-btn').on('click', function() {
    var form = $(this).parents('form:first');
    var hidden = form.find('input[name=export]');
    hidden.val('true');
    form.submit();
    hidden.val('');
});
</script>
