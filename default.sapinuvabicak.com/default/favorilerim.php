<?php if (!paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { 
	header("Location: ". $ayar['siteurl']);
	exit;
} ?>

<title>Favori Ürünlerim</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Favori Ürünlerim<span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Favori Ürünlerim</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

<div class="page-content">
            	<div class="container">
					<table class="table table-wishlist table-mobile">
						<thead>
							<tr>
								<th>Ürün</th>
								<th>Fiyat</th>
								<th>Kargo</th>
								<th>Kampanyası</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
						
	                    <?php $uyesepeti11 = $ozy->prepare("SELECT * FROM urunler 
	                    INNER JOIN favoriler ON urunler.id = favoriler.urunid  
	                    WHERE favoriler.gelenkim=? ORDER BY favoriler.id DESC");                
	                    $uyesepeti11->execute(array($sepetimdekikim));
	                    foreach ($uyesepeti11 as $favoriler) {?>
	
							<tr>
								<td class="product-col">
									<div class="product">
										<figure class="product-media">
											<a href="urun/<?php echo $favoriler['seo'];?>">
												<img src="resimler/urunler/<?php echo $favoriler['resim'];?>" alt="Product image">
											</a>
										</figure>

										<h3 class="product-title">
											<a href="urun/<?php echo $favoriler['seo'];?>"><?php echo $favoriler['adi'];?></a>
										</h3><!-- End .product-title -->
									</div><!-- End .product -->
								</td>
								<td class="price-col">
								<?php if($favoriler['idurum']=='1'){?>							
	                            <?php if($favoriler['kdv']>'0'){?>
                                <?php echo fiyatgoster(KdvDahil($favoriler['ifiyat'],$favoriler['kdv']));?>
	                            <?php } else { ?>
	                            <?php echo fiyatgoster($favoriler['ifiyat']);?>
	                            <?php } ?>							
	                            <?php } else { ?>
	                            <?php if($favoriler['kdv']>'0'){?>
                                <?php echo fiyatgoster(KdvDahil($favoriler['fiyat'],$favoriler['kdv']));?>						   
	                            <?php } else { ?>
	                            <?php echo fiyatgoster($favoriler['fiyat']);?>						    
	                            <?php } ?>							
	                            <?php } ?>
	                            </td>
								 <td class="stock-col">
								 <?php if($favoriler['ucretsizkargo']=='1'){?>    
	                             <div class="product-cargo-button free_shipping">
	                             <i style="font-size: 18px;" class="icon-truck"></i>
	                             <span>BU ÜRÜNDE KARGO ÜCRETSİZ</span>
	                             </div>
                                 <?php } else { ?>	
	                             <?php } ?>
                                 							 
								
								</td>
								<td class="action-col">
                                 <?php if($favoriler['alode']=='1'){?>    
	                             <div class="product-cargo-button free_shipping">
	                             <i style="font-size: 18px;" class="icon-shopping-cart"></i>
	                             <span>BU ÜRÜNDE <?php echo $favoriler['al'];?> AL <?php echo $favoriler['ode'];?> ÖDE FIRSATI</span>
	                             </div>
	                             <?php } else { ?>
	                             <?php } ?>
								</td>
								<td class="remove-col"><a href="?favorilsil=<?php echo $favoriler['id']; ?>" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a></td>
							</tr>
							
							
						   <?php } ?>		
							
						</tbody>
					</table><!-- End .table table-wishlist -->
	            	
            	</div><!-- End .container -->
            </div>




	


        </main>