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
  box-shadow: none !important;
  text-align: center;
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


:root {
  --trendy-accent: #f27a1a;
  --trendy-accent-dark: #d96506;
  --trendy-text: #111422;
  --trendy-muted: #5b6370;
  --trendy-border: #eceff5;
  --trendy-soft: #f9fafb;
  --trendy-shadow: 0 20px 60px rgba(17, 20, 34, 0.12);
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

body.trendy-nav-open {
  overflow: hidden;
}

.trendy-nav {
  background: #fff;
  border-top: 1px solid var(--trendy-border);
  border-bottom: 1px solid var(--trendy-border);
  box-shadow: var(--trendy-shadow);
  position: sticky;
  top: 0;
  z-index: 1030;
}

.trendy-nav__container {
  padding: 0;
}

.trendy-nav__inner {
  display: flex;
  align-items: center;
  gap: 18px;
  min-height: 74px;
}

.trendy-nav__toggle {
  display: none;
  flex-direction: column;
  gap: 6px;
  border: 1px solid var(--trendy-border);
  border-radius: 14px;
  padding: 10px 12px;
  background: #fff;
  color: var(--trendy-text);
  font-weight: 600;
  transition: border-color 0.2s ease, background 0.2s ease;
}

.trendy-nav__toggle-line {
  width: 22px;
  height: 2px;
  background: currentColor;
  border-radius: 99px;
  transition: transform 0.3s ease, opacity 0.3s ease, width 0.3s ease;
}

.trendy-nav__toggle-line:nth-of-type(2) {
  width: 12px;
}

.trendy-nav__toggle-line:nth-of-type(3) {
  width: 18px;
}

.trendy-nav__toggle.is-active .trendy-nav__toggle-line:nth-of-type(1) {
  transform: translateY(4px) rotate(45deg);
}

.trendy-nav__toggle.is-active .trendy-nav__toggle-line:nth-of-type(2) {
  opacity: 0;
}

.trendy-nav__toggle.is-active .trendy-nav__toggle-line:nth-of-type(3) {
  transform: translateY(-4px) rotate(-45deg);
  width: 22px;
}

.trendy-nav__content {
  flex: 1;
  display: flex;
  align-items: stretch;
  gap: 16px;
}

.trendy-nav__categories {
  position: relative;
  min-width: 220px;
}

.trendy-nav__all-btn {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  border: none;
  border-radius: 18px;
  padding: 14px 18px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  background: linear-gradient(135deg, #ffb347, var(--trendy-accent));
  color: #fff;
  box-shadow: 0 12px 30px rgba(242, 122, 26, 0.35);
}

.trendy-nav__all-btn .icon-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
}

.trendy-nav__all-btn i {
  font-size: 22px;
}

.trendy-nav__drawer {
  position: absolute;
  top: calc(100% + 14px);
  left: 0;
  width: min(1100px, calc(100vw - 40px));
  max-height: 640px;
  background: #fff;
  border-radius: 24px;
  border: 1px solid var(--trendy-border);
  box-shadow: 0 40px 80px rgba(17, 20, 34, 0.18);
  overflow: hidden;
  opacity: 0;
  visibility: hidden;
  transform: translateY(12px);
  transition: opacity 0.25s ease, transform 0.25s ease;
  z-index: 1000;
}

.trendy-nav__drawer.is-open {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.trendy-nav__drawer-inner {
  display: flex;
  min-height: 340px;
}

.trendy-nav__primary {
  width: 260px;
  background: var(--trendy-soft);
  border-right: 1px solid var(--trendy-border);
  overflow-y: auto;
}

.trendy-nav__primary-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 18px;
  gap: 12px;
  cursor: pointer;
  transition: background 0.2s ease;
  border-left: 3px solid transparent;
}

.trendy-nav__primary-item.is-active {
  background: #fff;
  border-left-color: var(--trendy-accent);
  box-shadow: inset -8px 0 20px rgba(0,0,0,0.03);
}

.trendy-nav__primary-link {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 12px;
  color: var(--trendy-text);
  text-decoration: none;
  font-weight: 600;
}

.trendy-nav__primary-link img {
  width: 28px;
  height: 28px;
  object-fit: contain;
}

.trendy-nav__primary-toggle {
  border: none;
  background: transparent;
  color: var(--trendy-muted);
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.trendy-nav__details {
  flex: 1;
  padding: 28px 32px;
  overflow-y: auto;
}

.trendy-nav__detail {
  display: none;
}

.trendy-nav__detail.is-active {
  display: block;
}

.trendy-nav__detail-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 28px;
}

.trendy-nav__detail-col {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.trendy-nav__detail-title {
  font-weight: 600;
  color: var(--trendy-text);
  text-decoration: none;
  padding-bottom: 6px;
  border-bottom: 1px solid var(--trendy-border);
}

.trendy-nav__detail-links {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.trendy-nav__detail-links a {
  color: var(--trendy-muted);
  text-decoration: none;
  font-size: 14px;
  transition: color 0.2s ease, padding-left 0.2s ease;
}

.trendy-nav__detail-links a:hover {
  color: var(--trendy-accent);
  padding-left: 6px;
}

.trendy-nav__detail-empty {
  padding: 24px;
  border: 1px dashed var(--trendy-border);
  border-radius: 18px;
  background: var(--trendy-soft);
  color: var(--trendy-muted);
  font-weight: 500;
}

.trendy-nav__shortcuts {
  flex: 1;
  border: 1px solid var(--trendy-border);
  border-radius: 20px;
  padding: 8px 12px;
  background: var(--trendy-soft);
  overflow: hidden;
}

.trendy-nav__shortcuts-list {
  display: flex;
  align-items: center;
  gap: 10px;
  list-style: none;
  margin: 0;
  padding:8px 0;
  overflow-x: auto;
  scrollbar-width: none;
}

.trendy-nav__shortcuts-list::-webkit-scrollbar {
  display: none;
}

.trendy-nav__shortcut-link {
  white-space: nowrap;
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  padding: 10px 18px;
  border-radius: 999px;
  border: 1px solid transparent;
  color: var(--trendy-text);
  background: #fff;
  transition: color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
}

.trendy-nav__shortcut-link:hover,
.trendy-nav__shortcut-link:focus {
  color: var(--trendy-accent);
  border-color: var(--trendy-accent);
  transform: translateY(-1px);
}

@media (max-width: 1199px) {
  .trendy-nav__inner {
    flex-direction: column;
    padding: 16px 0;
  }
  
  .trendy-nav__toggle {
    display: none;
  }
  
  .trendy-nav__content {
    flex-direction: column;
    width: 96%;
    max-height: none;
    overflow: visible;
    border-top: 1px solid var(--trendy-border);
    padding-top: 16px;
  }
  
  .trendy-nav__content.is-open {
    max-height: none;
    overflow-y: visible;
  }
  
  .trendy-nav__categories {
    min-width: 100%;
  }
  
  .trendy-nav__drawer {
    position: static;
    width: 100%;
    max-height: none;
    box-shadow: none;
    border-radius: 18px;
    opacity: 1;
    visibility: visible;
    transform: none;
    margin-top: 12px;
    display: none;
  }
  
  .trendy-nav__drawer.is-open {
    display: block;
  }
  
  .trendy-nav__drawer-inner {
    flex-direction: column;
  }
  
  .trendy-nav__primary {
    width: 100%;
    border-right: none;
    border-bottom: 1px solid var(--trendy-border);
  }
  
  .trendy-nav__primary-item {
    border-left: none;
    border-bottom: 1px solid var(--trendy-border);
  }
  
  .trendy-nav__primary-item.is-active {
    box-shadow: none;
  }
}

@media (max-width: 575px) {
  .trendy-nav__shortcuts {
    padding: 6px 8px;
  }
  
  .trendy-nav__shortcut-link {
    font-size: 13px;
    padding: 8px 14px;
  }
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
<nav class="trendy-nav sticky-top" id="siteNav" data-trendy-nav>
    <div class="container-lg trendy-nav__container">
        <div class="trendy-nav__inner">
			<?php 
			$ustkattt = $ozy->query("select * from kategoriler where durum='1' and ustkat='0' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
			// Varsayılan olarak 3 göster, 6 ve üstü ise 6 göster
			$shortcutLimit = 3;
			if (isset($_SERVER['HTTP_USER_AGENT'])) {
				// Masaüstü tarayıcılar için kaba bir kontrol
				if (!preg_match('/Mobile|Android|iP(hone|od|ad)|IEMobile|BlackBerry|Opera Mini/i', $_SERVER['HTTP_USER_AGENT'])) {
					$shortcutLimit = 6;
				}
			}
			$shortcutItems = array_slice($ustkattt, 0, $shortcutLimit);
			?>
            <button class="trendy-nav__toggle" type="button" aria-expanded="false" aria-controls="trendyNavContent" data-nav-toggle>
                <span class="trendy-nav__toggle-line"></span>
                <span class="trendy-nav__toggle-line"></span>
                <span class="trendy-nav__toggle-line"></span>
                <span class="sr-only">Menüyü aç/kapat</span>
            </button>
            <div class="trendy-nav__content" id="trendyNavContent" data-nav-content aria-hidden="true">
                <div class="trendy-nav__categories">
                    <button class="trendy-nav__all-btn" type="button" data-all-toggle aria-expanded="false" aria-controls="allCategoriesPanel">
                        <span class="icon-wrap">
                            <i class="ri-menu-line"></i>
                            <span>TÜM KATEGORİLER</span>
                        </span>
                        <i class="ri-arrow-down-s-line"></i>
                    </button>
					<?php if(!empty($ustkattt)){ ?>
                    <div class="trendy-nav__drawer" id="allCategoriesPanel" data-all-panel aria-hidden="true">
                        <div class="trendy-nav__drawer-inner">
                            <div class="trendy-nav__primary">
							<?php foreach($ustkattt as $index => $katadi){
							$hasDropdown = $katadi['ac'] == '1';
							$isActive = $index === 0 ? 'is-active' : '';
							?>
                                <div class="trendy-nav__primary-item <?php echo $isActive; ?>" data-cat="<?php echo $katadi['id']; ?>">
                                    <a class="trendy-nav__primary-link" href="kategori/<?php echo $katadi['seo']; ?>">
										<?php if($katadi['nikon'] && $katadi['nikon'] != '0' && $katadi['nikon'] != '1'){?>	
										<img src="resimler/kategoriler/<?php echo $katadi['nikon']; ?>" alt="<?php echo $katadi['adi']; ?>">
										<?php } ?>
                                        <span><?php echo $katadi['adi']; ?></span>
                                    </a>
									<?php if($hasDropdown){ ?>
                                    <button class="trendy-nav__primary-toggle" type="button" aria-label="<?php echo $katadi['adi']; ?> alt kategorileri" data-cat-toggle="<?php echo $katadi['id']; ?>">
                                        <i class="ri-arrow-right-s-line"></i>
                                    </button>
									<?php } ?>
                                </div>
							<?php } ?>
                            </div>
                            <div class="trendy-nav__details">
							<?php foreach($ustkattt as $index => $katadi){
							$hasDropdown = $katadi['ac'] == '1';
							$isDetailActive = $index === 0 ? 'is-active' : '';
							?>
                                <div class="trendy-nav__detail <?php echo $isDetailActive; ?>" data-cat-panel="<?php echo $katadi['id']; ?>">
									<?php 
									$ustkatid = $katadi['id'];
									$ustkattta = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
									if($hasDropdown && !empty($ustkattta)){ ?>
                                    <div class="trendy-nav__detail-grid">
										<?php foreach($ustkattta as $katadi2){?>
                                        <div class="trendy-nav__detail-col">
                                            <a href="kategori/<?php echo $katadi2['seo']; ?>" class="trendy-nav__detail-title"><?php echo $katadi2['adi']; ?></a>
											<?php 
											$ustkatid2 = $katadi2['id'];
											$ustkatttaz = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid2' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
											if(!empty($ustkatttaz)){ ?>
                                            <ul class="trendy-nav__detail-links">
                                                <?php foreach($ustkatttaz as $katadi22){?>
                                                <li><a href="kategori/<?php echo $katadi22['seo']; ?>"><?php echo $katadi22['adi']; ?></a></li>
                                              	<?php } ?>  
											</ul>
											<?php } ?>
                                        </div>
										<?php } ?>
                                    </div>
									<?php } else { ?>
									<div class="trendy-nav__detail-empty">
										<?php echo $katadi['adi']; ?> kategorisindeki ürünleri keşfetmek için menüden ilerleyin.
									</div>
									<?php } ?>
                                </div>
							<?php } ?>
                            </div>
                        </div>
                    </div>
					<?php } ?>
                </div>
                <div class="trendy-nav__shortcuts">
                    <ul class="trendy-nav__shortcuts-list">
					<?php if(!empty($shortcutItems)){ 
					foreach($shortcutItems as $katadi){ ?>
                        <li>
                            <a href="kategori/<?php echo $katadi['seo']; ?>" class="trendy-nav__shortcut-link">
								<?php echo $katadi['adi']; ?>
							</a>
                        </li>
					<?php } } else { ?>
						<li class="trendy-nav__detail-empty" style="margin: 0;">
							Kategoriler yakında yüklenecek.
						</li>
					<?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var navRoot = document.querySelector('[data-trendy-nav]');
    if (!navRoot) {
        return;
    }

    var navToggle = navRoot.querySelector('[data-nav-toggle]');
    var navContent = navRoot.querySelector('[data-nav-content]');
    var allToggle = navRoot.querySelector('[data-all-toggle]');
    var allPanel = navRoot.querySelector('[data-all-panel]');
    var primaryItems = navRoot.querySelectorAll('[data-cat]');
    var detailPanels = navRoot.querySelectorAll('[data-cat-panel]');
    var body = document.body;
    var mq = window.matchMedia('(min-width: 1200px)');

    function isToggleInteractive() {
        if (!navToggle) {
            return false;
        }
        return window.getComputedStyle(navToggle).display !== 'none';
    }

    function setNavOpen(isOpen) {
        if (!navContent) {
            return;
        }
        navContent.classList.toggle('is-open', isOpen);
        navContent.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        if (navToggle) {
            navToggle.classList.toggle('is-active', isOpen);
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
        body.classList.toggle('trendy-nav-open', isOpen);
        if (!isOpen) {
            closeAllDrawer();
        }
    }

    function closeAllDrawer() {
        if (allPanel) {
            allPanel.classList.remove('is-open');
            allPanel.setAttribute('aria-hidden', 'true');
        }
        if (allToggle) {
            allToggle.setAttribute('aria-expanded', 'false');
        }
    }

    function toggleDrawer() {
        if (!allPanel || !allToggle) {
            return;
        }
        var willOpen = !allPanel.classList.contains('is-open');
        allPanel.classList.toggle('is-open', willOpen);
        allPanel.setAttribute('aria-hidden', willOpen ? 'false' : 'true');
        allToggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        if (willOpen && !mq.matches) {
            setNavOpen(true);
        }
    }

    function setActiveCategory(catId) {
        if (!catId) {
            return;
        }
        Array.prototype.forEach.call(primaryItems, function (item) {
            item.classList.toggle('is-active', item.getAttribute('data-cat') === catId);
        });
        Array.prototype.forEach.call(detailPanels, function (panel) {
            panel.classList.toggle('is-active', panel.getAttribute('data-cat-panel') === catId);
        });
    }

    if (navToggle && navContent) {
        navToggle.addEventListener('click', function () {
            var isOpen = !navContent.classList.contains('is-open');
            setNavOpen(isOpen);
        });
    }

    var mqListener = function (event) {
        if (!navContent) {
            return;
        }
        if (event.matches) {
            setNavOpen(false);
        } else {
            setNavOpen(true);
        }
    };

    mqListener(mq);

    if (mq.addEventListener) {
        mq.addEventListener('change', mqListener);
    } else if (mq.addListener) {
        mq.addListener(mqListener);
    }

    if (allToggle) {
        allToggle.addEventListener('click', function () {
            toggleDrawer();
        });
    }

    Array.prototype.forEach.call(primaryItems, function (item) {
        var catId = item.getAttribute('data-cat');
        item.addEventListener('mouseenter', function () {
            if (mq.matches) {
                setActiveCategory(catId);
            }
        });
        item.addEventListener('focusin', function () {
            if (mq.matches) {
                setActiveCategory(catId);
            }
        });
    });

    var toggleButtons = navRoot.querySelectorAll('[data-cat-toggle]');
    Array.prototype.forEach.call(toggleButtons, function (btn) {
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var catId = btn.getAttribute('data-cat-toggle');
            setActiveCategory(catId);
        });
    });

    document.addEventListener('click', function (event) {
        if (!navRoot.contains(event.target)) {
            closeAllDrawer();
            if (isToggleInteractive()) {
                setNavOpen(false);
            }
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAllDrawer();
            if (isToggleInteractive()) {
                setNavOpen(false);
            }
        }
    });
});
</script>

<main>