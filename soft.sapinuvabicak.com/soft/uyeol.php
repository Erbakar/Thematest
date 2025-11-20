<title>Üye Girişi / Kayıt Ol</title>
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
						
					
						
					                <div class="col-lg-6" style="border: 1px solid #ebe7e7;padding: 30px;">
			                        <h6 style="text-align: center;background: #f8f8f8;padding: 10px;">Üye Girişi</h6>
			                        <form action="" method="POST">
									<input type="hidden" name="nereden" value="anauyelik"/>
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
 

											   <a style="" href="sifremiunuttum/" class="forgot-link">Şifremi Unuttum ?</a>
                                                                                   
											<button type="submit" name="girisyap" class="butonok btn btn-outline-primary-2">
                                                <span>GİRİŞ YAP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                          
                                          
                                        </div><!-- End .form-footer -->
                                    </form>
			
			               </div>
	                	
					
						
						
					<div class="col-lg-6" style="border: 1px solid #ebe7e7;padding: 30px;">
					<h6 style="text-align: center;background: #f8f8f8;padding: 10px;">Üyelik Kaydı</h6>
                          <form action="" method="POST">
									    <input type="hidden" name="nereden" value="anauyelik"/>
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
                                                <label class="custom-control-label" for="register-policy"><a data-toggle="modal" data-target=".bannerformmodal">Üyelik Sözleşmesini</a> kabul ediyorum *</label>
                                            </div><!-- End .custom-checkbox -->
											
											<div class="custom-control custom-checkbox" style="">
                                                <input type="checkbox" name="ebultensor" value="1" class="custom-control-input" id="register-policy2">
                                                <label class="custom-control-label" for="register-policy2">Ebültene kayıt olmak istiyorum</label>
                                            </div><!-- End .custom-checkbox -->
											 
                                        </div><!-- End .form-footer -->
										<button type="submit" name="kayitol" class="butonok btn btn-outline-primary-2">
                                                <span>KAYIT OL</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                    </form>
                    </div>	


						
						
						
						
						
						</div><!-- End .row -->
						
						
					

<div class="modal fade bannerformmodal" tabindex="-1" role="dialog" aria-labelledby="bannerformmodal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Üyelik Sözleşmesi</h4>
        </div>
        <div class="modal-body">
        <p><?php echo $system['rizametni'];?> </p>
        </div>
        <div class="modal-footer">
          <button style="background: <?php echo $tema['t8']; ?>;color: white;opacity: 1;font-size: 12px;padding: 10px;" type="button" class="butonok close" data-dismiss="modal" aria-hidden="true">Sözleşmeyi okudum ve kabul ediyorum.</button>
        </div>        
      </div>
    </div>
  </div>
</div>

<style>
.modal.in .modal-dialog {
    -webkit-transform: translate(0, 0);
    -ms-transform: translate(0, 0);
    -o-transform: translate(0, 0);
    transform: translate(0, 0);
    width: 50%;
    height:auto;
}
</style>

						
	                </div><!-- End .container -->
                </div>
                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>