<?php

require_once dirname(__FILE__) . '/../lib/functions.php';

class WebApp extends Singleton
{
    /**
     * @var Request
     */
    protected $request;

    public function getRequest(): Request
    {
        if (empty($this->request)) {
            $this->request = new Request;
        }

        return $this->request;
    }

    public function start()
    {
        session_start();

        $request = $this->getRequest()->getMVCRequest();

        if (empty($request['action']) || empty($request['controller'])) {
            http_response_code(404);
            echo 404;
            exit(0);
        }

        $controllerName = ucfirst($request['controller']) . 'Controller';

        if (!class_exists($controllerName)) {
            http_response_code(404);
            echo 404;
            exit(0);
        }

        try {
            header('Cache-Control: no-cache');

            /** @var Controller $controller */
            $controller = new $controllerName;
            $controller->action($request['action']);
        }
        catch (Exception $e) {
            http_response_code(404);
            echo $e->getMessage();
            exit(0);
        }
    }
}