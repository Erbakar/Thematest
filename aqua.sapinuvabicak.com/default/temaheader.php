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

            <div class="header-bottom header">
                <div class="container">
                    <div class="header-left">
                        <div class="dropdown category-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
                                Ürün Kategorilerimiz <i class="icon-angle-down"></i>
                            </a>

                            <div class="dropdown-menu">
                                <nav class="side-nav">
                                    <ul class="menu-vertical sf-arrows sf-js-enabled" style="touch-action: pan-y; max-height: 300px; overflow-y: auto; overflow-x: hidden;">


                                        <?php $ustkattt = $ozy->query("select * from kategoriler where durum='1' and ustkat='0' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($ustkattt as $katadi) { ?>

                                            <?php if ($katadi['ac'] == '1') { ?>

                                                <li class="megamenu-container">
                                                    <a class="sf-with-ul" href="kategori/<?php echo $katadi['seo']; ?>">
                                                        <div><img style="<?php echo $katadi['nikon'] == '1' ? 'display:none;' : null; ?>width: 14px;height: 14px;max-width: 16px;position: initial;float: left;margin-right: 6px;margin-top: 3px;" src="resimler/kategoriler/<?php echo $katadi['nikon']; ?>"></img> <?php echo $katadi['adi']; ?></div>
                                                    </a>

                                                    <div class="megamenu" style="display: none;">
                                                        <div class="menu-col">
                                                            <div class="row">

                                                                <?php

                                                                $ustkatid = $katadi['id'];
                                                                $ustkattta = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($ustkattta as $katadi2) { ?>
                                                                    <div class="col-md-4">
                                                                        <div class="menu-title"><a href="kategori/<?php echo $katadi2['seo']; ?>"><?php echo $katadi2['adi']; ?></a></div><!-- End .menu-title -->
                                                                        <ul>
                                                                            <?php

                                                                            $ustkatid2 = $katadi2['id'];
                                                                            $ustkatttaz = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid2' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                                                            foreach ($ustkatttaz as $katadi22) { ?>

                                                                                <li><a href="kategori/<?php echo $katadi22['seo']; ?>"><?php echo $katadi22['adi']; ?></a></li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div><!-- End .col-md-4 -->

                                                                <?php } ?>
                                                            </div><!-- End .row -->

                                                        </div><!-- End .menu-col -->
                                                    </div><!-- End .megamenu -->
                                                </li>



                                            <?php } else { ?>

                                                <li><a href="kategori/<?php echo $katadi['seo']; ?>">
                                                        <div><img style="<?php echo $katadi['nikon'] == '1' ? 'display:none;' : null; ?>width: 14px;height: 14px;max-width: 16px;position: initial;float: left;margin-right: 6px;margin-top: 3px;" src="resimler/kategoriler/<?php echo $katadi['nikon']; ?>"></img> <?php echo $katadi['adi']; ?></div>
                                                    </a></li>


                                        <?php }
                                        } ?>

                                    </ul>
                                </nav><!-- End .side-nav -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .category-dropdown -->
                    </div><!-- End .header-left -->
                    <?php $ustkattt1 = $ozy->query("select * from kategoriler where durum='1' and ustgoster='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                    $yataymenuclass = "menu";
                    foreach ($ustkattt1 as $katadi111) { ?>
                        <?php if ($katadi111['agoster'] == '0') { ?>
                            <?php $yataymenuclass = "menu sf-arrows"; ?>
                        <?php } ?>
                    <?php } ?>

                    <div class="header-center tamekranmenu">
                        <nav class="main-nav">
                            <ul class="<?php echo $yataymenuclass; ?>">
                                <li><a href="anasayfa">Anasayfa</a>

                                    <?php
                                    foreach ($ustkattt1 as $katadi1) { ?>

                                        <?php if ($katadi1['ac'] == '1') { ?>

                                <li>
                                    <a href="kategori/<?php echo $katadi1['seo']; ?>" class="sf-with-ul"><?php echo $katadi1['adi']; ?></a>

                                    <div class="megamenu megamenu-md">
                                        <div class="row no-gutters">
                                            <div class="col-md-8">
                                                <div class="menu-col">
                                                    <div class="row">

                                                        <?php

                                                        $ustkatid1 = $katadi1['id'];
                                                        $ustkattta1 = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($ustkattta1 as $katadi21) { ?>
                                                            <div class="col-md-6">
                                                                <div class="menu-title"><a href="kategori/<?php echo $katadi21['seo']; ?>"><?php echo $katadi21['adi']; ?></a></div><!-- End .menu-title -->
                                                                <ul>
                                                                    <?php

                                                                    $ustkatid25 = $katadi21['id'];
                                                                    $ustkatttaz5 = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid25' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($ustkatttaz5 as $katadi225) { ?>

                                                                        <li><a href="kategori/<?php echo $katadi225['seo']; ?>"><?php echo $katadi225['adi']; ?></a></li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div><!-- End .col-md-4 -->


                                                        <?php } ?>


                                                    </div><!-- End .row -->
                                                </div><!-- End .menu-col -->
                                            </div><!-- End .col-md-8 -->

                                            <!-- <div class="col-md-4">
                                                <div class="banner banner-overlay">
                                                    <a href="kategori/<?php //echo $katadi1['seo']; 
                                                                        ?>" class="banner banner-menu">
                                                        <img src="resimler/kategoriler/<?php //echo $katadi1['yanresim']; 
                                                                                        ?>" alt="Banner">

                                                    </a>
                                                </div>
                                            </div> -->
                                        </div><!-- End .row -->
                                    </div><!-- End .megamenu megamenu-md -->
                                </li>



                            <?php } else { ?>

                                <li><a href="kategori/<?php echo $katadi1['seo']; ?>"><?php echo $katadi1['adi']; ?></a></li>


                        <?php }
                                    } ?>

                        <li><a href="iletisim/">Bize Ulaşın</a>


                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-center -->


                </div><!-- End .container -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->