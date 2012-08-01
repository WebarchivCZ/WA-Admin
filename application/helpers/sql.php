<?php
/**
 * This is just helper class for sql shortcuts.
 */
class sql {
	/**
	 * Retrieve first result by execution of sql on database
	 * @static
	 * @param $sql
	 * @return bool|mixed first result
	 */
	public static function get_first_result($sql)
	{
		return Database::instance()->query($sql)->current();
	}

	/**
	 * Retrieve result by execution of sql on database
	 * @static
	 * @param $sql
	 * @return Database_Result
	 */
	public static function get_result($sql)
	{
		return Database::instance()->query($sql)->result();
	}

	/**
	 * Return array of IDs (column id or column defined via parameter)
	 * returned by sql result.
	 * @static
	 * @param $sql
	 * @param string $id_column
	 * @return array|int
	 */
	public static function get_id_array($sql, $id_column = 'id')
	{
		$result = sql::get_result($sql);
		$id_array = array();
		foreach ($result->result_array(FALSE) as $row)
		{
			array_push($id_array, $row["${id_column}"]);
		}
		return $id_array;
	}
}
