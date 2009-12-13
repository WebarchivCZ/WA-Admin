<?php
class table {

	public static function header() {
		$header = '<div class="table">' .
    				html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left')) .
    				html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right')) .
    				'<table class="listing" cellpadding="0" cellspacing="0">';
    	return $header;
	}
	
	public static function footer() {
		$footer = '    </table>
				   </div>';
		return $footer; 
	}
}
?>