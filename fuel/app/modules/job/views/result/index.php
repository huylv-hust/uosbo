<h3>
	応募実績
</h3>

<?php echo Form::open(array('class' => 'form-inline', 'id' => 'form_export_job', 'method' => 'get', 'enctype' => 'multipart/form-data'));?>
<div class="panel panel-default">
	<div class="panel-body">

		<div class="row">
			<div class="col-md-2">
				<label class="control-label">掲載期間</label>
			</div>
			<div class="col-md-10">
				<input name="start_date" type="text" class="form-control dateform" size="10" value="<?php echo \Fuel\Core\Input::get('start_date') ? Input::get('start_date') : '';?>">
				～
				<input name="end_date" type="text" class="form-control dateform" size="10" value="<?php echo \Fuel\Core\Input::get('end_date') ? Input::get('end_date') : '';?>">
				<p></p>
				<div class="text-info">
					※指定しない場合は全期間対象
				</div>
				<div class="text-info">
					※オーダーと関連していない応募は応募日で抽出します
				</div>
			</div>
		</div>

		<div class="row text-center">
			<button value="true" name="export" type="submit" class="btn btn-warning btn-sm">
				<i class="glyphicon glyphicon-download-alt icon-white"></i>
				CSVダウンロード
			</button>
		</div>
	</div>
</div>

<?php echo \Fuel\Core\Form::close();?>