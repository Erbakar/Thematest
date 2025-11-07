<?php
define("guvenlik", true);
require('../func/db.php');
require('../func/fonksiyon.php');

// Session başlatma kontrolü
if (session_status() == PHP_SESSION_NONE) {
    // Session ayarları
    ini_set('session.cookie_lifetime', 0);
    ini_set('session.gc_maxlifetime', 3600);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}

// Admin giriş kontrolü - AJAX için özel kontrol
if (!isset($_SESSION['kullaniciadi']) || !isset($_SESSION['sifre']) || empty($_SESSION['kullaniciadi']) || empty($_SESSION['sifre'])) {
    http_response_code(403);
    echo json_encode([
        'status' => 'error', 
        'message' => 'Oturum süresi dolmuş. Lütfen tekrar giriş yapın.',
        'debug' => [
            'session_status' => session_status(),
            'session_id' => session_id(),
            'kullaniciadi_set' => isset($_SESSION['kullaniciadi']),
            'sifre_set' => isset($_SESSION['sifre']),
            'kullaniciadi_value' => $_SESSION['kullaniciadi'] ?? 'NOT_SET',
            'sifre_value' => $_SESSION['sifre'] ?? 'NOT_SET'
        ]
    ]);
    exit;
}

// Veritabanında admin kontrolü - Prepared statement kullan
$kullaniciadi = trim($_SESSION['kullaniciadi']);
$sifre = trim($_SESSION['sifre']);
$login_kontrol = $ozy->prepare("SELECT * FROM admin WHERE kullaniciadi = ? and sifre = ?");
$login_kontrol->execute([$kullaniciadi, $sifre]);
$login_result = $login_kontrol->fetch(PDO::FETCH_ASSOC);

if (!$login_result) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz oturum. Lütfen tekrar giriş yapın.']);
    exit;
}

// Departman yetki kontrolü - AJAX için özel kontrol
if (isset($_SESSION['departmanid'])) {
    $departmanid = intval($_SESSION['departmanid']);
    $yetki = $ozy->prepare("SELECT * FROM yetki WHERE departmanid = ?");
    $yetki->execute([$departmanid]);
    $yetki_result = $yetki->fetch(PDO::FETCH_ASSOC);
    
    if ($yetki_result) {
        $dizi = explode(",", $yetki_result['menu']);
        if (!in_array('5', $dizi)) {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Bu işlem için yetkiniz bulunmuyor.']);
            exit;
        }
    }
}


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
            // XML işlemi başlatma kontrolü
            if ($yukledurum == '1') {
                // XML yükleme aktifse arka plan işlemini başlat
                echo json_encode([
                    'status' => 'processing', 
                    'message' => 'XML ayarları kaydedildi. XML yükleme işlemi arka planda başlatıldı.',
                    'xml_id' => $id,
                    'action' => 'start_xml_process'
                ]);
            } else {
                // XML yükleme pasifse sadece kaydet
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'XML ayarları başarıyla güncellendi. XML yükleme pasif olduğu için arka plan işlemi başlatılmadı.'
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
            
            // XML işlemi başlatma kontrolü
            if ($yukledurum == '1') {
                // XML yükleme aktifse arka plan işlemini başlat
                echo json_encode([
                    'status' => 'processing', 
                    'message' => 'XML kaydedildi. XML yükleme işlemi arka planda başlatıldı.',
                    'xml_id' => $id,
                    'action' => 'start_xml_process'
                ]);
            } else {
                // XML yükleme pasifse sadece kaydet
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'XML ayarları başarıyla kaydedildi. XML yükleme pasif olduğu için arka plan işlemi başlatılmadı.'
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