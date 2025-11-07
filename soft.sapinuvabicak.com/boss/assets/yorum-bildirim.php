<?php
require('../../func/db.php');

// AJAX kontrolü
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    http_response_code(403);
    exit('Direct access not allowed');
}

header('Content-Type: application/json');

try {
    // Cevaplanmayan ürün yorumları
    $stmt_urun = $ozy->prepare("SELECT COUNT(*) as toplam FROM tumyorumlar WHERE (durum = '' OR durum IS NULL OR durum = '0') AND konu = 'urunler'");
    $stmt_urun->execute();
    $urun_yorumlar = $stmt_urun->fetch(PDO::FETCH_ASSOC);
    
    // Cevaplanmayan blog yorumları
    $stmt_blog = $ozy->prepare("SELECT COUNT(*) as toplam FROM tumyorumlar WHERE (durum = '' OR durum IS NULL OR durum = '0') AND konu = 'blog'");
    $stmt_blog->execute();
    $blog_yorumlar = $stmt_blog->fetch(PDO::FETCH_ASSOC);
    
    // Cevaplanmamış destek talepleri (durum 0: okunmadı, 1: okundu, 2: cevaplandı, 3: kapatıldı)
    // Sadece durum 0 ve 1 olanlar cevaplanmamış sayılır
    $stmt_destek = $ozy->prepare("SELECT COUNT(*) as toplam FROM support WHERE durum IN (0, 1)");
    $stmt_destek->execute();
    $destek_talepleri = $stmt_destek->fetch(PDO::FETCH_ASSOC);
    
    // Okunmamış mesajlar (durum 0: okunmadı)
    $stmt_mesaj = $ozy->prepare("SELECT COUNT(*) as toplam FROM iletisim WHERE durum = 0");
    $stmt_mesaj->execute();
    $gelen_mesajlar = $stmt_mesaj->fetch(PDO::FETCH_ASSOC);
    
    // Toplam cevaplanmayan/okunmamış
    $toplam_cevaplanmayan = $urun_yorumlar['toplam'] + $blog_yorumlar['toplam'] + $destek_talepleri['toplam'] + $gelen_mesajlar['toplam'];
    
    // Bildirim ikonu belirleme
    $bildirim_icon = '';
    if ($toplam_cevaplanmayan > 0) {
        $bildirim_icon = "<i class='mdi mdi-circle text-danger blinking-circle'></i>";
    }
    
    echo json_encode([
        'success' => true,
        'toplam_count' => $toplam_cevaplanmayan,
        'urun_count' => $urun_yorumlar['toplam'],
        'blog_count' => $blog_yorumlar['toplam'],
        'destek_count' => $destek_talepleri['toplam'],
        'mesaj_count' => $gelen_mesajlar['toplam'],
        'html' => $toplam_cevaplanmayan > 0 ? $bildirim_icon . "İletişim Merkezi" : "İletişim Merkezi",
        'alt_menuler' => [
            'urun_yorumlari' => [
                'count' => $urun_yorumlar['toplam'],
                'html' => $urun_yorumlar['toplam'] > 0 ? "<i class='mdi mdi-circle text-danger blinking-circle'></i>Ürün Yorumları" : "Ürün Yorumları"
            ],
            'blog_yorumlari' => [
                'count' => $blog_yorumlar['toplam'],
                'html' => $blog_yorumlar['toplam'] > 0 ? "<i class='mdi mdi-circle text-danger blinking-circle'></i>Blog Yorumları" : "Blog Yorumları"
            ],
            'destek_merkezi' => [
                'count' => $destek_talepleri['toplam'],
                'html' => $destek_talepleri['toplam'] > 0 ? "<i class='mdi mdi-circle text-warning blinking-circle'></i>Destek Merkezi" : "Destek Merkezi"
            ],
            'gelen_kutusu' => [
                'count' => $gelen_mesajlar['toplam'],
                'html' => $gelen_mesajlar['toplam'] > 0 ? "<i class='mdi mdi-circle text-info blinking-circle'></i>Gelen Kutusu" : "Gelen Kutusu"
            ]
        ]
    ]);
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
