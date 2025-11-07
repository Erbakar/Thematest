<title>Arama Sonuçları</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
<?php
$arama = temizle($_GET['arama']);

$ara = explode(" ", $arama);
$adi = "";
$urunkodu = "";
$aciklama = "";
foreach($ara AS $a)
{
    $adi .= "adi LIKE '%".$a."%' AND ";
    $urunkodu .= "urunkodu LIKE '%".$a."%' AND ";
	$aciklama .= "aciklama LIKE '%".$a."%' AND ";
}
$adi = substr($adi, 0, -4);
$urunkodu = substr($urunkodu, 0, -4);
$aciklama = substr($aciklama, 0, -4);
?>



 
   <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h1><?php echo $page['adi'];?></h1>
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a>Ana Sayfa</a></li>

					
					
                    <li class="breadcrumb-item active" aria-current="page">Arama Sonuçları</li>
                </ol>
            </nav>
        </div>
    </section>
	
	
	
	 <section class="page category">
        <div class="container-lg">
            <div class="row">
			
			
			
				
				
                <div class="col-lg-12 mb-0">
                    <div class="pt-4 pb-4">
                        <div class="d-flex align-items-center justify-content-between filterbottom pb-4 mb-4">
                            <div class="scrolllr">
                                <div class="">
                                 <strong style="color: #ff0000;font-weight: 500;"><?php echo $arama;?></strong> kelimesine ait toplam <strong style="font-weight: 500;color: #ff0000">  <?php $katsorgu = $ozy->prepare("SELECT COUNT(*) FROM urunler where durum='1' and $adi or $urunkodu or $aciklama");

						$katsorgu->execute();

						$katsay = $katsorgu->fetchColumn();

						echo ''.$katsay.''; ?> </strong> adet ürün bulundu..
								 </div>
                            </div>
                            <div class="r">
							 <form  action="" method="GET">
									   	<?php 
							if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {
								$fitregelenveri = temizle($_GET["filtreleme"]);
								foreach($fitregelenveri as $filtreverisi){?>
									<input type="hidden" name="filtreleme[]" value="<?php echo $filtreverisi;?>"/>
								<?php  }}?>
								
								<?php 
								if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {
									$markagelenveri = temizle($_GET["markalar"]);
									foreach($markagelenveri as $markaverisi){?>
										<input type="hidden" name="markalar[]" value="<?php echo $markaverisi;?>"/>
									<?php  }}?>
									<input type="hidden" name="arama" value="<?php echo temizle($_GET['arama']);?>"/>
									<input type="hidden" name="pages" value="<?php echo temizle($_GET['pages']);?>"/>
									<input type="hidden" name="fiyatfiltre" value="<?php echo temizle($_GET['fiyatfiltre']);?>"/>	
									
                                            <select name="siralama" class="form-select selectorder" onchange='this.form.submit()'>
                            	             <option selected <?php echo $_GET['siralama'] == 'onerilen' ? 'selected="selected"' : null; ?> value="onerilen">Akıllı Sıralama</option>

											<option <?php echo $_GET['siralama'] == 'dusukfiyat' ? 'selected="selected"' : null; ?> value="dusukfiyat">Önce En Düşük Fiyat</option>

											<option <?php echo $_GET['siralama'] == 'yuksekfiyat' ? 'selected="selected"' : null; ?> value="yuksekfiyat">Önce En Yüksek Fiyat</option>

											<option <?php echo $_GET['siralama'] == 'encokyorum' ? 'selected="selected"' : null; ?> value="encokyorum">En Çok Yorum Alan</option>

											<option <?php echo $_GET['siralama'] == 'enbegenilen' ? 'selected="selected"' : null; ?> value="enbegenilen">En Çok Beğenilen</option>

											<option <?php echo $_GET['siralama'] == 'eskitarih' ? 'selected="selected"' : null; ?> value="eskitarih">En Eski Tarihe Göre</option>

											<option <?php echo $_GET['siralama'] == 'yenitarih' ? 'selected="selected"' : null; ?> value="yenitarih">En Yeni Tariha Göre</option>

                                            </select>
                                        </form>
                              
                            </div>
                        </div>

                        <div class="row mt-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 productlist">
                                                          
					<?php 

     
        $pages = intval(@$_GET['pages']);
        if (!$pages) {
          $pages = 1;
        }
        
        $bak = $ozy->prepare("select * from urunler where durum='1' and $adi or $urunkodu or $aciklama");
        $bak->execute(array());
        $toplam= $bak->rowCount();
        $limit = 55;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 200;
		
	
		
		
		if (isset($_GET["siralama"]) && $_GET["siralama"] != "0") {
			
		if(temizle($_GET["siralama"]=='dusukfiyat')){
			
		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and $adi or $urunkodu  or $aciklama order by simdikifiyat ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
	
        } elseif (temizle($_GET["siralama"]=='yuksekfiyat')) {

 		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and $adi or $urunkodu  or $aciklama order by simdikifiyat DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    	
		} elseif (temizle($_GET["siralama"]=='encokyorum')) {
			
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu  or $aciklama order by yorum DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='enbegenilen')) {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu  or $aciklama order by hit DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='eskitarih')) {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu  or $aciklama order by tarih DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='yenitarih')) {
			
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu  or $aciklama order by tarih ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    	
		} elseif (temizle($_GET["siralama"]=='onerilen')) {	
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu  or $aciklama order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		}
		
		
		} else {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu  or $aciklama order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		}
		
	    
		
		$__URUN__ = false;
        foreach ($pageoku as $katurunler) {
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
			<div class="title fs-5">Aradığın özellikte ürüne maalesef ulaşılmıyor.</div>
			<div class="text fs-5 fw-bold mt-1"><a href="<?php echo $url;?>">Tekrar denemek ister misin ?</a></div>
		</div>
	</div>													








													<?php }

													?>		
							
				  
								
								
								
								
								
								
								
								
								
								
							
                                                    </div>

                        <div class="text-center d-flex align-items-center justify-content-center mt-4">
                            <nav class="pagination" aria-label="Page navigation example">
                                <ul class="pagination">
                              


		
				<?php

                  for ($i= $pages - $forlimit ; $i < $pages + $forlimit + 1 ; $i++) { 

                  if ($i>0 and $i<=$sayfasayisi) {

                    

                  if ($i == $pages) {

          

                  echo " <li class='page-item'><a class='page-link active'>".$i."</a></li>";

                                      

                   }else{

					   

				   $eklenecekstr="";

				   foreach($_GET as $key=>$value) {

							if($key!="pages" and $key!="oziywebs" and $key!="id") $eklenecekstr.=$key."=&".$value;

						}

						$eklenecekstr=$eklenecekstr!="" ? "&".$eklenecekstr : "";

							

                  echo "<li class='page-item'><a class='page-link' href='arama/?arama=".$arama."&pages=".$i.$eklenecekstr."'>".$i."</a></li>";

          

          }



                  }

                }

          

          

          

          

                   ?> 
					



							   </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>