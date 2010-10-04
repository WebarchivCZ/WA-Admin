<?php
class Curators_Controller extends Table_Controller
{
    protected $table = 'curators';
    protected $title = 'Curators';
    protected $header = 'Kurátor';

    public function add ()
    {

        $form = Formo::factory();
        $form->add('username')->label('Uzivatelske jmeno');
        $form->add('password', 'password')->label('Heslo');
		$form->add('password', 'password_confirm')->label('Potvrdit heslo');
        $form->add('submit', 'odeslat');

        $this->template->content = $form;

        if ($form->validate())
        {

            if ($form->password->value != $form->password_confirm->value)
            {
                $this->template->content .= 'Hesla se neshoduji';
            } else
            {

                $curator = new Curator_Model();

                $curator->username = $form->username->value;
                $curator->password = $form->password->value;
                $curator->save();

                if ($curator->add(ORM::factory('role', 'login')) and $curator->saved)
                {
                    $this->template->content = '<h2>Uzivatel byl uspesne vlozen</h2>';
                }
            }
        }
    }

    public function edit($id = FALSE) {
        throw new WaAdmin_Exception('Neimplementovana funkcionalita', 'Bohuzel toto neni implementovano');
    }
}
?>