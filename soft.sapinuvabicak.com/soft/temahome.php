    <title><?php echo $ayar['siteadi']; ?></title>
    <meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
    <meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
	<meta property="og:url" content="<?php echo $url; ?>"/>
    <meta property="og:title" content="<?php echo $ayar['siteadi']; ?>"/>
    <meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
 

    





            

    <div class="cl-page-row mobile-story-row hide">
        <div class="swiper-container cl-fluid-slider cl-swiper-slider" data-type="story">
            <div class="swiper-wrapper">
			
			
			<?php $kati = $ozy->query("select * from kategoriler where durum='1' and ikongoster='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
            foreach($kati as $kategori){?>
			
                    <div class="swiper-slide">
                        <div class="cl-story-item">
                            <a href="kategori/<?php echo $kategori['seo']; ?>" class="cl-banner-images">
                                <?php if(!empty($kategori['ikon']) && $kategori['ikon'] != ''){ ?>
                                    <img class="swiper-lazy" src="resimler/kategoriler/<?php echo $kategori['ikon']; ?>" data-src="resimler/kategoriler/<?php echo $kategori['ikon']; ?>" alt="<?php echo $kategori['adi']; ?>">
                                <?php } else { 
                                    $renk1 = !empty($kategori['renk']) && $kategori['renk'] != '' ? $kategori['renk'] : '#667eea';
                                    $renk2 = !empty($kategori['renk']) && $kategori['renk'] != '' ? (strlen($kategori['renk']) == 7 ? $kategori['renk'].'dd' : '#764ba2') : '#764ba2';
                                ?>
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, <?php echo $renk1; ?> 0%, <?php echo $renk2; ?> 100%); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 24px; font-weight: bold; color: white; text-transform: uppercase; min-height: 80px;">
                                        <?php echo mb_substr($kategori['adi'], 0, 1, 'UTF-8'); ?>
                                    </div>
                                <?php } ?>
                            </a>
                            <div class="cl-banner-info">
                                <a href="kategori/<?php echo $kategori['seo']; ?>"><?php echo $kategori['adi']; ?></a>
                            </div>
                        </div>
                    </div>
            <?php } ?>     

            <?php $kk = $ozy->query("select * from kampanyalar where durum='1' order by sira DESC")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($kk as $kampi) {?>			
                    <div class="swiper-slide">
                        <div class="cl-story-item">
                            <a href="<?php echo $kampi["link"] == "0" ? "kampanya/".$kampi["seo"]."" : "".$kampi["link"].""; ?>" class="cl-banner-images">
                                <img class="swiper-lazy" src="resimler/kampanyalar/<?php echo $kampi['resim']; ?>" data-src="resimler/kampanyalar/<?php echo $kampi['resim']; ?>">
                            </a>
                            <div class="cl-banner-info">
                                <a href="<?php echo $kampi["link"] == "0" ? "kampanya/".$kampi["seo"]."" : "".$kampi["link"].""; ?>"><?php echo $kampi['adi']; ?></a>
                            </div>
                        </div>
                    </div>
                 <?php } ?>       
               
                  
					
					
					
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

        
    <?php $slider = $ozy->query("select * from slider where durum='1' order by sira desc limit 1")->fetchAll(PDO::FETCH_ASSOC); 
    foreach($slider as $demo){?> 
    <link rel="preload" as="image" href="resimler/slider/<?php echo $demo['resim'];?>" />
    <link rel="preload" as="image" href="resimler/slider/<?php echo $demo['resim'];?>" />
    <?php } ?> 
	
	<div id="cl-main-slider" class="swiper-container" style="widtg">
        <div class="swiper-wrapper">
	<?php $slider = $ozy->query("select * from slider where durum='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
    foreach($slider as $demo){?> 	
		
		
                <div id="tag1625129939824<?php echo $demo['id'];?>" class="swiper-slide cl-promo-item" data-id="tag1625129939824<?php echo $demo['id'];?>" data-name="slider-7" data-creative="" data-position="0" alt="slider">
                    <img class="cl-main-slider-img swiper-lazy" data-src="resimler/slider/<?php echo $demo['resim'];?>" />
                    <img class="cl-main-slider-mobile-img swiper-lazy" data-src="resimler/slider/<?php echo $demo['resim'];?>" />
                    <a href="<?php echo $demo['link'];?>"></a>
                </div>
              
    <?php } ?>            
			   
			   
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

        
  <div class="cl-width-limiter">



<style>
.cl-banner-box .cl-banner-images img {
    border-radius: 20px;
}
</style>
<div class="cl-page-row">
<h1 class="cl-page-row-header">En Popüler Kategoriler</h1>
<h2 class="cl-page-row-subheader">En çok tercih edilen kategorilerimizi gördünüz mü?</h2>
<div class="swiper-container cl-fluid-slider cl-swiper-slider" data-type="banner">
<div class="swiper-wrapper">

 
 <?php $katiz = $ozy->query("select * from kategoriler where durum='1' and agoster='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
 foreach($katiz as $kategorimx){?>  
<div class="swiper-slide" style="background:white;border: 1px solid <?php echo $tema['t8']; ?>;border-radius: 16px;padding: 5px;">
<div class="cl-banner-box"><a href="kategori/<?php echo $kategorimx['seo']; ?>" class="cl-banner-images">
<?php if(!empty($kategorimx['yanresim']) && $kategorimx['yanresim'] != ''){ ?>
    <img class="cl-wave cl-lazy" src="resimler/kategoriler/<?php echo $kategorimx['yanresim']; ?>" data-src="resimler/kategoriler/<?php echo $kategorimx['yanresim']; ?>" alt="<?php echo $kategorimx['adi']; ?>" />
<?php } else { 
    $renk1 = !empty($kategorimx['renk']) && $kategorimx['renk'] != '' ? $kategorimx['renk'] : '#667eea';
    $renk2 = !empty($kategorimx['renk']) && $kategorimx['renk'] != '' ? (strlen($kategorimx['renk']) == 7 ? $kategorimx['renk'].'dd' : '#764ba2') : '#764ba2';
?>
    <div style="width: 100%; height: 200px; background: linear-gradient(135deg, <?php echo $renk1; ?> 0%, <?php echo $renk2; ?> 100%); display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 48px; font-weight: bold; color: white; text-transform: uppercase; min-height: 200px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <span><?php echo mb_substr($kategorimx['adi'], 0, 1, 'UTF-8'); ?></span>
    </div>
<?php } ?>
</a>
<div class="cl-banner-info">
<p><?php echo $kategorimx['adi']; ?></p>
<a style="text-decoration: none;" href="kategori/<?php echo $kategorimx['seo']; ?>">İNCELE</a></div>
</div>
</div>
<?php } ?>	

</div>
<div class="swiper-button-next"></div>
<div class="swiper-button-prev"></div>
</div>
</div>


<div class="cl-page-row">
<h1 class="cl-page-row-header">Yeni Ürünler</h1>
<h2 class="cl-page-row-subheader">Yeni gelen tüm ürünleri gördünüz mü?</h2>



<div class="cl-product-grid cl-col-l12">
        <div class="cl-flex-row cl-page-row">
  

  <?php $uk = $ozy->query("select * from urunler where durum='1' and yeni='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
    foreach($uk as $anaurunler){?>


  
<div class="cl-col cl-col-l2 cl-col-m3 cl-col-s6">
<div class="cl-product-box">
    <div class="cl-product-images">
	
             <?php if($anaurunler['idurum']=='1'){?>
			<p class="cl-product-badge discount">
			
			  -%<?php echo yuzdeHesaplama($anaurunler['fiyat'],$anaurunler['ifiyat']);?>
			</p>
			<?php } ?>
        <a href="urun/<?php echo $anaurunler['seo']; ?>">
            <img class="" src="resimler/urunler/<?php echo $anaurunler['resim']; ?>" data-src="resimler/urunler/<?php echo $anaurunler['resim']; ?>" alt="Ürün" title="Ürün">
        </a>
        <div class="cl-product-box-inputs">
            <div class="cl-flex-row">
                <div class="cl-product-quantity-input-container">
                   
                </div>
            </div>
            <button class="add-to-cart-button" type="button" onclick="location.href='urun/<?php echo $anaurunler['seo']; ?>'">Sepete Ekle </button>
        </div>
    </div>
    <div class="cl-product-info">
        <a href="urun/<?php echo $anaurunler['seo']; ?>" class="cl-product-name" title="<?php echo $anaurunler['adi']; ?>"><p>
		<?php echo $anaurunler['adi']; ?></p></a>
        <div class="cl-product-prices">
         <?php echo urunfiyatbelirle($anaurunler['kdv'],$anaurunler['idurum'],$anaurunler['fiyat'],$anaurunler['ifiyat']);?>
            
        </div>
    </div>
</div>
</div>
  <?php } ?>  
				
				
				
				
				
				
        </div>

          
    </div>







</div>




<div class="cl-page-row">
<h1 class="cl-page-row-header">Fırsat Ürünleri</h1>
<h2 class="cl-page-row-subheader">Günün fırsat ürünleri ile avantajlı fiyatlardan yararlanın.</h2>



<div class="cl-product-grid cl-col-l12">
        <div class="cl-flex-row cl-page-row">
  

  <?php $ukz = $ozy->query("select * from urunler where durum='1' and firsat='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
    foreach($ukz as $firsat){?>


  
<div class="cl-col cl-col-l2 cl-col-m3 cl-col-s6">
<div class="cl-product-box">
    <div class="cl-product-images">
            <?php if($firsat['idurum']=='1'){?>
			<p class="cl-product-badge discount">
			
			  -%<?php echo yuzdeHesaplama($firsat['fiyat'],$firsat['ifiyat']);?>
			</p>
			<?php } ?>
        <a href="urun/<?php echo $firsat['seo']; ?>">
            <img class="" src="resimler/urunler/<?php echo $firsat['resim']; ?>" data-src="resimler/urunler/<?php echo $firsat['resim']; ?>" alt="Ürün" title="Ürün">
        </a>
        <div class="cl-product-box-inputs">
            <div class="cl-flex-row">
                <div class="cl-product-quantity-input-container">
                   
                </div>
            </div>
            <button class="add-to-cart-button" type="button" onclick="location.href='urun/<?php echo $firsat['seo']; ?>'">Sepete Ekle </button>
        </div>
    </div>
    <div class="cl-product-info">
        <a href="urun/<?php echo $firsat['seo']; ?>" class="cl-product-name" title="<?php echo $firsat['adi']; ?>"><p>
		<?php echo $firsat['adi']; ?></p></a>
        <div class="cl-product-prices">
         <?php echo urunfiyatbelirle($firsat['kdv'],$firsat['idurum'],$firsat['fiyat'],$firsat['ifiyat']);?>
            
        </div>
    </div>
</div>
</div>
  <?php } ?>  
				
		
				
        </div>
          
    </div>

</div>




<div class="cl-page-row">
<h1 class="cl-page-row-header">Popüler Ürünler</h1>
<h2 class="cl-page-row-subheader">En çok sevilen ürünlere göz atmak istermisin?</h2>



<div class="cl-product-grid cl-col-l12">
        <div class="cl-flex-row cl-page-row">
  

  <?php $ppp = $ozy->query("select * from urunler where durum='1' and populer='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
    foreach($ppp as $populer){?>


  
<div class="cl-col cl-col-l2 cl-col-m3 cl-col-s6">
<div class="cl-product-box">
    <div class="cl-product-images">
               <?php if($populer['idurum']=='1'){?>
			<p class="cl-product-badge discount">
			
			  -%<?php echo yuzdeHesaplama($populer['fiyat'],$populer['ifiyat']);?>
			</p>
			<?php } ?>
        <a href="urun/<?php echo $populer['seo']; ?>">
            <img class="" src="resimler/urunler/<?php echo $populer['resim']; ?>" data-src="resimler/urunler/<?php echo $populer['resim']; ?>" alt="Ürün" title="Ürün">
        </a>
        <div class="cl-product-box-inputs">
            <div class="cl-flex-row">
                <div class="cl-product-quantity-input-container">
                   
                </div>
            </div>
            <button class="add-to-cart-button" type="button" onclick="location.href='urun/<?php echo $populer['seo']; ?>'">Sepete Ekle </button>
        </div>
    </div>
    <div class="cl-product-info">
        <a href="urun/<?php echo $populer['seo']; ?>" class="cl-product-name" title="<?php echo $populer['adi']; ?>"><p>
		<?php echo $populer['adi']; ?></p></a>
        <div class="cl-product-prices">
         <?php echo urunfiyatbelirle($populer['kdv'],$populer['idurum'],$populer['fiyat'],$populer['ifiyat']);?>
            
        </div>
    </div>
</div>
</div>
  <?php } ?>  
				
		
				
        </div>
          
    </div>

</div>





<div class="cl-page-row">
<h1 class="cl-page-row-header">Çok Satan Ürünler</h1>
<h2 class="cl-page-row-subheader">En çok satılan ürünlere göz atmak istermisin?</h2>



<div class="cl-product-grid cl-col-l12">
        <div class="cl-flex-row cl-page-row">
  

  <?php $ccc = $ozy->query("select * from urunler where durum='1' and coksatan='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
    foreach($ccc as $coksatan){?>


  
<div class="cl-col cl-col-l2 cl-col-m3 cl-col-s6">
<div class="cl-product-box">
    <div class="cl-product-images">
           <?php if($coksatan['idurum']=='1'){?>
			<p class="cl-product-badge discount">
			
			  -%<?php echo yuzdeHesaplama($coksatan['fiyat'],$coksatan['ifiyat']);?>
			</p>
			<?php } ?>
        <a href="urun/<?php echo $coksatan['seo']; ?>">
            <img class="" src="resimler/urunler/<?php echo $coksatan['resim']; ?>" data-src="resimler/urunler/<?php echo $coksatan['resim']; ?>" alt="Ürün" title="Ürün">
        </a>
        <div class="cl-product-box-inputs">
            <div class="cl-flex-row">
                <div class="cl-product-quantity-input-container">
                   
                </div>
            </div>
            <button class="add-to-cart-button" type="button" onclick="location.href='urun/<?php echo $coksatan['seo']; ?>'">Sepete Ekle </button>
        </div>
    </div>
    <div class="cl-product-info">
        <a href="urun/<?php echo $coksatan['seo']; ?>" class="cl-product-name" title="<?php echo $coksatan['adi']; ?>"><p>
		<?php echo $coksatan['adi']; ?></p></a>
        <div class="cl-product-prices">
         <?php echo urunfiyatbelirle($coksatan['kdv'],$coksatan['idurum'],$coksatan['fiyat'],$coksatan['ifiyat']);?>
            
        </div>
    </div>
</div>
</div>
  <?php } ?>  
				
		
				
        </div>
          
    </div>

</div>





<div class="cl-page-row">
<h1 class="cl-page-row-header">Sizin İçin Seçtiklerimiz</h1>
<h2 class="cl-page-row-subheader">Sizler için seçtiğimiz ürünleri gördünüz mü?</h2>



<div class="cl-product-grid cl-col-l12">
        <div class="cl-flex-row cl-page-row">
  

  <?php $aaaa = $ozy->query("select * from urunler where durum='1' and agoster='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
    foreach($aaaa as $sizinicin){?>


  
<div class="cl-col cl-col-l2 cl-col-m3 cl-col-s6">
<div class="cl-product-box">
    <div class="cl-product-images">
         <?php if($sizinicin['idurum']=='1'){?>
			<p class="cl-product-badge discount">
			
			  -%<?php echo yuzdeHesaplama($sizinicin['fiyat'],$sizinicin['ifiyat']);?>
			</p>
			<?php } ?>
        <a href="urun/<?php echo $sizinicin['seo']; ?>">
            <img class="" src="resimler/urunler/<?php echo $sizinicin['resim']; ?>" data-src="resimler/urunler/<?php echo $sizinicin['resim']; ?>" alt="Ürün" title="Ürün">
        </a>
        <div class="cl-product-box-inputs">
            <div class="cl-flex-row">
                <div class="cl-product-quantity-input-container">
                   
                </div>
            </div>
            <button class="add-to-cart-button" type="button" onclick="location.href='urun/<?php echo $sizinicin['seo']; ?>'">Sepete Ekle </button>
        </div>
    </div>
    <div class="cl-product-info">
        <a href="urun/<?php echo $sizinicin['seo']; ?>" class="cl-product-name" title="<?php echo $sizinicin['adi']; ?>"><p>
		<?php echo $sizinicin['adi']; ?></p></a>
        <div class="cl-product-prices">
         <?php echo urunfiyatbelirle($sizinicin['kdv'],$sizinicin['idurum'],$sizinicin['fiyat'],$sizinicin['ifiyat']);?>
            
        </div>
    </div>
</div>
</div>
  <?php } ?>  
				
		
				
        </div>
          
    </div>

</div>





<div class="cl-page-row cl-feature-row">
<div class="cl-flex-row ">
<div class="cl-feature-col cl-col-l3 cl-col-s6">
<div class="cl-feature-icon"><img src="<?php echo $sitetemasi;?>/images/paketleme-usp.png" /></div>
<p class="cl-feature-name">Aynı Gün Kargo</p>
<p class="cl-feature-info">Satın aldığınız ürünler özenle paketlenir ve kargolanır.</p>
</div>
<div class="cl-feature-col cl-col-l3 cl-col-s6">
<div class="cl-feature-icon"><img src="<?php echo $sitetemasi;?>/images/musterihizmetleri-usp.png" /></div>
<p class="cl-feature-name">Müşteri Destek Hattı</p>
<p class="cl-feature-info"><?php echo $ayar['tel']; ?> veya <a href="mailto:<?php echo $ayar['email']; ?>"><?php echo $ayar['email']; ?></a></p>
</div>
<div class="cl-feature-col cl-col-l3 cl-col-s6">
<div class="cl-feature-icon"><img src="<?php echo $sitetemasi;?>/images/kargo-bedava.png" /></div>
<p class="cl-feature-name">Ücretsiz Kargo</p>
<p class="cl-feature-info"><?php echo $system['ucretsizkargo']; ?> TL ve üzeri alışverişlerde ücretsiz kargo!</p>
</div>
<div class="cl-feature-col cl-col-l3 cl-col-s6">
<div class="cl-feature-icon"><img src="<?php echo $sitetemasi;?>/images/direktsatis.png" /></div>
<p class="cl-feature-name">Hijyenik Paketleme</p>
<p class="cl-feature-info">Satın aldığınız tüm ürünler hijyen kurallarına uygun kargolanır</p>
</div>
</div>
</div>






        