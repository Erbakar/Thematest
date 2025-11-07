<?php
require('../func/db.php');
require('../func/fonksiyon.php');
?>
<!DOCTYPE html>
<html lang="tr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Şifremi Unuttum</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="oziyshop" name="description" />
        <meta content="oziyshop" name="author" />
        <link rel="shortcut icon" href="../resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metismenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/waves.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <link href="assets/toastr/toastr.css" rel="stylesheet"/>
		<script src="assets/toastr/toastr.min.js"></script>
<?php 

if (isset($_POST['sifremiunuttum'])) {

$yeniletip = temizle($_POST['yeniletip']);	
$stelefon = $admintel;
$seposta = $posta;
$sadsoyad = temizle($_POST['sadsoyad']);
$skullaniciadi = temizle($_POST['skullaniciadi']);
$url = $ayar['siteurl'];
if($yeniletip=='1'){
$emailkontrol = $ozy->prepare("SELECT * FROM users WHERE adi=? and kullaniciadi=?");
$emailkontrol->execute(array($sadsoyad,$skullaniciadi));
if ($emailkontrol->rowCount()) {
	
$newsifre = md5($RandStr);
$yenileeposta = $ozy->exec("UPDATE admin SET sifre='{$newsifre}' WHERE kullaniciadi='{$skullaniciadi}' and adi='{$sadsoyad}'");	
		
	
	  if($system['ssifrehatirlat']=='1'){
				$symesaj='Sayın Yönetici , Şifreniz '.$RandStr.' olarak yenilenmiştir. Eğer bu işlemi siz yapmadıysanız lütfen bizimle irtibat kurunuz. '.$ayar['siteadi'].'';
				$symesaj = html_entity_decode($symesaj, ENT_COMPAT, "UTF-8"); 
				$symesaj = rawurlencode($symesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8"); 
				$smsbaslik = rawurlencode($smsbaslik); 
				sendsms($symesaj,$stelefon,$smsbaslik);
	}
	
	
	
	
	
	
}else {

/////SMS İLE ŞİFRE YENİLEME BAŞLIYOR//////


echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm kullanıcı adınız veya adınız hatalıdır.", "Başarısız");});</script>';
    







 /////SMS İLE ŞİFRE YENİLEME BAŞLIYOR//////
}




}else {
  /////EMAİL İLE ŞİFRE YENİLEME BAŞLIYOR//////
 
 
 
$emailkontrol = $ozy->prepare("SELECT * FROM admin WHERE kullaniciadi=? and adi=?");
$emailkontrol->execute(array($skullaniciadi,$sadsoyad));
if ($emailkontrol->rowCount()) {

$newsifre = md5($RandStr);
$yenileeposta = $ozy->exec("UPDATE admin SET sifre='{$newsifre}' WHERE kullaniciadi='{$skullaniciadi}' and adi='{$sadsoyad}'");	
	
	
            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Yeni şifreniz epostanıza iletildi. Lütfen spam klasörünüzüde kontrol etmeyi unutmayın. Teşekkür ederiz.", "Başarılı");});</script>';
	 

            if($yenileeposta){

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
			$mail->AddAddress($seposta); // Maili gonderecegimiz kisi yani alici
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = "Yeni Şifreniz"; // Konu basligi
			$mail->Body = '
			
		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="'.$url.'"><img style="height: 30px;line-height: 1;width: 200px;margin: 80px;" class="top-image" src="'.$url.'/resimler/siteayarlari/'.$ayar['logo'].'"  alt="'.$siteadi.'"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">
										Talebiniz üzerine şifreniz yenilenmiştir.</br>
									
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="'.$url.'/mail/webinar-no-text.png" width="560"/><br><br>

										<strong>Sayın,</strong> '.$sadsoyad.'<br>
										<strong>Yeni Şifreniz :</strong> '.$RandStr.'<br>
										<strong>Eğer bu işlemi siz yapmadıysanız lütfen bizimle iletişime geçiniz.<br>
			                            <strong>İP Adresi</strong>: '.$ip.'<br><br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank">'.$RandStr.'</a>
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
	
 
}else {




echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm girdiğiniz veriler hatalı.", "Başarısız");});</script>';
    
 
  }
 
 
 
 
  /////EMAİL İLE ŞİFRE YENİLEME BAŞLIYOR//////
  }
 
 
} 

?>				
		
		
    </head>

    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
       
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">
    
                    <div class="card-body">
                           <div class="text-center m-t-0 m-b-15">
                                <a href="index.html" class="logo logo-admin">
								<img src="../resimler/siteayarlari/<?php echo $ayar['logo']; ?>" alt="" height="80"></a>
                        </div>
                        <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Şifremi Unuttum</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
                        
            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
    
            			<form action="" method="POST"/>
		                	<div class="row">
		                		<div class="col-lg-12" style="border: 1px solid #f8f8f8;border-radius: 4px;">
		                			<h2 class="checkout-title" style="font-size: 14px;margin-bottom: 30px;text-align: center;">Şifremi Unuttum</h2><!-- End .checkout-title -->
		                				<div class="row">
							
							
							<div class="col-sm-12" style="margin-bottom: 20px;">			
						    <div class="md-form md-outline">
							<input name="sadsoyad" type="text" class="form-control" required>
                            <label for="form15" class="active">Adınız Soyadınız</label>
                            </div>
				            </div>
							
							<div class="col-sm-12" style="margin-bottom: 20px;">			
						    <div class="md-form md-outline">
							<input name="skullaniciadi" type="text" class="form-control" required>
                            <label for="form15" class="active">Kullanıcı Adı</label>
                            </div>
				            </div>
							<div class="col-sm-12" style="margin-bottom: 20px;">
                            <?php if($system['sifrehatirlat']=='1'){?>							
						    <div class="md-form md-outline" style="width: 48%;float: left;">
						    <div class="kutu">
							<input  value="0" name="yeniletip" type="radio" class="login-check" id="register-check-20" required> 
							Eposta ile Şifre Alma
						    </div>
                            <label for="form15" class="active">Şifre Hatırlatma</label>
                            </div>
							<?php } ?>
							<?php if($system['ssifrehatirlat']=='1'){?>
				            <div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;">
						    <div class="kutu">
							<input  value="1" name="yeniletip" type="radio" class="login-check" id="register-check-20" required> 
							SMS ile Şifre Alma
						    </div>
                            <label for="form15" class="active">Şifre Hatırlatma</label>
                            </div>
							<?php } ?>
				            </div>
							
			
						
	                		


							

	                			</div><!-- End .col-lg-9 -->
		                			<button type="submit" name="sifremiunuttum" class="btn btn-warning btn-block btn-lg waves-effect waves-light">
                                                <span>ŞİFREMİ UNUTTUM</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
		                	</div><!-- End .row -->
							
							
							
							
							
            			</form>
						
						
					
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div>
			</div>
						
						
						
						
						
						
                    </div>
    
                </div>
            </div>
        <!-- END wrapper -->


        
    </body>
<script>
$(document).ready(function() {
		

	
	
	$('input[name="yeniletip"]').on("change",function(){
			//alert($(this).prop("value"));
		if($(this).prop("value")=="1"){
			$("#kurumsal").show();
			$("#kurumsal2").show();
			$("#kurumsal3").show();
			$("#bireysel").hide();
		}
		else{
			$("#kurumsal").hide();
			$("#kurumsal2").hide();
			$("#kurumsal3").hide();
			$("#bireysel").show();
		}
	});	
	
	
	

    });	
		
</script>
<style>
.md-form input:not([type]):focus:not([readonly])+label,
.md-form input[type=date]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=datetime]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=datetime-local]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=tel]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=number]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=search]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=phone]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=search-md]:focus:not([readonly])+label,
.md-form input[type=text]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=password]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=email]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=url]:not(.browser-default):focus:not([readonly])+label,
.md-form input[type=time]:not(.browser-default):focus:not([readonly])+label,
.md-form textarea.md-textarea:focus:not([readonly])+label {
 color:#4285f4
}
.md-form.md-outline label.active {
    left: 8px;
    padding-right: 5px;
    padding-left: 5px;
    font-weight: 500;
    background: #fff;
    -webkit-transform: translateY(-13px) scale(.8);
    transform: translateY(-13px) scale(.8);
    font-size: 16px;
    top: -5px;
    color: #a9acae;
    height: 30px;
    margin-top: -10px !important;
    font-size: 14px !important;
}
.md-form input:not([type])+label::after,
.md-form input[type=date]:not(.browser-default)+label::after,
.md-form input[type=datetime]:not(.browser-default)+label::after,
.md-form input[type=datetime-local]:not(.browser-default)+label::after,
.md-form input[type=tel]:not(.browser-default)+label::after,
.md-form input[type=number]:not(.browser-default)+label::after,
.md-form input[type=search]:not(.browser-default)+label::after,
.md-form input[type=phone]:not(.browser-default)+label::after,
.md-form input[type=search-md]+label::after,
.md-form input[type=text]:not(.browser-default)+label::after,
.md-form input[type=password]:not(.browser-default)+label::after,
.md-form input[type=email]:not(.browser-default)+label::after,
.md-form input[type=url]:not(.browser-default)+label::after,
.md-form input[type=time]:not(.browser-default)+label::after,
.md-form textarea.md-textarea+label::after {
 position:absolute;
 top:65px;
 display:block;
 content:"";
 opacity:0;
 -webkit-transition:.2s opacity ease-out,.2s color ease-out;
 transition:.2s opacity ease-out,.2s color ease-out
}
.md-form input:not([type]).valid,
.md-form input:not([type]):focus.valid,
.md-form input[type=date]:not(.browser-default).valid,
.md-form input[type=date]:not(.browser-default):focus.valid,
.md-form input[type=datetime]:not(.browser-default).valid,
.md-form input[type=datetime]:not(.browser-default):focus.valid,
.md-form input[type=datetime-local]:not(.browser-default).valid,
.md-form input[type=datetime-local]:not(.browser-default):focus.valid,
.md-form input[type=tel]:not(.browser-default).valid,
.md-form input[type=tel]:not(.browser-default):focus.valid,
.md-form input[type=number]:not(.browser-default).valid,
.md-form input[type=number]:not(.browser-default):focus.valid,
.md-form input[type=search]:not(.browser-default).valid,
.md-form input[type=search]:not(.browser-default):focus.valid,
.md-form input[type=phone]:not(.browser-default).valid,
.md-form input[type=phone]:not(.browser-default):focus.valid,
.md-form input[type=search-md].valid,
.md-form input[type=search-md]:focus.valid,
.md-form input[type=text]:not(.browser-default).valid,
.md-form input[type=text]:not(.browser-default):focus.valid,
.md-form input[type=password]:not(.browser-default).valid,
.md-form input[type=password]:not(.browser-default):focus.valid,
.md-form input[type=email]:not(.browser-default).valid,
.md-form input[type=email]:not(.browser-default):focus.valid,
.md-form input[type=url]:not(.browser-default).valid,
.md-form input[type=url]:not(.browser-default):focus.valid,
.md-form input[type=time]:not(.browser-default).valid,
.md-form input[type=time]:not(.browser-default):focus.valid,
.md-form textarea.md-textarea.valid,
.md-form textarea.md-textarea:focus.valid {
 border-bottom:1px solid #00c851;
 -webkit-box-shadow:0 1px 0 0 #00c851;
 box-shadow:0 1px 0 0 #00c851
}
.md-form input:not([type]).valid+label:after,
.md-form input:not([type]):focus.valid+label:after,
.md-form input[type=date]:not(.browser-default).valid+label:after,
.md-form input[type=date]:not(.browser-default):focus.valid+label:after,
.md-form input[type=datetime]:not(.browser-default).valid+label:after,
.md-form input[type=datetime]:not(.browser-default):focus.valid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).valid+label:after,
.md-form input[type=datetime-local]:not(.browser-default):focus.valid+label:after,
.md-form input[type=tel]:not(.browser-default).valid+label:after,
.md-form input[type=tel]:not(.browser-default):focus.valid+label:after,
.md-form input[type=number]:not(.browser-default).valid+label:after,
.md-form input[type=number]:not(.browser-default):focus.valid+label:after,
.md-form input[type=search]:not(.browser-default).valid+label:after,
.md-form input[type=search]:not(.browser-default):focus.valid+label:after,
.md-form input[type=phone]:not(.browser-default).valid+label:after,
.md-form input[type=phone]:not(.browser-default):focus.valid+label:after,
.md-form input[type=search-md].valid+label:after,
.md-form input[type=search-md]:focus.valid+label:after,
.md-form input[type=text]:not(.browser-default).valid+label:after,
.md-form input[type=text]:not(.browser-default):focus.valid+label:after,
.md-form input[type=password]:not(.browser-default).valid+label:after,
.md-form input[type=password]:not(.browser-default):focus.valid+label:after,
.md-form input[type=email]:not(.browser-default).valid+label:after,
.md-form input[type=email]:not(.browser-default):focus.valid+label:after,
.md-form input[type=url]:not(.browser-default).valid+label:after,
.md-form input[type=url]:not(.browser-default):focus.valid+label:after,
.md-form input[type=time]:not(.browser-default).valid+label:after,
.md-form input[type=time]:not(.browser-default):focus.valid+label:after,
.md-form textarea.md-textarea.valid+label:after,
.md-form textarea.md-textarea:focus.valid+label:after {
 color:#00c851;
 content:attr(data-success);
 opacity:1
}
.md-form input:not([type]).invalid,
.md-form input:not([type]):focus.invalid,
.md-form input[type=date]:not(.browser-default).invalid,
.md-form input[type=date]:not(.browser-default):focus.invalid,
.md-form input[type=datetime]:not(.browser-default).invalid,
.md-form input[type=datetime]:not(.browser-default):focus.invalid,
.md-form input[type=datetime-local]:not(.browser-default).invalid,
.md-form input[type=datetime-local]:not(.browser-default):focus.invalid,
.md-form input[type=tel]:not(.browser-default).invalid,
.md-form input[type=tel]:not(.browser-default):focus.invalid,
.md-form input[type=number]:not(.browser-default).invalid,
.md-form input[type=number]:not(.browser-default):focus.invalid,
.md-form input[type=search]:not(.browser-default).invalid,
.md-form input[type=search]:not(.browser-default):focus.invalid,
.md-form input[type=phone]:not(.browser-default).invalid,
.md-form input[type=phone]:not(.browser-default):focus.invalid,
.md-form input[type=search-md].invalid,
.md-form input[type=search-md]:focus.invalid,
.md-form input[type=text]:not(.browser-default).invalid,
.md-form input[type=text]:not(.browser-default):focus.invalid,
.md-form input[type=password]:not(.browser-default).invalid,
.md-form input[type=password]:not(.browser-default):focus.invalid,
.md-form input[type=email]:not(.browser-default).invalid,
.md-form input[type=email]:not(.browser-default):focus.invalid,
.md-form input[type=url]:not(.browser-default).invalid,
.md-form input[type=url]:not(.browser-default):focus.invalid,
.md-form input[type=time]:not(.browser-default).invalid,
.md-form input[type=time]:not(.browser-default):focus.invalid,
.md-form textarea.md-textarea.invalid,
.md-form textarea.md-textarea:focus.invalid {
 border-bottom:1px solid #f44336;
 -webkit-box-shadow:0 1px 0 0 #f44336;
 box-shadow:0 1px 0 0 #f44336
}
.md-form input:not([type]).invalid+label:after,
.md-form input:not([type]):focus.invalid+label:after,
.md-form input[type=date]:not(.browser-default).invalid+label:after,
.md-form input[type=date]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=datetime]:not(.browser-default).invalid+label:after,
.md-form input[type=datetime]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).invalid+label:after,
.md-form input[type=datetime-local]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=tel]:not(.browser-default).invalid+label:after,
.md-form input[type=tel]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=number]:not(.browser-default).invalid+label:after,
.md-form input[type=number]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=search]:not(.browser-default).invalid+label:after,
.md-form input[type=search]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=phone]:not(.browser-default).invalid+label:after,
.md-form input[type=phone]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=search-md].invalid+label:after,
.md-form input[type=search-md]:focus.invalid+label:after,
.md-form input[type=text]:not(.browser-default).invalid+label:after,
.md-form input[type=text]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=password]:not(.browser-default).invalid+label:after,
.md-form input[type=password]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=email]:not(.browser-default).invalid+label:after,
.md-form input[type=email]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=url]:not(.browser-default).invalid+label:after,
.md-form input[type=url]:not(.browser-default):focus.invalid+label:after,
.md-form input[type=time]:not(.browser-default).invalid+label:after,
.md-form input[type=time]:not(.browser-default):focus.invalid+label:after,
.md-form textarea.md-textarea.invalid+label:after,
.md-form textarea.md-textarea:focus.invalid+label:after {
 color:#f44336;
 content:attr(data-error);
 opacity:1
}
.md-form input:not([type]).form-control.valid+label:after,
.md-form input:not([type]).form-control:focus.valid+label:after,
.md-form input[type=date]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=date]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=number]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=number]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=search]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=search]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=search-md].form-control.valid+label:after,
.md-form input[type=search-md].form-control:focus.valid+label:after,
.md-form input[type=text]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=text]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=password]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=password]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=email]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=email]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=url]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=url]:not(.browser-default).form-control:focus.valid+label:after,
.md-form input[type=time]:not(.browser-default).form-control.valid+label:after,
.md-form input[type=time]:not(.browser-default).form-control:focus.valid+label:after,
.md-form textarea.md-textarea.form-control.valid+label:after,
.md-form textarea.md-textarea.form-control:focus.valid+label:after {
 top:4.1rem
}
.md-form input:not([type]).form-control.invalid+label:after,
.md-form input:not([type]).form-control:focus.invalid+label:after,
.md-form input[type=date]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=date]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=number]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=number]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=search]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=search]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=search-md].form-control.invalid+label:after,
.md-form input[type=search-md].form-control:focus.invalid+label:after,
.md-form input[type=text]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=text]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=password]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=password]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=email]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=email]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=url]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=url]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form input[type=time]:not(.browser-default).form-control.invalid+label:after,
.md-form input[type=time]:not(.browser-default).form-control:focus.invalid+label:after,
.md-form textarea.md-textarea.form-control.invalid+label:after,
.md-form textarea.md-textarea.form-control:focus.invalid+label:after {
 top:4rem
}
.md-form input:not([type]).form-control-lg.invalid+label:after,
.md-form input:not([type]).form-control-lg.valid+label:after,
.md-form input:not([type]).form-control-lg:focus.invalid+label:after,
.md-form input:not([type]).form-control-lg:focus.valid+label:after,
.md-form input[type=date]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=date]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=date]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=date]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=number]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=number]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=number]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=number]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=search]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=search]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=search]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=search]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=search-md].form-control-lg.invalid+label:after,
.md-form input[type=search-md].form-control-lg.valid+label:after,
.md-form input[type=search-md].form-control-lg:focus.invalid+label:after,
.md-form input[type=search-md].form-control-lg:focus.valid+label:after,
.md-form input[type=text]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=text]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=text]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=text]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=password]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=password]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=password]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=password]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=email]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=email]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=email]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=email]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=url]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=url]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=url]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=url]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form input[type=time]:not(.browser-default).form-control-lg.invalid+label:after,
.md-form input[type=time]:not(.browser-default).form-control-lg.valid+label:after,
.md-form input[type=time]:not(.browser-default).form-control-lg:focus.invalid+label:after,
.md-form input[type=time]:not(.browser-default).form-control-lg:focus.valid+label:after,
.md-form textarea.md-textarea.form-control-lg.invalid+label:after,
.md-form textarea.md-textarea.form-control-lg.valid+label:after,
.md-form textarea.md-textarea.form-control-lg:focus.invalid+label:after,
.md-form textarea.md-textarea.form-control-lg:focus.valid+label:after {
 top:4.6rem
}
.md-form input:not([type]).form-control-sm.valid+label:after,
.md-form input:not([type]).form-control-sm:focus.valid+label:after,
.md-form input[type=date]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=date]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=number]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=number]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=search]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=search]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=search-md].form-control-sm.valid+label:after,
.md-form input[type=search-md].form-control-sm:focus.valid+label:after,
.md-form input[type=text]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=text]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=password]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=password]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=email]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=email]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=url]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=url]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form input[type=time]:not(.browser-default).form-control-sm.valid+label:after,
.md-form input[type=time]:not(.browser-default).form-control-sm:focus.valid+label:after,
.md-form textarea.md-textarea.form-control-sm.valid+label:after,
.md-form textarea.md-textarea.form-control-sm:focus.valid+label:after {
 top:3.7rem
}
.md-form input:not([type]).form-control-sm.invalid+label:after,
.md-form input:not([type]).form-control-sm:focus.invalid+label:after,
.md-form input[type=date]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=date]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=datetime]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=datetime-local]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=tel]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=number]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=number]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=search]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=search]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=phone]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=search-md].form-control-sm.invalid+label:after,
.md-form input[type=search-md].form-control-sm:focus.invalid+label:after,
.md-form input[type=text]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=text]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=password]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=password]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=email]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=email]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=url]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=url]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form input[type=time]:not(.browser-default).form-control-sm.invalid+label:after,
.md-form input[type=time]:not(.browser-default).form-control-sm:focus.invalid+label:after,
.md-form textarea.md-textarea.form-control-sm.invalid+label:after,
.md-form textarea.md-textarea.form-control-sm:focus.invalid+label:after {
 top:3.6rem
}
.md-form>input[type=date]:not(.browser-default)+label {
 -webkit-transform:translateY(-27px) scale(.8);
 transform:translateY(-27px) scale(.8);
 -webkit-transform-origin:0 0;
 transform-origin:0 0
}
.md-form>input[type=time]:not(.browser-default)+label,
.md-form>input[type]:-webkit-autofill:not(.browser-default):not([type=search])+label {
 font-size:.8rem;
 -webkit-transform:translateY(-25px);
 transform:translateY(-25px);
 -webkit-transform-origin:0 0;
 transform-origin:0 0
}
.md-form .was-validated input[type=text]:valid+label {
 color:#00c851!important
}
.md-form .was-validated input[type=text]:invalid+label {
 color:#f44336!important
}
.md-form .was-validated .form-control:valid:focus {
 -webkit-box-shadow:0 1px 0 0 #00c851!important;
 box-shadow:0 1px 0 0 #00c851!important
}
.md-form .was-validated .form-control:valid {
 border-color:#00c851!important
}
.md-form .was-validated .form-control:invalid:focus {
 -webkit-box-shadow:0 1px 0 0 #f44336!important;
 box-shadow:0 1px 0 0 #f44336!important
}
.md-form .was-validated .form-control:invalid {
 border-color:#f44336!important
}
.md-form .form-control {
 height:auto;
 padding:.6rem 0 .4rem;
 margin:0 0 .5rem;
 background-color:transparent;
 border-radius:0
}
.md-form .form-control:focus {
 -webkit-box-shadow:none;
 box-shadow:none
}
.md-form .form-control:disabled,
.md-form .form-control[readonly] {
 background-color:transparent;
 border-bottom:1px solid #bdbdbd
}
.md-form .form-control.is-valid {
 border-color:#00c851
}
.md-form .form-control.is-valid:focus {
 border-color:#00c851!important;
 -webkit-box-shadow:0 1px 0 0 #00c851!important;
 box-shadow:0 1px 0 0 #00c851!important
}
.md-form .form-control.is-invalid {
 border-color:#f44336
}
.md-form .form-control.is-invalid:focus {
 border-color:#f44336!important;
 -webkit-box-shadow:0 1px 0 0 #f44336!important;
 box-shadow:0 1px 0 0 #f44336!important
}
.md-form .form-control.is-invalid,
.md-form .form-control.is-valid {
 background-position:center right!important
}
.md-form .validate {
 margin-bottom:2.5rem
}
.md-form label,
.md-form label.active {
 font-size:1rem
}
.md-form .prefix {
 top:.25rem;
 font-size:1.75rem
}
.md-form .prefix~input,
.md-form .prefix~textarea {
 width:calc(100% - 2.5rem);
 margin-left:2.5rem
}
.md-form .prefix~label {
 margin-left:2.5rem
}
.md-form .prefix~.form-text {
 margin-left:2.6rem
}
.md-form label {
 position:absolute;
 top:0;
 left:0;
 font-size:1rem;
 color:#757575;
 cursor:text;
 -webkit-transition:color .2s ease-out,-webkit-transform .2s ease-out;
 transition:color .2s ease-out,-webkit-transform .2s ease-out;
 transition:transform .2s ease-out,color .2s ease-out;
 transition:transform .2s ease-out,color .2s ease-out,-webkit-transform .2s ease-out;
 -webkit-transform:translateY(12px);
 transform:translateY(12px);
 -webkit-transform-origin:0 100%;
 transform-origin:0 100%
}
.md-form .prefix.active,
.md-form.md-outline input[type=date]:focus:not([readonly])+label,
.md-form.md-outline input[type=datetime-local]:focus:not([readonly])+label,
.md-form.md-outline input[type=tel]:focus:not([readonly])+label,
.md-form.md-outline input[type=number]:focus:not([readonly])+label,
.md-form.md-outline input[type=search]:focus:not([readonly])+label,
.md-form.md-outline input[type=search-md]:focus:not([readonly])+label,
.md-form.md-outline input[type=text]:focus:not([readonly])+label,
.md-form.md-outline input[type=password]:focus:not([readonly])+label,
.md-form.md-outline input[type=email]:focus:not([readonly])+label,
.md-form.md-outline input[type=url]:focus:not([readonly])+label,
.md-form.md-outline input[type=time]:focus:not([readonly])+label,
.md-form.md-outline textarea.md-textarea:focus:not([readonly])+label {
 color:#4285f4
}
.md-form label.active {
 -webkit-transform:translateY(-14px) scale(.8);
 transform:translateY(-14px) scale(.8)
}
.md-form .prefix {
 position:absolute;
 -webkit-transition:color .2s;
 transition:color .2s
}
.md-form.form-lg label {
 font-size:1.25rem
}
.md-form.form-lg label.active {
 font-size:1.15rem
}
.md-form.form-lg .prefix {
 top:.4rem;
 font-size:2rem
}
.md-form.form-lg .prefix~input,
.md-form.form-lg .prefix~textarea {
 width:calc(100% - 3rem);
 margin-left:3rem
}
.md-form.form-lg .prefix~label {
 margin-left:3rem
}
.md-form.form-lg .prefix~.form-text {
 margin-left:3.1rem
}
.md-form.form-sm .validate {
 margin-bottom:2.3rem
}
.md-form.form-sm label {
 font-size:.875rem
}
.md-form.form-sm label.active {
 font-size:.95rem
}
.md-form.form-sm .prefix {
 top:.35rem;
 font-size:1.5rem
}
.md-form.form-sm .prefix~input,
.md-form.form-sm .prefix~textarea {
 width:calc(100% - 2rem);
 margin-left:2rem
}
.md-form.form-sm .prefix~.form-text,
.md-form.form-sm .prefix~label {
 margin-left:2rem
}
.md-form textarea.md-textarea {
 padding:0;
 overflow-y:hidden
}
.md-form textarea.md-textarea+label {
 top:-.6rem
}
.md-form textarea.md-textarea-auto {
 padding:1.5rem 0 0
}
.md-form textarea.md-textarea-auto+label {
 top:0
}
.md-form.md-outline {
 position:relative;
 margin-top:5px;
 margin-bottom:10px;
}
.md-form.md-outline input[type=date],
.md-form.md-outline input[type=datetime-local],
.md-form.md-outline input[type=tel],
.md-form.md-outline input[type=number],
.md-form.md-outline input[type=search],
.md-form.md-outline input[type=search-md],
.md-form.md-outline input[type=text],
.md-form.md-outline input[type=password],
.md-form.md-outline input[type=email],
.md-form.md-outline input[type=url],
.md-form.md-outline input[type=time],
.md-form.md-outline textarea.md-textarea {
 -webkit-box-sizing:border-box;
 box-sizing:border-box;
 background-color:transparent;
 border:1px solid #dadce0;
 border-radius:2px;
 outline:0;
 -webkit-box-shadow:none;
 box-shadow:none;
 -webkit-transition:all .3s;
 transition:all .3s;
 height: 45px;
}
.md-form.md-outline input[type=date]:focus:not([readonly]),
.md-form.md-outline input[type=datetime-local]:focus:not([readonly]),
.md-form.md-outline input[type=tel]:focus:not([readonly]),
.md-form.md-outline input[type=number]:focus:not([readonly]),
.md-form.md-outline input[type=search]:focus:not([readonly]),
.md-form.md-outline input[type=search-md]:focus:not([readonly]),
.md-form.md-outline input[type=text]:focus:not([readonly]),
.md-form.md-outline input[type=password]:focus:not([readonly]),
.md-form.md-outline input[type=email]:focus:not([readonly]),
.md-form.md-outline input[type=url]:focus:not([readonly]),
.md-form.md-outline input[type=time]:focus:not([readonly]),
.md-form.md-outline textarea.md-textarea:focus:not([readonly]) {
 border-color:#4285f4;
 -webkit-box-shadow:inset 0 0 0 1px #4285f4;
 box-shadow:inset 0 0 0 1px #4285f4
}
.md-form.md-outline input[type=date].valid,
.md-form.md-outline input[type=date]:focus.valid,
.md-form.md-outline input[type=datetime-local].valid,
.md-form.md-outline input[type=datetime-local]:focus.valid,
.md-form.md-outline input[type=tel].valid,
.md-form.md-outline input[type=tel]:focus.valid,
.md-form.md-outline input[type=number].valid,
.md-form.md-outline input[type=number]:focus.valid,
.md-form.md-outline input[type=search].valid,
.md-form.md-outline input[type=search]:focus.valid,
.md-form.md-outline input[type=search-md].valid,
.md-form.md-outline input[type=search-md]:focus.valid,
.md-form.md-outline input[type=text].valid,
.md-form.md-outline input[type=text]:focus.valid,
.md-form.md-outline input[type=password].valid,
.md-form.md-outline input[type=password]:focus.valid,
.md-form.md-outline input[type=email].valid,
.md-form.md-outline input[type=email]:focus.valid,
.md-form.md-outline input[type=url].valid,
.md-form.md-outline input[type=url]:focus.valid,
.md-form.md-outline input[type=time].valid,
.md-form.md-outline input[type=time]:focus.valid,
.md-form.md-outline textarea.md-textarea.valid,
.md-form.md-outline textarea.md-textarea:focus.valid {
 border-color:#00c851;
 -webkit-box-shadow:inset 0 0 0 1px #00c851;
 box-shadow:inset 0 0 0 1px #00c851
}
.md-form.md-outline input[type=date].valid+label:after,
.md-form.md-outline input[type=date]:focus.valid+label:after,
.md-form.md-outline input[type=date]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=datetime-local].valid+label:after,
.md-form.md-outline input[type=datetime-local]:focus.valid+label:after,
.md-form.md-outline input[type=datetime-local]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=tel].valid+label:after,
.md-form.md-outline input[type=tel]:focus.valid+label:after,
.md-form.md-outline input[type=tel]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=number].valid+label:after,
.md-form.md-outline input[type=number]:focus.valid+label:after,
.md-form.md-outline input[type=number]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=search].valid+label:after,
.md-form.md-outline input[type=search]:focus.valid+label:after,
.md-form.md-outline input[type=search]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=search-md].valid+label:after,
.md-form.md-outline input[type=search-md]:focus.valid+label:after,
.md-form.md-outline input[type=search-md]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=text].valid+label:after,
.md-form.md-outline input[type=text]:focus.valid+label:after,
.md-form.md-outline input[type=text]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=password].valid+label:after,
.md-form.md-outline input[type=password]:focus.valid+label:after,
.md-form.md-outline input[type=password]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=email].valid+label:after,
.md-form.md-outline input[type=email]:focus.valid+label:after,
.md-form.md-outline input[type=email]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=url].valid+label:after,
.md-form.md-outline input[type=url]:focus.valid+label:after,
.md-form.md-outline input[type=url]:focus:not([readonly]).valid+label,
.md-form.md-outline input[type=time].valid+label:after,
.md-form.md-outline input[type=time]:focus.valid+label:after,
.md-form.md-outline input[type=time]:focus:not([readonly]).valid+label,
.md-form.md-outline textarea.md-textarea.valid+label:after,
.md-form.md-outline textarea.md-textarea:focus.valid+label:after,
.md-form.md-outline textarea.md-textarea:focus:not([readonly]).valid+label {
 color:#00c851;
 content:attr(data-success);
 opacity:1
}
.md-form.md-outline input[type=date].invalid,
.md-form.md-outline input[type=date]:focus.invalid,
.md-form.md-outline input[type=datetime-local].invalid,
.md-form.md-outline input[type=datetime-local]:focus.invalid,
.md-form.md-outline input[type=tel].invalid,
.md-form.md-outline input[type=tel]:focus.invalid,
.md-form.md-outline input[type=number].invalid,
.md-form.md-outline input[type=number]:focus.invalid,
.md-form.md-outline input[type=search].invalid,
.md-form.md-outline input[type=search]:focus.invalid,
.md-form.md-outline input[type=search-md].invalid,
.md-form.md-outline input[type=search-md]:focus.invalid,
.md-form.md-outline input[type=text].invalid,
.md-form.md-outline input[type=text]:focus.invalid,
.md-form.md-outline input[type=password].invalid,
.md-form.md-outline input[type=password]:focus.invalid,
.md-form.md-outline input[type=email].invalid,
.md-form.md-outline input[type=email]:focus.invalid,
.md-form.md-outline input[type=url].invalid,
.md-form.md-outline input[type=url]:focus.invalid,
.md-form.md-outline input[type=time].invalid,
.md-form.md-outline input[type=time]:focus.invalid,
.md-form.md-outline textarea.md-textarea.invalid,
.md-form.md-outline textarea.md-textarea:focus.invalid {
 border-color:#f44336;
 -webkit-box-shadow:inset 0 0 0 1px #f44336;
 box-shadow:inset 0 0 0 1px #f44336
}
.md-form.md-outline input[type=date].invalid+label:after,
.md-form.md-outline input[type=date]:focus.invalid+label:after,
.md-form.md-outline input[type=date]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=datetime-local].invalid+label:after,
.md-form.md-outline input[type=datetime-local]:focus.invalid+label:after,
.md-form.md-outline input[type=datetime-local]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=tel].invalid+label:after,
.md-form.md-outline input[type=tel]:focus.invalid+label:after,
.md-form.md-outline input[type=tel]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=number].invalid+label:after,
.md-form.md-outline input[type=number]:focus.invalid+label:after,
.md-form.md-outline input[type=number]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=search].invalid+label:after,
.md-form.md-outline input[type=search]:focus.invalid+label:after,
.md-form.md-outline input[type=search]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=search-md].invalid+label:after,
.md-form.md-outline input[type=search-md]:focus.invalid+label:after,
.md-form.md-outline input[type=search-md]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=text].invalid+label:after,
.md-form.md-outline input[type=text]:focus.invalid+label:after,
.md-form.md-outline input[type=text]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=password].invalid+label:after,
.md-form.md-outline input[type=password]:focus.invalid+label:after,
.md-form.md-outline input[type=password]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=email].invalid+label:after,
.md-form.md-outline input[type=email]:focus.invalid+label:after,
.md-form.md-outline input[type=email]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=url].invalid+label:after,
.md-form.md-outline input[type=url]:focus.invalid+label:after,
.md-form.md-outline input[type=url]:focus:not([readonly]).invalid+label,
.md-form.md-outline input[type=time].invalid+label:after,
.md-form.md-outline input[type=time]:focus.invalid+label:after,
.md-form.md-outline input[type=time]:focus:not([readonly]).invalid+label,
.md-form.md-outline textarea.md-textarea.invalid+label:after,
.md-form.md-outline textarea.md-textarea:focus.invalid+label:after,
.md-form.md-outline textarea.md-textarea:focus:not([readonly]).invalid+label {
 color:#f44336;
 content:attr(data-error);
 opacity:1
}
.md-form.md-outline input[type=date].form-control.invalid+label:after,
.md-form.md-outline input[type=date].form-control.valid+label:after,
.md-form.md-outline input[type=date].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=date].form-control:focus.valid+label:after,
.md-form.md-outline input[type=datetime-local].form-control.invalid+label:after,
.md-form.md-outline input[type=datetime-local].form-control.valid+label:after,
.md-form.md-outline input[type=datetime-local].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=datetime-local].form-control:focus.valid+label:after,
.md-form.md-outline input[type=tel].form-control.invalid+label:after,
.md-form.md-outline input[type=tel].form-control.valid+label:after,
.md-form.md-outline input[type=tel].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=tel].form-control:focus.valid+label:after,
.md-form.md-outline input[type=number].form-control.invalid+label:after,
.md-form.md-outline input[type=number].form-control.valid+label:after,
.md-form.md-outline input[type=number].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=number].form-control:focus.valid+label:after,
.md-form.md-outline input[type=search].form-control.invalid+label:after,
.md-form.md-outline input[type=search].form-control.valid+label:after,
.md-form.md-outline input[type=search].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=search].form-control:focus.valid+label:after,
.md-form.md-outline input[type=search-md].form-control.invalid+label:after,
.md-form.md-outline input[type=search-md].form-control.valid+label:after,
.md-form.md-outline input[type=search-md].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=search-md].form-control:focus.valid+label:after,
.md-form.md-outline input[type=text].form-control.invalid+label:after,
.md-form.md-outline input[type=text].form-control.valid+label:after,
.md-form.md-outline input[type=text].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=text].form-control:focus.valid+label:after,
.md-form.md-outline input[type=password].form-control.invalid+label:after,
.md-form.md-outline input[type=password].form-control.valid+label:after,
.md-form.md-outline input[type=password].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=password].form-control:focus.valid+label:after,
.md-form.md-outline input[type=email].form-control.invalid+label:after,
.md-form.md-outline input[type=email].form-control.valid+label:after,
.md-form.md-outline input[type=email].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=email].form-control:focus.valid+label:after,
.md-form.md-outline input[type=url].form-control.invalid+label:after,
.md-form.md-outline input[type=url].form-control.valid+label:after,
.md-form.md-outline input[type=url].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=url].form-control:focus.valid+label:after,
.md-form.md-outline input[type=time].form-control.invalid+label:after,
.md-form.md-outline input[type=time].form-control.valid+label:after,
.md-form.md-outline input[type=time].form-control:focus.invalid+label:after,
.md-form.md-outline input[type=time].form-control:focus.valid+label:after,
.md-form.md-outline textarea.md-textarea.form-control.invalid+label:after,
.md-form.md-outline textarea.md-textarea.form-control.valid+label:after,
.md-form.md-outline textarea.md-textarea.form-control:focus.invalid+label:after,
.md-form.md-outline textarea.md-textarea.form-control:focus.valid+label:after {
 position:absolute;
 top:4rem;
 left:0
}
.md-form.md-outline>input[type=time]:not(.browser-default)+label,
.md-form.md-outline>input[type]:-webkit-autofill:not(.browser-default):not([type=search])+label {
 left:8px;
 padding-right:5px;
 padding-left:5px;
 font-size:1rem;
 font-weight:500;
 background:#fff;
 -webkit-transform:translateY(-9px) scale(.8);
 transform:translateY(-9px) scale(.8);
 -webkit-transform-origin:0 0;
 transform-origin:0 0
}
.md-form.md-outline>input[type=time]:not(.browser-default)+label.active,
.md-form.md-outline>input[type]:-webkit-autofill:not(.browser-default):not([type=search])+label.active {
 -webkit-transform:translateY(-9px) scale(.8);
 transform:translateY(-9px) scale(.8);
 -webkit-transform-origin:0 0;
 transform-origin:0 0
}
@-webkit-keyframes autofill {
 to {
  color:#495057;
  background:0 0
 }
}
@keyframes autofill {
 to {
  color:#495057;
  background:0 0
 }
}
.md-form.md-outline input:-webkit-autofill {
 -webkit-animation-name:autofill;
 animation-name:autofill;
 -webkit-animation-fill-mode:both;
 animation-fill-mode:both
}
.md-form.md-outline .form-control {
 padding:.375rem .75rem;
 /*! padding-top: 100px; */
}
.md-form.md-outline label {
 position:absolute;
 top:0;
 left:0;
 padding-left:10px;
 font-size:1rem;
 color:#757575;
 cursor:text;
 -webkit-transition:color .2s ease-out,-webkit-transform .2s ease-out;
 transition:color .2s ease-out,-webkit-transform .2s ease-out;
 transition:transform .2s ease-out,color .2s ease-out;
 transition:transform .2s ease-out,color .2s ease-out,-webkit-transform .2s ease-out;
 -webkit-transform:translateY(9px);
 transform:translateY(9px);
 -webkit-transform-origin:0 100%;
 transform-origin:0 100%
}
.md-form.md-outline label.active {
 left:8px;
 padding-right:5px;
 padding-left:5px;
 font-weight:500;
 background:#fff;
 -webkit-transform:translateY(-13px) scale(.8);
 transform:translateY(-13px) scale(.8);
 font-size: 16px;
 top: -5px;
 color: #a9acae;
 /*! height: 30px; */
}
.md-form.md-outline.form-lg .form-control.form-control-lg {
 padding:.5rem .725rem
}
.md-form.md-outline.form-lg label {
 font-size:1.25rem;
 -webkit-transform:translateY(10px);
 transform:translateY(10px)
}
.md-form.md-outline.form-lg label.active {
 font-size:1.1rem;
 -webkit-transform:translateY(-14px) scale(.8);
 transform:translateY(-14px) scale(.8)
}
.md-form.md-outline.form-lg .prefix {
 top:.65rem;
 font-size:25px
}
.md-form.md-outline.form-lg .prefix~input,
.md-form.md-outline.form-lg .prefix~textarea {
 width:calc(100% - 2.2rem);
 margin-left:2.2rem
}
.md-form.md-outline.form-lg .prefix~label {
 margin-left:2.2rem
}
.md-form.md-outline.form-lg .prefix~.form-text {
 margin-left:2.3rem
}
.md-form.md-outline.form-sm .form-control.form-control-sm {
 padding:.25rem .625rem
}
.md-form.md-outline.form-sm label {
 font-size:.8rem;
 -webkit-transform:translateY(8px);
 transform:translateY(8px)
}
.md-form.md-outline.form-sm label.active {
 font-size:.85rem;
 -webkit-transform:translateY(-12px) scale(.8);
 transform:translateY(-12px) scale(.8)
}
.md-form.md-outline.form-sm .prefix {
 top:.5rem;
 font-size:15px
}
.md-form.md-outline.form-sm .prefix~input,
.md-form.md-outline.form-sm .prefix~textarea {
 width:calc(100% - 1.6rem);
 margin-left:1.6rem
}
.md-form.md-outline.form-sm .prefix~label {
 margin-left:1.6rem
}
.md-form.md-outline.form-sm .prefix~.form-text {
 margin-left:1.7rem
}
.md-form.md-outline .prefix {
 position:absolute;
 top:.6rem;
 font-size:20px;
 -webkit-transition:color .2s;
 transition:color .2s
}
.md-form.md-outline .prefix:focus {
 color:#4285f4
}
.md-form.md-outline .prefix~input,
.md-form.md-outline .prefix~textarea {
 width:calc(100% - 2rem);
 margin-left:2rem
}
.md-form.md-outline .prefix~label {
 margin-left:2rem
}
.md-form.md-outline .prefix~.form-text {
 margin-left:2.1rem
}
.md-form.md-outline .character-counter {
 margin-top:-.5rem
}
.md-form.md-bg input[type=date],
.md-form.md-bg input[type=datetime-local],
.md-form.md-bg input[type=tel],
.md-form.md-bg input[type=number],
.md-form.md-bg input[type=search],
.md-form.md-bg input[type=search-md],
.md-form.md-bg input[type=text],
.md-form.md-bg input[type=password],
.md-form.md-bg input[type=email],
.md-form.md-bg input[type=url],
.md-form.md-bg input[type=time],
.md-form.md-bg textarea.md-textarea {
 -webkit-box-sizing:border-box;
 box-sizing:border-box;
 padding:10px 5px;
 background:50% 100% no-repeat,50% 100% no-repeat #f5f5f5;
 background-image:-webkit-gradient(linear,left top,left bottom,from(#4285f4),to(#4285f4)),-webkit-gradient(linear,left top,left bottom,from(#ced4da),to(#ced4da));
 background-image:linear-gradient(to bottom,#4285f4,#4285f4),linear-gradient(to bottom,#ced4da,#ced4da);
 background-size:0 2px,100% 1px;
 border:0;
 border-top-left-radius:.3rem;
 border-top-right-radius:.3rem;
 -webkit-transition:background-size .3s cubic-bezier(.64,.09,.08,1);
 transition:background-size .3s cubic-bezier(.64,.09,.08,1)
}
.md-form.md-bg input[type=date]:focus:not([readonly]),
.md-form.md-bg input[type=datetime-local]:focus:not([readonly]),
.md-form.md-bg input[type=tel]:focus:not([readonly]),
.md-form.md-bg input[type=number]:focus:not([readonly]),
.md-form.md-bg input[type=search]:focus:not([readonly]),
.md-form.md-bg input[type=search-md]:focus:not([readonly]),
.md-form.md-bg input[type=text]:focus:not([readonly]),
.md-form.md-bg input[type=password]:focus:not([readonly]),
.md-form.md-bg input[type=email]:focus:not([readonly]),
.md-form.md-bg input[type=url]:focus:not([readonly]),
.md-form.md-bg input[type=time]:focus:not([readonly]),
.md-form.md-bg textarea.md-textarea:focus:not([readonly]) {
 border-bottom:none;
 -webkit-box-shadow:none;
 box-shadow:none
}
.md-form.md-bg input[type=date]:focus,
.md-form.md-bg input[type=datetime-local]:focus,
.md-form.md-bg input[type=tel]:focus,
.md-form.md-bg input[type=number]:focus,
.md-form.md-bg input[type=search]:focus,
.md-form.md-bg input[type=search-md]:focus,
.md-form.md-bg input[type=text]:focus,
.md-form.md-bg input[type=password]:focus,
.md-form.md-bg input[type=email]:focus,
.md-form.md-bg input[type=url]:focus,
.md-form.md-bg input[type=time]:focus,
.md-form.md-bg textarea.md-textarea:focus {
 background-color:#dcdcdc;
 background-size:100% 2px,100% 1px;
 outline:0
}
.md-form.md-bg>input[type=date]:not(.browser-default)+label {
 -webkit-transform:translateY(-12px) scale(.8);
 transform:translateY(-12px) scale(.8);
 -webkit-transform-origin:0 0;
 transform-origin:0 0
}
.md-form.md-bg>input[type=time]:not(.browser-default)+label,
.md-form.md-bg>input[type]:-webkit-autofill:not(.browser-default):not([type=search])+label {
 font-size:.8rem;
 -webkit-transform:translateY(-12px);
 transform:translateY(-12px);
 -webkit-transform-origin:0 0;
 transform-origin:0 0
}
.md-form.md-bg .form-control {
 padding:1.1rem .7rem .4rem!important
}
.md-form.md-bg label {
 top:0;
 padding-left:.7rem;
 font-size:1rem;
 -webkit-transition:color .2s ease-out,-webkit-transform .2s ease-out;
 transition:color .2s ease-out,-webkit-transform .2s ease-out;
 transition:transform .2s ease-out,color .2s ease-out;
 transition:transform .2s ease-out,color .2s ease-out,-webkit-transform .2s ease-out;
 -webkit-transform:translateY(13px);
 transform:translateY(13px);
 -webkit-transform-origin:0 100%;
 transform-origin:0 100%
}
.md-form.md-bg label.active {
 padding-left:.75rem;
 font-weight:500;
 -webkit-transform:translateY(-3px) scale(.8);
 transform:translateY(-3px) scale(.8)
}
.md-form.md-bg.form-lg label {
 -webkit-transform:translateY(16px);
 transform:translateY(16px)
}
.md-form.md-bg.form-lg label.active {
 -webkit-transform:translateY(-4px) scale(.8);
 transform:translateY(-4px) scale(.8)
}
.md-form.md-bg.form-sm label {
 -webkit-transform:translateY(11px);
 transform:translateY(11px)
}
.md-form.md-bg.form-sm label.active {
 -webkit-transform:translateY(-2px) scale(.8);
 transform:translateY(-2px) scale(.8)
}
.dotted-scrollspy,
.md-form .input-prefix {
 top:50%;
 -webkit-transform:translateY(-50%)
}
.md-form .form-control.is-invalid,
.md-form .form-control.is-valid,
.was-validated .md-form .form-control:invalid,
.was-validated .md-form .form-control:valid {
 padding-right:0
}
.needs-validation .md-form label {
 left:.3rem
}
.custom-file-input:lang(es)~.custom-file-label::after {
 content:"Elegir"
}
.custom-file-input:lang(pl-pl)~.custom-file-label::after {
 content:"Wybierz"
}
.custom-file-input:lang(fr)~.custom-file-label::after {
 content:"Choisir"
}
.wrapper-page {
    margin: 7.5% auto;
    width: 50%;
    position: relative;
}
@media screen and (max-device-width: 480px) and (orientation: portrait){
.wrapper-page {
    margin: 7.5% auto;
    width: 100%;
    position: relative;
}

}	

</style>
</html>