<div class="container">
		<h3>TOP</h3>
		<div class="panel panel-primary">
		<div class="panel-heading">担当応募者の未対応リスト</div>
		<div class="panel-body">
			<table class="table table-bordered table-striped">
				<tbody><tr>
					<th class="text-center">応募者氏名</th>
					<th class="text-center">応募日</th>
					<th class="text-center">対象SS</th>
					<th class="text-center">連絡結果</th>
					<th class="text-center">面接日</th>
					<th class="text-center">面接結果</th>
					<th class="text-center">採否結果</th>
					<th class="text-center">契約締結日</th>
					<th class="text-center">契約結果</th>
					<th class="text-center">入社日</th>
					<th class="text-center">社員コード</th>
					<th class="text-center">勤務確認</th>
				</tr>
				<?php
				function show_data($row,$list_emp)
				{

					$check = true;
					if ( ! isset($list_emp[$row['person_id']]) || ! $list_emp[$row['person_id']]['contact_result'])
					{
						$check = false;
						$data['contact_result'] = '<span class="label label-danger">×</span>';
					}
					else
						$data['contact_result'] = '<span class="label label-success">○</span>';

					if ( ! isset($list_emp[$row['person_id']]) || ! $list_emp[$row['person_id']]['review_date'] )
					{
						$check = false;
						$data['review_date'] = '<span class="label label-danger">×</span>';
					}
					else
						$data['review_date'] = '<span class="label label-success">○</span>';

					if ( ! isset($list_emp[$row['person_id']]) || ! $list_emp[$row['person_id']]['review_result'] )
					{
						$check = false;
						$data['review_result'] = '<span class="label label-danger">×</span>';
					}
					else
						$data['review_result'] = '<span class="label label-success">○</span>';

					if (! isset($list_emp[$row['person_id']]) || ! $list_emp[$row['person_id']]['adoption_result'] )
					{
						$check = false;
						$data['adoption_result'] = '<span class="label label-danger">×</span>';
					}
					else
						$data['adoption_result'] = '<span class="label label-success">○</span>';

					if ( ! isset($list_emp[$row['person_id']]) || ! $list_emp[$row['person_id']]['contract_date'] )
					{
						$check = false;
						$data['contract_date'] = '<span class="label label-danger">×</span>';
					}
					else
						$data['contract_date'] = '<span class="label label-success">○</span>';

					if ( ! isset($list_emp[$row['person_id']]) || ! $list_emp[$row['person_id']]['contract_result'] )
					{
						$check = false;
						$data['contract_result'] = '<span class="label label-danger">×</span>';
					}
					else
						$data['contract_result'] = '<span class="label label-success">○</span>';

					if (! isset($list_emp[$row['person_id']]) || ! $list_emp[$row['person_id']]['hire_date'] )
					{
						$check = false;
						$data['hire_date'] = '<span class="label label-danger">×</span>';
					}
					else
						$data['hire_date'] = '<span class="label label-success">○</span>';

					if ( ! isset($list_emp[$row['person_id']]) ||! $list_emp[$row['person_id']]['employee_code'] )
					{
						$check = false;
						$data['employee_code'] = '<span class="label label-danger">×</span>';
					}
					else
						$data['employee_code'] = '<span class="label label-success">○</span>';

					if ( ! isset($list_emp[$row['person_id']]) || ! $list_emp[$row['person_id']]['work_confirmation'] )
					{
						$data['work_confirmation'] = '<span class="label label-danger">×</span>';
						$check = false;
					}
					else
						$data['work_confirmation'] = '<span class="label label-success">○</span>';

					if($check)
						return true;

					return $data;

				}
				foreach($person_list as $row){
					$data = show_data($row,$employment_list);
					if($data === true) continue;
				?>
				<tr>
					<td><a href="<?php echo \Fuel\Core\Uri::base()?>job/employment?person_id=<?php echo $row['person_id']?>"><?php echo strlen($row['name']) ? $row['name'] : $row['name_kana'] ?></a></td>
					<td><?php echo $row['application_date']?></td>
					<td><?php echo isset($sssale_list[$row['sssale_id']]) ? $sssale_list[$row['sssale_id']] : ''; ?></td>
					<td class="text-center">
						<?php echo $data['contact_result'] ?>
					</td>
					<td class="text-center">
						<?php echo $data['review_date'] ?>
					</td>
					<td class="text-center">
						<?php echo $data['review_result'] ?>
					</td>
					<td class="text-center">
						<?php echo $data['adoption_result'] ?>
					</td>
					<td class="text-center">
						<?php echo $data['contract_date'] ?>
					</td>
					<td class="text-center">
						<?php echo $data['contract_result'] ?>
					</td>
					<td class="text-center">
						<?php echo $data['hire_date'] ?>
					</td>
					<td class="text-center">
						<?php echo $data['employee_code'] ?>
					</td>
					<td class="text-center">
						<?php echo $data['work_confirmation'] ?>
					</td>
				</tr>
				<?php } ?>
				</tbody></table>
			<!--
			<div>
				<a class="btn btn-info btn-sm" href="job/persons">担当応募者リスト</a>
			</div>
			-->

		</div>
	</div>
</div>
