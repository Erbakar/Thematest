<?php if (!defined("guvenlik")) define("guvenlik", true); ?>
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
<link rel="icon" type="image/png" sizes="32x32" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
<link rel="icon" type="image/png" sizes="16x16" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
<link rel="mask-icon" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>" color="#666666">
<link rel="shortcut icon" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
<!-- Plugins CSS File -->
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/vendor/line-awesome/css/line-awesome.min.css">
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/css/plugins/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/css/plugins/magnific-popup/magnific-popup.css">
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/css/plugins/jquery.countdown.css">
<!-- Main CSS File -->
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/css/skins/skin-demo-4.css">
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/css/demos/demo-4.css">
<link rel="stylesheet" href="<?php echo $sitetemasi; ?>/assets/css/plugins/nouislider/nouislider.css">
<?php echo $ayar['google']; ?>
<?php echo $ayar['yandex']; ?>
<?php echo $ayar['reklam']; ?>
<style>
:root {
  --trendy-accent: #9333ea;
  --trendy-accent-dark: #7c3aed;
  --trendy-text: #111422;
  --trendy-muted: #5b6370;
  --trendy-border: #eceff5;
  --trendy-soft: #f9fafb;
  --trendy-shadow: 0 20px 60px rgba(147, 51, 234, 0.12);
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
  cursor: pointer;
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
  background: linear-gradient(135deg, #a855f7, var(--trendy-accent));
  color: #fff;
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  margin-top: 6px;
}

.trendy-nav__all-btn:hover {
  transform: translateY(-1px);
}

.trendy-nav__all-btn .icon-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
}

.trendy-nav__all-btn i {
  font-size: 22px;
  display: inline-block;
  font-family: "molla", sans-serif;
  font-style: normal;
  font-weight: normal;
  line-height: 1;
  color: #fff;
  opacity: 1;
  visibility: visible;
}

.trendy-nav__all-btn > i:not(.icon-wrap i) {
  font-size: 18px !important;
  margin-left: auto;
  transition: transform 0.3s ease;
  display: inline-block !important;
  color: #fff !important;
  opacity: 1 !important;
  visibility: visible !important;
  font-family: "molla", sans-serif !important;
}

.trendy-nav__all-btn[aria-expanded="true"] > i:not(.icon-wrap i) {
  transform: rotate(180deg);
}

.trendy-nav__primary-toggle i {
  font-family: "molla", sans-serif;
  font-style: normal;
  font-weight: normal;
  display: inline-block;
  line-height: 1;
  color: var(--trendy-muted);
  opacity: 1;
  visibility: visible;
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

.trendy-nav__primary-item:hover {
  background: #fff;
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
  cursor: pointer;
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
  padding: 8px 0;
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
  display: inline-block;
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
    display: none !important;
  }
  
  .trendy-nav__content {
    flex-direction: column;
    width: 100%;
    max-height: none;
    overflow: visible;
    border-top: 1px solid var(--trendy-border);
    padding-top: 16px;
  }
  
  .trendy-nav__content.is-open {
    max-height: none;
    padding-top: 16px;
  }
  
  .trendy-nav__categories {
    min-width: 100%;
    padding: 0 15px;
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
  
  .trendy-nav__shortcuts {
    margin: 0 15px;
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

.stories.carousel {
  text-align: center;
  white-space: nowrap;
  overflow: auto;
  -webkit-overflow-scrolling: touch;
  overflow-scrolling: touch;
}
</style>
</head>

<body>


    <div <?php echo $tema['t13'] == '0' ? 'style="display:none;"' : null; ?>>

        <a href="<?php echo $tema['t13']; ?>"><img style="width: 100%;" src="resimler/temaayarlari/<?php echo $tema['t12']; ?>" alt="banner"></img></a>

    </div>

    <div class="page-wrapper">
        <header class="header header-intro-clearance header-4">

            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <a href="tel:<?php echo $ayar['tel']; ?>"><i class="icon-phone"></i>Destek Hattı: <?php echo $ayar['tel']; ?></a>
                    </div><!-- End .header-left -->

                    <div class="mobiluyelik">
                        <?php if (!empty($_SESSION['uyegirisdurumu']) && $_SESSION['uyegirisdurumu'] == 'true') { ?>
                            <a href="hesabim/"><i class="icon-user" aria-hidden="true"></i> Hesabım</a>
                        <?php } else { ?>
                            <a href="#signin-modal" data-toggle="modal"><i class="icon-user" aria-hidden="true"></i> Üyelik Kaydı / Üye Girişi</a>
                        <?php } ?>
                    </div>
                    <div class="header-right">

                        <ul class="top-menu">
                            <li>

                                <ul>
                                    <?php if (!empty($_SESSION['uyegirisdurumu']) && $_SESSION['uyegirisdurumu'] == 'true') { ?>
                                        <li><a href="hesabim/"><i class="icon-user" aria-hidden="true"></i> Hesabım</a></li>
                                    <?php } else { ?>
                                        <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user" aria-hidden="true"></i> Üyelik Kaydı / Üye Girişi</a></li>
                                    <?php } ?>

                                    <li>
                                        <a href="siparissorgulama/"><i class="icon-truck" aria-hidden="true"></i> Sipariş Sorgulama</a>
                                    </li>
                                    <li>
                                        <a href="bankabilgilerimiz/"><i class="icon-check" aria-hidden="true"></i> Banka Hesaplarımız</a>
                                    </li>
                                </ul>
                            </li>
                        </ul><!-- End .top-menu -->
                    </div><!-- End .header-right -->

                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Mobil Menü</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="anasayfa" class="logo">
                            <img src="resimler/siteayarlari/<?php echo $ayar['logo']; ?>" alt="Logo">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                            <form action="arama/" method="GET">
                                <div class="header-search-wrapper search-wrapper-wide">
                                    <label for="q" class="sr-only">Arama</label>
                                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                    <input type="search" class="form-control" name="arama" id="q" placeholder="Ne aramıştınız ?" required>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                    </div>

                    <div class="header-right">

                        <div class="dropdown compare-dropdown">
                            <a href="urunkarsilastirma/" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
                                <div class="icon">
                                    <i class="icon-random"></i>

                                </div>
                                <p>Karşılaştırma</p>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="compare-products">
                                    <?php
                                    $sepetebak1 = $ozy->prepare("SELECT * FROM karsilastir WHERE kim=? and gelenkim=?");
                                    $sepetebak1->execute(array($ip, $sepetimdekikim));
                                    if ($sepetebak1->rowCount()) {
                                        $uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
					  INNER JOIN karsilastir ON urunler.id = karsilastir.urunid  
					  WHERE karsilastir.kim=? and karsilastir.gelenkim=? ORDER BY karsilastir.id DESC");
                                        $uyesepeti1->execute(array($ip, $sepetimdekikim));
                                        foreach ($uyesepeti1 as $karsilastirma) { ?>

                                            <li class="compare-product">
                                                <a href="?karsilastirmasil=<?php echo $karsilastirma['id']; ?>" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                                <h4 class="compare-product-title"><a href="urun/<?php echo $karsilastirma['seo']; ?>"><?php echo $karsilastirma['adi']; ?></a></h4>
                                            </li>
                                    <?php }
                                    } ?>
                                </ul>

                                <div class="compare-actions">
                                    <a href="?tumunusil" class="action-link">Tümünü Sil</a>
                                    <a href="urunkarsilastirma/" class="btn btn-outline-primary-2"><span>Karşılaştır</span><i class="icon-long-arrow-right"></i></a>
                                </div>
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .compare-dropdown -->


                        <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                        <div class="wishlist">
                            <a href="favorilerim/" title="Wishlist">
                                <div class="icon">
                                    <i class="icon-heart-o"></i>
                                    <span class="wishlist-count badge"><?php echo $favorisayisi; ?></span>
                                </div>
                                <p>Favorilerim</p>
                            </a>
                        </div><!-- End .compare-dropdown -->
                        <?php } ?>



                        <div class="dropdown cart-dropdown">
                            <a href="" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <div class="icon">
                                    <i class="icon-shopping-cart"></i>
                                    <span class="cart-count"><?php echo $sepetsayi; ?></span>
                                </div>
                                <p>Sepet</p>
                            </a>

                            <?php if ($sepetsayi >= '1') { ?>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-cart-products">
                                        <?php
                                        $sepetebak = $ozy->prepare("SELECT * FROM sepet WHERE kim=? and gelenkim=?");
                                        $sepetebak->execute(array($ip, $sepetimdekikim));
                                        if ($sepetebak->rowCount()) {
                                            $uyesepeti = $ozy->prepare("SELECT * FROM urunler 
					  INNER JOIN sepet ON urunler.id = sepet.urunid  
					  WHERE sepet.kim=? and sepet.gelenkim=? ORDER BY sepet.id DESC");
                                            $uyesepeti->execute(array($ip, $sepetimdekikim));
                                            foreach ($uyesepeti as $sepet) { ?>
                                                <div class="product">
                                                    <div class="product-cart-details">
                                                        <h4 class="product-title">
                                                            <a href="urun/<?php echo $sepet['seo']; ?>"><?php echo $sepet['adi']; ?></a>
                                                        </h4>

                                                        <span class="cart-product-info">
                                                            <span class="cart-product-qty"><?php echo $sepet['adet']; ?></span>
                                                            x <?php echo fiyatgoster($sepet['fiyat'] + $sepet['efiyat']); ?>
                                                        </span>
                                                    </div><!-- End .product-cart-details -->

                                                    <figure class="product-image-container">
                                                        <a href="urun/<?php echo $sepet['seo']; ?>" class="product-image">
                                                            <img src="resimler/urunler/<?php echo $sepet['resim']; ?>" alt="product">
                                                        </a>
                                                    </figure>
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="sepetid" value="<?php echo $sepet['id']; ?>" />
                                                        <button name="delete" type="submit" class="btn-remove" title="Sil"><i class="icon-close"></i></button>
                                                    </form>
                                                </div><!-- End .product -->

                                        <?php }
                                        } ?>


                                    </div><!-- End .cart-product -->

                                    <div class="dropdown-cart-total">
                                        <span>Ara Tutar</span>

                                        <span class="cart-total-price"><?php echo fiyatgoster($sepetbedeli); ?></span>
                                    </div><!-- End .dropdown-cart-total -->

                                    <div class="dropdown-cart-action">
                                        <a href="anasayfa" class="btn btn-primary">Alışverişe Devam</a>
                                        <a href="sepet/" class="btn btn-outline-primary-2"><span>Satın Al</span><i class="icon-long-arrow-right"></i></a>
                                    </div><!-- End .dropdown-cart-total -->
                                </div><!-- End .dropdown-menu -->

                            <?php } ?>



                        </div><!-- End .cart-dropdown -->

                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->

        </header><!-- End .header -->
        
        <nav class="trendy-nav sticky-top" id="siteNav" data-trendy-nav>
            <div class="container trendy-nav__container">
                <div class="trendy-nav__inner">
                    <?php 
                    $ustkattt = $ozy->query("select * from kategoriler where durum='1' and ustkat='0' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                    // Varsayılan olarak 3 göster, masaüstünde 6 göster
                    $shortcutLimit = 3;
                    if (isset($_SERVER['HTTP_USER_AGENT'])) {
                        // Masaüstü tarayıcılar için kaba bir kontrol
                        if (!preg_match('/Mobile|Android|iP(hone|od|ad)|IEMobile|BlackBerry|Opera Mini/i', $_SERVER['HTTP_USER_AGENT'])) {
                            $shortcutLimit = 6;
                        }
                    }
                    $shortcutItems = array_slice($ustkattt, 0, $shortcutLimit);
                    ?>
                    <div class="trendy-nav__content is-open" id="trendyNavContent" data-nav-content aria-hidden="false">
                        <div class="trendy-nav__categories">
                            <button class="trendy-nav__all-btn" type="button" data-all-toggle aria-expanded="false" aria-controls="allCategoriesPanel">
                                <span class="icon-wrap">
                                    <i class="icon-bars"></i>
                                    <span>TÜM KATEGORİLER</span>
                                </span>
                                <i class="icon-angle-down"></i>
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
                                                <i class="icon-angle-right"></i>
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

            var navContent = navRoot.querySelector('[data-nav-content]');
            var allToggle = navRoot.querySelector('[data-all-toggle]');
            var allPanel = navRoot.querySelector('[data-all-panel]');
            var primaryItems = navRoot.querySelectorAll('[data-cat]');
            var detailPanels = navRoot.querySelectorAll('[data-cat-panel]');
            var mq = window.matchMedia('(min-width: 1200px)');

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
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeAllDrawer();
                }
            });
        });
        </script>