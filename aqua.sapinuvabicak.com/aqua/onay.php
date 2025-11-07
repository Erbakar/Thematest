<title>Üyelik Aktivasyonu</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>



      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Üyelik Aktivasyonu</h2>
        </div>
    </section>
 
  <section class="banner mt-5" style="margin-bottom:30px;">
            <div class="container-lg">
              
                <div class="row">
					<div class="col-sm-12 customer-login" style="text-align: center;border: 1px solid #d4d2d2;padding: 10px;">
						
					
						<?php  

				$email = temizle($_GET["email"]);
				$kod    = temizle($_GET["kod"]);

				if(!$email || !$kod){

					echo '<div  class="alert alert-warning" style="  background: red;
  padding: 10px;
  color: white;
  font-weight: 500;">Gereken kodlar eksik veya boş görünüyor.</div>';


				}else {


					$emailgeldi = $ozy->prepare("select * from users where email=? and kod=?");
					$emailgeldi->execute(array($email,$kod));
					$emailgeldi->fetch(PDO::FETCH_ASSOC);
					$kontrolet = $emailgeldi->rowCount(); 

					if($kontrolet){

						$guncelle = $ozy->prepare("update users set onay=? where email=? and kod=?"); 

						$ok =  $guncelle->execute(array(1,$email,$kod)); 

						if($ok == true){

							echo '<div class="alert alert-warning" style="background: #54d625;
padding: 10px;
color: white;
font-weight: 500;">Üyeliğiniz başarıyla aktif edildi. Sisteme giriş yapabilirsiniz.</div>'; 


						}else	{

							echo '<div class="alert alert-warning" style="  background: red;
  padding: 10px;
  color: white;
  font-weight: 500;">Onaylama başarısız. Veritabanı hatası oluştu.</div>'; 


						}


					}else {

						echo '<div  class="alert alert-warning" style="  background: red;
  padding: 10px;
  color: white;
  font-weight: 500;">Onay kodu yanlış veya daha önce onaylanmış.</div>'; 

					}


				}



				?>
						
								</div>
			    
                </div>
            </div>
        </section>