<?php
define("guvenlik", true);
require('../func/db.php');
require('../func/fonksiyon.php');

// Cron job güvenlik kontrolü
$allowed_ips = ['127.0.0.1', '::1', 'localhost'];
$client_ip = $_SERVER['REMOTE_ADDR'] ?? '';

// IP kontrolü
if (!in_array($client_ip, $allowed_ips)) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Cron job sadece localhost\'tan çalıştırılabilir.']);
    exit;
}

// Token kontrolü
$cron_token = $_GET['token'] ?? '';
$expected_token = 'awstats_cron_2024_secure'; // Bu token'ı değiştirin

if ($cron_token !== $expected_token) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz cron token.']);
    exit;
}

// AWStats verilerini trafik tablosuna kaydetme fonksiyonu
function saveAWStatsToDatabase($ozy) {
    $year = date("Y");
    $domain = $_SERVER['SERVER_NAME'];
    $user_info = posix_getpwuid(posix_geteuid());
    $cpanel_user = $user_info['name'];
    
    $path_normal = "/home/{$cpanel_user}/tmp/awstats/";
    $path_ssl = "/home/{$cpanel_user}/tmp/awstats/ssl/";
    
    $total_traffic = 0;
    $paths = [$path_normal, $path_ssl];
    
    // Bugünün tarihi
    $today = date('Y-m-d');
    
    // Bugün için zaten kayıt var mı kontrol et
    $stmt = $ozy->prepare("SELECT id FROM trafik WHERE tarih = ? AND islem LIKE 'AWStats%'");
    $stmt->execute([$today]);
    if ($stmt->fetch()) {
        return ['success' => true, 'message' => 'Bugün için AWStats verisi zaten kayıtlı'];
    }
    
    // AWStats dosyalarından veri oku
    foreach ($paths as $path) {
        for ($month = 1; $month <= 12; $month++) {
            $month_str = str_pad($month, 2, "0", STR_PAD_LEFT);
            $file = "{$path}awstats{$month_str}{$year}.{$domain}.txt";
            
            if (!file_exists($file)) continue;
            
            $content = file_get_contents($file);
            
            if (preg_match("/BEGIN_DAY(.*?)END_DAY/s", $content, $match)) {
                $lines = explode("\n", trim($match[1]));
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line) || strpos($line, "#") === 0) continue;
                    
                    $parts = preg_split('/\s+/', $line);
                    if (count($parts) >= 5) {
                        $day = $parts[0];
                        $month_num = $parts[1];
                        $year_num = $parts[2];
                        $traffic_bytes = (int)$parts[4];
                        
                        // Sadece bugünün verisini al
                        $file_date = "{$year_num}-{$month_num}-{$day}";
                        if ($file_date === $today) {
                            $total_traffic += $traffic_bytes;
                        }
                    }
                }
            }
        }
    }
    
    // Trafiği MB'ye çevir
    $traffic_mb = round($total_traffic / (1024 * 1024), 2);
    
    // Veritabanına kaydet
    if ($total_traffic > 0) {
        $islem_adi = "AWStats - {$domain} - " . date('d.m.Y');
        $stmt = $ozy->prepare("INSERT INTO trafik (islem, kullanim, tarih) VALUES (?, ?, ?)");
        $result = $stmt->execute([$islem_adi, $traffic_mb, $today]);
        
        if ($result) {
            return [
                'success' => true, 
                'message' => "AWStats verisi kaydedildi: {$traffic_mb} MB",
                'traffic_mb' => $traffic_mb
            ];
        } else {
            return [
                'success' => false, 
                'message' => 'Veritabanına kayıt hatası: ' . json_encode($stmt->errorInfo())
            ];
        }
    } else {
        return [
            'success' => true, 
            'message' => 'Bugün için AWStats verisi bulunamadı veya 0 MB'
        ];
    }
}

// Ana işlem
try {
    $result = saveAWStatsToDatabase($ozy);
    
    // Log dosyasına yaz
    $log_message = "[" . date('Y-m-d H:i:s') . "] AWStats Cron: " . $result['message'] . "\n";
    file_put_contents('awstats_cron_log.txt', $log_message, FILE_APPEND);
    
    // JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
    
} catch (Exception $e) {
    $error_message = "AWStats cron hatası: " . $e->getMessage();
    file_put_contents('awstats_cron_log.txt', "[" . date('Y-m-d H:i:s') . "] ERROR: {$error_message}\n", FILE_APPEND);
    
    http_response_code(500);
    echo json_encode([
        'status' => 'error', 
        'message' => $error_message
    ]);
}
?>
