<?php
admin_yetki($ozy, $_SESSION['departmanid'], 6);
if (isset($_GET['temizle'])) {

    $id = temizle($_GET['temizle']);
    $sayfasil = $ozy->prepare("delete from iletisim where id='$id'");
    $sayfasil->execute(array($id));
    if ($sayfasil) {


        echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';

    }


}

?>


<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Gelen Kutusu</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                        <li class="breadcrumb-item active">Gelen Kutusu</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Left sidebar -->
                <div class="email-leftbar card">
                    <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                    <a href="eposta-gonder"
                        class="btn btn-danger rounded btn-custom btn-block waves-effect waves-light">Toplu Eposta
                        Gönder</a>
                    <?php } ?>
                    <h6 class="m-t-30">Gelen Kutusu</h6>

                    <div class="mail-list m-t-10">
                        <a href="gelen-kutusu" <?php echo $_GET['s'] == '' ? ' class="active"' : null; ?>> <span
                                class="float-right">
                                <?php
                                $gelen = $ozy->prepare("SELECT COUNT(*) FROM iletisim");
                                $gelen->execute();
                                $gelenmesajsayisi = $gelen->fetchColumn();
                                echo $gelenmesajsayisi; ?>
                            </span> <i class="ti-archive mr-2"></i> Gelen </a>
                        <a <?php echo $_GET['s'] == '1' ? ' class="active"' : null; ?> href="gelen-kutusu?s=1"><span
                                class="float-right">
                                <?php
                                $giden = $ozy->prepare("SELECT COUNT(*) FROM iletisim  where giden='1'");
                                $giden->execute();
                                $gidenmesajsayisi = $giden->fetchColumn();
                                echo $gidenmesajsayisi; ?>
                            </span><i class="ti-location-arrow mr-2"></i> Cevaplanan </a>
                        <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                            <a href="toplu-eposta"><span class="float-right">
                                    <?php
                                    $toplu = $ozy->prepare("SELECT COUNT(*) FROM tiletisim");
                                    $toplu->execute();
                                    $toplueposta = $toplu->fetchColumn();
                                    echo $toplueposta; ?>

                                </span><i class="ti-pencil  mr-2"></i>Toplu Eposta </a>
                        <?php } ?>
                    </div>


                </div>
                <!-- End Left sidebar -->

                <!-- Right Sidebar -->
                <div class="email-rightbar mb-3">

                    <div class="card">


                        <ul class="message-list">

                            <?php


                            $page = intval(@$_GET['page']);
                            if (!$page) {
                                $page = 1;
                            }
                            $bak = $ozy->prepare("select * from iletisim");
                            $bak->execute(array());
                            $toplam = $bak->rowCount();
                            $limit = 20;
                            $goster = $page * $limit - $limit;
                            $sayfasayisi = ceil($toplam / $limit);
                            $forlimit = 200;

                            if (temizle($_GET["s"] == '1')) {

                                $pr = $ozy->query("select * from iletisim where giden='1' order by id DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

                            } elseif (temizle($_GET["s"] == '2')) {

                                $pr = $ozy->query("select * from iletisim where durum='0' order by id DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

                            } else {

                                $pr = $ozy->query("select * from iletisim  order by id DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);


                            }

                            $__URUN__ = false;
                            foreach ($pr as $iletisim) {
                                $__URUN__ = true;
                                ?>




                                <!-- start 1 -->
                                <li style="border-bottom: 1px solid #ededed;"> <a
                                        href="mesaj-duzenle/<?php echo $iletisim['id']; ?>">
                                        <div class="col-mail col-mail-1">

                                            <a href="mesaj-duzenle/<?php echo $iletisim['id']; ?>" class="title">
                                                <img class="mr-3 rounded-circle float-left mt-2"
                                                    src="assets/images/users/user-1.jpg" alt="" height="40">
                                                <h6 class="mb-0"><?php echo $iletisim['isim']; ?></h6>
                                                <p class="text-muted mt-1 mb-0"><?php echo $iletisim['tarih']; ?> </p>
                                            </a>
                                            <span class="star-toggle far fa-star"></span>
                                        </div>
                                        <div class="col-mail col-mail-2">

                                            <a href="mesaj-duzenle/<?php echo $iletisim['id']; ?>" class="subject">
                                                <h6 class="mb-0"> <span
                                                        class="badge-warning badge mr-2">Konu</span><?php echo $iletisim['konu']; ?>
                                                </h6>
                                                <p class="text-muted mt-1 mb-0">
                                                    <?php echo strip_tags(mb_substr($iletisim['mesaj'], 0, 100)); ?>...

                                                    </span></p>
                                            </a>
                                            <div class="date">

                                                <a href="tel:<?php echo $iletisim['telefon']; ?>" target="_blank"
                                                    onclick="return confirm('Telefon ile yanıt vermek istiyor musun ?')"
                                                    class="btn btn-sm btn-danger" style="border: none;background: #4192e9;"
                                                    data-toggle="tooltip" data-original-title="Telefon ile Yanıtla"><img
                                                        style="width: 16px;height: 16px;"
                                                        src="assets/images/tel.png"></img></a>
                                                <a href="https://api.whatsapp.com/send?phone=+9<?php echo $iletisim['telefon']; ?>&amp;text=Merhaba iyi günler, <?php echo $ayar['siteadi']; ?> olarak websitemizin iletişim formundan göndermiş olduğunuz mesaja istinaden sizi rahatsız ediyorum."
                                                    target="_blank"
                                                    onclick="return confirm('WhatsApp ile yanıt vermek istiyor musun  ?')"
                                                    class="btn btn-sm btn-danger"
                                                    style="border: #2ab200;background: #2ab200;" data-toggle="tooltip"
                                                    data-original-title="WhatsApp ile Yanıtla"><img
                                                        style="width: 16px;height: 16px;"
                                                        src="assets/images/whatsap.jpg"></img></a>
                                                <a href="mesaj-duzenle/<?php echo $iletisim['id'] ?>"
                                                    class="btn btn-sm btn-success" data-toggle="tooltip"
                                                    data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"
                                                        style="color:white;"></i></a>
                                                <a href="gelen-kutusu?temizle=<?php echo $iletisim['id']; ?>"
                                                    onclick="return confirm('Silmek istediğinize emin misiniz ?')"
                                                    class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                    data-original-title="Sil"><i style="color:white;" class="ti-trash"
                                                        aria-hidden="true"></i></a>



                                            </div>
                                        </div>
                                </li></a>
                                <!-- end 1 -->
                            <?php }

                            if (!$__URUN__) {
                                echo "Henüz gelen bir mesaj malesef bulunamadı";
                            }

                            ?>




                        </ul>

                    </div>
                    <!-- card -->

                    <div class="row m-t-20">
                        <ul class="pagination justify-content-center mt-5">
                            <?php $geri = $_GET['page'] - 1; ?>
                            <li class="page-item  <?php echo $_GET['pages'] == '1' ? 'disabled' : null; ?>">
                                <a class="page-link page-link-prev"
                                    href="gelen-kutusu?s=<?php echo $_GET['s']; ?>&page=<?php echo $geri; ?>"
                                    aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Geri
                                </a>
                            </li>
                            <?php
                            for ($i = $sayfa - $forlimit; $i < $sayfa + $forlimit + 1; $i++) {
                                if ($i > 0 and $i <= $sayfasayisi) {

                                    if ($i == $sayfa) {

                                        echo "<li class='page-item active' aria-current='page'><a>" . $i . "</a></li>
				 
				  ";

                                    } else {

                                        echo "<li class='page-item'><a class='page-link' href='gelen-kutusu?s=" . $_GET['s'] . "&page=" . $i . "'>" . $i . "</a></li>";

                                    }

                                }
                            }




                            ?>


                            <li class="page-item">
                                <?php $ileri = 1 + $_GET['page']; ?>
                                <a class="page-link page-link-next"
                                    href="gelen-kutusu?s=<?php echo $_GET['s']; ?>&page=<?php echo $ileri; ?>"
                                    aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    İleri <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- end Col-9 -->

            </div>
        </div> <!-- end row -->


    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->