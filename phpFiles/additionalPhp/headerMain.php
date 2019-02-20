<?php 

include_once "HeaderFooterFiles/header_top.php"; // prvi deo zaglavlja
//dodatni css u zavisnosti od korektne izabrane strane
switch (CURRENT_PAGE) {
  case 'index.php':
    break;
  case 'indexAdmin.php':
  include_once "HeaderFooterFiles/headerCSS/indexAdminCSS.php";
    // code...
    break;
  case 'indexWorker.php':
    // include_once "headerFooterFiles/headerCSS/indexWoerkerCSS.php";
    break;
  } // end switch


//end doddatni css ...
include_once "HeaderFooterFiles/header_bottom.php"; // zadnji deo headera











?>
