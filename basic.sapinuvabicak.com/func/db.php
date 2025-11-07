<?php 
ob_start(); 
ini_set("display_errors", 0);
session_start();
$php_ver = substr(phpversion(),0,3);

if($php_ver != '7.2'){
die("Yazılımın stabil çalışma versiyonu 7.2'dir. Lütfen php versiyonunuzu 7.2'ye yükseltin.");
}
define('DB_DRIVER', 'mysql');
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'sapinuvabicak_kbasic');
define('DB_SERVER_PASSWORD', '!FMV&e_{bekj');
define('DB_DATABASE', 'sapinuvabicak_basic');

date_default_timezone_set('Europe/Istanbul'); 

$dboptions = array(
    PDO::ATTR_PERSISTENT => FALSE,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
  $ozy = new PDO(DB_DRIVER . ':host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, $dboptions);
} catch (Exception $ex) {
  echo $ex->getMessage();
  echo "<br>Veritabanı bilgileriniz hatalı veya girilmemiş.";
  die;
}





?>