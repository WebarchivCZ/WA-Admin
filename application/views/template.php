<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>WA Admin - <?= $title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<?=media::stylesheet(array('main'))?>

</head>
<body>
<div id="main">
	<div id="header">
		<h1>
		<a href="<?= url::site() ?>" class="logo">
		WA Admin v2
		<?php //<img src="img/logo.gif" width="101" height="29" alt="" /> ?>
		</a>
		</h1>

		<ul id="top-navigation">
			<li class="active"><span><span>Hlavní stránka</span></span></li>
			<li><span><span><a href="<?= url::base(); ?>tables/resources">Zdroje</a></span></span></li>
			<li><span><span><a href="<?= url::base(); ?>tables/contracts">Smlouvy</a></span></span></li>
			<li><span><span><a href="<?= url::base(); ?>tables/publishers">Vydavatelé</a></span></span></li>
			<li><span><span><a href="<?= url::base(); ?>tables/contacts">Kontakty</a></span></span></li>
		</ul>
	</div>
	<div id="middle">
		<div id="left-column">
		<?= $nav; ?>
			
		</div>
		<div id="center-column">
			<?= $content; ?>			
		</div>
		<div id="right-column">
			<strong class="h">INFO</strong>
			<div class="box" id="help-box">Detect and eliminate viruses and Trojan horses, even new and unknown ones. Detect and eliminate viruses and Trojan horses, even new and </div>
	  </div>
	</div>
	<div id="footer"></div>

</div>

</body>
</html>
