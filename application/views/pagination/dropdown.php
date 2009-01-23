<?php
/**
 * Dropdown pagination style
 * 
 * @preview  ‹ First  < 1 2 3 >  Last ›
 */
?>

<div class="select pagination"><strong>Další stránky: </strong> 
	<select OnChange="location.href=options[selectedIndex].value">
	<?php for ($i = 1; $i <= $total_pages; $i++) {
	if ($current_page == $i) {
		echo "<option value='?page=$i' selected='selected'>$i</option>";
	} else {
		echo "<option value='?page=$i'>$i</option>";	
	}
	}
	?>	
</select></div>