<?php
class  Progress_Controller extends Template_Controller {
	protected $title = 'Zdroje v jednání';

	public function index()
	{
		$resources = ORM::factory('resource')
			->in('resource_status_id', RS_CONTACTED)
			->where('curator_id', $this->user->id)
			->orderby('title', 'ASC')
			->find_all();

		$view = View::factory('progress');
		$view->resources = $resources;

		$this->template->content = $view;
	}

	/**
	 * Show for contract assignment of resource identified by ID.
	 * @param int $resource_id
	 * @internal param int $id ID of resource
	 */
	public function new_contract($resource_id)
	{
		$resource = new Resource_Model($resource_id);
		$publisher = new Publisher_Model($resource->publisher_id);

		$form = $this->generate_new_contract_form($resource->title);

		if (! $form->validate())
		{
			$view = View::factory('new_contract');

			if (Contract_Model::domain_has_blanco($resource->url) === TRUE)
			{
				$view->blanko_contract = Contract_Model::domain_get_blanco($resource->url);
			} else
			{
				$view->contracts = $publisher->get_contracts();
			}

			$view->set_global('resource_id', $resource->id);
			$view->form = $form;
			$this->template->content = $view;
		} else
		{
			// remove title from form (it is not in contract model)
			$form->remove('resource_title');

			$this->session->set('contract_val', $form->get_values());
			$this->session->set('resource_id', $resource->id);

			url::redirect('progress/save_contract/'.$resource_id);
		}

	}

	public function save_contract($resource_id)
	{
		$contract_val = $this->session->get('contract_val', date(date_helper::MYSQL_DATE_FORMAT));
		if (! is_null($contract_val))
		{
			$contract_val['date_signed'] = date_helper::mysql_date($contract_val['date_signed']);
			$contract = Contract_Model::create($contract_val);

			$new_contract_no = Contract_Model::new_contract_no($contract->date_signed);
			$new_contract_year = date_helper::get_year($contract->date_signed);

			$form = Formo::factory('save_contract');
			$form->add('contract_no')
				->label('Číslo smlouvy')
				->value($new_contract_no)
				->required(TRUE);
			$form->add('year')
				->label('Rok')
				->value($new_contract_year)
				->required(TRUE);
			$form->add('submit', 'odeslat')
				->value('Uložit smlouvu');

			if ($form->validate())
			{
				$contract->year = $form->year->value;
				$contract->contract_no = $form->contract_no->value;

				$is_contract_inserted = Contract_Model::is_already_inserted($contract->year, $contract->contract_no);
				if ($is_contract_inserted)
				{
					$contract = Contract_Model::get_contract($contract->year, $contract->contract_no);
				} else
				{
					$contract->save();
				}

				$resource = new Resource_Model($resource_id);
				$resource->resource_status_id = RS_APPROVED_PUB;
				if ($resource->contract_id != NULL)
				{
					$contract->parent_id = $resource->contract_id;
					$contract->save();
				}
				$resource->contract_id = $contract->id;
				$resource->save();
				$message = "Zdroj <em>{$resource->title}</em> - smlouva {$contract} uložena.";
				$this->session->set_flash('message', $message);
				$this->session->delete('contract', 'resource_id');

				url::redirect('tables/resources/view/'.$resource->id);
			} else
			{
				$view = View::factory('new_contract');

				$view->resource_id = $resource_id;
				$view->form = $form;
				$this->template->content = $view;
			}
		} else
		{
			url::redirect('progress');
		}
	}

	public function reject($reason, $resource_id)
	{
		$resource = new Resource_Model($resource_id);
		switch ($reason)
		{
			case 'publisher' :
				$status = RS_REJECTED_PUB;
				$message = "Zdroj <em>{$resource->title}</em> byl odmítnut vydavatelem - uloženo.";
				break;
			case 'no_response' :
				$status = RS_NO_RESPONSE;
				$message = "Zdroj <em>{$resource->title}</em> je bez odezvy - uloženo.";
				break;
			default :
				$this->session->set_flash('message', 'Nesprávný důvod odmítnutí zdroje');
				return;
		}
		$resource->resource_status_id = $status;
		$resource->save();
		$this->session->set_flash('message', $message);
		url::redirect('progress');
	}

	public function assign_existing_contract($resource_id = NULL, $contract_id = NULL, $save = FALSE)
	{
		if ($resource_id == NULL OR $contract_id == NULL)
		{
			$this->session->set_flash('message', 'Není nastaveno ID smlouvy');
			url::redirect('progress');
		}
		$resource = new Resource_Model($resource_id);
		$contract = new Contract_Model($contract_id);
		$is_addendum = (bool)$contract->addendum;
		if (! $resource->__isset('title') OR ! $contract->__isset('contract_no'))
		{
			$this->session->set_flash('message', 'Smlouva nebo zdroj neexistuje.');
			url::redirect('progress');
		}

		// if contract is addendum save as well because addendums can't have hierarchy
		if ($save OR $is_addendum)
		{
			$resource->contract_id = $contract->id;
			$resource->resource_status_id = RS_APPROVED_PUB;
			$resource->save();

			$this->session->set_flash('message', 'Smlouva byla úspěšně přiřazena.');
			url::redirect('tables/resources/view/'.$resource->id);
		}
		else
		{
			$assignment_view = ($contract->is_blanco()) ? 'assign_blanco_contract' : 'assign_addendum';
			$this->template->content = View::factory("tables/contracts/{$assignment_view}")
				->set('resource', $resource)
				->set('contract', $contract);
		}


	}

	private function generate_new_contract_form($resource_title)
	{
		$form = Formo::factory('add_contract');
		$form
			->add('resource_title')
			->label('Název zdroje')
			->value($resource_title)
			->disabled();
		$form
			->add('date_signed')
			->label('Datum podpisu')
			->value(date('d.m.Y'))
			->required(TRUE);
		$form
			->add('checkbox', 'cc')
			->label('Creative Commons');
		$form
			->add('checkbox', 'addendum')
			->label('Doplněk');
		$form
			->add('checkbox', 'blanco_contract')
			->label('Blanco smlouva');
		$form
			->add('domain')
			->label('Doména');
		$form
			->add('type')
			->label('Typ smlouvy');
		$form
			->add('textarea', 'comments')
			->label('Komentář');
		$form->add('submit', 'Odeslat');
		return $form;
	}

	public function assign_addendum($resource_id, $contract_id)
	{
		$default_date_signed = date(date_helper::MYSQL_DATE_FORMAT);
		$date_signed = $this->input->post('date_signed', $default_date_signed);

		$resource = new Resource_Model($resource_id);
		$contract = new Contract_Model($contract_id);
		$addendum = $resource->create_addendum($contract_id, $date_signed);

		if ($contract->is_blanco())
		{
			message::set_flash("Smlouva patřící k blanco smlouvě {$addendum} byla úspěšně přiřazena.");
		} else
		{
			message::set_flash("Doplněk pro smlouvu {$addendum} byl úspěšně přiřazen.");
		}
		url::redirect(url::site("/tables/resources/view/{$resource_id}"));
	}
}