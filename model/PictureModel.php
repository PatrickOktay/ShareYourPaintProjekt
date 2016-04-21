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
    protected $tableName = 'pictures';

    /**
     * Erstellt einen neuen benutzer mit den gegebenen Werten.
     *
     * Das Passwort wird vor dem ausführen des Queries noch mit dem SHA1
     *  Algorythmus gehashed.
     *
     * @param $firstName Wert für die Spalte firstName
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     */
    public function CountPictures()
    {
        $query = "SELECT count(id) FROM $this->tableName";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        return $result;

    }

    public function uploadInDB($title, $type, $description, $owner)
    {
        $rating = 0;

        $query = "INSERT INTO $this->tableName (title, type, description, rating, calendar, owner) VALUES (?, ?, ?, ?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sssidi', $title, $type, $description, $rating, date(), $owner);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }
}
