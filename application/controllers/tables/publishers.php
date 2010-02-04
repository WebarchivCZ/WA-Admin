<?php
class Publishers_Controller extends Table_Controller {
	protected $table = 'publishers';
	protected $title = 'Publishers';
	protected $header = 'Vydavatel';
	protected $columns_ignored = array ('id' );
	
	public function view($id = FALSE) {
		parent::view ( $id );
		$append_view = View::factory ( 'tables/append_publisher' );
		$append_view->resources = ORM::factory ( 'resource' )->where ( 'publisher_id', $id )->find_all ();
		$view = $this->template->content;
		$view->set ( 'append_view', $append_view );
	}
	
	public function delete($id = FALSE) {
            if ($this->user->has(ORM::factory('role', 'admin'))) {
		if ($id) {
			$view = View::factory ( 'tables/delete_publishers' );
			$publisher = ORM::factory ( 'publisher', $id );
			$resources = $publisher->get_resources ();
			$view->publisher = $publisher;
			$view->resources = $resources;
			$this->template->content = $view;
		} else {
			message::set_flash ( 'Není vyplněno ID vydavatele.' );
		}
            } else {
                message::set_flash('Nemáte právo mazání.');
                url::redirect(url::site("tables/{$this->table}"));
            }
	}
	
	/**
	 * Metoda odstranuje prirazeni daneho zdroje od vydavatele.
	 * @param int $resource_id
	 */
	public function remove_from_resource($resource_id = FALSE) {
		if ($resource_id) {
			$resource = ORM::factory ( 'resource', $resource_id );
			if ($resource->loaded) {
				$publisher_id = $resource->publisher_id;
				$publisher = ORM::factory ( 'publisher', $publisher_id );
				
				$resource->publisher_id = NULL;
				$resource->save ();
				
				message::set_flash ( "Zdroj {$resource->title} byl úspěšně odstraněn od vydavatele {$publisher->name}" );
			} else {
				message::set_flash ( 'Neexistujíci zdroj!' );
			}
		} else {
			message::set_flash ( 'Nenastavené ID zdroje!' );
		}
		if ($publisher_id != 0) {
			url::redirect ( url::site ( '/tables/publishers/delete/' . $publisher_id ) );
		} else {
			url::redirect ( url::site ( '/tables/publishers/' ) );
		}
	}
	
	/**
	 * Vymaze vydavatele, ktere ma prirazeny.
	 * @param int $publisher_id
	 */
	public function erase($publisher_id = FALSE) {
		if ($publisher_id) {
			$publisher = new Publisher_Model($publisher_id);
			$publisher->delete_record();
			message::set_flash('Vydavatel byl úspěšně smazán.');
		} else {
			message::set_flash('Není nastavené ID vydavatele.');
		}
		url::redirect(url::site('/tables/publishers/'));
	}
}
?>