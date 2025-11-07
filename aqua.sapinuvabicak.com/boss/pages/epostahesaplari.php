<?php

session_start();
if (!empty($_SESSION['toastr'])) {
    echo '<script>
        $(document).ready(function(){
            toastr["' . $_SESSION['toastr']['type'] . '"]("' . $_SESSION['toastr']['message'] . '");
        });
    </script>';
    unset($_SESSION['toastr']);
}

error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../error_log.txt');

admin_yetki($ozy, $_SESSION['departmanid'], 3);

$url = $_SESSION['alanadi'];

// maillistele.php'den API fonksiyonlarını entegre et
function makeApiCall($endpoint, $params = [])
{
    global $url;

    $cpanelUser = $_SESSION['kullanici'];
    $apiToken = 'EP19G845I171S4ZI9L2QS5WP29BJ0ZN7';

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

// Mail hesaplarını al
$mailList = makeApiCall('Email/list_pops', ['api.version' => 1]);

// E-posta hesap sayısını kontrol et (ana hesap hariç)
$currentEmailCount = 0;
if (isset($mailList['status']) && $mailList['status'] == 1 && !empty($mailList['data'])) {
    foreach ($mailList['data'] as $mail) {
        if ($mail['email'] != $_SESSION['kullanici']) {
            $currentEmailCount++;
        }
    }
}



// Maksimum hesap limiti
$maxEmailLimit = 5;
$isLimitReached = $currentEmailCount >= $maxEmailLimit;



// AJAX işlemini handle et
if ($_POST && isset($_POST['action']) && $_POST['action'] == 'eposta_olustur' && isset($_POST['mailadresi'])) {
    // Limit kontrolü
    if ($isLimitReached) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Maksimum e-posta hesap limitine ulaştınız! (Limit: ' . $maxEmailLimit . ' hesap)',
            'isLimitReached' => true
        ]);
        exit;
    }

    eposta_olustur();
    exit; // AJAX için exit
}


function eposta_olustur()
{
    global $kullanici;
    global $mailadresi;
    global $mailadresisifre;
    global $adminid;
    global $url;
    global $kota;

    $kullanici = $_SESSION['kullanici'];
    $mailadresi = $_POST['mailadresi'];
    $mailadresisifre = $_POST['mailadresisifresi'];
    $adminid = $_POST['adminid'];
    $kota = $_SESSION['mailkota'];



    // Gerçek API işlemi
    $apiToken = 'EP19G845I171S4ZI9L2QS5WP29BJ0ZN7';
    $apiUrl = "https://$url:2083/execute/Email/add_pop";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: cpanel $kullanici:$apiToken"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'email' => $mailadresi,
        'password' => $mailadresisifre,
        'domain' => $url,
        'quota' => $kota
    ]));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // JSON response döndür (AJAX için)
    header('Content-Type: application/json');

    if ($response === false) {
        echo json_encode([
            'success' => false,
            'message' => 'CURL Hatası: ' . curl_error($ch),
            'httpCode' => $httpCode
        ]);
    } else {
        $responseData = json_decode($response, true);

        if ($responseData === null) {
            echo json_encode([
                'success' => false,
                'message' => 'API\'den geçersiz yanıt alındı.',
                'httpCode' => $httpCode,
                'rawResponse' => substr($response, 0, 200)
            ]);
        } else {
            $isSuccess = isset($responseData['status']) && $responseData['status'] == 1;

            if ($isSuccess) {
                global $ozy;
                $fullEmail = $mailadresi . '@' . $url; // @ işareti arasında boşluk yok
                $dbyaz = $ozy->prepare("INSERT INTO epostahesaplari (adminid, mail, kota, kullanim, durum) VALUES (?, ?, ?, '0', '1')");
                $dbyaz->execute([$adminid, $fullEmail, $kota]);
            }

            $message = $isSuccess ? 'E-posta hesabı başarıyla oluşturuldu!' : 'E-posta hesabı oluşturulurken hata oluştu.';

            if (isset($responseData['errors']) && !empty($responseData['errors'])) {
                $message .= ' Hatalar: ' . implode(', ', $responseData['errors']);
            }

            echo json_encode([
                'success' => $isSuccess,
                'message' => $message,
                'httpCode' => $httpCode,
                'data' => $responseData
            ]);
        }
    }

    curl_close($ch);
}




?>



<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Eposta Hesapları

                    </h4>
                </div>


                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                        <li class="breadcrumb-item active">Eposta Hesapları
                        </li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <!-- E-posta Limit Bilgisi -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-<?php echo $isLimitReached ? 'warning' : 'info'; ?> d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="alert-heading mb-1">
                                            <i class="fa fa-info-circle mr-1"></i>
                                            E-posta Hesap Durumu
                                        </h6>
                                        <p class="mb-0">
                                            <strong><?php echo $currentEmailCount; ?></strong> / <strong><?php echo $maxEmailLimit; ?></strong> hesap kullanılıyor
                                            <?php if ($isLimitReached): ?>
                                                <span class="text-danger ml-2">
                                                    <i class="fa fa-exclamation-triangle"></i> Limit doldu!
                                                </span>
                                            <?php else: ?>
                                                <span class="text-light ml-2">
                                                    <i class="fa fa-check"></i>
                                                    <?php echo ($maxEmailLimit - $currentEmailCount); ?> hesap daha ekleyebilirsiniz
                                                </span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <?php if ($isLimitReached): ?>
                                        <div class="ml-3">
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="showUpgradeInfo()">
                                                <i class="fa fa-arrow-up mr-1"></i>Paket Yükselt
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                       

                        <div class="tab-content">
                            <div class="tab-pane active p-3" id="home-1" role="tabpanel">

                                <div id="epostaForm">
                                    <div class="form-group row">
                                        <label for="mailadresi" class="col-sm-2 col-form-label">Eposta Adresi</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="mailadresi"
                                                    value="" name="mailadresi" autocomplete="off"
                                                    placeholder="<?php echo $isLimitReached ? 'Limit doldu - paket yükseltin' : 'ornek'; ?>"
                                                    required pattern="^[a-zA-Z][a-zA-Z0-9._-]*$"
                                                    <?php echo $isLimitReached ? 'disabled' : ''; ?>>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">@<?php echo $url; ?></span>
                                                </div>
                                            </div>
                                            <small id="emailHelp" class="form-text text-muted">İlk karakter harf olmalı, @ işareti ve boşluk kullanmayın</small>
                                            <small id="emailError" class="form-text text-danger" style="display:none;"></small>
                                            <input type="hidden" name="url" value="<?php echo $url; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="mailadresisifresi" class="col-sm-2 col-form-label">Eposta Şifresi</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="mailadresisifresi"
                                                value="" name="mailadresisifresi" autocomplete="new-password"
                                                placeholder="<?php echo $isLimitReached ? 'Limit doldu' : 'Güçlü bir şifre girin'; ?>"
                                                required minlength="6"
                                                <?php echo $isLimitReached ? 'disabled' : ''; ?>>
                                            <div class="password-strength mt-2" id="passwordStrength" style="display:none;">
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%"></div>
                                                </div>
                                                <small id="strengthText" class="form-text"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="adminid" class="col-sm-2 col-form-label">Yönetici Ata</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="adminid" name="adminid" <?php echo $isLimitReached ? 'disabled' : ''; ?>>
                                                <option value="0"><?php echo $isLimitReached ? 'Limit doldu' : 'Atamasız'; ?></option>
                                                <?php if (!$isLimitReached): ?>
                                                    <?php $yoneticiata = $ozy->query("select * from admin where durum='1'")->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($yoneticiata as $de) { ?>
                                                        <option value="<?php echo $de['id']; ?>"><?php echo $de['adi'] . " " . strtoupper($de['soyadi']); ?></option>
                                                    <?php } ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php if ($isLimitReached): ?>
                            <button type="button" class="btn btn-warning btn-lg btn-block" disabled>
                                <i class="fa fa-lock mr-2"></i>Limit Doldu - Paket Yükseltin
                            </button>
                            <div class="text-center mt-2">
                                <button type="button" class="btn btn-outline-primary" onclick="contactSupport()">
                                    <i class="fa fa-phone mr-1"></i>Destek İletişim
                                </button>
                            </div>
                        <?php else: ?>
                            <button type="button" onclick="eposta_olustur();" class="btn btn-success btn-lg btn-block waves-effect waves-light" id="olusturBtn" disabled>
                                <i class="fa fa-plus mr-2"></i>Oluştur
                            </button>
                        <?php endif; ?>
                    </div>



                </div>

            </div>
        </div>

        <!-- E-posta Hesapları Listesi -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fa fa-list mr-2"></i>Mevcut E-posta Hesapları
                        </h5>

                        <?php if (isset($mailList['status']) && $mailList['status'] == 1 && !empty($mailList['data'])): ?>
                            <div class="table-responsive">
                                <table id="emailListTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th><i class="fa fa-envelope"></i> E-posta Adresi</th>
                                            <th><i class="fa fa-database"></i> Kota</th>
                                            <th><i class="fa fa-circle"></i> Kullanım</th>
                                            <th><i class="fa fa-info-circle"></i> Durum</th>
                                            <th><i class="fa fa-user"></i> Yönetici</th>
                                            <!-- <th><i class="fa fa-cogs"></i> İşlemler</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($mailList['data'] as $mail):
                                            if ($mail['email'] != $_SESSION['kullanici']): // Ana hesabı gösterme
                                                $status = ($mail['suspended_login'] || $mail['suspended_incoming']) ? "Askıya Alınmış" : "Aktif";
                                                $statusClass = ($status == "Aktif") ? "success" : "danger";
                                                $email = $mail['email'];

                                                // Mail hesabı için kota bilgisi al
                                                $quotaInfo = makeApiCall('Email/get_pop_quota', [
                                                    'api.version' => 1,
                                                    'email' => $email
                                                ]);

                                                // Disk kullanım bilgisi al
                                                $emailParts = explode('@', $email);
                                                $domain = isset($emailParts[1]) ? $emailParts[1] : $url;
                                                $username = isset($emailParts[0]) ? $emailParts[0] : $email;

                                                $diskInfo = makeApiCall('Email/get_disk_usage', [
                                                    'api.version' => 1,
                                                    'user' => $username,
                                                    'domain' => $domain
                                                ]);

                                                // Kota bilgisini formatla
                                                $quota = '<span class="text-muted">Bilinmiyor</span>';
                                                if (isset($quotaInfo['data']) && $quotaInfo['status'] == 1) {
                                                    if (is_numeric($quotaInfo['data'])) {
                                                        $quota = '<span class="badge badge-info">' . $quotaInfo['data'] . ' MB</span>';
                                                    } else {
                                                        $quota = '<span class="badge badge-warning">' . ucfirst($quotaInfo['data']) . '</span>';
                                                    }
                                                }

                                                // Disk kullanım bilgisini formatla
                                                $diskused = '<span class="text-muted">Bilinmiyor</span>';
                                                if (isset($diskInfo['data']['diskused']) && $diskInfo['status'] == 1) {
                                                    $diskusedMB = round($diskInfo['data']['diskused'], 2);
                                                    $diskused = '<span class="badge badge-secondary">' . $diskusedMB . ' MB</span>';
                                                }

                                                // Oluşturma tarihi (varsayılan)
                                                $createDate = '<span class="text-muted">Bilinmiyor</span>';
                                        ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($email); ?></strong>
                                                    </td>
                                                    <td><?php echo $quota; ?></td>
                                                    <td><?php echo $diskused; ?></td>
                                                    <td>
                                                        <span class="badge badge-<?php echo $statusClass; ?>">
                                                            <i class="fa fa-<?php echo ($status == 'Aktif') ? 'check' : 'times'; ?>"></i>
                                                            <?php echo $status; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        global $ozy;

                                                        // epostahesaplari tablosundan admin bilgilerini çekiyoruz
                                                        $adminQuery = $ozy->prepare("
                                                              SELECT a.adi, a.soyadi, e.adminid, e.mail
                                                              FROM epostahesaplari e
                                                              LEFT JOIN admin a ON e.adminid = a.id
                                                              WHERE e.mail = ? AND e.durum='1'
                                                              LIMIT 1
                                                          ");
                                                        $adminQuery->execute([$email]);
                                                        $adminData = $adminQuery->fetch(PDO::FETCH_ASSOC);

                                                        if ($adminData && $adminData['adminid'] != "0" && $adminData['adi']) {
                                                            echo htmlspecialchars($adminData['adi']) . " " . strtoupper($adminData['soyadi']);
                                                        } else {
                                                            echo '<span class="text-muted">Atanmamış</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <!-- <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-info" 
                                                            onclick="showEmailDetails('<?php //echo htmlspecialchars($email); 
                                                                                        ?>')"
                                                            data-toggle="tooltip" title="Detayları Göster">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning" 
                                                            onclick="changeEmailPassword('<?php //echo htmlspecialchars($email); 
                                                                                            ?>')"
                                                            data-toggle="tooltip" title="Şifre Değiştir">
                                                        <i class="fa fa-key"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="deleteEmail('<?php //echo htmlspecialchars($email); 
                                                                                    ?>')"
                                                            data-toggle="tooltip" title="Hesabı Sil">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td> -->
                                                </tr>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
                                <h5>E-posta Hesabı Bulunamadı</h5>
                                <p class="mb-0">Henüz hiç e-posta hesabı oluşturulmamış veya hesaplar alınamıyor.</p>
                                <?php if (isset($mailList['errors'])): ?>
                                    <small class="text-muted">Hata: <?php echo implode(', ', $mailList['errors']); ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->
<style>
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
        color: #495057;
        font-weight: 500;
    }

    .password-strength .progress-bar.weak {
        background-color: #dc3545;
    }

    .password-strength .progress-bar.medium {
        background-color: #ffc107;
    }

    .password-strength .progress-bar.strong {
        background-color: #28a745;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .is-valid {
        border-color: #28a745;
    }

    .btn:disabled {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: #fff !important;
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn:disabled:hover {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        transform: none !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('mailadresi');
        const passwordInput = document.getElementById('mailadresisifresi');
        const emailError = document.getElementById('emailError');
        const emailHelp = document.getElementById('emailHelp');
        const passwordStrength = document.getElementById('passwordStrength');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const olusturBtn = document.getElementById('olusturBtn');
        const adminSelect = document.getElementById('adminid');
        const formContainer = document.getElementById('epostaForm');

        let emailValid = false;
        let passwordStrong = false;

        function checkFormValidity() {
            if (emailValid && passwordStrong) {
                olusturBtn.disabled = false;
                olusturBtn.innerHTML = '<i class="fa fa-plus mr-2"></i>Oluştur';
                olusturBtn.title = 'Eposta hesabı oluşturmak için tıklayın';
            } else {
                olusturBtn.disabled = true;
                let reasons = [];
                if (!emailValid) reasons.push('Geçerli eposta adresi');
                if (!passwordStrong) reasons.push('Güçlü şifre');
                olusturBtn.innerHTML = '<i class="fa fa-lock mr-2"></i>Oluştur';
                olusturBtn.title = 'Eksikler: ' + reasons.join(', ');
            }
        }

        emailInput.addEventListener('input', function() {
            const value = this.value;
            let isValid = true;
            let errorMessage = '';

            if (value === '') {
                emailError.style.display = 'none';
                emailHelp.style.display = 'block';
                this.classList.remove('is-invalid', 'is-valid');
                emailValid = false;
                checkFormValidity();
                return;
            }

            if (value.includes('@')) {
                isValid = false;
                errorMessage = '@ işareti kullanmayın, otomatik eklenir';
            } else if (value.includes(' ')) {
                isValid = false;
                errorMessage = 'Boşluk karakteri kullanmayın';
            } else if (!/^[a-zA-Z]/.test(value)) {
                isValid = false;
                errorMessage = 'İlk karakter mutlaka harf olmalı';
            } else if (!/^[a-zA-Z][a-zA-Z0-9._-]*$/.test(value)) {
                isValid = false;
                errorMessage = 'Sadece harf, rakam, nokta, alt çizgi ve tire kullanabilirsiniz';
            } else if (value.length < 3) {
                isValid = false;
                errorMessage = 'En az 3 karakter olmalı';
            }

            if (isValid) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                emailError.style.display = 'none';
                emailHelp.style.display = 'block';
                emailValid = true;
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                emailError.textContent = errorMessage;
                emailError.style.display = 'block';
                emailHelp.style.display = 'none';
                emailValid = false;
            }

            checkFormValidity();
        });

        passwordInput.addEventListener('input', function() {
            const password = this.value;

            if (password === '') {
                passwordStrength.style.display = 'none';
                this.classList.remove('is-invalid', 'is-valid');
                passwordStrong = false;
                checkFormValidity();
                return;
            }

            passwordStrength.style.display = 'block';

            let score = 0;
            let feedback = '';

            if (password.length >= 8) score += 1;
            if (password.length >= 12) score += 1;

            if (/[a-z]/.test(password)) score += 1;

            if (/[A-Z]/.test(password)) score += 1;

            if (/[0-9]/.test(password)) score += 1;

            if (/[^A-Za-z0-9]/.test(password)) score += 1;

            if (score <= 2) {
                strengthBar.className = 'progress-bar weak';
                strengthBar.style.width = '33%';
                strengthText.textContent = 'Zayıf şifre - Oluştur butonu devre dışı';
                strengthText.className = 'form-text text-danger';
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                passwordStrong = false;
            } else if (score <= 4) {
                strengthBar.className = 'progress-bar medium';
                strengthBar.style.width = '66%';
                strengthText.textContent = 'Orta güçlü şifre - Güçlü şifre gerekli';
                strengthText.className = 'form-text text-warning';
                this.classList.remove('is-invalid', 'is-valid');
                passwordStrong = false;
            } else {
                strengthBar.className = 'progress-bar strong';
                strengthBar.style.width = '100%';
                strengthText.textContent = 'Güçlü şifre - Mükemmel!';
                strengthText.className = 'form-text text-success';
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
                passwordStrong = true;
            }

            checkFormValidity();
        });

        checkFormValidity();

        // JavaScript eposta_olustur fonksiyonu
        window.eposta_olustur = function() {
            if (olusturBtn.disabled) {
                alert('Form henüz tamamlanmadı. Lütfen tüm alanları doğru şekilde doldurun.');
                return false;
            }

            if (!emailValid || !passwordStrong) {
                alert('Geçerli bir e-posta adresi ve güçlü bir şifre gereklidir.');
                return false;
            }

            // Butonu işlem durumuna getir
            olusturBtn.disabled = true;
            olusturBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>İşlem Yapılıyor...';

            // AJAX ile işlem yap
            const formData = new FormData();
            formData.append('action', 'eposta_olustur');
            formData.append('mailadresi', emailInput.value);
            formData.append('mailadresisifresi', passwordInput.value);
            formData.append('adminid', adminSelect.value);

            fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Başarılı
                        alert('✅ ' + data.message);
                        // Formu temizle
                        emailInput.value = '';
                        passwordInput.value = '';
                        adminSelect.value = '0';
                        emailInput.classList.remove('is-valid', 'is-invalid');
                        passwordInput.classList.remove('is-valid', 'is-invalid');
                        emailError.style.display = 'none';
                        emailHelp.style.display = 'block';
                        passwordStrength.style.display = 'none';
                        emailValid = false;
                        passwordStrong = false;

                        // Sayfayı yenile (e-posta listesini güncellemek için)
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Hata
                        alert('❌ ' + data.message);
                        
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                    setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                })
                .finally(() => {
                    // Butonu eski haline getir
                    checkFormValidity();
                });

            return false; // Form submit'i engelle
        };

        // E-posta listeleme fonksiyonları
        window.showEmailDetails = function(email) {
            alert('📧 E-posta Detayları\n\nE-posta: ' + email + '\n\nDetaylı bilgiler için geliştirme devam ediyor...');
        };

        window.changeEmailPassword = function(email) {
            const newPassword = prompt('🔑 Yeni Şifre\n\n' + email + ' hesabı için yeni şifre girin:');
            if (newPassword && newPassword.length >= 10) {
                if (confirm('Şifreyi değiştirmek istediğinize emin misiniz?')) {
                    alert('🔧 Şifre değiştirme özelliği geliştirme aşamasında...\n\nYeni şifre: ' + '*'.repeat(newPassword.length));
                }
            } else if (newPassword !== null) {
                alert('⚠️ Şifre en az 10 karakter olmalıdır!');
            }
        };

        window.deleteEmail = function(email) {
            if (confirm('⚠️ DİKKAT!\n\n' + email + ' hesabını silmek istediğinize emin misiniz?\n\nBu işlem geri alınamaz!')) {
                if (confirm('Son kez soruyorum!\n\nGerçekten ' + email + ' hesabını silmek istiyor musunuz?')) {
                    alert('🗑️ E-posta silme özelliği geliştirme aşamasında...\n\nSilinecek: ' + email);
                }
            }
        };

        // Yükseltme bilgi fonksiyonları
        window.showUpgradeInfo = function() {
            alert('📈 Paket Yükseltme Bilgileri\n\n' +
                '🔹 PLUS Paket: 15 e-posta hesabı\n' +
                '🔹 EXTREME Paket: 50 e-posta hesabı\n' +
                '🔹 ENTERPRISE Paket: Sınırsız e-posta\n\n' +
                'Detaylar için destek ekibi ile iletişime geçin.');
        };

        window.contactSupport = function() {
            if (confirm('🎧 Destek Ekibi ile İletişim\n\n' +
                    'Paket yükseltme için destek ekibi ile iletişime geçmek istiyor musunuz?\n\n' +
                    'WhatsApp, Telefon veya E-posta ile iletişim kurabilirsiniz.')) {
                // Burada destek sayfasına yönlendirme yapılabilir
                alert('📞 İletişim Bilgileri:\n\n' +
                    '📱 WhatsApp: +90 XXX XXX XX XX\n' +
                    '☎️ Telefon: +90 XXX XXX XX XX\n' +
                    '📧 E-posta: destek@sapinuvabicak.com\n\n' +
                    'Paket yükseltme talebinizi iletebilirsiniz.');
            }
        };

        // DataTable'ı başlat (eğer liste varsa)
        if (document.getElementById('emailListTable')) {
            $(document).ready(function() {
                $('#emailListTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
                    },
                    "order": [
                        [0, "asc"]
                    ],
                    "pageLength": 10,
                    "responsive": true
                });

                // Tooltip'leri aktifleştir
                $('[data-toggle="tooltip"]').tooltip();
            });
        }
    });
</script>