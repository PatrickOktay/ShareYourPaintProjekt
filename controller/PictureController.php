<?php

require_once 'model/PictureModel.php';
require_once 'model/UserModel.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class PictureController
{
    public function index()
    {
        header("Location: /Picture/all");
    }

    public function all()
    {
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

    public function best()
    {
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
    public function upload()
    {
        //validieren der eingabe
        $okTypes = array(".png",".jpg", ".jpeg",".gif");

        $filetype= explode("/",($_FILES["img"]["type"]));

        if($_FILES["img"]["type"] && $_POST["titel"] !=""){

            //nötige variabeln deffinieren/auslesen
            $title=htmlspecialchars($_POST["titel"]);
            $filetype='.'.$filetype[1];
            $description=htmlspecialchars($_POST["desc"]);

            //id des Benutzers herausfinden
            $userModel = new UserModel();
            $owner=($userModel->userid());

            if(array_search($filetype, $okTypes)){
                $picturemodel = new PictureModel();
                $pictureid=($picturemodel->maxId());
                $pictureid++;

                $type=$pictureid . $filetype;
                $picturemodel->uploadInDB($title, $type, $description, $owner);//speichern des Pfades in der Datenbank
                move_uploaded_file($_FILES['img']['tmp_name'], './view/css/pictures/uploads/'.$pictureid.$filetype); //speichern des bildes
            }
            else echo "<div id=\"error\"><p>Only jpegs and gifs allowed!</p></div>";
        }
        else echo "<div id=\"error\"><p>Please choose a title and a picture!</p></div>";
    

        header("Location: /Picture/all");

    }
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
    public function delete()
    {
        $id = $_POST['id'];
        $pictureModel = new PictureModel();
        $pictureModel->delete($id);

        header("Location: /Picture/all#$picture");
    }
}