<?php
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/dbh.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/adminDashboard/pregledKorisnik.class.php";
?>
<div class="container-fluid">
    <div class="block-header">
        <h2>Pregled korisnika</h2>
    </div>
    <div class="container-fluid">

                <!-- Basic Examples -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    Pregled Korisnika
                                </h2>

                                <ul class="header-dropdown m-r--5">

                                    <li>
                                      <div class="row clearfix js-sweetalert">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                          <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-type="basic" data-target="#modal_dodaj_korisnika">Dodaj Novog Korisnika</button>
                                          </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                <div id="content-table-show"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Basic Examples -->

                <!-- #END# Exportable Table -->
            </div>
          </div>
          <!--- END TESTING PHASE ABOVE ---->


            <!-- Modal Dialogs ====================================================================================================================== -->
   <!-- Dodaj Novog Korisnika :: Default Size -->
   <div class="modal fade" id="modal_dodaj_korisnika" tabindex="-1" role="dialog">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title" id="defaultModalLabel">Dodaj Novog korisnika</h4>
               </div>
               <div class="modal-body">
                 <div id="resultMsgAddUsr"></div>

                  <form id ="dodajKorisnikaForma" method="POST" action="/dashboard/admin/pages/content/php_and_jsAjax/pregled_korisnika_php.php">
                    <table class="padding10pxTD center">
                      <tr>
                        <td><label for="username">Korisničko ime </label></td>
                        <td><input required="required" type="text" name="username" value=""></td>
                      </tr>
                      <tr>
                        <td><label for="password">Lozinka </label></td>
                        <td><input required="required" type="password" name="password" value=""></td>
                      </tr>
                      <tr>
                        <td><label for="tip_naloga">Tip naloga </label></td>
                        <td>
                          <input name="tip" type="radio" id="radio_1" class="with-gap" value="1" />
                          <label for="radio_1">Administrator</label>
                            <br/>
                            <input name="tip" type="radio" id="radio_2" class="with-gap" value="2" checked />
                            <label for="radio_2">Radnik</label>
                        </td>
                      </tr>
                      <tr>
                        <td> <input type="hidden" name="formName" value="form1"/> </td>
                        <td><button type="submit" class="btn btn-success waves-effect">Dodaj korisnika</button></td>
                      </tr>
                    </table>
                  </form>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Otkaži</button>
               </div>

           </div>
       </div>
   </div> <!-- END modal dodaj novog korisnika -->
   <!-- Obriši:: Default Size -->
   <div class="modal fade" id="modal_obrisi" tabindex="-1" role="dialog">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title" id="defaultModalLabel">Obrišite korisnika</h4>
               </div>
               <div class="modal-body">
                 <div id="resultMsgDelUsr"></div>
                  <form  id ="izbrisiKorisnikaForma" method="POST" action="/dashboard/admin/pages/content/php_and_jsAjax/pregled_korisnika_php.php">
                    <input type="hidden" name="formName" value="form3"/>
                    <table class="padding10pxTD center">
                      <tr>
                        <td> <p>Korisničko ime:</p> </td>
                        <td> <p id="obrisi_k_ime"></p> </td>
                      </tr>
                        </td>
                      </tr>
                      <tr>
                        <td><button type="submit" class="btn bg-red waves-effect">Obriši korisnika</button></td>
                      </tr>
                    </table>
                  </form>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Otkaži</button>
               </div>
           </div>
       </div>
   </div> <!-- END modal Obriši -->
