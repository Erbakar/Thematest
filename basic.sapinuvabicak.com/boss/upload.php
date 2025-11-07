<?php define("guvenlik", true);
require('../func/db.php');
require('../func/fonksiyon.php');
require('../func/resim_fonksiyonlari.php');
giriskontrol($ozy, 1);

if (!isset($_SESSION["giris"])) {
    header("Location:index.php");
    exit;
}

// Paket sistemi için ayarları al
$paket_adi = $_SESSION['paketadi'];
$resim_limit = $_SESSION['resim_limit'];
$upload_modu = upload_modu_al();
$max_bulk_limit = max_bulk_limit_al();
$paket_bilgileri = paket_bilgileri_al();

$sayfaidx = temizle($_GET['id']);
$alanx = temizle($_GET['alan']);
$folder_name = '../resimler/urunler/';
 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tresimler = $ozy->query("SELECT * FROM tumresimler WHERE sayfaid='$sayfaidx' AND alan='$alanx' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    $guncel_resim_sayisi = count($tresimler);
    ?>

    <div class="row">
        <div class="col-md-12">
            <p id="resim_limiti" style="color: #30419b; font-weight: 500;">
                Resim Limiti: <?php echo $guncel_resim_sayisi; ?> / <?php echo $resim_limit; ?>
            </p>
        </div>
    </div>
    <br>
    <div class="row">
        <?php foreach ($tresimler as $abc) { ?>
            <div class="col-md-1" style="width:20%;margin-right:-25px;">
                <img src="../resimler/urunler/<?php echo $abc['sayfaresim']; ?>" class="img-thumbnail" style="height:75px;width:75px;" />
                <button type="button" class="btn btn-link remove_image" style="background: #30419b; color: #fff; margin-top: 10px; margin-left: 10px; height: 30px; width: 30px; font-size: 12px; padding-left: 8px; font-weight: 500;" id="<?php echo $abc['sayfaresim']; ?>">Sil</button>
            </div>
        <?php } ?>
    </div>

    <script>
        $(document).ready(function () {
            $('#resim_limiti').text('Resim Limiti: <?php echo $guncel_resim_sayisi; ?> / <?php echo $resim_limit; ?>');
        });
    </script>

    <?php
    exit;
}
 
if (isset($_POST["name"])) {
    $resimadimiz = temizle($_POST["name"]);
    $filename = $folder_name . $resimadimiz;
    $tresimsil = $ozy->prepare("DELETE FROM tumresimler WHERE sayfaresim=?");
    $tresimsil->execute([$resimadimiz]);
    if (file_exists($filename)) {
        unlink($filename);
    }
    $ozy->exec("DELETE FROM tumresimler WHERE sayfaid='0'");
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    if (empty($_POST['id']) || empty($_POST['alan'])) {
        http_response_code(400);
        echo "veri_eksik";
        exit;
    }

    // Çoklu dosya yükleme desteği kontrolü
    $files_to_process = [];
    
    if (isset($_FILES['file'])) {
        // Tek dosya yükleme
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo "dosya_hatasi";
            exit;
        }
        $files_to_process[] = $_FILES['file'];
    } elseif (isset($_FILES['files'])) {
        // Çoklu dosya yükleme
        $file_count = count($_FILES['files']['name']);
        
        // Paket1 için çoklu yükleme engelleme
        if ($upload_modu == 'tek_tek' && $file_count > 1) {
            http_response_code(400);
            echo "paket_limit_asildi";
            exit;
        }
        
        // Paket2 için maksimum limit kontrolü
        if ($file_count > $max_bulk_limit) {
            http_response_code(400);
            echo "coklu_limit_asildi";
            exit;
        }
        
        for ($i = 0; $i < $file_count; $i++) {
            if ($_FILES['files']['error'][$i] === UPLOAD_ERR_OK) {
                $files_to_process[] = [
                    'tmp_name' => $_FILES['files']['tmp_name'][$i],
                    'name' => $_FILES['files']['name'][$i],
                    'type' => $_FILES['files']['type'][$i],
                    'error' => $_FILES['files']['error'][$i],
                    'size' => $_FILES['files']['size'][$i]
                ];
            }
        }
    } else {
        http_response_code(400);
        echo "dosya_hatasi";
        exit;
    }

    $sayfaid = temizle($_POST['id']);
    $alan = temizle($_POST["alan"]);
 
    $mevcut_resimler = $ozy->query("SELECT * FROM tumresimler WHERE sayfaid='$sayfaid' AND alan='$alan'")->fetchAll(PDO::FETCH_ASSOC);
    $mevcut_sayi = count($mevcut_resimler);
    
    // Toplam limit kontrolü
    if (($mevcut_sayi + count($files_to_process)) > $resim_limit) {
        http_response_code(400);
        echo "toplam_limit_doldu";
        exit;
    }
    
    $basarili_yuklemeler = 0;
    $hata_sayisi = 0;
    
    foreach ($files_to_process as $file) {
        $tresimkonum = $file['tmp_name'];
        $tresimad = $file['name'];
        $dosya_uzantisi = strtolower(pathinfo($tresimad, PATHINFO_EXTENSION));
        $izin_verilen_uzantilar = ['jpg', 'jpeg', 'png'];

        if (!in_array($dosya_uzantisi, $izin_verilen_uzantilar)) {
            $hata_sayisi++;
            continue;
        }

        $tyeniad = seo(md5(uniqid(rand()))) . '.' . $dosya_uzantisi;
        $hedef_yol = $folder_name . $tyeniad;

        // Resmi boyutlandırarak kaydet
        if (resizeProductImage($tresimkonum, $hedef_yol)) {
            $tresim = $ozy->prepare("INSERT INTO tumresimler (sayfaid, sayfaresim, alan) VALUES (?, ?, ?)");
            $tresim->execute([$sayfaid, $tyeniad, $alan]);
            $basarili_yuklemeler++;
        } else {
            $hata_sayisi++;
        }
    }
    
    // Son limit kontrolü
    $sonraki_resimler = $ozy->query("SELECT * FROM tumresimler WHERE sayfaid='$sayfaid' AND alan='$alan'")->fetchAll(PDO::FETCH_ASSOC);
    if (count($sonraki_resimler) > $resim_limit) {
        http_response_code(400);
        echo "limit_doldu";
        exit;
    }
    
    // Sonuç bildirimi
    if ($basarili_yuklemeler > 0 && $hata_sayisi == 0) {
        echo "basarili";
    } elseif ($basarili_yuklemeler > 0 && $hata_sayisi > 0) {
        echo "kismi_basarili";
    } else {
        http_response_code(400);
        echo "yuklenemedi";
    }

    exit;
}
?>
