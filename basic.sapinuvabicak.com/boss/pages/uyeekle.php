<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 8); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$ekresimid = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from users where id=$id")->fetch(PDO::FETCH_ASSOC); 
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



  $isim   = temizle($_POST['isim']);
  $email   = temizle($_POST['email']);
  $telefon   = temizle($_POST['telefon']);
  $sifre   = md5($_POST['sifre']);
  $onay   = temizle($_POST['onay']);
  $tarih   = date('d.m.Y H:i:s');
  $uyetip   = temizle($_POST['uyetip']);
  $tc   = temizle($_POST['tc']);
  $vergi1   = temizle($_POST['vergi1']);
  $vergi2   = temizle($_POST['vergi2']);
  $vergi3   = temizle($_POST['vergi3']);
  $sifretip   = temizle($_POST['sifretip']);
  
  
  if($sifretip=='1'){
   
   
  
   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE users SET isim = ?, email = ?, telefon = ?, onay = ?, tarih = ?, uyetip = ?, tc = ?, vergi1 = ?, vergi2 = ?, vergi3 = ?, sifre = ? WHERE id = ?");
   $result2 = $stmt->execute(array($isim, $email, $telefon, $onay, $tarih, $uyetip, $tc, $vergi1, $vergi2, $vergi3, $sifre, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi ve şifreyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/uye/duzenle/'.$id.'">'; 	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   } 
   
   
   
   }else{
   
   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE users SET isim = ?, email = ?, telefon = ?, onay = ?, tarih = ?, uyetip = ?, tc = ?, vergi1 = ?, vergi2 = ?, vergi3 = ? WHERE id = ?");
   $result2 = $stmt->execute(array($isim, $email, $telefon, $onay, $tarih, $uyetip, $tc, $vergi1, $vergi2, $vergi3, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/uye/duzenle/'.$id.'">'; 	 	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }

}









	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



////Sayfa güncelleme kodları bitiş

}else{
	

 
if (isset($_POST['kaydet'])) {
	
  $isim   = temizle($_POST['isim']);
  $email   = temizle($_POST['email']);
  $telefon   = temizle($_POST['telefon']);
  $sifre   = md5($_POST['sifre']);
  $onay   = temizle($_POST['onay']);
  $tarih   = date('d.m.Y H:i:s');
  $uyetip   = temizle($_POST['uyetip']);
  $tc   = temizle($_POST['tc']);
  $vergi1   = temizle($_POST['vergi1']);
  $vergi2   = temizle($_POST['vergi2']);
  $vergi3   = temizle($_POST['vergi3']);
  
 
  $emailkontrol = $ozy->prepare("SELECT * FROM users WHERE email=?");
  $emailkontrol->execute(array($email));
  if ($emailkontrol->rowCount()) {
	
  echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bu eposta hesabı ile daha önce kayıt oluşturulmuş.", "Başarısız");});</script>';
    	
   }else {
   $stmt = $ozy->prepare("INSERT INTO users (isim, email, telefon, sifre, onay, tarih, sozlesme, uyetip, tc, vergi1, vergi2, vergi3) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
   $result2 = $stmt->execute(array($isim, $email, $telefon, $sifre, $onay, $tarih,1, $uyetip, $tc, $vergi1, $vergi2, $vergi3));
   $id = $ozy->lastInsertId();
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=tum-uyeler">'; 	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }
}







}

////Sayfa oluşturma kodları bitiş






}

	
	



?>




<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Üye 
						<?php if($_GET['duzenle']){?>
						Düzenle
						<?php } else { ?>
                        Ekle
						<?php } ?>
						</h4>
                    </div>
					

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                            
                            <li class="breadcrumb-item active">Üye 
							<?php if($_GET['duzenle']){?>
						    Düzenle
						    <?php } else { ?>
                            Ekle
						    <?php } ?>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Adı Soyadı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="isim" value="<?php echo $sayfam['isim']; ?>" required>
                                </div>
                            </div>
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Eposta Adresi</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="email" value="<?php echo $sayfam['email']; ?>" required>
                                </div>
                            </div>
							
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Telefon Numarası</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="telefon" value="<?php echo $sayfam['telefon']; ?>" required>
                                </div>
                            </div>
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Üyelik Tipi</label>
                                <div class="col-sm-10">
                                <input <?php echo $sayfam['uyetip'] == '0' ? 'checked' : null; ?> value="0" name="uyetip" type="radio" class="login-check" id="register-check-20" required> 
							    Bireysel  
								<input <?php echo $sayfam['uyetip'] == '1' ? 'checked' : null; ?> value="1" name="uyetip" type="radio" class="login-check" id="register-check-20" required> 
							    Kurumsal
                                </div>
                            </div>
							
							
					       <div class="form-group row" id="bireysel">	
                                <label for="example-text-input" class="col-sm-2 col-form-label">TC. Numarası</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="tc" size="11" maxlength="11" value="<?php echo $sayfam['tc']; ?>">
                                </div>
                            </div>
							
							
							
							<div class="form-group row" id="kurumsal" style="<?php echo $sayfam['uyetip'] == '1' ? 'display:block !important;' : null; ?>display:none;">	 	
                                <label for="example-text-input" class="col-sm-2 col-form-label">Firma Adı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="vergi1"  value="<?php echo $sayfam['vergi1']; ?>">
                                </div>
                            </div>
							
							<div class="form-group row" id="kurumsal2" style="<?php echo $sayfam['uyetip'] == '1' ? 'display:block !important;' : null; ?>display:none;">	 	
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vergi Dairesi Adı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="vergi2"  value="<?php echo $sayfam['vergi2']; ?>">
                                </div>
                            </div>
							
							
							<div class="form-group row" id="kurumsal3" style="<?php echo $sayfam['uyetip'] == '1' ? 'display:block !important;' : null; ?>display:none;">	 	
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vergi No</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="vergi3"  value="<?php echo $sayfam['vergi3']; ?>">
                                </div>
                            </div>
							
						
						
						
							
							<?php if($_GET['duzenle']){?>	
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Şifre Yenileme</label>
                                <div class="col-sm-10">
                                <input <?php echo $sayfam['sifretip'] == '0' ? 'checked' : null; ?> value="1" name="sifretip" type="radio" class="login-check" id="register-check-20"> 
							    Şifreyi Güncellemek istiyorum  
                                </div>
                            </div>
							
							<div class="form-group row" id="sifre1" style="display:none;">	 	
                                <label for="example-text-input" class="col-sm-2 col-form-label">Yeni Şifreniz</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" name="sifre"  value="<?php echo $sayfam['sifre']; ?>">
                                </div>
                            </div>
							
						
							<?php } else { ?>
							<div class="form-group row">	 	
                                <label for="example-text-input" class="col-sm-2 col-form-label">Şifresi</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" name="sifre"  value="<?php echo $sayfam['sifre']; ?>">
                                </div>
                            </div>
							
							<?php } ?> 
							
							
							
							
							
							
						 <?php if($_GET['duzenle']){?>
						  <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['onay'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="onay"></div>
                                            
                          </div>   
                        <?php } else { ?>
						 <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                <div class="col-sm-10">
                                <input type="checkbox"  checked="" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="onay"></div>
                                            
                          </div> 

						<?php } ?>   
							
							
								
						
								
								
								
								
							</div>
                                 


		
						
						
                                </div>




                         <?php if($_GET['duzenle']){?>
						  
						  <button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>
                         
                          <?php } else { ?>
						 
                          <button type="submit" name="kaydet" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Kaydet</button>
                         
						
								 
                         <?php } ?>     

			             
						 
						 </div>	
								
								
								
								
								
								
								
								
								
                            </div>
							</form>
                            
                        </div>
                    </div>
                </div> <!-- end col -->
	
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>