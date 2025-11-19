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
			 
			 
		
		   <main class="main">
       
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
            		<?php if($sepetsayi<='0'){?>
						 <div class="col-md-12">
           
             
                <div class="card-body cart">
                    <div class="col-sm-12 empty-cart-cls text-center"> 
					<img style="margin: auto !important;" src="eklentiler/sepetbos.png" width="100" height="100" class="img-fluid mb-4 mr-3">
                        <h5><strong>Alışverişiz Sepetiniz Boş</strong></h5>
                        <h5>Biraz Gezinmeye Ne Dersin :)</h5> <a href="<?php echo $url;?>" class="btn btn-primary cart-btn-transform m-3" data-abc="true">hadi gezinelim</a>
                    </div>
                </div>
           
                </div>
				<?php } else { ?>
            			
	 
		
					







	            <div class="col-md-12">
                <div class="card-body cart">
                <div class="col-sm-12 empty-cart-cls text-center"> 
				

<?php 


//////// Havale/EFT / KAPIDA ÖDEME ALANI /////

if($_POST['odemetipi']=='Havale/EFT' and $system['havaleok']=='1' or $_POST['odemetipi']=='Kapıda Ödeme' and $system['kapidaok']=='1'){

   $durum = "Ödeme Bekleniyor";
   $siparis = $ozy->prepare("INSERT INTO siparis (siparisno, odemetipi, urunid, adet, uyetip, vergibilgileri, adsoyad, telefon, email, adres, il, ilce, faturatip, faturaadres, faturail, faturailce, onay, aratutar, kdvtutari, kargotutari, havaleindirimtutari, kuponid, kupontutari, cekid, cektutari, kapitutar, toplamtutar, uye, kim, gelenkim, uruntablo, mesaj, durum, ekozellikid, ekozellikadet, tarih, mailtablo, tarihson) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
   $siparisonuc = $siparis->execute(array($siparisno, $odemetipi, $urunid, $adet, $uyetip, $vergibilgileri, $adsoyad, $telefon, $email, $adres, $il, $ilce, $faturatip, $faturaadres, $faturail, $faturailce, $onay, $aratutar, $kdvtutari, $kargotutari, $havaleindirimtutari, $kuponid, $kupontutari, $cekid, $cektutari, $kapitutar, $toplamtutar, $uye, $ip, $sepetimdekikim, $uruntablo, $mesaj, $durum, $ekozellikid, $ekozellikadet, $tarih, $mailtablomuz, $tarihson));

   if($siparisonuc){
	   
   include('genelmesaj.php');
   //////// STOK DÜŞME ALANI /////
     
	$idler = explode(',', $ekozellikid);
    $adetler = explode(',', $ekozellikadet);
  
	foreach(array_combine($idler, $adetler) as $ekid => $ekad){
		
    $ozellikkontrol = $ozy->prepare("SELECT stok FROM anaozellikalt WHERE id =?");
	$ozellikkontrol->execute([$ekid]);
	if($ozellikkontrol->rowCount()) {
	$ozelbak = $ozellikkontrol ->fetch(PDO::FETCH_ASSOC);
	$son = $ozelbak['stok']-$ekad;
	$ozellikstokla = $ozy->exec("UPDATE anaozellikalt SET stok='$son' where id='$ekid'");
	}
	
	}
	
	
    $urunidler = explode(',', $urunid);
    $adetler = explode(',', $adet);
  
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
   
   
	$kuponkontrol = $ozy->prepare("SELECT * FROM kuponlar WHERE id=?");
	$kuponkontrol->execute(array($kuponid));
	if ($kuponkontrol->rowCount()) {
	$urowskupon = $kuponkontrol ->fetch(PDO::FETCH_ASSOC);
	$total = $urowskupon['stok'];
	$yenikupon = $urowskupon['stok']-1;
	$kuponsonuccc = $ozy->exec("UPDATE kuponlar SET stok='$yenikupon' WHERE id='$kuponid' limit 1");
    }
	
	
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
				$smesaj='Sayın yönetici, '.$siparisno.' numaralı sipariş alındı. Ödeme yöntemi : '.$odemetipi.' , Ödenen tutar : '.$toplamtutar.' TL';
				$smesaj = html_entity_decode($smesaj, ENT_COMPAT, "UTF-8"); 
				$smesaj = rawurlencode($smesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8"); 
				$smsbaslik = rawurlencode($smsbaslik); 
				sendsms($smesaj,$admintel,$smsbaslik);
	}
    if($system['ssiparisonay']=='1'){
				$symesaj='Sayın '.$adsoyad.', Siparişiniz başarıyla alındı. Sipariş No : '.$siparisno.' , Sipariş Durumu: '.$durum.' , Ödeme yöntemi : '.$odemetipi.' , Toplam Tutar : '.$toplamtutar.' TL Bizi tercih ettiğiniz için teşekkürler. '.$ayar['siteadi'].'';
				$symesaj = html_entity_decode($symesaj, ENT_COMPAT, "UTF-8"); 
				$symesaj = rawurlencode($symesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8"); 
				$smsbaslik = rawurlencode($smsbaslik); 
				sendsms($symesaj,$telefon,$smsbaslik);
	}
   
   ////////SMS BİLDİRİM ALANI////
	
   //////// EPOSTA BİLDİRİM ALANI /////
            if($system['siparisonay']=='1'){
			include('siparismesaj.php');	
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
			$mail->CharSet  ="utf-8";
			$mail->Username = "$posta"; // Mail adresimizin kullanicı adi
			$mail->Password = "$esifre"; // Mail adresimizin sifresi
			$mail->SetFrom($mail->Username, ''.$siteadi.'');
			$mail->AddAddress($email); // Maili gonderecegimiz kisi yani alici
			if($system['adminsiparisonay']=='1'){		
			$mail->AddCC($posta, $siteadi);
			}
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = 'Siparişinizi başarıyla aldık'; // Konu basligi
			$mail->Body = ' '.$siparismetin.''; // Mailin icerigi
			if(!$mail->Send()){
			}else {
			}	
			}

   //////// EPOSTA BİLDİRİM ALANI /////
	
	
	
 }else{

    echo "ÜZGÜNÜM ! Bir hata oluştu :/";

   }


//////// Havale/EFT / KAPIDA ÖDEME ALANI /////





}elseif($_POST['odemetipi']=='Kredi Kartı' and $system['kartok']=='1'){
   $durum = "Ödeme Bekleniyor";
   $siparis = $ozy->prepare("INSERT INTO siparis (siparisno, odemetipi, urunid, adet, uyetip, vergibilgileri, adsoyad, telefon, email, adres, il, ilce, faturatip, faturaadres, faturail, faturailce, onay, aratutar, kdvtutari, kargotutari, havaleindirimtutari, kuponid, kupontutari, cekid, cektutari, kapitutar, toplamtutar, uye, kim, gelenkim, uruntablo, mesaj, durum, ekozellikid, ekozellikadet, tarih, mailtablo, tarihson) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
   $siparisonuc = $siparis->execute(array($siparisno, $odemetipi, $urunid, $adet, $uyetip, $vergibilgileri, $adsoyad, $telefon, $email, $adres, $il, $ilce, $faturatip, $faturaadres, $faturail, $faturailce, $onay, $aratutar, $kdvtutari, $kargotutari, $havaleindirimtutari, $kuponid, $kupontutari, $cekid, $cektutari, $kapitutar, $toplamtutar, $uye, $ip, $sepetimdekikim, $uruntablo, $mesaj, $durum, $ekozellikid, $ekozellikadet, $tarih, $mailtablomuz, $tarihson));

if($system['postip']=='0'){
///////PAYTR ALANI/////


		$merchant_id 	= $system['paytrid'];
		$merchant_key 	= $system['paytrkey'];
		$merchant_salt	= $system['paytrsalt'];
        $total =0;
		$b = 0;
		$sepet = array();
		
		$uysepet = $ozy->prepare("SELECT * FROM urunler 
				INNER JOIN sepet ON urunler.id = sepet.urunid  
				WHERE sepet.kim=? ORDER BY sepet.id DESC");                
		$uysepet->execute(array($ip));
		
		foreach ($uysepet as $urun)
		{
			
   

        $ufiyat = ($sepet['fiyat']+$sepet['efiyat'])*$sepet['adet'];

		$sepetbedeli = $ufiyat;
		$total = ($total + $sepetbedeli+$kargobedeli+$kapikargobedeli)-($kupontutari+$hediyecekitutari);
		array_push($sepet, array($urun["adi"],$ufiyat,1));
		}
				
		//$payment_amount	= $total * 100;
		$payment_amount	= $toplamtutarim * 100;
		$merchant_oid = $siparisno;
		$user_name = $adsoyad;
		$user_address = $adres;
		$user_phone = $telefon;

		$merchant_ok_url = $ayar['siteurl'] . "/paytrsonuc.php?siparisno=".$siparisno;	
		$merchant_fail_url = $ayar['siteurl'] . "/paytrsonuc.html.php";	
		$user_basket = base64_encode(json_encode($sepet));
		$user_ip=$ip;
		$timeout_limit = "30";
		$debug_on = 1;
		if($system['paytrtest']=='1'){
		$test_mode = 1;
		} else { 
		$test_mode = 0;
		}
		$no_installment	= 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın
		$max_installment = 0;
		$currency = "TL";

		####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
		$hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
		$paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
		$post_vals=array(
				'merchant_id'=>$merchant_id,
				'user_ip'=>$user_ip,
				'merchant_oid'=>$merchant_oid,
				'email'=>$email,
				'payment_amount'=>$payment_amount,
				'paytr_token'=>$paytr_token,
				'user_basket'=>$user_basket,
				'debug_on'=>$debug_on,
				'no_installment'=>$no_installment,
				'max_installment'=>$max_installment,
				'user_name'=>$user_name,
				'user_address'=>$user_address,
				'user_phone'=>$user_phone,
				'merchant_ok_url'=>$merchant_ok_url,
				'merchant_fail_url'=>$merchant_fail_url,
				'timeout_limit'=>$timeout_limit,
				'currency'=>$currency,
				'test_mode'=>$test_mode
			);
		
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1) ;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$result = @curl_exec($ch);

		if(curl_errno($ch))
			die("PAYTR IFRAME connection error. err:".curl_error($ch));

		curl_close($ch);
		
		$result=json_decode($result,1);
			
		if($result['status']=='success')
			$token=$result['token'];
		else
			die("PAYTR IFRAME failed. reason:".$result['reason']);
		#########################################################################

		?>
		<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
		<iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
		<script>iFrameResize({},'#paytriframe');</script>


<?php



///////PAYTR ALANI/////
}elseif($system['postip']=='1'){
///////İYZİCO ALANI/////

		
		require "pos/iyzipay/IyzipayBootstrap.php";								
		$key1 = $system['iyziapi'];
		$key2 = $system['iyzikey'];
		$durum = "Ödeme Bekleniyor";
	    $sonfiyat = $toplamtutarim;
		$adSoyad = $adsoyad;
		$last_space = strrpos($adSoyad, ' ');
		$soyad = substr($adSoyad, $last_space);
		$ad = substr($adSoyad, 0, $last_space);	
		$mtc ="25442567452";
		$rurl = $ayar['siteurl'] . "/iyzicosonuc.php?kk=ok";

		IyzipayBootstrap::init();
		$options = new \Iyzipay\Options();
		$options->setApiKey($key1);
	    $options->setSecretKey($key2);
		$options->setBaseUrl("https://api.iyzipay.com");

		$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
		$request->setLocale(\Iyzipay\Model\Locale::TR);
		$request->setPrice($sonfiyat);
		$request->setPaidPrice($sonfiyat);
		$request->setCurrency(\Iyzipay\Model\Currency::TL);
		$request->setBasketId($siparisno);
		$request->setCallbackUrl($rurl);
		$request->setEnabledInstallments(array(2, 3, 6, 9));

		$buyer = new \Iyzipay\Model\Buyer();
		$buyer->setId($uye);
		$buyer->setName($ad);
		$buyer->setSurname($soyad);
		$buyer->setGsmNumber($telefon);
		$buyer->setEmail($email);
		$buyer->setIdentityNumber($mtc);
		$buyer->setRegistrationAddress($adres);
		$buyer->setIp($ip);
		$buyer->setCity($il);
		$buyer->setCountry($ilce);
		$request->setBuyer($buyer);

		$shippingAddress = new \Iyzipay\Model\Address();
		$shippingAddress->setContactName($ad);
		$shippingAddress->setCity($il);
		$shippingAddress->setCountry($ilce);
		$shippingAddress->setAddress($adres);
		$request->setShippingAddress($shippingAddress);

		$billingAddress = new \Iyzipay\Model\Address();
		$billingAddress->setContactName($ad);
		$billingAddress->setCity($il);
		$billingAddress->setCountry("Turkey");
		$billingAddress->setAddress($adres);
		$request->setBillingAddress($billingAddress);

		$basketItems = array();
		
		$uysepet = $ozy->prepare("SELECT * FROM urunler 
			INNER JOIN sepet ON urunler.id = sepet.urunid  
			WHERE sepet.kim=? ORDER BY sepet.id DESC");                
		$uysepet->execute(array($ip));
		foreach ($uysepet as $sepet) { 
			$ufiyat =  ($sepet['fiyat']+$sepet['efiyat'])*$sepet['adet'];     
			$sepetFiyat= number_format($sepFiy, 2, ',', '.');
            $sepetledim = $ozy->prepare("SELECT COUNT(*) FROM sepet where kim='$ip'");
            $sepetledim->execute();
            $sepetsay = $sepetledim->fetchColumn();
		    $newkargo = ($kargotutari/$sepetsay); 
		  
			 	
			$item = new \Iyzipay\Model\BasketItem();
			$item->setId($sepet['urunkodu']);
			$item->setName($sepet['adi']);
			$item->setCategory1("Ürün");
			$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
			$item->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
			$item->setPrice($ufiyat+$newkargo);
			$basketItems[] = $item;
		}	
		$request->setBasketItems($basketItems);

		$checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request,$options );

		print_r($checkoutFormInitialize->getErrorMessage());
		print_r($checkoutFormInitialize->getCheckoutFormContent());?>
		
	</br>     </br>               
	<div id="iyzipay-checkout-form" class="responsive"></div> <style>.css-6385ki-Screens {    position: relative !important;    padding: 16px 8px 8px !important;    min-height: 100% !important;    max-height: 100% !important;    overflow: none;}</style>
</br>
</br

<?php


///////İYZİCO ALANI/////
}elseif($system['postip']=='2'){
///////SHOPİER ALANI/////


require("pos/Shopier.php");
$sapi = $system['shopapi'];
$skey = $system['shopkey'];
$shopier = new Shopier($sapi, $skey);
$shopier_ok_url = $ayar['siteurl'] . "/shopiersonuc.php";
$shopier->setBuyer(Array(
		'id' => ($siparisno),
		'first_name' => $adsoyad, 'last_name' => " ", 'email' => $email, 'phone' => $telefon));
		$shopier->setOrderBilling(Array(
		'billing_address' => $adres,
		'billing_city' => $il,
		'billing_country' => 'turkey',
		'billing_postcode' => '90000',
	));
	$shopier->setOrderShipping(Array(
		'shipping_address' => $adres,
		'shipping_city' => $il,
		'shipping_country' => 'turkey',
		'shipping_postcode' => '90000',
	));
	echo $shopier->run($siparisno, $toplamtutar, $shopier_ok_url);













///////SHOPİER ALANI/////
}else{
	
	echo "SİSTEMDE AKTİF POS BULUNAMAMIŞTIR :(";
	
}



}else{

echo "<b>BÖYLE BİR ÖDEME YÖNTEMİ HİÇ OLMADI;/</b>";



}



?>















			    </div>
                </div>
                </div>








					
				<?php } ?>
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div>
			
			
			
			
        </main>