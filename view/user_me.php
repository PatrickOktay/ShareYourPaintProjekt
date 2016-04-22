<?php
	$description = $_POST['description'];

	echo'<h3>Upload your pictures!</h3>';
	echo '<form action="/Picture/upload" method="post" enctype="multipart/form-data">';
		echo '<input maxlength="40" type="text" name="titel" placeholder="Title" required="true"><br>';
		echo '<p>Only jpegs, jpgs and gifs allowed.</p>';
		echo '<input type="file" name="img">';
		echo '<br>';
		echo '<textarea maxlength="300" name="desc" placeholder="Here you can write a description of your picture!"></textarea><br>';
		echo '<button type="submit">Upload</button>';
	echo '</form>';
	echo '<h3>Change your profile description</h3>';
	echo '<form action="/User/changedescription" method="post">';
		echo '<br>';
		echo '<textarea maxlength="300" name="description">'.$description.'</textarea>';
		echo '<br>';
		echo '<button type="submit">Change</button>';
	echo '</form>';
?>