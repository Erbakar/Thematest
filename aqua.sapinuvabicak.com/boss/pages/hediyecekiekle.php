<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$ekresimid = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from kuponlar where sekil='1' and id=$id")->fetch(PDO::FETCH_ASSOC); 
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



  $adi   = temizle($_POST['adi']);
  $tip = ($_POST['tip'] != "") ? $_POST['tip'] : "0";
  $oran   = temizle($_POST['oran']);
  $stok   = temizle($_POST['stok']);
  $durum   = temizle($_POST['durum']);
  $slimit   = temizle($_POST['slimit']);
  $tarih   = date('d.m.Y');
  $gtarih   = temizle($_POST['gtarih']);
  $epostalar 	= $_POST["epostalar"];
  $epostalarimiz 	= implode(",",$epostalar);
  $mesaj   = $_POST['mesaj'];
   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE kuponlar SET adi = ?, tip = ?, oran = ?, stok = ?, durum = ?, slimit = ?, tarih = ?, epostalar = ?, mesaj = ?, gtarih = ? WHERE id = ?");
   $result2 = $stmt->execute(array($adi, $tip, $oran, $stok, $durum, $slimit, $tarih, $epostalarimiz, $mesaj, $gtarih, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$id.'">'; 	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }
               if($system['scekgonder']=='1'){
				$smesaj='Değerli Müşterimiz, Size özel bir hediye çeki hesabınıza tanımladık. İyi günlerde kullanınız :) '.$url.'';
				$smesaj = html_entity_decode($smesaj, ENT_COMPAT, "UTF-8"); 
				$smesaj = rawurlencode($smesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8"); 
				$smsbaslik = rawurlencode($smsbaslik); 
				foreach ($epostalar as $trr) {
                $topluepostalar = trim($trr, ",");	
				$uyemmm = $ozy->query("select * from user where email='$topluepostalar'")->fetchAll(PDO::FETCH_ASSOC); 
                foreach($uyemmm as $yyyy){
				sendsms($smesaj,$yyyy['telefon'],$smsbaslik);
				}
			    }
				
	         }
            if($system['cekgonder']=='1'){
            include("../mail/PHPMailerAutoload.php");	
      
			$mail = new PHPMailer;            
			$mail->IsSMTP();
			//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
			$mail->Host = "$sunucu"; // Mail sunucusuna ismi
			$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
			$mail->IsHTML(true);
			$mail->SetLanguage("tr", "phpmailer/language");
			$mail->CharSet  ="utf-8";
			$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
			$mail->Password = "$esifre"; // Mail adresimizin sifresi
			$mail->SetFrom($mail->Username, ''.$siteadi.'');
			$mail->AddAddress($posta); // Maili gonderecegimiz kisi yani alici
			foreach ($epostalar as $trr) {
            $topluepostalar = trim($trr, ",");				
			$mail->AddCC($topluepostalar, $siteadi);
			}
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = "Size bir sürprizimiz var ;)"; // Konu basligi
			$mail->Body = ' '.$mesaj .''; // Mailin icerigi
			if(!$mail->Send()){
			}else {
			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla toplu eposta iletildi.", "Başarılı");});</script>';
		
			}
            }




	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



////Sayfa güncelleme kodları bitiş

}else{
	

 
if (isset($_POST['kaydet'])) {
	
  $adi   = temizle($_POST['adi']);
  $tip = ($_POST['tip'] != "") ? $_POST['tip'] : "0";
  $oran   = temizle($_POST['oran']);
  $stok   = temizle($_POST['stok']);
  $sekil   = "1";
  $durum   = temizle($_POST['durum']);
  $tarih   = date('d.m.Y');
  $slimit   = temizle($_POST['slimit']);
  $epostalar 	= $_POST["epostalar"];
  $epostalarimiz 	= implode(",",$epostalar);
  $mesaj   = $_POST['mesaj'];
  $gtarih   = temizle($_POST['gtarih']);

   $stmt = $ozy->prepare("INSERT INTO kuponlar (adi, tip, oran, stok, sekil, durum, tarih, slimit, epostalar, mesaj, gtarih) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?)");
   $result2 = $stmt->execute(array($adi, $tip, $oran, $stok, $sekil, $durum, $tarih, $slimit, $epostalarimiz, $mesaj, $gtarih));
   $id = $ozy->lastInsertId();
   
        if($system['cekgonder']=='1'){
            include("../mail/PHPMailerAutoload.php");	
      
			$mail = new PHPMailer;            
			$mail->IsSMTP();
			//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
			$mail->Host = "$sunucu"; // Mail sunucusuna ismi
			$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
			$mail->IsHTML(true);
			$mail->SetLanguage("tr", "phpmailer/language");
			$mail->CharSet  ="utf-8";
			$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
			$mail->Password = "$esifre"; // Mail adresimizin sifresi
			$mail->SetFrom($mail->Username, ''.$siteadi.'');
			$mail->AddAddress($posta); // Maili gonderecegimiz kisi yani alici
			foreach ($epostalar as $trr) {
            $topluepostalar = trim($trr, ",");				
			$mail->AddCC($topluepostalar, $siteadi);
			}
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = "Size bir sürprizimiz var ;)"; // Konu basligi
			$mail->Body = ' '.$mesaj .''; // Mailin icerigi
			if(!$mail->Send()){
			}else {
			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla toplu eposta iletildi.", "Başarılı");});</script>';
		
			}
            }
			
			
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=tum-hediyecekleri">'; 	

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
                        <h4 class="page-title">Hediye Çeki 
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
                            
                            <li class="breadcrumb-item active">Hediye Çeki 
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Hediye Çeki Kodu</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="adi" value="<?php echo $sayfam['adi']; ?>" required>
                                </div>
                            </div>
							
							<div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Hediye Çeki Tipi</label>
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
			
			
			<div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Geçerlilik Tarihi</label>
            <div class="col-sm-10">
            <input type="date" class="form-control" value="<?php echo $sayfam['gtarih']; ?>" name="gtarih">
           
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
							
							
						        <?php if($_GET['duzenle']){?>
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Kimlere Tanımlanacak</label>
                                <div class="col-sm-10">
								<select class="form-control js-example-basic-multiple" name="epostalar[]" multiple="multiple">
								<?php $kat = $ozy->query("select * from users where onay='1'")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($kat as $de) { ?>
								 <?php $katidler = $sayfam['epostalar'];
								 $katidler = explode(',', $katidler);
								 foreach( $katidler as $anahtar => $katdeger ){?>
                  
								<option value="<?php echo $de['email']; ?>" <?php if ($de['email'] == $katdeger) { ?> selected="selected" <?php }}  ?>><?php echo $de['isim']; ?></option>
                                <?php } ?>
		
                                </select>                       
							    </div>
                                </div>
								<?php } else { ?>
								
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Kimlere Tanımlanacak</label>
                                <div class="col-sm-10">
								<select class="form-control js-example-basic-multiple" name="epostalar[]" multiple="multiple">
								<?php $kat = $ozy->query("select * from users where onay='1'")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($kat as $de) { ?>
								
                  
								<option value="<?php echo $de['email']; ?>" selected="selected"><?php echo $de['isim']; ?></option>
                                <?php } ?>
		
                                </select>                       
							    </div>
                                </div>
								<?php } ?>		
						
								
								
								<div class="form-group">
         
                               
                                 <textarea id="summernote" rows="6" name="mesaj" placeholder="Eposta İçeriğiniz">
								 <?php if($_GET['duzenle']){?>
								 <?php echo $sayfam['mesaj']; ?>
								 <?php } else { ?>
									 <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="height: 800px !important;font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="<?php echo $ayar['siteurl'];?>"><img style="height: 70px;line-height: 1;width: 200px;margin: 10px;" class="top-image" src="<?php echo $ayar['siteurl'];?>/resimler/siteayarlari/<?php echo $ayar['logo'];?>"  alt="<?php echo $ayar['siteadi'];?>"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
							
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="<?php echo $ayar['siteurl'];?>/mail/webinar-no-text.png" width="560"/><br><br>
										<strong>Tebrikler, Size Özel Hediye Çeki Tanımlandı !</strong><br><br>
									
			                           
			                             <a href="" style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank">HEDİYEÇEKİKODUNUZ</a>
									</div>
									</td>
								</tr>
								
								<tr>
						<td valign="top" align="center" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								<tr>
									<td align="center" valign="middle" class="social" style="border-collapse: collapse;border: 0;margin: 0;padding: 10px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;text-align: center;">
										<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
											<tr>
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="<?php echo $ayar['siteurl'];?>/blog"><img src="<?php echo $ayar['siteurl'];?>/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="<?php echo $ayar['twitter'];?>"><img src="<?php echo $ayar['siteurl'];?>/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="<?php echo $ayar['facebook'];?>"><img src="<?php echo $ayar['siteurl'];?>/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="<?php echo $ayar['youtube'];?>"><img src="<?php echo $ayar['siteurl'];?>/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="<?php echo $ayar['instagram'];?>"><img width="20px" height="20px" src="<?php echo $ayar['siteurl'];?>/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="<?php echo $ayar['googleplus'];?>"><img src="<?php echo $ayar['siteurl'];?>/mail/google-teal.png"></a></td>

											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
<tr bgcolor="#fff" style="border-top: 4px solid #00a5b5;">
						<td valign="top" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								<tr>
									<td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
<div id="address" class="mktEditable">
										<b><?php echo $ayar['siteadi'];?></b><br>
                            <?php echo $ayar['adres'];?><br>
							<?php echo $ayar['tel'];?> <?php echo $ayar['email'];?><br>
                            <a style="color: #00a5b5;" href="<?php echo $ayar['siteurl'];?>/iletisim/">Bize Ulaşın</a>
</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
							</table>
						</td>
					</tr>
				
												
					
					
				</table>
			</td>
		</tr>
	</table>
  </body>
								 <?php } ?>
								 </textarea>
							
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