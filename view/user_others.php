<?php
	$username = $_POST['username'];
    $description = $_POST['description'];

    echo '<div class="others">';
	echo '<p class="textothers">Username</p>';
    echo '<input value="'.$username.'" disabled>';
    echo '<p class="textothers">Description</p>';
    echo '<textarea id="seedescription" disabled>'.$description.'</textarea>';
    echo '</div>';
?>