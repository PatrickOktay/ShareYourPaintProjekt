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
    }

    public function login($username, $password)
    {
        $password = sha1($password);
        //echo $password;
        //echo $username;

        $query = "SELECT username, password FROM $this->tableName WHERE username=? AND password=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ss', $username, $password);
        $statement->execute();
        $statement->store_result();

        $statement->bind_result($username, $pw);
        $statement->fetch();

        if ($statement->num_rows == 1)
        {
            if ($pw == $password)
            {
                $_SESSION['user'] = $username;
            } 
            else
            {
                echo "Login fehlgeschlagen!";
            }
        }
        
        else
        {
            echo "Login fehlgeschlagen!";
        }
    }
}
