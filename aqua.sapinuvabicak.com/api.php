<?php
require('func/db.php');
require('func/fonksiyon.php');
require('func/boyut.php');
require('func/trafik.php');

$klasorler = [
    "resimler"
];



$token = isset($_GET['token']) ? $_GET['token'] : null;

$stmt = $ozy->prepare("SELECT token FROM system WHERE id=1");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && $token === $row['token']) {
    $stmt = $ozy->prepare("SELECT COUNT(*) as urunsayisi FROM urunler");
    $stmt->execute();
    $urunsayisi = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $urunsayisi['urunsayisi'];
}

echo ",";

function makeApiCall($endpoint, $params = [])
{
    global $ozy;
    global $ayar;
    global $ayar2;

    $ayar = $ozy->query("select * from siteayarlari where id=1")->fetch(PDO::FETCH_ASSOC);
    $ayar2 = $ozy->query("select * from system where id=1")->fetch(PDO::FETCH_ASSOC);

    $url = $ayar['alanadi'];
    $apiToken = $ayar2['apiToken'];

    $cpanelUser = $ayar['kullanici'];


    $apiUrl = "https://$url:2083/execute/$endpoint";
    if (!empty($params)) {
        $apiUrl .= '?' . http_build_query($params);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: cpanel $cpanelUser:$apiToken"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
 

$mailList = makeApiCall('Email/list_pops', ['api.version' => 1]);

$currentEmailCount = 0;
if (isset($mailList['status']) && $mailList['status'] == 1 && !empty($mailList['data'])) { 
    foreach ($mailList['data'] as $mail) { 
        if ($mail['email'] != $ayar['kullanici']) {
            $currentEmailCount++;
        }
    }
} 

echo $currentEmailCount;

echo ",";

echo HamSitedepolama2();

echo ",";

echo Trafik2();
