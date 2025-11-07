<?php
require('../func/db.php');
require('../func/fonksiyon.php');
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Yönetim Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="oziyshop" name="description" />
    <meta content="oziyshop" name="author" />
    <link rel="shortcut icon" href="../resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/metismenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <link href="assets/toastr/toastr.css" rel="stylesheet" />
    <script src="assets/toastr/toastr.min.js"></script>
    <?php

    if (isset($_POST['giris'])) {

        $kullaniciadi = temizle($_POST['kullaniciadi']);
        $sifre = temizle(md5($_POST['sifre']));
        $giris = $ozy->prepare("select * from admin where kullaniciadi=? and sifre=?");
        $giris->execute(array($kullaniciadi, $sifre));
        $parcala = $giris->fetch(PDO::FETCH_ASSOC);
        $kontrol = $giris->rowCount();
        $yetki = $ozy->prepare("select * from yetki where departmanid=?");
        $yetki->execute(array($parcala['departman']));
        $parcalayetki = $yetki->fetch(PDO::FETCH_ASSOC);
        
        // Departman adını departman tablosundan al
        $departman_bilgi = $ozy->prepare("select * from departman where id=?");
        $departman_bilgi->execute(array($parcala['departman']));
        $departman_adi = $departman_bilgi->fetch(PDO::FETCH_ASSOC);

        if ($kontrol) {
            $_SESSION["giris"] = "true";
            $_SESSION['id'] = $parcala['id'];
            $_SESSION['adi'] = $parcala['adi'];
            $_SESSION['kullaniciadi'] = $parcala['kullaniciadi'];
            $_SESSION['sifre'] = $parcala['sifre'];
            $_SESSION['durum'] = $parcala['durum'];
            $_SESSION['departmanid'] = $parcala['departman'];
            $_SESSION['departmanadi'] = $departman_adi ? $departman_adi['adi'] : 'Departman Atanmamış';


            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla sisteme giriş yaptınız. Yönlendiriliyorsunuz", "Başarılı");});</script>';

            header("Refresh: 1; url=" . $ayar['siteurl'] . "/boss/anasayfa.php");
        } else {


            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Kullanıcı adınız veya şifreniz hatalı.", "Başarısız");});</script>';
        }



    }



    if (isset($_POST['sitegiris'])) {

        $siteurl = temizle($_POST['siteurl']);
        $siteurlupdate = $ozy->prepare("update siteayarlari set siteurl=? where id=?");
        $siteurlupdate->execute(array($siteurl, 1));
        if ($siteurlupdate) {


            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Kurulum başarıyla tamamlandı. Sisteme giriş yapmak için yönlendiriliyorsunuz", "Başarılı");});</script>';
            echo '<meta http-equiv="refresh" content="2; url=index.php">';

        } else {


            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Malesef bir hata meydana geldi.", "Başarısız");});</script>';
        }



    }






    ?>


</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>

    <?php if ($ayar['siteurl'] == '0') { ?>

        <div class="wrapper-page">
            <div class="card card-pages shadow-none">

                <div class="card-body">
                    <div class="text-center m-t-0 m-b-15">
                        <a href="index.php" class="logo logo-admin">
                            <img src="../resimler/siteayarlari/<?php echo $ayar['logo']; ?>" alt="" height="80"></a>
                    </div>
                    <h5 class="font-18 text-center">Kurulum için son bir adım kaldı</h5>

                    <form class="form-horizontal m-t-30" action="" method="POST">

                        <div class="form-group">
                            <div class="col-12">
                                <label>Lütfen site url adresinizi yazarak kurulumu tamamlayınız</label>
                                <input class="form-control" type="text" required="" name="siteurl"
                                    placeholder="Örnek http://siteniz.com">
                            </div>
                        </div>


                        <div class="form-group text-center m-t-20">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" name="sitegiris"
                                    type="submit">Kurulumu Tamamla</button>
                            </div>
                        </div>


                    </form>
                </div>

            </div>
        </div>

    <?php } else { ?>

        <div class="wrapper-page">
            <div class="card card-pages shadow-none">

                <div class="card-body">
                    <div class="text-center m-t-0 m-b-15">
                        <a href="index.html" class="logo logo-admin">
                            <img src="../resimler/siteayarlari/<?php echo $ayar['logo']; ?>" alt="" height="80"></a>
                    </div>
                    <h5 class="font-18 text-center">admin paneline hoşgeldiniz.</h5>

                    <form class="form-horizontal m-t-30" action="" method="POST">

                        <div class="form-group">
                            <div class="col-12">
                                <label>Kullanıcı Adınız</label>
                                <input class="form-control" type="text" required="" name="kullaniciadi"
                                    placeholder="Kullanıcı Adınız">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label>Şifreniz</label>
                                <input class="form-control" type="password" name="sifre" required="" placeholder="Şifreniz">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <div class="checkbox checkbox-primary">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1"> Beni Anımsa</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-20">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" name="giris"
                                    type="submit">Giriş Yap</button>
                            </div>
                        </div>

                        <div class="form-group row m-t-30 m-b-0">
                            <div class="col-sm-7">
                                <a href="sifremiunuttum.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Şifremi
                                    Unuttum ?</a>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>


    <?php } ?>




</body>

</html>