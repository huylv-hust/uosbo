<?php echo \Fuel\Core\Asset::js('validate/group.js')?>
<?php echo \Fuel\Core\Asset::js('validate/partner.js')?>
<h3>
	取引先(支店)
</h3>
<?php
if(isset($partner_code))
{
?>
	<div class="edit-before <?php if( ! empty($is_view)) echo 'edit-display-show'; ?> bottom-space">
		※この枠内は変更前の内容を記載しています
	</div>
<?php
}
?>
<?php
	echo \Fuel\Core\Form::open(array('name' => 'form-partner-list', 'id' => 'form-partner-list'));
?>
	<input type="hidden" value="" id="action_partner_code" name="action_partner_code">
	<p class="text-right">
	<a class="btn btn-warning btn-sm" href="<?php echo \Fuel\Core\Uri::base(); ?>master/partners?<?php echo Session::get('url_filter_partner'); ?>">
			<i class="glyphicon glyphicon-arrow-left icon-white"></i>
			戻る
	</a>
	<?php
	if(isset($partner_code))
	{
	?>
		<span>&nbsp;&nbsp;</span>
		<a value="<?php echo $partner_code; ?>" class="delete_partner">
			<button type="submit" class="btn btn-danger btn-sm">
				<i class="glyphicon glyphicon-trash icon-white"></i>
				削除
			</button>
		</a>
		<input type="hidden" name="partner_id" value="<?php echo $partner_code; ?>">
	<?php
	}
	?>
	</p>
<?php
	echo \Fuel\Core\Form::close();
?>
<?php
echo render('showinfo');
?>
<?php echo Form::open(array('class' => 'form-inline', 'id' => 'form_partner', 'name' => 'form_partner')); ?>
<?php
echo Form::csrf();
?>

<table class="table table-striped">
	<?php
	if(isset($partner_code))
	{
	?>
	<tr>
		<th class="text-right">取引先コード</th>
		<td>
			<?php
				echo $partner_code;
			?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<th class="text-right">取引先区分</th>
		<?php echo \Fuel\Core\Form::input('type',(isset($partner) ? $partner->type : ''),array('type' => 'hidden', ( ! isset($partner) ? 'disabled' : ''))); ?>
		<td <?php if(isset($partner)) echo "class='element_disabled'"; ?> >
			<label class="radio-inline partner-type">
				<?php
				echo Form::radio('type', '1', (isset($partner) && $partner->type == 1) ? true : false, array('id' => 'form_type1', 'class' => 'form_type', (isset($partner) ? 'disabled' : null)));
				echo '受注先';
				?>
			</label>
			<label class="radio-inline partner-type">
				<?php
					echo Form::radio('type', '2', (isset($partner) AND $partner->type == 2) ? true : false , array('id' => 'form_type2', 'class' => 'form_type', (isset($partner) ? 'disabled' : null)));
				    echo  '発注 ';
				?>
			</label>
			<span class="text-info">※いずれか必須</span>
			<label for="type" class="error"></label>
		</td>
	</tr>
	<tr>
		<th class="text-right">Staff2000顧客マスタ番号</th>
		<td>
			<?php echo Form::input('master_num', isset($partner) ? $partner->master_num : '',array('class' => 'form-control', 'size' => '50')); ?>

			<label for="form_master_num" class="error"></label>
			<div class="edit-before <?php echo isset($is_view['master_num']) ? $is_view['master_num'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->master_num : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">所属</th>
		<td>
			<?php
			echo Form::select('m_group_id',isset($partner) ? $partner->m_group_id : '', $form['arr_group'] ,array('class' => 'form-control'));
			?>
			<!--
			<button type="button" class="btn btn-success btn-sm" id="partnercreategroup" name="add-group-btn">
				<i class="glyphicon glyphicon-plus icon-white"></i>
			</button>
			-->
			<label for="form_m_group_id" class="error"></label>
			<div class="edit-before <?php echo isset($is_view['m_group_id']) ? $is_view['m_group_id'] : '' ?>">
				<?php echo isset($edit_partner) ? Model_Mgroups::find_by_pk($edit_partner->m_group_id)->name : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">取引先(支店)名</th>
		<td>
			<?php
			echo Form::input('branch_name',isset($partner)?$partner->branch_name:'',array('class'=>'form-control','size'=>'50'));
			?>
			<span class="text-info">※必須</span>
			<label for="form_branch_name" class="error"></label>
			<div class="edit-before <?php echo isset($is_view['branch_name']) ? $is_view['branch_name'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->branch_name : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">郵便番号</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('zipcode_p1',isset($partner) ? substr($partner->zipcode,0,3) : '',array('class' => 'form-control', 'size' => '4', 'maxlength' => '3'));
			?>
			-
			<?php
			echo Fuel\Core\Form::input('zipcode_p2',isset($partner) ? substr($partner->zipcode,3,4) : '', array('class' => 'form-control', 'size' => '2', 'maxlength' => '4'));
			?>
			<span class="text-info">※必須</span>
			<label id="zipcode-error" class="error" for="zipcode"></label>
			<div class="clear">
				<div class="edit-before <?php echo isset($is_view['zipcode']) ? $is_view['zipcode'] : '' ?> edit-inline">
					<?php echo isset($edit_partner) ? substr($edit_partner->zipcode,0,3) : '' ?>
				</div>
				<div class="edit-before <?php echo isset($is_view['zipcode']) ? $is_view['zipcode'] : '' ?> edit-inline">
					<?php echo isset($edit_partner) ? substr($edit_partner->zipcode,3,4) : '' ?>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">都道府県</th>
		<td>
			<?php
			//Get array address
			$address = \Constants::get_create_address();
			echo Fuel\Core\Form::select('addr1',isset($partner->addr1) ? $partner->addr1 : '', $address,array('class' => 'form-control'));
			?>
			<div class="input-group">
				<div class="input-group-addon">市区町村</div>
				<?php echo Fuel\Core\Form::input('addr2',isset($partner->addr2) ? $partner->addr2 : '',array('class' => 'form-control', 'size' => '20')); ?>
			</div>
			<span class="text-info">※必須</span>
			<label id="addr-error" class="error" for="addr"></label>
			<!--Edit data-->
			<div class="edit-before <?php echo isset($is_view['addr2']) ? $is_view['addr2'] : '' ?> <?php echo isset($is_view['addr1']) ? $is_view['addr1'] : '' ?> ">
			<?php
			//Get array address
			if(isset($edit_partner))
			{
				echo Fuel\Core\Form::select('addr1_edit',$edit_partner->addr1,$address,array('class' => 'form-control', 'disabled'));
			}
			?>
			<div class="input-group">
				<div class="input-group-addon">市区町村</div>
				<?php echo Fuel\Core\Form::input('addr2_edit',isset($edit_partner) ? $edit_partner->addr2 : '',array('class' => 'form-control', 'size' => '20', 'disabled')); ?>
			</div>
			</div>

		</td>
	</tr>
	<tr>
		<th class="text-right">以降の住所</th>
		<td>
			<?php echo Fuel\Core\Form::input('addr3',isset($partner->addr3) ? $partner->addr3:'',array('class'=>'form-control','size'=>'80')); ?>
			<label class="error" for="form_addr3"></label>
			<div class="edit-before <?php echo isset($is_view['addr3']) ? $is_view['addr3'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->addr3 : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">電話番号</th>
		<td>
			<?php echo Fuel\Core\Form::input('tel_1',isset($partner->tel) ? (substr_count($partner->tel, '-') ? explode('-', $partner->tel)[0] : substr($partner->tel,0,4)) : '',array('class'=>'form-control','size'=>'4', 'maxlength' => '4')); ?>
            -
			<?php echo Fuel\Core\Form::input('tel_2',isset($partner->tel) ? (substr_count($partner->tel, '-') ? explode('-', $partner->tel)[1] : substr($partner->tel,4,4)) : '',array('class'=>'form-control','size'=>'4', 'maxlength' => '4')); ?>
            -
			<?php echo Fuel\Core\Form::input('tel_3',isset($partner->tel) ? (substr_count($partner->tel, '-') ? explode('-', $partner->tel)[2] : substr($partner->tel,8,4)) : '',array('class'=>'form-control','size'=>'4', 'maxlength' => '4')); ?>
			<span class="text-info">※必須</span>
            <label id="tel-error" class="error" for="tel"></label>
			<label  class="error" for="form_tel"></label>
			<div class="edit-before <?php echo isset($is_view['tel']) ? $is_view['tel'] : '' ?>">
                <?php echo Fuel\Core\Form::input('tel_1',isset($edit_partner->tel) ? (substr_count($edit_partner->tel, '-') ? explode('-', $edit_partner->tel)[0] : substr($edit_partner->tel,0,4)) : '',array('class'=>'form-control','size'=>'4', 'maxlength' => '4', 'disabled')); ?>
                -
                <?php echo Fuel\Core\Form::input('tel_2',isset($edit_partner->tel) ? (substr_count($edit_partner->tel, '-') ? explode('-', $edit_partner->tel)[1] : substr($edit_partner->tel,4,4)) : '',array('class'=>'form-control','size'=>'4', 'maxlength' => '4', 'disabled')); ?>
                -
                <?php echo Fuel\Core\Form::input('tel_3',isset($edit_partner->tel) ? (substr_count($edit_partner->tel, '-') ? explode('-', $edit_partner->tel)[2] : substr($edit_partner->tel,8,4)) : '',array('class'=>'form-control','size'=>'4', 'maxlength' => '4', 'disabled')); ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">FAX</th>
		<td>
			<?php echo Fuel\Core\Form::input('fax_1',isset($partner->fax) ? (substr_count($partner->fax, '-') ? explode('-', $partner->fax)[0] : substr($partner->fax,0,4)) : '',array('class' => 'form-control', 'size' => '4', 'maxlength' => '4')); ?>
            -
			<?php echo Fuel\Core\Form::input('fax_2',isset($partner->fax) ? (substr_count($partner->fax, '-') ? explode('-', $partner->fax)[1] : substr($partner->fax,4,4)) : '',array('class' => 'form-control', 'size' => '4', 'maxlength' => '4')); ?>
			-
            <?php echo Fuel\Core\Form::input('fax_3',isset($partner->fax) ? (substr_count($partner->fax, '-') ? explode('-', $partner->fax)[2] : substr($partner->fax,8,4)) : '',array('class' => 'form-control', 'size' => '4', 'maxlength' => '4')); ?>
            <label id="fax-error" class="error" for="fax"></label>
            <label  class="error" for="form_fax"></label>
			<div class="edit-before <?php echo isset($is_view['fax']) ? $is_view['fax'] : '' ?>">
                <?php echo Fuel\Core\Form::input('fax_1',isset($edit_partner->fax) ? (substr_count($edit_partner->fax, '-') ? explode('-', $edit_partner->fax)[0] : substr($edit_partner->fax,0,4)) : '',array('class' => 'form-control', 'size' => '4', 'maxlength' => '4', 'disabled')); ?>
                -
                <?php echo Fuel\Core\Form::input('fax_2',isset($edit_partner->fax) ? (substr_count($edit_partner->fax, '-') ? explode('-', $edit_partner->fax)[1] : substr($edit_partner->fax,4,4)) : '',array('class' => 'form-control', 'size' => '4', 'maxlength' => '4', 'disabled')); ?>
                -
                <?php echo Fuel\Core\Form::input('fax_3',isset($edit_partner->fax) ? (substr_count($edit_partner->fax, '-') ? explode('-', $edit_partner->fax)[2] : substr($edit_partner->fax,8,4)) : '',array('class' => 'form-control', 'size' => '4', 'maxlength' => '4', 'disabled')); ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">担当部門</th>
		<td>
			<?php
				echo \Fuel\Core\Form::select('department_id',isset($partner->department_id) ? $partner->department_id : '',Constants::get_create_department(),array('class' => 'form-control'))
			?>
			<span class="text-info text-info-userid">※受注先の場合必須</span>
			<label id="form_department_id-error" class="error" for="form_department_id"></label>
			<div class="edit-before <?php echo isset($is_view['department_id']) ? $is_view['department_id'] : '' ?> disabled">
				<?php
					echo Fuel\Core\Form::select('department_id_edit',isset($edit_partner) ? $edit_partner->department_id : '',Constants::get_create_department(),array('class' => 'form-control', 'disabled'));
				?>
			</div>

		</td>
	</tr>

	<tr>
		<th class="text-right">担当営業</th>
		<td>
			<?php
				//Get array department
				$department = \Constants::get_create_department();
				$user_id = '';
				$arr_user = array();
				$department_id = '';
				if(isset($partner->user_id))
				{
					$user_id = $partner->user_id;
					$department_id = Model_Mpartner::get_department_user($user_id);
					$arr_user = Model_Mpartner::get_filter_user_department($department_id);
					$arr_user = array_column($arr_user,'name','user_id');
				}

				echo Fuel\Core\Form::select('department',$department_id,$department,array('class' => 'form-control'));
				echo ' - ';
				echo Fuel\Core\Form::select('user_id',$user_id,array(''=>'担当者を選択してください')+$arr_user,array('class' => 'form-control'));
			?>
			<span class="text-info text-info-userid">※受注先の場合必須</span>
			<label id="form_user_id-error" class="error" for="form_user_id"></label>

			<div class="edit-before <?php echo isset($is_view['user_id']) ? $is_view['user_id'] : '' ?> disabled">
				<?php
				if(isset($edit_partner))
				{
					$user_id = $edit_partner->user_id;
					$department_id = Model_Mpartner::get_department_user($user_id);
					$arr_user = Model_Mpartner::get_filter_user_department($department_id);
					$arr_user = array_column($arr_user,'name','user_id');
					echo Fuel\Core\Form::select('department_edit',$department_id,$department,array('class' => 'form-control', 'disabled'));
					echo Fuel\Core\Form::select('user_id_edit',$user_id,$arr_user,array('class' => 'form-control', 'disabled'));
				}
				?>
			</div>

		</td>
	</tr>

	<tr>
		<th class="text-right">請求先部署</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('billing_department',isset($partner->billing_department)?$partner->billing_department:'',array('class'=>'form-control','size'=>'50'));
			?>
			<label class="error" for="form_billing_department"></label>
			<div class="edit-before <?php echo isset($is_view['billing_department']) ? $is_view['billing_department'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->billing_department : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">請求先電話番号</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('billing_tel',isset($partner->billing_tel)?$partner->billing_tel:'',array('class'=>'form-control','size'=>'20', 'maxlength' => '11'));
			?>
			<label class="error" for="form_billing_tel"></label>
			<div class="edit-before <?php echo isset($is_view['billing_tel']) ? $is_view['billing_tel'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->billing_tel : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">請求先FAX</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('billing_fax',isset($partner->billing_fax)?$partner->billing_fax:'',array('class'=>'form-control','size'=>'20', 'maxlength' => '11'));
			?>
			<label class="error" for="form_billing_fax"></label>
			<div class="edit-before <?php echo isset($is_view['billing_fax']) ? $is_view['billing_fax'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->billing_fax : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">請求先〆日</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('billing_deadline_day',isset($partner->billing_deadline_day)?$partner->billing_deadline_day:'',array('class'=>'form-control','size'=>'5', 'maxlength' => '2'));
			?>
			<span class="text-info">※末締めの場合は30を入力</span>
			<label class="error" for=form_"billing_deadline_day"></label>
			<div class="edit-before <?php echo isset($is_view['billing_deadline_day']) ? $is_view['billing_deadline_day'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->billing_deadline_day : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">支払日</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('payment_day',isset($partner->payment_day)?$partner->payment_day:'',array('class'=>'form-control','size'=>'5', 'maxlength' => '2'));
			?>
			<span class="text-info">※末締めの場合は30を入力</span>
			<label class="error" for="form_payment_day"></label>
			<div class="edit-before <?php echo isset($is_view['payment_day']) ? $is_view['payment_day'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->payment_day : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">取引開始年月日</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('billing_start_date',isset($partner->billing_start_date)?$partner->billing_start_date:'',array('class'=>'dateform form-control','size'=>'12'));
			?>
			<label class="error" for="form_billing_start_date"></label>
			<div class="edit-before <?php echo isset($is_view['billing_start_date']) ? $is_view['billing_start_date'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->billing_start_date : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">銀行名</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('bank_name',isset($partner->bank_name)?$partner->bank_name:'',array('class'=>'form-control','size'=>'50'));
			?>
			<label class="error" for="form_bank_name"></label>
			<div class="edit-before <?php echo isset($is_view['bank_name']) ? $is_view['bank_name'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->bank_name : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">銀行支店名</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('bank_branch_name',isset($partner->bank_branch_name)?$partner->bank_branch_name:'',array('class'=>'form-control','size'=>'50'));
			?>
			<label class="error" for="form_bank_branch_name"></label>
			<div class="edit-before <?php echo isset($is_view['bank_branch_name']) ? $is_view['bank_branch_name'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->bank_branch_name : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">銀行口座番号</th>
		<td>
			<div class="input-group">
				<div class="input-group-addon">種別</div>
				<?php
					echo \Fuel\Core\Form::select('bank_type',isset($partner->bank_type) ? $partner->bank_type : '',Constants::$bank_type, array('class' => 'form-control'));
				?>
			</div>
			<label id="form_bank_type-error" class="error" for="form_bank_type"></label>
			<?php
			echo Fuel\Core\Form::input('bank_account_number',isset($partner->bank_account_number)?$partner->bank_account_number:'',array('class'=>'form-control','size'=>'12', 'maxlength' => '7'));
			?>
			<label class="error" for="form_bank_account_number"></label>

			<div class="edit-before <?php echo (isset($is_view['bank_account_number']) or isset($is_view['bank_type'])) ? 'edit-display-show' : '' ?>">
				<div class="input-group">
					<div class="input-group-addon">種別</div>
					<?php
					echo \Fuel\Core\Form::select('bank_type',isset($edit_partner->bank_type) ? $edit_partner->bank_type : '',Constants::$bank_type, array('class' => 'form-control','disabled'));
					?>
				</div>
				<?php echo isset($edit_partner) ? \Fuel\Core\Form::input('',$edit_partner->bank_account_number,array('class' => 'form-control','disabled')) : '' ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">備考</th>
		<td>
			<?php
			echo Fuel\Core\Form::textarea('notes',isset($partner->notes)?$partner->notes:'',array('rows' => 5, 'cols' => 80,'class'=>'form-control'))
			?>
			<label class="error" for="form_notes"></label>
			<div class="edit-before  <?php echo isset($is_view['notes']) ? $is_view['notes'] : '' ?>">
				<?php echo \Fuel\Core\Form::textarea('notes_edit', isset($edit_partner) ? $edit_partner->notes : '',array('rows' => 5, 'cols' => 80,'class'=>'form-control','disabled'));  ?>
			</div>
		</td>
	</tr>
	<tr>
		<th class="text-right">宇佐美支店番号</th>
		<td>
			<?php
			echo Fuel\Core\Form::input('usami_branch_code',isset($partner->usami_branch_code)?$partner->usami_branch_code:'',array('class'=>'form-control','size'=>'2', 'maxlength' => '2'));
			?>
			<label class="error" for="form_usami_branch_code"></label>
			<div class="edit-before <?php echo isset($is_view['usami_branch_code']) ? $is_view['usami_branch_code'] : '' ?>">
				<?php echo isset($edit_partner) ? $edit_partner->usami_branch_code : '' ?>
			</div>
			<span class="text-info">※OBIC7連携に使用</span>
		</td>
	</tr>
</table>

<div class="text-center">

	<button type="submit" class="btn btn-primary btn-sm">
		<i class="glyphicon glyphicon-pencil icon-white"></i>
		保存
	</button>
</div>

<?php echo Form::close(); ?>

<script type="text/javascript">
	$(function(){
		$('.edit-before').addClass('edit-display-none');
//		 $('input[name=branch_name]').autocomplete({
//		 minLength : 0,
//		 source : [
//		<?php
//			foreach($partner_name as $v)
//			{
//				echo "'".$v['branch_name']."'".",";
//			}
//		?>
//		 ]
//		 });
//
//		 $('input[name=branch_name]').on('focus', function()
//		 {
//		 $(this).autocomplete('search', $(this).val());
//		 });
	});
</script>