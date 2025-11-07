<title>Kampanyalar</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Kampanyalar"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>



      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Kampanyalar</h2>
        </div>
    </section>
 
  <section class="banner mt-5" style="margin-bottom:30px;">
            <div class="container-lg">
              
                <div class="row">
			
			<?php 

     
        $pages = intval(temizle(@$_GET['pages']));
        if (!$pages) {
          $pages = 1;
        }
        
        $bak = $ozy->prepare("select * from kampanyalar where durum='1'");
        $bak->execute(array());
        $toplam= $bak->rowCount();
        $limit = 15000;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 200;
		
	
	
        $pr = $ozy->query("select * from kampanyalar where durum='1' order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
        



        $__URUN__ = false;
       foreach ($pr as $blog) {
        $__URUN__ = true;

                           ?>
					
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                        <a href="<?php if($blog['link']=='0'){?>kampanya/<?php echo $blog['seo']; ?><?php } else { ?><?php echo $blog['link']; ?><?php } ?>">
                            <img src="resimler/kampanyalar/<?php echo $blog['resim']; ?>" class="img-fluid" height="225" width="338" alt="">
                        </a>
                    </div>
					
					
				 <?php }

                        if (!$__URUN__){
                            echo "Henüz kampanya eklenmemiş.";
                        }

                         ?>	
				 	  	
					
			    
                </div>
            </div>
        </section>