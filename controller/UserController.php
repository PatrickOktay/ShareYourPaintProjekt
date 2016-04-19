<?php

require_once 'model/UserModel.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    public function register()
    {
        $view = new View('user_register');
        $view->display();
    }

    public function login()
    {
        $view = new View('user_login');
        $view->display();
    }

    public function saveUser()
    {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $description = $_POST['description'];

            $userModel = new UserModel();
            $userModel->create($username, $password, $description);
            
            $view = new View('user_me');
            $view->display();
    }

    public function loginUser()
    {

    }

    public function me(){
        $view = new View('user_me');
        $view->display();
    }

    public function others()
    {
        $view = new View('user_others');
        $view->display();
    }



    public function index()
    {
        $userModel = new UserModel();

        $view = new View('user_index');
        $view->title = 'Benutzer';
        $view->heading = 'Benutzer';
        $view->users = $userModel->readAll();
        $view->display();
    }

    public function create()
    {
        $view = new View('user_create');
        $view->title = 'Benutzer erstellen';
        $view->heading = 'Benutzer erstellen';
        $view->display();
    }

    public function doCreate()
    {
        if ($_POST['send']) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $userModel->create($firstName, $lastName, $email, $password);
        }

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /user');
    }

    public function delete()
    {
        $userModel = new UserModel();
        $userModel->deleteById($_GET['id']);

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /user');
    }
}
