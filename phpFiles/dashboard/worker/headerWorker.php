<nav class="navbar bg-brown">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="navbar-brand">
              Radnik :  <u class="col-cyan"><?php echo $_SESSION["username"]; ?></u>
            </div>
        </div>
        <div class="collapse navbar-collapse bg-brown" id="navbar-collapse">
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
                  <li class="bg-teal">
                    <a href="indexWorker.php" class="col-white">
                      <i class='material-icons'>add_shopping_cart</i>
                      <span class="col-white">Naplata Proizvoda</span>
                    </a>
                </li>
            </ul>
        </div>
      </aside>
      <!-- #END# Left Sidebar -->
  </section>
