<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <title>ShareYourPaint</title>
  <link rel="stylesheet" type="text/css" href="/view/css/style.css">
</head>
<body>
<img src="/view/css/pictures/ShareYourPaint.PNG" alt="ShareYourPaint">
<h1>Sharing is Caring</h1>
<form id="menu">
  <a href="/">Home</a>
  <a href="/User/me">Me</a>
  <a href="/Picture/all">All pictures</a>
  <a href="/Picture/best">The best rated pictures</a>
  <a href="/User/others">Other users profiles</a>
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