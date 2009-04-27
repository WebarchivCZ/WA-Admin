<div id="footer">

</div>
<?php
if (Kohana::config('config.debug_mode') AND !empty ($this->log)) {
	echo "<div id='debug'>$this->log</div>";
}
?>