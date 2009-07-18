<?php
class Login_Controller extends Template_Controller
{

    protected $title = "Přihlásit se";

    protected $need_auth = FALSE;

    public function index ()
    {
        $auth = Auth::instance();
        $session = Session::instance();

        if ($auth->logged_in())
        {
            url::redirect('home');
        }

        if ($auth->auto_login())
        {
            url::redirect($session->get('login_requested_url'));
            return TRUE;
        }
        $form = new Forge();
        $form->input('username')->label('jmeno')->rules('required');
        $form->password('password')->label('heslo')->rules('required');
        $form->checkbox('remember')->label('zapamatovat si prihlaseni');
        $form->submit('Přihlásit');
        if ($form->validate())
        {
            $username = $form->username->value;
            $password = $form->password->value;
            $remember = $form->remember->value;

            if ($auth->login($username, $password, $remember))
            {
                url::redirect($session->get('login_requested_url'));
            } else
            {
                $this->session->set_flash('message', 'Špatně zadaná kombinace uživatelského jména a hesla');
            }
        }
        $this->template->content = $form;
    }

}
?>