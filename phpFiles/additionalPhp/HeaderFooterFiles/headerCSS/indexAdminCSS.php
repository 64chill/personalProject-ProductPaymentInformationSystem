<?php

if($current_page){
  switch ($current_page) {
    case 'glavni_podaci':
    print <<<END
      <link href="/plugins/morris/morris.css" rel="stylesheet">
      <!-- Bootstrap Select Css -->
    <link href="../../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
END;
      break;
    case 'pregled_korisnika':
    case 'pregled_proizvoda':
    case 'pregled_racuna':
    print <<<END
  <!-- Bootstrap Material Datetime Picker Css -->
    <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="../../plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="../../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
END;
      break;

    }//end switch
} // end if($current_page){


?>
