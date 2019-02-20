<?php
switch ($current_page) {
  case 'glavni_podaci':
  print <<<END
  <script src="/plugins/inputmask/inputmask.bundle.js"></script>
  <script src="/plugins/morris/raphael.js"></script>
  <script src="/plugins/morris/morris.js"></script>
  <script src="/js/dashboard_js/admin_js/adminGraph.js"></script>
END;
    break;
  case 'pregled_korisnika':
  case 'pregled_proizvoda':
  case 'pregled_racuna':
  print <<<END
  <!-- Bootstrap Notify Plugin Js -->
    <script src="/plugins/bootstrap-notify/bootstrap-notify.js"></script>
  <!-- Autosize Plugin Js -->
   <script src="../../plugins/autosize/autosize.js"></script>

   <!-- Moment Plugin Js -->
   <script src="../../plugins/momentjs/moment.js"></script>
END;

    if($current_page=="pregled_korisnika"){
      print <<<END
      <script src="/js/dashboard_js/admin_js/pregled_korisnika_ajax.js"></script>
END;
    } else if ($current_page=="pregled_proizvoda"){
      print <<<END
      <script src="/js/dashboard_js/admin_js/pregled_proizvoda_ajax.js"></script>
END;
    }else if ($current_page=="pregled_racuna"){
        print <<<END
        <script src="/js/dashboard_js/admin_js/pregled_racuna_ajax.js"></script>
END;
    }
    break;

}

?>
