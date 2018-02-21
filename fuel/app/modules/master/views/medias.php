<?php
echo \Fuel\Core\Asset::js('validate/media.js');
$login_info = \Fuel\Core\Session::get('login_info');
?>
<h3>
	媒体マスタ
	<button id="media_create_btn" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
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
<?php echo Form::open(array('class' => 'form-inline', 'id' => 'form_search_media', 'method' => 'GET'));?>
<input type="hidden" name="m_media_id" id="m_media_id">
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
					<label class="control-label">広告会社</label>
				</div>
				<div class="col-md-4">
					<?php
						echo Form::select('m_group_id', isset($filters['m_group_id']) ? $filters['m_group_id'] : '', $groups, array('class' => 'form-control', 'id' => 'medias_group', 'style' => 'max-width:150px')); ?>
					-
					<?php
						echo Form::select('partner_code', isset($filters['partner_code']) ? $filters['partner_code'] : '', $partners, array('class' => 'form-control', 'id' => 'medias_partner', 'style' => 'max-width:150px'));
					?>
				</div>
				<div class="col-md-2">
					<label class="control-label">自他区分</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::select('type', isset($filters['type']) ? $filters['type'] : '', $type, array('class' => 'form-control'));?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">分類</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::select('classification', isset($filters['classification']) ? $filters['classification'] : '', $classification, array('class' => 'form-control'));?>
				</div>
				<div class="col-md-2">
					<label class="control-label">キーワード</label>
				</div>
				<div class="col-md-4">
					<?php echo Form::input('media_name', isset($filters['media_name']) ? $filters['media_name'] : '', array('placeholder' => '媒体名/版名', 'class' => 'form-control w100'));?>
				</div>
			</div>
            <?php if($login_info['division_type'] == 1){?>
            <div class="row">
                <div class="col-md-2">
                    <label class="control-label">非表示フラグ</label>
                </div>
                <div class="col-md-4">
                    <label class="checkbox-inline"><input name="is_hidden" id="is_hidden_1" value="1" <?php if(\Fuel\Core\Input::get('is_hidden') == '1') echo 'checked="checked"' ?> type="checkbox">ON</label>
                    <label class="checkbox-inline"><input name="is_hidden" id="is_hidden_0" value="0" <?php if(\Fuel\Core\Input::get('is_hidden') == '0') echo 'checked="checked"' ?> type="checkbox">OFF</label>
                </div>
            </div>
            <?php }?>

			<div class="row text-center">
				<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
				<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
				<a class="btn btn-warning btn-sm" href="<?php echo  \Uri::base().'master/medias/index/'.(\Uri::segment(4) ? \Uri::segment(4):1).'?'.http_build_query(\Input::get()).'&export=true'?>"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</button></a>
			</div>
		</div>
	</div>

    <div class="row form-inline">
        <div class="col-md-4">
            <?php echo html_entity_decode($pagination);?>
        </div>
        <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
        <?php if (!empty($count_media)) {?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        <?php }?>
    </div>
	<?php
	if($count_media == 0)
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
        <span class="text-info">チェックした媒体を</span>
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
                <th class="text-center">ID</th>
				<th class="text-center">区分</th>
				<th class="text-center">分類</th>
				<th class="text-center">法人名</th>
				<th class="text-center">支店名</th>
				<th class="text-center">媒体名</th>
				<th class="text-center">版名</th>
				<th class="text-center">載枠数</th>
				<th class="text-center">管理</th>
			</tr>
			<?php
				foreach($medias as $media)
				{
				?>
				<tr class='<?php echo $media->is_hidden ? 'bg-gray' : '' ?>'>
                    <?php if ($login_info['division_type'] == 1) {?>
                    <td>
						<input name="all_id" value="<?php echo $media->m_media_id; ?>" type="checkbox">
					</td>
                    <?php }?>
                    <td><?php echo $media->m_media_id ?></td>
					<td>
						<?php
						if($media->type == 1)
						{
							echo '自力';
						}
						else
						{
							echo '他力';
						}
						?>
					</td>
					<td><?php echo $classification[$media->classification];?></td>
					<td><?php echo $media->name?></td>
					<td><?php echo $media->branch_name?></td>
					<td><?php echo $media->media_name?></td>
					<td><?php echo $media->media_version_name?></td>
					<td class="text-right"><?php echo Model_Mpost::count_by_media_id($media->m_media_id)?></td>
					<td>
						<div class="btn-group">
							<a class="btn dropdown-toggle btn-sm btn-success" data-toggle="dropdown" href="#">
								処理
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" name="add-pulldown">
								<input type="hidden" value="<?php echo $media->m_media_id;?>"/>
								<li><a href="<?php echo \Fuel\Core\Uri::base()?>master/media?id=<?php echo $media->m_media_id; ?>" name="add-btn" href="#"><i class="glyphicon glyphicon-pencil"></i> 編集</a></li>
								<li><a class="media_delete_btn" href="#"><i class="glyphicon glyphicon-trash"></i> 削除</a></li>
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
        <?php if (!empty($count_media)) {?>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        <?php }?>
    </div>
<?php echo Form::close(); ?>
<script>
	$(function(){
		$('input[name=media_name]').autocomplete({
			source : <?php
				$_array = [];
				foreach($media_autocomplete as $v)
				{
                    if (strlen($v['media_name'])) { $_array[] = $v['media_name']; }
				}
				echo json_encode(array_values(array_unique($_array)));
			?>
		});
	});
	$(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
		$("#form_search_media").submit();
	});

    $("#visible-btn").on('click',function(){
        setHiddenVisibale(0,'m_media','m_media_id','<?php echo Fuel\Core\Uri::base()?>');
    });
    $("#hidden-btn").on('click',function(){
        setHiddenVisibale(1,'m_media','m_media_id','<?php echo Fuel\Core\Uri::base()?>');
    });
</script>

