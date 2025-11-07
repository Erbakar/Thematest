<?php
admin_yetki($ozy, $_SESSION['departmanid'], 4);
if ($_GET['duzenle']) {
    $id = temizle($_GET['duzenle']);
    $ekresimid = temizle($_GET['duzenle']);
    $sayfam = $ozy->query("select * from urunler where id=$id")->fetch(PDO::FETCH_ASSOC);
    if (isset($_GET['eksil'])) {

        $ekid = temizle($_GET['eksil']);
        $fsayfasil = $ozy->prepare("delete from anaozellik where id='$ekid'");
        $fsayfasil->execute(array($ekid));
        $fsayfasilx = $ozy->prepare("delete from anaozellikalt where anaid='$ekid'");
        $fsayfasilx->execute(array($ekid));
        if ($fsayfasil) {


            echo '<meta http-equiv="refresh" content="0; url=' . $url . '/boss/urun/duzenle/' . $id . '">';
        }
    }


    ///Sayfa güncelleme kodları başlangıç
    if (isset($_POST['guncelle'])) {



        $adi = str_replace('/', '', $_POST['adi']);
        $aciklama = $_POST['aciklama'];
        if ($_POST['seo'] == '') {
            $seo = "" . seo($adi) . "-" . $id . "";
        } else {
            $seo = seo($_POST['seo']);
        }
        $hit = "0";
        $durum = temizle($_POST['durum']);
        $sira_temp = temizle($_POST['sira']);
        $sira = (trim($sira_temp) === '' || $sira_temp === null) ? 0 : intval($sira_temp);
        $seodurum = temizle($_POST['seodurum']);
        $stitle = temizle($_POST['stitle']);
        $skey = temizle($_POST['skey']);
        $sdesc = temizle($_POST['sdesc']);
        $tarih = date('d.m.Y H:i:s');
        $urunkodu = temizle($_POST['urunkodu']);
        $urunbarkodu = temizle($_POST['urunbarkodu']);
        $idurum = ($_POST['idurum'] != "") ? $_POST['idurum'] : "0";
        $kdv = ($_POST['kdv'] != "") ? $_POST['kdv'] : "0";
        if ($_POST['kdv'] > '0') {

            if ($system['kdvdahil'] == '0') {

                if ($sayfam['fiyat'] == $_POST['fiyat']) {
                    $fiyat = $sayfam['fiyat'];
                } else {
                    $fiyat = KdvHaric($_POST['fiyat'], $_POST['kdv']);
                }
                if ($sayfam['ifiyat'] == $_POST['ifiyat']) {
                    $ifiyat = $sayfam['ifiyat'];
                } else {
                    $ifiyat_temp = trim($_POST['ifiyat']) !== '' ? KdvHaric($_POST['ifiyat'], $_POST['kdv']) : 0;
                    $ifiyat = ($ifiyat_temp !== '' && $ifiyat_temp !== null) ? floatval($ifiyat_temp) : 0;
                }
                if ($sayfam['hfiyat'] == $_POST['hfiyat']) {
                    $hfiyat = $sayfam['hfiyat'];
                } else {
                    $hfiyat_temp = trim($_POST['hfiyat']) !== '' ? KdvHaric($_POST['hfiyat'], $_POST['kdv']) : 0;
                    $hfiyat = ($hfiyat_temp !== '' && $hfiyat_temp !== null) ? floatval($hfiyat_temp) : 0;
                }
            } else {
                $fiyat = ($_POST['fiyat'] != "") ? $_POST['fiyat'] : "0";
                $ifiyat_temp = trim($_POST['ifiyat']);
                $ifiyat = ($ifiyat_temp !== '' && $ifiyat_temp !== null) ? floatval($ifiyat_temp) : 0;
                $hfiyat_temp = trim($_POST['hfiyat']);
                $hfiyat = ($hfiyat_temp !== '' && $hfiyat_temp !== null) ? floatval($hfiyat_temp) : 0;
            }
        } else {

            if ($system['kdvdahil'] == '0') {
                if ($sayfam['fiyat'] == $_POST['fiyat']) {
                    $fiyat = $sayfam['fiyat'];
                } else {
                    $fiyat = $_POST['fiyat'];
                }
                if ($sayfam['ifiyat'] == $_POST['ifiyat']) {
                    $ifiyat = $sayfam['ifiyat'];
                } else {
                    $ifiyat_temp = trim($_POST['ifiyat']);
                    $ifiyat = ($ifiyat_temp !== '' && $ifiyat_temp !== null) ? floatval($ifiyat_temp) : 0;
                }
                if ($sayfam['hfiyat'] == $_POST['hfiyat']) {
                    $hfiyat = $sayfam['hfiyat'];
                } else {
                    $hfiyat_temp = trim($_POST['hfiyat']);
                    $hfiyat = ($hfiyat_temp !== '' && $hfiyat_temp !== null) ? floatval($hfiyat_temp) : 0;
                }
            } else {
                $fiyat = ($_POST['fiyat'] != "") ? $_POST['fiyat'] : "0";
                $ifiyat_temp = trim($_POST['ifiyat']);
                $ifiyat = ($ifiyat_temp !== '' && $ifiyat_temp !== null) ? floatval($ifiyat_temp) : 0;
                $hfiyat_temp = trim($_POST['hfiyat']);
                $hfiyat = ($hfiyat_temp !== '' && $hfiyat_temp !== null) ? floatval($hfiyat_temp) : 0;
            }
        }
        $havaledurum = ($_POST['havaledurum'] != "") ? $_POST['havaledurum'] : "0";

        $parabirimi = temizle($_POST['parabirimi']);
        $dolar = ($_POST['dolar'] != "") ? $_POST['dolar'] : "0";
        $idolar = ($_POST['idolar'] != "") ? $_POST['idolar'] : "0";
        $euro = ($_POST['euro'] != "") ? $_POST['euro'] : "0";
        $ieuro = ($_POST['ieuro'] != "") ? $_POST['ieuro'] : "0";
        $kisa = temizle($_POST['kisa']);
        $instagram = " ";
        $stok = temizle($_POST['stok']);
        $kategorim = $_POST["kategori"];
        $kategori = implode(",", $kategorim);
        $marka = temizle($_POST['marka']);
        $kdv = ($_POST['kdv'] != "") ? $_POST['kdv'] : "0";
        $agoster = ($_POST['agoster'] != "") ? $_POST['agoster'] : "0";
        $yeni = ($_POST['yeni'] != "") ? $_POST['yeni'] : "0";
        $populer = ($_POST['populer'] != "") ? $_POST['populer'] : "0";
        $coksatan = ($_POST['coksatan'] != "") ? $_POST['coksatan'] : "0";
        $firsat = ($_POST['firsat'] != "") ? $_POST['firsat'] : "0";
        $firsatsaat = ($_POST['firsatsaat'] != "") ? $_POST['firsatsaat'] : "0";
        $filtre = $_POST['filtre'];
        $ucretsizkargo = ($_POST['ucretsizkargo'] != "") ? $_POST['ucretsizkargo'] : "0";
        $alode = ($_POST['alode'] != "") ? $_POST['alode'] : "0";
        $al_temp = trim($_POST['al']);
        $al = ($al_temp !== '' && $al_temp !== null) ? intval($al_temp) : 0;
        $ode_temp = trim($_POST['ode']);
        $ode = ($ode_temp !== '' && $ode_temp !== null) ? intval($ode_temp) : 0;

        $reskonum = $_FILES['resim']['tmp_name'];
        $resad = $_FILES['resim']['name'];
        $restip = $_FILES['resim']['type'];
        $resboyut = $_FILES['resim']['size'];
        $reserror = $_FILES['resim']['error'];
        $uzanti = strtolower(pathinfo($resad, PATHINFO_EXTENSION));
        $resimadi = md5(uniqid(rand(1000, 9999) . time() . $resad)) . '.' . $uzanti;
        $yol = "../resimler/urunler";
        
        // Klasör yazma izni kontrolü
        if (!is_writable($yol)) {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Hata: Resim klasörüne yazma izni yok. Lütfen yönetici ile iletişime geçin.", "Klasör Hatası");});</script>';
            return;
        }

        if (!empty($_FILES['resim']['name'])) {
            // Upload hata kontrolü
            if ($reserror !== UPLOAD_ERR_OK) {
                $hataMesajlari = array(
                    UPLOAD_ERR_INI_SIZE => 'Dosya boyutu PHP ini dosyasında belirlenen maksimum boyutu aşıyor.',
                    UPLOAD_ERR_FORM_SIZE => 'Dosya boyutu HTML formunda belirlenen maksimum boyutu aşıyor.',
                    UPLOAD_ERR_PARTIAL => 'Dosya sadece kısmen yüklendi.',
                    UPLOAD_ERR_NO_FILE => 'Hiçbir dosya yüklenmedi.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Geçici klasör bulunamadı.',
                    UPLOAD_ERR_CANT_WRITE => 'Dosya diske yazılamadı.',
                    UPLOAD_ERR_EXTENSION => 'Bir PHP eklentisi dosya yüklemeyi durdurdu.'
                );
                $hataMesaji = isset($hataMesajlari[$reserror]) ? $hataMesajlari[$reserror] : 'Bilinmeyen bir hata oluştu. (Hata Kodu: ' . $reserror . ')';
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("' . addslashes($hataMesaji) . '", "Yükleme Hatası");});</script>';
                return;
            }
            // Dosya boyutu kontrolü (10MB maksimum)
            elseif ($resboyut > 10485760) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Dosya boyutu çok büyük! Maksimum dosya boyutu: 10 MB. Lütfen daha küçük bir resim seçin.", "Dosya Boyutu Hatası");});</script>';
                return;
            }
            // Dosya format kontrolü
            elseif (!in_array(strtolower($uzanti), array('jpg', 'jpeg', 'png')) || !in_array($restip, array('image/jpeg', 'image/png'))) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Geçersiz dosya formatı! Sadece JPG, JPEG ve PNG formatları desteklenmektedir. (Yüklenen: ' . addslashes($resad) . ')", "Format Hatası");});</script>';
                return;
            }
            // Gerçek resim dosyası kontrolü
            elseif (!getimagesize($reskonum)) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Yüklenen dosya geçerli bir resim dosyası değil veya dosya bozuk. Lütfen başka bir resim deneyin.", "Resim Dosyası Hatası");});</script>';
                return;
            }
            else {
                $ekle = move_uploaded_file($reskonum, $yol . '/' . $resimadi);
                
                if (!$ekle) {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Resim yüklenirken bir hata oluştu. Dosya yazılamadı. Lütfen yönetici ile iletişime geçin.", "Yükleme Hatası");});</script>';
                } else {
                    $id = $_GET['duzenle'];
                    echo '<script>console.log("[DB DEBUG] Ürün güncelleme başlatılıyor... ID: ' . $id . '");</script>';
                    $stmt = $ozy->prepare("UPDATE urunler SET adi = ?, aciklama = ?, seo = ?, durum = ?, sira = ?, seodurum = ?, stitle = ?, skey = ?, sdesc = ?, resim = ? , urunkodu = ?, urunbarkodu = ?, fiyat = ?, idurum = ?, ifiyat = ?, parabirimi = ?, dolar = ?, idolar = ?, euro = ?, ieuro = ?, kisa = ?, instagram = ?, stok = ?, kategori = ?, marka = ?, kdv = ?, agoster = ?, yeni = ?, populer = ?, coksatan = ?, firsat = ?, firsatsaat = ?, filtre = ?, havaledurum = ?, hfiyat = ?, ucretsizkargo = ?, alode = ?, al = ?, ode = ? WHERE id = ?");
                    $result2 = $stmt->execute(array($adi, $aciklama, $seo, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $resimadi, $urunkodu, $urunbarkodu, $fiyat, $idurum, $ifiyat, $parabirimi, $dolar, $idolar, $euro, $ieuro, $kisa, $instagram, $stok, $kategori, $marka, $kdv, $agoster, $yeni, $populer, $coksatan, $firsat, $firsatsaat, $filtre, $havaledurum, $hfiyat, $ucretsizkargo, $alode, $al, $ode, $id));
                    if ($result2) {
                        echo '<script>console.log("[DB DEBUG] ✅ UPDATE urunler BAŞARILI - ID: ' . $id . ', Ürün: ' . addslashes($adi) . '");</script>';
                    } else {
                        $errorInfo = $stmt->errorInfo();
                        echo '<script>console.error("[DB DEBUG] ❌ UPDATE urunler BAŞARISIZ - ID: ' . $id . '");</script>';
                        echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorInfo, JSON_UNESCAPED_UNICODE) . ');</script>';
                    }

                $temakonumv1 = $_FILES['firsatresim']['tmp_name'];
                $temaadv1 = $_FILES['firsatresim']['name'];
                $tematipv1 = $_FILES['firsatresim']['type'];
                $temaboyutv1 = $_FILES['firsatresim']['size'];
                $temaerrorv1 = $_FILES['firsatresim']['error'];
                $tuzanti1 = strtolower(pathinfo($temaadv1, PATHINFO_EXTENSION));
                $firsatresim = md5(uniqid(rand(1000, 9999) . time())) . '.' . $tuzanti1;
                $temav1yol = "../resimler/genel";
                
                if (!empty($_FILES['firsatresim']['name'])) {
                    // Upload hata kontrolü
                    if ($temaerrorv1 !== UPLOAD_ERR_OK) {
                        $hataMesajlariFirsat = array(
                            UPLOAD_ERR_INI_SIZE => 'Fırsat resmi dosya boyutu PHP ini dosyasında belirlenen maksimum boyutu aşıyor.',
                            UPLOAD_ERR_FORM_SIZE => 'Fırsat resmi dosya boyutu HTML formunda belirlenen maksimum boyutu aşıyor.',
                            UPLOAD_ERR_PARTIAL => 'Fırsat resmi dosyası sadece kısmen yüklendi.',
                            UPLOAD_ERR_NO_FILE => 'Hiçbir fırsat resmi dosyası yüklenmedi.',
                            UPLOAD_ERR_NO_TMP_DIR => 'Geçici klasör bulunamadı.',
                            UPLOAD_ERR_CANT_WRITE => 'Fırsat resmi dosyası diske yazılamadı.',
                            UPLOAD_ERR_EXTENSION => 'Bir PHP eklentisi fırsat resmi dosya yüklemeyi durdurdu.'
                        );
                        $hataMesajiFirsat = isset($hataMesajlariFirsat[$temaerrorv1]) ? $hataMesajlariFirsat[$temaerrorv1] : 'Bilinmeyen bir hata oluştu. (Hata Kodu: ' . $temaerrorv1 . ')';
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("' . addslashes($hataMesajiFirsat) . '", "Fırsat Resmi Yükleme Hatası");});</script>';
                    }
                    // Dosya boyutu kontrolü (10MB maksimum)
                    elseif ($temaboyutv1 > 10485760) {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Fırsat resmi dosya boyutu çok büyük! Maksimum dosya boyutu: 10 MB. Lütfen daha küçük bir resim seçin.", "Fırsat Resmi Dosya Boyutu Hatası");});</script>';
                    }
                    // Dosya format kontrolü
                    elseif (!in_array(strtolower($tuzanti1), array('jpg', 'jpeg', 'png')) || !in_array($tematipv1, array('image/jpeg', 'image/png'))) {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Geçersiz fırsat resmi formatı! Sadece JPG, JPEG ve PNG formatları desteklenmektedir. (Yüklenen: ' . addslashes($temaadv1) . ')", "Fırsat Resmi Format Hatası");});</script>';
                    }
                    // Gerçek resim dosyası kontrolü
                    elseif (!getimagesize($temakonumv1)) {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Yüklenen fırsat resmi dosyası geçerli bir resim dosyası değil veya dosya bozuk. Lütfen başka bir resim deneyin.", "Fırsat Resmi Dosyası Hatası");});</script>';
                    }
                    else {
                        $temav1 = move_uploaded_file($temakonumv1, $temav1yol . '/' . $firsatresim);
                        
                        if (!$temav1) {
                            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Fırsat resmi yüklenirken bir hata oluştu. Dosya yazılamadı. Lütfen yönetici ile iletişime geçin.", "Fırsat Resmi Yükleme Hatası");});</script>';
                        } else {
                            echo '<script>console.log("[DB DEBUG] Fırsat resmi güncelleme başlatılıyor (güncelleme resimli)... ID: ' . $id . '");</script>';
                            $temav1Update = $ozy->prepare("update urunler set firsatresim=? where id='$id'");
                            $resultFirsatUpdate = $temav1Update->execute(array($firsatresim));
                            if ($resultFirsatUpdate) {
                                echo '<script>console.log("[DB DEBUG] ✅ UPDATE urunler.firsatresim BAŞARILI (güncelleme resimli) - ID: ' . $id . '");</script>';
                            } else {
                                $errorFirsatUpdate = $temav1Update->errorInfo();
                                echo '<script>console.error("[DB DEBUG] ❌ UPDATE urunler.firsatresim BAŞARISIZ (güncelleme resimli) - ID: ' . $id . '");</script>';
                                echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorFirsatUpdate, JSON_UNESCAPED_UNICODE) . ');</script>';
                            }
                        }
                    }
                }


                $a = 0;
                if (isset($_POST['ozellik_adi'])) {
                    $ozellikadi = $_POST['ozellik_adi'];
                    $ozelliktipi = $_POST['ozellik_tipi'];
                    foreach (array_combine($ozellikadi, $ozelliktipi) as $anaozellikgeldi => $tipgeldi) {
                        echo '<script>console.log("[DB DEBUG] Ana özellik ekleme başlatılıyor (güncelleme resimli)... Ürün ID: ' . $ekresimid . ', Özellik: ' . addslashes($anaozellikgeldi) . '");</script>';
                        $ekoz = $ozy->prepare("INSERT INTO anaozellik (urunid, adi, tip) 
            VALUES (?,?,?)");
                        $resultekoz = $ekoz->execute(array($ekresimid, $anaozellikgeldi, $tipgeldi));
                        $anaozellikid = $ozy->lastInsertId();
                        if ($resultekoz) {
                            echo '<script>console.log("[DB DEBUG] ✅ INSERT anaozellik BAŞARILI (güncelleme resimli) - ID: ' . $anaozellikid . ', Ürün ID: ' . $ekresimid . '");</script>';
                        } else {
                            $errorOzellikUpdate = $ekoz->errorInfo();
                            echo '<script>console.error("[DB DEBUG] ❌ INSERT anaozellik BAŞARISIZ (güncelleme resimli) - Ürün ID: ' . $ekresimid . '");</script>';
                            echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorOzellikUpdate, JSON_UNESCAPED_UNICODE) . ');</script>';
                        }
                        $aa = 0;
                        if (isset($_POST['alt_ozellik_adi' . $a])) {
                            foreach ($_POST['alt_ozellik_adi' . $a] as $altozellikverisi) {
                                $ekstok = $_POST['alt_ozellik_stok' . $a][$aa];
                                $zekfiyat = $_POST['alt_ozellik_fiyat' . $a][$aa];

                                if ($_POST['kdv'] > '0') {
                                    if ($system['kdvdahil'] == '0') {
                                        $ekfiyat = KdvHaric($zekfiyat, $_POST['kdv']);
                                    } else {
                                        $ekfiyat = ($zekfiyat != "") ? $zekfiyat : "0";
                                    }
                                } else {
                                    if ($system['kdvdahil'] == '0') {
                                        $ekfiyat = $zekfiyat;
                                    } else {
                                        $ekfiyat = ($zekfiyat != "") ? $zekfiyat : "0";
                                    }
                                }


                                echo '<script>console.log("[DB DEBUG] Alt özellik ekleme başlatılıyor (güncelleme resimli)... Ana ID: ' . $anaozellikid . ', Alt Özellik: ' . addslashes($altozellikverisi) . '");</script>';
                                $altekoz = $ozy->prepare("INSERT INTO anaozellikalt (anaid, adi, stok, fiyat, ustadi) 
                VALUES (?,?,?,?,?)");
                                $resultekaltoz = $altekoz->execute(array($anaozellikid, $altozellikverisi, $ekstok, $ekfiyat, $anaozellikgeldi));
                                if ($resultekaltoz) {
                                    $altOzellikIdUpdate = $ozy->lastInsertId();
                                    echo '<script>console.log("[DB DEBUG] ✅ INSERT anaozellikalt BAŞARILI (güncelleme resimli) - ID: ' . $altOzellikIdUpdate . ', Ana ID: ' . $anaozellikid . '");</script>';
                                } else {
                                    $errorAltOzellikUpdate = $altekoz->errorInfo();
                                    echo '<script>console.error("[DB DEBUG] ❌ INSERT anaozellikalt BAŞARISIZ (güncelleme resimli) - Ana ID: ' . $anaozellikid . '");</script>';
                                    echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorAltOzellikUpdate, JSON_UNESCAPED_UNICODE) . ');</script>';
                                }

                                $aa++;
                            }
                        }

                        $a++;
                    }
                }


                $aozellik = $ozy->prepare("SELECT * FROM anaozellik WHERE urunid = ?");
                $result = $aozellik->execute(array($ekresimid));
                foreach ($aozellik as $verimiz) {
                    $ustid = $verimiz['id'];
                    $altozellik = $ozy->prepare("SELECT * FROM anaozellikalt WHERE anaid = ?");
                    $resultalt = $altozellik->execute(array($ustid));
                    foreach ($altozellik as $altverimiz) {
                        $varozellik .= "" . $altverimiz['adi'] . ",";
                    }
                }


                $urunfiltrem = "" . $filtre . "," . $varozellik . ",";
                echo '<script>console.log("[DB DEBUG] Filtre güncelleme başlatılıyor (güncelleme resimli)... ID: ' . $id . '");</script>';
                $filtreyenile = $ozy->prepare("update urunler set filtre=? where id='$id'");
                $resultFiltreUpdate = $filtreyenile->execute(array($urunfiltrem));
                if ($resultFiltreUpdate) {
                    echo '<script>console.log("[DB DEBUG] ✅ UPDATE urunler.filtre BAŞARILI (güncelleme resimli) - ID: ' . $id . '");</script>';
                } else {
                    $errorFiltreUpdate = $filtreyenile->errorInfo();
                    echo '<script>console.error("[DB DEBUG] ❌ UPDATE urunler.filtre BAŞARISIZ (güncelleme resimli) - ID: ' . $id . '");</script>';
                    echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorFiltreUpdate, JSON_UNESCAPED_UNICODE) . ');</script>';
                }



                if ($result2) {
                    echo '<script>console.log("[DB DEBUG] ✅ TÜM İŞLEMLER TAMAMLANDI - Ürün güncellendi: ID ' . $id . '");</script>';
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
                    echo '<meta http-equiv="refresh" content="1; url=' . $url . '/boss/urun/duzenle/' . $id . '">';
                } else {

                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
                }
            }
        }
    } else {



            $id = $_GET['duzenle'];
            echo '<script>console.log("[DB DEBUG] Ürün güncelleme başlatılıyor (resimsiz)... ID: ' . $id . '");</script>';
            $stmt = $ozy->prepare("UPDATE urunler SET adi = ?, aciklama = ?, seo = ?, durum = ?, sira = ?, seodurum = ?, stitle = ?, skey = ?, sdesc = ? , urunkodu = ?, urunbarkodu = ?, fiyat = ?, idurum = ?, ifiyat = ?, parabirimi = ?, dolar = ?, idolar = ?, euro = ?, ieuro = ?, kisa = ?, instagram = ?,  stok = ?, kategori = ?, marka = ?, kdv = ?, agoster = ?, yeni = ?, populer = ?, coksatan = ?, firsat = ?, firsatsaat = ?, filtre = ?, havaledurum = ?, hfiyat = ?, ucretsizkargo = ?, alode = ?, al = ?, ode = ? WHERE id = ?");
            $result2 = $stmt->execute(array($adi, $aciklama, $seo, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $urunkodu, $urunbarkodu, $fiyat, $idurum, $ifiyat, $parabirimi, $dolar, $idolar, $euro, $ieuro, $kisa, $instagram, $stok, $kategori, $marka, $kdv, $agoster, $yeni, $populer, $coksatan, $firsat, $firsatsaat, $filtre, $havaledurum, $hfiyat, $ucretsizkargo, $alode, $al, $ode, $id));
            if ($result2) {
                echo '<script>console.log("[DB DEBUG] ✅ UPDATE urunler BAŞARILI (resimsiz) - ID: ' . $id . ', Ürün: ' . addslashes($adi) . '");</script>';
            } else {
                $errorInfo = $stmt->errorInfo();
                echo '<script>console.error("[DB DEBUG] ❌ UPDATE urunler BAŞARISIZ (resimsiz) - ID: ' . $id . '");</script>';
                echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorInfo, JSON_UNESCAPED_UNICODE) . ');</script>';
            }

            $temakonumv1 = $_FILES['firsatresim']['tmp_name'];
            $temaadv1 = $_FILES['firsatresim']['name'];
            $tematipv1 = $_FILES['firsatresim']['type'];
            $tuzanti1 = substr($temaadv1, -5, 5);
            $firsatresim = md5(uniqid(rand(1000, 9999) . time())) . $tuzanti1;
            $temav1yol = "../resimler/genel";
            if (!empty($_FILES['firsatresim']['name'])) {
                if ($tematipv1 != 'image/jpeg' && $tematipv1 != 'image/png' && $tuzanti1 != '.jpg' && $tuzanti1 != '.png' && $tuzanti1 != '.jpeg') {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                } else {
                    $temav1 = move_uploaded_file($temakonumv1, $temav1yol . '/' . $firsatresim);
                    $temav1 = $ozy->prepare("update urunler set firsatresim=? where id='$id'");
                    $temav1->execute(array($firsatresim));
                }
            }





            $a = 0;
            if (isset($_POST['ozellik_adi'])) {
                $ozellikadi = $_POST['ozellik_adi'];
                $ozelliktipi = $_POST['ozellik_tipi'];
                foreach (array_combine($ozellikadi, $ozelliktipi) as $anaozellikgeldi => $tipgeldi) {
                    $ekoz = $ozy->prepare("INSERT INTO anaozellik (urunid, adi, tip) 
            VALUES (?,?,?)");
                    $resultekoz = $ekoz->execute(array($ekresimid, $anaozellikgeldi, $tipgeldi));
                    $anaozellikid = $ozy->lastInsertId();

                    $aa = 0;
                    if (isset($_POST['alt_ozellik_adi' . $a])) {
                        foreach ($_POST['alt_ozellik_adi' . $a] as $altozellikverisi) {
                            $ekstok = $_POST['alt_ozellik_stok' . $a][$aa];
                            $zekfiyat = $_POST['alt_ozellik_fiyat' . $a][$aa];

                            if ($_POST['kdv'] > '0') {
                                if ($system['kdvdahil'] == '0') {
                                    $ekfiyat = KdvHaric($zekfiyat, $_POST['kdv']);
                                } else {
                                    $ekfiyat = ($zekfiyat != "") ? $zekfiyat : "0";
                                }
                            } else {
                                if ($system['kdvdahil'] == '0') {
                                    $ekfiyat = KdvHaric($zekfiyat, $system['kdv']);
                                } else {
                                    $ekfiyat = ($zekfiyat != "") ? $zekfiyat : "0";
                                }
                            }


                            $altekoz = $ozy->prepare("INSERT INTO anaozellikalt (anaid, adi, stok, fiyat, ustadi) 
                VALUES (?,?,?,?,?)");
                            $resultekaltoz = $altekoz->execute(array($anaozellikid, $altozellikverisi, $ekstok, $ekfiyat, $anaozellikgeldi));

                            $aa++;
                        }
                    }

                    $a++;
                }
            }

            $aozellik = $ozy->prepare("SELECT * FROM anaozellik WHERE urunid = ?");
            $result = $aozellik->execute(array($ekresimid));
            foreach ($aozellik as $verimiz) {
                $ustid = $verimiz['id'];
                $altozellik = $ozy->prepare("SELECT * FROM anaozellikalt WHERE anaid = ?");
                $resultalt = $altozellik->execute(array($ustid));
                foreach ($altozellik as $altverimiz) {
                    $varozellik .= "" . $altverimiz['adi'] . ",";
                }
            }


            $urunfiltrem = "" . $filtre . "," . $varozellik . ",";
            $filtreyenile = $ozy->prepare("update urunler set filtre=? where id='$id'");
            $filtreyenile->execute(array($urunfiltrem));




            if ($result2) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
                echo '<meta http-equiv="refresh" content="1; url=' . $url . '/boss/urun/duzenle/' . $id . '">';
            } else {

                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
            }
        }
    }



    ////Sayfa güncelleme kodları bitiş

} else {

    $q = $ozy->query("SHOW TABLE STATUS LIKE 'urunler'");
    $next = $q->fetch(PDO::FETCH_ASSOC);
    $ekresimid = $next['Auto_increment'];
    ////Sayfa oluşturma kodları başlangıç	

    if (isset($_POST['kaydet'])) {

        // Debug: Log form submission
        echo '<script>console.log("[DB DEBUG] ========== YENİ ÜRÜN EKLEME BAŞLATILIYOR ==========");</script>';
        echo '<script>console.log("[DB DEBUG] Form gönderildi - İşlem: Yeni ürün ekleme");</script>';
        error_log("Product addition form submitted");
        error_log("POST data: " . print_r($_POST, true));

        $adi = str_replace('/', '', $_POST['adi']);
        $aciklama = $_POST['aciklama'];
        if ($_POST['seo'] == '') {
            $seo = "" . seo($adi) . "-" . $ekresimid . "";
        } else {
            $seo = seo($_POST['seo']);
        }

        // Validate required fields
        if (empty($adi) || empty($aciklama) || empty($_POST['urunkodu']) || empty($_POST['urunbarkodu']) || empty($_POST['fiyat'])) {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen tüm zorunlu alanları doldurun!", "Hata");});</script>';
            error_log("Product addition failed: Missing required fields");
            return;
        }
        $hit = "0";
        $durum = ($_POST['durum'] != "") ? $_POST['durum'] : "0";
        $sira_temp = temizle($_POST['sira']);
        $sira = (trim($sira_temp) === '' || $sira_temp === null) ? 0 : intval($sira_temp);
        $seodurum = temizle($_POST['seodurum']);
        $stitle = temizle($_POST['stitle']);
        $skey = temizle($_POST['skey']);
        $sdesc = temizle($_POST['sdesc']);
        $tarih = date('d.m.Y H:i:s');
        $urunkodu = temizle($_POST['urunkodu']);
        $urunbarkodu = temizle($_POST['urunbarkodu']);
        $parabirimi = temizle($_POST['parabirimi']);
        $dolar = ($_POST['dolar'] != "") ? $_POST['dolar'] : "0";
        $idolar = ($_POST['idolar'] != "") ? $_POST['idolar'] : "0";
        $euro = ($_POST['euro'] != "") ? $_POST['euro'] : "0";
        $ieuro = ($_POST['ieuro'] != "") ? $_POST['ieuro'] : "0";
        $kisa = temizle($_POST['kisa']);
        $instagram = " ";
        $stok = temizle($_POST['stok']);
        $kategorim = $_POST["kategori"];
        $kategori = implode(",", $kategorim);
        $marka = temizle($_POST['marka']);
        $idurum = ($_POST['idurum'] != "") ? $_POST['idurum'] : "0";
        $kdv = ($_POST['kdv'] != "") ? $_POST['kdv'] : "0";
        if ($_POST['kdv'] > '0') {

            if ($system['kdvdahil'] == '0') {
                $fiyat = KdvHaric($_POST['fiyat'], $_POST['kdv']);
                $ifiyat_temp = trim($_POST['ifiyat']) !== '' ? KdvHaric($_POST['ifiyat'], $_POST['kdv']) : 0;
                $ifiyat = ($ifiyat_temp !== '' && $ifiyat_temp !== null) ? floatval($ifiyat_temp) : 0;
                $hfiyat_temp = trim($_POST['hfiyat']) !== '' ? KdvHaric($_POST['hfiyat'], $_POST['kdv']) : 0;
                $hfiyat = ($hfiyat_temp !== '' && $hfiyat_temp !== null) ? floatval($hfiyat_temp) : 0;
            } else {
                $fiyat = ($_POST['fiyat'] != "") ? $_POST['fiyat'] : "0";
                $ifiyat_temp = trim($_POST['ifiyat']);
                $ifiyat = ($ifiyat_temp !== '' && $ifiyat_temp !== null) ? floatval($ifiyat_temp) : 0;
                $hfiyat_temp = trim($_POST['hfiyat']);
                $hfiyat = ($hfiyat_temp !== '' && $hfiyat_temp !== null) ? floatval($hfiyat_temp) : 0;
            }
        } else {

            if ($system['kdvdahil'] == '0') {
                $fiyat = $_POST['fiyat'];
                $ifiyat_temp = trim($_POST['ifiyat']);
                $ifiyat = ($ifiyat_temp !== '' && $ifiyat_temp !== null) ? floatval($ifiyat_temp) : 0;
                $hfiyat_temp = trim($_POST['hfiyat']);
                $hfiyat = ($hfiyat_temp !== '' && $hfiyat_temp !== null) ? floatval($hfiyat_temp) : 0;
            } else {
                $fiyat = ($_POST['fiyat'] != "") ? $_POST['fiyat'] : "0";
                $ifiyat_temp = trim($_POST['ifiyat']);
                $ifiyat = ($ifiyat_temp !== '' && $ifiyat_temp !== null) ? floatval($ifiyat_temp) : 0;
                $hfiyat_temp = trim($_POST['hfiyat']);
                $hfiyat = ($hfiyat_temp !== '' && $hfiyat_temp !== null) ? floatval($hfiyat_temp) : 0;
            }
        }
        $havaledurum = ($_POST['havaledurum'] != "") ? $_POST['havaledurum'] : "0";
        $agoster = ($_POST['agoster'] != "") ? $_POST['agoster'] : "0";
        $yeni = ($_POST['yeni'] != "") ? $_POST['yeni'] : "0";
        $populer = ($_POST['populer'] != "") ? $_POST['populer'] : "0";
        $coksatan = ($_POST['coksatan'] != "") ? $_POST['coksatan'] : "0";
        $firsat = ($_POST['firsat'] != "") ? $_POST['firsat'] : "0";
        $firsatsaat = ($_POST['firsatsaat'] != "") ? $_POST['firsatsaat'] : "0";
        $filtre = $_POST['filtre'];
        $ucretsizkargo = ($_POST['ucretsizkargo'] != "") ? $_POST['ucretsizkargo'] : "0";
        $alode = ($_POST['alode'] != "") ? $_POST['alode'] : "0";
        $al_temp = trim($_POST['al']);
        $al = ($al_temp !== '' && $al_temp !== null) ? intval($al_temp) : 0;
        $ode_temp = trim($_POST['ode']);
        $ode = ($ode_temp !== '' && $ode_temp !== null) ? intval($ode_temp) : 0;



        $reskonum = $_FILES['resim']['tmp_name'];
        $resad = $_FILES['resim']['name'];
        $restip = $_FILES['resim']['type'];
        $resboyut = $_FILES['resim']['size'];
        $reserror = $_FILES['resim']['error'];
        $uzanti = strtolower(pathinfo($resad, PATHINFO_EXTENSION));
        $resimadi = md5(uniqid(rand(1000, 9999) . time() . $resad)) . '.' . $uzanti;
        $yol = "../resimler/urunler";
        
        // Klasör yazma izni kontrolü
        if (!is_writable($yol)) {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Hata: Resim klasörüne yazma izni yok. Lütfen yönetici ile iletişime geçin.", "Klasör Hatası");});</script>';
            return;
        }

        if (empty($_FILES['resim']['name'])) {

            $resimadi = "resimyok.jpg";

            // Debug: Log the insert attempt
            error_log("Attempting to insert product without image");
            error_log("Product name: " . $adi);
            error_log("Category: " . $kategori);
            error_log("Brand: " . $marka);

            try {
                echo '<script>console.log("[DB DEBUG] Ürün ekleme başlatılıyor (resimsiz)... Ürün: ' . addslashes($adi) . '");</script>';
                $stmt = $ozy->prepare("INSERT INTO urunler (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim, urunkodu, urunbarkodu, fiyat, idurum, ifiyat, parabirimi, dolar, idolar, euro, ieuro, kisa, instagram, stok, kategori, marka, kdv, agoster, yeni, populer, coksatan, firsat, firsatsaat, filtre, havaledurum, hfiyat, ucretsizkargo, alode, al, ode) 
       VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $result2 = $stmt->execute(array($adi, $aciklama, $seo, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $tarih, $resimadi, $urunkodu, $urunbarkodu, $fiyat, $idurum, $ifiyat, $parabirimi, $dolar, $idolar, $euro, $ieuro, $kisa, $instagram, $stok, $kategori, $marka, $kdv, $agoster, $yeni, $populer, $coksatan, $firsat, $firsatsaat, $filtre, $havaledurum, $hfiyat, $ucretsizkargo, $alode, $al, $ode));
                $id = $ozy->lastInsertId();

                if ($result2) {
                    echo '<script>console.log("[DB DEBUG] ✅ INSERT urunler BAŞARILI (resimsiz) - Yeni ID: ' . $id . ', Ürün: ' . addslashes($adi) . '");</script>';
                } else {
                    $errorInfo = $stmt->errorInfo();
                    echo '<script>console.error("[DB DEBUG] ❌ INSERT urunler BAŞARISIZ (resimsiz)");</script>';
                    echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorInfo, JSON_UNESCAPED_UNICODE) . ');</script>';
                    error_log("Database insert failed. Error info: " . print_r($errorInfo, true));
                }
            } catch (Exception $e) {
                echo '<script>console.error("[DB DEBUG] ❌ INSERT urunler EXCEPTION (resimsiz): ' . addslashes($e->getMessage()) . '");</script>';
                error_log("Exception during product insert: " . $e->getMessage());
                $result2 = false;
            }


            $temakonumv1 = $_FILES['firsatresim']['tmp_name'];
            $temaadv1 = $_FILES['firsatresim']['name'];
            $tematipv1 = $_FILES['firsatresim']['type'];
            $tuzanti1 = substr($temaadv1, -5, 5);
            $firsatresim = md5(uniqid(rand(1000, 9999) . time())) . $tuzanti1;
            $temav1yol = "../resimler/genel";
            if (!empty($_FILES['firsatresim']['name'])) {
                if ($tematipv1 != 'image/jpeg' && $tematipv1 != 'image/png' && $tuzanti1 != '.jpg' && $tuzanti1 != '.png' && $tuzanti1 != '.jpeg') {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';
                } else {
                    $temav1 = move_uploaded_file($temakonumv1, $temav1yol . '/' . $firsatresim);
                    $temav1 = $ozy->prepare("update urunler set firsatresim=? where id='$id'");
                    $temav1->execute(array($firsatresim));
                }
            }



            $a = 0;
            if (isset($_POST['ozellik_adi'])) {
                $ozellikadi = $_POST['ozellik_adi'];
                $ozelliktipi = $_POST['ozellik_tipi'];
                foreach (array_combine($ozellikadi, $ozelliktipi) as $anaozellikgeldi => $tipgeldi) {
                    $ekoz = $ozy->prepare("INSERT INTO anaozellik (urunid, adi, tip) 
            VALUES (?,?,?)");
                    $resultekoz = $ekoz->execute(array($ekresimid, $anaozellikgeldi, $tipgeldi));
                    $anaozellikid = $ozy->lastInsertId();


                    $aa = 0;
                    if (isset($_POST['alt_ozellik_adi' . $a])) {
                        foreach ($_POST['alt_ozellik_adi' . $a] as $altozellikverisi) {
                            $ekstok = $_POST['alt_ozellik_stok' . $a][$aa];
                            $zekfiyat = $_POST['alt_ozellik_fiyat' . $a][$aa];
                            if ($_POST['kdv'] > '0') {
                                if ($system['kdvdahil'] == '0') {
                                    $ekfiyat = KdvHaric($zekfiyat, $_POST['kdv']);
                                } else {
                                    $ekfiyat = ($zekfiyat != "") ? $zekfiyat : "0";
                                }
                            } else {
                                if ($system['kdvdahil'] == '0') {
                                    $ekfiyat = KdvHaric($zekfiyat, $system['kdv']);
                                } else {
                                    $ekfiyat = ($zekfiyat != "") ? $zekfiyat : "0";
                                }
                            }
                            $altekoz = $ozy->prepare("INSERT INTO anaozellikalt (anaid, adi, stok, fiyat, ustadi) 
                VALUES (?,?,?,?,?)");
                            $resultekaltoz = $altekoz->execute(array($anaozellikid, $altozellikverisi, $ekstok, $ekfiyat, $anaozellikgeldi));

                            $aa++;
                        }
                    }

                    $a++;
                }
            }

            $aozellik = $ozy->prepare("SELECT * FROM anaozellik WHERE urunid = ?");
            $result = $aozellik->execute(array($ekresimid));
            foreach ($aozellik as $verimiz) {
                $ustid = $verimiz['id'];
                $altozellik = $ozy->prepare("SELECT * FROM anaozellikalt WHERE anaid = ?");
                $resultalt = $altozellik->execute(array($ustid));
                foreach ($altozellik as $altverimiz) {
                    $varozellik .= "" . $altverimiz['adi'] . ",";
                }
            }


            // Sadece ürün başarıyla eklendiyse filtre güncelle
            if ($result2 && isset($id) && is_numeric($id) && $id > 0) {
                $urunfiltrem = "" . $filtre . "," . $varozellik . ",";
                echo '<script>console.log("[DB DEBUG] Filtre güncelleme başlatılıyor (yeni ekleme resimsiz)... ID: ' . $id . '");</script>';
                $filtreyenile = $ozy->prepare("update urunler set filtre=? where id='$id'");
                $resultFiltreNewNoImg = $filtreyenile->execute(array($urunfiltrem));
                if ($resultFiltreNewNoImg) {
                    echo '<script>console.log("[DB DEBUG] ✅ UPDATE urunler.filtre BAŞARILI (yeni ekleme resimsiz) - ID: ' . $id . '");</script>';
                } else {
                    $errorFiltreNewNoImg = $filtreyenile->errorInfo();
                    echo '<script>console.error("[DB DEBUG] ❌ UPDATE urunler.filtre BAŞARISIZ (yeni ekleme resimsiz) - ID: ' . $id . '");</script>';
                    echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorFiltreNewNoImg, JSON_UNESCAPED_UNICODE) . ');</script>';
                }
            } else {
                echo '<script>console.warn("[DB DEBUG] ⚠️ Filtre güncelleme atlandı - Ürün ekleme başarısız veya ID geçersiz. ID: ' . (isset($id) ? $id : 'yok') . '");</script>';
            }


            if ($result2) {
                echo '<script>console.log("[DB DEBUG] ✅ TÜM İŞLEMLER TAMAMLANDI - Yeni ürün eklendi: ID ' . $id . '");</script>';
                echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
                echo '<meta http-equiv="refresh" content="1; url=tum-urunler">';
            } else {
                // Detailed error logging for debugging
                $errorInfo = $stmt->errorInfo();
                error_log("Product insertion failed: " . print_r($errorInfo, true));
                error_log("SQL Query: INSERT INTO urunler (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim, urunkodu, urunbarkodu, fiyat, idurum, ifiyat, parabirimi, dolar, idolar, euro, ieuro, kisa, instagram,  stok, kategori, marka, kdv, agoster, yeni, populer, coksatan, firsat, firsatsaat, filtre, havaledurum, hfiyat, ucretsizkargo, alode, al, ode)");
                error_log("Parameters: " . print_r(array($adi, $aciklama, $seo, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $tarih, $resimadi, $urunkodu, $urunbarkodu, $fiyat, $idurum, $ifiyat, $parabirimi, $dolar, $idolar, $euro, $ieuro, $kisa, $instagram, $stok, $kategori, $marka, $kdv, $agoster, $yeni, $populer, $coksatan, $firsat, $firsatsaat, $filtre, $havaledurum, $hfiyat, $ucretsizkargo, $alode, $al, $ode), true));

                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Ürün eklenirken bir hata oluştu. Lütfen tüm gerekli alanları doldurun ve tekrar deneyin.", "Başarısız");});</script>';
            }
        } else {



            // Upload hata kontrolü
            if ($reserror !== UPLOAD_ERR_OK) {
                $hataMesajlari = array(
                    UPLOAD_ERR_INI_SIZE => 'Dosya boyutu PHP ini dosyasında belirlenen maksimum boyutu aşıyor.',
                    UPLOAD_ERR_FORM_SIZE => 'Dosya boyutu HTML formunda belirlenen maksimum boyutu aşıyor.',
                    UPLOAD_ERR_PARTIAL => 'Dosya sadece kısmen yüklendi.',
                    UPLOAD_ERR_NO_FILE => 'Hiçbir dosya yüklenmedi.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Geçici klasör bulunamadı.',
                    UPLOAD_ERR_CANT_WRITE => 'Dosya diske yazılamadı.',
                    UPLOAD_ERR_EXTENSION => 'Bir PHP eklentisi dosya yüklemeyi durdurdu.'
                );
                $hataMesaji = isset($hataMesajlari[$reserror]) ? $hataMesajlari[$reserror] : 'Bilinmeyen bir hata oluştu. (Hata Kodu: ' . $reserror . ')';
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("' . addslashes($hataMesaji) . '", "Yükleme Hatası");});</script>';
                return;
            }
            // Dosya boyutu kontrolü (10MB maksimum)
            elseif ($resboyut > 10485760) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Dosya boyutu çok büyük! Maksimum dosya boyutu: 10 MB. Lütfen daha küçük bir resim seçin.", "Dosya Boyutu Hatası");});</script>';
                return;
            }
            // Dosya format kontrolü
            elseif (!in_array(strtolower($uzanti), array('jpg', 'jpeg', 'png')) || !in_array($restip, array('image/jpeg', 'image/png'))) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Geçersiz dosya formatı! Sadece JPG, JPEG ve PNG formatları desteklenmektedir. (Yüklenen: ' . addslashes($resad) . ')", "Format Hatası");});</script>';
                return;
            }
            // Gerçek resim dosyası kontrolü
            elseif (!getimagesize($reskonum)) {
                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Yüklenen dosya geçerli bir resim dosyası değil veya dosya bozuk. Lütfen başka bir resim deneyin.", "Resim Dosyası Hatası");});</script>';
                return;
            }
            else {
                $ekle = move_uploaded_file($reskonum, $yol . '/' . $resimadi);
                
                if (!$ekle) {
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Resim yüklenirken bir hata oluştu. Dosya yazılamadı. Lütfen yönetici ile iletişime geçin.", "Yükleme Hatası");});</script>';
                    return;
                }

                // Debug: Log the insert attempt with image
                error_log("Attempting to insert product with image");
                error_log("Product name: " . $adi);
                error_log("Image uploaded: " . ($ekle ? 'success' : 'failed'));

                try {
                    echo '<script>console.log("[DB DEBUG] Ürün ekleme başlatılıyor (resimli)... Ürün: ' . addslashes($adi) . '");</script>';
                    $stmt = $ozy->prepare("INSERT INTO urunler (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim, urunkodu, urunbarkodu, fiyat, idurum, ifiyat, parabirimi, dolar, idolar, euro, ieuro, kisa, instagram, stok, kategori, marka, kdv, agoster, yeni, populer, coksatan, firsat, firsatsaat, filtre, havaledurum, hfiyat, ucretsizkargo, alode, al, ode) 
       VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $result2 = $stmt->execute(array($adi, $aciklama, $seo, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $tarih, $resimadi, $urunkodu, $urunbarkodu, $fiyat, $idurum, $ifiyat, $parabirimi, $dolar, $idolar, $euro, $ieuro, $kisa, $instagram, $stok, $kategori, $marka, $kdv, $agoster, $yeni, $populer, $coksatan, $firsat, $firsatsaat, $filtre, $havaledurum, $hfiyat, $ucretsizkargo, $alode, $al, $ode));
                    $id = $ozy->lastInsertId();

                    if ($result2) {
                        echo '<script>console.log("[DB DEBUG] ✅ INSERT urunler BAŞARILI (resimli) - Yeni ID: ' . $id . ', Ürün: ' . addslashes($adi) . '");</script>';
                    } else {
                        $errorInfo = $stmt->errorInfo();
                        echo '<script>console.error("[DB DEBUG] ❌ INSERT urunler BAŞARISIZ (resimli)");</script>';
                        echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorInfo, JSON_UNESCAPED_UNICODE) . ');</script>';
                        error_log("Database insert with image failed. Error info: " . print_r($errorInfo, true));
                    }
                } catch (Exception $e) {
                    echo '<script>console.error("[DB DEBUG] ❌ INSERT urunler EXCEPTION (resimli): ' . addslashes($e->getMessage()) . '");</script>';
                    error_log("Exception during product insert with image: " . $e->getMessage());
                    $result2 = false;
                }

                $temakonumv1 = $_FILES['firsatresim']['tmp_name'];
                $temaadv1 = $_FILES['firsatresim']['name'];
                $tematipv1 = $_FILES['firsatresim']['type'];
                $temaboyutv1 = $_FILES['firsatresim']['size'];
                $temaerrorv1 = $_FILES['firsatresim']['error'];
                $tuzanti1 = strtolower(pathinfo($temaadv1, PATHINFO_EXTENSION));
                $firsatresim = md5(uniqid(rand(1000, 9999) . time())) . '.' . $tuzanti1;
                $temav1yol = "../resimler/genel";
                
                if (!empty($_FILES['firsatresim']['name'])) {
                    // Upload hata kontrolü
                    if ($temaerrorv1 !== UPLOAD_ERR_OK) {
                        $hataMesajlariFirsat = array(
                            UPLOAD_ERR_INI_SIZE => 'Fırsat resmi dosya boyutu PHP ini dosyasında belirlenen maksimum boyutu aşıyor.',
                            UPLOAD_ERR_FORM_SIZE => 'Fırsat resmi dosya boyutu HTML formunda belirlenen maksimum boyutu aşıyor.',
                            UPLOAD_ERR_PARTIAL => 'Fırsat resmi dosyası sadece kısmen yüklendi.',
                            UPLOAD_ERR_NO_FILE => 'Hiçbir fırsat resmi dosyası yüklenmedi.',
                            UPLOAD_ERR_NO_TMP_DIR => 'Geçici klasör bulunamadı.',
                            UPLOAD_ERR_CANT_WRITE => 'Fırsat resmi dosyası diske yazılamadı.',
                            UPLOAD_ERR_EXTENSION => 'Bir PHP eklentisi fırsat resmi dosya yüklemeyi durdurdu.'
                        );
                        $hataMesajiFirsat = isset($hataMesajlariFirsat[$temaerrorv1]) ? $hataMesajlariFirsat[$temaerrorv1] : 'Bilinmeyen bir hata oluştu. (Hata Kodu: ' . $temaerrorv1 . ')';
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("' . addslashes($hataMesajiFirsat) . '", "Fırsat Resmi Yükleme Hatası");});</script>';
                    }
                    // Dosya boyutu kontrolü (10MB maksimum)
                    elseif ($temaboyutv1 > 10485760) {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Fırsat resmi dosya boyutu çok büyük! Maksimum dosya boyutu: 10 MB. Lütfen daha küçük bir resim seçin.", "Fırsat Resmi Dosya Boyutu Hatası");});</script>';
                    }
                    // Dosya format kontrolü
                    elseif (!in_array(strtolower($tuzanti1), array('jpg', 'jpeg', 'png')) || !in_array($tematipv1, array('image/jpeg', 'image/png'))) {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Geçersiz fırsat resmi formatı! Sadece JPG, JPEG ve PNG formatları desteklenmektedir. (Yüklenen: ' . addslashes($temaadv1) . ')", "Fırsat Resmi Format Hatası");});</script>';
                    }
                    // Gerçek resim dosyası kontrolü
                    elseif (!getimagesize($temakonumv1)) {
                        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Yüklenen fırsat resmi dosyası geçerli bir resim dosyası değil veya dosya bozuk. Lütfen başka bir resim deneyin.", "Fırsat Resmi Dosyası Hatası");});</script>';
                    }
                    else {
                        $temav1 = move_uploaded_file($temakonumv1, $temav1yol . '/' . $firsatresim);
                        
                        if (!$temav1) {
                            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Fırsat resmi yüklenirken bir hata oluştu. Dosya yazılamadı. Lütfen yönetici ile iletişime geçin.", "Fırsat Resmi Yükleme Hatası");});</script>';
                        } else {
                            $temav1Update = $ozy->prepare("update urunler set firsatresim=? where id='$id'");
                            $temav1Update->execute(array($firsatresim));
                        }
                    }
                }


                $a = 0;
                if (isset($_POST['ozellik_adi'])) {
                    $ozellikadi = $_POST['ozellik_adi'];
                    $ozelliktipi = $_POST['ozellik_tipi'];
                    foreach (array_combine($ozellikadi, $ozelliktipi) as $anaozellikgeldi => $tipgeldi) {
                        $ekoz = $ozy->prepare("INSERT INTO anaozellik (urunid, adi, tip) 
            VALUES (?,?,?)");
                        $resultekoz = $ekoz->execute(array($ekresimid, $anaozellikgeldi, $tipgeldi));
                        $anaozellikid = $ozy->lastInsertId();


                        $aa = 0;
                        if (isset($_POST['alt_ozellik_adi' . $a])) {
                            foreach ($_POST['alt_ozellik_adi' . $a] as $altozellikverisi) {
                                $ekstok = $_POST['alt_ozellik_stok' . $a][$aa];
                                $zekfiyat = $_POST['alt_ozellik_fiyat' . $a][$aa];
                                if ($_POST['kdv'] > '0') {
                                    if ($system['kdvdahil'] == '0') {
                                        $ekfiyat = KdvHaric($zekfiyat, $_POST['kdv']);
                                    } else {
                                        $ekfiyat = ($zekfiyat != "") ? $zekfiyat : "0";
                                    }
                                } else {
                                    if ($system['kdvdahil'] == '0') {
                                        $ekfiyat = $zekfiyat;
                                    } else {
                                        $ekfiyat = ($zekfiyat != "") ? $zekfiyat : "0";
                                    }
                                }


                                $altekoz = $ozy->prepare("INSERT INTO anaozellikalt (anaid, adi, stok, fiyat, ustadi) 
                VALUES (?,?,?,?,?)");
                                $resultekaltoz = $altekoz->execute(array($anaozellikid, $altozellikverisi, $ekstok, $ekfiyat, $anaozellikgeldi));

                                $aa++;
                            }
                        }

                        $a++;
                    }
                }


                $aozellik = $ozy->prepare("SELECT * FROM anaozellik WHERE urunid = ?");
                $result = $aozellik->execute(array($ekresimid));
                foreach ($aozellik as $verimiz) {
                    $ustid = $verimiz['id'];
                    $altozellik = $ozy->prepare("SELECT * FROM anaozellikalt WHERE anaid = ?");
                    $resultalt = $altozellik->execute(array($ustid));
                    foreach ($altozellik as $altverimiz) {
                        $varozellik .= "" . $altverimiz['adi'] . ",";
                    }
                }


                // Sadece ürün başarıyla eklendiyse filtre güncelle
                if ($result2 && isset($id) && is_numeric($id) && $id > 0) {
                    $urunfiltrem = "" . $filtre . "," . $varozellik . ",";
                    echo '<script>console.log("[DB DEBUG] Filtre güncelleme başlatılıyor (yeni ekleme resimli)... ID: ' . $id . '");</script>';
                    $filtreyenile = $ozy->prepare("update urunler set filtre=? where id='$id'");
                    $resultFiltreNewImg = $filtreyenile->execute(array($urunfiltrem));
                    if ($resultFiltreNewImg) {
                        echo '<script>console.log("[DB DEBUG] ✅ UPDATE urunler.filtre BAŞARILI (yeni ekleme resimli) - ID: ' . $id . '");</script>';
                    } else {
                        $errorFiltreNewImg = $filtreyenile->errorInfo();
                        echo '<script>console.error("[DB DEBUG] ❌ UPDATE urunler.filtre BAŞARISIZ (yeni ekleme resimli) - ID: ' . $id . '");</script>';
                        echo '<script>console.error("[DB DEBUG] Hata Detayı:", ' . json_encode($errorFiltreNewImg, JSON_UNESCAPED_UNICODE) . ');</script>';
                    }
                } else {
                    echo '<script>console.warn("[DB DEBUG] ⚠️ Filtre güncelleme atlandı - Ürün ekleme başarısız veya ID geçersiz. ID: ' . (isset($id) ? $id : 'yok') . '");</script>';
                }


                if ($result2) {
                    echo '<script>console.log("[DB DEBUG] ✅ TÜM İŞLEMLER TAMAMLANDI - Yeni ürün eklendi (resimli): ID ' . $id . '");</script>';
                    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
                    echo '<meta http-equiv="refresh" content="1; url=tum-urunler">';
                } else {
                    // Detailed error logging for debugging
                    $errorInfo = $stmt->errorInfo();
                    error_log("Product insertion with image failed: " . print_r($errorInfo, true));
                    error_log("SQL Query: INSERT INTO urunler (adi, aciklama, seo, hit, durum, sira, seodurum, stitle, skey, sdesc, tarih, resim, urunkodu, urunbarkodu, fiyat, idurum, ifiyat, parabirimi, dolar, idolar, euro, ieuro, kisa, instagram, stok, kategori, marka, kdv, agoster, yeni, populer, coksatan, firsat, firsatsaat, filtre, havaledurum, hfiyat, ucretsizkargo, alode, al, ode)");
                    error_log("Parameters: " . print_r(array($adi, $aciklama, $seo, $hit, $durum, $sira, $seodurum, $stitle, $skey, $sdesc, $tarih, $resimadi, $urunkodu, $urunbarkodu, $fiyat, $idurum, $ifiyat, $parabirimi, $dolar, $idolar, $euro, $ieuro, $kisa, $instagram, $stok, $kategori, $marka, $kdv, $agoster, $yeni, $populer, $coksatan, $firsat, $firsatsaat, $filtre, $havaledurum, $hfiyat, $ucretsizkargo, $alode, $al, $ode), true));

                    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Ürün eklenirken bir hata oluştu. Lütfen tüm gerekli alanları doldurun ve tekrar deneyin.", "Başarısız");});</script>';
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
                    <h4 class="page-title">Ürün
                        <?php if ($_GET['duzenle']) { ?>
                            Düzenle
                        <?php } else { ?>
                            Ekle
                        <?php } ?>
                    </h4>
                </div>


                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                        <li class="breadcrumb-item active">Ürün
                            <?php if ($_GET['duzenle']) { ?>
                                Düzenle
                            <?php } else { ?>
                                Ekle
                            <?php } ?>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <form class="form-horizontal" id="urunForm" action="" method="POST" enctype="multipart/form-data">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">
                                        <span class="d-none d-md-block">Genel Ayarlar</span><span
                                            class="d-block d-md-none"><i class="mdi mdi-airplay h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-2" role="tab">
                                        <span class="d-none d-md-block">Fiyat Ayarları</span><span
                                            class="d-block d-md-none"><i class="mdi mdi-currency-try h5"></i></span>
                                    </a>
                                </li>

                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-3" role="tab">
                                        <span class="d-none d-md-block">Ürün Özellikleri</span><span
                                            class="d-block d-md-none"><i class="mdi mdi-animation h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-4" role="tab">
                                        <span class="d-none d-md-block">Gösterim Ayarları</span><span
                                            class="d-block d-md-none"><i
                                                class="mdi mdi-folder-multiple-outline h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
                                        <span class="d-none d-md-block">Resim Ayarları</span><span
                                            class="d-block d-md-none"><i
                                                class="mdi mdi-folder-multiple-outline h5"></i></span>
                                    </a>
                                </li>
                                <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#messages-1" role="tab">
                                        <span class="d-none d-md-block">Seo Ayarları</span><span
                                            class="d-block d-md-none"><i
                                                class="mdi mdi-guitar-pick-outline h5"></i></span>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>


                            <div class="tab-content">








                                <div class="tab-pane active p-3" id="home-1" role="tabpanel">


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Linki
                                            </br>(Boş bırakırsanız otomatik seo link oluşacaktır)</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="seo"
                                                value="<?php echo $sayfam['seo']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Sırası
                                            </br>(En başa almak için en yüksek sayıyı veriniz)</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="number" name="sira" min="0"
                                                onkeydown="return !['e', 'E', '+', '-', '.', ','].includes(event.key)"
                                                value="<?php echo $sayfam['sira']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Adı <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="adi" id="adi"
                                                value="<?php echo $sayfam['adi']; ?>" required>
                                            <small class="text-danger d-none" id="adi-error">Ürün adı zorunludur.</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Kodu <span class="text-danger">*</span> (Aynı
                                            ürün koduna sahip ürünler kombine gösterilecektir)</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="urunkodu" id="urunkodu"
                                                value="<?php echo $sayfam['urunkodu']; ?>" required>
                                            <small class="text-danger d-none" id="urunkodu-error">Ürün kodu zorunludur.</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün
                                            Barkodu <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="urunbarkodu" id="urunbarkodu"
                                                value="<?php echo $sayfam['urunbarkodu']; ?>" required>
                                            <small class="text-danger d-none" id="urunbarkodu-error">Ürün barkodu zorunludur.</small>
                                        </div>
                                    </div>



                                    <?php if ($_GET['duzenle']) { ?>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Ürün
                                                Kategorisi <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control js-example-basic-multiple" name="kategori[]" id="kategori"
                                                    multiple="multiple" required>
                                                    <?php $kat = $ozy->query("select * from kategoriler")->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($kat as $de) { ?>
                                                        <?php $katidler = $sayfam['kategori'];
                                                        $katidler = explode(',', $katidler);
                                                        foreach ($katidler as $anahtar => $katdeger) { ?>

                                                            <option value="<?php echo $de['id']; ?>" <?php if ($de['id'] == $katdeger) { ?> selected="selected" <?php }
                                                                                                                                                        } ?>><?php echo $de['adi']; ?>
                                                            </option>
                                                        <?php } ?>

                                                </select>
                                                <small class="text-danger d-none" id="kategori-error">En az bir kategori seçmelisiniz.</small>
                                            </div>
                                        </div>

                                    <?php } else { ?>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Ürün
                                                Kategorisi <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control js-example-basic-multiple" name="kategori[]" id="kategori"
                                                    multiple="multiple" required>
                                                    <?php $kat = $ozy->query("select * from kategoriler")->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($kat as $de) { ?>
                                                        <option value="<?php echo $de['id']; ?>"><?php echo $de['adi']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <small class="text-danger d-none" id="kategori-error">En az bir kategori seçmelisiniz.</small>
                                            </div>
                                        </div>

                                    <?php } ?>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün
                                            Markası</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="marka">
                                                <option value="0">Seçiniz</option>
                                                <?php $marka = $ozy->query("select * from markalar")->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($marka as $markam) { ?>
                                                    <option name="marka" value="<?php echo $markam['id']; ?>" <?php if ($markam['id'] == $sayfam['marka']) { ?> selected="selected" <?php } ?>><?php echo $markam['adi']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>





                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Manşet
                                            Resmi <small class="text-muted">(Desteklenen formatlar: JPG, JPEG, PNG)</small></label>
                                        <div class="col-sm-10">

                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">





                                                    <div class="fileupload-new thumbnail fileupload-preview thumbnail"
                                                        style="width: 200px; height: 150px;">

                                                        <?php if ($_GET['duzenle']) { ?>
                                                            <img src="../resimler/urunler/<?php echo $sayfam['resim']; ?>"
                                                                style="width: 200px; height: 200px;" alt="" />
                                                        <?php } else { ?>
                                                            <img src="assets/images/resimyok.jpg" alt="" />
                                                        <?php } ?>

                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                        style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-default btn-file"
                                                            style="border: 1px solid #ebeef0;">
                                                            <span class="fileupload-new"><i
                                                                    class="fa fa-paper-clip"></i> Resim Seç</span>
                                                            <span class="fileupload-exists"><i class="fa fa-undo"></i>
                                                                Değiştir</span>
                                                            <input name="resim" type="file" class="default" accept="image/jpeg,image/jpg,image/png,.jpg,.jpeg,.png" />
                                                        </span>
                                                        <a href="#"
                                                            class="btn btn-outline-primary waves-effect waves-light"
                                                            data-dismiss="fileupload"><i class="fa fa-trash"></i>
                                                            Sil</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>



                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['durum'] == '1') { ?> checked=""
                                                    <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="durum">
                                            </div>

                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" checked="" value="1" data-toggle="toggle"
                                                    data-onstyle="primary" data-offstyle="secondary" name="durum">
                                            </div>

                                        </div>

                                    <?php } ?>







                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Kısa Ürün
                                            Açıklaması</label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control" rows="6"
                                                name="kisa"><?php echo $sayfam['kisa']; ?></textarea>
                                        </div>
                                    </div>






                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Açıklama <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <textarea id="summernote" rows="6" required
                                                name="aciklama" id="aciklama"><?php echo $sayfam['aciklama']; ?></textarea>
                                            <small class="text-danger d-none" id="aciklama-error">Açıklama zorunludur.</small>
                                        </div>

                                    </div>






                                </div>




                                <div class="tab-pane p-3" id="profile-1" role="tabpanel">

                                    <div class="form-group row">
                                        <iframe scrolling="no"
                                            src="resimyukle.php?id=<?php echo $ekresimid; ?>&alan=urunler"
                                            style="width:100%;height:1500px;" frameborder="0"></iframe>
                                    </div>






                                </div>


                                <div class="tab-pane p-3" id="profile-3" role="tabpanel">

                                    <?php if ($_GET['duzenle']) { ?>



                                        <div class="form-group row" id="ozellikler">

                                            <?php
                                            $aozellik = $ozy->prepare("SELECT * FROM anaozellik WHERE urunid = ?");
                                            $result = $aozellik->execute(array($ekresimid));
                                            foreach ($aozellik as $verimiz) { ?>


                                                <div class="col-xl-4">
                                                    <div class="card m-b-30" style="border: 1px solid #30419b;">
                                                        <div class="card-body">

                                                            <h4 class="mt-0 header-title"><?php echo $verimiz['adi']; ?></h4>
                                                            <?php $ustid = $verimiz['id'];
                                                            $altozellik = $ozy->prepare("SELECT * FROM anaozellikalt WHERE anaid = ?");
                                                            $resultalt = $altozellik->execute(array($ustid));
                                                            foreach ($altozellik as $altverimiz) {

                                                            ?>
                                                                <div class="">
                                                                    <h6 style="font-size: 11px;"> *
                                                                        <?php echo $altverimiz['adi']; ?>
                                                                        - <?php echo $altverimiz['stok']; ?> Adet /
                                                                        +<?php echo $altverimiz['fiyat']; ?> TL
                                                                    </h6>
                                                                </div>


                                                            <?php } ?>
                                                            <?php if ($verimiz['tip'] == '1') { ?>
                                                                <span class="badge badge-success"
                                                                    style="height: 26px;line-height: 20px;border-radius: 2px;">Kutu
                                                                    Şeklinde</span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-danger"
                                                                    style="height: 26px;line-height: 20px;border-radius: 2px;">Açılır
                                                                    Şekilde</span>
                                                            <?php } ?>
                                                            <a href="urun/duzenle/<?php echo $_GET['duzenle']; ?>?eksil=<?php echo $verimiz['id']; ?>"
                                                                style="background-color: #30419b;border: 1px solid #30419b;"
                                                                onclick="return confirm('Bu özelliği kalıcı olarak silmek istediğinizden emin misiniz ?')"
                                                                class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                                data-original-title="Sil"> <span
                                                                    class="badge badge-primary">Özelliği Sil</span></a>

                                                        </div>
                                                    </div>
                                                </div>






                                            <?php } ?>




                                            <button type="button" id="ozellikekle"
                                                style="width: 100%;margin-bottom: 20px;height: 40px;"
                                                class="btn btn-warning waves-effect waves-light">Ürün Seçenek Ekle</button>
                                            <script type="text/javascript">
                                                $(document).ready(function() {

                                                    $('#ozellikekle').click(function() {
                                                        var bul = $('[data-ozellik]').length;
                                                        $('#ozellikler').append('\
                                                                    <div class="col-md-12" data-ozellik="' + bul + '">\
                                                                    <div class="row form-group">\
                                                                        <div class="col-md-7"><input type="text" class="form-control" name="ozellik_adi[]" placeholder="Seçenek Adı"></div>\
                                                                        <div class="col-md-3"><select name="ozellik_tipi[]" class="form-control"><option value="0">Açılır Şeklinde</option><option value="1">Kutu Şeklinde</option></select></div>\
                                                                        <div class="col-md-2"><button type="button" data-alt-ozellik-ekle="' + bul + '" class="btn btn-success">Alt Seçenek Ekle</button><button type="button" data-ozellik-sil="' + bul + '" class="btn btn-danger">Sil</button></div>\
                                                                    <div class="form-group alt_ozellikler" data-alt-ozellik="' + bul + '"></div>\
                                                                </div>\
                                                                </div>\
                                                            ');
                                                    });

                                                    $(document).on('click', '[data-ozellik-sil]', function() {
                                                        $('[data-ozellik="' + $(this).attr('data-ozellik-sil') + '"]').remove();
                                                        $('#ekle').fadeIn(1000);
                                                    });

                                                    $(document).on('click', '[data-alt-ozellik-ekle]', function() {
                                                        var bul = $('[data-alt-ozellik-dis]').length;
                                                        $('[data-alt-ozellik="' + $(this).attr('data-alt-ozellik-ekle') + '"]').append('\
                                                                <div class="col-md-12" style="margin-top: 10px;" data-alt-ozellik-dis="' + bul + '">\
                                                                    <div class="row form-group">\
                                                                        <div class="col-md-7">\
                                                                            <input type="text" class="form-control" placeholder="Alt Seçenek Adı" name="alt_ozellik_adi' + $(this).attr('data-alt-ozellik-ekle') + '[]">\
                                                                        </div>\
                                                                        <div class="col-md-2">\
                                                                            <input type="number" class="form-control" placeholder="Stok Sayısı" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, \'\')" name="alt_ozellik_stok' + $(this).attr('data-alt-ozellik-ekle') + '[]">\
                                                                        </div>\
                                                                        <div class="col-md-2">\
                                                                            <input type="text" class="form-control" placeholder="Fiyat" oninput="this.value = this.value.replace(/[^0-9,]/g, \'\')" name="alt_ozellik_fiyat' + $(this).attr('data-alt-ozellik-ekle') + '[]">\
                                                                        </div>\
                                                                        <div class="col-md-1">\
                                                                            <button type="button" data-alt-ozellik-sil="' + bul + '" class="btn btn-danger">Sil</button>\
                                                                        </div>\
                                                                    </div>\
                                                                </div>\
                                                            ');
                                                    });

                                                    $(document).on('click', '[data-alt-ozellik-sil]', function() {
                                                        $('[data-alt-ozellik-dis="' + $(this).attr('data-alt-ozellik-sil') + '"]').remove();
                                                    });

                                                });
                                            </script>



                                        </div>

                                    <?php } else { ?>


                                        <div class="form-group row" id="ozellikler">

                                            <button type="button" id="ozellikekle"
                                                style="width: 100%;margin-bottom: 20px;height: 40px;"
                                                class="btn btn-warning waves-effect waves-light">Ürün Seçenek Ekle</button>
                                            <script type="text/javascript">
                                                $(document).ready(function() {

                                                    $('#ozellikekle').click(function() {
                                                        var bul = $('[data-ozellik]').length;
                                                        $('#ozellikler').append('\
                                                                <div class="col-md-12" data-ozellik="' + bul + '">\
                                                                    <div class="row form-group">\
                                                                        <div class="col-md-7"><input type="text" class="form-control" name="ozellik_adi[]" placeholder="Seçenek Adı"></div>\
                                                                        <div class="col-md-3"><select name="ozellik_tipi[]" class="form-control"><option value="0">Açılır Şeklinde</option><option value="1">Kutu Şeklinde</option></select></div>\
                                                                        <div class="col-md-2"><button type="button" data-alt-ozellik-ekle="' + bul + '" class="btn btn-success">Alt Seçenek Ekle</button><button type="button" data-ozellik-sil="' + bul + '" class="btn btn-danger">Sil</button></div>\
                                                                    <div class="form-group alt_ozellikler" data-alt-ozellik="' + bul + '"></div>\
                                                                </div>\
                                                                </div>\
                                                            ');
                                                    });

                                                    $(document).on('click', '[data-ozellik-sil]', function() {
                                                        $('[data-ozellik="' + $(this).attr('data-ozellik-sil') + '"]').remove();
                                                        $('#ekle').fadeIn(1000);
                                                    });

                                                    $(document).on('click', '[data-alt-ozellik-ekle]', function() {
                                                        var bul = $('[data-alt-ozellik-dis]').length;
                                                        $('[data-alt-ozellik="' + $(this).attr('data-alt-ozellik-ekle') + '"]').append('\
                                                                <div class="col-md-12" style="margin-top: 10px;" data-alt-ozellik-dis="' + bul + '">\
                                                                    <div class="row form-group">\
                                                                        <div class="col-md-7">\
                                                                            <input type="text" class="form-control" placeholder="Alt Seçenek Adı" name="alt_ozellik_adi' + $(this).attr('data-alt-ozellik-ekle') + '[]">\
                                                                        </div>\
                                                                        <div class="col-md-2">\
                                                                            <input type="number" class="form-control" placeholder="Stok Sayısı" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, \'\')" name="alt_ozellik_stok' + $(this).attr('data-alt-ozellik-ekle') + '[]">\
                                                                        </div>\
                                                                        <div class="col-md-2">\
                                                                            <input type="text" class="form-control" placeholder="Fiyat" oninput="this.value = this.value.replace(/[^0-9,]/g, \'\')" name="alt_ozellik_fiyat' + $(this).attr('data-alt-ozellik-ekle') + '[]">\
                                                                        </div>\
                                                                        <div class="col-md-1">\
                                                                            <button type="button" data-alt-ozellik-sil="' + bul + '" class="btn btn-danger">Sil</button>\
                                                                        </div>\
                                                                    </div>\
                                                                </div>\
                                                            ');
                                                    });

                                                    $(document).on('click', '[data-alt-ozellik-sil]', function() {
                                                        $('[data-alt-ozellik-dis="' + $(this).attr('data-alt-ozellik-sil') + '"]').remove();
                                                    });

                                                });
                                            </script>
                                        </div>




                                    <?php } ?>








                                </div>






                                <div class="tab-pane p-3" id="profile-4" role="tabpanel">




                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Yeni
                                                Ürün</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['yeni'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="yeni">
                                            </div>

                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Yeni
                                                Ürün</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="yeni">
                                            </div>

                                        </div>

                                    <?php } ?>


                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Popüler
                                                Ürün</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['populer'] == '1') { ?> checked=""
                                                    <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="populer">
                                            </div>

                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Popüler
                                                Ürün</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="populer">
                                            </div>

                                        </div>

                                    <?php } ?>



                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Çok Satan
                                                Ürün</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['coksatan'] == '1') { ?> checked=""
                                                    <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="coksatan">
                                            </div>

                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Çok Satan
                                                Ürün</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="coksatan">
                                            </div>

                                        </div>

                                    <?php } ?>



                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfada
                                                Göster</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['agoster'] == '1') { ?> checked=""
                                                    <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="agoster">
                                            </div>

                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfada
                                                Göster</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="agoster">
                                            </div>

                                        </div>

                                    <?php } ?>


                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Fırsat
                                                Ürünü</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" id="firsatdurumu" <?php if ($sayfam['firsat'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle"
                                                    data-onstyle="primary" data-offstyle="secondary" name="firsat">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Fırsat
                                                Ürünü</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" id="firsatdurumu" value="1" data-toggle="toggle"
                                                    data-onstyle="primary" data-offstyle="secondary" name="firsat">
                                            </div>
                                        </div>
                                    <?php } ?>



                                    <div class="form-group row" id="firsatdurumum"
                                        style="<?php if ($sayfam['firsat'] !== '1') { ?> display:none; <?php } ?> ">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Fırsat
                                            Resmi <small class="text-muted">(Desteklenen formatlar: JPG, JPEG, PNG)</small></label>
                                        <div class="col-sm-10">

                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">



                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                        style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    </div>

                                                    <div class="fileupload-new thumbnail fileupload-preview thumbnail"
                                                        style="width: 200px; height: 150px;">




                                                        <?php if ($_GET['duzenle']) { ?>
                                                            <img src="../resimler/genel/<?php echo $sayfam['firsatresim']; ?>"
                                                                style="width: 200px; height: 200px;" alt="" />
                                                        <?php } else { ?>
                                                            <img src="assets/images/resimyok.jpg" alt="" />
                                                        <?php } ?>

                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                        style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-default btn-file"
                                                            style="border: 1px solid #ebeef0;">
                                                            <span class="fileupload-new"><i
                                                                    class="fa fa-paper-clip"></i> Resim Seç</span>
                                                            <span class="fileupload-exists"><i class="fa fa-undo"></i>
                                                                Değiştir</span>
                                                            <input name="firsatresim" type="file" class="default" accept="image/jpeg,image/jpg,image/png,.jpg,.jpeg,.png" />
                                                        </span>
                                                        <a href="#"
                                                            class="btn btn-outline-primary waves-effect waves-light"
                                                            data-dismiss="fileupload"><i class="fa fa-trash"></i>
                                                            Sil</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>



                                    <div class="form-group row" id="firsatdurumumx"
                                        style="<?php if ($sayfam['firsat'] !== '1') { ?> display:none; <?php } ?> ">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Fırsat Saati
                                            </br>(Fırsat kaç saat geçerli olacaksa o kadar saat yazınız Örnek 1saat =
                                            1)</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="number" name="firsatsaat"
                                                value="<?php echo $sayfam['firsatsaat']; ?>">
                                        </div>
                                    </div>





                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün Filtreleri
                                            </br>(Ürünün kategorilerde filtrelenmesini sağlayan anahtar
                                            kelimeler)</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" data-role="tagsinput" name="filtre"
                                                value="<?php echo $sayfam['filtre']; ?>">
                                        </div>

                                    </div>








                                </div>









































                                <div class="tab-pane p-3" id="profile-2" role="tabpanel">
                                    <?php if ($system['sinirsizstok'] == '1') { ?>

                                        <input type="hidden" name="stok" value="99999999999999999999999999999">
                                    <?php } else { ?>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Stok
                                                Sayısı <span class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" name="stok" id="stok" min="0" required
                                                    onkeydown="return !['e', 'E', '+', '-'].includes(event.key)"
                                                    value="<?php echo $sayfam['stok']; ?>">
                                                <small class="text-danger d-none" id="stok-error">Stok sayısı zorunludur.</small>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">KDV Oranı (Eğer
                                            boş bırakırsanız sistemdeki genel kdv oranı baz alınacaktır.)</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" min="0" max="20"
                                                onkeydown="return !['e', 'E', '+', '-'].includes(event.key)"
                                                value="<?php echo $sayfam['kdv']; ?>" name="kdv">
                                            <span class="input-group-addon"> %</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Ürün
                                            Fiyatı <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="fiyat"
                                                onkeydown="return !['e', 'E', '+', '-'].includes(event.key)"
                                                value="<?php echo $sayfam['fiyat']; ?>" min="0" name="fiyat" required>
                                            <span class="input-group-addon"> TL</span>
                                            <small class="text-danger d-none" id="fiyat-error">Ürün fiyatı zorunludur.</small>
                                        </div>
                                    </div>


                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">İndirim
                                                Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" id="indirimdurum" <?php if ($sayfam['idurum'] == '1') { ?> checked="" <?php } ?> value="1" data-toggle="toggle"
                                                    data-onstyle="primary" data-offstyle="secondary" name="idurum">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">İndirim
                                                Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" id="indirimdurum" value="1" data-toggle="toggle"
                                                    data-onstyle="primary" data-offstyle="secondary" name="idurum">
                                            </div>
                                        </div>
                                    <?php } ?>


                                    <div class="form-group row" id="indirimlifiyat"
                                        style="<?php if ($sayfam['idurum'] !== '1') { ?> display:none; <?php } ?> ">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">İndirimli Ürün
                                            Fiyatı</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control"
                                                onkeydown="return !['e', 'E', '+', '-'].includes(event.key)"
                                                value="<?php echo $sayfam['ifiyat']; ?>" min="0" name="ifiyat">
                                            <span class="input-group-addon"> TL</span>
                                        </div>
                                    </div>



                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">İndirimli Havale
                                                Fiyatı</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" id="havaledurum" <?php if ($sayfam['havaledurum'] == '1') { ?> checked="" <?php } ?> value="1"
                                                    min="0" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="havaledurum">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">İndirimli Havale
                                                Fiyatı</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" id="havaledurum" value="1" data-toggle="toggle"
                                                    min="0" data-onstyle="primary" data-offstyle="secondary"
                                                    name="havaledurum">
                                            </div>
                                        </div>
                                    <?php } ?>


                                    <div class="form-group row" id="havalefiyati"
                                        style="<?php if ($sayfam['havaledurum'] !== '1') { ?> display:none; <?php } ?> ">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">İndirimli Havale
                                            Fiyatı</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control"
                                                onkeydown="return !['e', 'E', '+', '-'].includes(event.key)" min="0"
                                                value="<?php echo $sayfam['hfiyat']; ?>" name="hfiyat">
                                            <span class="input-group-addon"> TL</span>
                                        </div>
                                    </div>



                                    <?php if ($_GET['duzenle']) { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Ücretsiz
                                                Kargo</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['ucretsizkargo'] == '1') { ?>
                                                    checked="" <?php } ?> value="1" data-toggle="toggle"
                                                    data-onstyle="primary" data-offstyle="secondary" name="ucretsizkargo">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Ücretsiz
                                                Kargo</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="ucretsizkargo">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>

                                        <?php if ($_GET['duzenle']) { ?>
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">X Al Y
                                                    Öde</label>
                                                <div class="col-sm-10">
                                                    <input type="checkbox" id="alode" <?php if ($sayfam['alode'] == '1') { ?>
                                                        checked="" <?php } ?> value="1" data-toggle="toggle"
                                                        data-onstyle="primary" data-offstyle="secondary" name="alode">
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">X Al Y
                                                    Öde</label>
                                                <div class="col-sm-10">
                                                    <input type="checkbox" id="alode" value="1" data-toggle="toggle"
                                                        data-onstyle="primary" data-offstyle="secondary" name="alode">
                                                </div>
                                            </div>
                                        <?php } ?>


                                        <div class="form-group row" id="alodefiyati"
                                            style="<?php if ($sayfam['alode'] !== '1') { ?> display:none; <?php } ?> ">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Al Öde
                                                Kombinasyonu</label>
                                            <div class="col-sm-5">
                                                <input type="number" min="0"
                                                    onkeydown="return !['e', 'E', '+', '-', '.', ','].includes(event.key)"
                                                    class="form-control" value="<?php echo $sayfam['al']; ?>" name="al">
                                                <span class="input-group-addon">ADET AL</span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="number" class="form-control" min="0"
                                                    value="<?php echo $sayfam['ode']; ?>" name="ode"
                                                    onkeydown="return !['e', 'E', '+', '-'].includes(event.key)">
                                                <span class="input-group-addon">ADET ÖDE</span>
                                            </div>
                                        </div>
                                    <?php } ?>







                                </div>










                                <?php if (paket_kontrol_donus(["plus", "extreme", "enterprise"])) { ?>

                                    <div class="tab-pane p-3" id="messages-1" role="tabpanel">


                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel
                                                Titlesi</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="stitle"
                                                    value="<?php echo $sayfam['stitle']; ?>">
                                            </div>

                                        </div>


                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel
                                                Keyword</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" data-role="tagsinput" name="skey"
                                                    value="<?php echo $sayfam['skey']; ?>">
                                            </div>

                                        </div>



                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Sayfa Özel
                                                Açıklaması</label>
                                            <div class="col-sm-10">
                                                <textarea id="textarea" class="form-control" rows="6"
                                                    name="sdesc"><?php echo $sayfam['sdesc']; ?></textarea>
                                            </div>

                                        </div>




                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Seo
                                                Durumu</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if ($sayfam['seodurum'] == '1') { ?> checked=""
                                                    <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary"
                                                    data-offstyle="secondary" name="seodurum">
                                            </div>

                                        </div>



                                    </div>

                                <?php } ?>
                            </div>








                        </div>




                        <input type="hidden" value="0" name="parabirimi">
                        <input type="hidden" value="0" name="dolar">
                        <input type="hidden" value="0" name="idolar">
                        <input type="hidden" value="0" name="euro">
                        <input type="hidden" value="0" name="ieuro">



                        <?php if ($_GET['duzenle']) { ?>

                            <button type="submit" name="guncelle"
                                class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>

                        <?php } else { ?>

                            <button type="submit" name="kaydet"
                                class="btn btn-primary btn-lg btn-block waves-effect waves-light">Kaydet</button>



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
<style>
    .input-group-addon {
        padding: .375rem .75rem;
        margin-bottom: 0;
        font-size: 0.9rem !important;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        float: right !important;
        margin-top: -36px !important;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    
    .is-invalid:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    
    #summernote.is-invalid {
        border: 2px solid #dc3545 !important;
    }
    
    .note-editor.is-invalid {
        border: 2px solid #dc3545 !important;
    }
    
    .select2-container--default .select2-selection--multiple.is-invalid {
        border-color: #dc3545 !important;
    }
</style>

<script>
// Passive event listener uyarılarını azaltmak için
if (typeof EventTarget !== 'undefined' && EventTarget.prototype.addEventListener) {
    const originalAddEventListener = EventTarget.prototype.addEventListener;
    EventTarget.prototype.addEventListener = function(type, listener, options) {
        // Wheel event için passive ekle (tarayıcı uyumluluğu için)
        if (type === 'wheel') {
            if (!options || typeof options !== 'object') {
                options = { passive: true };
            } else {
                options = Object.assign({}, options, { passive: true });
            }
        }
        return originalAddEventListener.call(this, type, listener, options);
    };
}

$(document).ready(function() {
    // Form validasyonu
    $('#urunForm').on('submit', function(e) {
        var isValid = true;
        var shouldPreventDefault = false;
        
        // Tüm hata mesajlarını gizle
        $('.text-danger.d-none').addClass('d-none').removeClass('d-block');
        $('.form-control').removeClass('is-invalid');
        $('.select2-selection--multiple').removeClass('is-invalid');
        $('.note-editor').removeClass('is-invalid');
        
        // Ürün Adı kontrolü
        var adi = $('#adi').val().trim();
        if (!adi || adi === '') {
            $('#adi-error').removeClass('d-none').addClass('d-block');
            $('#adi').addClass('is-invalid');
            isValid = false;
        }
        
        // Ürün Kodu kontrolü
        var urunkodu = $('#urunkodu').val().trim();
        if (!urunkodu || urunkodu === '') {
            $('#urunkodu-error').removeClass('d-none').addClass('d-block');
            $('#urunkodu').addClass('is-invalid');
            isValid = false;
        }
        
        // Ürün Barkodu kontrolü
        var urunbarkodu = $('#urunbarkodu').val().trim();
        if (!urunbarkodu || urunbarkodu === '') {
            $('#urunbarkodu-error').removeClass('d-none').addClass('d-block');
            $('#urunbarkodu').addClass('is-invalid');
            isValid = false;
        }
        
        // Kategori kontrolü
        var kategori = $('#kategori').val();
        if (!kategori || kategori.length === 0) {
            $('#kategori-error').removeClass('d-none').addClass('d-block');
            $('#kategori').next('.select2-container').find('.select2-selection--multiple').addClass('is-invalid');
            isValid = false;
        }
        
        // Açıklama kontrolü (Summernote için)
        var aciklama = $('#summernote').summernote('code');
        if (!aciklama || aciklama.trim() === '' || aciklama.trim() === '<p><br></p>' || aciklama.trim() === '<p></p>') {
            $('#aciklama-error').removeClass('d-none').addClass('d-block');
            $('#summernote').next('.note-editor').addClass('is-invalid');
            isValid = false;
        }
        
        // Stok kontrolü (sinirsizstok değilse)
        <?php if ($system['sinirsizstok'] != '1') { ?>
        var stok = $('#stok').val();
        if (!stok || stok === '' || parseFloat(stok) < 0) {
            $('#stok-error').removeClass('d-none').addClass('d-block');
            $('#stok').addClass('is-invalid');
            isValid = false;
        }
        <?php } ?>
        
        // Fiyat kontrolü
        var fiyat = $('#fiyat').val();
        if (!fiyat || fiyat === '' || parseFloat(fiyat) <= 0) {
            $('#fiyat-error').removeClass('d-none').addClass('d-block');
            $('#fiyat').addClass('is-invalid');
            isValid = false;
        }
        
        // Resim format kontrolü (eğer resim yüklendiyse)
        var resimInput = $('input[name="resim"]')[0];
        if (resimInput && resimInput.files.length > 0) {
            var resimFile = resimInput.files[0];
            var resimType = resimFile.type.toLowerCase();
            var resimName = resimFile.name.toLowerCase();
            var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            var allowedExtensions = ['.jpg', '.jpeg', '.png'];
            
            var hasValidExtension = allowedExtensions.some(ext => resimName.endsWith(ext));
            var hasValidType = allowedTypes.includes(resimType);
            
            if (!hasValidType && !hasValidExtension) {
                if (typeof toastr !== 'undefined') {
                    toastr['error']('Ürün resmi için sadece JPG, JPEG ve PNG formatları desteklenmektedir!', 'Hata');
                }
                isValid = false;
            }
        }
        
        // Fırsat resmi format kontrolü (eğer resim yüklendiyse ve fırsat ürünü seçiliyse)
        var firsatResimInput = $('input[name="firsatresim"]')[0];
        var firsatDurumu = $('input[name="firsat"]:checked').length > 0 || $('#firsatdurumu').is(':checked');
        if (firsatResimInput && firsatResimInput.files.length > 0 && firsatDurumu) {
            var firsatResimFile = firsatResimInput.files[0];
            var firsatResimType = firsatResimFile.type.toLowerCase();
            var firsatResimName = firsatResimFile.name.toLowerCase();
            
            var hasValidFirsatExtension = allowedExtensions.some(ext => firsatResimName.endsWith(ext));
            var hasValidFirsatType = allowedTypes.includes(firsatResimType);
            
            if (!hasValidFirsatType && !hasValidFirsatExtension) {
                if (typeof toastr !== 'undefined') {
                    toastr['error']('Fırsat resmi için sadece JPG, JPEG ve PNG formatları desteklenmektedir!', 'Hata');
                }
                isValid = false;
            }
        }
        
        // Eğer validasyon geçtiyse formu gönder
        if (!isValid) {
            shouldPreventDefault = true;
            console.error('[FORM DEBUG] Validasyon başarısız! Hatalı alanlar:', $('.is-invalid').map(function() { return this.id || this.name; }).get());
            
            // Hata varsa ilk hataya scroll yap
            var firstError = $('.is-invalid').first();
            if (firstError.length) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
            
            // Toastr ile genel hata mesajı göster
            if (typeof toastr !== 'undefined') {
                toastr['error']('Lütfen zorunlu alanları doldurun!', 'Hata');
            } else {
                alert('Lütfen zorunlu alanları doldurun!');
            }
        } else {
            console.log('[FORM DEBUG] ✅ Validasyon başarılı, form gönderiliyor...');
            console.log('[FORM DEBUG] Form action:', this.action || window.location.href);
            console.log('[FORM DEBUG] Form method:', this.method);
            // Validasyon başarılıysa formu normal şekilde gönder (preventDefault yapma)
        }
        
        // Sadece validasyon başarısızsa form gönderimini engelle
        if (shouldPreventDefault) {
            e.preventDefault();
            return false;
        }
        // Validasyon başarılıysa form doğal akışında gönderilecek
    });
    
    // Input değiştiğinde hata mesajını gizle
    $('#adi, #urunkodu, #urunbarkodu, #fiyat, #stok').on('input change', function() {
        $(this).removeClass('is-invalid');
        var errorId = $(this).attr('id') + '-error';
        $('#' + errorId).addClass('d-none').removeClass('d-block');
    });
    
    // Kategori değiştiğinde hata mesajını gizle
    $('#kategori').on('change', function() {
        $(this).next('.select2-container').find('.select2-selection--multiple').removeClass('is-invalid');
        $('#kategori-error').addClass('d-none').removeClass('d-block');
    });
    
    // Summernote değiştiğinde hata mesajını gizle
    $('#summernote').on('summernote.change', function() {
        $(this).next('.note-editor').removeClass('is-invalid');
        $('#aciklama-error').addClass('d-none').removeClass('d-block');
    });
});
</script>