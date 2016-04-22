<?php

require_once 'model/UserModel.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    public function index()
    {
        header("Location: /User/me");
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
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $password2 = htmlspecialchars($_POST['password2']);
        $description = htmlspecialchars($_POST['description']);

        if (strlen($username) < 4)
        {
            echo "<div id=\"error\"><p>Username is too short!</p></div>";
        }
        if (strlen($password) < 5)
        {
            echo "<div id=\"error\"><p>Password is too short!</p></div>";
        }
        if(!$password == $password2)
        {
            echo "<div id=\"error\"><p>The passwords don't match!</p></div>";
        }

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
            echo "<div id=\"errorregister\"><p>That username alreasy exists. Please choose another one.</p></div>";
            $view = new View('user_register');
            $view->display();
        }
    }

    public function loginUser()
    {
        $username = htmlspecialchars($_POST['loginname']);
        $password = htmlspecialchars($_POST['logpassword']);

        $userModel = new UserModel();
        $userModel->login($username, $password);

        if(isset($_SESSION["user"]))
        {
            //$view = new View('user_me');
            //$view->display();
            header("Location: /User/me");
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
            $userModel = new UserModel();
            $description=($userModel->description());

            $_POST['description'] = $description;

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

        $view = new View('user_others');
        $view->footer();
    }
    public function changedescription()
    {
        if(isset($_SESSION["user"]))
        {
            $description=htmlspecialchars($_POST["description"]);
            $userModel = new UserModel();
            $userModel->changeprofiledescription($description);
            $view = new View('user_me');
            $view->display();
        }
        else
        {
            $view = new View('user_login');
            $view->display();
        }
    }
}
