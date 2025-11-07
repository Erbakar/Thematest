    <?php define("guvenlik",true);?>

    <!-- Favicon -->
    <?php if (!empty($ayar['favicon'])) { ?>
    <link rel="shortcut icon" href="<?php echo $url; ?>/resimler/siteayarlari/<?php echo $ayar['favicon']; ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo $url; ?>/resimler/siteayarlari/<?php echo $ayar['favicon']; ?>" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $url; ?>/resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $url; ?>/resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $url; ?>/resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
    <link rel="mask-icon" href="<?php echo $url; ?>/resimler/siteayarlari/<?php echo $ayar['favicon']; ?>" color="#666666">
    <?php } ?>
	
 

    <?php include("".$sitetemasi."/assets/css/main.php");?>
    <link rel="stylesheet" href="<?php echo $sitetemasi;?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo $sitetemasi;?>/assets/css/responsive.css">
	<link rel="stylesheet" href="<?php echo $sitetemasi;?>/assets/css/slick.css">




<?php echo $ayar['google']; ?>
<?php echo $ayar['yandex']; ?>
<?php echo $ayar['reklam']; ?>


<!-- TEMA EKSTRALARI -->	
<?php if (isset($_GET['sepetsil'])) {
$sepetkaldiralim = temizle($_GET['sepetsil']);
$sil = $ozy->prepare("DELETE FROM sepet WHERE id=?");
$sil->execute(array($sepetkaldiralim));





header("Location: ".$url."");
}



    function yuzdeHesaplama($sayi,$sayi2){
    $newsayi = $sayi - $sayi2;	
	$yuzdelik = $sayi/100;
	$son = $newsayi/$yuzdelik;
    return substr($son,0,2);
   } 
   

   
?>
<style>


.old-price {
  color: #aba4a4;
  font-size: 14px;
  font-weight: 600;
  text-decoration: line-through;
  float: right;
}


.stories.carousel {
  white-space: nowrap;
  overflow: auto;
  -webkit-overflow-scrolling: touch;
  overflow-scrolling: touch;
  box-shadow: none !important;
}

.stories.snapgram .story > .item-link > .item-preview {
  border-radius: 50%;
  padding: 2px;
  background: <?php echo $tema['t37'];?> !important;
}

#zuck-modal-content .story-viewer .head .back, #zuck-modal-content .story-viewer .head .right .close {
  font-size: 42px;
  width: 48px;
  height: 48px;
  line-height: 48px;
  cursor: pointer;
  text-align: center;
  color:white !important;
}

/* Slider resmi en-boy oranını koruyarak boyutlandır */
section.slider .mainslider .slick-slide img {
  width: 100%;
  height: auto;
  object-fit: contain;
  max-height: 550px;
}

/* Thumbslider yazılarını gizle */
section.slider .thumbslider .slick-slide span {
  display: none !important;
}

/* Navbar kategori taşması için çözüm */
nav.navbar {
  overflow-x: auto !important;
  overflow-y: hidden !important;
  -webkit-overflow-scrolling: touch;
  scroll-behavior: smooth;
}

nav.navbar::-webkit-scrollbar {
  height: 6px;
}

nav.navbar::-webkit-scrollbar-track {
  background: #f5f5f5;
  border-radius: 3px;
}

nav.navbar::-webkit-scrollbar-thumb {
  background: #3fbafe;
  border-radius: 3px;
}

nav.navbar::-webkit-scrollbar-thumb:hover {
  background: #2ea8e8;
}

/* Firefox için scrollbar */
nav.navbar {
  scrollbar-width: thin;
  scrollbar-color: #3fbafe #f5f5f5;
}

nav.navbar .container-lg {
  overflow-x: visible !important;
  overflow-y: visible !important;
}

nav.navbar .navbar-collapse {
  overflow-x: auto !important;
  overflow-y: visible !important;
  width: 100%;
}

nav.navbar .navbar-collapse::-webkit-scrollbar {
  height: 6px;
}

nav.navbar .navbar-collapse::-webkit-scrollbar-track {
  background: #f5f5f5;
  border-radius: 3px;
}

nav.navbar .navbar-collapse::-webkit-scrollbar-thumb {
  background: #3fbafe;
  border-radius: 3px;
}

nav.navbar .navbar-collapse::-webkit-scrollbar-thumb:hover {
  background: #2ea8e8;
}

nav.navbar .navbar-collapse {
  scrollbar-width: thin;
  scrollbar-color: #3fbafe #f5f5f5;
}

nav.navbar ul.navbar-nav {
  flex-wrap: nowrap !important;
  min-width: max-content !important;
  width: auto !important;
}

nav.navbar ul.navbar-nav li {
  flex-grow: 0 !important;
  flex-shrink: 0 !important;
  width: auto !important;
  min-width: max-content;
}

/* Dropdown menülerin slider üstünde görünmesi için z-index */
nav.navbar {
  z-index: 1030 !important;
  position: relative !important;
}

nav.navbar .container-lg {
  z-index: 1030 !important;
  position: relative !important;
}

nav.navbar .navbar-collapse {
  z-index: 1030 !important;
  position: relative !important;
}

nav.navbar ul.navbar-nav {
  z-index: 1030 !important;
  position: relative !important;
}

nav.navbar ul.navbar-nav li {
  position: relative !important;
  z-index: 1030 !important;
}

nav.navbar ul.navbar-nav li .dropdown-menu {
  z-index: 9999 !important;
  position: absolute !important;
  top: 100% !important;
  left: 0 !important;
  right: 0 !important;
}

nav.navbar ul.navbar-nav li .dropdown-menu.show {
  display: block !important;
}

nav.navbar ul.navbar-nav li.dropdown:hover .dropdown-menu,
nav.navbar ul.navbar-nav li.dropdown.show .dropdown-menu {
  display: block !important;
}

/* Slider section'ın z-index'ini düşür */
section.slider {
  position: relative !important;
  z-index: 1 !important;
}




</style>
<!-- TEMA EKSTRALARI -->
<?php 

function  xurunfiyatbelirle($urunkdv,$indirim,$urunfiyat,$ifiyati){
	
global $system;

if($indirim=='1'){								
if($urunkdv>'0'){?>
<div class="oldprice"><?php echo $eskifiyatz = fiyatgoster(KdvDahil($urunfiyat,$urunkdv));?></div>
<div class="price"><?php echo $yenifiyatz = fiyatgoster(KdvDahil($ifiyati,$urunkdv));?></div>
<?php } else {?>
<div class="oldprice"> <?php echo $eskifiyatz = fiyatgoster(KdvDahil($urunfiyat,$system['kdv']));?></div>
<div class="price"><?php echo $yenifiyatz = fiyatgoster(KdvDahil($ifiyati,$system['kdv']));?></div>
<?php }
} else {
if($urunkdv>'0'){?>
<div class="oldprice"> &nbsp;</div>
<div class="price">
<?php echo $yenifiyatz = fiyatgoster(KdvDahil($urunfiyat,$urunkdv));?></div>
<?php } else {?>
<div class="oldprice">&nbsp; </div>
<div class="price">
<?php 
echo $yenifiyatz = fiyatgoster(KdvDahil($urunfiyat,$system['kdv']));?></div>

<?php
}} 	
	
	
}




if($_GET['oziywebs']=='urun'){	
$idx = temizle($_GET['id']); 
$durumx = "1";
$sayfaqqx = $ozy->prepare("SELECT * FROM urunler WHERE seo=:id and durum=:durum");
$pagex = $sayfaqqx->execute([':id' => $idx,':durum' => $durumx]);
$pagex = $sayfaqqx->fetch(PDO::FETCH_ASSOC);

if($pagex['idurum']=='1'){								
if($pagex['kdv']>'0'){
$yenifiyatx = fiyatgoster(KdvDahil($pagex['ifiyat'],$pagex['kdv']));
} else {
$yenifiyatx = fiyatgoster(KdvDahil($pagex['ifiyat'],$system['kdv']));
}
} else {
if($pagex['kdv']>'0'){
$yenifiyatx = fiyatgoster(KdvDahil($pagex['fiyat'],$pagex['kdv']));
} else { 
$yenifiyatx = fiyatgoster(KdvDahil($pagex['fiyat'],$system['kdv']));
}} 

if($pagex['ucretsizkargo']=='1'){
	$kargommmmmmmmmmmmmmmmmmmm = "/ KARGO BEDAVA"; 
}

if($pagex['alode']=='1'){
	$alodeeeeeee = "/ BU ÜRÜNDE ".$pagex['al']." AL ".$page['ode']." ÖDE FIRSATI"; 
}	
	
$metadesc ="".$pagex['adi']."  Sadece ".$yenifiyatx." ".$kargommmmmmmmmmmmmmmmmmmm." ".$alodeeeeeee."";

?>
<meta name="og:description" content="<?php echo $metadesc; ?>">
<meta property="og:image" content="<?php echo $url; ?>/resimler/urunler/<?php echo $pagex['resim']; ?>"/>
<?php }?>  



</head>
<body>
  <div <?php echo $tema['t13'] == '0' ? 'style="display:none;"' : null; ?>>
		
		<a href="<?php echo $tema['t13']; ?>">
		<img style="width: 100%;" src="resimler/temaayarlari/<?php echo $tema['t12']; ?>" alt="banner"></img></a>
	
</div> 
<header>
     
    <div class="container-lg">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-between">
                <?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
				<a href="hesabim/" class="mobileUser d-xl-none d-lg-none d-md-flex d-sm-flex d-flex">
                    <i class="ri-user-3-line"></i>
                </a>
                <?php } else { ?>
				<a href="uyeol/" class="mobileUser d-xl-none d-lg-none d-md-flex d-sm-flex d-flex">
                    <i class="ri-user-3-line"></i>
                </a>
				<?php } ?>
                <a href="<?php echo $url;?>">
                  <img width="214" height="72" src="resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="<?php echo $ayar['siteadi'];?>"/>
                    <a href="#" class="mobileSearch d-xl-none d-lg-none d-md-flex d-sm-flex d-flex">
                        <i class="ri-search-2-line"></i>
                    </a>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12 d-xl-flex d-lg-flex d-md-none d-sm-none d-none align-items-center justify-content-end">
                <div class="mh text-center me-4">
                    <span class="title">MÜŞTERİ HİZMETLERİ</span>
                    <div class="number"><?php echo strip_tags(mb_substr($ayar['tel'],0,4));?> <span><?php echo strip_tags(mb_substr($ayar['tel'],5,40));?></span></div>
                </div>
                <form action="arama/" method="GET" class="search me-4 d-xl-flex d-lg-flex d-md-none d-sm-none d-none">
                    <div class="form-group position-relative w-100">
                        <input type="text" name="arama" class="form-control" placeholder="Ne aramıştınız ?" required>
                        <button class="search"><i class="ri-search-line"></i></button>
                    </div>
                </form>
                <a href="sepet/" class="btn-cart me-4 d-xl-flex d-lg-flex d-md-none d-sm-none d-none">
                    <span class="icon">
                        <i class="ri-shopping-basket-2-line"></i>
                    </span>
                    <span class="text">Sepetim</span>
                    <span class="number">
                       <?php echo $sepetsayi;?>
                    </span>
                </a>
				
				<?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
                <div class="dropdown d-xl-flex d-lg-flex d-md-none d-sm-none d-none">
                    <a class="btn-user dropdown-toggle" href="#" role="button" id="user" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="icon">
                            <i class="ri-user-3-line"></i>
                        </span>
                        <span class="text d-flex align-items-center">Hesabım <i class="ri-arrow-drop-down-line"></i></span>
                    </a>
                    <div class="dropdown-menu" id="user" aria-labelledby="userDropdown">
                        <ul>
                    
                            <li><a href="hesabim/">Hesabım</a></li>
                            <li><a href="hesabim/">Sipariş Geçmişi</a></li>
                            <li><a href="hesabim/">Şifremi Güncelle</a></li>
                            <li><a href="cikis/">Çıkış</a></li>
                        </ul>
                    </div>
                </div>
				<?php } else { ?>
                <a href="uyeol/" class="btn-user">
                    <span class="icon">
                        <i class="ri-user-3-line"></i>
                    </span>
                    <span class="text">Giriş Yap<br><em>veya üye ol</em></span>
                </a>
				<?php } ?>
				
				
            </div>
        </div>
    </div>
</header>
<nav class="navbar navbar-expand-xl navbar-light d-xl-flex d-none sticky-top">
    <div class="container-lg">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex align-items-center justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav">
			
			<?php $ustkattt = $ozy->query("select * from kategoriler where durum='1' and ustkat='0' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
            foreach($ustkattt as $katadi){?>

            <?php if($katadi['ac']=='1'){?>	
			
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="kategori/<?php echo $katadi['seo']; ?>" role="button" id="kategoriToggle<?php echo $katadi['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>
                            <?php if($katadi['nikon'] === null or $katadi['nikon'] === '' or $katadi['nikon'] === '1' or $katadi['nikon'] === '0'){?>
						    <?php } else { ?>	
                            <img style="height: 28px;width: 32px;margin-right: 5px;" src="resimler/kategoriler/<?php echo $katadi['nikon']; ?>"></img>
                            <?php } ?>	
							
							<?php echo $katadi['adi']; ?>
                        </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="kategoriToggle<?php echo $katadi['id']; ?>">
                        <div class="container-lg">
                            <div class="row">
							
				<?php 
				
				$ustkatid = $katadi['id'];
				$ustkattta = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                foreach($ustkattta as $katadi2){?>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                    <a href="kategori/<?php echo $katadi2['seo']; ?>">
									<div class="title"><?php echo $katadi2['adi']; ?></div>
									</a>
                                    <div class="linkgroup">
                                 	    <?php 
				
				$ustkatid2= $katadi2['id'];
				$ustkatttaz = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid2' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                foreach($ustkatttaz as $katadi22){?>
                                        <a href="kategori/<?php echo $katadi22['seo']; ?>"><?php echo $katadi22['adi']; ?></a>
                                  	<?php } ?>  
								  </div>
                                </div>
                             	<?php } ?>   
                               
                                
								
								
								
                            </div>
                        </div>
                    </div>
                </li>
				
				
					      <?php } else { ?>			
														
														
														
														
                                                   
                <li class="nav-item dropdown">
                    <a class="nav-link " href="kategori/<?php echo $katadi['seo']; ?>">
                        <span>
                            <?php if($katadi['nikon'] === null or $katadi['nikon'] === '' or $katadi['nikon'] === '1' or $katadi['nikon'] === '0'){?>
						    <?php } else { ?>	
                            <img style="height: 28px;width: 32px;margin-right: 5px;" src="resimler/kategoriler/<?php echo $katadi['nikon']; ?>"></img>
                            <?php } ?>	
						   <?php echo $katadi['adi']; ?>
                        </span>
                    </a>
                   
                </li>
				
                                                     
													 
													     <?php }} ?>	
				
				
            </ul>
        </div>
    </div>
</nav>
<main>