<?php
include ('func/db.php');
include ('func/fonksiyon.php');
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';?>
			
<!-- Tekil Sayfalar -->
<?php $lastmod  = date('d.m.Y H:i:s', time());$datetime = new DateTime($lastmod);$result = $datetime->format('Y-m-d\TH:i:sP');?>
<url>
  <loc><?php echo $ayar['siteurl'];?>/index.html</loc>
  <lastmod><?php echo $result;?></lastmod>
  <changefreq>daily</changefreq>
  <priority>1.00</priority>
</url>

<url>
  <loc><?php echo $ayar['siteurl'];?>/siparissorgulama/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/bankabilgilerimiz/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/anasayfa</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/urunkarsilastirma/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/favorilerim/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/404.html</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/gununfirsati/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>

<url>
  <loc><?php echo $ayar['siteurl'];?>/sizinicin/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/iletisim/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/uyeol/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/kampanyalar/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/bloglar/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/sss/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/sifremiunuttum/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/rizametni/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/bloglar/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc><?php echo $ayar['siteurl'];?>/sepet/</loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>

<!-- Tekil Sayfalar -->

<?php $ss = $ozy->query("select * from kategoriler where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($ss as $cc){?>
<url>
  <loc><?php echo $ayar['siteurl'];?>/kategori/<?php echo $cc['seo']; ?></loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<?php } ?> 
<?php $ussa = $ozy->query("select * from urunler where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($ussa as $ucca){?>
<url>
  <loc><?php echo $ayar['siteurl'];?>/urun/<?php echo $ucca['seo']; ?></loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<?php } ?> 
<?php $hiz = $ozy->query("select * from sayfalar where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($hiz as $hizmetler){?>
<url>
  <loc><?php echo $ayar['siteurl'];?>/sayfa/<?php echo $hizmetler['seo']; ?></loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<?php } ?> 
<?php $hab = $ozy->query("select * from kampanyalar where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($hab as $haberler){?>
<url>
  <loc><?php echo $ayar['siteurl'];?>/kampanya/<?php echo $haberler['seo']; ?></loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<?php } ?> 
<?php $pro = $ozy->query("select * from haberler where durum='1' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($pro as $projek){?>
<url>
  <loc><?php echo $ayar['siteurl'];?>/blog/<?php echo $projek['seo']; ?></loc>
  <lastmod><?php echo $result;?></lastmod>
  <priority>0.80</priority>
</url>
<?php } ?> 
</urlset>