<?php
$id = temizle($_GET['id']);
$query = $ozy->prepare("UPDATE kampanyalar SET hit = (hit+1) WHERE seo=?");
$update = $query->execute(array($id));
?>

<?php 
$id = temizle($_GET['id']); 
$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM kampanyalar WHERE seo=:id and durum=:durum");
$page = $sayfaqq->execute([':id' => $id,':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

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


 
	<section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h1><?php echo $page['adi']; ?></h1>
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a>Ana Sayfa</a></li>
                  <li class="breadcrumb-item"><a>Kampanyalar</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $page['adi']; ?></li>
                </ol>
            </nav>
        </div>
    </section>
	
	
	
	
    <section class="page pt-5 pb-5">
        <div class="container-lg">
            <div class="row content">
			<?php if($page['resim']=='resimyok.jpg'){?>
			 <div class="col-lg-12 d-flex align-items-center">
                    <div class="g">
                        <?php echo $page['aciklama']; ?>
                    </div>
                </div>
				<?php } else { ?>
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="g">
                        <?php echo $page['aciklama']; ?>
                    </div>
                </div>
                <div class="col-md-6 d-xl-flex d-lg-flex d-md-none d-sm-none d-none align-items-center justify-content-end">
                  <a href="resimler/kampanyalar/<?php echo $page['resim']?>" data-lightbox="image-1">
                             
				  <img src="resimler/kampanyalar/<?php echo $page['resim']?>" alt="" class="img-fluid" width="600" height="538">
                </a>
				</div>
				<?php } ?>
				
				
            </div>
			
				<div class="row content mt-4">
						
			        <?php 
					$gelenid = $page['id'];
					$sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='kampanyalar' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                    foreach($sayfaresimi as $genelresim){?>
                      <div class="col-lg-3 col-md-3">
                        
						<a data-lightbox="image-1" href="resimler/genel/<?php echo $genelresim['sayfaresim'];?>">		
                              <img style="width: 100%;" src="resimler/genel/<?php echo $genelresim['sayfaresim'];?>" alt="image" class="mx-auto mb-6">
                        </a>
						</div>
						
                     <?php } ?>
					</div>
			
        </div>
    </section>
 