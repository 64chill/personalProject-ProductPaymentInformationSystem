<div class="container-fluid">
    <div class="block-header">
        <h2>Glavni Podaci</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <!-- Graph 1


         -->
            <div class="card">
              <div class="header">
                <h2>Pregled ukupne zarade</h2>
              </div>
              <form class="marginTop15px" action="" method="POST" id="form1_graph" name="form1_graph">
                <div class="row clearfix">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-3">
                      <div class="form-group">
                          <div class="form-line">
                            <label for="odDatum1">Od Datuma</label>
                              <input id="form1input1" type="date" class="form-control" placeholder="col-sm-6" name="odDatum1" value="<?php echo date('Y-m-d', strtotime('-1 months'));?>" />
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-3">
                      <div class="form-group">
                          <div class="form-line">
                            <label for="doDatum1">Do Datuma</label>
                              <input id="form1input2" type="date" class="form-control" placeholder="col-sm-6" name="doDatum1" value="<?php echo date('Y-m-d'); ?>" />
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-2">
                    <button type="submit" class="btn btn-success waves-effect marginTop15px">Učitaj</button>
                  </div>
                </div>
              </form>
              <div class="row">
                <div class="col-sm-4"></div>
                <div class="">
                  <button id="modalBtn-zarada" type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-type="basic" data-target="#modal_pregled_zarade">Tabelarni prikaz ukupne zarade</button>
                </div>

              </div>
              <div id="pre1" class='preloader pl-size-l'><div class='spinner-layer pl-blue'> <div class='circle-clipper left'> <div class='circle'></div> </div> <div class='circle-clipper right'> <div class='circle'></div> </div></div></div>
              <div id="chart1"></div>
          </div>
          <!-- Graph 2


         -->
          <div class="card">
            <div class="header">
              <h2>10 Najprodavanijih proizvoda u određenom periodu</h2>
              <form class="marginTop15px" action="" method="POST" id="form2_graph" name="form2_graph">
                <div class="row clearfix">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-3">
                      <div class="form-group">
                          <div class="form-line">
                            <label for="odDatum1">Od Datuma</label>
                              <input id="form2input1" type="date" class="form-control" placeholder="col-sm-6" name="odDatum1form2" value="<?php echo date('Y-m-d', strtotime('-1 months'));?>" />
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-3">
                      <div class="form-group">
                          <div class="form-line">
                            <label for="doDatum1">Do Datuma</label>
                              <input id="form2input2" type="date" class="form-control" placeholder="col-sm-6" name="doDatum1form2" value="<?php echo date('Y-m-d'); ?>" />
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-2">
                    <button type="submit" class="btn btn-success waves-effect marginTop15px">Učitaj</button>
                  </div>

                </div>
              </form>
            </div>
              <div class="row">
                  <div class="col-md-2"></div>
                <div class="col-md-4">
                <div id="pre2" class='preloader pl-size-l'><div class='spinner-layer pl-blue'> <div class='circle-clipper left'> <div class='circle'></div> </div> <div class='circle-clipper right'> <div class='circle'></div> </div></div></div>
                <div id="chart2"></div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4" id="productTable"></div>

              </div>

        </div>
        <!-- Graph 3

       -->
        <div class="card graph3">
          <div class="header">
            <h2>Poredi dva proizvoda po prodaji i zaradi</h2>
            <form class="marginTop15px" action="" method="POST" id="form3_graph" name="form3_graph">
              <div class="row clearfix">
                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="form-line">
                      <label for="status3">Status</label>
                        <select name="status3" class="form-control show-tick" >
                           <option value="1">zarada</option>
                           <option value="2">br prodatih</option>
                          </select>
                    </div>
                </div>
              </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <div class="form-line">
                          <label for="odDatum3">Od Datuma</label>
                            <input id="form2input1" type="date" class="form-control" placeholder="col-sm-6" name="odDatum1form3" value="<?php echo date('Y-m-d', strtotime('-1 months'));?>" />
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <div class="form-line">
                          <label for="doDatum3">Do Datuma</label>
                            <input id="form2input2" type="date" class="form-control" placeholder="col-sm-6" name="doDatum1form3" value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"><div class="form-group">
                    <div class="form-line">
                      <label for="sp1">Sifra Proizvoda 1</label>
                        <input maxlength="13" id="sp1" type="text" class="form-control" placeholder="sifra proizvoda 1" name="sp1" autocomplete="off" />
                        <div id="live-search-suggestion1"></div>
                    </div>
                </div></div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="form-line">
                      <label for="sp2">Sifra Proizvoda 2</label>
                        <input maxlength="13" id="sp2" type="text" class="form-control" placeholder="sifra proizvoda 2" name="sp2" autocomplete="off" />
                        <div id="live-search-suggestion2"></div>
                    </div>
                </div>
              </div>
                <div class="col-sm-2">
                  <button type="submit" name="changeSubmit" class="btn btn-success waves-effect marginTop15px">Učitaj</button>
                </div>

              </div>
            </form>
          </div>
          <!--- -->
            <div id="pre3" class='preloader pl-size-l'><div class='spinner-layer pl-blue'> <div class='circle-clipper left'> <div class='circle'></div> </div> <div class='circle-clipper right'> <div class='circle'></div> </div></div></div>
          <div id="chart3"></div>
      </div>
        </div>
    </div>


  </div>

  <!-- Pregled ukupne zarade:: Default Size -->
   <div class="modal fade" id="modal_pregled_zarade" tabindex="-1" role="dialog">
       <div class="modal-dialog" role="document">
           <div class="modal-content modal-lg">
               <div class="modal-header">
                   <h4 class="modal-title" id="defaultModalLabel">Tabelarni prikaz ukupne zarade</h4>
               </div>
               <div class="modal-body">
                 <div>
                   <table class="table table-bordered table-striped dataTable" id="salesTable">
                   </table>
                 </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Otkaži</button>
               </div>

           </div>
       </div>
   </div> <!-- END modal Pregled ukupne zarade -->
