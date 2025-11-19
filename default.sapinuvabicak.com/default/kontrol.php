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
						
						            <?php if($system['misafirok']=='1'){?>
						
			                        <div class="col-lg-4" style="border: 1px solid #ebe7e7;padding: 30px;border-right: none;">
			                        <h6 style="text-align: center;background: #f8f8f8;padding: 10px;">Üye Girişi</h6>
			                        <form action="" method="POST">
									<input type="hidden" name="nereden" value="kontrol"/>
                                        <div class="form-group">
                                            <label for="singin-email">Eposta Adresiniz *</label>
                                            <input type="text" class="form-control"  name="email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password">Şifreniz *</label>
                                            <input type="password" class="form-control"  name="sifre" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                               <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Beni Anımsa</label>
                                            </div><!-- End .custom-checkbox -->
 

											   <a style="margin-left: 5% !important;" href="sifremiunuttum/" class="forgot-link">Şifremi Unuttum ?</a>
                                         
											<button type="submit" name="girisyap" class="btn btn-outline-primary-2">
                                                <span>GİRİŞ YAP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                          
                                        </div><!-- End .form-footer -->
                                    </form>
			
			               </div>
	                	
						
						<div class="col-lg-4" style="border: 1px solid #ebe7e7;padding: 30px;border-right: none;">
						<h6 style="text-align: center;background: #f8f8f8;padding: 10px;">Misafir Alışverişi</h6>
						<div>
						Dilerseniz sitemize üye olmadanda alışverişinizi hızlı bir şekilde tamamlayabilirsiniz.
						</br></br>
						<a href="odeme/"><h6 style="text-align: center;background: #f8f8f8;padding: 10px;">ÜYELİKSİZ ALIŞVERİŞE DEVAM ET</h6></a></div>
						</div>
						
						
						
						
						
					<div class="col-lg-4" style="border: 1px solid #ebe7e7;padding: 30px;">
					<h6 style="text-align: center;background: #f8f8f8;padding: 10px;">Üyelik Kaydı</h6>
                          <form action="" method="POST">
									    <input type="hidden" name="nereden" value="kontrol"/>
                                        <div class="form-group">
                                            <label>Adınız Soyadınız *</label>
                                            <input type="text" class="form-control" name="isim" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="register-email">Eposta Adresiniz *</label>
                                            <input type="email" class="form-control" id="register-email" name="email" required>
                                        </div><!-- End .form-group -->
										 <div class="form-group">
                                            <label>Telefon Numaranız *</label>
                                            <input type="text" class="form-control" name="telefon" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="register-password">Şifreniz *</label>
                                            <input type="password" class="form-control" id="register-password" name="sifre" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                       

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="sozlesme" value="1" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy"><a target="_blank" href="rizametni/">Üyelik Sözleşmesini</a> kabul ediyorum *</label>
                                            </div><!-- End .custom-checkbox -->
											
											<div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="ebultensor" value="1" class="custom-control-input" id="register-policy2">
                                                <label class="custom-control-label" for="register-policy2">Ebültene kayıt olmak istiyorum</label>
                                            </div><!-- End .custom-checkbox -->
											 
                                        </div><!-- End .form-footer -->
										<button type="submit" name="kayitol" class="btn btn-outline-primary-2">
                                                <span>KAYIT OL</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                    </form>
                    </div>					
						
						
					<?php } else { ?>	
						
						
					                <div class="col-lg-6" style="border: 1px solid #ebe7e7;padding: 30px;">
			                        <h6 style="text-align: center;background: #f8f8f8;padding: 10px;">Üye Girişi</h6>
			                        <form action="" method="POST">
									<input type="hidden" name="nereden" value="kontrol"/>
                                        <div class="form-group">
                                            <label for="singin-email">Eposta Adresiniz *</label>
                                            <input type="text" class="form-control"  name="email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password">Şifreniz *</label>
                                            <input type="password" class="form-control"  name="sifre" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                               <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Beni Anımsa</label>
                                            </div><!-- End .custom-checkbox -->
 

											   <a style="margin-left: 5% !important;" href="sifremiunuttum/" class="forgot-link">Şifremi Unuttum ?</a>
                                         
											<button type="submit" name="girisyap" class="btn btn-outline-primary-2">
                                                <span>GİRİŞ YAP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                          
                                        </div><!-- End .form-footer -->
                                    </form>
			
			               </div>
	                	
					
						
						
					<div class="col-lg-6" style="border: 1px solid #ebe7e7;padding: 30px;">
					<h6 style="text-align: center;background: #f8f8f8;padding: 10px;">Üyelik Kaydı</h6>
                          <form action="" method="POST">
									    <input type="hidden" name="nereden" value="kontrol"/>
                                        <div class="form-group">
                                            <label>Adınız Soyadınız *</label>
                                            <input type="text" class="form-control" name="isim" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="register-email">Eposta Adresiniz *</label>
                                            <input type="email" class="form-control" id="register-email" name="email" required>
                                        </div><!-- End .form-group -->
										 <div class="form-group">
                                            <label>Telefon Numaranız *</label>
                                            <input type="text" class="form-control" name="telefon" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="register-password">Şifreniz *</label>
                                            <input type="password" class="form-control" id="register-password" name="sifre" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                       

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="sozlesme" value="1" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy"><a target="_blank" href="rizametni/">Üyelik Sözleşmesini</a> kabul ediyorum *</label>
                                            </div><!-- End .custom-checkbox -->
											
											<div class="custom-control custom-checkbox" style="margin-left: 10% !important;">
                                                <input type="checkbox" name="ebultensor" value="1" class="custom-control-input" id="register-policy2">
                                                <label class="custom-control-label" for="register-policy2">Ebültene kayıt olmak istiyorum</label>
                                            </div><!-- End .custom-checkbox -->
											 
                                        </div><!-- End .form-footer -->
										<button type="submit" name="kayitol" class="btn btn-outline-primary-2">
                                                <span>KAYIT OL</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                    </form>
                    </div>	


                     <?php } ?>					
						
						
						
						
						
						
						
						</div><!-- End .row -->
						
						
						
						
	                </div><!-- End .container -->
                </div>
                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>