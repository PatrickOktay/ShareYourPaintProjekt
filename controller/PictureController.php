<?php

require_once 'model/PictureModel.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class PictureController
{
    public function index()
    {
        $view = new View('picture_all');
        $view->display();
    }

    public function all()
    {
        $view = new View('picture_all');
        $view->display();
    }

    public function best()
    {
        $view = new View('picture_best');
        $view->display();
    }
    public function upload()
    {
        //validieren der eingabe
        $okTypes = array("png","jpg", "jpeg","gif");

        $filetype= explode("/",($_FILES["img"]["type"]));

        if($_FILES["img"]["type"] && $_POST["titel"] !=""){

            //nötige variabeln deffinieren/auslesen
            $title=$_POST["titel"]
            $filetype='.'.$filetype[1]
            $description=$_POST["desc"]

            //id des Benutzers herausfinden
            /*TODO*/
            /*TODO*/
            $owner=/*TODO*/

            if(array_search($filetype[1], $okTypes)){
                $picturemodel = new PictureModel();
                $pictureid=($picturemodel->CountPictures()); /*TODO*/
                $picturemodel->uploadInDB($title, $filetype, $description, $owner);//speichern des Pfades in der Datenbank
                move_uploaded_file($_FILES['img']['tmp_name'], './view/css/pictures/uplouds/'.$pictureid.$filetype); //speichern des bildes
            }
            else echo "Es sind nur png jpg jpeg und gif erlaubt";
        }
        else echo "Bitte Datei auswählen und Titel eingeben.";
    

        $view = new View('picture_all');
        $view->display();

    }
}