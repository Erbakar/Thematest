<title>Ürün Karşılaştırma</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		   <main class="main">
      
        
            <div class="page-content pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="about-text text-left">
                                <!-- DIRTY Responsive pricing table HTML -->

<article>

<table>

  <tbody>
  <tr>
      <td></td>
	<?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	
    <td><span class="txt-l">
	 <a href="urun/<?php echo $karsilastirma['seo'];?>" class="product-image">
      <img style="width: 100%;" src="resimler/urunler/<?php echo $karsilastirma['resim'];?>" alt="product">
    </a>
                            
	</span></td>
	
    <?php } ?>	
	
	
    </tr>
    <tr>
      <td>Ürün Fiyatı</td>
    <?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	
    <td><span class="txt-l">
	<?php if($karsilastirma['idurum']=='1'){?>							
	<?php if($karsilastirma['kdv']>'0'){?>
    <?php echo fiyatgoster(KdvDahil($karsilastirma['ifiyat'],$karsilastirma['kdv']));?>
	<?php } else { ?>
	<?php echo fiyatgoster(KdvDahil($karsilastirma['ifiyat'],$system['kdv']));?>
	<?php } ?>							
	<?php } else { ?>
	<?php if($karsilastirma['kdv']>'0'){?>
    <?php echo fiyatgoster(KdvDahil($karsilastirma['fiyat'],$karsilastirma['kdv']));?>						   
	<?php } else { ?>
	<?php echo fiyatgoster(KdvDahil($karsilastirma['fiyat'],$system['kdv']));?>						    
	<?php } ?>							
	<?php } ?>
                            
	</span></td>
	
    <?php } ?>	
    </tr>
    <tr>
      <td colspan="5" class="sep">Ürün Bilgileri</td>
    </tr>
	   <tr>
      <td>Ürün Adı</td>
      <?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	  
      <td><span><a href="urun/<?php echo $karsilastirma['seo'];?>" class="product-image"><?php echo $karsilastirma['adi'];?></a></span></td>
      
	<?php } ?>
    </tr>
    <tr>
      <td>Ürün Kodu</td>
	<?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	  
      <td><span><?php echo $karsilastirma['urunkodu'];?></span></td>
      
	<?php } ?>
    </tr>
 
   <tr>
      <td>Ürün Özeti</td>
	<?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	  
      <td><span><?php echo $karsilastirma['kisa'];?></span></td>
      
	<?php } ?>
    </tr>
	
	<tr>
      <td>Ürün Açıklaması</td>
	<?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	  
      <td><span><?php echo $karsilastirma['aciklama'];?></span></td>
      
	<?php } ?>
    </tr>
	
	
 
    <tr>
      <td colspan="5" class="sep">Ürün Kampanyaları</td>
    </tr>
       <tr>
      <td>Kargo Durumu</td>
    <?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	<td><span>
    <?php if($karsilastirma['ucretsizkargo']=='1'){?>    
	<div class="product-cargo-button free_shipping">
	<i style="font-size: 18px;" class="icon-truck"></i>
	<span>BU ÜRÜNDE KARGO ÜCRETSİZ</span>
	</div>
    <?php } else { ?>	
	<?php } ?>	
	</span></td>													
	<?php } ?>
    </tr>
	<tr>
	<td>Al Öde Kampanyası</td>
    <?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	<td><span>
    <?php if($karsilastirma['alode']=='1'){?>    
	<div class="product-cargo-button free_shipping">
	<i style="font-size: 18px;" class="icon-shopping-cart"></i>
	<span>BU ÜRÜNDE <?php echo $karsilastirma['al'];?> AL <?php echo $karsilastirma['ode'];?> ÖDE FIRSATI</span>
	</div>
	<?php } else { ?>
	<?php } ?>
	</span></td>													
	<?php } ?>
    </tr>
	
	<tr>
      <td colspan="5" class="sep">Ürün İşlemleri</td>
    </tr>
	<tr>
	<td>Sepete Ekle</td>
    <?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	<td><span>
    <a href="urun/<?php echo $karsilastirma['seo']; ?>" class="btn-product btn-cart" title="Ürünü İncele"><span>Ürünü İncele</span></a>
    
	</td></span>
	<?php } ?>
    </tr>

	<tr>
	<td>Listeden Kaldır</td>
    <?php $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
	INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
	WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");                
	$uyesepeti1->execute(array($ip,$sepetimdekikim));
	foreach ($uyesepeti1 as $karsilastirma) {?>
	<td><span>
    <a href="?karsilastirmasil=<?php echo $karsilastirma['id']; ?>" class="btn-remove" title="Remove Product"><i class="fa fa-close"></i></a>
                                        
	</td></span>
	<?php } ?>
    </tr>

	
  </tbody>
</table>
  
</article>
                               
 <style>
		
		
article {
  width:100%;
  max-width:1000px;
  margin:0 auto;
  position:relative;
}

table { border-collapse:collapse; table-layout:fixed; width:100%; }
th { background:#F5F5F5; display:none; }
td, th {
  height:53px
}
td,th { border:1px solid #DDD; padding:10px; empty-cells:show; }
td,th {
  text-align:left;
}
td+td, th+th {
  text-align:center;
}
td.default {
  display:table-cell;
}
.bg-purple {
  border-top:3px solid #A32362;
}
.bg-blue {
  border-top:3px solid #0097CF;
}
.sep {
  background:#F5F5F5;
  font-weight:bold;
}
.txt-l { font-size: 20px;
font-weight: 500; }
.txt-top { position:relative; top:-9px; left:-2px; }
.tick { font-size:18px; color:#2CA01C; }
.hide {
  border:0;
  background:none;
}


</style>		</div><!-- End .about-text -->
                        </div><!-- End .col-lg-10 offset-1 -->
                    </div><!-- End .row -->
                    
                </div><!-- End .container -->

                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>