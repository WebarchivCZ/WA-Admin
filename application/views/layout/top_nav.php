<ul id="top-navigation">
	<?
	$menu_items = Kohana::config('wadmin.top_menu');

	foreach ($menu_items as $item)
	{
		$item_title = Kohana::lang('menu.'.$item);
		$href = url::base().$item;
		if ($item == URI::controller(FALSE))
		{
			echo "<li class='active'><span><span><a href='$href'>$item_title</a></span></span></li>";
		}
		else
		{
			$base = url::base();
			echo "<li><span><span><a href='$href'>$item_title</a></span></span></li>";
		}
	}
	?>
</ul>