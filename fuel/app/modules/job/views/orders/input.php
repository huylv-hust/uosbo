<?php
if(isset($info)){
	$orderinfo = $info;
}else{
	$orderinfo = $properties;
}
?>
<h3>オーダー<?php //echo $orderinfo['status'];?></h3>
<?php if(\Session::get_flash('error')) { ?>
	<div role="alert" class="alert alert-danger alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<?php echo \Session::get_flash('error');?>
	</div>
<?php } ?>
<div class="text-right" style="padding-bottom: 5px;">

<a class="btn btn-warning btn-sm" href="<?php echo \Fuel\Core\Cookie::get('return_url_search') ? \Fuel\Core\Cookie::get('return_url_search') : \Fuel\Core\Uri::base().'job/orders'; ?>">
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
		<tbody><tr>
				<th class="text-right">申請日</th>
				<td>
					<?php echo Form::input('apply_date', Input::post('apply_date', isset($post) ? $post->apply_date : $orderinfo['apply_date']), array('class' => 'form-control dateform', 'size' => 12, 'onchange' => 'get_remaining_cost()')); ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">掲載日</th>
				<td>
					<?php
					$postdateArr = array('class' => 'form-control dateform', 'size' => 12);
					if($user_login['division_type'] != 1){
						$postdateArr['disabled'] = 'disabled ';
					}
					$post_date = $orderinfo['post_date'];
					if($orderinfo['post_date'] == '0000-00-00'){
						$post_date = '';
					}
					?>
					<?php echo Form::input('post_date', Input::post('post_date', isset($post) ? $post->post_date : $post_date), $postdateArr); ?>
					<span class="text-info">※管理者のみ入力可、確定処理の場合必須</span>
					<label id="form_post_date-error" class="error" for="form_post_date"></label>
				</td>
			</tr>
			<tr>
				<th class="text-right">対象SS</th>
				<td><?php echo $filtergroup; ?></td>
			</tr>
			<tr id="show-work" style="display:none">
				<th class="text-right text-work">売上形態</th>
				<td>
					<div id="agreement">
					<?php //echo Form::select('agreement_type', Input::post('agreement_type', isset($post) ? $post->agreement_type : $orderinfo['agreement_type']), Constants::$sale_type, array('class'=>'form-control')); ?>
					</div>
					<p></p>
					<div class="panel panel-info" style="min-height:140px">
						<div class="panel-body" style="display:none;">
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
					<?php $apply_reason = array('','新規受注','前回の募集で集まらなかった','スタッフ退職の為','その他'); ?>
					<?php echo Form::select('apply_reason', Input::post('apply_reason', isset($post) ? $post->apply_reason : $orderinfo['apply_reason']), $apply_reason, array('class'=>'form-control')); ?>
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
					<div class="workerr" style="float:left;margin-right:2px">
					<?php echo Form::input('work_date', Input::post('work_date', isset($post) ? $post->work_date : $orderinfo['work_date']), array('class' => 'form-control', 'size' => 50)); ?>
					</div>
					<div class="input-group">
						<div class="input-group-addon">月</div>
						<?php echo Form::input('work_time_of_month', Input::post('work_time_of_month', isset($post) ? $post->work_time_of_month : $orderinfo['work_time_of_month']), array('class' => 'form-control', 'size' => 5)); ?>
						<div class="input-group-addon">時間程度</div>
					</div>
					<span class="text-info">※必須</span>
				</td>
			</tr>
			<tr>
				<th class="text-right">社会保険</th>
				<td>
					<label class="radio-inline"><input type="radio" name="is_insurance" value="1" checked="checked" />あり</label>
					<label class="radio-inline"><input type="radio" name="is_insurance" value="0" <?php if($orderinfo['is_insurance'] == 0){ echo 'checked="checked"';} ?>/>なし</label>
					<span class="text-info">※いずれか必須</span>
				</td>
			</tr>
			<tr>
				<th class="text-right">土日の勤務</th>
				<td>
					<?php $holiday_work = array('','土日祝すべて勤務','土日祝いずれか勤務','土日祝休みの相談ＯＫ'); ?>
					<?php echo Form::select('holiday_work', Input::post('holiday_work', isset($post) ? $post->holiday_work : $orderinfo['holiday_work']), $holiday_work, array('class'=>'form-control')); ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">資格(必須)</th>
				<td>
					<?php echo Form::input('require_des', Input::post('require_des', isset($post) ? $post->require_des : $orderinfo['require_des']), array('class' => 'form-control', 'size' => 80)); ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">資格(優遇)</th>
				<td>
					<?php echo Form::input('require_experience', Input::post('require_experience', isset($post) ? $post->require_experience : $orderinfo['require_experience']), array('class' => 'form-control', 'size' => 80)); ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">資格(メリット他)</th>
				<td>
					<?php echo Form::input('require_other', Input::post('require_other', isset($post) ? $post->require_other : $orderinfo['require_other']), array('class' => 'form-control', 'size' => 80)); ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">資格(年齢)</th>
				<td>
					<?php echo Form::input('require_age', Input::post('require_age', isset($post) ? $post->require_age : $orderinfo['require_age']), array('class' => 'form-control', 'size' => 80)); ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">資格(性別)</th>
				<td>
					<?php echo Form::input('require_gender', Input::post('require_gender', isset($post) ? $post->require_gender : $orderinfo['require_gender']), array('class' => 'form-control', 'size' => 80)); ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">資格(Ｗワーク)</th>
				<td>
					<input type="hidden" name="total_ss" value="0" readonly="readonly" />
					<?php echo Form::input('require_w', Input::post('require_w', isset($post) ? $post->require_w : $orderinfo['require_w']), array('class' => 'form-control', 'size' => 80)); ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">
					掲載媒体
					<!--button type="button" class="btn btn-success btn-sm" name="add-media-btn">
						<i class="glyphicon glyphicon-plus icon-white"></i>
					</button-->
				</th>
				<td id="medias">
					<div class="media-append">
					<?php
					if($info['post_id'] && $post_id_isset){
						echo \Presenter::forge('group/mediaorder')->set(array('post_id' => $info['post_id']));
					}else{
						echo \Presenter::forge('group/mediaorder')->set(array('post_id' => 0));
					}
					?>
					</div>
				</td>
			</tr>
			<tr>
				<th class="text-right">
					同募SS
					<button type="button" class="btn btn-success btn-sm" name="add-ss-btn">
						<i class="glyphicon glyphicon-plus icon-white"></i>
					</button>
					<div>
						<span class="text-info">あと<strong id="total-ss">3</strong>個可能</span>
					</div>
				</th>
				<td id="copy-ss">
					<?php
					$ss_list = trim($info['ss_list'],',');
					if($ss_list){
						$ss_list = explode(',', $ss_list);
						$i = 0;
						foreach($ss_list as $ss_id)
						{
							echo \Presenter::forge('group/ss')->set(array('ss_id' => $ss_id, 'stt' => $i));
							$i++;
						}
					}
					?>
				</td>
			</tr>
			<tr>
				<th class="text-right">備考</th>
				<td>
					<?php echo Form::textarea('notes', Input::post('notes', isset($post) ? $post->notes : $orderinfo['notes']), array('rows' => 5, 'cols' => 77)); ?>
				</td>
			</tr>
		</tbody></table>

	<div class="alert alert-danger text-center" role="alert">
		本オーダー発注後の今期残り予算はあと<strong class="show-price"><?php echo number_format(round($remaining_cost)); ?>円</strong>です。
	</div>
	<?php
	$list_author = \Utility::create_array_users($listusers_author);
	$list_sales  = \Utility::create_array_users($listusers_sales);
	$list_interview  = \Utility::create_array_users($listusers_interview);
	$list_agreement  = \Utility::create_array_users($listusers_agreement);
	$list_training  = \Utility::create_array_users($listusers_training);
	if(!isset($author_department_id)){ $author_department_id = null; }
	if(!isset($sales_department_id)){ $sales_department_id = null; }
	if(!isset($interview_department_id)){ $interview_department_id = null; }
	if(!isset($agreement_department_id)){ $agreement_department_id = null; }
	if(!isset($training_department_id)){ $training_department_id = null; }
	?>
	<table class="table table-striped">
		<tbody><tr>
				<th class="text-right">作成者</th>
				<td>
					<?php $userDefault = '部門を選択してください'; ?>
					<div class="input-group">
						<div class="input-group-addon">部門</div>
						<?php echo Form::select('select_author_user_id', Input::post('select_author_user_id', isset($post) ? $post->select_author_user_id : $author_department_id), \Constants::get_search_department($userDefault), array('class'=>'form-control user_id','data-type'=>'author')); ?>
					</div>
					<div class="input-group">
						<div class="input-group-addon">担当者</div>
						<?php echo Form::select('author_user_id', Input::post('author_user_id', isset($post) ? $post->author_user_id : $orderinfo['author_user_id']), $list_author, array('class'=>'form-control')); ?>
					</div>
				</td>
			</tr>
			<tr>
				<th class="text-right">面接</th>
				<td>
					<div class="input-group">
						<div class="input-group-addon">部門</div>
						<?php echo Form::select('select_interview_user_id', Input::post('select_interview_user_id', isset($post) ? $post->select_interview_user_id : $interview_department_id), \Constants::get_search_department($userDefault), array('class'=>'form-control user_id','data-type'=>'interview')); ?>
					</div>
					<div class="input-group">
						<div class="input-group-addon">担当者</div>
						<?php echo Form::select('interview_user_id', Input::post('interview_user_id', isset($post) ? $post->interview_user_id : $orderinfo['interview_user_id']), $list_interview, array('class'=>'form-control')); ?>
					</div>
					<span class="text-info">※必須</span>
				</td>
			</tr>
			<tr>
				<th class="text-right">契約</th>
				<td>
					<div class="input-group">
						<div class="input-group-addon">部門</div>
						<?php echo Form::select('select_agreement_user_id', Input::post('select_agreement_user_id', isset($post) ? $post->select_agreement_user_id : $agreement_department_id), \Constants::get_search_department($userDefault), array('class'=>'form-control user_id','data-type'=>'agreement')); ?>
					</div>
					<div class="input-group">
						<div class="input-group-addon">担当者</div>
						<?php echo Form::select('agreement_user_id', Input::post('agreement_user_id', isset($post) ? $post->agreement_user_id : $orderinfo['agreement_user_id']), $list_agreement, array('class'=>'form-control')); ?>
					</div>
					<span class="text-info">※必須</span>
				</td>
			</tr>
			<tr>
				<th class="text-right">研修</th>
				<td>
					<div class="input-group">
						<div class="input-group-addon">部門</div>
						<?php echo Form::select('select_training_user_id', Input::post('select_training_user_id', isset($post) ? $post->select_training_user_id : $training_department_id), \Constants::get_search_department($userDefault), array('class'=>'form-control user_id','data-type'=>'training')); ?>
					</div>
					<div class="input-group">
						<div class="input-group-addon">担当者</div>
						<?php echo Form::select('training_user_id', Input::post('training_user_id', isset($post) ? $post->training_user_id : $orderinfo['training_user_id']), $list_training, array('class'=>'form-control')); ?>
					</div>
				</td>
			</tr>

		</tbody></table>

	<div class="text-center">
		<?php
			$show_submit = true;
			$show_date = false;
			if(($orderinfo['status'] == 2 || $orderinfo['status'] == 3) && \Input::get('action') == 'copy'){
				$show_submit = true;
			}
			if(($orderinfo['status'] == 2 || $orderinfo['status'] == 3) && \Input::get('action') != 'copy'){
				$show_date = true;
			}
		?>
		<?php if($show_submit){ ?>
		<button type="<?php echo $show_date == true ? 'button' : 'submit'; ?>" class="btn btn-primary btn-sm show-post" <?php echo $show_date == true ? 'id="date-only"' : '';?>>
			<i class="glyphicon glyphicon-pencil icon-white"></i>
			保存
		</button>
		<?php } ?>
		<?php $user_login = Session::get('login_info'); ?>
		<?php if(\Input::get('order_id') && \Input::get('action') != 'copy' && $orderinfo['status'] != 2 && $orderinfo['status'] != 3 && $orderinfo['status'] != 1 && ($user_login['division_type'] == 1 || $user_login['division_type'] == 2)){ ?>
		<button type="button" class="btn btn-primary btn-sm popup" data-status="1">
			<i class="glyphicon glyphicon-thumbs-up icon-white"></i>
			 承認
		</button>
		<?php if($orderinfo['status'] != -1){ ?>
		<button type="button" class="btn btn-primary btn-sm popup" data-status="-1">
			<i class="glyphicon glyphicon-thumbs-down icon-white"></i>
			 非承認
		</button>
		<?php } } ?>
	</div>
</form>

<style type="text/css">
#dialog{text-align:center}
#dialog button{margin:10px;padding:0px 4px}
</style>

<div id="dialog" title="オーダーの承認">
</div>

<?php echo Asset::js('validate/order-input.js'); ?>
<?php echo Asset::js('validate/order-presenter.js'); ?>

<script type="text/javascript">
$(document).ready(function(){

	$('select.user_id').change(function(){
		var type = $(this).attr('data-type');
		var department_id = $(this).val();
		strString = '<option value=""></option>';
		if(department_id == '' || department_id == 0){
			$('select#form_'+type+'_user_id').html(strString);
			return false;
		}
		$.post(baseUrl+'job/order/get_users', {department_id:department_id}, function(result){
			var data = jQuery.parseJSON(result);
			for (var i = 0; i < data['list_user'].length; i++) {
                strString += '<option value=' + data['list_user'][i].user_id + '>' + data['list_user'][i].name + '</option>';
            }
            $('select#form_'+type+'_user_id').html(strString);
		});
	});

	//get agreement type follow ss_id
	$(document).on('change', '#form_m_group_id', function(){
		var ss_id = null;
		get_agreement_type(ss_id, null);
		get_local_access(ss_id);
		get_remaining_cost();
	});

	//get agreement type follow ss_id
	$(document).on('change', '#form_partner_code', function(){
		var ss_id = null;
		get_agreement_type(ss_id, null);
		get_local_access(ss_id);
		get_remaining_cost();
	});

	//get agreement type follow ss_id
	$(document).on('change', '#form_ss_id', function(){
		var ss_id = $(this).val();
		get_agreement_type(ss_id, null);
		get_local_access(ss_id);
		get_remaining_cost();
	});

	//if is edit
	<?php if(\Input::get('order_id')){ ?>
	var ss_id = $('#form_ss_id').val();
	var agreement_type = '<?php echo $orderinfo['agreement_type']; ?>';
	get_agreement_type(ss_id, agreement_type);
	get_local_access(ss_id);
	<?php } ?>

	function get_agreement_type(ss_id, agreement_type){
		var string = '<select class="form-control" name="agreement_type" id="form_agreement_type"><option value=""></option>';
		var agreement_obj = $('#agreement');
		var work_obj = $('#show-work');
		$('.panel-body').html('');
		work_obj.show();
		if(ss_id == ''){
			work_obj.hide();
			return false;
		}
		$.post(baseUrl+'ajax/orders', {ss_id:ss_id}, function(result){
			var sale_type_obj = {'1':'直接雇用','2':'職業紹介','3':'派遣','4':'紹介予定派遣','5':'請負','6':'求人代行'};
			var data = jQuery.parseJSON(result);
			var agreement = data['list_sales'];
            for(var i = 0; i < agreement.length; i++){
				sale_type_id = agreement[i].sale_type;
				sale_name = '';
				if(agreement[i].sale_name != null){
					sale_name = agreement[i].sale_name;
				}
				if(sale_type_id == null != sale_type_id == ''){
					sale_type = '';
				}else{
					sale_type = sale_type_obj[sale_type_id] != undefined ? sale_type_obj[sale_type_id] : '';
				}
				if(agreement_type == agreement[i].sssale_id){
					string += '<option value='+agreement[i].sssale_id+' selected="selected">'+sale_type+sale_name+'</option>';
				}else{
					string += '<option value='+agreement[i].sssale_id+'>'+sale_type+sale_name+'</option>';
				}
            }
			string += '</select>';
			agreement_obj.html(string);

			if((order_status == 2 || order_status == 3)&& action != 'copy')
			{
				$('#order-input input').prop('disabled', true);
				$('#form_agreement_type').prop('disabled', true);
				if(division_type == 1){
					$('#form_post_date').removeAttr('disabled');
					$('button.show-post').removeAttr('disabled');
				}
			}
		});
	}

	//get work type follow agreement_type
	$(document).on('change', '#form_agreement_type', function(){
		var sssale_id = $(this).val();
		var work_type = '<?php echo $orderinfo['work_type']; ?>';
		var agreement_type = sssale_id;
		<?php if(\Input::get('order_id')){ ?>
		var agreement_type = '<?php echo $orderinfo['agreement_type']; ?>';
		if(agreement_type == ''){
			agreement_type = sssale_id;
		}
		<?php } ?>
		get_work_type(sssale_id, agreement_type, work_type);
	});

	//if is edit
	<?php if(\Input::get('order_id')){ ?>
	var ss_id = $('#form_ss_id').val();
	if(ss_id != ''){
		var sssale_id = '<?php echo $orderinfo['agreement_type']; ?>';
		var work_type = '<?php echo $orderinfo['work_type']; ?>';
		get_work_type(sssale_id, sssale_id, work_type);
	}
	<?php } ?>

	function get_work_type(sssale_id, agreement_type, work_type){
		var panel_body = $('.panel-body');
		panel_body.show();
		if(sssale_id == ''){
			panel_body.html('');
			return false;
		}
		$.post(baseUrl+'ajax/orders/worktype', {sssale_id:sssale_id, work_type:work_type, agreement_type:agreement_type, status:order_status, action:action}, function(result){
			panel_body.html(result);
		});

		if((order_status == 2 || order_status == 3 ) && action != 'copy')
		{
			$('#order-input input').attr('disabled', 'disabled');
			if(division_type == 1){
				$('#form_post_date').removeAttr('disabled');
				$('button.show-post').removeAttr('disabled');
			}

		}
	}

	//get location and asscess
	function get_local_access(ss_id){
		var location = $('input[name=location]');
		var access   = $('input[name=access]');
		if(ss_id == '' || ss_id == null){
			location.val('');
			access.val('');
			return false;
		}
		$.post(baseUrl+'ajax/orders/ssinfo', {ss_id:ss_id}, function(result){
			var data = jQuery.parseJSON(result);
			var info = data['ssinfo'];
			var addr1 = data['addr1'];
			var addr2 = info[0]['addr2'] != null ? info[0]['addr2']+' ' : '';
			var addr3 = info[0]['addr3'] != null ? info[0]['addr3'] : '';
			location.val(addr1+' '+addr2+' '+addr3);
            access.val(info[0]['access']);
		});
	}

	/**********************************************************/
	$("#dialog").dialog({
		autoOpen: false,
		minWidth: 350
    });

	$('button.popup').click(function(){
		var status = $(this).attr('data-status');
		var order_id = '<?php echo \Input::get('order_id'); ?>';
		var html = '<button type="button" data-id="'+order_id+'" class="statubtn" value="1">承認済</button><button class="statubtn" data-id="'+order_id+'" value="0" type="button" class="popupclose">キャンセル</button>';
		if(status == -1){
			html = '<button type="button" class="statubtn" data-id="'+order_id+'" value="-1">非承認</button><button class="statubtn" data-id="'+order_id+'" value="0" type="button" class="popupclose">キャンセル</button>';
		}
		$("#dialog" ).html(html);
		$("#dialog").dialog("open");
	});
	$(document).on('click', '#dialog button.statubtn', function(){
		var status = $(this).val();
		var order_id = $(this).attr('data-id');
		if(status == 0){ //hide popup
			$("#dialog").dialog('close');
			return false;
		}
		if(status == 1){ //approved
			if(!confirm('承認します、よろしいですか？')){
				return false;
			}
			var imgLoad = '<br /><img src="<?php echo \Uri::base(); ?>assets/img/loading.gif"/>';
			$(this).parent().append(imgLoad);
			$.post(baseUrl + 'job/orders/update_status',{status: status, order_id:order_id}, function(result){
				if(result == 'failed'){
					window.location.href = '<?php echo \Uri::base(); ?>job/orders?lost=true';
					return false;
				}
				if(result == 'true'){
					window.location.href = '<?php echo \Uri::base(); ?>job/orders';
				}
			});
		}
		if(status == -1){ //noapproved
			var object = $('.popup_box_'+order_id);
			var html = '<p>非承認の理由</p><form><textarea class="reason_info'+order_id+'" data-stt="'+order_id+'" cols="30" rows="4"></textarea><br /><button type="button" style="float:left" data-stt="'+order_id+'" name="reason">送信</button><div style="float:left" class="loading"></div></form>';
			$("#dialog" ).html(html);
			$("#dialog").dialog("open");
		}
	});
	$(document).on('click', 'button[name=reason]', function(){
		var order_id = $(this).attr('data-stt');
		var reason = $('textarea.reason_info'+order_id);
		if(reason.val() == ''){
			reason.focus().css('border','1px solid #F00');
			return false;
		}
		if(!confirm('非承認します。よろしいですか？')){
			return false;
		}
		var imgLoad = '<br /><img src="<?php echo \Uri::base(); ?>assets/img/loading.gif"/>';
		$('div.loading').html(imgLoad);
		$.post(baseUrl + 'job/orders/update_status',{status: -1, order_id:order_id, reason:reason.val()}, function(result){
			if(result == 'failed'){
				window.location.href = '<?php echo \Uri::base(); ?>job/orders?lost=true';
				return false;
			}
			if(result == 'true'){
				window.location.href = '<?php echo \Uri::base(); ?>job/orders';
			}
		});
	});

	//status = 2, view only
	if((order_status == 2 || order_status == 3) && action != 'copy')
	{
		$('#order-input select').prop('disabled', true);
		$('#order-input button').prop('disabled', true);
		$('#order-input input').prop('disabled', true);
		$('#order-input textarea').prop('disabled', true);
		$('#form_agreement_type').prop('disabled', true);
		if(division_type == 1){
			$('#form_post_date').removeAttr('disabled');
			$('button.show-post').removeAttr('disabled');
		}
	}

	//update post_date when status = 2
	$(document).on('click', '#date-only', function(){
		var post_date = $('#form_post_date').val();
		if(order_status == 2 && post_date == '')
		{
			$("#form_post_date-error").html('必須です');
			return false;
		}
		var order_id = '<?php echo \Input::get('order_id'); ?>';
		if (!confirm('保存します、よろしいですか？')) {
			return false;
		}
		console.log(post_date);
		$.post(baseUrl+'job/order/post_date', {post_date:post_date, order_id:order_id}, function(result){
			if(result == 'true'){

				var return_url_search = '<?php echo \Cookie::get('return_url_search'); ?>';
				if(return_url_search)
				{
					window.location.href = return_url_search;
					return false;
				}
				window.location.href = '<?php echo \Uri::base(); ?>job/orders';
			}
		});
	});
});

//get remaining cost when change
function get_remaining_cost(){
	var apply_date = $('#form_apply_date').val();
	var post_id = $('select[name=list_post]').val();
	var order_id = '<?php echo \Input::get('order_id'); ?>';
	var ss_id = $('#form_ss_id').val();
	var list_ss = [];
	$('select.ss-item').each(function(){
		list_ss.push($(this).val());
	});
	var object = $('.show-price');
	if(apply_date == '' || ss_id == ''){
		object.html('0円');
		return false;
	}
	$.post(baseUrl+'job/order/remaining_cost', {apply_date:apply_date, post_id:post_id, list_ss:list_ss, ss_id:ss_id, order_id:order_id, action:action}, function(result){
		var data = jQuery.parseJSON(result);
		object.html(data['remaining_cost']+'円');
	});
}
get_remaining_cost();
</script>

<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">