<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from kargolar where id=$id")->fetch(PDO::FETCH_ASSOC); 
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



  $adi   = temizle($_POST['adi']);
  if($_POST['seo']==''){
  $seo		= seo($adi);
  } else {  
  $seo		= seo($_POST['seo']);
  }
  $durum   = temizle($_POST['durum']);
  $link   = temizle($_POST['link']);
  $tarih   = date('d.m.Y H:i:s');

  $reskonum  = $_FILES['resim']['tmp_name'];
  $resad     = $_FILES['resim']['name'];
  $restip    = $_FILES['resim']['type'];
  $uzanti      = substr($resad, -5,5);
  $resimadi      = md5(uniqid(rand(time($resad)))).$uzanti;
  $yol         = "../resimler/kargolar";
  

  
   if (!empty($_FILES['resim']['name'])) {
   if($restip != 'image/jpeg'  && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg'){
   echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

   }else{
	   
   $ekle = move_uploaded_file($reskonum, $yol.'/'.$resimadi);   
   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE kargolar SET adi = ?, seo = ?, link = ?, durum = ?, sira = ?, resim = ? WHERE id = ?");
   $result2 = $stmt->execute(array($adi, $seo, $link, $durum, $sira, $resimadi ,$id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/kargo/duzenle/'.$id.'">';	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }






}

 }else{ 



   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE kargolar SET adi = ?, seo = ?, link = ?, durum = ?, sira = ? WHERE id = ?");
   $result2 = $stmt->execute(array($adi, $seo, $link, $durum, $sira, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/kargo/duzenle/'.$id.'">';	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }






}
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



////Sayfa güncelleme kodları bitiş

}else{
	

////Sayfa oluşturma kodları başlangıç	
 
if (isset($_POST['kaydet'])) {
	
  $adi   = temizle($_POST['adi']);
  $aciklama   = $_POST['aciklama'];
  $seo		= seo($adi);
  $durum   = temizle($_POST['durum']);
  $link   = temizle($_POST['link']);
  $tarih   = date('d.m.Y H:i:s');

  $reskonum  = $_FILES['resim']['tmp_name'];
  $resad     = $_FILES['resim']['name'];
  $restip    = $_FILES['resim']['type'];
  $uzanti      = substr($resad, -5,5);
  $resimadi      = md5(uniqid(rand(time($resad)))).$uzanti;
  $yol         = "../resimler/kargolar";
  
   if (empty($_FILES['resim']['name'])) {
	  
   $resimadi = "resimyok.jpg";
   $stmt = $ozy->prepare("INSERT INTO kargolar (adi, seo, durum, link, tarih, resim) 
   VALUES (?,?,?,?,?,?)");
   $result2 = $stmt->execute(array($adi, $seo, $durum, $link, $tarih, $resimadi));
   $id = $ozy->lastInsertId();
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=tum-kargolar">'; 		

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }
   
   
  }else{
  
  
  
   if($restip != 'image/jpeg'  && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg'){
   echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

   }else{
	   
   $ekle = move_uploaded_file($reskonum, $yol.'/'.$resimadi);   
   
   $stmt = $ozy->prepare("INSERT INTO kargolar (adi, seo, durum, link, tarih, resim) 
   VALUES (?,?,?,?,?,?)");
   $result2 = $stmt->execute(array($adi, $seo, $durum, $link, $tarih, $resimadi));
   $id = $ozy->lastInsertId();
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=tum-kargolar">'; 	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }






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
                        <h4 class="page-title">Kargo 
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
                            
                            <li class="breadcrumb-item active">Kargo 
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
						  
						  
						  
						  
						  
						  

        
							
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Kargo Sırası </br>(En başa almak için en yüksek sayıyı veriniz)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="sira" value="<?php echo $sayfam['sira']; ?>">
                                </div>
                            </div>
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Firma Adı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="adi" value="<?php echo $sayfam['adi']; ?>" required>
                                </div>
                            </div>
							
							 <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Kargo Takip URL</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="link" value="<?php echo $sayfam['link']; ?>">
                                </div>
                            </div>
							
							
							
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Firma Resmi</label>
                                <div class="col-sm-10">
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									<?php if($_GET['duzenle']){?>
									<img src="../resimler/kargolar/<?php echo $sayfam['resim']; ?>" style="width: 200px; height: 200px;" alt="" />
                                    <?php } else { ?>
									<img src="assets/images/resimyok.jpg" alt="" />
									<?php }?>
									
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                    <span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                    <input name="resim" type="file" class="default" />
                                    </span>
                                    <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                    </div>
                                    </div>
                                    </div>
                                   
								</div>
                                            
                            </div>	
								
							
							
						 <?php if($_GET['duzenle']){?>
						  <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['durum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>
                                            
                          </div>   
                        <?php } else { ?>
						 <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                <div class="col-sm-10">
                                <input type="checkbox"  checked="" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>
                                            
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