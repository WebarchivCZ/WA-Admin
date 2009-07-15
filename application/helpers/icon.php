<?php
class icon
{
	
	private static $icons = array('tick' => 'tick.png');
	
	private static $default_path = 'media/img/icons/';
	
	private static $extension = 'png';
	
	private static $width = '16';
	
	private static $height = '16';
	
	static function img($icon = NULL, $text = 'icon') {
		$src = self::$default_path . $icon . '.' . self::$extension;
		return html::image(array('src' => $src , 'width' => self::$width , 'height' => self::$height,
                                         'alt' => $text, 'title' => $text));
	}
}
?>