<div id="right-column">
	<?php if ($help_box)
{
	?>
    <strong class="h help">NÁPOVĚDA</strong>
    <div class="box help">
        <p><?= $help_box ?></p>
    </div>
	<? } ?>

    <strong class="h">Informace</strong>

    <div class="box">
		<?php
		if (app::in_debug_mode())
		{
			echo "<p></p><b>TESTOVACÍ VERZE</b><br/>";
			echo 'DB: '.Kohana::config("database.default.connection.database").'</p>';
		}
		?>
        <p><?= date('H:i - d.m.Y'); ?></p>
		<?php if (Auth::instance()->logged_in())
	{
		?>
        <p>přihlášen: <?= Auth::instance()->get_user()->username ?><br/></p>
        <p><a href="<?= url::site('home') ?>/logout">Odhlásit</a></p>
		<?
	} else
	{
		echo '<p>Nepřihlášen</p>';
	} ?>
    </div>

    <strong class="h">VÝVOJ</strong>

    <div class="box">
        <p><a href="<?= Kohana::config('wadmin.ticket_url') ?>" target="_blank">Vytvořit ticket</a></p>

        <p>WA Admin <?= app::get_full_version() ?></p>

        <p><a href="https://github.com/WebArchivCZ/WA-Admin/commits/master" target="_blank">Poslední změny</a></p>
    </div>
    <strong class="h"><a href="<?= url::site('tools') ?>">Nástroje</a></strong>

    <div class="box">
        <p><?= html::anchor(url::site('/tables/seeds/generate_list'), 'Semínkáč')?></p>

        <p><?= html::anchor(url::site('/tools'), 'Generátor metadat')?></p>
    </div>
</div>