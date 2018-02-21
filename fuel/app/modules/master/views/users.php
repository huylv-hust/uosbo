<?php echo \Fuel\Core\Asset::js('validate/user.js')?>

<h3>
	ログインアカウントリスト
	<button id="users_btn_add" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-plus icon-white"></i>
		新規追加
	</button>
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
<?php echo Form::open(array('class' => 'form-inline', 'id' => 'form_search_user', 'method' => 'GET'));?>
<input type="hidden" name="user_id" id="user_id_working">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">所属部門</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::select('department_id', isset($filters['department_id']) ? $filters['department_id'] : '', $department, array('class' => 'form-control')); ?>
				</div>
				<div class="col-md-2">
					<label class="control-label">氏名</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::input('name', isset($filters['name']) ? $filters['name'] : '', array('class' => 'form-control', 'size' => 20));?>
				</div>
			</div>
			<div class="row text-center">
				<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
				<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
                <a class="btn btn-warning btn-sm" id="btn_down_csv" href="<?php echo \Uri::base() . 'master/users' . '?' . http_build_query(\Input::get()) . '&export=true' ?>"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</a>
            </div>
		</div>
	</div>
    <div class="row form-inline">
        <div class="col-md-4">
            <?php echo html_entity_decode($pagination);?>
        </div>
        <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
        <?php if (!empty($count_user)) {?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        <?php }?>
    </div>
	<?php
	if($count_user == 0)
	{
		echo '<div role="alert" class="alert alert-danger alert-dismissible">';
		echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>';
		echo '該当するデータがありません</div>';
	}
	else
	{
	?>
	<table class="table table-bordered table-striped">
		<tbody>
		<tr>
			<th class="text-center">所属部門</th>
			<th class="text-center">氏名</th>
			<th class="text-center">ログインID</th>
			<th class="text-center">権限</th>
			<th class="text-center">メールアドレス</th>
			<th class="text-center">管理</th>
		</tr>
		<?php
			foreach($users as $user)
			{
		?>
			<tr>
				<td><?php echo $department[$user->department_id]; ?></td>
				<td><?php echo $user->name; ?></td>
				<td><?php echo $user->login_id; ?></td>
				<td><?php echo $division_type[$user->division_type]; ?></td>
				<td><?php echo $user->mail; ?></td>
				<td>
					<input class="user_id" type="hidden" value="<?php echo $user->user_id; ?>">
					<div class="btn-group">
						<a class="btn dropdown-toggle btn-sm btn-success" data-toggle="dropdown" href="#">
							処理
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" name="add-pulldown">
							<li><a href="<?php echo \Fuel\Core\Uri::base().'master/user?user_id='.$user->user_id; ?>"><i class="glyphicon glyphicon-pencil"></i> 編集</a></li>
							<li><a class="users_btn_delete" href="#"><i class="glyphicon glyphicon-trash"></i> 削除</a></li>
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
    <div class="row form-inline">
        <div class="col-md-4">
            <?php echo html_entity_decode($pagination);?>
        </div>
        <?php if (!empty($count_user)) {?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        <?php }?>
    </div>
</form>
<script>
	$(function(){
		$('input[name=name]').autocomplete({
			source : <?php
				$_array = [];
				foreach($users_autocomplete as $v)
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
		$("#form_search_user").submit();
	});
</script>
