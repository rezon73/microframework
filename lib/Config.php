<?php

class Config extends Singleton
{
    /**
    * @var array
    */
    private $config = [];
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key) {
        if (empty($this->config)) {
            $this->config = array_merge(
                require(dirname(__FILE__) . '/../config/global.php'),
                require(dirname(__FILE__) . '/../config/local.php')
            );
        }
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        return null;
    }
}