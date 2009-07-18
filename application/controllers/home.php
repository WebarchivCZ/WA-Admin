<?php
// TODO dodelat dashboard

class Home_Controller extends Template_Controller
{
    protected $title = 'Home';
    protected $page_title = 'Dashboard';

    public function index()
    {
        $content = View::factory('home');
        $view = View::factory('dashboard');
        $dashboard = ORM::factory('dashboard');
        $dashboard->fill_dashboard($this->user);
        $view->dashboard = $dashboard;
        $content->dashboard = $view;
        $content->stats = Statistic_Model::getBasic();

        $this->template->content = $content;
    }

}
?>