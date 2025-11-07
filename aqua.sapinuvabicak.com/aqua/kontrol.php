<title>Alışveriş Sepetim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
 

      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Üye Girişi / Kayıt Ol</h2>
        </div>
    </section>
 
  <section class="page login pt-5 pb-5">
        <div class="container pt-5 pb-5">
            <div class="row content">
			
			
			
			<?php if($system['misafirok']=='1'){?>
			
			
			
			
			
			
			
			
<div class="col-lg-4 mb-0" style="background: #fcfcfc;
padding: 20px;">
                    <form action="" method="POST" enctype="multipart/form-data">
					<div class="title" style="font-size: 24px;
font-weight: 600;
text-align: left;

margin-bottom: 30px;text-align: center;">Üye Girişi</div>
					<input type="hidden" name="nereden" value="kontrol"/>
                        <div class="group mb-4">
                            <label class="d-flex align-items-center"><i class="ri-mail-open-line me-3"></i> E-Posta Adresi</label>
                            <input type="email" class="form-control" name="email" placeholder="E-Posta Adresinizi giriniz..." required>
                        </div>
                            <div class="group mb-4">
                            <label class="d-flex align-items-center"><i class="ri-lock-password-line me-3"></i> Parolanız</label>
                            <input type="password" class="form-control" name="sifre" placeholder="Şifrenizi giriniz..." required>
                        </div>
                        <div class="group mb-4 text-left">
                            <a href="sifremiunuttum/" class="lostpass">Şifremi Unuttum</a>
                        </div>
                        <div class="group">
                            <button type="submit" name="girisyap" class="submit">Giriş Yap</button>
                        </div>
                    </form>
                </div>
				
				<div class="col-lg-3 mb-0" style="background: #f5f7fc;
padding: 20px;">
                   
					<div class="title" style="font-size: 24px;
font-weight: 600;
text-align: left;

margin-bottom: 30px;text-align: center;">Misafir Alışverişi</div>
					
                        <div class="group mb-4">
<img  style="width: 300px;
display: block;" src="<?php echo $sitetemasi;?>/user/misafir.png"></img>
	<b style="text-align: center;
display: block;
font-weight: 500;
margin-top: 10%;">Dilerseniz sitemize üye olmadanda alışverişinizi hızlı bir şekilde tamamlayabilirsiniz.
	</b>					
					
						<div class="bottom-form">
										<a style="display: block;
width: 100%;
padding: 15px;
margin: 8px 0;
  margin-top: 8px;
font-size: 18px;
margin-top: 12%;
background: white;
color: #3fbafe;
font-weight: 500;
border: 1px solid #3fbafe;" href="odeme/" class="btn btn-success">Üyeliksiz Devam Et</a>
						</div>
                        </div>
                    
                   
                </div>
				
				
				
                <div class="col-lg-5 d-flex align-items-end justify-content-end">
                    <div class="box w-100 mt-xl-0 mt-lg-0 mt-md-5 mt-sm-5 mt-5">
                        <div class="title" style="text-align: center;">Hesap Oluştur</div>
                       <form action="" method="POST" enctype="multipart/form-data">
					  <input type="hidden" name="nereden" value="kontrol"/>
					    <div class="group mb-4">
                            <label class="d-flex align-items-center" style="color: white;"><i style="color: white;" class="ri-user-3-line me-3"></i> Adınız Soyadınız</label>
                            <input type="text" class="form-control" name="isim" placeholder="Adınız Soyadınız..." required>
                        </div>
                        <div class="group mb-4">
                            <label class="d-flex align-items-center" style="color: white;"><i style="color: white;" class="ri-mail-open-line me-3"></i> E-Posta Adresi</label>
                            <input type="email" class="form-control" name="email" placeholder="E-Posta Adresinizi giriniz..." required>
                        </div>
						
						 <div class="group mb-4">
                            <label class="d-flex align-items-center" style="color: white;"><i style="color: white;" class="ri-key-line me-3"></i> Şifreniz</label>
                            <input type="password" class="form-control" name="sifre" placeholder="Şifreniz..." required>
                        </div>
						
						<div class="group mb-4">
                            <label class="d-flex align-items-center" style="color: white;"><i style="color: white;" class="ri-phone-line me-3"></i> Telefon</label>
                            <input type="tel" class="form-control" name="telefon" placeholder="Telefon Numaranız..." required>
                        </div>
						
						<div class="group mb-4">
                            <div style="padding: 0px !important;" class="form-check form-check-inline d-flex align-items-center">
                                <input id="sozlesmeaboneligi" class="styled-checkbox" name="sozlesme" type="checkbox" value="1" required>
                                <label for="sozlesmeaboneligi"><a style="color:white;" target="_blank" href="rizametni/">Üyelik Sözleşmesini ve rıza metnini okudum ,</a> kabul ediyorum *</label>
                            </div>
                        </div>
						
						
						  <div class="group mb-4">
                            <div  style="padding: 0px !important;" class="form-check form-check-inline d-flex align-items-center">
                                <input id="bultenaboneligi" class="styled-checkbox" name="ebultensor" type="checkbox" value="1">
                                <label for="bultenaboneligi">Bülten Aboneliğini onaylıyorum.</label>
                            </div>
                        </div>
						
						
                        <button style="border: 0;
background-color: #feffff;
display: inline-flex;
margin-top: 20px;
justify-content: space-between;
align-items: center;
font-size: 18px;
font-weight: 600;
color: #151515;
padding: 20px;
width: 100%;
text-align: center;" type="submit" name="kayitol" class="register">Hemen Kayıt Ol <i class="ri-arrow-right-line"></i></button>
                     </form>
					</div>
                </div>
				
			
			
			<style>
			section.login .box {
  background: #3fbafe;
  border-radius: 2px;
  padding: 15px;
}
			</style>
			
			
			
			
			
			
			
			<?php } else { ?>	
			
			
			
			
			
                <div class="col-lg-5 mb-0" style="background: #fcfcfc;
padding: 20px;">
                    <form action="" method="POST" enctype="multipart/form-data">
					<div class="title" style="font-size: 24px;
font-weight: 600;
text-align: left;text-align: center;

margin-bottom: 30px;">Üye Girişi</div>
					<input type="hidden" name="nereden" value="kontrol"/>
                        <div class="group mb-4">
                            <label class="d-flex align-items-center"><i class="ri-mail-open-line me-3"></i> E-Posta Adresi</label>
                            <input type="email" class="form-control" name="email" placeholder="E-Posta Adresinizi giriniz..." required>
                        </div>
                            <div class="group mb-4">
                            <label class="d-flex align-items-center"><i class="ri-lock-password-line me-3"></i> Parolanız</label>
                            <input type="password" class="form-control" name="sifre" placeholder="Şifrenizi giriniz..." required>
                        </div>
                        <div class="group mb-4 text-left">
                            <a href="sifremiunuttum/" class="lostpass">Şifremi Unuttum</a>
                        </div>
                        <div class="group">
                            <button type="submit" name="girisyap" class="submit">Giriş Yap</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-7 d-flex align-items-end justify-content-end">
                    <div class="box w-100 mt-xl-0 mt-lg-0 mt-md-5 mt-sm-5 mt-5">
                        <div class="title" style="text-align: center;">Hesap Oluştur</div>
                       <form action="" method="POST" enctype="multipart/form-data">
					  <input type="hidden" name="nereden" value="kontrol"/>
					    <div class="group mb-4">
                            <label class="d-flex align-items-center" style="color: white;"><i style="color: white;" class="ri-user-3-line me-3"></i> Adınız Soyadınız</label>
                            <input type="text" class="form-control" name="isim" placeholder="Adınız Soyadınız..." required>
                        </div>
                        <div class="group mb-4">
                            <label class="d-flex align-items-center" style="color: white;"><i style="color: white;" class="ri-mail-open-line me-3"></i> E-Posta Adresi</label>
                            <input type="email" class="form-control" name="email" placeholder="E-Posta Adresinizi giriniz..." required>
                        </div>
						
						 <div class="group mb-4">
                            <label class="d-flex align-items-center" style="color: white;"><i style="color: white;" class="ri-key-line me-3"></i> Şifreniz</label>
                            <input type="password" class="form-control" name="sifre" placeholder="Şifreniz..." required>
                        </div>
						
						<div class="group mb-4">
                            <label class="d-flex align-items-center" style="color: white;"><i style="color: white;" class="ri-phone-line me-3"></i> Telefon</label>
                            <input type="tel" class="form-control" name="telefon" placeholder="Telefon Numaranız..." required>
                        </div>
						
						<div class="group mb-4">
                            <div class="form-check form-check-inline d-flex align-items-center">
                                <input id="sozlesmeaboneligi" class="styled-checkbox" name="sozlesme" type="checkbox" value="1" required>
                                <label for="sozlesmeaboneligi"><a style="color:white;" target="_blank" href="rizametni/">Üyelik Sözleşmesini ve rıza metnini okudum ,</a> kabul ediyorum *</label>
                            </div>
                        </div>
						
						
						  <div class="group mb-4">
                            <div class="form-check form-check-inline d-flex align-items-center">
                                <input id="bultenaboneligi" class="styled-checkbox" name="ebultensor" type="checkbox" value="1">
                                <label for="bultenaboneligi">Bülten Aboneliğini onaylıyorum.</label>
                            </div>
                        </div>
						
						
                        <button style="border: 0;
background-color: #feffff;
display: inline-flex;
margin-top: 20px;
justify-content: space-between;
align-items: center;
font-size: 18px;
font-weight: 600;
color: #151515;
padding: 20px;
width: 100%;
text-align: center;" type="submit" name="kayitol" class="register">Hemen Kayıt Ol <i class="ri-arrow-right-line"></i></button>
                     </form>
					</div>
                </div>
				
				
				
				<?php } ?>	
				  
				
				
				
				
				
            </div>
        </div>
    </section>
	<style>
	.mb-4 {
  margin-bottom: 5px !important;
}
	</style>