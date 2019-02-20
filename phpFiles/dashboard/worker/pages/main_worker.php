<?php include_once "headerWorker.php"; ?>

<section class="content">
  <!-- Basic Alerts -->
              <div class="row clearfix " id="showReceipt">
                  <div class="hiddenReceipt col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="card">
                          <div class="header">
                              <h2>
                                  Račun
                              </h2>
                              <ul class="header-dropdown">
                                <li><button id="closeReceipt" type="button" name="button" class="btn bg-red waves-effect waves-float">
                                  Zatvori
                                </button></li>
                              </ul>
                          </div>
                          <div class="body">

                          </div>
                  </div>
              </div>
    <div class="container-fluid">
        <div class="block-header">
          <h2>Naplata proizvoda</h2>
        </div>
        <div class="container-fluid">
          <div class="row clearfix">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="card">
                      <div class="header">
                          <h2>
                              Napravi novi račun
                          </h2>
                      </div>
                      <div class="body">

                        <?php include_once "pages/funct/receipt.php" ?>

                      </div>
                  </div>
              </div>
          </div>
          <!-- #END# Basic Examples -->



        </div>
    </div>
  </section>
