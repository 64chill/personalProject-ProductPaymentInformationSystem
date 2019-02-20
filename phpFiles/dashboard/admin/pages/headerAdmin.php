<?php
function if_active($current_page,$value){
  if($current_page==$value)
            return "class=\"bg-light-green\"";
}
function set_icon($key){
  switch($key){
    case '0':
      return "home";
    case '1':
      return "account_circle";
    case '2':
      return "style";
    case '3':
      return "receipt";
  }
} //end set_icon
?><nav class="navbar bg-blue-grey">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="navbar-brand">
              ADMIN
            </div>
            <a href="javascript:void(0);" class="bars"></a>
        </div>
        <div class="collapse navbar-collapse bg-blue-grey" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li>
                <form name="logout" action="/simpleFunctions/logout.php" method="post">
                <button class="btn bg-teal btn-block btn-lg waves-effect margintop10px" type="submit" >
                 ODJAVA SA SISTEMA
               </button></form></li>
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->

        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">Navigacioni meni</li>
                <?php
                //create nav
                $pagesArr = array("glavni_podaci",
                                  "pregled_korisnika",
                                  "pregled_proizvoda",
                                  "pregled_racuna",);

                foreach ($pagesArr as $key => $value) {
                  echo "<li ". if_active($current_page,$value).">".
                  "<a href=\"indexAdmin.php?page=$value\">".
                  "<i class='material-icons'>".set_icon($key)."</i><span>".
                  ucwords(str_replace('_', ' ', $value)) .
                  "</span></a></li>";
                }
                ?>
            </ul>
        </div>
        <!-- #Menu -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
