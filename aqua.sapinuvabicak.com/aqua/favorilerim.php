<title>Favori Ürünlerim</title>

<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">

<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">

<meta property="og:url" content="<?php echo $url; ?>"/>

<meta property="og:title" content="Favori Ürünlerim"/>

<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>




 
   <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h1><?php echo $page['adi'];?></h1>
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a>Ana Sayfa</a></li>
                   
					 
					
                    <li class="breadcrumb-item active" aria-current="page">Favori Ürünlerim</li>
                </ol>
            </nav>
        </div>
    </section>
	
	
	
	 <section class="page category">
        <div class="container-lg">
            <div class="row">
			
			
			
				
                <div class="col-lg-12 mb-0">
                    <div class="pt-4 pb-4">
                       

                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 productlist">
                                                          

						<?php $uyesepeti11 = $ozy->prepare("SELECT * FROM urunler 

	                    INNER JOIN favoriler ON urunler.id = favoriler.urunid  

	                    WHERE favoriler.gelenkim=? ORDER BY favoriler.id DESC");                

	                    $uyesepeti11->execute(array($sepetimdekikim));

	$__URUN__ = false;

        foreach ($uyesepeti11 as $katurunler) {
			
     
        $__URUN__ = true;



	                    ?>
				
				

   <div class="col">
                            <div class="item">
                                <div class="img">
                                <span class="d-flex bdgs">
								    <?php if($katurunler['ucretsizkargo']=='1'){?>
                                    <span class="bdg green">Ücretsiz Kargo!</span>
									<?php } ?> 
									<?php if($katurunler['idurum']=='1'){?>
                                    <span class="bdg orange">%<?php echo yuzdeHesaplama($katurunler['fiyat'],$katurunler['ifiyat']);?> İndirimli</span>    
                                    <?php } ?> 
									 <button style="color: #f6284e;
background-color: #fee9ed;
padding: 0px 15px;
border-radius: 20px;
display: block;
transition: all 0.3s;
border: none;
z-index: 999999999999999999999;
position: absolute;
margin-top: -8%;
height: 46px;
margin-left: 118%;" class="wishlist btn-button" type="button" onclick="javascript:location.href='?favorilsil=<?php echo $katurunler['id']; ?>'"><i class="ri-delete-bin-2-line"></i> 
                                        </button>
									
									
									</span>
                                    <a href="urun/<?php echo $katurunler['seo']; ?>">
                                        <img src="resimler/urunler/<?php echo $katurunler['resim']; ?>" width="238" height="175" class="img-fluid" alt="">
                                    </a>
                                </div>
                                <a href="urun/<?php echo $katurunler['seo']; ?>" class="title"><h3><?php echo $katurunler['adi']; ?></h3></a>
                                <div class="pb">
                                    <?php echo xurunfiyatbelirle($katurunler['kdv'],$katurunler['idurum'],$katurunler['fiyat'],$katurunler['ifiyat']);?>
                                  

								   <a href="urun/<?php echo $katurunler['seo']; ?>" class="addcart">SEPETE EKLE</a>
                                </div>
                            </div>
                        </div>
						
				  
				  
				  
<?php }

													

													if (!$__URUN__){?>

														

	<div class="notfound_container text-center" style="padding: 40px;font-weight: 500;">
	
	
		<div class="notfound_content">
			<div class="title fs-5">Favorilerinizde henüz ürün bulunmuyor.</div>
			<div class="text fs-5 fw-bold mt-1"><a href="<?php echo $url;?>">Hemen eklemek ister misiniz ?</a></div>
		</div>
	</div>													








													<?php }

													?>		
							
								
								
								
								
								
								
								
								
								
								
							
                                                    </div>

                
                    </div>
                </div>
            </div>
        </div>
    </section>