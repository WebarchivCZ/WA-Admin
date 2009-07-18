<?php
/**
 * DONE priradit smlouvu ala stary wadmin + creative commons
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

        $view = View::factory('progress');
        $view->resources = $resources;

        $this->template->content = $view;
    }

    /**
     * Zobrazí formulář pro přiřazení nové smlouvy ke zdroji s daným ID.
     * @param int $id
     */
    public function new_contract($resource_id) {

        $resource = ORM::factory('resource', $resource_id);
        
        $contract = ORM::factory('contract');
        $new_contract_no = $contract->new_contract_no(date('Y'));
        
        $form = Formo::factory('add_contract');
        $form->add('resource_title')->label('Nazev zdroje')->value($resource->title)->disabled();
        $form->add('contract_no')->label('Číslo smlouvy')->value($new_contract_no)->required(TRUE);
        $form->add('year')->label('Rok')->value(date('Y'))->required(TRUE);
        $form->add('date_signed')->label('Datum podpisu')->value(date('Y-m-d'))->required(TRUE);
        $form->add('checkbox', 'cc')->label('Creative Commons');
        $form->add('checkbox', 'addendum')->label('Doplnek');
        $form->add('textarea', 'comments')->label('Komentare');
        $form->add('submit', 'odeslat');        

        if( ! $form->validate()) {
            $view = View::factory('new_contract');
            $view->form = $form;

            // DONE upravit format formulare (css, view)
            $this->template->content = $view;
        } else {
            $form->remove('resource_title');
            $values = $form->get_values();
            foreach ($values as $name => $value) {
                $contract->__set($name, $value);
            }
            $resource->resource_status_id = RS_APPROVED_PUB;
            $contract->save();
            $resource->save();
            $contract_no = $contract->contract_no.'/'.$contract->year;
            $message = "Zdroj <em>{$resource->title}</em> - smlouva {$contract_no} uložena.";
            $this->session->set_flash('message', $message);
            url::redirect('progress');
        }
        
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