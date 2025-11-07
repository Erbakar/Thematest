<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 7); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$ekresimid = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from slider where id=$id")->fetch(PDO::FETCH_ASSOC); 
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



  $adi   = temizle($_POST['adi']);
  $aciklama   = $_POST['aciklama']; 
  $link		= $_POST['link'];
  $hit   = "0";
  $durum   = temizle($_POST['durum']);
  $sira   = temizle($_POST['sira']);
  $seodurum   = temizle($_POST['seodurum']);
  $stitle   = temizle($_POST['stitle']);
  $skey   = temizle($_POST['skey']);
  $sdesc   = temizle($_POST['sdesc']);
  $tarih   = date('d.m.Y H:i:s');

  $reskonum  = $_FILES['resim']['tmp_name'];
  $resad     = $_FILES['resim']['name'];
  $restip    = $_FILES['resim']['type'];
  $uzanti      = substr($resad, -5,5);
  $resimadi      = md5(uniqid(rand(time($resad)))).$uzanti;
  $yol         = "../resimler/slider";
 

 
  
   if (!empty($_FILES['resim']['name'])) {
   if($restip != 'image/jpeg'  && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg'){
   echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

   }else{
	   
   $ekle = move_uploaded_file($reskonum, $yol.'/'.$resimadi);   
   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE slider SET adi = ?, aciklama = ?, link = ?, durum = ?, sira = ?, seodurum = ?, stitle = ?, skey = ?, sdesc = ?, resim = ? WHERE id = ?");
   $result2 = $stmt->execute(array($adi, $aciklama, $link, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $resimadi, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/slider/duzenle/'.$id.'">';

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }






}

 }else{ 



   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE slider SET adi = ?, aciklama = ?, link = ?, durum = ?, sira = ?, seodurum = ?, stitle = ?, skey = ?, sdesc = ? WHERE id = ?");
   $result2 = $stmt->execute(array($adi, $aciklama, $link, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/slider/duzenle/'.$id.'">';	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }






}
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



////Sayfa güncelleme kodları bitiş

}else{
	
$q = $ozy->query("SHOW TABLE STATUS LIKE 'slider'");
$next = $q->fetch(PDO::FETCH_ASSOC);
$ekresimid = $next['Auto_increment']; 
////Sayfa oluşturma kodları başlangıç	
 
if (isset($_POST['kaydet'])) {
	
  $adi   = temizle($_POST['adi']);
  $aciklama   = "0";
  $link		= $_POST['link'];
  $hit   = "0";
  $durum   = temizle($_POST['durum']);
  $sira   = temizle($_POST['sira']);
  $seodurum   = temizle($_POST['seodurum']);
  $stitle   = temizle($_POST['stitle']);
  $skey   = temizle($_POST['skey']);
  $sdesc   = temizle($_POST['sdesc']);
  $tarih   = date('d.m.Y H:i:s');

  $reskonum  = $_FILES['resim']['tmp_name'];
  $resad     = $_FILES['resim']['name'];
  $restip    = $_FILES['resim']['type'];
  $uzanti      = substr($resad, -5,5);
  $resimadi      = md5(uniqid(rand(time($resad)))).$uzanti;
  $yol         = "../resimler/slider";
  
   if (empty($_FILES['resim']['name'])) {
	  
   $resimadi = "resimyok.jpg";
   $stmt = $ozy->prepare("INSERT INTO slider (adi, aciklama, link, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
   $result2 = $stmt->execute(array($adi, $aciklama, $link, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $tarih, $resimadi));
   $id = $ozy->lastInsertId();
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=slider/duzenle/'.$id.'">'; 		

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }
   
   
  }else{
  
  
  
   if($restip != 'image/jpeg'  && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg'){
   echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

   }else{
	   
   $ekle = move_uploaded_file($reskonum, $yol.'/'.$resimadi);   
   
   $stmt = $ozy->prepare("INSERT INTO slider (adi, aciklama, link, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
   $result2 = $stmt->execute(array($adi, $aciklama, $link, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $tarih, $resimadi));
   $id = $ozy->lastInsertId();
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=slider/duzenle/'.$id.'">'; 	

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
                        <h4 class="page-title">Slider 
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
                            
                            <li class="breadcrumb-item active">Slider 
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Slider Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="link" value="<?php echo $sayfam['link']; ?>">
                                </div>
                            </div>
							
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Slider Sırası </br>(En başa almak için en yüksek sayıyı veriniz)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="sira" value="<?php echo $sayfam['sira']; ?>">
                                </div>
                            </div>
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Slider Adı</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="adi" value="<?php echo $sayfam['adi']; ?>" required>
                                </div>
                            </div>
							
							
							
							
							
									<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Slider Resmi</label>
                                <div class="col-sm-10">
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									<?php if($_GET['duzenle']){?>
									<img src="../resimler/slider/<?php echo $sayfam['resim']; ?>" style="width: 200px; height: 200px;" alt="" />
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
                                 



           	
								
								
								
								
								
								
                            <div class="tab-pane p-3" id="messages-1" role="tabpanel">
                            
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel Titlesi</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="stitle" value="<?php echo $sayfam['stitle']; ?>">
                                </div>
                                            
                            </div>	
							
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel Keyword</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" data-role="tagsinput" name="skey" value="<?php echo $sayfam['skey']; ?>">
                                </div>
                                            
                            </div>	
							
							
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel Açıklaması</label>
                                <div class="col-sm-10">
                                  <textarea id="textarea" class="form-control" rows="6" name="sdesc"><?php echo $sayfam['sdesc']; ?></textarea>  
                                            </div>
                                            
                            </div>	


								
								
						        <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Seo Durumu</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['seodurum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="seodurum"></div>
                                            
                                </div>   
                              
								
                                            
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