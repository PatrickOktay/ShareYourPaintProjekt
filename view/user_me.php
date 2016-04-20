<form method="post"w>
<input type="file" name="img"></input>
</br></br>
<input type="submit" name="submit"></input>
</form>

<?php
/*
session_start();
if(isset($_SESSION["user"])){
	echo "You are logged in!";
}
else{
	echo "You are not logged in!";
}

*/

if(isset($_POST["submit"]))
{
	$okTypes = array("png","jpg", "jpeg","gif","PNG","JPG","JPEG","GIF");
	$filetype= pathinfo($_POST["img"],PATHINFO_EXTENSION);

	//$_FILES["img"]["name"];
	//$_FILES["img"]["type"];
	//$_FILES["img"]["tmp_name"];

	if(array_search($filetype, $okTypes))
	{
		echo "OK";
		move_uploaded_file($_FILES["img"]["tmp_name"],"/view/css/pictures".$_FILES["img"]["name"]);
	}
	else
	{
		echo "not an image";
	}
	
	//$_FILES[$_POST['img']]['img'];
} 
?>