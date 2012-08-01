<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Model representing Publishers
 * available attributes
 * - id
 * - name
 */

class Publisher_Model extends Table_Model {
	public $headers = array('name');
	protected $primary_val = 'name';
	protected $sorting = array('name' => 'asc');
	protected $has_many = array('contact', 'resource');

	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	public function __get($column)
	{
		if ($column == 'short_name')
		{
			$value = parent::__get('name');
			$length = Kohana::config('wadmin.title_length');
			return text::limit_chars($value, $length, '');
		}
		$value = parent::__get($column);
		return $value;
	}

	public function delete_record()
	{
		$resources = $this->get_resources();
		foreach ($resources as $resource)
		{
			$resource->publisher_id = NULL;
			$resource->save();
		}
		$this->delete();
	}

	//TODO opravit prazdny nazev vydavatele


	/**
	 * Zjisti, jestli ma vydavatel jiz podepsanou smlouvu
	 * @return bool TRUE, pokud vydavatel ma jiz sepsanou nejakou smlouvu
	 */
	public function has_contract()
	{
		$sql = "SELECT COUNT(c.id) as 'contract_count' FROM contracts c, resources r WHERE
                                   r.publisher_id = {$this->id} AND
                                   r.contract_id = c.id";

		$contract_count = sql::get_first_result($sql)->contract_count;
		if ($contract_count > 0)
		{
			return TRUE;
		} else
		{
			return FALSE;
		}
	}

	/**
	 * Vraci vsechny smlouvy, ktere ma vydavatel podepsane
	 * @return ORM_Iterator smlouvy
	 */
	public function get_contracts()
	{
		$contracts = ORM::factory('contract')
			->select('DISTINCT contracts.id')
			->join('resources', 'resources.contract_id', 'contracts.id')
			->where('resources.publisher_id', $this->id)
			->find_all();
		return $contracts;
	}

	/**
	 * Vraci vsechny zdroje, ktere patri k danemu vydavateli
	 * @return Resource_Model zdroje nalezici danemu vydavateli
	 */
	public function get_resources()
	{
		$resources = ORM::factory('resource')->where('publisher_id', $this->id)->find_all();
		return $resources;
	}

	/**
	 * Funkce zjistuje, zda ma vydavatel vice zdroju k osloveni,
	 * aby mohli byt osloveni najednou a ne po castech
	 * @return bool TRUE pokud ma vydavatel vice zdroju k osloveni
	 */
	public function has_many_to_address()
	{
		// stavy schvalen wa a osloven v zavorkach, pouziti v SQL IN
		$statuses = RS_NEW.','.RS_APPROVED_WA;
		$sql = "SELECT r.id FROM publishers p, resources r
                            WHERE p.id = r.publisher_id AND
                                  p.id = {$this->id} AND
                                  r.resource_status_id IN ({$statuses})";
		$query = $this->db->query($sql);
		return $query->count() > 1 ? TRUE : FALSE;
	}
}

?>