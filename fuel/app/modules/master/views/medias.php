<?php echo \Fuel\Core\Asset::js('validate/media.js')?>
<h3>
	媒体リスト
	<button id="media_create_btn" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button>
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
<?php echo Form::open(array('class' => 'form-inline', 'id' => 'form_search_media', 'method' => 'GET'));?>
<input type="hidden" name="m_media_id" id="m_media_id">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">取引先(発注先)</label>
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
					<?php echo Form::input('media_name', isset($filters['media_name']) ? $filters['media_name'] : '', array('placeholder' => '媒体名', 'maxlength' => 16, 'size' => 30, 'class' => 'form-control'));?>
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
	if($count_media == 0)
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
				<th class="text-center">区分</th>
				<th class="text-center">分類</th>
				<th class="text-center">取引先(発注先)</th>
				<th class="text-center">媒体名</th>
				<th class="text-center">版名</th>
				<th class="text-center">載枠数</th>
				<th class="text-center">管理</th>
			</tr>
			<?php
				foreach($medias as $media)
				{
			?>
				<tr>
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
<?php echo Form::close(); ?>
<script>
	$(function(){
		$('input[name=media_name]').on('focus', function(){
			$(this).autocomplete('search', $(this).val());
		});
		$('input[name=media_name]').autocomplete({
			minLength : 0,
			source : [
				<?php
				foreach($media_autocomplete as $v)
				{
					echo "'".$v['media_name']."',";
				}
				?>
			]
		});
	});
	$("#limit").on('change',function(){
		$("#form_search_media").submit();
	});
</script>

