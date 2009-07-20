<div id="right-column"><strong class="h">Informace</strong>
    <div class="box" id="help-box">
        <p><?= date('H:i - d.m.Y'); ?></p>
        <?php if (Auth::instance()->logged_in())
        { ?>
        <p>přihlášen: <?= Auth::instance()->get_user()->username ?><br /></p>
        <p><a href="<?= url::current() ?>/logout">Odhlásit</a></p>
        <? } else
        {
            echo '<p>Nepřihlášen</p>';
        }
        ?>
    </div>
    <strong class="h">VÝVOJ</strong>
    <div class="box">
        <p><a href="<?= Kohana::config('wadmin.ticket_url') ?>" target="_blank">Vytvořit ticket</a></p>
        <p>WA Admin v<?= Kohana::config('wadmin.version') ?></p>
        <p><a href="http://raptor.webarchiv.cz:8000/trac/milestone/WA%20Admin%20v2.02" target="_blank">Stav nové verze</a></p>
    </div>
</div>