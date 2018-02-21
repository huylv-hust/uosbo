<?php echo \Fuel\Core\Asset::js('validate/support.js')?>
<div class="container">
	<h3>
		コンシェルジュ登録リスト
	</h3>

	<form id="list-concierges" action="" class="form-inline" method="get">
		<input type="hidden" name="status" id="form-status" value="">
		<input type="hidden" name="register_id" id="form-register_id" value="">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">
						<label class="control-label">登録日</label>
					</div>
					<div class="col-md-4">
						<?php echo Form::input('start_date', Input::get('start_date', isset($get) ? $get->start_date : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
						～
						<?php echo Form::input('end_date', Input::get('end_date', isset($get) ? $get->end_date : ''), array('class' => 'form-control dateform', 'size' => 10)); ?>
					</div>
					<div class="col-md-2">
						<label class="control-label">都道府県</label>
					</div>
					<div class="col-md-4">
						<?php echo Form::select('addr1', \Input::get('addr1'), Constants::$address_1, array('class' => 'form-control'));?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label class="control-label">キーワード</label>
					</div>
					<div class="col-md-10">
						<?php echo Form::input('keyword', Input::get('keyword', isset($get) ? $get->keyword : ''), array('class' => 'form-control w100', 'placeholder' => '電話番号　氏名(全角)　氏名(ふりがな)　メールアドレス')); ?>
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
				<?php echo Pagination::instance('concierges-pagination'); ?>
			</div>
            <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
			<?php if($listall){ ?>
			<div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
			</div>
			<?php }?>
		</div>

		<?php if($listall){ ?>
		<table class="table table-bordered table-striped">
			<tbody><tr>
					<th class="text-center">登録日時</th>
					<th class="text-center">住所</th>
					<th class="text-center">氏名</th>
					<th class="text-center">電話番号</th>
					<th class="text-center">メールアドレス</th>
					<th class="text-center">状態</th>
					<th class="text-center">管理</th>
				</tr>
				<?php
				foreach($listall as $register)
				{
				?>
				<tr>
					<td nowrap><?php echo date('Y-m-d H:i', strtotime($register['created_at'])); ?></td>
					<?php $addr1 = $register['addr1']; ?>
					<td><?php echo isset(\Constants::$address_1[$addr1]) ? \Constants::$address_1[$addr1].' ' : ''; ?> <?php echo $register['addr2'].' '.$register['addr3']; ?></td>
					<td nowrap><?php echo $register['name']; ?></td>
					<td nowrap>
						<?php if($register['mobile_home']){ ?>
						<div>(固定)<?php echo $register['mobile_home']; ?></div>
						<?php } ?>
						<?php if($register['mobile']){ ?>
						<div>(携帯)<?php echo $register['mobile']; ?></div>
						<?php } ?>
					</td>
					<td>
						<?php if($register['mail']){ ?>
						<div>(1)<?php echo $register['mail']; ?></div>
						<?php } ?>
						<?php if($register['mail2']){ ?>
						<div>(2)<?php echo $register['mail2']; ?></div>
						<?php } ?>
					</td>
					<td>
						<?php
							if($register['status'] == 1)
							{
						?>
							<span class="label label-default">対応済</span>
								<?php
									echo isset($register['update_at']) ? substr($register['update_at'],0,16).' - ' : '';
									if(isset($register['user_id']) && $muser = Model_Muser::find_by_pk($register['user_id']))
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
							<a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-sm btn-success" aria-expanded="false">
								処理
								<span class="caret"></span>
							</a>
							<ul name="add-pulldown" class="dropdown-menu">
								<li><a href="<?php echo \Uri::base().'support/concierge?register_id='.$register['register_id']; ?>" name="detail-btn"><i class="glyphicon glyphicon-tag"></i> 詳細</a></li>
								<?php
								if($register['status'] == 0)
								{
								?>
									<li class="concierges-change-0" value="<?php echo $register['register_id']; ?>"><a><i class="glyphicon glyphicon-ok"></i> 対応済にする</a></li>
								<?php
								}
								else
								{
								?>
									<li class="concierges-change-1" value="<?php echo $register['register_id']; ?>"><a><i class="glyphicon glyphicon-remove"></i> 未対応に戻す</a></li>
								<?php
								}
								?>

							</ul>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody></table>
        <div class="row form-inline">
            <div class="col-md-4">
                <?php echo Pagination::instance('concierges-pagination'); ?>
            </div>
            <div style="margin: 20px 0; padding-left: 15px;">
                <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
            </div>
        </div>
			<?php }else{ ?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					該当するデータがありません
				</div>
			<?php } ?>
	</form>

</div>
<script>
	$(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
		$("#list-concierges").submit();
	});

	//autocomplete
	$('input[name=keyword]').autocomplete({
		minLength : 0,
		source : [
			<?php
			foreach($concierges_autocomplete as $v)
			{
				$name = $v['name'] ? "'".$v['name']."'," : "";
				$name_kana = $v['name_kana'] ? "'".$v['name_kana']."'," : "";
				$mail2 = $v['mail2'] ? "'".$v['mail2']."'," : "";
				$mail = $v['mail'] ? "'".$v['mail']."'," : "";
				$mobile = $v['mobile'] ? "'".$v['mobile']."'," : "";
				$mobile_home = $v['mobile_home'] ? "'".$v['mobile_home']."'," : "";
				echo $name.$name_kana.$mobile.$mail.$mail2.$mobile_home;
			}
			?>
		]
	}).on('focus', function(){
		$(this).autocomplete('search', $(this).val());
	});
</script>
