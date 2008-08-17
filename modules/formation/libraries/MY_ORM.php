<?php
 
class ORM extends ORM_Core {

	// Database field rules
	protected $validate=array();


  /**
	 * Finds the many<>many relationship table. 
	 *
	 * This override updates the handling of the join table name 
	 * to be alphabetically based for has_and_belongs_to_many relationships.
	 *
	 * @param   string  table name
	 * @return  string
	 */
	protected function related_table($table)
	{
		if (in_array($table, $this->has_and_belongs_to_many))
		{
		  return (strcasecmp($this->table, $table) <= 0) ? $this->table.'_'.$table : $table.'_'.$this->table;
		} else {
		  return parent::related_table($table);
		}
	}
	/**
	 * Load array of values into ORM object
	 *
	 * @param array $data
	 */
	public function load_values(array $data)
	{
		foreach ($data as $field=>$value)
		{
			if(array_key_exists($field,self::$fields[$this->table]))
			{
				$this->$field=$value;
			}
		}

	}	
	/** 
	 * Retrieve field_data from ORM
	 */
	public function list_fields()
	{
		return self::$fields[$this->table];	
	}

	/**
	 * Get validation rules from ORM
	 */
	public function get_validate()
	{
		return $this->validate;
	}
	/**
	 * Simple exists method to see if model exists
	 *
	 * @return boolean
	 */
	public function exists()
	{
		return $this->object->id > 0;
	}
	/**
	* Retrieve relationships of a model
	* 
	* @return array
	*/
	public function get_relationships()
	{
		return array(
			'has_one'=>$this->has_one,
			'has_many'=>$this->has_many,
			'belongs_to'=>$this->belongs_to,
			'belongs_to_many'=>$this->belongs_to_many,
			'has_and_belongs_to_many'=>$this->has_and_belongs_to_many,		
		);
	}	
}