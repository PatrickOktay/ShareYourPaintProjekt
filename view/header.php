<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <title>ShareYourPaint</title>
  <link rel="stylesheet" type="text/css" href="/view/css/style.css">
</head>
<body>
<img id="syp" src="/view/css/pictures/web/ShareYourPaint.PNG" alt="ShareYourPaint">
<form id="menu">
  <a href="/">Home</a>
  <a href="/User/me">Me</a>
  <a href="/Picture/all">All</a>
  <a href="/Picture/best">Best rated</a>
  <a href="/User/others">All users</a>
</form>
<form id="menu">
  <?php
    if(isset($_SESSION["user"]))
    {
     $username = $_SESSION['user'];
      echo '<a href="/User/logout">Logout</a>';
      echo '<p>Sie sind angemeldet als '.$username.'</p>';
    }
    else
    {
      echo '<a href="/User/register">Register</a>';
      echo '<a href="/User/login">Login</a>';
    }
  ?>
</form>
<div id="main">