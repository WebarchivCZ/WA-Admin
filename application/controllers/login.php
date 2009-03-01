<?php
class Login_Controller extends Template_Controller
{

	protected $title = "Přihlásit se";

	protected $need_auth = FALSE;
	
	public function index ()
	{
		$form = new Forge();
		$form->input('username')->label('jmeno')->rules('required');
		$form->password('password')->label('heslo')->rules('required');
		$form->checkbox('remember')->label('zapamatovat si prihlaseni');
		$form->submit('odeslat');
		if ($form->validate()) {
			$username = $form->username->value;
			$password = $form->password->value;
			$remember = $form->remember->value;
			
			if (Auth::instance()->login($username, $password, $remember)) {
				$session = Session::instance();
				
				url::redirect($session->get('requested_url'));
			} else {
				//echo 'spatne zadane heslo';
			}
		}
		$this->template->content = $form;		
	}
	
	public function add() {
		$curator = new Curator_Model();
		$curator->username = 'adam';
		$curator->password = 'cyber';
		$curator->add(ORM::factory('role', 'login'));
		$curator->save();
		Auth::instance()->login($curator->username,'cyber');
	}
	
	public function logout() {
		Auth::instance()->logout();
		url::redirect('login');
	}
}
?>