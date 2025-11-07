<title>Bize Ulaşın</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>" />
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>" />
<meta property="og:url" content="<?php echo $url; ?>" />
<meta property="og:title" content="Bize Ulaşın" />
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>" />



      <section class="cover pt-5 pb-5">
        <div class="container-lg">
		<iframe src="<?php echo $ayar['maps']; ?>" allowfullscreen="" aria-hidden="false" tabindex="0" width="100%" height="550" frameborder="0"></iframe>
    
         
			
        </div>
    </section>
 
 <section class="contact pt-5 pb-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-6 mb-0">
                    <div class="card h-100">
                        <div class="card-header">
                            İletişim Bilgileri
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-auto col-lg-auto col-sm-12 col-12">
                                            <div class="icon blue"><i class="ri-map-pin-line"></i></div>
                                        </div>
                                        <div class="col txt">
                                            <strong>Adres:</strong>
                                            <p><?php echo $ayar['adres'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-auto col-lg-auto col-sm-12 col-12">
                                            <div class="icon orange"><i class="ri-phone-line"></i></div>
                                        </div>
                                        <div class="col txt">
                                            <strong>Telefon &amp; Gsm:</strong>
                                            <p>Tel: <?php echo $ayar['tel'];?><br>Gsm: <?php echo $ayar['ceptel'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-auto col-lg-auto col-sm-12 col-12">
                                            <div class="icon green"><i class="ri-mail-open-line"></i></div>
                                        </div>
                                        <div class="col txt">
                                            <strong>E-mail:</strong>
                                            <p><?php echo $ayar['email'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-auto col-lg-auto col-sm-12 col-12">
                                            <div class="icon black mb-0"><i class="ri-thumb-up-line"></i></div>
                                        </div>
                                        <div class="col txt">
                                            <strong>Sosyal Hesaplar:</strong>
                                            <ul>
                                                <li><a class="bg-facebook" href="<?php echo $ayar['facebook'];?>" title="Facebook"><i class="ri-facebook-fill"></i></a></li>
                                                <li><a class="bg-twitter" href="<?php echo $ayar['twitter'];?>" title="Twitter"><i class="ri-twitter-fill"></i></a></li>
                                                <li><a class="bg-youtube" href="<?php echo $ayar['youtube'];?>" title="Youtube"><i class="ri-youtube-fill"></i></a></li>
                                                <li><a class="bg-linkedin" href="<?php echo $ayar['linkedin'];?>" title="Linkedin"><i class="ri-linkedin-fill"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
                <div class="col-lg-6 mb-0">
                    <div class="card mt-xl-0 mt-lg-0 mt-md-5 mt-sm-5 mt-5">
                        <div class="card-header">
                            İletişim Formu
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Adınız ve Soyadınız</label>
                                            <input type="text" class="form-control" name="isim" placeholder="Lütfen adınızı ve soyadınızı giriniz." required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Telefon Numarası:</label>
                                            <input type="text" class="form-control" name="telefon" placeholder="Lütfen telefon numaranızı giriniz." required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>E-Posta Adresiniz:</label>
                                            <input type="email" class="form-control" name="email" placeholder="Lütfen eposta adresinizi giriniz." required>
                                        </div>
                                    </div>
									<div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Konu</label>
                                            <input type="text" class="form-control" name="konu" placeholder="Lütfen ilgili konuyu giriniz." required>
                                        </div>
                                    </div>
									
								
									<div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Güvenlik Kodu</label>
                                            <input type="text" class="form-control" name="captcha" placeholder="Lütfen güvenlik kodunu giriniz." required>
                                        </div>
                                    </div>
									
									<div class="col-lg-6">
                                        <div class="form-group">
                                        	<img class="guvenlik_resmi" style="width: 170px;
height: 60px;
margin-top: 11%;" src="<?php echo $sitetemasi;?>/captcha.php"> <div style="height: 60px;
line-height: 3;
position: absolute;
margin-top: 5%;
background: #615c5c;
color: white;
" class="guvenlikkodum yenile_buton btn btn-default buttonGray">Yenile</div>
								
										</div>
                                    </div>
								
									
                                    <div class="col-lg-12">
                                        <label>Mesajınız</label>
                                        <div class="form-group">
                                            <textarea class="form-control" required="" name="mesaj" placeholder="Lütfen mesajınızı yazınız"></textarea>
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-6 col-lg-6 col-sm-12 col-12 d-flex justify-content-end">
                                        <button style="width: 100%;" type="submit" name="mesajgonder"><span>Gönder</span><i class="ri-send-plane-2-line"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>