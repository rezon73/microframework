<?php

class IndexController extends Controller
{
    public function indexAction()
    {
        $id = WebApp::me()->getRequest()->getGetParam('id');

        $database = Database::me()->getDatabase('database');
        $query = $database
            ->select()
            ->from('table')
            ->where('id', '=', $id)
            ->execute();

        $result = $query->fetch();

        Cache::me()->set('result', $result);

        echo $this->view
            ->make(
                'index.index',
                [
                    'text' => 'Hello world',
                    'id'   => $id,
                ]
            )
            ->render();
    }
}