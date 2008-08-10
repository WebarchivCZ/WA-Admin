<ul id="top-navigation">
<?
$menu_items = Kohana::config('wadmin.top_menu');

foreach ($menu_items as $item)
{
	$item_title = Kohana::lang('menu.'.$item);
	$class = ucfirst(inflector::singular($item));
	
	if ($class == URI::segment(3))
	{
		echo "<li class='active'><span><span>$item_title</span></span></li>";
	}
	else
	{
		$base = url::base();
		$controller = $base.'table/view/'.$class;
		echo '<li><span><span><a href="'.$controller.'">'.$item_title.'</a></span></span></li>';
	}
}
?>
</ul>