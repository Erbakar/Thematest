<?php
require('../../func/db.php');

// AJAX kontrolü
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    http_response_code(403);
    exit('Direct access not allowed');
}

header('Content-Type: application/json');

try {
    // Destek merkezi sayısı
    $destek_sayisi = $ozy->query("SELECT COUNT(*) as toplam FROM destek WHERE durum = 0")->fetch(PDO::FETCH_ASSOC)['toplam'];
    
    // Ürün yorumları sayısı
    $urun_yorum_sayisi = $ozy->query("SELECT COUNT(*) as toplam FROM yorumlar WHERE durum = 0")->fetch(PDO::FETCH_ASSOC)['toplam'];
    
    // Blog yorumları sayısı
    $blog_yorum_sayisi = $ozy->query("SELECT COUNT(*) as toplam FROM blog_yorumlar WHERE durum = 0")->fetch(PDO::FETCH_ASSOC)['toplam'];
    
    // Gelen kutusu sayısı
    $mesaj_sayisi = $ozy->query("SELECT COUNT(*) as toplam FROM iletisim WHERE durum = 0")->fetch(PDO::FETCH_ASSOC)['toplam'];
    
    $toplam_iletisim = $destek_sayisi + $urun_yorum_sayisi + $blog_yorum_sayisi + $mesaj_sayisi;
    
    // Ana menü ikonu - herhangi biri varsa kırmızı
    $ana_menu_icon = $toplam_iletisim > 0 ? "<i class='mdi mdi-circle text-danger blinking-circle'></i>" : '';

    echo json_encode([
        'success' => true,
        'count' => $toplam_iletisim,
        'html' => $toplam_iletisim > 0 ? $ana_menu_icon . "İletişim Merkezi" : "İletişim Merkezi",
        'alt_menuler' => [
            'destek_merkezi' => [
                'count' => $destek_sayisi,
                'html' => $destek_sayisi > 0 ? "<i class='mdi mdi-circle text-danger blinking-circle'></i>Destek Merkezi" : "Destek Merkezi"
            ],
            'urun_yorumlari' => [
                'count' => $urun_yorum_sayisi,
                'html' => $urun_yorum_sayisi > 0 ? "<i class='mdi mdi-circle text-danger blinking-circle'></i>Ürün Yorumları" : "Ürün Yorumları"
            ],
            'blog_yorumlari' => [
                'count' => $blog_yorum_sayisi,
                'html' => $blog_yorum_sayisi > 0 ? "<i class='mdi mdi-circle text-danger blinking-circle'></i>Blog Yorumları" : "Blog Yorumları"
            ],
            'gelen_kutusu' => [
                'count' => $mesaj_sayisi,
                'html' => $mesaj_sayisi > 0 ? "<i class='mdi mdi-circle text-danger blinking-circle'></i>Gelen Kutusu" : "Gelen Kutusu"
            ]
        ]
    ]);
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
