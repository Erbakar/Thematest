<?php
include ('func/db.php');
include ('func/fonksiyon.php');
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';?>
<?php $url= $ayar['siteurl'];
function sayi($sayi){
		if ( $sayi < 10 ) sayi(++$sayi);
}
?>

<MerchantItems xmlns="http://www.cimri.com/schema/merchant/upload" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<?php $genel = $ozy->query("select * from urunler where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($genel as $urun){?>
<?php 
if($urun['idurum']=='1'){								
if($urun['kdv']>'0'){
$fiyat = KdvDahil($urun['ifiyat'],$urun['kdv']);
} else {
$fiyat = KdvDahil($urun['ifiyat'],$system['kdv']);
}
} else {
if($urun['kdv']>'0'){
$fiyat = KdvDahil($urun['fiyat'],$urun['kdv']);
} else { 
$fiyat = KdvDahil($urun['fiyat'],$system['kdv']);
}} 
?>
<MerchantItem>
<?php 
$urunmarkaid = $urun['marka'];
$mar = $ozy->query("select * from markalar where durum='1' and id='$urunmarkaid' order by id desc limit 1")->fetchAll(PDO::FETCH_ASSOC); 
foreach($mar as $marka){?>
<brand><![CDATA[<?php echo $marka['adi']; ?>]]></brand>
<?php } ?>
<merchantItemCategoryName>
<?php 
$etiketler = $urun['kategori'];
$etiketler = explode(',', $etiketler);
foreach( $etiketler as $anahtar => $deger ){
$kat = $ozy->query("select * from kategoriler where durum='1' and id='$deger' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($kat as $kategori){?>
<![CDATA[<?php echo $kategori['adi']; ?>-]]><?php }} ?></merchantItemCategoryName>
<merchantItemId><?php echo $urun['id']; ?></merchantItemId>
<merchantItemCategoryId>
<?php 
$etiketler = $urun['kategori'];
$etiketler = explode(',', $etiketler);
foreach( $etiketler as $anahtar => $deger ){
$kat = $ozy->query("select * from kategoriler where durum='1' and id='$deger' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($kat as $kategori){?>
<![CDATA[<?php echo $kategori['id']; ?>-]]><?php }} ?></merchantItemCategoryId>
<merchantItemField/>
<itemTitle><![CDATA[<?php echo $urun['adi']; ?>]]></itemTitle>
<itemUrl><![CDATA[<?php echo $url;?>/urun/<?php echo $urun['seo']; ?>]]></itemUrl>
<price3T><![CDATA[<?php echo $t3 = ($fiyat/3);?>]]></price3T>
<price6T><![CDATA[<?php echo $t6 = ($fiyat/6);?>]]></price6T>
<price9T><![CDATA[<?php echo $t9 = ($fiyat/9);?>]]></price9T>
<price12T><![CDATA[<?php echo $t12 = ($fiyat/12);?>]]></price12T>
<itemImageUrl><![CDATA[<?php echo $url; ?>/resimler/urunler/<?php echo $urun['resim']; ?>]]></itemImageUrl>
<?php if($urun['havaledurum']=='1'){?>
<priceEft><![CDATA[<?php echo $urun['hfiyat'];?>]]></priceEft>
<?php } else { ?>
<priceEft><![CDATA[<?php echo $fiyat;?>]]></priceEft>
<?php } ?>
<pricePlusTax><![CDATA[<?php echo $fiyat;?>]]></pricePlusTax>
<shippingFee>0</shippingFee>
<stockStatus><?php echo $urun['stok'];?></stockStatus>
<shippingDay>0</shippingDay>
<merchantItemField/>
</MerchantItem>
<?php } ?>  
</MerchantItems>