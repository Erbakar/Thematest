<?php
$cpanelUser = 'sapinuvabicak';
$apiToken = 'EP19G845I171S4ZI9L2QS5WP29BJ0ZN7';
$cpanelDomain = 'sapinuvabicak.com';

// Fonksiyon: cPanel API çağrısı yapmak için
function makeApiCall($endpoint, $params = []) {
    global $cpanelUser, $apiToken, $cpanelDomain;
    
    $url = "https://$cpanelDomain:2083/execute/$endpoint";
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: cpanel $cpanelUser:$apiToken"
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Mail hesaplarını al
$mailList = makeApiCall('Email/list_pops', ['api.version' => 1]);

// Mail hesaplarını listele

if (isset($mailList['status']) && $mailList['status'] == 1 && !empty($mailList['data'])) {
    echo "<h2>Tüm Mail Hesapları</h2>";
    echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
    echo "<tr><th>E-posta</th><th>Quota (MB)</th><th>Kullanım (MB)</th><th>Durum</th></tr>";

    foreach ($mailList['data'] as $mail) {
        if ($mail['email'] != $cpanelUser) {
            $status = ($mail['suspended_login'] || $mail['suspended_incoming']) ? "Askıya Alınmış" : "Aktif";
            
            $email = $mail['email'];
            
            // Mail hesabı için kota bilgisi al
            $quotaInfo = makeApiCall('Email/get_pop_quota', [
                'api.version' => 1,
                'email' => $email
            ]);
            
            // Disk kullanım bilgisi al
            $emailParts = explode('@', $email);
            $domain = isset($emailParts[1]) ? $emailParts[1] : $cpanelDomain;
            $username = isset($emailParts[0]) ? $emailParts[0] : $email;
            
            $diskInfo = makeApiCall('Email/get_disk_usage', [
                'api.version' => 1,
                'user' => $username,
                'domain' => $domain
            ]);
            
            // Kota bilgisini formatla
            $quota = 'Bilinmiyor';
            if (isset($quotaInfo['data']) && $quotaInfo['status'] == 1) {
                if (is_numeric($quotaInfo['data'])) {
                    $quota = $quotaInfo['data'] . ' MB';
                } else {
                    $quota = $quotaInfo['data']; // unlimited gibi
                }
            }
            
            // Disk kullanım bilgisini formatla
            $diskused = 'Bilinmiyor';
            if (isset($diskInfo['data']['diskused']) && $diskInfo['status'] == 1) {
                $diskusedMB = round($diskInfo['data']['diskused'], 2);
                $diskused = $diskusedMB . ' MB';
            }
            
            echo "<tr>";
            echo "<td>$email</td>";
            echo "<td>$quota</td>";
            echo "<td>$diskused</td>";
            echo "<td>$status</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
} else {
    echo "Mail hesapları alınamadı<br>";
    echo "Hata: " . json_encode($mailList['errors']);
}
?>