<?php
session_start();
if(isset($_SESSION["user"])){
	echo "You are logged in!";
}
else{
	echo "You are not logged in!";
}
?>