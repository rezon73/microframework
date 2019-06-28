<?php

use Philo\Blade\Blade;

abstract class Widget
{
    /** @var  \Illuminate\View\Factory */
    protected $view;

    /** @var array */
    protected $extendedInfo = [];

    public function __construct()
    {
        $views = Config::me()->get('rootDir') . '/application/views/widgets';
        $cache = Config::me()->get('rootDir') . '/application/cache';

        $blade = new Blade($views, $cache);
        $this->view = $blade->view();
    }

    /**
     * @return array
     */
    public function getExtendedInfo()
    {
        return $this->extendedInfo;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setExtendedInfo(array $data)
    {
        $this->extendedInfo = $data;

        return $this;
    }
}