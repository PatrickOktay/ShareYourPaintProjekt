<?php
	$id = $_POST['id'];
	$type = $_POST['type'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $calender = $_POST['calender'];
    $owner = $_POST['owner'];
    $rating = $_POST['rating'];
    $userid = $_POST['ownerid'];
    $user = $_POST['user'];

    echo '<div class="allpictures" id="'.$id.'">';
    	echo '<br>';
    	echo '<input value="'.$title.'" disabled>';
    	echo '<img class="uploads" src="/view/css/pictures/uploads/'.$type.'">';
    	echo '<br>';
    	echo '<textarea id="seedescription" disabled>'.$description.'</textarea>';
    	echo '<p class="rating">'.$rating.' likes</p>';
        if(isset($_SESSION["user"]))
        {
            echo '<form action="/Picture/rate" method="post">';
                echo '<input name="id" type="hidden" value="'.$id.'">';
                echo '<button name="like" type="submit">L♥ve it</button>';
            echo '</form>';
            if($userid == $user)
            {
                echo '<form action="/Picture/delete" method="post">';
                    echo '<input name="id" type="hidden" value="'.$id.'">';
                    echo '<button name="delete" >Delete</button>';
                echo '</form>';
            }
        }
    	echo '<p>'.$calender.'</p>';
    	echo '<p class="owner">From '.$owner.'</p>';
    echo '</div>';
?>