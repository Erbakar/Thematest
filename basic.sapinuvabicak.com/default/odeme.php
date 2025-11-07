<title>Alışveriş Sepetim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

             <?php if($system['misafirok']!='1'){?>
			 <?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
             <?php } else { ?>			 
             <meta http-equiv="refresh" content="0; url='<?php echo $url;?>/kontrol/">
			 <?php } ?>
			 
	         <?php } ?>

		
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
            			<form action="alisverisi-tamamla/" method="POST"/>
		                	<div class="row">
		                		<div class="col-lg-9" style="border: 1px solid #f8f8f8;border-radius: 4px;">
		                			<h2 class="checkout-title">Sipariş Detayları</h2><!-- End .checkout-title -->
		                				<div class="row">
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <input value="<?php echo $uyebilgileri['isim'];?>" name="adsoyad" type="text" id="form15" class="form-control"  onblur="this.value.split(' ').length < 2 ? alert('Adınızı ve Soyadınızı eksiksiz girmelisiniz.') : '';"  required>
                            <label for="form15" class="active">Adınız Soyadınız</label>
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <input value="<?php echo $uyebilgileri['telefon'];?>" name="telefon" type="tel"   class="form-control" required>
                            <label for="form15" class="active">Telefon Numaranız</label>
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <input value="<?php echo $uyebilgileri['email'];?>" name="email" type="email"   class="form-control" required>
                            <label for="form15" class="active">Eposta Adresiniz</label>
                            </div>
				            </div>
							
							<?php if ($_SESSION['uyegirisdurumu'] == 'true') { 
                            $adresbak = $ozy->prepare("SELECT COUNT(*) FROM adreslerim where uyeid='{$uyeid}'");
                            $adresbak->execute();
                            $adressay = $adresbak->fetchColumn();
							if($adressay>='1'){?>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <select id="adresgeldi" class="form-control">
							<option>Kayıtlı Adreslerimden Kullan</option>
							<?php $adresim = $ozy->query("select * from adreslerim where uyeid='{$uyeid}' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
							foreach($adresim as $adresoku){?>
                            <option data-il="<?php echo $adresoku['il']; ?>" data-ilce="<?php echo $adresoku['ilce']; ?>" data-adres="<?php echo $adresoku['adres']; ?>"> <?php echo $adresoku['adi']; ?> / <?php echo $adresoku['adres']; ?> <?php echo $adresoku['il']; ?> <?php echo $adresoku['ilce']; ?></option>
                            <?php } ?>
							</select>
                            <label for="form15" class="active">Kayıtlı Adreslerim</label>
                            </div>
	
				            </div>
							
							
							
							
							<?php }} ?>	
							
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
                            <textarea name="adres" class="form-control" id="uyeadresal" cols="30" rows="4" placeholder="" required></textarea>
                            <label for="form15" class="active">Sipariş Adresiniz</label>
                            </div>
				            </div>
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline" style="width: 48%;float: left;">
                            <select name="il" id="adresil" class="form-control" required>
							<?php foreach($sehir as $key => $val){?>
                            <option value="<?=$val;?>"><?=$val;?></option>
                            <?php }?>
							</select>
                            <label for="form15" class="active">Sipariş İli</label>
                            </div>
							<div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;">
                            <input name="ilce" type="text" id="adresilce"  class="form-control" required>
                            <label for="form15" class="active">Sipariş İlçesi</label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline" style="width: 48%;float: left;">
						    <div class="kutu">
							<input checked value="0" name="uyetip" type="radio" class="login-check" id="register-check-20" required> 
							Bireysel
						    </div>
                            <label for="form15" class="active">Fatura Bilgisi</label>
                            </div>
				            <div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;">
						    <div class="kutu">
							<input  value="1" name="uyetip" type="radio" class="login-check" id="register-check-20" required> 
							Kurumsal
						    </div>
                            <label for="form15" class="active">Fatura Bilgisi</label>
                            </div>
				            </div>
							
							
							
								
							<div class="col-sm-12" id="bireysel">			
						    <div class="md-form md-outline">
                            <input value="<?php echo $uyebilgileri['tc'];?>" name="tc" type="text"  class="form-control" size="11" maxlength="11">
                            <label for="form15" class="active">TC. Numaranız</label>
                            </div>
				            </div>
							
							<div class="col-sm-12" id="kurumsal" style="display:none;">			
						    <div class="md-form md-outline">
                            <input value="<?php echo $uyebilgileri['vergi1'];?>" name="vergi1" type="text"  class="form-control">
                            <label for="form15" class="active">Firma Adı</label>
                            </div>
				            </div>
							
							<div class="col-sm-12" id="kurumsal2" style="display:none;">			
						    <div class="md-form md-outline">
                            <input value="<?php echo $uyebilgileri['vergi2'];?>" name="vergi2" type="text"  class="form-control">
                            <label for="form15" class="active">Vergi Dairesi Adı</label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12" id="kurumsal3" style="display:none;">			
						    <div class="md-form md-outline">
                            <input value="<?php echo $uyebilgileri['vergi3'];?>" name="vergi3" type="text"  class="form-control">
                            <label for="form15" class="active">Vergi No</label>
                            </div>
				            </div>
						
						
					        <div class="col-sm-12">			
						    <div class="md-form md-outline" style="width: 48%;float: left;">
						    <div class="kutu">
							<input checked value="0" name="faturatip" type="radio" class="login-check" id="register-check-202" required> 
							Fatura Adresim Sipariş Adresimle Aynı
						    </div>
                            <label for="form15" class="active">Fatura Adres Bilgisi</label>
                            </div>
				            <div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;">
						    <div class="kutu">
							<input  value="1" name="faturatip" type="radio" class="login-check" id="register-check-202" required> 
							Yeni Fatura Adresi Oluştur
						    </div>
                            <label for="form15" class="active">Fatura Adres Bilgisi</label>
                            </div>
				            </div>
					
					
					
							<div class="col-sm-12" id="faturaadres" style="display:none;">		
						    <div class="md-form md-outline">
                            <textarea name="faturaadres" class="form-control" cols="30" rows="4" placeholder=""></textarea>
                            <label for="form15" class="active">Fatura Adresiniz</label>
                            </div>
				            </div>
							
							<div class="col-sm-12" id="faturail" style="display:none;">		
						    <div class="md-form md-outline" style="width: 48%;float: left;">
                            <select name="faturail" id="sehir" class="form-control">
							<?php foreach($sehir as $key => $val){?>
                            <option value="<?=$val;?>"><?=$val;?></option>
                            <?php }?>
							</select>
                            <label for="form15" class="active">Fatura İli</label>
                            </div>
							<div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;display:none;" id="faturailce">	
                            <input name="faturailce" type="text"   class="form-control">
                            <label for="form15" class="active">Fatura İlçesi</label>
                            </div>
				            </div>
							
							
							
							<div class="col-sm-12">		
						    <div class="md-form md-outline">
                            <textarea name="mesaj" class="form-control" cols="30" rows="4" placeholder="Bırakmak istediğiniz not ."></textarea>
                            <label for="form15" class="active">Notunuz </label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12">	
							<div class="custom-control custom-checkbox">
                            <input type="checkbox" name="onay" value="1" class="custom-control-input" id="register-policy" required>
                            <label class="custom-control-label" for="register-policy"><a target="_blank" href="mesafeli-satis-sozlesmesi/">Mesafeli Satış Sözleşmesi Şartlarını</a> okudum ve kabul ediyorum *</label>
                            </div><!-- End .custom-checkbox -->
													 
							</div>
	                		


							

	                			</div><!-- End .col-lg-9 -->
		                		
		                	</div><!-- End .row -->
							
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
											 <tr class="summary-shipping-row" id="kapidaodemediv" style="display:none;">
	                							<td>
													<div class="custom-control custom-radio">
														<label class="custom-control-label" for="free-shipping">Kapıda Ödeme Bedeli :</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td style="min-width: 150px !important;"><?php echo fiyatgoster($system['kapitutar']);?></td>
	                						</tr><!-- End .summary-shipping-row -->
											<?php if($havaleindirimbedeli!='0'){?>
											  <tr class="summary-shipping-row" id="havaleodemediv" style="display:none;">
	                							<td>
													<div class="custom-control custom-radio">
														<label class="custom-control-label" for="free-shipping" style="color:red;">Havale/EFT İndirimi :</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>- <?php echo fiyatgoster($havaleindirimbedeli);?></td>
	                						 </tr><!-- End .summary-shipping-row -->
											 <?php } ?>
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

	                						
	                						<tr class="summary-total" >
	                							<td>Ödenecek Tutar :</td>
	                							<td id="toplam-price-val" data-price="<?php echo $toplamtutarim;?>"><?php echo $toplamtutari;?></td>
	                						</tr><!-- End .summary-total -->
	                					</tbody>
	                				</table><!-- End .table table-summary -->

	                			</div><!-- End .summary -->
		                			<div class="summary">
		                				<h3 class="summary-title">Ödeme Yöntemleri</h3><!-- End .summary-title -->

		                

                                        <div id="paymentOptions">

                                         <ul>
										 <?php if($system['havaleok']=='1'){?>
										 <li>
                                         <span class="radio"><input onclick="kapidaodemeekle(2)" type="radio" name="odemetipi" value="Havale/EFT" required><label></label></span>
                                         <i style="margin-right: 10px;color: #70b7ff;"  class="fa fa-university" aria-hidden="true"></i> <span class="details credit">Havale/EFT</span>
                                         </li>
										 <?php } ?>
										 
										 <?php if($system['kapidaok']=='1'){?>
										 <li>
                                         <span class="radio"><input onclick="kapidaodemeekle(1)" type="radio" name="odemetipi" value="Kapıda Ödeme" required><label></label></span>
                                         <i style="margin-right: 10px;color: #70b7ff;" class="fa fa-truck" aria-hidden="true"></i> <span class="details credit">Kapıda Ödeme <b>+ <?php echo fiyatgoster($system['kapitutar']);?></b></span>
                                         </li>
										 <?php } ?>
										 
										 <?php if($system['kartok']=='1'){?>
										 <li>
                                         <span class="radio"><input onclick="kapidaodemeekle(0)" type="radio" name="odemetipi" value="Kredi Kartı" required><label></label></span>
                                         <i style="margin-right: 10px;color: #70b7ff;"  class="fa fa-credit-card" aria-hidden="true"></i> <span class="details credit"> Kredi Kartı</span>
                                         </li>
										 <?php } ?>
										 
										 </ul>
										 
										 
										 </div>


                                            



		                				<button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
		                					<span class="btn-text">ALIŞVERİŞİ TAMAMLA</span>
		                					<span class="btn-hover-text">ÖDEME YAP</span>
		                				</button>
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
							
							
							
							
							
            			</form>
						
						
						<?php } ?>
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div>
			</div>
	</main>
	<script>
	var kapifiyat = parseFloat(<?php echo $system['kapitutar'];?>);
    var havalefiyat = parseFloat(<?php echo $havaleindirimbedeli;?>);
	var odemefiyati = parseFloat(<?php echo $toplamtutarim;?>);
    function kapidaodemeekle(id) {
   
        if (id == 1) {
			var yenifiyat = kapifiyat + odemefiyati;
            $("#toplam-price-val").html(yenifiyat.toFixed(2).toString() + " TL");
            $("#kapidaodemediv").show();
			 $("#havaleodemediv").hide();
        } else if (id == 2){
			var yenifiyat1 = odemefiyati - havalefiyat;
            $("#toplam-price-val").html(yenifiyat1.toFixed(2).toString() + " TL");
            $("#havaleodemediv").show();
			$("#kapidaodemediv").hide();
        }else{
		$("#toplam-price-val").html(odemefiyati.toFixed(2).toString() + " TL");
            $("#havaleodemediv").hide();
			$("#kapidaodemediv").hide();
		} 

    }
	</script>
	<link rel="stylesheet" href="eklentiler/font-awesome.css">