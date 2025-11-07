<title>Alışveriş Sepetim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
 
	
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
   <div class="page-content pb-3">
                <div class="cart">
	                <div class="container">
	                	<div class="row">
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
	                		<div class="col-lg-9" style="border: 1px solid #f2f2f2;">
							
	                			<table class="table table-cart table-mobile">
									<thead>
										<tr>
											<th>Ürün</th>
											<th>Birim Fiyatı</th>
											<th>KDV</th>
											<th>Adet</th>
											<th>Toplam</th>
											<th></th>
										</tr>
									</thead>

									<tbody>
					  <?php
					  // Önce sepetteki geçersiz ürünleri temizle (silinmiş veya pasif ürünler)
					  $temizlik = $ozy->prepare("DELETE sepet FROM sepet 
					  LEFT JOIN urunler ON sepet.urunid = urunler.id 
					  WHERE sepet.kim=? AND sepet.gelenkim=? AND (urunler.id IS NULL OR urunler.durum != 1)");
					  $temizlik->execute(array($ip,$sepetimdekikim));
					  
					  $sepetebak = $ozy->prepare("SELECT * FROM sepet WHERE kim=? and gelenkim=?");
					  $sepetebak->execute(array($ip,$sepetimdekikim));
					  if ($sepetebak->rowCount()) {
					  $uyesepeti = $ozy->prepare("SELECT urunler.*, sepet.* FROM urunler 
					  INNER JOIN sepet ON urunler.id = sepet.urunid  
					  WHERE sepet.kim=? AND sepet.gelenkim=? AND urunler.durum = 1 
					  ORDER BY sepet.id DESC");                
					  $uyesepeti->execute(array($ip,$sepetimdekikim));
					  foreach ($uyesepeti as $sepet) {?>
									
									
										<tr>
										 <td class="product-col">
												<div class="product">
													<figure class="product-media">
														<a href="urun/<?php echo $sepet['seo'];?>">
															<img src="resimler/urunler/<?php echo $sepet['resim'];?>" alt="Product image">
														</a>
													</figure>

													    <h3 class="product-title">
														<a href="urun/<?php echo $sepet['seo'];?>"><b style="font-weight: 400;"><?php echo $sepet['adi'];?></b></br>
														<div style="font-weight: 400;font-size: 12px;margin-left: 2px;"><?php echo $sepet['ekurun'];?>
							                            
					                                    
					                                   
														</div>
														
														</a>
														<div class="badges" style="margin-top: 10px; display: inline-block;width: 300px;">
														
														<?php if($sepet['kargo']=='1'){?>
					                                    <span class="badge" style="border: 1px solid #2cc43c;padding: 5px;line-height: 20px !important;color: #2cc43c;">
					                                    <i style="font-size: 18px;" class="icon-truck"></i> KARGO ÜCRETSİZ
					                                    </span>
                                                        <?php } ?>
														 <?php if($sepet['alodedurum']=='1'){?> 
                                                        <span class="badge" style="border: 1px solid #d2ab13;padding: 5px;line-height: 20px !important;color: #d2ab13;">
					                                    <i style="font-size: 18px;" class="icon-shopping-cart"></i> <?php echo $sepet['alodemetin'];?></span>
                                                        <?php } ?>
					                                    </div>
													</h3><!-- End .product-title -->
													
													
												</div><!-- End .product -->
											</td>
											<td class="price-col"><?php echo fiyatgoster($sepet['kdvsizfiyat']);?></td>
											<td class="price-col" style="font-size: 14px;">(%<?php echo $sepet['oran'];?>)</br>
											<?php echo fiyatgoster($sepet['kdv']);?></td>
											<form action="" method="POST">
											<td class="quantity-col">
                                                <div class="cart-product-quantity">
												    <?php if($sepet['alodedurum']=='1'){?> 
													<?php $newstok = $sepet['adet']+$sepet['alodeadet'];?>
													<?php } else { ?>
													<?php $newstok = $sepet['adet'];?>
													<?php } ?>
													
													<?php if($system['sinirsizstok']!='1'){	?>
													
                                                    <input name="adet" onchange="this.form.submit()" type="number" class="form-control" value="<?php echo $newstok;?>" min="1" max="<?php echo $sepet['stok'];?>" step="1" data-decimals="0" required="" style="display: none;">	
                                                    <?php } else { ?>
													<input name="adet" onchange="this.form.submit()" type="number" class="form-control" value="<?php echo $newstok;?>" min="1" max="9999999999999999999" step="1" data-decimals="0" required="" style="display: none;">	
                                                    <?php } ?>
													<input type="hidden" name="sepetguncelle"/>
												</div><!-- End .cart-product-quantity -->
                                            </td>
											<td class="total-col"><?php echo fiyatgoster($sepet['fiyat']*$sepet['adet']);?></td>
											<td class="remove-col">
										<form action="" method="POST">
										<input type="hidden" name="sepetid" value="<?php echo $sepet['id']; ?>"/>
										<input type="hidden" name="urunid" value="<?php echo $sepet['urunid']; ?>"/>
										<button name="delete" type="submit" class="btn-remove" title="Sil"><i class="icon-close"></i></button>
                                        </form>	
											</td>
										</tr>
										
									<?php }} ?> 	
										
										
									</tbody>
								</table><!-- End .table table-wishlist -->
                               </form>
	                			<div class="cart-bottom">
			            			<div class="cart-discount">
			            				<form method="POST" action="">
			            					<div class="input-group">
				        						<input type="text" class="form-control" name="kuponadi" placeholder="İndirim Kuponu Kodunuz">
				        						<div class="input-group-append">
													<button class="btn btn-outline-primary-2" type="submit" name="kuponguncelle"><i class="icon-long-arrow-right"></i></button>
												</div><!-- .End .input-group-append -->
			        						</div><!-- End .input-group -->
			            			
			            			</div><!-- End .cart-discount -->

			            		</div><!-- End .cart-bottom -->
	                		</div><!-- End .col-lg-9 -->
							</form>
	                		<aside class="col-lg-3">
	                			<div class="summary summary-cart" style="background: white !important;">
	                				<h3 class="summary-title">Ödeme Detayları</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                		
	                						<tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
														<label class="custom-control-label" for="free-shipping">Ara Tutar :</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td><?php echo $aratutari;?></td>
	                						</tr><!-- End .summary-shipping-row -->

	                						<tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
														<label class="custom-control-label" for="free-shipping">KDV Bedeli :</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td><?php echo $kdvtutari;?></td>
	                						</tr><!-- End .summary-shipping-row -->

	                                        <tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
														<label class="custom-control-label" for="free-shipping">Kargo Bedeli :</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td style="min-width: 150px !important;"><?php echo $kargometni;?></td>
	                						</tr><!-- End .summary-shipping-row -->
                                           <?php if($kuponindirim!='0'){?>
                                            <tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
														<label class="custom-control-label" for="free-shipping" style="color:red;">İndirim Kuponu Bedeli :</label><a style="font-size: 10px;background: #dd1616a8;color: white;" href="sepet/?kuponsil">Kuponu Sil</a> 
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>- <?php echo fiyatgoster($kuponindirim)?></td>
	                						 </tr><!-- End .summary-shipping-row -->
                                            <?php } ?>
											
                                           <?php if($cekindirim!='0'){?>
                                            <tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
														<label class="custom-control-label" for="free-shipping" style="color:red;">Hediye Çeki Bedeli :</label><a style="font-size: 10px;background: #dd1616a8;color: white;" href="sepet/?ceksil">Hediye Çeki Sil</a> 
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>- <?php echo fiyatgoster($cekindirim)?></td>
	                						 </tr><!-- End .summary-shipping-row -->
                                            <?php } ?>

                                            <?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
	                						
	                						<div class="cart-discount">
			            				    <form method="POST" action="">
			            					<div class="input-group">
											
											<select name="kuponadi" class="form-control" style="background: #f9f9f9;margin-bottom: 10px;font-weight: 400;" onchange='this.form.submit()'>
											<option value="0">Aktif Hediye Çeklerim</option>
											<?php $uyeepostamiz = temizle($uyebilgileri['email']);
		                                    $cekoku = $ozy->query("select * from kuponlar where durum='1' and sekil='1' and epostalar like '%$uyeepostamiz%' and gtarih>='$buguntarihim' and kullanildi not like '%$uyeepostamiz%' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($cekoku as $hediyecek) {?>
											<option value="<?php echo $hediyecek['adi']?>"><?php echo $hediyecek['adi']?></option>
											<?php } ?>
				        					</select>
											
				        					<input type="hidden" name="cekguncelle">
											</div><!-- End .input-group -->
			            			
			            			         </div><!-- End .cart-discount -->
	                					
											
											<?php } ?>
											

	                						<tr class="summary-total">
	                							<td>Ödenecek Tutar :</td>
	                							<td><?php echo $toplamtutari;?></td>
	                						</tr><!-- End .summary-total -->
	                					</tbody>
	                				</table><!-- End .table table-summary -->
                                    <?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
	                				<a href="odeme/" class="btn btn-outline-primary-2 btn-order btn-block">ÖDEME ADIMINA GEÇ</a>
	                			    <?php } else { ?>
									<a href="kontrol/" class="btn btn-outline-primary-2 btn-order btn-block">ÖDEME ADIMINA GEÇ</a>
	                			    <?php } ?>
								</div><!-- End .summary -->

		            		</aside><!-- End .col-lg-3 -->
							
							<?php } ?>
							
	                	</div><!-- End .row -->
						
						
						
						
	                </div><!-- End .container -->
                </div>
                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>