<?php
$year = date("Y"); 

// Veritabanından trafik verilerini al
try {
    require_once('db.php');
    
    // Bu yıl için AWStats trafik verilerini topla
    $stmt = $ozy->prepare("SELECT SUM(kullanim) as total_awstats_traffic FROM trafik WHERE YEAR(tarih) = ? AND islem LIKE 'AWStats%'");
    $stmt->execute([$year]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $awstats_traffic_total = 0;
    if ($result && $result['total_awstats_traffic']) {
        $awstats_traffic_total = $result['total_awstats_traffic'] * 1024 * 1024; // MB'yi byte'a çevir
    }
    
    // Bu yıl için XML trafik verilerini topla
    $stmt = $ozy->prepare("SELECT SUM(kullanim) as total_xml_traffic FROM trafik WHERE YEAR(tarih) = ? AND islem LIKE 'XML%'");
    $stmt->execute([$year]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $xml_traffic_total = 0;
    if ($result && $result['total_xml_traffic']) {
        $xml_traffic_total = $result['total_xml_traffic'] * 1024 * 1024; // MB'yi byte'a çevir
    }
    
    // Toplam trafiği hesapla (AWStats + XML)
    $total_traffic = $awstats_traffic_total + $xml_traffic_total;
    
} catch (Exception $e) {
    // Veritabanı hatası durumunda sıfır değerler
    $awstats_traffic_total = 0;
    $xml_traffic_total = 0;
    $total_traffic = 0;
}
  
function formatBytesGB($bytes, $precision = 2) {
    $bytes = max($bytes, 0);
    $bytes /= 1024; 
    $bytes /= 1024; 
    $bytes /= 1024; 
    return round($bytes, $precision) . ' GB';
}
 
function formatBytesGB2($bytes, $precision = 2) {
    $bytes = max($bytes, 0);
    $bytes /= 1024; 
    $bytes /= 1024; 
    return round($bytes, $precision);
}

function Trafik() {
    global $total_traffic;
    return formatBytesGB($total_traffic);
}
 
function Trafik2() {
    global $total_traffic;
    return formatBytesGB2($total_traffic);
}

// Sadece AWStats trafiği için
function TrafikAWStats() {
    global $awstats_traffic_total;
    return formatBytesGB($awstats_traffic_total);
}

// Sadece XML trafiği için
function TrafikXML() {
    global $xml_traffic_total;
    return formatBytesGB($xml_traffic_total);
}

// Detaylı trafik bilgisi
function TrafikDetay() {
    global $awstats_traffic_total, $xml_traffic_total, $total_traffic;
    
    $awstats_gb = formatBytesGB2($awstats_traffic_total);
    $xml_gb = formatBytesGB2($xml_traffic_total);
    $total_gb = formatBytesGB2($total_traffic);
    
    return [
        'awstats' => $awstats_gb,
        'xml' => $xml_gb,
        'total' => $total_gb,
        'awstats_formatted' => formatBytesGB($awstats_traffic_total),
        'xml_formatted' => formatBytesGB($xml_traffic_total),
        'total_formatted' => formatBytesGB($total_traffic),
        'data_source' => 'Veritabanı (Cron Job)'
    ];
}

// Aylık trafik raporu
function TrafikAylik($ay = null, $yil = null) {
    global $ozy;
    
    if ($ay === null) $ay = date('m');
    if ($yil === null) $yil = date('Y');
    
    try {
        // AWStats aylık trafiği
        $stmt = $ozy->prepare("SELECT SUM(kullanim) as awstats_traffic FROM trafik WHERE YEAR(tarih) = ? AND MONTH(tarih) = ? AND islem LIKE 'AWStats%'");
        $stmt->execute([$yil, $ay]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $awstats_monthly = $result['awstats_traffic'] ? $result['awstats_traffic'] * 1024 * 1024 : 0;
        
        // XML aylık trafiği
        $stmt = $ozy->prepare("SELECT SUM(kullanim) as xml_traffic FROM trafik WHERE YEAR(tarih) = ? AND MONTH(tarih) = ? AND islem LIKE 'XML%'");
        $stmt->execute([$yil, $ay]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $xml_monthly = $result['xml_traffic'] ? $result['xml_traffic'] * 1024 * 1024 : 0;
        
        $total_monthly = $awstats_monthly + $xml_monthly;
        
        return [
            'awstats' => formatBytesGB2($awstats_monthly),
            'xml' => formatBytesGB2($xml_monthly),
            'total' => formatBytesGB2($total_monthly),
            'awstats_formatted' => formatBytesGB($awstats_monthly),
            'xml_formatted' => formatBytesGB($xml_monthly),
            'total_formatted' => formatBytesGB($total_monthly),
            'month' => $ay,
            'year' => $yil
        ];
        
    } catch (Exception $e) {
        return [
            'awstats' => 0,
            'xml' => 0,
            'total' => 0,
            'awstats_formatted' => '0 GB',
            'xml_formatted' => '0 GB',
            'total_formatted' => '0 GB',
            'month' => $ay,
            'year' => $yil,
            'error' => $e->getMessage()
        ];
    }
}

// Günlük trafik raporu
function TrafikGunluk($gun = null, $ay = null, $yil = null) {
    global $ozy;
    
    if ($gun === null) $gun = date('d');
    if ($ay === null) $ay = date('m');
    if ($yil === null) $yil = date('Y');
    
    $tarih = "{$yil}-{$ay}-{$gun}";
    
    try {
        // AWStats günlük trafiği
        $stmt = $ozy->prepare("SELECT SUM(kullanim) as awstats_traffic FROM trafik WHERE tarih = ? AND islem LIKE 'AWStats%'");
        $stmt->execute([$tarih]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $awstats_daily = $result['awstats_traffic'] ? $result['awstats_traffic'] * 1024 * 1024 : 0;
        
        // XML günlük trafiği
        $stmt = $ozy->prepare("SELECT SUM(kullanim) as xml_traffic FROM trafik WHERE tarih = ? AND islem LIKE 'XML%'");
        $stmt->execute([$tarih]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $xml_daily = $result['xml_traffic'] ? $result['xml_traffic'] * 1024 * 1024 : 0;
        
        $total_daily = $awstats_daily + $xml_daily;
        
        return [
            'awstats' => formatBytesGB2($awstats_daily),
            'xml' => formatBytesGB2($xml_daily),
            'total' => formatBytesGB2($total_daily),
            'awstats_formatted' => formatBytesGB($awstats_daily),
            'xml_formatted' => formatBytesGB($xml_daily),
            'total_formatted' => formatBytesGB($total_daily),
            'date' => $tarih
        ];
        
    } catch (Exception $e) {
        return [
            'awstats' => 0,
            'xml' => 0,
            'total' => 0,
            'awstats_formatted' => '0 GB',
            'xml_formatted' => '0 GB',
            'total_formatted' => '0 GB',
            'date' => $tarih,
            'error' => $e->getMessage()
        ];
    }
}
 
?>