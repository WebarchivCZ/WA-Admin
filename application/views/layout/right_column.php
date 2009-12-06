<div id="right-column">
    <?php if ($help_box) { ?>
    <strong class="h help">NÁPOVĚDA</strong>
    <div class="box help">
        <p><?= $help_box ?></p>
    </div>
    <? } ?>
    
    <strong class="h">Informace</strong>
    <div class="box">
        <p><?= date('H:i - d.m.Y'); ?></p>
        <?php if (Auth::instance()->logged_in()) { ?>
        <p>přihlášen: <?= Auth::instance()->get_user()->username ?><br /></p>
        <p><a href="<?= url::site('home') ?>/logout">Odhlásit</a></p>
        <? } else {
            echo '<p>Nepřihlášen</p>';
        } ?>
    </div>
    
    <strong class="h">VÝVOJ</strong>
    <div class="box">
        <p><a href="<?= Kohana::config('wadmin.ticket_url') ?>" target="_blank">Vytvořit ticket</a></p>
        <p>WA Admin <?= Kohana::config('wadmin.version') ?>.<?= Kohana::config('wadmin.build') ?></p>
        <p><a href="http://raptor.webarchiv.cz:8000/trac/milestone/WA%20Admin%20v2.2" target="_blank">Stav nové verze</a></p>
    </div>
</div>