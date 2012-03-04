<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Contact_Model extends Table_Model
{
    public $headers = array(
        'publisher',
        'email',
        'name'
    );

    public $formo_ignores = array('publisher_id');

    protected $primary_val = 'email';
    protected $sorting = array('name' => 'asc');

    protected $belongs_to = array(
        'publisher');

    protected $has_many = array(
        'resources');

    public function __set($key, $value)
    {
        if ($key === 'name') {
            // Ensure the name is formatted correctly
            $value = ucwords(strtolower($value));
        }
        parent::__set($key, $value);
    }

    public function table_view($per_page, $offset)
    {
        return $this->join('publishers', 'contacts.publisher_id = publishers.id')
            ->orderby('publishers.name')
            ->find_all($per_page, $offset);
    }

    public function search($pattern, & $count, $limit = 20, $offset = 0)
    {
        $count = $this->join('publishers', 'contacts.publisher_id = publishers.id')
            ->orlike(array('contacts.name' => $pattern, 'email' => $pattern, 'publishers.name' => $pattern))
            ->count_all();
        $records = $this->join('publishers', 'contacts.publisher_id = publishers.id')
            ->orlike(array('contacts.name' => $pattern, 'email' => $pattern, 'publishers.name' => $pattern))
            ->find_all($limit, $offset);
        return $records;
    }

    public function delete_record()
    {
        $resources = $this->get_resources();
        foreach ($resources as $resource) {
            $resource->contact_id = NULL;
            $resource->save();
        }
        $this->delete();
    }

    /**
     * Vraci vsechny zdroje, ktere patri k danemu kontaktu
     * @return Resource_Model zdroje nalezici danemu kontaktu
     */
    public function get_resources()
    {
        $resources = ORM::factory('resource')
            ->where('contact_id', $this->id)
            ->find_all();
        return $resources;
    }

    /**
     * Priradi kontakt vydavateli.
     * @param Publisher_Model $publisher
     */
    public function add_publisher($publisher)
    {
        if ($publisher instanceof Publisher_Model) {
            $this->publisher_id = $publisher->id;
        } else
        {
            throw new InvalidArgumentException('Objekt neni typu vydavatel');
        }
    }
}

?>