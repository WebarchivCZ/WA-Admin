<?php
class Contracts_Controller extends Table_Controller
{
    protected $table = 'contracts';
    protected $title = 'Contracts';
    protected $header = 'Smlouva';
    protected $columns_ignored = array('id');
    protected $view = 'tables/table_contracts';

    public function view ($id = NULL)
    {
        parent::view($id);

        $contract = $this->record;
        $resources = $contract->get_resources();

        $append_view = View::factory('tables/append_contract');
        $append_view->resources = $resources;

        $view = $this->template->content;
        $view->set('append_view', $append_view);
    }

    public function delete($id = FALSE)
    {
        if ($this->user->has(ORM::factory('role', 'admin')))
        {
            if ($id)
            {
                $view = View::factory ( 'tables/delete_contracts' );
                $contract = ORM::factory ( 'contract', $id );
                $resources = $contract->get_resources();
                $view->contract = $contract;
                $view->resources = $resources;
                $this->template->content = $view;
            } else
            {
                message::set_flash ( 'Není vyplněno ID smlouvy.' );
                url::redirect(url::site("tables/{$this->table}"));
            }
        } else
        {
            message::set_flash('Nemáte právo mazání.');
        }
    }

    /**
     * Metoda odstranuje prirazeni daneho zdroje od smlouvy
     * @param int $resource_id
     */
    public function remove_from_resource($resource_id = FALSE)
    {
        if ($resource_id)
        {
            $resource = ORM::factory ( 'resource', $resource_id );
            if ($resource->loaded)
            {
                $contract_id = $resource->contract_id;
                $contract = ORM::factory ( 'contract', $contract_id );

                $resource->contract_id = NULL;
                $resource->save ();

                message::set_flash ( "Zdroj {$resource->title} byl úspěšně odstraněn od smlouvy {$contract}" );
            } else
            {
                message::set_flash ( 'Neexistujíci zdroj!' );
            }
        } else
        {
            message::set_flash ( 'Nenastavené ID zdroje!' );
        }
        if ($contract_id != 0)
        {
            url::redirect ( url::site ( '/tables/contracts/delete/' . $contract_id ) );
        } else
        {
            url::redirect ( url::site ( '/tables/contracts/' ) );
        }
    }

    public function erase($contract_id = FALSE)
    {
        if ($contract_id)
        {
            $contract = new Contract_Model($contract_id);
            $resources = $contract->get_resources();

            $contract->delete_record();
            message::set_flash('Smlouva byla úspěšně smazána.');
        } else
        {
            message::set_flash('Není nastavené ID smlouvy.');
        }
        url::redirect(url::site('/tables/contracts/'));
    }
}
?>