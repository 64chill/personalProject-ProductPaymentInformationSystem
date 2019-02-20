<?php
define("CURRENT_PAGE", "indexAdmin.php");
session_start();


if(!(isset($_SESSION["tip_naloga"]) && $_SESSION["tip_naloga"]==1)){
  header('Location: /');
}
//pamtimo stranicu preko GET metode
if(isset($_GET["page"])) {
  $current_page = $_GET["page"];
} else{
    $current_page = "glavni_podaci";
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/additionalPhp/headerMain.php";
include_once "pages/main_admin.php";



include_once $_SERVER['DOCUMENT_ROOT'] . "/additionalPhp/footerMain.php";

 ?>
