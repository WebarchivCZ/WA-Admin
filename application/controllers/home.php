<?php
class Home_Controller extends Template_Controller
{
    protected $title = 'Úvodní stránka';
    protected $page_title = 'Dashboard';

    public function index()
    {
        $content = View::factory('home');
        $view = View::factory('dashboard');
        $dashboard = new Dashboard_Model();
        $dashboard->fill_dashboard($this->user);
        $view->dashboard = $dashboard;
        $content->dashboard = $view;
        $content->stats = Statistic_Model::getBasic();

        $this->template->content = $content;
    }

}
?>