<style type="text/css">
/* popup_box DIV-Styles*/
#dialog{text-align:center}
#dialog button{margin:10px;padding:0px 4px}
.popup_box{
	display:none; /* Hide the DIV */
	position:fixed;
	_position:absolute; /* hack for internet explorer 6 */
	min-height:150px;
	min-width:400px;
	background:#FFFFFF;
	top:20%;
	left:30%;
	z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	margin-left: 15px;
	/* additional features, can be omitted */
	border:2px solid #CCC;
	padding:15px;
	font-size:15px;
	-moz-box-shadow: 0 0 5px #CCC;
	-webkit-box-shadow: 0 0 5px #CCC;
	box-shadow: 0 0 5px #CCC;
}
.popup_box img{
	max-width:700px;
}
.popup_box button{
	margin: 10px;
}
#container {
	background:#d2d2d2; /*Sample*/
	width:100%;
	height:100%;
}

a{
cursor: pointer;
text-decoration:none;
}

/* This is for the positioning of the Close Link */
.popupBoxClose {
	font-size:17px;
	line-height:15px;
	right:5px;
	top:5px;
	position:absolute;
	color:#F00;
	font-weight:500;
}
</style>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<?php $user_login = \Fuel\Core\Session::get('login_info'); ?>
<?php $division_type = $user_login['division_type']; ?>
<script type="text/javascript">
	var return_url_search = '<?php echo \Cookie::get('return_url_search'); ?>';
</script>
<?php echo Asset::js('module/image_order.js');?>
<h3>
	オーダーリスト
	<button type="button" class="btn btn-info btn-sm" name="add-btn-order" onclick="window.location='<?php echo \Uri::base(); ?>job/order'"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
</h3>
<?php if(\Input::get('lost') != null && \Input::get('lost') == 'true') { ?>
<div role="alert" class="alert alert-danger alert-dismissible">
	<button aria-label="Close" data-dismiss="alert" class="close" type="button">
		<span aria-hidden="true">×</span>
	</button>
	<?php echo 'オーダーは存在しません';?>
</div>
<?php } ?>
<?php if(\Input::get('permission') != null && \Input::get('permission') == 'false') { ?>
<div role="alert" class="alert alert-danger alert-dismissible">
	<button aria-label="Close" data-dismiss="alert" class="close" type="button">
		<span aria-hidden="true">×</span>
	</button>
	<?php echo '編集の権利がありません。';?>
</div>
<?php } ?>
<?php if(\Session::get_flash('error') && \Input::get('lost') == null) { ?>
	<div role="alert" class="alert alert-danger alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<?php echo \Session::get_flash('error');?>
	</div>
<?php } if(\Session::get_flash('success')){ ?>
	<div role="alert" class="alert alert-success alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<?php echo \Session::get_flash('success');?>
	</div>
<?php } ?>
<?php $listmedias = array_column($listmedias, 'media_name', 'm_media_id');?>
<?php
	$_array = array();
	foreach ($listpost as $_post)
	{
		$_array[$_post['post_id']] = $listmedias[$_post['m_media_id']].' '.$_post['name'];
	}
	$listpost = $_array; unset($_array);

	if($list_all_ss){
		// $listss = array_column($list_all_ss, 'ss_name', 'ss_id');

		$listss = array();
		foreach ($list_all_ss as $ss)
		{
			$listss[$ss['ss_id']] = $ss['branch_name'].'('.$ss['ss_name'].')';
		}

		$listss_item = $listss;
		$list_add2 = array('' => '全て') + array_column($list_all_ss, 'addr2', 'addr2');
		$listss = array('' => '全て') + $listss;
	}else{
		$listss = array('' => '全て');
		$list_add2 = array('' => '全て');
		$listss_item = $listss;
	}
?>
<?php echo Form::open(array('action' => \Uri::base().'job/orders','method' => 'get', 'class' => 'form-inline', 'id' => 'list-orders')); ?>
<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">都道府県</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::select('addr1', Input::get('addr1', isset($get) ? $get->addr1 : ''), \Constants::get_search_address(), array('class'=>'form-control')); ?>
				</div>
				<div class="col-md-2">
					<label class="control-label">市区町村</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::select('maddr2', Input::get('maddr2', isset($get) ? $get->maddr2 : ''), $list_add2, array('class'=>'form-control')); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2">
					<label class="control-label">取引先(受注先)</label>
				</div>
				<div class="col-md-10">
					<select name="group" class="form-control">
						<option value="">全て</option>
						<?php foreach ($listgroup as $group_id => $name) { ?>
						<option value="<?php echo $group_id ?>"<?php echo Fuel\Core\Input::get('group') == $group_id ? ' selected' : '' ?>><?php echo htmlspecialchars($name) ?>
						<?php } ?>
					</select>
					-
					<select name="partner" class="form-control">
						<option value="">全て</option>
						<?php foreach ($listpartner as $row) { ?>
						<option value="<?php echo htmlspecialchars($row['partner_code']) ?>" group_id="<?php echo htmlspecialchars($row['m_group_id']) ?>"<?php echo \Fuel\Core\Input::get('partner') == $row['partner_code'] ? ' selected' : '' ?>><?php echo htmlspecialchars($row['branch_name']) ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2">
					<label class="control-label">SS</label>
				</div>
				<div class="col-md-10">
					<select name="ssid" class="form-control">
						<option value="">全て</option>
						<?php foreach ($list_all_ss as $row) { ?>
						<option value="<?php echo htmlspecialchars($row['ss_id']) ?>" addr1="<?php echo htmlspecialchars($row['addr1']) ?>" partner_code="<?php echo htmlspecialchars($row['partner_code']) ?>"<?php echo \Fuel\Core\Input::get('ssid') == $row['ss_id'] ? ' selected' : '' ?>><?php echo htmlspecialchars($row['ss_name']) ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2">
					<label class="control-label">掲載期間</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::input('apply_date', Input::get('apply_date', isset($get) ? $get->apply_date : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
					～
					<?php echo Form::input('post_date', Input::get('post_date', isset($get) ? $get->post_date : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
				</div>
				<div class="col-md-2">
					<label class="control-label">取引先担当部門</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::select('department_id', Input::get('department_id', isset($get) ? $get->department_id : ''), \Constants::get_search_department(), array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">取引先担当営業</label>
				</div>
				<div class="col-md-10">
					<?php echo Form::select('department', Input::get('department', isset($get) ? $get->department : ''), \Constants::get_search_department(), array('class'=>'form-control')); ?>
					-
					<?php echo Form::select('user_id', Input::get('user_id', isset($get) ? $get->user_id : ''), array(''=>'全て'), array('class'=>'form-control')); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2">
					<label class="control-label">発注者</label>
				</div>
				<div class="col-md-10">
					<?php echo Form::select('order_department', \Fuel\Core\Input::get('order_department'), \Constants::get_search_department(), array('class'=>'form-control')); ?>
					-
					<?php echo Form::select('order_user_id', \Fuel\Core\Input::get('order_user_id'), array(''=>'全て'), array('class'=>'form-control')); ?>
				</div>
			</div>


			<div class="row">
				<div class="col-md-2">
					<label class="control-label">媒体</label>
				</div>
				<div class="col-md-4">
					<?php $listmedias_null = array('' => '全て') + $listmedias; ?>
					<?php echo Form::select('media_id', Input::get('media_id', isset($get) ? $get->media_id : ''), $listmedias_null, array('class'=>'form-control')); ?>
				</div>
				<div class="col-md-2">
					<label class="control-label">状態</label>
				</div>
				<div class="col-md-4">
					<?php foreach(Constants::$order_status as $key =>$val) { ?>
					<label class="checkbox-inline"><input type="checkbox" <?php if(isset($_GET[$key]) && $_GET[$key] == $val){ echo "checked='checked'";} ?> name="<?php echo $key ?>" value="<?php echo $val ?>"><?php echo Constants::$order_status_lable[$val];?></label>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">売上形態</label>
				</div>
				<div class="col-md-8">
					<?php echo Form::select('sale_type', Input::get('sale_type', isset($get) ? $get->sale_type : ''), Constants::$sale_type, array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">キーワード</label>
				</div>
				<div class="col-md-8">
					<input type="text" id="form_keyword" value="<?php echo Input::get('keyword', isset($get) ? $get->keyword : '')?>" name="keyword" placeholder="取引先名 or SS名 or 売上形態名 or 媒体名" size="50" class="form-control">
				</div>
			</div>
			<div class="row text-center">
				<input type="hidden" name="flag" value="1" />
				<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
				<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
				<a class="btn btn-warning btn-sm" href="<?php echo  \Uri::base().'job/orders/index/'.(\Uri::segment(4) ? \Uri::segment(4):1).'?'.http_build_query(\Input::get()).'&export=true'?>"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<?php echo Pagination::instance('orders-pagination'); ?>
		</div>
		<div style="margin: 20px 0; padding-left: 15px;">
			<select class="form-control" name="limit" id="limit">
				<option value="10" <?php if(Fuel\Core\Input::get('limit') == '10') echo 'selected'?>>10件</option>
				<option value="50" <?php if(Fuel\Core\Input::get('limit') == '50') echo 'selected'?>>50件</option>
				<option value="100" <?php if(Fuel\Core\Input::get('limit') == '100') echo 'selected'?>>100件</option>
			</select>
		</div>
	</div>
	<?php if(isset($listorders) && $listorders != NULL && count($listorders) > 0){ ?>
	<table class="table table-bordered table-striped">
		<tbody><tr>
				<th class="text-center">オーダーID</th>
				<th class="text-center">掲載枠</th>
				<th class="text-center">掲載SS</th>
				<th class="text-center">作成者</th>
				<th class="text-center">発注者</th>
				<th class="text-center">掲載開始日</th>
				<th class="text-center">金額</th>
				<th class="text-center">状態</th>
				<th class="text-center">管理</th>
			</tr>
			<?php foreach($listorders as $items){ ?>
			<tr>
				<td><?php echo $items['order_id']; ?></td>
				<td>
				<?php
				$post_id = $items['post_id'];
				if($items['post_id']){
					echo isset($listpost[$post_id]) ? $listpost[$post_id] : '';
				}
				?>
				</td>
				<td>
				<?php
				$first_ss = '';
				if(array_key_exists($items['ss_id'], $listss_item)){
					$first_ss = $listss_item[$items['ss_id']];
				}
				if($items['ss_list']){
					$ss_list_item = explode(',', trim($items['ss_list'] ,','));
					foreach($ss_list_item as $key => $value){
						if(array_key_exists($value, $listss_item)){
							if($first_ss == ''){
								$first_ss.= $listss_item[$value];
							}
							else{
								$first_ss.= ',' .$listss_item[$value];
							}
						}
					}
				}
				echo $first_ss;
				?>
				</td>
				<td><?php echo $items['user_name']; ?></td>
				<td>
					<?php
						if(isset($items['order_user_id']) and  $order_user = Model_Muser::find_by_pk($items['order_user_id']))
						{
							echo $order_user->name;
						}

					?>
				</td>
				<td><?php echo $items['post_date']; ?></td>
				<td class="text-right"><?php echo number_format($items['price']); ?>円</td>
				<td class="text-center">
					<span class="label label-<?php echo \Constants::$order_status_class[$items['status']] ?>"><?php echo array_key_exists($items['status'], \Constants::$order_status_lable) ? \Constants::$order_status_lable[$items['status']] : ''; ?></span>
				</td>
				<td>
					<div class="btn-group">
						<a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-sm btn-success">
							処理
							<span class="caret"></span>
						</a>
						<ul name="add-pulldown" class="dropdown-menu" data-id="<?php echo $items['order_id']; ?>">
							<?php if($items['status'] != 3){ ?>
								<?php //if($items['status'] != 2){ ?>
								<li><a href="<?php echo \Uri::base().'job/order?order_id='.$items['order_id']; ?>" name="add-btn"><i class="glyphicon glyphicon-pencil"></i> 編集</a></li>
								<?php //} ?>
								<?php if(($items['status'] != 2 && $items['status'] != 1) && ($division_type == 1 || $division_type == 2)){ ?>
								<li><a href="javascript:void(0)" class="popup" data-status="<?php echo $items['status']; ?>" name="auth-btn"><i class="glyphicon glyphicon-thumbs-up"></i> 承認・非承認処理</a></li>
								<?php } ?>
								<?php if($items['status'] == 1 && $division_type == 1){ ?>
								<li><a href="javascript:void(0)" class="status" data-status="2" name="fix-btn"><i class="glyphicon glyphicon-ok-sign"></i> 確定処理</a></li>
								<?php } ?>
								<?php if($items['status'] == 2 && $division_type == 1){ ?>
								<li><a href="javascript:void(0)" class="status" data-status="3" name="stop-btn"><i class="glyphicon glyphicon-remove"></i> 停止処理</a></li>
								<?php } ?>
								<?php if($items['status'] == 2){ ?>
									<?php if($division_type == 1){ ?>
									<li>
										<button name="image_add_btn" class="btn btn-info btn-sm image_add_btn" type="button" style="background: none; margin-left:10px; color: #000; border: none; font-size:14px;">
											<i class="glyphicon glyphicon-plus icon-white glyphicon-picture"></i> 媒体画像登録
										</button>
										<input type="file" id="<?php echo $items['order_id'] ?>" class="image hide" name="image" />
									</li>
									<?php } ?>
									<li><a href="javascript:void(0)" onclick="loadPopupBox('<?php echo $items['order_id'] ?>'); return false;" name="view-image-btn"><i class="glyphicon glyphicon-picture"></i> 媒体画像を見る</a></li>
								<?php } ?>
							<?php } else { ?>
								<li><a href="<?php echo \Uri::base().'job/order?order_id='.$items['order_id']; ?>" name="add-btn"><i class="glyphicon glyphicon-pencil"></i> 編集</a></li>
							<?php }?>
							<li><a href="<?php echo \Uri::base().'job/order?order_id='.$items['order_id'].'&action=copy'; ?>" name="add-btn"><i class="glyphicon glyphicon-plus"></i> 複製</a></li>
							<?php if ($items['status'] > 0) { ?>
							<li><a href="<?php echo \Uri::base().'job/person?order_id='.$items['order_id']; ?>" name="person-btn"><i class="glyphicon glyphicon-user"></i> 応募者登録</a></li>
							<?php } ?>
							<li><a onclick="return confirmDel()" href="<?php echo \Uri::base().'job/orders/del_order?order_id='.$items['order_id']; ?>"><i class="glyphicon glyphicon-trash"></i> 削除</a></li>
						</ul>
					</div>
					<div class="popup_box_<?php echo $items['order_id']?> popup_box">
						<a class="popupBoxClose">X</a>
						<br/>
						<?php if($items['image_content']){ ?>
						<img style="max-height:450px;max-width:700px" src="data:<?php echo $items['mine_type'] ?>;base64,<?php echo $items['image_content']?>">
						<?php }else{ ?>
						<p>媒体画像がありません</p>
						<?php } ?>
					</div>
				</td>
			</tr>
			<?php } ?>
		</tbody></table>
		<?php }else{ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			該当するデータがありません
		</div>
		<?php } ?>
<?php echo Form::close(); ?>

<div id="dialog" title="オーダーの承認">
</div>

<script type="text/javascript">
$(document).ready(function(){
	$( "#dialog" ).dialog({
      autoOpen: false,
	  minWidth: 350
    });

	var refleshSelect = function()
	{
		$('select[name=partner] option, select[name=ssid] option').show();

		if ($('select[name=group]').val().length > 0) {
			$('select[name=partner] option[value!=""][group_id!=' + $('select[name=group]').val() + ']').hide().prop('selected', false);
		}

		if ($('select[name=addr1]').val().length > 0) {
			$('select[name=ssid] option[value!=""][addr1!=' + $('select[name=addr1]').val() + ']').hide().prop('selected', false);
		}

		if ($('select[name=partner]').val().length > 0) {
			$('select[name=ssid] option[value!=""][partner_code!=' + $('select[name=partner]').val() + ']').hide().prop('selected', false);
		}
	};

	$('select[name=group],select[name=addr1],select[name=partner]').on('change', function()
	{
		refleshSelect();
	});

	refleshSelect();

	//get list user by department
	function get_list_user(department_id, change){
		var strString = '<option value="">全て</option>';
		$.post(baseUrl + 'job/order/get_users',{department_id: department_id}, function(result){
            var data = jQuery.parseJSON(result);
			for (var i = 0; i < data['list_user'].length; i++) {
                strString += '<option value=' + data['list_user'][i].user_id + '>' + data['list_user'][i].name + '</option>';
            }
            $('select#form_user_id').html(strString);
			if(change == 2){
				$('select#form_user_id').val('<?php echo \Input::get('user_id'); ?>');
			}
        });
	}

	//when submit search
	<?php if(\Input::get('department')){ ?>
		var department_id = '<?php echo \Input::get('department'); ?>';
		get_list_user(department_id, 2);
	<?php }else{ ?>
		get_list_user('', 2);
	<?php } ?>

	$('#form_department').change(function(){
		var department_id = $(this).val();
		get_list_user(department_id, 1);
	});

	//Change order_department filter user id
	$('#form_order_department').on('change',function(){
		var department_id = $(this).val();
		get_list_order_user(department_id,1);
	});

	//get list user by department
	function get_list_order_user(department_id, change){
		var strString = '<option value="">全て</option>';
		$.post(baseUrl + 'job/order/get_users',{department_id: department_id}, function(result){
			var data = jQuery.parseJSON(result);
			for (var i = 0; i < data['list_user'].length; i++) {
				strString += '<option value=' + data['list_user'][i].user_id + '>' + data['list_user'][i].name + '</option>';
			}
			$('select#form_order_user_id').html(strString);
			if(change == 2){
				$('select#form_order_user_id').val('<?php echo \Input::get('order_user_id'); ?>');
			}
		});
	}
	//when submit search
	<?php if(\Input::get('order_department')){ ?>
	var department_id = '<?php echo \Input::get('order_department'); ?>';
	get_list_order_user(department_id, 2);
	<?php }else{ ?>
	get_list_order_user('', 2);
	<?php } ?>

	//update status
	$('ul li a.status').click(function(){
		var status = $(this).attr('data-status');
		message = '承認します、よろしいですか？';
		if(status == 2){
			message = '確定します。よろしいですか？';
		}
		if(status == 3){
			message = '停止します。よろしいですか？';
		}
		var order_id = $(this).parent().parent().attr('data-id');
		if(status == '' || !confirm(message)){
			return false;
		}
		$.post(baseUrl + 'job/orders/update_status',{status: status, order_id:order_id}, function(result){
			if(result == 'failed'){
				window.location.href = '<?php echo \Uri::base(); ?>job/orders?lost=true';
				return false;
			}
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
</script>
<script type="text/javascript">
	function confirmDel(){
		if(!confirm('削除します、よろしいですか？')){
			return false;
		}
	}
	function loadPopupBox(id)
	{	// To Load the Popupbox
		$('.popup_box_'+id).fadeIn("slow");
		$("#container").css({ // this is just for style
			"opacity": "0.3"
		});
	}
	function unloadPopupBox() {	// TO Unload the Popupbox
		$('.popup_box').fadeOut();
		$("#container").css({ // this is just for style
			"opacity": "1"
		});
	}
	$(document).ready( function() {
		$(document).on('click', '.popupBoxClose', function() {
			unloadPopupBox();
		});
		$('#container').click( function() {
			unloadPopupBox();
		});
		//$("a").click(function(){alert(1)});
		/**********************************************************/
		$('a.popup').click(function(){
			var status = $(this).attr('data-status');
			var order_id = $(this).parent().parent().attr('data-id');
			var html = '<button type="button" data-id="'+order_id+'" class="statubtn" value="1">承認済</button><button type="button" class="statubtn" data-id="'+order_id+'" value="-1">非承認</button><button class="statubtn" data-id="'+order_id+'" value="0" type="button" class="popupclose">キャンセル</button>';
			if(status == -1){
				html = '<button type="button" data-id="'+order_id+'" class="statubtn" value="1">承認済</button><button class="statubtn" data-id="'+order_id+'" value="0" type="button" class="popupclose">キャンセル</button>';
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
	});
	$("#limit").on('change',function(){
		$("#list-orders").submit();
	});
</script>