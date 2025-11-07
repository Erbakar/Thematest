<?php
include '../../func/db.php';

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $urun = $ozy->prepare("SELECT * FROM urunler WHERE id = ?");
    $urun->execute([$id]);
    $urun = $urun->fetch(PDO::FETCH_ASSOC);

    $urun2 = $ozy->prepare("SELECT * FROM kategoriler WHERE id = ?");
    $urun2->execute([$urun['kategori']]);
    $urun2 = $urun2->fetch(PDO::FETCH_ASSOC);

    if ($urun['parabirimi'] == 0 || $urun['parabirimi'] == '') {
        $parabirim = '₺';
    } else {
        $parabirim = $urun['parabirimi'];
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'kategori' => $urun2['adi'],
        'stok' => number_format($urun['stok'], 0, ',', '.'),
        'resim' => $urun['resim'],
        'urunbarkodu' => $urun['urunbarkodu'],
        'satisfiyati' => str_replace('.', ',', $urun['fiyat']),
        'parabirim' => $parabirim
    ]);

}
?>