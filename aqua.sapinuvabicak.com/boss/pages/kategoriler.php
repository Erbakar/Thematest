<?php
admin_yetki($ozy, $_SESSION['departmanid'], 4);
if (isset($_GET['temizle'])) {

    $id = temizle($_GET['temizle']);
    $bakresim = $ozy->query("select * from kategoriler where id='$id'")->fetch(PDO::FETCH_ASSOC);
    $sayfasil = $ozy->prepare("delete from kategoriler where id='$id'");
    $sayfasil->execute(array($id));

    $newust = $bakresim['ustkat'];

    if ($sayfasil) {

        if ($bakresim['resim'] == 'resimyok.jpg') {
        } else {
            $silresim = "../resimler/kategoriler/" . $bakresim['resim'] . "";
            $sil = @unlink("$silresim");
        }

        $sonuccc = $ozy->exec("UPDATE kategoriler SET ustkat='$newust' WHERE ustkat='$id'");


        echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';
    }
}

$temagelsin = $ayar['tema'];
$temamiz = $ozy->query("select * from temalar where adi='$temagelsin'")->fetch(PDO::FETCH_ASSOC);
if (isset($_GET['fsil'])) {

    $fid = temizle($_GET['fsil']);
    $fsayfasil = $ozy->prepare("delete from filtre where fid='$fid'");
    $fsayfasil->execute(array($fid));

    if ($fsayfasil) {


        echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';
    }
}

$category_list = $ozy->query("SELECT * from kategoriler where level!='2'", PDO::FETCH_OBJ)->fetchAll();


if ($_GET['duzenle']) {
    $id = temizle($_GET['duzenle']);
    $sayfam = $ozy->query("select * from kategoriler where id=$id")->fetch(PDO::FETCH_ASSOC);
    ///Sayfa güncelleme kodları başlangıç
    if (isset($_POST['guncelle'])) {



        $adi   = temizle($_POST['adi']);
        $aciklama   = " ";
        if ($_POST['seo'] == '') {
            $seo        = "" . seo($adi) . "-" . $id . "";
        } else {
            $seo        = seo($_POST['seo']);
        }
        $hit   = "0";
        $durum   = temizle($_POST['durum']);
        $siram   = temizle($_POST['siram']);
        $seodurum   = temizle($_POST['seodurum']);
        $stitle   = temizle($_POST['stitle']);
        $skey   = temizle($_POST['skey']);
        $sdesc   = temizle($_POST['sdesc']);
        $ustkat   = temizle($_POST['ustkat']);
        $ac = ($_POST['ac'] != "") ? $_POST['ac'] : "0";
        if ($_POST['ustkat'] == '0') {
            $level   = "0";
        } else {

            $uskatid = $_POST['ustkat'];
            $ekleid = $ozy->query("select * from kategoriler where id='$uskatid'")->fetch(PDO::FETCH_ASSOC);
            $level   = 1 + $ekleid['level'];
        }
        $ustgoster = ($_POST['ustgoster'] != "") ? $_POST['ustgoster'] : "0";
        $agoster = ($_POST['agoster'] != "") ? $_POST['agoster'] : "0";
        $ikongoster = ($_POST['ikongoster'] != "") ? $_POST['ikongoster'] : "0";
        $renk   = $_POST['renk'];

        $reskonum  = $_FILES['resim']['tmp_name'];
        $resad     = $_FILES['resim']['name'];
        $restip    = $_FILES['resim']['type'];
        $uzanti      = substr($resad, -5, 5);
        $resimadi      = md5(uniqid(rand(time($resad)))) . $uzanti;
        $yol         = "../resimler/kategoriler";



        $favkonum = $_FILES['yanresim']['tmp_name'];
        $favad = $_FILES['yanresim']['name'];
        $favtip = $_FILES['yanresim']['type'];
        $favuzanti = substr($favad, -5, 5);
        $favyeniad = md5(uniqid(rand(time($favad)))) . $favuzanti;
        $favyol = "../resimler/kategoriler";




        $favkonum1 = $_FILES['ikon']['tmp_name'];
        $favad1 = $_FILES['ikon']['name'];
        $favtip1 = $_FILES['ikon']['type'];
        $favuzanti1 = substr($favad1, -5, 5);
        $favyeniad1 = md5(uniqid(rand(time($favad1)))) . $favuzanti1;
        $favyol1 = "../resimler/kategoriler";





        $nfavkonum1 = $_FILES['nikon']['tmp_name'];
        $nfavad1 = $_FILES['nikon']['name'];
        $nfavtip1 = $_FILES['nikon']['type'];
        $nfavuzanti1 = substr($nfavad1, -5, 5);
        $nfavyeniad1 = md5(uniqid(rand(time($nfavad1)))) . $nfavuzanti1;
        $nfavyol1 = "../resimler/kategoriler";



        if (!empty($_FILES['resim']['name'])) {
            if ($restip != 'image/jpeg'  && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg') {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
            } else {

                $ekle = move_uploaded_file($reskonum, $yol . '/' . $resimadi);
                $id = $_GET['duzenle'];
                $stmt = $ozy->prepare("UPDATE kategoriler SET adi = ?, aciklama = ?, seo = ?, durum = ?, sira = ?, seodurum = ?, stitle = ?, skey = ?, sdesc = ?, resim = ?, ustkat = ?, ac = ?, level = ?, ustgoster = ?, agoster = ?, ikongoster = ?, renk = ? WHERE id = ?");
                $result2 = $stmt->execute(array($adi, $aciklama, $seo, $durum, $siram, $seodurum, $stitle, $skey, $sdesc, $resimadi, $ustkat, $ac, $level, $ustgoster, $agoster, $ikongoster, $renk, $id));



                ////FİLTRE EKLEME KODLARI BAŞLANGIÇ////   
                $fsira   = $_POST['sira'];
                $fadi   = $_POST['fadi'];
                $fozellik   = $_POST['ozellik'];
                $fid   = ($_POST['fid'] != "") ? $_POST['fid'] : "0";

                $result = array_map(function ($name, $type, $price, $fid) {
                    return array_combine(
                        ['sira', 'fadi', 'ozellik', 'fid'],
                        [$name, $type, $price, $fid]
                    );
                }, $fsira, $fadi, $fozellik, $fid);

                foreach ($result as $filtre) {

                    $filtresira = $filtre['sira'];
                    $filtreadi = $filtre['fadi'];
                    $filtreozellik = $filtre['ozellik'];
                    $filtreid = $filtre['fid'];
                    $bak = $ozy->query("SELECT fid FROM filtre WHERE fid = '" . $filtreid . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
                    if (count($bak) > 0) {

                        $fstmt = $ozy->prepare("UPDATE filtre SET sira=?, fadi=?, ozellik=? WHERE fid=?");
                        $result2f = $fstmt->execute(array($filtresira, $filtreadi, $filtreozellik, $filtreid));
                    } else {
                        $kid = temizle($_GET['duzenle']);
                        $fstmt = $ozy->prepare("INSERT INTO filtre (sira, fadi, ozellik, kategori) 
VALUES (?,?,?,?)");
                        $result2f = $fstmt->execute(array($filtresira, $filtreadi, $filtreozellik, $kid));
                    }
                }
                ////FİLTRE EKLEME KODLARI BİTİŞ//// 







                if (!empty($_FILES['yanresim']['name'])) {
                    if ($favtip != 'image/jpeg' && $favtip != 'image/png' && $favuzanti != '.jpg' && $favuzanti != '.png' && $favuzanti != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {

                        $favekle = move_uploaded_file($favkonum, $favyol . '/' . $favyeniad);
                        $favekle = $ozy->prepare("update kategoriler set yanresim=? where id=?");
                        $favekle->execute(array($favyeniad, $id));
                    }
                }

                if (!empty($_FILES['ikon']['name'])) {
                    if ($favtip1 != 'image/jpeg' && $favtip1 != 'image/png' && $favuzanti1 != '.jpg' && $favuzanti1 != '.png' && $favuzanti1 != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {
                        $faveklem = move_uploaded_file($favkonum1, $favyol1 . '/' . $favyeniad1);
                        $faveklem = $ozy->prepare("update kategoriler set ikon=? where id=?");
                        $faveklem->execute(array($favyeniad1, $id));
                    }
                }

                if (!empty($_FILES['nikon']['name'])) {
                    if ($nfavtip1 != 'image/jpeg' && $nfavtip1 != 'image/png' && $nfavuzanti1 != '.jpg' && $nfavuzanti1 != '.png' && $nfavuzanti1 != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {
                        $nfaveklem = move_uploaded_file($nfavkonum1, $nfavyol1 . '/' . $nfavyeniad1);
                        $nfaveklem = $ozy->prepare("update kategoriler set nikon=? where id=?");
                        $nfaveklem->execute(array($nfavyeniad1, $id));
                    }
                }




                if ($result2) {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
                    echo '<meta http-equiv="refresh" content="1; url=' . $id . '">';
                    echo '<meta http-equiv="refresh" content="1; url=' . $url . '/boss/kategori/duzenle/' . $id . '">';
                } else {

                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
                }
            }
        } else {



            $id = $_GET['duzenle'];
            $stmt = $ozy->prepare("UPDATE kategoriler SET adi = ?, aciklama = ?, seo = ?, durum = ?, sira = ?, seodurum = ?, stitle = ?, skey = ?, sdesc = ?, ustkat = ?, ac = ?, level = ?, ustgoster = ?, agoster = ?, ikongoster = ?, renk = ? WHERE id = ?");
            $result2 = $stmt->execute(array($adi, $aciklama, $seo, $durum, $siram, $seodurum, $stitle, $skey, $sdesc, $ustkat, $ac, $level, $ustgoster, $agoster, $ikongoster, $renk, $id));

            ////FİLTRE EKLEME KODLARI BAŞLANGIÇ////   
            $fsira   = $_POST['sira'];
            $fadi   = $_POST['fadi'];
            $fozellik   = $_POST['ozellik'];
            $fid   = ($_POST['fid'] != "") ? $_POST['fid'] : "0";

            $result = array_map(function ($name, $type, $price, $fid) {
                return array_combine(
                    ['sira', 'fadi', 'ozellik', 'fid'],
                    [$name, $type, $price, $fid]
                );
            }, $fsira, $fadi, $fozellik, $fid);

            foreach ($result as $filtre) {

                $filtresira = $filtre['sira'];
                $filtreadi = $filtre['fadi'];
                $filtreozellik = $filtre['ozellik'];
                $filtreid = $filtre['fid'];
                $bak = $ozy->query("SELECT fid FROM filtre WHERE fid = '" . $filtreid . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
                if (count($bak) > 0) {

                    $fstmt = $ozy->prepare("UPDATE filtre SET sira=?, fadi=?, ozellik=? WHERE fid=?");
                    $result2f = $fstmt->execute(array($filtresira, $filtreadi, $filtreozellik, $filtreid));
                } else {
                    $kid = temizle($_GET['duzenle']);
                    $fstmt = $ozy->prepare("INSERT INTO filtre (sira, fadi, ozellik, kategori) 
VALUES (?,?,?,?)");
                    $result2f = $fstmt->execute(array($filtresira, $filtreadi, $filtreozellik, $kid));
                }
            }
            ////FİLTRE EKLEME KODLARI BİTİŞ//// 








            if (!empty($_FILES['yanresim']['name'])) {
                if ($favtip != 'image/jpeg' && $favtip != 'image/png' && $favuzanti != '.jpg' && $favuzanti != '.png' && $favuzanti != '.jpeg') {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                } else {

                    $favekle = move_uploaded_file($favkonum, $favyol . '/' . $favyeniad);
                    $favekle = $ozy->prepare("update kategoriler set yanresim=? where id=?");
                    $favekle->execute(array($favyeniad, $id));
                }
            }

            if (!empty($_FILES['ikon']['name'])) {
                if ($favtip1 != 'image/jpeg' && $favtip1 != 'image/png' && $favuzanti1 != '.jpg' && $favuzanti1 != '.png' && $favuzanti1 != '.jpeg') {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                } else {
                    $faveklem = move_uploaded_file($favkonum1, $favyol1 . '/' . $favyeniad1);
                    $faveklem = $ozy->prepare("update kategoriler set ikon=? where id=?");
                    $faveklem->execute(array($favyeniad1, $id));
                }
            }

            if (!empty($_FILES['nikon']['name'])) {
                if ($nfavtip1 != 'image/jpeg' && $nfavtip1 != 'image/png' && $nfavuzanti1 != '.jpg' && $nfavuzanti1 != '.png' && $nfavuzanti1 != '.jpeg') {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                } else {
                    $nfaveklem = move_uploaded_file($nfavkonum1, $nfavyol1 . '/' . $nfavyeniad1);
                    $nfaveklem = $ozy->prepare("update kategoriler set nikon=? where id=?");
                    $nfaveklem->execute(array($nfavyeniad1, $id));
                }
            }



            if ($result2) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
                echo '<meta http-equiv="refresh" content="1; url=' . $url . '/boss/kategori/duzenle/' . $id . '">';
            } else {

                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
            }
        }
    }



    ////Sayfa güncelleme kodları bitiş

} else {

    $q = $ozy->query("SHOW TABLE STATUS LIKE 'kategoriler'");
    $next = $q->fetch(PDO::FETCH_ASSOC);
    $katidmiz = $next['Auto_increment'];

    if (isset($_POST['kaydet'])) {

        $adi   = temizle($_POST['adi']);
        $aciklama   = "";
        if ($_POST['seo'] == '') {
            $seo        = "" . seo($adi) . "-" . $katidmiz . "";
        } else {
            $seo        = seo($_POST['seo']);
        }
        $hit   = "0";
        $durum   = temizle($_POST['durum']);
        $sira   = temizle($_POST['sira']);
        $seodurum   = temizle($_POST['seodurum']);
        $stitle   = temizle($_POST['stitle']);
        $skey   = temizle($_POST['skey']);
        $sdesc   = temizle($_POST['sdesc']);
        $ustkat   = temizle($_POST['ustkat']);
        $ac = ($_POST['ac'] != "") ? $_POST['ac'] : "0";
        if ($_POST['ustkat'] == '0') {
            $level   = "0";
        } else {

            $uskatid = $_POST['ustkat'];
            $ekleid = $ozy->query("select * from kategoriler where id='$uskatid'")->fetch(PDO::FETCH_ASSOC);
            $level   = 1 + $ekleid['level'];
        }
        $ustgoster = ($_POST['ustgoster'] != "") ? $_POST['ustgoster'] : "0";
        $agoster = ($_POST['agoster'] != "") ? $_POST['agoster'] : "0";
        $ikongoster = ($_POST['ikongoster'] != "") ? $_POST['ikongoster'] : "0";
        $renk   = $_POST['renk'];

        $reskonum  = $_FILES['resim']['tmp_name'];
        $resad     = $_FILES['resim']['name'];
        $restip    = $_FILES['resim']['type'];
        $uzanti      = substr($resad, -5, 5);
        $resimadi      = md5(uniqid(rand(time($resad)))) . $uzanti;
        $yol         = "../resimler/kategoriler";

        $favkonum = $_FILES['yanresim']['tmp_name'];
        $favad = $_FILES['yanresim']['name'];
        $favtip = $_FILES['yanresim']['type'];
        $favuzanti = substr($favad, -5, 5);
        $favyeniad = md5(uniqid(rand(time($favad)))) . $favuzanti;
        $favyol = "../resimler/kategoriler";

        $favkonum1 = $_FILES['ikon']['tmp_name'];
        $favad1 = $_FILES['ikon']['name'];
        $favtip1 = $_FILES['ikon']['type'];
        $favuzanti1 = substr($favad1, -5, 5);
        $favyeniad1 = md5(uniqid(rand(time($favad1)))) . $favuzanti1;
        $favyol1 = "../resimler/kategoriler";

        $nfavkonum1 = $_FILES['nikon']['tmp_name'];
        $nfavad1 = $_FILES['nikon']['name'];
        $nfavtip1 = $_FILES['nikon']['type'];
        $nfavuzanti1 = substr($nfavad1, -5, 5);
        $nfavyeniad1 = md5(uniqid(rand(time($nfavad1)))) . $nfavuzanti1;
        $nfavyol1 = "../resimler/kategoriler";



        if (empty($_FILES['resim']['name'])) {

            $resimadi = "resimyok.jpg";
            $stmt = $ozy->prepare("INSERT INTO kategoriler (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, ustkat, resim, ac, level, ustgoster, agoster, ikongoster, renk) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $result2 = $stmt->execute(array($adi, $aciklama, $seo, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $ustkat, $resimadi, $ac, $level, $ustgoster, $agoster, $ikongoster, $renk));
            $id = $ozy->lastInsertId();

            ////FİLTRE EKLEME KODLARI BAŞLANGIÇ////   
            $fsira   = $_POST['sira'];
            $fadi   = $_POST['fadi'];
            $fozellik   = $_POST['ozellik'];

            $result = array_map(function ($name, $type, $price) {
                return array_combine(
                    ['sira', 'fadi', 'ozellik'],
                    [$name, $type, $price]
                );
            }, $fsira, $fadi, $fozellik);

            foreach ($result as $filtre) {

                $filtresira = $filtre['sira'];
                $filtreadi = $filtre['fadi'];
                $filtreozellik = $filtre['ozellik'];
                $kid = $ozy->lastInsertId();
                $fstmt = $ozy->prepare("INSERT INTO filtre (sira, fadi, ozellik, kategori) 
VALUES (?,?,?,?)");
                $result2f = $fstmt->execute(array($filtresira, $filtreadi, $filtreozellik, $kid));
            }
            ////FİLTRE EKLEME KODLARI BİTİŞ//// 







            if ($result2) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
                echo '<meta http-equiv="refresh" content="1; url=tum-kategoriler">';

                if (!empty($_FILES['yanresim']['name'])) {
                    if ($favtip != 'image/jpeg' && $favtip != 'image/png' && $favuzanti != '.jpg' && $favuzanti != '.png' && $favuzanti != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {
                        $q = $ozy->query("SHOW TABLE STATUS LIKE 'kategoriler'");
                        $next = $q->fetch(PDO::FETCH_ASSOC);
                        $katidmiz = $next['Auto_increment'];

                        $favekle = move_uploaded_file($favkonum, $favyol . '/' . $favyeniad);
                        $favekle = $ozy->prepare("update kategoriler set yanresim=? where id=?");
                        $favekle->execute(array($favyeniad, $id));
                    }
                }

                if (!empty($_FILES['ikon']['name'])) {
                    if ($favtip1 != 'image/jpeg' && $favtip1 != 'image/png' && $favuzanti1 != '.jpg' && $favuzanti1 != '.png' && $favuzanti1 != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {
                        $faveklem = move_uploaded_file($favkonum1, $favyol1 . '/' . $favyeniad1);
                        $faveklem = $ozy->prepare("update kategoriler set ikon=? where id=?");
                        $faveklem->execute(array($favyeniad1, $id));
                    }
                }

                if (!empty($_FILES['nikon']['name'])) {
                    if ($nfavtip1 != 'image/jpeg' && $nfavtip1 != 'image/png' && $nfavuzanti1 != '.jpg' && $nfavuzanti1 != '.png' && $nfavuzanti1 != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {
                        $nfaveklem = move_uploaded_file($nfavkonum1, $nfavyol1 . '/' . $nfavyeniad1);
                        $nfaveklem = $ozy->prepare("update kategoriler set nikon=? where id=?");
                        $nfaveklem->execute(array($nfavyeniad1, $id));
                    }
                }
            } else {

                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
            }
        } else {



            if ($restip != 'image/jpeg'  && $restip != 'image/png' && $uzanti != '.jpg' && $uzanti != '.png' && $uzanti != '.jpeg') {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
            } else {

                $ekle = move_uploaded_file($reskonum, $yol . '/' . $resimadi);

                $stmt = $ozy->prepare("INSERT INTO kategoriler (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, ustkat, resim, ac, level, ustgoster, agoster, ikongoster, renk) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $result2 = $stmt->execute(array($adi, $aciklama, $seo, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $ustkat, $resimadi, $ac, $level, $ustgoster, $agoster, $ikongoster, $renk));
                $id = $ozy->lastInsertId();


                ////FİLTRE EKLEME KODLARI BAŞLANGIÇ////   
                $fsira   = $_POST['sira'];
                $fadi   = $_POST['fadi'];
                $fozellik   = $_POST['ozellik'];

                $result = array_map(function ($name, $type, $price) {
                    return array_combine(
                        ['sira', 'fadi', 'ozellik'],
                        [$name, $type, $price]
                    );
                }, $fsira, $fadi, $fozellik);

                foreach ($result as $filtre) {

                    $filtresira = $filtre['sira'];
                    $filtreadi = $filtre['fadi'];
                    $filtreozellik = $filtre['ozellik'];
                    $kid = $ozy->lastInsertId();
                    $fstmt = $ozy->prepare("INSERT INTO filtre (sira, fadi, ozellik, kategori) 
VALUES (?,?,?,?)");
                    $result2f = $fstmt->execute(array($filtresira, $filtreadi, $filtreozellik, $kid));
                }
                ////FİLTRE EKLEME KODLARI BİTİŞ////      

                if (!empty($_FILES['yanresim']['name'])) {
                    if ($favtip != 'image/jpeg' && $favtip != 'image/png' && $favuzanti != '.jpg' && $favuzanti != '.png' && $favuzanti != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {

                        $favekle = move_uploaded_file($favkonum, $favyol . '/' . $favyeniad);
                        $favekle = $ozy->prepare("update kategoriler set yanresim=? where id=?");
                        $favekle->execute(array($favyeniad, $id));
                    }
                }

                if (!empty($_FILES['ikon']['name'])) {
                    if ($favtip1 != 'image/jpeg' && $favtip1 != 'image/png' && $favuzanti1 != '.jpg' && $favuzanti1 != '.png' && $favuzanti1 != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {
                        $faveklem = move_uploaded_file($favkonum1, $favyol1 . '/' . $favyeniad1);
                        $faveklem = $ozy->prepare("update kategoriler set ikon=? where id=?");
                        $faveklem->execute(array($favyeniad1, $id));
                    }
                }

                if (!empty($_FILES['nikon']['name'])) {
                    if ($nfavtip1 != 'image/jpeg' && $nfavtip1 != 'image/png' && $nfavuzanti1 != '.jpg' && $nfavuzanti1 != '.png' && $nfavuzanti1 != '.jpeg') {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                    } else {
                        $nfaveklem = move_uploaded_file($nfavkonum1, $nfavyol1 . '/' . $nfavyeniad1);
                        $nfaveklem = $ozy->prepare("update kategoriler set nikon=? where id=?");
                        $nfaveklem->execute(array($nfavyeniad1, $id));
                    }
                }


                if ($result2) {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
                    echo '<meta http-equiv="refresh" content="1; url=' . $url . '/boss/kategori/duzenle/' . $katidmiz . '">';
                } else {

                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
                }
            }
        }
    }

    ////Sayfa oluşturma kodları bitiş






}






?>


<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Kategoriler</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Kategoriler</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card m-b-30">
                    <div class="card-body" style="max-height: 715px !important;overflow: auto;overflow-x: hidden;border: 1px solid #cccccd;">

                        <h4 class="mt-0 header-title">Kategori Listesi</h4>
                        <p class="sub-title">Sitenizdeki tüm kategorileri burada görebilirsiniz.</p>

                        <div class="custom-dd dd">

                            <?php



                            function kategori_listele($kategori_id = 0)
                            {

                                global $ozy;

                                $kategori_listele = $ozy->prepare("select nikon, seo, id, ustkat, adi from kategoriler where ustkat=:id order by sira desc");
                                $kategori_listele->execute(array("id" => $kategori_id));
                                echo '<ol class="dd-list">';

                                while ($kategoriler_dizisi = $kategori_listele->fetch(PDO::FETCH_ASSOC)) {

                                    $kategori_id = $kategoriler_dizisi["id"];
                                    $ana_kategori_id = $kategoriler_dizisi["ustkat"];
                                    $kategori_adi = $kategoriler_dizisi["adi"];
                                    $kategori_ikon = $kategoriler_dizisi["nikon"];
                                    $kategori_seo = $kategoriler_dizisi["seo"]; ?>

                                    <li class='dd-item'>
                                        <div class='dd-handle'>
                                            <?php if ($kategori_ikon == '') { ?>
                                            <?php } else { ?>
                                                <img style="width: 16px;height: 16px;" src="../resimler/kategoriler/<?php echo $kategori_ikon; ?>"></img>
                                            <?php } ?>
                                            <?php echo $kategori_adi; ?>
                                            <div style="width: 100px !important;float: right;margin-right: -36px;margin-top: -2px;">
                                                <a href="tum-kategoriler?temizle=<?php echo $kategori_id;  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>
                                                <a href="kategori/duzenle/<?php echo $kategori_id ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            </div>
                                        </div>


                                <?php $sql_say = $ozy->prepare("select * from kategoriler where ustkat=:id order by sira desc");
                                    $sql_say->execute(array("id" => $kategori_id));
                                    $alt_kategori_say = $sql_say->rowcount();

                                    // Alt kategori sayısı 0 dan büyük ise aynı fonksiyon tekrar kullanılacak
                                    if ($alt_kategori_say > 0) {
                                        kategori_listele($kategori_id);
                                    }

                                    echo "</li>";
                                }

                                echo "</ol>";
                            }

                            kategori_listele();









                                ?>


                        </div>

                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-lg-8">
                <div class="card m-b-30">
                    <div class="card-body">

                        <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">
                                                <span class="d-none d-md-block">Genel Ayarlar</span><span class="d-block d-md-none"><i class="mdi mdi-airplay h5"></i></span>
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
                                                <span class="d-none d-md-block">Kategori Resim Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-folder-multiple-outline h5"></i></span>
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-toggle="tab" href="#profile-2" role="tab">
                                                <span class="d-none d-md-block">Filtreleme Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-folder-multiple-outline h5"></i></span>
                                            </a>
                                        </li>
                                        <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-toggle="tab" href="#messages-1" role="tab">
                                                    <span class="d-none d-md-block">Seo Ayarları</span><span class="d-block d-md-none"><i class="mdi mdi-guitar-pick-outline h5"></i></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>


                                    <div class="tab-content">








                                        <div class="tab-pane active p-3" id="home-1" role="tabpanel">


                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Kategori Sırası</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" value="<?php echo $sayfam['sira']; ?>" name="siram">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Kategori Adı</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" value="<?php echo $sayfam['adi']; ?>" name="adi" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Varsa Üst Kategori</label>
                                                <div class="controls">
                                                    <select name="ustkat" class="form-control">
                                                        <option selected value="0">Yok</option>
                                                        <?php foreach ($category_list as $category) { ?>
                                                            <option value="<?php echo $category->id; ?>" <?php if ($category->id == $sayfam['ustkat']) { ?> selected="selected" <?php } ?>><?php echo $category->adi; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <?php if ($_GET['duzenle']) { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Durumu</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" <?php if ($sayfam['durum'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum">
                                                    </div>

                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Durumu</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" checked="" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum">
                                                    </div>

                                                </div>

                                            <?php } ?>


                                            <?php if ($_GET['duzenle']) { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Açılır Kategori</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" <?php if ($sayfam['ac'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ac">
                                                    </div>

                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Açılır Kategori</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ac">
                                                    </div>

                                                </div>

                                            <?php } ?>

                                            <?php if ($_GET['duzenle']) { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Üst Menüde Göster</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" <?php if ($sayfam['ustgoster'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ustgoster">
                                                    </div>

                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Üst Menüde Göster</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ustgoster">
                                                    </div>

                                                </div>

                                            <?php } ?>

                                            <?php if ($_GET['duzenle']) { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Kategoriyi Storyde Göster</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" <?php if ($sayfam['ikongoster'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ikongoster">
                                                    </div>

                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Kategoriyi Storyde Göster</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="ikongoster">
                                                    </div>

                                                </div>

                                            <?php } ?>



                                            <?php if ($_GET['duzenle']) { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfada Göster</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" <?php if ($sayfam['agoster'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="agoster">
                                                    </div>

                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfada Göster</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="agoster">
                                                    </div>

                                                </div>

                                            <?php } ?>

                                        </div>




                                        <div class="tab-pane p-3" id="profile-1" role="tabpanel">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kategori Arkaplan Rengi</label>
                                                <div class="controls">
                                                    <input id="example-color-input" style="width: 600px !important;" type="color" class="form-control" value="<?php echo $sayfam['renk']; ?>" name="renk">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Kategori İkonu</label>
                                                <div class="col-sm-10">

                                                    <div class="controls">
                                                        <div class="fileupload fileupload-new" data-provides="fileupload">



                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                                            <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">

                                                                <?php if ($_GET['duzenle']) { ?>
                                                                    <img src="../resimler/kategoriler/<?php echo $sayfam['nikon']; ?>" style="width: 200px; height: 200px;" alt="" />
                                                                <?php } else { ?>
                                                                    <img src="assets/images/resimyok.jpg" alt="" />
                                                                <?php } ?>

                                                            </div>
                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                            <div>
                                                                <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                                                    <input name="nikon" type="file" class="default" />
                                                                </span>
                                                                <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>







                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label"><?php echo $temamiz['t49']; ?></label>
                                                <div class="col-sm-10">

                                                    <div class="controls">
                                                        <div class="fileupload fileupload-new" data-provides="fileupload">



                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                                            <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">





                                                                <?php if ($_GET['duzenle']) { ?>
                                                                    <img src="../resimler/kategoriler/<?php echo $sayfam['resim']; ?>" style="width: 200px; height: 200px;" alt="" />
                                                                <?php } else { ?>
                                                                    <img src="assets/images/resimyok.jpg" alt="" />
                                                                <?php } ?>

                                                            </div>
                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                            <div>
                                                                <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                                                    <input name="resim" type="file" class="default" />
                                                                </span>
                                                                <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>







                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label"><?php echo $temamiz['t48']; ?></label>
                                                <div class="col-sm-10">

                                                    <div class="controls">
                                                        <div class="fileupload fileupload-new" data-provides="fileupload">



                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                                            <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">





                                                                <?php if ($_GET['duzenle']) { ?>
                                                                    <img src="../resimler/kategoriler/<?php echo $sayfam['ikon']; ?>" style="width: 200px; height: 200px;" alt="" />
                                                                <?php } else { ?>
                                                                    <img src="assets/images/resimyok.jpg" alt="" />
                                                                <?php } ?>

                                                            </div>
                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                            <div>
                                                                <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                                                    <input name="ikon" type="file" class="default" />
                                                                </span>
                                                                <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>










                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label"><?php echo $temamiz['t47']; ?></label>
                                                <div class="col-sm-10">

                                                    <div class="controls">
                                                        <div class="fileupload fileupload-new" data-provides="fileupload">



                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                                            <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">








                                                                <?php if ($_GET['duzenle']) { ?>
                                                                    <img src="../resimler/kategoriler/<?php echo $sayfam['yanresim']; ?>" style="width: 200px; height: 200px;" alt="" />
                                                                <?php } else { ?>
                                                                    <img src="assets/images/resimyok.jpg" alt="" />
                                                                <?php } ?>

                                                            </div>
                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                            <div>
                                                                <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                                                    <input name="yanresim" type="file" class="default" />
                                                                </span>
                                                                <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>



                                        </div>




                                        <div class="tab-pane p-3" id="profile-2" role="tabpanel">

                                            <?php if ($_GET['duzenle']) { ?>
                                                <form action="" method="post">

                                                    <?php
                                                    $ozsorgu = $ozy->prepare("SELECT COUNT(*) FROM filtre where FIND_IN_SET($id,kategori)");
                                                    $ozsorgu->execute();
                                                    $ozelliksay = $ozsorgu->fetchColumn();
                                                    if ($ozelliksay == '0') { ?>

                                                        <ul id="fieldList" style="background: #f1efef;padding: 20px;margin: 0px !important;width: 100% !important;">

                                                            </br>
                                                        </ul>
                                                    <?php } else { ?>

                                                        <?php $fbak = $ozy->query("select * from filtre where FIND_IN_SET($id,kategori) order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($fbak as $filtrebak) { ?>
                                                            <ul id="fieldList" style="background: #f1efef;padding: 20px;margin: 0px !important;width: 100% !important;">
                                                                <input type="hidden" value="<?php echo $filtrebak['fid']; ?>" name="fid[]" />
                                                                <input type="text" class="form-control" style="margin-bottom: 5px;" value="<?php echo $filtrebak['sira']; ?>" name="sira[]" placeholder="Filtre Sırası (En yüksek değer en önde sıralanır.)" />
                                                                <input type="text" class="form-control" style="margin-bottom: 5px;" value="<?php echo $filtrebak['fadi']; ?>" name="fadi[]" placeholder="Filtre Ana Başlık" />
                                                                <input type="text" class="form-control" style="margin-bottom: 5px;" value="<?php echo $filtrebak['ozellik']; ?>" name="ozellik[]" data-role="tagsinput" placeholder="Filtrelenecek Öğeler" />
                                                                <a style="margin-bottom: 10px;width: 100%;margin-top:10px;" href="kategori/duzenle/<?php echo $_GET['duzenle'];  ?>?fsil=<?php echo $filtrebak['fid'];  ?>" onclick="return confirm('Bu filtreleme özelliğini silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i><?php echo $filtrebak['fadi'];  ?> Özelliğini Sil</a>
                                                                </br>
                                                            </ul>
                                                        <?php } ?>

                                                    <?php } ?>

                                                    <button style="margin-top: 20px;width: 100% !important;" class="btn btn-warning waves-effect waves-light" id="addMore">Yeni Filtreme Alanı Ekle</button>
                                                </form>

                                            <?php } else { ?>

                                                <form action="" method="post">
                                                    <ul id="fieldList" style="background: #f1efef;padding: 20px;margin: 0px !important;width: 100% !important;">

                                                    </ul>
                                                    <button style="margin-top: 20px;width: 100% !important;" class="btn btn-warning waves-effect waves-light" id="addMore">Yeni Filtreme Alanı Ekle</button>
                                                </form>

                                            <?php } ?>

                                        </div>







                                        <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>

                                            <div class="tab-pane p-3" id="messages-1" role="tabpanel">


                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Kategori Özel Titlesi</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" value="<?php echo $sayfam['stitle']; ?>" name="stitle">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Kategori Özel Keyword</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" data-role="tagsinput" value="<?php echo $sayfam['skey']; ?>" name="skey">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Kategori Özel Açıklaması</label>
                                                    <div class="controls">
                                                        <textarea id="textarea" class="form-control" rows="6" name="sdesc"><?php echo $sayfam['sdesc']; ?></textarea>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Seo Durumu</label>
                                                    <div class="col-sm-10">
                                                        <input type="checkbox" <?php if ($sayfam['seodurum'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="seodurum">
                                                    </div>

                                                </div>




                                            </div>
                                        <?php } ?>






                                    </div>




                                    <?php if ($_GET['duzenle']) { ?>

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
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->
<script>
    $(function() {
        $("#addMore").click(function(e) {
            e.preventDefault();
            $("#fieldList").append("</br>");
            $("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control' name='sira[]' placeholder='Filtre Sırası (En yüksek değer en önde sıralanır.)'/>");
            $("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control' name='fadi[]' placeholder='Filtre Ana Başlık'>");
            $("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control tags-input' name='ozellik[]' data-role='tagsinput' placeholder='Filtrelenecek Öğeler'>");
            $('.tags-input').tagsinput('refresh');
        });
    });
</script>
<style>
    .custom-dd .dd-list .dd-item .dd-handle {
        background: #f1efef;
        border: 1px solid #f0f4f7;
        padding: 0px !important;
        height: auto;
        font-size: 14px;
        font-weight: normal;
        border-radius: 3px;
        padding-top: 5px !important;
        padding-bottom: 5px !important;
        padding-left: 5px !important;
        color: #727e8e;
    }
</style>