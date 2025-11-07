<?php
paket_kontrol(["plus", "extreme", "enterprise"]); 
admin_yetki($ozy, $_SESSION['departmanid'], 6); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$sayfasil = $ozy->prepare("delete from tumyorumlar where id='$id' and konu='blog'");
$sayfasil->execute(array($id));

if ($sayfasil) {
	


echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';
	
}


}

if (isset($_POST['guncelle'])) {


  $id = $_POST['id'];
  $durum   = temizle($_POST['durum']);
  $cevap   = $_POST['cevap'];
  $uyemail   = $_POST['uyemail'];
  $uyeadi   = $_POST['uyeadi'];
  $sayfaid = $_POST['sayfaid'];
  $url = $ayar['siteurl'];
  
   $stmt = $ozy->prepare("UPDATE tumyorumlar SET durum = ?, cevap = ? WHERE id = ?");
   $result2 = $stmt->execute(array($durum, $cevap, $id));
   
   
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=blog-yorumlari">'; 	

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }

            if($system['uyeblogonay']=='1'){
			$blogbak = $ozy->query("select * from haberler where id='$sayfaid'")->fetch(PDO::FETCH_ASSOC);
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
			$mail->Subject = "Bloga yaptığınız yorum yanıtlandı."; // Konu basligi
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
									<div class="mktEditable" id="intro_title">Yorumunuza Cevap Geldi.
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
										Sitemizdeki <a href="'.$url.'/blog/'.$blogbak['seo'].'" target="_blank"> '.$blogbak['adi'].' </a> isimli yazıya yaptığınız yoruma cevap geldi.
									
									
			                           </br></br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="'.$url.'/blog/'.$blogbak['seo'].'">Cevabı Görüntüle</a>
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

}

 






?>

	
<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Tüm Blog Yorumları</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Yorumlar</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                         
                            <p class="sub-title" style="text-align:right;">
						
                               
                            </p>

                            <table id="datatable" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                   
                                    <th>Adı Soyadı</th>
									<th>Eposta Adresi</th>
									<th>İP Adresi</th>
                                    <th>Yorum</th>
									<th>Cevap</th>
									<th>Blog Linki</th>
                                    <th>Durumu</th>
                                    <th>Tarih</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	                       <?php $pr = $ozy->query("select * from tumyorumlar where konu='blog' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($pr as $tr) {?>	
						   		
								
                                <tr>
                                    <td><?php echo $tr['adi']?></td>
									<td><?php echo $tr['email']?></td>
									<td><?php echo $tr['ip']?></td>
									<td><?php echo strip_tags(mb_substr($tr['yorum'],0,50));?>...</td>
									<td>
									<?php 
									$karakter_sayisi = strlen($tr['cevap']);
									
									if($karakter_sayisi>'1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Cevaplandı</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Cevaplanmadı</span>
                                    <?php } ?>
									</td>	
										
									<?php 
									$sayfamid = $tr['sayfaid'];
									$ppr = $ozy->query("select * from haberler where id='$sayfamid' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($ppr as $ptr) {?>	
									<td><a target="_blank" href="../blog/<?php echo $ptr['seo']?>">Yoruma Git</a></td>
                                     <?php } ?>
									<td>
									<?php if($tr['durum']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Aktif</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Pasif</span>
                                    <?php } ?>
									</td>
									
                                    <td><?php echo $tr['tarih']?></td>
                                    <td>
									
									<a href="blog-yorumlari?temizle=<?php echo $tr['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
			                        <a data-toggle="modal" data-target=".bs-example-modal-lg-<?php echo $tr['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" style="color: white !important;" aria-hidden="true"></i></a>					
												
				
									
									
									</td>
                                </tr>
                               
		                    <?php }?>					   
							   
							   
							
                              
                                </tbody>
                            </table>

                                 <?php $prr = $ozy->query("select * from tumyorumlar where konu='blog' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                                 foreach ($prr as $trr) {?>	

                                  <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
								   <input type="hidden" name="uyeadi" value="<?php echo $tr['adi']?>"/>
                                   <input type="hidden" name="uyemail" value="<?php echo $tr['email']?>"/>
								    <input type="hidden" name="sayfaid" value="<?php echo $tr['sayfaid']?>"/>
									<!--  Modal content for the above example -->
                                    <div class="modal fade bs-example-modal-lg-<?php echo $trr['id']?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg-<?php echo $trr['id']?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0" id="myLargeModalLabel"><?php echo $trr['adi']?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?php echo $trr['yorum']?></p>
								 	
													<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($trr['durum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>
                                            
                                 </div> 

                               <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Cevabınız</label>
                                <div class="col-sm-10">
                                  <textarea id="summernote" class="form-control" rows="8" name="cevap"><?php echo $trr['cevap']; ?></textarea>  
                                </div>
								<input type="hidden" name="id" value="<?php echo $trr['id']?>"/>				
                                <div class="col-sm-12" style="margin-top:20px;">
								<button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>
                                </div>
								
								</div>
												
								


								 
								</div>		
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
								</form>
								
                               <?php }?>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
<style>
.modal-dialog {
    max-width: 1000px;
    margin: 1.75rem auto;
}
</style>