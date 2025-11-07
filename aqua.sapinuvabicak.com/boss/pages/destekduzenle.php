<?php 
paket_kontrol(["plus", "extreme", "enterprise"]); 
admin_yetki($ozy, $_SESSION['departmanid'], 6); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from support where id=$id")->fetch(PDO::FETCH_ASSOC); 
$ds = $ozy->query("UPDATE support SET durum = 1 WHERE id='$id'");
$destekid = $sayfam["id"];
$ticketsor = $ozy->query("select * from support_reply where destekid='{$id}'")->fetch(PDO::FETCH_ASSOC);
$uyeidkkk = $sayfam["uye"];
$desteknewid = $sayfam["id"];
$uyekim = $ozy->query("select * from users where id='{$uyeidkkk}'")->fetch(PDO::FETCH_ASSOC);

///Sayfa güncelleme kodları başlangıç
if (isset($_POST['destekcevapla'])) {
	    $uye = "0";
        $destekid = $ticketsor['destekid'];
		$siparisno = $ticketsor['siparisno'];
		$konu = $ticketsor['konu'];
		$mesaj= temizle($_POST["mesaj"]);
		$tarih = date("d.m.Y h:i");
		$mid =  $ticketsor['mid'];
		$email = $ticketsor['email'];
        $durum = "2";
		$uyeadi  = $uyekim['isim'];
		$uyemail  = $uyekim['email'];
		$telcik  = $uyekim['telefon'];
        $ticketcevapver = $ozy-> prepare("insert into support_reply set uye=?, destekid=?, siparisno=?, konu=?, mesaj=?, tarih=?, mid=?, email=?, durum=?");
        $ticketcevapver -> execute(array($uye,$destekid,$siparisno,$konu,$mesaj,$tarih,$mid,$email,$durum));
            if ($ticketcevapver) {
                $ticketguncelle = $ozy->prepare("update support set durum='$durum' where id='$destekid'");
  
		
			 if($system['sadmindestekonay']=='1'){
				$symesaj='Sayın '.$uyeadi.', Sitemizdeki #'.$mid.' kodlu destek talebinize yanıt geldi. '.$ayar['siteadi'].'';
				$symesaj = html_entity_decode($symesaj, ENT_COMPAT, "UTF-8"); 
				$symesaj = rawurlencode($symesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8"); 
				$smsbaslik = rawurlencode($smsbaslik); 
				sendsms($symesaj,$telcik,$smsbaslik);
	        }
			if($system['admindestekonay']=='1'){
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
			$mail->AddAddress($uyemail); // Maili gonderecegimiz kisi yani alici
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = "Destek Talebiniz yanıtlandı."; // Konu basligi
		    $mail->Body = '
			
		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="'.$url.'"><img style="height: 30px;line-height: width: 200px;margin: 80px;" class="top-image"  src="'.$url.'/resimler/siteayarlari/'.$ayar['logo'].'"  alt="'.$siteadi.'"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">Destek Talebiniz Yanıtlandı
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="'.$url.'/mail/webinar-no-text.png" width="560"/><br><br>
										<strong>Sayın, </strong> '.$uyeadi.'<br>
										Sitemizdeki #'.$mid.' kodlu destek talebinize yanıt geldi.
									
									
			                           </br></br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="'.$url.'/hesabim/">Cevabı Görüntüle</a>
									</div>
									</td>
								</tr>
								
								

							</table>
						</td>
					</tr>
				
												
					<tr>
						<td valign="top" align="center" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								<tr>
									<td align="center" valign="middle" class="social" style="border-collapse: collapse;border: 0;margin: 0;padding: 10px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;text-align: center;">
										<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
											<tr>
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="'.$url.'/blog"><img src="'.$url.'/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="'.$ayar['twitter'].'"><img src="'.$url.'/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="'.$ayar['facebook'].'"><img src="'.$url.'/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="'.$ayar['youtube'].'"><img src="'.$url.'/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="'.$ayar['instagram'].'"><img width="20px" height="20px" src="'.$url.'/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="'.$ayar['googleplus'].'"><img src="'.$url.'/mail/google-teal.png"></a></td>

											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgcolor="#fff" style="border-top: 4px solid #00a5b5;">
						<td valign="top" class="footer" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								<tr>
									<td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
<div id="address" class="mktEditable">
										<b>'.$ayar['siteadi'].'</b><br>
                            '.$ayar['adres'].'<br>
							'.$ayar['tel'].' '.$ayar['email'].'<br>
                            <a style="color: #00a5b5;" href="'.$url.'/iletisim/">Bize Ulaşın</a>
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
  </body>

			'; // Mailin icerigi
			if(!$mail->Send()){
			}else {
			
			}	
}
			
			
			
			}else{
          
		   
            
      }
	  
	  
	}
	
////Sayfa güncelleme kodları bitiş

}


if (isset($_GET['temizle'])) {
	
$sid = temizle($_GET['temizle']);
$sayfasil = $ozy->prepare("delete from support_reply where id='$sid'");
$sayfasil->execute(array($sid));

if ($sayfasil) {
	

echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/destek/duzenle/'.$id.'">'; 	
	
	
}


}

?>


<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Destek Oku</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Destek Oku</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
            <div class="col-12">
                    <!-- Left sidebar -->
                   

                        <div class="card">


                            <div class="card-body">

            <h4 class="mt-0 font-16" style="text-align: center;margin-bottom: 30px;border: 1px solid #ebe7e7;padding: 10px;"><?php echo $sayfam['konu'];?></h4>
                      
			<?php $duys = $ozy->query("select * from support_reply where destekid='{$desteknewid}' order by id asc")->fetchAll(PDO::FETCH_ASSOC); 
            foreach($duys as $stes){?>
            <?php if($stes['uye'] =="00"){?>
			
			<div class="media m-b-30" style="border-bottom: 1px solid #e5dfdf;padding-bottom: 20px;">
            <img class="d-flex mr-3 rounded-circle thumb-md" src="../resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="Generic placeholder image">
            <div class="media-body align-self-center">
            <h4 class="font-14 m-0"><?php echo $ayar['siteadi'];?></h4>
	        <blockquote class="blockquote font-13 mt-4">
                                     <?php echo $stes['mesaj'];?>
			</blockquote>
			<div style="float: right;margin-top: -50px;">
			<small class="text-muted"><?php echo $stes['tarih'];?></small>
			<a href="destek-duzenle/<?php echo $id;?>?temizle=<?php echo $stes['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
			                        
			
			</div>
			</div>
            </div>
			<?php }else {?>
				  
		  					
									<div class="media m-b-30" style="border-bottom: 1px solid #e5dfdf;padding-bottom: 20px;">
                                        <img class="d-flex mr-3 rounded-circle thumb-md" src="assets/images/users/user-3.jpg" alt="Generic placeholder image">
                                        <div class="media-body align-self-center">
                                            <h4 class="font-14 m-0"><?php echo $uyekim['isim'];?></h4>
                                            <small class="text-muted"><?php echo $uyekim['eposta'];?></small>
                                        <div><?php echo $stes['mesaj'];?></div>
										<div style="float: right;margin-top: -50px;">
										<a href="tel:<?php echo $uyekim['telefon'];  ?>" target="_blank" onclick="return confirm('Telefon ile yanıt vermek istiyor musun ?')" class="btn btn-sm btn-danger" style="border: none;background: #4192e9;" data-toggle="tooltip" data-original-title="Telefon ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/tel.png"></img></a>									 
									    <a href="https://api.whatsapp.com/send?phone=+9<?php echo $uyekim['telefon'];  ?>&amp;text=Merhaba iyi günler, <?php echo $ayar['siteadi'];?> olarak websitemizin destek formundan göndermiş olduğunuz mesaja istinaden sizi rahatsız ediyorum." target="_blank" onclick="return confirm('WhatsApp ile yanıt vermek istiyor musun  ?')" class="btn btn-sm btn-danger" style="border: #2ab200;background: #2ab200;" data-toggle="tooltip" data-original-title="WhatsApp ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/whatsap.jpg"></img></a>									 
										</div>
										</div>
                                    </div>


                                 <?php }}?>


                                   
                                    

                                    
                                        
                                   
                                    <hr>

                                    <div class="row">
                                       
									  <form action="" method="POST" style="width: 100% !important;">
                             
							   
							   
							   
                                <div class="form-group">
         
                               
                                 <textarea id="summernote" rows="6" name="mesaj" placeholder="Mesajınız">
								 </textarea>
							
								</div>

                                  

                              
									   
									   
                                    </div>

                                    <a href="destek-merkezi" class="btn btn-primary waves-effect m-t-30"><i class="mdi mdi-reply"></i> Geri Dön</a>
                                    <button type="submit" name="destekcevapla" class="btn btn-danger waves-effect m-t-30">Mesajı Cevapla <i class="mdi mdi-share"></i></button>
                                </div>

                              </form> 

                        </div>
                        <!-- card -->



                </div>
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
