<?php
use Fuel\Core\Input;
?>
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
<?php echo Form::open(array('action' => \Uri::base().'job/orders','method' => 'get', 'class' => 'form-inline', 'id' => 'list-orders')); ?>
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
					<?php echo Form::select('addr1', Input::get('addr1', isset($get) ? $get->addr1 : ''), \Constants::get_search_address(), array('class'=>'form-control')); ?>
				</div>
				<div class="col-md-2">
					<label class="control-label">市区町村</label>
				</div>
				<div class="col-md-4">
                    <select name="maddr2" class="form-control">
                        <option value="">全て</option>
                    </select>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2">
					<label class="control-label">取引先（法人）</label>
				</div>
				<div class="col-md-10">
					<select name="group" class="form-control">
						<option value="">全て</option>
						<?php foreach ($listgroup as $group_id => $name) { ?>
						<option value="<?php echo $group_id ?>"<?php echo Fuel\Core\Input::get('group') == $group_id ? ' selected' : '' ?>><?php echo htmlspecialchars($name) ?>
						<?php } ?>
					</select>
                    <div class="input-group">
                        <div class="input-group-addon">取引先（支店）</div>
                        <select name="partner" class="form-control">
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
					<select name="ssid" class="form-control">
						<option value="">全て</option>
					</select>
				</div>
			</div>

			<div class="row">
                <div class="col-md-2">
                    <label class="control-label">申請日</label>
                </div>
                <div class="col-md-4">
                    <?php echo Form::input('apply_date1', Input::get('apply_date1', isset($get) ? $get->apply_date1 : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
                    ～
                    <?php echo Form::input('apply_date2', Input::get('apply_date2', isset($get) ? $get->apply_date2 : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
                </div>
				<div class="col-md-2">
					<label class="control-label">掲載開始日</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::input('post_date1', Input::get('post_date1', isset($get) ? $get->post_date1 : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
					～
					<?php echo Form::input('post_date2', Input::get('post_date2', isset($get) ? $get->post_date2 : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
				</div>
                <!--
				<div class="col-md-2">
					<label class="control-label">取引先担当部門</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::select('department_id', Input::get('department_id', isset($get) ? $get->department_id : ''), \Constants::get_search_department(), array('class'=>'form-control')); ?>
				</div>
				-->
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">UOS営業所</label>
				</div>
				<div class="col-md-6">
					<?php echo Form::select('department', Input::get('department', isset($get) ? $get->department : ''), \Constants::get_search_department(), array('class'=>'form-control')); ?>
                    <div class="input-group">
                        <div class="input-group-addon">UOS担当者</div>
                        <?php echo Form::select('user_id', Input::get('user_id', isset($get) ? $get->user_id : ''), array(''=>'全て'), array('class'=>'form-control')); ?>
                    </div>
				</div>
                <div class="col-md-1">
                    <label class="control-label">発注者</label>
                </div>
                <div class="col-md-3">
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
					<?php foreach(Constants::$order_status as $key =>$val) { if ($key == 'stop') { continue; } ?>
					<label class="checkbox-inline"><input type="checkbox" <?php echo @in_array($val, Input::get('status')) ? ' checked' : '' ?> name="status[]" value="<?php echo $val ?>"><?php echo Constants::$order_status_lable[$val];?></label>
					<?php } ?>
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
					<label class="control-label">キーワード</label>
				</div>
				<div class="col-md-8">
					<input type="text" id="form_keyword" value="<?php echo Input::get('keyword', isset($get) ? $get->keyword : '')?>" name="keyword" placeholder="取引先名 or SS名 or 売上形態名 or 媒体名" class="form-control w100">
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

	<div class="row form-inline">
		<div class="col-md-4">
			<?php echo Pagination::instance('orders-pagination'); ?>
		</div>
        <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
		<?php if(isset($listorders) && $listorders != NULL && count($listorders) > 0){ ?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
		<?php }?>
	</div>
	<?php if(isset($listorders) && $listorders != NULL && count($listorders) > 0){ ?>
	<table class="table table-bordered table-striped">
		<tbody><tr>
				<th class="text-center">オーダーID</th>
				<th class="text-center">媒体</th>
				<th class="text-center">勤務地</th>
            <th class="text-center">勤務形態</th>
				<th class="text-center">作成者</th>
				<th class="text-center">発注者</th>
				<th class="text-center">掲載開始日</th>
				<th style="min-width: 115px;" class="text-center">金額</th>
                <th class="text-center">応募人数</th>
                <th class="text-center">採用人数</th>
				<th class="text-center">状態</th>
				<th class="text-center">管理</th>
			</tr>
			<?php foreach($listorders as $items){ ?>
			<tr>
				<td><?php echo $items['order_id']; ?></td>
                <td><?php echo $items['media_name']; ?> <?php echo $items['media_version_name']; ?></td>
                <td>
                    <div><?php echo $items['place']; ?></div>
                    <?php foreach (Model_Orders::ssPlaces($items['ss_list']) as $_place) { ?>
                        <div><?php echo htmlspecialchars($_place) ?></div>
                    <?php } ?>
                </td>
                <td><?php echo Constants::$sale_type[$items['sale_type']] ?></td>
				<td><?php echo $items['create_user_name']; ?></td>
                <td><?php echo $items['order_user_name']; ?></td>
				<td><?php echo $items['post_date']; ?></td>
				<td class="text-right"><?php echo number_format($items['price']); ?>円</td>
                <td class="text-right"><?php echo number_format($items['application_count']); ?>人</td>
                <td class="text-right"><?php echo number_format($items['employment_count']); ?>人</td>
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
                            <?php if ($division_type == 1) { ?>
							<li><a class="delete_order" onclick="return confirmDel()" href="<?php echo \Uri::base().'job/orders/del_order?order_id='.$items['order_id']; ?>"><i class="glyphicon glyphicon-trash"></i> 削除</a></li>
                            <?php } ?>
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
    <div class="row form-inline">
        <div class="col-md-4">
            <?php echo Pagination::instance('orders-pagination'); ?>
        </div>
        <?php if(isset($listorders) && $listorders != NULL && count($listorders) > 0){ ?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        <?php }?>
    </div>
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

    var getParams = {
        groupId : '<?php echo \Fuel\Core\Input::get('group') ?>',
        partnerCode : '<?php echo \Fuel\Core\Input::get('partner') ?>',
        ssid : '<?php echo \Fuel\Core\Input::get('ssid') ?>'
    };

    $('select[name=group]').on('change', function()
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
            $("select[name=partner] option[value!='']").remove();
            $.each(response, function()
            {
                var opt = $('<option></option>')
                    .attr('value', this.partner_code)
                    .text(this.branch_name)
                ;

                if (this.partner_code == getParams.partnerCode) {
                    opt.prop('selected', true);
                }

                $("select[name=partner]").append(opt);
            });
            $("select[name=partner]").trigger('change');
        });
    }).trigger('change');

    $('select[name=partner]').on('change', function()
    {
        if (getParams.partnerCode != $(this).val()) {
            getParams.ssid = null;
        }

        $.getJSON(
            '<?php echo Fuel\Core\Uri::base()?>ajax/common/get_ss',
            { 'group_id' : $('select[name=group]').val(), 'partner_code' : $(this).val() }
        ).done(function(response)
        {
            $("select[name=ssid] option[value!='']").remove();
            $.each(response, function()
            {
                var opt = $('<option></option>')
                    .attr('value', this.ss_id)
                    .text(this.ss_name)
                ;

                if (this.ss_id == getParams.ssid) {
                    opt.prop('selected', true);
                }

                $("select[name=ssid]").append(opt);
            });
        });
    });

    $('select[name=addr1]').on('change', function() {
        var param = {
            addr1: $(this).val()
        };
        var request = $.ajax({
            type: 'post',
            data: param,
            url: baseUrl + 'ajax/common/get_addr2'
        });
        var selected = '<?php echo Input::get('maddr2') ?>';
        request.done(function(data){
            $("select[name=maddr2] option[value!='']").remove();
            data = jQuery.parseJSON(data);
            $.each(data, function(key, value){
                var option = $('<option></option>').attr('value', value).text(value);
                if (value == selected) {
                    option.prop('selected', true);
                }
                $('select[name=maddr2]').append(option);
            });
        });
    }).trigger('change');

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

	// order department
    get_list_order_user(203, 2);

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
				window.location.href = '<?php echo $requestUriLost; ?>';
				return false;
			}
			if(result == 'true'){
				var return_url_search = '<?php echo \Cookie::get('return_url_search'); ?>';
				if(return_url_search)
				{
					window.location.href = return_url_search;
					return false;
				}
				window.location.href = '<?php echo $requestUri; ?>';
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
						window.location.href = '<?php echo $requestUriLost; ?>';
						return false;
					}
					if(result == 'true'){
						window.location.href = '<?php echo $requestUri; ?>';
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
					window.location.href = '<?php echo $requestUriLost; ?>';
					return false;
				}
				if(result == 'true'){
					window.location.href = '<?php echo $requestUri; ?>';
				}
			});
		});

		//autocomplete
		$('input[name=keyword]').autocomplete({
			source : <?php
				$_array = [];
				foreach($orders_autocomplete as $v)
				{
					if (strlen($v['sale_name'])) { $_array[] = $v['sale_name']; }
					if (strlen($v['ss_name'])) { $_array[] = $v['ss_name']; }
					if (strlen($v['branch_name'])) { $_array[] = $v['branch_name']; }
					if (strlen($v['media_name'])) { $_array[] = $v['media_name']; }
				}
				echo json_encode(array_values(array_unique($_array)));
			?>
		});
	});
	$(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
		$("#list-orders").submit();
	});
</script>
