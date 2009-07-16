<?php
/**
 * TODO priradit smlouvu ala stary wadmin + creative commons
 *
 */
class Progress_Controller extends Template_Controller
{

    protected $title = 'Zdroje v jednání';

    public function index()
    {
        $resources = ORM::factory('resource')
            ->in('resource_status_id', array(2, 8))
            ->where('curator_id', $this->user->id)
            ->find_all();

        $view = new View('progress');
        $view->resources = $resources;

        $this->template->content = $view;
    }

    /**
     * Zobrazí formulář pro přiřazení nové smlouvy ke zdroji s daným ID.
     * @param int $id
     */
    public function new_contract($resource_id) {
        $view = View::factory('new_contract');
        $view->resource = ORM::factory('resource', $resource_id);
        $form = Formo::factory('add_contract');
        $form->add('contract_no')->label('Číslo smlouvy')->value('doplnit generovane cislo');
        $form->add('checkbox', 'cc')->label('Creative Commons');
        $view->form = $form;
        $this->template->content = $view;
    }

    public function reject($reason, $id) {
        $resource = ORM::factory('resource', $id);
        
        switch ($reason) {
            case 'publisher':
                $status = RS_REJECTED_PUB;
                $message = "Zdroj <em>{$resource->title}</em> byl odmítnut vydavatelem - uloženo.";
                break;
            case 'no_response':
                $status = RS_NO_RESPONSE;
                $message = "Zdroj <em>{$resource->title}</em> je bez odezvy - uloženo.";
                break;
            default:
                $this->session->set_flash('message', 'Nesprávný důvod odmítnutí zdroje');
                return;
        }
        $resource->resource_status_id = $status;
        $resource->save();
        $this->session->set_flash('message', $message);
        url::redirect('progress');
    }
}
?>