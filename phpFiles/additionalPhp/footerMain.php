<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/additionalPhp/HeaderFooterFiles/footer_top.php";

if(CURRENT_PAGE=="indexAdmin.php"){
    include_once $_SERVER['DOCUMENT_ROOT'] . "/additionalPhp/HeaderFooterFiles/footerJS/indexAdminJS.php";
} else if(CURRENT_PAGE=="workerAdmin.php"){
    include_once $_SERVER['DOCUMENT_ROOT'] . "/additionalPhp/HeaderFooterFiles/footerJS/indexWorkerJS.php";
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/additionalPhp/HeaderFooterFiles/footer_bottom.php";
 ?>
