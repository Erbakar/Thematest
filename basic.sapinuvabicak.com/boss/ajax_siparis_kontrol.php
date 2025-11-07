<?php

$siparisler = $ozy->query("SELECT COUNT(*) as adet FROM siparis WHERE durum != 'Sipariş Tamamlandı'")->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'adet' => $siparisler['adet']
]);

?>