<?php
// Test dosyası - XML kaydetme işlemini test etmek için
define("guvenlik", true);
require('../func/db.php');
require('../func/fonksiyon.php');

// Session başlatma
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Test verisi
$_POST['kaydet'] = '1';
$_POST['xmlurl'] = 'https://test.com/test.xml';
$_POST['urunadi'] = 'Test Ürün';
$_POST['urunkodu'] = 'TEST001';
$_POST['urunbarkodu'] = '123456789';
$_POST['stok'] = '10';
$_POST['fiyat'] = '100.00';
$_POST['kdv'] = '18';
$_POST['aciklama'] = 'Test açıklama';
$_POST['resim'] = 'test.jpg';
$_POST['kategori'] = 'Test Kategori';
$_POST['durum'] = '1';
$_POST['resim1'] = 'test1.jpg';
$_POST['resim2'] = 'test2.jpg';
$_POST['resim3'] = 'test3.jpg';
$_POST['resim4'] = 'test4.jpg';
$_POST['resim5'] = 'test5.jpg';
$_POST['resim6'] = 'test6.jpg';
$_POST['resim7'] = 'test7.jpg';
$_POST['resim8'] = 'test8.jpg';
$_POST['resim9'] = 'test9.jpg';
$_POST['yukledurum'] = '1';
$_POST['marka'] = 'Test Marka';
$_POST['kattip'] = '1';
$_POST['parcatip'] = '>>>';
$_POST['resimtip'] = '0';
$_POST['anaresim'] = 'ana.jpg';

// Admin session simülasyonu (test için)
$_SESSION['kullaniciadi'] = 'admin';
$_SESSION['sifre'] = '21232f297a57a5a743894a0e4a801fc3';
$_SESSION['departmanid'] = '1';

echo "<h2>XML Kaydetme Testi</h2>";

try {
    // Veritabanı bağlantısını test et
    echo "<p>Veritabanı bağlantısı: ";
    if ($ozy) {
        echo "✓ Başarılı</p>";
    } else {
        echo "✗ Başarısız</p>";
        exit;
    }

    // Admin kontrolü
    $kullaniciadi = trim($_SESSION['kullaniciadi']);
    $sifre = trim($_SESSION['sifre']);
    $login_kontrol = $ozy->query("SELECT * FROM admin WHERE kullaniciadi = '{$kullaniciadi}' and sifre = '{$sifre}'")->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Admin kontrolü: ";
    if ($login_kontrol) {
        echo "✓ Başarılı (ID: " . $login_kontrol['id'] . ")</p>";
    } else {
        echo "✗ Başarısız</p>";
        exit;
    }

    // XML kaydetme işlemi
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
    $durum = '1';
    $resim1 = trim(($_POST['resim1'] != "") ? $_POST['resim1'] : "0");
    $resim2 = trim(($_POST['resim2'] != "") ? $_POST['resim2'] : "0");
    $resim3 = trim(($_POST['resim3'] != "") ? $_POST['resim3'] : "0");
    $resim4 = trim(($_POST['resim4'] != "") ? $_POST['resim4'] : "0");
    $resim5 = trim(($_POST['resim5'] != "") ? $_POST['resim5'] : "0");
    $resim6 = trim(($_POST['resim6'] != "") ? $_POST['resim6'] : "0");
    $resim7 = trim(($_POST['resim7'] != "") ? $_POST['resim7'] : "0");
    $resim8 = trim(($_POST['resim8'] != "") ? $_POST['resim8'] : "0");
    $resim9 = trim(($_POST['resim9'] != "") ? $_POST['resim9'] : "0");
    $yukledurum = temizle($_POST['yukledurum']);
    $marka = temizle($_POST['marka']);
    $kattip = temizle($_POST['kattip']);
    $parcatip = temizle($_POST['parcatip']);
    $resimtip = temizle($_POST['resimtip']);
    $anaresim = temizle($_POST['anaresim']);
    $tarih = date('d.m.Y H:i:s');

    echo "<p>Veri hazırlama: ✓ Başarılı</p>";
    echo "<p>XML URL: " . $xmlurl . "</p>";
    echo "<p>Ürün Adı: " . $urunadi . "</p>";

    // INSERT işlemi
    $stmt = $ozy->prepare("INSERT INTO xml (xmlurl, urunadi, urunkodu, urunbarkodu, stok, fiyat, kdv, aciklama, resim, kategori, durum, resim1, resim2, resim3, resim4, resim5, resim6, resim7, resim8, resim9, yukledurum, marka, kattip, parcatip, resimtip, anaresim, tarih) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $result2 = $stmt->execute(array($xmlurl, $urunadi, $urunkodu, $urunbarkodu, $stok, $fiyat, $kdv, $aciklama, $resim, $kategori, $durum, $resim1, $resim2, $resim3, $resim4, $resim5, $resim6, $resim7, $resim8, $resim9, $yukledurum, $marka, $kattip, $parcatip, $resimtip, $anaresim, $tarih));
    
    if ($result2) {
        $id = $ozy->lastInsertId();
        echo "<p style='color: green; font-weight: bold;'>✓ XML başarıyla kaydedildi! ID: " . $id . "</p>";
        
        // Kaydedilen veriyi kontrol et
        $kontrol = $ozy->query("SELECT * FROM xml WHERE id = " . $id)->fetch(PDO::FETCH_ASSOC);
        if ($kontrol) {
            echo "<p>Kaydedilen veri kontrolü: ✓ Başarılı</p>";
            echo "<p>XML URL: " . $kontrol['xmlurl'] . "</p>";
            echo "<p>Ürün Adı: " . $kontrol['urunadi'] . "</p>";
            echo "<p>Tarih: " . $kontrol['tarih'] . "</p>";
        }
    } else {
        echo "<p style='color: red; font-weight: bold;'>✗ XML kaydedilemedi!</p>";
        echo "<p>Hata: " . print_r($stmt->errorInfo(), true) . "</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red; font-weight: bold;'>Hata: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='pages/xmlyukle.php'>XML Yükleme Sayfasına Dön</a></p>";
?>
