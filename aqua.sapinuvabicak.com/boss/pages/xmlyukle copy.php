<?php
function download_remote_content($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
function download_remote_content_if_large_enough($url, $minBytes = 10240){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
	$data = curl_exec($ch);
	$errno = curl_errno($ch);
	curl_close($ch);
	if ($data === false || strlen($data) < $minBytes || $errno) {
		return false;
	}
	return $data;
}
function has_client_disconnected(){
	$statusNotNormal = function_exists('connection_status') && connection_status() !== CONNECTION_NORMAL;
	$aborted = function_exists('connection_aborted') && connection_aborted() === 1;
	return $aborted || $statusNotNormal;
}
admin_yetki($ozy, $_SESSION['departmanid'], 5);
if($_GET['duzenle']){
    $id = temizle($_GET['duzenle']);
    $ekresimid = temizle($_GET['duzenle']);
    $sayfam = $ozy->query("select * from xml where id=$id")->fetch(PDO::FETCH_ASSOC);
    ///Sayfa güncelleme kodları başlangıç
    if (isset($_POST['guncelle'])) {



  $xmlurl   = temizle($_POST['xmlurl']);
  $urunadi   = temizle($_POST['urunadi']);
  $urunkodu   = temizle($_POST['urunkodu']);
  $urunbarkodu   = temizle($_POST['urunbarkodu']);
  $stok   = temizle($_POST['stok']);
  $fiyat   = temizle($_POST['fiyat']);
  $kdv   = temizle($_POST['kdv']);
  $aciklama   = temizle($_POST['aciklama']);
        $resim = trim(($_POST['resim'] != "") ? $_POST['resim'] : "0");
  $kategori   = temizle($_POST['kategori']);
  $durum   = isset($_POST['durum']) ? '1' : '0';
        $resim1 = trim(($_POST['resim1'] != "") ? $_POST['resim1'] : "0");
        $resim2 = trim(($_POST['resim2'] != "") ? $_POST['resim2'] : "0");
        $resim3 = trim(($_POST['resim3'] != "") ? $_POST['resim3'] : "0");
        $resim4 = trim(($_POST['resim4'] != "") ? $_POST['resim4'] : "0");
        $resim5 = trim(($_POST['resim5'] != "") ? $_POST['resim5'] : "0");
        $resim6 = trim(($_POST['resim6'] != "") ? $_POST['resim6'] : "0");
        $resim7 = trim(($_POST['resim7'] != "") ? $_POST['resim7'] : "0");
        $resim8 = trim(($_POST['resim8'] != "") ? $_POST['resim8'] : "0");
        $resim9 = trim(($_POST['resim9'] != "") ? $_POST['resim9'] : "0");
  $yukledurum   = isset($_POST['yukledurum']) ? '1' : '0';
  $marka   = trim(temizle($_POST['marka']));
  $kattip   = trim(temizle($_POST['kattip']));
  $parcatip   = trim($_POST['parcatip']);
  $resimtip   = trim(temizle($_POST['resimtip']));
        $anaresim = trim(($_POST['anaresim'] != "") ? $_POST['anaresim'] : "0");

        $id = $_GET['duzenle'];
        $stmt = $ozy->prepare("UPDATE xml SET xmlurl = ?, urunadi = ?, urunkodu = ?, urunbarkodu = ?, stok = ?, fiyat = ?, kdv = ?, aciklama = ?, resim = ?, kategori = ?, durum = ?, resim1 = ?, resim2 = ?, resim3 = ?, resim4 = ?, resim5 = ?, resim6 = ?, resim7 = ?, resim8 = ?, resim9 = ?, yukledurum = ?, marka = ?, kattip = ?, parcatip = ?, resimtip = ?, anaresim = ? WHERE id = ?");
        $result2 = $stmt->execute(array($xmlurl, $urunadi, $urunkodu, $urunbarkodu, $stok, $fiyat, $kdv, $aciklama, $resim, $kategori, $durum, $resim1, $resim2, $resim3, $resim4, $resim5, $resim6, $resim7, $resim8, $resim9, $yukledurum, $marka, $kattip, $parcatip, $resimtip, $anaresim, $id));
  if($result2){
	echo '<meta http-equiv="refresh" content="1; url='.$id.'">'; 	

        }




        ////////////XML YÜKLEME İŞLEMİ BAŞLIYOR//////
if($yukledurum=='1'){

            header('Content-Type: text/html; charset=utf-8');
            ini_set('memory_limit', '128M');
            set_time_limit(0);
            if (function_exists('session_write_close')) { session_write_close(); }
            if (function_exists('ignore_user_abort')) { ignore_user_abort(false); }
            // Performans optimizasyonları
            ini_set('max_execution_time', 0);
            ini_set('default_socket_timeout', 30);
            ini_set('mysql.connect_timeout', 30);
            ini_set('mysqlnd.net_read_timeout', 30);
// URL'den XML çek: allow_url_fopen kapalı olabilir, bu yüzden cURL kullan
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $xmlurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
$xmlResponse = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

if ($curlErr) {
  echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("XML indirilemedi: '.addslashes($curlErr).'", "Hata");});</script>';
  $xml = false;
} elseif ($httpCode !== 200 || empty($xmlResponse)) {
  echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("XML indirilemedi. HTTP Kodu: '.(int)$httpCode.'", "Hata");});</script>';
  $xml = false;
} else {
  libxml_use_internal_errors(true);
  $xml = simplexml_load_string($xmlResponse);
  if ($xml === false) {
    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("XML parse edilemedi.", "Hata");});</script>';
  }
}
            list($usec, $sec) = explode(" ", microtime());
            $script_start = (float) $sec + (float) $usec;
$i= 1;
$clientAborted = false;
if ($xml instanceof SimpleXMLElement) {
foreach($xml->children() as $urun)
{
if (has_client_disconnected()) { $clientAborted = true; break; }

if($resimtip=='1'){
$obj=explode("->",$anaresim);
$sonuc=$urun;
foreach($obj as $ob) {
	$sonuc=$sonuc->$ob;
                    }
                }

                // Auto increment değerini her ürün için tekrar çekmeye gerek yok
                // $q = $ozy->query("SHOW TABLE STATUS LIKE 'urunler'");
                // $next = $q->fetch(PDO::FETCH_ASSOC);
                // $ekresimid = $next['Auto_increment'];

                $xurunadi = trim(($urun->$urunadi != "") ? $urun->$urunadi : "0");
   $xseo		= seo($xurunadi);
                $xurunkodu = trim(($urun->$urunkodu != "") ? $urun->$urunkodu : "0");
                $xurunbarkodu = trim(($urun->$urunbarkodu != "") ? $urun->$urunbarkodu : "0");
                $xstok = trim(($urun->$stok != "") ? $urun->$stok : "0");
                $xfiyat = trim(($urun->$fiyat != "") ? $urun->$fiyat : "0");
                $xkdv = ($urun->$kdv != "") ? $urun->$kdv : "0";
                $xaciklama = ($urun->$aciklama != "") ? $urun->$aciklama : " ";
                $parabirimi = "0";
                $yildiz = "5";
                $durum = "1";
                $xmarka = trim(($urun->$marka != "") ? $urun->$marka : "0");
   $tarih   = date('d.m.Y H:i:s');

    if($xstok>='0'){   


                    $urunbak = $ozy->query("SELECT id FROM urunler WHERE seo = '" . $xseo . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);

                    if (count($urunbak) > 0) {


                        $urunguncelle = $ozy->prepare("UPDATE urunler SET fiyat=?, stok=?, aciklama=? WHERE seo = ?");
                        $urunguncelle->execute(array($xfiyat, $xstok, $xaciklama, $xseo));



   }else {  




                if($kattip=='1'){

                            /////////PARÇALI KATEGORİ ALANI //////
                            $kategories = $urun->$kategori;
				$kategoriler = mb_split("".$parcatip."",$kategories);
                            $akategori = 0;
                            $bkategori = 0;
                            $ckategori = 0;
                            $katCount = count($kategoriler);

                            $kategoriBak = $ozy->query("SELECT id FROM kategoriler WHERE seo = '" . seo($kategoriler[0]) . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
                            if (count($kategoriBak) > 0) {
                                $katida = $kategoriBak[0]["id"];
                            } else {
                                $katadi = $kategoriler[0];
					$katseo		= seo($katadi);
                    $katdurum   = "1";
                                $katresim = "resimyok.jpg";
                                $ustkat = "0";
                                $level = "0";
                    $ac="0";
                                if ($katCount <= 1) {
                        $ac="1";
                                }
                                $veriekle = $ozy->prepare("INSERT INTO kategoriler SET adi=?, seo=?, ac=?, durum =?, resim =?, ustkat=?, level=?");
                                $veriekle->execute(array($katadi, $katseo, $ac, $katdurum, $katresim, $ustkat, $level));
                                $katida = $ozy->lastInsertId();
                            }

				if ($katCount > 1 ) {
                                $akategoriBak = $ozy->query("SELECT id FROM kategoriler WHERE seo = '" . seo($kategoriler[1]) . "' AND ustkat = '" . $katida . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
                                if (count($akategoriBak) > 0) {
                                    $katid1 = $akategoriBak[0]["id"];
                                } else {
                                    $katadi1 = $kategoriler[1];
						$katseo1		= seo($katadi1);
                        $katdurum1   = "1";
                                    $katresim1 = "resimyok.jpg";
                                    $ustkat1 = $katida;
                                    $level1 = "1";
                                    $veriekle1 = $ozy->prepare("INSERT INTO kategoriler SET adi=?, seo=?, durum =?, resim =?, ustkat=?, level=?");
                                    $veriekle1->execute(array($katadi1, $katseo1, $katdurum1, $katresim1, $ustkat1, $level1));
                                    $katid1 = $ozy->lastInsertId();
                                }
                            }

				if ($katCount > 2 ) {
                                $ckategoriBak = $ozy->query("SELECT id FROM kategoriler WHERE seo = '" . seo($kategoriler[2]) . "' AND ustkat = '" . $katid1 . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
                                if (count($ckategoriBak) > 0) {
                                    $katid2 = $ckategoriBak[0]["id"];
                                } else {
                                    $katadi2 = $kategoriler[2];
						$katseo2		= seo($katadi2);
                        $katdurum2   = "1";
                                    $katresim2 = "resimyok.jpg";
                                    $ustkat2 = $katid1;
                                    $level2 = "2";
                                    $veriekle2 = $ozy->prepare("INSERT INTO kategoriler SET adi=?, seo=?, durum =?, resim =?, ustkat=?, level=?");
                                    $veriekle2->execute(array($katadi2, $katseo2, $katdurum2, $katresim2, $ustkat2, $level2));
                                    $katid2 = $ozy->lastInsertId();
                                }
                            }


                            /////////PARÇALI KATEGORİ ALANI //////

	            $katid = "".$katida.",".$katid1.",".$katid2."";



                        } else {

                            $katadi = ($urun->$kategori != "") ? $urun->$kategori : " ";
   $katseo		= seo($katadi);
   $katdurum   = "1";
                            $katresim = "resimyok.jpg";

                            $katbak = $ozy->query("SELECT id FROM kategoriler WHERE seo = '" . $katseo . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);

                            if (count($katbak) > 0) {
                                $katid = $katbak[0]["id"];

                            } else {


                                $katstmt = $ozy->prepare("INSERT INTO kategoriler (adi, seo, durum, resim) 
   VALUES (?,?,?,?)");
                                $katresult2 = $katstmt->execute(array($katadi, $katseo, $katdurum, $katresim));
                                $katid = $ozy->lastInsertId();

                            }

                        }








   $markaadi   = $urun->$marka;
   $markaseo		= seo($markaadi);
   $markadurum   = "1";
                        $markaresim = "resimyok.jpg";


   $markabak = $ozy->query("SELECT id FROM markalar WHERE seo = '" .$markaseo. "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);

                        if (count($markabak) > 0) {

                            $markaid = $markabak[0]["id"];
                        } else {


                            $markastmt = $ozy->prepare("INSERT INTO markalar (seo, adi, durum, resim) 
   VALUES (?,?,?,?)");
   $markaresult2 = $markastmt->execute(array($markaseo,$markaadi, $markadurum, $markaresim));
                            $markaid = $ozy->lastInsertId();

                        }





                if($resimtip=='1'){

                            $resimkonum = $sonuc[0];
                            $resimad = basename($resimkonum);
                            $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
				$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                            $yol = "../resimler/genel";
                            $image = download_remote_content_if_large_enough($resimkonum, 10240);
                            if ($image === false) {
                                $yeniad = 'resimyok.jpg';
                            } else {
                                file_put_contents($yol . '/' . $yeniad, $image);
                            }

                        } else {

                            $resimkonum = $urun->$resim;
                            $resimad = basename($resimkonum);
                            $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
				$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                            $yol = "../resimler/genel";
                            $image = download_remote_content_if_large_enough($resimkonum, 10240);
                            if ($image === false) {
                                $yeniad = 'resimyok.jpg';
                            } else {
                                file_put_contents($yol . '/' . $yeniad, $image);
                            }

                        }

                        $stmtx = $ozy->prepare("INSERT INTO urunler (adi, seo, urunkodu, urunbarkodu, parabirimi, stok, fiyat, kdv, aciklama, kategori, durum, tarih, yildiz, resim, marka) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        $result2x = $stmtx->execute(array($xurunadi, $xseo, $xurunkodu, $xurunbarkodu, $parabirimi, $xstok, $xfiyat, $xkdv, $xaciklama, $katid, $durum, $tarih, $yildiz, $yeniad, $markaid));
                        $urun_id = $ozy->lastInsertId();

                        // Her ürün için temizlik yapmaya gerek yok, sadece en sonda yapılacak
                        // $markasil = $ozy->exec("DELETE FROM markalar WHERE adi=' '");
                        // $kategorisil = $ozy->exec("DELETE FROM kategoriler WHERE adi=' '");
                        // $urunsil = $ozy->exec("DELETE FROM urunler WHERE adi=' '");

	if($resimtip=='1'){

                            if (isset($sonuc[1]) && $sonuc[1] != " ") {
                                $resimkonum = $sonuc[1];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }

                            if (isset($sonuc[2]) && $sonuc[2] != " ") {
                                $resimkonum = $sonuc[2];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }

                            if (isset($sonuc[3]) && $sonuc[3] != " ") {
                                $resimkonum = $sonuc[3];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }

                            if (isset($sonuc[4]) && $sonuc[4] != " ") {
                                $resimkonum = $sonuc[4];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }


                            if (isset($sonuc[5]) && $sonuc[5] != " ") {
                                $resimkonum = $sonuc[5];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }


                            if (isset($sonuc[6]) && $sonuc[6] != " ") {
                                $resimkonum = $sonuc[6];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }


                            if (isset($sonuc[7]) && $sonuc[7] != " ") {
                                $resimkonum = $sonuc[7];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }


                            if (isset($sonuc[8]) && $sonuc[8] != " ") {
                                $resimkonum = $sonuc[8];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }


                            if (isset($sonuc[9]) && $sonuc[9] != " ") {
                                $resimkonum = $sonuc[9];
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }



	}else{

                            if (isset($urun->$resim1) && $urun->$resim1 != " ") {
                                $resimkonum = $urun->$resim1;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }

                            if (isset($urun->$resim2) && $urun->$resim2 != " ") {
                                $resimkonum = $urun->$resim2;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }



                            if (isset($urun->$resim3) && $urun->$resim3 != " ") {
                                $resimkonum = $urun->$resim3;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }



                            if (isset($urun->$resim4) && $urun->$resim4 != " ") {
                                $resimkonum = $urun->$resim4;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content($resimkonum);
                                file_put_contents($yol . '/' . $yeniad, $image);
                                $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                $ekle->execute(array($yeniad, 'urunler', $urun_id));
                            }


                            if (isset($urun->$resim5) && $urun->$resim5 != " ") {
                                $resimkonum = $urun->$resim5;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content($resimkonum);
                                file_put_contents($yol . '/' . $yeniad, $image);
                                $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                $ekle->execute(array($yeniad, 'urunler', $urun_id));
                            }


                            if (isset($urun->$resim6) && $urun->$resim6 != " ") {
                                $resimkonum = $urun->$resim6;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content($resimkonum);
                                file_put_contents($yol . '/' . $yeniad, $image);
                                $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                $ekle->execute(array($yeniad, 'urunler', $urun_id));
                            }


                            if (isset($urun->$resim7) && $urun->$resim7 != " ") {
                                $resimkonum = $urun->$resim7;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content($resimkonum);
                                file_put_contents($yol . '/' . $yeniad, $image);
                                $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                $ekle->execute(array($yeniad, 'urunler', $urun_id));
                            }


                            if (isset($urun->$resim8) && $urun->$resim8 != " ") {
                                $resimkonum = $urun->$resim8;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content($resimkonum);
                                file_put_contents($yol . '/' . $yeniad, $image);
                                $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                $ekle->execute(array($yeniad, 'urunler', $urun_id));
                            }


                            if (isset($urun->$resim9) && $urun->$resim9 != " ") {
                                $resimkonum = $urun->$resim9;
                                $resimad = basename($resimkonum);
                                $uzanti = pathinfo($resimad, PATHINFO_EXTENSION);
	$yeniad = rand().md5(time().$resimad) . ($uzanti ? '.' . $uzanti : '');
                                $yol = "../resimler/genel";
                                $image = download_remote_content_if_large_enough($resimkonum, 10240);
                                if ($image !== false) {
                                    file_put_contents($yol . '/' . $yeniad, $image);
                                    $ekle = $ozy->prepare("insert into tumresimler set sayfaresim=?, alan=?, sayfaid=?");
                                    $ekle->execute(array($yeniad, 'urunler', $urun_id));
                                }
                            }






                        }













                    }

                }

$urunadetsayisi =  $i++;

            }

            // Eğer istemci bağlantıyı kapattıysa süreci durdur
            if ($clientAborted) { exit; }
            $id = $_GET['duzenle'];
            $okstmt = $ozy->prepare("UPDATE xml SET yukledurum = ? WHERE id = ?");
            $okresult2 = $okstmt->execute(array($yukledurum, $id));
            
            // En sonda temizlik işlemleri
            $markasil = $ozy->exec("DELETE FROM markalar WHERE adi=' '");
            $kategorisil = $ozy->exec("DELETE FROM kategoriler WHERE adi=' '");
            $urunsil = $ozy->exec("DELETE FROM urunler WHERE adi=' '");

            list($usec, $sec) = explode(" ", microtime());
            $script_end = (float) $sec + (float) $usec;
            $elapsed_time = round($script_end - $script_start, 5);
  








        }

        ////////////XML YÜKLEME İŞLEMİ BAŞLIYOR//////


   if($result2){
            ///echo '<meta http-equiv="refresh" content="5; url='.$id.'">'; 	

   }else{

            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';


        }








        // Temizlik işlemleri zaten yukarıda yapıldı
        // $kattemizle = $ozy->exec("DELETE FROM  kategoriler where adi=' '");
	// $uruntemizle= $ozy->exec("DELETE FROM  urunler where adi=' '");


    }



    ////Sayfa güncelleme kodları bitiş

}else{



    if (isset($_POST['kaydet'])) {

  $xmlurl   = trim(temizle($_POST['xmlurl']));
  $urunadi   = trim(temizle($_POST['urunadi']));
  $urunkodu   = trim(temizle($_POST['urunkodu']));
  $urunbarkodu   = trim(temizle($_POST['urunbarkodu']));
  $stok   = trim(temizle($_POST['stok']));
  $fiyat   = trim(temizle($_POST['fiyat']));
  $kdv   = trim(temizle($_POST['kdv']));
  $aciklama   = trim(temizle($_POST['aciklama']));
  $resim   = trim(temizle($_POST['resim']));
  $kategori   = trim(temizle($_POST['kategori']));
  $durum   = isset($_POST['durum']) ? '1' : '0';
  $tarih   = date('d.m.Y H:i:s');
        $resim = trim(($_POST['resim'] != "") ? $_POST['resim'] : "0");
        $resim1 = trim(($_POST['resim1'] != "") ? $_POST['resim1'] : "0");
        $resim2 = trim(($_POST['resim2'] != "") ? $_POST['resim2'] : "0");
        $resim3 = trim(($_POST['resim3'] != "") ? $_POST['resim3'] : "0");
        $resim4 = trim(($_POST['resim4'] != "") ? $_POST['resim4'] : "0");
        $resim5 = trim(($_POST['resim5'] != "") ? $_POST['resim5'] : "0");
        $resim6 = trim(($_POST['resim6'] != "") ? $_POST['resim6'] : "0");
        $resim7 = trim(($_POST['resim7'] != "") ? $_POST['resim7'] : "0");
        $resim8 = trim(($_POST['resim8'] != "") ? $_POST['resim8'] : "0");
        $resim9 = trim(($_POST['resim9'] != "") ? $_POST['resim9'] : "0");
  $marka   = trim(temizle($_POST['marka']));
  $kattip   = trim(temizle($_POST['kattip']));
  $parcatip   = trim($_POST['parcatip']);
  $resimtip   = trim(temizle($_POST['resimtip']));
        $anaresim = trim(($_POST['anaresim'] != "") ? $_POST['anaresim'] : "0");

        $stmt = $ozy->prepare("INSERT INTO xml (xmlurl, urunadi, urunkodu, urunbarkodu, stok, fiyat, kdv, aciklama, resim, kategori, durum, tarih, resim1, resim2, resim3, resim4, resim5, resim6, resim7, resim8, resim9, marka, kattip, parcatip, resimtip, anaresim) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $result2 = $stmt->execute(array($xmlurl, $urunadi, $urunkodu, $urunbarkodu, $stok, $fiyat, $kdv, $aciklama, $resim, $kategori, $durum, $tarih, $resim1, $resim2, $resim3, $resim4, $resim5, $resim6, $resim7, $resim8, $resim9, $marka, $kattip, $parcatip, $resimtip, $anaresim));
        $id = $ozy->lastInsertId();


   if($result2){
		echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/xml/duzenle/'.$id.'">'; 	

   }else{

            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';


        }









    }

    ////Sayfa oluşturma kodları bitiş






}
}

?>





<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">XML

                    </h4>
                </div>


                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                        <li class="breadcrumb-item active">XML
                            İmport
                        </li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                    <div class="card m-b-30">
                        <div class="card-body">








                            <div class="tab-content">








                                <div class="tab-pane active p-3" id="home-1" role="tabpanel">



                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">XML URL Adresi</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="xmlurl" value="<?php echo $sayfam['xmlurl']; ?>" placeholder="https://....." required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Adı</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="urunadi" value="<?php echo $sayfam['urunadi']; ?>" placeholder="urunadi" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Tipi</label>
                                        <div class="col-sm-10">

                                            <input id="demo-inline-form-radio" class="magic-radio" name="kattip"
                            value="0" checked <?php echo $sayfam['kattip'] == '0' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio">Normal Kategori ( Örnek kategori )</label>

                                            <input id="demo-inline-form-radio-2" class="magic-radio" name="kattip"
                                                value="1" <?php echo $sayfam['kattip'] == '1' ? 'checked=""' : null; ?>
                                                type="radio">
                            <label for="demo-inline-form-radio-2">Parçalı Kategori ( Örnek kategori>altkategori>enaltkategori )</label>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Kategorileri</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="kategori" value="<?php echo $sayfam['kategori']; ?>" placeholder="kategori" >
                                        </div>
                                    </div>

							<div class="form-group row" id="parcatip" style="<?php echo $sayfam['kattip'] == '1' ? 'display:block !important;' : 'display:none !important;'; ?>">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Ayracı</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="parcatip" value="<?php echo $sayfam['parcatip']; ?>" placeholder="örnek > , / ...vb" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Kodu</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="urunkodu" value="<?php echo $sayfam['urunkodu']; ?>" placeholder="urunkodu" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Barkodu</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="urunbarkodu" value="<?php echo $sayfam['urunbarkodu']; ?>" placeholder="urunbarkodu" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Markası</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="marka" value="<?php echo $sayfam['marka']; ?>" placeholder="marka" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Stok Sayısı</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="stok" value="<?php echo $sayfam['stok']; ?>" placeholder="stok" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Fiyatı</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="fiyat" value="<?php echo $sayfam['fiyat']; ?>" placeholder="fiyat" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">KDV Oranı</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="kdv" value="<?php echo $sayfam['kdv']; ?>" placeholder="kdv" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Açıklaması</label>
                                        <div class="col-sm-10">
                                    <input class="form-control" type="text" name="aciklama" value="<?php echo $sayfam['aciklama']; ?>" placeholder="aciklama" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Resim Tipi</label>
                                        <div class="col-sm-10">

                                            <input id="demo-inline-form-radio" class="magic-radio" name="resimtip"
                            value="0" checked <?php echo $sayfam['resimtip'] == '0' ? 'checked=""' : null; ?>
                            type="radio">
                            <label for="demo-inline-form-radio">Normal Sıralı Resim ( resim,resim1,resim2 )</label>

                                            <input id="demo-inline-form-radio-2" class="magic-radio" name="resimtip"
                                                value="1" <?php echo $sayfam['resimtip'] == '1' ? 'checked=""' : null; ?>
                                                type="radio">
                            <label for="demo-inline-form-radio-2">Döngülü Resim ( Örnek resimler>resim )</label>

                                        </div>
                                    </div>

							<div class="form-group row" id="anaresim" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:block !important;' : 'display:none !important;'; ?>">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Ana Resim</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="anaresim" value="<?php echo $sayfam['anaresim']; ?>" placeholder="Örnek (images->img_item)">
                                        </div>
                                    </div>


							<div class="form-group row" id="resim" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Ana Resim</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim" value="<?php echo $sayfam['resim']; ?>" placeholder="resim">
                                        </div>
                                    </div>

							<div class="form-group row" id="resim1" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 1</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim1" value="<?php echo $sayfam['resim1']; ?>" placeholder="resim1">
                                        </div>
                                    </div>


							<div class="form-group row" id="resim2" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 2</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim2" value="<?php echo $sayfam['resim2']; ?>" placeholder="resim2">
                                        </div>
                                    </div>


							<div class="form-group row" id="resim3" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 3</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim3" value="<?php echo $sayfam['resim3']; ?>" placeholder="resim3">
                                        </div>
                                    </div>



							<div class="form-group row" id="resim4" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 4</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim4" value="<?php echo $sayfam['resim4']; ?>" placeholder="resim4">
                                        </div>
                                    </div>


							<div class="form-group row" id="resim5" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 5</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim5" value="<?php echo $sayfam['resim5']; ?>" placeholder="resim5">
                                        </div>
                                    </div>


							<div class="form-group row" id="resim6" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 6</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim6" value="<?php echo $sayfam['resim6']; ?>" placeholder="resim6">
                                        </div>
                                    </div>


							<div class="form-group row" id="resim7" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 7</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim7" value="<?php echo $sayfam['resim7']; ?>" placeholder="resim7">
                                        </div>
                                    </div>


							<div class="form-group row" id="resim8" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 8</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim8" value="<?php echo $sayfam['resim8']; ?>" placeholder="resim8">
                                        </div>
                                    </div>

							<div class="form-group row" id="resim9" style="<?php echo $sayfam['resimtip'] == '1' ? 'display:none !important;' : 'display:block !important;'; ?>">
                               <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Resmi 9</label>
                                        <div class="col-sm-10" style="max-width: 83.333333% !important;float: right;">
                                    <input class="form-control" type="text" name="resim9" value="<?php echo $sayfam['resim9']; ?>" placeholder="resim9">
                                        </div>
                                    </div>



					        <?php if($_GET['duzenle']){?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                            <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['durum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>

                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                            <div class="col-sm-10">
                                <input type="checkbox"  checked="" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>

                                        </div>

                                    <?php } ?>


						    <?php if($_GET['duzenle']){?>
                                        <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Yükleme Durumu</label>
                                            <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['yukledurum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="yukledurum"></div>

                                        </div>
                                    <?php } ?>





                                </div>






                            </div>




                         <?php if($_GET['duzenle']){?>

						  <button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>

                            <?php } else { ?>

                          <button type="submit" name="kaydet" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Kaydet</button>



                            <?php } ?>



                        </div>









                    </div>
                </form>


            </div>
        </div>
    </div> <!-- end col -->

</div> <!-- end row -->

</div>
<!-- end wrapper -->