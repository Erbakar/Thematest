<title>Alışveriş Sepetim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
<?php require('func/checkout.php');?>
      
			 
			 
		
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Alışveriş Sepetim<span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Alışveriş Sepetim</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
	
		
        <div class="page-content">
            	<div class="checkout">
	                <div class="container">
      
            			
	 
		
					







	            <div class="col-md-12">
                <div class="card-body cart">
                <div class="col-sm-12 empty-cart-cls text-center"> 
				

<?php 


    if ($_GET["siparisno"]) {
    $siparisno = temizle($_GET["siparisno"]);
	$durum = "Sipariş Onaylandı";
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








	
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div>
			
			
			
			
        </main>