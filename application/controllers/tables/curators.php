<?php
class Curators_Controller extends Table_Controller
{

    protected $table = 'curators';

    protected $title = 'Curators';

    public function add ()
    {

        $form = new Forge();
        $form->input('username')->rules('required')->label(TRUE);
        $form->password('password')->rules('required')->label(TRUE);
        $form->password('password_confirm')->rules('required')->label(TRUE);
        $form->input('firstname')->label(TRUE);
        $form->input('lastname')->label(TRUE);
        $form->input('email')->label(TRUE);
        $form->input('icq')->label(TRUE);
        $form->input('skype')->label(TRUE);
        $form->textarea('comments')->label(TRUE);
        $form->submit('odeslat');

        $this->template->content = $form;

        if ($form->validate())
        {

            if ($form->password->value != $form->password_confirm->value)
            {
                $this->template->content .= 'Hesla se neshoduji';
            } else
            {

                $curator = new Curator_Model();

                $values = $form->as_array();
                foreach ($values as $key => $val)
                {
                    $curator->$key = $val;
                }

                if ($curator->add(ORM::factory('role', 'login')) and $curator->save())
                {
                    $this->template->content = '<h2>Uzivatel byl uspesne vlozen</h2>';
                }
            }
        }
    }
}
?>