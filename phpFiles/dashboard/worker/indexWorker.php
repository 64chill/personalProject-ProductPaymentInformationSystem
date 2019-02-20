<?php
define("CURRENT_PAGE", "workerAdmin.php");
session_start();
if(!(isset($_SESSION["tip_naloga"]) && $_SESSION["tip_naloga"]==2)){
  header('Location: /');
}


include_once $_SERVER['DOCUMENT_ROOT'] . "/additionalPhp/headerMain.php";
include_once "pages/main_worker.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/additionalPhp/footerMain.php";


?>
