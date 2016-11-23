<?php echo \Fuel\Core\Asset::js('validate/ss.js')?>
<h3>
	SSリスト
	<button id="ss_add_btn" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
</h3>
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

if(Session::get_flash('success'))
{
	?>
	<div role="alert" class="alert alert-success alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<?php echo Session::get_flash('success');?>
	</div>
<?php
}
?>
<?php echo Form::open(array('class' => 'form-inline', 'id' => 'form_search_ss', 'method' => 'get'));?>
	<input type="hidden" name="ss_id" id="ss_id_working">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">都道府県</label>
				</div>
				<div class="col-md-4">
					<?php
						echo Form::select('addr1', isset($filters['addr1']) ? $filters['addr1'] : '', $addr1, array('class' => 'form-control'));
					?>
				</div>
				<div class="col-md-2">
					<label class="control-label">拠点コード</label>
				</div>
				<div class="col-md-4">
					<?php
						echo Form::input('base_code',isset($filters['base_code']) ? $filters['base_code'] : '',array('class' => 'form-control', 'size' => '20'))
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">キーワード</label>
				</div>
				<div class="col-md-4">
					<?php
						echo Form::input('keyword',isset($filters['keyword']) ? $filters['keyword'] : '',array('class' => 'form-control', 'size' => '30', 'maxlength' => 50, 'placeholder' => '取引先グループ名 or 取引先名'));
					?>
				</div>
				<div class="col-md-2">
					<label class="control-label">状態</label>
				</div>
				<div class="col-md-4">
					<label class="checkbox-inline">
						<?php
							echo Form::checkbox('is_available', 1, (isset($filters['is_available']) && $filters['is_available'] == 1) ? true : false, array('class' => 'ss_status_checkbox')).'有効';
						?>
					</label>
					<label class="checkbox-inline">
						<?php
						echo Form::checkbox('is_available', 0, (isset($filters['is_available']) && $filters['is_available'] != '' && $filters['is_available'] == 0) ? true : false, array('class' => 'ss_status_checkbox')).'無効';
						?>
					</label>
					<label class="checkbox-inline">
						<?php
						echo Form::checkbox('status', 0, (isset($filters['status']) && $filters['status'] != '' && $filters['status'] == 0) ? true : false).'承認待ち';
						?>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">取引先担当部門</label>
				</div>
				<div class="col-md-4">
					<?php
					echo \Fuel\Core\Form::select('department_id',isset($filters['department_id']) ? $filters['department_id'] : '', Constants::get_search_department(), array('class' => 'form-control'));
					?>
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
			<select class="form-control" id="limit" name="limit">
				<option value="10" <?php if(Fuel\Core\Input::get('limit') == '10') echo 'selected'?>>10件</option>
				<option value="50" <?php if(Fuel\Core\Input::get('limit') == '50') echo 'selected'?>>50件</option>
				<option value="100" <?php if(Fuel\Core\Input::get('limit') == '100') echo 'selected'?>>100件</option>
			</select>
		</div>
	</div>
	<?php
		if($count_ss == 0)
		{
			echo '<div role="alert" class="alert alert-danger alert-dismissible">';
			echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>';
			echo '該当するデータがありません</div>';
		}
		else
		{
	?>
	<table class="table table-bordered table-striped">
		<tbody><tr>
			<th class="text-center">拠点コード</th>
			<th class="text-center">SS名</th>
			<th class="text-center">取引先グループ</th>
			<th class="text-center">取引先(支店)</th>
			<th class="text-center">状態</th>
			<th class="text-center">管理</th>
		</tr>
		<?php
			foreach ($ss as $v)
			{
		?>
			<tr>
				<td>
					<input class="ss_id" type="hidden" value="<?php echo $v->ss_id; ?>">
					<?php echo $v->base_code; ?>
				</td>
				<td><?php echo $v->ss_name; ?></td>
				<td><?php echo $v->name; ?></td>
				<td><?php echo $v->branch_name; ?></td>
				<td class="text-center">
					<?php
					if ($v->is_available == 1)
					{
					?>
						<span class="label label-success">有効</span>
					<?php
					}
					if ($v->is_available == 0)
					{
						echo '<span class="label label-default">無効</span>';
					}
					if ($v->status == 0)
					{
					?>
						<span class="label label-danger">承認待ち</span>
					<?php
					}
					if ($v->status == 1)
					{
					?>
						<span class="label label-info">承認済み</span>
					<?php
					}
					?>
				</td>
				<td>
					<div class="btn-group">
						<a class="btn dropdown-toggle btn-sm btn-success" data-toggle="dropdown" href="#">
							処理
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" name="add-pulldown">
							<li class="<?php echo Utility::is_allowed(MyAuth::$role_edit)?>"><a name="add-btn"
							       href="<?php echo \Fuel\Core\Uri::base() . 'master/ss?ss_id=' . $v->ss_id?>"><i
										class="glyphicon glyphicon-pencil"></i> 編集</a></li>
							<li>
								<a href="<?php echo \Fuel\Core\Uri::base().'master/sssale?ss_id='.$v->ss_id.'&ss_name='.urlencode($v->ss_name)?>"><i
										class="glyphicon glyphicon-pencil"></i> 売上形態</a></li>
							<?php if ($v->is_available == 0) { ?>
								<li class="<?php echo Utility::is_allowed(MyAuth::$role_public)?>"><a class="ss_btn_active" href="javascript:void(0)" >
										<i class="glyphicon glyphicon-ok"></i> 有効化</a></li>
							<?php } elseif ($v->is_available == 1) { ?>
								<li class="<?php echo Utility::is_allowed(MyAuth::$role_unpublic)?>"><a class="ss_btn_deactive" href="javascript:void(0)">
										<i class="glyphicon glyphicon-remove"></i> 無効化</a></li>
							<?php }
							if ($v->status == 0) {
								?>
								<li class="<?php echo Utility::is_allowed(MyAuth::$role_approval)?>"><a href="javascript:void(0)" class="ss_btn_confirm">
										<i class="glyphicon glyphicon-thumbs-up"></i> 承認</a></li>
							<?php }?>
							<li><a class="ss_btn_delete" href="javascript:void(0)"><i
										class="glyphicon glyphicon-trash"></i> 削除</a></li>
						</ul>
					</div>
				</td>
			</tr>
		<?php
			}
		}
		?>
		</tbody>
	</table>

<?php echo Form::close(); ?>
<script>
	$(function(){
		$('input[name=keyword], input[name=base_code]').on('focus', function(){
			$(this).autocomplete('search', $(this).val());
		});
		$('input[name=keyword]').autocomplete({
			minLength : 0,
			source : [
				<?php
				foreach($ss_autocomplete as $v)
				{
					echo "'".$v->name."','".$v->branch_name."',";
				}
				?>
			]
		});
		$('input[name=base_code]').autocomplete({
			minLength : 0,
			source : [
				<?php
				foreach($ss_autocomplete as $v)
				{
					if($v->base_code) {
						echo "'".$v->base_code."',";
					}

				}
				?>
			]
		});
	});
	$("#limit").on('change',function(){
		$("#form_search_ss").submit();
	});
</script>
