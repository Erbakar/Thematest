<title>Ürün Karşılaştırma</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>


      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Ürün Karşılaştırma</h2>
        </div>
    </section>
 
  <section class="banner mt-5" style="margin-bottom:30px;">
            <div class="container-lg">
              
                <div class="row">
										<div class="col-sm-12 customer-login productlist">
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
      <img style="width: 70px !important;" src="resimler/urunler/<?php echo $karsilastirma['resim'];?>" alt="product">
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
     <div class="pb">
    <?php echo xurunfiyatbelirle($karsilastirma['kdv'],$karsilastirma['idurum'],$karsilastirma['fiyat'],$karsilastirma['ifiyat']);?>
               
                                                      
      </div>              
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
	  
      <td style="width: 25% !important;"><span><?php echo $karsilastirma['aciklama'];?></span></td>
      
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
                               <span class="stock me-3" style="border-radius: 30px;
display: block;padding:10px;background: white;font-size: 12px;border: 1px solid #ec3737;color: #ec3737;">
							   BU ÜRÜNDE KARGO ÜCRETSİZ</span>
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
	<td> 	  <?php if($karsilastirma['alode']=='1'){?>
                               <span class="stock me-3" style="border-radius: 30px;
display: block;padding:10px;background: white;font-size: 12px;border: 1px solid #6205a2;color: #6205a2;">
							  BU ÜRÜNDE <?php echo $karsilastirma['al'];?> AL <?php echo $karsilastirma['ode'];?> ÖDE FIRSATI                 
           </span>
								<?php } ?>	</td>													
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
    <a style="background: <?php echo $tema['t37'];?>;
border: none;
border-radius: 4px;" href="urun/<?php echo $karsilastirma['seo']; ?>" class="btn btn-primary btn-default font-title" title="Ürünü İncele"><span>Ürünü İncele</span></a>
    
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
    <a href="?karsilastirmasil=<?php echo $karsilastirma['id']; ?>" class="gributton text-center" style="height: 40px;line-height: 0px;font-size: 13px;" title="Remove Product">Listeden Sil</a>
                                        
	</td></span>
	<?php } ?>
    </tr>

	
  </tbody>
</table>
  
</article>
                               
 <style>
		
		
article {
  width:100%;
  margin:0 auto;
  position:relative;
  background: white;
border-radius: 6px;
}

.oldprice {
font-size: 16px;
font-weight: 600;
color: #8d94a6;
text-decoration: line-through;
}
.price {
margin-top: 8px;
font-size: 24px;
font-weight: 600;
color: #00b373;
}
.product-image{
padding: 0px 10px 15px;
display: flex;
text-align: center;
font-size: 16px;
line-height: 1.4;
font-weight: 600;
color: #1f2430;
}

table { border-collapse:collapse;  width:100%; }
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


.product-image {
  width: 100%;
display: block;
text-align: center;
margin: auto;
}



  @media screen and (max-width: 1000px){
  @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px){
.varyantablo table, thead, tbody, th, td, tr {
	display: revert !important;
}
}
}
</style>	
							
								</div>
							
							
			    
                </div>
            </div>
        </section>