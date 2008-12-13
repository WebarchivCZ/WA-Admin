<?php
class Column_Item
{
	public $render = TRUE;
	public $foreign_key = '';
	public $name = '';
	public $column = '';
	public $link = FALSE;

	public function __construct($name, $column = '', $foreign_key = '', $render = TRUE)
	{
		$this->name = $name;
		if ($column == '')
		{
			$this->column = $name;
		}
		else
		{
			$this->column = $column;
		}
		$this->render = $render;
		$this->foreign_key = $foreign_key;
	}

	public function isLink() {
		return $this->link;
	}
	
	public function __toString()
	{
		return $this->name;
	}
}
?>