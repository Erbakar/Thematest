<title>Alışveriş Sepetim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
 
	
		   <main class="main">
     
         
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
	                		<div class="col-lg-9" style="border: 1px solid #f2f2f2;background: white;">
							<?php if($toplamtutarim>=$system['ucretsizkargo']){?>
 
 <div class="alert alert-success alert-dismissible" style="margin-bottom: 15px;padding-left: 8px;padding-right: 8px;">
 <i class="fa fa-check"></i> Tebrikler! <b>KARGO ÜCRETSİZ</b> fırsatını yakaladınız!
 </div>
 	<?php } else { ?>

<div class="alert alert-warning alert-dismissible" style="margin-bottom: 15px;padding-left: 8px;padding-right: 8px;color: #333;">
<i class="fa fa-exclamation-circle"></i> <b>Ücretsiz Kargo </b>İçin Kalan Tutar: <?php echo $kalan = $system['ucretsizkargo']-$toplamtutarim;?> TL<button type="button" class="close" data-dismiss="alert">×</button>
</div>

	<?php } ?>
	                			<table class="table table-cart table-mobile">
									<thead>
										<tr>
											<th>Ürün</th>
											<th>Birim</th>
											<th>KDV</th>
											<th>Adet</th>
											<th>Toplam</th>
											<th></th>
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
										 <td class="product-col">
												<div class="product">
													<figure class="product-media">
														<a href="urun/<?php echo $sepet['seo'];?>">
															<img style="width:50px;" src="resimler/urunler/<?php echo $sepet['resim'];?>" alt="Product image">
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
                                               <div class="cl-product-quantity-input-container">
           							<?php if($sepet['alodedurum']=='1'){?> 
											<?php $newstok = $sepet['adet']+$sepet['alodeadet'];?>
											<?php } else { ?>
											<?php $newstok = $sepet['adet'];?>
											<?php } ?>
			                                <?php if($system['sinirsizstok']!='1'){	?>
			                                <input type="number" onchange="this.form.submit()" name="adet" value="<?php echo $newstok;?>" min="1" max="<?php echo $sepet['stok'];?>"  size="2" id="input-quantity" class="form-control" required>
                                            <?php } else { ?>
                                            <input type="number" onchange="this.form.submit()" name="adet" value="<?php echo $newstok;?>" min="1" max="9999999999999999999" size="2" id="input-quantity" class="form-control" required>
                                            <?php } ?>
                 
				
			
            </div>
											
											
											<input type="hidden" name="sepetguncelle"/>
												</div><!-- End .cart-product-quantity -->
                                            </td>
											<td class="total-col" style="font-weight:bold;"><?php echo fiyatgoster($sepet['fiyat']*$sepet['adet']);?></td>
											<td class="remove-col">
										<form action="" method="POST">
										<input type="hidden" name="sepetid" value="<?php echo $sepet['id']; ?>"/>
										<input type="hidden" name="urunid" value="<?php echo $sepet['urunid']; ?>"/>
										<button name="delete" type="submit" class="btn-remove" title="Sil"><i class="fa fa-close"></i></button>
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
				        					<button class="butonok btn btn-outline-primary-2" type="submit" name="kuponguncelle">Kupon Güncelle</button>	
												
			        						</div><!-- End .input-group -->
			            			
			            			</div><!-- End .cart-discount -->
	
											
			            		</div><!-- End .cart-bottom -->
	                		</div><!-- End .col-lg-9 -->
							</form>
	                		<aside class="col-lg-3" style="background: white;background: white;
border: 1px solid #eceaea;
    border-left-color: rgb(236, 234, 234);
    border-left-style: solid;
    border-left-width: 1px;
border-radius: 6px;
border-left: 0px !important;">
	                			<div class="summary summary-cart" style="background: white !important;">
	                				<h3 style="border-bottom: 1px solid #ece9e9;
text-align: center;
background: #f8f8f8;
padding: 10px;
border-radius: 6px;
font-size: 14px;" class="summary-title">Ödeme Detayları</h3><!-- End .summary-title -->

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
			            					<div class="input-group" style="width: 100%;">
											
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
	                							<td style="color: #fa5616;font-size: 18px;font-weight: bold;"><?php echo $toplamtutari;?></td>
	                						</tr><!-- End .summary-total -->
	                					</tbody>
	                				</table><!-- End .table table-summary -->
                                    <?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
	                				<a href="odeme/" class="butonok btn btn-outline-primary-2 btn-order btn-block">ÖDEME ADIMINA GEÇ</a>
	                			    <?php } else { ?>
									<a href="kontrol/" class="butonok btn btn-outline-primary-2 btn-order btn-block">ÖDEME ADIMINA GEÇ</a>
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
		<style>
		.table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > td {
    border-top: 0;
    width: 20% !important;
}
#input-quantity {
    top: -8px;
    height: 40px;
    text-align: center;
    position: relative;
    font-size: 15px;
    width: 100px !important;
    background: whitesmoke;
    color: #777;
    border: 1px solid #d2d2d2;
}
		</style>