<?php

require_once 'lib/Model.php';

/**
 * Das UserModel ist zuständig für alle Zugriffe auf die Tabelle "user".
 *
 * Die Ausführliche Dokumentation zu Models findest du in der Model Klasse.
 */
class PictureModel extends Model
{
    /**
     * Diese Variable wird von der Klasse Model verwendet, um generische
     * Funktionen zur Verfügung zu stellen.
     */
    protected $tableName = 'pictures';

    /**
     * Erstellt einen neuen benutzer mit den gegebenen Werten.
     *
     * Das Passwort wird vor dem ausführen des Queries noch mit dem SHA1
     *  Algorythmus gehashed.
     *
     * @param $firstName Wert für die Spalte firstName
     * @param $lastName Wert für die Spalte lastName
     * @param $email Wert für die Spalte email
     * @param $password Wert für die Spalte password
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     */
    public function CountPictures()
    {
        $query = "SELECT count(id) FROM $this->tableName";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $statement->store_result();
        $statement->bind_result($picscount);
        $statement->fetch();

        return $picscount;
    }
    public function maxId()
    {
        $query = "SELECT MAX(id) FROM $this->tableName";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();
        $statement->store_result();
        $statement->bind_result($pictureid);
        $statement->fetch();

        return $pictureid;

    }
    public function uploadInDB($title, $type, $description, $owner)
    {
        $rating = 0;

        $query = "INSERT INTO $this->tableName (title, type, description, owner, rating) VALUES (?, ?, ?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sssii', $title, $type, $description, $owner, $rating);
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

    }
    public function showAll()
    {
        $query = "SELECT * FROM $this->tableName ORDER BY id DESC";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();
        $statement->store_result();
        $statement->bind_result($id, $title, $type, $description, $calender, $owner, $rating);

        $query2 = "SELECT count(id) FROM $this->tableName";
        $statement2 = ConnectionHandler::getConnection()->prepare($query2);
        $statement2->execute();
        $statement2->store_result();
        $statement2->bind_result($idcount);
        $statement2->fetch();

        $view = new View('picture_all');
        $view->header();
        echo'<h2>All pictures</h2>';

        for ($i=0; $i < $idcount; $i++)
        {
            $statement->fetch();
            $_POST['id'] = $id;
            $_POST['type'] = $type;
            $_POST['title'] = $title;
            $_POST['description'] = $description;
            $_POST['calender'] = $calender;
            $_POST['ownerid'] = $owner;
            $userModel = new UserModel();
            $owner=($userModel->owner($owner));
            $_POST['owner'] = $owner;
            $pictureModel = new PictureModel();
            $rating=($pictureModel->rating($id));
            $_POST['rating'] = $rating;

            $userModel = new UserModel();
            $_POST['user'] = ($userModel->userid());
            
            $view = new View('picture_all');
            $view->content();
        }
    }
    public function showbest()
    {
        $query = "SELECT * FROM $this->tableName ORDER BY rating DESC";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();
        $statement->store_result();
        $statement->bind_result($id, $title, $type, $description, $calender, $owner, $rating);

        $query2 = "SELECT count(id) FROM $this->tableName";
        $statement2 = ConnectionHandler::getConnection()->prepare($query2);
        $statement2->execute();
        $statement2->store_result();
        $statement2->bind_result($idcount);
        $statement2->fetch();

        $view = new View('picture_best');
        $view->header();
        echo'<h2>All pictures</h2>';

        for ($i=0; $i < $idcount; $i++)
        {
            $statement->fetch();
            $_POST['id'] = $id;
            $_POST['type'] = $type;
            $_POST['title'] = $title;
            $_POST['description'] = $description;
            $_POST['calender'] = $calender;
            $_POST['ownerid'] = $owner;
            $userModel = new UserModel();
            $owner=($userModel->owner($owner));
            $_POST['owner'] = $owner;
            $pictureModel = new PictureModel();
            $rating=($pictureModel->rating($id));
            $_POST['rating'] = $rating;

            $userModel = new UserModel();
            $_POST['user'] = ($userModel->userid());
            
            $view = new View('picture_best');
            $view->content();
        }
    }
    public function rate($picture, $user)
    {
        $query = "SELECT id FROM rating WHERE evaluator =? AND picture =?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $user, $picture);
        $statement->execute();

        $statement->store_result();
        $statement->bind_result($id);
        $statement->fetch();

        if ($statement->num_rows == 1)
        {
            header("Location: /Picture/all");
        }
        else
        {
            $query2 = "INSERT INTO rating (evaluator, picture) VALUES (?, ?)";
            $statement2 = ConnectionHandler::getConnection()->prepare($query2);
            $statement2->bind_param('ii', $user, $picture);

            if (!$statement2->execute()) {
                throw new Exception($statement2->error);
            }
            $pictureModel = new PictureModel();
            $pictureModel->updaterating($picture);
        }
    }
    public function updaterating($picture)
    {
        $pictureModel = new PictureModel();
        $rating=($pictureModel->rating($picture));

        $query = "UPDATE $this->tableName SET rating=? WHERE id=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $rating, $picture);
        $statement->execute();
    } 
    public function rating($id)
    {
        $query = "SELECT count(id) FROM rating WHERE picture=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();

        $statement->store_result();
        $statement->bind_result($rating);
        $statement->fetch();
        return $rating;
    }
    public function delete($id)
    {
        $query = "DELETE FROM $this->tableName WHERE id=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
    }
}