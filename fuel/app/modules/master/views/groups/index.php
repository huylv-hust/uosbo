<?php echo \Fuel\Core\Asset::js('validate/group.js')?>
<h3>
	取引先(法人)マスタ
	<button type="button" id="creategroup" class="btn btn-info btn-sm" name="open-btn"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
</h3>
<?php
echo render('showinfo');
?>
<?php
	echo \Fuel\Core\Form::open(array('class'=>'form-inline', 'method' => 'get', 'id' => 'list-groups'))
?>
<input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
				<label class="control-label">キーワード</label>
			</div>
			<div class="col-md-10">
				<input type="text" class="form-control w100" name="keywork" value="<?php echo \Fuel\Core\Input::get('keywork')?>" placeHolder="法人名">
			</div>
		</div>
		<div class="row text-center">
			<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
			<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
            <a class="btn btn-warning btn-sm" href="<?php echo \Fuel\Core\Uri::base().'master/groups/export?'.http_build_query(\Fuel\Core\Input::get());?>"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</a>
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
		<?php if (!empty($groups)) {?>
		<div style="margin: 20px 0; padding-left: 15px;">
            <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
		</div>
		<?php }?>
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
				<th>法人名</th>
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
                                <?php if ($login_info['division_type'] == 1) { ?>
								<li><a class="delete_group" value="<?php echo $group['m_group_id']; ?>"><i class="glyphicon glyphicon-trash"></i> 削除</a> </li>
                                <?php } ?>
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
    <div class="row form-inline">
        <div class="col-md-4">
            <?php echo html_entity_decode($pagination);?>
        </div>
        <?php if (!empty($groups)) {?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        <?php }?>
    </div>
</form>
<script>
	$(function(){
		$('input[name=keywork]').autocomplete({
			source : <?php
				$_array = [];
				foreach($group_name as $v)
				{
                    if (strlen($v['name'])) { $_array[] = $v['name']; }
				}
				echo json_encode(array_values(array_unique($_array)));
			?>
		});
	});
    $(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
        $("#list-groups").submit();
    });
</script>
