<?php
// Include path'i admin_yetki'den sonra yapacağız çünkü anasayfa tarafından include ediliyoruz
admin_yetki($ozy, $_SESSION['departmanid'], 5);

// GET parametresini kontrol et
$id = isset($_GET['duzenle']) ? temizle($_GET['duzenle']) : 0;
$sayfam = [];
if ($id > 0) {
    $sayfam = $ozy->query("select * from xml where id=$id")->fetch(PDO::FETCH_ASSOC);
    if (!$sayfam) {
        $sayfam = []; // Boş array döndür
    }
} else {
    // Yeni kayıt için boş değerler
    $sayfam = [
        'xmlurl' => '',
        'urunadi' => '',
        'kategori' => '',
        'kattip' => '0',
        'parcatip' => '',
        'urunkodu' => '',
        'urunbarkodu' => '',
        'marka' => '',
        'stok' => '',
        'fiyat' => '',
        'kdv' => '',
        'aciklama' => '',
        'resimtip' => '0',
        'anaresim' => '',
        'resim' => '',
        'resim1' => '',
        'resim2' => '',
        'resim3' => '',
        'resim4' => '',
        'resim5' => '',
        'resim6' => '',
        'resim7' => '',
        'resim8' => '',
        'resim9' => '',
        'durum' => '1',
        'yukledurum' => '0'
    ];
}
?>
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">XML
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                        <li class="breadcrumb-item active">XML
                            İmport
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active p-3" id="home-1" role="tabpanel">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">XML URL Adresi</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="xmlurl" id="xmlurl" value="<?php echo $sayfam['xmlurl']; ?>" placeholder="https://....." required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Adı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="urunadi" id="urunadi" value="<?php echo $sayfam['urunadi']; ?>" placeholder="urunadi" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Tipi</label>
                                        <div class="col-sm-10">
                                            <input id="demo-inline-form-radio" class="magic-radio" name="kattip"
                                                value="0" <?php echo (!isset($sayfam['kattip']) || $sayfam['kattip'] == '0') ? 'checked=""' : ''; ?>
                                                type="radio">
                                            <label for="demo-inline-form-radio">Normal Kategori ( Örnek kategori )</label>
                                            <input id="demo-inline-form-radio-2" class="magic-radio" name="kattip"
                                                value="1" <?php echo (isset($sayfam['kattip']) && $sayfam['kattip'] == '1') ? 'checked=""' : ''; ?>
                                                type="radio">
                                            <label for="demo-inline-form-radio-2">Parçalı Kategori ( Örnek kategori>altkategori>enaltkategori )</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Kategorileri</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="kategori" id="kategori" value="<?php echo $sayfam['kategori']; ?>" placeholder="kategori">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="parcatip" style="<?php echo (isset($sayfam['kattip']) && $sayfam['kattip'] == '1') ? 'display:block !important;' : 'display:none !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Ayracı</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="parcatip" value="<?php echo $sayfam['parcatip']; ?>" placeholder="örnek > , / ...vb">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Kodu</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="urunkodu" id="urunkodu" value="<?php echo $sayfam['urunkodu']; ?>" placeholder="urunkodu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Barkodu</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="urunbarkodu" id="urunbarkodu" value="<?php echo $sayfam['urunbarkodu']; ?>" placeholder="urunbarkodu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Markası</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="marka" id="marka" value="<?php echo $sayfam['marka']; ?>" placeholder="marka">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Stok Sayısı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="stok" id="stok" value="<?php echo $sayfam['stok']; ?>" placeholder="stok">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Fiyatı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="fiyat" id="fiyat" value="<?php echo $sayfam['fiyat']; ?>" placeholder="fiyat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">KDV Oranı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="kdv" id="kdv" value="<?php echo $sayfam['kdv']; ?>" placeholder="kdv">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Açıklaması</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="aciklama" id="aciklama" value="<?php echo $sayfam['aciklama']; ?>" placeholder="aciklama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Resim Tipi</label>
                                        <div class="col-sm-10">
                                            <input id="demo-inline-form-radio" class="magic-radio" name="resimtip"
                                                value="0" <?php echo (!isset($sayfam['resimtip']) || $sayfam['resimtip'] == '0') ? 'checked=""' : ''; ?>
                                                type="radio">
                                            <label for="demo-inline-form-radio">Normal Sıralı Resim ( resim,resim1,resim2 )</label>
                                            <input id="demo-inline-form-radio-2" class="magic-radio" name="resimtip"
                                                value="1" <?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'checked=""' : ''; ?>
                                                type="radio">
                                            <label for="demo-inline-form-radio-2">Döngülü Resim ( Örnek resimler>resim )</label>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="anaresim" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:block !important;' : 'display:none !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Ana Resim</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="anaresim" value="<?php echo $sayfam['anaresim']; ?>" placeholder="Örnek (images->img_item)">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Ana Resim</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim" value="<?php echo $sayfam['resim']; ?>" placeholder="resim">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim1" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 1</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim1" value="<?php echo $sayfam['resim1']; ?>" placeholder="resim1">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim2" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 2</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim2" value="<?php echo $sayfam['resim2']; ?>" placeholder="resim2">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim3" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 3</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim3" value="<?php echo $sayfam['resim3']; ?>" placeholder="resim3">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim4" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 4</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim4" value="<?php echo $sayfam['resim4']; ?>" placeholder="resim4">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim5" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 5</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim5" value="<?php echo $sayfam['resim5']; ?>" placeholder="resim5">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim6" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 6</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim6" value="<?php echo $sayfam['resim6']; ?>" placeholder="resim6">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim7" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 7</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim7" value="<?php echo $sayfam['resim7']; ?>" placeholder="resim7">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim8" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 8</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim8" value="<?php echo $sayfam['resim8']; ?>" placeholder="resim8">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="resim9" style="<?php echo (isset($sayfam['resimtip']) && $sayfam['resimtip'] == '1') ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 9</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim9" value="<?php echo $sayfam['resim9']; ?>" placeholder="resim9">
                                        </div>
                                    </div>
                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if (isset($sayfam['durum']) && $sayfam['durum'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum">
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
                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Yükleme Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if (isset($sayfam['yukledurum']) && $sayfam['yukledurum'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="yukledurum">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if ($_GET['duzenle']) { ?>
                                <button type="submit" name="guncelle" id="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>
                            <?php } else { ?>
                                <button type="submit" name="kaydet" id="kaydet" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Kaydet</button>
                            <?php } ?>
                        </div>
                    </div>
                </form>
                <div id="sonuc" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $("#kaydet").click(function(e) {
        e.preventDefault(); // Formun normal gönderimini engelle

        // Form verilerini serialize et
        var formData = $('form').serialize();

        $.ajax({
            url: "/boss/xmlyukle-arkaplan.php", // verilerin gideceği PHP dosyası
            type: "POST", // gönderim tipi
            data: formData, // tüm form verilerini gönder
            dataType: 'json',
            success: function(response) {
                if (response.status === 'processing') {
                    $("#sonuc").html('<div class="alert alert-info">' + response.message + '</div>');
                    // XML işlemini başlat
                    startXmlProcess(response.xml_id);
                } else if (response.status === 'success') {
                    $("#sonuc").html('<div class="alert alert-success">' + response.message + '</div>');
                } else if (response.status === 'error') {
                    $("#sonuc").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = 'Bilinmeyen bir hata oluştu.';
                
                if (xhr.status === 403) {
                    errorMessage = 'Oturum süresi dolmuş. Lütfen sayfayı yenileyip tekrar giriş yapın.';
                } else if (xhr.status === 404) {
                    errorMessage = 'İstenen sayfa bulunamadı. Lütfen sistem yöneticisi ile iletişime geçin.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.';
                } else if (error === 'timeout') {
                    errorMessage = 'İşlem zaman aşımına uğradı. Lütfen tekrar deneyin.';
                } else if (error === 'parsererror') {
                    errorMessage = 'Sunucudan gelen yanıt işlenemedi. Lütfen tekrar deneyin.';
                }
                
                $("#sonuc").html('<div class="alert alert-danger"><strong>Hata:</strong> ' + errorMessage + '</div>');
            }
        });
    });

    $("#guncelle").click(function(e) {
        e.preventDefault(); // Formun normal gönderimini engelle

        // Form verilerini serialize et ve guncelle parametresi ekle
        var formData = $('form').serialize() + '&guncelle=1';

        $.ajax({
            url: "/boss/xmlyukle-arkaplan.php?duzenle=<?php echo isset($id) ? $id : 0; ?>",
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'processing') {
                    $("#sonuc").html('<div class="alert alert-info">' + response.message + '</div>');
                    // XML işlemini başlat
                    startXmlProcess(response.xml_id);
                } else if (response.status === 'success') {
                    $("#sonuc").html('<div class="alert alert-success">' + response.message + '</div>');
                } else if (response.status === 'error') {
                    $("#sonuc").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error){
                var errorMessage = 'Bilinmeyen bir hata oluştu.';
                
                if (xhr.status === 403) {
                    errorMessage = 'Oturum süresi dolmuş. Lütfen sayfayı yenileyip tekrar giriş yapın.';
                } else if (xhr.status === 404) {
                    errorMessage = 'İstenen sayfa bulunamadı. Lütfen sistem yöneticisi ile iletişime geçin.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.';
                } else if (error === 'timeout') {
                    errorMessage = 'İşlem zaman aşımına uğradı. Lütfen tekrar deneyin.';
                } else if (error === 'parsererror') {
                    errorMessage = 'Sunucudan gelen yanıt işlenemedi. Lütfen tekrar deneyin.';
                }
                
                $("#sonuc").html('<div class="alert alert-danger"><strong>Hata:</strong> ' + errorMessage + '</div>');
            }
        });
    });

    // XML işlemini arka planda başlat
    function startXmlProcess(xmlId) {
        // Progress popup'ı aç
        var progressWindow = window.open("/boss/xml_progress_show.php", "_blank", "width=400,height=200");
        
        // Arka planda XML işlemini başlat
        $.ajax({
            url: "/boss/xml_worker.php",
            type: "POST",
            data: { xml_id: xmlId },
            dataType: 'json',
            timeout: 10000, // 10 saniye timeout - hızlı response beklendiği için
            success: function(response) {
                if (response.status === 'started') {
                    $("#sonuc").html('<div class="alert alert-success">' + response.message + ' Progress penceresi açıldı.</div>');
                } else if (response.status === 'success') {
                    $("#sonuc").html('<div class="alert alert-success">' + response.message + '</div>');
                } else {
                    $("#sonuc").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
                
                // İşlem tamamlandığında progress window'u kapat (5 saniye sonra)
                setTimeout(function() {
                    if (progressWindow && !progressWindow.closed) {
                        progressWindow.close();
                    }
                }, 5000);
            },
            error: function(xhr, status, error) {
                $("#sonuc").html('<div class="alert alert-danger">XML işlemi sırasında hata oluştu: ' + error + '</div>');
                // Progress window'u kapat
                if (progressWindow && !progressWindow.closed) {
                    progressWindow.close();
                }
            }
        });
    }
</script>