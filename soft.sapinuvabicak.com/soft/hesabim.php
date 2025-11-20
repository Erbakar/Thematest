<title>Hesabım</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
<?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>

	
		   <main class="main" style="margin-top: 10px;">
       
       
		
						
<div class="page-content">
            	<div class="dashboard">
	                <div class="container">
	                	<div class="row">
	                		<aside class="col-md-2 col-lg-2">
	                			<ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
								    <li class="nav-item">
								        <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Hesabım</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Siparişlerim</a>
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

	                		<div class="col-md-10 col-lg-10">
	                			<div class="tab-content">
								    <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
								    	<p>Hoşgeldin Sayın <span class="font-weight-normal text-dark" style="text-transform: capitalize;"><?php echo $uyebilgileri['isim'];?></span> 
								    	<br>
								    	Dilersen buradan tüm siparişlerini görebilir veya kayıtlı adreslerini görebilir veya düzenleyebilir  veya üyelik bilgilerini görüntüleyip güncelleyebilirsin.</p>
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
								    	
			 <div class="panel-group" id="accordion">
             <div class="faqHeader" style="background: #f6f6f6;color: #777;padding: 5px;text-align: center;font-weight: 500;font-size: 15px;border: 1px solid #ece5e5;">Siparişlerim</div>
 
 	
 		<?php 

     
        $pages = intval(temizle(@$_GET['pages']));
        if (!$pages) {
          $pages = 1;
        }
        
        $bak = $ozy->prepare("select * from siparis where onay='1' and uye=?");
        $bak->execute(array($uyeid));
        $toplam= $bak->rowCount();
        $limit = 10;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 200;
		
	
	
        $pr = $ozy->query("select * from siparis where onay='1' and uye='{$uyeid}' order by id DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
        



        $__URUN__ = false;
       foreach ($pr as $sip) {
        $__URUN__ = true;

                           ?>
 
 
 
 <div style="border: 1px solid #f6f6f6;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title" style="margin-top: 10px;">
                    <a style="font-size: 14px;margin-top: 10px;color: #888181;font-weight: 500;" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $sip['siparisno'];?>">
					Sipariş Kodu : <b><?php echo $sip['siparisno'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;Ödeme Yöntemi : <b><?php echo $sip['odemetipi'];?>&nbsp;&nbsp;&nbsp;&nbsp;</b> Ödenen Tutar : <b><?php echo $sip['toplamtutar'];?> TL</b>&nbsp;&nbsp;&nbsp;&nbsp;Sipariş Durumu : <b><span style="font-size: 13px;" class="badge badge-success"><?php echo $sip['durum'];?></span></b></a>
                </h4>
            </div>
			<div id="collapse<?php echo $sip['siparisno'];?>" class="panel-collapse collapse">
            <div class="col-12">

    <article class="card">
       
        <div class="card-body">
            <h6 style="padding: 10px;">Sipariş Kodunuz : <?php echo $sip['siparisno'];?></h6>
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
                <div class="step <?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-home"></i> </span> <span class="text">Siparişiniz Tamamlandı</span> </div>
            </div>
            <hr>
       </div>
    </article>


				
			
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12" id="divYazdir">
                                    <div class="invoice-title">
                                        <h4 class="float-right font-12"><strong style="font-weight: 400;font-size: 14px;line-height: 70px;">Sipariş Kodu : <?php echo $sip['siparisno'];?></strong></h4>
                                        <h3 class="m-t-0" style="margin-bottom: -15px !important;">
                                            <img style="width: 200px;height:80px;" src="resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="logo" height="24">
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
									
									<div class="row" style="margin:auto;margin: auto;
background: <?php echo $tema['t8']; ?>;
color: white;
text-align: center;
padding: 10px;">
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
														
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                         <strong>Aratutar :</strong></td>
                                                        <td class="thick-line text-right"><?php echo fiyatgoster($sip['aratutar']);?></td>
                                                    </tr>
													  <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
													
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                        <strong>KDV Bedeli :</strong></td>
                                                        <td class="thick-line text-right"><?php echo fiyatgoster($sip['kdvtutari']);?></td>
                                                    </tr>
													
													 <tr>
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
													
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                           <strong style="color:red;">Kupon Bedeli :</strong></td>
                                                        <td class="thick-line text-right">- <?php echo fiyatgoster($sip['kupontutari']);?></td>
                                                    </tr>	
                                                    <?php } ?>
													<?php if($sip['cekid']!='0'){?>
                                                
												    <tr>
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
														
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                           <strong style="color:red;">Havale/EFT İndirim Bedeli :</strong></td>
                                                        <td class="thick-line text-right">- <?php echo fiyatgoster($sip['havaleindirimtutari']);?></td>
                                                    </tr>	
                                                    <?php } ?>
													
													
                                                  
                                                    <tr>
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
                                                 <a class="butonok btn btn-primary waves-effect waves-light" href="javascript:printDiv('divYazdir');">Siparişi Yazdır</a>
												
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
								
    </div>
										
		
									
									
							
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
						<?php $geri = $_GET['pages']-1;?>
                            <li class="page-item  <?php echo $_GET['pages'] == '1' ? 'disabled' : null; ?>">
                                <a class="page-link page-link-prev" href="hesabim/?pages=<?php echo $geri;?>" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Geri
                                </a>
                            </li>
							 <?php
                for ($i= $pages - $forlimit ; $i < $pages + $forlimit + 1 ; $i++) { 
                  if ($i>0 and $i<=$sayfasayisi) {
                    
                    if ($i == $pages) {
          
                  echo "<li class='page-item active' aria-current='page'><a class='page-link'>".$i."</a></li>
				 
				  ";
                                      
                             }else{
          
                  echo "<li class='page-item'><a class='page-link' href='hesabim/?pages=".$i."'>".$i."</a></li>";
          
          }

                  }
                }
          
          
          
          
                   ?> 
             
						
                      
							
                            <li class="page-item">
							<?php $ileri = 1+$_GET['pages'];?>
                                <a class="page-link page-link-next" href="hesabim/?pages=<?php echo $ileri;?>" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                   İleri <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>		
									
									
									
									
									
									</div><!-- .End .tab-pane -->









				    <div class="tab-pane fade" id="tab-orders2" role="tabpanel" aria-labelledby="tab-orders-link2">
								    	
			 <div class="panel-group" id="accordion">
             <div class="faqHeader" style="background: #f6f6f6;color: #777;padding: 5px;text-align: center;font-weight: 500;font-size: 15px;border: 1px solid #ece5e5;">Destek Merkezi</div>
 
 	
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
                    <a style="font-size: 14px;margin-top: 10px;color: #888181;font-weight: 500;padding-left: 60px;" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsedestek<?php echo $ticketsor['mid'];?>">
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
                                            <img style="width: 200px;" src="resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="logo" height="24">
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
                        <div style="border:1px solid;padding:10px;border-radius:5px;">
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
			<textarea name="mesaj" style="min-height:200px;" class="form-control" cols="30" rows="4" id="cmessage" required></textarea>

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
						<b class="butonok btn btn-outline-primary-2 btn-minwidth-sm">DESTEK KAPATILDIĞI İÇİN CEVAP VERİLEMEZ</b>
					</div>
				<?php }else {?>
					<div class="group-button" >
						<button class="butonok btn btn-outline-primary-2 btn-minwidth-sm" type="submit" name="destekcevapla">CEVAPLA</button>
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
        </div>
       </div>
    
												
										
			   <?php }

                        if (!$__DESTEK__){
                            echo '
							
						              <p> Henüz bir destek talebiniz bulunmamaktadır.</p>
								    	<a href="'.$url.'/hesabim/" class="butonok btn btn-outline-primary-2"><span>ŞİMDİ DESTEK TALEBİ OLUŞTURMAK İSTER MİSİNİZ ?</span><i class="icon-long-arrow-right"></i></a>
								    
										
							
							
							';
                        }

                         ?>							
								
    </div>
										
		
				
									
									
									
									
									</div><!-- .End .tab-pane -->


















								    <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
								    	<div class="tab-pane fade active show" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
								    	
			 <div class="panel-group" id="accordion">
             <div class="faqHeader" style="background: #f6f6f6;color: #777;padding: 5px;text-align: center;font-weight: 500;font-size: 15px;border: 1px solid #ece5e5;">Hediye Çeklerim</div>
 

                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th style="text-align: center;">Hediye Çeki Kodu</th>
                                    <th style="text-align: center;">Hediye Çeki Tipi</th>
									<th style="text-align: center;">Geçerlilik  Tarihi</th>
									<th style="text-align: center;">Sepet Limiti</th>
                                    <th style="text-align: center;">Durumu</th>
                                   
                                </tr>
                                </thead>


                                <tbody>
								
	    <?php 
		$uyeepostamiz = temizle($uyebilgileri['email']);
		$cekoku = $ozy->query("select * from kuponlar where durum='1' and sekil='1' and epostalar like '%$uyeepostamiz%' and gtarih>='$buguntarihim' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
		$__CEK__ = false;
        foreach ($cekoku as $tr) {
        $__CEK__ = true;
		
		
	
		?>				
 
			 
                                <tr>
                                    <td><?php echo $tr['adi']?></td>
									
                                    <td>
									<?php if($tr['tip']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">% <?php echo $tr['oran']?> Yüzde İndirim</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger"><?php echo $tr['oran']?> TL Normal İndirim</span>
                                    <?php } ?>
									</td>
									<td><?php echo $tr['gtarih']?></td>

									<td><?php echo $tr['slimit']?> TL</td>
		
<?php 
$uyeepostamiz2 = "".$tr['adi']."-".$uyebilgileri['email']."";
$ceksorgu = $ozy->prepare("SELECT COUNT(*) FROM kuponlar where durum='1' and sekil='1' and epostalar like '%$uyeepostamiz%' and gtarih>='$buguntarihim' and kullanildi like '%$uyeepostamiz2%' order by id DESC");
$ceksorgu->execute();
$ceksay = $ceksorgu->fetchColumn(); ?>
		           
									<td>
									<?php if($ceksay=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Kullanıldı</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Kullanılmadı</span>
                                    <?php } ?>
									</td>
									
							
                                   
                                </tr>
                               
		                   <?php }
							
                            if (!$__CEK__){
								
                            echo "Malesef hesabınıza tanımlı herhangi bir hediye çeki bulunmamaktadır :(";
							
							}
							?>				
									
							   
							   
                                </tbody>
                            </table>






				
								
    </div>
										
		
									
									
						
									
									
									
									
									</div>
									
									
									</div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
				
								    	<div class="row">
										
									
								    		<div class="col-lg-6">
								    			<div class="card card-dashboard">
												<h3 class="card-title" style="text-align: center;margin-top: 20px;">Adres Ekle</h3><!-- End .card-title -->
								    				<div class="card-body" style="padding:2px !important;">
								    					
                            <form action="" method="POST">
						
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <input name="adi" type="text" class="form-control" required>
                            <label for="form15" class="active">Adres Adı</label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <textarea name="adres" style="min-height:200px;" class="form-control" cols="30" rows="4" placeholder="" required></textarea>
                            <label for="form15" class="active">Adresiniz</label>
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline" style="width: 48%;float: left;">
                            <select name="il" id="sehir" class="form-control" required>
							<?php foreach($sehir as $key => $val){?>
                            <option value="<?=$val;?>"><?=$val;?></option>
                            <?php }?>
							</select>
                            <label for="form15" class="active">İl</label>
                            </div>
							<div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;">
                            <input name="ilce" type="text"   class="form-control" required>
                            <label for="form15" class="active">İlçe</label>
                            </div>
				            </div>
									   								   
									
														
							</div><!-- End .card-body -->
							<button type="submit" name="adresekle" class="butonok btn btn-outline-primary-2">
                            <span>ADRES EKLE</span>
                            <i class="icon-long-arrow-right"></i>
                            </button>
                                     
							</form>
													
													
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->
												
										
										
										
										
										
										
										
										
										
										
		<?php 
		$adresoku = $ozy->query("select * from adreslerim where uyeid='{$uyeid}' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
		$__ADRES__ = false;
        foreach ($adresoku as $adres) {
        $__ADRES__ = true;
		
		
	
		?>				
 
										
								    		<div class="col-lg-6">
								    			<div class="card card-dashboard">
								    				<div class="card-body">
								    					<h3 class="card-title"><?php echo $adres['adi'];?></h3><!-- End .card-title -->
														<?php echo $adres['adres'];?><br>
														<?php echo $adres['il'];?><br>
														<?php echo $adres['ilce'];?><br>
														<a onclick="return confirm('Silmek istediğinize emin misiniz ?')" href="<?php echo $url;?>/hesabim/?adressil=<?php echo $adres['id'];?>">Adresi Sil <i class="icon-edit"></i></a></p>
								    				</div><!-- End .card-body -->
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->
											
											
				   <?php }
							
                            if (!$__ADRES__){
								
                            echo "Malesef hesabınıza tanımlı herhangi bir adres bulunamadı :(";
							
							}
							?>								
											

											
											
											
								    	</div><!-- End .row -->
										
										
										
								    </div><!-- .End .tab-pane -->
									
									
									
									
									
							<div class="tab-pane fade" id="tab-address2" role="tabpanel" aria-labelledby="tab-address-link2">
				
							<div class="row">	
							<div class="col-lg-12">
							<div class="card card-dashboard">
							<h3 class="card-title" style="text-align: center;margin-top: 20px;">Destek Talebi Oluştur</h3><!-- End .card-title -->
							<div class="card-body" style="padding:2px !important;">    					
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
                            <label for="form15" class="active">Sipariş Numaranız</label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <input name="konu" class="form-control" type="text" required>
                            <label for="form15" class="active">Konu</label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <textarea name="mesaj" style="min-height:200px;" class="form-control" cols="30" rows="4" placeholder="" required></textarea>
                            <label for="form15" class="active">Mesajınız</label>
                            </div>
				            </div>
									   								   
									
														
							</div><!-- End .card-body -->
							<button type="submit" name="destekekle" class="butonok btn btn-outline-primary-2">
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
                            <input name="isim" type="text" id="form15" class="form-control"  onblur="this.value.split(' ').length < 2 ? alert('Adınızı ve Soyadınızı eksiksiz girmelisiniz.') : '';"  value="<?php echo $uyebilgileri['isim'];?>">
                            <label for="form15" class="active">Adınız Soyadınız</label>
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <input name="telefon" type="tel"   class="form-control" value="<?php echo $uyebilgileri['telefon'];?>">
                            <label for="form15" class="active">Telefon Numaranız</label>
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <input name="email" type="email"   class="form-control" value="<?php echo $uyebilgileri['email'];?>">
                            <label for="form15" class="active">Eposta Adresiniz</label>
                            </div>
				            </div>
		                	
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline" style="width: 48%;float: left;">
						    <div class="kutu">
							<input <?php echo $uyebilgileri['uyetip'] == '0' ? 'checked' : null; ?> value="0" name="uyetip" type="radio" class="login-check" id="register-check-20" required> 
							Bireysel
						    </div>
                            <label for="form15" class="active">Fatura Bilgisi</label>
                            </div>
				            <div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;">
						    <div class="kutu">
							<input <?php echo $uyebilgileri['uyetip'] == '1' ? 'checked' : null; ?> value="1" name="uyetip" type="radio" class="login-check" id="register-check-20" required> 
							Kurumsal
						    </div>
                            <label for="form15" class="active">Fatura Bilgisi</label>
                            </div>
				            </div>
							
							
							
							<div class="col-sm-12" id="bireysel">			
						    <div class="md-form md-outline">
                            <input name="tc" type="text"  class="form-control" size="11" maxlength="11" value="<?php echo $uyebilgileri['tc'];?>">
                            <label for="form15" class="active">TC. Numaranız</label>
                            </div>
				            </div>
							
							<div class="col-sm-12" id="kurumsal" style="display:none;">			
						    <div class="md-form md-outline">
                            <input name="vergi1" type="text"  class="form-control" value="<?php echo $uyebilgileri['vergi1'];?>">
                            <label for="form15" class="active">Firma Adı</label>
                            </div>
				            </div>
							
							<div class="col-sm-12" id="kurumsal2" style="display:none;">			
						    <div class="md-form md-outline">
                            <input name="vergi2" type="text"  class="form-control" value="<?php echo $uyebilgileri['vergi2'];?>">
                            <label for="form15" class="active">Vergi Dairesi Adı</label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12" id="kurumsal3" style="display:none;">			
						    <div class="md-form md-outline">
                            <input name="vergi3" type="text"  class="form-control" value="<?php echo $uyebilgileri['vergi3'];?>">
                            <label for="form15" class="active">Vergi No</label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
						    <div class="kutu">
							<input value="1" name="sifretip" type="radio" class="login-check" id="register-check-20"> 
							Şifremi Güncellemek istiyorum
						    </div>
                            <label for="form15" class="active">Şifremi Yenile</label>
                            </div>
				 
				            </div>
							
							<div class="col-sm-12" id="sifre1" style="display:none;">			
						    <div class="md-form md-outline">
                            <input name="sifre" type="password"  class="form-control">
                            <label for="form15" class="active">Yeni Şifreniz</label>
                            </div>
				            </div>
							
							
		            						<div class="col-sm-12">
		                					<button type="submit" name="uyeguncelle" class="butonok btn btn-outline-primary-2">
			                					<span>BİLGİLERİMİ GÜNCELLE</span>
			            						<i class="icon-long-arrow-right"></i>
			                				</button>
											 </div>
			                			</form>
								    </div><!-- .End .tab-pane -->
								</div>
	                		</div><!-- End .col-lg-9 -->
							
							
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div>

            </div><!-- End .page-content -->
        </main>
										
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
    color: #c96;
    font-weight: 400;
    font-size: 14px;
}
.md-form.md-outline .form-control {
    padding: .375rem .75rem;
        padding-top: 0.375rem;
    padding-top: 10px;
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


.badge {
    display: inline-block;
    min-width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: bold;
    line-height: 1;
    color: #fff !important;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: <?php echo $tema['t8']; ?>;
    border-radius: 10px;
    background: <?php echo $tema['t8']; ?> !important;
    border: none !important;
}
.panel-default > .panel-heading .badge {
    color: #fff;
    background-color: <?php echo $tema['t8']; ?> !important;
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
.col-1,
.col-2,
.col-3,
.col-4,
.col-5,
.col-6,
.col-7,
.col-8,
.col-9,
.col-10,
.col-11,
.col-12,
.col,
.col-auto,
.col-sm-1,
.col-sm-2,
.col-sm-3,
.col-sm-4,
.col-sm-5,
.col-sm-6,
.col-sm-7,
.col-sm-8,
.col-sm-9,
.col-sm-10,
.col-sm-11,
.col-sm-12,
.col-sm,
.col-sm-auto,
.col-md-1,
.col-md-2,
.col-md-3,
.col-md-4,
.col-md-5,
.col-md-6,
.col-md-7,
.col-md-8,
.col-md-9,
.col-md-10,
.col-md-11,
.col-md-12,
.col-md,
.col-md-auto,
.col-lg-1,
.col-lg-2,
.col-lg-3,
.col-lg-4,
.col-lg-5,
.col-lg-6,
.col-lg-7,
.col-lg-8,
.col-lg-9,
.col-lg-10,
.col-lg-11,
.col-lg-12,
.col-lg,
.col-lg-auto,
.col-xl-1,
.col-xl-2,
.col-xl-3,
.col-xl-4,
.col-xl-5,
.col-xl-6,
.col-xl-7,
.col-xl-8,
.col-xl-9,
.col-xl-10,
.col-xl-11,
.col-xl-12,
.col-xl,
.col-xl-auto {
 padding-right:10px;
 padding-left:10px
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
.container {
 width:1188px;
 max-width:100%;
 padding-left:10px;
 padding-right:10px
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







</style>


<?php } else { ?>	
<meta http-equiv="refresh" content="0; url='<?php echo $url;?>">
<?php } ?>