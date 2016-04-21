<h2>The other users</h2>
<?php
	$username = $_POST['username'];
    $description = $_POST['description'];

    echo '<div id="others">';
	echo '<p>Username</p>';
    echo '<input value="'.$username.'" disabled>';
    echo '<p>Description</p>';
    echo '<textarea id="seedescription" disabled>'.$description.'</textarea>';
    echo '</div>';
?>