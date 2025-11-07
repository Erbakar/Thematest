<?php

include ('func/db.php');

include ('func/fonksiyon.php');

header('Content-Type: text/xml');

echo '<?xml version="1.0" encoding="UTF-8" ?>';

echo '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">';?>

<?php $url= $ayar['siteurl'];

?>

<channel>

		<title><![CDATA[<?php echo $ayar['siteadi']; ?>]]></title>

		<link><?php echo $url; ?></link>

		<description><?php echo $ayar['sitedesc']; ?></description>

        <?php $ss = $ozy->query("select * from urunler where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 

        foreach($ss as $urun){?>

		<item>

			<!-- The following attributes are always required -->

			<g:id><?php echo $urun['id']; ?></g:id>

			<g:title><![CDATA[<?php echo $urun['adi']; ?>]]></g:title>

			<g:description><![CDATA[<?php echo $urun['aciklama']; ?>]]></g:description>

			<g:link><?php echo $url;?>/urun/<?php echo $urun['seo']; ?></g:link>

			<g:image_link><?php echo $url; ?>/resimler/urunler/<?php echo $urun['resim']; ?></g:image_link>

			<g:condition>new</g:condition>

			<g:availability>in stock</g:availability>

			<g:price>

<?php if($urun['idurum']='1'){?>

<?php if($urun['kdv']>'0'){?>

<?php echo $fiyat = KdvDahil($urun['ifiyat'],$urun['kdv']);?>

<?php } else { ?>

<?php echo $fiyat = KdvDahil($urun['ifiyat'],$system['kdv']);?>

<?php } ?>

<?php } else { ?>

<?php if($urun['kdv']>'0'){?>

<?php echo $fiyat = KdvDahil($urun['fiyat'],$urun['kdv']);?>

<?php } else { ?>

<?php echo $fiyat = KdvDahil($urun['fiyat'],$system['kdv']);?>

<?php } ?>

<?php } ?> TL</g:price>

		

			<g:shipping>

				<g:country>TR</g:country>

				<g:service>Standard</g:service>

				<g:price><?php echo $system['genelkargo']; ?> TL</g:price>

			</g:shipping>

			

			<!-- 2 of the following 3 attributes are required fot this item according to the Unique Product Identifier Rules -->

			<g:gtin><?php echo $urun['urunkodu']; ?></g:gtin>

			<?php $urunmarkaid = $urun['marka'];

            $mar = $ozy->query("select * from markalar where durum='1' and id='$urunmarkaid' order by id desc limit 1")->fetchAll(PDO::FETCH_ASSOC); 

            foreach($mar as $marka){?>

            <g:brand><?php echo $marka['adi']; ?></g:brand>

            <?php } ?>

			<g:mpn><?php echo $urun['urunkodu']; ?></g:mpn>

			<g:google_product_category>321</g:google_product_category> 

			<g:product_type>

<?php $etiketler = $urun['kategori'];

$etiketler = explode(',', $etiketler);

foreach( $etiketler as $anahtar => $deger ){

$kat = $ozy->query("select * from kategoriler where durum='1' and id='$deger' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 

foreach($kat as $kategori){?>

<![CDATA[<?php echo $kategori['adi']; ?>]]><?php }} ?></g:product_type>

</item>

<?php } ?>  

</channel>

</rss>