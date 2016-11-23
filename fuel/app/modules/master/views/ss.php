<?php echo \Fuel\Core\Asset::js('validate/ss.js')?>
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
?>
<h3>SS</h3>
	<div class="edit-before bottom-space <?php echo isset($is_view['title']) ? $is_view['title'] : 'hide'?>">
		<strong>※この枠内は変更前の内容を記載しています</strong>
	</div>

	<form action="<?php echo \Fuel\Core\Uri::base(); ?>master/ss/delete" method="post">
		<p class="text-right">
			<a href="<?php echo (\Fuel\Core\Session::get('sslist_url')) ?  \Fuel\Core\Session::get('sslist_url') :  \Fuel\Core\Uri::base().'master/sslist';?>" class="btn btn-warning btn-sm right">
				<i class="glyphicon glyphicon-arrow-left icon-white"></i>
				戻る
			</a>
		<?php
			if(isset($ss))
			{
		?>
			<input type="hidden" name="ss_id" value="<?php echo $ss->ss_id;?>">
			<button class="btn btn-danger btn-sm" type="button" id="btn_sslist_back">
				<i class="glyphicon glyphicon-trash icon-white"></i>
				削除
			</button>
		<?php
			}
		?>
		</p>
	</form>
<?php
if(isset($ss)) {
?>
	<p class="text-center">
		<a href="#">SS基本情報</a>
		|
		<a href="<?php echo \Fuel\Core\Uri::base().'master/sssale?ss_id='.$ss->ss_id.'&ss_name='.urlencode($ss->ss_name)?>">売上形態</a>
	</p>
<?php }?>
<?php echo Form::open(array('class' => 'form-inline', 'id' => 'ss_form'));?>
<?php
if(isset($ss))
{
	echo '<input type="hidden" name="ss_id" value="'.$ss->ss_id.'">';
}
?>

<table class="table table-striped">
	<tbody>
	<tr>
		<th class="text-right">取引先(受注先)</th>
		<td>
			<?php echo $filtergroup; ?>
			<div class="edit-before <?php echo isset($is_view['partner_code']) ? $is_view['partner_code'] : 'hide'?>">
				<select class="form-control" disabled>
					<option><?php echo isset($group_name) ? $group_name : ''?></option>
				</select>
				<select class="form-control" disabled>
					<option><?php echo isset($branch_name) ? $branch_name : ''?></option>
				</select>
			</div>
			<label id="form_partner_code-error" class="error" for="form_partner_code"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">SS名</th>
		<td>
			<?php echo Form::input('ss_name', Input::post('ss_name') ? Input::post('ss_name') : (isset($json->ss_name) ? $json->ss_name : ''), array('class' => 'form-control', 'size' => 50));?>
			<span class="text-info">※必須</span>
			<span class="edit-before <?php echo isset($is_view['ss_name']) ? $is_view['ss_name'] : 'hide'?>"><?php echo isset($ss) ? $ss->ss_name : '' ?></span>
			<label id="form_ss_name-error" class="error" for="form_ss_name"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">元売</th>
		<td>
			<?php echo Form::input('original_sale', Input::post('original_sale') ? Input::post('original_sale') : (isset($json->original_sale) ? $json->original_sale : ''), array('class' => 'form-control', 'size' => 50));?>
			<span class="edit-before <?php echo isset($is_view['original_sale']) ? $is_view['original_sale'] : 'hide'?>"><?php echo isset($ss) ? $ss->original_sale : '' ?></span>
		</td>
	</tr>
	<tr>
		<th class="text-right">拠点コード</th>
		<td>
			<?php echo Form::input('base_code', Input::post('base_code') ? Input::post('base_code') : (isset($json->base_code) ? $json->base_code : ''), array('class' => 'form-control', 'size' => 20));?>
			<span class="edit-before <?php echo isset($is_view['base_code']) ? $is_view['base_code'] : 'hide'?>"><?php echo isset($ss) ? $ss->base_code : '' ?></span>
		</td>
	</tr>
	<tr>
		<th class="text-right">郵便番号</th>
		<td>
			<?php echo Form::input('zipcode_first', Input::post('zipcode_first') ? Input::post('zipcode_first') : (isset($json->zipcode) ? substr($json->zipcode,0,3) : ''), array('class' => 'form-control', 'size' => 2, 'maxlength' => 3));?>
			<span class="edit-before <?php echo isset($is_view['zipcode']) ? $is_view['zipcode'] : 'hide'?>"><?php echo isset($ss) ? substr($ss->zipcode,0,3) : '' ?></span>
			-
			<?php echo Form::input('zipcode_last', Input::post('zipcode_last') ? Input::post('zipcode_last') : (isset($json->zipcode) ? substr($json->zipcode,3,4) : ''), array('class' => 'form-control', 'size' => 4, 'maxlength' => 4));?>
			<span class="edit-before <?php echo isset($is_view['zipcode']) ? $is_view['zipcode'] : 'hide'?>"><?php echo isset($ss) ? substr($ss->zipcode,3,4) : '' ?></span>
			<span class="text-info">※必須</span>
			<label id="zipcode-error" class="error" for="zipcode"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">都道府県</th>
		<td>
			<?php echo Form::select('addr1', Input::post('addr1') ? Input::post('addr1') : (isset($json->addr1) ? $json->addr1 : ''), $address1, array('class' => 'form-control')); ?>
			<span>市区町村</span>
			<?php echo Form::input('addr2', Input::post('addr2') ? Input::post('addr2') : (isset($json->addr2) ? $json->addr2 : ''), array('class' => 'form-control', 'size' => 20));?>
			<span class="text-info">※必須</span>
			<label id="address" class="error" for="address"></label>
			<div class="edit-before <?php echo isset($is_view['addr1']) || isset($is_view['addr2']) ? '' : 'hide'?>">
				<select class="form-control <?php echo isset($is_view['addr1']) ? $is_view['addr1'] : 'hide' ?>" disabled>
					<option><?php echo isset($ss) ? $address1[$ss->addr1] : '' ?></option>
				</select>
				<span>市区町村</span>
				<span class="edit-before <?php echo isset($is_view['addr2']) ? $is_view['addr2'] : 'hide'?>"><?php echo isset($ss->addr2) ? $ss->addr2 : '' ?></span>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">以降の住所</th>
		<td>
			<?php echo Form::input('addr3', Input::post('addr3') ? Input::post('addr3') : (isset($json->addr3) ? $json->addr3 : ''), array('class' => 'form-control', 'size' => 80));?>
			<span class="edit-before <?php echo isset($is_view['addr3']) ? $is_view['addr3'] : 'hide'?>"><?php echo isset($ss) ? $ss->addr3 : '' ?></span>
		</td>
	</tr>
	<tr>
		<th class="text-right">電話番号</th>
		<td>
			<?php echo Form::input('tel_1', Input::post('tel_1') ? Input::post('tel_1') : (isset($json->tel) ? substr_count($json->tel, '-') ? explode('-', $json->tel)[0] : substr($json->tel, 0,4) : ''), array('class' => 'form-control', 'size' => 4, 'maxlength' => 4));?>
            -
			<?php echo Form::input('tel_2', Input::post('tel_2') ? Input::post('tel_2') : (isset($json->tel) ? substr_count($json->tel, '-') ? explode('-', $json->tel)[1] : substr($json->tel, 4,4) : ''), array('class' => 'form-control', 'size' => 4, 'maxlength' => 4));?>
            -
			<?php echo Form::input('tel_3', Input::post('tel_3') ? Input::post('tel_3') : (isset($json->tel) ? substr_count($json->tel, '-') ? explode('-', $json->tel)[2] : substr($json->tel, 8,4) : ''), array('class' => 'form-control', 'size' => 4, 'maxlength' => 4));?>
			<span class="text-info">※必須</span>
            <label id="tel-error" class="error" for="tel"></label>
			<span class="edit-before <?php echo isset($is_view['tel']) ? $is_view['tel'] : 'hide'?>">
                <?php echo Form::input('tel_1', Input::post('tel_1') ? Input::post('tel_1') : (isset($ss->tel) ? substr_count($ss->tel, '-') ? explode('-', $ss->tel)[0] : substr($ss->tel, 0,4) : ''), array('class' => 'form-control', 'size' => 4, 'maxlength' => 4, 'disabled'));?>
                -
                <?php echo Form::input('tel_2', Input::post('tel_2') ? Input::post('tel_2') : (isset($ss->tel) ? substr_count($ss->tel, '-') ? explode('-', $ss->tel)[1] : substr($ss->tel, 4,4) : ''), array('class' => 'form-control', 'size' => 4, 'maxlength' => 4, 'disabled'));?>
                -
                <?php echo Form::input('tel_3', Input::post('tel_3') ? Input::post('tel_3') : (isset($ss->tel) ? substr_count($ss->tel, '-') ? explode('-', $ss->tel)[2] : substr($ss->tel, 8,4) : ''), array('class' => 'form-control', 'size' => 4, 'maxlength' => 4, 'disabled'));?>
            </span>
			<label id="form_tel-error" class="error" for="form_tel"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">アクセス</th>
		<td>
			<?php echo Form::input('access', Input::post('access') ? Input::post('access') : (isset($json->access) ? $json->access : ''), array('class' => 'form-control', 'size' => 80));?>
			<span class="edit-before <?php echo isset($is_view['access']) ? $is_view['access'] : 'hide'?>"><?php echo isset($ss) ? $ss->access : '' ?></span>
		</td>
	</tr>
	<tr>
		<th class="text-right">最寄り駅</th>
		<td>
			<p></p>
			<div class="input-group">
				<div class="input-group-addon">会社</div>
				<?php echo Form::input('station_name1', Input::post('station_name1') ? Input::post('station_name1') : (isset($json->station_name1) ? $json->station_name1 : ''), array('class' => 'form-control', 'size' => 10));?>
			</div>
			<label id="form_station_name1-error" class="error" for="form_station_name1"></label>
			<div class="input-group">
				<?php echo Form::input('station_line1', Input::post('station_line1') ? Input::post('station_line1') : (isset($json->station_line1) ? $json->station_line1 : ''), array('class' => 'form-control', 'size' => 10));?>
				<div class="input-group-addon">線</div>
			</div>
			<label id="form_station_line1-error" class="error" for="form_station_line1"></label>

			<div class="input-group">
				<?php echo Form::input('station1', Input::post('station1') ? Input::post('station1') : (isset($json->station1) ? $json->station1 : ''), array('class' => 'form-control', 'size' => 10));?>
				<div class="input-group-addon">駅</div>
			</div>
			<label id="form_station1-error" class="error" for="form_station1"></label>

			<div class="input-group">
				<div class="input-group-addon">徒歩</div>
				<?php echo Form::input('station_walk_time1', Input::post('station_walk_time1') ? Input::post('station_walk_time1') : (isset($json->station_walk_time1) ? $json->station_walk_time1 : ''), array('class' => 'form-control', 'size' => 3));?>
				<div class="input-group-addon">分</div>
			</div>
			<label id="form_station_walk_time1-error" class="error" for="form_station_walk_time1"></label>
			<p></p>
			<div class="edit-before <?php echo isset($is_view['station_name1']) || isset($is_view['station_line1']) || isset($is_view['station1']) || isset($is_view['station_walk_time1']) ? '' : 'hide'?>">
				<div class="input-group <?php echo isset($is_view['station_name1']) ? '' : 'hide'?>">
					<div class="input-group-addon">会社</div>
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_name1 : '' ?>">
				</div>
				<div class="input-group <?php echo isset($is_view['station_line1']) ? '' : 'hide'?>">
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_line1 : '' ?>">
					<div class="input-group-addon">線</div>
				</div>

				<div class="input-group <?php echo isset($is_view['station1']) ? '' : 'hide'?>"">
				<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station1 : '' ?>" size="10">
					<div class="input-group-addon">駅</div>
				</div>

				<div class="input-group <?php echo isset($is_view['station_walk_time1']) ? '' : 'hide'?>">
					<div class="input-group-addon">徒歩</div>
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_walk_time1 : '' ?>">
					<div class="input-group-addon">分</div>
				</div>
			</div>
			<p></p>

			<div class="input-group">
				<div class="input-group-addon">会社</div>
				<?php echo Form::input('station_name2', Input::post('station_name2') ? Input::post('station_name2') : (isset($json->station_name2) ? $json->station_name2 : ''), array('class' => 'form-control', 'size' => 10));?>
			</div>
			<label id="form_station_name2-error" class="error" for="form_station_name2"></label>
			<div class="input-group">
				<?php echo Form::input('station_line2', Input::post('station_line2') ? Input::post('station_line2') : (isset($json->station_line2) ? $json->station_line2 : ''), array('class' => 'form-control', 'size' => 10));?>
				<div class="input-group-addon">線</div>
			</div>
			<label id="form_station_line2-error" class="error" for="form_station_line2"></label>

			<div class="input-group">
				<?php echo Form::input('station2', Input::post('station2') ? Input::post('station2') : (isset($json->station2) ? $json->station2 : ''), array('class' => 'form-control', 'size' => 10));?>
				<div class="input-group-addon">駅</div>
			</div>
			<label id="form_station2-error" class="error" for="form_station2"></label>

			<div class="input-group">
				<div class="input-group-addon">徒歩</div>
				<?php echo Form::input('station_walk_time2', Input::post('station_walk_time2') ? Input::post('station_walk_time2') : (isset($json->station_walk_time2) ? $json->station_walk_time2 : ''), array('class' => 'form-control', 'size' => 3));?>
				<div class="input-group-addon">分</div>
			</div>
			<label id="form_station_walk_time2-error" class="error" for="form_station_walk_time2"></label>
			<p></p>
			<div class="edit-before <?php echo isset($is_view['station_name2']) || isset($is_view['station_line2']) || isset($is_view['station2']) || isset($is_view['station_walk_time2']) ? '' : 'hide'?>">
				<div class="input-group <?php echo isset($is_view['station_name2']) ? '' : 'hide'?>">
					<div class="input-group-addon">会社</div>
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_name2 : '' ?>">
				</div>
				<div class="input-group <?php echo isset($is_view['station_line2']) ? '' : 'hide'?>">
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_line2 : '' ?>">
					<div class="input-group-addon">線</div>
				</div>

				<div class="input-group <?php echo isset($is_view['station2']) ? '' : 'hide'?>">
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station2 : '' ?>" size="10">
					<div class="input-group-addon">駅</div>
				</div>

				<div class="input-group <?php echo isset($is_view['station_walk_time2']) ? '' : 'hide'?>">
					<div class="input-group-addon">徒歩</div>
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_walk_time2 : '' ?>">
					<div class="input-group-addon">分</div>
				</div>
			</div>
			<p></p>

			<div class="input-group">
				<div class="input-group-addon">会社</div>
				<?php echo Form::input('station_name3', Input::post('station_name3') ? Input::post('station_name3') : (isset($json->station_name3) ? $json->station_name3 : ''), array('class' => 'form-control', 'size' => 10));?>
			</div>
			<label id="form_station_name3-error" class="error" for="form_station_name3"></label>
			<div class="input-group">
				<?php echo Form::input('station_line3', Input::post('station_line3') ? Input::post('station_line3') : (isset($json->station_line3) ? $json->station_line3 : ''), array('class' => 'form-control', 'size' => 10));?>
				<div class="input-group-addon">線</div>
			</div>
			<label id="form_station_line3-error" class="error" for="form_station_line3"></label>

			<div class="input-group">
				<?php echo Form::input('station3', Input::post('station3') ? Input::post('station3') : (isset($json->station3) ? $json->station3 : ''), array('class' => 'form-control', 'size' => 10));?>
				<div class="input-group-addon">駅</div>
			</div>
			<label id="form_station3-error" class="error" for="form_station3"></label>

			<div class="input-group">
				<div class="input-group-addon">徒歩</div>
				<?php echo Form::input('station_walk_time3', Input::post('station_walk_time3') ? Input::post('station_walk_time3') : (isset($json->station_walk_time3) ? $json->station_walk_time3 : ''), array('class' => 'form-control', 'size' => 3));?>
				<div class="input-group-addon">分</div>
			</div>
			<label id="form_station_walk_time3-error" class="error" for="form_station_walk_time3"></label>
			<p></p>
			<div class="edit-before <?php echo isset($is_view['station_name3']) || isset($is_view['station_line3']) || isset($is_view['station3']) || isset($is_view['station_walk_time3']) ? '' : 'hide'?>">
				<div class="input-group <?php echo isset($is_view['station_name3']) ? '' : 'hide'?>">
					<div class="input-group-addon">会社</div>
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_name3 : '' ?>">
				</div>
				<div class="input-group <?php echo isset($is_view['station_line3']) ? '' : 'hide'?>">
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_line3 : '' ?>">
					<div class="input-group-addon">線</div>
				</div>

				<div class="input-group <?php echo isset($is_view['station3']) ? '' : 'hide'?>">
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station3 : '' ?>" size="10">
					<div class="input-group-addon">駅</div>
				</div>

				<div class="input-group <?php echo isset($is_view['station_walk_time3']) ? '' : 'hide'?>">
					<div class="input-group-addon">徒歩</div>
					<input class="form-control" type="text" disabled value="<?php echo isset($ss) ? $ss->station_walk_time3 : '' ?>">
					<div class="input-group-addon">分</div>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">目印情報</th>
		<td>
			<?php echo Form::input('mark_info', Input::post('mark_info') ? Input::post('mark_info') : (isset($json->mark_info) ? $json->mark_info : ''), array('class' => 'form-control', 'size' => 80));?>
			<span class="edit-before <?php echo isset($is_view['mark_info']) ? $is_view['mark_info'] : 'hide'?>"><?php echo isset($ss) ? $ss->mark_info : '' ?></span>
		</td>
	</tr>
	<tr>
		<th class="text-right">備考</th>
		<td>
			<?php echo Form::textarea('notes', Input::post('notes') ? Input::post('notes') : (isset($json->notes) ? $json->notes : ''), array('rows' => 5, 'cols' => 77));?>
			<div class="edit-before <?php echo isset($is_view['notes']) ? $is_view['notes'] : 'hide'?>">
				<textarea class="form-control" disabled rows='5' cols='77'><?php echo isset($ss) ? $ss->notes : '' ?></textarea>
			</div>
		</td>
	</tr>

	</tbody>
</table>

<div class="text-center">
	<button name="submit" class="btn btn-primary btn-sm" type="submit">
		<i class="glyphicon glyphicon-pencil icon-white"></i>
		保存
	</button>
</div>

<?php echo Form::close();