<?php echo \Fuel\Core\Asset::js('validate/group.js')?>
<h3>
	取引先グループ
	<button type="button" id="creategroup" class="btn btn-info btn-sm" name="open-btn"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
</h3>
<?php
echo render('showinfo');
?>
<?php
	echo \Fuel\Core\Form::open(array('class'=>'form-inline', 'method' => 'get', 'id' => 'list-groups'))
?>
<input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit') ? Fuel\Core\Input::get('limit') : ''?>">
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
				<label class="control-label">キーワード</label>
			</div>
			<div class="col-md-10">
				<input type="text" class="form-control" name="keywork" value="<?php echo \Fuel\Core\Input::get('keywork')?>" size="50" placeHolder="グループ名">
			</div>
		</div>
		<div class="row text-center">
			<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
			<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
		</div>
	</div>
</div>
<?php
	echo \Fuel\Core\Form::close();
?>
<form action="" id="action_group" value="" method="post">
	<?php echo \Fuel\Core\Form::input('group_id','',array('type' => 'hidden')); ?>
	<div class="row form-inline">
		<div class="col-md-4">
			<?php echo html_entity_decode($pagination);?>
		</div>
		<div style="margin: 20px 0; padding-left: 15px;">
			<select class="form-control" id="limit">
				<option value="10" <?php if(Fuel\Core\Input::get('limit') == '10') echo 'selected'?>>10件</option>
				<option value="50" <?php if(Fuel\Core\Input::get('limit') == '50') echo 'selected'?>>50件</option>
				<option value="100" <?php if(Fuel\Core\Input::get('limit') == '100') echo 'selected'?>>100件</option>
			</select>
		</div>
	</div>
	<?php
	if(empty($groups))
	{
	?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			データがありません
		</div>
	<?php
	}
	else
	{
	?>
		<table id="grouplist" class="table table-bordered table-striped">
			<tr>
				<th>グループ名</th>
				<th>管理</th>
			</tr>
			<!--List group-->
			<?php
			foreach($groups as $group)
			{
				?>
				<tr>
					<td id="groupname<?php echo $group['m_group_id']; ?>"><?php echo $group['name']; ?></td>
					<td>
						<div class="btn-group">
							<a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-sm btn-success">
								処理
								<span class="caret"></span>
							</a>
							<ul name="add-pulldown" class="dropdown-menu">
								<li class="<?php echo Utility::is_allowed(MyAuth::$role_edit)?>"><a class="edit_group" value="<?php echo $group['m_group_id']; ?>"><i class="glyphicon glyphicon-pencil"></i> 編集</a></li>
								<li><a class="delete_group" value="<?php echo $group['m_group_id']; ?>"><i class="glyphicon glyphicon-trash"></i> 削除</a> </li>
							</ul>
						</div>

					</td>
				</tr>
			<?php
			}
			?>
			<!--End list group-->
		</table>
	<?php
	}
	?>
</form>
<script>
	$(function(){
		$('input[name=keywork]').on('focus', function(){
			$(this).autocomplete('search', $(this).val());
		});
		$('input[name=keywork]').autocomplete({
			minLength : 0,
			source : [
				<?php
				foreach($group_name as $v)
				{
					echo "'".$v['name']."',";
				}
				?>
			]
		});
	});
    $("#limit").on('change',function(){
        var val = $("#limit option:selected").val();
        $("input[name='limit']").val(val);
        $("#list-groups").submit();
    });
</script>