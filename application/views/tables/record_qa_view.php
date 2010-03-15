<?php if (isset($values)): ?>

<div class="table">

        <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
        <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>

    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first" width="60%">Sloupec</th>
            <th class="last">Hodnota</th>
        </tr>
            <?php foreach ($values as $key => $value):
                if ($key == 'url') {
                    $value = "<a href='{$value}' target='_blank'>{$value}</a>";
                }
                if ($key == 'email') {
                    $value = "<a href='mailto:{$value}'>{$value}</a>";
                }
                if ($key == 'result') {
                    $value = Qa_Check_Model::get_result_value($value);
                }
                ?>
        <tr>
            <td><?= ucfirst(Kohana::lang('tables.'.$key)) ?></td>
            <td><?= $value ?></td>
        </tr>

    <?php endforeach; ?>
            <?php
            $problems = ORM::factory('qa_problem')->find_all();
            foreach ($problems as $problem) {
                // pokud ma zdroj problem pak je odpoved NE (plyne z polozene otazky)
                $value = $record->has($problem);
                $value = ($value == TRUE) ? 'NE' : 'ANO';
                echo "<tr><td>{$problem->question}</td><td>{$value}</td></tr>";
            }
            ?>
    </table>
</div>

    <?php if (isset($append_view)) {
        $append_view->render(TRUE);
    }
    ?>

<?php endif; ?>

<p>
    <button onclick="history.back()" class="floatright">Zpět</button></p>