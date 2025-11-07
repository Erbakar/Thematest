<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from tiletisim where id=$id")->fetch(PDO::FETCH_ASSOC); 

///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



  $adi   = temizle($_POST['adi']);
  $epostalar 	= $_POST["epostalar"];
  $epostalarimiz 	= implode(",",$epostalar);
  $konu   = temizle($_POST['konu']);
  $mesaj   = $_POST['mesaj'];
  $durum   = $_POST['durum'];
            if($durum=='1'){
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
			$mail->Subject = $konu; // Konu basligi
			$mail->Body = ' '.$mesaj .''; // Mailin icerigi
			if(!$mail->Send()){
			}else {
			}	
			}
   $stmt = $ozy->prepare("UPDATE tiletisim SET adi = ?, konu = ?, mesaj = ?, durum = ?, epostalar = ? WHERE id = ?");
   $result2 = $stmt->execute(array($adi, $konu, $mesaj, $durum, $epostalarimiz, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla toplu eposta iletildi.", "Başarılı");});</script>';	
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/eposta-duzenle/'.$id.'">'; 	
	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }	
				
			
			
 
 
 
 
 
 
 
 






	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



////Sayfa güncelleme kodları bitiş

}

if (isset($_POST['kaydet'])) {



  $adi   = temizle($_POST['adi']);
  $epostalar 	= $_POST["epostalar"];
  $epostalarimiz 	= implode(",",$epostalar);
  $konu   = temizle($_POST['konu']);
  $mesaj   = $_POST['mesaj'];
  $tarih   = date('d.m.Y H:i:s');
  $durum   = $_POST['durum'];
  
            if($durum=='1'){
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
			$mail->Subject = $konu; // Konu basligi
			$mail->Body = ' '.$mesaj .''; // Mailin icerigi
			if(!$mail->Send()){
			}else {
			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla toplu eposta iletildi.", "Başarılı");});</script>';
		
			}
            }
   $stmt = $ozy->prepare("INSERT INTO tiletisim (adi, konu, mesaj, durum, epostalar,tarih) 
   VALUES (?,?,?,?,?,?)");
   $result2 = $stmt->execute(array($adi, $konu, $mesaj, $durum, $epostalarimiz, $tarih));
   
   
   
   if($result2){
	   
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla şablon kayıt edildi.", "Başarılı");});</script>';
	

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
                        <h4 class="page-title">Toplu Eposta Oku</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Toplu Eposta</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
            <div class="col-12">
                    <!-- Left sidebar -->
                    <div class="email-leftbar card">
                        <a href="eposta-gonder" class="btn btn-danger rounded btn-custom btn-block waves-effect waves-light">Toplu Eposta Gönder</a>

                        <h6 class="m-t-30">Gelen Kutusu</h6>

                        <div class="mail-list m-t-10">
                            <a href="gelen-kutusu" > <span class="float-right">
							<?php 
							$gelen = $ozy->prepare("SELECT COUNT(*) FROM iletisim");
                            $gelen->execute();
                            $gelenmesajsayisi = $gelen->fetchColumn(); echo $gelenmesajsayisi;?>
							</span> <i class="ti-archive mr-2"></i> Gelen </a>
                            <a <?php echo $_GET['s'] == '1' ? ' class="active"' : null; ?> href="gelen-kutusu?s=1"><span class="float-right">
							<?php 
							$giden = $ozy->prepare("SELECT COUNT(*) FROM iletisim  where giden='1'");
                            $giden->execute();
                            $gidenmesajsayisi = $giden->fetchColumn(); echo $gidenmesajsayisi;?>
							</span><i class="ti-location-arrow mr-2"></i> Cevaplanan </a>
                            <a href="gelen-kutusu?s=2" <?php echo $_GET['s'] == '2' ? ' class="active"' : null; ?> ><span class="float-right">
							<?php 
							$silinen = $ozy->prepare("SELECT COUNT(*) FROM iletisim where durum='0'");
                            $silinen->execute();
                            $silinenmesajsayisi = $silinen->fetchColumn(); echo $silinenmesajsayisi;?>
							</span><i class="ti-trash mr-2"></i> Silinen </a>
							<a href="toplu-eposta" class="active"><span class="float-right">
							<?php 
							$toplu = $ozy->prepare("SELECT COUNT(*) FROM tiletisim");
                            $toplu->execute();
                            $toplueposta = $toplu->fetchColumn(); echo $toplueposta;?>
							
							</span><i class="ti-pencil  mr-2"></i>Toplu Eposta  </a>
                            
                        </div>

                 
                    </div>
                    <!-- End Left sidebar -->

                    <div class="email-rightbar mb-3">

                        <div class="card">


                            <div class="card-body">

                                 


                                    <div class="row">
                                       
									  <form action="" method="POST" style="width: 100% !important;">
                                     <div class="form-group">
                                        <input type="text" class="form-control" name="adi" value="<?php echo $sayfam['adi'];?>" placeholder="Eposta Şablon Adı">
                                 
								 </div>
								 
								<?php if($_GET['duzenle']){?>
								<div class="form-group">
                                
                                <select class="form-control js-example-basic-multiple" name="epostalar[]" multiple="multiple">
								<?php $kat = $ozy->query("select * from ebulten")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($kat as $de) { ?>
								 <?php $katidler = $sayfam['epostalar'];
								 $katidler = explode(',', $katidler);
								 foreach( $katidler as $anahtar => $katdeger ){?>
                  
								<option value="<?php echo $de['eposta']; ?>" <?php if ($de['eposta'] == $katdeger) { ?> selected="selected" <?php }}  ?>><?php echo $de['eposta']; ?></option>
                                <?php } ?>
		
                                </select>                       
							  
                                </div>
								<?php } else { ?>
								
								<div class="form-group">
                                
                                <select class="form-control js-example-basic-multiple" name="epostalar[]" multiple="multiple">
								<?php $kat = $ozy->query("select * from ebulten")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($kat as $de) { ?>
								
                  
								<option value="<?php echo $de['eposta']; ?>" selected="selected"><?php echo $de['eposta']; ?></option>
                                <?php } ?>
		
                                </select>                       
							  
                                </div>
								<?php } ?>

                       


                                <div class="form-group">
                                <input type="text" class="form-control" name="konu" placeholder="Konunuz" value="<?php echo $sayfam['konu'];?>">
                                </div>
                               
							    <?php if($_GET['duzenle']){?>
						        <div class="form-group">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Epostayı Şimdi Gönder</label>
                                <div class="col-sm-7">
                                <input type="checkbox" <?php if($sayfam['durum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>
                                            
                                </div>   
                                <?php } else { ?>
						        <div class="form-group">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Epostayı Şimdi Gönder</label>
                                <div class="col-sm-7">
                                <input type="checkbox"  checked="" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>
                                            
                                </div> 

						        <?php } ?> 
							   
							   
                                <div class="form-group">
         
                               
                                 <textarea id="summernote" rows="6" name="mesaj" placeholder="Eposta İçeriğiniz">
								 <?php if($sayfam['durum']=='1'){?>
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
										<strong>Örnek Mesaj Alanıdır.</strong>
									
			                           
			                             <a href="" style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank">Örnek Buton</a>
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
                                       <?php if($_GET['duzenle']){?>
									   <button type="submit" name="guncelle" class="btn btn-danger waves-effect m-t-30">Toplu Eposta Gönder <i class="mdi mdi-share"></i></button>
                                        
                                       <?php } else { ?>
									   <button type="submit" name="kaydet" class="btn btn-warning waves-effect m-t-30">Toplu Eposta Gönder<i class="mdi mdi-share"></i></button>
                                       <?php } ?>
								</div>

                              </form> 

                        </div>
                        <!-- card -->


                    </div>

                </div>
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
