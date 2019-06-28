<?php

use Philo\Blade\Blade;

abstract class Controller
{
    /** @var  \Illuminate\View\Factory */
    protected $view;

    public function action($action)
    {
        if (!method_exists($this, $action . 'Action')) {
            http_response_code(404);
            echo 404;
            exit(0);
        }

        $this->preAction();
        $this->{$action . 'Action'}();
        $this->postACtion();
    }

    protected function preAction()
    {
        $views = Config::me()->get('rootDir') . '/application/views';
        $cache = Config::me()->get('rootDir') . '/application/cache';

        $blade = new Blade($views, $cache);
        $this->view = $blade->view();

        if(
            isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            $this->view->share('layout', 'layouts.ajax');
        }
        else {
            $this->view->share('layout', 'layouts.main');
        }
    }

    protected function postAction()
    {

    }
}