<?php
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
$id = "1";
$sayfam = $ozy->query("select * from system where id=$id")->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['guncelle'])) {



   $kdvdahil = ($_POST['kdvdahil'] != "") ? $_POST['kdvdahil'] : "0";
   $kdv = ($_POST['kdv'] != "") ? $_POST['kdv'] : "0";
   $fiyatgizle = ($_POST['fiyatgizle'] != "") ? $_POST['fiyatgizle'] : "0";
   $genelkargo = ($_POST['genelkargo'] != "") ? $_POST['genelkargo'] : "0";
   $uyeonay = ($_POST['uyeonay'] != "") ? $_POST['uyeonay'] : "0";
   $rizametni = $_POST['rizametni'];
   $yorumgoster = ($_POST['yorumgoster'] != "") ? $_POST['yorumgoster'] : "0";
   $kvk = $_POST['kvk'];
   $iade = $_POST['iade'];
   $telefonal = ($_POST['telefonal'] != "") ? $_POST['telefonal'] : "0";
   $whatsapal = ($_POST['whatsapal'] != "") ? $_POST['whatsapal'] : "0";
   $sinirsizstok = ($_POST['sinirsizstok'] != "") ? $_POST['sinirsizstok'] : "0";
   $urungoster = ($_POST['urungoster'] != "") ? $_POST['urungoster'] : "0";
   $ucretsizkargo = ($_POST['ucretsizkargo'] != "") ? $_POST['ucretsizkargo'] : "0";
   $sozlesme = $_POST['sozlesme'];
   
   $id = "1";
   $stmt = $ozy->prepare("UPDATE system SET kdvdahil = ?,kdv = ?,fiyatgizle = ?,genelkargo = ?,uyeonay = ?,rizametni = ?,yorumgoster = ?,kvk = ?,iade = ?,telefonal = ?,whatsapal = ?,sinirsizstok = ?,urungoster = ?,ucretsizkargo = ?,sozlesme = ? WHERE id = ?");
   $result2 = $stmt->execute(array($kdvdahil, $kdv, $fiyatgizle, $genelkargo, $uyeonay, $rizametni, $yorumgoster, $kvk, $iade, $telefonal, $whatsapal, $sinirsizstok, $urungoster, $ucretsizkargo, $sozlesme, $id));




    if($result2){
    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=sistemayarlari">';

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';


   }






}








?>



<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Sistem Ayarları

						</h4>
                    </div>


                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                            <li class="breadcrumb-item active">Sistem Ayarları
							</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
			     <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                    <div class="card m-b-30">
                        <div class="card-body">
                         <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">
                                        <span class="d-none d-md-block">Genel Site Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-airplay h5"></i></span>
                                    </a>
                                </li>
                              
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#messages-1" role="tab">
                                        <span class="d-none d-md-block">Yasal Sözleşmeler</span><span class="d-block d-md-none"><i class="mdi mdi-guitar-pick-outline h5"></i></span>
                                    </a>
                                </li>

							

                            </ul>


                          <div class="tab-content">








                          <div class="tab-pane active p-3" id="home-1" role="tabpanel">
 
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Fiyat Giriş Şekli</label>
                                <div class="col-sm-10">

                                    <input id="demo-inline-form-radio" class="magic-radio" name="kdvdahil"
                                    value="0" <?php echo $sayfam['kdvdahil'] == '0' ? 'checked=""' : null; ?>
                                    type="radio">
                                    <label for="demo-inline-form-radio">KDV Dahil Fiyat</label>

                                    <input id="demo-inline-form-radio-2" class="magic-radio" name="kdvdahil"
                                    value="1" <?php echo $sayfam['kdvdahil'] == '1' ? 'checked=""' : null; ?>
                                    type="radio">
                                    <label for="demo-inline-form-radio-2">KDV Hariç Fiyat</label>

                                    <p class="text-muted">KDV Dahil Fiyat seçildiğinde genel KDV oranı 0 olarak ayarlanmalıdır.</p>
                                    <p class="text-muted">KDV Hariç Fiyat seçildiğinde ürünlere girilen fiyatlar otomatik olarak KDV oranı ile hesaplanacaktır.</p>

								</div>
                            </div>


                           <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Fiyatı Kimler Görebilir</label>
                            <div class="col-sm-10">

                            <input id="demo-inline-form-radio-3" class="magic-radio" name="fiyatgizle"
                            value="0" <?php echo $sayfam['fiyatgizle'] == '0' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-3">Herkes Görebilir</label>

                            <input id="demo-inline-form-radio-4" class="magic-radio" name="fiyatgizle"
                            value="1" <?php echo $sayfam['fiyatgizle'] == '1' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-4">Sadece Üyeler Görebilir</label>

								</div>
                            </div>




	                        <div class="form-group row">
		                    <label for="example-text-input" class="col-sm-2 col-form-label">Genel KDV Oranı</label>
		                    <div class="col-sm-10">
			                <input type="text" class="form-control" value="<?php echo $sayfam['kdv']; ?>" name="kdv">
			                <span class="input-group-addon"> %</span>
		                    </div>
	                        </div>


                            <div class="form-group row">
		                    <label for="example-text-input" class="col-sm-2 col-form-label">Genel Kargo Bedeli</label>
		                    <div class="col-sm-10">
			                <input type="text" class="form-control" value="<?php echo $sayfam['genelkargo']; ?>" name="genelkargo">
			                <span class="input-group-addon"> TL</span>
		                    </div>
	                        </div>

                            <div class="form-group row">
		                    <label for="example-text-input" class="col-sm-2 col-form-label">Ücretsiz Kargo Sepet Limiti</label>
		                    <div class="col-sm-10">
			                <input type="text" class="form-control" value="<?php echo $sayfam['ucretsizkargo']; ?>" name="ucretsizkargo">
			                <span class="input-group-addon"> TL</span>
		                    </div>
	                        </div>



                            <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Üyelik Onaylama Durumu</label>
                            <div class="col-sm-10">

                            <input id="demo-inline-form-radio-999" class="magic-radio" name="uyeonay"
                            value="0" <?php echo $sayfam['uyeonay'] == '0' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-999">Otomatik Onay</label>

                            <input id="demo-inline-form-radio-2999" class="magic-radio" name="uyeonay"
                            value="1" <?php echo $sayfam['uyeonay'] == '1' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-2999">Yönetici Onaylı</label>
							
							<input id="demo-inline-form-radio-299999999" class="magic-radio" name="uyeonay"
                            value="2" <?php echo $sayfam['uyeonay'] == '2' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-299999999">SMS ile Onay</label>
							
							<input id="demo-inline-form-radio-8888" class="magic-radio" name="uyeonay"
                            value="3" <?php echo $sayfam['uyeonay'] == '3' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-8888">Eposta ile Onay</label>

								</div>
                            </div>


                            <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>

                           <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Bloga Yorumu Kimler Yapabilir</label>
                            <div class="col-sm-10">

                            <input id="demo-inline-form-radio-3666666666" class="magic-radio" name="yorumgoster"
                            value="0" <?php echo $sayfam['yorumgoster'] == '0' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-3666666666">Herkes Yapabilir</label>

                            <input id="demo-inline-form-radio-47777777777777777777" class="magic-radio" name="yorumgoster"
                            value="1" <?php echo $sayfam['yorumgoster'] == '1' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-47777777777777777777">Sadece Üyeler Yapabilir</label>

								</div>
                            </div>
							
							<div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Ürüne Yorumu Kimler Yapabilir</label>
                            <div class="col-sm-10">

                            <input id="demo-inline-form-radio-3666666666111" class="magic-radio" name="urungoster"
                            value="0" <?php echo $sayfam['urungoster'] == '0' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-3666666666111">Herkes Yapabilir</label>

                            <input id="demo-inline-form-radio-47777777777777777777222" class="magic-radio" name="urungoster"
                            value="1" <?php echo $sayfam['urungoster'] == '1' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-47777777777777777777222">Sadece Üyeler Yapabilir</label>

								</div>
                            </div>
							
							

                          
                                <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Telefon İle Satın Al</label>
                                <div class="col-sm-7">
                                <input type="checkbox" <?php if($sayfam['telefonal'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="telefonal"></div>        
                                </div> 
                                
                                <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">WhatsApp İle Satın Al</label>
                                <div class="col-sm-7">
                                <input type="checkbox" <?php if($sayfam['whatsapal'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="whatsapal"></div>        
                                </div>  
                                <?php } ?>

                                <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                                <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Sınırsız Stoklu Ürün</label>
                                <div class="col-sm-7">
                                <input type="checkbox" <?php if($sayfam['sinirsizstok'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="sinirsizstok"></div>        
                                </div> 
                                <?php } ?>
							</div>













                          <div class="tab-pane fade p-3" id="messages-1" role="tabpanel">


		
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Üyelik Rıza Metni</label>
                                <div class="col-sm-10">
                                <textarea id="summernote" rows="6" name="rizametni"><?php echo $sayfam['rizametni']; ?></textarea>
								</div>
                                            
                            </div>	
								

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Site Kullanım Koşulları</label>
                                <div class="col-sm-10">
                                <textarea id="summernote2" rows="6" name="kvk"><?php echo $sayfam['kvk']; ?></textarea>
								</div>
                                            
                            </div>	


                           <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün İade & Değişim Şartları</label>
                                <div class="col-sm-10">
                                <textarea id="summernote3" rows="6" name="iade"><?php echo $sayfam['iade']; ?></textarea>
								</div>
                                            
                            </div>	

                           <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Mesafeli Satış Sözleşme Şartları</label>
                                <div class="col-sm-10">
                                <textarea id="summernote4" rows="6" name="sozlesme"><?php echo $sayfam['sozlesme']; ?></textarea>
								</div>
                                            
                            </div>	








						  </div>


















                                </div>







						 </div>







							 <button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>


                            </div>
							</form>

                        </div>
                    </div>
                </div> <!-- end col -->

            </div> <!-- end row -->

        </div>
        <!-- end container-fluid -->
    </div>
		<style>
.input-group-addon {
    padding: .375rem .75rem;
    margin-bottom: 0;
    font-size: 0.9rem !important;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    text-align: center;
    white-space: nowrap;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    float: right !important;
    margin-top: -36px !important;
}
	</style>