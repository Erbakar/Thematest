<title>Alışveriş Sepetim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Alışveriş Sepetim"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>


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
				
				
				
				
				
                   <form action="alisverisi-tamamla/" method="POST"/>
                
                    <div class="form-group mb-4">
                        <div class="head">
                            <i class="ri-user-3-line"></i> KİŞİSEL BİLGİLERİNİZ
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-6">
                                <input value="<?php echo $uyebilgileri['isim'];?>" name="adsoyad" type="text" id="form15" class="form-control" placeholder="Adınız Soyadınız*" required>
                            
                                </div>
                              <div class="col-md-6">
                                <input value="<?php echo $uyebilgileri['telefon'];?>" name="telefon" type="tel"   class="form-control" placeholder="Telefon Numaranız" required>
                               </div>
                                <div class="col-md-12">
                                    <input value="<?php echo $uyebilgileri['email'];?>" name="email" type="email"  placeholder="Eposta Adresiniz" class="form-control" required>
                            
                                </div>
                                
							   
							  
							   
							   
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group mb-4">
                        <div class="head">
                            <i class="ri-account-pin-circle-line"></i> ADRES BİLGİLERİNİZ
                        </div>
                        <div class="body">
                            <div class="row">
							<?php if ($_SESSION['uyegirisdurumu'] == 'true') { 
                            $adresbak = $ozy->prepare("SELECT COUNT(*) FROM adreslerim where uyeid='{$uyeid}'");
                            $adresbak->execute();
                            $adressay = $adresbak->fetchColumn();
							if($adressay>='1'){?>
							 <div class="col-md-12">
                             <select id="adresgeldi" class="form-control">
							<option>Kayıtlı Adreslerimden Kullan</option>
							<?php $adresim = $ozy->query("select * from adreslerim where uyeid='{$uyeid}' order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
							foreach($adresim as $adresoku){?>
                            <option data-il="<?php echo $adresoku['il']; ?>" data-ilce="<?php echo $adresoku['ilce']; ?>" data-adres="<?php echo $adresoku['adres']; ?>"> <?php echo $adresoku['adi']; ?> / <?php echo $adresoku['adres']; ?> <?php echo $adresoku['il']; ?> <?php echo $adresoku['ilce']; ?></option>
                            <?php } ?>
							</select>
                                </div>
								<?php }} ?>	
                                <div class="col-md-12">
                                 <textarea name="adres" style="min-height:200px;" class="form-control" id="uyeadresal" cols="30" rows="4" placeholder="Sipariş Adresiniz" required></textarea>
                             </div>
								
								
								
                           <div class="col-md-6">
                            <select name="il" id="adresil" class="form-control" required>
							<option>İl Seçiniz</option>
							<?php foreach($sehir as $key => $val){?>
                            <option value="<?=$val;?>"><?=$val;?></option>
                            <?php }?>
							</select></div>
                                <div class="col-md-6">
                                <input name="ilce" type="text" id="adresilce"  class="form-control" placeholder="İlçe" required>
                            </div>
                              
                               
                               
                            </div>
                        </div>
                    </div>
					
					       <div class="form-group mb-4">
                        <div class="head">
                            <i class="ri-account-pin-circle-line"></i> FATURA BİLGİLERİNİZ
                        </div>
                        <div class="body">
                            <div class="row">
							
								 <div class="col-lg-6">
                                    <div class="form-radio">
                                        <input class="form-check-input"  checked value="0" name="uyetip" type="radio" id="kargo1" required>
                                        <label class="form-check-label" for="kargo1">
                                           Bireysel
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-radio mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                        <input class="form-check-input" value="1" name="uyetip" type="radio" id="kargo2" required>
                                        <label class="form-check-label" for="kargo2">
                                            Kurumsal
                                        </label>
                                    </div>
                                </div>
                                
								
								
                                <div class="col-md-12 mt-3" id="bireysel">
                                 <input value="<?php echo $uyebilgileri['tc'];?>" name="tc" type="text"  class="form-control" size="11" maxlength="11" placeholder="T.C. Numaranız">
								 </div>
								 
								 <div class="col-md-12 mt-3" id="kurumsal" style="display:none;">
                                  <input value="<?php echo $uyebilgileri['vergi1'];?>" name="vergi1" type="text"  class="form-control" placeholder="Firma Adı">
								  </div>
                              
								  <div class="col-md-6" id="kurumsal2" style="display:none;">
                                 <input value="<?php echo $uyebilgileri['vergi2'];?>" name="vergi2" type="text"  class="form-control" placeholder="Vergi Dairesi Adı">
								  </div>
                              
								  <div class="col-md-6" id="kurumsal3" style="display:none;">
                                 <input value="<?php echo $uyebilgileri['vergi3'];?>" name="vergi3" type="text"  class="form-control" placeholder="Vergi No">
								  </div>
								 
                                <div class="col-lg-6">
                                    <div class="form-radio mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                        <input class="form-check-input" checked value="0" name="faturatip" type="radio" id="kargo23" required>
                                        <label class="form-check-label" for="kargo23">
                                          Fatura Adresim Sipariş Adresimle Aynı
                                        </label>
                                    </div>
                                </div>
								
								  <div class="col-lg-6">
                                    <div class="form-radio mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                        <input class="form-check-input" value="1" name="faturatip" type="radio" id="kargo233" required>
                                        <label class="form-check-label" for="kargo233">
                                          Yeni Fatura Adresi Oluştur
                                        </label>
                                    </div>
                                </div>
                               
							   
							    <div class="col-md-12 mt-3" id="faturaadres" style="display:none;">
                                 <textarea name="faturaadres" style="min-height:200px;" class="form-control" cols="30" rows="4" placeholder="Fatura Adresiniz"></textarea>
                             </div>
								
								
								
                           <div class="col-md-6" id="faturail" style="display:none;">
                            <select name="faturail" id="sehir" class="form-control">
							<option>Fatura İl Seçiniz</option>
							<?php foreach($sehir as $key => $val){?>
                            <option value="<?=$val;?>"><?=$val;?></option>
                            <?php }?>
							</select></div>
                                <div class="col-md-6" style="display:none;" id="faturailce">
                                <input name="faturailce" type="text" class="form-control" placeholder="Fatura İlçesi">
                            </div>
                              
							   
							   
                               
                            </div>
                        </div>
                    </div>
					
					
					
					
					
					
                    <div class="form-group mb-4">
                        <div class="head">
                            <i class="ri-message-line"></i> NOTUNUZ
                        </div>
                        <div class="body">
                            <div class="row">
                              <div class="col-md-12 mt-3">
                                 <textarea name="mesaj" style="min-height:200px;" class="form-control" cols="30" rows="4" placeholder="Sipariş Notunuz"></textarea>
                             </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="head">
                            <i class="ri-bank-card-2-line"></i> ÖDEME YÖNTEMİ
                        </div>
                        <div class="body">
                            <div class="row">
						
							
							 <?php if($system['havaleok']=='1'){?>	
                                <div class="col-lg-4">
                                    <div class="form-radio mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                        <input class="form-check-input" onclick="kapidaodemeekle(2)" type="radio" name="odemetipi" value="Havale/EFT" required id="odeme3">
                                        <label class="form-check-label" for="odeme3">
                                            Banka Havalesi
                                        </label>
                                    </div>
                                </div>
							<?php } ?>	

	                      <?php if($system['kapidaok']=='1'){?>	
                                <div class="col-lg-4">
                                    <div class="form-radio mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                        <input  class="form-check-input" onclick="kapidaodemeekle(1)" type="radio" id="odeme2" name="odemetipi" value="Kapıda Ödeme" required>
                                        <label class="form-check-label" for="odeme2">
                                            Kapıda Ödeme - <?php echo fiyatgoster($system['kapitutar']);?>
                                        </label>
                                    </div>
                                </div>
							<?php } ?>	


								<?php if($system['kartok']=='1'){?>
                                <div class="col-lg-4">
                                    <div class="form-radio">
                                        <input  class="form-check-input" onclick="kapidaodemeekle(0)" type="radio" id="odeme1" name="odemetipi" value="Kredi Kartı" required>
									
                                          <label class="form-check-label" for="odeme1">   
											Online Ödeme / 3D Secure
                                        </label>
                                    </div>
                                </div>
							  <?php } ?>	
								
                            </div>
                        </div>
                    </div>
                    <ul class="price mb-4">
                        
                        <li><span>Ara Toplam :</span><span><?php echo $aratutari;?></span></li>
                        <li><span>KDV :</span><span><?php echo $kdvtutari;?></span></li>
						<li><span>Kargo Bedeli :</span><span><?php echo $kargometni;?></span></li>
						<li id="kapidaodemediv" style="display:none;"><span>Kapıda Ödeme Bedeli :</span><span><?php echo fiyatgoster($system['kapitutar']);?></span></li>
						<?php if($kuponindirim!='0'){?>
						<li><span>İndirim Bedeli :</br><a style="padding:2px;font-size: 12px;background: #dd1616a8;color: white;" href="sepet/?kuponsil">Kuponu Sil</a>
						</span><span style="color:red;">- <?php echo fiyatgoster($kuponindirim)?></span></li>
						 <?php } ?>
						 <?php if($cekindirim!='0'){?>
						 <li><span>Çek İndirimi :</br><a style="padding:2px;font-size: 12px;background: #dd1616a8;color: white;" href="sepet/?ceksil">Hediye Çekini Sil</a>
						 </span><span style="color:red;">- <?php echo fiyatgoster($cekindirim)?></span></li>
						 <?php } ?>
						 
						 
						<?php if($havaleindirimbedeli!='0'){?> 
				        <li id="havaleodemediv" style="display:none;"><span>Havale/EFT İndirimi :</span>
						<span style="color:red;">- <?php echo fiyatgoster($havaleindirimbedeli)?></span></li>
						<?php } ?>
						<li>
						<span>Ödenecek Tutar :</span>
						<span id="toplam-price-val" data-price="<?php echo $toplamtutarim;?>"><?php echo $toplamtutari;?></span></li>
                 
                    </ul>
                    <div class="group mb-4">
                        <div class="form-check form-check-inline d-flex align-items-center">
                            <input class="styled-checkbox" id="gizlilik" type="checkbox" name="onay" value="1" required>
                            <label for="gizlilik"><a style="color: #ff4545;" href="mesafeli-satis-sozlesmesi/" target="_blank">Mesafeli Satış Sözleşmesi ve Ön Bilgilendirme Formunu okudum ve kabul ediyorum.</a></label>
                        </div>
                    </div>
                
                <div class="button-group mt-5 text-center d-flex align-items-center justify-content-center">
                    <a href="<?php echo $url;?>" class="btn-homepage me-2 mt-0"><i class="ri-arrow-left-line fw-normal"></i> GERİ DÖN</a>
                    <button type="submit" style="padding: 16px 16px 16px 73px;
border-radius: 28px;
background-color: #00b373;
display: inline-flex;
margin-top: 20px;
justify-content: space-between;
align-items: center;
font-size: 18px;
font-weight: 600;
text-align: left;
color: #fff;border:none;
" class="btn-complete ms-2 mt-0">ÖDEME YAP <i class="ri-arrow-right-line"></i></button>
                </div>    
             
				</form>
				
				
				
	<?php } ?>
				
				
				
				 </div> 
				 
				 </div>
            </div>
    </section>
	<script type="text/javascript">
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