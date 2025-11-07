<?php
require('func/db.php');

try {
    $insert = $ozy->prepare('INSERT INTO menu (paketadi, menuadi, link, icon, ustmenu, sira, durum) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $result = $insert->execute(array('enterprise', 'Menü Yetki Yönetimi', 'menu-yetki-yonetimi', 'mdi mdi-shield-account', 0, 99, 1));
    
    if ($result) {
        echo 'Menü başarıyla eklendi!';
    } else {
        echo 'Hata: ' . print_r($ozy->errorInfo(), true);
    }
} catch (Exception $e) {
    echo 'Hata: ' . $e->getMessage();
}
?>
