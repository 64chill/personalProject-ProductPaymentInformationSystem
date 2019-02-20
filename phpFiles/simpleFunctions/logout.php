<?php

//remove all cookies if
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);//get all cookies
    foreach($cookies as $cookie) { //go through every cookie
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
session_unset();//remove variable
session_destroy(); //destroy session
header("Location: /index.php");
 ?>
