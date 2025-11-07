<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 2); 
if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$ekresimid = temizle($_GET['duzenle']);
$sip = $ozy->query("select * from siparis where id=$id")->fetch(PDO::FETCH_ASSOC); 
$uyeidkkk = $sip["uye"];
$uyekim = $ozy->query("select * from users where id='{$uyeidkkk}'")->fetch(PDO::FETCH_ASSOC);
$kargoid = $sip['kargoid'];
$kargobilgileri = $ozy->query("select * from kargolar where id='$kargoid'")->fetch(PDO::FETCH_ASSOC);
									
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



   $durum   = temizle($_POST['durum']);
   $kargoid = ($_POST['kargoid'] != "") ? $_POST['kargoid'] : "0";
   $takipno = ($_POST['takipno'] != "") ? $_POST['takipno'] : " ";
   $ekdurum = ($_POST['ekdurum'] != "") ? $_POST['ekdurum'] : "0";
   $eknot = ($_POST['eknot'] != "") ? $_POST['eknot'] : " ";


   $stmt = $ozy->prepare("UPDATE siparis SET durum = ?, kargoid = ?, takipno = ?, ekdurum = ?, eknot = ? WHERE id = ?");
   $result2 = $stmt->execute(array($durum, $kargoid, $takipno, $ekdurum, $eknot, $id));
   
   
   ///////İPTAL VE İADE EDİNCE STOK EKLEME ALANI///////
   if($_POST['durum']=='İptal Edildi' or $_POST['durum']=='İade Edildi'){

    $ekozellikid = $sip['ekozellikid'];
	$ekozellikadet = $sip['ekozellikadet'];
    $idler = explode(',', $ekozellikid);
    $adetler = explode(',', $ekozellikadet);
  
	foreach(array_combine($idler, $adetler) as $ekid => $ekad){
		
    $ozellikkontrol = $ozy->prepare("SELECT stok FROM anaozellikalt WHERE id =?");
	$ozellikkontrol->execute([$ekid]);
	if($ozellikkontrol->rowCount()) {
	$ozelbak = $ozellikkontrol ->fetch(PDO::FETCH_ASSOC);
	$son = $ozelbak['stok']+$ekad;
	$ozellikstokla = $ozy->exec("UPDATE anaozellikalt SET stok='$son' where id='$ekid'");
	}
	
	}
	
	$urunid = $sip['urunid'];
	$adet = $sip['adet'];
    $urunidler = explode(',', $urunid);
    $adetler = explode(',', $adet);
  
	foreach(array_combine($urunidler, $adetler) as $urnid => $urnadt){
		
    $stokkontrol = $ozy->prepare("SELECT stok FROM urunler WHERE id =?");
	$stokkontrol->execute([$urnid]);
	if($stokkontrol->rowCount()) {
	$stokbak = $stokkontrol ->fetch(PDO::FETCH_ASSOC);
	$son = $stokbak['stok']+$urnadt;
	$urunstokla = $ozy->exec("UPDATE urunler SET stok='$son' where id='$urnid'");
	}
	
	}
   
   
   } 
   ///////İPTAL VE İADE EDİNCE STOK EKLEME ALANI///////
   
   
   
   ///////SMS BİLDİRİM ALANI//////
     if($system['ssiparisonay']=='1'){
		
		  if($_POST['ekdurum']=='1'){	 
		  $ekdurumnotu = $_POST['eknot'];
		  }else{			
          $ekdurumnotu = "";
          }
		
		 
	 if($_POST['durum']=='Kargoya Verildi'){	 
     $symesaj='Sayın '.$sip['adsoyad'].', Siparişiniz kargoya verilmiştir. Kargo Takip : '.$kargobilgileri['link'].''.$_POST['takipno'].' . Bizi tercih ettiğiniz için teşekkürler. '.$ayar['siteadi'].'';
	 }else{	
     $symesaj='Sayın '.$sip['adsoyad'].', Sipariş durumunuz : '.$_POST['durum'].' olarak güncellenmiştir. '.$ekdurumnotu.' Bizi tercih ettiğiniz için teşekkürler. '.$ayar['siteadi'].'';
	 }
			
				$teli = $uyekim['telefon'];
				$symesaj = html_entity_decode($symesaj, ENT_COMPAT, "UTF-8"); 
				$symesaj = rawurlencode($symesaj);
				$smsbaslik = html_entity_decode($smsbaslik, ENT_COMPAT, "UTF-8"); 
				$smsbaslik = rawurlencode($smsbaslik); 
				sendsms($symesaj,$teli,$smsbaslik);
	
	
	}
   
       ///////SMS BİLDİRİM ALANI//////
   
	        /////SİPARİŞ EPOSTA BİLDİRİM ALANI///// 
            if($system['siparisonay']=='1'){
            include("../mail/PHPMailerAutoload.php");	
            include('siparismesaj.php');
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
			$mail->addReplyTo($posta, $siteadi);
			$mail->Subject = 'Siparişiniz Güncellendi'; // Konu basligi
			$mail->Body = ' '.$siparismetin.''; // Mailin icerigi
			if(!$mail->Send()){
			}else {
				
			}	
			}
			/////SİPARİŞ EPOSTA BİLDİRİM ALANI///// 
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';	
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/siparis/duzenle/'.$id.'">';

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }






}
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



////Sayfa güncelleme kodları bitiş

}else{
	





}

	
	



?>




<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Sipariş 
						Oku
						</h4>
                    </div>
					

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                            
                            <li class="breadcrumb-item active">Sipariş 
						
						    Oku
						 
							</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
			     <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                    <div class="card m-b-30">
                        <div class="card-body">
                         

                          <div class="tab-content">
						  
			 <div style="padding: 4px; border: 1px solid #f6f6f6;">
   

    <article class="card">
       
        <div class="card-body">
            <h6>Sipariş Kodunuz : <?php echo $sip['siparisno'];?></h6>
            <article class="card">
                <div class="card-body row">
                    <div class="col"> <strong>Sipariş Tarihi:</strong> <br><?php echo $sip['tarih'];?></div>
                    <div class="col"> <strong>Sipariş Durumu:</strong> <br> <?php echo $sip['durum'];?></div>
                    <?php if($sip['ekdurum']=='1'){?>
					<div class="col" style="color:red"> <strong>Yönetici Notu:</strong> <br> <?php echo $sip['eknot']; ?> </div>
                    <?php } else { ?>
					<div class="col"> <strong>Toplam Ödenen Tutar:</strong> <br> <?php echo $sip['toplamtutar']; ?> TL</div>  
					<?php } ?>
					<?php if($sip['kargoid']>'0'){?>
					<?php 
					$kargoidm = $sip['kargoid'];
					$kargomnerede = $ozy->query("select * from kargolar where id='$kargoidm'")->fetch(PDO::FETCH_ASSOC);?>
					<div class="col"> <strong>Kargo Takip :</strong> <br><?php echo $kargomnerede['adi'];?> - <a target="_blank" href="<?php echo $kargomnerede['link'];?><?php echo $sip['takipno']; ?>"><?php echo $sip['takipno']; ?></a> </div>
					<?php } ?>
                </div>
            </article>
            <div class="track">
                <div class="step <?php echo $sip['durum'] == 'Sipariş Onaylandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Hazırlandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Siparişiniz Onaylandı</span> </div>
                <div class="step <?php echo $sip['durum'] == 'Sipariş Hazırlandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Siparişiniz Hazırlanıyor</span> </div>
                <div class="step <?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Kargoya Verildi </span> </div>
                <div class="step <?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Siparişiniz Tamamlandı</span> </div>
            </div>
            <hr>
       </div>
    </article>


				
			
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
							
							<!-- SİPARİŞ YAZDIRMA ALANI -->
							
							
							
							     
							 <div class="col-12" id="divYazdir" style="display:none;">
							 <?php $adresdizi = $dizi = explode (" ",$sip['adres']);?>
<div style="position:absolute;left:50%;margin-left:-420px;top:0px;width:841px;height:594px;border-style:outset;overflow:hidden">
<div style="position:absolute;left:0px;top:0px">
<img src="faturaback.jpg" width=841 height=594></div>
<div style="position: absolute;left: 15%;top: 40.33px;" class="cls_002"><span class="cls_002"><img src="../resimler/siteayarlari/<?php echo $ayar['logo']; ?>" style="height: 40px !important"></span></div>
<div style="position:absolute;left:41.76px;top:84.33px" class="cls_002"><span class="cls_002">Gönderici Bilgileri</span></div>
<div style="position:absolute;left:41.76px;top:106.09px" class="cls_003"><span class="cls_003">Şirket İsmi</span></div>
<div style="position:absolute;left:134.07px;top:106.09px" class="cls_003"><span class="cls_003"><?php echo $ayar['siteadi'];?></span></div>
<div style="position:absolute;left:41.76px;top:127.85px" class="cls_003"><span class="cls_003">Şirket Telefon</span></div>
<div style="position:absolute;left:134.07px;top:127.85px" class="cls_003"><span class="cls_003"><?php echo $ayar['tel'];?></span></div>
<div style="position:absolute;left:41.76px;top:149.62px" class="cls_002"><span class="cls_002">Alıcı Bilgileri</span></div>
<div style="position:absolute;left:41.76px;top:171.38px" class="cls_003"><span class="cls_003">Ad / Soyad</span></div>
<div style="position:absolute;left:134.07px;top:171.38px" class="cls_003"><span class="cls_003"><?php echo $sip['adsoyad'];?></span></div>
<div style="position:absolute;left:134.07px;top:193.15px" class="cls_003"><span class="cls_003"><?php echo $dizi[0];?> <?php echo $dizi[1];?> <?php echo $dizi[2];?> </span></div>
<div style="position:absolute;left:41.76px;top:209.66px" class="cls_003"><span class="cls_003">Adres</span></div>
<div style="position:absolute;left:134.07px;top:209.66px" class="cls_003"><span class="cls_003"><?php echo $dizi[3];?>  <?php echo $dizi[4];?> <?php echo $dizi[5];?></span></div>
<div style="position:absolute;left:134.07px;top:226.17px" class="cls_003"><span class="cls_003"><?php echo $dizi[6];?> <?php echo $dizi[7];?> <?php echo $dizi[8];?> <?php echo $dizi[9];?></span></div>
<div style="position:absolute;left:41.76px;top:247.93px" class="cls_003"><span class="cls_003">İl / İlçe</span></div>
<div style="position:absolute;left:134.07px;top:247.93px" class="cls_003"><span class="cls_003"><?php echo $sip['il'];?> / <?php echo $sip['ilce'];?></span></div>
<div style="position:absolute;left:41.76px;top:269.69px" class="cls_003"><span class="cls_003">Telefon No</span></div>
<div style="position:absolute;left:134.07px;top:269.69px" class="cls_003"><span class="cls_003"><?php echo $sip['telefon'];?></span></div>
<div style="position:absolute;left:41.76px;top:291.46px" class="cls_003"><span class="cls_003">Cep Telefonu</span></div>
<div style="position:absolute;left:134.07px;top:291.46px" class="cls_003"><span class="cls_003"><?php echo $sip['telefon'];?></span></div>
<div style="position:absolute;left:41.76px;top:313.22px" class="cls_003"><span class="cls_003">Posta Kodu</span></div>
<div style="position:absolute;left:134.07px;top:313.22px" class="cls_003"><span class="cls_003">90000</span></div>
<div style="position:absolute;left:41.76px;top:334.99px" class="cls_002"><span class="cls_002">Satış Bilgileri</span></div>
<div style="position:absolute;left:41.76px;top:356.75px" class="cls_003"><span class="cls_003">Kargo</span></div>
<div style="position:absolute;left:41.76px;top:373.26px" class="cls_003"><span class="cls_003">Bilgileri</span></div>
<div style="position:absolute;left:134.07px;top:352.69px" class="cls_003"><span class="cls_003"><?php echo $kargobilgileri['adi'];?></span></div>
<div style="position:absolute;left:134.07px;top:372.69px" class="cls_003"><span class="cls_003"><?php echo $sip['takipno'];?></span></div>
<div style="position:absolute;left:41.76px;top:395.02px" class="cls_003"><span class="cls_003">Durum : <?php echo $sip['durum'];?></span></div>
<div style="position:absolute;left:41.76px;top:416.79px" class="cls_003"><span class="cls_003">Ödeme</span></div>
<div style="position:absolute;left:134.07px;top:425.04px" class="cls_003"><span class="cls_003"><?php echo $sip['odemetipi'];?></span></div>
<div style="position:absolute;left:41.76px;top:433.30px" class="cls_003"><span class="cls_003">Yöntemi</span></div>
<div style="position:absolute;left:41.76px;top:455.06px" class="cls_003"><span class="cls_003">Sipariş Kodu</span></div>
<div style="position:absolute;left:134.07px;top:455.06px" class="cls_003"><span class="cls_003"><?php echo $sip['siparisno'];?></span></div>
</div>
                                      
								
                                    
							 
							 
							</div>
							<!-- SİPARİŞ YAZDIRMA ALANI -->
							<!-- SİPARİŞ YAZDIRMA ALANI -->
							
							
                                <div class="col-12">
                                    <div class="invoice-title">
                                        <h4 class="float-right font-12"><strong>Sipariş Kodu : <?php echo $sip['siparisno'];?></strong></h4>
                                        <h3 class="m-t-0">
                                            <img style="width: 300px;" src="../resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="logo" height="100">
                                        </h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <address>
                                                <strong style="font-weight: 500;">Alıcı Bilgileri:</strong><br>
                                                <?php echo $sip['adsoyad'];?><br>
                                                <?php echo $sip['telefon'];?><br>
                                                <?php echo $sip['email'];?><br>
												<?php echo $sip['adres'];?> <?php echo $sip['il'];?> / <?php echo $sip['ilce'];?><br>
                                            </address>
                                        </div>
                                        <div class="col-6 text-right">
                                            <address>
                                                <strong style="font-weight: 500;">Fatura Bilgileri:</strong><br>
                                                
                                                <?php if($sip['uyetip']=='1'){?> Kurumsal Üye
                                                <?php } else { ?> Bireysel Üye
												<?php } ?>
												<br>
                                                <?php echo $sip['vergibilgileri'];?><br>
                                               <?php echo $sip['faturaadres'];?> <?php echo $sip['faturail'];?> / <?php echo $sip['faturailce'];?>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row" style="text-align: center;background: #6875b6;color: #fff;border: 3px dashed;">
                                        <div class="col-12 m-t-10">
                                            <address>
                                                <strong style="font-weight: 500;">Bırakılan Not:</strong><br>
                                                <?php echo $sip['mesaj'];?><br>
                                            </address>
                                        </div>
                                      
									</div>
									
									  <div class="row">
                                        <div class="col-6 m-t-30">
                                            <address>
                                                <strong style="font-weight: 500;">Ödeme Bilgileri:</strong><br>
                                                <?php echo $sip['odemetipi'];?><br>
                                               <span style="font-size: 13px;" class="badge badge-success"><?php echo $sip['durum'];?></span>
                                            </address>
                                        </div>
                                        <div class="col-6 m-t-30 text-right">
                                            <address>
                                                 <strong style="font-weight: 500;">Sipariş Oluşturulma Tarihi:</strong><br>
                                                <?php echo $sip['tarih'];?><br><br>
                                            </address>
                                        </div>
                                    </div>
                         
                                    <div class="panel panel-default" style="border: 1px solid #f2f2f2;padding: 5px;">
                                        <div class="p-2">
                                            <h3 class="panel-title font-20" style="font-size: 16px;"> <strong style="font-weight: 500;">Sipariş Detayları</strong></h3>
                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <td><strong>Ürün</strong></td>
                                                        <td class="text-center"><strong>Birim Fiyatı</strong></td>
														<td class="text-center"><strong>KDV</strong></td>
                                                        <td class="text-center"><strong>Adet</strong>
                                                        </td>
                                                        <td class="text-right"><strong>Toplam</strong></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                    
													
                                                    <?php echo $sip['uruntablo'];?>
													
													
													
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
														<td class="thick-line"></td>
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                         <strong>Aratutar :</strong></td>
                                                        <td class="thick-line text-right"><?php echo fiyatgoster($sip['aratutar']);?></td>
                                                    </tr>
													  <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
														<td class="thick-line"></td>
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                        <strong>KDV Bedeli :</strong></td>
                                                        <td class="thick-line text-right"><?php echo fiyatgoster($sip['kdvtutari']);?></td>
                                                    </tr>
													
													 <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
														<td class="no-line"></td>
                                                       <td class="thick-line text-left" style="text-align: left !important;">
                                                          <strong>Kargo Bedeli</strong></td>
                                                        <td class="no-line text-right"><?php echo fiyatgoster($sip['kargotutari']);?></td>
                                                    </tr>
													
													<?php if($sip['kuponid']!='0'){?>
                                                
												    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
														<td class="thick-line"></td>
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                           <strong style="color:red;">Kupon Bedeli :</strong></td>
                                                        <td class="thick-line text-right">- <?php echo fiyatgoster($sip['kupontutari']);?></td>
                                                    </tr>	
                                                    <?php } ?>
													<?php if($sip['cekid']!='0'){?>
                                                
												    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
														<td class="thick-line"></td>
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                            <strong style="color:red;">Hediye Çeki Bedeli :</strong></td>
                                                        <td class="thick-line text-right">- <?php echo fiyatgoster($sip['cektutari']);?></td>
                                                    </tr>	
                                                    <?php } ?>
													
													<?php if($sip['havaleindirimtutari']!='0' and $sip['odemetipi']=='Havale/EFT'){?>
												    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
														<td class="thick-line"></td>
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                           <strong style="color:red;">Havale/EFT İndirim Bedeli :</strong></td>
                                                        <td class="thick-line text-right">- <?php echo fiyatgoster($sip['havaleindirimtutari']);?></td>
                                                    </tr>	
                                                    <?php } ?>
													
													
                                                  
                                                    <tr>
                                                        <td class="no-line"></td>
														<td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                           <strong>Ödenecek Tutar</strong></td>
                                                        <td class="no-line text-right"><h4 class="m-0" style="font-size: 14px;"><?php echo fiyatgoster($sip['toplamtutar']);?></h4></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="d-print-none">
                                                <div class="float-right">
                                                 <a class="btn btn-primary waves-effect waves-light" href="javascript:printDiv('divYazdir');">Siparişi Yazdır</a>
												
												</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div>
			              <div class="form-group row">
					      <label for="example-text-input" class="col-sm-2 col-form-label">Sipariş Durumu</label> 
					      <div class="col-sm-10">
					      <select id="kargodurum" name="durum" class="form-control">
						  <option <?php echo $sip['durum'] == 'Ödeme Bekleniyor' ? 'selected' : null; ?> value="Ödeme Bekleniyor"/>Ödeme Bekleniyor</option>
						  <option <?php echo $sip['durum'] == 'Sipariş Onaylandı' ? 'selected' : null; ?> value="Sipariş Onaylandı"/>Sipariş Onaylandı</option>
						  <option <?php echo $sip['durum'] == 'Sipariş Hazırlandı' ? 'selected' : null; ?> value="Sipariş Hazırlandı"/>Sipariş Hazırlandı</option>
						  <option <?php echo $sip['durum'] == 'Tedarik Edilemedi' ? 'selected' : null; ?> value="Tedarik Edilemedi"/>Tedarik Edilemedi</option>
						  <option <?php echo $sip['durum'] == 'Kargoya Verildi' ? 'selected' : null; ?> value="Kargoya Verildi"/>Kargoya Verildi</option>
						  <option <?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'selected' : null; ?> value="Sipariş Tamamlandı"/>Sipariş Tamamlandı</option>
						  <option <?php echo $sip['durum'] == 'İptal Edildi' ? 'selected' : null; ?> value="İptal Edildi"/>İptal Edildi</option>
						  <option <?php echo $sip['durum'] == 'İade Edildi' ? 'selected' : null; ?> value="İade Edildi"/>İade Edildi</option>
						  </select>
				          </div>
			              </div>
						  
						  <div id="kargoid"class="form-group row" <?php echo $sip['durum'] !== 'Kargoya Verildi' ? 'style="display:none;"' : null; ?>>
					      <label for="example-text-input" class="col-sm-2 col-form-label">Kargo Firması</label> 
					      <div class="col-sm-10">
					      <select name="kargoid" class="form-control">
						  <?php $karg = $ozy->query("select * from kargolar where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                          foreach($karg as $kargom){?>
						  <option <?php echo $sip['kargoid'] == $kargom['id'] ? 'selected' : null; ?> value="<?php echo $kargom['id']; ?>"/><?php echo $kargom['adi']; ?></option>
						  <?php } ?>
						  </select>
				          </div>
			              </div>
						  
	                      <div class="form-group row" id="takipno" <?php echo $sip['durum'] !== 'Kargoya Verildi' ? 'style="display:none;"' : null; ?>>
                          <label for="example-text-input" class="col-sm-2 col-form-label">Kargo Takip Numarası</label>
                          <div class="col-sm-10">
                          <input class="form-control" type="text" name="takipno" value="<?php echo $sip['takipno']; ?>">
                          </div>
                          </div>
						
						
			             <?php if($_GET['duzenle']){?>
	                     <div class="form-group row">
                         <label for="example-text-input" class="col-sm-2 col-form-label">Yönetici Notu</label>
                         <div class="col-sm-10">
                         <input type="checkbox" id="ekdurum" <?php if($sip['firsat'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ekdurum"></div>                                      
                         </div>   
                         <?php } else { ?>
	                     <div class="form-group row">
                         <label for="example-text-input" class="col-sm-2 col-form-label">Yönetici Notu</label>
                         <div class="col-sm-10">
                         <input type="checkbox" id="ekdurum" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ekdurum"></div>
                         </div> 							
	                     <?php } ?>	
						
						 <div class="form-group row" id="eknot" style="<?php if($sip['ekdurum'] !== '1') {?> display:none; <?php } ?>">
                         <label for="example-text-input" class="col-sm-2 col-form-label">Sipariş Yönetici Notu</label>
                         <div class="col-sm-10">
                         <textarea id="textarea" class="form-control" rows="6" name="eknot"><?php echo $sip['eknot']; ?></textarea>  
                         </div>
                         </div>	
						
						
                
						  
						  
						  
						</div>




                         <button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>
                         
                   
						
				

			             
						 
						 </div>	
								
								
								
								
								
								
								
								
								
                            </div>
							</form>
                            
                        </div>
                    </div>
                </div> <!-- end col -->
	
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>
	<style>

.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.10rem
}

.card-header:first-child {
    border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
}

.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1)
}

.track {
    position: relative;
    background-color: #ddd;
    height: 7px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 60px;
    margin-top: 50px
}

.track .step {
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    width: 25%;
    margin-top: -18px;
    text-align: center;
    position: relative
}

.track .step.active:before {
    background: #FF5722
}

.track .step::before {
    height: 7px;
    position: absolute;
    content: "";
    width: 100%;
    left: 0;
    top: 18px
}

.track .step.active .icon {
    background: #ee5435;
    color: #fff
}

.track .icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    position: relative;
    border-radius: 100%;
    background: #ddd
}

.track .step.active .text {
    font-weight: 400;
    color: #000
}

.track .text {
    display: block;
    margin-top: 7px
}

.itemside {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 100%
}

.itemside .aside {
    position: relative;
    -ms-flex-negative: 0;
    flex-shrink: 0
}

.img-sm {
    width: 80px;
    height: 80px;
    padding: 7px
}

ul.row,
ul.row-sm {
    list-style: none;
    padding: 0
}

.itemside .info {
    padding-left: 15px;
    padding-right: 7px
}

.itemside .title {
    display: block;
    margin-bottom: 5px;
    color: #212529
}

p {
    margin-top: 0;
    margin-bottom: 1rem
}


b, strong {
    font-weight: 400;
    font-size: 13px;
}
.table td {

    padding: 4px !important;
	text-align: center !important;
	font-size: 14px;
}
.table .total-col {
    color: #c96;
    font-weight: 400;
    font-size: 14px;
}
.md-form.md-outline .form-control {
    padding: .375rem .75rem;
        padding-top: 0.375rem;
    padding-top: 10px;
}
</style>