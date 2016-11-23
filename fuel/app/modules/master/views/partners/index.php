<?php echo \Fuel\Core\Asset::js('validate/partner.js')?>
<h3>
	取引先(支店)リスト
	<button type="button" class="btn btn-info btn-sm" name="add-btn"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
</h3>
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
				<label class="control-label">取引先区分</label>
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
				echo \Fuel\Core\Form::input('keyword', isset($filter['keyword']) ? $filter['keyword'] : '',array('class' => 'form-control', 'size' => '30', 'maxlength' => '16', 'placeHolder' => '取引先グループ名 or 取引先名'));
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<label class="control-label">取引先担当部門</label>
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
		<div class="row text-center">
			<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
			<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
		</div>
	</div>
</div>
<div class="row form-inline">
	<div class="col-md-4">
		<?php echo html_entity_decode($pagination);?>
	</div>
	<div style="margin: 20px 0; padding-left: 15px;">
		<select class="form-control" name="limit" id="limit">
			<option value="10" <?php if(Fuel\Core\Input::get('limit') == '10') echo 'selected'?>>10件</option>
			<option value="50" <?php if(Fuel\Core\Input::get('limit') == '50') echo 'selected'?>>50件</option>
			<option value="100" <?php if(Fuel\Core\Input::get('limit') == '100') echo 'selected'?>>100件</option>
		</select>
	</div>
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
<table class="table table-bordered table-striped">
	<tr>
		<th class="text-center">取引先コード</th>
		<th class="text-center">取引先グループ</th>
		<th class="text-center">取引先名</th>
		<th class="text-center">住所</th>
		<th class="text-center">状態</th>
		<th class="text-center">管理</th>
	</tr>
	<?php
	foreach ($partners as $partner)
	{
		?>
		<tr>
			<td><?php echo isset($partner['partner_code']) ? $partner['partner_code'] : ''; ?></td>
			<td><?php echo isset($partner['name']) ? $partner['name'] : ''; ?></td>
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
				<li><a href="#" value="<?php echo $partner['partner_code']; ?>" class="delete_partner"><i
							class="glyphicon glyphicon-trash"></i> 削除</a></form></li>
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
<?php
	echo \Fuel\Core\Form::close();
?>
<script>
	$(function(){
		$('input[name=keyword], input[name=partner_code]').on('focus', function(){
			$(this).autocomplete('search', $(this).val());
		});
		$('input[name=keyword]').autocomplete({
			minLength : 0,
			source : [
				<?php
				foreach($partner_autocomplete as $v)
				{
					echo "'".$v['name']."','".$v['branch_name']."',";
				}
				?>
			]
		});
		$('input[name=partner_code]').autocomplete({
			minLength : 0,
			source : [
				<?php
				foreach($partner_autocomplete as $v)
				{
					echo "'".$v['partner_code']."',";
				}
				?>
			]
		});
	});
	$("#limit").on('change',function(){
		$("#form-partner-list").submit();
	});
</script>
