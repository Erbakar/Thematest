<?php
include ('func/db.php');
include ('func/fonksiyon.php');
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';?>
<urunler> 
<?php $url= $ayar['siteurl'];
function sayi($sayi){
		if ( $sayi < 10 ) sayi(++$sayi);
}
?>
<?php $genel = $ozy->query("select * from urunler where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($genel as $urun){?>
<urun>
<urunadi><![CDATA[<?php echo $urun['adi']; ?>]]></urunadi>
<urunkodu><![CDATA[<?php echo $urun['urunkodu']; ?>]]></urunkodu>
<kategori>
<?php 
$etiketler = $urun['kategori'];
$etiketler = explode(',', $etiketler);
foreach( $etiketler as $anahtar => $deger ){
$kat = $ozy->query("select * from kategoriler where durum='1' and id='$deger' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($kat as $kategori){?>
<![CDATA[<?php echo $kategori['adi']; ?>-]]><?php }} ?></kategori>
<stok><?php echo $urun['stok']; ?></stok>
<fiyati>
<?php if($urun['kdv']>'0'){?>
<?php echo KdvDahil($urun['fiyat'],$urun['kdv']);?>
<?php } else { ?>
<?php echo KdvDahil($urun['fiyat'],$system['kdv']);?>
<?php } ?>
</fiyati>
<kdv>
<?php if($urun['kdv']>'0'){?>
<?php echo $urun['kdv'];?>
<?php } else { ?>
<?php $system['kdv'];?>
<?php } ?>
</kdv>
<indirim><?php echo $urun['idurum']; ?></indirim>
<indirimlifiyati>
<?php if($urun['kdv']>'0'){?>
<?php echo KdvDahil($urun['ifiyat'],$urun['kdv']);?>
<?php } else { ?>
<?php echo KdvDahil($urun['ifiyat'],$system['kdv']);?>
<?php } ?>
</indirimlifiyati>
<havaleindirimi><?php echo $urun['havaledurum']; ?></havaleindirimi>
<havalefiyati>
<?php if($urun['kdv']>'0'){?>
<?php echo KdvDahil($urun['hfiyat'],$urun['kdv']);?>
<?php } else { ?>
<?php echo KdvDahil($urun['hfiyat'],$system['kdv']);?>
<?php } ?>
</havalefiyati>
<yildiz><?php echo $urun['yildiz']; ?></yildiz>
<?php 
$urunmarkaid = $urun['marka'];
$mar = $ozy->query("select * from markalar where durum='1' and id='$urunmarkaid' order by id desc limit 1")->fetchAll(PDO::FETCH_ASSOC); 
foreach($mar as $marka){?>
<markasi><![CDATA[<?php echo $marka['adi']; ?>]]></markasi>
<?php } ?>
<ucretsizkargo><?php echo $urun['ucretsizkargo']; ?></ucretsizkargo>
<kisaaciklama><![CDATA[<?php echo $urun['kisa']; ?>]]></kisaaciklama>
<aciklama><![CDATA[<?php echo $urun['aciklama']; ?>]]></aciklama>
<aramafiltre><![CDATA[<?php echo $urun['filtre']; ?>]]></aramafiltre>
<resim><![CDATA[<?php echo $url; ?>/resimler/genel/<?php echo $urun['resim']; ?>]]></resim>
<?php $gelenid = $urun['id'];
$i = 0;
$sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='urunler' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($sayfaresimi as $genelresim){?> 
<resim<?php echo $i;?>><![CDATA[<?php echo $url; ?>/resimler/genel/<?php echo $genelresim['sayfaresim'];?>]]></resim<?php echo $i++;?>>
<?php } ?> 
<?php
$ekresimid = $urun['id'];
$aozellik = $ozy->prepare("SELECT * FROM anaozellik WHERE urunid = ?");
$result = $aozellik->execute(array($ekresimid));
foreach( $aozellik as $verimiz ){?>
<secenekler>
<secenekadi><![CDATA[<?php echo $verimiz['adi'];?>]]></secenekadi>
<?php $ustid = $verimiz['id'];
$altozellik = $ozy->prepare("SELECT * FROM anaozellikalt WHERE anaid = ?");
$resultalt = $altozellik->execute(array($ustid));
foreach( $altozellik as $altverimiz ){?>
<altsecenek>
<altsecenekadi><![CDATA[<?php echo $altverimiz['adi'];?>]]></altsecenekadi>
<altsecenekstok><![CDATA[<?php echo $altverimiz['stok'];?>]]></altsecenekstok>
<altsecenekfiyat><![CDATA[<?php echo $altverimiz['fiyat'];?>]]></altsecenekfiyat>
</altsecenek>
<?php } ?> 
</secenekler>
<?php } ?> 


</urun>
<?php } ?>   
</urunler>
