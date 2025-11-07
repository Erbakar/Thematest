<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 6); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from iletisim where id=$id")->fetch(PDO::FETCH_ASSOC); 
$ds = $ozy->query("UPDATE iletisim SET durum = 1 WHERE id='$id'");
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



  $ckonu   = temizle($_POST['ckonu']);
  $cevap   = $_POST['cevap'];
  $meposta   = temizle($sayfam['eposta']);

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
			$mail->AddAddress($meposta); // Maili gonderecegimiz kisi yani alici
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = $ckonu; // Konu basligi
			$mail->Body = ' '.$cevap .''; // Mailin icerigi
			if(!$mail->Send()){
			}else {
				
			
   $stmt = $ozy->prepare("UPDATE iletisim SET ckonu = ?, cevap = ?, giden = ? WHERE id = ?");
   $result2 = $stmt->execute(array($ckonu, $cevap, 1, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla eposta iletildi.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/mesaj-duzenle/'.$id.'">';

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }	
				
			
			}
 
 
 
 
 
 
 
 






	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



////Sayfa güncelleme kodları bitiş

}



?>


<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Mesajı Oku</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Mesajı Oku</li>
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
                            <a href="gelen-kutusu" <?php echo $_GET['s'] == '' ? ' class="active"' : null; ?>> <span class="float-right">
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
							<a href="toplu-eposta"><span class="float-right">
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

                                    <div class="media m-b-30">
                                        <img class="d-flex mr-3 rounded-circle thumb-md" src="assets/images/users/user-3.jpg" alt="Generic placeholder image">
                                        <div class="media-body align-self-center">
                                            <h4 class="font-14 m-0"><?php echo $sayfam['isim'];?></h4>
                                            <small class="text-muted"><?php echo $sayfam['eposta'];?></small>
                                        <div><?php echo $sayfam['telefon'];?></div>
										<div style="float: right;margin-top: -50px;">
										<a href="tel:<?php echo $sayfam['telefon'];  ?>" target="_blank" onclick="return confirm('Telefon ile yanıt vermek istiyor musun ?')" class="btn btn-sm btn-danger" style="border: none;background: #4192e9;" data-toggle="tooltip" data-original-title="Telefon ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/tel.png"></img></a>									 
									    <a href="https://api.whatsapp.com/send?phone=+9<?php echo $sayfam['telefon'];  ?>&amp;text=Merhaba iyi günler, <?php echo $ayar['siteadi'];?> olarak websitemizin iletişim formundan göndermiş olduğunuz mesaja istinaden sizi rahatsız ediyorum." target="_blank" onclick="return confirm('WhatsApp ile yanıt vermek istiyor musun  ?')" class="btn btn-sm btn-danger" style="border: #2ab200;background: #2ab200;" data-toggle="tooltip" data-original-title="WhatsApp ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/whatsap.jpg"></img></a>									 
										</div>
										</div>
                                    </div>

                                    <h4 class="mt-0 font-16"><?php echo $sayfam['konu'];?></h4>

                                    

                                    <blockquote class="blockquote font-13 mt-4">
                                     <?php echo $sayfam['mesaj'];?>
									 </blockquote>
                                        
                                   
                                    <hr>

                                    <div class="row">
                                       
									  <form action="" method="POST" style="width: 100% !important;">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="eposta" value="<?php echo $sayfam['eposta'];?>" disabled>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="ckonu" placeholder="Konunuz" value="<?php echo $sayfam['ckonu'];?>">
                                    </div>
                               
							   
							   
							   
                                <div class="form-group">
         
                               
                                 <textarea id="summernote" rows="6" name="cevap" placeholder="Eposta İçeriğiniz">
								 <?php if($sayfam['giden']=='1'){?>
								 <?php echo $sayfam['cevap']; ?>
								 <?php } else { ?>
														 <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="height: 800px !important;font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="<?php echo $ayar['siteurl'];?>"><img style="height: 30px;line-height: width: 200px;margin: 80px;" class="top-image"  src="<?php echo $ayar['siteurl'];?>/resimler/siteayarlari/<?php echo $ayar['logo'];?>"  alt="<?php echo $ayar['siteadi'];?>"></a>
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

                                    <a href="gelen-kutusu" class="btn btn-primary waves-effect m-t-30"><i class="mdi mdi-reply"></i> Geri Dön</a>
                                    <button type="submit" name="guncelle" class="btn btn-danger waves-effect m-t-30">Mesajı Cevapla <i class="mdi mdi-share"></i></button>
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
