<?php echo \Fuel\Core\Asset::js('validate/support.js')?>
<div class="container">
	<h3>
		お問い合わせリスト
	</h3>
		<?php
			echo \Fuel\Core\Form::open(array('method' => 'get', 'id' => 'list-contact', 'class' => 'form-inline', 'action' => \Fuel\Core\Uri::base().'support/contacts'));
		?>
	<input type="hidden" name="status" id="form-status" value="">
	<input type="hidden" name="contact_id" id="form-contact_id" value="">
	<input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit') ? Fuel\Core\Input::get('limit') : ''?>">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-2">
							<label class="control-label">登録日</label>
						</div>
						<div class="col-md-4">
							<?php
								echo \Fuel\Core\Form::input('start_date',\Fuel\Core\Input::get('start_date'),array('class' => 'form-control dateform', 'size' => '10'));
							?>
							～
							<?php
								echo \Fuel\Core\Form::input('end_date',\Fuel\Core\Input::get('end_date'),array('class' => 'form-control dateform', 'size' => '10'));
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label class="control-label">キーワード</label>
						</div>
						<div class="col-md-10">
							<?php
								echo \Fuel\Core\Form::input('keyword',\Fuel\Core\Input::get('keyword'),array('class' => 'form-control', 'size' => '100', 'placeHolder' => '電話番号　氏名(全角)　氏名(ふりがな)　メールアドレス'));
							?>
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
		if( ! empty($contacts))
		{
			?>

			<table class="table table-bordered table-striped">
				<tr>
					<th class="text-center">登録日時</th>
					<th class="text-center">氏名</th>
					<th class="text-center">電話番号</th>
					<th class="text-center">メールアドレス</th>
					<th class="text-center">状態</th>
					<th class="text-center">管理</th>
				</tr>
				<?php
				foreach ($contacts as $contact)
				{
					?>
					<tr>
						<td><?php echo $contact['created_at']; ?></td>
						<td><?php echo $contact['name']; ?></td>
						<td><?php echo $contact['mobile']; ?></td>
						<td><?php echo $contact['mail']; ?></td>
						<td>
							<?php
							if($contact['status'] == 1)
							{
								?>
								<span class="label label-default">対応済</span>
								<?php
								echo isset($contact['update_at']) ? substr($contact['update_at'],0,16).' - ' : '';
								if(isset($contact['user_id']) && $muser = Model_Muser::find_by_pk($contact['user_id']))
								{
									echo $muser->name;
								}
								?>
							<?php
							}
							else
							{
								?>
								<span class="label label-danger">未対応</span>
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
									<li>
										<a href="<?php echo \Fuel\Core\Uri::base(); ?>support/contact/index/<?php echo $contact['contact_id']; ?>"
										   name="detail-btn"><i class="glyphicon glyphicon-tag"></i> 詳細</a></li>
									<?php
									if($contact['status'] == 0)
									{
										?>
										<li class="contact-change-0" value="<?php echo $contact['contact_id']; ?>"><a><i class="glyphicon glyphicon-ok"></i> 対応済にする</a></li>
									<?php
									}
									else
									{
										?>
										<li class="contact-change-1" value="<?php echo $contact['contact_id']; ?>"><a><i class="glyphicon glyphicon-remove"></i> 未対応に戻す</a></li>
									<?php
									}
									?>
								</ul>
							</div>
						</td>
					</tr>
				<?php
				}
				?>
			</table>
		<?php
		}
	else
	{
		?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			該当するデータがありません
		</div>
	<?php
	}
	?>


</div>
<script>
	$("#limit").on('change',function(){
		var val = $("#limit option:selected").val();
		$("input[name='limit']").val(val);
		$("#list-contact").submit();
	});
</script>