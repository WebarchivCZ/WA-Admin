<?php
abstract class Table_Model extends ORM {
	
	public $headers;
	
	protected $default_column;
	
	public function table_columns()
	{
		$columns = array();
		foreach ($this->headers as $header)
		{
			if (in_array($header, $this->belongs_to))
			{
				$column = new Column_Item($header, $header . '_id', TRUE);
				$column->link = TRUE;
			}
			else
			{
				$column = new Column_Item($header);
			}
			array_push($columns, $column);
		}
		return $columns;
	}
	
	public function __toString() {
		return $this->{$this->default_column};
	}
}
?>