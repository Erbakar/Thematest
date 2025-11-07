<?php

define("guvenlik", true);
require('../func/db.php');
require('../func/fonksiyon.php');

// Session başlatma kontrolü
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Admin giriş kontrolü
if (!isset($_SESSION['kullaniciadi']) || !isset($_SESSION['sifre']) || empty($_SESSION['kullaniciadi']) || empty($_SESSION['sifre'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Oturum süresi dolmuş. Lütfen tekrar giriş yapın.']);
    exit;
}

// Veritabanında admin kontrolü
$kullaniciadi = trim($_SESSION['kullaniciadi']);
$sifre = trim($_SESSION['sifre']);
$login_kontrol = $ozy->query("SELECT * FROM admin WHERE kullaniciadi = '{$kullaniciadi}' and sifre = '{$sifre}'")->fetch(PDO::FETCH_ASSOC);

if (!$login_kontrol) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz oturum. Lütfen tekrar giriş yapın.']);
    exit;
}

// Departman yetki kontrolü
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

// Düzenleme modu
if (isset($_GET['duzenle']) && $_GET['duzenle'] > 0) {
    $id = temizle($_GET['duzenle']);
    $sayfam = $ozy->query("select * from xml where id=$id")->fetch(PDO::FETCH_ASSOC);
    
    if (!$sayfam) {
        echo json_encode(['status' => 'error', 'message' => 'XML kaydı bulunamadı.']);
        exit;
    }
    
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
            // Eğer yükleme durumu açıksa XML işlemini başlat
            if ($yukledurum == '1') {
                echo json_encode([
                    'status' => 'processing', 
                    'message' => 'XML ayarları güncellendi. XML yükleme işlemi başlatılıyor...',
                    'xml_id' => $id,
                    'action' => 'start_xml_process'
                ]);
            } else {
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'XML ayarları başarıyla güncellendi.'
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
            echo json_encode([
                'status' => 'success', 
                'message' => 'XML ayarları başarıyla kaydedildi. ID: ' . $id,
                'redirect' => 'xml.php'
            ]);
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Kaydetme sırasında bir hata oluştu'
            ]);
        }
        exit;
    }
}

// Eğer hiçbir işlem yapılmadıysa
echo json_encode(['status' => 'error', 'message' => 'Geçersiz işlem.']);
exit;
?>