<?php
define("guvenlik", true);
require('../../func/db.php');
require('../../func/fonksiyon.php');

// Session kontrolü
if (!isset($_SESSION['kullaniciadi']) || !isset($_SESSION['sifre'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Oturum süresi dolmuş.']);
    exit;
}

header('Content-Type: application/json');

// İşlem durumu kontrolü
if (isset($_POST['check_status']) && $_POST['check_status'] == '1') {
    $progressFile = 'xml_progress.txt';
    
    if (file_exists($progressFile)) {
        $progressContent = file_get_contents($progressFile);
        $progressData = explode('|', $progressContent);
        
        $progressValue = isset($progressData[0]) ? trim($progressData[0]) : '0';
        $progressMessage = isset($progressData[1]) ? trim($progressData[1]) : 'İşlem bekleniyor...';
        
        $isProcessing = ($progressValue !== 'done' && $progressValue !== 'error' && $progressValue !== '');
        
        echo json_encode([
            'success' => true,
            'data' => [
                'is_processing' => $isProcessing,
                'progress' => $progressValue . '|' . $progressMessage,
                'message' => $progressMessage
            ]
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'data' => [
                'is_processing' => false,
                'progress' => '0|İşlem bulunamadı',
                'message' => 'İşlem bulunamadı'
            ]
        ]);
    }
    exit;
}

// XML işlemi başlatma
if (isset($_POST['start_process']) && isset($_POST['xml_id'])) {
    $xml_id = intval($_POST['xml_id']);
    
    if ($xml_id > 0) {
        // XML worker'ı başlat (arkaplanda)
        $workerUrl = $_SERVER['HTTP_HOST'] . '/boss/pages/xml_worker.php?xml_id=' . $xml_id;
        
        // Background process olarak başlat
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://' . $workerUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_exec($ch);
        curl_close($ch);
        
        echo json_encode([
            'success' => true,
            'message' => 'XML işlemi başlatıldı'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Geçersiz XML ID'
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Geçersiz istek'
]);
