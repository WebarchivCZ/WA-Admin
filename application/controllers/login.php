<?php
class Login_Controller extends Template_Controller {

	protected $title = "Přihlásit se";

	protected $need_auth = FALSE;

	public function index()
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

		$form = Formo::factory('login_form');
		$form->add_html('<h2>Přihlásit do systému</h2>');

		$form->add('username')->label('Uživatel')->required(TRUE);
		$form->add('password', 'password')->label('Heslo')->required(TRUE);
		$form->add('checkbox', 'remember')->label('Zapamatovat přihlášení');
		$form->add('submit', 'login')->value('Přihlásit');
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
				$this->template->message = 'Špatně zadaná kombinace uživatelského jména a hesla';
			}
		}
		$this->template = View::factory('login_page');
		$this->template->form = $form;
	}

}

?>