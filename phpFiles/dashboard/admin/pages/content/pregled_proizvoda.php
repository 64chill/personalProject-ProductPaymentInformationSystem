<?php
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/dbh.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/adminDashboard/pregledProizvod.class.php";
?>
<div class="container-fluid">
    <div class="block-header">
        <h2>Pregled proizvoda</h2>
    </div>


        <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Pregled Proizvoda
                                    </h2>

                                    <ul class="header-dropdown m-r--5">

                                        <li>
                                          <div class="row clearfix js-sweetalert">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                              <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-type="basic" data-target="#modal_dodaj_proizvod">Dodaj Nov Proizvod</button>
                                              </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body">
                                  <button class="bg-green btn" id="getXML" type="button" name="button">Preuzmi XML fajl cele tabele</button>
                                  <!--a id="getXML" href="#" download>Click here to download</a-->
                                    <div id="content-table-show"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Dialogs ====================================================================================================================== -->
       <!-- Dodaj Nov Proizvod:: Default Size -->
       <div class="modal fade" id="modal_dodaj_proizvod" tabindex="-1" role="dialog">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="defaultModalLabel">Dodaj Proizvod</h4>
                   </div>
                   <div class="modal-body">
                     <div id="resultMsgAddProduct"></div>

                      <form id ="dodajProizvodForma" method="POST" action="/dashboard/admin/pages/content/php_and_jsAjax/pregled_proizvoda_php.php">
                        <table class="padding10pxTD center">
                          <tr>
                            <td><label for="naziv_proizvoda">Naziv Proizvoda</label></td>
                            <td><input required="required" type="text" name="naziv_proizvoda" value=""></td>
                          </tr>
                          <tr>
                            <td><label for="cena_proizvoda">Cena </label></td>
                            <td><input required="required" type="number" name="cena_proizvoda" value=""></td>
                          </tr>
                          <tr>
                            <td><label for="barkod_proizvoda">Barkod </label></td>
                            <td><input required="required" type="number" name="barkod_proizvoda" value=""></td>
                          </tr>
                          <tr>
                            <td><label for="kolicina_proizvoda">Kolicina </label></td>
                            <td><input required="required" type="number" name="kolicina_proizvoda" value=""></td>
                          </tr>
                          <tr>
                            <td><label for="jedinica_mere_proizvoda">Jedinica Mere </label></td>
                            <td><input required="required" type="text" name="jedinica_mere_proizvoda" value=""></td>
                          </tr>
                          <tr>
                            <td><label for="naziv_kompanije_proizvoda">Naziv Kompanije</label></td>
                            <td>
                              <select class="form-control show-tick" data-live-search="true" name="naziv_kompanije_proizvoda">
                                <?php  $obj = new PregledProizvod();
                                echo $obj->get_option_product_companies(); ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td> <input type="hidden" name="formName" value="form1_proizvod"/> </td>
                            <td><button type="submit" class="btn btn-success waves-effect">Dodaj Proizvod</button></td>
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
