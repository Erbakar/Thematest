<?php
require('../../func/db.php');

// AJAX kontrolü
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    http_response_code(403);
    exit('Direct access not allowed');
}

header('Content-Type: application/json');

try {
    // Ana sipariş sayısı
    $stmt = $ozy->prepare("SELECT COUNT(*) as toplam FROM siparis WHERE durum IN ('Ödeme Bekleniyor', 'Sipariş Onaylandı', 'Sipariş Hazırlandı', 'Kargoya Verildi')");
    $stmt->execute();
    $siparis = $stmt->fetch(PDO::FETCH_ASSOC);
    $toplam = $siparis['toplam'];
    
    // Alt menü sayıları
    $stmt2 = $ozy->prepare("SELECT COUNT(*) as toplam FROM siparis WHERE durum IN ('Ödeme Bekleniyor', 'Sipariş Onaylandı')");
    $stmt2->execute();
    $yeni = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    $stmt3 = $ozy->prepare("SELECT COUNT(*) as toplam FROM siparis WHERE durum = 'Sipariş Hazırlandı'");
    $stmt3->execute();
    $hazirlanan = $stmt3->fetch(PDO::FETCH_ASSOC);
    
    $stmt4 = $ozy->prepare("SELECT COUNT(*) as toplam FROM siparis WHERE durum = 'Kargoya Verildi'");
    $stmt4->execute();
    $kargolanan = $stmt4->fetch(PDO::FETCH_ASSOC);
    
    // Ana menü renk önceliği: hazırlanan > yeni > kargolanan
    $ana_menu_icon = '';
    if ($hazirlanan['toplam'] > 0) {
        $ana_menu_icon = "<i class='mdi mdi-circle text-warning blinking-circle'></i>";
    } elseif ($yeni['toplam'] > 0) {
        $ana_menu_icon = "<i class='mdi mdi-circle text-success blinking-circle'></i>";
    } elseif ($kargolanan['toplam'] > 0) {
        $ana_menu_icon = "<i class='mdi mdi-circle text-info blinking-circle'></i>";
    }

    echo json_encode([
        'success' => true,
        'count' => $toplam,
        'html' => $toplam > 0 ? $ana_menu_icon . "Siparişlerim" : "Siparişlerim",
        'alt_menuler' => [
            'yeni_siparisler' => [
                'count' => $yeni['toplam'],
                'html' => $yeni['toplam'] > 0 ? "<i class='mdi mdi-circle text-success blinking-circle'></i>Yeni Siparişler" : "Yeni Siparişler"
            ],
            'hazirlanan_siparisler' => [
                'count' => $hazirlanan['toplam'],
                'html' => $hazirlanan['toplam'] > 0 ? "<i class='mdi mdi-circle text-warning blinking-circle'></i>Hazırlanan Siparişler" : "Hazırlanan Siparişler"
            ],
            'kargolanan_siparisler' => [
                'count' => $kargolanan['toplam'],
                'html' => $kargolanan['toplam'] > 0 ? "<i class='mdi mdi-circle text-info blinking-circle'></i>Kargolanan Siparişler" : "Kargolanan Siparişler"
            ]
        ]
    ]);
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>