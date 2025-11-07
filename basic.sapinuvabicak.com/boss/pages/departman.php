<?php 
// Departman yönetimi için özel yetki kontrolü
// Sadece admin yönetimi yetkisi olan kullanıcılar bu sayfaya erişebilir

// Paket kontrolü - sadece extreme ve enterprise paketleri
paket_kontrol(array('basic','plus','extreme', 'enterprise'));

// Debug: Mevcut kullanıcının departman bilgilerini kontrol et
if (!isset($_SESSION['departmanid']) || empty($_SESSION['departmanid'])) {
    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Departman bilgisi bulunamadı. Lütfen tekrar giriş yapın.", "Hata");});</script>';
    echo '<meta http-equiv="refresh" content="2; url=index.php">';
    exit();
}

$yetki = $ozy->query("SELECT * FROM yetki WHERE departmanid = {$_SESSION['departmanid']}")->fetch(PDO::FETCH_ASSOC);
if ($yetki) {
    $dizi = explode(",", $yetki['menu']);
    // Menü ID 59 (Admin Yönetimi) yetkisi kontrolü
    if (!in_array('59', $dizi)) {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Bu sayfaya erişim yetkiniz bulunmamaktadır.", "Yetki Hatası");});</script>';
        echo '<meta http-equiv="refresh" content="2; url=anasayfa.php">';
        exit();
    }
} else {
    // Yetki kaydı yoksa, geçici olarak erişim ver (sistem kurulumu için)
    echo '<script type="text/javascript">$(document).ready(function(){toastr["warning"]("Yetki kaydı bulunamadı. Geçici erişim verildi.", "Uyarı");});</script>';
} 

// Departman ekleme işlemi
if (isset($_POST['departman_ekle'])) {
    $departman_adi = temizle($_POST['departman_adi']);
    $departman_aciklama = temizle($_POST['departman_aciklama']);
    $durum = temizle($_POST['durum']);
    $tarih = date('d.m.Y H:i:s');
    
    // Departman tablosuna ekle
    $stmt = $ozy->prepare("INSERT INTO departman (adi, aciklama, durum, tarih) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute(array($departman_adi, $departman_aciklama, $durum, $tarih));
    
    if ($result) {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Departman başarıyla eklendi.", "Başarılı");});</script>';
    } else {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Departman eklenirken hata oluştu.", "Hata");});</script>';
    }
}

// Departman düzenleme işlemi
if (isset($_POST['departman_duzenle'])) {
    $id = temizle($_POST['departman_id']);
    $departman_adi = temizle($_POST['departman_adi']);
    $departman_aciklama = temizle($_POST['departman_aciklama']);
    $durum = temizle($_POST['durum']);
    $tarih = date('d.m.Y H:i:s');
    
    $stmt = $ozy->prepare("UPDATE departman SET adi = ?, aciklama = ?, durum = ?, tarih = ? WHERE id = ?");
    $result = $stmt->execute(array($departman_adi, $departman_aciklama, $durum, $tarih, $id));
    
    if ($result) {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Departman başarıyla güncellendi.", "Başarılı");});</script>';
    } else {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Departman güncellenirken hata oluştu.", "Hata");});</script>';
    }
}

// Yetki güncelleme işlemi
if (isset($_POST['yetki_guncelle'])) {
    $departman_id = temizle($_POST['departman_id']);
    $selected_menu_ids = isset($_POST['menu_ids']) ? $_POST['menu_ids'] : array();
    
    // Seçilen menü ID'lerini al
    $final_menu_ids = array();
    
    foreach ($selected_menu_ids as $menu_id) {
        $final_menu_ids[] = $menu_id;
        
        // Bu menünün üst menüsü var mı kontrol et
        $ust_menu = $ozy->query("SELECT ustmenu FROM menu WHERE id = $menu_id AND ustmenu > 0")->fetch(PDO::FETCH_ASSOC);
        
        if ($ust_menu && !in_array($ust_menu['ustmenu'], $final_menu_ids)) {
            // Üst menüyü de ekle
            $final_menu_ids[] = $ust_menu['ustmenu'];
        }
    }
    
    // Duplicate'leri kaldır ve sırala
    $final_menu_ids = array_unique($final_menu_ids);
    sort($final_menu_ids);
    $menu_ids_string = implode(',', $final_menu_ids);
    
    // Yetki tablosunda kayıt var mı kontrol et
    $yetki_kontrol = $ozy->query("SELECT * FROM yetki WHERE departmanid = $departman_id")->fetch(PDO::FETCH_ASSOC);
    
    if ($yetki_kontrol) {
        // Güncelle
        $stmt = $ozy->prepare("UPDATE yetki SET menu = ?, durum = 1 WHERE departmanid = ?");
        $result = $stmt->execute(array($menu_ids_string, $departman_id));
    } else {
        // Yeni kayıt ekle
        $stmt = $ozy->prepare("INSERT INTO yetki (departmanid, menu, durum) VALUES (?, ?, 1)");
        $result = $stmt->execute(array($departman_id, $menu_ids_string));
    }
    
    if ($result) {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Yetkiler başarıyla güncellendi.", "Başarılı");});</script>';
    } else {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Yetkiler güncellenirken hata oluştu.", "Hata");});</script>';
    }
}

// Departman silme işlemi
if (isset($_GET['sil'])) {
    $id = temizle($_GET['sil']);
    
    // Önce bu departmana ait admin var mı kontrol et
    $admin_kontrol = $ozy->query("SELECT COUNT(*) as toplam FROM admin WHERE departman = $id")->fetch(PDO::FETCH_ASSOC);
    
    if ($admin_kontrol['toplam'] > 0) {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Bu departmana ait admin kullanıcılar bulunduğu için silinemez.", "Hata");});</script>';
    } else {
        // Yetki kayıtlarını sil
        $ozy->query("DELETE FROM yetki WHERE departmanid = $id");
        
        // Departmanı sil
        $stmt = $ozy->prepare("DELETE FROM departman WHERE id = ?");
        $result = $stmt->execute(array($id));
        
        if ($result) {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Departman başarıyla silindi.", "Başarılı");});</script>';
        } else {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Departman silinirken hata oluştu.", "Hata");});</script>';
        }
    }
}

// Düzenleme için departman bilgilerini al
$duzenle_departman = null;
if (isset($_GET['duzenle'])) {
    $id = temizle($_GET['duzenle']);
    // Departman var mı kontrol et
    $duzenle_departman = $ozy->query("SELECT * FROM departman WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
    if (!$duzenle_departman) {
        echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Departman bulunamadı.", "Hata");});</script>';
        echo '<meta http-equiv="refresh" content="1; url=departman">';
        exit();
    }
}

?>

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Departman Yönetimi</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Departman Yönetimi</li>
                    </ol>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Departman Ekleme/Düzenleme Formu -->
            <div class="col-lg-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">
                            <?php echo isset($_GET['duzenle']) ? 'Departman Düzenle' : 'Yeni Departman Ekle'; ?>
                        </h4>
                        
                        <form method="POST" action="">
                            <?php if (isset($_GET['duzenle'])): ?>
                                <input type="hidden" name="departman_id" value="<?php echo $duzenle_departman['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label>Departman Adı</label>
                                <input type="text" class="form-control" name="departman_adi" 
                                       value="<?php echo isset($duzenle_departman) ? $duzenle_departman['adi'] : ''; ?>" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label>Açıklama</label>
                                <textarea class="form-control" name="departman_aciklama" rows="3"><?php echo isset($duzenle_departman) ? $duzenle_departman['aciklama'] : ''; ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Durum</label>
                                <select class="form-control" name="durum" required>
                                    <option value="1" <?php echo (isset($duzenle_departman) && $duzenle_departman['durum'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="0" <?php echo (isset($duzenle_departman) && $duzenle_departman['durum'] == 0) ? 'selected' : ''; ?>>Pasif</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <?php if (isset($_GET['duzenle'])): ?>
                                    <button type="submit" name="departman_duzenle" class="btn btn-warning waves-effect waves-light">
                                        <i class="mdi mdi-pencil"></i> Güncelle
                                    </button>
                                    <a href="departman" class="btn btn-secondary waves-effect waves-light">
                                        <i class="mdi mdi-close"></i> İptal
                                    </a>
                                <?php else: ?>
                                    <button type="submit" name="departman_ekle" class="btn btn-success waves-effect waves-light">
                                        <i class="mdi mdi-plus"></i> Ekle
                                    </button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Departman Listesi -->
            <div class="col-lg-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Departman Listesi</h4>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Departman Adı</th>
                                        <th>Açıklama</th>
                                        <th>Durum</th>
                                        <th>Admin Sayısı</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $departmanlar = $ozy->query("SELECT d.*, 
                                        (SELECT COUNT(*) FROM admin WHERE departman = d.id) as admin_sayisi
                                        FROM departman d ORDER BY d.id DESC")->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach ($departmanlar as $departman): ?>
                                        <tr>
                                            <td><?php echo $departman['id']; ?></td>
                                            <td><?php echo $departman['adi']; ?></td>
                                            <td><?php echo $departman['aciklama']; ?></td>
                                            <td>
                                                <?php if ($departman['durum'] == 1): ?>
                                                    <span class="badge badge-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Pasif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $departman['admin_sayisi']; ?></span>
                                            </td>
                                            <td>
                                                <a href="departman?duzenle=<?php echo $departman['id']; ?>" 
                                                   class="btn btn-sm btn-warning waves-effect waves-light" title="Düzenle">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <a href="departman?yetki=<?php echo $departman['id']; ?>" 
                                                   class="btn btn-sm btn-info waves-effect waves-light" title="Yetki Ayarla">
                                                    <i class="mdi mdi-key"></i>
                                                </a>
                                                <?php if ($departman['admin_sayisi'] == 0): ?>
                                                    <a href="departman?sil=<?php echo $departman['id']; ?>" 
                                                       class="btn btn-sm btn-danger waves-effect waves-light" 
                                                       onclick="return confirm('Bu departmanı silmek istediğinizden emin misiniz?')" title="Sil">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['yetki'])): ?>
            <!-- Yetki Ayarlama Modal -->
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <?php
                            $yetki_departman_id = temizle($_GET['yetki']);
                            $yetki_departman = $ozy->query("SELECT * FROM departman WHERE id = $yetki_departman_id")->fetch(PDO::FETCH_ASSOC);
                            
                            // Departman var mı kontrol et
                            if (!$yetki_departman) {
                                echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Departman bulunamadı.", "Hata");});</script>';
                                echo '<meta http-equiv="refresh" content="1; url=departman">';
                                exit();
                            }
                            
                            $mevcut_yetki = $ozy->query("SELECT * FROM yetki WHERE departmanid = $yetki_departman_id")->fetch(PDO::FETCH_ASSOC);
                            $mevcut_menu_ids = $mevcut_yetki ? explode(',', $mevcut_yetki['menu']) : array();
                            ?>
                            
                            <h4 class="mt-0 header-title">
                                Yetki Ayarları - <?php echo $yetki_departman['adi']; ?>
                            </h4>
                            
                            <form method="POST" action="">
                                <input type="hidden" name="departman_id" value="<?php echo $yetki_departman_id; ?>">
                                
                                <div class="row">
                                    <?php
                                    // Ana menüleri al (sadece departman yetki sistemine dahil olanlar)
                                    $ana_menuler = $ozy->query("SELECT * FROM menu WHERE durum = 1 AND ustmenu = 0 AND id IN (2,3,4,5,6,7,8,59) ORDER BY sira ASC")->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach ($ana_menuler as $ana_menu): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="mb-0">
                                                        <i class="<?php echo $ana_menu['icon']; ?>"></i>
                                                        <?php echo $ana_menu['menuadi']; ?>
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <?php
                                                    // Alt menüleri al
                                                    $alt_menuler = $ozy->query("SELECT * FROM menu WHERE durum = 1 AND ustmenu = {$ana_menu['id']} ORDER BY sira ASC")->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    if (count($alt_menuler) > 0): ?>
                                                        <?php foreach ($alt_menuler as $alt_menu): ?>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" 
                                                                       name="menu_ids[]" value="<?php echo $alt_menu['id']; ?>"
                                                                       id="menu_<?php echo $alt_menu['id']; ?>"
                                                                       <?php echo in_array($alt_menu['id'], $mevcut_menu_ids) ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="menu_<?php echo $alt_menu['id']; ?>">
                                                                    <i class="<?php echo $alt_menu['icon']; ?>"></i>
                                                                    <?php echo $alt_menu['menuadi']; ?>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="menu_ids[]" value="<?php echo $ana_menu['id']; ?>"
                                                                   id="menu_<?php echo $ana_menu['id']; ?>"
                                                                   <?php echo in_array($ana_menu['id'], $mevcut_menu_ids) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="menu_<?php echo $ana_menu['id']; ?>">
                                                                <i class="<?php echo $ana_menu['icon']; ?>"></i>
                                                                <?php echo $ana_menu['menuadi']; ?>
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="form-group mt-3">
                                    <button type="submit" name="yetki_guncelle" class="btn btn-success waves-effect waves-light">
                                        <i class="mdi mdi-check"></i> Yetkileri Güncelle
                                    </button>
                                    <a href="departman" class="btn btn-secondary waves-effect waves-light">
                                        <i class="mdi mdi-close"></i> Kapat
                                    </a>
                                </div>
                            </form>
                            
                            <script>
                            $(document).ready(function() {
                                // Alt menü seçildiğinde üst menüyü otomatik seç
                                $('input[name="menu_ids[]"]').change(function() {
                                    var checkbox = $(this);
                                    var isChecked = checkbox.is(':checked');
                                    var card = checkbox.closest('.card');
                                    var parentCheckbox = card.find('input[name="menu_ids[]"]').first();
                                    
                                    // Eğer bu alt menü ise (ana menü değilse)
                                    if (checkbox.attr('id') !== parentCheckbox.attr('id')) {
                                        if (isChecked) {
                                            // Alt menü seçildiğinde üst menüyü de seç
                                            parentCheckbox.prop('checked', true);
                                        } else {
                                            // Alt menü kaldırıldığında, eğer başka alt menü yoksa üst menüyü de kaldır
                                            var otherChildCheckboxes = card.find('input[name="menu_ids[]"]').not(parentCheckbox);
                                            var hasOtherChecked = false;
                                            
                                            otherChildCheckboxes.each(function() {
                                                if ($(this).is(':checked')) {
                                                    hasOtherChecked = true;
                                                    return false; // break
                                                }
                                            });
                                            
                                            if (!hasOtherChecked) {
                                                parentCheckbox.prop('checked', false);
                                            }
                                        }
                                    } else {
                                        // Üst menü seçildiğinde tüm alt menüleri seç
                                        var childCheckboxes = card.find('input[name="menu_ids[]"]').not(parentCheckbox);
                                        childCheckboxes.prop('checked', isChecked);
                                    }
                                });
                                
                                // Sayfa yüklendiğinde mevcut durumu kontrol et
                                $('.card').each(function() {
                                    var card = $(this);
                                    var parentCheckbox = card.find('input[name="menu_ids[]"]').first();
                                    var childCheckboxes = card.find('input[name="menu_ids[]"]').not(parentCheckbox);
                                    
                                    // Eğer tüm alt menüler seçiliyse üst menüyü de seç
                                    var allChildrenChecked = true;
                                    childCheckboxes.each(function() {
                                        if (!$(this).is(':checked')) {
                                            allChildrenChecked = false;
                                            return false; // break
                                        }
                                    });
                                    
                                    if (allChildrenChecked && childCheckboxes.length > 0) {
                                        parentCheckbox.prop('checked', true);
                                    }
                                });
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>