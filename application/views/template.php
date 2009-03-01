<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>WA Admin - <?=$title;?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<?php
	echo html::stylesheet('media/css/main');
	echo html::script('media/js/jquery.js');
	echo html::script('media/js/wadmin.js');
	?>
</head>
<body>
<div id="main">
<div id="header">
<h1><a href="<?=url::site()?>" class="logo">		
		<img src="<?= url::base() ?>media/img/logo.png" width="317" height="90" alt="" />
		</a></h1>
		<?=$top_nav;?>
	</div>
<div id="middle">
<div id="left-column">
		<?=$left_nav;?>
			
		</div>
<div id="center-column">
			<?=$content;?>
		</div>
<div id="right-column"><strong class="h">INFO</strong>
<div class="box" id="help-box">
<p><?= date('h:i - d.m.Y'); ?></p>
<p>přihlášen: <?= Auth::instance()->get_user()->username ?><br /></p>
<p><a href="<?= url::base() ?>login/logout">Odhlásit</a></p>
</div>
</div>
</div>
<div id="footer"></div>

</div>

</body>
</html>
