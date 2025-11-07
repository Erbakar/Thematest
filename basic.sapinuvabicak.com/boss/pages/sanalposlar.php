<?php
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
$id = "1";
$sayfam = $ozy->query("select * from system where id=$id")->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['guncelle'])) {



   $misafirok = ($_POST['misafirok'] != "") ? $_POST['misafirok'] : "0";
   $havaleok = ($_POST['havaleok'] != "") ? $_POST['havaleok'] : "0";
   $kapidaok = ($_POST['kapidaok'] != "") ? $_POST['kapidaok'] : "0";
   $kartok = ($_POST['kartok'] != "") ? $_POST['kartok'] : "0";
   $postip = ($_POST['postip'] != "") ? $_POST['postip'] : "0";
   $iyziapi = $_POST['iyziapi'];
   $iyzikey = ($_POST['iyzikey'] != "") ? $_POST['iyzikey'] : "0";
   $paytrid = $_POST['paytrid'];
   $paytrkey = $_POST['paytrkey'];
   $paytrsalt = ($_POST['paytrsalt'] != "") ? $_POST['paytrsalt'] : "0";
   $paytrtest = ($_POST['paytrtest'] != "") ? $_POST['paytrtest'] : "0";
   $shopapi = ($_POST['shopapi'] != "") ? $_POST['shopapi'] : "0";
   $shopkey = ($_POST['shopkey'] != "") ? $_POST['shopkey'] : "0";
   $kapitutar = ($_POST['kapitutar'] != "") ? $_POST['kapitutar'] : "0";

   
   
   $id = "1";
   $stmt = $ozy->prepare("UPDATE system SET misafirok = ?,havaleok = ?,kapidaok = ?,kartok = ?,postip = ?,iyziapi = ?,iyzikey = ?,paytrid = ?,paytrkey = ?,paytrsalt = ?,paytrtest = ?,shopapi = ?,shopkey = ?,kapitutar = ? WHERE id = ?");
   $result2 = $stmt->execute(array($misafirok, $havaleok, $kapidaok, $kartok, $postip, $iyziapi, $iyzikey, $paytrid, $paytrkey, $paytrsalt, $paytrtest, $shopapi, $shopkey, $kapitutar, $id));




    if($result2){
    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=sanal-poslar">';

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
                        <h4 class="page-title">Sanal Pos Ayarları

						</h4>
                    </div>


                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                            <li class="breadcrumb-item active">Sanal Pos Ayarları
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
                                        <span class="d-none d-md-block">Genel Ödeme Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-airplay h5"></i></span>
                                    </a>
                                </li>
                              
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#messages-1" role="tab">
                                        <span class="d-none d-md-block">PayTR Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-guitar-pick-outline h5"></i></span>
                                    </a>
                                </li>

								 <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#messages-2" role="tab">
                                        <span class="d-none d-md-block">İyzico Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-format-align-justify h5"></i></span>
                                    </a>
                                </li>
								
								<li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#messages-3" role="tab">
                                        <span class="d-none d-md-block">Shopier Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-format-align-justify h5"></i></span>
                                    </a>
                                </li>

                            </ul>


                          <div class="tab-content">








                          <div class="tab-pane active p-3" id="home-1" role="tabpanel">

                                <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Misafir Alışverişi</label>
                                <div class="col-sm-7">
                                <input type="checkbox" <?php if($sayfam['misafirok'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="misafirok"></div>        
                                </div> 
								
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Havale / EFT Modülü</label>
                                <div class="col-sm-7">
                                <input type="checkbox" <?php if($sayfam['havaleok'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="havaleok"></div>        
                                </div> 
								
								
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Kapıda Ödeme Modülü</label>
                                <div class="col-sm-7">
                                <input type="checkbox" id="kapidadurum" <?php if($sayfam['kapidaok'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="kapidaok"></div>        
                                </div> 
								
							    <div class="form-group row" id="kapifiyat" style="<?php if($sayfam['kapidaok'] !== '1') {?> display:none; <?php } ?> ">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Kapıda Ödeme Ekstra Kargo Fiyatı</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $sayfam['kapitutar']; ?>" name="kapitutar">
                                <span class="input-group-addon"> TL</span>
                                </div>
                                </div>	

								
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Kredi Kartı Modülü</label>
                                <div class="col-sm-7">
                                <input type="checkbox" <?php if($sayfam['kartok'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="kartok"></div>        
                                </div> 
								
								


							<div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Aktif POS Sistemi</label>
                            <div class="col-sm-10">

                            <input id="demo-inline-form-radio" class="magic-radio" name="postip"
                            value="0" <?php echo $sayfam['postip'] == '0' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio">PayTR</label>

                            <input id="demo-inline-form-radio-2" class="magic-radio" name="postip"
                            value="1" <?php echo $sayfam['postip'] == '1' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-2">İyzico</label>
							
							 <input id="demo-inline-form-radio-3" class="magic-radio" name="postip"
                            value="2" <?php echo $sayfam['postip'] == '2' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-3">Shopier</label>

								</div>
                            </div>


                    

                      


                           


							
							



							</div>













                          <div class="tab-pane fade p-3" id="messages-1" role="tabpanel">

                                <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">PayTR Bildirim URL</label>
                                <div class="col-sm-8">
                                <b style="color: #30419b;"><?php echo $ayar['siteurl'];?>/paytrcallback.php</b>
								</div> 
								</div> 

		
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">PayTR Merchant İD</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="paytrid" value="<?php echo $sayfam['paytrid']; ?>">
                                </div>
                            </div>
						
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">PayTR Merchant KEY</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="paytrkey" value="<?php echo $sayfam['paytrkey']; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">PayTR Merchant SALT</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="paytrsalt" value="<?php echo $sayfam['paytrsalt']; ?>">
                                </div>
                            </div>

                                <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">PayTR Test Sistemi</label>
                                <div class="col-sm-7">
                                <input type="checkbox" <?php if($sayfam['paytrtest'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="paytrtest"></div>        
                                </div> 


						  </div>




                       <div class="tab-pane fade p-3" id="messages-2" role="tabpanel">

 
		
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">İyzico Api Anahtarı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="iyziapi" value="<?php echo $sayfam['iyziapi']; ?>">
                                </div>
                            </div>
						
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">İyzico Güvenlik Anahtarı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="iyzikey" value="<?php echo $sayfam['iyzikey']; ?>">
                                </div>
                            </div>

                          


						  </div>







                          <div class="tab-pane fade p-3" id="messages-3" role="tabpanel">

                                <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Shopier Bildirim URL</label>
                                <div class="col-sm-8">
                                <b style="color: #30419b;"><?php echo $ayar['siteurl'];?>/shopiersonuc.php</b>
								</div> 
								</div> 

		
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Shopier Api Anahtarı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="shopapi" value="<?php echo $sayfam['shopapi']; ?>">
                                </div>
                            </div>
						
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Shopier Key Anahtarı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="shopkey" value="<?php echo $sayfam['shopkey']; ?>">
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