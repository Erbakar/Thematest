<?php
include ('func/db.php');
include ('func/fonksiyon.php');
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';?>
<products> 
<?php $url= $ayar['siteurl'];
function sayi($sayi){
		if ( $sayi < 10 ) sayi(++$sayi);
}
?>
<?php $genel = $ozy->query("select * from urunler where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($genel as $urun){?>
<product>
<sku><?php echo $urun['id']; ?></sku>
<name><![CDATA[<?php echo $urun['adi']; ?>]]></name>
<url><![CDATA[<?php echo $url;?>/urun/<?php echo $urun['seo']; ?>]]></url>
<imgUrl><![CDATA[<?php echo $url; ?>/resimler/urunler/<?php echo $urun['resim']; ?>]]></imgUrl>
<description><![CDATA[<?php echo $urun['aciklama']; ?>]]></description>
<distributor/>
<price>
<?php if($urun['idurum']='1'){?>
<?php if($urun['kdv']>'0'){?>
<?php $fiyat = KdvDahil($urun['ifiyat'],$urun['kdv']);?>
<?php } else { ?>
<?php $fiyat = KdvDahil($urun['ifiyat'],$system['kdv']);?>
<?php } ?>
<?php } else { ?>
<?php if($urun['kdv']>'0'){?>
<?php $fiyat = KdvDahil($urun['fiyat'],$urun['kdv']);?>
<?php } else { ?>
<?php $fiyat = KdvDahil($urun['fiyat'],$system['kdv']);?>
<?php } ?>
<?php } ?>
</price>
<shipPrice>
<?php if($urun['ucretsizkargo']>'1'){?>
0
<?php } else { ?>
<?php echo $system['genelkargo'];?>
<?php } ?>
</shipPrice>
<shipmentVolume>0</shipmentVolume>
<dayOfDelivery>1</dayOfDelivery>
<quantity><![CDATA[<?php echo $urun['stok']; ?>]]></quantity>
<?php 
$urunmarkaid = $urun['marka'];
$mar = $ozy->query("select * from markalar where durum='1' and id='$urunmarkaid' order by id desc limit 1")->fetchAll(PDO::FETCH_ASSOC); 
foreach($mar as $marka){?>
<productBrand><![CDATA[<?php echo $marka['adi']; ?>]]></productBrand>
<?php } ?>

<productCategory>
<?php 
$etiketler = $urun['kategori'];
$etiketler = explode(',', $etiketler);
foreach( $etiketler as $anahtar => $deger ){
$kat = $ozy->query("select * from kategoriler where durum='1' and id='$deger' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($kat as $kategori){?>
<![CDATA[<?php echo $kategori['adi']; ?>-]]><?php }} ?></productCategory>
<stok><?php echo $urun['stok']; ?></stok>
<barcode/>
</product>
<?php } ?>   
</products>