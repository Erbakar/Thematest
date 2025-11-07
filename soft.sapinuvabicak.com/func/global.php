<?php

if (isset($_GET['karsilastir'])) {
	$karsilastirid = temizle($_GET['karsilastir']);
	$ip = ipadresi();
	$tarih   = date('d.m.Y H:i:s');

	$bak = $ozy->query("SELECT urunid FROM karsilastir WHERE urunid ='" . $karsilastirid . "' and gelenkim = '" . $sepetimdekikim . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
	if (count($bak) > 0) {

		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Bu ürün zaten karşılaştırma listenizde bulunuyor.", "Başarısız");});</script>';
	} else {


		$karsilastirmaekle = $ozy->prepare("INSERT INTO karsilastir (urunid, kim, tarih, gelenkim) 
VALUES (?,?,?,?)");
		$result2 = $karsilastirmaekle->execute(array($karsilastirid, $ip, $tarih, $sepetimdekikim));


		if ($result2) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Ürün karşılaştırma listenize kayıt edildi.", "Başarılı");});</script>';
			echo '<meta http-equiv="refresh" content="1; url=' . $url . '/anasayfa">';
		} else {


			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
		}
	}
}







if (isset($_GET['karsilastirmasil'])) {
	$karsil = temizle($_GET['karsilastirmasil']);
	$silx = $ozy->prepare("DELETE FROM karsilastir WHERE id=?");
	$silx->execute(array($karsil));
	header("Location: " . $url . "");
}

if (isset($_GET['tumunusil'])) {;
	$silxx = $ozy->prepare("DELETE FROM karsilastir WHERE kim=? and gelenkim=?");
	$silxx->execute(array($ip, $sepetimdekikim));
	header("Location: " . $url . "");
}

if (isset($_GET['favoriekle'])) {
	$favorid = temizle($_GET['favoriekle']);
	$ip = ipadresi();
	$tarih   = date('d.m.Y H:i:s');
	if (isset($_SESSION['uyegirisdurumu']) && $_SESSION['uyegirisdurumu'] === 'true') {

		$fbak = $ozy->query("SELECT urunid FROM favoriler WHERE urunid ='" . $favorid . "' and gelenkim = '" . $sepetimdekikim . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
		if (count($fbak) > 0) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Bu ürün zaten favorilerinizde bulunuyor.", "Başarısız");});</script>';
		} else {


			$favoriekle = $ozy->prepare("INSERT INTO favoriler (urunid, tarih, gelenkim) 
VALUES (?,?,?)");
			$result22 = $favoriekle->execute(array($favorid, $tarih, $sepetimdekikim));


			if ($result22) {

				echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Ürün favorilerinize kayıt edildi.", "Başarılı");});</script>';
				echo '<meta http-equiv="refresh" content="1; url=' . $url . '/favorilerim/">';
			} else {


				echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
			}
		}
	} else {

		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm ürünleri favorilerine eklemek için üye girişi yapmalısın..", "Başarısız");});</script>';
	}
}


if (isset($_GET['favorilsil'])) {
	$farsil = temizle($_GET['favorilsil']);
	$fsilx = $ozy->prepare("DELETE FROM favoriler WHERE id=?");
	$fsilx->execute(array($farsil));
	header("Location: " . $url . "");
}


if (isset($_POST['ebulten'])) {

	$eposta = temizle($_POST['eposta']);
	$ip = ipadresi();
	$tarih   = date('d.m.Y H:i:s');
	$ebultenekle = $ozy->prepare("INSERT INTO ebulten (eposta, ip, tarih) 
VALUES (?,?,?)");
	$ebultenok = $ebultenekle->execute(array($eposta, $ip, $tarih));


	if ($ebultenok) {

		echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Ebülten listemize kayıt edildiniz.", "Başarılı");});</script>';
		echo '<meta http-equiv="refresh" content="2; url=' . $url . '/anasayfa">';


		if ($system['ebultenonay'] == '1') {

			include("mail/PHPMailerAutoload.php");
			$mail = new PHPMailer;
			$mail->IsSMTP();
			//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
			$mail->Host = "$sunucu"; // Mail sunucusuna ismi
			$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
			$mail->IsHTML(true);
			$mail->SetLanguage("tr", "phpmailer/language");
			$mail->CharSet  = "utf-8";
			$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
			$mail->Password = "$esifre"; // Mail adresimizin sifresi
			$mail->SetFrom($mail->Username, '' . $siteadi . '');
			$mail->AddAddress($posta); // Maili gonderecegimiz kisi yani alici
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = "Yeni Ebülten Kaydı"; // Konu basligi
			$mail->Body = '
			
		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="' . $url . '"><img style="height: 30px;line-height: 1;width: 200px;margin: 80px;" class="top-image" src="' . $url . '/resimler/siteayarlari/' . $ayar['logo'] . '"  alt="' . $siteadi . '"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">
										Sitenizde yeni bir ebülten kaydı gerçekleşti.
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="' . $url . '/mail/webinar-no-text.png" width="560"/><br><br>
										<strong>Eposta Adresi :</strong> ' . $eposta . '<br>
			                            <strong>İP Adresi</strong>: ' . $ip . '<br><br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="' . $url . '/boss/">Hemen İncele</a>
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
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="' . $url . '/blog"><img src="' . $url . '/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['twitter'] . '"><img src="' . $url . '/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['facebook'] . '"><img src="' . $url . '/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['youtube'] . '"><img src="' . $url . '/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['instagram'] . '"><img width="20px" height="20px" src="' . $url . '/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['googleplus'] . '"><img src="' . $url . '/mail/google-teal.png"></a></td>

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
										<b>' . $ayar['siteadi'] . '</b><br>
                            ' . $ayar['adres'] . '<br>
							' . $ayar['tel'] . ' ' . $ayar['email'] . '<br>
                            <a style="color: #00a5b5;" href="' . $url . '/iletisim/">Bize Ulaşın</a>
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
			if (!$mail->Send()) {
			} else {
			}
		}


		if ($system['sebultenonay'] == '1') {
			$smesaj = 'Sayın yönetici, sitenizde yeni bir ebülten kaydı gerçekleşti. Eposta Adresi : ' . $eposta . ' . İyi günler dileriz.';
			$smesaj = html_entity_decode($smesaj, ENT_COMPAT, "UTF-8");
			$smesaj = rawurlencode($smesaj);
			$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8");
			$smsbaslik = rawurlencode($smsbaslik);
			sendsms($smesaj, $admintel, $smsbaslik);
		}
	} else {

		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
	}
}

if (isset($_POST['kayitol'])) {

	$isim = temizle($_POST['isim']);
	$email = temizle($_POST['email']);
	$telefon = temizle($_POST['telefon']);
	$sifre = temizle(md5($_POST['sifre']));
	$ip = ipadresi();
	$tarih   = date('d.m.Y H:i:s');
	$kod    = md5(rand(0, 9999999999));
	$nereden = temizle($_POST['nereden']);
	$sozlesme = temizle($_POST['sozlesme']);
	$ebultensor = temizle($_POST['ebultensor']);

	if ($ebultensor == '1') {
		$ebulteneklee = $ozy->prepare("INSERT INTO ebulten (eposta, ip, tarih) 
VALUES (?,?,?)");
		$ebultenokk = $ebulteneklee->execute(array($email, $ip, $tarih));
	}

	if (empty($sozlesme)) {
		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm sözleşmeyi kabul etmeden üye olamazsın.", "Başarısız");});</script>';
	} else {

		$emailkontrol = $ozy->prepare("SELECT * FROM users WHERE email=?");
		$emailkontrol->execute(array($email));
		if ($emailkontrol->rowCount()) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bu eposta hesabı ile daha önce kayıt oluşturulmuş.", "Başarısız");});</script>';
		} else {


			if ($system['uyeonay'] == '0') {

				$uyeekle = $ozy->prepare("INSERT INTO users (isim, email, telefon, sifre, ip, tarih, kod, sozlesme, onay) 
VALUES (?,?,?,?,?,?,?,?,?)");
				$uyeler = $uyeekle->execute(array($isim, $email, $telefon, $sifre, $ip, $tarih, $kod, $sozlesme, 1));


				if ($uyeler) {

					echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Sisteme başarıyla kayıt oldunuz. Sisteme giriş yapabilirsiniz.", "Başarılı");});</script>';
					session_destroy();
					ob_end_flush();
					if ($nereden == 'anauyelik') {
						echo '<meta http-equiv="refresh" content="1; url=' . $url . '/uyeol/">';
					}
					if ($nereden == 'kontrol') {
						echo '<meta http-equiv="refresh" content="1; url=' . $url . '/odeme/">';
					}
				} else {


					echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
				}
			} elseif ($system['uyeonay'] == '1') {


				$uyeekle = $ozy->prepare("INSERT INTO users (isim, email, telefon, sifre, ip, tarih, kod, sozlesme, onay) 
VALUES (?,?,?,?,?,?,?,?,?)");
				$uyeler = $uyeekle->execute(array($isim, $email, $telefon, $sifre, $ip, $tarih, $kod, $sozlesme, 0));


				if ($uyeler) {

					echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Sisteme başarıyla kayıt oldunuz. Yönetici onayından sonra üyeliğiniz aktif olacaktır.", "Başarılı");});</script>';
					if ($nereden == 'anauyelik') {
						echo '<meta http-equiv="refresh" content="1; url=' . $url . '/anasayfa">';
					}
					if ($nereden == 'kontrol') {
						echo '<meta http-equiv="refresh" content="1; url=' . $url . '/odeme/">';
					}
				} else {


					echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
				}
			} elseif ($system['uyeonay'] == '2') {

				////SMS İLE ONAY KISMI

				$uyeekle = $ozy->prepare("INSERT INTO users (isim, email, telefon, sifre, ip, tarih, kod, sozlesme, onay) 
VALUES (?,?,?,?,?,?,?,?,?)");
				$uyeler = $uyeekle->execute(array($isim, $email, $telefon, $sifre, $ip, $tarih, $kod, $sozlesme, 0));


				if ($uyeler) {

					echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Sisteme başarıyla kayıt oldunuz. Telefonunuze gelen onay linkinden  sonra üyeliğiniz aktif olacaktır.", "Başarılı");});</script>';
				} else {


					echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
				}



				$smesaj = 'Sayın ' . $isim . ', Aktivasyon linkine tıklayarak üyeliğinizi aktif edebilirsiniz. Aktivasyon Linki : ' . $url . '/onay?email=' . $email . '&kod=' . $kod . ' ' . $ayar['siteadi'] . '';
				$smesaj = html_entity_decode($smesaj, ENT_COMPAT, "UTF-8");
				$smesaj = rawurlencode($smesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8");
				$smsbaslik = rawurlencode($smsbaslik);
				sendsms($smesaj, $telefon, $smsbaslik);
			} else {


				$uyeekle = $ozy->prepare("INSERT INTO users (isim, email, telefon, sifre, ip, tarih, kod, sozlesme, onay) 
VALUES (?,?,?,?,?,?,?,?,?)");
				$uyeler = $uyeekle->execute(array($isim, $email, $telefon, $sifre, $ip, $tarih, $kod, $sozlesme, 0));


				if ($uyeler) {

					echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Sisteme başarıyla kayıt oldunuz. Epostanıza gelen onay linkinden  sonra üyeliğiniz aktif olacaktır.", "Başarılı");});</script>';
				} else {


					echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
				}



				include("mail/PHPMailerAutoload.php");
				$mail = new PHPMailer;
				$mail->IsSMTP();
				//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
				$mail->Host = "$sunucu"; // Mail sunucusuna ismi
				$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
				$mail->IsHTML(true);
				$mail->SetLanguage("tr", "phpmailer/language");
				$mail->CharSet  = "utf-8";
				$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
				$mail->Password = "$esifre"; // Mail adresimizin sifresi
				$mail->SetFrom($mail->Username, '' . $siteadi . '');
				$mail->AddAddress($email); // Maili gonderecegimiz kisi yani alici
				$mail->addReplyTo($posta, $siteadi);
				$mail->Subject = "Üyelik Aktivasyonu"; // Konu basligi
				$mail->Body = '
			
		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="' . $url . '"><img style="height: 30px;line-height: 1;width: 200px;margin: 80px;" class="top-image" src="' . $url . '/resimler/siteayarlari/' . $ayar['logo'] . '"  alt="' . $siteadi . '"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">
										Üyelik Aktivasyonu
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="' . $url . '/mail/webinar-no-text.png" width="560"/><br><br>
										<strong>Sayın :</strong> ' . $isim . '<br>
										Aşağıda bulunan linke tıklayarak üyeliğini lütfen aktif ediniz.
			                            <strong>İP Adresi</strong>: ' . $ip . '<br><br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="' . $url . '/onay?email=' . $email . '&kod=' . $kod . '">Üyeliğimi Onayla</a>
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
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="' . $url . '/blog"><img src="' . $url . '/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['twitter'] . '"><img src="' . $url . '/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['facebook'] . '"><img src="' . $url . '/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['youtube'] . '"><img src="' . $url . '/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['instagram'] . '"><img width="20px" height="20px" src="' . $url . '/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['googleplus'] . '"><img src="' . $url . '/mail/google-teal.png"></a></td>

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
										<b>' . $ayar['siteadi'] . '</b><br>
                            ' . $ayar['adres'] . '<br>
							' . $ayar['tel'] . ' ' . $ayar['email'] . '<br>
                            <a style="color: #00a5b5;" href="' . $url . '/iletisim/">Bize Ulaşın</a>
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
				if (!$mail->Send()) {
				} else {
				}
			}
		}
	}
}



if (isset($_POST['girisyap'])) {

	$email   = temizle($_POST['email']);
	$sifre   = temizle(md5($_POST['sifre']));
	$nereden = temizle($_POST['nereden']);
	$uyegiris = $ozy->prepare("select * from users where email=? and sifre=?");
	$uyegiris->execute(array($email, $sifre));
	$kontrol = $uyegiris->rowCount();
	$parcalax = $ozy->query("select * from users where email='{$email}' and sifre='{$sifre}'")->fetch(PDO::FETCH_ASSOC);
	if ($parcalax['onay'] == '0') {
		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üyeliğiniz onay sürecindedir.", "Başarısız");});</script>';
	} else {


		if ($kontrol) {
			$_SESSION["uyegirisdurumu"] = "true";
			$_SESSION['uyeid'] = $parcalax['id'];
			$_SESSION['isim'] = $parcalax['isim'];
			$_SESSION['email'] = $parcalax['email'];
			$_SESSION['sifre'] = $parcalax['sifre'];
			$_SESSION['telefon'] = $parcalax['telefon'];
			$_SESSION['ip'] = $parcalax['ip'];

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Sisteme başarıyla giriş yaptınız.", "Başarılı");});</script>';
			if ($nereden == 'anauyelik') {
				echo '<meta http-equiv="refresh" content="1; url=' . $url . '/hesabim/">';
			}
			if ($nereden == 'kontrol') {

				$sepbak = $ozy->query("SELECT gelenkim FROM sepet WHERE gelenkim ='" . $parcala['id'] . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
				if (count($sepbak) > 0) {
					echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Sepetinizde üyeliğinize ait ürünler bulunmaktadır. Sepete yönlendiriliyorsunuz.", "Başarılı");});</script>';
					echo '<meta http-equiv="refresh" content="3; url=' . $url . '/sepet/">';
				} else {
					echo '<meta http-equiv="refresh" content="1; url=' . $url . '/odeme/">';
				}
			}
		} else {
			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Epostanız veya şifreniz hatalı.", "Başarısız");});</script>';
			if ($nereden == 'anauyelik') {
				echo '<meta http-equiv="refresh" content="1; url=' . $url . '/uyeol/">';
			}
			if ($nereden == 'kontrol') {

				$sepbak = $ozy->query("SELECT gelenkim FROM sepet WHERE gelenkim ='" . $parcala['id'] . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
				if (count($sepbak) > 0) {
					echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Sepetinizde üyeliğinize ait ürünler bulunmaktadır. Sepete yönlendiriliyorsunuz.", "Başarılı");});</script>';
					echo '<meta http-equiv="refresh" content="1; url=' . $url . '/sepet/">';
				} else {
					echo '<meta http-equiv="refresh" content="1; url=' . $url . '/odeme/">';
				}
			}
		}
	}
}



if (isset($_POST['blogyorum'])) {

	$adi = temizle($_POST['adi']);
	$email = temizle($_POST['email']);
	$yorum = temizle($_POST['yorum']);
	$sayfaid = temizle($_POST['sayfaid']);
	$ip = ipadresi();
	$tarih   = date('d.m.Y H:i:s');
	$konu    = "blog";
	$durum = "0";
	$cevap = "";
	$uye = $_SESSION['uyeid'];
	$blogbak = $ozy->query("select * from haberler where id='$sayfaid'")->fetch(PDO::FETCH_ASSOC);

	if ($system['yorumgoster'] == '0') {

		$yorumekle = $ozy->prepare("INSERT INTO tumyorumlar (adi, email, yorum, ip, tarih, konu, durum, cevap, sayfaid) 
VALUES (?,?,?,?,?,?,?,?,?)");
		$blogyorum = $yorumekle->execute(array($adi, $email, $yorum, $ip, $tarih, $konu, 0, $cevap, $sayfaid));


		if ($blogyorum) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Yorumunuz başarıyla iletildi. Onaylandıktan sonra sitede görünecektir.", "Başarılı");});</script>';
		} else {


			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
		}
	} else {

		if ($_SESSION['uyegirisdurumu'] == 'true') {


			$yorumekle = $ozy->prepare("INSERT INTO tumyorumlar (adi, email, yorum, ip, tarih, konu, durum, cevap, uye, sayfaid) 
VALUES (?,?,?,?,?,?,?,?,?,?)");
			$blogyorum = $yorumekle->execute(array($adi, $email, $yorum, $ip, $tarih, $konu, 0, $cevap, $uye, $sayfaid));


			if ($blogyorum) {

				echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Yorumunuz başarıyla iletildi. Onaylandıktan sonra sitede görünecektir.", "Başarılı");});</script>';
			} else {


				echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
			}
		} else {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Malesef bu yazıya yorum bırakabilmek için sisteme üye olmalısınız.", "Başarısız");});</script>';
		}
	}

	if ($system['sblogonay'] == '1') {
		$smesaj = 'Sayın yönetici,Sitenizdeki Blog Linki : ' . $url . '/blog/' . $blogbak['seo'] . ' ' . $blogbak['adi'] . ' isimli yazıya yorum geldi.';
		$smesaj = html_entity_decode($smesaj, ENT_COMPAT, "UTF-8");
		$smesaj = rawurlencode($smesaj);
		$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8");
		$smsbaslik = rawurlencode($smsbaslik);
		sendsms($smesaj, $admintel, $smsbaslik);
	}

	if ($system['blogonay'] == '1') {



		include("mail/PHPMailerAutoload.php");
		$mail = new PHPMailer;
		$mail->IsSMTP();
		//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
		$mail->Host = "$sunucu"; // Mail sunucusuna ismi
		$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
		$mail->IsHTML(true);
		$mail->SetLanguage("tr", "phpmailer/language");
		$mail->CharSet  = "utf-8";
		$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
		$mail->Password = "$esifre"; // Mail adresimizin sifresi
		$mail->SetFrom($mail->Username, '' . $siteadi . '');
		$mail->AddAddress($posta); // Maili gonderecegimiz kisi yani alici
		$mail->addReplyTo($posta, $siteadi);
		$mail->Subject = "Blog Yorumu"; // Konu basligi
		$mail->Body = '
			
		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="' . $url . '"><img style="height: 30px;line-height: 1;width: 200px;margin: 80px;" class="top-image" src="' . $url . '/resimler/siteayarlari/' . $ayar['logo'] . '"  alt="' . $siteadi . '"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">
										Sitenizdeki <a href="' . $url . '/blog/' . $blogbak['seo'] . '" target="_blank"> ' . $blogbak['adi'] . ' </a> isimli yazıya yorum geldi.
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="' . $url . '/mail/webinar-no-text.png" width="560"/><br><br>
										<strong>Gönderen Kişi :</strong> ' . $adi . '<br>
										<strong>Eposta Adresi :</strong> ' . $email . '<br>
										<strong>Yorum Başlığı :</strong> ' . $konu . '<br>
										<strong>Gelen Yorum :</strong> ' . $yorum . '<br>
			                            <strong>İP Adresi</strong>: ' . $ip . '<br><br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="' . $url . '/boss/">Hemen İncele</a>
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
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="' . $url . '/blog"><img src="' . $url . '/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['twitter'] . '"><img src="' . $url . '/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['facebook'] . '"><img src="' . $url . '/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['youtube'] . '"><img src="' . $url . '/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['instagram'] . '"><img width="20px" height="20px" src="' . $url . '/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['googleplus'] . '"><img src="' . $url . '/mail/google-teal.png"></a></td>

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
										<b>' . $ayar['siteadi'] . '</b><br>
                            ' . $ayar['adres'] . '<br>
							' . $ayar['tel'] . ' ' . $ayar['email'] . '<br>
                            <a style="color: #00a5b5;" href="' . $url . '/iletisim/">Bize Ulaşın</a>
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
		if (!$mail->Send()) {
		} else {
		}
	}
}


if (isset($_POST['mesajgonder'])) {

	$isim = temizle($_POST['isim']);
	$eposta = temizle($_POST['eposta']);
	$konu = temizle($_POST['konu']);
	$mesaj = temizle($_POST['mesaj']);
	$telefon = temizle($_POST['telefon']);
	$ip = ipadresi();
	$tarih   = date('d.m.Y H:i:s');



	if ($_POST['captcha'] != $_SESSION['captcha']) {
		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Girdiğiniz güvenlik kodu hatalı lütfen kontrol ediniz.", "Başarısız");});</script>';
		echo '<meta http-equiv="refresh" content="2; url=' . $url . '/iletisim/">';
	} else {


		$iletisimekle = $ozy->prepare("INSERT INTO iletisim (isim, eposta, konu, mesaj, telefon, ip, tarih,durum) 
VALUES (?,?,?,?,?,?,?,?)");
		$iletisimok = $iletisimekle->execute(array($isim, $eposta, $konu, $mesaj, $telefon, $ip, $tarih, 0));


		if ($iletisimok) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Gönderdiğiniz mesaj bize başarıyla ulaştı.", "Başarılı");});</script>';
			echo '<meta http-equiv="refresh" content="4; url=' . $url . '/anasayfa">';

			if ($system['siletisimonay'] == '1') {
				$smesaj = 'Sayın yönetici, iletişim formundan ' . $isim . ' adlı kişi ' . $mesaj . ' gönderdi.';
				$smesaj = html_entity_decode($smesaj, ENT_COMPAT, "UTF-8");
				$smesaj = rawurlencode($smesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8");
				$smsbaslik = rawurlencode($smsbaslik);
				sendsms($smesaj, $admintel, $smsbaslik);
			}
			if ($system['iletisimonay'] == '1') {

				include("mail/PHPMailerAutoload.php");
				$mail = new PHPMailer;
				$mail->IsSMTP();
				//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
				$mail->Host = "$sunucu"; // Mail sunucusuna ismi
				$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
				$mail->IsHTML(true);
				$mail->SetLanguage("tr", "phpmailer/language");
				$mail->CharSet  = "utf-8";
				$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
				$mail->Password = "$esifre"; // Mail adresimizin sifresi
				$mail->SetFrom($mail->Username, '' . $siteadi . '');
				$mail->AddAddress($posta); // Maili gonderecegimiz kisi yani alici
				$mail->addReplyTo($posta, $siteadi);
				$mail->Subject = "Yeni İletişim Mesajı"; // Konu basligi
				$mail->Body = '
			
		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="' . $url . '"><img style="height: 30px;line-height: 1;width: 200px;margin: 80px;" class="top-image" src="' . $url . '/resimler/siteayarlari/' . $ayar['logo'] . '"  alt="' . $siteadi . '"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">
										Sitenizde yeni bir iletişim mesajı iletildi.
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="' . $url . '/mail/webinar-no-text.png" width="560"/><br><br>
										<strong>Adı Soyadı :</strong> ' . $isim . '<br>
										<strong>Eposta Adresi :</strong> ' . $eposta . '<br>
										<strong>Telefon Numarası :</strong> ' . $telefon . '<br>
										<strong>Bırakılan Mesaj:</strong> ' . $mesaj . '<br>
			                            <strong>İP Adresi</strong>: ' . $ip . '<br><br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="' . $url . '/boss/">Hemen İncele</a>
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
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="' . $url . '/blog"><img src="' . $url . '/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['twitter'] . '"><img src="' . $url . '/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['facebook'] . '"><img src="' . $url . '/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['youtube'] . '"><img src="' . $url . '/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['instagram'] . '"><img width="20px" height="20px" src="' . $url . '/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['googleplus'] . '"><img src="' . $url . '/mail/google-teal.png"></a></td>

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
										<b>' . $ayar['siteadi'] . '</b><br>
                            ' . $ayar['adres'] . '<br>
							' . $ayar['tel'] . ' ' . $ayar['email'] . '<br>
                            <a style="color: #00a5b5;" href="' . $url . '/iletisim/">Bize Ulaşın</a>
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
				if (!$mail->Send()) {
				} else {
				}
			}
		} else {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
		}
	}
}









if (isset($_POST['sepetle'])) {
	$urunid  = temizle($_POST['urunid']);
	$ip = ipadresi();
	$tarih   = date('d.m.Y H:i:s');
	$sepeturunid = $ozy->query("select * from urunler where id='$urunid'")->fetch(PDO::FETCH_ASSOC);
	if ($sepeturunid['ucretsizkargo'] == '1') {
		$kargom = "1";
	} else {
		$kargom = "0";
	}
	if ($sepeturunid['alode'] == '1' and $_POST['adet'] >= $sepeturunid['al']) {
		$sonadet = temizle($_POST['adet']);
		$alodedurum = "1";
		$yeniadet  = ($sonadet / $sepeturunid['al']);
		$adet = ceil($yeniadet * $sepeturunid['ode']);
		$alodedurum = "1";
		$kazanc = $sonadet - $adet;
		$alodemetin = "" . $kazanc . " ADET ÜRÜN HEDİYE";
		$alodeadet = $kazanc;
	} else {
		$adet  = temizle($_POST['adet']);
		$alodedurum = "0";
		$alodemetin = "";
		$alodeadet = "";
	}

	$stok = $sepeturunid['stok'];

	if ($system['sinirsizstok'] != '1') {
		if ($adet > $stok) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("' . $sepeturunid['adi'] . ' isimli üründen en fazla ' . $stok . ' adet alabilirsiniz.", "Başarısız");});</script>';
		} else {

			if (isset($_POST['ozellik'])) {

				$ekozellik = temizle($_POST['ozellik']);
				$in_values = implode(',', $ekozellik);
				$my_result = $ozy->prepare("SELECT * FROM anaozellikalt WHERE FIND_IN_SET(id, :in_values) order by id desc");
				$my_result->execute(array(':in_values' => $in_values));
				$my_results = $my_result->fetchAll();
				foreach ($my_results as $urunekozellik) {
					if ($sepeturunid['kdv'] > '0') {
						$ekfiyat += KdvDahil($urunekozellik['fiyat'], $sepeturunid['kdv']);
					} else {
						$ekfiyat += $urunekozellik['fiyat'];
					}



					$ekurun .= "" . $urunekozellik['ustadi'] . " : " . $urunekozellik['adi'] . "</br>";
					if ($adet > $urunekozellik['stok']) {
						echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("' . $urunekozellik['adi'] . ' isimli ek özellikten en fazla ' . $urunekozellik['stok'] . ' adet alabilirsiniz.</br>", "Başarısız");});</script>';

						echo exit;
					}
				}
			} else {
				$ekfiyat = "0";
				$ekurun = "";
			}
			if ($sepeturunid['idurum'] == '1') {
				if ($sepeturunid['kdv'] > '0') {
					$kdvlifiyat1 = KdvDahil($sepeturunid['ifiyat'], $sepeturunid['kdv']);
					$kdvlifiyat = $kdvlifiyat1 + $ekfiyat;
				} else {
					$kdvlifiyat1 = $sepeturunid['ifiyat'];
					$kdvlifiyat = $kdvlifiyat1 + $ekfiyat;
				}
			} else {

				if ($sepeturunid['kdv'] > '0') {
					$kdvlifiyat1 = KdvDahil($sepeturunid['fiyat'], $sepeturunid['kdv']);
					$kdvlifiyat = $kdvlifiyat1 + $ekfiyat;
				} else {
					$kdvlifiyat1 = $sepeturunid['fiyat'];
					$kdvlifiyat = $kdvlifiyat1 + $ekfiyat;
				}
			}

			if ($sepeturunid['kdv'] > '0') {
				$oran = $sepeturunid['kdv'];
				$kdvsizfiyat = KdvHaric($kdvlifiyat, $sepeturunid['kdv']);
				$kdvm = $kdvlifiyat - $kdvsizfiyat;
			} else {
				$oran = '0';
				$kdvsizfiyat = $kdvlifiyat;
				$kdvm = '0.00';
			}
			if ($sepeturunid['havaledurum'] == '1') {
				$havalefiyati =	$kdvlifiyat - KdvDahil($sepeturunid['hfiyat'], $oran);
				$havaleindirim = $adet * $havalefiyati;
			} else {
				$havaleindirim = "0.00";
			}

			$sepetekle = $ozy->prepare("INSERT INTO sepet (urunid, adet, kdvsizfiyat, fiyat, kdv, oran, kargo, kim, tarih, gelenkim, efiyat, ekurun, alodedurum, alodemetin, havaleindirim, alodeadet) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$sepetledim = $sepetekle->execute(array($urunid, $adet, $kdvsizfiyat, $kdvlifiyat, $kdvm, $oran, $kargom, $ip, $tarih, $sepetimdekikim, $ekfiyat, $ekurun, $alodedurum, $alodemetin, $havaleindirim, $alodeadet));
			$newid = $ozy->lastInsertId();



			if (isset($_POST['ozellik'])) {

				$ekozellik = temizle($_POST['ozellik']);
				foreach ($ekozellik as $newozel) {
					$newozelx .= "" . $newozel . ",";
					$aadet .= "" . $adet . ",";
				}
				$newozelx =  mb_substr($newozelx, 0, -1);
				$sonaadet .= mb_substr($aadet, 0, -1);
				$fstmt = $ozy->prepare("update sepet set ekozellikid=?, ekozellikadet=? where id=?");
				$fstmt->execute(array($newozelx, $sonaadet, $newid));
			}


			if ($sepetledim) {

				echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("' . $sepeturunid['adi'] . ' isimli ürün sepete başarıyla eklendi.", "Başarılı");});</script>';
				echo '<meta http-equiv="refresh" content="1; url=' . $url . '/urun/' . $sepeturunid['seo'] . '">';
			} else {


				echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
			}
		}
	} else {





		if (isset($_POST['ozellik'])) {

			$ekozellik = temizle($_POST['ozellik']);
			$in_values = implode(',', $ekozellik);
			$my_result = $ozy->prepare("SELECT * FROM anaozellikalt WHERE FIND_IN_SET(id, :in_values) order by id desc");
			$my_result->execute(array(':in_values' => $in_values));
			$my_results = $my_result->fetchAll();
			foreach ($my_results as $urunekozellik) {
				if ($sepeturunid['kdv'] > '0') {
					$ekfiyat += KdvDahil($urunekozellik['fiyat'], $sepeturunid['kdv']);
				} else {
					$ekfiyat += $urunekozellik['fiyat'];
				}
				$ekurun .= "" . $urunekozellik['ustadi'] . " : " . $urunekozellik['adi'] . "</br>";
			}
		} else {
			$ekfiyat = "0";
			$ekurun = "";
		}
		if ($sepeturunid['idurum'] == '1') {
			if ($sepeturunid['kdv'] > '0') {
				$kdvlifiyat1 = KdvDahil($sepeturunid['ifiyat'], $sepeturunid['kdv']);
				$kdvlifiyat = $kdvlifiyat1 + $ekfiyat;
			} else {
				$kdvlifiyat1 = $sepeturunid['ifiyat'];
				$kdvlifiyat = $kdvlifiyat1 + $ekfiyat;
			}
		} else {

			if ($sepeturunid['kdv'] > '0') {
				$kdvlifiyat1 = KdvDahil($sepeturunid['fiyat'], $sepeturunid['kdv']);
				$kdvlifiyat = $kdvlifiyat1 + $ekfiyat;
			} else {
				$kdvlifiyat1 = $sepeturunid['fiyat'];
				$kdvlifiyat = $kdvlifiyat1 + $ekfiyat;
			}
		}

		if ($sepeturunid['kdv'] > '0') {
			$oran = $sepeturunid['kdv'];
			$kdvsizfiyat = KdvHaric($kdvlifiyat, $sepeturunid['kdv']);
			$kdvm = $kdvlifiyat - $kdvsizfiyat;
		} else {
			$oran = '0';
			$kdvsizfiyat = $kdvlifiyat;
			$kdvm = '0.00';
		}

		if ($sepeturunid['havaledurum'] == '1') {
			$havalefiyati =	$kdvlifiyat - KdvDahil($sepeturunid['hfiyat'], $oran);
			$havaleindirim = $adet * $havalefiyati;
		} else {
			$havaleindirim = "0.00";
		}

		$sepetekle = $ozy->prepare("INSERT INTO sepet (urunid, adet, kdvsizfiyat, fiyat, kdv, oran, kargo, kim, tarih, gelenkim, efiyat, ekurun, alodedurum, alodemetin, havaleindirim, alodeadet) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$sepetledim = $sepetekle->execute(array($urunid, $adet, $kdvsizfiyat, $kdvlifiyat, $kdvm, $oran, $kargom, $ip, $tarih, $sepetimdekikim, $ekfiyat, $ekurun, $alodedurum, $alodemetin, $havaleindirim, $alodeadet));
		$newid = $ozy->lastInsertId();

		if (isset($_POST['ozellik'])) {

			$ekozellik = temizle($_POST['ozellik']);
			foreach ($ekozellik as $newozel) {
				$newozelx .= "" . $newozel . ",";
				$aadet .= "" . $adet . ",";
			}
			$newozelx =  mb_substr($newozelx, 0, -1);
			$sonaadet .= mb_substr($aadet, 0, -1);
			$fstmt = $ozy->prepare("update sepet set ekozellikid=?, ekozellikadet=? where id=?");
			$fstmt->execute(array($newozelx, $sonaadet, $newid));
		}



		if ($sepetledim) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("' . $sepeturunid['adi'] . ' isimli ürün sepete başarıyla eklendi.", "Başarılı");});</script>';
			echo '<meta http-equiv="refresh" content="1; url=' . $url . '/urun/' . $sepeturunid['seo'] . '">';
		} else {


			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
		}
	}
}








if (isset($_POST['urunyorum'])) {

	$adi = temizle($_POST['adi']);
	$email = temizle($_POST['email']);
	$yorum = temizle($_POST['yorum']);
	$sayfaid = temizle($_POST['sayfaid']);
	$yildiz = temizle($_POST['yildiz']);
	$ip = ipadresi();
	$tarih   = date('d.m.Y H:i:s');
	$konu    = "urunler";
	$durum = "0";
	$cevap = "";
	$uye = $_SESSION['uyeid'];
	$blogbak = $ozy->query("select * from urunler where id='$sayfaid'")->fetch(PDO::FETCH_ASSOC);

	if ($system['urungoster'] == '0') {

		$yorumekle = $ozy->prepare("INSERT INTO tumyorumlar (adi, email, yorum, ip, tarih, konu, durum, cevap, sayfaid, yildiz) 
VALUES (?,?,?,?,?,?,?,?,?,?)");
		$blogyorum = $yorumekle->execute(array($adi, $email, $yorum, $ip, $tarih, $konu, 0, $cevap, $sayfaid, $yildiz));


		if ($blogyorum) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Yorumunuz başarıyla iletildi. Onaylandıktan sonra sitede görünecektir.", "Başarılı");});</script>';
		} else {


			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
		}
	} else {

		if ($_SESSION['uyegirisdurumu'] == 'true') {


			$yorumekle = $ozy->prepare("INSERT INTO tumyorumlar (adi, email, yorum, ip, tarih, konu, durum, cevap, uye, sayfaid, yildiz) 
VALUES (?,?,?,?,?,?,?,?,?,?,?)");
			$blogyorum = $yorumekle->execute(array($adi, $email, $yorum, $ip, $tarih, $konu, 0, $cevap, $uye, $sayfaid, $yildiz));


			if ($blogyorum) {

				echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Yorumunuz başarıyla iletildi. Onaylandıktan sonra sitede görünecektir.", "Başarılı");});</script>';
			} else {


				echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
			}
		} else {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Malesef bu ürüne yorum bırakabilmek için sisteme üye olmalısınız.", "Başarısız");});</script>';
		}
	}

	if ($system['surunonay'] == '1') {
		$smesaj = 'Sayın yönetici, 	Sitenizdeki  Ürün Linki : ' . $url . '/urun/' . $blogbak['seo'] . ' ' . $blogbak['adi'] . ' isimli ürüne yorum geldi.';
		$smesaj = html_entity_decode($smesaj, ENT_COMPAT, "UTF-8");
		$smesaj = rawurlencode($smesaj);
		$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8");
		$smsbaslik = rawurlencode($smsbaslik);
		sendsms($smesaj, $admintel, $smsbaslik);
	}

	if ($system['urunonay'] == '1') {



		include("mail/PHPMailerAutoload.php");
		$mail = new PHPMailer;
		$mail->IsSMTP();
		//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
		$mail->Host = "$sunucu"; // Mail sunucusuna ismi
		$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
		$mail->IsHTML(true);
		$mail->SetLanguage("tr", "phpmailer/language");
		$mail->CharSet  = "utf-8";
		$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
		$mail->Password = "$esifre"; // Mail adresimizin sifresi
		$mail->SetFrom($mail->Username, '' . $siteadi . '');
		$mail->AddAddress($posta); // Maili gonderecegimiz kisi yani alici
		$mail->addReplyTo($posta, $siteadi);
		$mail->Subject = "Ürün Yorumu"; // Konu basligi
		$mail->Body = '
			
		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="' . $url . '"><img style="height: 30px;line-height: 1;width: 200px;margin: 80px;" class="top-image" src="' . $url . '/resimler/siteayarlari/' . $ayar['logo'] . '"  alt="' . $siteadi . '"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">
										Sitenizdeki <a href="' . $url . '/urun/' . $blogbak['seo'] . '" target="_blank"> ' . $blogbak['adi'] . ' </a> isimli ürüne yorum geldi.
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="' . $url . '/mail/webinar-no-text.png" width="560"/><br><br>
										<strong>Gönderen Kişi :</strong> ' . $adi . '<br>
										<strong>Eposta Adresi :</strong> ' . $email . '<br>
										<strong>Yorum Başlığı :</strong> ' . $konu . '<br>
										<strong>Yıldız Sayısı :</strong> ' . $yildiz . '<br>
										<strong>Gelen Yorum :</strong> ' . $yorum . '<br>
			                            <strong>İP Adresi</strong>: ' . $ip . '<br><br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="' . $url . '/boss/">Hemen İncele</a>
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
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="' . $url . '/blog"><img src="' . $url . '/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['twitter'] . '"><img src="' . $url . '/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['facebook'] . '"><img src="' . $url . '/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['youtube'] . '"><img src="' . $url . '/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['instagram'] . '"><img width="20px" height="20px" src="' . $url . '/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['googleplus'] . '"><img src="' . $url . '/mail/google-teal.png"></a></td>

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
										<b>' . $ayar['siteadi'] . '</b><br>
                            ' . $ayar['adres'] . '<br>
							' . $ayar['tel'] . ' ' . $ayar['email'] . '<br>
                            <a style="color: #00a5b5;" href="' . $url . '/iletisim/">Bize Ulaşın</a>
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
		if (!$mail->Send()) {
		} else {
		}
	}
}
















if (isset($_POST['kuponguncelle'])) {
	$kuponadi  = temizle($_POST['kuponadi']);
	$sekli = "0";
	$kuponkontrol = $ozy->prepare("SELECT * FROM kuponlar WHERE durum='1' and adi=? and sekil=?");
	$kuponkontrol->execute(array($kuponadi, $sekli));
	if ($kuponkontrol->rowCount()) {
		$rows = $kuponkontrol->fetch(PDO::FETCH_ASSOC);
		if ($rows['stok'] <= '0') {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Malesef kupon limiti dolmuştur.", "Başarısız");});</script>';
		} else {


			if ($sepetbedeli >= $rows['slimit']) {
				$yeni = $rows['oran'];
				$kid = $rows['id'];
				$sekil = $rows['tip'];
				if ($sekil == '1') {
					$ksyeni = $sepetbedeli * $yeni;
					$syeni = $ksyeni / 100;
					$sonuccc = $ozy->exec("UPDATE sepet SET  cekid='0',cektutar='0.00',kupontutar='$syeni',kuponid='$kid' WHERE gelenkim='$sepetimdekikim' order by id asc limit 1");

					echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Kupon başarıyla uygulandı.", "Başarılı");});</script>';
					echo '<meta http-equiv="refresh" content="0; url=' . $url . '/sepet/">';
				} else {
					$sonuccc = $ozy->exec("UPDATE sepet SET cekid='0',cektutar='0.00',kupontutar='$yeni',kuponid='$kid' WHERE gelenkim='$sepetimdekikim' order by id asc limit 1");
					echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Kupon başarıyla uygulandı.", "Başarılı");});</script>';
					echo '<meta http-equiv="refresh" content="0; url=' . $url . '/sepet/">';
				}
			} else {


				echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Kuponu kullanabilmek için sepet tutarınız en az ' . $rows['slimit'] . ' TL olmalıdır.", "Başarısız");});</script>';
			}
		}
	} else {
		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Kupon Kodu Geçersiz veya Süresi Bitmiş.", "Başarısız");});</script>';
	}
}






if (isset($_GET['kuponsil'])) {;
	$sonuccc = $ozy->exec("UPDATE sepet SET kupontutar='0.00',kuponid='0' WHERE gelenkim='$sepetimdekikim'");
	echo '<meta http-equiv="refresh" content="0; url=' . $url . '/sepet/">';
}





if (isset($_POST['sepetguncelle'])) {

	$urunid  = temizle($_POST['urunid']);
	$adet  = temizle($_POST['adet']);
	$sepetid  = temizle($_POST['sepetid']);
	$sepeturunid = $ozy->query("select * from urunler where id='$urunid'")->fetch(PDO::FETCH_ASSOC);
	if ($sepeturunid['alode'] == '1' and $_POST['adet'] >= $sepeturunid['al']) {
		$sonadet = temizle($_POST['adet']);
		$alodedurum = "1";
		$yeniadet  = ($sonadet / $sepeturunid['al']);
		$adet = ceil($yeniadet * $sepeturunid['ode']);
		$alodedurum = "1";
		$kazanc = $sonadet - $adet;
		$alodemetin = "" . $kazanc . " ADET ÜRÜN HEDİYE";
		$alodeadet = $kazanc;
	} else {
		$adet  = temizle($_POST['adet']);
		$alodedurum = "0";
		$alodemetin = "";
		$alodeadet = "";
	}

	$stok = $sepeturunid['stok'];

	if ($system['sinirsizstok'] != '1') {
		if ($adet > $stok) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("' . $sepeturunid['adi'] . ' isimli üründen en fazla ' . $stok . ' adet alabilirsiniz.", "Başarısız");});</script>';
		} else {


			$sepguncelle = $ozy->prepare("update sepet set adet=?, alodedurum=?, alodemetin=?, alodeadet=? where id=?");
			$sepguncelle->execute(array($adet, $alodedurum, $alodemetin, $alodeadet, $sepetid));


			if ($sepguncelle) {

				header("Location: ");
			}
		}
	} else {


		$sepguncelle = $ozy->prepare("update sepet set adet=?, alodedurum=?, alodemetin=?, alodeadet=? where id=?");
		$sepguncelle->execute(array($adet, $alodedurum, $alodemetin, $alodeadet, $sepetid));


		if ($sepguncelle) {

			header("Location: ");
		}
	}
}



if (isset($_POST['adresekle'])) {

	$adi = temizle($_POST['adi']);
	$adres = temizle($_POST['adres']);
	$il = temizle($_POST['il']);
	$ilce = temizle($_POST['ilce']);
	$uye = $_SESSION['uyeid'];


	if ($_SESSION['uyegirisdurumu'] == 'true') {


		$adresekle = $ozy->prepare("INSERT INTO adreslerim (adi, adres, il, ilce, uyeid) 
VALUES (?,?,?,?,?)");
		$adresekledim = $adresekle->execute(array($adi, $adres, $il, $ilce, $uye));


		if ($adresekledim) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Adresiniz başarıyla eklendi.", "Başarılı");});</script>';
			echo '<meta http-equiv="refresh" content="2; url=' . $url . '/hesabim/">';
		} else {


			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
		}
	} else {

		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Malesef bu ürüne yorum bırakabilmek için sisteme üye olmalısınız.", "Başarısız");});</script>';
	}
}


if (isset($_GET['adressil'])) {
	$adressil = temizle($_GET['adressil']);
	$siladres = $ozy->prepare("DELETE FROM adreslerim WHERE id=? and uyeid=?");
	$siladres->execute(array($adressil, $uyeid));
	header("Location: " . $url . "/hesabim/");
}



if (isset($_POST['uyeguncelle'])) {
	$isim = temizle($_POST['isim']);
	$telefon = temizle($_POST['telefon']);
	$email = temizle($_POST['email']);
	$uyetip = temizle($_POST['uyetip']);
	$tc = temizle($_POST['tc']);
	$vergi1 = temizle($_POST['vergi1']);
	$vergi2 = temizle($_POST['vergi2']);
	$vergi3 = temizle($_POST['vergi3']);
	$vergi3 = temizle($_POST['vergi3']);
	$sifretip = temizle($_POST['sifretip']);
	$sifre = md5(temizle($_POST['sifre']));

	if ($sifretip == '1') {

		$uyeguncelle = $ozy->prepare("update users set isim=?, telefon=?, email=?, uyetip=?, tc=?, vergi1=?, vergi2=?, vergi3=?, sifre=? where id=?");
		$uyeguncelle->execute(array($isim, $telefon, $email, $uyetip, $tc, $vergi1, $vergi2, $vergi3, $sifre, $uyeid));

		if ($uyeguncelle) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Üyelik bilgileriniz başarıyla güncellendi. Yeni şifreniz sisteme eklendi.", "Başarılı");});</script>';
			echo '<meta http-equiv="refresh" content="2; url=' . $url . '/hesabim/">';
		} else {


			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
		}
	} else {



		$uyeguncelle = $ozy->prepare("update users set isim=?, telefon=?, email=?, uyetip=?, tc=?, vergi1=?, vergi2=?, vergi3=? where id=?");
		$uyeguncelle->execute(array($isim, $telefon, $email, $uyetip, $tc, $vergi1, $vergi2, $vergi3, $uyeid));


		if ($uyeguncelle) {

			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Üyelik bilgileriniz başarıyla güncellendi.", "Başarılı");});</script>';
			echo '<meta http-equiv="refresh" content="2; url=' . $url . '/hesabim/">';
		} else {


			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu.", "Başarısız");});</script>';
		}
	}
}








if (isset($_POST["destekcevapla"])) {
	$uye = $uyeid;
	$destekid = temizle($_POST["destekid"]);
	$siparisno = temizle($_POST["siparisno"]);
	$konu = temizle($_POST["konu"]);
	$mesaj = temizle($_POST["mesaj"]);
	$tarih = date("d.m.Y h:i");
	$mid = temizle($_POST["mid"]);
	$email = temizle($_POST["email"]);
	$durum = 0;
	$ticketcevapver = $ozy->prepare("insert into support_reply set uye=?, destekid=?, siparisno=?, konu=?, mesaj=?, tarih=?, mid=?, email=?, durum=?");
	$ticketcevapver->execute(array($uye, $destekid, $siparisno, $konu, $mesaj, $tarih, $mid, $email, $durum));
	if ($ticketcevapver) {
		$ticketguncelle = $ozy->prepare("update support set durum='$durum' where id='$destekid'");
		header("Location:" . $url . "/hesabim/");
	} else {
		header("Location:" . $url . "/hesabim/");
	}
}





if (isset($_POST['destekekle'])) {

	$uye   = $uyeid;
	$siparisno  = temizle($_POST['siparisno']);
	$konu  = temizle($_POST['konu']);
	$mesaj  = temizle($_POST['mesaj']);
	$durum  = "0";
	$tarih		= date("d-m-Y H:i:s");
	$mid  = $RandStr;
	$email  = temizle($uyebilgileri['email']);
	if (empty($konu) || empty($email)) {
		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm boş alan bıraktınız.", "Başarısız");});</script>';
	} else {
		$ekle = $ozy->prepare("insert into support set uye=?, siparisno=?, konu=?, mesaj=?, durum=?, tarih=?, mid=?, email=?");
		$ekle->execute(array($uye, $siparisno, $konu, $mesaj, $durum, $tarih, $mid, $email));
		$id = $ozy->lastInsertId();
		$ekleme = $ozy->prepare("insert into support_reply set  destekid=?, siparisno=?, konu=?, mesaj=?, tarih=?, mid=?, email=?, uye=?");
		$ekleme->execute(array($id, $siparisno, $konu, $mesaj, $tarih, $mid, $email, $uye));



		echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Destek Talebiniz bize ulaşmıştır. Yetkili departman en kısa sürede size dönüş sağlanacaktır. Teşekkür ederiz.", "Başarılı");});</script>';
		echo '<meta http-equiv="refresh" content="2; url=' . $url . '/hesabim/">';

		if ($system['sdestekonay'] == '1') {
			$symesaj = 'Sayın yönetici, Siteniz üzerinden destek talebi oluşturuldu.';
			$symesaj = html_entity_decode($symesaj, ENT_COMPAT, "UTF-8");
			$symesaj = rawurlencode($symesaj);
			$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8");
			$smsbaslik = rawurlencode($smsbaslik);
			sendsms($symesaj, $admintel, $smsbaslik);
		}
		if ($system['destekonay'] == '1') {

			include("mail/PHPMailerAutoload.php");
			$mail = new PHPMailer;
			$mail->IsSMTP();
			//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
			$mail->Host = "$sunucu"; // Mail sunucusuna ismi
			$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
			$mail->IsHTML(true);
			$mail->SetLanguage("tr", "phpmailer/language");
			$mail->CharSet  = "utf-8";
			$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
			$mail->Password = "$esifre"; // Mail adresimizin sifresi
			$mail->SetFrom($mail->Username, '' . $siteadi . '');
			$mail->AddAddress($posta); // Maili gonderecegimiz kisi yani alici
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = "Destek Talebi Geldi"; // Konu basligi
			$mail->Body = '
			
		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
							<a href="' . $url . '"><img style="height: 30px;line-height: 1;width: 200px;margin: 80px;" class="top-image" src="' . $url . '/resimler/siteayarlari/' . $ayar['logo'] . '"  alt="' . $siteadi . '"></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">
										Siteniz üzerinden destek talebi oluşturuldu.</br>
									
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img class="top-image" src="' . $url . '/mail/webinar-no-text.png" width="560"/><br><br>

										<strong>Eposta Adresi :</strong> ' . $email . '<br>
										<strong>Konusu :</strong> ' . $konu . '<br>
										<strong>Bırakılan Destek Mesajı :</strong> ' . $mesaj . '<br>
			                            <strong>İP Adresi</strong>: ' . $ip . '<br><br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank" href="' . $url . '/boss/">Hemen İncele</a>
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
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="' . $url . '/blog"><img src="' . $url . '/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['twitter'] . '"><img src="' . $url . '/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['facebook'] . '"><img src="' . $url . '/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['youtube'] . '"><img src="' . $url . '/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['instagram'] . '"><img width="20px" height="20px" src="' . $url . '/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['googleplus'] . '"><img src="' . $url . '/mail/google-teal.png"></a></td>

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
										<b>' . $ayar['siteadi'] . '</b><br>
                            ' . $ayar['adres'] . '<br>
							' . $ayar['tel'] . ' ' . $ayar['email'] . '<br>
                            <a style="color: #00a5b5;" href="' . $url . '/iletisim/">Bize Ulaşın</a>
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
			if (!$mail->Send()) {
			} else {
			}
		}
	}
}




if (isset($_POST['cekguncelle'])) {
	$kuponadi  = temizle($_POST['kuponadi']);
	$sekli = "1";
	$uyeepostamiz = $uyebilgileri['email'];
	$uyeepostamiz2 = "" . $kuponadi . "-" . $uyebilgileri['email'] . "";
	$ceksorgu = $ozy->prepare("SELECT COUNT(*) FROM kuponlar where durum='1' and sekil='1' and epostalar like '%$uyeepostamiz%' and gtarih>='$buguntarihim' and kullanildi like '%$uyeepostamiz2%' order by id DESC");
	$ceksorgu->execute();
	$ceksay = $ceksorgu->fetchColumn();
	if ($ceksay == '1') {
		echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Malesef bu hediye çekini daha önce kullanmışsınız.", "Başarısız");});</script>';
	} else {

		$kuponkontrol = $ozy->prepare("SELECT * FROM kuponlar WHERE durum='1' and adi=? and sekil=? and epostalar like '%$uyeepostamiz%'");
		$kuponkontrol->execute(array($kuponadi, $sekli));
		if ($kuponkontrol->rowCount()) {
			$rows = $kuponkontrol->fetch(PDO::FETCH_ASSOC);
			if ($rows['stok'] <= '0') {

				echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Malesef bu hediye çeki limiti dolmuştur.", "Başarısız");});</script>';
			} else {


				if ($sepetbedeli >= $rows['slimit']) {
					$yeni = $rows['oran'];
					$kid = $rows['id'];
					$sekil = $rows['tip'];
					if ($sekil == '1') {
						$ksyeni = $sepetbedeli * $yeni;
						$syeni = $ksyeni / 100;
						$sonuccc = $ozy->exec("UPDATE sepet SET  kuponid='0',kupontutar='0.00',cektutar='$syeni',cekid='$kid' WHERE gelenkim='$sepetimdekikim' order by id asc limit 1");

						echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Hediye çeki başarıyla uygulandı.", "Başarılı");});</script>';
						echo '<meta http-equiv="refresh" content="0; url=' . $url . '/sepet/">';
					} else {
						$sonuccc = $ozy->exec("UPDATE sepet SET kuponid='0',kupontutar='0.00',cektutar='$yeni',cekid='$kid' WHERE gelenkim='$sepetimdekikim' order by id asc limit 1");
						echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Hediye çeki başarıyla uygulandı.", "Başarılı");});</script>';
						echo '<meta http-equiv="refresh" content="0; url=' . $url . '/sepet/">';
					}
				} else {


					echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Kuponu kullanabilmek için sepet tutarınız en az ' . $rows['slimit'] . ' TL olmalıdır.", "Başarısız");});</script>';
				}
			}
		} else {
			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Hediye Çeki Kodu Geçersiz veya Süresi Bitmiş.", "Başarısız");});</script>';
		}
	}
}






if (isset($_GET['ceksil'])) {;
	$sonuccc = $ozy->exec("UPDATE sepet SET cektutar='0.00',cekid='0' WHERE gelenkim='$sepetimdekikim'");
	echo '<meta http-equiv="refresh" content="0; url=' . $url . '/sepet/">';
}









if (isset($_POST['sifremiunuttum'])) {

	$yeniletip = temizle($_POST['yeniletip']);
	$stelefon = temizle($_POST['stelefon']);
	$seposta = temizle($_POST['seposta']);
	$sadsoyad = temizle($_POST['sadsoyad']);

	if ($yeniletip == '1') {
		$emailkontrol = $ozy->prepare("SELECT * FROM users WHERE telefon=? and isim=?");
		$emailkontrol->execute(array($stelefon, $sadsoyad));
		if ($emailkontrol->rowCount()) {

			$newsifre = md5($RandStr);
			$yenileeposta = $ozy->exec("UPDATE users SET sifre='{$newsifre}' WHERE telefon='{$stelefon}' and isim='{$sadsoyad}'");


			if ($system['ssifrehatirlat'] == '1') {
				$symesaj = 'Sayın ' . $sadsoyad . ', Şifreniz ' . $RandStr . ' olarak yenilenmiştir. Eğer bu işlemi siz yapmadıysanız lütfen bizimle irtibat kurunuz. ' . $ayar['siteadi'] . '';
				$symesaj = html_entity_decode($symesaj, ENT_COMPAT, "UTF-8");
				$symesaj = rawurlencode($symesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8");
				$smsbaslik = rawurlencode($smsbaslik);
				sendsms($symesaj, $stelefon, $smsbaslik);
			}
		} else {

			/////SMS İLE ŞİFRE YENİLEME BAŞLIYOR//////


			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bu telefon numarasına ait hesap bulunamadı", "Başarısız");});</script>';








			/////SMS İLE ŞİFRE YENİLEME BAŞLIYOR//////
		}
	} else {
		/////EMAİL İLE ŞİFRE YENİLEME BAŞLIYOR//////



		$emailkontrol = $ozy->prepare("SELECT * FROM users WHERE email=? and isim=?");
		$emailkontrol->execute(array($seposta, $sadsoyad));
		if ($emailkontrol->rowCount()) {

			$newsifre = md5($RandStr);
			$yenileeposta = $ozy->exec("UPDATE users SET sifre='{$newsifre}' WHERE email='{$seposta}' and isim='{$sadsoyad}'");


			echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Yeni şifreniz epostanıza iletildi. Lütfen spam klasörünüzüde kontrol etmeyi unutmayın. Teşekkür ederiz.", "Başarılı");});</script>';


			if ($yenileeposta) {

				include("mail/PHPMailerAutoload.php");
				$mail = new PHPMailer;
				$mail->IsSMTP();
				//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "$type"; // Güvenli baglanti icin ssl normal baglanti icin tls
				$mail->Host = "$sunucu"; // Mail sunucusuna ismi
				$mail->Port = "$port"; // Gucenli baglanti icin 465 Normal baglanti icin 587
				$mail->IsHTML(true);
				$mail->SetLanguage("tr", "phpmailer/language");
				$mail->CharSet  = "utf-8";
				$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
				$mail->Password = "$esifre"; // Mail adresimizin sifresi
				$mail->SetFrom($mail->Username, '' . $siteadi . '');
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
							<a href="' . $url . '"><img style="height: 30px;line-height: 1;width: 200px;margin: 80px;" class="top-image" src="' . $url . '/resimler/siteayarlari/' . $ayar['logo'] . '"  alt="' . $siteadi . '"></a>
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
									<img class="top-image" src="' . $url . '/mail/webinar-no-text.png" width="560"/><br><br>

										<strong>Sayın,</strong> ' . $sadsoyad . '<br>
										<strong>Yeni Şifreniz :</strong> ' . $RandStr . '<br>
										<strong>Eğer bu işlemi siz yapmadıysanız lütfen bizimle iletişime geçiniz.<br>
			                            <strong>İP Adresi</strong>: ' . $ip . '<br><br>
			                             <a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;" target="_blank">' . $RandStr . '</a>
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
												<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank"  href="' . $url . '/blog"><img src="' . $url . '/mail/rss-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['twitter'] . '"><img src="' . $url . '/mail/x-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['facebook'] . '"><img src="' . $url . '/mail/facebook-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['youtube'] . '"><img src="' . $url . '/mail/youtube-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['instagram'] . '"><img width="20px" height="20px" src="' . $url . '/mail/linkedin-teal.png"></a></td>
									<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a target="_blank" href="' . $ayar['googleplus'] . '"><img src="' . $url . '/mail/google-teal.png"></a></td>

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
										<b>' . $ayar['siteadi'] . '</b><br>
                            ' . $ayar['adres'] . '<br>
							' . $ayar['tel'] . ' ' . $ayar['email'] . '<br>
                            <a style="color: #00a5b5;" href="' . $url . '/iletisim/">Bize Ulaşın</a>
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
				if (!$mail->Send()) {
				} else {
				}
			}
		} else {




			echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm girdiğiniz veriler hatalı.", "Başarısız");});</script>';
		}




		/////EMAİL İLE ŞİFRE YENİLEME BAŞLIYOR//////
	}
}
