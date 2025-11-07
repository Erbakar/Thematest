<?php
include ('func/db.php');
include ('func/fonksiyon.php');
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';?>
<rss version='2.0'>
<channel>
<title><?php echo $ayar['siteadi']; ?></title>
<description><?php echo $ayar['des']; ?></description>
<?php $url= $ayar['siteurl']; ?>
<link><?php echo $url;?></link>
<?php $haber = $ozy->query("select * from haberler where durum='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($haber as $blog){?>
<item>
<title><![CDATA[<?php echo $blog['adi']; ?>]]></title>
<link><![CDATA[<?php echo $url;?>/blog/<?php echo $blog['seo']; ?>]]></link>
<pubDate><![CDATA[<?php echo $blog['tarih']; ?> GMT]]></pubDate>
</item>
<?php } ?>  
</channel>
</rss>