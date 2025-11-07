<title><?php echo $ayar['siteadi']; ?></title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>" />
<meta property="og:title" content="<?php echo $ayar['siteadi']; ?>" />
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>" />

<main class="main">


    <?php require('hikaye.php'); ?>

    <div class="intro-slider-container mb-2">
        <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl" data-owl-options='{
                        "dots": true,
                        "nav": false, 
                        "autoplay":true,
                        "autoplayTimeout":3000,
                        "responsive": {
                            "1200": {
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>

            <?php $slider = $ozy->query("select * from slider where durum='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($slider as $demo) { ?>

                <div class="intro-slide" style="background:white;">
                    <div class="container intro-content sliderim">
                        <div class="row justify-content-end">
                            <a href="<?php echo $demo['link']; ?>"> <img
                                    src="resimler/slider/<?php echo $demo['resim']; ?>"></img>
                            </a>
                        </div><!-- End .row -->
                    </div><!-- End .intro-content -->
                </div><!-- End .intro-slide -->
            <?php } ?>



        </div><!-- End .intro-slider owl-carousel owl-simple -->

        <span class="slider-loader"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="banner banner-overlay banner-overlay-light">
                    <a href="<?php echo $tema['t4']; ?>">
                        <img style="width: 396px;height: 160px;" src="resimler/temaayarlari/<?php echo $tema['t1']; ?>"
                            alt="Banner"> </a>


                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="banner banner-overlay banner-overlay-light">
                    <a href="<?php echo $tema['t5']; ?>">
                        <img style="width: 396px;height: 160px;" src="resimler/temaayarlari/<?php echo $tema['t2']; ?>"
                            alt="Banner">
                    </a>


                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="banner banner-overlay banner-overlay-light">
                    <a href="<?php echo $tema['t6']; ?>">
                        <img style="width: 396px;height: 160px;" src="resimler/temaayarlari/<?php echo $tema['t3']; ?>"
                            alt="Banner">
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="mb-3"></div><!-- End .mb-5 -->

    <div class="container new-arrivals">
        <div class="heading heading-flex mb-3">
            <div class="heading-left">
                <h2 class="title">Popüler Ürünler</h2><!-- End .title -->
            </div><!-- End .heading-left -->


        </div><!-- End .heading -->

        <div class="tab-content tab-content just-action-icons-sm">
            <div class="tab-pane p-0 fade show active" id="new-all-tab" role="tabpanel" aria-labelledby="new-all-link">
                <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                "nav": true, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":5
                                    }
                                }
                            }'>

                    <?php $uk = $ozy->query("select * from urunler where durum='1' and populer='1' order by rand() limit 8")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($uk as $anaurunler) { ?>


                        <form method="GET" action="" />

                        <div class="product product-2">
                            <figure class="product-media">
                                <a href="urun/<?php echo $anaurunler['seo']; ?>">
                                    <img style="width: 218px;height: 249px;"
                                        src="resimler/urunler/<?php echo $anaurunler['resim']; ?>" alt="Product image"
                                        class="product-image">
                                </a>
                                <?php if ($anaurunler['yeni'] == '1') { ?>
                                    <span class="product-label label-circle label-new">Yeni Ürün</span>
                                <?php } ?>
                                <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                                <div class="product-action-vertical">
                                    <a href="?favoriekle=<?php echo $anaurunler['id']; ?>"
                                        class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->
                                <?php } ?>
                                <div class="product-action">
                                    <a href="urun/<?php echo $anaurunler['seo']; ?>" class="btn-product btn-cart"
                                        title="Ürünü İncele"><span>Ürünü İncele</span></a>
                                    <a href="?karsilastir=<?php echo $anaurunler['id']; ?>"
                                        class="btn-product btn-quickview" title="Karşılaştır"><span>Karşılaştır</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a>Ürün Kodu : #<?php echo $anaurunler['urunkodu']; ?></a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a
                                        href="urun/<?php echo $anaurunler['seo']; ?>"><?php echo $anaurunler['adi']; ?></a>
                                </h3><!-- End .product-title -->
                                <div class="product-price">
                                    <?php echo urunfiyatbelirle($anaurunler['kdv'], $anaurunler['idurum'], $anaurunler['fiyat'], $anaurunler['ifiyat']); ?>
                                </div><!-- End .product-price -->
                                <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                                <div class="ratings-container">
                                    <?php
                                    $urunid = $anaurunler['id'];
                                    $urun = $ozy->prepare("SELECT * FROM tumyorumlar WHERE sayfaid = ? and durum = 1");
                                    $urun->execute([$urunid]);
                                    $urun = $urun->fetchAll(PDO::FETCH_ASSOC);
                                    $yorumadet = 0;
                                    $yildiz = 0;
                                    foreach ($urun as $yorum) {
                                        $yildiz += $yorum['yildiz'];
                                        $yorumadet++;
                                    }

                                    $yildiz = intval($yildiz / $yorumadet);
                                    ?>
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 
                                            <?php echo $yildiz == '1' ? '20%' : null; ?>
                                            <?php echo $yildiz == '2' ? '40%' : null; ?>
                                            <?php echo $yildiz == '3' ? '60%' : null; ?>
                                            <?php echo $yildiz == '4' ? '80%' : null; ?>
                                            <?php echo $yildiz == '5' ? '100%' : null; ?>
                                            ;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <?php
                                    $sayfaid = $anaurunler['id'];
                                    $urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='urunler' and durum='1'");
                                    $urunyorumsayisi->execute();
                                    $urunyorumsayimis = $urunyorumsayisi->fetchColumn(); ?>
                                    <span class="ratings-text">( <?php echo $urunyorumsayimis; ?> Yorum )</span>
                                </div><!-- End .rating-container -->
                                <?php } ?>
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                        </form>

                    <?php } ?>




                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->

        </div><!-- End .tab-content -->
    </div><!-- End .container -->

    <div class="mb-6"></div><!-- End .mb-6 -->

    <div class="container">
        <div class="cta cta mb-5">
            <a href="<?php echo $tema['t7']; ?>">
                <img src="resimler/temaayarlari/<?php echo $tema['anabanner']; ?>" alt="camera" class="cta-img">
            </a>
        </div><!-- End .cta -->
    </div><!-- End .container -->

    <div class="container">
        <div class="heading text-center mb-3">
            <h2 class="title">Günün Fırsat Ürünleri</h2><!-- End .title -->
            <p class="title-desc">Bugüne özel günün fırsat ürünleri</p><!-- End .title-desc -->
        </div><!-- End .heading -->

        <div class="row">


            <?php $gr = $ozy->query("select * from urunler where durum='1' and firsat='1' order by rand() limit 2")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($gr as $gfirsat) { ?>


                <div class="col-lg-6 deal-col">
                    <div class="deal"
                        style="background-image: url('resimler/urunler/<?php echo $gfirsat['firsatresim']; ?>');">
                        <div class="deal-top">
                            <h2>Günün Fırsat Ürünü</h2>
                            <h4><?php echo $gfirsat['kisa']; ?></h4>
                        </div><!-- End .deal-top -->

                        <div class="deal-content">
                            <h3 class="product-title"><a
                                    href="urun/<?php echo $gfirsat['seo']; ?>"><?php echo $gfirsat['adi']; ?></a></h3>
                            <!-- End .product-title -->

                            <div class="product-price">
                                <?php echo urunfiyatbelirle($gfirsat['kdv'], $gfirsat['idurum'], $gfirsat['fiyat'], $gfirsat['ifiyat']); ?>
                            </div><!-- End .product-price -->

                            <a href="urun/<?php echo $gfirsat['seo']; ?>" class="btn btn-link"><span>Ürünü İncele</span><i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .deal-content -->

                        <div class="deal-bottom">
                            <div class="deal-countdown daily-deal-countdown"
                                data-until="+<?php echo $gfirsat['firsatsaat']; ?>h"></div><!-- End .deal-countdown -->
                        </div><!-- End .deal-bottom -->
                    </div><!-- End .deal -->
                </div><!-- End .col-lg-6 -->

            <?php } ?>

        </div><!-- End .row -->

        <div class="more-container text-center mt-1 mb-5">
            <a href="gununfirsati/" class="btn btn-outline-dark-2 btn-round btn-more"><span>Tüm Fırsat Ürünleri</span><i
                    class="icon-long-arrow-right"></i></a>
        </div><!-- End .more-container -->
    </div><!-- End .container -->

    <div class="container">
        <hr class="mb-0">
        <div class="owl-carousel mt-5 mb-5 owl-simple">

            <?php $mark = $ozy->query("select * from markalar where durum='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($mark as $markalar) { ?>
                <a href="<?php echo $markalar['link']; ?>" class="brand">
                    <img src="resimler/markalar/<?php echo $markalar['resim']; ?>" alt="Brand Name">
                </a>
            <?php } ?>

        </div><!-- End .owl-carousel -->
    </div><!-- End .container -->
    <?php $katiz = $ozy->query("select * from kategoriler where durum='1' and agoster='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($katiz as $kategorimx) { ?>
        <div class="bg-light pt-2 pb-2" style="background: <?php echo $kategorimx['renk']; ?> !important;">
            <div class="container trending-products">
                <div class="heading heading-flex mb-3" style="padding-top:20px;">
                    <div class="heading-left">
                        <h2 class="title" style="color:white;"><?php echo $kategorimx['adi']; ?></h2><!-- End .title -->
                    </div><!-- End .heading-left -->


                </div><!-- End .heading -->

                <div class="row">
                    <!-- <div class="col-xl-5col d-none d-xl-block">
                        <div class="banner">
                            <a href="kategori/<?php //echo $kategorimx['seo']; ?>">
                                <img style="width: 218px;height: 410px;box-shadow: 1px 0px 10px #fff;"
                                    src="resimler/kategoriler/<?php //echo $kategorimx['yanresim']; ?>" alt="banner">
                            </a>
                        </div>
                    </div>  -->

                    <div class="col-xl-12">
                        <div class="tab-content tab-content-carousel just-action-icons-sm">
                            <div class="tab-pane p-0 fade show active" id="trending-top-tab" role="tabpanel"
                                aria-labelledby="trending-top-link">
                                <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow"
                                    data-toggle="owl" data-owl-options='{
                                            "nav": true, 
                                            "dots": false,
                                            "margin": 20,
                                            "loop": false,
                                            "responsive": {
                                                "0": {
                                                    "items":2
                                                },
                                                "480": {
                                                    "items":2
                                                },
                                                "768": {
                                                    "items":3
                                                },
                                                "992": {
                                                    "items":4
                                                }
                                            }
                                        }'>
                                    <?php
                                    $katimiz = $kategorimx['id'];
                                    $ukk = $ozy->query("select * from urunler where durum='1' and FIND_IN_SET($katimiz,kategori) order by rand() limit 6")->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($ukk as $katurunler) { ?>


                                        <form method="GET" action="" />

                                        <div class="product product-2">
                                            <figure class="product-media">
                                                <a href="urun/<?php echo $katurunler['seo']; ?>">
                                                    <img style="width: 218px;height: 245px;"
                                                        src="resimler/urunler/<?php echo $katurunler['resim']; ?>"
                                                        alt="Product image" class="product-image">
                                                </a>
                                                <?php if ($katurunler['yeni'] == '1') { ?>
                                                    <span class="product-label label-circle label-new">Yeni Ürün</span>
                                                <?php } ?>
                                                <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                                                <div class="product-action-vertical">
                                                    <a href="?favoriekle=<?php echo $katurunler['id']; ?>"
                                                        class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                                </div><!-- End .product-action -->
                                                <?php } ?>
                                                <div class="product-action">
                                                    <a href="urun/<?php echo $katurunler['seo']; ?>"
                                                        class="btn-product btn-cart" title="Ürünü İncele"><span>Ürünü
                                                            İncele</span></a>
                                                    <a href="?karsilastir=<?php echo $katurunler['id']; ?>"
                                                        class="btn-product btn-quickview"
                                                        title="Karşılaştır"><span>Karşılaştır</span></a>
                                                </div><!-- End .product-action -->
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a>Ürün Kodu : #<?php echo $katurunler['urunkodu']; ?></a>
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a
                                                        href="urun/<?php echo $katurunler['seo']; ?>"><?php echo $katurunler['adi']; ?></a>
                                                </h3><!-- End .product-title -->
                                                <div class="product-price">
                                                    <?php echo urunfiyatbelirle($katurunler['kdv'], $katurunler['idurum'], $katurunler['fiyat'], $katurunler['ifiyat']); ?>
                                                </div><!-- End .product-price -->
                                                <?php
                                                $urunid = $katurunler['id'];
                                                if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) {  
                                                $urun = $ozy->prepare("SELECT * FROM tumyorumlar WHERE sayfaid = ? and durum = 1");
                                                $urun->execute([$urunid]);
                                                $urun = $urun->fetchAll(PDO::FETCH_ASSOC);
                                                $yorumadet = 0;
                                                $yildiz = 0;
                                                foreach ($urun as $yorum) {
                                                    $yildiz += $yorum['yildiz'];
                                                    $yorumadet++;
                                                }

                                                $yildiz = intval($yildiz / $yorumadet);
                                                ?>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 
                                            <?php echo $yildiz == '1' ? '20%' : null; ?>
                                            <?php echo $yildiz == '2' ? '40%' : null; ?>
                                            <?php echo $yildiz == '3' ? '60%' : null; ?>
                                            <?php echo $yildiz == '4' ? '80%' : null; ?>
                                            <?php echo $yildiz == '5' ? '100%' : null; ?>
                                            ;"></div><!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                    <?php
                                                    $sayfaid = $katurunler['id'];
                                                    $urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='urunler' and durum='1'");
                                                    $urunyorumsayisi->execute();
                                                    $urunyorumsayimis = $urunyorumsayisi->fetchColumn(); ?>
                                                    <span class="ratings-text">( <?php echo $urunyorumsayimis; ?> Yorum )</span>
                                                </div><!-- End .rating-container -->
                                                <?php } ?>
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                        </form>

                                    <?php } ?>

                                </div><!-- End .owl-carousel -->
                            </div><!-- .End .tab-pane -->

                        </div><!-- End .tab-content -->
                    </div>
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .bg-light pt-5 pb-6 -->
    <?php } ?>


    <div class="mb-5"></div><!-- End .mb-5 -->

    <div class="container for-you">
        <div class="heading heading-flex mb-3">
            <div class="heading-left">
                <h2 class="title">Sizin İçin Seçtiklerimiz</h2><!-- End .title -->
            </div><!-- End .heading-left -->

            <div class="heading-right">
                <a href="sizinicin/" class="title-link">Tüm Ürünleri Görüntüle <i class="icon-long-arrow-right"></i></a>
            </div><!-- End .heading-right -->
        </div><!-- End .heading -->

        <div class="products">
            <div class="row justify-content-center">




                <?php $ukkz = $ozy->query("select * from urunler where durum='1' and agoster='1' order by rand() limit 15")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($ukkz as $sizinicin) { ?>






                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <a href="urun/<?php echo $sizinicin['seo']; ?>">
                                    <img style="width: 278px;height: 310px;"
                                        src="resimler/urunler/<?php echo $sizinicin['resim']; ?>" alt="Product image"
                                        class="product-image">
                                </a>
                                <?php if ($sizinicin['yeni'] == '1') { ?>
                                    <span class="product-label label-circle label-new">Yeni Ürün</span>
                                <?php } ?>
                                <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                                <div class="product-action-vertical">
                                    <a href="?favoriekle=<?php echo $sizinicin['id']; ?>"
                                        class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->
                                <?php } ?>
                                <form method="GET" action="">
                                    <div class="product-action">
                                        <a href="urun/<?php echo $sizinicin['seo']; ?>" class="btn-product btn-cart"
                                            title="Ürünü İncele"><span>Ürünü İncele</span></a>
                                        <a href="?karsilastir=<?php echo $sizinicin['id']; ?>"
                                            class="btn-product btn-quickview"
                                            title="Karşılaştır"><span>Karşılaştır</span></a>
                                    </div><!-- End .product-action -->
                                </form>
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a>Ürün Kodu : #<?php echo $sizinicin['urunkodu']; ?></a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a
                                        href="urun/<?php echo $sizinicin['seo']; ?>"><?php echo $sizinicin['adi']; ?></a>
                                </h3><!-- End .product-title -->
                                <div class="product-price">
                                    <?php echo urunfiyatbelirle($sizinicin['kdv'], $sizinicin['idurum'], $sizinicin['fiyat'], $sizinicin['ifiyat']); ?>
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <?php
                                    $urunid = $sizinicin['id'];
                                    if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) {  
                                    $urun = $ozy->prepare("SELECT * FROM tumyorumlar WHERE sayfaid = ? and durum = 1");
                                    $urun->execute([$urunid]);
                                    $urun = $urun->fetchAll(PDO::FETCH_ASSOC);
                                    $yorumadet = 0;
                                    $yildiz = 0;
                                    foreach ($urun as $yorum) {
                                        $yildiz += $yorum['yildiz'];
                                        $yorumadet++;
                                    }

                                    $yildiz = intval($yildiz / $yorumadet);
                                    ?>
                                    <div class="ratings">
                                        <div class="ratings-val" style="width:
                                            <?php echo $yildiz == '1' ? '20%' : null; ?>
                                            <?php echo $yildiz == '2' ? '40%' : null; ?>
                                            <?php echo $yildiz == '3' ? '60%' : null; ?>
                                            <?php echo $yildiz == '4' ? '80%' : null; ?>
                                            <?php echo $yildiz == '5' ? '100%' : null; ?>
                               ;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <?php
                                    $sayfaid = $sizinicin['id'];
                                    $urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='urunler' and durum='1'");
                                    $urunyorumsayisi->execute();
                                    $urunyorumsayimis = $urunyorumsayisi->fetchColumn(); ?>
                                    <span class="ratings-text">( <?php echo $urunyorumsayimis; ?> Yorum )</span>
                                    </div><!-- End .rating-container -->
                                    <?php } ?>
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div>



                <?php } ?>













            </div><!-- End .row -->
        </div><!-- End .products -->
    </div><!-- End .container -->

    <div class="mb-4"></div><!-- End .mb-4 -->

    <div class="container">
        <hr class="mb-0">
    </div><!-- End .container -->

    <div class="icon-boxes-container bg-transparent">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-rocket"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Ücretsiz Kargo</h3><!-- End .icon-box-title -->
                            <p><?php echo $system['ucretsizkargo']; ?> TL ve üzeri</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-rotate-left"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">İade Garantili</h3><!-- End .icon-box-title -->
                            <p>14 Gün Kolay İade</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-info-circle"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Güvenli Ödeme</h3><!-- End .icon-box-title -->
                            <p>256 Bit SSL Şifreleme</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-life-ring"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Canlı Destek</h3><!-- End .icon-box-title -->
                            <p>7/24 Kesintisiz Destek Hattı</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-sm-6 col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .icon-boxes-container -->
</main><!-- End .main -->