<title>Üye Girişi / Kayıt Ol</title>
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
                <div class="col-lg-5 mb-0" style="background: #fcfcfc;
padding: 20px;">
                    <form action="" method="POST" enctype="multipart/form-data">
					<div class="title" style="font-size: 24px;
font-weight: 600;
text-align: left;text-align: center;

margin-bottom: 30px;">Üye Girişi</div>
					<input type="hidden" name="nereden" value="anauyelik"/>
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
					  <input type="hidden" name="nereden" value="anauyelik"/>
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
            </div>
        </div>
    </section>