<?php
paket_kontrol(["plus", "extreme", "enterprise"]);  
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
$id = "1";
$sayfam = $ozy->query("select * from system where id=$id")->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['guncelle'])) {



   $stelefon = temizle($_POST['stelefon']);
   $sadi = temizle($_POST['sadi']);
   $ssifre = temizle($_POST['ssifre']);
   $sbaslik = temizle($_POST['sbaslik']);
   $sebultenonay = ($_POST['sebultenonay'] != "") ? $_POST['sebultenonay'] : "0";
   $sblogonay = ($_POST['sblogonay'] != "") ? $_POST['sblogonay'] : "0";
   $siletisimonay = ($_POST['siletisimonay'] != "") ? $_POST['siletisimonay'] : "0";
   $suyeblogonay = ($_POST['suyeblogonay'] != "") ? $_POST['suyeblogonay'] : "0";
   $surunonay = ($_POST['surunonay'] != "") ? $_POST['surunonay'] : "0";
   $suyeurunonay = ($_POST['suyeurunonay'] != "") ? $_POST['suyeurunonay'] : "0";
   $scekgonder = ($_POST['scekgonder'] != "") ? $_POST['scekgonder'] : "0";
   $ssiparisonay = ($_POST['ssiparisonay'] != "") ? $_POST['ssiparisonay'] : "0";
   $sadminsiparisonay = ($_POST['sadminsiparisonay'] != "") ? $_POST['sadminsiparisonay'] : "0";
   $sdestekonay = ($_POST['sdestekonay'] != "") ? $_POST['sdestekonay'] : "0";
   $sadmindestekonay = ($_POST['sadmindestekonay'] != "") ? $_POST['sadmindestekonay'] : "0";
   $ssifrehatirlat = ($_POST['ssifrehatirlat'] != "") ? $_POST['ssifrehatirlat'] : "0";
   
   $id = "1";
   $stmt = $ozy->prepare("UPDATE system SET stelefon = ?,sadi = ?,ssifre = ?,sbaslik = ?,sebultenonay = ?,sblogonay = ?,siletisimonay = ?,suyeblogonay = ?,surunonay = ?,suyeurunonay = ?,scekgonder = ?,ssiparisonay = ?,sadminsiparisonay = ?,sdestekonay = ?,sadmindestekonay = ?,ssifrehatirlat = ? WHERE id = ?");
   $result2 = $stmt->execute(array($stelefon, $sadi, $ssifre, $sbaslik, $sebultenonay, $sblogonay, $siletisimonay, $suyeblogonay, $surunonay, $suyeurunonay, $scekgonder, $ssiparisonay, $sadminsiparisonay, $sdestekonay, $sadmindestekonay, $ssifrehatirlat, $id));




    if($result2){
    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=sms-servisleri">';

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
                        <h4 class="page-title">SMS Ayarları

						</h4>
                    </div>


                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                            <li class="breadcrumb-item active">SMS Ayarları
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
                         


                          <div class="tab-content">








                          <div class="tab-pane active p-3" id="home-1" role="tabpanel">






	                        <div class="form-group row">
		                    <label for="example-text-input" class="col-sm-2 col-form-label">SMS Bildirim Telefonu (Admin)</label>
		                    <div class="col-sm-10">
			                <input type="text" class="form-control" value="<?php echo $sayfam['stelefon']; ?>" name="stelefon">
		                    </div>
	                        </div>
							
							
							<div class="form-group row">
		                    <label for="example-text-input" class="col-sm-2 col-form-label">Netgsm Kullanıcı Adı</label>
		                    <div class="col-sm-10">
			                <input type="text" class="form-control" value="<?php echo $sayfam['sadi']; ?>" name="sadi">
		                    </div>
	                        </div>
							
							
							<div class="form-group row">
		                    <label for="example-text-input" class="col-sm-2 col-form-label">Netgsm Şifre</label>
		                    <div class="col-sm-10">
			                <input type="password" class="form-control" value="<?php echo $sayfam['ssifre']; ?>" name="ssifre">
		                    </div>
	                        </div>
							
							<div class="form-group row">
		                    <label for="example-text-input" class="col-sm-2 col-form-label">Netgsm Başlık</label>
		                    <div class="col-sm-10">
			                <input type="text" class="form-control" value="<?php echo $sayfam['sbaslik']; ?>" name="sbaslik">
		                    </div>
	                        </div>
							
							
							
							
                          <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ebülten Kaydı Bildirimi </br>( Yönetici Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['sebultenonay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="sebultenonay"></div>
                                            
                          </div>   

                         <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Yorumu Bildirimi </br>( Yönetici Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['sblogonay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="sblogonay"></div>
                                            
                          </div>  

						

                          <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">İletişim Formu Bildirimi </br>( Yönetici Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['siletisimonay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="siletisimonay"></div>
                                            
                          </div> 

                          
                           <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Yorumu Bildirimi </br>( Yönetici Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['surunonay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="surunonay"></div>
                                            
                           </div>  

						

                          <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Hediye Çeki Bildirimi </br>( Üye Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['scekgonder'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="scekgonder"></div>
                                            
                          </div> 
						  
						  <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Sipariş Bildirimi </br>( Üye Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['ssiparisonay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ssiparisonay"></div>
                                            
                          </div>
						  
						  
						  <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Sipariş Bildirimi </br>( Yönetici Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['sadminsiparisonay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="sadminsiparisonay"></div>
                                            
                          </div>
						  
						  <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Destek Talebi Bildirimi </br>( Üye Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['sadmindestekonay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="sadmindestekonay"></div>
                                            
                          </div>
						  
						  
						  <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Destek Talebi Bildirimi </br>( Yönetici Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['sdestekonay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="sdestekonay"></div>
                                            
                          </div>
						  
						  
		


                         <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Şifremi Unuttum </br>( Üye Bildirimi )</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['ssifrehatirlat'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ssifrehatirlat"></div>
                                            
                         </div>



							</div>













                          <div class="tab-pane fade p-3" id="messages-1" role="tabpanel">


		
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Üyelik Rıza Metni</label>
                                <div class="col-sm-10">
                                <textarea id="summernote" rows="6" name="rizametni"><?php echo $sayfam['rizametni']; ?></textarea>
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