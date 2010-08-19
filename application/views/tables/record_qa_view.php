<?php
if (isset ( $values )) {
    $resource = $values ['resource'];
    ?>

<?php
    echo table::header ();
    ?>
<tr>
	<th class="first" width="60%">Sloupec</th>
	<th class="last">Hodnota</th>
</tr>
<?php
    foreach ( $values as $key => $value ) {
        switch ($key) {
        	case 'id':
        		break;
            case 'url' :
                $value = "<a href='{$value}' target='_blank'>{$value}</a>";
                break;
            case 'solution_date':
            	$value = date_helper::short_date($value);
            	break;
            case 'resource' :
                $url = url::site ( '/tables/resources/view/' . $resource->id );
                $value = "<a href='{$url}'>{$resource->title}</a>";
                break;
            case 'solution_user':
            	$value = ORM::factory('curator', $value)->lastname; 
            	break;
            case 'email' :
                $value = "<a href='mailto:{$value}'>{$value}</a>";
            case 'result' :
                $value = Qa_Check_Model::get_result_value ( $value );
                break;
            case 'solution' :
                $value = Qa_Check_Model::get_solution_value ( $value );
                break;
        }
        ?>
<tr>
	<td><?=ucfirst ( Kohana::lang ( 'tables.' . $key ) )?></td>
	<td><?=$value?></td>
</tr>
<?php
    
    }
    
    echo table::footer ();
    
    $url = Kohana::config ( 'wadmin.wayback_url' ) . $resource->url;
    
    echo "<p><a href='{$url}' target='_blank'><button>Odkaz do waybacku</button></a></p>";
    
    echo "<h3>Problémy</h3>";
    
    $problems = $qa_check->qa_check_problems;
    
    foreach ( $problems as $problem ) {
        
        $urls = explode ( ' ', $problem->url );
        
        echo "<div class='problem'>";
        echo "<p><strong>{$problem->qa_problem->question}?</strong></p>";
        echo "<p>{$problem->comments}</p>";
        if (count ( $urls ) > 0) {
            echo "<ul>";
            foreach ( $urls as $url ) {
                if (! empty ( $url ))
                    echo "<li>" . html::anchor ( $url, $url, array ('target' => '_blank' ) ) . "</li>";
            }
            echo "</ul>";
        }
        echo "</div>";
    }

}
?>
<p><a href="<?=url::site ( 'quality_control/edit/' . $qa_check->id )?>">
<button>Editace záznamu</button>
</a>
<button onclick="history.back()" class="floatright">Zpět</button>
</p>
<?php /*
<p>
<a href="<?= url::site('quality_control/add_solution/'.$qa_check->id) ?>"><button>Přidat řešení</button></a>
</p>
 *
 */?>