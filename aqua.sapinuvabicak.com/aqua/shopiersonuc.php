<title>Alışveriş Sepetim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

             <?php require('func/checkout.php');?>
             <?php if($system['misafirok']!='1'){?>
			 <?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
             <?php } else { ?>			 
             <meta http-equiv="refresh" content="0; url='<?php echo $url;?>/kontrol/">
			 <?php } ?>
			 
	         <?php } ?>
			 
			 
			          <?php
					  $sepetebak = $ozy->prepare("SELECT * FROM sepet WHERE kim=? and gelenkim=?");
					  $sepetebak->execute(array($ip,$sepetimdekikim));
					  if ($sepetebak->rowCount()) {
					  $uyesepeti = $ozy->prepare("SELECT * FROM urunler 
					  INNER JOIN sepet ON urunler.id = sepet.urunid  
					  WHERE sepet.kim=? and sepet.gelenkim=? ORDER BY sepet.id DESC");                
					  $uyesepeti->execute(array($ip,$sepetimdekikim));
					  foreach ($uyesepeti as $sepet) {
						  
						$sepettekfiyat = fiyatgoster($sepet['fiyat']);
						$sepetsonfiyat = fiyatgoster($sepet['fiyat']*$sepet['adet']);
						  
						  ?>
					  
					  <?php $siparissontablo.= "
			 
                         <tr>
                                    <td>
                                        <a href='urun/$sepet[seo]' class='d-flex align-items-center'>
                                            <img src='resimler/urunler/$sepet[resim]' class='img-fluid me-3' width='120'
                                                 height='80' alt=''>
                                            <span class='title'>$sepet[adi]<br/><b style='font-size: 13px;
background: #f7f7f7;
padding: 10px;
width: 100%;
display: block;
border-radius: 6px;
margin-top: 5px;
font-weight: 500;'>$sepet[ekurun]</b></span>
                                        </a>
                                    </td>
                                    <td>$sepet[urunkodu]</td>
                                    <td>
									 
                                        <div class='d-flex align-items-center'>
                                           <span class='number'>$sepet[adet] Adet</span>
              </div>
										
                                    </td>
                                    <td>$sepettekfiyat</td>
                                    <td>$sepetsonfiyat</td>
                                </tr>
			
   
			
       ";?>
                  
                            <?php }} ?>
			 
			
			 


      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Alışveriş Sepetim</h2>
        </div>
    </section>
 
 <section class="page cart pt-5 pb-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
				
						

<?php 

$status = $_POST["status"]; 
$invoiceId = $_POST["platform_order_id"];
$status = strtolower($status);
if ($status == "success") {
		
		$siparisno = $_POST["platform_order_id"];
	    $durum = "Sipariş Onaylandı";
		$ekle = $ozy->prepare("UPDATE siparis SET durum=? where siparisno=?");
	    $ekle -> execute(array($durum,$siparisno));
	    $sipkontrol = $ozy->prepare("SELECT siparisno FROM siparis WHERE siparisno = ?");
	    $sipkontrol->execute([$siparisno]);
	    if($sipkontrol->rowCount()) {
	    $sip = $ozy->query("select * from siparis where siparisno='{$siparisno}'")->fetch(PDO::FETCH_ASSOC); 

	include('kredikartigenelmesaj.php');
   //////// STOK DÜŞME ALANI /////
     
	$idler = explode(',', $sip['ekozellikid']);
    $adetler = explode(',', $sip['ekozellikadet']);
  
	foreach(array_combine($idler, $adetler) as $ekid => $ekad){
		
    $ozellikkontrol = $ozy->prepare("SELECT stok FROM anaozellikalt WHERE id =?");
	$ozellikkontrol->execute([$ekid]);
	if($ozellikkontrol->rowCount()) {
	$ozelbak = $ozellikkontrol ->fetch(PDO::FETCH_ASSOC);
	$son = $ozelbak['stok']-$ekad;
	$ozellikstokla = $ozy->exec("UPDATE anaozellikalt SET stok='$son' where id='$ekid'");
	}
	
	}
	
	
    $urunidler = explode(',', $sip['urunid']);
    $adetler = explode(',', $sip['adet']);
  
	foreach(array_combine($urunidler, $adetler) as $urnid => $urnadt){
		
    $stokkontrol = $ozy->prepare("SELECT stok FROM urunler WHERE id =?");
	$stokkontrol->execute([$urnid]);
	if($stokkontrol->rowCount()) {
	$stokbak = $stokkontrol ->fetch(PDO::FETCH_ASSOC);
	$son = $stokbak['stok']-$urnadt;
	$urunstokla = $ozy->exec("UPDATE urunler SET stok='$son' where id='$urnid'");
	}
	
	}
	

	
   //////// STOK DÜŞME ALANI /////
   
   //////// KUPON HEDİYE ÇEKİ DÜŞME ALANI /////
   
   	$kuponid = $sip['kuponid'];
	$kuponkontrol = $ozy->prepare("SELECT * FROM kuponlar WHERE id=?");
	$kuponkontrol->execute(array($kuponid));
	if ($kuponkontrol->rowCount()) {
	$urowskupon = $kuponkontrol ->fetch(PDO::FETCH_ASSOC);
	$total = $urowskupon['stok'];
	$yenikupon = $urowskupon['stok']-1;
	$kuponsonuccc = $ozy->exec("UPDATE kuponlar SET stok='$yenikupon' WHERE id='$kuponid' limit 1");
    }
	
	$cekid = $sip['cekid'];
	$cekkontrol = $ozy->prepare("SELECT * FROM kuponlar WHERE id=?");
	$cekkontrol->execute(array($cekid));
	if ($cekkontrol->rowCount()) {
	$cekurowskupon = $cekkontrol ->fetch(PDO::FETCH_ASSOC);
	$totalcek = $cekurowskupon['stok'];
	$yenicek = $cekurowskupon['stok']-1;
	$cekadimiz = $cekurowskupon['adi'];
	$ceksonuccc = $ozy->exec("UPDATE kuponlar SET stok='$yenicek' WHERE id='$cekid' limit 1");
	$userinepostasi = "".$cekurowskupon['kullanildi'].",".$cekadimiz."-".$email."";
	$cekkulandik = $ozy->exec("UPDATE kuponlar SET kullanildi='$userinepostasi' WHERE id='$cekid' limit 1");
	
    }
	
   
   //////// KUPON HEDİYE ÇEKİ DÜŞME ALANI /////
   
   //////// SEPET CLEAN ALANI /////
   $sepetbosalt = $ozy->exec("DELETE FROM sepet where kim='$ip' and gelenkim='$sepetimdekikim'");
   //////// SEPET CLEAN ALANI /////
   
   
   
   
   /////SMS BİLDİRİM ALANI/////
   
    if($system['sadminsiparisonay']=='1'){
				$smesaj='Sayın yönetici, '.$siparisno.' numaralı sipariş alındı. Ödeme yöntemi : '.$sip['odemetipi'].' , Ödenen tutar : '.$sip['toplamtutar'].' TL';
				$smesaj = html_entity_decode($smesaj, ENT_COMPAT, "UTF-8"); 
				$smesaj = rawurlencode($smesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8"); 
				$smsbaslik = rawurlencode($smsbaslik); 
				sendsms($smesaj,$admintel,$smsbaslik);
	}
    if($system['ssiparisonay']=='1'){
				$symesaj='Sayın '.$adsoyad.', Siparişiniz başarıyla alındı. Sipariş No : '.$siparisno.' , Sipariş Durumu: '.$sip['durum'].' , Ödeme yöntemi : '.$sip['odemetipi'].' , Toplam Tutar : '.$sip['toplamtutar'].' TL Bizi tercih ettiğiniz için teşekkürler. '.$ayar['siteadi'].'';
				$symesaj = html_entity_decode($symesaj, ENT_COMPAT, "UTF-8"); 
				$symesaj = rawurlencode($symesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8"); 
				$smsbaslik = rawurlencode($smsbaslik); 
				sendsms($symesaj,$sip['telefon'],$smsbaslik);
	}
   
   ////////SMS BİLDİRİM ALANI////	
		
		    
		
		
		///////EPOSTA BİLDİRİM ALANI///////
		
            if($system['siparisonay']=='1'){
            include("mail/PHPMailerAutoload.php");	
            include('kredikartisiparismesaj.php');
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
			$mail->AddAddress($sip["email"]); // Maili gonderecegimiz kisi yani alici
			if($system['adminsiparisonay']=='1'){		
			$mail->AddCC($posta, $siteadi);
			}
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = 'Siparişiniz Alındı'; // Konu basligi
			$mail->Body = ' '.$siparismetin.''; // Mailin icerigi
			if(!$mail->Send()){
			}else {
				
			}	
			}






    
										
												
		
	/////EPOSTA BİLDİRİM ONAYI/////
		
		
		
} else{
	
	echo "BOYLE SİPARİŞ NUMARASI SİSTEMDE YOKTUR.";
}
	
	
	
    
	
 }else{

    echo "ÜZGÜNÜM ! Bir hata oluştu :/";

   }



?>

				
			</div>
				</div>
					
				
            </div>
    </section>