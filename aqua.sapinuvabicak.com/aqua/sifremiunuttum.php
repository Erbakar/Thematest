<title>Şifremi Unuttum</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>


      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Şifremi Unuttum</h2>
        </div>
    </section>
 
  <section class="page cart pt-5 pb-5" style="margin-bottom:30px;">
            <div class="container-lg">
              
                <div class="row">
			
				<div class="form-group mb-4" style="padding: 0px !important;">
                        <div class="head">
                           ŞİFREMİ UNUTTUM
                        </div>
                        <div class="body">
					<form action="" method="POST">
                            <div class="row">
							 <div class="group mb-2">
                           <input type="text" class="form-control" name="sadsoyad" placeholder="Adınız Soyadınız..." required>
                        </div>
								
								
								<?php if($system['sifrehatirlat']=='1'){?>		
                                <div class="col-lg-6">
                                    <div class="form-radio">
                                        <input class="form-check-input" value="0" name="yeniletip" type="radio" id="hesap1" required>
                                        <label class="form-check-label" for="hesap1">
                                          Eposta ile Şifre Alma
                                        </label>
                                    </div>
                                </div>
                              <?php } ?>
							  
							  <?php if($system['ssifrehatirlat']=='1'){?>
                                <div class="col-lg-6">
                                    <div class="form-radio mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                        <input class="form-check-input" value="1" name="yeniletip" type="radio" id="hesap3" required>
                                        <label class="form-check-label" for="hesap3">
                                            SMS ile Şifre Alma
                                        </label>
                                    </div>
                                </div>
								<?php } ?>
								
								
						<div class="group mb-4" id="bireysel" style="display:none;margin-top:20px;">
                           <input type="email" class="form-control" name="seposta" placeholder="Eposta Adresiniz...">
                        </div>
								
								
							<div class="group mb-4" id="kurumsal" style="display:none;margin-top:20px;">
                           <input type="tel" class="form-control" name="stelefon" placeholder="Telefon Numaranız...">
                        </div>
									
								<div class="group mb-4">
							<button type="submit" name="sifremiunuttum" class="gonderbuton">
                                                ŞİFREMİ UNUTTUM
                                               
                                            </button>	
								 </div>
								
								
                            </div>
							</form>
                        </div>
                    </div>
							
			    
                </div>
            </div>
        </section>