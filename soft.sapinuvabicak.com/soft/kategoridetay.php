<?php
// SEO değerini doğrudan al, temizleme SEO'yu bozabilir
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
$id = urldecode($id); // URL decode yap
$id = trim($id); // Başta/sonda boşluk varsa temizle

$durum = "1";
// Önce tam eşleşme dene
$sayfaqq = $ozy->prepare("SELECT * FROM kategoriler WHERE seo = :id AND durum = :durum LIMIT 1");
$sayfaqq->execute([':id' => $id, ':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

// Bulunamazsa TRIM ile tekrar dene (veritabanında başta/sonda boşluk olabilir)
if(!$page || empty($page)){
    $sayfaqq = $ozy->prepare("SELECT * FROM kategoriler WHERE TRIM(seo) = TRIM(:id) AND durum = :durum LIMIT 1");
    $sayfaqq->execute([':id' => $id, ':durum' => $durum]);
    $page = $sayfaqq->fetch(PDO::FETCH_ASSOC);
}

// Hala bulunamazsa 404 sayfasına yönlendir
if(!$page || empty($page)){
    header("Location: " . $url . "/404");
    exit;
}

// Kategori bulundu, şimdi hit'i güncelle
$query = $ozy->prepare("UPDATE kategoriler SET hit = (hit+1) WHERE seo = ? AND durum = '1'");
$query->execute(array($id));

$katid = $page['id'];
$maxfiyat=0;
$maxfiyatz = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and FIND_IN_SET($katid,kategori)  order by simdikifiyat DESC")->fetchAll(PDO::FETCH_ASSOC);
foreach ($maxfiyatz as $max) {
	$maxfiyat = floatval($max['simdikifiyat'])>$maxfiyat ? $max['simdikifiyat'] : $maxfiyat;
}
$maxfiyat = ceil(intval($maxfiyat*2));
$minfiyat=0;
$minfiyatz = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and FIND_IN_SET($katid,kategori)  order by simdikifiyat ASC")->fetchAll(PDO::FETCH_ASSOC);
foreach ($minfiyatz as $min) {
	$minfiyat = floatval($min['simdikifiyat'])<$minfiyat ? $min['simdikifiyat'] : $minfiyat;
}
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

	  
<?php 
$pageoku = $ozy->query("select * from urunler where durum='1' and FIND_IN_SET($katid,kategori) order by sira DESC")->fetchAll(PDO::FETCH_ASSOC);
$urunmarkalari.="";
foreach ($pageoku as $katurunler) {
$urunmarkalari.="".$katurunler['marka'].",";
?>
<?php } ?>		  
 <div class="cl-width-limiter">
        

            <style>
                .cl-header-title.mobile-title {
                    display: none;
                    text-align: center;
                    color: <?php echo $tema['t8']; ?>;
                    font-size: 21px;
                    margin: 20px 12px 12px;
                }

                @media only screen and (max-width: 767px) {
                    .cl-header-title.mobile-title {
                        display: block;
                    }
                }
            </style>
            <div class="cl-breadcrumb-container-with-border">
                          <ol class="cl-breadcrumb">
						  <li class="cl-breadcrumb-item">
                                <a href="anasayfa">
                                    <span>Anasayfa</span>
                                </a>
                            </li>
							
<?php if($page['level']=='2'){?>
<?php 
$ustkat1 = $page['ustkat'];
$ustu = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat1'")->fetch(PDO::FETCH_ASSOC);
if($ustu && !empty($ustu)){
    if(!empty($ustu['ustkat'])){
        $ustkat2 = $ustu['ustkat'];
        $ustu2 = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat2'")->fetch(PDO::FETCH_ASSOC);
        if($ustu2 && !empty($ustu2)){?>
<li class="cl-breadcrumb-item"><a href="kategori/<?php echo $ustu2['seo'];?>"><?php echo $ustu2['adi'];?></a></li>
        <?php }
    }
    if($ustu && !empty($ustu)){?>
<li class="cl-breadcrumb-item"><a href="kategori/<?php echo $ustu['seo'];?>"><?php echo $ustu['adi'];?></a></li>
    <?php }
}
?>
<?php } ?>

<?php if($page['level']=='1'){?>
<?php 
$ustkat1 = $page['ustkat'];
$ustu = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat1'")->fetch(PDO::FETCH_ASSOC);
if($ustu && !empty($ustu)){?>
<li class="cl-breadcrumb-item"><a href="kategori/<?php echo $ustu['seo'];?>"><?php echo $ustu['adi'];?></a></li>
<?php } ?>
<?php } ?>

							
							
							
							
                                    <li class="cl-breadcrumb-item active">
                                        <a title="">
                                            <span><?php echo $page['adi'];?></span>
                                        </a>
                                    </li>

                        </ol>
            </div>
                <span class="cl-header-title mobile-title"></span>
        
<div class="cl-flex-row cl-category-page">
    <div class="cl-col-l2  cl-filter-col">


                          
                    
    <div class="cl-filter-box-header">FİLTRELE</div>

 <?php if($page['level']=='0' or $page['level']=='1'){?>
    <div id="sk-subcategories-navigation" class="block sk-block-navigation active">
        <span class="h5 d-block sk-nav-title collapsable-title">Alt Kategoriler</span>
        <ul class="non-style-list">
              
<?php if($page['level']=='0' or $page['level']=='1'){?>
<?php 
$ustkat1 = $page['id'];
$altkategoriler = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkat1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
if($altkategoriler && count($altkategoriler) > 0){
    foreach($altkategoriler as $ustu2){
        if($ustu2 && !empty($ustu2)){?>
<li><a href="kategori/<?php echo $ustu2['seo'];?>"><?php echo $ustu2['adi'];?></a></li>
        <?php }
    }
} ?>
<?php } ?>
                    
             
        </ul>
    </div>
<?php } ?>
                        <form action="" method="GET">

						<input type="hidden" name="siralama" value="<?php echo temizle($_GET['siralama']);?>"/>	

						<input type="hidden" name="pages" value="<?php echo temizle($_GET['pages']);?>"/>	

						<input type="hidden" name="fiyatfiltre" value="<?php echo temizle($_GET['fiyatfiltre']);?>"/>	

						<?php 

						if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {

			            $markagelenveri = temizle($_GET["markalar"]);

			            foreach($markagelenveri as $markaverisi){?>

				        <input type="hidden" name="markalar[]" value="<?php echo $markaverisi;?>"/>

						<?php  }}?>

								


                       <div id="sk-FİYAT-navigation" class="block sk-block-navigation">
                            <span class="h5 d-block sk-nav-title collapsable-title">FİYAT ARALIĞI</span>
                            <ul class="non-style-list collapsable-list collapsed">
                                    
									
									<?php $bolumfiyat=intval($maxfiyat/5);

												

												for($i=0;$i<5;$i++){

													$basfiyat=intval($minfiyat+$i*$bolumfiyat);

													$sonfiyat=intval($minfiyat+($i+1)*$bolumfiyat);

												?>

												
                                                <li>
												 <label class="input-link" for="FİYAT-1" style="padding: 0px !important;">
														<input style="display: block !important;
position: static;
float: left;
margin-top: 8px;
margin-right: 10px;" <?php echo $_GET['fiyatfiltre'] == $basfiyat."-".$sonfiyat ? 'checked' : null; ?> type="radio" class="custom-control-input" id="size-1<?php echo $i;?>" name="fiyatfiltre" value="<?php echo $basfiyat."-".$sonfiyat;?>">

														<label class="custom-control-label" for="size-1<?php echo $i;?>"><?php echo $basfiyat." - ".$sonfiyat;?> TL</label>

											  </li>

												<?php } ?>

									
									
									
									
								
                                 
                            </ul>
                        </div>
						            <?php $filtre = $ozy->query("select * from filtre where FIND_IN_SET($katid,kategori) order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 

                            foreach($filtre as $filtregel){?>

						  <div id="sk-<?php echo $filtregel['fadi']; ?>-navigation" class="block sk-block-navigation">
                            <span class="h5 d-block sk-nav-title collapsable-title"><?php echo $filtregel['fadi']; ?></span>
                            <ul class="non-style-list collapsable-list collapsed">
                              	    <?php
                                    $gelenfiltreleme = array();
                                    if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {
                                        $gelenfiltreleme = is_array($_GET['filtreleme']) ? $_GET['filtreleme'] : array($_GET['filtreleme']);
                                    }
                                    $katoz = $filtregel['ozellik'];
                                    $katozel = explode(',', $katoz);
                                    foreach( $katozel as $katozellik => $verimiz ){
                                        $verimiz = trim($verimiz);
                                        if(empty($verimiz)) continue;
                                    ?>
											   

								  <li>
                                        <label class="input-link" for="<?php echo $filtregel['fadi']; ?>-1<?php echo $verimiz;?>">
                                            <input  <?php 																																if (in_array($verimiz,$gelenfiltreleme)){																																echo "checked";																}; ?> type="checkbox" id="<?php echo $filtregel['fadi']; ?>-1<?php echo $verimiz;?>" name="filtreleme[]" value="<?php echo $verimiz;?>">
                                            <span class="text">
                                                <span class="filter-active"></span>
                                                <span class="filter-text"><?php echo $verimiz;?></span>
                                            </span>
                                          
                                        </label>
                                    </li>
                                
						<?php } ?> 
                            </ul>
                        </div>
						
						<?php } ?>
												
												
												

						  <div id="sk-MARKA-navigation" class="block sk-block-navigation">
                            <span class="h5 d-block sk-nav-title collapsable-title">MARKALAR</span>
                            <ul class="non-style-list collapsable-list collapsed">
                                 
										                                               <?php
                                    $markafiltreleme = array();
                                    if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {
                                        $markafiltreleme = is_array($_GET['markalar']) ? $_GET['markalar'] : array($_GET['markalar']);
                                    }
                                    
                                    $markalarimiz = "";
                                    if(!empty($urunmarkalari)){
                                        $kelimeler = explode(",", $urunmarkalari);
                                        foreach($kelimeler as $markamid){
                                            $markamid = trim($markamid);
                                            if($markamid == ''){
                                                $newid = "0";
                                            } else {
                                                $newid = $markamid;
                                            }
                                            $markalarimiz .= "".$newid.",";
                                        }
                                        $markalarimiz = mb_substr($markalarimiz, 0, -1);
                                    }
                                    
                                    if(!empty($markalarimiz)){
                                        $mark = $ozy->query("select adi,id from markalar where durum='1' AND id IN ($markalarimiz) group by adi asc")->fetchAll(PDO::FETCH_ASSOC);
                                    } else {
                                        $mark = array();
                                    }
                                    
                                    foreach($mark as $marka){
                                        $markaidmmmm = $marka['id'];
                                    ?>																		   

								  <li>
                                        <label class="input-link" for="MARKA-1<?php echo $marka['id']; ?>">
                                            <input  <?php 																																if (in_array($markaidmmmm,$markafiltreleme)){																																echo "checked";																};?> type="checkbox"   id="MARKA-1<?php echo $marka['id']; ?>" name="markalar[]" value="<?php echo $marka['id']; ?>">
                                            <span class="text">
                                                <span class="filter-active"></span>
                                                <span class="filter-text"><?php echo $marka['adi']; ?></span>
                                            </span>
                                          
                                        </label>
                                    </li>
                                
						<?php } ?> 
                            </ul>
                        </div>


		<div class="col-12 col-lg-12" style="padding: 0px;">

	                		<div class="btn-wrap">

		                	
                				

		                		<button style="margin: 0px !important;
    margin-bottom: 0px;
height: 30px !important;
font-size: 12px !important;
border-radius: 19px !important;
margin-bottom: 10px !important;
line-height: 16px !important;" type="submit" class="butonok btn btn-primary btn-rounded">Filteyi Uygula</a>
	

                			
		                	</div><!-- End .btn-wrap -->
							<a href="kategori/<?php echo $page['seo']; ?>" style="background: #3b3939 !important;
margin: 0px !important;
    margin-bottom: 0px;
height: 30px !important;
font-size: 12px !important;
border-radius: 19px !important;
margin-bottom: 10px !important;
line-height: 16px !important;" class="butonok btn btn-primary btn-rounded">Filtreyi Temizle</a>

		                </div>			








						
						
				</form>	



    </div>
    <div class="cl-col-l10  cl-products-col ">
        
        





                    <div class="cl-category-filter-row">
                <div class="cl-category-filter-row-checkboxes">
                        <div class="cl-filter-item">
                           
                                <span class="text">
                                    <span class="filter-active"></span>
                                    <span class="filter-text">  <?php echo $page['adi'];?>   &nbsp;<span class="active">(<?php $katsorgu = $ozy->prepare("SELECT COUNT(*) FROM urunler where durum='1' and FIND_IN_SET($katid,kategori)");

                                         $katsorgu->execute();

                                         $katsay = $katsorgu->fetchColumn();

                                         echo ''.$katsay.''; ?> Ürün)</span>
                                </span>
                           
                        </div>
                    </div>
                    
                    <p class="cl-category-filter-button">Filtreler<span></span></p>
                   
	<div class="selecti">
		                             <form action="" method="GET"> 

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

									

										

										<input type="hidden" name="pages" value="<?php echo temizle($_GET['pages']);?>"/>

										<input type="hidden" name="fiyatfiltre" value="<?php echo temizle($_GET['fiyatfiltre']);?>"/>	

											<select name="siralama" id="products-orderby" class="cl-custom-selectbox" onchange='this.form.submit()'>

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



                </div>

    <div class="cl-product-grid cl-col-l12">
        <div class="cl-flex-row cl-page-row">
            <span class="cl-product-grid-length"><?php echo $page['adi'];?>   &nbsp;( <?php $katsorgu = $ozy->prepare("SELECT COUNT(*) FROM urunler where durum='1' and FIND_IN_SET($katid,kategori)");

                                         $katsorgu->execute();

                                         $katsay = $katsorgu->fetchColumn();

                                         echo ''.$katsay.''; ?> Ürün)</span>

 
 
 
 <?php 



     

        $pages = intval(@$_GET['pages']);

        if (!$pages) {

          $pages = 1;

        }

        

        $bak = $ozy->prepare("select * from urunler where durum='1' and FIND_IN_SET($katid,kategori)");

        $bak->execute(array());

        $toplam= $bak->rowCount();

        $limit = 40;

        $goster = $pages*$limit-$limit;

        $sayfasayisi = ceil($toplam/$limit);

        $forlimit = 10;

		$where = " ";

		$marka = " ";

		$wherex = " ";

		

		if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {

			$fitregelenveri = temizle($_GET["filtreleme"]);

			foreach($fitregelenveri as $filtreverisi){

				

			$where .= " and FIND_IN_SET('".$filtreverisi."', filtre)";

			

			

		    }

		

		}

		

		if (isset($_GET["fiyatfiltre"]) && $_GET["fiyatfiltre"] != "") {

			$gelenfiyat = temizle($_GET["fiyatfiltre"]);

			$fiyatexp=explode("-",$gelenfiyat);

			

			$wherex = " and if(idurum=1,ifiyat,fiyat)>=".intval($fiyatexp[0])." and if(idurum=1,ifiyat,fiyat)<=".intval($fiyatexp[1]);



		

		}

		

		if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {

			$markagelenveri = is_array($_GET["markalar"]) ? temizle($_GET["markalar"]) : array(temizle($_GET["markalar"]));
            $markammmmm = "";

			foreach($markagelenveri as $markaverisi){

				
            if($markaverisi==''){
			$newid = "0";  
            }else{
			$newid = $markaverisi;    
			}
									  
			$markammmmm .= "".$newid.",";
			}
			
			if(!empty($markammmmm)){
			    $markammmmm = mb_substr($markammmmm,0,-1);
			    $marka = " AND marka IN (".$markammmmm.") ";
			} else {
			    $marka = " ";
			}

			

		    }

		




		

		if (isset($_GET["siralama"]) && $_GET["siralama"] != "") {

			

		if(temizle($_GET["siralama"]=='dusukfiyat')){

			

		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat) AS simdikifiyat from urunler where durum='1' and FIND_IN_SET($katid,kategori) ".$where." ".$wherex." ".$marka." order by simdikifiyat ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

	

        } elseif (temizle($_GET["siralama"]=='yuksekfiyat')) {



 		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat) AS simdikifiyat from urunler where durum='1' and FIND_IN_SET($katid,kategori) ".$where." ".$wherex." ".$marka." order by simdikifiyat DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    	

		} elseif (temizle($_GET["siralama"]=='encokyorum')) {

			

		$pageoku = $ozy->query("select * from urunler where durum='1' and FIND_IN_SET($katid,kategori) ".$where." ".$wherex." ".$marka." order by yorum DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		} elseif (temizle($_GET["siralama"]=='enbegenilen')) {

		

		$pageoku = $ozy->query("select * from urunler where durum='1' and FIND_IN_SET($katid,kategori) ".$where." ".$wherex." ".$marka." order by hit DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		} elseif (temizle($_GET["siralama"]=='eskitarih')) {

		

		$pageoku = $ozy->query("select * from urunler where durum='1' and FIND_IN_SET($katid,kategori) ".$where." ".$wherex." ".$marka." order by tarih ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		} elseif (temizle($_GET["siralama"]=='yenitarih')) {

			

		$pageoku = $ozy->query("select * from urunler where durum='1' and FIND_IN_SET($katid,kategori) ".$where." ".$wherex." ".$marka." order by tarih DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    	

		} elseif (temizle($_GET["siralama"]=='onerilen')) {	

		

		$pageoku = $ozy->query("select * from urunler where durum='1' and FIND_IN_SET($katid,kategori) ".$where." ".$wherex." ".$marka." order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		}

		

		

		} else {

		

		$pageoku = $ozy->query("select * from urunler where durum='1' and FIND_IN_SET($katid,kategori) ".$where." ".$wherex." ".$marka." order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		}

		

	  
        $urunmarkalari.="";
		
		$__URUN__ = false;

        foreach ($pageoku as $katurunler) {
			
        $urunmarkalari.="".$katurunler['marka'].",";
		
        $__URUN__ = true;

		

		?>					

					



<div class="cl-col cl-col-l3 cl-col-m4 cl-col-s6">
                   

<div class="cl-product-box">
    <div class="cl-product-images">
      
			    <?php if($katurunler['idurum']=='1'){?>
			<p class="cl-product-badge discount">
			
			  -%<?php echo yuzdeHesaplama($katurunler['fiyat'],$katurunler['ifiyat']);?>
			</p>
			<?php } ?>
			
			
        <a href="urun/<?php echo $katurunler['seo']; ?>">
            <img class="" src="resimler/urunler/<?php echo $katurunler['resim']; ?>" data-src="resimler/urunler/<?php echo $katurunler['resim']; ?>" alt="Ürün" title="Ürün">
        </a>
        <div class="cl-product-box-inputs">
            <div class="cl-flex-row">
                <div class="cl-product-quantity-input-container">
                   
                </div>
            </div>
            <button class="add-to-cart-button" type="button" onclick="location.href='urun/<?php echo $katurunler['seo']; ?>'">Sepete Ekle </button>
        </div>
    </div>
    <div class="cl-product-info">
        <a href="urun/<?php echo $katurunler['seo']; ?>" class="cl-product-name" title="<?php echo $katurunler['adi']; ?>"><p>
		<?php echo $katurunler['adi']; ?></p></a>
        <div class="cl-product-prices">
         <?php echo urunfiyatbelirle($katurunler['kdv'],$katurunler['idurum'],$katurunler['fiyat'],$katurunler['ifiyat']);?>
            
        </div>
    </div>
</div>

</div>
                
<?php }

							

                            if (!$__URUN__){

								

                            echo "<b style='font-weight: 500;background: #fafafa;padding: 10px;width: 100%;text-align: center;border: 1px solid #ededed;'>Üzgünüm Böyle bir ürün bulunamadı</b>";

							

							}

							?>					
				
 
 
 
 
 
 
 
 
        </div>
		
		<nav aria-label="Page navigation">

                        <ul class="pagination justify-content-center">

			

				  <?php

                  for ($i= $pages - $forlimit ; $i < $pages + $forlimit + 1 ; $i++) { 

                  if ($i>0 and $i<=$sayfasayisi) {

                    

                  if ($i == $pages) {

          

                  echo "<li class='page-item active' aria-current='page'><a class='page-link'>".$i."</a></li>";

                                      

                   }else{

					   

				   $eklenecekstr="";

				   foreach($_GET as $key=>$value) {

							if($key!="pages" and $key!="oziywebs" and $key!="id") $eklenecekstr.=$key."=&".$value;

						}

						$eklenecekstr=$eklenecekstr!="" ? "&".$eklenecekstr : "";

							

                  echo "<li class='page-item'><a class='page-link' href='kategori/".$page['seo']."?pages=".$i.$eklenecekstr."'>".$i."</a></li>";

          

          }



                  }

                }

          

          

          

          

                   ?> 

             

						

                      

							

                          

                        </ul>

                    </nav>
		
		

    </div>
    <div class="cl-plp-seo extended">
        <div class="cl-plp-seo-body">
<h2><?php echo $page['stitle']; ?></h2>
<?php echo $page['sdesc']; ?>
     
    </div>









        
    </div>









        
    </div>
     
    <div class="overlay-filter">
        <div class="cl-category-filter-close-button">
            <img src="<?php echo $sitetemasi;?>/images/close-icon-dark.png">
        </div>
    </div>
</div>






        
    </div>