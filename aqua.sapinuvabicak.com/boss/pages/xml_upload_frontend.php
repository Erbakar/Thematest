<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 5); 

// XML kaydı oluşturma ve güncelleme
if($_GET['duzenle']){
    $id = temizle($_GET['duzenle']);
    $sayfam = $ozy->query("select * from xml where id=$id")->fetch(PDO::FETCH_ASSOC); 
    
    // XML ayarlarını güncelleme (yükleme işlemi hariç)
    if (isset($_POST['guncelle']) && !isset($_POST['yukledurum'])) {
        $xmlurl = temizle($_POST['xmlurl']);
        $urunadi = temizle($_POST['urunadi']);
        $urunkodu = temizle($_POST['urunkodu']);
        $urunbarkodu = temizle($_POST['urunbarkodu']);
        $stok = temizle($_POST['stok']);
        $fiyat = temizle($_POST['fiyat']);
        $kdv = temizle($_POST['kdv']);
        $aciklama = temizle($_POST['aciklama']);
        $resim = trim(($_POST['resim'] != "") ? $_POST['resim'] : "0");
        $kategori = temizle($_POST['kategori']);
        $durum = temizle($_POST['durum']);
        $resim1 = trim(($_POST['resim1'] != "") ? $_POST['resim1'] : "0");
        $resim2 = trim(($_POST['resim2'] != "") ? $_POST['resim2'] : "0");
        $resim3 = trim(($_POST['resim3'] != "") ? $_POST['resim3'] : "0");
        $resim4 = trim(($_POST['resim4'] != "") ? $_POST['resim4'] : "0");
        $resim5 = trim(($_POST['resim5'] != "") ? $_POST['resim5'] : "0");
        $resim6 = trim(($_POST['resim6'] != "") ? $_POST['resim6'] : "0");
        $resim7 = trim(($_POST['resim7'] != "") ? $_POST['resim7'] : "0");
        $resim8 = trim(($_POST['resim8'] != "") ? $_POST['resim8'] : "0");
        $resim9 = trim(($_POST['resim9'] != "") ? $_POST['resim9'] : "0");
        $marka = trim(temizle($_POST['marka']));
        $kattip = trim(temizle($_POST['kattip']));
        $parcatip = trim($_POST['parcatip']);
        $resimtip = trim(temizle($_POST['resimtip']));
        $anaresim = trim(($_POST['anaresim'] != "") ? $_POST['anaresim'] : "0");
        
        $stmt = $ozy->prepare("UPDATE xml SET xmlurl = ?, urunadi = ?, urunkodu = ?, urunbarkodu = ?, stok = ?, fiyat = ?, kdv = ?, aciklama = ?, resim = ?, kategori = ?, durum = ?, resim1 = ?, resim2 = ?, resim3 = ?, resim4 = ?, resim5 = ?, resim6 = ?, resim7 = ?, resim8 = ?, resim9 = ?, marka = ?, kattip = ?, parcatip = ?, resimtip = ?, anaresim = ? WHERE id = ?");
        $result2 = $stmt->execute(array($xmlurl, $urunadi, $urunkodu, $urunbarkodu, $stok, $fiyat, $kdv, $aciklama, $resim, $kategori, $durum, $resim1, $resim2, $resim3, $resim4, $resim5, $resim6, $resim7, $resim8, $resim9, $marka, $kattip, $parcatip, $resimtip, $anaresim, $id));
        
        if($result2){
            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
        } else {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
        }
    }
    
    // XML yükleme işlemini başlatma
    if (isset($_POST['guncelle']) && isset($_POST['yukledurum']) && $_POST['yukledurum'] == '1') {
        // İşlem zaten devam ediyor mu kontrol et
        $lockFile = 'xml_process.lock';
        if (file_exists($lockFile)) {
            $lockTime = filemtime($lockFile);
            $timeDiff = time() - $lockTime;
            if ($timeDiff < 3600) { // 1 saat içinde işlem varsa
                echo '<script type="text/javascript">$(document).ready(function(){toastr["warning"]("XML yükleme işlemi zaten devam ediyor. Lütfen bekleyin.", "Uyarı");});</script>';
            } else {
                unlink($lockFile); // Eski lock dosyasını temizle
            }
        }
        
        if (!file_exists($lockFile)) {
            // Lock dosyası oluştur
            file_put_contents($lockFile, time());
            
            // Progress dosyasını başlat
            file_put_contents('xml_progress.txt', '0|XML yükleme işlemi başlatıldı...');
            
            // AJAX ile backend'e işlemi başlatma isteği gönder
            echo '<script>
                $(document).ready(function(){
                    $.ajax({
                        url: "xml_process_backend.php",
                        type: "POST",
                        data: {
                            xml_id: ' . $id . ',
                            start_process: 1
                        },
                        success: function(response) {
                            console.log("XML işlemi başlatıldı");
                        },
                        error: function() {
                            console.log("XML işlemi başlatılamadı");
                        }
                    });
                    
                    toastr["info"]("XML yükleme işlemi arkaplanda başlatıldı. Tahminen 10-15 dakika sürecek.", "Bilgi");
                    
                    // Progress takip window\'unu aç
                    window.open("xml_progress_show.php", "_blank", "width=500,height=300,scrollbars=no,resizable=no");
                    
                    // 3 saniye sonra ana sayfaya yönlendir
                    setTimeout(function(){
                        window.location.href = "' . $url . '/boss/";
                    }, 3000);
                });
            </script>';
        }
    }
} else {
    // Yeni XML kaydı oluşturma
    if (isset($_POST['kaydet'])) {
        $xmlurl = trim(temizle($_POST['xmlurl']));
        $urunadi = trim(temizle($_POST['urunadi']));
        $urunkodu = trim(temizle($_POST['urunkodu']));
        $urunbarkodu = trim(temizle($_POST['urunbarkodu']));
        $stok = trim(temizle($_POST['stok']));
        $fiyat = trim(temizle($_POST['fiyat']));
        $kdv = trim(temizle($_POST['kdv']));
        $aciklama = trim(temizle($_POST['aciklama']));
        $resim = trim(temizle($_POST['resim']));
        $kategori = trim(temizle($_POST['kategori']));
        $durum = temizle($_POST['durum']);
        $tarih = date('d.m.Y H:i:s');
        $resim = trim(($_POST['resim'] != "") ? $_POST['resim'] : "0");
        $resim1 = trim(($_POST['resim1'] != "") ? $_POST['resim1'] : "0");
        $resim2 = trim(($_POST['resim2'] != "") ? $_POST['resim2'] : "0");
        $resim3 = trim(($_POST['resim3'] != "") ? $_POST['resim3'] : "0");
        $resim4 = trim(($_POST['resim4'] != "") ? $_POST['resim4'] : "0");
        $resim5 = trim(($_POST['resim5'] != "") ? $_POST['resim5'] : "0");
        $resim6 = trim(($_POST['resim6'] != "") ? $_POST['resim6'] : "0");
        $resim7 = trim(($_POST['resim7'] != "") ? $_POST['resim7'] : "0");
        $resim8 = trim(($_POST['resim8'] != "") ? $_POST['resim8'] : "0");
        $resim9 = trim(($_POST['resim9'] != "") ? $_POST['resim9'] : "0");
        $marka = trim(temizle($_POST['marka']));
        $kattip = trim(temizle($_POST['kattip']));
        $parcatip = trim($_POST['parcatip']);
        $resimtip = trim(temizle($_POST['resimtip']));
        $anaresim = trim(($_POST['anaresim'] != "") ? $_POST['anaresim'] : "0");

        $stmt = $ozy->prepare("INSERT INTO xml (xmlurl, urunadi, urunkodu, urunbarkodu, stok, fiyat, kdv, aciklama, resim, kategori, durum, tarih, resim1, resim2, resim3, resim4, resim5, resim6, resim7, resim8, resim9, marka, kattip, parcatip, resimtip, anaresim) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $result2 = $stmt->execute(array($xmlurl, $urunadi, $urunkodu, $urunbarkodu, $stok, $fiyat, $kdv, $aciklama, $resim, $kategori, $durum, $tarih, $resim1, $resim2, $resim3, $resim4, $resim5, $resim6, $resim7, $resim8, $resim9, $marka, $kattip, $parcatip, $resimtip, $anaresim));
        $id = $ozy->lastInsertId();
        
        if($result2){
            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("XML bilgileri kaydedildi şimdi verileri çekmek için düzenlemeye yönlendiriliyorsunuz.", "Başarılı");});</script>';
            echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/xml/duzenle/'.$id.'">'; 
        } else {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
        }
    }
}

// İşlem durumunu kontrol et
$isProcessing = false;
$lockFile = 'xml_process.lock';
if (file_exists($lockFile)) {
    $lockTime = filemtime($lockFile);
    $timeDiff = time() - $lockTime;
    if ($timeDiff < 3600) { // 1 saat içinde işlem varsa
        $isProcessing = true;
    }
}
?>

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">XML Yükleme</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                        <li class="breadcrumb-item active">XML İmport</li>
                    </ol>
                </div>
            </div>
        </div>

        <?php if ($isProcessing): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle-outline me-2"></i>
                    <strong>Dikkat!</strong> XML yükleme işlemi devam ediyor. İşlem tamamlanana kadar lütfen başka XML yükleme işlemi başlatmayın.
                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="window.open('xml_progress_show.php', '_blank', 'width=500,height=300')">
                        İlerlemeyi Görüntüle
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>

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
                                            <input class="form-control" type="text" name="xmlurl" value="<?php echo $sayfam['xmlurl']; ?>" placeholder="https://....." required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Adı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="urunadi" value="<?php echo $sayfam['urunadi']; ?>" placeholder="urunadi" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Tipi</label>
                                        <div class="col-sm-10">
                                            <input id="demo-inline-form-radio" class="magic-radio" name="kattip" value="0" checked <?php echo $sayfam['kattip'] == '0' ? 'checked=""' : null; ?> type="radio">
                                            <label for="demo-inline-form-radio">Normal Kategori ( Örnek kategori )</label>
                                            
                                            <input id="demo-inline-form-radio-2" class="magic-radio" name="kattip" value="1" <?php echo $sayfam['kattip'] == '1' ? 'checked=""' : null; ?> type="radio">
                                            <label for="demo-inline-form-radio-2">Parçalı Kategori ( Örnek kategori>altkategori>enaltkategori )</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Kategorileri</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="kategori" value="<?php echo $sayfam['kategori']; ?>" placeholder="kategori">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row" id="parcatip" style="<?php echo $sayfam['kattip'] == '1' ? 'display:block !important;' : 'display:none !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Ayracı</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="parcatip" value="<?php echo $sayfam['parcatip']; ?>" placeholder="örnek > , / ...vb">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Kodu</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="urunkodu" value="<?php echo $sayfam['urunkodu']; ?>" placeholder="urunkodu">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Barkodu</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="urunbarkodu" value="<?php echo $sayfam['urunbarkodu']; ?>" placeholder="urunbarkodu">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Markası</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="marka" value="<?php echo $sayfam['marka']; ?>" placeholder="marka">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Stok Sayısı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="stok" value="<?php echo $sayfam['stok']; ?>" placeholder="stok">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Fiyatı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="fiyat" value="<?php echo $sayfam['fiyat']; ?>" placeholder="fiyat">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">KDV Oranı</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="kdv" value="<?php echo $sayfam['kdv']; ?>" placeholder="kdv">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Açıklaması</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="aciklama" value="<?php echo $sayfam['aciklama']; ?>" placeholder="aciklama">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Resim Tipi</label>
                                        <div class="col-sm-10">
                                            <input id="demo-inline-form-radio" class="magic-radio" name="resimtip" value="0" checked <?php echo $sayfam['resimtip'] == '0' ? 'checked=""' : null; ?> type="radio">
                                            <label for="demo-inline-form-radio">Normal Sıralı Resim ( resim,resim1,resim2 )</label>
                                            
                                            <input id="demo-inline-form-radio-2" class="magic-radio" name="resimtip" value="1" <?php echo $sayfam['resimtip'] == '1' ? 'checked=""' : null; ?> type="radio">
                                            <label for="demo-inline-form-radio-2">Döngülü Resim ( Örnek resimler>resim )</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row" id="anaresim" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:block !important;' : 'display:none !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Ana Resim</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="anaresim" value="<?php echo $sayfam['anaresim']; ?>" placeholder="Örnek (images->img_item)">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row" id="resim" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Ana Resim</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim" value="<?php echo $sayfam['resim']; ?>" placeholder="resim">
                                        </div>
                                    </div>
                                    
                                    <!-- Resim alanları 1-9 için aynı mantık -->
                                    <?php for($i = 1; $i <= 9; $i++): ?>
                                    <div class="form-group row" id="resim<?php echo $i; ?>" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi <?php echo $i; ?></label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                            <input class="form-control" type="text" name="resim<?php echo $i; ?>" value="<?php echo $sayfam['resim'.$i]; ?>" placeholder="resim<?php echo $i; ?>">
                                        </div>
                                    </div>
                                    <?php endfor; ?>

                                    <?php if($_GET['duzenle']): ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if($sayfam['durum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum">
                                        </div>
                                    </div>   
                                    <?php else: ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" checked="" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum">
                                        </div>
                                    </div> 
                                    <?php endif; ?>   
                                    
                                    <?php if($_GET['duzenle']): ?>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Yükleme Durumu</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" <?php if($sayfam['yukledurum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="yukledurum" <?php echo $isProcessing ? 'disabled' : ''; ?>>
                                            <?php if($isProcessing): ?>
                                            <small class="text-warning">XML işlemi devam ediyor, lütfen bekleyin.</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>   
                                    <?php endif; ?>  		
                                    
                                </div>
                            </div>

                            <?php if($_GET['duzenle']): ?>
                            <button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light" <?php echo $isProcessing ? 'disabled' : ''; ?>>
                                <?php echo $isProcessing ? 'XML İşlemi Devam Ediyor...' : 'Güncelle'; ?>
                            </button>
                            <?php else: ?>
                            <button type="submit" name="kaydet" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Kaydet</button>
                            <?php endif; ?>     

                        </div>	
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
// Kategori tipi değiştiğinde parcatip alanını göster/gizle
$('input[name="kattip"]').change(function() {
    if ($(this).val() == '1') {
        $('#parcatip').show();
    } else {
        $('#parcatip').hide();
    }
});

// Resim tipi değiştiğinde resim alanlarını göster/gizle
$('input[name="resimtip"]').change(function() {
    if ($(this).val() == '1') {
        $('#anaresim').show();
        $('#resim, #resim1, #resim2, #resim3, #resim4, #resim5, #resim6, #resim7, #resim8, #resim9').hide();
    } else {
        $('#anaresim').hide();
        $('#resim, #resim1, #resim2, #resim3, #resim4, #resim5, #resim6, #resim7, #resim8, #resim9').show();
    }
});
</script>
