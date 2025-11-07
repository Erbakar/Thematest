<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$ekresimid = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from kuponlar where sekil='0' and id=$id")->fetch(PDO::FETCH_ASSOC); 
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



  $adi   = temizle($_POST['adi']);
  $tip = ($_POST['tip'] != "") ? $_POST['tip'] : "0";
  $oran   = temizle($_POST['oran']);
  $stok   = temizle($_POST['stok']);
  $durum   = temizle($_POST['durum']);
  $slimit   = temizle($_POST['slimit']);
  $tarih   = date('d.m.Y');

   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE kuponlar SET adi = ?, tip = ?, oran = ?, stok = ?, durum = ?, slimit = ?, tarih = ? WHERE id = ?");
   $result2 = $stmt->execute(array($adi, $tip, $oran, $stok, $durum, $slimit, $tarih, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/kupon/duzenle/'.$id.'">';	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }






	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



////Sayfa güncelleme kodları bitiş

}else{
	

 
if (isset($_POST['kaydet'])) {
	
  $adi   = temizle($_POST['adi']);
  $tip = ($_POST['tip'] != "") ? $_POST['tip'] : "0";
  $oran   = temizle($_POST['oran']);
  $stok   = temizle($_POST['stok']);
  $sekil   = "0";
  $durum   = temizle($_POST['durum']);
  $tarih   = date('d.m.Y');
  $slimit   = temizle($_POST['slimit']);

   $stmt = $ozy->prepare("INSERT INTO kuponlar (adi, tip, oran, stok, sekil, durum, tarih, slimit) 
   VALUES (?,?,?,?,?,?,?,?)");
   $result2 = $stmt->execute(array($adi, $tip, $oran, $stok, $sekil, $durum, $tarih, $slimit));
   $id = $ozy->lastInsertId();
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=tum-kuponlar">'; 	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

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
                        <h4 class="page-title">Kupon 
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
                            
                            <li class="breadcrumb-item active">Kupon 
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Kupon Kodu</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="adi" value="<?php echo $sayfam['adi']; ?>" required>
                                </div>
                            </div>
							
							<div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kupon Tipi</label>
                            <div class="col-sm-10">

                            <input id="demo-inline-form-radio-3" class="magic-radio" name="tip"
                            value="0" <?php echo $sayfam['tip'] == '0' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-3">Normal İndirim - TL</label>

                            <input id="demo-inline-form-radio-4" class="magic-radio" name="tip"
                            value="1" <?php echo $sayfam['tip'] == '1' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio-4">Yüzde İndirim %</label>

								</div>
                            </div>
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">İndirim Bedeli</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="oran" value="<?php echo $sayfam['oran']; ?>" required>
                                <span class="input-group-addon">Sadece Rakam</span>
								</div>
                            </div>
					
            <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Minumun Sepet Limiti</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" value="<?php echo $sayfam['slimit']; ?>" name="slimit">
            <span class="input-group-addon"> TL</span>
            </div>
            </div>			    
 

					
			<div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" value="<?php echo $sayfam['stok']; ?>" name="stok">
           
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