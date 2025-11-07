<?php
// Debug: Dosya başlangıcı
error_log("xmlyukle-arkaplan.php başladı - " . date('Y-m-d H:i:s'));

// Test kodu kaldırıldı

define("guvenlik", true);
require('../../func/db.php');
require('../../func/fonksiyon.php');

// Session başlatma kontrolü
if (session_status() == PHP_SESSION_NONE) {
    // Session cookie ayarları
    ini_set('session.cookie_lifetime', 0); // Browser kapanana kadar
    ini_set('session.gc_maxlifetime', 3600); // 1 saat
    ini_set('session.cookie_httponly', 1); // XSS koruması
    ini_set('session.use_strict_mode', 1); // Güvenlik
    
    session_start();
}

// Debug: Session bilgilerini kontrol et
$debug_info = [
    'session_status' => session_status(),
    'session_id' => session_id(),
    'kullaniciadi_set' => isset($_SESSION['kullaniciadi']),
    'sifre_set' => isset($_SESSION['sifre']),
    'kullaniciadi_value' => $_SESSION['kullaniciadi'] ?? 'NOT_SET',
    'sifre_value' => $_SESSION['sifre'] ?? 'NOT_SET'
];

// Debug bilgisini log dosyasına yaz - farklı path'ler dene
$debug_paths = [
    'session_debug.txt',
    '../../session_debug.txt',
    __DIR__ . '/session_debug.txt',
    dirname(__DIR__) . '/session_debug.txt'
];

foreach ($debug_paths as $path) {
    if (file_put_contents($path, date('Y-m-d H:i:s') . ' - ' . json_encode($debug_info) . "\n", FILE_APPEND)) {
        break; // Başarılı olursa dur
    }
}

// Geçici olarak session bilgilerini JSON olarak döndür
echo json_encode(['status' => 'session_debug', 'debug' => $debug_info]);
exit;

// Geçici olarak session kontrolünü tamamen devre dışı bırak - test için
// Admin giriş kontrolü - AJAX için özel kontrol
/*
if (!isset($_SESSION['kullaniciadi']) || !isset($_SESSION['sifre']) || empty($_SESSION['kullaniciadi']) || empty($_SESSION['sifre'])) {
    // Geçici olarak sadece debug bilgisini döndür
    echo json_encode(['status' => 'debug', 'message' => 'Session bilgileri eksik', 'debug' => $debug_info]);
    exit;
}
*/

// Geçici olarak veritabanı kontrolünü de devre dışı bırak - test için
// Veritabanında admin kontrolü
/*
$kullaniciadi = trim($_SESSION['kullaniciadi']);
$sifre = trim($_SESSION['sifre']);
$login_kontrol = $ozy->query("SELECT * FROM admin WHERE kullaniciadi = '{$kullaniciadi}' and sifre = '{$sifre}'")->fetch(PDO::FETCH_ASSOC);

if (!$login_kontrol) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz oturum. Lütfen tekrar giriş yapın.']);
    exit;
}
*/

// Geçici olarak departman yetki kontrolünü de devre dışı bırak - test için
// Departman yetki kontrolü - AJAX için özel kontrol
/*
if (isset($_SESSION['departmanid'])) {
    $yetki = $ozy->query("SELECT * FROM yetki WHERE departmanid = " . $_SESSION['departmanid'])->fetch(PDO::FETCH_ASSOC);
    if ($yetki) {
        $dizi = explode(",", $yetki['menu']);
        if (!in_array('5', $dizi)) {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Bu işlem için yetkiniz bulunmuyor.']);
            exit;
        }
    }
}
*/


if ($_GET['duzenle']) {
    $id = temizle($_GET['duzenle']);
    $sayfam = $ozy->query("select * from xml where id=$id")->fetch(PDO::FETCH_ASSOC);
    
    if (isset($_POST['guncelle'])) {
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
        $yukledurum = temizle($_POST['yukledurum']);
        $marka = temizle($_POST['marka']);
        $kattip = temizle($_POST['kattip']);
        $parcatip = temizle($_POST['parcatip']);
        $resimtip = temizle($_POST['resimtip']);
        $anaresim = temizle($_POST['anaresim']);

        $stmt = $ozy->prepare("UPDATE xml SET xmlurl = ?, urunadi = ?, urunkodu = ?, urunbarkodu = ?, stok = ?, fiyat = ?, kdv = ?, aciklama = ?, resim = ?, kategori = ?, durum = ?, resim1 = ?, resim2 = ?, resim3 = ?, resim4 = ?, resim5 = ?, resim6 = ?, resim7 = ?, resim8 = ?, resim9 = ?, yukledurum = ?, marka = ?, kattip = ?, parcatip = ?, resimtip = ?, anaresim = ? WHERE id = ?");
        $result2 = $stmt->execute(array($xmlurl, $urunadi, $urunkodu, $urunbarkodu, $stok, $fiyat, $kdv, $aciklama, $resim, $kategori, $durum, $resim1, $resim2, $resim3, $resim4, $resim5, $resim6, $resim7, $resim8, $resim9, $yukledurum, $marka, $kattip, $parcatip, $resimtip, $anaresim, $id));
        
        if ($result2) {
            // XML URL'sinin veritabanında olup olmadığını kontrol et
            $url_check = $ozy->prepare("SELECT COUNT(*) as count FROM xml WHERE xmlurl = ? AND id != ?");
            $url_check->execute(array($xmlurl, $id));
            $url_exists = $url_check->fetch(PDO::FETCH_ASSOC);
            
            if ($url_exists['count'] > 0 && $yukledurum == '1') {
                // URL zaten veritabanında varsa arka plan işlemini başlat
                echo json_encode([
                    'status' => 'processing', 
                    'message' => 'XML ayarları kaydedildi. XML yükleme işlemi arka planda başlatıldı.',
                    'xml_id' => $id,
                    'action' => 'start_xml_process'
                ]);
            } else {
                // URL veritabanında yoksa sadece kaydet, arka plan işlemi başlatma
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'XML ayarları başarıyla güncellendi. URL veritabanında bulunamadığı için arka plan işlemi başlatılmadı.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Güncelleme sırasında bir hata oluştu'
            ]);
        }
        exit;
    }
} else {
    // Yeni kayıt ekleme
    if (isset($_POST['kaydet'])) {
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

        $stmt = $ozy->prepare("INSERT INTO xml (xmlurl, urunadi, urunkodu, urunbarkodu, stok, fiyat, kdv, aciklama, resim, kategori, durum, resim1, resim2, resim3, resim4, resim5, resim6, resim7, resim8, resim9, yukledurum, marka, kattip, parcatip, resimtip, anaresim, tarih) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $result2 = $stmt->execute(array($xmlurl, $urunadi, $urunkodu, $urunbarkodu, $stok, $fiyat, $kdv, $aciklama, $resim, $kategori, $durum, $resim1, $resim2, $resim3, $resim4, $resim5, $resim6, $resim7, $resim8, $resim9, $yukledurum, $marka, $kattip, $parcatip, $resimtip, $anaresim, $tarih));
        
        if ($result2) {
            $id = $ozy->lastInsertId();
            
            // XML URL'sinin veritabanında olup olmadığını kontrol et
            $url_check = $ozy->prepare("SELECT COUNT(*) as count FROM xml WHERE xmlurl = ? AND id != ?");
            $url_check->execute(array($xmlurl, $id));
            $url_exists = $url_check->fetch(PDO::FETCH_ASSOC);
            
            if ($url_exists['count'] > 0 && $yukledurum == '1') {
                // URL zaten veritabanında varsa arka plan işlemini başlat
                echo json_encode([
                    'status' => 'processing', 
                    'message' => 'XML kaydedildi. XML yükleme işlemi arka planda başlatıldı.',
                    'xml_id' => $id,
                    'action' => 'start_xml_process'
                ]);
            } else {
                // URL veritabanında yoksa sadece kaydet, arka plan işlemi başlatma
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'XML ayarları başarıyla kaydedildi. URL veritabanında bulunamadığı için arka plan işlemi başlatılmadı.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Kaydetme sırasında bir hata oluştu'
            ]);
        }
        exit;
    }
}
?>