<?php
// SEO değerini doğrudan al, temizleme SEO'yu bozabilir
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
$id = urldecode($id); // URL decode yap

$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM urunler WHERE seo=:id and durum=:durum");
$sayfaqq->execute([':id' => $id,':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

// Ürün bulunamazsa 404 sayfasına yönlendir
if(!$page || empty($page)){
    header("Location: " . $url . "/404");
    exit;
}

// Ürün bulundu, şimdi hit'i güncelle
$query = $ozy->prepare("UPDATE urunler SET hit = (hit+1) WHERE seo=?");
$query->execute(array($id));

////////URUN FİYAT BELİRMELE ALANI///////

if($page['idurum']=='1'){								
if($page['kdv']>'0'){
$eskifiyat = fiyatgoster(KdvDahil($page['fiyat'],$page['kdv']));
$yenifiyat = fiyatgoster(KdvDahil($page['ifiyat'],$page['kdv']));
} else {
$eskifiyat = fiyatgoster(KdvDahil($page['fiyat'],$system['kdv']));
$yenifiyat = fiyatgoster(KdvDahil($page['ifiyat'],$system['kdv']));
}
} else {
if($page['kdv']>'0'){
$yenifiyat = fiyatgoster(KdvDahil($page['fiyat'],$page['kdv']));
} else { 
$yenifiyat = fiyatgoster(KdvDahil($page['fiyat'],$system['kdv']));
}} 

////////URUN FİYAT BELİRMELE ALANI///////									

?>
<?php if($page['seodurum']=='1'){?>
<title><?php echo $page['stitle']; ?></title>
<meta name="keywords" content="<?php echo $page['skey']; ?>">
<meta name="description" content="<?php echo $page['sdesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="<?php echo $ayar['stitle']; ?>"/>
<meta property="og:description" content="<?php echo $page['sdesc']; ?>"/>
<?php } else { ?>
<title><?php echo $page['adi']; ?></title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="<?php echo $page['adi']; ?>"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
<?php } ?>
	   
		  <div class="cl-width-limiter">
        

        
        <div  class="cl-breadcrumb-container-with-border">
         <ol class="cl-breadcrumb">
                            <li class="cl-breadcrumb-item">
                                <a href="anasayfa">
                                    <span>Anasayfa</span>
                                </a>
                            </li>
							
   <?php 
			            $urunkategori = $page['kategori'];
			            $kat = $ozy->query("select * from kategoriler where durum='1' and id='$urunkategori'")->fetchAll(PDO::FETCH_ASSOC); 
			            foreach($kat as $ukat){?>
						<li class="cl-breadcrumb-item"><a href="kategori/<?php echo $ukat['seo'];?>"><?php echo $ukat['adi'];?></a></li>
<?php } ?>



							
							
							
							
                                    <li class="cl-breadcrumb-item active">
                                        <a title="">
                                            <span><?php echo $page['adi'];?></span>
                                        </a>
                                    </li>

                        </ol>
    </div>
    


            

<div class="cl-product-details-page" style="border: 1px solid #e9e9e9;
border-radius: 13px;">
    


    <div class="cl-flex-row cl-product-row">
        
        <div class="cl-product-images-col">
            <!--product pictures-->
            <div class="cl-product-gallery swiper-container">
    <div class="swiper-wrapper">
	
                <?php 
                // Varsayılan resim dosyası - resimler/urunler/ klasörüne ekleyin
                $varsayilan_resim = 'resimyok.jpg'; // Bu dosyayı resimler/urunler/ klasörüne ekleyin
                $ana_resim_yolu = (!empty($page['resim']) && $page['resim'] != 'resimyok.jpg') ? $page['resim'] : $varsayilan_resim;
                ?>
                <div class="swiper-slide  ">
                    <div class="cl-product-picture picture-60b139e868904a3d6cee4638<?php echo $ana_resim_yolu?>">
                        <a data-fancybox="cl-product-gallery"  id="main-product-img-anchor-60b139e868904a3d6cee4638<?php echo $ana_resim_yolu?>" href="resimler/urunler/<?php echo $ana_resim_yolu?>">
                            <img class="swiper-lazy" loading="lazy"  src="resimler/urunler/<?php echo $ana_resim_yolu?>" data-src="resimler/urunler/<?php echo $ana_resim_yolu?>" data-fullsize="resimler/urunler/<?php echo $ana_resim_yolu?>" id="main-product-img-60b139e868904a3d6cee4638<?php echo $ana_resim_yolu?>" />
                        </a>
                    </div>
                </div>
				
				 <?php 
					    $gelenid = $page['id'];
					    $sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='urunler' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                        $anaresim = trim($page['resim']);
                        $varsayilan_resim = 'resimyok.jpg'; // Varsayılan resim
                        foreach($sayfaresimi as $genelresim){
                            $ekresim = trim($genelresim['sayfaresim']);
                            // Ana resmi atla, sadece farklı resimleri göster
                            if($ekresim != $anaresim && !empty($ekresim)){
                                // Eğer ek resim boş veya resimyok ise varsayılan resmi kullan
                                $ek_resim_yolu = ($ekresim == 'resimyok.jpg' || empty($ekresim)) ? $varsayilan_resim : $ekresim;
                            ?>   
				  <div class="swiper-slide  ">
                    <div class="cl-product-picture picture-60b139e868904a3d6cee4638<?php echo $ek_resim_yolu;?>">
                        <a data-fancybox="cl-product-gallery"  id="main-product-img-anchor-60b139e868904a3d6cee4638<?php echo $ek_resim_yolu;?>" href="resimler/urunler/<?php echo $ek_resim_yolu;?>">
                            <img class="swiper-lazy" loading="lazy"  src="resimler/urunler/<?php echo $ek_resim_yolu;?>" data-src="resimler/urunler/<?php echo $ek_resim_yolu;?>" data-fullsize="resimler/urunler/<?php echo $ek_resim_yolu;?>" id="main-product-img-60b139e868904a3d6cee4638<?php echo $ek_resim_yolu;?>" />
                        </a>
                    </div>
                </div>
				    <?php }
                        } ?>
         
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>
<div class="cl-product-gallery-thumbnails swiper-container">
    <div class="swiper-wrapper">
        <?php 
        // Ana resim için varsayılan kontrolü
        $varsayilan_resim = 'resimyok.jpg'; // Varsayılan resim
        $ana_resim_yolu = (!empty($page['resim']) && $page['resim'] != 'resimyok.jpg') ? $page['resim'] : $varsayilan_resim;
        ?>
        <div class="swiper-slide" style="background-image:url(resimler/urunler/<?php echo $ana_resim_yolu;?>)" data-fullsize="resimler/urunler/<?php echo $ana_resim_yolu;?>"></div>
         <?php 
					    $gelenid = $page['id'];
					    $sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='urunler' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                        $anaresim = trim($page['resim']);
                        foreach($sayfaresimi as $genelresim){
                            $ekresim = trim($genelresim['sayfaresim']);
                            // Ana resmi atla, sadece farklı resimleri göster
                            if($ekresim != $anaresim && !empty($ekresim)){
                                // Eğer ek resim boş veya resimyok ise varsayılan resmi kullan
                                $ek_resim_yolu = ($ekresim == 'resimyok.jpg' || empty($ekresim)) ? $varsayilan_resim : $ekresim;
                            ?> 
		<div class="swiper-slide" style="background-image:url(resimler/urunler/<?php echo $ek_resim_yolu;?>)" data-fullsize="resimler/urunler/<?php echo $ek_resim_yolu;?>"></div>
      <?php }
                        } ?>
   </div>
</div>

        </div>
        <div class="cl-product-info-col">
            
            <div class="cl-product-info">

                <!-- Product Info -->
                    
                    <h1 class="cl-product-title" itemprop="name">
                       <?php echo $page['adi'];?> <span class="cl-product-alt-title"></span>
                    </h1>
                    <div style="width: 100%;" class="product-reviews-overview d-inline-flex align-items-center flex-wrap mb-0 sk-ratings-review" >

        <div class="cl-product-no-reviews" style="width: 100%;">
            <a class="cl-review-scroll-button cl-smooth-scroll"><b>Ürün Kodu :</b> <?php echo $page['urunkodu'];?></a>
<div style="margin-top: -10% !important;">
        
		 <a style="line-height: 28px;
float: right;
color: <?php echo $tema['t8']; ?>;
margin-right: 10px;
border: 1px solid #e0d8d8;" href="?favoriekle=<?php echo $page['id']; ?>" data-toggle="tooltip" class="btn btn-default wishlist"  data-original-title="Favorilerime Ekle"><i class="fa fa-heart"></i></a>
          <a style="line-height: 28px;
float: right;
color: <?php echo $tema['t8']; ?>;
margin-right: 10px;
border: 1px solid #e0d8d8;" href="?karsilastir=<?php echo $page['id']; ?>" data-toggle="tooltip" class="btn btn-default compare"  data-original-title="Karşılaştırma listesine ekle"><i class="fa fa-exchange"></i></a>
          
</div>
		
		</div>
		
		
		
             </div>
			 
			   <hr>
         
			  <div>
		   <b>Stok Durumu : </b>
						<?php if($page['stok']>='1'){?>	
						<span style="color:green;">Stokta var</span>
						<?php } else { ?>
						<span style="color:red;">Tükendi</span>
						<?php } ?>
						
		  </div>
		  
		  
		  
		
  <hr>
         <div>   <?php echo $page['kisa'];?> 

 </div>
   <hr>
		   <!-- Product Price -->
                    <div class="cl-product-prices">

                                    <div id="detayfiyat" data-price="<?php echo mb_substr($yenifiyat,0,-3);?>" class="product-price">
									<?php if($page['idurum']=='1'){?>	
								    <span style="font-size: 21px;text-decoration: line-through;" class="old-price"><?php echo $eskifiyat;?></span>&nbsp;&nbsp;
								    <span style="font-weight: 600;font-size: 24px;color: <?php echo $tema['t8']; ?>;margin: 0;" id="sonfiyat"><?php echo $yenifiyat;?></span>
									<?php } else { ?>
									<span style="font-weight: 600;font-size: 24px;color: <?php echo $tema['t8']; ?>;margin: 0;" id="sonfiyat"><?php echo $yenifiyat;?></span>
									<?php } ?>
                                    </div><!-- End .product-price -->
									
									


                    		
                                    <?php if($page['kdv']>'0'){?>	
								    <?php  $ekkdv = $page['kdv'];?>
									<?php } else { ?>
					                <?php  $ekkdv = $system['kdv'];?>
									<?php } ?>
                                     
				                   
            
           
		


                    </div>
					<?php if($page['havaledurum']=='1'){?>	
									<div>
									<hr>
                                    <?php if($page['kdv']>='0'){?>	
								    <b style="font-weight:600;">Havale Fiyatı :</b> <span style="font-weight: 500;font-size: 18px;margin: 0;"><?php echo $hfiyat = fiyatgoster(KdvDahil($page['hfiyat'],$system['kdv']));?></span>
									<?php } else { ?>
									 <b style="font-weight:600;">Havale Fiyatı :</b> <span style="font-weight: 500;font-size: 18px;margin: 0;"><?php echo $hfiyat = fiyatgoster(KdvDahil($page['hfiyat'],$page['kdv']));?></span>
									<?php } ?>
									 </div>
									 	<hr>
                                    <?php } ?>	
                   <form action="" method="POST">
                    <!-- Product Colors -->
					           <?php 
								      $kod = $page['urunkodu'];
								      $varyant = $ozy->prepare("SELECT COUNT(*) FROM urunler where durum='1' and  urunkodu='$kod'");
                                      $varyant->execute();
                                      $varyantsayi = $varyant->fetchColumn();?>
                    <div class="cl-product-colors" <?php echo $varyantsayi <= '1' ? 'style="display:none;"' : null; ?>>
                     <hr>
					 <span></span>
                        <div class="cl-product-colors-images">
						     <div class="details-filter-row details-row-size" >
                                        <label>Renk: </label>

                                        <div class="product-nav product-nav-thumbs">
                                        <?php 
										$sayfaidmiz = $page['id'];
										$urunvaryant = $ozy->query("select * from urunler where durum='1' and urunkodu='$kod' and id!='$sayfaidmiz' ORDER BY sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                                        foreach($urunvaryant as $varyantbak){?>  
                                            <a href="urun/<?php echo $varyantbak['seo'];?>">
                                                <img style="border: 2px solid #f4f4f4;width: 50px !important;" class="lazyload"  data-src="resimler/urunler/<?php echo $varyantbak['resim'];?>">
                                            </a>
										<?php } ?>		
											
                                        </div><!-- End .product-nav -->
                                    </div><!-- End .details-filter-row -->
                        </div>
                    </div>
					
					<div class="badges" style="margin-bottom: 10px;">
					<?php if($page['alode']=='1'){?> 
                    <span class="badge" style="border: 1px solid #d2ab13;padding: 5px;line-height: 20px !important;color: #d2ab13;">
					<i style="font-size: 18px;" class="icon-shopping-cart"></i> BU ÜRÜNDE <?php echo $page['al'];?> AL <?php echo $page['ode'];?> ÖDE FIRSATI</span>
                    <?php } ?>
					<?php if($page['ucretsizkargo']=='1'){?>
					<span class="badge" style="border: 1px solid #2cc43c;padding: 5px;line-height: 20px !important;color: #2cc43c;">
					<i style="font-size: 18px;" class="icon-truck"></i> BU ÜRÜNDE KARGO ÜCRETSİZ
					</span>
                    <?php } ?>
					</div>
										
									
									<?php 
									$urunid = $page['id'];
									$ozellik = $ozy->query("select * from anaozellik where tip='0' and urunid='$urunid' ORDER BY id desc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($ozellik as $anaozellik){?>  
                                    <div class="details-filter-row details-row-size">
                                        <label for="size" style="width: 100%;font-weight: 500;"><?php echo $anaozellik['adi'];?> :</label>
                                        <div class="select-custom" style="width: 100%;">
                                    <select class="form-control varyantselect" onchange="detayfiyathesapla(this);" name="ozellik[]" id="size"  required>
                                    <option data-price="0.00" value="0">Seçim Yapınız</option>
									<?php 
									$altanaid = $anaozellik['id'];
									$ozellikalt = $ozy->query("select * from anaozellikalt where anaid='$altanaid' ORDER BY id asc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($ozellikalt as $anaozellikalt){?> 		
                                    <option data-price="<?php echo KdvDahil($anaozellikalt['fiyat'],$ekkdv);?>" value="<?php echo $anaozellikalt['id'];?>" <?php echo $anaozellikalt['stok'] <= '0' ? 'disabled' : null; ?>><?php echo $anaozellikalt['adi'];?> <?php echo $anaozellikalt['stok'] <= '0' ? '(Tükendi)' : null; ?></option>
                                    <?php } ?>	  
                                    </select>
                                        </div><!-- End .select-custom -->

                                    </div><!-- End .details-filter-row -->
									
									   <hr>
								   <?php } ?>	
								
								
			                    
	
			              
									

                                    <?php 
									$urunid = $page['id'];
									$iozellik = $ozy->query("select * from anaozellik where tip='1' and urunid='$urunid' ORDER BY id desc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($iozellik as $ianaozellik){?>  
									
                                    <div class="details-filter-row details-row-size" style="background: #fbf8f8;padding: 10px;width: 93%;">
                                    <label for="size" style="width: 100%;font-weight: 500;"><?php echo $ianaozellik['adi'];?> :</label>
									<?php 
									$ialtanaid = $ianaozellik['id'];
									$iozellikalt = $ozy->query("select * from anaozellikalt where anaid='$ialtanaid' ORDER BY id asc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($iozellikalt as $ianaozellikalt){?>
			                        <label class="size-item">
				                    <input onclick="detayfiyathesapla(this);" data-price="<?php echo KdvDahil($ianaozellikalt['fiyat'],$ekkdv);?>" class="varyantradio" type="radio" name="ozellik[]" level="2" <?php echo $ianaozellikalt['stok'] <= '0' ? 'disabled' : null; ?> value="<?php echo $ianaozellikalt['id'];?>" stocksize="<?php echo $ianaozellikalt['adi'];?>" available="1" required>
				                    <span <?php echo $ianaozellikalt['stok'] <= '0' ? 'style="border-color: #eee;
color: #3f3a3a;
background: #fbf8f8;"' : null; ?> class="size-slt-box" level="2" value="<?php echo $ianaozellikalt['id'];?>" name="ozellik[]"><?php echo $ianaozellikalt['adi'];?></span></label>
				                    <?php } ?>
                                    </div>
									   <hr>
                                    <?php } ?>



                                    <input type="hidden" value="<?php echo $page['id'];?>" name="urunid"/>
									
			   
			   
			   
			   
			   
			              
			   
					
					
					
                  
                    <div class="cl-product-button-container">
                        <span class="cl-add-cart-error-message" id="addcarterrmsg"></span>
                        <div class="cl-add-to-basket">
                 <div class="cl-product-quantity-input-container">
                <div class="cl-input-minus-button disabled" onclick="updateOrderQuantity(this)"></div>
               <?php if($system['sinirsizstok']!='1'){	?>
			   <input type="number" onchange="detayfiyathesapla(this);" class="cl-product-quantity-input" name="adet" style="display:block !important" value="1" min="1" max="<?php echo $page['stok'];?>" size="2" id="input-quantity" class="form-control" required>
               <?php } else { ?>
               <input type="number" onchange="detayfiyathesapla(this);" class="cl-product-quantity-input"  name="adet" style="display:block !important" value="1" min="1" max="999999999999999999999999999999" size="2" id="input-quantity" class="form-control" required>
               <?php } ?>
				
				
				<div class="cl-input-plus-button" onclick="updateOrderQuantity(this)"></div>
                <span>Adet</span>
            </div>
			
			
			<?php if($page['stok']>='1'){?>
            <button  type="submit" name="sepetle"  class="add-to-cart-button">
                <span>Sepete Ekle</span>
            </button>
			 <?php } else { ?>
             <button style="background: #d50e0e;border: #d50e0e;" type="button" class="add-to-cart-button">
                <span>Tükendi</span>
            </button>
            <?php } ?>
                        </div>
						
						
						
                    </div>
					<div style="margin-bottom:15px;">
						  <?php if($system['telefonal']=='1'){?>
			  <a style="margin: 0px;background: #474747 !important;
border: none !important;" target="_blank" href="tel:<?php echo $ayar['ceptel']; ?>" class="butonlar urunmobilbuton butonok btn btn-primary btn-lg"><span><i class="fa fa-phone"></i> Telefon İle Satın Al</span></a>
              <?php } ?>
			  <?php if($system['whatsapal']=='1'){?>
			  <a style="border: none !important;margin: 0px;margin-top:10px;background: green !important;" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $ayar['whatsapp']; ?>&amp;text=<?php echo $page['adi']; ?>%20sipari%C5%9Fi%20vermek%20istiyorum. <?php echo $url;?>/urun/<?php echo $page['seo']; ?>" class="butonlar butonok btn btn-primary btn-lg"><span><i class="fa fa-whatsapp"></i> WhatsApp ile Satın Al</span></a>
              <?php } ?>
					</div>
                    <span class="cl-product-button-info">Siparişiniz 1-3 İş Günü İçinde Kargoda!</span>

               <div class="cl-product-features-container">
                    <div class="cl-product-feature-item"><img src="<?php echo $sitetemasi;?>/images/paketleme-usp.png"><p>Aynı Gün Kargo</p></div>
                    <div class="cl-product-feature-item"><img src="<?php echo $sitetemasi;?>/images/kargo-bedava.png"><p><?php echo $system['ucretsizkargo']; ?> TL Üzeri Kargo Bedava</p></div>
                    <div class="cl-product-feature-item"><img src="<?php echo $sitetemasi;?>/images/direktsatis.png"><p>Hijyenik Paketleme</p></div>
                </div>
            </div>
        </div>
    </div>
</form>

    <div id="cl-product-tabs-container" class="cl-product-tabs-container">
        <div class="cl-product-tab-header active" data-target="tab1content"> Ürün Açıklaması</div>
        <div class="cl-product-tab-content tab1content active">
            <span class="cl-product-description">
           
		    <?php echo $page['aciklama'];?>
		   
		   
            </span>
        </div>
<?php 
								      $sayfaid = $page['id'];
								      $urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='urunler' and durum='1'");
                                      $urunyorumsayisi->execute();
                                      $urunyorumsayimis = $urunyorumsayisi->fetchColumn();?>
            <div class="cl-product-tab-header" data-target="tab2content">Yorumlar</div>
            <div class="cl-product-tab-content tab2content">
           		<div class="comments" style="border: 1px solid #dad8d8;margin-bottom:20px;
border-radius: 6px;
background: #fff;">
                    <?php if($urunyorumsayimis>'0'){?>
                      
                    <?php } else { ?>
					<h4 class="title">Bu ürüne henüz yorum yapılmamış. İlk yorumu sen yapmak ister misin ?</h4><!-- End .title -->
					<?php } ?>	

                                <ul>
								
								
				<?php 
				$blogid = $page['id'];
				$deneme = $ozy->query("select * from tumyorumlar where durum='1' and sayfaid='$blogid' and konu='urunler' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($deneme as $blogyorum) {?>			
								
                                <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto" style="padding-top: 34px;">
                                                
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                            
														  <div class="ratings-val" style="width:
											<?php echo $blogyorum['yildiz'] == '1' ? '20%' : null; ?>
											<?php echo $blogyorum['yildiz'] == '2' ? '40%' : null; ?>
											<?php echo $blogyorum['yildiz'] == '3' ? '60%' : null; ?>
											<?php echo $blogyorum['yildiz'] == '4' ? '80%' : null; ?>
											<?php echo $blogyorum['yildiz'] == '5' ? '100%' : null; ?>
											;"></div><!-- End .ratings-val -->
														
														<!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                </div><!-- End .rating-container -->
                                                <span class="review-date"><?php echo $blogyorum['tarih']; ?></span>
                                           
   <h4><a style="color: black !important;"><?php echo $blogyorum['adi']; ?></a></h4>

                                                <div class="review-content">
                                                    <p><?php echo $blogyorum['yorum']; ?></p>
                                                </div><!-- End .review-content -->

										   </div><!-- End .col -->
                                            <div class="col">
                                            
                                        <?php 
									$karakter_sayisi = strlen($blogyorum['cevap']);
									
									if($karakter_sayisi>'1'){?>
                                                <div class="review-action" style="padding: 20px;border: 1px solid #f1ecec;border-radius: 4px;">
                                                
												<div class="comment">
                                                    <figure class="comment-media">
                                                        <a href="<?php echo  $url;?>">
                                                            <img class="lazyload" style="width: 100px;"  data-src="resimler/siteayarlari/<?php echo $ayar['logo']; ?>" alt="User name">
                                                        </a>
                                                    </figure>

                                                    <div class="comment-body">
                                                        <div class="comment-user">
                                                            <h4><?php echo $ayar['siteadi']; ?></h4>
                                                        </div><!-- End .comment-user -->

                                                        <div class="comment-content">
                                                            <p style="font-weight: 500 !important;"><?php echo $blogyorum['cevap']; ?></p>
                                                        </div><!-- End .comment-content -->
                                                    </div><!-- End .comment-body -->
                                                </div><!-- End .comment -->
												
												
												</div><!-- End .review-action -->
												
												<?php } ?>
												
                                            </div><!-- End .col-auto -->
                                        </div><!-- End .row -->
                                    </div> 

									
                       <?php } ?>
								 
								 
								 
								 
								 
								 
								 
								 
								 
                                </ul>
                            </div>
					
			   
			   
			   
			   
			   
			   
              <form class="form-horizontal" method="POST" action="">
                <div id="review"></div>
                <h2>Yorum Yap</h2>
				 <p class="title-desc" style="color: #d81818;border: 1px solid #d81818;padding: 10px;font-size: 14px;border-radius: 2px;">Eposta adresiniz gizlilik nedeniyle görünmeyecektir. * Argo , küfür veya hukuka aykırı yorumlar onaylanmayacaktır.
							Bu tarz yorum yapanlar hakkında yasal süreç başlatılacaktır.</p>
                  <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name">Adınız Soyadınız</label>
                    <input type="text" class="form-control" name="adi" required="" value="<?php echo $uyebilgileri['isim'];?>">
                  </div>
                     <div class="col-sm-12">
                    <label class="control-label" for="input-name">Eposta Adresiniz</label>
                      <input type="email" class="form-control" id="reply-email" name="email" required=""  value="<?php echo $uyebilgileri['email'];?>">
                  </div>
				  
				  
				</div>
				
             
              
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review">Yorumunuz</label>
                    <textarea name="yorum" rows="5" id="input-review" class="form-control" required></textarea>
                    <div class="help-block"><span class="text-danger">Not:</span> HTML'e dönüştürülmez!</div>
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label">Oylama</label>
                    &nbsp;&nbsp;&nbsp; Kötü&nbsp;
                    <input type="radio" name="yildiz" value="1">
                    &nbsp;
                    <input type="radio" name="yildiz" value="2">
                    &nbsp;
                    <input type="radio" name="yildiz" value="3">
                    &nbsp;
                    <input type="radio" name="yildiz" value="4">
                    &nbsp;
                    <input type="radio" name="yildiz" value="5">
                    &nbsp;İyi</div>
                </div>
                   <div class="buttons clearfix">
				    <input type="hidden" name="sayfaid" value="<?php echo $page['id'];?>"/>
                  <div class="pull-right">
                    <button type="submit" name="urunyorum" id="button-review" class="butonok btn btn-primary">Gönder</button>
                  </div>
                </div>
                              </form>

            </div>


        <div class="cl-product-tab-header" data-target="tab3content"> İade & Değişim Şartları</div>
        <div class="cl-product-tab-content tab3content">
           <?php echo $system['iade']; ?>
		 
		 </div>



    </div>


</div>








        
    </div>