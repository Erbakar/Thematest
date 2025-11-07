<?php
// Komut satırından çalıştırılacak XML işleme worker'ı
if (php_sapi_name() !== 'cli' && !isset($_GET['debug'])) {
    die('Bu dosya sadece komut satırından çalıştırılabilir.');
}

// XML ID'yi al
$xml_id = isset($argv[1]) ? intval($argv[1]) : (isset($_GET['xml_id']) ? intval($_GET['xml_id']) : 0);

if (!$xml_id) {
    die('XML ID belirtilmedi.');
}

// Temel konfigürasyon
ini_set('max_execution_time', 3600); // 1 saat
ini_set('memory_limit', '128M'); // 128MB RAM (256MB sunucu için optimize edildi)
set_time_limit(3600);

// Veritabanı bağlantısı
include("../../func/db.php");

// Başlangıç zamanı
$startTime = microtime(true);
$startDate = date('d.m.Y H:i:s');

echo "🚀 XML İşlemi Başladı: {$startDate} (ID: {$xml_id})" . PHP_EOL;
file_put_contents('xml_progress.txt', '0|XML işlemi başlatıldı...');

try {
    // XML konfigürasyonunu getir
    $sayfam = $ozy->query("SELECT * FROM xml WHERE id = $xml_id")->fetch(PDO::FETCH_ASSOC);
    
    if (!$sayfam) {
        throw new Exception('XML konfigürasyonu bulunamadı');
    }
    
    $xmlurl = $sayfam['xmlurl'];
    $urunadi = $sayfam['urunadi'];
    $urunkodu = $sayfam['urunkodu'];
    $urunbarkodu = $sayfam['urunbarkodu'];
    $stok = $sayfam['stok'];
    $fiyat = $sayfam['fiyat'];
    $kdv = $sayfam['kdv'];
    $aciklama = $sayfam['aciklama'];
    $resim = $sayfam['resim'];
    $kategori = $sayfam['kategori'];
    $durum = $sayfam['durum'];
    $resim1 = $sayfam['resim1'];
    $resim2 = $sayfam['resim2'];
    $resim3 = $sayfam['resim3'];
    $resim4 = $sayfam['resim4'];
    $resim5 = $sayfam['resim5'];
    $resim6 = $sayfam['resim6'];
    $resim7 = $sayfam['resim7'];
    $resim8 = $sayfam['resim8'];
    $resim9 = $sayfam['resim9'];
    $marka = $sayfam['marka'];
    $kattip = $sayfam['kattip'];
    $parcatip = $sayfam['parcatip'];
    $resimtip = $sayfam['resimtip'];
    $anaresim = $sayfam['anaresim'];
    
    // XML dosyasını yükle
    file_put_contents('xml_progress.txt', '1|XML dosyası yükleniyor...');
    echo "📥 XML dosyası yükleniyor: {$xmlurl}" . PHP_EOL;
    
    $xml = simplexml_load_file($xmlurl);
    if (!$xml) {
        throw new Exception('XML dosyası yüklenemedi: ' . $xmlurl);
    }
    
    $totalProducts = count($xml->children());
    echo "📊 Toplam ürün sayısı: {$totalProducts}" . PHP_EOL;
    
    file_put_contents('xml_progress.txt', '5|XML dosyası başarıyla yüklendi. Ürünler işleniyor...');
    
    $processedCount = 0;
    $addedCount = 0;
    $updatedCount = 0;
    $errorCount = 0;
    
    foreach($xml->children() as $urun) {
        $processedCount++;
        
        try {
            // Resim tipine göre resim işleme
            if($resimtip == '1') {
                $obj = explode("->", $anaresim);
                $sonuc = $urun;
                foreach($obj as $ob) {
                    $sonuc = $sonuc->$ob;
                }
            }
            
            // Ürün verilerini hazırla
            $xurunadi = trim(($urun->$urunadi != "") ? $urun->$urunadi : "0");
            $xseo = seo($xurunadi);
            $xurunkodu = trim(($urun->$urunkodu != "") ? $urun->$urunkodu : "0");
            $xurunbarkodu = trim(($urun->$urunbarkodu != "") ? $urun->$urunbarkodu : "0");
            $xstok = trim(($urun->$stok != "") ? $urun->$stok : "0");
            $xfiyat = trim(($urun->$fiyat != "") ? $urun->$fiyat : "0");
            $xkdv = ($urun->$kdv != "") ? $urun->$kdv : "0";
            $xaciklama = ($urun->$aciklama != "") ? $urun->$aciklama : " ";
            $xmarka = trim(($urun->$marka != "") ? $urun->$marka : "0");
            $tarih = date('d.m.Y H:i:s');
            
            if($xstok >= '0') {
                // Ürün kontrolü
                $urunbak = $ozy->query("SELECT id FROM urunler WHERE seo = '" . $xseo . "' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                
                if ($urunbak) {
                    // Ürün güncelleme
                    $urunguncelle = $ozy->prepare("UPDATE urunler SET fiyat=?, stok=?, aciklama=? WHERE seo = ?");
                    $urunguncelle->execute(array($xfiyat, $xstok, $xaciklama, $xseo));
                    $updatedCount++;
                    echo "✅ Güncellendi: {$xurunadi}" . PHP_EOL;
                } else {
                    // Yeni ürün ekleme
                    $newProductId = addNewProduct($ozy, $urun, $sayfam, $xurunadi, $xseo, $xurunkodu, $xurunbarkodu, $xstok, $xfiyat, $xkdv, $xaciklama, $xmarka, $tarih, $sonuc ?? null);
                    if ($newProductId) {
                        $addedCount++;
                        echo "➕ Eklendi: {$xurunadi}" . PHP_EOL;
                    } else {
                        $errorCount++;
                        echo "❌ Hata: {$xurunadi}" . PHP_EOL;
                    }
                }
            }
            
            // Progress güncelle
            if ($processedCount % 50 == 0) {
                $percent = round(($processedCount / $totalProducts) * 100, 1);
                file_put_contents('xml_progress.txt', $processedCount . '|' . $processedCount . ' ürün işlendi (%' . $percent . ')');
                echo "📊 İşlenen: {$processedCount}/{$totalProducts} (%{$percent})" . PHP_EOL;
            }
            
        } catch (Exception $e) {
            $errorCount++;
            echo "❌ Ürün işleme hatası: " . $e->getMessage() . PHP_EOL;
        }
    }
    
    // Temizlik işlemleri
    $ozy->exec("DELETE FROM markalar WHERE adi=' '");
    $ozy->exec("DELETE FROM kategoriler WHERE adi=' '");
    $ozy->exec("DELETE FROM urunler WHERE adi=' '");
    
    // Sonuç
    $endTime = microtime(true);
    $duration = round($endTime - $startTime, 2);
    $minutes = floor($duration / 60);
    $seconds = $duration % 60;
    
    $resultMessage = "✅ Tamamlandı! {$addedCount} eklendi, {$updatedCount} güncellendi, {$errorCount} hata. Süre: {$minutes}dk {$seconds}sn";
    echo $resultMessage . PHP_EOL;
    
    file_put_contents('xml_progress.txt', 'done|' . $resultMessage);
    
    // Lock dosyasını temizle
    if (file_exists('xml_process.lock')) {
        unlink('xml_process.lock');
    }
    
} catch (Exception $e) {
    $errorMessage = "❌ XML İşlemi Hatası: " . $e->getMessage();
    echo $errorMessage . PHP_EOL;
    file_put_contents('xml_progress.txt', 'error|' . $errorMessage);
    
    // Lock dosyasını temizle
    if (file_exists('xml_process.lock')) {
        unlink('xml_process.lock');
    }
}

// Yeni ürün ekleme fonksiyonu
function addNewProduct($ozy, $urun, $sayfam, $xurunadi, $xseo, $xurunkodu, $xurunbarkodu, $xstok, $xfiyat, $xkdv, $xaciklama, $xmarka, $tarih, $sonuc = null) {
    try {
        $kategori = $sayfam['kategori'];
        $kattip = $sayfam['kattip'];
        $parcatip = $sayfam['parcatip'];
        $resim = $sayfam['resim'];
        $resimtip = $sayfam['resimtip'];
        
        // Kategori işleme
        $katid = processCategory($ozy, $urun, $kategori, $kattip, $parcatip);
        
        // Marka işleme
        $markaid = processBrand($ozy, $xmarka);
        
        // Resim işleme
        $yeniad = processMainImage($urun, $resim, $resimtip, $sonuc);
        
        // Ürün ekleme
        $stmtx = $ozy->prepare("INSERT INTO urunler (adi, seo, urunkodu, urunbarkodu, parabirimi, stok, fiyat, kdv, aciklama, kategori, durum, tarih, yildiz, resim, marka) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $result2x = $stmtx->execute(array($xurunadi, $xseo, $xurunkodu, $xurunbarkodu, "0", $xstok, $xfiyat, $xkdv, $xaciklama, $katid, "1", $tarih, "5", $yeniad, $markaid));
        
        if ($result2x) {
            $urun_id = $ozy->lastInsertId();
            
            // Ek resimler işleme
            processAdditionalImages($ozy, $urun, $sayfam, $urun_id, $sonuc);
            
            return $urun_id;
        }
        
        return false;
        
    } catch (Exception $e) {
        echo "Ürün ekleme hatası: " . $e->getMessage() . PHP_EOL;
        return false;
    }
}

// Kategori işleme fonksiyonu
function processCategory($ozy, $urun, $kategori, $kattip, $parcatip) {
    if($kattip == '1') {
        // Parçalı kategori işleme
        $kategories = $urun->$kategori;
        $kategoriler = mb_split($parcatip, $kategories);
        $katCount = count($kategoriler);
        
        $kategoriBak = $ozy->query("SELECT id FROM kategoriler WHERE seo = '" . seo($kategoriler[0]) . "' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        if ($kategoriBak) {
            $katida = $kategoriBak["id"];
        } else {
            $katadi = $kategoriler[0];
            $katseo = seo($katadi);
            $ac = ($katCount <= 1) ? "1" : "0";
            $veriekle = $ozy->prepare("INSERT INTO kategoriler SET adi=?, seo=?, ac=?, durum=?, resim=?, ustkat=?, level=?");
            $veriekle->execute(array($katadi, $katseo, $ac, "1", "resimyok.jpg", "0", "0"));
            $katida = $ozy->lastInsertId();
        }
        
        // Alt kategoriler için aynı mantık...
        return $katida . ",0,0"; // Basitleştirilmiş
    } else {
        // Normal kategori işleme
        $katadi = ($urun->$kategori != "") ? $urun->$kategori : " ";
        $katseo = seo($katadi);
        
        $katbak = $ozy->query("SELECT id FROM kategoriler WHERE seo = '" . $katseo . "' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        
        if ($katbak) {
            return $katbak["id"];
        } else {
            $katstmt = $ozy->prepare("INSERT INTO kategoriler (adi, seo, durum, resim) VALUES (?,?,?,?)");
            $katstmt->execute(array($katadi, $katseo, "1", "resimyok.jpg"));
            return $ozy->lastInsertId();
        }
    }
}

// Marka işleme fonksiyonu
function processBrand($ozy, $xmarka) {
    $markaseo = seo($xmarka);
    $markabak = $ozy->query("SELECT id FROM markalar WHERE seo = '" . $markaseo . "' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    
    if ($markabak) {
        return $markabak["id"];
    } else {
        $markastmt = $ozy->prepare("INSERT INTO markalar (seo, adi, durum, resim) VALUES (?,?,?,?)");
        $markastmt->execute(array($markaseo, $xmarka, "1", "resimyok.jpg"));
        return $ozy->lastInsertId();
    }
}

// Ana resim işleme fonksiyonu
function processMainImage($urun, $resim, $resimtip, $sonuc = null) {
    try {
        if($resimtip == '1' && $sonuc) {
            $resimkonum = $sonuc[0];
        } else {
            $resimkonum = $urun->$resim;
        }
        
        if (empty($resimkonum)) {
            return "resimyok.jpg";
        }
        
        $resimad = basename($resimkonum);
        $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
        $yeniad = rand() . md5(time() . $resimad) . ($uzanti ? '.' . $uzanti : '');
        $yol = "../resimler/urunler";
        
        if (!is_dir($yol)) {
            mkdir($yol, 0755, true);
        }
        
        $image = @file_get_contents($resimkonum);
        if ($image !== false) {
            file_put_contents($yol . '/' . $yeniad, $image);
            return $yeniad;
        }
        
        return "resimyok.jpg";
        
    } catch (Exception $e) {
        echo "Resim işleme hatası: " . $e->getMessage() . PHP_EOL;
        return "resimyok.jpg";
    }
}

// Ek resimler işleme fonksiyonu
function processAdditionalImages($ozy, $urun, $sayfam, $urun_id, $sonuc = null) {
    try {
        $resimtip = $sayfam['resimtip'];
        
        if($resimtip == '1' && $sonuc) {
            // Döngülü resim işleme
            for ($i = 1; $i <= 9; $i++) {
                if (isset($sonuc[$i]) && $sonuc[$i] != " ") {
                    $additionalImageName = processAdditionalImage($sonuc[$i]);
                    if ($additionalImageName) {
                        insertImageToDatabase($ozy, $additionalImageName, $urun_id);
                    }
                }
            }
        } else {
            // Normal sıralı resim işleme
            for ($i = 1; $i <= 9; $i++) {
                $resimField = $sayfam['resim' . $i];
                if ($resimField && isset($urun->$resimField) && $urun->$resimField != " ") {
                    $additionalImageName = processAdditionalImage($urun->$resimField);
                    if ($additionalImageName) {
                        insertImageToDatabase($ozy, $additionalImageName, $urun_id);
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo "Ek resim işleme hatası: " . $e->getMessage() . PHP_EOL;
    }
}

function processAdditionalImage($resimkonum) {
    try {
        $resimad = basename($resimkonum);
        $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
        $yeniad = rand() . md5(time() . $resimad) . ($uzanti ? '.' . $uzanti : '');
        $yol = "../resimler/urunler";
        
        $image = @file_get_contents($resimkonum);
        if ($image !== false) {
            file_put_contents($yol . '/' . $yeniad, $image);
            return $yeniad;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

function insertImageToDatabase($ozy, $imageName, $urun_id) {
    try {
        $ekle = $ozy->prepare("INSERT INTO tumresimler SET sayfaresim=?, alan=?, sayfaid=?");
        $ekle->execute(array($imageName, 'urunler', $urun_id));
    } catch (Exception $e) {
        echo "Resim veritabanı hatası: " . $e->getMessage() . PHP_EOL;
    }
}

// SEO fonksiyonu (basit versiyon)
function seo($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s]/', '', $text);
    $text = preg_replace('/\s+/', '-', trim($text));
    return $text;
}
?>
