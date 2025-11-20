<?php
// SEO değerini doğrudan al, temizleme SEO'yu bozabilir
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
$id = urldecode($id); // URL decode yap

$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM sayfalar WHERE seo=:id and durum=:durum");
$sayfaqq->execute([':id' => $id,':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

// Sayfa bulunamazsa 404 sayfasına yönlendir
if(!$page || empty($page)){
    header("Location: " . $url . "/404");
    exit;
}

// Sayfa bulundu, şimdi hit'i güncelle
$query = $ozy->prepare("UPDATE sayfalar SET hit = (hit+1) WHERE seo=?");
$query->execute(array($id));

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
	<div class="cl-width-limiter">
        
        

    <div class="page topic-page" id="ph-topic">
        <div class="page-title" id="ph-title">
            <h1><?php echo $page['adi']; ?></h1>
        </div>
        <div class="page-body">
            <style>
h1{display:none}
</style>
<div class="cl-static-page cl-footer-page">
<div class="cl-page-row">
<div <?php echo $page['resim'] == 'resimyok.jpg' ? 'style="display:none;"' : null; ?>>
<a href="resimler/sayfalar/<?php echo $page['resim']?>" data-lightbox="image-1">
<img style="width: 100%;text-align: center;margin: auto;" src="resimler/sayfalar/<?php echo $page['resim'];?>" alt="signature" class="mx-auto mb-5">								
</a>
</div>  
<div class="cl-section-header"><?php echo $page['adi']; ?></div>
<div class="cl-section-body">
 
<?php echo $page['aciklama']; ?>
<div class="col-lg-12">
    <?php 
					$gelenid = $page['id'];
					$sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='sayfalar' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                    foreach($sayfaresimi as $genelresim){?>
                        <div class="col-lg-4">
                        
						<a data-lightbox="image-1" href="resimler/genel/<?php echo $genelresim['sayfaresim'];?>">		
                              <img style="width: 25%;text-align: center;margin: auto;float:left;" src="resimler/genel/<?php echo $genelresim['sayfaresim'];?>" alt="image" class="mx-auto mb-6">
                        </a>
						</div><!-- End .col-lg-4 col-sm-6 -->
                     <?php } ?>
</div>					 

</div>



</div>
</div>
        </div>
    </div>





        
    </div>