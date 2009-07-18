<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>WA Admin - <?=$title;?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <?php
        echo html::stylesheet('media/css/formo');
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
                    <?php
                    /**
                     * pokud je radic jeden z hlavnich, zobrazi se automaticky
                     * vyhledavaci box, nadpis a pripadne chybova hlaska
                     * viz view layout/top_content
                     */
                    $top_menu = Kohana::config('wadmin.top_menu');
                    if (in_array(URI::$controller, $top_menu)) {
                        if (isset($this->page_header) AND $this->page_header != "")
                        {
                            $title = $this->page_header;
                        } else
                        {
                            $title = $this->title;
                        }
                        View::factory('layout/top_content')->set('title', $title)->render(TRUE);
                    }
                    ?>
                    
                    <?=$content;?>
                </div>
                <div id="right-column"><strong class="h">INFO</strong>
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
                </div>
            </div>
<?=$footer ?>
        </div>

    </body>
</html>
