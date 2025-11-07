<?php
$id = temizle($_GET['id']);
$query = $ozy->prepare("UPDATE urunler SET hit = (hit+1) WHERE seo=?");
$update = $query->execute(array($id));
?>

<?php
$id = temizle($_GET['id']);
$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM urunler WHERE seo=:id and durum=:durum");
$page = $sayfaqq->execute([':id' => $id, ':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

////////URUN FİYAT BELİRMELE ALANI///////

if ($page['idurum'] == '1') {
    if ($page['kdv'] > '0') {
        $eskifiyat = fiyatgoster(KdvDahil($page['fiyat'], $page['kdv']));
        $yenifiyat = fiyatgoster(KdvDahil($page['ifiyat'], $page['kdv']));
    } else {
        $eskifiyat = fiyatgoster(KdvDahil($page['fiyat'], $system['kdv']));
        $yenifiyat = fiyatgoster(KdvDahil($page['ifiyat'], $system['kdv']));
    }
} else {
    if ($page['kdv'] > '0') {
        $yenifiyat = fiyatgoster(KdvDahil($page['fiyat'], $page['kdv']));
    } else {
        $yenifiyat = fiyatgoster(KdvDahil($page['fiyat'], $system['kdv']));
    }
}

////////URUN FİYAT BELİRMELE ALANI///////									

?>
<?php if ($page['seodurum'] == '1') { ?>
    <title><?php echo $page['stitle']; ?></title>
    <meta name="keywords" content="<?php echo $page['skey']; ?>">
    <meta name="description" content="<?php echo $page['sdesc']; ?>">
    <meta property="og:url" content="<?php echo $url; ?>" />
    <meta property="og:title" content="<?php echo $ayar['stitle']; ?>" />
    <meta property="og:description" content="<?php echo $page['sdesc']; ?>" />
<?php } else { ?>
    <title><?php echo $page['adi']; ?></title>
    <meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
    <meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
    <meta property="og:url" content="<?php echo $url; ?>" />
    <meta property="og:title" content="<?php echo $page['adi']; ?>" />
    <meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>" />
<?php } ?>

<main class="main">
    <div class="page-header text-center"
        style="background-image: url('<?php echo $sitetemasi; ?>/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title"><?php echo $page['adi']; ?><span>Anasayfa</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                <?php
                $urunkategori = $page['kategori'];
                $kat = $ozy->query("select * from kategoriler where durum='1' and id='$urunkategori'")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($kat as $ukat) { ?>
                    <li class="breadcrumb-item"><a
                            href="kategori/<?php echo $ukat['seo']; ?>"><?php echo $ukat['adi']; ?></a></li>
                <?php } ?>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $page['adi']; ?></li>
            </ol>

            <nav class="product-pager ml-auto" aria-label="Product">
                <?php
                $id = isset($page['id']) ? (int) $page['id'] : 0;

                if ($id > 0) {
                    $stmt = $ozy->prepare("SELECT * FROM urunler WHERE durum = '1' AND id < :id ORDER BY id DESC LIMIT 1");
                    $stmt->execute(['id' => $id]);
                    $a3k = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($a3k as $a33k) { ?>
                        <a class="product-pager-link product-pager-prev"
                            href="urun/<?php echo htmlspecialchars($a33k['seo']); ?>" aria-label="Previous" tabindex="-1">
                            <i class="icon-angle-left"></i>
                            <span>Önceki Ürün</span>
                        </a>
                    <?php }
                }
                ?>

                <?php
                $id = $page['id'];
                $stmt2 = $ozy->prepare("SELECT * FROM urunler WHERE durum = 1 AND id > :id ORDER BY id ASC LIMIT 1");
                $stmt2->execute(['id' => $id]);
                $sonraki = $stmt2->fetch(PDO::FETCH_ASSOC);

                if ($sonraki) { ?>
                    <a class="product-pager-link product-pager-next" href="urun/<?php echo $sonraki['seo']; ?>"
                        aria-label="Next">
                        <span>Sonraki Ürün</span>
                        <i class="icon-angle-right"></i>
                    </a>
                <?php } ?>


            </nav><!-- End .pager-nav -->
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->




    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6" style="border: 1px solid #fbf8f8;padding-top: 20px;padding-left: 10px;">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <div class="product-zoom-cover">&nbsp;</div>

                                    <img class="lazyload" id="product-zoom" style="max-width: 100%; height: auto;"
                                        data-src="resimler/urunler/<?php echo $page['resim'] ?>"
                                        data-zoom-image="resimler/urunler/<?php echo $page['resim'] ?>">

                                    <a href="resimler/urunler/<?php echo $page['resim'] ?>" id="btn-product-gallery"
                                        class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    <a class="product-gallery-item active"
                                        href="resimler/urunler/<?php echo $page['resim'] ?>"
                                        data-image="resimler/urunler/<?php echo $page['resim'] ?>"
                                        data-zoom-image="resimler/urunler/<?php echo $page['resim'] ?>">
                                        <img class="lazyload" data-src="resimler/urunler/<?php echo $page['resim']; ?>" style="width: 80px; height: 80px; object-fit: cover;">
                                    </a>


                                    <?php
                                    $gelenid = $page['id'];
                                    $sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='urunler' and sayfaresim != '{$page['resim']}' order by id desc")->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($sayfaresimi as $genelresim) { ?>
                                        <a class="product-gallery-item"
                                            href="resimler/urunler/<?php echo $genelresim['sayfaresim']; ?>"
                                            data-image="resimler/urunler/<?php echo $genelresim['sayfaresim']; ?>"
                                            data-zoom-image="resimler/urunler/<?php echo $genelresim['sayfaresim']; ?>">
                                            <img class="lazyload"
                                                data-src="resimler/urunler/<?php echo $genelresim['sayfaresim']; ?>" style="width: 80px; height: 80px; object-fit: cover;">
                                        </a>
                                    <?php } ?>


                                </div><!-- End .product-image-gallery -->
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6" style="border: 1px solid #fbf8f8;padding-top: 20px;padding-left: 10px;">
                        <div class="product-details">
                            <h1 class="product-title"><?php echo $page['adi']; ?></h1><!-- End .product-title -->

                            <?php
                            if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) {

                                $urunid = $page['id'];
                                $urun = $ozy->prepare("SELECT * FROM tumyorumlar WHERE sayfaid = ? and durum = 1");
                                $urun->execute([$urunid]);
                                $urun = $urun->fetchAll(PDO::FETCH_ASSOC);
                                $yorumadet = 0;
                                $yildiz = 0;
                                foreach ($urun as $yorum) {
                                    $yildiz += $yorum['yildiz'];
                                    $yorumadet++;
                                }
                                if ($yorumadet > 0) {
                                    $yildiz = intval($yildiz / $yorumadet);
                                } else {
                                    $yildiz = 0;
                                }

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
                                    <a class="ratings-text" href="#product-review-link" id="review-link">( <?php
                                    $sayfaid = $page['id'];
                                    $urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='urunler' and durum='1'");
                                    $urunyorumsayisi->execute();
                                    $urunyorumsayimis = $urunyorumsayisi->fetchColumn(); ?>
                                        <?php echo $urunyorumsayimis; ?> Yorum )</a>
                                </div><!-- End .rating-container -->

                            <?php } ?>




                            <div id="detayfiyat" data-price="<?php echo mb_substr($yenifiyat, 0, -3); ?>"
                                class="product-price">
                                <?php if ($page['idurum'] == '1') { ?>
                                    <span class="old-price"><?php echo $eskifiyat; ?></span>&nbsp;&nbsp;
                                    <span id="sonfiyat"><?php echo $yenifiyat; ?></span>
                                <?php } else { ?>
                                    <span id="sonfiyat"><?php echo $yenifiyat; ?></span>
                                <?php } ?>
                            </div><!-- End .product-price -->

                            <?php if ($page['havaledurum'] == '1') { ?>
                                <?php if ($page['kdv'] >= '0') { ?>
                                    <?php echo $hfiyat = fiyatgoster(KdvDahil($page['hfiyat'], $system['kdv'])); ?>
                                <?php } else { ?>
                                    <?php echo $hfiyat = fiyatgoster(KdvDahil($page['hfiyat'], $page['kdv'])); ?>
                                <?php } ?>
                            <?php } ?>



                            <?php if ($page['kdv'] > '0') { ?>
                                <?php $ekkdv = $page['kdv']; ?>
                            <?php } else { ?>
                                <?php $ekkdv = $system['kdv']; ?>
                            <?php } ?>



                            <div class="product-content">
                                <p><?php echo $page['kisa']; ?></p>
                            </div><!-- End .product-content -->

                            <form action="" method="POST">

                                <?php
                                $kod = $page['urunkodu'];
                                $varyant = $ozy->prepare("SELECT COUNT(*) FROM urunler where durum='1' and  urunkodu='$kod'");
                                $varyant->execute();
                                $varyantsayi = $varyant->fetchColumn(); ?>

                                <div class="details-filter-row details-row-size" <?php echo $varyantsayi <= '1' ? 'style="display:none;"' : null; ?>>
                                    <label>Renk: </label>

                                    <div class="product-nav product-nav-thumbs">
                                        <?php
                                        $sayfaidmiz = $page['id'];
                                        $urunvaryant = $ozy->query("select * from urunler where durum='1' and urunkodu='$kod' and id!='$sayfaidmiz' ORDER BY sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($urunvaryant as $varyantbak) { ?>
                                            <a href="urun/<?php echo $varyantbak['seo']; ?>"
                                                style="border: 1px solid gainsboro;border-radius: 2px;">
                                                <img class="lazyload"
                                                    data-src="resimler/urunler/<?php echo $varyantbak['resim']; ?>" style="width: 60px; height: 60px; object-fit: cover;">
                                            </a>
                                        <?php } ?>

                                    </div><!-- End .product-nav -->
                                </div><!-- End .details-filter-row -->



                                <div class="badges" style="margin-bottom: 10px;">
                                    <?php if ($page['alode'] == '1') { ?>
                                        <span class="badge"
                                            style="border: 1px solid #d2ab13;padding: 5px;line-height: 20px !important;color: #d2ab13;">
                                            <i style="font-size: 18px;" class="icon-shopping-cart"></i> BU ÜRÜNDE
                                            <?php echo $page['al']; ?> AL <?php echo $page['ode']; ?> ÖDE FIRSATI</span>
                                    <?php } ?>
                                    <?php if ($page['ucretsizkargo'] == '1') { ?>
                                        <span class="badge"
                                            style="border: 1px solid #2cc43c;padding: 5px;line-height: 20px !important;color: #2cc43c;">
                                            <i style="font-size: 18px;" class="icon-truck"></i> BU ÜRÜNDE KARGO ÜCRETSİZ
                                        </span>
                                    <?php } ?>
                                </div>


                                <?php
                                $urunid = $page['id'];
                                $ozellik = $ozy->query("select * from anaozellik where tip='0' and urunid='$urunid' ORDER BY id desc")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($ozellik as $anaozellik) { ?>
                                    <div class="details-filter-row details-row-size">
                                        <label for="size"
                                            style="width: 100%;font-weight: 500;"><?php echo $anaozellik['adi']; ?>
                                            :</label>
                                        <div class="select-custom" style="width: 100%;">
                                            <select class="form-control varyantselect" onchange="detayfiyathesapla(this);"
                                                name="ozellik[]" id="size" required>
                                                <?php
                                                $altanaid = $anaozellik['id'];
                                                $ozellikalt = $ozy->query("select * from anaozellikalt where anaid='$altanaid' ORDER BY id asc")->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($ozellikalt as $anaozellikalt) { ?>
                                                    <option
                                                        data-price="<?php echo KdvDahil($anaozellikalt['fiyat'], $ekkdv); ?>"
                                                        value="<?php echo $anaozellikalt['id']; ?>" <?php echo $anaozellikalt['stok'] <= '0' ? 'disabled' : null; ?>>
                                                        <?php echo $anaozellikalt['adi']; ?>
                                                        <?php echo $anaozellikalt['stok'] <= '0' ? '(Tükendi)' : null; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div><!-- End .select-custom -->

                                    </div><!-- End .details-filter-row -->


                                <?php } ?>







                                <?php
                                $urunid = $page['id'];
                                $iozellik = $ozy->query("select * from anaozellik where tip='1' and urunid='$urunid' ORDER BY id desc")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($iozellik as $ianaozellik) { ?>

                                    <div class="details-filter-row details-row-size"
                                        style="background: #fbf8f8;padding: 10px;width: 93%;">
                                        <label for="size"
                                            style="width: 100%;font-weight: 500;"><?php echo $ianaozellik['adi']; ?>
                                            :</label>
                                        <?php
                                        $ialtanaid = $ianaozellik['id'];
                                        $iozellikalt = $ozy->query("select * from anaozellikalt where anaid='$ialtanaid' ORDER BY id asc")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($iozellikalt as $ianaozellikalt) { ?>
                                            <label class="size-item">
                                                <input onclick="detayfiyathesapla(this);"
                                                    data-price="<?php echo KdvDahil($ianaozellikalt['fiyat'], $ekkdv); ?>"
                                                    class="varyantradio" type="radio" name="ozellik[]" level="2" <?php echo $ianaozellikalt['stok'] <= '0' ? 'disabled' : null; ?>
                                                    value="<?php echo $ianaozellikalt['id']; ?>"
                                                    stocksize="<?php echo $ianaozellikalt['adi']; ?>" available="1" required>
                                                <span <?php echo $ianaozellikalt['stok'] <= '0' ? 'style="   border-color: #eee;color: #ccc;background: linear-gradient(to top, #e6e6e6 0px, #fff 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);"' : null; ?> class="size-slt-box"
                                                    level="2" value="<?php echo $ianaozellikalt['id']; ?>"
                                                    name="ozellik[]"><?php echo $ianaozellikalt['adi']; ?></span></label>
                                        <?php } ?>
                                    </div>

                                <?php } ?>



                                <input type="hidden" value="<?php echo $page['id']; ?>" name="urunid" />

                                <?php if ($system['sinirsizstok'] != '1') { ?>
                                    <div class="details-filter-row details-row-size">
                                        <label for="qty">Adet:</label>
                                        <div class="product-details-quantity">
                                            <input onchange="detayfiyathesapla(this);" type="number" id="qty"
                                                class="adetsayisi" name="adet" class="form-control" value="1" min="1"
                                                max="<?php echo $page['stok']; ?>" step="1" data-decimals="0" required>
                                        </div><!-- End .product-details-quantity -->
                                    </div><!-- End .details-filter-row -->
                                <?php } else { ?>
                                    <div class="details-filter-row details-row-size">
                                        <label for="qty">Adet:</label>
                                        <div class="product-details-quantity">
                                            <input onchange="detayfiyathesapla(this);" type="number" id="qty"
                                                class="adetsayisi" name="adet" class="form-control" value="1" min="1"
                                                max="999999999999999999999999999999" step="1" data-decimals="0" required>
                                        </div><!-- End .product-details-quantity -->
                                    </div><!-- End .details-filter-row -->

                                <?php } ?>


                                <div class="product-details-action">
                                    <?php if ($page['stok'] >= '1') { ?>
                                        <button class="btn-product btn-cart" type="submit" name="sepetle"><span>Sepete
                                                Ekle</span></button>
                                    <?php } else { ?>
                                        <button class="btn-product btn-cart" type="button"><span>Ürün Tükenmiştir
                                                :(</span></button>
                                    <?php } ?>
                                    <div class="details-action-wrapper">
                                        <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                                        <a href="?favoriekle=<?php echo $page['id']; ?>"
                                            class="btn-product btn-wishlist" title="Wishlist"><span>Favorilerine
                                                Ekle</span></a>
                                        <?php } ?>
                                        <a href="?karsilastir=<?php echo $page['id']; ?>"
                                            class="btn-product btn-compare" title="Compare"><span>Ürünü
                                                Karşılaştır</span></a>
                                    </div><!-- End .details-action-wrapper -->
                                </div><!-- End .product-details-action -->
                            </form>
                            <div class="product-details-action">
                                <?php if ($system['telefonal'] == '1') { ?>
                                    <a target="_blank" href="tel:<?php echo $ayar['ceptel']; ?>"
                                        class="btn-product btn-cart ikontel"><span><i class="icon-phone"></i> Telefon İle
                                            Satın Al</span></a>
                                <?php } ?>
                                <?php if ($system['whatsapal'] == '1') { ?>
                                    <a target="_blank"
                                        href="https://api.whatsapp.com/send?phone=<?php echo $ayar['whatsapp']; ?>&amp;text=<?php echo $page['adi']; ?>%20sipari%C5%9Fi%20vermek%20istiyorum. <?php echo $url; ?>/urun/<?php echo $page['seo']; ?>"
                                        class="btn-product btn-cart ikonwhatsapp"><span><i class="icon-whatsapp"></i>
                                            WhatsApp ile Satın Al</span></a>
                                <?php } ?>

                            </div><!-- End .product-details-action -->

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Ürün Etiketleri:</span>
                                    <?php $etiketlerz = $page['skey'];
                                    $etiketlerz = explode(',', $etiketlerz);
                                    foreach ($etiketlerz as $anahtarz => $degerz) { ?>
                                        <a><?php echo $degerz; ?></a>,
                                    <?php } ?>
                                </div><!-- End .product-cat -->

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Paylaş:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>/urun/<?php echo $page['seo']; ?>"
                                        class="social-icon" title="Facebook" target="_blank"><i
                                            class="icon-facebook-f"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>/urun/<?php echo $page['seo']; ?>"
                                        class="social-icon" title="X" target="_blank"><img
                                            src="resimler/siteayarlari/x.png" alt="X"
                                            style="width:16px; height:16px;"></a>
                                    <a href="https://api.whatsapp.com/send?phone=<?php echo $ayar['whatsapp']; ?>&amp;text=<?php echo $page['adi']; ?> <?php echo $url; ?>/urun/<?php echo $page['seo']; ?>"
                                        class="social-icon" title="WhatsApp" target="_blank"><i
                                            class="icon-whatsapp"></i></a>
                                </div>
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                            role="tab" aria-controls="product-desc-tab" aria-selected="true">Ürün Detayı</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab"
                            aria-controls="product-info-tab" aria-selected="false">İade & Değişim Şartları</a>
                    </li>
                    <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                                role="tab" aria-controls="product-review-tab" aria-selected="false">Ürün Değerlendirmesi
                                (<?php echo $urunyorumsayimis; ?>)</a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                        aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <?php echo html_entity_decode($page['aciklama']); ?>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                        aria-labelledby="product-info-link">
                        <div class="product-desc-content">
                            <?php echo $system['iade']; ?>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                        <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                            aria-labelledby="product-review-link">
                            <div class="comments">
                                <?php if ($urunyorumsayimis > '0') { ?>
                                    <h3 class="title"><?php echo $urunyorumsayimis; ?> Yorum</h3><!-- End .title -->
                                <?php } else { ?>
                                    <h3 class="title">Bu ürüne henüz yorum yapılmamış. İlk yorumu sen yapmak ister misin ?</h3>
                                    <!-- End .title -->
                                <?php } ?>

                                <ul>


                                    <?php
                                    $blogid = $page['id'];
                                    $deneme = $ozy->query("select * from tumyorumlar where durum='1' and sayfaid='$blogid' and konu='urunler' order by id desc")->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($deneme as $blogyorum) { ?>

                                        <div class="review">
                                            <div class="row no-gutters">
                                                <div class="col-auto" style="width: 100%;">
                                                    <div class="ratings-container">
                                                        <div class="ratings">
                                                            <div class="ratings-val" style="width:
                                                            <?php echo $blogyorum['yildiz'] == '1' ? '20%' : null; ?>
                                                            <?php echo $blogyorum['yildiz'] == '2' ? '40%' : null; ?>
                                                            <?php echo $blogyorum['yildiz'] == '3' ? '60%' : null; ?>
                                                            <?php echo $blogyorum['yildiz'] == '4' ? '80%' : null; ?>
                                                            <?php echo $blogyorum['yildiz'] == '5' ? '100%' : null; ?>
                                                            ;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto" style="width: 100%;">
                                                    <span
                                                        style="display: inline-flex; align-items: center; gap: 8px; color: #666; font-size: 14px;">
                                                        <span
                                                            style="font-weight: 500; color: #333;"><?php echo $blogyorum['adi']; ?></span>
                                                        <span>•</span>
                                                        <span><?php echo substr($blogyorum['tarih'], 0, 10); ?></span>
                                                    </span>
                                                </div>
                                                <div class="col-auto" style="width: 100%; margin-top: 10px; font-weight: 400;">
                                                    <span><?php echo $blogyorum['yorum']; ?></span>
                                                </div>
                                                <?php if ($blogyorum['cevap'] != '') { ?>
                                                    <div class="col-auto" style="width: 100%; margin-top: 10px; font-weight: 400;">
                                                        <div class="review-action"
                                                            style="padding: 15px; border: 1px solid #f1ecec;border-radius: 4px;">
                                                            <div class="comment">
                                                                <figure class="comment-media">
                                                                    <a href="<?php echo $url; ?>">
                                                                        <img class="lazyload"
                                                                            data-src="resimler/siteayarlari/<?php echo $ayar['logo']; ?>"
                                                                            alt="User name">
                                                                    </a>
                                                                </figure>
                                                                <div class="comment-body">
                                                                    <div class="comment-content"
                                                                        style="font-weight: 400; font-size: 14px;">
                                                                        <?php echo strip_tags($blogyorum['cevap'], '<br>'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    <?php } ?>









                                </ul>
                            </div>


                            <div class="reply" style="background:white;border: 3px solid #fafafa;">
                                <div class="heading">
                                    <h3 class="title">Yorum Yaz</h3><!-- End .title -->
                                    <p class="title-desc"
                                        style="color: #d81818;border: 1px solid #d81818;padding: 10px;font-size: 14px;border-radius: 2px;">
                                        Eposta adresiniz gizlilik nedeniyle görünmeyecektir. * Argo , küfür veya hukuka
                                        aykırı yorumlar onaylanmayacaktır.
                                        Bu tarz yorum yapanlar hakkında yasal süreç başlatılacaktır.</p>
                                </div><!-- End .heading -->

                                <form action="" method="POST">

                                    <?php
                                    $ubas = "";
                                    $ubm = "";

                                    if (!empty($uyebilgileri['isim'])) {
                                        $ubas = $uyebilgileri['isim'];
                                    }
                                    if (!empty($uyebilgileri['email'])) {
                                        $ubm = $uyebilgileri['email'];
                                    }

                                    ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="reply-name" class="sr-only">Adınız Soyadınız</label>
                                            <input type="text" class="form-control" id="reply-name" name="adi" required=""
                                                placeholder="Adınız Soyadınız *" value="<?php echo $ubas; ?>">
                                        </div><!-- End .col-md-6 -->

                                        <div class="col-md-4">
                                            <label for="reply-email" class="sr-only">Eposta Adresiniz</label>
                                            <input type="email" class="form-control" id="reply-email" name="email"
                                                required="" placeholder="Eposta Adresiniz *" value="<?php echo $ubm; ?>">
                                        </div><!-- End .col-md-6 -->


                                        <div class="col-md-4">
                                            <label for="reply-email" class="sr-only">Yıldız Sayısı</label>
                                            <select name="yildiz" class="form-control">
                                                <option value="1">1 Yıldız</option>
                                                <option value="2">2 Yıldız</option>
                                                <option value="3">3 Yıldız</option>
                                                <option value="4">4 Yıldız</option>
                                                <option value="5">5 Yıldız</option>
                                            </select>
                                        </div><!-- End .col-md-6 -->
                                    </div><!-- End .row -->
                                    <label for="reply-message" class="sr-only">Yorumunuz</label>
                                    <textarea name="yorum" id="reply-message" cols="30" rows="4" class="form-control"
                                        required="" placeholder="Yorumunuz *"></textarea>


                                    <input type="hidden" name="sayfaid" value="<?php echo $page['id']; ?>" />
                                    <button type="submit" name="urunyorum" class="btn btn-outline-primary-2">
                                        <span>YORUMU GÖNDER</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            </div><!-- End .reply -->
                        </div><!-- .End .tab-pane -->
                    <?php } ?>
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <h2 class="title text-center mb-4">Benzer Ürünler</h2><!-- End .title text-center -->

            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
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
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>






                <?php
                $benzerurunadi = $page['adi'];
                $benzerurunler = $ozy->query("select * from urunler where durum='1' and adi like '%$adi%' ORDER BY RAND() limit 6")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($benzerurunler as $katurunler) {

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
                        if ($yorumadet > 0) {
                            $yildiz = intval($yildiz / $yorumadet);
                        } else {
                            $yildiz = 0;
                        }
                    }

                    ?>


                    <form method="GET" action="" />
                    <div class="product product-7 text-center">
                        <figure class="product-media">
                            <a href="urun/<?php echo $katurunler['seo']; ?>">
                                <img class="lazyload product-image" style="width: 230px;height: 245px; object-fit: cover;"
                                    data-src="resimler/urunler/<?php echo $katurunler['resim']; ?>" alt="<?php echo htmlspecialchars($katurunler['adi']); ?>">
                            </a>
                            <?php if ($katurunler['yeni'] == '1') { ?>
                                <span class="product-label label-circle label-new">Yeni Ürün</span>
                            <?php } ?>
                            <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                            <div class="product-action-vertical">
                                <a href="?favoriekle=<?php echo $katurunler['id']; ?>" class="btn-product-icon btn-wishlist"
                                    title="Add to wishlist"></a>
                            </div><!-- End .product-action -->
                            <?php } ?>
                            <div class="product-action">
                                <a href="urun/<?php echo $katurunler['seo']; ?>" class="btn-product btn-cart"
                                    title="Ürünü İncele"></a>
                                <a href="?karsilastir=<?php echo $katurunler['id']; ?>" class="btn-product btn-quickview"
                                    title="Karşılaştır"></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a>Ürün Kodu : #<?php echo $katurunler['urunkodu']; ?></a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a
                                    href="urun/<?php echo $katurunler['seo']; ?>"><?php echo $katurunler['adi']; ?></a></h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <?php if ($katurunler['idurum'] == '1') { ?>

                                    <?php if ($katurunler['kdv'] > '0') { ?>
                                        <span
                                            class="old-price"><?php echo fiyatgoster(KdvDahil($katurunler['fiyat'], $katurunler['kdv'])); ?></span>&nbsp;&nbsp;
                                        <?php echo fiyatgoster(KdvDahil($katurunler['ifiyat'], $katurunler['kdv'])); ?>
                                    <?php } else { ?>
                                        <span
                                            class="old-price"><?php echo fiyatgoster(KdvDahil($katurunler['fiyat'], $system['kdv'])); ?></span>&nbsp;&nbsp;
                                        <?php echo fiyatgoster(KdvDahil($katurunler['ifiyat'], $system['kdv'])); ?>
                                    <?php } ?>

                                <?php } else { ?>

                                    <?php if ($katurunler['kdv'] > '0') { ?>
                                        <?php echo fiyatgoster(KdvDahil($katurunler['fiyat'], $katurunler['kdv'])); ?>

                                    <?php } else { ?>
                                        <?php echo fiyatgoster(KdvDahil($katurunler['fiyat'], $system['kdv'])); ?>

                                    <?php } ?>

                                <?php } ?>
                            </div><!-- End .product-price -->

                            <?php




                            ?>
                            <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
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
                                <span class="ratings-text">( <?php echo $urunyorumsayimis; ?> Yorum )
                                </span>
                            </div><!-- End .rating-container -->
                            <?php } ?>
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    </form>

                <?php } ?>

            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->




</main>