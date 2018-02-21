<div class="container">

	<h3>TOP</h3>

	<div class="panel panel-primary">
		<div class="panel-heading">承認待ち件数</div>
		<div class="panel-body">

			<div class="btn-group btn-group-justified" role="group">
				<div class="btn-group" role="group">
					<a class="btn btn-info" href="<?php echo Uri::base()?>master/partners?type=&addr1=&partner_code=&keyword=&status=1&action_partner_code=">
						取引先
						<span class="badge"><?php echo $m_partner ?></span>
					</a>
				</div>
				<div class="btn-group" role="group">
					<a class="btn btn-success" href="<?php echo Uri::base()?>master/sslist?ss_id=&addr1=&base_code=&keyword=&status=0">
						SS
						<span class="badge"><?php echo $m_ss ?></span>
					</a>
				</div>
				<div class="btn-group" role="group">
					<a class="btn btn-warning" href="<?php echo Uri::base()?>job/jobs?address_1=&address_2=&partner_search=&ss_search=&start_date=&end_date=&media_search=&status=0">
						求人情報
						<span class="badge"><?php echo $job ?></span>
					</a>
				</div>
				<div class="btn-group" role="group">
					<a class="btn btn-danger" href="<?php echo Uri::base()?>job/orders?addr1=&maddr2=&partner=&ssid=&apply_date=&post_date=&department=&user_id=&media_id=&unapproved=0&flag=1&image=&image=&image=&image=&image=&image=&image=&image=&image=&image=">
						オーダー
						<span class="badge"><?php echo $or ?></span>
					</a>
				</div>
				<div role="group" class="btn-group">
					<a href="<?php echo \Fuel\Core\Uri::base()?>job/persons?person_id=&person_status=&from_date=&to_date=&addr1=&addr2=&email=&name=&phone=&media_name=&group_id=&partner_code=&ss_id=&department=&user_id=&sale_type=&status=0&age_from=&age_to=" class="btn btn-primary">
						応募者
						<span class="badge"><?php echo $person_inactive;?></span>
					</a>
				</div>
			</div>
		</div>
	</div>

</div>