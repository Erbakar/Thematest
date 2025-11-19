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
                	<style>
                		/* Countdown sayılarının arka planını saydam yap */
                		.deal-countdown .countdown-section {
                			background-color: rgba(255, 255, 255, 0.2) !important;
                			backdrop-filter: blur(5px);
                		}
                		/* Countdown sayılarını beyaz yap */
                		.deal-countdown .countdown-amount {
                			color: #fff !important;
                		}
                		/* Altındaki saat, dakika, saniye yazılarını beyaz ve okunabilir yap */
                		.deal-countdown .countdown-period {
                			color: #fff !important;
                			font-weight: 600 !important;
                			opacity: 1 !important;
                			font-size: 0.85rem !important;
                		}
                	</style>
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
								
								
								
								 
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="deal" style="
                            background: #fff;
                            border-radius: 20px;
                            padding: 0;
                            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
                            transition: transform 0.3s ease, box-shadow 0.3s ease;
                            position: relative;
                            overflow: hidden;
                            display: flex;
                            flex-direction: column;
                            height: 100%;
                        " onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 50px rgba(0,0,0,0.18)';" 
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.12)';">
                            
                            <!-- Ürün Resmi Bölümü -->
                            <div style="
                                position: relative;
                                width: 100%;
                                height: 280px;
                                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                                overflow: hidden;
                            ">
                                <img src="resimler/urunler/<?php echo $gfirsat['firsatresim']; ?>" 
                                     alt="<?php echo $gfirsat['adi']; ?>"
                                     style="
                                         width: 100%;
                                         height: 100%;
                                         object-fit: cover;
                                         transition: transform 0.5s ease;
                                     "
                                     onmouseover="this.style.transform='scale(1.1)';"
                                     onmouseout="this.style.transform='scale(1)';">
                                
                                <!-- Fırsat Badge -->
                                <div style="
                                    position: absolute;
                                    top: 20px;
                                    right: 20px;
                                    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
                                    color: white;
                                    padding: 10px 20px;
                                    border-radius: 30px;
                                    font-weight: 700;
                                    font-size: 0.9rem;
                                    box-shadow: 0 4px 15px rgba(255,107,107,0.4);
                                    z-index: 10;
                                    text-transform: uppercase;
                                    letter-spacing: 0.5px;
                                ">
                                    Fırsat Ürünü
                                </div>
                            </div>

                            <!-- İçerik Bölümü -->
                            <div style="padding: 30px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                <div style="display: flex; gap: 20px;">
                                    <!-- Sol Taraf: Ürün Bilgileri -->
                                    <div style="flex: 1;">
                                        <h2 style="font-size: 1.1rem; font-weight: 600; color: #999; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">
                                            Günün Fırsat Ürünü
                                        </h2>
                                        
                                        <h3 class="product-title" style="margin-bottom: 12px;">
                                            <a href="urun/<?php echo $gfirsat['seo']; ?>" style="
                                                font-size: 1.6rem; 
                                                font-weight: 700; 
                                                color: #333; 
                                                text-decoration: none;
                                                transition: color 0.3s ease;
                                                display: block;
                                                line-height: 1.3;
                                            " onmouseover="this.style.color='#ff6b6b';" onmouseout="this.style.color='#333';">
                                                <?php echo $gfirsat['adi']; ?>
                                            </a>
                                        </h3>

                                        <p style="font-size: 0.95rem; color: #666; margin-bottom: 20px; line-height: 1.6;">
                                            <?php echo mb_substr($gfirsat['kisa'], 0, 100); ?><?php echo strlen($gfirsat['kisa']) > 100 ? '...' : ''; ?>
                                        </p>

                                        <div class="product-price" style="margin-bottom: 25px;">
                                            <div style="font-size: 2.2rem; font-weight: 800; color: #ff6b6b; line-height: 1.2;">
                                                <?php echo urunfiyatbelirle($gfirsat['kdv'],$gfirsat['idurum'],$gfirsat['fiyat'],$gfirsat['ifiyat']);?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sağ Taraf: Kalan Süre -->
                                    <div style="
                                        min-width: 180px;
                                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                        padding: 20px;
                                        border-radius: 15px;
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: center;
                                        align-items: center;
                                        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
                                        height: fit-content;
                                    ">
                                        <div style="
                                            font-size: 0.85rem;
                                            color: rgba(255,255,255,0.9);
                                            margin-bottom: 12px;
                                            font-weight: 600;
                                            text-transform: uppercase;
                                            letter-spacing: 0.5px;
                                        ">
                                            ⏰ Kalan Süre
                                        </div>
                                        <div class="deal-countdown daily-deal-countdown" 
                                             data-until="+<?php echo $gfirsat['firsatsaat']; ?>h"
                                             style="
                                                 font-size: 1.3rem;
                                                 font-weight: 700;
                                                 color: #fff;
                                                 text-align: center;
                                             "></div>
                                    </div>
                                </div>

                                <div style="margin-top: 25px;">
                                    <a href="urun/<?php echo $gfirsat['seo']; ?>" class="btn btn-primary" style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        padding: 15px 35px;
                                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                        color: white;
                                        border: none;
                                        border-radius: 12px;
                                        font-weight: 700;
                                        font-size: 1.05rem;
                                        text-decoration: none;
                                        transition: all 0.3s ease;
                                        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
                                        width: 100%;
                                        text-transform: uppercase;
                                        letter-spacing: 0.5px;
                                    " onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 8px 25px rgba(102, 126, 234, 0.45)';" 
                                       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.35)';">
                                        <span>Ürünü İncele</span>
                                        <i class="icon-long-arrow-right" style="margin-left: 10px; font-size: 1.2rem;"></i>
                                    </a>
                                </div>
                            </div>
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