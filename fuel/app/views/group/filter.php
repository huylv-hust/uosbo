<?php
/**
 * Nếu custom.step = 2 thì hiện group, partner
 * Nếu custom.step = 3 thì hiện group, partner, ss
 * Nếu custom.step = 4 thì hiện group, partner, ss, mscale
 *
 **/
$l_group = '';
$l_partner = '';
$l_ss = '';
$l_sssale = '';
if(isset($custom['field']['step']))
	$step = $custom['field']['step'];
if(isset($custom['field']['type']))
	$type = $custom['field']['type'];
if(isset($custom['field']['label']))
	$label = $custom['field']['label'];

$default_group = array('' => '法人を選択して下さい');
$default_partner = array('' => '支店を選択して下さい');
$default_ss = array('' => 'SSを選択して下さい');
$default_ss_sale = array('' => '売上形態を選択して下さい');
$arr_partner = $default_partner;
$arr_sss     = $default_ss;
$arr_ss_sale = $default_ss_sale;

if(isset($custom['datafilter']))
{
	$customdata = $custom['datafilter'];
}
if(isset($label['group']))
	$l_group = $label['group'];

if(isset($label['partner']))
	$l_partner = $label['partner'];

if(isset($label['ss']))
	$l_ss = $label['ss'];

if(isset($label['sslist']))
	$l_sssale = $label['sslist'];
?>

<?php
$is_diff_ss = true;
if(isset($customdata['label_sssale_id']) && ($customdata['label_sssale_id'] == $customdata['sssale_id']))
{
	$is_diff_ss = false;
}
?>
<div class="filter-group-presenter">
<?php
	if($step >= 1)
	{
		$groups = Model_Mgroups::get_type($type);
		//Set groups default
		$arr_group = $default_group + $groups;
?>
	<?php echo Form::select('m_group_id',isset($customdata['m_group_id']) ? $customdata['m_group_id'] : '',$arr_group,array('class' => 'form-control')); ?>
		<?php
		if ($is_diff_ss && isset($customdata['label_m_group_id']))
		{
			?>
			<span class="edit-before edit-before-ss">
			<?php
			echo Model_Mgroups::find_by_pk($customdata['label_m_group_id'])->name;
			?>
		</span>
		<?php
		}
		?>
<?php
	}

	if($step >= 2)
	{
		/*Select partner*/
		if(isset($customdata) and $edit_partner = isset($customdata['edit_partner']) ? $customdata['edit_partner'] : array())
		{
			$arr_partner = array_column($edit_partner, 'branch_name', 'partner_code');
			$arr_partner = $default_partner + $arr_partner;
		}
		?>
		<?php echo Form::select('partner_code', isset($customdata['partner_code']) ? $customdata['partner_code'] : '', $arr_partner, array('class' => 'form-control')); ?>
		<?php
		if ($is_diff_ss && isset($customdata['label_partner_code']))
		{
		?>
		<span class="edit-before edit-before-ss">
			<?php
				echo Model_Mpartner::find_by_pk($customdata['label_partner_code'])->branch_name;
			?>
		</span>
		<?php
		}
		?>
<?php
	}

	if($step >= 3)
	{
		/*Select SS*/
		if(isset($customdata) and $edit_ss_id = isset($customdata['edit_ss_id']) ? $customdata['edit_ss_id'] : array())
		{
			$arr_sss = array_column($edit_ss_id,'ss_name','ss_id');
			$arr_sss = $default_ss + $arr_sss;
		}
?>
<p></p>
	<?php echo Form::select('ss_id',isset($customdata['ss_id']) ? $customdata['ss_id'] : '',$arr_sss,array('class' => 'form-control')); ?>
		<?php
		if ($is_diff_ss && isset($customdata['label_ss_id']))
		{
			?>
			<span class="edit-before edit-before-ss">
			<?php
			echo Model_Mss::find_by_pk($customdata['label_ss_id'])->ss_name;
			?>
		</span>
		<?php
		}
		?>
<?php
	}

	if($step >= 4)
	{
		/*Select SSsale*/
		if(isset($customdata) and $edit_ss_sale = isset($customdata['edit_ss_sale']) ? $customdata['edit_ss_sale'] : array())
		{
			$arr_ss_sale = array();
			foreach($edit_ss_sale as $ss_sale)
			{
				if(isset($ss_sale['sale_type']) and $ss_sale['sale_type'])
					$sale_type = $ss_sale['sale_type'];
				else
					$sale_type = '';

				$arr_ss_sale[$ss_sale['sssale_id']] = Constants::$sale_type[$sale_type].' '.$ss_sale['sale_name'];
			}

			$arr_ss_sale = $default_ss_sale + $arr_ss_sale;
		}
?>
	<?php echo Form::select('sssale_id',isset($customdata['sssale_id']) ? $customdata['sssale_id'] : '',$arr_ss_sale,array('class' => 'form-control')); ?>
		<?php
		if ($is_diff_ss && isset($customdata['label_sssale_id']))
		{
			?>
			<span class="edit-before edit-before-ss">
			<?php
			echo Constants::$sale_type[Model_Sssale::find_by_pk($customdata['label_sssale_id'])->sale_type].' '.Model_Sssale::find_by_pk($customdata['label_sssale_id'])->sale_name;
			?>
		</span>
		<?php
		}
		?>
<?php
	}
?>
</div>

<script type="text/javascript">
    /*get type if type = 1 ss, type = 2 media*/
    var type = <?php echo $type; ?>
     /*Custom label*/
    var l_group = '<?php echo $l_group; ?>',
    l_partner = '<?php echo $l_partner; ?>',
    l_ss = '<?php echo $l_ss; ?>',
    l_sssale = '<?php echo $l_sssale; ?>';
    function addLabel(id,label)
    {
		$('#'+id).wrap( "<div class='input-group'></div>" );
		$('#'+id).before("<div class='input-group-addon label_sssale'>"+label+"</div>");
    }
	if(l_group != '')
	{
		addLabel('form_m_group_id',l_group);
	}
	if(l_partner != '')
	{
		addLabel('form_partner_code',l_partner);
	}
	if(l_ss != '')
	{
		addLabel('form_ss_id',l_ss);
	}
	if(l_sssale != '')
	{
		addLabel('form_sssale_id',l_sssale);
	}

</script>
<?php
	echo \Fuel\Core\Asset::js('module/presenter/group.js');
