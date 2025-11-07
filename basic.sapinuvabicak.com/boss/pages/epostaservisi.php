<?php
admin_yetki($ozy, $_SESSION['departmanid'], 3);
$id = "1";
$sayfam = $ozy->query("select * from system where id=$id")->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['guncelle'])) {



    $sunucum = temizle($_POST['sunucum']);
    $epostam = temizle($_POST['epostam']);
    $sifrem = temizle($_POST['sifrem']);
    $typem = temizle($_POST['typem']);
    $portum = temizle($_POST['portum']);
    $ebultenonay = ($_POST['ebultenonay'] != "") ? $_POST['ebultenonay'] : "0";
    $blogonay = ($_POST['blogonay'] != "") ? $_POST['blogonay'] : "0";
    $iletisimonay = ($_POST['iletisimonay'] != "") ? $_POST['iletisimonay'] : "0";
    $uyeblogonay = ($_POST['uyeblogonay'] != "") ? $_POST['uyeblogonay'] : "0";
    $urunonay = ($_POST['urunonay'] != "") ? $_POST['urunonay'] : "0";
    $uyeurunonay = ($_POST['uyeurunonay'] != "") ? $_POST['uyeurunonay'] : "0";
    $cekgonder = ($_POST['cekgonder'] != "") ? $_POST['cekgonder'] : "0";
    $siparisonay = ($_POST['siparisonay'] != "") ? $_POST['siparisonay'] : "0";
    $adminsiparisonay = ($_POST['adminsiparisonay'] != "") ? $_POST['adminsiparisonay'] : "0";
    $destekonay = ($_POST['destekonay'] != "") ? $_POST['destekonay'] : "0";
    $admindestekonay = ($_POST['admindestekonay'] != "") ? $_POST['admindestekonay'] : "0";
    $sifrehatirlat = ($_POST['sifrehatirlat'] != "") ? $_POST['sifrehatirlat'] : "0";

    $id = "1";
    $stmt = $ozy->prepare("UPDATE system SET sunucum = ?,epostam = ?,sifrem = ?,typem = ?, portum = ?,ebultenonay = ?,blogonay = ?,iletisimonay = ?,uyeblogonay = ?,urunonay = ?,uyeurunonay = ?,cekgonder = ?,siparisonay = ?,adminsiparisonay = ?,destekonay = ?,admindestekonay = ?,sifrehatirlat = ? WHERE id = ?");
    $result2 = $stmt->execute(array($sunucum, $epostam, $sifrem, $typem, $portum, $ebultenonay, $blogonay, $iletisimonay, $uyeblogonay, $urunonay, $uyeurunonay, $cekgonder, $siparisonay, $adminsiparisonay, $destekonay, $admindestekonay, $sifrehatirlat, $id));




    if ($result2) {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
        echo '<meta http-equiv="refresh" content="1; url=eposta-servisi">';

    } else {

        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';


    }






}








?>



<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Eposta Ayarları

                    </h4>
                </div>


                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                        <li class="breadcrumb-item active">Eposta Ayarları
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



                            <div class="tab-content">








                                <div class="tab-pane active p-3" id="home-1" role="tabpanel">






                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Sunucu
                                            Adresi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"
                                                value="<?php echo $sayfam['sunucum']; ?>" name="sunucum">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Eposta
                                            Adresi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"
                                                value="<?php echo $sayfam['epostam']; ?>" name="epostam">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Eposta
                                            Şifresi</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control"
                                                value="<?php echo $sayfam['sifrem']; ?>" name="sifrem">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Sunucu Bağlantı
                                            Tipi </br>(ssl veya tls)</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"
                                                value="<?php echo $sayfam['typem']; ?>" name="typem">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Port No</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"
                                                value="<?php echo $sayfam['portum']; ?>" name="portum">
                                        </div>
                                    </div>
 
                                    <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ebülten Kaydı
                                            Bildirimi </br>( Yönetici Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['ebultenonay'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="ebultenonay">
                                        </div>

                                    </div>
                                   
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Blog Yorumu
                                            Bildirimi </br>( Yönetici Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['blogonay'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="blogonay">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Blog Cevap
                                            Bildirimi </br>( Üye Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['uyeblogonay'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="uyeblogonay">
                                        </div>

                                    </div>
                                    <?php } ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">İletişim Formu
                                            Bildirimi </br>( Yönetici Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['iletisimonay'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="iletisimonay">
                                        </div>

                                    </div> 

                                    <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Yorumu
                                            Bildirimi </br>( Yönetici Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['urunonay'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="urunonay">
                                        </div>

                                    </div>
                                   
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Cevap
                                            Bildirimi </br>( Üye Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['uyeurunonay'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="uyeurunonay">
                                        </div>

                                    </div>
                                    <?php } ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Hediye Çeki
                                            Bildirimi </br>( Üye Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['cekgonder'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="cekgonder">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Sipariş
                                            Bildirimi </br>( Üye Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['siparisonay'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="siparisonay">
                                        </div>

                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Sipariş
                                            Bildirimi </br>( Yönetici Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['adminsiparisonay'] == '1') { ?>
                                                    checked="" <?php } ?> value="1" data-toggle="toggle"
                                                data-onstyle="primary" data-offstyle="secondary"
                                                name="adminsiparisonay">
                                        </div>

                                    </div>
                                    <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Destek Talebi
                                            Bildirimi </br>( Üye Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['admindestekonay'] == '1') { ?>
                                                    checked="" <?php } ?> value="1" data-toggle="toggle"
                                                data-onstyle="primary" data-offstyle="secondary" name="admindestekonay">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Destek Talebi
                                            Bildirimi </br>( Yönetici Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['destekonay'] == '1') { ?> checked=""
                                                <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                data-offstyle="secondary" name="destekonay">
                                        </div>

                                    </div>

                                    <?php } ?>




                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Şifremi Unuttum
                                            </br>( Üye Bildirimi )</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if ($sayfam['sifrehatirlat'] == '1') { ?>
                                                    checked="" <?php } ?> value="1" data-toggle="toggle"
                                                data-onstyle="primary" data-offstyle="secondary" name="sifrehatirlat">
                                        </div>

                                    </div>



                                </div>













                                <div class="tab-pane fade p-3" id="messages-1" role="tabpanel">



                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Üyelik Rıza
                                            Metni</label>
                                        <div class="col-sm-10">
                                            <textarea id="summernote" rows="6"
                                                name="rizametni"><?php echo $sayfam['rizametni']; ?></textarea>
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
    .input-group-addon {
        padding: .375rem .75rem;
        margin-bottom: 0;
        font-size: 0.9rem !important;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        float: right !important;
        margin-top: -36px !important;
    }
</style>