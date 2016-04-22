<?php
require_once 'lib/Model.php';

/**
 * Das UserModel ist zuständig für alle Zugriffe auf die Tabelle "user".
 *
 * Die Ausführliche Dokumentation zu Models findest du in der Model Klasse.
 */
class UserModel extends Model
{
    /**
     * Diese Variable wird von der Klasse Model verwendet, um generische
     * Funktionen zur Verfügung zu stellen.
     */
    protected $tableName = 'user';

    public function create($username, $password, $description)
    {
        $password = sha1($password);

        $query = "INSERT INTO $this->tableName (username, password, description) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sss', $username, $password, $description);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
        $_SESSION['user'] = $username;
    }

    public function checkexist($username)
    {
        $query = "SELECT username, password FROM $this->tableName WHERE username=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $username);
        $statement->execute();
        $statement->store_result();

        $statement->bind_result($username, $pw);
        $statement->fetch();

        if ($statement->num_rows == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
            
    }

    public function login($username, $password)
    {
        $password = sha1($password);
        //echo $password;
        //echo $username;

        $query = "SELECT id, username, password FROM $this->tableName WHERE username=? AND password=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ss', $username, $password);
        $statement->execute();
        $statement->store_result();

        $statement->bind_result($id, $username, $pw);
        $statement->fetch();

        if ($statement->num_rows == 1)
        {
            if ($pw == $password)
            {
                $_SESSION['user'] = $username;
            } 
            else
            {
                echo "<div id=\"error\"><p>Login failed!</p></div>";
            }
        }
        
        else
        {
            echo "<div id=\"error\"><p>Login failed!</p></div>";
        }
    }
    public function others()
    {
        $query = "SELECT username, description FROM $this->tableName ORDER BY id DESC";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();
        $statement->store_result();
        $statement->bind_result($username, $description);

        $query2 = "SELECT count(id) FROM $this->tableName";
        $statement2 = ConnectionHandler::getConnection()->prepare($query2);
        $statement2->execute();
        $statement2->store_result();
        $statement2->bind_result($idcount);
        $statement2->fetch();

        $view = new View('user_others');
        $view->header();
        echo'<h2>All users</h2>';

        for ($i=0; $i < $idcount; $i++) {
            $statement->fetch();
            $_POST['username'] = $username;
            $_POST['description'] = $description;
            $view = new View('user_others');
            $view->content();
        }
    }
    public function userid()
    {
        if (isset($_SESSION["user"]))
        {
            $username = $_SESSION['user'];
            $query = "SELECT id FROM $this->tableName WHERE username =?";
            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('s', $username);

            $statement->execute();
            $statement->store_result();
            $statement->bind_result($owner);
            $statement->fetch();

            return $owner;
        }
    }
    public function owner($owner)
    {
        $query = "SELECT username FROM user WHERE id=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $owner);

        $statement->execute();
        $statement->store_result();
        $statement->bind_result($owner);
        $statement->fetch();

        return $owner;
    }
    public function changeprofiledescription($description)
    {
        $userModel = new UserModel();
        $id=($userModel->userid());

        $query = "UPDATE $this->tableName SET description=? WHERE id=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('si', $description, $id);
        $statement->execute();
    }
    public function description()
    {
        $userModel = new UserModel();
        $id=($userModel->userid());

        $query = "SELECT description FROM user WHERE id=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        $statement->execute();
        $statement->store_result();
        $statement->bind_result($description);
        $statement->fetch();

        return $description;
    }
}
