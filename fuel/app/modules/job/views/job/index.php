<?php
function show_edit_add_rec($row){
?>
<div class="edit-before">
	<div class="input-group">
		<div style="width: 100px" class="input-group-addon">見出し</div>
		<input type="text" disabled="" value="<?php echo $row['sub_title'] ?>" size="83" class="form-control">
	</div>
	<p></p>
	<div class="input-group">
		<div style="width: 100px" class="input-group-addon">本文</div>
		<textarea disabled="" rows="3" cols="80" class="form-control"><?php echo $row['text'] ?></textarea>
	</div>
</div>
<?php } ?>
<style>
	.edit-before-1{
		display: block;
		margin-right: 10px;
		margin-bottom: 10px;
		height: 40px;
		padding: 10px;
	}
	<?php
	if (\Fuel\Core\Input::get('job_id')) {
		if (count($is_show_old) == 0) {
			echo '.edit-before{display:none}';
		}
	}
	?>
</style>
	<?php echo Asset::js('module/image.js'); ?>
<?php echo Asset::js('validate/order-ss.js'); ?>
<?php echo Asset::css('job.css'); ?>
<h3>求人</h3>
<div class="text-right" style="padding-bottom: 5px;">
	<a class="btn btn-warning btn-sm" href="<?php echo Session::get('url_job_redirect') ? Session::get('url_job_redirect') : \Fuel\Core\Uri::base() . 'job/jobs'; ?>">
		<i class="glyphicon glyphicon-arrow-left icon-white"></i>
		戻る
	</a>
</button>
</div>
<?php
if (\Fuel\Core\Session::get_flash('report')) {
	?>
	<div role="alert" class="alert alert-danger alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
	<?php echo \Fuel\Core\Session::get_flash('report') ?>
	</div>
	<?php } ?>
<?php
$disabled = '';
if (Fuel\Core\Input::get('copy_job_id') || !Fuel\Core\Input::get('job_id')) {
	$disabled = 'display:none';
}
if (!$status && Fuel\Core\Input::get('job_id')) {
	?>
	<div class="edit-before bottom-space">
		※この枠内は変更前の内容を記載しています
	</div>
<?php }
?>
<style>
	.edit-before
	{

<?php echo $disabled ?>
	}
	.check_box{
		padding: 5px;
	}
</style>
<form class="form-inline" id="job_form" method="post" enctype="multipart/form-data">

	<table class="table table-striped">
		<tbody>
			<tr>
				<th class="text-right" width="20%">自社WEB掲載期間</th>
				<td width="80%">
					<input type="text" class="form-control dateform" name="start_date" size="12" value="<?php if ((int) str_replace('-', '', $start_date)) echo $start_date;
else echo ''; ?>">
<?php if (isset($is_show_old['start_date'])) { ?><span class="edit-before"><?php echo $old_data['start_date'] ?></span><?php } ?>
					～ <input type="text" class="form-control dateform" name="end_date" size="12" value="<?php if ((int) str_replace('-', '', $end_date)) echo $end_date;
else echo ''; ?>">
					<?php if (isset($is_show_old['end_date'])) { ?><span class="edit-before"><?php echo $old_data['end_date'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">自社掲載WEBサイト</th>
				<td>
					<label class="checkbox-inline">
<?php
echo Form::checkbox('public_type_1', 1, $public_type & 1 ? true : false, array('class' => 'job_public_type'));

if (Fuel\Core\Input::get('copy_job_id') || \Fuel\Core\Input::get('job_id', 0) == 0) {
	echo 'UOS';
} else {

	if ($old_data['public_type'] == 0 && $public_type == 0)
	{
		echo 'UOS';
	} elseif ($old_data['public_type'] == 1 || $old_data['public_type'] == 9)
	{
		if ($public_type == 1 || $public_type == 9)
			echo 'UOS';
		else
			echo '<span class="edit-before check_box">UOS</span>';
	}
	else { // 8

		if ($public_type == 8 || $public_type == 0)
			echo 'UOS';
		else
			echo '<span class="edit-before check_box">UOS</span>';
	}
}
?>
					</label>
					<label class="checkbox-inline">
						<?php
						echo Form::checkbox('public_type_2', 8, $public_type & 8 ? true : false, array('class' => 'job_public_type'));

						if (Fuel\Core\Input::get('copy_job_id') || \Fuel\Core\Input::get('job_id', 0) == 0) {
							echo '宇佐美';
						} else {
							if ($old_data['public_type'] == 0 && $public_type == 0) {
								echo '宇佐美';
							} elseif ($old_data['public_type'] == 8 || $old_data['public_type'] == 9) {
								if ($public_type == 8 || $public_type == 9)
									echo '宇佐美';
								else
									echo '<span class="edit-before check_box">宇佐美</span>';
							}
							else { // 1
								if ($public_type == 1 || $public_type == 0)
									echo '宇佐美';
								else
									echo '<span class="edit-before check_box">宇佐美</span>';
							}
						}
						?>
					</label>
				</td>
			</tr>
			<tr>
				<th class="text-right">急募&PICK UP</th>
				<td>
					<label class="checkbox-inline">
						<input type="checkbox" id="form_is_conscription" value="1" <?php if($is_conscription == '1') echo 'checked="checked"' ?> name="is_conscription">
						<?php if((int)$is_conscription == (int)$old_data['is_conscription'])
								echo '急募';
							else
								echo '<span class="edit-before check_box">急募</span>';
						?>

					</label>
					<label class="checkbox-inline">
						<input type="checkbox" id="form_is_pickup" value="1" <?php   if($is_pickup == '1') echo 'checked="checked"' ?> name="is_pickup">
						<?php if((int)$is_pickup == (int)$old_data['is_pickup'])
								echo 'PICK UP';
							else
								echo '<span class="edit-before check_box">PICK UP</span>';
						?>

					</label>
				</td>
			</tr>
			<tr>
				<th class="text-right">対象SS<div class="text-info">※必須</div></th>
				<td>
						<?php echo $filtergroup ?>

				</td>
			</tr>
			<tr id="show-work" style="display:none">
				<th class="text-right">売上形態</th>
				<td>
					<div id="agreement">

					</div>
					<p></p>
					<div class="panel panel-info" style="min-height:140px">
						<div class="panel-body" style="display:none;">
						</div>
					</div>

				</td>
			</tr>
			<tr class="hide">
				<th class="text-right">
					掲載媒体
					<button type="button" class="btn btn-success btn-sm" name="add-media-btn">
						<i class="glyphicon glyphicon-plus icon-white"></i>
					</button>
				</th>
				<td id="medias">
					<div class="media-append">
<?php
$media = '';
$media_list_str = trim($media_list, ',');
$media_add = \Presenter::forge('group/media')->set('media_id', 0);
if($media_list_str)
{
	$media_list = explode(',', $media_list_str);
	foreach ($media_list as $media_id)
	{
		$media .= \Presenter::forge('group/media')->set('media_id', $media_id);
	}
}
else
{
	$media_list = array();
}

if ($media == '')
{
	echo $media_add; // Show creat
}
else
{
	echo $media; // Show new add
}
?>

					</div>
						<?php if (\Fuel\Core\Input::get('job_id')) { ?>

							<script>
	                            $(function () {
	                                $('.edit-before select').prop('disabled', true);
	                                $(".edit-before [name=remove-media-btn]").prop('disabled', true);
	                            });
							</script>
							<?php
							$media_list_old = trim($old_data['media_list'], ',');
							if($media_list_old)
							{
								$media_list_old = explode(',', $media_list_old);
								foreach($media_list_old as $media_id)
								{
									if( ! in_array($media_id, $media_list))
									{
										echo '<div class="edit-before">';
											echo \Presenter::forge('group/media')->set('media_id',$media_id);
										echo '</div>';
									}
								}
							}
							else
							{
								if(count($media_list)) // have new no have old
								{
									echo '<div class="edit-before">';
										echo \Presenter::forge('group/media')->set('media_id',0);
									echo '</div>';
								}
							}
							?>
<?php } ?>
				</td></tr>

			<tr>
				<th class="text-right">
					画像
					<button type="button" class="btn btn-info btn-sm image_add_btn" name="image_add_btn">
						<i class="glyphicon glyphicon-plus icon-white"></i> 追加
					</button>
					<input type="file" name="image" class="image hide">
				</th>
				<td>
					<div id="image_append">
						<?php
						$_arr_check = array();
						if (count($m_image)) {
							foreach ($m_image as $row) {
								$_arr_check[] = $row['m_image_id'].'.'.$row['alt'];
								?>
								<div class="image-box pull-left image_panel">
									<a target="_blank"><img width="200" height="200" src="data:<?php echo $row['mine_type'] ?>;base64,<?php echo $row['content'] ?>"></a>
									<button class="btn btn-danger btn-sm remove-btn delete_image" type="button"><i class="glyphicon glyphicon-remove"></i></button>
									<p class="image-caption"><input type="text" name="alt[]" value="<?php echo $row['alt'] ?>" size="30" class="form-control" maxlength="30"></p>
									<input type="hidden" name="content[]" value="<?php echo $row['content'] ?>">
									<input type="hidden" name="width[]" value="<?php echo $row['width'] ?>">
									<input type="hidden" name="height[]" value="<?php echo $row['height'] ?>">
									<input type="hidden" name="mine_type[]" value="<?php echo $row['mine_type'] ?>">
									<input type="hidden" name="m_image_id[]" value="<?php echo $row['m_image_id'] ?>">
								</div>
		<?php
	}
}
?>		</div>
					<div style="clear:both"></div>
					<?php  if(isset($is_show_old['image_list'])){?>
		<div class="clearfix edit-before">
<?php
if (count($old_data['m_image'])) {
	foreach ($old_data['m_image'] as $row) {
		if( ! in_array($row['m_image_id'].'.'.$row['alt'],$_arr_check))
		{

		?>
								<div class="image-box pull-left image_panel">
									<a target="_blank"><img width="200" height="200" src="data:<?php echo $row['mine_type'] ?>;base64,<?php echo $row['content'] ?>"></a>
									<p class="image-caption">
										<input type="text" disabled="" value="<?php echo $row['alt'] ?>" size="30" class="form-control">
									</p>
								</div>

		<?php
		}}
}else{
	?>
		<?php if (count($m_image)) {?>
		<div class="image-box pull-left image_panel">
			<a target="_blank"></a>
			<p class="image-caption"></p>
		</div>
		<?php }?>
<?php
}
?>
	</div>
	<?php }?>
			</td>
			</tr>
			<tr>
				<th class="text-right">掲載社名</th>
				<td>
					<?php echo Form::input('post_company_name', $post_company_name, array('class' => 'form-control', 'size' => '80', 'type' => 'text')); ?>
					<span class="text-info">※必須</span>
					<?php if (isset($is_show_old['post_company_name'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['post_company_name'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">ホームページURL</th>
				<td>
<?php echo Form::input('url_home_page', $url_home_page, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '50')); ?>
<?php if (isset($is_show_old['url_home_page'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['url_home_page'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">Youtube URL</th>
				<td>
<?php echo Form::input('url_youtube', $url_youtube, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '255')); ?>
<?php if (isset($is_show_old['url_youtube'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['url_youtube'] ?></span><?php } ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">住所表示</th>
				<td>
					<label class="radio-inline"><?php echo Form::radio('addr_is_view',0, (\Fuel\Core\Input::get('job_id',0) || (\Fuel\Core\Input::get('copy_job_id',0)) && $addr_is_view == 0) ? true : false); ?>全表示</label>
					<label class="radio-inline"><?php echo Form::radio('addr_is_view',1, ($addr_is_view == 1) ? true : false); ?>市区町村まで</label>
					<span class="text-info">※いずれか必須</span>
					<?php if ($old_data['addr_is_view'] == 0 && $addr_is_view != 0) { ?>
					<div class="edit-before">全表示</div>
					<?php } elseif ($old_data['addr_is_view'] == 1 && $addr_is_view != 1) { ?>
					<div class="edit-before">市区町村まで</div>
					<?php } ?>
				</td>
			</tr>

			<tr class="hide">
				<th class="text-right">郵便番号</th>
				<td>
						<?php echo Fuel\Core\Form::input('zipcode_first', isset($zipcode) ? substr($zipcode, 0, 3) : '', array('class' => 'form-control', 'size' => 3, 'maxlength' => 3)); ?>
						<?php if(substr($old_data['zipcode'], 0, 3) != substr($zipcode, 0, 3)){ ?><span class="edit-before"><?php echo substr($old_data['zipcode'], 0, 3) ?></span><?php } ?>
					-
						<?php echo Fuel\Core\Form::input('zipcode_last', isset($zipcode) ? substr($zipcode, 3, 4) : '', array('class' => 'form-control', 'size' => 4, 'maxlength' => 4)); ?>
						<?php if(substr($old_data['zipcode'], 3, 4) != substr($zipcode, 3, 4)){ ?><span class="edit-before"><?php echo substr($old_data['zipcode'], 3, 4) ?></span><?php } ?>
				</td>
			</tr>
			<tr class="hide">
				<th class="text-right">掲載住所</th>
				<td>
					<?php echo Form::input('location', $location, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '32')); ?>
					<?php if (isset($is_show_old['location'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['location'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">交通</th>
				<td>
					<?php echo Form::input('traffic', $traffic, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '50')); ?>
					<?php if (isset($is_show_old['traffic'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['traffic'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">表示店舗名称</th>
				<td>
					<?php echo Form::input('store_name', $store_name, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '50')); ?>
					<?php if (isset($is_show_old['store_name'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['store_name'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">Web得 項目<br>勤務地表示方式</th>
				<td>
					<label class="radio-inline"><?php echo Form::radio('work_location_display_type', 1, ($work_location_display_type == 1) ? true : false); ?>カセット式</label>
					<label class="radio-inline"><?php echo Form::radio('work_location_display_type', 2, ($work_location_display_type == 2) ? true : false); ?>テキスト</label>
					<span class="text-info">※いずれか必須</span>
					<?php if ($old_data['work_location_display_type'] == 1 && $work_location_display_type != 1) { ?>
						<div class="edit-before">カセット式</div>
					<?php
					} elseif ($old_data['work_location_display_type'] == 2 && $work_location_display_type != 2) {
						?>
						<div class="edit-before">テキスト</div>
					<?php }?>
				</td>
			</tr>
			<tr>
				<th class="text-right">Web得 項目<br>勤務地(派遣・契約の場合)</th>
				<td>
					<?php echo Form::input('work_location', $work_location, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'maxlength' => '20')); ?>
					<span class="text-info">※必須</span>
<?php if (isset($is_show_old['work_location'])) { ?><span class="edit-before"><?php echo $old_data['work_location'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">Web得 項目<br>勤務地カセット式タイトル</th>
				<td>
					<?php echo Form::input('work_location_title', $work_location_title, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '10')); ?>
					<?php if (isset($is_show_old['work_location_title'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['work_location_title'] ?></span><?php } ?>
				</td>
			</tr>
			<tr class="hide">
				<th class="text-right">(勤)地図補足</th>
				<td>
					<?php echo Form::input('work_location_map', $work_location_map, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '100')); ?>
					<?php if (isset($is_show_old['work_location_map'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['work_location_map'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">雇用形態</th>
				<td>
<?php echo Form::select('employment_type', $employment_type, Constants::$employment_type, array('class' => 'form-control')); ?>
<?php if (isset($is_show_old['employment_type'])) { ?><span class="edit-before"><?php echo isset(Constants::$employment_type[$old_data['employment_type']]) ? Constants::$employment_type[$old_data['employment_type']] : ""; ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">雇用形態マーク</th>
				<td>
<?php foreach (Constants::$employment_mark as $key => $val) { ?>
						<label class="checkbox-inline">
	<?php echo Form::checkbox('employment_mark[]', $key, substr_count($employment_mark, ',' . $key . ',') ? true : false); ?>
	<?php
	if (Fuel\Core\Input::get('copy_job_id') && \Fuel\Core\Input::get('job_id', 0) == 0) {
		echo '[' . $val . ']';
	} else {
		if (isset($is_show_old['employment_mark'])) {
			if (substr_count($old_data['employment_mark'], ',' . $key . ',') && substr_count($employment_mark, ',' . $key . ',')) {
				echo '[' . $val . ']';
			} else {
				if (substr_count($employment_mark, ',' . $key . ',') || substr_count($old_data['employment_mark'], ',' . $key . ','))
					echo '<span class="edit-before check_box">[' . $val . ']</span>';
				else
					echo '[' . $val . ']';
			}
		} else
			echo '[' . $val . ']';
	}
	?>

						</label>
<?php } ?>


				</td>
			</tr>
			<tr>
				<th class="text-right">職種</th>
				<td>
						<?php echo Form::input('job_category', $job_category, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '64')); ?>
						<?php if (isset($is_show_old['job_category'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['job_category'] ?></span><?php } ?>
				</td>
			</tr>

			<tr>
				<th class="text-right">職業</th>
				<td>
						<?php echo Fuel\Core\Form::select('occupation', $occupation, Constants::$occupation, array('class' => 'form-control')); ?>
						<?php if (isset($is_show_old['occupation'])) { ?><span class="edit-before"><?php echo isset(Constants::$occupation[$old_data['occupation']]) ? Constants::$occupation[$old_data['occupation']] : "" ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">給与形態</th>
				<td>
						<?php echo Form::select('salary_type', $salary_type, Constants::$salary_type, array('class' => 'form-control')); ?>
						<?php if (isset($is_show_old['salary_type'])) { ?><span class="edit-before"><?php echo isset(Constants::$salary_type[$old_data['salary_type']]) ? Constants::$salary_type[$old_data['salary_type']] : "" ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">給与</th>
				<td>
					<?php echo Form::input('salary_des', $salary_des, array('class' => 'form-control', 'size' => '80', 'type' => 'text','maxlength'=>72)); ?>
					<span class="text-info">※必須</span>
					<?php if (isset($is_show_old['salary_des'])) { ?><div class="edit-before"><?php echo $old_data['salary_des'] ?></div><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">最低給与金額</th>
				<td>
					<div class="input-group">
						<?php echo Form::input('salary_min', $salary_min, array('class' => 'form-control', 'size' => '10', 'type' => 'text')); ?>
						<div class="input-group-addon">円</div>
					</div>
					<?php if (isset($is_show_old['salary_min'])) { ?><span class="edit-before"><?php echo $old_data['salary_min'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">キャッチコピー</th>
				<td>
					<textarea class="form-control" cols="80" rows="5" name="catch_copy" length="45"><?php echo $catch_copy ?></textarea>
					<?php if (isset($is_show_old['catch_copy'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['catch_copy'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">リード</th>
				<td>
					<textarea class="form-control" cols="80" rows="5" name="lead" length="60"><?php echo $lead ?></textarea>
<?php if (isset($is_show_old['lead'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['lead'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">表示勤務時間帯</th>
				<td>

<?php
foreach (Constants::$work_time_view as $key => $val) {
	?>
						<label class="checkbox-inline"><?php echo Form::checkbox('work_time_view[]', $key, substr_count($work_time_view, ',' . $key . ',') ? true : false); ?>
	<?php
	if (Fuel\Core\Input::get('copy_job_id') && \Fuel\Core\Input::get('job_id', 0) == 0) {
		echo $val;
	} else {
		if (isset($is_show_old['work_time_view'])) {
			if (substr_count($old_data['work_time_view'], ',' . $key . ',') && substr_count($work_time_view, ',' . $key . ',')) {
				echo $val;
			} else {
				if (substr_count($work_time_view, ',' . $key . ',') || substr_count($old_data['work_time_view'], ',' . $key . ','))
					echo '<span class="edit-before check_box">' . $val . '</span>';
				else
					echo $val;
			}
		} else
			echo $val;
	}
	?>
						</label>
	<?php
}
?>
				</td>
			</tr>
			<tr>
				<th class="text-right">週当たり最低勤務日数</th>
				<td>
					<div class="input-group">
<?php echo Form::input('work_day_week', $work_day_week, array('class' => 'form-control', 'size' => '5', 'type' => 'text')); ?>
						<div class="input-group-addon">日</div>
					</div>
					<?php if (isset($is_show_old['work_day_week'])) { ?><span class="edit-before"><?php echo $old_data['work_day_week'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">勤務曜日・時間について</th>
				<td>
						<?php echo Form::input('work_time_des', $work_time_des, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '200')); ?>
						<?php if (isset($is_show_old['work_time_des'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['work_time_des'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">資格</th>
				<td>
						<?php echo Form::input('qualification', $qualification, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '100')); ?>
						<?php if (isset($is_show_old['qualification'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['qualification'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">採用予定人数</th>
				<td>
						<?php echo Form::select('employment_people', $employment_people, Constants::$employment_people, array('class' => 'form-control')); ?>
						<?php if (isset($is_show_old['employment_people'])) { ?><span class="edit-before"><?php echo isset(Constants::$employment_people[$old_data['employment_people']]) ? Constants::$employment_people[$old_data['employment_people']] : "" ?></span><?php } ?>
					<span class="text-info">人数入力の場合：</span>
					<div class="input-group">
						<?php echo Form::input('employment_people_num', $employment_people_num, array('class' => 'form-control', 'size' => '5', 'type' => 'text')); ?>
						<div class="input-group-addon">人</div>

					</div>
						<?php if (isset($is_show_old['employment_people_num'])) { ?><span class="edit-before"><?php echo (int)$old_data['employment_people_num'] . '人' ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">採用予定人数キャプション</th>
				<td>
					<?php echo Form::input('employment_people_des', $employment_people_des, array('class' => 'form-control', 'size' => '80', 'type' => 'text')); ?>
					<?php if (isset($is_show_old['employment_people_des'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['employment_people_des'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">勤務期間</th>
				<td>
						<?php echo Form::select('work_period', $work_period, Constants::$work_period, array('class' => 'form-control')); ?>
						<?php if (isset($is_show_old['work_period'])) { ?><span class="edit-before"><?php echo isset(Constants::$work_period[$old_data['work_period']]) ? Constants::$work_period[$old_data['work_period']] : "" ?></span><?php } ?>
				</td>
			</tr>
			<tr class="hide">
				<th class="text-right">紹介予定派遣の場合</th>
				<td>

<?php echo Form::input('dispatch_placement_des', $dispatch_placement_des, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '100')); ?>
					<?php if (isset($is_show_old['dispatch_placement_des'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['dispatch_placement_des'] ?></span><?php } ?>
				</td>
			</tr>
			<tr>
				<th class="text-right">
					募集追加
					<button type="button" class="btn btn-success btn-sm recruit_add_btn" name="recruit_add_btn" id="recruit_add_btn">
						<i class="glyphicon glyphicon-plus icon-white"></i>
					</button>
		<div class="text-info">※9件まで</div>
		</th>
		<td id="recruit">
<?php
$job_recruit_st = array();
if(count($job_recruit))
{
	foreach($job_recruit as $rec)
	{
		if(trim($rec['text']) != '' || trim($rec['sub_title']) != '')
			$job_recruit_st[] = $rec;
	}
}

if (\Fuel\Core\Input::get('job_id',0) == 0 || count($job_recruit_st) == 0)
{
	$job_recruit_st[] = array('sub_title' => '', 'text' => '');
}

$i = 0;
$job_recruit_check = array();
foreach ($job_recruit_st as $rec) {
	$job_recruit_check[] = $rec['sub_title'].'.'.$rec['text'];
	?>
				<div class="panel panel-default recruit">
					<input type="hidden" class="post_index_recruit" value="<?php echo $i ?>">
					<div class="panel-heading text-right">
						<button type="button" class="btn btn-default btn-sm recruit_remove_btn " name="recruit_remove_btn">
							<i class="glyphicon glyphicon-remove icon-white"></i>
						</button>
					</div>
					<div class="panel-body">
						<div class="job_error">
							<div class="input-group">
								<div class="input-group-addon" style="width: 100px">見出し</div>
								<input type="text" class="form-control job_recruit_sub_title" size="83" name="job_recruit_sub_title[<?php echo $i ?>]" value="<?php echo $rec['sub_title'] ?>" length="7">
							</div>
						</div>
						<p></p>
						<div class="input-group">
							<div class="input-group-addon" style="width: 100px">本文</div>
							<textarea class="form-control" cols="80" rows="3" name="job_recruit_text[<?php echo $i ?>]"><?php echo $rec['text'] ?></textarea>
						</div>
					</div>
				</div>
						<?php
						++$i;
					}
					?>
			<div id="job_recruit"></div>
<?php
if(isset($is_show_old['job_recruit_sub_title']))
{
	if( ! count($old_data['job_recruit'])) $old_data['job_recruit'][] = array('sub_title' => '', 'text' => '');
	foreach ($old_data['job_recruit'] as $rec)
	{
		if( ! in_array($rec['sub_title'].'.'.$rec['text'], $job_recruit_check))
		{
			show_edit_add_rec($rec);
		}
	}
}
?>
		</td>
		</tr>
		<tr>
			<th class="text-right">仕事内容</th>
			<td>
				<textarea class="form-control" cols="80" rows="5" name="job_description" length="40"><?php echo $job_description ?></textarea>
<?php if (isset($is_show_old['job_description'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['job_description'] ?></span><?php } ?>
			</td>
		</tr>
		<tr>
			<th class="text-right">
				仕事追加
				<button type="button" class="btn btn-success btn-sm work_add_btn" name="work_add_btn" id="work_add_btn">
					<i class="glyphicon glyphicon-plus icon-white"></i>
				</button>
		<div class="text-info">※4件まで</div>
		</th>
		<td id="work">

			<?php

			$job_add_st = array();
			if(count($job_add))
			{
				foreach($job_add as $add)
				{
					if(trim($add['text']) != '' || trim($add['sub_title']) != '')
						$job_add_st[] = $add;
				}
			}

			if (\Fuel\Core\Input::get('job_id',0) == 0 || count($job_add_st) == 0)
			{
				$job_add_st[]= array('sub_title' => '', 'text' => '');
			};
			$arr_job_check = array();
			$i = 0;
			foreach ($job_add_st as $add) {
				$arr_job_check[] = $add['sub_title'].'.'.$add['text'];
				?>
				<div class="panel panel-default work">
					<input type="hidden" class="post_index_add" value="<?php echo $i ?>">
					<div class="panel-heading text-right">
						<button type="button" class="btn btn-default btn-sm work_remove_btn" name="work_remove_btn">
							<i class="glyphicon glyphicon-remove icon-white"></i>
						</button>
					</div>
					<div class="panel-body">
						<div class="job_error">
							<div class="input-group">
								<div class="input-group-addon" style="width: 100px">見出し</div>
								<input type="text" class="form-control job_add_sub_title"  size="83" name="job_add_sub_title[<?php echo $i ?>]" value="<?php echo $add['sub_title'] ?>" length="12">
							</div>
						</div>
						<p></p>
						<div class="input-group">
							<div class="input-group-addon" style="width: 100px">本文</div>
							<textarea class="form-control" cols="80" rows="3" name="job_add_text[<?php echo $i ?>]"><?php echo $add['text'] ?></textarea>
						</div>
					</div>
				</div>
	<?php ++$i;
} ?>
<div id="job_add"></div>
<?php
if(isset($is_show_old['job_add_sub_title'])){
	if( ! count($old_data['job_add'])) $old_data['job_add'][] = array('sub_title' => '' ,'text' => '');
	foreach ($old_data['job_add'] as $add)
	{
		$job_add_old_check[] = $add['sub_title'].'.'.$add['text'];
		if( ! in_array($add['sub_title'].'.'.$add['text'], $arr_job_check))
		{
			show_edit_add_rec($add);
		}
	}

}
?>
		</td>
		</tr>
		<tr>
			<th class="text-right">事業内容</th>
			<td>
				<textarea class="form-control" cols="80" rows="5" name="business_description" length="40"><?php echo $business_description ?></textarea>
<?php if (isset($is_show_old['business_description'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['business_description'] ?></span><?php } ?>
			</td>
		</tr>
		<tr>
			<th class="text-right">面接地・他タイトル</th>
			<td>
<?php echo Form::input('interview_des', $interview_des, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '60', 'readonly' => 'readonly')); ?>
<?php if (isset($is_show_old['interview_des'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['interview_des'] ?></span><?php } ?>
			</td>
		</tr>
		<tr>
			<th class="text-right">面接地</th>
			<td>
			<?php echo Form::input('interview_location', $interview_location, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '60')); ?>
			<?php if (isset($is_show_old['interview_location'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['interview_location'] ?></span><?php } ?>
			</td>
		</tr>
		<tr>
			<th class="text-right">応募方法</th>
			<td>
<?php echo Form::input('apply_method', $apply_method, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'maxlength' => '100', 'readonly' => 'readonly')); ?>
<?php if (isset($is_show_old['apply_method'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['apply_method'] ?></span><?php } ?>
			</td>
		</tr>
		<tr>
			<th class="text-right">応募方法のプロセス</th>
			<td>
<?php echo Form::input('apply_process', $apply_process, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'maxlength' => '100', 'readonly' => 'readonly')); ?>
			<?php if (isset($is_show_old['apply_process'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['apply_process'] ?></span><?php } ?>
			</td>
		</tr>
		<tr class="hide">
			<th class="text-right">携帯電話応募ボタン</th>
			<td>
				<label class="radio-inline"><?php echo Form::radio('is_apply_by_mobile', 1, ($is_apply_by_mobile == 1) ? true : false); ?>利用する</label>
				<label class="radio-inline"><?php echo Form::radio('is_apply_by_mobile', 2, ($is_apply_by_mobile == 2) ? true : false); ?>利用しない</label>
<?php if ($old_data['is_apply_by_mobile'] == 1 && $is_apply_by_mobile !=1) { ?>
					<div class="edit-before">利用する</div>
<?php } elseif ($old_data['is_apply_by_mobile'] == 2 && $is_apply_by_mobile !=2) { ?>
					<div class="edit-before">利用しない</div>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th class="text-right">代表電話(1)</th>
			<td>
				<?php
				if($phone_number1 == '') $phone_number1 =',,';
				$_arr_phone1 = explode(',', $phone_number1);

				if ($old_data['phone_number1'] == '')
					$old_data['phone_number1'] = ',,';

				if($old_data['phone_number1'] == '') $old_data['phone_number1'] = ',,';
				$_arr_phone1_old = explode(',', $old_data['phone_number1']);

				if($phone_number2 == '') $phone_number2 =',,';
				$_arr_phone2 = explode(',', $phone_number2);
				if ($old_data['phone_number2'] == '')
					$old_data['phone_number2'] = ',,';
				$_arr_phone2_old = explode(',', $old_data['phone_number2']);
				?>
<?php echo Form::input('phone_name1', $phone_name1, array('class' => 'form-control', 'size' => '20', 'type' => 'text', 'placeholder' => '名称', 'length' => '20')); ?>
				<?php if (isset($is_show_old['phone_name1'])) { ?><span class="edit-before"><?php echo $old_data['phone_name1'] ?></span><?php } ?>
				<?php echo Fuel\Core\Form::input('phone_number1_1', isset($_arr_phone1['0']) ? $_arr_phone1['0'] : '', array('class' => 'form-control', 'size' => 5, 'placeholder' => '例)03', 'maxlength' => '4')); ?>
				<?php if($_arr_phone1_old['0'] !== $_arr_phone1['0']){?><span class="edit-before"><?php echo $_arr_phone1_old['0'] ?></span><?php } ?>
				-
<?php echo Fuel\Core\Form::input('phone_number1_2', isset($_arr_phone1['1']) ? $_arr_phone1['1'] : '', array('class' => 'form-control', 'size' => 4, 'placeholder' => '例)1234', 'maxlength' => '4')); ?>
				<?php if(isset($_arr_phone1_old['1']) && $_arr_phone1_old['1'] !== $_arr_phone1['1']){?><span class="edit-before"><?php echo $_arr_phone1_old['1'] ?></span><?php } ?>
				-
<?php echo Fuel\Core\Form::input('phone_number1_3', isset($_arr_phone1['2']) ? $_arr_phone1['2'] : '', array('class' => 'form-control', 'size' => 4, 'placeholder' => '例)1234', 'maxlength' => '4')); ?>
				<?php if(isset($_arr_phone1_old['2']) && $_arr_phone1_old['2'] !== $_arr_phone1['2']){?><span class="edit-before"><?php echo $_arr_phone1_old['2']; ?></span><?php } ?>
			</td>
		</tr>
		<tr class="hide">
			<th class="text-right">代表電話(2)</th>
			<td>
				<?php echo Form::input('phone_name2', $phone_name2, array('class' => 'form-control', 'size' => '20', 'type' => 'text', 'placeholder' => '名称', 'length' => '20')); ?>
				<?php if (isset($is_show_old['phone_name2'])) { ?><span class="edit-before"><?php echo $old_data['phone_name2'] ?></span><?php } ?>
				<?php echo Fuel\Core\Form::input('phone_number2_1', isset($_arr_phone2['0']) ? $_arr_phone2['0'] : '', array('class' => 'form-control', 'size' => 5, 'placeholder' => '例)03', 'maxlength' => '4')); ?>
				<?php if($_arr_phone2_old['0'] !== $_arr_phone2['0']){?><span class="edit-before"><?php echo $_arr_phone2_old['0'] ?></span><?php } ?>
				-
<?php echo Fuel\Core\Form::input('phone_number2_2', isset($_arr_phone2['1']) ? $_arr_phone2['1'] : '', array('class' => 'form-control', 'size' => 4, 'placeholder' => '例)1234', 'maxlength' => '4')); ?>
<?php if(isset($_arr_phone2_old['1']) && $_arr_phone2_old['1'] !== $_arr_phone2['1']){?><span class="edit-before"><?php echo $_arr_phone2_old['1'] ?></span><?php } ?>
				-
<?php echo Fuel\Core\Form::input('phone_number2_3', isset($_arr_phone2['2']) ? $_arr_phone2['2'] : '', array('class' => 'form-control', 'size' => 4, 'placeholder' => '例)1234', 'maxlength' => '4')); ?>
				<?php if(isset($_arr_phone2_old['2']) && $_arr_phone2_old['2'] !== $_arr_phone2['2']){?><span class="edit-before"><?php echo $_arr_phone2_old['2'] ?></span><?php } ?>
			</td>
		</tr>
		<tr class="hide">
			<th class="text-right">問い合わせ補足</th>
			<td>
				<?php echo Form::input('contact', $contact, array('class' => 'form-control', 'size' => '80', 'type' => 'text', 'length' => '60')); ?>
				<?php if (isset($is_show_old['contact'])) { ?><span class="edit-before edit-before-1"><?php echo $old_data['contact'] ?></span><?php } ?>
			</td>
		</tr>
		<tr class="hide">
			<th class="text-right">WEB応募受付</th>
			<td>
				<label class="radio-inline"><?php echo Form::radio('is_web_receipt', 1, ($is_web_receipt == 1) ? true : false); ?>利用する</label>
				<label class="radio-inline"><?php echo Form::radio('is_web_receipt', 2, ($is_web_receipt == 2) ? true : false); ?>利用しない</label>
				<span class="text-info">※いずれか必須</span>
					<?php if (isset($is_show_old['start_date'])) { ?><span class="text-info">※いずれか必須</span><?php } ?>
	<?php if ($old_data['is_web_receipt'] == 1 && $is_web_receipt !=1) { ?>
						<div class="edit-before">利用する</div>
					<?php
					} elseif ($old_data['is_web_receipt'] == 2 && $is_web_receipt !=2) {
						?>
						<div class="edit-before">利用しない</div>
	<?php }?>
				</td>
			</tr>
			<tr>
				<th class="text-right">
					こだわり選択
			<div class="text-info" >※*マークは10件まで</div>
			</th>
			<td>
				<div class="row trouble">
	<?php
	foreach (Constants::$trouble as $key => $val) {
		?>
						<div class="col-md-3" style="margin: 6px;">
							<label class="checkbox-inline" style="margin-top:-20px;"><?php echo Form::checkbox('trouble[]', $key, substr_count($trouble, ',' . $key . ',') ? true : false, array('class' => 'trouble')); ?>
						<?php
						if (Fuel\Core\Input::get('copy_job_id') && \Fuel\Core\Input::get('job_id', 0) == 0) {
							echo $val;
						} else {
							if (isset($is_show_old['trouble'])) {
								if (substr_count($old_data['trouble'], ',' . $key . ',') && substr_count($trouble, ',' . $key . ',')) {
									echo $val;
								} else {
									if (substr_count($trouble, ',' . $key . ',') || substr_count($old_data['trouble'], ',' . $key . ','))
										echo '<span class="edit-before check_box">' . $val . '</span>';
									else
										echo $val;
								}
							} else
								echo $val;
						}
						?>
							<?php if (in_array($key, Constants::$trouble4recruit)) { ?>
								<span class="text-info for-recruit">*</span>
							<?php } ?>
							</label>
						</div>
						<?php
					}
					?>
				</div>
			</td>
			</tr>
			</tbody></table>

		<div class="text-center">
			<button type="submit" class="btn btn-primary btn-sm">
				<i class="glyphicon glyphicon-pencil icon-white"></i>
				保存
			</button>
		</div>
	</form>

	<?php echo Asset::js('validate/job.js'); ?>
<script type="text/javascript">
	    $('.dateform').datepicker();
				<?php
				if (Fuel\Core\Input::get('view')) {
					?>
$("input").prop('disabled', true);
$("select").prop('disabled', true);
$("textarea ").prop('disabled', true);
$(".btn-primary").prop('disabled', true);
$(".btn-success").prop('disabled', true);
$(".work_remove_btn").prop('disabled', true);
$(".recruit_remove_btn ").prop('disabled', true);
$(".delete_image ").prop('disabled', true);
$("[name=remove-media-btn]").prop('disabled', true);<?php } ?>

$("#form_ss_id").change(function(){
		$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/get_m_ss_access/',
				{	'ss_id':$('#form_ss_id option:selected').val()
				},
				function(data){
					$("#form_traffic").val(data);
				}
				)
});

</script>