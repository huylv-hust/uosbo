<?php
	$person = Model_Person::find($person_id);
?>

<div class="panel panel-default">
	<div class="panel-heading">応募者</div>
	<div class="panel-body">
		<table class="table table-striped">
			<tr>
				<th class="text-right">氏名</th>
				<td><?php echo isset($person->name) ? $person->name : '' ?></td>
				<th class="text-right">生年月日</th>
				<td>
					<?php
						echo isset($person->birthday) ? date('Y/n/j',strtotime($person->birthday)) : '';
					?>
					(応募時の年齢:
					<?php
					if(isset($person->birthday) and isset($person->application_date))
					{
						$from = new DateTime($person->birthday);
						$to = new DateTime($person->application_date);
						echo floor((strtotime($person->application_date)-strtotime($person->birthday))/31536000);
					}
					else
						echo 'Unknown';
					?>才)
				</td>
			</tr>
			<tr>
				<th class="text-right">住所</th>
				<td>
					<?php
						echo isset($person->addr1) ? Constants::$address_1[$person->addr1] : '';
					?>
					<br>
					<?php
						echo isset($person->addr2) ? $person->addr2 : '';
						echo '&nbsp;';
						echo isset($person->addr3) ? $person->addr3 : '';
					?>
				</td>
				<th class="text-right">電話番号</th>
				<td>
					<div>
					<?php
					if(isset($person->mobile) and $person->mobile != null)
						echo '(携帯)'.$person->mobile;
					?>
					</div>
					<div>
						<?php
						if(isset($person->tel) and $person->tel != null)
							echo '(固定)'.$person->tel;
						?>
					</div>
				</td>
			</tr>
			<tr>
				<th class="text-right">対象SS</th>
				<td colspan="3">
					<?php
						if(isset($person->sssale_id))
						{
							$ss_id = Model_Sssale::find_by_pk($person->sssale_id)->ss_id;
							$partner_code = Model_Mss::find_by_pk($ss_id)->	partner_code;
							$m_group_id = Model_Mpartner::find_by_pk($partner_code)->m_group_id;

							$group_name = Model_Mgroups::find_by_pk($m_group_id)->name;
							$partner_name = Model_Mpartner::find_by_pk($partner_code)->branch_name;
							$ss_name = Model_Mss::find_by_pk($ss_id)->ss_name;
							$sssale_name = Model_Sssale::find_by_pk($person->sssale_id)->sale_name;

							echo $group_name.$partner_name.$ss_name.$sssale_name;
						}
					?>
				</td>
			</tr>
		</table>
	</div>
</div>