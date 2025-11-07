<?php
admin_yetki($ozy, $_SESSION['departmanid'], 7);
if ($_GET['duzenle']) {
    $id = temizle($_GET['duzenle']);
    $ekresimid = temizle($_GET['duzenle']);
    $sayfam = $ozy->query("select * from sayfalar where id=$id")->fetch(PDO::FETCH_ASSOC);
    ///Sayfa güncelleme kodları başlangıç
    if (isset($_POST['guncelle'])) {



        $adi   = temizle($_POST['adi']);
        $aciklama   = $_POST['aciklama'];
        if ($_POST['seo'] == '') {
            $seo        = "" . seo($adi) . "-" . $id . "";
        } else {
            $seo        = seo($_POST['seo']);
        }
        $hit   = "0";
        $durum   = temizle($_POST['durum']);
        $sira   = temizle($_POST['sira']);
        $seodurum   = temizle($_POST['seodurum']);
        $stitle   = temizle($_POST['stitle']);
        $skey   = temizle($_POST['skey']);
        $sdesc   = temizle($_POST['sdesc']);
        $tarih   = date('d.m.Y H:i:s');

        $reskonum  = $_FILES['resim']['tmp_name'];
        $resad     = $_FILES['resim']['name'];
        $restip    = $_FILES['resim']['type'];
        $uzanti      = substr($resad, -5, 5);
        $resimadi      = md5(uniqid(rand(time($resad)))) . $uzanti;
        $yol         = "../resimler/sayfalar";



        if (!empty($_FILES['resim']['name'])) {
            if ($restip != 'image/jpeg'  && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg') {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
            } else {

                $ekle = move_uploaded_file($reskonum, $yol . '/' . $resimadi);
                $id = $_GET['duzenle'];
                $stmt = $ozy->prepare("UPDATE sayfalar SET adi = ?, aciklama = ?, seo = ?, durum = ?, sira = ?, seodurum = ?, stitle = ?, skey = ?, sdesc = ?, resim = ? WHERE id = ?");
                $result2 = $stmt->execute(array($adi, $aciklama, $seo, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $resimadi, $id));



                if ($result2) {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
                    echo '<meta http-equiv="refresh" content="1; url=' . $url . '/boss/sayfa/duzenle/' . $id . '">';
                } else {

                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
                }
            }
        } else {



            $id = $_GET['duzenle'];
            $stmt = $ozy->prepare("UPDATE sayfalar SET adi = ?, aciklama = ?, seo = ?, durum = ?, sira = ?, seodurum = ?, stitle = ?, skey = ?, sdesc = ? WHERE id = ?");
            $result2 = $stmt->execute(array($adi, $aciklama, $seo, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $id));



            if ($result2) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
                echo '<meta http-equiv="refresh" content="1; url=' . $url . '/boss/sayfa/duzenle/' . $id . '">';
            } else {

                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
            }
        }
    }



    ////Sayfa güncelleme kodları bitiş

} else {

    $q = $ozy->query("SHOW TABLE STATUS LIKE 'sayfalar'");
    $next = $q->fetch(PDO::FETCH_ASSOC);
    $ekresimid = $next['Auto_increment'];
    ////Sayfa oluşturma kodları başlangıç	

    if (isset($_POST['kaydet'])) {

        $adi   = temizle($_POST['adi']);
        $aciklama   = $_POST['aciklama'];
        if ($_POST['seo'] == '') {
            $seo        = "" . seo($adi) . "-" . $ekresimid . "";
        } else {
            $seo        = seo($_POST['seo']);
        }
        $hit   = "0";
        $durum   = temizle($_POST['durum']);
        $sira   = temizle($_POST['sira']);
        $seodurum   = temizle($_POST['seodurum']);
        $stitle   = temizle($_POST['stitle']);
        $skey   = temizle($_POST['skey']);
        $sdesc   = temizle($_POST['sdesc']);
        $tarih   = date('d.m.Y H:i:s');

        $reskonum  = $_FILES['resim']['tmp_name'];
        $resad     = $_FILES['resim']['name'];
        $restip    = $_FILES['resim']['type'];
        $uzanti      = substr($resad, -5, 5);
        $resimadi      = md5(uniqid(rand(time($resad)))) . $uzanti;
        $yol         = "../resimler/sayfalar";

        if (empty($_FILES['resim']['name'])) {

            $resimadi = "resimyok.jpg";
            $stmt = $ozy->prepare("INSERT INTO sayfalar (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $result2 = $stmt->execute(array($adi, $aciklama, $seo, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $tarih, $resimadi));
            $id = $ozy->lastInsertId();


            if ($result2) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
                echo '<meta http-equiv="refresh" content="1; url=tum-sayfalar">';
            } else {

                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
            }
        } else {



            if ($restip != 'image/jpeg'  && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg') {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
            } else {

                $ekle = move_uploaded_file($reskonum, $yol . '/' . $resimadi);

                $stmt = $ozy->prepare("INSERT INTO sayfalar (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                $result2 = $stmt->execute(array($adi, $aciklama, $seo, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $tarih, $resimadi));
                $id = $ozy->lastInsertId();


                if ($result2) {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
                    echo '<meta http-equiv="refresh" content="1; url=tum-sayfalar">';
                } else {

                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
                }
            }
        }
    }

    ////Sayfa oluşturma kodları bitiş






}






?>




<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Sayfa
                        <?php if ($_GET['duzenle']) { ?>
                            Düzenle
                        <?php } else { ?>
                            Ekle
                        <?php } ?>
                    </h4>
                </div>


                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                        <li class="breadcrumb-item active">Sayfa
                            <?php if ($_GET['duzenle']) { ?>
                                Düzenle
                            <?php } else { ?>
                                Ekle
                            <?php } ?>
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
                                        <span class="d-none d-md-block">Genel Ayarlar</span><span class="d-block d-md-none"><i class="mdi mdi-airplay h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
                                        <span class="d-none d-md-block">Resim Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-folder-multiple-outline h5"></i></span>
                                    </a>
                                </li>
                                <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-toggle="tab" href="#messages-1" role="tab">
                                            <span class="d-none d-md-block">Seo Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-guitar-pick-outline h5"></i></span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>


                            <div class="tab-content">








                                <div class="tab-pane active p-3" id="home-1" role="tabpanel">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Linki </br>(Boş bırakırsanız otomatik seo link oluşacaktır)</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="seo" value="<?php echo $sayfam['seo']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Sırası </br>(En başa almak için en yüksek sayıyı veriniz)</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="sira" value="<?php echo $sayfam['sira']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Adı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="adi" value="<?php echo $sayfam['adi']; ?>" required>
                                        </div>
                                    </div>





                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Manşet Resmi</label>
                                        <div class="col-sm-10">

                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">



                                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                                    <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">

                                                        <?php if ($_GET['duzenle']) { ?>
                                                            <img src="../resimler/sayfalar/<?php echo $sayfam['resim']; ?>" style="width: 200px; height: 200px;" alt="" />
                                                        <?php } else { ?>
                                                            <img src="assets/images/resimyok.jpg" alt="" />
                                                        <?php } ?>

                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                    <div>
                                                        <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                                            <input name="resim" type="file" class="default" />
                                                        </span>
                                                        <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>



                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['durum'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum">
                                            </div>

                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" checked="" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum">
                                            </div>

                                        </div>

                                    <?php } ?>



                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Açıklama</label>
                                        <div class="col-sm-10">
                                            <textarea id="summernote" rows="6" name="aciklama"><?php echo $sayfam['aciklama']; ?></textarea>
                                        </div>

                                    </div>






                                </div>




                                <div class="tab-pane p-3" id="profile-1" role="tabpanel">

                                    <div class="form-group row">
                                        <iframe scrolling="no" src="resimyukle.php?id=<?php echo $ekresimid; ?>&alan=sayfalar" style="width:100%;height:1500px;" frameborder="0"></iframe>
                                    </div>






                                </div>


                                <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>




                                    <div class="tab-pane p-3" id="messages-1" role="tabpanel">


                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel Titlesi</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="stitle" value="<?php echo $sayfam['stitle']; ?>">
                                            </div>

                                        </div>


                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel Keyword</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" data-role="tagsinput" name="skey" value="<?php echo $sayfam['skey']; ?>">
                                            </div>

                                        </div>



                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel Açıklaması</label>
                                            <div class="col-sm-10">
                                                <textarea id="textarea" class="form-control" rows="6" name="sdesc"><?php echo $sayfam['sdesc']; ?></textarea>
                                            </div>

                                        </div>




                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Seo Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['seodurum'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="seodurum">
                                            </div>

                                        </div>



                                    </div>
                                <?php } ?>



                            </div>




                            <?php if ($_GET['duzenle']) { ?>

                                <button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>

                            <?php } else { ?>

                                <button type="submit" name="kaydet" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Kaydet</button>



                            <?php } ?>



                        </div>









                    </div>
                </form>

            </div>
        </div>
    </div> <!-- end col -->

</div> <!-- end row -->

</div>
<!-- end container-fluid -->
</div>