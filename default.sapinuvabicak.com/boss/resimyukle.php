<?php define("guvenlik", true); ?>
<?php
require('../func/db.php');
require('../func/fonksiyon.php');
giriskontrol($ozy, 1);

if (!isset($_SESSION["giris"])) {
    header("Location:index.php");
} else {

}

// Paket sistemi için ayarları al
$paket_adi = $_SESSION['paketadi'];
$resim_limit = $_SESSION['resim_limit'];
$upload_modu = upload_modu_al();
$max_bulk_limit = max_bulk_limit_al();
$paket_bilgileri = paket_bilgileri_al();

$sayfaidx = temizle($_GET['id']);
$alanx = temizle($_GET['alan']);
$tresimler = $ozy->query("select * from tumresimler where sayfaid='$sayfaidx' and alan='$alanx' order by id desc")->fetchAll(PDO::FETCH_ASSOC);
$mevcut_resim_sayisi = count($tresimler);
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

<body>

    <?php if ($upload_modu == 'tek_tek') { ?>
        <!-- Paket1 için özel tek dosya yükleme sistemi -->
        <div id="tek-yukle-container" style="border: 2px dashed #0087F7; border-radius: 10px; padding: 40px; text-align: center; background: #f8f9ff; margin: 20px 0;">
            <div style="margin-bottom: 20px;">
                <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #0087F7; margin-bottom: 15px;"></i>
                           <p style="color: #666; margin-bottom: 20px;">Sadece bir dosya seçebilirsiniz (JPG, JPEG, PNG)</p>
            </div>
            
            <form id="tekDosyaForm" enctype="multipart/form-data" style="margin-bottom: 20px;">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <input type="hidden" name="alan" value="<?php echo $_GET['alan']; ?>" />
                <input type="file" id="tekDosyaInput" name="file" accept=".jpg,.jpeg,.png" style="display: none;" />
                <button type="button" id="dosyaSecBtn" class="btn btn-primary btn-lg">
                    <i class="fas fa-folder-open"></i> Dosya Seç
                </button>
            </form>
            
            <div id="yuklemeDurumu" style="display: none; margin-top: 20px;">
                <div id="yuklemeProgress" style="background: #e9ecef; border-radius: 5px; overflow: hidden; margin-bottom: 10px;">
                    <div style="background: #0087F7; height: 20px; width: 0%; transition: width 0.3s;"></div>
                </div>
                <span id="yuklemeMetni">Yükleniyor...</span>
            </div>
        </div>
    <?php } else { ?>
        <form action="upload.php" class="dropzone" id="dropzoneFrom">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
            <input type="hidden" name="alan" value="<?php echo $_GET['alan']; ?>" />
        </form>
    <?php } ?>




    <div id="preview"></div>
    <br />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/dropzone.css" />
    <script src="assets/dropzone.js"></script>
    
    <style>
        <?php if ($upload_modu == 'coklu') { ?>
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
        }
        .dropzone .dz-message {
            font-weight: 600;
            color: #666;
        }
        <?php } ?>
        
        #tek-yukle-container {
            transition: all 0.3s ease;
        }
        
        #tek-yukle-container:hover {
            border-color: #0056b3;
            background: #f0f7ff;
        }
        
        #dosyaSecBtn {
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        #dosyaSecBtn:hover:not(:disabled) {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,87,243,0.3);
        }
        
        #dosyaSecBtn:disabled {
            background: #6c757d;
            border-color: #6c757d;
            cursor: not-allowed;
        }
    </style>

    <script>

        $(document).ready(function () {

            let maxFiles = <?php echo $resim_limit - $mevcut_resim_sayisi; ?>;
            let uploadModu = '<?php echo $upload_modu; ?>';
            let maxBulkLimit = <?php echo $max_bulk_limit; ?>;
            let paketAdi = '<?php echo $paket_adi; ?>';

            <?php if ($upload_modu == 'tek_tek') { ?>
                $('#dosyaSecBtn').click(function() {
                    $('#tekDosyaInput').click();
                });

                $('#tekDosyaInput').change(function() {
                    var file = this.files[0];
                    if (file) {
                        // Dosya doğrulaması
                        var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Sadece JPG, JPEG ve PNG dosyaları yükleyebilirsiniz.');
                            this.value = '';
                            return;
                        }

                        // Dosya boyutu kontrolü (5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Dosya boyutu 5MB\'dan küçük olmalıdır.');
                            this.value = '';
                            return;
                        }

                        // Mevcut resim sayısı kontrolü
                        if (maxFiles <= 0) {
                            alert('Resim yükleme limitine ulaşıldı. Maksimum <?php echo $resim_limit; ?> resim yükleyebilirsiniz.');
                            this.value = '';
                            return;
                        }

                        // Dosyayı yükle
                        var formData = new FormData();
                        formData.append('file', file);
                        formData.append('id', <?php echo $_GET["id"]; ?>);
                        formData.append('alan', '<?php echo $_GET["alan"]; ?>');

                        $('#yuklemeDurumu').show();
                        $('#dosyaSecBtn').prop('disabled', true).text('Yükleniyor...');

                        $.ajax({
                            url: 'upload.php',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        var percentComplete = (evt.loaded / evt.total) * 100;
                                        $('#yuklemeProgress div').css('width', percentComplete + '%');
                                    }
                                }, false);
                                return xhr;
                            },
                            success: function(response) {
                                $('#yuklemeDurumu').hide();
                                $('#dosyaSecBtn').prop('disabled', false).html('<i class="fas fa-folder-open"></i> Dosya Seç');
                                $('#tekDosyaInput').val('');
                                
                                if (response === 'basarili' || response.trim() === '') {
                                    
                                    list_image();
                                } else {
                                    handleUploadError(response);
                                }
                            },
                            error: function() {
                                $('#yuklemeDurumu').hide();
                                $('#dosyaSecBtn').prop('disabled', false).html('<i class="fas fa-folder-open"></i> Dosya Seç');
                                alert('Yükleme sırasında bir hata oluştu. Lütfen tekrar deneyin.');
                            }
                        });
                    }
                });

                function handleUploadError(response) {
                    switch(response.trim()) {
                        case 'limit_doldu':
                            alert('Resim yükleme limitine ulaşıldı. Maksimum <?php echo $resim_limit; ?> resim yükleyebilirsiniz.');
                            break;
                        case 'paket_limit_asildi':
                            alert('Mevcut pakette tek tek yükleme yapabilirsiniz.');
                            break;
                        case 'toplam_limit_doldu':
                            alert('Toplam resim limitine ulaştınız. Maksimum <?php echo $resim_limit; ?> resim yükleyebilirsiniz.');
                            break;
                        case 'gecersiz_dosya':
                            alert('Sadece JPG, JPEG ve PNG dosyaları yükleyebilirsiniz.');
                            break;
                        case 'dosya_hatasi':
                            alert('Dosya yükleme hatası. Lütfen tekrar deneyin.');
                            break;
                        case 'yuklenemedi':
                            alert('Dosya yüklenemedi. Lütfen tekrar deneyin.');
                            break;
                        default:
                            alert('Bilinmeyen hata: ' + response);
                    }
                }

            <?php } else { ?>
                // Paket2+ için Dropzone konfigürasyonu
                var dropzoneConfig = {
                autoProcessQueue: true,
                acceptedFiles: ".png,.jpg,.jpeg",
                uploadMultiple: false, // Her zaman tek tek yükle
                maxFiles: uploadModu === 'tek_tek' ? 1 : Math.min(maxFiles, maxBulkLimit),
                parallelUploads: uploadModu === 'tek_tek' ? 1 : maxBulkLimit,
                addRemoveLinks: true,
                
                // Türkçe mesajlar
                dictDefaultMessage: uploadModu === 'tek_tek' ? 
                    "Mevcut pakette tek tek yükleme yapabilirsiniz. Dosyayı buraya sürükleyin veya tıklayın." :
                    "Dosyaları buraya sürükleyin veya tıklayın",
                dictFallbackMessage: "Tarayıcınız drag&drop dosya yüklemeyi desteklemiyor.",
                dictFallbackText: "Lütfen aşağıdaki formu kullanarak dosyalarınızı yükleyin.",
                dictFileTooBig: "Dosya çok büyük ({{filesize}}MiB). Maksimum dosya boyutu: {{maxFilesize}}MiB.",
                dictInvalidFileType: "Bu dosya türü kabul edilmiyor. Sadece JPG, JPEG ve PNG dosyaları yükleyebilirsiniz.",
                dictResponseError: "Sunucu {{statusCode}} kodu ile yanıt verdi.",
                dictCancelUpload: "Yüklemeyi iptal et",
                dictCancelUploadConfirmation: "Bu yüklemeyi iptal etmek istediğinizden emin misiniz?",
                dictRemoveFile: "Dosyayı kaldır",
                dictMaxFilesExceeded: uploadModu === 'tek_tek' ? 
                    "Mevcut pakette tek tek yükleme yapabilirsiniz." : 
                    "Maksimum " + maxBulkLimit + " resmi aynı anda yükleyebilirsiniz.",
                
            };

            // Tek tek modda çoklu dosya seçimini tamamen engelle
            if (uploadModu === 'tek_tek') {
                dropzoneConfig.clickable = true;
                dropzoneConfig.maxFiles = 1;
                dropzoneConfig.createImageThumbnails = true;
                dropzoneConfig.thumbnailWidth = 80;
                dropzoneConfig.thumbnailHeight = 80;
            }

            Dropzone.options.dropzoneFrom = dropzoneConfig;
            Dropzone.options.dropzoneFrom.init = function () {
                    var myDropzone = this;
                    
                    // Input element'ini paket tipine göre özelleştir
                    if (uploadModu === 'tek_tek') {
                        // Dropzone'un hidden input'unu tamamen kontrol et
                        var observer = new MutationObserver(function(mutations) {
                            mutations.forEach(function(mutation) {
                                mutation.addedNodes.forEach(function(node) {
                                    if (node.nodeType === 1 && node.tagName === 'INPUT' && node.type === 'file') {
                                        node.removeAttribute('multiple');
                                    }
                                });
                            });
                        });
                        
                        observer.observe(myDropzone.element, {
                            childList: true,
                            subtree: true
                        });
                        
                        // Mevcut input'ları da kontrol et
                        var checkInput = setInterval(function() {
                            var inputs = myDropzone.element.querySelectorAll('input[type="file"]');
                            inputs.forEach(function(input) {
                                input.removeAttribute('multiple');
                            });
                            if (inputs.length > 0) {
                                clearInterval(checkInput);
                            }
                        }, 50);
                        
                        // Click event'inde de kontrol et
                        myDropzone.element.addEventListener('click', function() {
                            setTimeout(function() {
                                var inputs = myDropzone.element.querySelectorAll('input[type="file"]');
                                inputs.forEach(function(input) {
                                    input.removeAttribute('multiple');
                                });
                            }, 10);
                        });
                    }

                    this.on("maxfilesexceeded", function (file) {
                        this.removeFile(file);
                        if (uploadModu === 'tek_tek') {
                            alert("Mevcut pakette tek tek yükleme yapabilirsiniz.");
                        } else {
                            alert("Maksimum " + maxBulkLimit + " resmi aynı anda yükleyebilirsiniz.");
                        }
                    });

                    this.on("error", function (file, response) {
                        if (response === "limit_doldu") {
                            this.removeFile(file);
                            alert("Resim yükleme limitine ulaşıldı. Maksimum <?php echo $resim_limit; ?> resim yükleyebilirsiniz.");
                        } else if (response === "paket_limit_asildi") {
                            this.removeFile(file);
                            alert("Mevcut pakette tek tek yükleme yapabilirsiniz.");
                        } else if (response === "coklu_limit_asildi") {
                            this.removeFile(file);
                            alert("Maksimum " + maxBulkLimit + " resmi aynı anda yükleyebilirsiniz.");
                        } else if (response === "toplam_limit_doldu") {
                            this.removeFile(file);
                            alert("Toplam resim limitine ulaştınız. Maksimum <?php echo $resim_limit; ?> resim yükleyebilirsiniz.");
                        } else if (response === "dosya_hatasi") {
                            this.removeFile(file);
                            alert("Dosya yüklenirken bir hata oluştu. Lütfen tekrar deneyin.");
                        } else if (response === "kismi_basarili") {
                            alert("Bazı resimler başarıyla yüklendi, bazıları yüklenemedi.");
                        } else {
                            this.removeFile(file);
                            alert("Resim yüklenirken bir hata oluştu. Lütfen tekrar deneyin.");
                        }
                    });

                    this.on("complete", function () {
                        if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                            this.removeAllFiles();
                        }
                        list_image();
                    });
                };

                Dropzone.options.dropzoneFrom = dropzoneConfig;
                Dropzone.options.dropzoneFrom.init = function () {
                    // Dropzone init kodları burada olacak
                };
            <?php } ?>

            list_image();

            function list_image() {
                $.ajax({
                    url: "upload.php",
                    data: {
                        id: <?php echo $_GET["id"]; ?>,
                        alan: '<?php echo $_GET["alan"]; ?>'
                    },
                    success: function (data) {
                        $('#preview').html(data);
 
                        let yukluAdet = $('#preview img').length;
                        let limit = <?php echo $resim_limit; ?>;
                        let kalanLimit = limit - yukluAdet;
                        maxFiles = kalanLimit; // Global değişkeni güncelle
                         
                        <?php if ($upload_modu == 'tek_tek') { ?>
                            // Paket1 için buton durumunu güncelle
                            if (kalanLimit <= 0) {
                                $('#dosyaSecBtn').prop('disabled', true).html('<i class="fas fa-ban"></i> Limit Doldu');
                                $('#tek-yukle-container p').text('Resim yükleme limitine ulaştınız.');
                            } else {
                                $('#dosyaSecBtn').prop('disabled', false).html('<i class="fas fa-folder-open"></i> Dosya Seç');
                                $('#tek-yukle-container p').text('Sadece bir dosya seçebilirsiniz (JPG, JPEG, PNG)');
                            }
                        <?php } else { ?>
                            // Paket2+ için Dropzone kontrolü
                            if (Dropzone.forElement("#dropzoneFrom")) {
                                let yeniMaxFiles = Math.min(kalanLimit, maxBulkLimit);
                                Dropzone.forElement("#dropzoneFrom").options.maxFiles = yeniMaxFiles;
                                 
                                if (yukluAdet >= limit) {
                                    Dropzone.forElement("#dropzoneFrom").disable();
                                } else {
                                    Dropzone.forElement("#dropzoneFrom").enable();
                                }
                            }
                        <?php } ?>
                        
                        $('#resim_limiti').text('Resim Limiti: ' + yukluAdet + ' / ' + limit);
                         
                        if (window.parent && window.parent !== window) {
                            window.parent.postMessage({
                                type: 'resim_limiti_guncelle',
                                yukluAdet: yukluAdet,
                                limit: limit
                            }, '*');
                        }
                    },
                    error: function() {
                        console.log('Resim listesi yüklenirken hata oluştu');
                    }
                });
            }

            $(document).on('click', '.remove_image', function () {
                var name = $(this).attr('id');
                $.ajax({
                    url: "upload.php",
                    method: "POST",
                    data: { name: name },
                    success: function (data) {
                        list_image();
                    }
                })
            });

        });
    </script>
</body>




</html>