<?php
echo \Fuel\Core\Asset::js('validate/partner.js');
$login_info = \Fuel\Core\Session::get('login_info');
?>
<h3>
	取引先(支店)マスタ
	<button type="button" class="btn btn-info btn-sm" name="add-btn"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
</h3>
<?php
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
<?php
echo render('showinfo');
?>
<?php
echo \Fuel\Core\Form::open(array('name' => 'form-partner-list', 'id' => 'form-partner-list', 'method' => 'get', 'class' => 'form-inline'));
?>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
				<label class="control-label">取引区分</label>
			</div>
			<div class="col-md-4">
				<?php
				echo \Fuel\Core\Form::select('type', isset($filter['type']) ? $filter['type'] : '' ,Constants::$_type_partner, array('class' => 'form-control'));
				?>
			</div>
			<div class="col-md-2">
				<label class="control-label">都道府県</label>
			</div>
			<div class="col-md-4">
				<?php
				$address = Constants::get_search_address();
				echo Fuel\Core\Form::select('addr1', isset($filter['addr1']) ? $filter['addr1'] : '', $address, array('class' => 'form-control', 'id' => 'search_addr1'));
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<label class="control-label">取引先コード</label>
			</div>
			<div class="col-md-4">
				<?php
				echo \Fuel\Core\Form::input('partner_code', isset($filter['partner_code']) ? $filter['partner_code'] : '', array('class' => 'form-control', 'size' => '20'));
				?>
			</div>
			<div class="col-md-2">
				<label class="control-label">キーワード</label>
			</div>
			<div class="col-md-4">
				<?php
				echo \Fuel\Core\Form::input('keyword', isset($filter['keyword']) ? $filter['keyword'] : '',array('class' => 'form-control w100', 'placeHolder' => '法人名 or 支店名'));
				?>
			</div>
		</div>
        <div class="row">
			<div class="col-md-2">
				<label class="control-label">UOS営業所</label>
			</div>
			<div class="col-md-4">
				<?php
					echo \Fuel\Core\Form::select('department_id',isset($filter['department_id']) ? $filter['department_id'] : '', Constants::get_search_department(), array('class' => 'form-control'));
				?>
			</div>

			<div class="col-md-2">
				<label class="control-label">状態</label>
			</div>
			<div class="col-md-4">
				<label class="checkbox-inline">
					<?php
						echo \Fuel\Core\Form::checkbox('status','1',isset($filter['status']) and $filter['status'] == 1 ? true : false);
					?>
					承認待ち</label>
			</div>
		</div>

        <?php  if ($login_info['division_type'] == 1) {?>
        <div class="row">
            <div class="col-md-2">
                <label class="control-label">非表示フラグ</label>
            </div>
            <div class="col-md-4">
                <label class="checkbox-inline"><input id="is_hidden_1" name="is_hidden" value="1" <?php if(\Fuel\Core\Input::get('is_hidden') == '1') echo 'checked="checked"'?> type="checkbox">ON</label>
                <label class="checkbox-inline"><input id="is_hidden_0" name="is_hidden" value="0" <?php if(\Fuel\Core\Input::get('is_hidden') == '0') echo 'checked="checked"'?> type="checkbox">OFF</label>
            </div>
        </div>
        <?php } ?>

        <div class="row text-center">
			<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
			<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
			<a class="btn btn-warning btn-sm" id="btn_down_csv" href="<?php echo \Uri::base() . 'master/partners' . '?' . http_build_query(\Input::get()) . '&export=true' ?>"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</a>
		</div>
	</div>
</div>
<div class="row form-inline">
    <div class="col-md-4">
        <?php echo html_entity_decode($pagination);?>
    </div>
    <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
    <?php if (!empty($partners)) {?>
        <div style="margin: 20px 0; padding-left: 15px;">
            <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
        </div>
    <?php }?>
</div>
<?php
if(empty($partners))
{
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		該当するデータがありません
	</div>
<?php
}
else
{
?>
<?php if ($login_info['division_type'] == 1) {?>
<div class="alert alert-info">
	<span class="text-info">チェックした取引先(支店)を</span>
	<button type="button" class="btn btn-sm btn-info" name="visible-btn" id="visible-btn">
		<i class="glyphicon glyphicon-eye-open"></i> 再表示
	</button>
	<button type="button" class="btn btn-sm btn-danger" name="hidden-btn" id="hidden-btn">
		<i class="glyphicon glyphicon-eye-close"></i> 非表示
	</button>
</div>
<?php } ?>
<table class="table table-bordered">
	<tr>
        <?php if ($login_info['division_type'] == 1) {?>
            <th class="text-center">
                <input name="all" type="checkbox">
            </th>
        <?php }?>
		<th class="text-center">取引先コード</th>
		<th class="text-center">法人名</th>
		<th class="text-center">支店名</th>
		<th class="text-center">住所</th>
		<th class="text-center">状態</th>
		<th class="text-center">管理</th>
	</tr>
	<?php
	foreach ($partners as $partner)
	{
		?>
        <tr class='<?php echo $partner['is_hidden'] ? 'bg-gray' : '' ?>'>
            <?php if ($login_info['division_type'] == 1) {?>
                <td>
                    <input name="all_id" value="<?php echo $partner['partner_code']; ?>" type="checkbox">
                </td>
            <?php }?>
            <td><?php echo isset($partner['partner_code']) ? $partner['partner_code'] : ''; ?></td>
			<td><?php echo isset($partner['group_name']) ? $partner['group_name'] : ''; ?></td>
			<td><?php echo isset($partner['branch_name']) ? $partner['branch_name'] : ''; ?></td>
			<td><?php echo isset($partner['addr1'])? Constants::$address_1[$partner['addr1']] : ''; echo isset($partner['addr2']) ?  $partner['addr2'] : ''; ?><?php echo isset($partner['addr3']) ? $partner['addr3'] : ''; ?></td>
			<td class="text-center" id="status<?php echo $partner['partner_code']; ?>">
				<?php
				if ($partner['status'] == Constants::$_status_partner['pending'])
				{
				?>
					<span class="label label-danger">承認待ち</span>
				<?php
				}
				else
				{
				?>
					<span class="label label-info">承認済み</span>
				<?php
				}
				?>
			</td>
			<td>
					<div class="btn-group">
						<a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-sm btn-success">
							処理
							<span class="caret"></span>
						</a>
						<ul name="add-pulldown" class="dropdown-menu">
							<li class="<?php echo Utility::is_allowed(MyAuth::$role_edit)?>"><a href="#" value="<?php echo $partner['partner_code']; ?>" class="edit_partner"><i
										class="glyphicon glyphicon-pencil"></i> 編集</a>
				</li>
				<li class="<?php echo Utility::is_allowed(MyAuth::$role_approval) ?>" ><a href="#" value="<?php echo $partner['partner_code']; ?>" class="<?php  if ($partner['status'] == Constants::$_status_partner['approval']) echo 'pointer_disabled'; ?> approval_partner"><i
							class="glyphicon glyphicon-thumbs-up"></i> 承認</a></li>
                <?php  if ($login_info['division_type'] == 1) {?>
				<li><a href="#" value="<?php echo $partner['partner_code']; ?>" class="delete_partner"><i
							class="glyphicon glyphicon-trash"></i> 削除</a></form></li>
                <?php } ?>
				</ul>
				</div>

			</td>
		</tr>

	<?php
	}
}
	?>

</table>
<input type="hidden" id="action_partner_code" name="action_partner_code" value="">
<div class="row form-inline">
    <div class="col-md-4">
        <?php echo html_entity_decode($pagination);?>
    </div>
    <?php if (!empty($partners)) {?>
        <div style="margin: 20px 0; padding-left: 15px;">
            <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
        </div>
    <?php }?>
</div>
<?php
	echo \Fuel\Core\Form::close();
?>
<script>
	$(function(){
		$('input[name=keyword]').autocomplete({
			source : <?php
				$_array = [];
				foreach($partner_autocomplete as $v)
				{
					$_array[] = $v['name'];
					$_array[] = $v['branch_name'];
				}
				echo json_encode(array_values(array_unique($_array)));
			?>
		});
		$('input[name=partner_code]').autocomplete({
			source : <?php
				$_array = [];
				foreach($partner_autocomplete as $v)
				{
                    if (strlen($v['partner_code'])) { $_array[] = $v['partner_code']; }
				}
				echo json_encode(array_values(array_unique($_array)));
            ?>
		});
	});
	$(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
		$("#form-partner-list").submit();
	});
	$("#visible-btn").on('click',function(){
		setHiddenVisibale(0,'m_partner','partner_code','<?php echo Fuel\Core\Uri::base()?>');
	});
	$("#hidden-btn").on('click',function(){
		setHiddenVisibale(1,'m_partner','partner_code','<?php echo Fuel\Core\Uri::base()?>');
	});
</script>
