<!-- Custom Css -->
<link href="/css/style.css" rel="stylesheet">
<title>
  <?php
  switch (CURRENT_PAGE) {

    case 'index.php':
      echo 'Pristup Nalogu';
      break;

    case 'indexAdmin.php':
      echo 'Komandna Tabla Admin';
      break;

    case 'indexWorker.php':
      echo 'Nalog Radnika';
      break;

    default:
      echo "Informacioni Sistem Naplate proizvoda";
      break;
  }
   ?>
</title>
</head>
<body
<?php
//dodavanje klase body tag-u
if(CURRENT_PAGE=="index.php"){
echo 'class="login-page"';          //index.php
} else if (CURRENT_PAGE=="indexAdmin.php"){
echo " class=\"theme-blue-grey\"";
} else if (CURRENT_PAGE=="workerAdmin.php"){
echo " class=\"theme-black\"";
}
?>
>
