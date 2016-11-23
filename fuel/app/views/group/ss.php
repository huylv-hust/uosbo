<div class="ss-block">
	<input class="stt" type="hidden" value="<?php echo $data['stt_selected']?>">
	<div class="input-group">
		<div class="input-group-addon">グループ</div>
		<select class="form-control ss-group" datastt="<?php echo $data['stt_selected']?>">
			<option value="">グループを選択して下さい</option>
			<?php foreach($data['listgroup1'] as $key => $val){ ?>
			<option value="<?php echo $val['m_group_id']; ?>" <?php if($val['m_group_id'] == $data['group_id_selected']){ echo 'selected="selected"'; } ?>><?php echo $val['name']; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="input-group">
		<div class="input-group-addon">取引先(受注先)</div>
		<select class="form-control ss-partner ss-partner<?php echo $data['stt_selected']?>" datastt="<?php echo $data['stt_selected']?>">
			<option value="">取引先を選択して下さい</option>
			<?php foreach($data['listpartner'] as $partner) { ?>
			<option value="<?php echo $partner['partner_code']; ?>" <?php if($partner['partner_code'] == $data['partner_code_selected']){ echo 'selected'; } ?>><?php echo $partner['branch_name']; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="input-group">
		<div class="input-group-addon">SS</div>
		<select name="ss_list[]" class="form-control ss-item ss-item<?php echo $data['stt_selected']?>">
			<option value="">SSを選択して下さい</option>
			<?php foreach($data['listss'] as $ss) { ?>
			<option value="<?php echo $ss['ss_id']; ?>" <?php if($ss['ss_id'] == $data['ss_id_selected']){ echo 'selected'; } ?>><?php echo $ss['ss_name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<button type="button" class="btn btn-danger btn-sm" name="remove-ss-btn">
		<i class="glyphicon glyphicon-trash icon-white"></i>
	</button>
</div>