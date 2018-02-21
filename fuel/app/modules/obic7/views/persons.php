<h3>
	採用者リスト
</h3>
<form class="form-inline" id="obic7-persons-list">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label">インポート設定日</label>
				</div>
				<div class="col-md-4">
					<input type="text" size="10" class="form-control dateform" name="start_obic7_date" value="<?php echo isset($filters['start_obic7_date']) ? $filters['start_obic7_date'] : '';?>">
					～
					<input type="text" size="10" class="form-control dateform" name="end_obic7_date" value="<?php echo isset($filters['end_obic7_date']) ? $filters['end_obic7_date'] : '';?>">
				</div>
				<div class="col-md-2">
					<label class="control-label">応募日</label>
				</div>
				<div class="col-md-4">
					<input type="text" size="10" class="form-control dateform" name="start_application_date" value="<?php echo isset($filters['start_application_date']) ? $filters['start_application_date'] : ''?>">
					～
					<input type="text" size="10" class="form-control dateform" name="end_application_date" value="<?php echo isset($filters['end_application_date']) ? $filters['end_application_date'] : ''?>">
				</div>
			</div>

			<div class="row">
				<div class="col-md-2">
					<label class="control-label">社員番号</label>
				</div>
				<div class="col-md-4">
					<input type="text" size="20" class="form-control" name="employee_code" value="<?php echo isset($filters['employee_code']) ? $filters['employee_code'] : '' ?>">
				</div>
				<div class="col-md-2">
					<label class="control-label">氏名</label>
				</div>
				<div class="col-md-4">
					<input type="text" placeholder="漢字 or かな" class="form-control w100" name="person_name" value="<?php echo isset($filters['person_name']) ? $filters['person_name'] : ''?>">
				</div>
			</div>

			<div class="row text-center">
				<button class="btn btn-primary btn-sm" type="submit"><i class="glyphicon glyphicon-search icon-white"></i> フィルタ</button>
				<button name="filter-clear-btn" class="btn btn-info btn-sm" type="button"><i class="glyphicon glyphicon-refresh icon-white"></i> フィルタ解除</button>
				<a id="csvdownload-btn" href="#" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-download-alt icon-white"></i>CSVダウンロード</a>
			</div>
		</div>
	</div>
	<div class="row form-inline">
		<div class="col-md-4">
			<?php echo Pagination::instance('mypagination'); ?>
		</div>
        <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit','')?>">
		<?php if(count($listPerson)) {?>
		<div style="margin: 20px 0; padding-left: 15px;">
            <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
		</div>
		<?php }?>
	</div>
	<?php if(count($listPerson)) {?>
	<table class="table table-bordered table-striped">
		<tbody>
			<tr>
				<th class="text-center">インポート設定日</th>
				<th class="text-center">応募日時</th>
				<th class="text-center">氏名</th>
				<th class="text-center">社員番号</th>
				<th class="text-center">メールアドレス</th>
				<th class="text-center">管理</th>
			</tr>
			<?php foreach($listPerson as $row) {?>
			<tr>
				<td class="text-center"><?php echo $row['obic7_date']; ?></td>
				<td><?php echo $row['application_date']?></td>
				<td><a href="<?php echo Uri::base(true).'obic7/person?person_id='.$row['person_id']?>"><?php echo $row['p_name']?></a></td>
				<td><?php echo $row['employee_code']?></td>
				<td>
					<?php
						echo $row['mail_addr1'];
						echo $row['mail_addr2'] ? '<br/>'.$row['mail_addr2'] : '';
					?>
				</td>
				<td>
					<div class="btn-group">
						<a class="btn dropdown-toggle btn-sm btn-success" data-toggle="dropdown" href="#" aria-expanded="false">
							処理
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" name="add-pulldown">
							<li><a name="detail-btn" href="<?php echo Uri::base(true).'obic7/person?person_id='.$row['person_id']?>"><i class="glyphicon glyphicon-eye-open"></i> 閲覧</a></li>
						</ul>
					</div>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
    <div class="row form-inline">
        <div class="col-md-4">
            <?php echo Pagination::instance('mypagination'); ?>
        </div>
        <div style="margin: 20px 0; padding-left: 15px;">
            <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : 100, Constants::$limit_pagination, array('class' => 'form-control limit'))?>
        </div>
    </div>
	<?php } else  {?>
	<div role="alert" class="alert alert-danger alert-dismissible">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
			該当するデータがありません
	</div>
	<?php } ?>

</form>
<script type="text/javascript">
$(function (e)
	{

		$('.dateform').datepicker();
		$('#csvdownload-btn').on('click', function()
		{
			$.post('<?php echo Fuel\Core\Uri::base()?>obic7/persons/total/',
				{
					'start_obic7_date':$("input[name=start_obic7_date]").val(),
					'end_obic7_date':$("input[name=end_obic7_date]").val(),
					'employee_code':$("input[name=employee_code]").val(),
					'start_application_date':$("input[name=start_application_date]").val(),
					'end_application_date':$("input[name=end_application_date]").val(),
					'person_name':$("input[name=person_name]").val()
				},
				function(data){
					if(data > 0)
					{
						if (confirm('ダウンロード開始してよろしいですか？\n(実行ログが記録されます)') == false) {
							return false;
						}

						window.location.href ='<?php echo  \Uri::base().'obic7/persons/index/'.(\Uri::segment(4) ? \Uri::segment(4):1).'?export=true';?>'
									+ '&start_obic7_date='+$("input[name=start_obic7_date]").val()
									+ '&end_obic7_date=' + $("input[name=end_obic7_date]").val()
									+ '&employee_code='+$("input[name=employee_code]").val()
									+ '&start_application_date='+$("input[name=start_application_date]").val()
									+ '&end_application_date='+$("input[name=end_application_date]").val()
									+ '&person_name='+$("input[name=person_name]").val();
					}
					else
					{
						alert('該当するデータがありません');
						return false;
					}
				}
			);

		});
	});
$(".limit").on('change',function(){
    var val = $(this).val();
    $("input[name='limit']").val(val);
		$("#obic7-persons-list").submit();
	});
</script>

