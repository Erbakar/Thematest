<title>Hesabım</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Hesabım"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
<?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>


      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Hesabım</h2>
        </div>
    </section>
 
  <section class="profile pt-5 pb-5" style="margin-bottom:30px;">
            <div class="container-lg">
              
                <div class="row">
			<aside class="col-md-3 col-lg-3 sidebar" style="background: white;">
			
			<div class="top">
                            <img style="width: 100px;" src="<?php echo $sitetemasi;?>/assets/img/img-avatar.png" class="img-fluid" alt="">
                            <div class="name"><?php echo $uyebilgileri['isim'];?></div>
                            <div class="email"><?php echo $uyebilgileri['email'];?></div>
                        </div>
			<div class="nav">
                            <a id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Profilini Düzenle</a>
                            <a href="cikis/" class="border-end-0">Çıkış Yap</a>
                        </div>
			
	                			<ul style="display: flex;
flex-direction: column;
border-top: 1px solid #e8e9ea;" class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
								    <li class="nav-item">
								        <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Hesabım</a>
								    </li>
								     <li class="nav-item">
								        <a class="nav-link" id="tab-sip-link" data-toggle="tab" href="#tab-sip" role="tab" aria-controls="tab-sip" aria-selected="false">Siparişlerim</a>
								    </li>
									<li class="nav-item">
								        <a class="nav-link" id="tab-address-link2" data-toggle="tab" href="#tab-address2" role="tab" aria-controls="tab-address2" aria-selected="false">Destek Talebi Oluştur</a>
								    </li>
									   <li class="nav-item">
								        <a class="nav-link" id="tab-orders-link2" data-toggle="tab" href="#tab-orders2" role="tab" aria-controls="tab-orders2" aria-selected="false">Destek Merkezi</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads" role="tab" aria-controls="tab-downloads" aria-selected="false">Hediye Çeklerim</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">Adreslerim</a>
								    </li>
									
								    <li class="nav-item">
								        <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Üyelik Bilgilerim</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="cikis/">Çıkış Yap</a>
								    </li>
								</ul>
	                		</aside><!-- End .col-lg-3 -->

	                		<div class="col-md-9 col-lg-9 profile pb-5">
	                			<div class="tab-content">
								    <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
								    	
										
									<div class="card mb-xl-0 mb-lg-0 mb-md-5 mb-sm-5 mb-5">
                        <div class="card-header">
                            Hoşgeldin Sayın <?php echo $uyebilgileri['isim'];?>	
									
                        </div>
                        <div class="card-body">
                           	Dilersen buradan tüm siparişlerini görebilir, veya kayıtlı adreslerini görebilir veya düzenleyebilir , veya üyelik bilgilerini görüntüleyip güncelleyebilirsin..</p>
								    
                        </div>
                    </div>	
										
										
							



								   </div><!-- .End .tab-pane -->


		<div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
					<div class="card mb-xl-0 mb-lg-0 mb-md-5 mb-sm-5 mb-5">
                        <div class="card-header">
                           Hediye Çeklerim
                        </div>
                        <div class="card-body">
                            <ul class="orders">
                             
							 
							 
							   <?php 
		$uyeepostamiz = temizle($uyebilgileri['email']);
		$cekoku = $ozy->query("select * from kuponlar where durum='1' and sekil='1' and epostalar like '%$uyeepostamiz%' and gtarih>='$buguntarihim' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
		$__CEK__ = false;
        foreach ($cekoku as $tr) {
        $__CEK__ = true;
		
		
	
		?>	
                                <li class="d-flex align-items-center justify-content-between">
                                    <div class="r d-flex align-items-center">
                                        <span class="blue me-3">
                                           <?php echo $tr['adi']?>
                                        </span>
                                          <span class="status canceled  me-3" style="#eb4848">
										  <?php if($tr['tip']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">% <?php echo $tr['oran']?> Yüzde İndirim</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger"><?php echo $tr['oran']?> TL Normal İndirim</span>
                                    <?php } ?></span>
                                    </div>
                                    <div class="r d-flex align-items-center mt-xl-0 mt-lg-0 mt-md-0 mt-sm-4 mt-4">
                                        <span class="date me-3"><?php echo $tr['gtarih']?></span>
                                        <span class="status waiting me-3"><?php echo $tr['slimit']?> TL</span>
                                        <a class="btn-detail" style="background: #68c40c;
"><?php 
$uyeepostamiz2 = "".$tr['adi']."-".$uyebilgileri['email']."";
$ceksorgu = $ozy->prepare("SELECT COUNT(*) FROM kuponlar where durum='1' and sekil='1' and epostalar like '%$uyeepostamiz%' and gtarih>='$buguntarihim' and kullanildi like '%$uyeepostamiz2%' order by id DESC");
$ceksorgu->execute();
$ceksay = $ceksorgu->fetchColumn(); ?>
<?php if($ceksay=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Kullanıldı</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Kullanılmadı</span>
                                    <?php } ?>		     </a>
                                    </div>
                                </li>
								
                                <?php }
							
                            if (!$__CEK__){
								
                            echo "Malesef hesabınıza tanımlı herhangi bir hediye çeki bulunmamaktadır :(";
							
							}
							?>				
									
                            </ul>
                        </div>
                    </div>
									</div><!-- .End .tab-pane -->





			
								    <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
				
								<div class="card mb-xl-0 mb-lg-0 mb-md-5 mb-sm-5 mb-5">
                        <div class="card-header">
                            Adres Defteri
                        </div>
                        <div class="card-body">
                            <ul class="address">
							
							<?php 
		$adresoku = $ozy->query("select * from adreslerim where uyeid='{$uyeid}' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
		$__ADRES__ = false;
        foreach ($adresoku as $adres) {
        $__ADRES__ = true;
		
		
	
		?>				
 
                                <li class="d-flex align-items-center justify-content-between">
                                    <div class="r">
                                        <p>
                                            <?php echo $adres['adi'];?><br>
                                            <?php echo $adres['adres'];?><br>
                                            <?php echo $adres['il'];?> / <?php echo $adres['ilce'];?>
                                        </p>
                                    </div>
                                    <div class="r d-flex flex-column mt-xl-0 mt-lg-0 mt-md-0 mt-sm-5 mt-5">
                           
                                        <a onclick="return confirm('Silmek istediğinize emin misiniz ?')" href="<?php echo $url;?>/hesabim/?adressil=<?php echo $adres['id'];?>" class="red">Adresi Sil</a>
                                    </div>
                                </li>
                                
								 <?php }
							
                            if (!$__ADRES__){
								
                            echo "&nbsp;&nbsp;Malesef hesabınıza tanımlı herhangi bir adres bulunamadı :(";
							
							}
							?>								
									
								
								
                            </ul>
							
							
									    				<div class="card-body" style="padding:2px !important;">
								    					
                            <form action="" method="POST">
						
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
							
                            <input  placeholder="Adres Adı" name="adi" type="text" class="form-control" required>
                           
                            </div>
				            </div>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
							
                            <textarea placeholder="Adresiniz" style="height:200px;" name="adres" class="form-control" cols="30" rows="4" placeholder="" required></textarea>
                           
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline" style="width: 48%;float: left;">
							
                            <select name="il" id="sehir" class="form-control" required>
							<option>İl Seçiniz</option>
							<?php foreach($sehir as $key => $val){?>
                            <option value="<?=$val;?>"><?=$val;?></option>
                            <?php }?>
							</select>
                           
                            </div>
							<div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;">
                           
						   <input placeholder="İlçe" name="ilce" type="text"   class="form-control" required>
                           
                            </div>
				            </div>
									   								   
									
														
							</div><!-- End .card-body -->
							<button type="submit" name="adresekle" class="newaddress">
                            <span>ADRES EKLE</span>
                           
                            </button>
                                     
							</form>
                           
							
							
							
							
							
							
                        </div>
                    </div>
										
										
								    </div><!-- .End .tab-pane -->
									
									
												
							<div class="tab-pane fade" id="tab-address2" role="tabpanel" aria-labelledby="tab-address-link2">
				
							<div class="row">	
							<div class="col-lg-12">
							<div class="card card-dashboard">
							<div class="card-header">
                            Destek Talebi Oluştur
                        </div>
							<div class="card-body" style="padding:20px !important;">    					
                            <form action="" method="POST">
						
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
							
							<select name="siparisno" class="form-control" required>
                            <option value="Genel Destek Talebi">Genel Destek Talebi</option>
                            <?php $ss = $ozy->query("select * from siparis where uye='{$uyeid}' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
							foreach($ss as $tt){?>
							<option value="<?php echo $tt['siparisno']; ?>"><?php echo $tt['siparisno']; ?></option>
							<?php } ?>	
							</select>
                           
                            </div>
				            </div>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
							
                            <input placeholder="Konu" name="konu" class="form-control" type="text" required>
                            
                            </div>
				            </div>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
							<textarea placeholder="Mesajınız" name="mesaj" class="form-control" cols="30" rows="4" placeholder="" required></textarea>
                           
                            </div>
				            </div>
									   								   
									
														
							</div><!-- End .card-body -->
							<button type="submit" name="destekekle" class="gonderbuton">
                            <span>DESTEK TALEBİNİ GÖNDER</span>
                            <i class="icon-long-arrow-right"></i>
                            </button>
                                     
							</form>
													
													
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->
												
								
	
											
											
								    	</div><!-- End .row -->
										
										
										
								    </div><!-- .End .tab-pane -->

									
											

								    <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
								    	<form action="" method="POST">
			                				<div class="row">
		                    <div class="col-sm-12">			
						    <div class="md-form md-outline">
							 
                            <input placeholder="Adınız Soyadınız" name="isim" type="text" id="form15" class="form-control"  onblur="this.value.split(' ').length < 2 ? alert('Adınızı ve Soyadınızı eksiksiz girmelisiniz.') : '';"  value="<?php echo $uyebilgileri['isim'];?>">
                          
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
							
                            <input placeholder="Telefon Numaranız" name="telefon" type="tel"   class="form-control" value="<?php echo $uyebilgileri['telefon'];?>">
                            
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
							
                            <input placeholder="Eposta Adresiniz" name="email" type="email"   class="form-control" value="<?php echo $uyebilgileri['email'];?>">
                           
                            </div>
				            </div>
		                	
							
								 <div class="col-lg-6">
                                    <div class="form-radio" style="background: #fffdfd;
padding: 10px;
margin-top: 10px;
border-radius: 6px;
border: 1px solid #3fbafe;">
                                        <input class="form-check-input"  <?php echo $uyebilgileri['uyetip'] == '0' ? 'checked' : null; ?> value="0" name="uyetip" type="radio" id="kargo1" required>
                                        <label class="form-check-label" for="kargo1">
                                           Bireysel
                                        </label>
                                    </div>
                                </div>
								
								 <div class="col-lg-6">
                                            <div class="form-radio" style="background: #fffdfd;
padding: 10px;
margin-top: 10px;
border-radius: 6px;
border: 1px solid #3fbafe;">
                                    <div class="form-radio mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                        <input <?php echo $uyebilgileri['uyetip'] == '1' ? 'checked' : null; ?> class="form-check-input" value="1" name="uyetip" type="radio" id="kargo2" required>
                                        <label class="form-check-label" for="kargo2">
                                            Kurumsal
                                        </label>
                                    </div>
                                </div>
                                </div>
								
								
                                <div class="col-md-12 mt-3" id="bireysel">
                                 <input value="<?php echo $uyebilgileri['tc'];?>" name="tc" type="text"  class="form-control" size="11" maxlength="11" value="<?php echo $uyebilgileri['tc'];?>" placeholder="T.C. Numaranız">
								 </div>
								 
								 <div class="col-md-12 mt-3" id="kurumsal" style="display:none;margin-bottom:10px;">
                                  <input value="<?php echo $uyebilgileri['vergi1'];?>" name="vergi1" value="<?php echo $uyebilgileri['vergi1'];?>" type="text"  class="form-control" placeholder="Firma Adı">
								  </div>
                              
								  <div class="col-md-6" id="kurumsal2" style="display:none;">
                                 <input value="<?php echo $uyebilgileri['vergi2'];?>" name="vergi2" value="<?php echo $uyebilgileri['vergi2'];?>" type="text"  class="form-control" placeholder="Vergi Dairesi Adı">
								  </div>
                              
								  <div class="col-md-6" id="kurumsal3" style="display:none;">
                                 <input value="<?php echo $uyebilgileri['vergi3'];?>" name="vergi3" value="<?php echo $uyebilgileri['vergi3'];?>" type="text"  class="form-control" placeholder="Vergi No">
								  </div>
								 
							
							
						
							
							
							
							 <div class="col-md-12">
							    <div class="form-radio" style="background: #fffdfd;
padding: 10px;
margin-top: 10px;
border-radius: 6px;
border: 1px solid #3fbafe;">
                                    <div class="form-radio mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                        <input class="form-check-input" value="1" name="sifretip" type="radio" id="kargo244">
                                        <label class="form-check-label" for="kargo244">
                                           Şifremi Güncellemek istiyorum
                                        </label>
                                    </div>
                                </div>
							 </div>
							
							
							<div class="col-sm-12" id="sifre1" style="display:none;">			
						    <div class="md-form md-outline">
							<input name="sifre" placeholder="Yeni Şifreniz" type="password"  class="form-control">
                           
                            </div>
				            </div>
							
							
		            						<div class="col-sm-12">
		                					<button type="submit" name="uyeguncelle" class="gonderbuton">
			                					<span>BİLGİLERİMİ GÜNCELLE</span>
			            						
			                				</button>
											 </div>
			                			</form>
								    </div><!-- .End .tab-pane -->
								</div>
								
								
								
								
		
    
					
						<div class="tab-pane fade" id="tab-sip" role="tabpanel" aria-labelledby="tab-sip-link">
				
				
				
					 <div class="card mb-xl-0 mb-lg-0 mb-md-5 mb-sm-5 mb-5">
                        <div class="card-header">
                            Sipariş Geçmişim
                        </div>
                        <div class="card-body">
                            <ul class="orders">
							<?php 

     
        $pages = intval(temizle(@$_GET['pages']));
        if (!$pages) {
          $pages = 1;
        }
        
        $bak = $ozy->prepare("select * from siparis where onay='1' and uye=?");
        $bak->execute(array($uyeid));
        $toplam= $bak->rowCount();
        $limit = 100000;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 200;
		
	
	
        $pr = $ozy->query("select * from siparis where onay='1' and uye='{$uyeid}' order by id DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
        



        $__URUN__ = false;
       foreach ($pr as $sip) {
        $__URUN__ = true;

        ?>
							
							
                                <li class="d-flex align-items-center justify-content-between">
                                    <div class="r d-flex align-items-center">
                                        <span class="blue me-3">
                                           <?php echo $sip['siparisno'];?>
                                        </span>
                                        <span class="count"><?php 
										
										
       $sayac =0;
	   $ss= $sip['urunid'];
       $verit = explode(',', $ss);
       foreach($verit as $item){
	
        $sayac++;
       }
      
    
										
										
										
										echo $sayac;?> Ürün</span>
                                    </div>
                                    <div class="r d-flex align-items-center mt-xl-0 mt-lg-0 mt-md-0 mt-sm-4 mt-4">
                                        <span class="date me-3"><?php echo $sip['tarih'];?></span>
									
                                        <span class="status completed me-3"><?php echo $sip['durum'];?></span>
                                        <a class="btn-detail accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $sip['siparisno'];?>">Siparişi görüntüle</a>
                                    </div>
                                </li>
								
								
								
								
			<div id="collapse<?php echo $sip['siparisno'];?>" class="panel-collapse collapse">
            <div class="col-12">

    <article class="card" style="text-align: center;">
       
        <div class="card-body">
            <h6 style="margin-bottom:10px;">Sipariş Kodunuz : <?php echo $sip['siparisno'];?></h6>
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
                <div class="step <?php echo $sip['durum'] == 'Sipariş Onaylandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Hazırlandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Siparişiniz Onaylandı</span> </div>
                <div class="step <?php echo $sip['durum'] == 'Sipariş Hazırlandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="ri-user-line"></i> </span> <span class="text"> Siparişiniz Hazırlanıyor</span> </div>
                <div class="step <?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="ri-truck-line"></i> </span> <span class="text"> Kargoya Verildi </span> </div>
                <div class="step <?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="ri-home-line"></i> </span> <span class="text">Siparişiniz Tamamlandı</span> </div>
            </div>
            <hr>
       </div>
    </article>


				
			
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12" id="divYazdir" style="padding-left: 50px;">
                                    <div class="invoice-title">
                                        <h4 class="float-right font-12"><strong style="font-weight: 400;font-size: 14px;line-height: 70px;">Sipariş Kodu : <?php echo $sip['siparisno'];?></strong></h4>
                                        <h3 class="m-t-0" style="margin-bottom: -15px !important;">
                                            <img src="resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="logo" height="24">
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
									
									<div class="row" style="text-align: center;padding: 10px;border-radius: 4px;">
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
                         
                                    <div class="panel panel-default" style="margin-left: -2% !important;
width: 98%;border: 1px solid #f2f2f2;padding: 5px;">
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
													
													<?php if($sip['havaleindirimtutari']!='0'){?>
                                                
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
                                                        <td class="no-line text-right"><h4 class="m-0" style="color: #12c872;
font-weight: bold;
font-size: 18px;"><?php echo fiyatgoster($sip['toplamtutar']);?></h4></td>
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
			
			
			</div>
                              
					<?php }

                        if (!$__URUN__){
                            echo '
							
						              <p> Henüz bir siparişiniz bulunmamaktadır.</p>
								    	<a href="'.$url.'" class="btn btn-outline-primary-2"><span>ŞİMDİ SİPARİŞ OLUŞTURMAK İSTER MİSİNİZ ?</span><i class="icon-long-arrow-right"></i></a>
								    
										
							
							
							';
                        }

                         ?>	
								  
                            </ul>
                        </div>
                    </div>
									</div><!-- .End .tab-pane -->



	
					
					
						<div class="tab-pane fade" id="tab-orders2" role="tabpanel" aria-labelledby="tab-orders-link2">
								    	
			 <div class="panel-group" id="accordion">
             <div class="card-header">
                            Destek Merkezi
                        </div>
 	
 		<?php 
		$desoku = $ozy->query("select * from support where uye='{$uyeid}' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
		$__DESTEK__ = false;
        foreach ($desoku as $destek) {
        $__DESTEK__ = true;
		$destekid = $destek["id"];
		$ticketsor = $ozy->query("select * from support_reply where destekid='{$destekid}'")->fetch(PDO::FETCH_ASSOC);
	
		?>		
	
      
 
 
 
 <div style="padding: 4px; border: 1px solid #f6f6f6;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title" style="margin-top: 10px;">
                    <a style="font-size: 15px;
margin-top: 10px;
color: #888181;
font-weight: 500;
padding: 20px;
display: block;" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsedestek<?php echo $ticketsor['mid'];?>">
					Destek Kodu : <b>#<?php echo $ticketsor['mid']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;Sipariş No : <b><?php echo $ticketsor['siparisno']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</b> Konu : <b><?php echo $ticketsor['konu'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;Destek Durumu : <b> 				
					                            <?php echo $destek['durum'] == '0' ? '<span class="label label-danger " >Okunmadı</span>' : null; ?>
												<?php echo $destek['durum'] == '1' ? '<span class="label label-success " >Okundu</span>' : null; ?>
												<?php echo $destek['durum'] == '2' ? '<span class="label label-success " >Cevaplandı</span>' : null; ?>
												<?php echo $destek['durum'] == '3' ? '<span class="label label-info " >Kapatıldı</span>' : null; ?>
								</h4></td> 

					</b></a>
                </h4>
            </div>
			<div id="collapsedestek<?php echo $ticketsor['mid'];?>" class="panel-collapse collapse">
            <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12" id="divYazdir">
                                    <div class="invoice-title">
                                        <h4 class="float-right font-12"><strong style="font-weight: 400;font-size: 14px;line-height: 70px;">Sipariş Kodu : <?php echo $ticketsor['siparisno']; ?></strong></h4>
                                        <h3 class="m-t-0" style="margin-bottom: -15px !important;">
                                            <img style="width: 250px;
height: 100px;" src="resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="logo" height="24">
                                        </h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                        <?php $altdestek = $ozy->query("select * from support_reply where destekid='{$destekid}' order by id asc")->fetchAll(PDO::FETCH_ASSOC); 
					    foreach($altdestek as $kdestek){?>

						<div class="comment-item" style="border: 1px solid #e4e4e4;padding: 10px;">
						<div class="head">
                        <?php if($kdestek['uye'] =="00"){?>
                        <div style="border:1px solid;padding:10px;">
						<span class="name"><img style="    max-width: 120px;margin-bottom: 20px;" src="resimler/siteayarlari/<?php echo $ayar['logo']; ?>"></span>  
                        <span class="time" style="float:right;margin-top: 60px;"> Gönderilme Tarihi <?php echo $kdestek['tarih']; ?></span>
                        </br>
						<p class="comment" style="margin-top: -10px;margin-bottom: 50px;font-weight: 600;"><?php echo $kdestek['mesaj']; ?></p>
						</div>
						</div>
						</div>
					    <?php }else {?>
						<span class="name"><b><?php echo $uyebilgileri['isim']; ?> </b></span>  </br>
						<span class="time" style="float: right;"> Gönderilme Tarihi <?php echo $kdestek['tarih']; ?></span>
					</br>
				</div>
				<p class="comment"><?php echo $kdestek['mesaj']; ?></p>
			    </div>
		        <?php }}?>


                                        </div>
                                       
                                       
                                    </div>
                         
            <div class="panel panel-default" style="border: 1px solid #f2f2f2;padding: 5px;">
            <form action="" method="post">
		    <div class="login-form">
			<textarea name="mesaj"  class="form-control" cols="30" rows="4" id="cmessage" required></textarea>

			<input type="hidden" name="uye" value="<?php echo $uyid; ?>">
			<input type="hidden" name="destekid" value="<?php echo $ticketsor['destekid']; ?>">
			<input type="hidden" name="siparisno" value="<?php echo $ticketsor['siparisno']; ?>">
			<input type="hidden" name="konu" value="<?php echo $ticketsor['konu']; ?>">
			<input type="hidden" name="mid" value="<?php echo $ticketsor['mid']; ?>">
			<input type="hidden" name="email" value="<?php echo $ticketsor['email']; ?>">
			<?php 
			$newid = $ticketsor['destekid'];
			$dee = $ozy->query("select * from support where id='{$newid}' limit 1")->fetchAll(PDO::FETCH_ASSOC); 
			foreach($dee as $see){?>
				
				
				<?php if($see['durum'] =="3"){?>

					<div class="group-button" >
						<b class="gonderbuton">DESTEK KAPATILDIĞI İÇİN CEVAP VERİLEMEZ</b>
					</div>
				<?php }else {?>
					<div class="group-button" >
						<button class="gonderbuton" type="submit" name="destekcevapla">CEVAPLA</button>
					</div>
				<?php }} ?>


			</div>


		</form>

                                    </div>

                                </div>
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div>
			
			
			</div>
			
										
			   <?php }

                        if (!$__DESTEK__){
                            echo '
							
						              <p> Henüz bir destek talebiniz bulunmamaktadır.</p>
								    	<a href="'.$url.'/hesabim/" class="btn btn-outline-primary-2"><span>ŞİMDİ DESTEK TALEBİ OLUŞTURMAK İSTER MİSİNİZ ?</span><i class="icon-long-arrow-right"></i></a>
								    
										
							
							
							';
                        }

                         ?>	
			
			
			
        </div>
       </div>
					
					
			
			
			
			




                </div>
                </div>
			     </div>
            </div>
        </section>
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
    border: none !important;
    border-radius: 0.10rem
}

.card-header:first-child {
 font-size: 18px;
font-weight: 600;
text-align: left;
color: #1f2430;
border-bottom: 1px solid #e8e9ea;
padding: 30px;
background-color: transparent;
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
    background: #ddd;
    line-height: 40px;
    font-size: 20px;
    padding-top: 10px;

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

.btn-warning {
    color: #ffffff;
    background-color: #ee5435;
    border-color: #ee5435;
    border-radius: 1px
}

.btn-warning:hover {
    color: #ffffff;
    background-color: #ff2b00;
    border-color: #ff2b00;
    border-radius: 1px
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

color: #12c872;
font-weight: bold;
font-size: 15px;
}
.md-form.md-outline .form-control {
    padding: .375rem .75rem;
    padding-top: 0.375rem;
}



.show {
    display: block !important;
    opacity: 1;
}

.tab-content {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 20px;
    background: white;
}


.panel-default > .panel-heading .badge {
    color: #fff;
    background-color: <?php echo $tema['t37'] ?> !important;
}
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
    border-radius: 0.10rem;
    padding: 1px;
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
b, strong {
  font-weight: 600 !important;
  font-size: 13px;
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
    background: #ddd;
    line-height: 20px;
    font-size: 20px;
    padding-top: 10px;

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

.btn-warning {
    color: #ffffff;
    background-color: #ee5435;
    border-color: #ee5435;
    border-radius: 1px
}

.btn-warning:hover {
    color: #ffffff;
    background-color: #ff2b00;
    border-color: #ff2b00;
    border-radius: 1px
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

.md-form.md-outline .form-control {
    padding: .375rem .75rem;
        padding-top: 0.375rem;
margin-bottom: 0px !important;
}

.no-gutters {
 margin-left:0;
 margin-right:0
}
.no-gutters>.col,
.no-gutters>[class*=col-] {
 padding-left:0;
 padding-right:0
}

.page-wrapper {
 position:relative;
 display:flex;
 flex-direction:column;
 min-height:100%;
 transition:transform 0.4s ease
}
.mmenu-active .page-wrapper {
 transform:translateX(200px)
}



.fade {
    opacity: 1 !important;
    -webkit-transition: opacity .15s linear;
    -o-transition: opacity .15s linear;
    transition: opacity .15s linear;
}
h3 {
  font-size: 16px !important;
}
.fade {
  opacity: 1;
  transition: opacity .15s linear;
}
.nav-item .nav-link, .nav-item .nav-separtor {
  font-size: 16px;
  font-weight: 500;
  text-align: left;
  color: #8d94a6;
  border-bottom: 1px solid #e8e9ea;
  width: 100%;
  display: flex;
  padding: 18px 28px;
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
}
#divYazdir{

  margin: 0px;
  padding:20px;
}
.btn {

border-style: solid !important;
border-width: 1px !important;
border-color: <?php echo $tema['t37'] ?> !important;
background-color: <?php echo $tema['t37'] ?> !important;
color: white !important;
font-size: 13px !important;
font-weight: 500 !important;
text-align: center !important;

}

.btn-outline-primary-2{
margin-top:10px;
}
.md-form{
margin-top:10px;
}


.nav-item {



}

.panel-heading {
background: #f6f6f6;
line-height: 1px;
}
.link-block {

    color: #fff;
    font-size: 12px !important;

}


p {
  margin-top: 0;
  margin-bottom: 1rem;
  font-size: 13px !important;
}
.time {
float: right;
margin-top: 0px !important;
font-size: 12px;
}

.table-responsive {
  min-height: .01%;
  overflow-x: auto;
  background: none !important;
}
@media (min-width: 1200px){
.col-6 {
  width: 45%;
}

.col-6{
  float: left;
}
}
.col {
padding-left: 25px;
padding-right: 25px;
}



a {
  color: #4e5154;
  text-decoration: none !important;
  font-size: 12px;
}

.kutu {
background: #e7e7e7;
padding: 15px;
  padding-top: 15px;
  padding-right: 15px;
  padding-bottom: 15px;
  padding-left: 15px;
margin-bottom: 10px;
font-size: 13px;
font-weight: bold;
border-radius: 4px;
}


.product{
height: auto !important;
}
.product-title{
background: none !important;
}




</style>


<script src="<?php echo $sitetemasi;?>/user/jquery.min.js"></script>
<script src="<?php echo $sitetemasi;?>/user/bootstrap.bundle.min.js"></script>

		
<?php } else { ?>	
<meta http-equiv="refresh" content="0; url='<?php echo $url;?>">
<?php } ?>