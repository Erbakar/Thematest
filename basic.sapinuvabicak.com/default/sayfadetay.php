<?php
$id = temizle($_GET['id']);
$query = $ozy->prepare("UPDATE sayfalar SET hit = (hit+1) WHERE seo=?");
$update = $query->execute(array($id));
?>

<?php 
$id = temizle($_GET['id']); 
$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM sayfalar WHERE seo=:id and durum=:durum");
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
	   
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title"><?php echo $page['adi'];?><span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $page['adi'];?></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="about-text text-left">
                                <h2 class="title text-left mb-2"><?php echo $page['adi'];?></h2><!-- End .title text-center mb-2 -->
                                <a class="image-popup-no-margins" href="resimler/sayfalar/<?php echo $page['resim']?>">
								<img src="resimler/sayfalar/<?php echo $page['resim'];?>" alt="signature" class="mx-auto mb-5" <?php echo $page['resim'] == 'resimyok.jpg' ? 'style="display:none;"' : null; ?>>
								<p><?php echo $page['aciklama'];?> </p>
                                </a>
                               
                            </div><!-- End .about-text -->
                        </div><!-- End .col-lg-10 offset-1 -->
                    </div><!-- End .row -->
                    <div class="row justify-content-left">
					
					
			        <?php 
					$gelenid = $page['id'];
					$sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='sayfalar' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                    foreach($sayfaresimi as $genelresim){?>
                        <div class="col-lg-4 col-sm-6">
                            <div class="icon-box icon-box-sm text-center">
						<a class="image-popup-no-margins" href="resimler/genel/<?php echo $genelresim['sayfaresim'];?>">		
                              <img src="resimler/genel/<?php echo $genelresim['sayfaresim'];?>" alt="image" class="mx-auto mb-6"></div><!-- End .icon-box -->
                        </a>
						</div><!-- End .col-lg-4 col-sm-6 -->
                     <?php } ?>
					 
					 
                    </div><!-- End .row -->
                </div><!-- End .container -->

                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>