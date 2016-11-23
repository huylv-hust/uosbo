<h3>
	事業所名変換設定
</h3>
<form class="form-inline" method="get" action="" id="obic7-office-list">
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
				<label class="control-label">キーワード</label>
			</div>
			<div class="col-md-4">
				<input type="text" placeholder="取引先グループ名" maxlength="100" size="30" value="<?php echo Fuel\Core\Input::get('keywork','')?>" name="keywork" class="form-control">
			</div>
		</div>
		<div class="row text-center">
			<button class="btn btn-primary btn-sm" type="submit"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
			<button name="filter-clear-btn" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
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
</form>
<form class="form-inline" method="post" action="">

		<?php if(Fuel\Core\Session::get_flash('success')) {?>
		<div role="alert" class="alert alert-success alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
			<?php echo Fuel\Core\Session::get_flash('success')?>
		</div>
		<?php } ?>
		<?php if(Fuel\Core\Session::get_flash('error')) {?>
		<div role="alert" class="alert alert-danger alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
			<?php echo Fuel\Core\Session::get_flash('error')?>
		</div>
		<?php } ?>

		<?php if(count($groups)) {?>
		<table class="table table-bordered table-striped">
			<tbody>
			<tr>
				<th class="text-center">変換前</th>
				<th class="text-center">→</th>
				<th class="text-center">変換後</th>
			</tr>
			<?php foreach($groups as $group) {?>
				<tr>
					<td><?php echo $group['name']?></td>
					<td>→</td>
					<td><input type="text" name="obic7_name[][<?php echo $group['m_group_id']?>]" maxlength="100" size="30" value="<?php echo $group['obic7_name']?>" class="form-control"></td>
				</tr>
			<?php } ?>

			</tbody>
		</table>
		<div class="text-center">
			<button name="save-btn" class="btn btn-primary btn-sm" type="submit">
				<i class="glyphicon glyphicon-pencil icon-white"></i>
				保存
			</button>
		</div>
		<?php } else { ?>
		<div role="alert" class="alert alert-danger alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
			該当するデータがありません
		</div>
		<?php } ?>

</form>
<script>
	$("#limit").on('change',function(){
		$("#obic7-office-list").submit();
	});
</script>