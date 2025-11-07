<?php
require('../../func/db.php');
header('Content-Type: application/json');

$stmt = $ozy->prepare("SELECT COUNT(*) as toplam FROM siparis WHERE durum IN ('Ödeme Bekleniyor', 'Sipariş Onaylandı', 'Sipariş Hazırlandı', 'Kargoya Verildi')");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'count' => $result['toplam']]);
?>
