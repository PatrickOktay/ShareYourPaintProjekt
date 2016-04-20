<?php

require_once 'model/UserModel.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class PictureController
{
    public function index()
    {
        $view = new View('picture_all');
        $view->display();
    }

    public function all()
    {
        $view = new View('picture_all');
        $view->display();
    }

    public function best()
    {
        $view = new View('picture_best');
        $view->display();
    }
}