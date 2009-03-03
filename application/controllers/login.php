<?php
class Login_Controller extends Template_Controller
{

	protected $title = "Přihlásit se";

	protected $need_auth = FALSE;

	public function index ()
	{
		$auth = Auth::instance();
		$session = Session::instance();
		
		if ($auth->auto_login()) {
			url::redirect($session->get('login_requested_url'));
			return TRUE;
		}
		$form = new Forge();
		$form->input('username')->label('jmeno')->rules('required');
		$form->password('password')->label('heslo')->rules('required');
		$form->checkbox('remember')->label('zapamatovat si prihlaseni');
		$form->submit('odeslat');
		if ($form->validate()) {
			$username = $form->username->value;
			$password = $form->password->value;
			$remember = $form->remember->value;
			
			if ($auth->login($username, $password, $remember)) {
				
				url::redirect($session->get('login_requested_url'));
			} else {	//echo 'spatne zadane heslo';
			}
		}
		$this->template->content = $form;
	}

}
?>