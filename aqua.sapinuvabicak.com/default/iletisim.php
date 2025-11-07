<title>Bize Ulaşın</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Bize Ulaşın"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>


		  
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Bize Ulaşın<span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bize Ulaşın</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            	<div class="mb-5">
				<iframe  src="<?php echo $ayar['maps']; ?>" style="border:0;margin-top: -15px;" allowfullscreen="" width="100%" height="420" frameborder="0"></iframe>
                  
				</div><!-- End #map -->
                <div class="container">
                	<div class="row">
                		<div class="col-md-4">
                			<div class="contact-box text-center">
        						<h3>İletişim Adresimiz</h3>

        						<address><?php echo $ayar['adres']; ?></address>
        					</div><!-- End .contact-box -->
                		</div><!-- End .col-md-4 -->

                		<div class="col-md-4">
                			<div class="contact-box text-center">
        						<h3>Müşteri Hizmetleri</h3>

        						<div><a href="mailto:<?php echo $ayar['email']; ?>"><?php echo $ayar['email']; ?></a></div>
        						<div><a href="tel:<?php echo $ayar['tel']; ?>"><?php echo $ayar['tel']; ?></a>, <a href="tel:<?php echo $ayar['ceptel']; ?>"><?php echo $ayar['ceptel']; ?></a></div>
        					</div><!-- End .contact-box -->
                		</div><!-- End .col-md-4 -->

                		<div class="col-md-4">
                			<div class="contact-box text-center">
        						<h3>Sosyal Medya Hesaplarımız</h3>

        		<div class="social-icons social-icons-color justify-content-center">
			    <a <?php echo $ayar['facebook'] == '' ? 'style="display:none;"' : null; ?> href="<?php echo $ayar['facebook']; ?>" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
				<a <?php echo $ayar['twitter'] == '' ? 'style="display:none;"' : null; ?> href="<?php echo $ayar['twitter']; ?>" class="social-icon" target="_blank" title="X"><img src="resimler/siteayarlari/x.png" alt="X" style="width:16px; height:16px;"></a>
                <a <?php echo $ayar['pinterest'] == '' ? 'style="display:none;"' : null; ?> href="<?php echo $ayar['pinterest']; ?>" class="social-icon" target="_blank" title="pinterest"><i class="icon-pinterest"></i></a>
                <a <?php echo $ayar['linkedin'] == '' ? 'style="display:none;"' : null; ?> href="<?php echo $ayar['linkedin']; ?>" class="social-icon" target="_blank" title="linkedin	"><i class="icon-linkedin"></i></a>
                <a <?php echo $ayar['instagram'] == '' ? 'style="display:none;"' : null; ?> href="<?php echo $ayar['instagram']; ?>" class="social-icon" target="_blank" title="instagram"><i class="icon-instagram"></i></a>
                <a <?php echo $ayar['youtube'] == '' ? 'style="display:none;"' : null; ?> href="<?php echo $ayar['youtube']; ?>" class="social-icon" target="_blank" title="youtube"><i class="icon-youtube"></i></a>
                <a <?php echo $ayar['googleplus'] == '' ? 'style="display:none;"' : null; ?> href="<?php echo $ayar['googleplus']; ?>" class="social-icon" target="_blank" title="googleplus"><i class="icon-google-plus"></i></a>
               </div><!-- End .soial-icons -->
        					</div><!-- End .contact-box -->
                		</div><!-- End .col-md-4 -->
                	</div><!-- End .row -->

                	<hr class="mt-3 mb-5 mt-md-1">
                	<div class="touch-container row justify-content-center">
                		<div class="col-md-9 col-lg-7">
                			<div class="text-center">
                			<h2 class="title mb-1">İletişim Formu</h2><!-- End .title mb-2 -->
                			<p class="lead text-primary">
                				Aklınıza takılan tüm soruları bizlere bu form üzerinden yazabilirsiniz.
                			</p><!-- End .lead text-primary -->
                			</div><!-- End .text-center -->

                			<form action="#" class="contact-form mb-2" method="POST">
                				<div class="row">
                					<div class="col-sm-4">
                                        <label for="cname" class="sr-only">Adınız Soyadınız</label>
                						<input type="text" class="form-control" id="cname" name="isim" placeholder="Adınız Soyadınız" value="<?php echo $uyebilgileri['isim'];?>" required>
                					</div><!-- End .col-sm-4 -->

                					<div class="col-sm-4">
                                        <label for="cemail" class="sr-only">Eposta Adresiniz</label>
                						<input type="email" class="form-control" id="cemail" name="eposta" placeholder="Eposta Adresiniz" value="<?php echo $uyebilgileri['email'];?>" required>
                					</div><!-- End .col-sm-4 -->

                					<div class="col-sm-4">
                                        <label for="cphone" class="sr-only">Telefon Numaranız</label>
                						<input type="tel" class="form-control" id="cphone" name="telefon" placeholder="Telefon Numaranız" value="<?php echo $uyebilgileri['telefon'];?>" required>
                					</div><!-- End .col-sm-4 -->
									
                				</div><!-- End .row -->

                                <label for="csubject" class="sr-only">Konu</label>
        						<input type="text" class="form-control" id="csubject" name="konu" placeholder="Konu">

                                <label for="cmessage" class="sr-only">Mesajınız</label>
                				<textarea class="form-control" cols="30" rows="4" id="cmessage" name="mesaj" required placeholder="Mesajınız"></textarea>
								<div class="row">
								<div class="col-sm-6">
								<img class="guvenlik_resmi" style="width: 170px;height: 39.7px;" src="<?php echo $sitetemasi;?>/captcha.php">
								<div style="float: right;margin-top: -39.5px;background: red;border: 1px solid red;color: white;" class="yenile_buton btn btn-outline-primary-2">Yenile</div>
								</div>
								<div class="col-sm-6">
			                    <input type="text" placeholder="Güvenlik Kodunu Giriniz" name="captcha" class="form-control" required>
								</div>
								</div><!-- End .row -->
								<div class="text-center">
	                				<button type="submit" name="mesajgonder" class="btn btn-outline-primary-2 btn-minwidth-sm">
	                					<span>GÖNDER</span>
	            						<i class="icon-long-arrow-right"></i>
	                				</button>
                				</div><!-- End .text-center -->
                			</form><!-- End .contact-form -->
                		</div><!-- End .col-md-9 col-lg-7 -->
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main>