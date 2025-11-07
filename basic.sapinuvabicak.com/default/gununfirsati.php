<title>Fırsat Ürünleri</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>




	  
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Fırsat Ürünleri<span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Fırsat Ürünleri</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
<div class="page-content">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="toolbox">
								<div class="toolbox-left">
                					<div class="toolbox-sort">
                						<label for="sortby">Ürün Sıralama:</label>
                						<div class="select-custom">
										<form action="" method="GET"> 
										<input type="hidden" name="arama" value="<?php echo temizle($_GET['arama']);?>"/>
											<select name="siralama" class="form-control" onchange='this.form.submit()'>
												<option <?php echo $_GET['siralama'] == 'onerilen' ? 'selected="selected"' : null; ?> value="onerilen">Önerilen Sıralama</option>
												<option <?php echo $_GET['siralama'] == 'dusukfiyat' ? 'selected="selected"' : null; ?> value="dusukfiyat">Önce En Düşük Fiyat</option>
												<option <?php echo $_GET['siralama'] == 'yuksekfiyat' ? 'selected="selected"' : null; ?> value="yuksekfiyat">Önce En Yüksek Fiyat</option>
												<option <?php echo $_GET['siralama'] == 'encokyorum' ? 'selected="selected"' : null; ?> value="encokyorum">En Çok Yorum Alan</option>
												<option <?php echo $_GET['siralama'] == 'enbegenilen' ? 'selected="selected"' : null; ?> value="enbegenilen">En Çok Beğenilen</option>
												<option <?php echo $_GET['siralama'] == 'eskitarih' ? 'selected="selected"' : null; ?> value="eskitarih">En Eski Tarihe Göre</option>
												<option <?php echo $_GET['siralama'] == 'yenitarih' ? 'selected="selected"' : null; ?> value="yenitarih">En Yeni Tariha Göre</option>
											</select>
									    </form>
										</div>
                					</div><!-- End .toolbox-sort -->
                				
                				</div><!-- End .toolbox-right -->
							
							
                				<div class="toolbox-right">
                					<div class="toolbox-info">
                						 <span>	
										 Arama sonucuna göre toplam <?php $katsorgu = $ozy->prepare("SELECT COUNT(*) FROM urunler where durum='1' and firsat='1'");
                                         $katsorgu->execute();
                                         $katsay = $katsorgu->fetchColumn();
                                         echo ''.$katsay.''; ?> adet ürün bulunmaktadır.</span> 
                					</div><!-- End .toolbox-info -->
                				</div><!-- End .toolbox-left -->

                			
                			</div><!-- End .toolbox -->

                            <div class="products mb-3">
                                <div class="row justify-content-center">
								
		<?php 

     
        $pages = intval(@$_GET['pages']);
        if (!$pages) {
          $pages = 1;
        }
        
        $bak = $ozy->prepare("select * from urunler where durum='1' and firsat='1'");
        $bak->execute(array());
        $toplam= $bak->rowCount();
        $limit = 20;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 200;
		
	
		
		
		if (isset($_GET["siralama"]) && $_GET["siralama"] != "0") {
			
		if(temizle($_GET["siralama"]=='dusukfiyat')){
			
		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and firsat='1' order by simdikifiyat ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
	
        } elseif (temizle($_GET["siralama"]=='yuksekfiyat')) {

 		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and firsat='1' order by simdikifiyat DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    	
		} elseif (temizle($_GET["siralama"]=='encokyorum')) {
			
		$pageoku = $ozy->query("select * from urunler where durum='1' and firsat='1' order by yorum DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='enbegenilen')) {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and firsat='1' order by hit DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='eskitarih')) {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and firsat='1' order by tarih DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='yenitarih')) {
			
		$pageoku = $ozy->query("select * from urunler where durum='1' and firsat='1' order by tarih ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    	
		} elseif (temizle($_GET["siralama"]=='onerilen')) {	
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and firsat='1' order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		}
		
		
		} else {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and firsat='1' order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		}
		
	    
		
		$__URUN__ = false;
        foreach ($pageoku as $gfirsat) {
        $__URUN__ = true;
		
		?>					
								
								
								
								 
                    <div class="col-lg-6 deal-col">
                        <div class="deal" style="background-image: url('resimler/genel/<?php echo $gfirsat['firsatresim']; ?>');">
                            <div class="deal-top">
                                <h2>Günün Fırsat Ürünü</h2>
                                <h4><?php echo $gfirsat['kisa']; ?></h4>
                            </div><!-- End .deal-top -->

                            <div class="deal-content">
                                <h3 class="product-title"><a href="urun/<?php echo $gfirsat['seo']; ?>"><?php echo $gfirsat['adi']; ?></a></h3><!-- End .product-title -->

                                <div class="product-price">
									<?php echo urunfiyatbelirle($gfirsat['kdv'],$gfirsat['idurum'],$gfirsat['fiyat'],$gfirsat['ifiyat']);?>
                                </div><!-- End .product-price -->

                                <a href="urun/<?php echo $gfirsat['seo']; ?>" class="btn btn-link"><span>Ürünü İncele</span><i class="icon-long-arrow-right"></i></a>
                            </div><!-- End .deal-content -->

                            <div class="deal-bottom">
                                <div class="deal-countdown daily-deal-countdown" data-until="+<?php echo $gfirsat['firsatsaat']; ?>h"></div><!-- End .deal-countdown -->
                            </div><!-- End .deal-bottom -->
                        </div><!-- End .deal -->
                    </div><!-- End .col-lg-6 -->
                           

                                    
							<?php }
							
                            if (!$__URUN__){
								
                            echo "Herhangi bir fırsat ürünü bulunamadı :(";
							
							}
							?>				
									
									
									
									
									
									
									
                                </div><!-- End .row -->
                            </div><!-- End .products -->


                		 <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
						
							  <?php
                  for ($i= $pages - $forlimit ; $i < $pages + $forlimit + 1 ; $i++) { 
                  if ($i>0 and $i<=$sayfasayisi) {
                    
                  if ($i == $pages) {
          
                  echo "<li class='page-item active' aria-current='page'><a>".$i."</a></li>";
                                      
                   }else{
					   
				   $eklenecekstr="";
				   foreach($_GET as $key=>$value) {
							if($key!="pages" and $key!="trendmaxtrs" and $key!="id") $eklenecekstr.=$key."=".$value;
						}
						$eklenecekstr=$eklenecekstr!="" ? "&".$eklenecekstr : "";
							
                  echo "<li class='page-item'><a class='page-link' href='gununfirsati/?pages=".$i.$eklenecekstr."'>".$i."</a></li>";
          
          }

                  }
                }
          
          
          
          
                   ?> 
             		 
				
                           
                        </ul>
                    </nav>
                		</div><!-- End .col-lg-9 -->
			
						
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div>
        
        </main>