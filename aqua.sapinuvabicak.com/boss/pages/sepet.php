<?php
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$sayfasil = $ozy->prepare("delete from sepet where gelenkim='$id'");
$sayfasil->execute(array($id));

if ($sayfasil) {
	
echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';
	
}


}



if (isset($_GET['epostabildir'])) {
	
            $epostabildir = temizle($_GET['epostabildir']);

			$blogbak = $ozy->query("select * from users where email='$epostabildir'")->fetch(PDO::FETCH_ASSOC);
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
			$mail->AddAddress($epostabildir); // Maili gonderecegimiz kisi yani alici
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = "Sepetini Unutma!"; // Konu basligi
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
									<div class="mktEditable" id="intro_title">Sepetinizdeki ürünler tükenmek üzere
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="'.$url.'/mail/webinar-no-text.png" width="560"/><br><br>
										<strong>Sayın, </strong> '.$blogbak['isim'].'<br>
										Sepetinizdeki ürünler tükenmek üzere. </br>
									Fırsatı ve ürünleri kaçırmamak için şimdi sitemizi ziyaret ediniz :)
									
			                           </br></br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="'.$url.'/sepet/">Sepeti Görüntüle</a>
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
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="'.$ayar['twitter'].'"><img src="'.$url.'/mail/twitter-teal.png"></a></td>
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
				
				echo '<script type="text/javascript">$(document).ready(function(){toastr["warning"]("Eposta gönderilemedi. Bir hata oluştu.", "Hata");});</script>'; 	
			}else {
			
			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla sepet hatırlatma epostası iletildi.", "Başarılı");});</script>';
	
			
			}	







}





?>


<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Site Sepet Kontrolü</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Site Sepet Kontrolü</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <table id="datatable" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
								    <th>Sepet İD</th>
									<th>Kullanıcı</th>
									<th>Ürünler</th>
									<th>Sepet Tutarı</th>
                                    <th>İP Adresi</th>
									<th>Sepet Tarihi</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	    <?php $pr = $ozy->query("select * from sepet GROUP BY gelenkim")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pr as $tr) {
							   
		$baks = $tr['gelenkim'];
		$urunlerim = "";
		$uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
		INNER JOIN sepet ON urunler.id = sepet.urunid  
		WHERE sepet.gelenkim=? ORDER BY sepet.id DESC");                
		$uyesepeti1->execute(array($baks));
		foreach ($uyesepeti1 as $sepet1) {
		$toplamf+= ($sepet1['fiyat']+$sepet1['efiyat'])*$sepet1['adet'];
		
		$urunlerim.= '<a  target="_blank" href="../urun/'.$sepet1['seo'].'">
		<img class="lazyload" height="30px" width="30px" data-src="../resimler/urunler/'.$sepet1['resim'].'"></br>'.substr($sepet1['adi'],0,28).' ... </br><b style="text-align:center;">'.$sepet1['fiyat'].' TL x '.$sepet1['adet'].' Adet</b> </br></a>';
		
		
		}   
		
		   
							   
							   ?>	
								
								
                                <tr>
								    <td><?php echo $tr['id']?></td>
									<?php 
									$sipuyeid = $tr['gelenkim'];
									$siparisuyebilgileri = $ozy->query("select * from users where id='$sipuyeid'")->fetch(PDO::FETCH_ASSOC);?>
									<?php if (count($siparisuyebilgileri) == 1) {?>
									<td>
									<b>Misafir</b></br>
									
									</td>
									<?php } else { ?>
									<td>
									<a href="uye/duzenle/<?php echo $siparisuyebilgileri['id'];?>" target="_blank"><?php echo $siparisuyebilgileri['isim'];?></br>
									
			
									</a>
									</td>
									<?php } ?>
									
									  <td>
									  <?php echo $urunlerim;?>
									  </td>
									
									
                                    <td><?php echo number_format($toplamf, 2, '.', '');
									?> TL</td>
									
									
                                   <td><?php echo $tr['kim']?></td>
									<td><?php echo $tr['tarih']?></td>
							
									
									
                                     <td>
									<?php 
									$sipuyeid = $tr['gelenkim'];
									$siparisuyebilgileri = $ozy->query("select * from users where id='$sipuyeid'")->fetch(PDO::FETCH_ASSOC);?>
									<?php if (count($siparisuyebilgileri) == 1) {?>
									
									<b>Misafire malesef bildirim yapılamaz :/</b>
																 
			                        <a href="sepet?temizle=<?php echo $tr['gelenkim'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>	
									<?php } else { ?>
									<a href="tel:<?php echo $siparisuyebilgileri['telefon'];  ?>" target="_blank" onclick="return confirm('Telefon ile yanıt vermek istiyor musun ?')" class="btn btn-sm btn-danger" style="border: none;background: #4192e9;" data-toggle="tooltip" data-original-title="Telefon ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/tel.png"></img></a>									 
									<a href="https://api.whatsapp.com/send?phone=+9<?php echo $tr['telefon'];  ?>&amp;text=Merhaba Sayın <?php echo $siparisuyebilgileri['isim'];  ?>, Sitemiz üzerinden oluşturduğunuz sepetinizdeki ürünler tükenmek üzere . Buna istinaden sizleri rahatsız ediyorum. Bilginize sunar iyi günler dilerim." target="_blank" onclick="return confirm('WhatsApp ile yanıt vermek istiyor musun  ?')" class="btn btn-sm btn-danger" style="border: #2ab200;background: #2ab200;" data-toggle="tooltip" data-original-title="WhatsApp ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/whatsap.jpg"></img></a>	
									<a href="sepet?epostabildir=<?php echo $siparisuyebilgileri['email'];  ?>" onclick="return confirm('Eposta ile yanıt bildirmek istiyor musun  ?')" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Eposta Bildir"><i class="fa fa-envelope" style="color:white;" aria-hidden="true"></i></a>										 
																 
			                        <a href="sepet?temizle=<?php echo $tr['gelenkim'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>	
									<?php } ?>
									
														 
												
									</td>
									
									
									
									
                                </tr>
                               
							
							   
		                    <?php }?>					   
							   
							   
							   
							   
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
