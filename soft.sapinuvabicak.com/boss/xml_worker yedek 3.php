<?php
define("guvenlik", true);
require('../func/db.php');
require('../func/fonksiyon.php');

// Cron job kontrolü - eğer cron job ise session kontrolü yapma
$is_cron_job = isset($_GET['cron']) && $_GET['cron'] == '1';

// Sadece manuel çağrılar için session kontrolü yap
if (!$is_cron_job) {
    // Admin yetki kontrolü
    if (!isset($_SESSION['kullaniciadi']) || !isset($_SESSION['sifre'])) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Oturum süresi dolmuş. Lütfen tekrar giriş yapın.']);
        exit;
    }

    // Departman yetki kontrolü
    if (isset($_SESSION['departmanid'])) {
        admin_yetki($ozy, $_SESSION['departmanid'], 5);
    }
} else {
    // Cron job için güvenlik kontrolü - IP ve token kontrolü
    $allowed_ips = ['127.0.0.1', '::1', 'localhost', '::ffff:127.0.0.1', '159.146.109.218']; // Localhost ve sunucu IP'leri
    $client_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    
    // Debug için IP bilgisini log'a yaz
    file_put_contents('xml_worker_error.txt', "Cron job IP kontrolü - Client IP: {$client_ip}\n", FILE_APPEND);
    file_put_contents('xml_worker_error.txt', "Cron job parametreleri - XML ID: " . ($_GET['xml_id'] ?? 'yok') . ", Update: " . ($_GET['update'] ?? 'yok') . ", Token: " . ($_GET['token'] ?? 'yok') . "\n", FILE_APPEND);
    
    // IP kontrolü
    if (!in_array($client_ip, $allowed_ips)) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Cron job sadece localhost\'tan çalıştırılabilir. Client IP: ' . $client_ip]);
        exit;
    }
    
    // Token kontrolü (opsiyonel - daha güvenli olması için)
    $cron_token = $_GET['token'] ?? '';
    $expected_token = 'your_secure_token_here_2024'; // Bu token'ı değiştirin
    
    if ($cron_token !== $expected_token) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz cron token.']);
        exit;
    }
}

// Session'ı kapatarak site lock'ını engelle
if (session_status() == PHP_SESSION_ACTIVE) {
    session_write_close();
}
// Background process olarak çalış - Sunucu optimizasyonu
ignore_user_abort(true);
set_time_limit(0);
ini_set('memory_limit', '128M'); // 512MB RAM kullanımı (sunucu limiti)
ini_set('max_execution_time', 0); // Sınırsız çalışma süresi
ini_set('max_input_time', -1); // Sınırsız input süresi
ini_set('default_socket_timeout', 5); // Socket timeout
ini_set('pcre.backtrack_limit', 1000000); // Regex limit artır
ini_set('pcre.recursion_limit', 1000000); // Regex recursion limit
// Ürün güncelleme fonksiyonu - cron job için
function updateExistingProduct($ozy, $product_data, $product_id) {
    try {
        $stmt = $ozy->prepare("UPDATE urunler SET adi=?, seo=?, urunkodu=?, urunbarkodu=?, stok=?, fiyat=?, kdv=?, aciklama=?, kategori=?, marka=?, resim=?, idurum=? WHERE id=?");
        $result = $stmt->execute([
            $product_data['adi'],
            $product_data['seo'], 
            $product_data['urunkodu'],
            $product_data['urunbarkodu'],
            $product_data['stok'],
            $product_data['fiyat'],
            $product_data['kdv'],
            $product_data['aciklama'],
            $product_data['kategori'],
            $product_data['marka'],
            $product_data['resim'],
            '0', // idurum - varsayılan değer
            $product_id
        ]);
        return $result;
    } catch (Exception $e) {
        file_put_contents('xml_worker_error.txt', "Ürün güncelleme hatası (ID: {$product_id}): " . $e->getMessage() . "\n", FILE_APPEND);
        return false;
    }
}

// Ürün varlık kontrolü fonksiyonu
function checkProductExists($ozy, $urunkodu, $urunbarkodu) {
    try {
        $stmt = $ozy->prepare("SELECT id FROM urunler WHERE urunkodu = ? OR urunbarkodu = ? LIMIT 1");
        $stmt->execute([$urunkodu, $urunbarkodu]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : 0;
    } catch (Exception $e) {
        file_put_contents('xml_worker_error.txt', "Ürün varlık kontrolü hatası: " . $e->getMessage() . "\n", FILE_APPEND);
        return 0;
    }
}

// Ürünü güvenli silme fonksiyonu (ID rezerve et, yorum/puan koru)
function safeDeleteProduct($ozy, $product_id) {
    try {
        $ozy->beginTransaction();
        
        // Ürünü sil ama ID'yi rezerve et
        $stmt = $ozy->prepare("DELETE FROM urunler WHERE id = ?");
        $stmt->execute([$product_id]);
        
        // Yorum ve puan tablolarındaki verileri koru (ID rezerve)
        // Bu tablolar varsa kontrol et ve güncelle
        $tables_to_check = ['yorumlar', 'puanlar', 'urunpuanlari', 'degerlendirmeler'];
        foreach ($tables_to_check as $table) {
            try {
                $check_table = $ozy->query("SHOW TABLES LIKE '{$table}'");
                if ($check_table->rowCount() > 0) {
                    // Tablo varsa ürün ID'sini -1 yap (rezerve)
                    $ozy->query("UPDATE {$table} SET urunid = -1 WHERE urunid = {$product_id}");
                }
            } catch (Exception $e) {
                // Tablo yoksa devam et
            }
        }
        
        // Resimleri de sil
        $ozy->query("DELETE FROM tumresimler WHERE sayfaid = {$product_id} AND alan = 'urunler'");
        
        $ozy->commit();
        return true;
    } catch (Exception $e) {
        $ozy->rollback();
        file_put_contents('xml_worker_error.txt', "Ürün silme hatası (ID: {$product_id}): " . $e->getMessage() . "\n", FILE_APPEND);
        return false;
    }
}

// Bulk insert fonksiyonu - hızlı veritabanı işlemi
function processBatchProducts($ozy, $batch_products, $batch_images)
{
    if (empty($batch_products))
        return 0;

    try {
        $ozy->beginTransaction();

        // Ürünleri bulk insert - tüm gerekli alanlar
        $stmt = $ozy->prepare("INSERT INTO urunler (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim, urunkodu, urunbarkodu, fiyat, idurum, ifiyat, parabirimi, dolar, idolar, euro, ieuro, kisa, instagram, stok, kategori, marka, kdv, agoster, yeni, populer, coksatan, firsat, firsatsaat, filtre, havaledurum, hfiyat, ucretsizkargo, alode, al, ode, yildiz) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $inserted_ids = [];
        foreach ($batch_products as $product_index => $product) {
            $result = $stmt->execute($product['data']);
            if ($result) {
                $inserted_ids[] = $ozy->lastInsertId();
            } else {
                $error = $stmt->errorInfo();
                file_put_contents('xml_bulk_error.txt', "Bulk insert hatası (Ürün {$product_index}): " . $error[2] . "\n", FILE_APPEND);
                $inserted_ids[] = 0; // Hata durumunda 0
            }
        }

        // Resimleri bulk insert - ID'leri doğru şekilde set et
        if (!empty($batch_images)) {
            $img_stmt = $ozy->prepare("INSERT INTO tumresimler (sayfaid, sayfaresim, alan) VALUES (?,?,?)");
            $image_index = 0;
            foreach ($batch_products as $product_index => $product) {
                $product_id = $inserted_ids[$product_index];
                if ($product_id > 0) { // Sadece başarılı ürünler için
                    // Bu ürün için kaç resim var?
                    $product_image_count = 1; // Ana resim
                    if (isset($product['extra_images'])) {
                        $product_image_count += count($product['extra_images']);
                    }

                    // Bu ürünün resimlerini ekle
                    for ($j = 0; $j < $product_image_count && $image_index < count($batch_images); $j++) {
                        $batch_images[$image_index][0] = $product_id; // sayfaid set et
                        $img_stmt->execute($batch_images[$image_index]);
                        $image_index++;
                    }
                } else {
                    // Hatalı ürün için resimleri atla
                    $product_image_count = 1;
                    if (isset($product['extra_images'])) {
                        $product_image_count += count($product['extra_images']);
                    }
                    $image_index += $product_image_count;
                }
            }
        }

        $ozy->commit();
        return count(array_filter($inserted_ids)); // Sadece başarılı olanları say

    } catch (Exception $e) {
        $ozy->rollback();
        file_put_contents('xml_bulk_error.txt', "Bulk insert exception: " . $e->getMessage() . "\n", FILE_APPEND);
        return 0;
    }
}

// cURL ile resim indirme fonksiyonu - hızlandırılmış ve optimize edilmiş
function downloadImageWithCurl($url)
{
    // URL cache kontrolü - aynı resim tekrar indirilmesin (512MB limit için)
    static $imageCache = [];
    static $cacheCount = 0;
    $cacheKey = md5($url);

    // Cache'i 50 resimde bir temizle (memory tasarrufu)
    if ($cacheCount > 100) {
        // sadece eski 50 cache’i sil
        $imageCache = array_slice($imageCache, -50, 50, true);
        $cacheCount = count($imageCache);
        gc_collect_cycles();
    }

    if (isset($imageCache[$cacheKey])) {
        return $imageCache[$cacheKey];
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 10 saniye timeout (daha hızlı)
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // 3 saniye bağlantı timeout
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3); // Maksimum 3 redirect
    curl_setopt($ch, CURLOPT_MAXFILESIZE, 3145728); // 3MB maksimum dosya boyutu
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate,br'); // Sıkıştırma desteği
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0); // HTTP/2 kullan
    curl_setopt($ch, CURLOPT_TCP_NODELAY, 1); // TCP_NODELAY aktif
    curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1); // TCP Fast Open
    curl_setopt($ch, CURLOPT_BUFFERSIZE, 65536); // 64KB buffer
    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $fileSize = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
    if (curl_error($ch) || $httpCode !== 200 || $fileSize > 3145728) {
        curl_close($ch);
        $imageCache[$cacheKey] = false;
        return false;
    }
    curl_close($ch);
    $imageCache[$cacheKey] = $imageData;
    $cacheCount++;
    return $imageData;
}

// Eş zamanlı resim indirme fonksiyonu - curl_multi_exec kullanarak
function downloadImagesConcurrently($urls, $maxConcurrent = 10)
{
    if (empty($urls)) {
        return [];
    }

    // URL cache kontrolü - aynı resimler tekrar indirilmesin
    static $imageCache = [];
    static $cacheCount = 0;
    
    $results = [];
    $cachedResults = [];
    $urlsToDownload = [];
    
    // Cache kontrolü yap
    foreach ($urls as $index => $url) {
        $cacheKey = md5($url);
        if (isset($imageCache[$cacheKey])) {
            $cachedResults[$index] = $imageCache[$cacheKey];
        } else {
            $urlsToDownload[$index] = $url;
        }
    }
    
    // Cache'i temizle (memory tasarrufu)
    if ($cacheCount > 100) {
        $imageCache = array_slice($imageCache, -50, 50, true);
        $cacheCount = count($imageCache);
        gc_collect_cycles();
    }
    
    // Eğer tüm resimler cache'de varsa
    if (empty($urlsToDownload)) {
        return $cachedResults;
    }
    
    // URL'leri batch'lere böl (maksimum eş zamanlı indirme sayısı)
    $urlBatches = array_chunk($urlsToDownload, $maxConcurrent, true);
    
    foreach ($urlBatches as $batch) {
        $multiHandle = curl_multi_init();
        $curlHandles = [];
        
        // Her URL için cURL handle oluştur
        foreach ($batch as $index => $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8); // 8 saniye timeout
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // 5 saniye bağlantı timeout
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
            curl_setopt($ch, CURLOPT_MAXFILESIZE, 3145728); // 3MB maksimum
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate,br');
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
            curl_setopt($ch, CURLOPT_TCP_NODELAY, 1);
            curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);
            curl_setopt($ch, CURLOPT_BUFFERSIZE, 65536);
            
            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[$index] = $ch;
        }
        
        // Eş zamanlı indirme işlemini başlat
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
            curl_multi_select($multiHandle, 0.1); // 100ms bekle
        } while ($running > 0);
        
        // Sonuçları al
        foreach ($curlHandles as $index => $ch) {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $fileSize = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
            $error = curl_error($ch);
            
            if ($error || $httpCode !== 200 || $fileSize > 3145728) {
                $results[$index] = false;
            } else {
                $imageData = curl_multi_getcontent($ch);
                $results[$index] = $imageData;
                
                // Cache'e ekle
                $cacheKey = md5($batch[$index]);
                $imageCache[$cacheKey] = $imageData;
                $cacheCount++;
            }
            
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }
        
        curl_multi_close($multiHandle);
        
        // Memory temizleme
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
    }
    
    // Cache'den gelen sonuçları da ekle
    foreach ($cachedResults as $index => $cachedData) {
        $results[$index] = $cachedData;
    }
    
    return $results;
}

// Klasör oluşturma fonksiyonu
function createDirectoryIfNotExists($path)
{
    if (!is_dir($path)) {
        return mkdir($path, 0755, true);
    }
    return true;
}

// Trafik verisi kaydetme fonksiyonu
function saveTrafficData($ozy, $islem, $kullanim, $tarih) {
    try {
        $stmt = $ozy->prepare("INSERT INTO trafik (islem, kullanım, tarih) VALUES (?, ?, ?)");
        $result = $stmt->execute([$islem, $kullanim, $tarih]);
        return $result;
    } catch (Exception $e) {
        file_put_contents('xml_worker_error.txt', "Trafik verisi kaydetme hatası: " . $e->getMessage() . "\n", FILE_APPEND);
        return false;
    }
}

// XML güncelleme fonksiyonu - cron job için
function processXmlUpdate($xml_id, $is_cron_update = false) {
    global $ozy;
    
    try {
        // XML ayarlarını veritabanından al
        $sayfam = $ozy->query("select * from xml where id=$xml_id")->fetch(PDO::FETCH_ASSOC);
        if (!$sayfam) {
            return ['success' => false, 'message' => 'XML kaydı bulunamadı'];
        }
        
        // XML işleme kodunu buraya taşıyacağız (mevcut kodun bir kopyası)
        // Şimdilik basit bir başarı döndürüyoruz
        return ['success' => true, 'message' => 'XML güncellendi'];
        
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'XML güncelleme hatası: ' . $e->getMessage()];
    }
}
// POST ile gelen XML ID'sini al veya cron job için parametre
$xml_id = isset($_POST['xml_id']) ? intval($_POST['xml_id']) : (isset($_GET['xml_id']) ? intval($_GET['xml_id']) : 0);
$is_cron_update = isset($_GET['update']) && $_GET['update'] == '1'; // Cron job güncelleme modu

// Cron job için tüm XML'leri güncelleme modu
if ($is_cron_job && $xml_id == 0) {
    // Tüm aktif XML kayıtlarını al ve güncelle
    $all_xmls = $ozy->query("SELECT id FROM xml WHERE durum = '1' AND yukledurum = '1'")->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($all_xmls)) {
        echo json_encode(['status' => 'success', 'message' => 'Güncellenecek XML kaydı bulunamadı.']);
        exit;
    }
    
    $processed_count = 0;
    $error_count = 0;
    
    foreach ($all_xmls as $xml_record) {
        $current_xml_id = $xml_record['id'];
        
        // Her XML için ayrı işlem yap
        $result = processXmlUpdate($current_xml_id, true); // true = cron update mode
        
        if ($result['success']) {
            $processed_count++;
        } else {
            $error_count++;
        }
    }
    
    echo json_encode([
        'status' => 'success', 
        'message' => "Cron job tamamlandı. İşlenen: {$processed_count}, Hata: {$error_count}",
        'processed' => $processed_count,
        'errors' => $error_count
    ]);
    exit;
}

if ($xml_id > 0) {
    // XML ayarlarını veritabanından al
    $sayfam = $ozy->query("select * from xml where id=$xml_id")->fetch(PDO::FETCH_ASSOC);
    if (!$sayfam) {
        echo json_encode(['status' => 'error', 'message' => 'XML kaydı bulunamadı']);
        exit;
    }
    // Cron job değilse response gönder ve bağlantıyı kes
    if (!$is_cron_update) {
        $response = json_encode(['status' => 'started', 'message' => 'XML işlemi başlatıldı']);
        // Output buffer'ı temizle
        while (ob_get_level()) {
            ob_end_clean();
        }
        // Response gönder
        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($response));
        header('Connection: close');
        echo $response;
        // Buffer'ı flush et ve connection'ı kapat
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } else {
            ob_end_flush();
            flush();
        }
    }
    ini_set('memory_limit', '128M');
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
    $marka = $sayfam['marka'];
    $kattip = $sayfam['kattip'];
    $parcatip = $sayfam['parcatip'];
    $resimtip = $sayfam['resimtip'];
    $anaresim = $sayfam['anaresim'];
    $resim1 = $sayfam['resim1'];
    $resim2 = $sayfam['resim2'];
    $resim3 = $sayfam['resim3'];
    $resim4 = $sayfam['resim4'];
    $resim5 = $sayfam['resim5'];
    $resim6 = $sayfam['resim6'];
    $resim7 = $sayfam['resim7'];
    $resim8 = $sayfam['resim8'];
    $resim9 = $sayfam['resim9'];
    $durum = '1';
    $tarih = date('d.m.Y H:i:s');
    $yildiz = '5';
    $parabirimi = 'TL';
    // Debug dosyasını temizle ve yeni bilgileri yaz
    $parcatip_decoded = html_entity_decode($parcatip, ENT_QUOTES, 'UTF-8');
    // $debug_info = "=== XML KATEGORI DEBUG RAPORU ===\n";
    // $debug_info .= "Tarih: " . date('Y-m-d H:i:s') . "\n";
    // $debug_info .= "XML ID: {$xml_id}\n";
    // $debug_info .= "XML URL: {$xmlurl}\n";
    // $debug_info .= "Kategori Field: '{$kategori}'\n";
    // $debug_info .= "Kategori Tip: {$kattip}\n";
    // $debug_info .= "Parça Tip Orijinal: '{$parcatip}'\n";
    // $debug_info .= "Parça Tip Decoded: '{$parcatip_decoded}'\n";
    // $debug_info .= "Ürün Adı Field: '{$urunadi}'\n";
    // $debug_info .= "Marka Field: '{$marka}'\n";
    // $debug_info .= "================================\n\n";
    // file_put_contents('xml_kategori_debug.txt', $debug_info);
    try {
        // cURL ile XML içeriğini al
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $xmlurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        $xmlData = curl_exec($ch);
        if (curl_error($ch)) {
            curl_close($ch);
            echo json_encode(['status' => 'error', 'message' => 'XML indirme hatası']);
            exit;
        }
        curl_close($ch);
        // XML verisini parse et
        $xml = simplexml_load_string($xmlData);
        if ($xml === false) {
            echo json_encode(['status' => 'error', 'message' => 'XML parse hatası']);
            exit;
        }
        $i = 1;
        $success_count = 0;
        $update_count = 0; // Güncellenen ürün sayısı
        $delete_count = 0; // Silinen ürün sayısı
        $batch_size = 100; // 3 ürünlük batch'ler halinde işle (ultra güvenli - 512MB için)
        $batch_products = [];
        $batch_images = [];
        $total_concurrent_downloads = 0; // Eş zamanlı indirme istatistikleri
        $successful_concurrent_downloads = 0;
        
        // Güncelleme modu için XML'deki ürün kodlarını topla
        $xml_product_codes = [];
        if ($is_cron_update) {
            foreach ($xml->children() as $urun) {
                $xurunkodu = (string) $urun->{$urunkodu};
                $xurunbarkodu = (string) $urun->{$urunbarkodu};
                if (!empty($xurunkodu)) $xml_product_codes[] = $xurunkodu;
                if (!empty($xurunbarkodu)) $xml_product_codes[] = $xurunbarkodu;
            }
        }

        // XML işleme başlangıç zamanı
        $start_time = microtime(true);
        $start_datetime = date('Y-m-d H:i:s');
        $mode_text = $is_cron_update ? "GÜNCELLEME" : "YÜKLEME";
        file_put_contents('xml_progress.txt', "=== XML İŞLEME BAŞLADI ({$mode_text} MODU) ===\n", FILE_APPEND);
        file_put_contents('xml_progress.txt', "Başlangıç Zamanı: {$start_datetime}\n", FILE_APPEND);
        file_put_contents('xml_progress.txt', "Toplam Ürün Sayısı: {$total_products}\n", FILE_APPEND);
        file_put_contents('xml_progress.txt', "Memory Limit: 512MB\n", FILE_APPEND);
        file_put_contents('xml_progress.txt', "Batch Size: {$batch_size}\n", FILE_APPEND);
        file_put_contents('xml_progress.txt', "İşlem Modu: " . ($is_cron_update ? "Güncelleme" : "Yeni Yükleme") . "\n", FILE_APPEND);
        file_put_contents('xml_progress.txt', "========================\n", FILE_APPEND);
        // Debug: XML yapısını analiz et
        $total_products = count($xml->children());
        $xml_info = '';
        // XML root elementi ve ilk child'ı göster
        if ($xml->children()->count() > 0) {
            $first_child = $xml->children()[0];
            $element_names = [];
            foreach ($first_child->children() as $child_name => $child_value) {
                $element_names[] = $child_name;
            }
            $xml_info = 'İlk ürün elementleri: ' . implode(', ', array_slice($element_names, 0, 10));
            // XML yapısını debug dosyasına yaz
            // $xml_debug = "=== XML YAPISI ===\n";
            // $xml_debug .= "Toplam ürün sayısı: {$total_products}\n";
            // $xml_debug .= "İlk ürün elementleri: " . implode(', ', $element_names) . "\n";
            // $xml_debug .= "==================\n\n";
            // file_put_contents('xml_kategori_debug.txt', $xml_debug, FILE_APPEND);
        }
        // Urunler tablosunun yapısını kontrol et
        try {
            $table_check = $ozy->query("DESCRIBE urunler");
            $columns = $table_check->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
        }
        foreach ($xml->children() as $urun) {
            try {
                // Ürün işleme başlangıcı log
                if ($i % 100 == 0) {
                    $memory_usage = memory_get_usage(true) / 1024 / 1024; // MB
                    file_put_contents('xml_worker_error.txt', "Ürün {$i} işleniyor... Memory: {$memory_usage}MB\n", FILE_APPEND);
                }
                // Progress güncelleme
                if ($i % 10 == 0 || $i == 1) {
                }
                // Ürün verilerini işle - {} kullanarak değişken isim erişimi
                $xurunadi = (string) $urun->{$urunadi};
                $xseo = function_exists('seo') ? seo($xurunadi) : str_replace(' ', '-', strtolower($xurunadi));
                // Ürün kodu için alternatif field'ları dene
                $xurunkodu = (string) $urun->{$urunkodu};
                if (empty($xurunkodu)) {
                    $kod_alternatifleri = ['productCode', 'product_code', 'code', 'sku'];
                    foreach ($kod_alternatifleri as $alt_kod) {
                        if (isset($urun->{$alt_kod}) && !empty((string) $urun->{$alt_kod})) {
                            $xurunkodu = (string) $urun->{$alt_kod};
                            break;
                        }
                    }
                }
                // Barkod için alternatif field'ları dene  
                $xurunbarkodu = (string) $urun->{$urunbarkodu};
                if (empty($xurunbarkodu)) {
                    $barkod_alternatifleri = ['barcode', 'barCode', 'ean', 'gtin'];
                    foreach ($barkod_alternatifleri as $alt_barkod) {
                        if (isset($urun->{$alt_barkod}) && !empty((string) $urun->{$alt_barkod})) {
                            $xurunbarkodu = (string) $urun->{$alt_barkod};
                            break;
                        }
                    }
                }
                $xstok = (string) $urun->{$stok};
                $xfiyat = (string) $urun->{$fiyat};
                $xkdv = (string) $urun->{$kdv};
                $xaciklama = (string) $urun->{$aciklama};
                $xmarka = (string) $urun->{$marka};
                // Debug: İlk ürün için bilgi yazdır
                if ($i == 1) {
                    // İlk ürünün TÜM field'larını yazdır
                    $all_fields = [];
                    foreach ($urun->children() as $field_name => $field_value) {
                        $all_fields[] = "$field_name = '" . (string) $field_value . "'";
                    }
                }
                // Boş kontroller
                if (empty($xurunadi) || empty($xfiyat)) {
                    if ($i <= 5) {
                    }
                    $i++;
                    continue;
                }
                // Marka işleme - Prepared statement kullan
                $markaid = 0;
                if (!empty($xmarka)) {
                    $markavarmi = $ozy->prepare("SELECT id FROM markalar WHERE adi = ? LIMIT 1");
                    $markavarmi->execute(array($xmarka));
                    $markavarmi_result = $markavarmi->fetch(PDO::FETCH_ASSOC);
                    if ($markavarmi_result) {
                        $markaid = $markavarmi_result['id'];
                    } else {
                        $stmt = $ozy->prepare("INSERT INTO markalar (adi, seo, durum, tarih) VALUES (?,?,?,?)");
                        $stmt->execute(array($xmarka, seo($xmarka), 1, $tarih));
                        $markaid = $ozy->lastInsertId();
                    }
                }
                // Kategori işleme - alternatif field'ları dene
                $xkategori = (string) $urun->{$kategori};
                $kategori_debug = "XML Field: '{$kategori}' = '{$xkategori}'";
                // Kategori bulunamadıysa varsayılan kategori kullan
                if (empty($xkategori)) {
                    $xkategori = 'Genel';
                    $kategori_debug .= " | Varsayılan: 'Genel'";
                }
                $katid = 1; // Varsayılan kategori
                // İlk 5 ürün için kategori debug bilgisi
                // if ($i <= 5) {
                //     file_put_contents('xml_kategori_debug.txt', "Ürün {$i}: {$kategori_debug}\n", FILE_APPEND);
                // }
                if (!empty($xkategori)) {
                    try {
                        if ($kattip == '1' && !empty($parcatip)) {
                            // Parçalı kategori işleme - HTML entity decode yap
                            $parcatip_decoded = html_entity_decode($parcatip, ENT_QUOTES, 'UTF-8');
                            // Debug için parça tip bilgisini yaz
                            // if ($i <= 5) {
                            //     file_put_contents('xml_kategori_debug.txt', "Ürün {$i}: Parça tip orijinal: '{$parcatip}' | Decoded: '{$parcatip_decoded}'\n", FILE_APPEND);
                            // }
                            // >>> ile ayır
                            $kategoriler = preg_split('/\s*>{3}\s*/u', $xkategori);
                            $kategoriler = array_map('trim', $kategoriler);
                            $kategoriler = array_filter($kategoriler);
                            $katCount = count($kategoriler);
                            // Debug için kategori parçalarını yaz
                            // if ($i <= 5) {
                            //     file_put_contents('xml_kategori_debug.txt', "Ürün {$i}: Kategori parçaları (" . $katCount . "): " . implode(' | ', $kategoriler) . "\n", FILE_APPEND);
                            // }
                            $katida = 0; // Ana kategori ID
                            $katid1 = 0; // Alt kategori ID  
                            $katid2 = 0; // En alt kategori ID
                            // Ortak INSERT fonksiyonu
                            $insertKategori = function ($adi, $seo, $ustkat, $level, $ac = 0) use ($ozy) {
                                try {
                                    // Kolon listesi (id hariç)
                                    $cols = [
                                        'adi',
                                        'aciklama',
                                        'resim',
                                        'seo',
                                        'hit',
                                        'skey',
                                        'sdesc',
                                        'seodurum',
                                        'durum',
                                        'ustkat',
                                        'sira',
                                        'dil',
                                        'stitle',
                                        'ac',
                                        'level',
                                        'ustgoster',
                                        'yanresim',
                                        'ikon',
                                        'nikon',
                                        'agoster',
                                        'ikongoster',
                                        'renk'
                                    ];
                                    $placeholders = implode(',', array_fill(0, count($cols), '?'));
                                    $sql = "INSERT INTO kategoriler (" . implode(',', $cols) . ") VALUES ($placeholders)";
                                    $stmt = $ozy->prepare($sql);

                                    // Değer dizisi - kolon sırası ile eşleşmeli
                                    $values = [
                                        $adi,          // adi
                                        '',            // aciklama
                                        'resimyok.jpg', // resim
                                        $seo,          // seo
                                        '0',           // hit
                                        '',            // skey
                                        '',            // sdesc
                                        '0',           // seodurum
                                        '1',           // durum
                                        $ustkat,       // ustkat
                                        0,             // sira
                                        'tr',          // dil
                                        $adi,          // stitle
                                        $ac,           // ac
                                        $level,        // level
                                        0,             // ustgoster
                                        '',            // yanresim
                                        '',            // ikon
                                        '',            // nikon
                                        0,             // agoster
                                        0,             // ikongoster
                                        ''             // renk
                                    ];

                                    // Execute ve hata kontrolü
                                    if (!$stmt->execute($values)) {
                                        $err = $stmt->errorInfo();
                                        file_put_contents('xml_kategori_debug.txt', "Kategori INSERT error: " . ($err[2] ?? json_encode($err)) . "\n", FILE_APPEND);
                                        return 0;
                                    }

                                    $newId = $ozy->lastInsertId();
                                    // file_put_contents('xml_kategori_debug.txt', "Yeni kategori oluşturuldu: '{$adi}' -> ID: {$newId}\n", FILE_APPEND);
                                    return $newId;
                                } catch (Exception $e) {
                                    file_put_contents('xml_kategori_debug.txt', "Kategori INSERT exception: " . $e->getMessage() . "\n", FILE_APPEND);
                                    return 0;
                                }
                            };
                            // 1. Seviye - Ana Kategori
                            if ($katCount >= 1) {
                                $katadi = $kategoriler[0];
                                $katseo = function_exists('seo') ? seo($katadi) : str_replace(' ', '-', strtolower($katadi));
                                $stmtCheck = $ozy->prepare("SELECT id FROM kategoriler WHERE adi = ? AND ustkat = ? LIMIT 1");
                                $stmtCheck->execute([$katadi, 0]);
                                $kategoriBak = $stmtCheck->fetch(PDO::FETCH_ASSOC);
                                if ($kategoriBak) {
                                    $katida = $kategoriBak["id"];
                                } else {
                                    if ($i != 1) {
                                        $ac = ($katCount <= 1) ? 1 : 0;
                                        $katida = $insertKategori($katadi, $katseo, 0, 0, $ac);
                                    }
                                }
                            }
                            // 2. Seviye - Alt Kategori
                            if ($katCount >= 2 && $katida > 0) {
                                $katadi1 = $kategoriler[1];
                                $katseo1 = function_exists('seo') ? seo($katadi1) : str_replace(' ', '-', strtolower($katadi1));
                                $stmtCheck2 = $ozy->prepare("SELECT id FROM kategoriler WHERE adi = ? AND ustkat = ? LIMIT 1");
                                $stmtCheck2->execute([$katadi1, $katida]);
                                $akategoriBak = $stmtCheck2->fetch(PDO::FETCH_ASSOC);
                                if ($akategoriBak) {
                                    $katid1 = $akategoriBak["id"];
                                } else {
                                    if ($i != 1) {
                                        $katid1 = $insertKategori($katadi1, $katseo1, $katida, 1, 0);
                                    }
                                }
                            }
                            // 3. Seviye - En Alt Kategori
                            if ($katCount >= 3 && $katid1 > 0) {
                                $katadi2 = $kategoriler[2];
                                $katseo2 = function_exists('seo') ? seo($katadi2) : str_replace(' ', '-', strtolower($katadi2));
                                $stmtCheck3 = $ozy->prepare("SELECT id FROM kategoriler WHERE adi = ? AND ustkat = ? LIMIT 1");
                                $stmtCheck3->execute([$katadi2, $katid1]);
                                $ckategoriBak = $stmtCheck3->fetch(PDO::FETCH_ASSOC);
                                if ($ckategoriBak) {
                                    $katid2 = $ckategoriBak["id"];
                                } else {
                                    if ($i != 1) {
                                        $katid2 = $insertKategori($katadi2, $katseo2, $katid1, 2, 0);
                                    }
                                }
                            }
                            // Alt kategorisi olanların ac değerini güncelle
                            if ($katCount >= 2 && $katida > 0) {
                                $ozy->query("UPDATE kategoriler SET ac = '1' WHERE id = '$katida'");
                            }
                            if ($katCount >= 3 && $katid1 > 0) {
                                $ozy->query("UPDATE kategoriler SET ac = '1' WHERE id = '$katid1'");
                            }
                            // Kategori ID'sini belirle - En derin seviyeyi kullan
                            if ($katid2 > 0) {
                                $katid = $katid2;
                            } elseif ($katid1 > 0) {
                                $katid = $katid1;
                            } else {
                                $katid = $katida;
                            }
                        } else {
                            // Normal kategori işleme
                            $katvarmi = $ozy->prepare("SELECT id FROM kategoriler WHERE adi = ? LIMIT 1");
                            $katvarmi->execute([$xkategori]);
                            $katvarmi_result = $katvarmi->fetch(PDO::FETCH_ASSOC);
                            if ($katvarmi_result) {
                                $katid = $katvarmi_result['id'];
                                // if ($i <= 5) {
                                //     file_put_contents('xml_kategori_debug.txt', "Ürün {$i}: Kategori bulundu - ID: {$katid}, Ad: '{$xkategori}'\n", FILE_APPEND);
                                // }
                            } else {
                                $katseo = function_exists('seo') ? seo($xkategori) : str_replace(' ', '-', strtolower($xkategori));
                                $stmt = $ozy->prepare("INSERT INTO kategoriler 
                                    (adi, aciklama, resim, seo, hit, skey, sdesc, seodurum, durum, ustkat, sira, dil, stitle, ac, level, ustgoster, yanresim, ikon, nikon, agoster, ikongoster, renk) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                ");
                                $stmt->execute([
                                    $xkategori,
                                    '',
                                    'resimyok.jpg',
                                    $katseo,
                                    '0',
                                    '',
                                    '',
                                    '0',
                                    '1',
                                    0,
                                    0,
                                    'tr',
                                    $xkategori,
                                    1,
                                    0,
                                    0,
                                    '',
                                    '',
                                    '',
                                    0,
                                    0,
                                    ''
                                ]);
                                $katid = $ozy->lastInsertId();
                                // if ($i <= 5) {
                                //     file_put_contents('xml_kategori_debug.txt', "Ürün {$i}: Yeni kategori oluşturuldu - ID: {$katid}, Ad: '{$xkategori}'\n", FILE_APPEND);
                                // }
                            }
                        }
                    } catch (Exception $e) {
                        // Kategori işleme hatası raporu
                        if ($i <= 5) {
                            file_put_contents('xml_kategori_debug.txt', "Ürün {$i}: Kategori işleme hatası - " . $e->getMessage() . "\n", FILE_APPEND);
                        }
                        $katid = 1; // Hata durumunda varsayılan kategori
                    }
                }
                // Ana resim işleme - eş zamanlı indirme için URL'yi topla
                $yeniad = 'no-image.jpg'; // Varsayılan resim
                $resimkonum = ''; // Ana resim URL'si
                $imageUrls = []; // Eş zamanlı indirme için URL'leri topla
                $imageInfo = []; // Resim bilgilerini sakla
                
                if ($resimtip == '0') { // Tüm ürünler için resim indir
                    $resimkonum = trim((string) $urun->{$resim});
                    if (!empty($resimkonum) && $resimkonum != " " && filter_var($resimkonum, FILTER_VALIDATE_URL)) {
                        $resimad = basename($resimkonum);
                        $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
                        $yeniad = time() . '_' . rand(1000, 9999) . ($uzanti ? '.' . $uzanti : '.jpg');
                        $yol = "../resimler/urunler";
                        createDirectoryIfNotExists($yol);
                        
                        // URL'yi eş zamanlı indirme listesine ekle
                        $imageUrls[] = $resimkonum;
                        $imageInfo[] = [
                            'filename' => $yeniad,
                            'path' => $yol,
                            'type' => 'main'
                        ];
                    }
                }
                // Ek resimler işleme - eş zamanlı indirme için URL'leri topla
                $ek_resim_adlari = array();
                $kullanilan_resim_urleri = array(); // Aynı resim kontrolü için

                // Ana resmi kontrol listesine ekle (hem başarılı hem başarısız durumlar için)
                if (!empty($resimkonum) && $resimkonum != " " && filter_var($resimkonum, FILTER_VALIDATE_URL)) {
                    $kullanilan_resim_urleri[] = $resimkonum;
                }

                // Ek resim işleme - ana resim indirildiğinde diğer resimleri de indir
                if ($resimtip == '1') { // Tüm ürünler için ek resim işle
                    // Object path modunda - anaresim'den array olarak resimler gelir
                    if (!empty($anaresim)) {
                        $obj = explode("->", $anaresim);
                        $sonuc = $urun;
                        foreach ($obj as $ob) {
                            if (isset($sonuc->{$ob})) {
                                $sonuc = $sonuc->{$ob};
                            }
                        }
                        // Ana resim (index 0) - eğer daha önce ana resim yoksa
                        if (isset($sonuc[0]) && $sonuc[0] != " " && $yeniad == 'no-image.jpg') {
                            $ana_resim_url = trim($sonuc[0]);
                            if (!empty($ana_resim_url) && filter_var($ana_resim_url, FILTER_VALIDATE_URL)) {
                                $resimad = basename($ana_resim_url);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
                                $yeniad = time() . '_' . rand(1000, 9999) . ($uzanti ? '.' . $uzanti : '.jpg');
                                $yol = "../resimler/urunler";
                                createDirectoryIfNotExists($yol);
                                
                                // URL'yi eş zamanlı indirme listesine ekle
                                $imageUrls[] = $ana_resim_url;
                                $imageInfo[] = [
                                    'filename' => $yeniad,
                                    'path' => $yol,
                                    'type' => 'main'
                                ];
                                $kullanilan_resim_urleri[] = $ana_resim_url;
                            }
                        }
                        // Ek resimler (index 1-9)
                        for ($idx = 1; $idx <= 9; $idx++) {
                            if (isset($sonuc[$idx]) && $sonuc[$idx] != " ") {
                                $ek_resim_url = trim($sonuc[$idx]);
                                // Boş, geçersiz URL veya duplicate kontrolü
                                if (
                                    empty($ek_resim_url) ||
                                    !filter_var($ek_resim_url, FILTER_VALIDATE_URL) ||
                                    in_array($ek_resim_url, $kullanilan_resim_urleri)
                                ) {
                                    continue; // Bu resmi atla
                                }
                                $resimad = basename($ek_resim_url);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
                                $ek_yeniad = time() . '_' . $idx . '_' . rand(1000, 9999) . ($uzanti ? '.' . $uzanti : '.jpg');
                                
                                // URL'yi eş zamanlı indirme listesine ekle
                                $imageUrls[] = $ek_resim_url;
                                $imageInfo[] = [
                                    'filename' => $ek_yeniad,
                                    'path' => $yol,
                                    'type' => 'extra',
                                    'index' => $idx
                                ];
                                $kullanilan_resim_urleri[] = $ek_resim_url; // Kullanılan URL'yi kaydet
                            }
                        }
                    }
                } else { // Tüm ürünler için normal field modunda resim işle
                    // Normal field modunda - XML'deki TÜM resim field'larını dinamik tara
                    // Ana resim field'ını belirle (duplicate kontrolü için)
                    $ana_resim_field = $resim; // Form'dan gelen ana resim field adı
                    // XML'deki tüm field'ları kontrol et
                    foreach ($urun as $field_name => $field_value) {
                        $field_name_str = (string) $field_name;
                        $field_value_str = trim((string) $field_value);
                        // Ana resim field'ı ise atla (duplicate önlemek için)
                        if ($field_name_str === $ana_resim_field) {
                            continue;
                        }
                        // Resim field'ı kontrolü - image, resim, img, picture ile başlıyorsa
                        if (
                            (preg_match('/^(image|resim|img|picture)\d*$/i', $field_name_str) ||
                                preg_match('/^(photo|pic)\d*$/i', $field_name_str)) &&
                            !empty($field_value_str) &&
                            $field_value_str != " "
                        ) {
                            // Boş, geçersiz URL veya duplicate kontrolü
                            if (
                                empty($field_value_str) ||
                                !filter_var($field_value_str, FILTER_VALIDATE_URL) ||
                                in_array($field_value_str, $kullanilan_resim_urleri)
                            ) {
                                continue; // Bu field'ı atla
                            }
                            $resimad = basename($field_value_str);
                            $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
                            $unique_id = count($imageUrls) + 1; // Sıralı numara - imageUrls count'u kullan
                            $ek_yeniad = time() . '_' . $unique_id . '_' . rand(1000, 9999) . ($uzanti ? '.' . $uzanti : '.jpg');
                            $yol = "../resimler/urunler";
                            
                            // URL'yi eş zamanlı indirme listesine ekle
                            $imageUrls[] = $field_value_str;
                            $imageInfo[] = [
                                'filename' => $ek_yeniad,
                                'path' => $yol,
                                'type' => 'extra',
                                'index' => $unique_id
                            ];
                            $kullanilan_resim_urleri[] = $field_value_str; // Kullanılan URL'yi kaydet
                            
                            // Maksimum 9 ek resim sınırı
                            if (count($imageUrls) >= 10) { // Ana resim + 9 ek resim
                                break;
                            }
                        }
                    }
                }
                
                // Eş zamanlı resim indirme işlemi
                if (!empty($imageUrls)) {
                    try {
                        $downloadedImages = downloadImagesConcurrently($imageUrls, 25); // Maksimum 8 eş zamanlı indirme
                        
                        // İndirilen resimleri dosyalara kaydet
                        $successful_downloads = 0;
                        foreach ($downloadedImages as $index => $imageData) {
                            if ($imageData !== false && isset($imageInfo[$index])) {
                                $info = $imageInfo[$index];
                                $filePath = $info['path'] . '/' . $info['filename'];
                                
                                if (file_put_contents($filePath, $imageData)) {
                                    if ($info['type'] === 'main') {
                                        $yeniad = $info['filename'];
                                    } else {
                                        $ek_resim_adlari[$info['index']] = $info['filename'];
                                    }
                                    $successful_downloads++;
                                }
                            }
                        }
                        
                        // İstatistikleri güncelle
                        $total_concurrent_downloads += count($imageUrls);
                        $successful_concurrent_downloads += $successful_downloads;
                        
                    } catch (Exception $e) {
                        // Eş zamanlı indirme hatası durumunda tek tek indirmeyi dene
                        // Fallback: Tek tek indirme
                        foreach ($imageUrls as $index => $url) {
                            if (isset($imageInfo[$index])) {
                                $info = $imageInfo[$index];
                                $imageData = downloadImageWithCurl($url);
                                if ($imageData !== false) {
                                    $filePath = $info['path'] . '/' . $info['filename'];
                                    if (file_put_contents($filePath, $imageData)) {
                                        if ($info['type'] === 'main') {
                                            $yeniad = $info['filename'];
                                        } else {
                                            $ek_resim_adlari[$info['index']] = $info['filename'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
                // İlk 5 ürün için final kategori ID ve resim raporu
                // if ($i <= 5) {
                //     $resim_bilgi = "Ana resim: '{$yeniad}'";
                //     if (!empty($ek_resim_adlari)) {
                //         $resim_bilgi .= " | Ek resimler: " . count($ek_resim_adlari) . " adet";
                //     }
                //     file_put_contents('xml_kategori_debug.txt', "Ürün {$i}: Final kategori ID: {$katid}, Kategori adı: '{$xkategori}' | {$resim_bilgi}\n", FILE_APPEND);
                // }
                // Kategori ID kontrolü - 0 ise Genel kategorisini kullan
                if ($katid == 0) {
                    $katid = 1; // Genel kategori ID'si
                }

                // Güncelleme modu kontrolü
                if ($is_cron_update) {
                    // Ürün varlık kontrolü
                    $existing_product_id = checkProductExists($ozy, $xurunkodu, $xurunbarkodu);
                    
                    if ($existing_product_id > 0) {
                        // Ürün mevcut - güncelle
                        $product_data = [
                            'adi' => $xurunadi,
                            'seo' => $xseo,
                            'urunkodu' => $xurunkodu,
                            'urunbarkodu' => $xurunbarkodu,
                            'stok' => $xstok,
                            'fiyat' => $xfiyat,
                            'kdv' => $xkdv,
                            'aciklama' => $xaciklama,
                            'kategori' => $katid,
                            'marka' => $markaid,
                            'resim' => $yeniad
                        ];
                        
                        if (updateExistingProduct($ozy, $product_data, $existing_product_id)) {
                            $update_count++;
                            // Resimleri de güncelle
                            if (!empty($yeniad) && $yeniad != 'no-image.jpg') {
                                // Mevcut resimleri sil
                                $ozy->query("DELETE FROM tumresimler WHERE sayfaid = {$existing_product_id} AND alan = 'urunler'");
                                // Yeni resimleri ekle
                                $ozy->query("INSERT INTO tumresimler (sayfaid, sayfaresim, alan) VALUES ({$existing_product_id}, '{$yeniad}', 'urunler')");
                                foreach ($ek_resim_adlari as $resim_no => $ek_resim_adi) {
                                    $ozy->query("INSERT INTO tumresimler (sayfaid, sayfaresim, alan) VALUES ({$existing_product_id}, '{$ek_resim_adi}', 'urunler')");
                                }
                            }
                        }
                    } else {
                        // Ürün mevcut değil - yeni ekle
                        $batch_products[] = [
                            'data' => array(
                                $xurunadi,      // adi
                                $xaciklama,     // aciklama
                                $xseo,          // seo
                                '0',            // hit
                                $durum,         // durum
                                '0',            // sira
                                '0',            // seodurum
                                $xurunadi,      // stitle
                                '',             // skey
                                '',             // sdesc
                                $tarih,         // tarih
                                $yeniad,        // resim
                                $xurunkodu,     // urunkodu
                                $xurunbarkodu,  // urunbarkodu
                                $xfiyat,        // fiyat
                                '0',            // idurum
                                '0',            // ifiyat
                                $parabirimi,    // parabirimi
                                '0',            // dolar
                                '0',            // idolar
                                '0',            // euro
                                '0',            // ieuro
                                '',             // kisa
                                '',             // instagram
                                $xstok,         // stok
                                $katid,         // kategori
                                $markaid,       // marka
                                $xkdv,          // kdv
                                '0',            // agoster
                                '0',            // yeni
                                '0',            // populer
                                '0',            // coksatan
                                '0',            // firsat
                                '0',            // firsatsaat
                                '',             // filtre
                                '0',            // havaledurum
                                '0',            // hfiyat
                                '0',            // ucretsizkargo
                                '0',            // alode
                                '0',            // al
                                '0',            // ode
                                $yildiz         // yildiz
                            ),
                            'extra_images' => $ek_resim_adlari
                        ];
                    }
                } else {
                    // Normal yükleme modu - ürünü batch'e ekle
                    $batch_products[] = [
                        'data' => array(
                            $xurunadi,      // adi
                            $xaciklama,     // aciklama
                            $xseo,          // seo
                            '0',            // hit
                            $durum,         // durum
                            '0',            // sira
                            '0',            // seodurum
                            $xurunadi,      // stitle
                            '',             // skey
                            '',             // sdesc
                            $tarih,         // tarih
                            $yeniad,        // resim
                            $xurunkodu,     // urunkodu
                            $xurunbarkodu,  // urunbarkodu
                            $xfiyat,        // fiyat
                            '0',            // idurum
                            '0',            // ifiyat
                            $parabirimi,    // parabirimi
                            '0',            // dolar
                            '0',            // idolar
                            '0',            // euro
                            '0',            // ieuro
                            '',             // kisa
                            '',             // instagram
                            $xstok,         // stok
                            $katid,         // kategori
                            $markaid,       // marka
                            $xkdv,          // kdv
                            '0',            // agoster
                            '0',            // yeni
                            '0',            // populer
                            '0',            // coksatan
                            '0',            // firsat
                            '0',            // firsatsaat
                            '',             // filtre
                            '0',            // havaledurum
                            '0',            // hfiyat
                            '0',            // ucretsizkargo
                                '0',            // alode
                                '0',            // al
                                '0',            // ode
                                $yildiz         // yildiz
                        ),
                        'extra_images' => $ek_resim_adlari
                    ];
                }

                // Her ürün sonrası memory kontrol (512MB limit için)
                if ($i % 100 == 0) {
                    $memory_usage = memory_get_usage(true) / 1024 / 1024;
                    if ($memory_usage > 400) { // 400MB üzeri (512MB limit için)
                        file_put_contents('xml_worker_error.txt', "Memory yüksek: {$memory_usage}MB - Ürün {$i} - Temizleniyor...\n", FILE_APPEND);
                        gc_collect_cycles(); // Memory temizle
                        // Ekstra temizlik
                        if (function_exists('gc_mem_caches')) {
                            gc_mem_caches();
                        }
                    }
                }

                // Resimleri batch'e ekle
                if (!empty($yeniad) && $yeniad != 'no-image.jpg') {
                    $batch_images[] = [null, $yeniad, 'urunler']; // sayfaid sonra set edilecek
                }
                foreach ($ek_resim_adlari as $resim_no => $ek_resim_adi) {
                    $batch_images[] = [null, $ek_resim_adi, 'urunler']; // sayfaid sonra set edilecek
                }

                // Batch dolduğunda işle
                if (count($batch_products) >= $batch_size) {
                    try {
                        $inserted_count = processBatchProducts($ozy, $batch_products, $batch_images);
                        $success_count += $inserted_count;

                        // Progress raporu
                        $progress = round(($i / $total_products) * 100, 2);
                        $timestamp = date('Y-m-d H:i:s');
                        $memory_usage = memory_get_usage(true) / 1024 / 1024;
                        $elapsed_time = microtime(true) - $start_time;
                        $elapsed_formatted = gmdate('H:i:s', $elapsed_time);
                        $estimated_total = ($elapsed_time / $i) * $total_products;
                        $remaining_time = $estimated_total - $elapsed_time;
                        $remaining_formatted = gmdate('H:i:s', $remaining_time);

                        $concurrent_rate = $total_concurrent_downloads > 0 ? round(($successful_concurrent_downloads / $total_concurrent_downloads) * 100, 1) : 0;
                        file_put_contents('xml_progress.txt', "[{$timestamp}] Progress: {$progress}% - İşlenen: {$i}/{$total_products} - Başarılı: {$success_count} - Eş Zamanlı: {$successful_concurrent_downloads}/{$total_concurrent_downloads} ({$concurrent_rate}%) - Memory: {$memory_usage}MB - Geçen: {$elapsed_formatted} - Kalan: {$remaining_formatted}\n", FILE_APPEND);

                    } catch (Exception $e) {
                        file_put_contents('xml_worker_error.txt', "Batch işleme hatası: " . $e->getMessage() . "\n", FILE_APPEND);
                    }

                    $batch_products = [];
                    $batch_images = [];

                    // Memory temizleme
                    if (function_exists('gc_collect_cycles')) {
                        gc_collect_cycles();
                    }
                }
                $i++;
            } catch (Exception $e) {
                // Hata durumunda devam et - detaylı log
                $error_msg = "Ürün {$i} işlenirken hata: " . $e->getMessage();
                file_put_contents('xml_worker_error.txt', $error_msg . "\n", FILE_APPEND);
                $i++;
                continue;
            }
        }

        // Döngü tamamlandı log
        file_put_contents('xml_worker_error.txt', "Döngü tamamlandı. Toplam işlenen: {$i}\n", FILE_APPEND);
        
        // Güncelleme modu için XML'de olmayan ürünleri sil
        if ($is_cron_update && !empty($xml_product_codes)) {
            file_put_contents('xml_progress.txt', "XML'de olmayan ürünler kontrol ediliyor...\n", FILE_APPEND);
            
            // Bu XML kaynağından gelen tüm ürünleri bul
            $xml_codes_str = "'" . implode("','", array_unique($xml_product_codes)) . "'";
            $stmt = $ozy->prepare("SELECT id, urunkodu, urunbarkodu FROM urunler WHERE urunkodu IN ({$xml_codes_str}) OR urunbarkodu IN ({$xml_codes_str})");
            $stmt->execute();
            $existing_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // XML'de olmayan ürünleri bul ve sil
            foreach ($existing_products as $product) {
                $product_code = $product['urunkodu'];
                $product_barcode = $product['urunbarkodu'];
                
                // Bu ürün XML'de var mı kontrol et
                $in_xml = false;
                foreach ($xml->children() as $urun) {
                    $xurunkodu = (string) $urun->{$urunkodu};
                    $xurunbarkodu = (string) $urun->{$urunbarkodu};
                    
                    if (($product_code && $product_code == $xurunkodu) || 
                        ($product_barcode && $product_barcode == $xurunbarkodu)) {
                        $in_xml = true;
                        break;
                    }
                }
                
                // XML'de yoksa sil
                if (!$in_xml) {
                    if (safeDeleteProduct($ozy, $product['id'])) {
                        $delete_count++;
                        file_put_contents('xml_progress.txt', "Silinen ürün ID: {$product['id']} - Kod: {$product_code}\n", FILE_APPEND);
                    }
                }
            }
        }

        // Kalan batch'i işle
        if (!empty($batch_products)) {
            $inserted_count = processBatchProducts($ozy, $batch_products, $batch_images);
            $success_count += $inserted_count;

            // Final progress raporu
            $end_time = microtime(true);
            $end_datetime = date('Y-m-d H:i:s');
            $total_time = $end_time - $start_time;
            $total_time_formatted = gmdate('H:i:s', $total_time);
            $memory_usage = memory_get_usage(true) / 1024 / 1024;

            // Trafik ve disk kullanımı hesaplama
            $total_traffic = 0; // Toplam indirilen veri (bytes)
            $total_disk_usage = 0; // Toplam disk kullanımı (bytes)
            
            // XML dosyası boyutu
            $xml_size = strlen($xmlData);
            $total_traffic += $xml_size;
            
            // İndirilen resimlerin boyutunu hesapla
            $resim_klasoru = "../resimler/urunler";
            if (is_dir($resim_klasoru)) {
                $files = glob($resim_klasoru . "/*");
                foreach ($files as $file) {
                    if (is_file($file)) {
                        $file_size = filesize($file);
                        $file_time = filemtime($file);
                        // Sadece bu işlem sırasında oluşturulan dosyaları say
                        if ($file_time >= $start_time) {
                            $total_disk_usage += $file_size;
                        }
                    }
                }
            }
            
            // Trafik hesaplama (XML + resimler)
            $total_traffic += $total_disk_usage; // İndirilen resimler de trafik
            
            // Boyut formatı fonksiyonu
            function formatBytes($bytes, $precision = 2) {
                $units = array('B', 'KB', 'MB', 'GB', 'TB');
                for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                    $bytes /= 1024;
                }
                return round($bytes, $precision) . ' ' . $units[$i];
            }
            
            // Ortalama resim boyutu
            $avg_image_size = $successful_concurrent_downloads > 0 ? $total_disk_usage / $successful_concurrent_downloads : 0;
            
            // Trafik ve disk raporu
            $traffic_report = "\n=== TRAFİK VE DİSK KULLANIMI ===\n";
            $traffic_report .= "XML Dosya Boyutu: " . formatBytes($xml_size) . "\n";
            $traffic_report .= "İndirilen Resim Sayısı: {$successful_concurrent_downloads}\n";
            $traffic_report .= "Toplam Resim Boyutu: " . formatBytes($total_disk_usage) . "\n";
            $traffic_report .= "Ortalama Resim Boyutu: " . formatBytes($avg_image_size) . "\n";
            $traffic_report .= "Toplam Trafik (XML + Resimler): " . formatBytes($total_traffic) . "\n";
            $traffic_report .= "Disk Kullanımı: " . formatBytes($total_disk_usage) . "\n";
            $traffic_report .= "Trafik/Ürün Oranı: " . formatBytes($total_traffic / $success_count) . " (ortalama)\n";
            $traffic_report .= "===============================\n";

            $mode_text = $is_cron_update ? "GÜNCELLEME" : "YÜKLEME";
            file_put_contents('xml_progress.txt', "=== XML İŞLEME TAMAMLANDI ({$mode_text} MODU) ===\n", FILE_APPEND);
            file_put_contents('xml_progress.txt', "Bitiş Zamanı: {$end_datetime}\n", FILE_APPEND);
            file_put_contents('xml_progress.txt', "Toplam Süre: {$total_time_formatted}\n", FILE_APPEND);
            file_put_contents('xml_progress.txt', "Toplam İşlenen: {$i}/{$total_products}\n", FILE_APPEND);
            
            if ($is_cron_update) {
                file_put_contents('xml_progress.txt', "Güncellenen Ürün: {$update_count}\n", FILE_APPEND);
                file_put_contents('xml_progress.txt', "Yeni Eklenen Ürün: {$success_count}\n", FILE_APPEND);
                file_put_contents('xml_progress.txt', "Silinen Ürün: {$delete_count}\n", FILE_APPEND);
                file_put_contents('xml_progress.txt', "Toplam İşlem: " . ($update_count + $success_count + $delete_count) . "\n", FILE_APPEND);
            } else {
                file_put_contents('xml_progress.txt', "Başarılı Ürün: {$success_count}\n", FILE_APPEND);
                file_put_contents('xml_progress.txt', "Başarı Oranı: " . round(($success_count / $total_products) * 100, 2) . "%\n", FILE_APPEND);
            }
            
            file_put_contents('xml_progress.txt', "Ortalama Hız: " . round($total_products / ($total_time / 60), 2) . " ürün/dakika\n", FILE_APPEND);
            file_put_contents('xml_progress.txt', "Eş Zamanlı İndirme: {$successful_concurrent_downloads}/{$total_concurrent_downloads} resim\n", FILE_APPEND);
            if ($total_concurrent_downloads > 0) {
                $concurrent_success_rate = round(($successful_concurrent_downloads / $total_concurrent_downloads) * 100, 2);
                file_put_contents('xml_progress.txt', "Eş Zamanlı Başarı Oranı: {$concurrent_success_rate}%\n", FILE_APPEND);
            }
            file_put_contents('xml_progress.txt', "Final Memory: {$memory_usage}MB\n", FILE_APPEND);
            file_put_contents('xml_progress.txt', $traffic_report, FILE_APPEND);
            file_put_contents('xml_progress.txt', "============================\n", FILE_APPEND);
            
            // Trafik verisini veritabanına kaydet
            $traffic_data = [
                'islem' => $is_cron_update ? "XML Güncelleme (ID: {$xml_id})" : "XML Yükleme (ID: {$xml_id})",
                'kullanim' => round($total_traffic / 1024 / 1024, 2), // MB cinsinden
                'tarih' => date('Y-m-d')
            ];
            
            if (saveTrafficData($ozy, $traffic_data['islem'], $traffic_data['kullanim'], $traffic_data['tarih'])) {
                file_put_contents('xml_progress.txt', "Trafik verisi kaydedildi: {$traffic_data['kullanim']} MB\n", FILE_APPEND);
            } else {
                file_put_contents('xml_progress.txt', "Trafik verisi kaydedilemedi!\n", FILE_APPEND);
            }
        }

        // Tüm kategorilerin ac değerlerini güncelle
        $ozy->query("UPDATE kategoriler SET ac = '1' WHERE id IN (SELECT DISTINCT ustkat FROM kategoriler WHERE ustkat > 0)");
    } catch (Exception $e) {
        // JSON output yapmıyoruz çünkü connection zaten kapatıldı
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz XML ID']);
}
