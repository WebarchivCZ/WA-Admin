<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Allows a template to be automatically loaded and displayed. Display can be
 * dynamically turned off in the controller methods, and the template file
 * can be overloaded.
 *
 * To use it, declare your controller to extend this class:
 * `class Your_Controller extends Template_Controller`
 *
 * $Id$
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
abstract class Template_Controller extends Controller
{

// Template view name
    public $template = 'template';

    // Default to do auto-rendering
    public $auto_render = TRUE;

    protected $need_auth = TRUE;

    protected $session;

    protected $log = '';

	/**
	 * Template loading and setup routine.
	 */
    public function __construct ()
    {
        $this->session = Session::instance();
        parent::__construct();

        // load constants from config/constants.php file
        Kohana::config_load('constants');

        // Load the template
        $this->template = new View($this->template);

        if ($this->auto_render == TRUE)
        {
        // Render the template immediately after the controller method
            Event::add('system.post_controller', array(
                $this ,
                '_render'));
        }

        if (! empty($this->title))
        {
            $this->template->title = $this->title;
        } else
        {
            $this->template->title = " | ";
        }
        $this->template->content = new View("layout/center");
        $this->template->top_nav = new View("layout/top_nav");
        $this->template->left_nav = new View("layout/left_nav");

        $footer = new View("layout/footer");
        $footer->bind('log', $this->log);
        $this->template->footer = $footer;

        $this->login();

        // just for debug

        if (Kohana::config('config.debug_mode'))
        {
            $profiler = new Profiler();
        }
    }

	/**
	 * Render the loaded template.
	 */
    public function _render ()
    {
        if ($this->auto_render == TRUE)
        {
        // Render the template when the class is destroyed
            $this->template->render(TRUE);
        }
    }

    public function search ()
    {
        $pattern = $this->input->get('search_string');
        // strip white space from search string
        $pattern = trim($pattern);

        $resources = ORM::factory('resource')
            ->join('publishers', 'resources.publisher_id = publishers.id')
            ->orlike(array('url' => $pattern , 'title' => $pattern, 'publishers.name'=>$pattern))
            ->find_all();

        $view = new View('search');
        $view->pattern = $pattern;
        $view->resources = $resources;
        $this->template->content = $view;
    }

    private function login ($role = 'login')
    {
        if (! $this->need_auth)
        {
            return TRUE;
        }
        $this->session = Session::instance();
        $authentic = new Auth();
        if (! $authentic->logged_in($role))
        {
            $this->session->set("login_requested_url", "/" . url::current());
            url::redirect('login');
        } else
        {
            $this->user = $authentic->get_user();
        }

    }

    public function logout ()
    {
        $url = '/' . $this->uri->segment(1);
        $this->session->set("login_requested_url", $url);
        Auth::instance()->logout();
        url::redirect('login');
    }

    public function debug($message)
    {
        Kohana::log('debug', $message);
        $this->log .= Kohana::debug($message);
    }

} // End Template_Controller