<?php

require_once 'model/UserModel.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    public function index()
    {
        $view = new View('user_me');
        $view->display();
    }

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

    public function logout()
    {
        session_destroy();
        unset($_SESSION["user"]);
        $view = new View('default_index');
        $view->display();
    }

    public function saveUser()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $description = $_POST['description'];

        $check = new UserModel();

        if ($check->checkexist($username))
        {
            $userModel = new UserModel();
            $userModel->create($username, $password, $description);

            $view = new View('user_me');
            $view->display();
        }
        else
        {
            echo "That username alreasy exists. Please choose another one.";
            $view = new View('user_register');
            $view->display();
        }
    }

    public function loginUser()
    {
        $username = $_POST['loginname'];
        $password = $_POST['logpassword'];

        $userModel = new UserModel();
        $userModel->login($username, $password);

        if(isset($_SESSION["user"]))
        {
            $view = new View('user_me');
            $view->display();
        }
        else
        {
            $view = new View('user_login');
            $view->display();
        }
    }

    public function me()
    {
        if(isset($_SESSION["user"]))
        {
            $view = new View('user_me');
            $view->display();
        }
        else
        {
            $view = new View('user_login');
            $view->display();
        }
    }

    public function others()
    {
        $userModel = new UserModel();
        $userModel->others();

        $username = $_POST['username'];
        $username = $_POST['description'];

        $view = new View('user_others');
        $view->display();
    }

    public function mypictures()
    {
        if(isset($_SESSION["user"]))
        {
            $view = new View('user_mypictures');
            $view->display();
        }
        else
        {
            $view = new View('user_login');
            $view->display();
        }
    }

    public function myprofile()
    {
        if(isset($_SESSION["user"]))
        {
            $view = new View('user_myprofile');
            $view->display();
        }
        else
        {
            $view = new View('user_login');
            $view->display();
        }
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
