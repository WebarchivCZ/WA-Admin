<?php if (isset($values)): ?>

<?php echo table::header(); ?>
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
    <?php
    
    endforeach;
            
	echo table::footer(); 

	echo "<h3>Problémy</h3>";
	
	$problems = $qa_check->qa_check_problems;
	
	foreach ($problems as $problem) {
		
		$urls = split(' ', $problem->url);
		
		echo "<div class='problem'>";
		echo "<p><strong>{$problem->qa_problem->question}?</strong></p>";
		echo "<p>{$problem->comments}</p>";
		if (count($urls) > 0) {
    		echo "<ul>";
    		foreach ($urls as $url){
    			if (! empty($url))
    			echo "<li>". html::anchor($url, $url, array('target'=>'_blank')) ."</li>";
    		}
    		echo "</ul>";
		}
		echo "</div>";
	}
	

endif; ?>

<p>
    <button onclick="history.back()" class="floatright">Zpět</button></p>