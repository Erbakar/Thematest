<title>Bize Ulaşın</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Bize Ulaşın"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>


		  
		   <main class="main">
      
       
        <div class="page-content" style="margin-top:10px;">
            	<div class="mb-5">
				<iframe  src="<?php echo $ayar['maps']; ?>" style="border:0;margin-top: -15px;" allowfullscreen="" width="100%" height="420" frameborder="0"></iframe>
                  
				</div><!-- End #map -->
                <div class="container">
                	<div class="row" style="border: 1px solid #eee;
border-radius: 15px;
padding: 10px;
margin-bottom: 10px;">
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
			   <ul class="cl-footer-col-list">

  <li class="cl-footer-col-list-item" <?php echo $ayar['facebook'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['facebook']; ?>" class="social-icon" target="_blank" title="Facebook"><i class="fa fa-facebook"></i>&nbsp;Facebook</a></li>
                <li class="cl-footer-col-list-item" <?php echo $ayar['twitter'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['twitter']; ?>" class="social-icon" target="_blank" title="Twitter"><i class="fa fa-twitter"></i>&nbsp;Twitter</a></li>
               <li class="cl-footer-col-list-item" <?php echo $ayar['instagram'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['instagram']; ?>" class="social-icon" target="_blank" title="instagram"><i class="fa fa-instagram"></i>&nbsp;İnstagram</a></li>
              <li class="cl-footer-col-list-item" <?php echo $ayar['pinterest'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['pinterest']; ?>" class="social-icon" target="_blank" title="instagram"><i class="fa fa-pinterest"></i>&nbsp;Pinterest</a></li>
              <li class="cl-footer-col-list-item" <?php echo $ayar['youtube'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['instagram']; ?>" class="social-icon" target="_blank" title="youtube"><i class="fa fa-youtube"></i>&nbsp;Youtube</a></li>
              <li class="cl-footer-col-list-item" <?php echo $ayar['linkedin'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['linkedin']; ?>" class="social-icon" target="_blank" title="instagram"><i class="fa fa-linkedin"></i>&nbsp;Linkedin</a></li>
             


</ul> </div><!-- End .soial-icons -->
        					</div><!-- End .contact-box -->
                		</div><!-- End .col-md-4 -->
                	</div><!-- End .row -->

                	<hr class="mt-3 mb-5 mt-md-1">
                	<div class="touch-container row justify-content-center" style="border: 1px solid #eee;
border-radius: 15px;
padding: 10px;
margin-bottom: 10px;">
                		<div class="col-md-12 col-lg-12">
				<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend>İletişim Formu</legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name">Adınız Soyadınız</label>
            <div class="col-sm-10">
              <input style="text-align: left;" type="text" name="isim" id="input-name" class="form-control" required>
                          </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email">E-Posta</label>
            <div class="col-sm-10">
              <input style="text-align: left;" type="text" name="email" value="" id="input-email" class="form-control" required>
                          </div>
          </div>
		  
		     <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email">Telefon</label>
            <div class="col-sm-10">
              <input style="text-align: left;" type="tel" name="telefon" value=""  class="form-control" required>
                          </div>
          </div>
		  
		  
		    <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name">Konu</label>
            <div class="col-sm-10">
              <input style="text-align: left;" type="text" name="konu" class="form-control" required>
                          </div>
          </div>
		  
		  	   
		  
		  
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-enquiry">Mesajınız</label>
            <div class="col-sm-10">
              <textarea style="text-align: left;"  name="mesaj" rows="10" id="input-enquiry" class="form-control" required></textarea>
                          </div>
          </div>
		  
		  
		   <div class="form-group required">
            <label class="col-sm-5 control-label"for="input-name">Güvenlik Kodu <img class="guvenlik_resmi" style="width: 170px;height: 39.7px;" src="<?php echo $sitetemasi;?>/captcha.php"><div style="background: red;border: 1px solid red;color: white;" class="yenile_buton btn btn-outline-primary-2">Yenile</div>
			</label>
            <div class="col-sm-10" style="margin-top: 10px;
width: 61%;">
								
              <input style="text-align: left;" type="text" placeholder="Güvenlik Kodunu Giriniz" name="captcha" class="form-control" required>
                          </div>
          </div>
		  
		  
		  
		  
		  
		  
		  
		  
                  </fieldset>
        <div class="buttons">
          <div class="pull">
            <input class="butonok btn btn-primary" name="mesajgonder" type="submit" value="Gönder">
          </div>
        </div>
      </form>
                		</div><!-- End .col-md-9 col-lg-7 -->
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main>
		<style>
		.col-sm-10 {
    -ms-flex: 0 0 83.333333%;
    flex: 0 0 83.333333%;
    max-width: 83.333333%;
    max-width: 100% !important;
    width: 100% !important;
}
.cl-footer-col-list-item a {
    color: #030303;
    text-decoration: none;
    width: 100%;
}
.cl-footer-col-list-item {
    font-size: 12px;
    font-weight: 300;
    margin: 0 0 10px;
    list-style: none;
    line-height: 24px;
    padding: 0 12px;
    display: flex;
    border-radius: 20px;
    transition: background-color .3s;
    width: -moz-fit-content;
    width: fit-content;
    float: left;
}
		</style>