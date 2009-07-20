<?php
class Auth_Controller extends Template_Controller
{

	public function index()
	{
		if (Auth::instance()->logged_in())
		{
			$this->template->title = 'User Logout';
			$form = new Forge('auth_demo/logout');
			$form->submit('Logout Now');
		}
		else
		{
			$this->template->title = 'User Login';
			$form = new Forge();
			$form->input('username')->label(TRUE)->rules('required|length[4,32]');
			$form->password('password')->label(TRUE)->rules('required|length[5,40]');
			$form->submit('Attempt Login');
			if ($form->validate())
			{
				// Load the user
				$user = ORM::factory('curator', $form->username->value);
				//echo Kohana::debug($user);
				if (Auth::instance()->login($user, $form->password->value))
				{
					// Login successful, redirect
					url::redirect('auth_demo/login');
				}
				else
				{
					$form->password->add_error('login_failed', 'Invalid username or password.');
				}
			}
		}
		// Display the form
		$this->template->content = $form->render();
	}
	
public function create()
	{
		$this->template->title = 'Create User';

		$form = new Forge;
		$form->input('username')->label(TRUE)->rules('required|length[4,32]');
		$form->password('password')->label(TRUE)->rules('required|length[4,40]');
                $form->input('email')->label(TRUE)->rules('required|length[4,32]|valid_email');
                $form->input('firstname')->label(TRUE)->rules('required|length[2,32]|valid_email');
                $form->input('lastname')->label(TRUE)->rules('required|length[2,32]|valid_email');
		$form->submit('Create New User');

		if ($form->validate())
		{
			// Create new user
			$user = ORM::factory('curator');

			if ( ! $user->username_exists($form->username->value))
			{
				foreach ($form->as_array() as $key => $val)
				{
					// Set user data
					$user->$key = $val;
				}

				if ($user->save() AND $user->add(ORM::factory('role', 'login')))
				{
					Auth::instance()->login($user, $form->password->value);

					// Redirect to the login page
					url::redirect('auth_demo/login');
				}
			}
		}

		// Display the form
		$this->template->content = $form->render();
	}
}
?>