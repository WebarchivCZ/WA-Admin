<?php
abstract class Table_Model extends ORM
{

	public $headers;

	protected $default_column;

	public function table_columns ()
	{
		$columns = array();
		foreach ($this->headers as $header) {
			if (in_array($header, $this->belongs_to)) {
				$column = new Column_Item($header, $header . '_id', TRUE);
				$column->link = TRUE;
			} else {
				$column = new Column_Item($header);
			}
			array_push($columns, $column);
		}
		return $columns;
	}

	public function __toString ()
	{
		return $this->{$this->default_column};
	}

	public function get_default ()
	{
		return $default_column;
	}

	public function set_default ($value)
	{
		$default_column = $value;
	}

	public function is_related ($column)
	{
		return (boolean) in_array($column, $belongs_to);
	}

	public function find_insert ($value)
	{
		$column = $this->default_column;
		$model = ORM::factory($this->object_name)->where($column, $value)->find();
		
		if (empty($model->{$column})) {
			$model->{$column} = $value;
			return $model->save();			
		} else {
			return $model;
		}
	}
}
?>