<?php

require_once 'model/UserModel.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    // Standard View
    public function index()
    {
        header("Location: /User/me");
    }
    //Führt zur register Seite
    public function register()
    {
        $view = new View('user_register');
        $view->display();
    }
    //Führt zur login Seite
    public function login()
    {
        $view = new View('user_login');
        $view->display();
    }
    //Führt zur Standard Seite
    //zerstört und beendet die Session
    public function logout()
    {
        session_destroy();
        unset($_SESSION["user"]);
        $view = new View('default_index');
        $view->display();
    }
    //Überprüft die Eingaben
    //Führt zum sql Statement wo die User in die Datenbank gespeichert werden
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
        //führt zum sql Statement wo der User gesucht wird
        if ($check->checkexist($username))
        {
            $userModel = new UserModel();
            $userModel->create($username, $password, $description);

            $view = new View('user_me');
            $view->display();
        }
        //wenn es schon einen User mit dem gleichen Namen gibt
        else
        {
            echo "<div id=\"errorregister\"><p>That username alreasy exists. Please choose another one.</p></div>";
            $view = new View('user_register');
            $view->display();
        }
    }
    //führt zum sql Statement wo überprüft wird ob der User in der Datenbank existiert
    public function loginUser()
    {
        $username = htmlspecialchars($_POST['loginname']);
        $password = htmlspecialchars($_POST['logpassword']);

        $userModel = new UserModel();
        $userModel->login($username, $password);

        if(isset($_SESSION["user"]))
        {
            header("Location: /User/me");
        }
        else
        {
            $view = new View('user_login');
            $view->display();
        }
    }
    //die Seite me wird aufgerufen
    public function me()
    {
        //wenn der User eingeloggt ist
        if(isset($_SESSION["user"]))
        {
            $userModel = new UserModel();
            $description=($userModel->description());

            $_POST['description'] = $description;

            $view = new View('user_me');
            $view->display();
        }
        //wenn er nicht eingeloggt ist
        else
        {
            $view = new View('user_login');
            $view->display();
        }
    }
    //führt zum sql Statement alle User gesucht werden
    public function others()
    {
        $userModel = new UserModel();
        $userModel->others();

        $view = new View('user_others');
        $view->footer();
    }
    //führt zum sql Statement wo die User Beschreibung geändert wird
    public function changedescription()
    {
        //wenn der User angemeldet ist
        if(isset($_SESSION["user"]))
        {
            $description=htmlspecialchars($_POST["description"]);
            $userModel = new UserModel();
            $userModel->changeprofiledescription($description);
            $view = new View('user_me');
            $view->display();
        }
        // wenn er nicht angemeldet ist
        else
        {
            $view = new View('user_login');
            $view->display();
        }
    }
}
