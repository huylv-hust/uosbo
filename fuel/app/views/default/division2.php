<div class="container">
	<h3>TOP</h3>
	<div class="panel panel-primary">
		<div class="panel-heading">承認待ち件数</div>
		<div class="panel-body">

			<div role="group" class="btn-group btn-group-justified">
				<div role="group" class="btn-group">
					<a href="<?php echo $link_partner;?>" class="btn btn-info">
						取引先
						<span class="badge"><?php echo $count_partner;?></span>
					</a>
				</div>
				<div role="group" class="btn-group">
					<a href="<?php echo $link_ss;?>" class="btn btn-success">
						SS
						<span class="badge"><?php echo $count_ss;?></span>
					</a>
				</div>
				<div role="group" class="btn-group">
					<a href="<?php echo $link_job; ?>" class="btn btn-warning">
						求人情報
						<span class="badge"><?php echo $count_job;?></span>
					</a>
				</div>
				<div role="group" class="btn-group">
					<a href="<?php echo $link_order?>" class="btn btn-danger">
						オーダー
						<span class="badge"><?php echo $count_order;?></span>
					</a>
				</div>
				<div role="group" class="btn-group">
					<a href="<?php echo $link_person;?>" class="btn btn-primary">
						応募者
						<span class="badge"><?php echo $person_inactive;?></span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">担当者別ステータス（未処理件数一覧）</div>
		<div class="panel-body">

			<nav>
				<?php echo html_entity_decode($pagination);?>
			</nav>

			<table class="table table-bordered table-striped">
				<tbody><tr>
					<th class="text-center">担当者氏名</th>
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


				<?php foreach($list_user as $user) {
					//$check = (int)isset($count['user_id']['contact_result']) + (int)isset($count['user_id']['review_date']) + (int)isset($count['user_id']['review_result']) + (int)isset($count['user_id']['contract_date']) + (int)isset($count['user_id']['contract_result']) + (int)isset($count['user_id']['hire_date']) + (int)isset($count['user_id']['employee_code']) + (int)isset($count['user_id']['work_confirmation']);
					//if($check == 0)	continue;
				?>
				<tr>
					<td><?php echo $user->name; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['contact_result']) ? $count[$user->user_id]['contact_result'] : 0; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['review_date']) ? $count[$user->user_id]['review_date'] : 0; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['review_result']) ? $count[$user->user_id]['review_result'] : 0; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['adoption_result']) ? $count[$user->user_id]['adoption_result'] : 0; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['contract_date']) ? $count[$user->user_id]['contract_date'] : 0; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['contract_result']) ? $count[$user->user_id]['contract_result'] : 0; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['hire_date']) ? $count[$user->user_id]['hire_date'] : 0; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['employee_code']) ? $count[$user->user_id]['employee_code'] : 0; ?></td>
					<td class="text-right"><?php echo isset($count[$user->user_id]['work_confirmation']) ? $count[$user->user_id]['work_confirmation'] : 0; ?></td>
				</tr>
				<?php }?>
				</tbody></table>

			<p class="text-info">
				※担当者の並びはシステム登録順
			</p>

		</div>
	</div>


</div>