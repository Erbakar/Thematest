<title>Fırsat Ürünleri</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Fırsat Ürünleri"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
 
  <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Fırsat Ürünleri</h2>
        </div>
    </section>
  
		
        <section class="bestsellers mt-5 pt-5 pb-5">
            <div class="container-lg">
               
                <div class="row mt-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 productlist">
                <?php $ukzzz = $ozy->query("select * from urunler where durum='1' and firsat='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                foreach($ukzzz as $gfirsat){?>     
                               
                            <div class="col">
                            <div class="item">
                                <div class="img">
                                <span class="d-flex bdgs">
								    <?php if($gfirsat['ucretsizkargo']=='1'){?>
                                    <span class="bdg green">Ücretsiz Kargo!</span>
									<?php } ?> 
									<?php if($gfirsat['idurum']=='1'){?>
                                    <span class="bdg orange">%<?php echo yuzdeHesaplama($gfirsat['fiyat'],$gfirsat['ifiyat']);?> İndirimli</span>    
                                    <?php } ?> 
									</span>
                                    <a href="urun/<?php echo $gfirsat['seo']; ?>">
                                        <img src="resimler/urunler/<?php echo $gfirsat['resim']; ?>" width="238" height="175" class="img-fluid" alt="">
                                    </a>
                                </div>
                                <a href="urun/<?php echo $gfirsat['seo']; ?>" class="title"><h3><?php echo $gfirsat['adi']; ?></h3></a>
                                <div class="pb">
                                    <?php echo xurunfiyatbelirle($gfirsat['kdv'],$gfirsat['idurum'],$gfirsat['fiyat'],$gfirsat['ifiyat']);?>
                                    <a href="urun/<?php echo $gfirsat['seo']; ?>" class="addcart">SEPETE EKLE</a>
                                </div>
                            </div>
                        </div>
						
						<?php } ?>	
						
                   
				   </div>
            </div>
        </section>

       