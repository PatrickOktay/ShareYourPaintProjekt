<?php

require_once 'model/PictureModel.php';
require_once 'model/UserModel.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class PictureController
{
    //Standart View
    public function index()
    {
        header("Location: /Picture/all");
    }
    //Führt zu der Seite wo alle Bilder zu sehen sind.
    public function all()
    {
        //Führt zum sql Statement, wo alle Benutzer aufgerufen werden.
        $pictureModel = new PictureModel();
        $pictureModel->showAll();

        $id = $_POST['id'];
        $type = $_POST['type'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $calender = $_POST['calender'];
        $owner = $_POST['owner'];
        $ownerid = $_POST['ownerid'];

        $user = $_POST['user'];

        $view = new View('picture_all');
        $view->footer();
    }
    //Führt zu der Seite wo die am besten bewerteten Bilder sind.
    public function best()
    {
        //Führt zum sql Statement, wo alle Benutzer nach Bewertung sortiert aufgerufen werden.
        $pictureModel = new PictureModel();
        $pictureModel->showbest();

        $id = $_POST['id'];
        $type = $_POST['type'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $calender = $_POST['calender'];
        $owner = $_POST['owner'];
        $ownerid = $_POST['ownerid'];

        $user = $_POST['user'];

        $view = new View('picture_best');
        $view->footer();
    }
    //Überpfrüft die Eingabe der Bilder. 
    public function upload()
    {
        //Wenn eine Datei un ein Titel eingefügt wurden
        if($_FILES["img"]["type"] !="" && $_POST["titel"] !="")
        {
            $okTypes = array(".png",".jpg", ".jpeg",".gif");
            $filetype= explode("/",($_FILES["img"]["type"]));

            //nötige variabeln deffinieren/auslesen
            $title=htmlspecialchars($_POST["titel"]);
            $filetype='.'.$filetype[1];
            $description=htmlspecialchars($_POST["desc"]);

            //id des Benutzers herausfinden
            $userModel = new UserModel();
            $owner=($userModel->userid());
            //Wenn der typ des Bildes mit einem der vordefinierten typen übereinstimmt 
            if(array_search($filetype, $okTypes))
            {
                $picturemodel = new PictureModel();
                $pictureid=($picturemodel->maxId());
                $pictureid++;

                $type=$pictureid . $filetype;
                $picturemodel->uploadInDB($title, $type, $description, $owner);//speichern des Pfades in der Datenbank
                move_uploaded_file($_FILES['img']['tmp_name'], './view/css/pictures/uploads/'.$pictureid.$filetype); //speichern des bildes
                header("Location: /Picture/all");
            }
            //wenn es nicht übereinstimmt
            else
            {
                echo "<div id=\"errorpic\"><p>Only jpegs, jpgs and gifs allowed!</p></div>";
                $userModel = new UserModel();
                $description=($userModel->description());
                $_POST['description'] = $description;
                $view = new View('user_me');
                $view->display();
            }
        }
        //wenn etwas von beidem leer ist
        else
        {
            echo "<div id=\"errorpic\"><p>Please choose a title and a picture!</p></div>";

            $userModel = new UserModel();
            $description=($userModel->description());
            $_POST['description'] = $description;
            $view = new View('user_me');
            $view->display();
        }

    }
    //Führt zu dem sql Statement, wo die die Bewertung der Bilder in eine Tabelle gewschriben wird. 
    public function rate()
    {
        if(isset($_SESSION["user"]))
        {
            $picture = $_POST['id'];
            $userModel = new UserModel();
            $user=($userModel->userid());
            $pictureModel = new PictureModel();
            $pictureModel->rate($picture, $user);
            header("Location: /Picture/all#$picture");
        }
    }
    //Führt zum sql Statement, wo das zu löschende Bild gelöscht wird.
    public function delete()
    {
        $id = $_POST['id'];
        $pictureModel = new PictureModel();
        $pictureModel->delete($id);

        header("Location: /Picture/all#$picture");
    }
}