<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title; ?></title>
		<link href="http://fuelphp.com/addons/shared_addons/themes/fuel/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <?php echo \View::forge('partials/head'); ?>
    </head>
    <body>
		<?php echo \View::forge('partials/navi'); ?>
		<div class="container">
			<?php echo $content; ?>
        </div>
        <?php echo \View::forge('partials/footer'); ?>
    </body>
</html>
