<?php
    echo \Fuel\Core\Asset::js('validate/ss.js');
    $login_info = \Fuel\Core\Session::get('login_info');
?>
<h3>
	SSマスタ
	<button id="ss_add_btn" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
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
						echo Form::input('keyword',isset($filters['keyword']) ? $filters['keyword'] : '',array('class' => 'form-control w100', 'placeholder' => '法人名 or 支店名 or SS名'));
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
					<label class="control-label">UOS営業所</label>
				</div>
				<div class="col-md-4">
					<?php
					echo \Fuel\Core\Form::select('department_id',isset($filters['department_id']) ? $filters['department_id'] : '', Constants::get_search_department(), array('class' => 'form-control'));
					?>
				</div>
				<?php if ($login_info['division_type'] == 1) {?>
					<div class="col-md-2">
						<label class="control-label">非表示フラグ</label>
					</div>
					<div class="col-md-4">
						<label class="checkbox-inline"><input name="is_hidden" id="is_hidden_1" value="1" <?php if(\Fuel\Core\Input::get('is_hidden') == '1') echo 'checked="checked"'?> type="checkbox">ON</label>
						<label class="checkbox-inline"><input name="is_hidden" id="is_hidden_0" value="0" <?php if(\Fuel\Core\Input::get('is_hidden') == '0') echo 'checked="checked"'?> type="checkbox">OFF</label>
					</div>
				<?php }?>
			</div>
			<div class="row text-center">
				<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
				<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
				<a class="btn btn-warning btn-sm" href="<?php echo \Fuel\Core\Uri::base().'master/sslist/export?'.http_build_query($filters);?>"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</a>
			</div>
		</div>
	</div>

    <div class="row form-inline">
        <div class="col-md-4">
            <?php echo html_entity_decode($pagination);?>
        </div>
        <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
        <?php if (!empty($count_ss)) {?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        <?php }?>
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
<?php if ($login_info['division_type'] == 1) {?>
	<div class="alert alert-info">
		<span class="text-info">チェックしたSSを</span>
		<button type="button" class="btn btn-sm btn-info" name="visible-btn" id="visible-btn">
			<i class="glyphicon glyphicon-eye-open"></i> 再表示
		</button>
		<button type="button" class="btn btn-sm btn-danger" name="hidden-btn" id="hidden-btn">
			<i class="glyphicon glyphicon-eye-close"></i> 非表示
		</button>
	</div>
<?php }?>
	<table class="table table-bordered">
		<tbody>
        <tr>
            <?php if ($login_info['division_type'] == 1) {?>
            <th class="text-center">
                <input name="all" type="checkbox">
            </th>
            <?php }?>
            <th class="text-center">拠点コード</th>
			<th class="text-center">SS名</th>
			<th class="text-center">法人名</th>
			<th class="text-center">支店名</th>
			<th class="text-center">状態</th>
			<th class="text-center">管理</th>
		</tr>
		<?php
			foreach ($ss as $v)
			{
		?>
        <tr class='<?php echo $v->is_hidden ? 'bg-gray' : '' ?>'>
				<?php if ($login_info['division_type'] == 1) {?>
				<td>
                    <input name="all_id" value="<?php echo $v->ss_id; ?>" type="checkbox">
                </td>
				<?php }?>
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

                            <?php if ($login_info['division_type'] == 1) { ?>
							<?php if ($v->is_available == 0) { ?>
								<li class="<?php echo Utility::is_allowed(MyAuth::$role_public)?>"><a class="ss_btn_active" href="javascript:void(0)" >
										<i class="glyphicon glyphicon-ok"></i> 有効化</a></li>
							<?php } elseif ($v->is_available == 1) { ?>
								<li class="<?php echo Utility::is_allowed(MyAuth::$role_unpublic)?>"><a class="ss_btn_deactive" href="javascript:void(0)">
										<i class="glyphicon glyphicon-remove"></i> 無効化</a></li>
							<?php } ?>
                            <?php } ?>

							<?php if ($v->status == 0) { ?>
								<li class="<?php echo Utility::is_allowed(MyAuth::$role_approval)?>"><a href="javascript:void(0)" class="ss_btn_confirm">
										<i class="glyphicon glyphicon-thumbs-up"></i> 承認</a></li>
							<?php }?>
                            <?php if ($login_info['division_type'] == 1) {?>
							<li><a class="ss_btn_delete" href="javascript:void(0)"><i
										class="glyphicon glyphicon-trash"></i> 削除</a></li>
                            <?php } ?>
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
        <?php if (!empty($count_ss)) {?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        <?php }?>
    </div>

<?php echo Form::close(); ?>
<script>
	$(function(){
		$('input[name=keyword]').autocomplete({
			source : <?php
				$_array = [];
				foreach($ss_autocomplete as $v)
				{
					$_array[] = $v->name;
					$_array[] = $v->branch_name;
				}
				echo json_encode(array_values(array_unique($_array)));
			?>
		});
		$('input[name=base_code]').autocomplete({
			source : <?php
				$_array = [];
				foreach($ss_autocomplete as $v)
				{
                    if (strlen($v->base_code)) { $_array[] = $v->base_code; }
				}
				echo json_encode(array_values(array_unique($_array)));
            ?>
		});
	});
	$(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
		$("#form_search_ss").submit();
	});
    $("#visible-btn").on('click',function(){
        setHiddenVisibale(0,'m_ss','ss_id','<?php echo Fuel\Core\Uri::base()?>');
    });
    $("#hidden-btn").on('click',function(){
        setHiddenVisibale(1,'m_ss','ss_id','<?php echo Fuel\Core\Uri::base()?>');
    });
</script>
