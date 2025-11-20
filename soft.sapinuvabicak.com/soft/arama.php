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
foreach($ara AS $a)
{
    $adi .= "adi LIKE '%".$a."%' AND ";
    $urunkodu .= "urunkodu LIKE '%".$a."%' AND ";
}
$adi = substr($adi, 0, -4);
$urunkodu = substr($urunkodu, 0, -4);

?>

	   
		  
<style>
.cl-banner-box .cl-banner-images img {
    border-radius: 20px;
}
</style>


<div class="cl-page-row">
<h1 class="cl-page-row-header">Arama Sonuçları</h1>
<h2 class="cl-page-row-subheader">Aradığınız ürünü bulabildiniz mi?</h2>



<div class="cl-product-grid cl-col-l12">
        <div class="cl-flex-row cl-page-row">
  

     <?php 

     
        $pages = intval(@$_GET['pages']);
        if (!$pages) {
          $pages = 1;
        }
        
        $bak = $ozy->prepare("select * from urunler where durum='1' and $adi or $urunkodu");
        $bak->execute(array());
        $toplam= $bak->rowCount();
        $limit = 200000;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 200;
		
	
		
		
		if (isset($_GET["siralama"]) && $_GET["siralama"] != "0") {
			
		if(temizle($_GET["siralama"]=='dusukfiyat')){
			
		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and $adi or $urunkodu order by simdikifiyat ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
	
        } elseif (temizle($_GET["siralama"]=='yuksekfiyat')) {

 		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and $adi or $urunkodu order by simdikifiyat DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    	
		} elseif (temizle($_GET["siralama"]=='encokyorum')) {
			
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu order by yorum DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='enbegenilen')) {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu order by hit DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='eskitarih')) {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu order by tarih DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		} elseif (temizle($_GET["siralama"]=='yenitarih')) {
			
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu order by tarih ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    	
		} elseif (temizle($_GET["siralama"]=='onerilen')) {	
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		}
		
		
		} else {
		
		$pageoku = $ozy->query("select * from urunler where durum='1' and $adi or $urunkodu order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
  	    
		}
		
	    
		
		$__URUN__ = false;
        foreach ($pageoku as $anaurunler) {
        $__URUN__ = true;
		
		?>					

  
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
		<?php }
							
                            if (!$__URUN__){
								
                            echo "".$_GET['arama']." kelimeye ait herhangi bir ürün bulunamadı :(";
							
							}
							?>				
									
										
				
				
				
				
        </div>

          
    </div>







</div>

