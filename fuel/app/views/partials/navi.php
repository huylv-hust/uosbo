<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div id="login-bar">
		<?php if($login_info = \Fuel\Core\Session::get('login_info')) { ?>
		<span class="glyphicon glyphicon-user"></span>
		<?php echo htmlspecialchars($login_info['name']) ?>さん

		<?php } else { ?>
		　
		<?php } ?>
	</div>
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo Uri::base(); ?>">UOS求人システム</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<?php if($login_info['division_type'] != 4) { ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">マスタ管理
							<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="<?php echo Utility::view_menu_role('groups'); ?>"><a
									href="<?php echo Uri::base(); ?>master/groups">取引先グループ</a></li>
							<li class="<?php echo Utility::view_menu_role('partners'); ?>"><a
									href="<?php echo Uri::base(); ?>master/partners">取引先</a></li>
							<li class="<?php echo Utility::view_menu_role('sslist'); ?>"><a
									href="<?php echo Uri::base(); ?>master/sslist">SS</a></li>
							<li class="<?php echo Utility::view_menu_role('medias'); ?>"><a
									href="<?php echo Uri::base(); ?>master/medias">媒体</a></li>
							<li class="<?php echo Utility::view_menu_role('users'); ?>"><a
									href="<?php echo Uri::base(); ?>master/users">ログインアカウント</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">求人管理
							<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="<?php echo Utility::view_menu_role('jobs'); ?>"><a
									href="<?php echo Uri::base(); ?>job/jobs">求人情報</a></li>
							<li class="<?php echo Utility::view_menu_role('jobup'); ?>"><a
									href="<?php echo Uri::base(); ?>job/jobup">求人アップロード</a></li>
							<li class="<?php echo Utility::view_menu_role('persons'); ?>"><a
									href="<?php echo Uri::base(); ?>job/persons">応募者</a></li>
							<li class="<?php echo Utility::view_menu_role('orders'); ?>"><a
									href="<?php echo Uri::base(); ?>job/orders">オーダー</a></li>
							<li class="<?php echo Utility::view_menu_role('plan'); ?>"><a
									href="<?php echo Uri::base(); ?>job/plan">予算</a></li>
							<li class="<?php echo Utility::view_menu_role('result'); ?>"><a
									href="<?php echo Uri::base(); ?>job/result">応募実績</a></li>
						</ul>
					</li>
					<?php
					if (!\Fuel\Core\Session::get('login_info') || (\Fuel\Core\Session::get('login_info') && (Utility::view_menu_role('contacts') != 'hide' || Utility::view_menu_role('concierges') != 'hide'))) {
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
							   aria-expanded="false">サポート <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li class="<?php echo Utility::view_menu_role('contacts'); ?>"><a
										href="<?php echo Uri::base(); ?>support/contacts">お問い合わせ</a></li>
								<li class="<?php echo Utility::view_menu_role('concierges'); ?>"><a
										href="<?php echo Uri::base(); ?>support/concierges">コンシェルジュ</a></li>
							</ul>
						</li>
			<?php
					}
				}
					?>
				<?php if($login_info['division_type'] == 1 || $login_info['division_type'] == 4) {?>
				<li class="dropdown">
					<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">OBIC7<span class="caret"></span></a>
					<ul role="menu" class="dropdown-menu">
						<li><a href="<?php echo Uri::base(); ?>obic7/persons">採用者リスト</a></li>
						<li><a href="<?php echo Uri::base(); ?>obic7/office">事業所名変換設定</a></li>
						<li><a href="<?php echo Uri::base(); ?>obic7/workplace">所属名変換設定</a></li>

					</ul>
				</li>
				<?php } ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?php echo Uri::base(); ?>login/logout">
						<i class="glyphicon glyphicon-log-out"></i>
						ログアウト</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
