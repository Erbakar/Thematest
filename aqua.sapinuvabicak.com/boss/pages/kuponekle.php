<?php 
// Hata ayıklama için geçici olarak açık
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Debug mesajı
echo '<script>console.log("Kupon sayfası yüklendi");</script>';

admin_yetki($ozy, $_SESSION['departmanid'], 3); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$ekresimid = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from kuponlar where sekil='0' and id=$id")->fetch(PDO::FETCH_ASSOC); 
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {
    echo '<script>console.log("Kupon güncelleme işlemi başladı");</script>';
    try {
        // POST verilerini güvenli şekilde al
        $adi   = isset($_POST['adi']) ? temizle($_POST['adi']) : '';
        $tip = isset($_POST['tip']) ? ($_POST['tip'] != "" ? $_POST['tip'] : "0") : "0";
        $oran   = isset($_POST['oran']) ? temizle($_POST['oran']) : '';
        $stok   = isset($_POST['stok']) ? temizle($_POST['stok']) : '';
        $durum   = isset($_POST['durum']) ? temizle($_POST['durum']) : '0';
        $slimit   = isset($_POST['slimit']) ? temizle($_POST['slimit']) : '';
        $tarih   = date('d.m.Y');

        $id = isset($_GET['duzenle']) ? $_GET['duzenle'] : '';
        
        if (empty($id)) {
            throw new Exception("Güncellenecek kayıt ID'si bulunamadı");
        }

        // Veritabanı işlemi
        $stmt = $ozy->prepare("UPDATE kuponlar SET adi = ?, tip = ?, oran = ?, stok = ?, durum = ?, slimit = ?, tarih = ? WHERE id = ?");
        $result2 = $stmt->execute(array($adi, $tip, $oran, $stok, $durum, $slimit, $tarih, $id));
        
        if($result2){
            echo '<script>console.log("Kupon başarıyla güncellendi");</script>';
            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
            echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/kupon/duzenle/'.$id.'">';	
        } else {
            echo '<script>console.log("Kupon güncelleme başarısız");</script>';
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
        }
        
    } catch (Exception $e) {
        // Konsola hata yazdır
        echo '<script>console.error("Kupon güncelleme hatası:", "' . addslashes($e->getMessage()) . '");</script>';
        error_log("Kupon güncelleme hatası: " . $e->getMessage());
        
        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Hata: ' . addslashes($e->getMessage()) . '", "Hata");});</script>';
        echo '<div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px; border: 1px solid #f5c6cb;">Hata Detayı: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }






	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



////Sayfa güncelleme kodları bitiş

}else{
	

 
if (isset($_POST['kaydet'])) {
    echo '<script>console.log("Kupon kaydetme işlemi başladı");</script>';
    try {
        // POST verilerini güvenli şekilde al
        $adi   = isset($_POST['adi']) ? temizle($_POST['adi']) : '';
        $tip = isset($_POST['tip']) ? ($_POST['tip'] != "" ? $_POST['tip'] : "0") : "0";
        $oran   = isset($_POST['oran']) ? temizle($_POST['oran']) : '';
        $stok   = isset($_POST['stok']) ? temizle($_POST['stok']) : '';
        $sekil   = "0";
        $durum   = isset($_POST['durum']) ? temizle($_POST['durum']) : '0';
        $tarih   = date('d.m.Y');
        $slimit   = isset($_POST['slimit']) ? temizle($_POST['slimit']) : '';

        // Veritabanı işlemi
        $epostalar = ''; // Boş string olarak ekle
        $mesaj = ''; // Boş string olarak ekle
        $gtarih = ''; // Boş string olarak ekle
        $stmt = $ozy->prepare("INSERT INTO kuponlar (adi, tip, oran, stok, sekil, durum, tarih, slimit, epostalar, mesaj, gtarih) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $result2 = $stmt->execute(array($adi, $tip, $oran, $stok, $sekil, $durum, $tarih, $slimit, $epostalar, $mesaj, $gtarih));
        
        if($result2){
            echo '<script>console.log("Kupon başarıyla eklendi");</script>';
            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
            echo '<meta http-equiv="refresh" content="1; url=tum-kuponlar">'; 	
        } else {
            echo '<script>console.log("Kupon ekleme başarısız");</script>';
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
        }
        
    } catch (Exception $e) {
        // Konsola hata yazdır
        echo '<script>console.error("Kupon ekleme hatası:", "' . addslashes($e->getMessage()) . '");</script>';
        error_log("Kupon ekleme hatası: " . $e->getMessage());
        
        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Hata: ' . addslashes($e->getMessage()) . '", "Hata");});</script>';
        echo '<div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px; border: 1px solid #f5c6cb;">Hata Detayı: ' . htmlspecialchars($e->getMessage()) . '</div>';
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