<footer class="footer">
    <div class="cta bg-image bg-dark pt-4 pb-5 mb-0"
        style="background-image: url(<?php echo $sitetemasi; ?>/assets/images/demos/demo-4/bg-5.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-6">
                    <div class="cta-heading text-center">
                        <h3 class="cta-title text-white">E-Bülten</h3><!-- End .cta-title -->
                        <p class="cta-desc text-white"><span class="font-weight-normal">Ebülten listemize kayıt olarak
                                güncel kampanya ve duyurulardan anında haberdar olabilirsiniz.</span></p>
                        <!-- End .cta-desc -->
                    </div><!-- End .text-center -->

                    <form action="" method="POST">
                        <div class="input-group input-group-round">
                            <input type="email" class="form-control form-control-white" name="eposta"
                                placeholder="Eposta Adresiniz" aria-label="Eposta Adresiniz" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" name="ebulten" type="submit"><span>Kaydet</span><i
                                        class="icon-long-arrow-right"></i></button>
                            </div><!-- .End .input-group-append -->
                        </div><!-- .End .input-group -->
                    </form>
                </div><!-- End .col-sm-10 col-md-8 col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .cta -->
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="widget widget-about">
                        <img src="resimler/siteayarlari/<?php echo $ayar['logo']; ?>" class="footer-logo"
                            alt="Footer Logo" width="105" height="25">
                        <p><?php echo $tema['t8']; ?></p>

                        <div class="widget-call">
                            <i class="icon-phone"></i>
                            Aklınıza takılan birşey mi var ?
                            <a href="tel:<?php echo $ayar['tel']; ?>"><?php echo $ayar['tel']; ?></a>
                        </div><!-- End .widget-call -->
                    </div><!-- End .widget about-widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->



                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Müşteri Hizmetleri</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            <?php $hzmetler1 = $ozy->query("select * from sayfalar where durum='1'order by sira desc limit 6")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($hzmetler1 as $hizmetler11) { ?>
                                <li><a
                                        href="sayfa/<?php echo $hizmetler11['seo']; ?>"><?php echo $hizmetler11['adi']; ?></a>
                                </li>
                            <?php } ?>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Çözüm Merkezi</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            <?php $hzmetler1 = $ozy->query("select * from sayfalar where durum='1'order by sira desc limit 6,6")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($hzmetler1 as $hizmetler11) { ?>
                                <li><a
                                        href="sayfa/<?php echo $hizmetler11['seo']; ?>"><?php echo $hizmetler11['adi']; ?></a>
                                </li>
                            <?php } ?>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
                <!-- End .row -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Hızlı Linkler</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            <li><a href="siparissorgulama/">Sipariş Sorgulama</a></li>
                            <li><a href="bankabilgilerimiz/">Banka Bilgilerimiz</a></li>
                            <li><a href="uyeol/">Üyelik İşlemleri</a></li>
                            <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                                <li><a href="kampanyalar/">Kampanyalar</a> 
                                <li><a href="bloglar/">Blog</a></li>
                                <li><a href="sss/">Sıkça Sorulan Sorular</a></li>
                            <?php } ?>
                            <li><a href="iletisim/">Bize Ulaşın</a></li>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-ss-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="Etiketalani">
                            <div class="etiketgenel">
                                <div class="Etiketbaslik">En Çok Aranan Kelimeler:</div>
                                <ul class="Etiketliste">
                                    <?php $etikets = $ozy->query("select * from etiketler where durum='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($etikets as $etiket) { ?>
                                        <li><a target="_blank"
                                                href="<?php echo $etiket['link']; ?>"><?php echo $etiket['adi']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Sosyal Medya Hesaplarımız</h3>

                            <div class="social-icons social-icons-color justify-content-center">
                                <a <?php echo $ayar['facebook'] == '' ? 'style="display:none;"' : null; ?>
                                    href="<?php echo $ayar['facebook']; ?>" class="social-icon" target="_blank"
                                    title="Facebook"><i class="icon-facebook-f"></i></a>
                                <a <?php echo $ayar['twitter'] == '' ? 'style="display:none;"' : null; ?>
                                    href="<?php echo $ayar['twitter']; ?>" class="social-icon" target="_blank"
                                    title="X"><img src="resimler/siteayarlari/x.png" alt="X"
                                        style="width:16px; height:16px;"></a>
                                <a <?php echo $ayar['instagram'] == '' ? 'style="display:none;"' : null; ?>
                                    href="<?php echo $ayar['instagram']; ?>" class="social-icon" target="_blank"
                                    title="instagram"><i class="icon-instagram"></i></a>
                                <a <?php echo $ayar['pinterest'] == '' ? 'style="display:none;"' : null; ?>
                                    href="<?php echo $ayar['pinterest']; ?>" class="social-icon" target="_blank"
                                    title="pinterest"><i class="icon-pinterest"></i></a>
                                <a <?php echo $ayar['linkedin'] == '' ? 'style="display:none;"' : null; ?>
                                    href="<?php echo $ayar['linkedin']; ?>" class="social-icon" target="_blank"
                                    title="linkedin	"><i class="icon-linkedin"></i></a>
                                <a <?php echo $ayar['youtube'] == '' ? 'style="display:none;"' : null; ?>
                                    href="<?php echo $ayar['youtube']; ?>" class="social-icon" target="_blank"
                                    title="youtube"><i class="icon-youtube"></i></a>
                                <a <?php echo $ayar['googleplus'] == '' ? 'style="display:none;"' : null; ?>
                                    href="<?php echo $ayar['googleplus']; ?>" class="social-icon" target="_blank"
                                    title="googleplus"><i class="icon-google-plus"></i></a>
                            </div><!-- End .soial-icons -->
                        </div><!-- End .contact-box -->
                    </div><!-- End .col-md-4 -->
                </div>
            </div>


        </div><!-- End .container -->
    </div><!-- End .footer-middle -->

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright"><?php echo $ayar['copy']; ?></p><!-- End .footer-copyright -->
            <figure class="footer-payments">
                <img src="<?php echo $sitetemasi; ?>/assets/images/payments.png" alt="Payment methods" width="272"
                    height="20">
            </figure><!-- End .footer-payments -->
        </div><!-- End .container -->
    </div><!-- End .footer-bottom -->
</footer><!-- End .footer -->
</div><!-- End .page-wrapper -->
<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container mobile-menu-light">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="arama/" method="GET" class="mobile-search">
            <label for="mobile-search" class="sr-only">Arama</label>
            <input type="search" class="form-control" name="arama" id="mobile-search" placeholder="Ne aramıştınız ?"
                required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
        </form>

        <ul class="nav nav-pills-mobile nav-border-anim" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="mobile-menu-link" data-toggle="tab" href="#mobile-menu-tab" role="tab"
                    aria-controls="mobile-menu-tab" aria-selected="true">Kategorilerimiz</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="mobile-cats-link" data-toggle="tab" href="#mobile-cats-tab" role="tab"
                    aria-controls="mobile-cats-tab" aria-selected="false">Menü</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel"
                aria-labelledby="mobile-menu-link">
                <nav class="mobile-nav">
                    <ul class="mobile-menu">

                        <?php $ustkattt = $ozy->query("select * from kategoriler where durum='1' and ustkat='0' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($ustkattt as $katadi) { ?>
                            <?php if ($katadi['ac'] == '1') { ?>
                                <li>
                                    <a href="kategori/<?php echo $katadi['seo']; ?>"><?php echo $katadi['adi']; ?></a>
                                    <ul>
                                        <?php
                                        $ustkatid = $katadi['id'];
                                        $ustkattta = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($ustkattta as $katadi2) { ?>
                                            <?php if ($katadi2['ac'] == '1') { ?>
                                                <li>
                                                    <a href="kategori/<?php echo $katadi2['seo']; ?>"><?php echo $katadi2['adi']; ?></a>

                                                    <ul>

                                                        <?php

                                                        $ustkatid2 = $katadi2['id'];
                                                        $ustkatttaz = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid2' order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($ustkatttaz as $katadi22) { ?>

                                                            <li><a
                                                                    href="kategori/<?php echo $katadi22['seo']; ?>"><?php echo $katadi22['adi']; ?></a>
                                                            </li>


                                                        <?php } ?>

                                                    </ul>
                                                </li>

                                            <?php } else { ?>

                                                <li><a href="kategori/<?php echo $katadi2['seo']; ?>"><?php echo $katadi2['adi']; ?></a>
                                                </li>


                                            <?php }
                                        } ?>



                                    </ul>
                                </li>


                            <?php } else { ?>

                                <li><a href="kategori/<?php echo $katadi['seo']; ?>"><?php echo $katadi['adi']; ?></a></li>


                            <?php }
                        } ?>




                    </ul>
                </nav><!-- End .mobile-nav -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane fade" id="mobile-cats-tab" role="tabpanel" aria-labelledby="mobile-cats-link">
                <nav class="mobile-cats-nav">
                    <ul class="mobile-cats-menu">
                        <li><a class="mobile-cats-lead" href="anasayfa">Anasayfa</a></li>
                        <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                            <li><a class="mobile-cats-lead" href="kampanyalar/">Kampanyalar</a>
                            <?php } ?>
                        <li><a class="mobile-cats-lead" href="siparissorgulama/">Sipariş Sorgulama</a></li>
                        <li><a class="mobile-cats-lead" href="bankabilgilerimiz/">Banka Bilgilerimiz</a></li>
                        <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                            <li><a class="mobile-cats-lead" href="bloglar/">Blog</a>
                            <li><a class="mobile-cats-lead" href="sss/">Sıkça Sorulan Sorular</a>
                            <?php } ?>
                        <li><a class="mobile-cats-lead" href="iletisim/">Bize Ulaşın</a>
                    </ul><!-- End .mobile-cats-menu -->
                </nav><!-- End .mobile-cats-nav -->
            </div><!-- .End .tab-pane -->
        </div><!-- End .tab-content -->

        <div class="social-icons">
            <a <?php echo $ayar['facebook'] == '' ? 'style="display:none;"' : null; ?>
                href="<?php echo $ayar['facebook']; ?>" class="social-icon" target="_blank" title="Facebook"><i
                    class="icon-facebook-f"></i></a>
            <a <?php echo $ayar['twitter'] == '' ? 'style="display:none;"' : null; ?>
                href="<?php echo $ayar['twitter']; ?>" class="social-icon" target="_blank" title="X"><img
                    src="resimler/siteayarlari/x.png" alt="X" style="width:16px; height:16px;"></a>
            <a <?php echo $ayar['pinterest'] == '' ? 'style="display:none;"' : null; ?>
                href="<?php echo $ayar['pinterest']; ?>" class="social-icon" target="_blank" title="pinterest"><i
                    class="icon-pinterest"></i></a>
            <a <?php echo $ayar['linkedin'] == '' ? 'style="display:none;"' : null; ?>
                href="<?php echo $ayar['linkedin']; ?>" class="social-icon" target="_blank" title="linkedin	"><i
                    class="icon-linkedin"></i></a>
            <a <?php echo $ayar['instagram'] == '' ? 'style="display:none;"' : null; ?>
                href="<?php echo $ayar['instagram']; ?>" class="social-icon" target="_blank" title="instagram"><i
                    class="icon-instagram"></i></a>
            <a <?php echo $ayar['youtube'] == '' ? 'style="display:none;"' : null; ?>
                href="<?php echo $ayar['youtube']; ?>" class="social-icon" target="_blank" title="youtube"><i
                    class="icon-youtube"></i></a>
            <a <?php echo $ayar['googleplus'] == '' ? 'style="display:none;"' : null; ?>
                href="<?php echo $ayar['googleplus']; ?>" class="social-icon" target="_blank" title="googleplus"><i
                    class="icon-google-plus"></i></a>

        </div><!-- End .social-icons -->



    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->

<!-- Sign in / Register Modal -->
<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill nav-border-anim" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab"
                                    aria-controls="signin" aria-selected="true">Giriş Yap</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                                    aria-controls="register" aria-selected="false">Kayıt Ol</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">
                            <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                aria-labelledby="signin-tab">
                                <form action="" method="POST">
                                    <input type="hidden" name="nereden" value="anauyelik" />
                                    <div class="form-group">
                                        <label for="singin-email">Eposta Adresiniz *</label>
                                        <input type="text" class="form-control" name="email" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="singin-password">Şifreniz *</label>
                                        <input type="password" class="form-control" name="sifre" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" name="girisyap" class="btn btn-outline-primary-2">
                                            <span>GİRİŞ YAP</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="signin-remember">
                                            <label class="custom-control-label" for="signin-remember">Beni
                                                Anımsa</label>
                                        </div><!-- End .custom-checkbox -->

                                        <a href="sifremiunuttum/" class="forgot-link">Şifremi Unuttum ?</a>
                                    </div><!-- End .form-footer -->
                                </form>

                            </div><!-- .End .tab-pane -->



                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form action="" method="POST">
                                    <input type="hidden" name="nereden" value="anauyelik" />
                                    <div class="form-group">
                                        <label>Adınız Soyadınız *</label>
                                        <input type="text" class="form-control" name="isim" required>
                                    </div><!-- End .form-group -->
                                    <div class="form-group">
                                        <label for="register-email">Eposta Adresiniz *</label>
                                        <input type="email" class="form-control" id="register-email" name="email"
                                            required>
                                    </div><!-- End .form-group -->
                                    <div class="form-group">
                                        <label>Telefon Numaranız *</label>
                                        <input type="text" class="form-control" name="telefon" required>
                                    </div><!-- End .form-group -->
                                    <div class="form-group">
                                        <label for="register-password">Şifreniz *</label>
                                        <input type="password" class="form-control" id="register-password" name="sifre"
                                            required>
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">


                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="sozlesme" value="1"
                                                class="custom-control-input" id="register-policy" required>
                                            <label class="custom-control-label" for="register-policy"><a target="_blank"
                                                    href="rizametni/">Üyelik Sözleşmesini</a> kabul ediyorum *</label>
                                        </div><!-- End .custom-checkbox -->

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ebultensor" value="1"
                                                class="custom-control-input" id="register-policy2">
                                            <label class="custom-control-label" for="register-policy2">Ebültene kayıt
                                                olmak istiyorum</label>
                                        </div><!-- End .custom-checkbox -->

                                    </div><!-- End .form-footer -->
                                    <button type="submit" name="kayitol" class="btn btn-outline-primary-2">
                                        <span>KAYIT OL</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>

                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .form-tab -->
                </div><!-- End .form-box -->
            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div><!-- End .modal -->

<?php if ($tema['t11']) { ?>
    <div class="newsletter-overlay">

        <div id="newsletter-popup" style="background:none !important;">
            <a href="#" class="popup-close">X</a>
            <div class="row justify-content-center">
                <div class="col-12">
                    <a href="<?php echo $tema['t10']; ?>"><img
                            style="box-shadow: 2px 2px 16px white;width: 708px;height: 300px;"
                            src="resimler/temaayarlari/<?php echo $tema['t9']; ?>"></a></img>



                </div>
            </div>
        </div>
    </div>
<?php } ?>


<?php
$cihaz = $_SERVER['HTTP_USER_AGENT'];
$iphone = strpos($cihaz, "iPhone");
$android = strpos($cihaz, "Android");
$ipod = strpos($cihaz, "iPod");
if ($iphone == true || $android == true || $ipod == true) { ?>
    <div class="altbar">
        <div id="footer-bar" class="footer-bar-1">
            <a href="<?php echo $url; ?>" class="active-nav"><i class="icon-home"></i><span>Anasayfa</span></a>
            <a href="sepet/"><i class="icon-shopping-cart"></i><span>Sepetim</span></a>
            <?php if ($_SESSION['uyegirisdurumu'] == 'true' && $_SESSION['uyegirisdurumu'] != '') { ?>
                <a href="hesabim/"><i class="icon-user"></i><span>Hesabım</span></a>
            <?php } else { ?>
                <a href="uyeol/"><i class="icon-user"></i><span>Üyelik</span></a>
            <?php } ?>
            <?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
                <a href="favorilerim/"><i class="icon-heart-o"></i><span>Favorilerim</span></a>
            <?php } ?>
            <a target="_blank"
                href="https://api.whatsapp.com/send/?phone=<?php echo $ayar['whatsapp']; ?>&amp;text=Merhaba bilgi almak istiyorum."><i
                    class="icon-whatsapp"></i><span>Destek</span></a>
        </div>
    </div>
<?php } ?>




<!-- Plugins JS File -->
<script src="<?php echo $sitetemasi; ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/jquery.hoverIntent.min.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/jquery.waypoints.min.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/superfish.min.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/owl.carousel.min.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/bootstrap-input-spinner.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/jquery.plugin.min.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/jquery.countdown.min.js"></script>
<!-- <script src="<?php echo $sitetemasi; ?>/assets/js/jquery.nouislider.min.js"></script> -->
<script src="<?php echo $sitetemasi; ?>/assets/js/wNumb.js"></script>
<!-- Main JS File -->
<script src="<?php echo $sitetemasi; ?>/assets/js/main.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/demos/demo-4.js"></script>
<script src="<?php echo $sitetemasi; ?>/assets/js/jquery.elevateZoom.min.js"></script>
<script src="eklentiler/lazysizes.min.js" async></script>
<link href="boss/assets/toastr/toastr.css" rel="stylesheet" />
<script src="boss/assets/toastr/toastr.min.js"></script>
<?php require_once('func/global.php'); ?>

<style>
    .altbar {
        display: none !important;
    }

    #footer-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 98;
        background-color: rgba(249, 249, 249, .98);
        box-shadow: 0 -5px 10px 0 rgba(0, 0, 0, .06);
        min-height: 60px;
        min-height: calc(60px + (constant(safe-area-inset-bottom))*1.1);
        min-height: calc(60px + (env(safe-area-inset-bottom))*1.1);
        display: flex;
        text-align: center;
        transition: all 350ms ease
    }

    #footer-bar a {
        color: #1f1f1f;
        position: relative;
        flex: 1 1 auto;
        border: 1px solid #f5f6f9;
        background: white;
    }

    #footer-bar a span {
        position: relative;
        z-index: 2;
        display: block;
        font-size: 12px;
        font-weight: 500;
        margin-top: -6px;
        opacity: .7;
    }

    #footer-bar a i {
        font-size: 18px;
        position: relative;
        z-index: 2
    }

    #footer-bar .badge {
        font-style: normal;
        z-index: 5;
        top: 0;
        position: absolute;
        margin-left: 3px;
        color: #fff !important;
        width: 18px;
        text-align: center;
        line-height: 18px;
        padding: 0;
        padding-left: 0 !important;
        border-radius: 18px;
        margin-top: 7px;
        font-size: 11px
    }

    .footer-bar-2 .active-nav {
        color: #fff !important
    }

    .footer-bar-2 .active-nav strong {
        position: absolute;
        width: 80px;
        left: 50%;
        transform: translateX(-50%);
        top: 0;
        bottom: 0
    }

    .footer-bar-4 .active-nav {
        color: #fff !important
    }

    .footer-bar-4 .active-nav strong {
        position: absolute;
        width: 47px;
        height: 47px;
        border-radius: 60px;
        left: 50%;
        top: 30px;
        transform: translate(-50%, -50%);
        bottom: 0
    }

    .footer-bar-4 span {
        display: none !important
    }

    .footer-bar-4 i {
        padding-top: 10px
    }

    .footer-bar-5 .active-nav strong {
        position: absolute;
        width: 50px;
        height: 2px;
        border-radius: 60px;
        left: 50%;
        top: 0;
        transform: translateX(-50%)
    }

    .footer-bar-3 span {
        display: none !important
    }

    .footer-bar-3 .active-nav {
        padding-top: 11px !important
    }

    .footer-bar-3 .active-nav span {
        display: block !important
    }

    .footer-bar-3 a {
        padding-top: 18px !important
    }

    .footer-menu-hidden {
        transition: all 100ms ease;
        transform: translateY(100%) !important
    }

    .footer-bar-white * {
        color: #fff
    }

    #footer-bar.position-relative {
        z-index: 2 !important
    }

    .is-ios #footer-bar {
        height: calc(65px + (constant(safe-area-inset-bottom))*1.1);
        height: calc(65px + (env(safe-area-inset-bottom))*1.1)
    }

    .is-not-ios .footer-menu-clear {
        height: 70px;
        display: block
    }

    .is-not-ios .footer {
        padding-bottom: 0
    }

    .is-not-ios #footer-menu a i {
        padding-top: 13px
    }

    .is-not-ios #footer-menu a span {
        opacity: .6
    }

    .footer-bar-scroll {
        display: block !important;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        white-space: nowrap;
        margin: 0;
        padding: 0
    }

    .footer-bar-scroll a {
        display: inline-block;
        width: 19.5%
    }

    .footer-bar-scroll.footer-bar-4 .active-nav strong {
        margin-top: 1px
    }

    .footer-bar-scroll.footer-bar-4 .badge {
        margin-left: -8px !important;
        margin-top: 14px !important
    }

    .footer-bar-scroll.footer-bar-3 .badge {
        margin-left: -7px !important;
        margin-top: 0 !important
    }

    .footer-bar-scroll.footer-bar-3 i {
        transform: translateY(-10px)
    }

    .footer-bar-scroll.footer-bar-3 .active-nav i {
        transform: translateY(0px)
    }

    #newsletter-popup {
        margin: 70px auto;
        padding: 30px 40px 40px;
        background: #f5828a;
        border-radius: 5px;
        width: 50%;
        position: relative;
        transition: all 1s ease-in-out;
        min-height: 300px;
    }




    @media screen and (max-device-width: 480px) and (orientation: portrait) {
        .altbar {
            display: block !important;
        }
    }

    @media screen and (max-width: 1366px) {
        #newsletter-popup {
            width: 100%;
        }

        .altbar {
            display: block !important;
        }
    }

    @media screen and (max-width: 992px) {
        #newsletter-popup {
            width: 100%;
        }

        .altbar {
            display: block !important;
        }
    }

    .newsletter-overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: visible;
        opacity: 1;
        display: none;
        z-index: 999999999999;
    }

    #newsletter-popup h3 {
        color: #fff;
        font-size: 24px;
        margin: 0 0 10px;
        font-family: 'Gloria Hallelujah', cursive;
    }

    #newsletter-popup input[type="text"] {
        width: 100%;
        height: 36px;
        border: none;
        text-indent: 10px;
        font-size: 13px;
        border-bottom: 2px solid #faeaec;
        border-top: 2px solid #fff;
        padding: 0;
        color: #666;
        margin-bottom: 15px;
    }

    #newsletter-popup input[type="submit"] {
        background: #6EC5D9;
        border: none;
        border-bottom: 3px solid #57B8CE;
        color: #fff;
        text-align: center;
        display: block;
        padding: 0;
        line-height: 1.5;
        width: 100%;
        cursor: pointer;
        margin: 0;
        font-size: 21px;
        font-family: "Gloria Hallelujah", cursive;
    }

    #newsletter-popup .popup-close {
        color: #fff;
        height: 30px;
        width: 30px;
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: center;
        text-decoration: none;
        line-height: 30px;
        font-family: "Gloria Hallelujah", cursive;
        font-weight: bold;
    }
</style>
<script>
    $(function () {
        $(".yenile_buton").click(function () {
            $(".guvenlik_resmi").attr("src", "<?php echo $sitetemasi; ?>/captcha.php?d=" + Math.random());
        });
    });
</script>
<script>
    $(document).ready(function () {

        $('input[name="uyetip"]').on("change", function () {
            //alert($(this).prop("value"));
            if ($(this).prop("value") == "1") {
                $("#kurumsal").show();
                $("#kurumsal2").show();
                $("#kurumsal3").show();
                $("#bireysel").hide();
            }
            else {
                $("#kurumsal").hide();
                $("#kurumsal2").hide();
                $("#kurumsal3").hide();
                $("#bireysel").show();
            }
        });


        $('input[name="yeniletip"]').on("change", function () {
            //alert($(this).prop("value"));
            if ($(this).prop("value") == "1") {
                $("#kurumsal").show();
                $("#kurumsal2").show();
                $("#kurumsal3").show();
                $("#bireysel").hide();
            }
            else {
                $("#kurumsal").hide();
                $("#kurumsal2").hide();
                $("#kurumsal3").hide();
                $("#bireysel").show();
            }
        });


        $('input[name="sifretip"]').on("change", function () {
            //alert($(this).prop("value"));
            if ($(this).prop("value") == "1") {
                $("#sifre1").show();
            }
            else {
                $("#sifre1").hide();

            }
        });



        $('input[name="faturatip"]').on("change", function () {
            //alert($(this).prop("value"));
            if ($(this).prop("value") == "1") {
                $("#faturaadres").show();
                $("#faturail").show();
                $("#faturailce").show();
            }
            else {
                $("#faturaadres").hide();
                $("#faturail").hide();
                $("#faturailce").hide();
            }
        });




        $('#adresgeldi').on('change', function () {
            $("#uyeadresal").val($(this).children("option:selected").attr("data-adres"));
            $("#adresilce").val($(this).children("option:selected").attr("data-ilce"));
            $("#adresil").val($(this).children("option:selected").attr("data-il"));



        });





    });


    // Türkçe fiyat formatı fonksiyonu (ondalık: virgül, binlik: nokta)
    function formatFiyat(fiyat) {
        var parts = fiyat.toFixed(2).toString().split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        return parts.join(',') + ' TL';
    }

    function detayfiyathesapla(obj) {
        var detayfiyat = parseFloat($("#detayfiyat").attr("data-price"));
        $(".varyantselect option:selected").each(function () {
            detayfiyat += parseFloat($(this).attr("data-price"));
        });
        $("input[type=radio]:checked").each(function () {
            detayfiyat += parseFloat($(this).attr("data-price"));
        });
        detayfiyat *= parseInt($(".adetsayisi").val());
        $("#sonfiyat").html(formatFiyat(detayfiyat));

    }


    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }


    var delay = 1000; //in milleseconds

    jQuery(document).ready(function ($) {
        setTimeout(function () { showNewsletterPopup(); }, delay);

        $('.popup-close').click(function () {
            $('.newsletter-overlay').hide();

            //when closed create a cookie to prevent popup to show again on refresh
            setCookie('newsletter-popup', 'popped', 30);
        });
    });

    function showNewsletterPopup() {
        if (getCookie('newsletter-popup') == "") {
            $('.newsletter-overlay').show();
            setCookie('newsletter-popup', 'popped', 30);
        }
        else {
            console.log("Newsletter popup blocked.");
        }
    }


    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = jQuery.trim(ca[i]);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }
</script>

<style>
    .product-zoom-cover {
        display: none;
    }

    @media screen and (max-width: 768px) {
        .product-main-image {
            position: relative;
        }

        .product-zoom-cover {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 48;
        }
    }
</style>



</body>

</html>