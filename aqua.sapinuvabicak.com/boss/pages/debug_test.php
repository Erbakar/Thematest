<?php
// Hata ayıklama test sayfası
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

echo "Debug test sayfası çalışıyor<br>";

try {
    require('../func/db.php');
    echo "DB dosyası yüklendi<br>";
    
    if (isset($ozy)) {
        echo "DB bağlantısı mevcut<br>";
        
        // Veritabanı bağlantısını test et
        try {
            $test = $ozy->query("SELECT 1")->fetch();
            echo "DB sorgusu başarılı<br>";
        } catch (Exception $e) {
            echo "DB sorgu hatası: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "DB bağlantısı yok!<br>";
    }
} catch (Exception $e) {
    echo "DB hatası: " . $e->getMessage() . "<br>";
}

try {
    require('../func/fonksiyon.php');
    echo "Fonksiyon dosyası yüklendi<br>";
    
    if (function_exists('admin_yetki')) {
        echo "admin_yetki fonksiyonu mevcut<br>";
    } else {
        echo "admin_yetki fonksiyonu yok!<br>";
    }
    
    if (function_exists('temizle')) {
        echo "temizle fonksiyonu mevcut<br>";
    } else {
        echo "temizle fonksiyonu yok!<br>";
    }
    
} catch (Exception $e) {
    echo "Fonksiyon hatası: " . $e->getMessage() . "<br>";
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
    echo "Session başlatıldı<br>";
}

echo "Session giriş: " . (isset($_SESSION["giris"]) ? "var" : "yok") . "<br>";
echo "Session departmanid: " . (isset($_SESSION['departmanid']) ? $_SESSION['departmanid'] : "yok") . "<br>";

echo "Test tamamlandı<br>";
?>
