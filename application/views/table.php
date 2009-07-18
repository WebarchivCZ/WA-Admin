<div class="top-bar"><a href="<?= url::site(url::current().'/add') ?>" class="button"><?= Kohana::lang('tables.add') ?></a>
    <h1><?= Kohana::lang('tables.'.$title) ?></h1>
    <div class="breadcrumbs"><a href="<?= url::base() ?>">Home</a> / <a href="<?= url::base().url::current() ?>"><?= Kohana::lang('tables.'.$title) ?></a></div>
</div>
<br />
<div class="select-bar">
    <form action="<?= url::base().url::current() ?>/search/" method="POST">
        <label> <input type="text" name="search_string" /> </label>
        <label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
    </form>
</div>
<div class="table">

    <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
    <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>


    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <?php
            array_push($headers, 'delete');
            echo display::display_headers($headers);
            ?>
        </tr>
        <?php
        foreach ($items as $item)
        {
            echo '<tr>';
            foreach ($columns as $column)
            {
                if ($column->foreign_key)
                {
                    $model = $column->name;
                    $value = $item->$model->__toString();
                    if ($column->isLink())
                    {
                        $id = $item->$model->id;
                        $controller = ORM::factory($model)->__get('table_name');
                        $url = url::site("tables/{$controller}/view/{$id}");
                        $value = "<a href='$url'>".$value."</a>";
                    }
                }
                elseif ($column->isLink())
                {
                    $url = url::site("tables/".$item->__get('table_name')."/view/{$item->id}");
                    $value = "<a href='$url'>{$item->__get($column->column)}</a>";
                }
                else
                {
                    $value = $item->__get($column->column);
                }
                echo "<td>$value</td>\n";
            }
            $delete_url = url::site(url::current().'/delete/'.$item->id);
            echo "<td><a href='{$delete_url}'>Smazat</a></td>";
            echo '</tr>';
}
?>
    </table>

<?= $pages ?>

</div>

