<?php
class Resources_Controller extends Table_Controller {
	protected $table = 'resources';
	protected $title = 'Resources';
	protected $columns_ignored =
		array('id', 'publisher_id', 'contact_id', 'contract_id', 'annotation', 'rating_last_round');
	protected $columns_order =
		array('title', 'url', 'creator_id', 'date', 'curator_id', 'conspectus_id', 'crawl_freq_id', 'resource_status_id',
			'suggested_by_id', 'rating_result', 'aleph_id', 'issn', 'catalogued', 'tech_problems', 'comments');
	protected $header = 'Zdroj';

	public function view($id = FALSE)
	{
		parent::view($id);

		$resource = $this->record;
		$active_curators = ORM::factory('curator')->where('active', 1)->find_all();

		$append_view = View::factory('tables/append_resource');
		$append_view->set_global('resource', $resource);
		$append_view->set_global('active_curators', $active_curators);
		$append_view->set_global('ratings', $resource->ratings);
		$append_view->set_global('show_final_rating', $this->user->could_close_rating($resource->id));
		$append_view->set_global('user_id', $this->user->id);
		$append_view->set_global('seeds', $resource->seeds);

		$view = $this->template->content;
		$view->set('append_view', $append_view);
		$this->session->set_flash('request_page', url::current(TRUE));
	}

	public function edit($id = FALSE)
	{
		$resource = ORM::factory('resource')->find($id);
		// rating_last_round is immutable
		$this->columns_ignored [] = 'rating_last_round';

		if ($resource->__isset('id'))
		{
			$form = Formo::factory()->orm('resource', $id)->remove($this->columns_ignored)->add('submit', 'Upravit')
				->label_filter('display::translate_orm')->label_filter('ucfirst');

			$form->rating_result->type('select');
			$form->rating_result->values(Rating_Model::get_final_array());
			$form->rating_result->value($resource->get_rating_result());
			$form->catalogued->checked(! is_null($resource->catalogued))->title($resource->catalogued);

			$form->_order = array('title', 'url', 'date', 'creator_id', 'curator_id', 'conspectus_id',
				'conspectus_subcategory_id', 'crawl_freq_id', 'resource_status_id', 'suggested_by_id',
				'rating_result', 'reevaluate_date', 'aleph_id', 'issn', 'catalogued', 'important',
				'tech_problems', 'comments', 'upravit');

			// select all subcategories belonging to parent category
			$form->conspectus_subcategory_id->values = ORM::factory('conspectus_subcategory')
				->where('conspectus_id', $resource->conspectus_id)->orderby('subcategory')
				->select_list('id', 'title');

			$form->conspectus_id->id = 'category_select';
			$form->conspectus_subcategory_id->id = 'subcategory_select';
			$form->conspectus_subcategory_id->blank = TRUE;

			$view = View::factory('tables/record_edit');
			$view->header = 'Editace zdroje';
			$view->form = $form;
			$this->template->content = $view;
			if ($form->validate())
			{
				$form->save();
				url::redirect("{$this->view_record_url}/{$resource->id}");
			}
		} else
		{
			message::set_flash('Zdroj s daným ID neexistuje!');
			url::redirect('tables/resources');
		}
	}

	public function save_final_rating($id, $rating = NULL)
	{
		$resource = new Resource_Model($id);
		if ($rating == NULL)
		{
			$rating = $this->input->post('final_rating');
		}
		// conspectus subcategory has to be filled
		if ($resource->conspectus_subcategory_id == '')
		{
			message::set_flash('Nelze uložit hodnoceni - není vyplněna podkategorie konspektu.');
		} else
		{
			if ($rating == 3)
			{
				$reevaluate_date = $this->input->post('reevaluate_date');
				if ($reevaluate_date != '')
				{
					$resource->reevaluate_date = $reevaluate_date;
				}
			}
			if ($rating == 2)
			{
				$crawl_freq = $this->input->post('crawl_freq_id');
				if ($crawl_freq == 0)
				{
					message::set_flash('Je nutné vyplnit frekvenci sklízení!');
					url::redirect("{$this->view_record_url}/{$resource->id}");
				} else
				{
					$resource->crawl_freq_id = $crawl_freq;
				}
			}
			$rating_saved = $resource->save_final_rating($rating);
			if ($rating_saved)
			{
				message::set_flash('Finální hodnocení bylo úspěšně uloženo.');
			}
		}
		url::redirect("{$this->view_record_url}/{$resource->id}");
	}

	public function save_rating($resource_id, $curator_id, $round)
	{
		$rating_value = $this->input->post('rating');
		$comments = $this->input->post('comment', NULL);

		if ($rating_value != 'NULL')
		{
			$resource = ORM::factory('resource', $resource_id);

			$is_rating_saved = $resource->add_rating($rating_value, $curator_id, $round, $comments);

			if ($is_rating_saved)
			{
				message::set_flash('Hodnocení bylo úspěšně uloženo.');
			}

		}
		url::redirect('/tables/resources/view/'.$resource_id);
	}

	public function search_by_conspectus($conspectus_id = NULL)
	{
		if (! is_null($conspectus_id))
		{
			$per_page = $this->input->get('limit', 20);
			$page_num = $this->input->get('page', 1);
			$offset = ($page_num - 1) * $per_page;

			$result = ORM::factory('resource')->where('conspectus_id', $conspectus_id)->find_all();

			$count = $result->count();
			$pages = Pagination::dropdown($count, $per_page);
			$pages_inline = Pagination::inline($count, $per_page);

			$view = new View('tables/table_conspectus');
			$view->items = $result;
			$view->pages = $pages.$pages_inline;
			$this->template = $view;
			$this->template->title = Kohana::lang('tables.'.$this->title)." | ".Kohana::lang('tables.index');
		}
	}

	public function add_publisher($resource_id = NULL, $publisher_id = NULL)
	{
		if (! is_null($publisher_id))
		{
			$this->set_publisher($resource_id, $publisher_id);
		}

		$view = View::factory('form');

		$form = Formo::factory('add_form');
		$form->add('publisher')->label('Vydavatel');
		$form->add_rules('required', 'publisher', 'Povinná položka');
		$form->add('submit', 'odeslat')->value('Ověřit');

		$view->form = $form;
		$view->header = 'Ověřit vkládaného vydavatele';

		$publisher_checked = (bool)$this->session->get('publisher_checked');

		if ($publisher_checked == TRUE)
		{
			$form->set('odeslat', 'value', 'Vložit');
			$view->header = "Vložit vydavatele.";
			$form->set('action', url::site("tables/resources/insert_publisher/{$resource_id}"));
		} elseif ($form->validate())
		{

			$publisher_name = $form->publisher->value;

			$resources = $this->check_publishers($publisher_name);
			if ($resources->count() == 0)
			{
				$form->set('odeslat', 'value', 'Vložit');
				$view->header = "Nebyly nalezeny shody - vložit vydavatele.";
				$form->set('action', url::site("tables/resources/insert_publisher/{$resource_id}"));
			} else
			{
				$view = View::factory('match_resources');

				$redirect_urls = array();
				$redirect_urls ['insert'] = "tables/resources/add_publisher/{$resource_id}/";
				$redirect_urls ['back'] = 'tables/resources/add_publisher';
				$redirect_urls ['continue'] = $redirect_urls ['insert'];

				$this->session->set_flash('publisher_checked', TRUE);

				$view->redirect_urls = $redirect_urls;

				$view->match_resources = $resources;
				$this->help_box = 'Kliknutím na konkrétního vydavatele přiřadíte již existujícího vydavatele';
			}
		} else
		{
			$view->form = $form->get();
		}

		$this->template->content = $view;
	}

	public function insert_publisher($resource_id)
	{
		$publisher_name = $this->input->post('publisher');
		$publisher = ORM::factory('publisher');
		$publisher->name = $publisher_name;
		$publisher->save();
		$resource = ORM::factory('resource', $resource_id);
		$resource->publisher_id = $publisher->id;
		$resource->save();
		message::set_flash('Ke zdroji byl přiřazen vydavatel: '.$publisher->name);
		url::redirect("{$this->view_record_url}/{$resource_id}");
	}

	public function nominate($resource_id)
	{
		$resource = new Resource_Model($resource_id);
		if (! $resource->has_nomination())
		{
			$resource->nominate($this->user->id);
			message::set_flash('Zdroj byl úspěšně nominován.');
		} else
		{
			message::set_flash('Zdroj je již nominovaný.');
		}
		$request_page = $this->session->get_once('request_page', '/tables/conspectus_table');
		url::redirect(url::site($request_page));

	}

	private function set_publisher($resource_id, $publisher_id)
	{
		$publisher = ORM::factory('publisher', $publisher_id);
		if ($publisher->id == '')
		{
			message::set_flash('Vydavatel neexistuje');
		} else
		{
			$resource = ORM::factory('resource', $resource_id);
			$resource->publisher_id = $publisher->id;
			$resource->save();
			message::set_flash("Ke zdroji byl úspěšně uložen vydavatel: {$publisher->name}");
		}
		url::redirect("{$this->view_record_url}/{$resource_id}");
	}

	private function check_publishers($publisher_name)
	{
		$resources = ORM::factory('resource')->join('publishers', 'resources.publisher_id = publishers.id')->orlike(
			array('publishers.name' => $publisher_name))->find_all();
		return $resources;
	}

	public function upload_screenshot()
	{
		$resource_id = $this->input->post('resource_id');
		if ($resource_id != '')
		{
			$redirect_url = url::site('tables/resources/view/'.$resource_id);
		} else
		{
			$redirect_url = url::site('tables/resources/');
		}

		if (count($_FILES) > 0)
		{
			$date = $this->input->post('screenshot_date', date('d.m.Y'));

			$screenshot = new Screenshot_Model();
			$screenshot->set_resource_id($resource_id);
			$screenshot->set_datetime(date_helper::screenshot_date($date));

			$this->convert_screenshot($_FILES['screenshot_file'], $screenshot);
		}

		url::redirect($redirect_url);
	}

	// TODO move this function
	public function convert_screenshot($screenshot_file, $screenshot)
	{
		$is_converted = FALSE;

		$file_type = $screenshot_file['type'];
		$tmp_file_name = $screenshot_file['tmp_name'];
		$screenshot_dir = Screenshot_Model::get_screens_dir();
		$new_image_path = $screenshot_dir.$screenshot->get_filename();

		$should_update_screenshot = $this->input->post('update_screenshot', FALSE);
		if (file_exists($new_image_path))
		{
			if ($should_update_screenshot)
			{
				unlink($new_image_path);
				// TODO update id in database
			} else
			{
				message::set_flash('Screenshot tohot data již existuje.');
				return;
			}
		}

		if ($file_type == 'image/jpeg')
		{
			$jpg_for_conversion = imagecreatefromjpeg($tmp_file_name);
			if (imagepng($jpg_for_conversion, $new_image_path, 5, PNG_ALL_FILTERS))
			{
				$is_converted = TRUE;
			}
			imagedestroy($jpg_for_conversion);
		} elseif ($file_type == 'image/png')
		{
			if (rename($tmp_file_name, $new_image_path))
			{
				$is_converted = TRUE;
			}
		} else
		{
			throw new WaAdmin_Exception('Nesprávný formát', 'Screenshot musí být typu JPEG nebo PNG');
		}

		if ($is_converted)
		{
			$this->image = new Image($new_image_path);
			$this->image->resize(800, 600, IMAGE::NONE);
			$this->image->save();

			$this->image->resize(120, 80, IMAGE::NONE);
			$this->image->save($screenshot_dir.$screenshot->get_filename(TRUE));
		}
	}

	public function select_screenshot($resource_id, $screenshot_date)
	{
		if ($resource_id == NULL OR $screenshot_date == NULL)
		{
			throw new WaAdmin_Exception("Nesprávné parametry pro funkci select_screenshot",
				"Pro funkci select_screenshot nebyly předány správné parametry.");
		}
		$resource = new Resource_Model($resource_id);
		if ($resource->__get('loaded'))
		{
			$resource->screenshot_date = $screenshot_date;
			$resource->save();
			message::set_flash('Screenshot byl úspěšně zvolen.');
			url::redirect(url::site('tables/resources/view/'.$resource->id));
		}
	}
}

?>