<?php
/**
 * XML Worker Cron Job Örneği
 * 
 * Bu dosya, XML worker'ı cron job olarak çalıştırmak için örnek bir dosyadır.
 * 
 * Kullanım:
 * 1. Bu dosyayı sunucunuzda uygun bir konuma kopyalayın
 * 2. Cron job'ı şu şekilde ayarlayın:
 *    # Her 30 dakikada bir XML'leri güncelle
 *   
 * 
 * 3. Veya curl ile:
 *    curl "https://yoursite.com/boss/pages/xml_worker.php?cron=1&token=xml_cron_2024_secure"
 */

// Cron job için XML worker'ı çağır
$xml_worker_url = 'https://plus.sapinuvabicak.com/boss/pages/xml_worker.php';
$cron_token = 'xml_cron_2024_secure';

// Tüm XML'leri güncelle
$url = $xml_worker_url . '?cron=1&token=' . $cron_token;

// cURL ile çağır
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 300); // 5 dakika timeout
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'XML-Cron-Job/1.0');

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// Sonucu logla
$log_message = date('Y-m-d H:i:s') . " - XML Cron Job - HTTP: {$http_code}";
if ($error) {
    $log_message .= " - Error: {$error}";
} else {
    $log_message .= " - Response: {$response}";
}

// Log dosyasına yaz
file_put_contents('xml_cron.log', $log_message . "\n", FILE_APPEND);

// Konsola da yazdır (cron job logları için)
echo $log_message . "\n";

// HTTP 200 ise başarılı
if ($http_code == 200) {
    echo "XML Cron Job başarıyla tamamlandı.\n";
    exit(0);
} else {
    echo "XML Cron Job hatası. HTTP Code: {$http_code}\n";
    exit(1);
}
?>
