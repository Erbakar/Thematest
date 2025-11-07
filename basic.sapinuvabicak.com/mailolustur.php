<?php




$cpanelDomain = 'sapinuvabicak.com';
$apiToken = 'EP19G845I171S4ZI9L2QS5WP29BJ0ZN7';

$emailUser = 'test4';
$emailPassword = 'adfe½#$wersdf457';
$emailDomain = 'sapinuvabicak.com';
$emailQuota = 100;

$url = "https://$cpanelDomain:2083/execute/Email/add_pop";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: cpanel sapinuvabicak:$apiToken"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'email' => $emailUser,
    'password' => $emailPassword,
    'domain' => $emailDomain,
    'quota' => $emailQuota
]));

$response = curl_exec($ch); 

$response = json_decode($response, true);
echo $response['status'] . "<br>"; 
 
curl_close($ch);
