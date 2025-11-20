<title>Üyelik Aktivasyonu</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		   <main class="main">
    
         

            <div class="page-content pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="about-text text-left">
                <?php  

				$email = temizle($_GET["email"]);
				$kod    = temizle($_GET["kod"]);

				if(!$email || !$kod){

					echo '<div  class="alert alert-warning">Gereken kodlar eksik veya boş görünüyor.</div>';


				}else {


					$emailgeldi = $ozy->prepare("select * from users where email=? and kod=?");
					$emailgeldi->execute(array($email,$kod));
					$emailgeldi->fetch(PDO::FETCH_ASSOC);
					$kontrolet = $emailgeldi->rowCount(); 

					if($kontrolet){

						$guncelle = $ozy->prepare("update users set onay=? where email=? and kod=?"); 

						$ok =  $guncelle->execute(array(1,$email,$kod)); 

						if($ok == true){

							echo '<div class="alert alert-warning">Üyeliğiniz başarıyla aktif edildi. Sisteme giriş yapabilirsiniz.</div>'; 


						}else	{

							echo '<div class="alert alert-warning">Onaylama başarısız. Veritabanı hatası oluştu.</div>'; 


						}


					}else {

						echo '<div  class="alert alert-warning">Onay kodu yanlış veya daha önce onaylanmış.</div>'; 

					}


				}



				?>
                               
                            </div><!-- End .about-text -->
                        </div><!-- End .col-lg-10 offset-1 -->
                    </div><!-- End .row -->
                    
                </div><!-- End .container -->

                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>