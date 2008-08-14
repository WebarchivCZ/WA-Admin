<ul id="top-navigation">
<?
$menu_items = Kohana::config('wadmin.top_menu');

foreach ($menu_items as $item)
{
	$item_title = Kohana::lang('menu.'.$item);
	
	if ($item == URI::controller(FALSE))
	{
		echo "<li class='active'><span><span>$item_title</span></span></li>";
	}
	else
	{
		$base = url::base();
		echo '<li><span><span><a href="'.url::base().$item.'">'.$item_title.'</a></span></span></li>';
	}
}
?>
</ul>