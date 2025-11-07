<?php
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
$id = "1";
$sayfam = $ozy->query("select * from siteayarlari where id=$id")->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['guncelle'])) {



    $siteadi = $_POST['siteadi'];
    $sitekey = $_POST['sitekey'];
    $sitedesc = $_POST['sitedesc'];
    $google = $_POST['google'];
    $yandex = $_POST['yandex'];
    $reklam = $_POST['reklam'];
    $ssldurum = $_POST['ssldurum'];
    $bakimdurum = $_POST['bakimdurum'];
    $bakim = $_POST['bakim'];
    $tel = $_POST['tel'];
    $ceptel = $_POST['ceptel'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];
    $adres = $_POST['adres'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $pinterest = $_POST['pinterest'];
    $linkedin = $_POST['linkedin'];
    $instagram = $_POST['instagram'];
    $youtube = $_POST['youtube'];
    $googleplus = $_POST['googleplus'];
    $copy = $_POST['copy'];
    $maps = $_POST['maps'];
    $tema = $_POST['tema'];
    $t4 = $_POST['t4'];
    $t5 = " ";
    $t6 = " ";
    $t7 = " ";
    $t8 = " ";
    $siteurl = $_POST['siteurl'];
    $dtitle = $_POST['dtitle'];

    $reskonum = $_FILES['logo']['tmp_name'];
    $resad = $_FILES['logo']['name'];
    $restip = $_FILES['logo']['type'];
    $uzanti = substr($resad, -5, 5);
    $resimadi = md5($resad) . $uzanti;
    $yol = "../resimler/siteayarlari";



    $favkonum = $_FILES['favicon']['tmp_name'];
    $favad = $_FILES['favicon']['name'];
    $favtip = $_FILES['favicon']['type'];
    $favuzanti = substr($favad, -5, 5);
    $favyeniad = md5($favad) . $favuzanti;
    $favyol = "../resimler/siteayarlari";


    $temakonumv1 = $_FILES['t1']['tmp_name'];
    $temaadv1 = $_FILES['t1']['name'];
    $tematipv1 = $_FILES['t1']['type'];
    $tuzanti1 = substr($temaadv1, -5, 5);
    $t1 = md5($temaadv1) . $tuzanti1;
    $temav1yol = "../resimler/siteayarlari";

    $temakonumv2 = $_FILES['t2']['tmp_name'];
    $temaadv2 = $_FILES['t2']['name'];
    $tematipv2 = $_FILES['t2']['type'];
    $tuzanti2 = substr($temaadv2, -5, 5);
    $t2 = md5($temaadv2) . $tuzanti2;
    $temav2yol = "../resimler/siteayarlari";

    $temakonumv3 = $_FILES['t3']['tmp_name'];
    $temaadv3 = $_FILES['t3']['name'];
    $tematipv3 = $_FILES['t3']['type'];
    $tuzanti3 = substr($temaadv3, -5, 5);
    $t3 = md5($temaadv3) . $tuzanti3;
    $temav3yol = "../resimler/siteayarlari";


    $temakonumv4 = $_FILES['anabanner']['tmp_name'];
    $temaadv4 = $_FILES['anabanner']['name'];
    $tematipv4 = $_FILES['anabanner']['type'];
    $tuzanti4 = substr($temaadv4, -5, 5);
    $anabanner = md5($temaadv4) . $tuzanti4;
    $temav4yol = "../resimler/siteayarlari";


    if (!empty($_FILES['t1']['name'])) {
        if ($tematipv1 != 'image/jpeg' && $tematipv1 != 'image/png' && $tuzanti1 != '.jpg' && $tuzanti1 != '.png' && $tuzanti1 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav1 = move_uploaded_file($temakonumv1, $temav1yol . '/' . $t1);
            $temav1 = $ozy->prepare("update siteayarlari set t1=? where id='1'");
            $temav1->execute(array($t1));
        }

    }



    if (!empty($_FILES['t2']['name'])) {
        if ($tematipv2 != 'image/jpeg' && $tematipv2 != 'image/png' && $tuzanti2 != '.jpg' && $tuzanti2 != '.png' && $tuzanti2 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav2 = move_uploaded_file($temakonumv2, $temav2yol . '/' . $t2);
            $temav2 = $ozy->prepare("update siteayarlari set t2=? where id='1'");
            $temav2->execute(array($t2));
        }

    }


    if (!empty($_FILES['t3']['name'])) {
        if ($tematipv3 != 'image/jpeg' && $tematipv3 != 'image/png' && $tuzanti3 != '.jpg' && $tuzanti3 != '.png' && $tuzanti3 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav2 = move_uploaded_file($temakonumv3, $temav3yol . '/' . $t3);
            $temav2 = $ozy->prepare("update siteayarlari set t3=? where id='1'");
            $temav2->execute(array($t3));
        }

    }

    if (!empty($_FILES['anabanner']['name'])) {
        if ($tematipv4 != 'image/jpeg' && $tematipv4 != 'image/png' && $tuzanti4 != '.jpg' && $tuzanti4 != '.png' && $tuzanti4 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav4 = move_uploaded_file($temakonumv4, $temav4yol . '/' . $anabanner);
            $temav4 = $ozy->prepare("update siteayarlari set anabanner=? where id='1'");
            $temav4->execute(array($anabanner));
        }

    }




    if (!empty($_FILES['favicon']['name'])) {
        if ($favtip != 'image/jpeg' && $favtip != 'image/png' && $favuzanti != '.jpg' && $favuzanti != '.png' && $favuzanti != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $favekle = move_uploaded_file($favkonum, $favyol . '/' . $favyeniad);
            $favekle = $ozy->prepare("update siteayarlari set favicon=? where id='1'");
            $favekle->execute(array($favyeniad));
        }

    }

    if (!empty($_FILES['logo']['name'])) {
        if ($restip != 'image/jpeg' && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {

            $id = "1";
            $ekle = move_uploaded_file($reskonum, $yol . '/' . $resimadi);

            $stmt = $ozy->prepare("UPDATE siteayarlari SET siteadi = ?, sitekey = ?, sitedesc = ?, logo = ?, google = ?, yandex = ?, reklam = ?, ssldurum = ?, bakimdurum = ?, bakim = ?, tel = ?, ceptel = ?, whatsapp = ?, email = ?, adres = ?, facebook = ?, twitter = ?, pinterest = ?, linkedin = ?, instagram = ?, youtube = ?, googleplus = ?, maps = ?, copy = ?, tema = ?, t4 = ?, t5 = ?, t6 = ?, t7 = ?, t8 = ?, siteurl = ?, dtitle = ? WHERE id = ?");
            $result2 = $stmt->execute(array($siteadi, $sitekey, $sitedesc, $resimadi, $google, $yandex, $reklam, $ssldurum, $bakimdurum, $bakim, $tel, $ceptel, $whatsapp, $email, $adres, $facebook, $twitter, $pinterest, $linkedin, $instagram, $youtube, $googleplus, $maps, $copy, $tema, $t4, $t5, $t6, $t7, $t8, $siteurl, $dtitle, $id));



            if ($result2) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
                echo '<meta http-equiv="refresh" content="1; url=siteayarlari">';

            } else {

                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';


            }






        }

    } else {



        $id = "1";
        $stmt = $ozy->prepare("UPDATE siteayarlari SET siteadi = ?, sitekey = ?, sitedesc = ?, google = ?, yandex = ?, reklam = ?, ssldurum = ?, bakimdurum = ?, bakim = ?, tel = ?, ceptel = ?, whatsapp = ?, email = ?, adres = ?, facebook = ?, twitter = ?, pinterest = ?, linkedin = ?, instagram = ?, youtube = ?, googleplus = ?, maps = ?, copy = ?, tema = ?, t4 = ?, t5 = ?, t6 = ?, t7 = ?, t8 = ?, siteurl = ?, dtitle = ? WHERE id = ?");
        $result2 = $stmt->execute(array($siteadi, $sitekey, $sitedesc, $google, $yandex, $reklam, $ssldurum, $bakimdurum, $bakim, $tel, $ceptel, $whatsapp, $email, $adres, $facebook, $twitter, $pinterest, $linkedin, $instagram, $youtube, $googleplus, $maps, $copy, $tema, $t4, $t5, $t6, $t7, $t8, $siteurl, $dtitle, $id));




        if ($result2) {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
            echo '<meta http-equiv="refresh" content="1; url=siteayarlari">';

        } else {

            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';


        }

        $anadizin = $_SERVER['DOCUMENT_ROOT'] . '/robots.txt';
        $rdosya = fopen($anadizin, 'w+'); //dosya oluşturma işlemi
        //dosya içine ne yazmak istiyorsanız buraya yazın. $değer
        fwrite($rdosya, $t4);
        fclose($rdosya);



    }





}






?>



<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Genel Site Ayarları

                    </h4>
                </div>


                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                        <li class="breadcrumb-item active">Genel Site Ayarları
                        </li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">
                                        <span class="d-none d-md-block">Genel Site Ayarları</span><span
                                            class="d-block d-md-none"><i class="mdi mdi-airplay h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
                                        <span class="d-none d-md-block">Tema Ayarları</span><span
                                            class="d-block d-md-none"><i
                                                class="mdi mdi-folder-multiple-outline h5"></i></span>
                                    </a>
                                </li>



                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#messages-1" role="tab">
                                        <span class="d-none d-md-block">İletişim Ayarları</span><span
                                            class="d-block d-md-none"><i
                                                class="mdi mdi-guitar-pick-outline h5"></i></span>
                                    </a>
                                </li>

                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#messages-2" role="tab">
                                        <span class="d-none d-md-block">Sosyal Medya Ayarları</span><span
                                            class="d-block d-md-none"><i
                                                class="mdi mdi-format-align-justify h5"></i></span>
                                    </a>
                                </li>

                            </ul>


                            <div class="tab-content">








                                <div class="tab-pane active p-3" id="home-1" role="tabpanel">

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Site URL
                                            Adresiniz</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="siteurl"
                                                value="<?php echo $sayfam['siteurl']; ?>">
                                        </div>
                                    </div>
                                    <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Site Değişen
                                            Title</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="dtitle"
                                                value="<?php echo $sayfam['dtitle']; ?>">
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Site Adı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="siteadi"
                                                value="<?php echo $sayfam['siteadi']; ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Site Özel
                                            Keyword</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" data-role="tagsinput" name="sitekey"
                                                value="<?php echo $sayfam['sitekey']; ?>">
                                        </div>

                                    </div>



                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Site Özel
                                            Açıklaması</label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control" rows="6"
                                                name="sitedesc"><?php echo $sayfam['sitedesc']; ?></textarea>
                                        </div>

                                    </div>







                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Bakım
                                            Modu</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['bakimdurum'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="bakimdurum">
                                        </div>

                                    </div>




                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Bakım Modu
                                            Metni</label>
                                        <div class="col-sm-10">
                                            <textarea id="summernote" rows="6"
                                                name="bakim"><?php echo $sayfam['bakim']; ?></textarea>
                                        </div>

                                    </div>



                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Google Analytics
                                            Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control" rows="6"
                                                name="google"><?php echo $sayfam['google']; ?></textarea>
                                        </div>

                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Yandex
                                            Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control" rows="6"
                                                name="yandex"><?php echo $sayfam['yandex']; ?></textarea>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Reklam
                                            Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control" rows="6"
                                                name="reklam"><?php echo $sayfam['reklam']; ?></textarea>
                                        </div>

                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Robots.txt
                                            Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control" rows="8"
                                                name="t4"><?php echo $sayfam['t4']; ?></textarea>
                                        </div>

                                    </div>



                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Google Maps
                                            Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control" rows="6"
                                                name="maps"><?php echo $sayfam['maps']; ?></textarea>
                                        </div>

                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Copyright
                                            Metni</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="copy"
                                                value="<?php echo $sayfam['copy']; ?>">
                                        </div>
                                    </div>




                                </div>




                                <div class="tab-pane p-3" id="profile-1" role="tabpanel">

                                    <?php
                                    function siteurl()
                                    {
                                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
                                        $domain = $_SERVER['HTTP_HOST'];
                                        $uri = $_SERVER['REQUEST_URI'];
                                        return $domain;
                                    }
                                    ?>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Site
                                            Teması</label>
                                        <div class="col-sm-10">
                                            <?php $tmlr = $ozy->query("select * from temalar")->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($tmlr as $tm) { ?>
                                                <div style="float: left; margin-right: 10px;">

                                                    <?php
                                                    if ($tm['fiyat'] == 0) { ?>
                                                        <input style="position: absolute;margin-left:10px;margin-top: 120px;"
                                                            id="demo-inline-form-radio-<?php echo $tm['adi']; ?>"
                                                            class="magic-radio" name="tema" value="<?php echo $tm['adi']; ?>"
                                                            <?php echo $sayfam['tema'] == $tm['adi'] ? 'checked=""' : null; ?>
                                                            type="radio">

                                                    <?php } else { ?>

                                                        <a href="https://wa.me/+905322006726?text=<?php echo urlencode('Merhaba, ' . siteurl() . ' için "' . $tm['adi'] . '" adlı temayı satın almak istiyorum.'); ?>"
                                                            target="_blank"
                                                            style="position: absolute;margin-left:10px;margin-top: 110px;">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
                                                                alt="WhatsApp"
                                                                style="width: 36px; height: 36px; cursor: pointer;">
                                                        </a>



                                                    <?php } ?>


                                                    <label
                                                        style="border: 1px solid #e4e4e5;border-radius: 2px;text-align: center;"
                                                        for="demo-inline-form-radio-<?php echo $tm['adi']; ?>"><img
                                                            style="height:105px; width: 175px;"
                                                            src="../<?php echo $tm['adi']; ?>/<?php echo $tm['temaresim']; ?>"></br><?php echo $tm['adi']; ?></img>
                                                        <?php
                                                        if ($tm['fiyat'] == 0) {
                                                            $fiyat = "Sahipsiniz"; ?>
                                                            <p style="color:green;font-size:12px;"><?php echo $fiyat; ?></p>

                                                        <?php } else {
                                                            $fiyat = number_format($tm['fiyat'], 2, ",", ".") . " ₺";
                                                            ?>
                                                            <p style="color:blue;font-size:12px;"><?php echo $fiyat; ?></p>
                                                            <?php
                                                        }
                                                        ?>



                                                    </label>
                                                </div>
                                            <?php } ?>


                                        </div>
                                    </div>







                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Site
                                            Favicon</label>
                                        <div class="col-sm-10">

                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">



                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                        style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    </div>

                                                    <div class="fileupload-new thumbnail fileupload-preview thumbnail"
                                                        style="width: 200px; height: 150px;">


                                                        <img src="../resimler/siteayarlari/<?php echo $sayfam['favicon']; ?>"
                                                            style="width: 200px; height: 200px;" alt="" />


                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                        style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-default btn-file"
                                                            style="border: 1px solid #ebeef0;">
                                                            <span class="fileupload-new"><i
                                                                    class="fa fa-paper-clip"></i> Resim Seç</span>
                                                            <span class="fileupload-exists"><i class="fa fa-undo"></i>
                                                                Değiştir</span>
                                                            <input name="favicon" type="file" class="default" />
                                                        </span>
                                                        <a href="#"
                                                            class="btn btn-outline-primary waves-effect waves-light"
                                                            data-dismiss="fileupload"><i class="fa fa-trash"></i>
                                                            Sil</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>










                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Site
                                            Logosu</label>
                                        <div class="col-sm-10">

                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">



                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                        style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    </div>

                                                    <div class="fileupload-new thumbnail fileupload-preview thumbnail"
                                                        style="width: 200px; height: 150px;">


                                                        <img src="../resimler/siteayarlari/<?php echo $sayfam['logo']; ?>"
                                                            style="width: 200px; height: 200px;" alt="" />


                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                        style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-default btn-file"
                                                            style="border: 1px solid #ebeef0;">
                                                            <span class="fileupload-new"><i
                                                                    class="fa fa-paper-clip"></i> Resim Seç</span>
                                                            <span class="fileupload-exists"><i class="fa fa-undo"></i>
                                                                Değiştir</span>
                                                            <input name="logo" type="file" class="default" />
                                                        </span>
                                                        <a href="#"
                                                            class="btn btn-outline-primary waves-effect waves-light"
                                                            data-dismiss="fileupload"><i class="fa fa-trash"></i>
                                                            Sil</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>










                                </div>






                                <div class="tab-pane p-3" id="messages-1" role="tabpanel">

                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-sm-2 col-form-label">Telefon
                                            Numaranız</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="tel" value="<?php echo $sayfam['tel']; ?>"
                                                id="example-tel-input" name="tel">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-sm-2 col-form-label">Gsm
                                            Numaranız</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="tel"
                                                value="<?php echo $sayfam['ceptel']; ?>" id="example-tel-input"
                                                name="ceptel">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-sm-2 col-form-label">WhatsApp
                                            Numaranız</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="tel"
                                                value="<?php echo $sayfam['whatsapp']; ?>" id="example-tel-input"
                                                name="whatsapp">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-sm-2 col-form-label">Email
                                            Adresiniz</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text"
                                                value="<?php echo $sayfam['email']; ?>" name="email">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">İletişim
                                            Adresi</label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control" rows="6"
                                                name="adres"><?php echo $sayfam['adres']; ?></textarea>
                                        </div>

                                    </div>


                                </div>




                                <div class="tab-pane p-3" id="messages-2" role="tabpanel">


                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-facebook"></i></span>
                                            <input class="form-control" name="facebook"
                                                value="<?php echo $sayfam['facebook']; ?>" type="text"
                                                placeholder="https://www.facebook.com/">
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <img src="../../../resimler/siteayarlari/x.png" alt="Twitter"
                                                    style="width:16px; height:16px;">
                                            </span>
                                            <input class="form-control" name="twitter"
                                                value="<?php echo $sayfam['twitter']; ?>" type="text"
                                                placeholder="https://x.com/">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-instagram"></i></span>
                                            <input class="form-control" name="instagram"
                                                value="<?php echo $sayfam['instagram']; ?>" type="text"
                                                placeholder="https://www.instagram.com/">
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-google"></i></span>
                                            <input class="form-control" name="googleplus"
                                                value="<?php echo $sayfam['googleplus']; ?>" type="text"
                                                placeholder="https://www.google.com/">
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-pinterest"></i></span>
                                            <input class="form-control" name="pinterest"
                                                value="<?php echo $sayfam['pinterest']; ?>" type="text"
                                                placeholder="https://www.pinterest.com/">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-linkedin"></i></span>
                                            <input class="form-control" name="linkedin"
                                                value="<?php echo $sayfam['linkedin']; ?>" type="text"
                                                placeholder="https://www.linkedin.com/">
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-youtube"></i></span>
                                            <input class="form-control" name="youtube"
                                                value="<?php echo $sayfam['youtube']; ?>" type="text"
                                                placeholder="https://www.youtube.com/">
                                        </div>
                                    </div>








                                </div>





                            </div>







                        </div>







                        <button type="submit" name="guncelle"
                            class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>


                    </div>
                </form>

            </div>
        </div>
    </div> <!-- end col -->

</div> <!-- end row -->

</div>
<!-- end container-fluid -->
</div>
<style>
    .box {
        width: 100%;
        margin: 0 auto;
        border: 1px solid #7487EF;
    }

    .heading {
        height: 30px;
        border-bottom: 1px solid #7487EF;
        background: #7487EF;
        font-size: 14px;
        text-align: center;
        line-height: 30px;
        color: white;
        font-weight: 500;
    }

    .msg {
        text-align: center;
        line-height: 30px;
        color: #FF0000;
    }

    .form_field {
        margin: 20px 0 0 20px;
        text-align: center;
    }

    label {

        padding: 0 20px 0 10px;
    }

    .upload {}
</style>