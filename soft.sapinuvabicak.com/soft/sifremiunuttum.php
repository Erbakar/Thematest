<title>Şifremi Unuttum</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
 
	
		   <main class="main">

		
            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
    
            			<form action="" method="POST"/>
		                	<div class="row">
		                		<div class="col-lg-12" style="border-radius: 16px;
border: 1px solid #ebe7e7;
padding: 30px;
margin-top: 10px;
margin-bottom: 10px;">
		                			<h5 class="checkout-title">Şifremi Unuttum</h5><!-- End .checkout-title -->
		                				<div class="row">
							
							
							<div class="col-sm-12">			
						    <div class="md-form md-outline">
							<input name="sadsoyad" type="text" class="form-control" required>
                            <label for="form15" class="active">Adınız ve Soyadınız</label>
                            </div>
				            </div>
							
							
							<div class="col-sm-12">	
                            <?php if($system['sifrehatirlat']=='1'){?>							
						    <div class="md-form md-outline" style="width: 48%;float: left;">
						    <div class="kutu">
							<input value="0" name="yeniletip" type="radio" class="login-check" id="register-check-20" required> 
							Eposta ile Şifre Alma
						    </div>
                            <label for="form15" class="active">Şifre Hatırlatma</label>
                            </div>
							<?php } ?>
							<?php if($system['ssifrehatirlat']=='1'){?>
				            <div class="md-form md-outline" style="width: 48%;float: left;margin-left: 4%;">
						    <div class="kutu">
							<input  value="1" name="yeniletip" type="radio" class="login-check" id="register-check-20" required> 
							SMS ile Şifre Alma
						    </div>
                            <label for="form15" class="active">Şifre Hatırlatma</label>
                            </div>
							<?php } ?>
				            </div>
							
			
							
							<div class="col-sm-12" id="bireysel" style="display:none;">			
						    <div class="md-form md-outline">
							<input name="seposta" type="email"  class="form-control">
                            <label for="form15" class="active">Eposta Adresiniz</label>
                            </div>
				            </div>
							
							<div class="col-sm-12" id="kurumsal" style="display:none;">			
						    <div class="md-form md-outline">
							<input name="stelefon" type="text"  class="form-control" size="11" maxlength="11">
                            <label for="form15" class="active">Telefon Numaranız</label>
                            </div>
				            </div>
							
	                		


							

	                			</div><!-- End .col-lg-9 -->
		                			<button type="submit" name="sifremiunuttum" class="butonok btn btn-outline-primary-2">
                                                <span>ŞİFREMİ UNUTTUM</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
		                	</div><!-- End .row -->
							
							
							
							
							
            			</form>
						
						
					
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div>
			</div>
        </main>