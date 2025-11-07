<?php
session_destroy();
header("Refresh: 2; url=".$url."");
ob_end_flush();
?>
<title>Sistemden Çıkış</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>



      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Çıkış</h2>
        </div>
    </section>
 
  <section class="banner mt-5" style="margin-bottom:30px;">
            <div class="container-lg">
              
                <div class="row">
			<div class="col-sm-12 customer-login" style="text-align: center;padding: 10px;">
						
				
					<h4 style="font-weight: bold;
font-size: 20px;">Oturumunuz başarıyla kapatıldı.</h4></br>
                        <h5 style="font-weight: bold;
font-size: 18px;">Tekrar görüşmek üzere :)</h5>

						
				 </div> 	  	
					
			    
                </div>
            </div>
        </section>