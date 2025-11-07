<title>Alışveriş Sepetim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Alışveriş Sepetim"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
<?php if (isset($_POST['deletex'])) {$sepetidm = temizle($_POST['sepetid']);$silxy = $ozy->prepare("DELETE FROM sepet WHERE id=?");$silxy->execute(array($sepetidm));echo '<meta http-equiv="refresh" content="0; url='.$url.'/sepet/">'; }?>

      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Alışveriş Sepetim</h2>
        </div>
    </section>
 
 <section class="page cart pt-5 pb-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
				
							<?php if($sepetsayi<='0'){?>
						 <div class="col-md-12">
           
             
                <div class="card-body cart">
                    <div class="col-sm-12 empty-cart-cls text-center" style="text-align: center;"> 
					<img style="margin: auto !important;width: 200px;" src="<?php echo $sitetemasi;?>/user/sepetbos.png" width="100" height="100" class="img-fluid mb-4 mr-3">
                        <h5><strong>Alışverişiz Sepetiniz Boş</strong></h5>
                        <h5>Biraz Gezinmeye Ne Dersin :)</h5> <a href="<?php echo $url;?>" style="background: <?php echo $tema['t37'];?>;border: none;" class="btn btn-primary cart-btn-transform m-3" data-abc="true">hadi gezinelim :)</a>
                    </div>
                </div>
           
        </div>
<?php } else { ?>
				
				
				
				
				
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Ürünleriniz</th>
                                <th scope="col">Stok Kodu</th>
                                <th scope="col">Miktar</th>
                                <th scope="col">Birim Fiyatı</th>
                                <th scope="col">Toplam</th>
                            </tr>
                            </thead>
                            <tbody>
                           <?php
					  $sepetebak = $ozy->prepare("SELECT * FROM sepet WHERE kim=? and gelenkim=?");
					  $sepetebak->execute(array($ip,$sepetimdekikim));
					  if ($sepetebak->rowCount()) {
					  $uyesepeti = $ozy->prepare("SELECT * FROM urunler 
					  INNER JOIN sepet ON urunler.id = sepet.urunid  
					  WHERE sepet.kim=? and sepet.gelenkim=? ORDER BY sepet.id DESC");                
					  $uyesepeti->execute(array($ip,$sepetimdekikim));
					  foreach ($uyesepeti as $sepet) {?>
                                <tr>
                                    <td>
                                        <a href="urun/<?php echo $sepet['seo'];?>" class="d-flex align-items-center">
                                            <img src="resimler/urunler/<?php echo $sepet['resim'];?>" class="img-fluid me-3" width="120"
                                                 height="80" alt="">
                                            <span class="title"><?php echo $sepet['adi'];?><br/><b style="font-size: 13px;
background: #f7f7f7;
padding: 10px;
width: 100%;
display: block;
border-radius: 6px;
margin-top: 5px;
font-weight: 500;"><?php echo $sepet['ekurun'];?></b></span>
                                        </a>
                                    </td>
                                    <td><?php echo $sepet['urunkodu'];?></td>
                                    <td>
									 <form action="" method="POST">
									  <input type="hidden" name="sepetid" value="<?php echo $sepet['id']; ?>"/>
					                  <input type="hidden" name="urunid" value="<?php echo $sepet['urunid']; ?>"/>
                                        <div class="d-flex align-items-center">
                                            <span class="number">
											<?php if($sepet['alodedurum']=='1'){?> 
						<?php $newstok = $sepet['adet']+$sepet['alodeadet'];?>
						<?php } else { ?>
						<?php $newstok = $sepet['adet'];?>
						<?php } ?>
			            <?php if($system['sinirsizstok']!='1'){	?>
			            <input style="border: none;width: 40px;" class="submit_on_enter" type="text" data-type="number"  pattern="[0-9]*" name="adet" value="<?php echo $newstok;?>" min="1" max="<?php echo $sepet['stok'];?>"  size="2">
                        <?php } else { ?>
                        <input style="border: none;width: 40px;" class="submit_on_enter" type="text" data-type="number"  pattern="[0-9]*" name="adet" value="<?php echo $newstok;?>" min="1" max="9999999999999999999">
                        <?php } ?>
											
											</span>
                                            <button style="color: #00b373;
background-color: #e5f7f1;
height: 100%;
display: flex;
padding: 14px 22px;
border-radius: 24px;
-webkit-transition: all 0.3s;
transition: all 0.3s;
margin-right: 10px;border:none;" name="sepetupdate" type="submit" class="refresh"><i class="ri-refresh-line"></i></button>
                                            <button style="color: #f6284e;
background-color: #fee9ed;
height: 100%;
display: flex;
padding: 14px 22px;
border-radius: 24px;
-webkit-transition: all 0.3s;
transition: all 0.3s;border:none;" name="deletex" type="submit" class="delete"><i class="ri-delete-bin-2-line"></i></button>
                                        </div>
										</form>
                                    </td>
                                    <td><?php echo fiyatgoster($sepet['fiyat']);?></td>
                                    <td><?php echo fiyatgoster($sepet['fiyat']*$sepet['adet']);?></td>
                                </tr>
                            <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="subtitle text-center mt-5 mb-3">Bir sonraki adımda ne yapmak istersiniz?</div>
                    <div class="desc text-center mb-5">Eğer kullanmak istediğiniz bir indirim kodu veya puan varsa bu adımda kullanabilirsiniz.
                    </div>

                    <div class="accordion" id="patiAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    <i class="ri-coupon-3-line me-2"></i> Kupon Kodu Kullan
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1"
                                 data-bs-parent="#patiAccordion">
                                <div class="accordion-body">
								 <form method="POST" action="">
                                    <div class="form-group">
		
		
			<input type="text" class="form-control" name="kuponadi" placeholder="İndirim Kuponu Kodunuz">
			<button class="gonderbuton" type="submit" name="kuponguncelle">Kuponu Uygula</button>
			
		
	</div>
	</form>
                                </div>
                            </div>
                        </div>
                       
					    <?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                    <i class="ri-gift-line me-2"></i> Hediye Çeki Kullan
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                 data-bs-parent="#patiAccordion">
                                <div class="accordion-body">
                                   <form method="POST" action="">
				 	                        <div class="form-group">
			       
			            					
											
											<select name="kuponadi" class="form-control" style="background: #f9f9f9;margin-bottom: 10px;font-weight: 400;" onchange='this.form.submit()'>
											<option value="0">Aktif Hediye Çeklerim</option>
											<?php $uyeepostamiz = temizle($uyebilgileri['email']);
		                                    $cekoku = $ozy->query("select * from kuponlar where durum='1' and sekil='1' and epostalar like '%$uyeepostamiz%' and gtarih>='$buguntarihim' and kullanildi not like '%$uyeepostamiz%' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($cekoku as $hediyecek) {?>
											<option value="<?php echo $hediyecek['adi']?>"><?php echo $hediyecek['adi']?></option>
											<?php } ?>
				        					</select>
											
				        					<input type="hidden" name="cekguncelle">
										
			            			
			            			         </div><!-- End .cart-discount -->
	                					
											</form>
								   
                                </div>
                            </div>
                        </div>
						
						<?php } ?> 
						
                    </div>

                    <div class="line mt-5 mb-5"></div>

                    <ul class="price">
                        <li><span>Ara Toplam :</span><span><?php echo $aratutari;?></span></li>
                        <li><span>KDV :</span><span><?php echo $kdvtutari;?></span></li>
						<li><span>Kargo Bedeli :</span><span><?php echo $kargometni;?></span></li>
						<?php if($kuponindirim!='0'){?>
						<li><span>İndirim Bedeli :</br><a style="padding:2px;font-size: 12px;background: #dd1616a8;color: white;" href="sepet/?kuponsil">Kuponu Sil</a>
						</span><span style="color:red;">- <?php echo fiyatgoster($kuponindirim)?></span></li>
						 <?php } ?>
						 <?php if($cekindirim!='0'){?>
						 <li><span>Çek İndirimi :</br><a style="padding:2px;font-size: 12px;background: #dd1616a8;color: white;" href="sepet/?ceksil">Hediye Çekini Sil</a>
						 </span><span style="color:red;">- <?php echo fiyatgoster($cekindirim)?></span></li>
						 <?php } ?>
				
						<li><span>Ödenecek Tutar :</span><span><?php echo $toplamtutari;?></span></li>
                    </ul>

                    <div class="button-group mt-5 text-center d-flex align-items-center justify-content-center">
                        <a href="<?php echo $url;?>" class="btn-homepage me-2"><i class="ri-arrow-left-line"></i> MAĞAZAYA GERİ DÖN</a>
                        <?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
						<a href="odeme/" class="btn-complete ms-2">ALIŞVERİŞİ TAMAMLA <i class="ri-arrow-right-line"></i></a>
                        <?php } else { ?>
						<a href="kontrol/" class="btn-complete ms-2">ALIŞVERİŞİ TAMAMLA <i class="ri-arrow-right-line"></i></a>
                        <?php } ?>
						
				   </div>
                
				
				
				
	<?php } ?>
				
				
			</div>
				</div>
					
				
            </div>
    </section>