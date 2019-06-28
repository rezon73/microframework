<?php

class Request
{
    protected $post = [];

    protected $get = [];

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @param array $post
     * @return $this
     */
    public function setPost(array $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return array
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @param array $get
     * @return $this
     */
    public function setGet(array $get)
    {
        $this->get = $get;

        return $this;
    }

    public function getPostParam(string $key)
    {
        if (!isset($this->post[$key])) {
            return null;
        }

        return $this->post[$key];
    }

    public function getGetParam(string $key)
    {
        if (!isset($this->get[$key])) {
            return null;
        }

        return $this->get[$key];
    }

    public function getMVCParam(string $key)
    {
        $mvcRequest = $this->getMVCRequest();

        if (!isset($mvcRequest[$key])) {
            return null;
        }

        return $mvcRequest[$key];
    }

    public function getMVCRequest()
    {
        $get = [];
        $counter = 0;

        $handledRequestUri = trim($_SERVER['REQUEST_URI'], '/');
        $handledRequestUri = explode('?', $handledRequestUri);
        $handledRequestUri = $handledRequestUri[0];
        foreach(explode('/', $handledRequestUri) as $part) {
            if ($counter == 0) {
                $get['controller'] = $part;
            }
            elseif ($counter == 1) {
                $get['action'] = $part;
            }
            elseif ($counter > 1) {
                switch($counter % 2) {
                    case 0:
                        $get[$part] = null;

                        break;
                    case 1:
                        $getKeys = array_keys($get);
                        $get[end($getKeys)] = $part;

                        break;
                }
            }

            $counter++;
        }

        if (empty($get['controller'])) {
            $get['controller'] = 'index';
        }

        if (empty($get['action'])) {
            $get['action'] = 'index';
        }

        return array_merge($this->post, $this->get, $get);
    }
}