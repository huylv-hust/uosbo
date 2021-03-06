<h3>
	求人情報リスト
	<a href="<?php echo Fuel\Core\Uri::base()?>job/job"><button name="add-btn" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-plus icon-white"></i> 新規追加</button></a>
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
<form class="form-inline" method="get" action="" id="list-jobs">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">都道府県</label>
							</div>
							<div class="col-md-4">
								<?php echo Form::select('address_1',\Fuel\Core\Input::get('address_1'),  Constants::$address_1, array('class' => 'form-control','style'=>'width:132px'));?>
							</div>
							<div class="col-md-2">
								<label class="control-label">市区町村</label>
							</div>
							<div class="col-md-4">
								<?php
								//get list ss
								$model_ss = new \Model_Mss();
								$listss = $model_ss->get_list_all_ss();
								$addr_2 = array('' => '全て') + array_column($listss,'addr2','addr2');
								echo \Fuel\Core\Form::select('address_2',\Fuel\Core\Input::get('address_2'),$addr_2,array('class' => 'form-control','style'=>'width:132px'))
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">取引先担当部門</label>
							</div>
							<div class="col-md-4">
								<?php
								echo \Fuel\Core\Form::select('department_id',Fuel\Core\Input::get('department_id'), Constants::get_search_department(), array('class' => 'form-control'));
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">取引先(受注先)</label>
							</div>
							<div class="col-md-10">
								<select class="form-control" id="group_search" name="group_search">
									<option value="">全て</option>
									<?php foreach ($search_group as $group_id => $name) { ?>
									<option value="<?php echo $group_id ?>" <?php if(Fuel\Core\Input::get('group_search') == $group_id) echo 'selected="selected"'?>><?php echo htmlspecialchars($name) ?>
									<?php } ?>
								</select>
								-
								<select class="form-control" id="partner_search" name="partner_search">
									<option value="">全て</option>
									<?php

									foreach($search_partner as $row)
										{
									?>
									<option value="<?php echo $row['partner_code']?>" <?php if(Fuel\Core\Input::get('partner_search') == (string)$row['partner_code']) echo 'selected="selected"'?>><?php echo $row['branch_name']?></option>
									<?php }
									?>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<label class="control-label">SS</label>
							</div>
							<div class="col-md-4">
								<select class="form-control" id="ss_search" name="ss_search">
									<option value="">全て</option>
									<?php
									foreach($search_ss_list as $row)
									{
									?>
									<option value="<?php echo $row['ss_id']?>" <?php if(Fuel\Core\Input::get('ss_search') == $row['ss_id']) echo 'selected="selected"'?> ><?php echo $row['ss_name']?></option>
									<?php

									}
									?>
								</select>
							</div>
							<div class="col-md-2">
								<label class="control-label">売上形態</label>
							</div>
							<div class="col-md-4">
								<?php
								echo Form::select('sale_type', Fuel\Core\Input::get('sale_type'), Constants::get_search_sale_type(), array('class' => 'form-control'));
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<label class="control-label">掲載期間</label>
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control dateform" name="start_date" size="10" value="<?php echo $start_date?>">
								～
								<input type="text" class="form-control dateform" name="end_date" size="10" value="<?php echo $end_date?>">
							</div>
							<div class="col-md-2">
								<label class="control-label">自社掲載WEBサイト</label>
							</div>
							<div class="col-md-4">
								<label class="checkbox-inline"><input type="checkbox" value="1" name="public_type_1" <?php if(Fuel\Core\Input::get('public_type_1')=='1' || (Fuel\Core\Input::get('public_type_1')&& Fuel\Core\Input::get('public_type_1')) ) echo 'checked="checked"'?>>UOS</label>
								<label class="checkbox-inline"><input type="checkbox" value="8" name="public_type_2" <?php if(Fuel\Core\Input::get('public_type_2')=='8' || (Fuel\Core\Input::get('public_type_2')&& Fuel\Core\Input::get('public_type_2')) ) echo 'checked="checked"'?>>宇佐美</label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">媒体</label>
							</div>
							<div class="col-md-4">
								<select class="form-control" name="media_search" style="width: 132px">
									<option value="">全て</option>
									<?php
									foreach($search_media as $row)
									{
									?>
									<option value="<?php echo $row['m_media_id']?>" <?php if(Fuel\Core\Input::get('media_search') == $row['m_media_id']) echo 'selected="selected"'?> ><?php echo $row['media_name']?></option>

									<?php } ?>
								</select>
							</div>
							<div class="col-md-2">
								<label class="control-label">状態</label>
							</div>
							<div class="col-md-4">
								<label class="checkbox-inline"><input id="is_available_1" type="checkbox" value="1" name="is_available" <?php if(Fuel\Core\Input::get('is_available') == '1') echo 'checked="checked"'?>>公開</label>
								<label class="checkbox-inline"><input id="is_available_0" type="checkbox" value="0" name="is_available" <?php if(Fuel\Core\Input::get('is_available')== '0') echo 'checked="checked"'?>>非公開</label>
								<label class="checkbox-inline"><input type="checkbox" value="0" name="status" <?php if(Fuel\Core\Input::get('status') == '0') echo 'checked="checked"'?>>承認待ち</label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<label class="control-label">最終更新日</label>
							</div>
							<div class="col-md-4">
								<input name="updated_at_from" value="<?php echo \Fuel\Core\Input::get('updated_at_from')?>" type="text" size="12" class="form-control dateform">
								～
								<input name="updated_at_to" value="<?php echo \Fuel\Core\Input::get('updated_at_to')?>" type="text" size="12" class="form-control dateform">
							</div>
							<div class="col-md-2">
								<label class="control-label">WEB得</label>
							</div>
							<div class="col-md-4">
								<label class="checkbox-inline"><input id="is_webtoku_1" name="is_webtoku" value="1" type="checkbox" <?php if(Fuel\Core\Input::get('is_webtoku') == '1') echo 'checked="checked"'?>>ON</label>
								<label class="checkbox-inline"><input id="is_webtoku_0" name="is_webtoku" value="0" type="checkbox" <?php if(Fuel\Core\Input::get('is_webtoku') == '0') echo 'checked="checked"'?>>OFF</label>
							</div>
						</div>
						<div class="row text-center">
							<button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
							<button type="button" class="btn btn-info btn-sm" name="filter-clear-btn"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
							<a class="btn btn-warning btn-sm" href="<?php echo  \Uri::base().'job/jobs/index/'.(\Uri::segment(4) ? \Uri::segment(4):1).'?'.http_build_query(\Input::get()).'&export=true'?>"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</button></a>
						</div>
					</div>
				</div>
				<?php if( ! count($res['res']))
					{ ?>
				<div role="alert" class="alert alert-danger alert-dismissible">
				<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
					該当するデータがありません
				</div>
				<?php } ?>
				<?php
				if(count($res['res'])){
				?>
				<div class="row">
					<div class="col-md-4">
						<?php echo Pagination::instance('jobpage'); ?>
					</div>
					<div style="margin: 20px 0; padding-left: 15px;">
						<select class="form-control" name="limit" id="limit">
							<option value="10" <?php if(Fuel\Core\Input::get('limit') == '10') echo 'selected'?>>10件</option>
							<option value="50" <?php if(Fuel\Core\Input::get('limit') == '50') echo 'selected'?>>50件</option>
							<option value="100" <?php if(Fuel\Core\Input::get('limit') == '100') echo 'selected'?>>100件</option>
						</select>
					</div>
				</div>

				<table class="table table-bordered table-striped">
					<tbody><tr>
						<th class="text-center">ID</th>
						<th class="text-center">SS名</th>
						<th class="text-center">取引先グループ</th>
						<th class="text-center">取引先(支店)</th>
						<th class="text-center">売上形態</th>
						<th class="text-center">給与</th>
						<th class="text-center">掲載サイト</th>
						<th class="text-center">WEB得</th>
						<th class="text-center">状態</th>
						<th class="text-center">管理</th>
						<th class="text-center">最終更新日時</th>
					</tr>

					<?php

					$res_ss = $res['res_ss'];
					$res_partner = $res['res_partner'];
					$res_sssale = $res['res_sssale'];
					$res_group = $res['res_group'];
					?>
					<?php foreach($res['res'] as $row){ ?>
					<tr>
						<td><?php echo $row['job_id'];?></td>
						<td><?php echo isset($res_ss[$row['ss_id']]['ss_name']) ? $res_ss[$row['ss_id']]['ss_name'] :"" ?></td>
						<td>
							<?php
								$partner_code = isset($res_ss[$row['ss_id']]['partner_code']) ? $res_ss[$row['ss_id']]['partner_code'] :"";
								if($partner_code)
								{
									if(isset($res_partner[$partner_code]['m_group_id']))
										echo $res_group[$res_partner[$partner_code]['m_group_id']]['name'];
									else
										echo '';
								}
								else
									echo '';



							?>
						</td>
						<td>
							<?php

								echo isset($res_partner[$partner_code]['branch_name']) ? $res_partner[$partner_code]['branch_name']:"";
							?>
						</td>
						<td>
							<?php if (isset($res_sssale[$row['sssale_id']])) { ?>
							<?php echo Constants::$sale_type[$res_sssale[$row['sssale_id']]['sale_type']] ?>
							<?php echo $res_sssale[$row['sssale_id']]['sale_name'] ?>
							<?php } ?>
						</td>
						<td><?php echo $row['salary_des']?></td>
						<td><?php
							$text = '';
							if( ( $row['public_type']&1) == 1)
								$text .= 'UOS';
							if(($row['public_type']&8) == 8)
								$text .= ' , 宇佐美';
							echo trim($text,' ,');
						?></td>
						<td>
							<?php
							if($row['is_webtoku'])
							{
								echo '<span class="label label-success">〇</span>';
							}
							else
							{
								echo '<span class="label label-default">×</span>';
							}
							?>
						</td>
						<td class="text-center" style="min-width: 155px;">
										<?php
											if($row['is_available'])
											{
												$text_a  =  '公開';
												$class_a = 'label-success';
											}
											else
											{
												$text_a  = '非公開';
												$class_a = 'label-danger';
											}
										?>
							<span class="label <?php echo $class_a?>"><?php echo $text_a?></span>
							<?php
									if($row['status'])
									{$text = '承認済み'; $class="label-success";}
									else
									{$text = '承認待ち'; $class="label-danger";}
								?>
							<span class="label <?php echo $class?>" style="margin: 0px 0px 0px 5px"><?php echo $text?></span>
						</td>
						<td>
							<div class="btn-group">
								<a class="btn dropdown-toggle btn-sm btn-success" data-toggle="dropdown" style="cursor: pointer">
									処理
									<span class="caret"></span>
								</a>
								<?php echo Presenter::forge('privilege/job')->set('obj',$row); ?>
							</div>
						</td>
						<td style="min-width: 135px;"><?php echo $row['updated_at'];?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</form>
<script>
$('.dateform').datepicker();

$('select[name=group_search]').on('change', function()
{
	$.getJSON(
		'<?php echo Fuel\Core\Uri::base()?>ajax/common/get_partners',
		{ type : '1', 'group_id' : $(this).val() }
	).done(function(response)
	{
		$("select[name=partner_search] option[value!='']").remove();
		$.each(response, function()
		{
			var opt = $('<option></option>')
				.attr('value', this.partner_code)
				.text(this.branch_name)
			;

			if (this.partner_code == '<?php echo \Fuel\Core\Input::get('partner_search') ?>')
			{
				opt.prop('selected', true);
			}

			$("select[name=partner_search]").append(opt);
		});
		$("select[name=partner_search]").trigger('change');
	});
}).trigger('change');

$('select[name=partner_search]').on('change', function()
{
	$.getJSON(
		'<?php echo Fuel\Core\Uri::base()?>ajax/common/get_ss',
		{ 'group_id' : $('select[name=group_search]').val(), 'partner_code' : $(this).val() }
	).done(function(response)
	{
		$("select[name=ss_search] option[value!='']").remove();
		$.each(response, function()
		{
			var opt = $('<option></option>')
				.attr('value', this.ss_id)
				.text(this.ss_name)
			;

			if (this.ss_id == '<?php echo \Fuel\Core\Input::get('ss_search') ?>')
			{
				opt.prop('selected', true);
			}

			$("select[name=ss_search]").append(opt);
		});
	});
}).trigger('change');

function approved(id,status)
{
	if(confirm('承認します、よろしいですか？'))
	{
	$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/approved',
				{
					'job_id':id,
					'status':status
				},
				function(data){

					window.location.reload();
				}
			);
	}
}
function delete_job(id)
{
	if(confirm('削除します、よろしいですか？'))
	{
		$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/deletejob',
			{
				'job_id':id,
			},
			function(data){

				window.location.reload();
			}
		);
	}
}
function is_available(id,is_available)
{
	if(is_available == '1')
		ok = confirm('公開にします、よろしいですか？');
	else
		ok =confirm('非公開にします、よろしいですか？');
	if(ok)
	{
		$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/available',
				{
					'job_id':id,
					'is_available':is_available
				},
				function(data){
					window.location.reload();
				}
			);
	}
}
function is_webtoku(id,is_webtoku)
{
	if(is_webtoku == '1')
		ok = confirm('WEB得ONにします、よろしいですか？');
	else
		ok = confirm('WEB得OFFにします、よろしいですか？');
	if(ok)
	{
		$.post('<?php echo Fuel\Core\Uri::base()?>ajax/common/webtoku',
			{
				'job_id':id,
				'is_webtoku':is_webtoku
			},
			function(data){
				window.location.reload();
			}
		);
	}
}
$("#is_available_1").click(function(){

	$("#is_available_0").attr('checked',false);
});
$("#is_available_0").click(function(){

	$("#is_available_1").attr('checked',false);
});
$("#is_webtoku_1").click(function(){

	$("#is_webtoku_0").attr('checked',false);
});
$("#is_webtoku_0").click(function(){

	$("#is_webtoku_1").attr('checked',false);
});
$("#limit").on('change',function(){
	$("#list-jobs").submit();
});
</script>