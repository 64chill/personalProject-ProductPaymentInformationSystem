    <!-- Overlay For Sidebars
    <div class="overlay"></div-->>
    <!-- #END# Overlay For Sidebars -->
<?php include_once "headerAdmin.php" ?>


    <section class="content">
      <?php
      if($current_page=="glavni_podaci"){
        include_once "content/glavni_podaci.php";

      } else if($current_page=="pregled_korisnika"){
        include_once "content/pregled_korisnika.php";

      } else if($current_page=="pregled_proizvoda"){
        include_once "content/pregled_proizvoda.php";

      } else if($current_page=="pregled_racuna"){
        include_once "content/pregled_racuna.php";
      }
       ?>
    </section>
