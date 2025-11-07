<?php
paket_kontrol(["extreme", "enterprise"]); 
admin_yetki($ozy, $_SESSION['departmanid'], 2); 
if (isset($_GET['temizle'])) {

    $id = temizle($_GET['temizle']);
    // $sayfasil = $ozy->prepare("delete from siparis where id='$id'");
// $sayfasil->execute(array($id));

    if ($sayfasil) {

        // echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';

    }


}

?>

<?php

// kafayı toplarlayınca veritabanı eklemesi yapılacak......





?>


<!-- Bootstrap Select -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Select JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<div class="wrapper">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h4 class="page-title">Sipariş Oluştur</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Sipariş Oluştur</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header bg-white text-black text-center font-weight-bold">
                        Üye Bilgileri
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive mb-0"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Kullanıcı</th>
                                    <th>Ödeme Tipi</th>
                                    <th>Sipariş Durumu</th>
                                    <th>Sipariş Tarihi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select id="kullanici" name="kullanici" class="form-control"
                                            style="overflow-y: auto;">
                                            <option value="NaN">Seçiniz</option>
                                            <?php
                                            $kul = $ozy->query("SELECT * FROM users ORDER BY id");
                                            while ($kull = $kul->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?= $kull['id'] ?>"><?= $kull['isim'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="odemetipi" name="odemetipi" class="form-control"
                                            style="overflow-y: auto;">
                                            <option value="0">Seçiniz</option>
                                            <option value="1">Havale/EFT</option>
                                            <option value="2">Kapıda Ödeme</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="siparisdurumu" name="siparisdurumu" class="form-control"
                                            style="overflow-y: auto;">
                                            <option value="0">Seçiniz</option>
                                            <option value="1">Ödeme Bekliyor</option>
                                            <option value="2">Sipariş Onaylandı</option>
                                            <option value="3">Sipariş Hazırlandı</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="date" id="tarih" name="tarih" class="form-control"
                                            placeholder="Tarih seçiniz">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header bg-white text-black text-center font-weight-bold">
                        Ürün Detayları
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive mb-0"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Ürün Adı</th>
                                    <th>Ürün Barkodu</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Sipariş Miktarı</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select id="urunadi" class="form-select selectpicker w-100"
                                            data-live-search="true" data-size="10" title="Ürün seçiniz">
                                            <?php
                                            $urunler = $ozy->query("SELECT * FROM urunler ORDER BY id");
                                            while ($urun = $urunler->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?= $urun['id'] ?>"><?= htmlspecialchars($urun['adi']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                    </td>
                                    <td id="urunbarkodu"></td>
                                    <td id="kategori"></td>
                                    <td id="stok"></td>
                                    <td class="w-25">
                                        <input type="number" id="siparismiktari" name="siparismiktari"
                                            class="form-control" placeholder="Sipariş Miktarı" min="0" max="1000000"
                                            value="0" step="1">

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <br>
                        <table class="table table-bordered dt-responsive mb-0"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Ürün Kapak Fotoğrafı</th>
                                    <th>Satış Fiyatı</th>
                                    <th>İndirim %</th>
                                    <th>İndirimli Fiyat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img id="urunresim" style="display: none; margin-right: 10px;" width="250"
                                            height="250">
                                    </td>
                                    <td>
                                        <div id="satisfiyati"></div>
                                        <br>
                                        <div id="satisfiyatitoplam" style="font-weight: bold; font-style: italic;">
                                        </div>
                                    </td>
                                    <td class="w-25">
                                        <input type="number" id="indirim" name="indirim" class="form-control"
                                            placeholder="İndirim" maxlength="3" min="0" max="100" step="1" value="0"
                                            oninput="this.value = Math.min(Math.max(this.value, 0), 100);">
                                    </td>
                                    <td>
                                        <div id="indirimlifiyat"></div>
                                        <br>
                                        <div id="indirimlifiyattoplam" style="font-weight: bold; font-style: italic;">
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary" id="listeyeekle">Listeye Ekle</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <br>
                        <br>
                        <br>

                        <div class="card-header bg-white text-black text-center font-weight-bold">
                            Sipariş Listesi
                        </div>

                        <table id="siparisdetay" class="table table-bordered dt-responsive mb-0"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Ürün Adı</th>
                                    <th>Ürün Barkodu</th>
                                    <th>Kategori</th>
                                    <th>Sipariş Miktarı</th>
                                    <th>Satış Fiyatı</th>
                                    <th>İndirimli Fiyat</th>
                                </tr>
                            </thead>
                            <tbody id="siparisdetay-body">

                            </tbody>
                        </table>

                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" id="siparisdetay-onayla">Siparişi Onayla</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>




    </div>
</div>

<div class="modal fade" id="siparisdetay-onayla-modal" tabindex="-1" aria-labelledby="siparisdetay-onayla-modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="siparisdetay-onayla-modal-label">Sipariş Oluştur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sipariş onaylamak istediğinize emin misiniz?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" id="siparisdetay-onayla-button"
                    name="siparisdetay-onayla-button" type="submit">Siparişi Onayla</button>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tarih').value = today;
    });

</script>

<script>
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = parseFloat(number).toFixed(decimals);
        var parts = number.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
        return parts.join(dec_point);
    }

    var parabirim = '₺';

    $(document).ready(function () {
        $('.selectpicker').selectpicker();

        // Ürün seçildiğinde detayları çek
        $('#urunadi').on('changed.bs.select', function () {
            var urunID = $(this).val();

            $('#siparismiktari').val('0');
            $('#urunresim').show();
            $('#kategori, #stok, #satisfiyati, #satisfiyatitoplam, #indirimlifiyat, #indirimlifiyattoplam').text('');
            $('#indirim').val('0');

            if (urunID) {
                $.ajax({
                    url: 'pages/ajax_urundetay.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: urunID },
                    success: function (data) {
                        $('#kategori').text(data.kategori);
                        $('#stok').text(data.stok);
                        $('#urunresim').attr('src', '../../../resimler/urunler/' + data.resim);
                        $('#satisfiyati').text(data.satisfiyati);
                        parabirim = data.parabirim;
                    },
                    error: function () {
                        $('#kategori, #stok, #satisfiyati, #satisfiyatitoplam, #indirimlifiyat, #indirimlifiyattoplam').text('');
                        $('#indirim').val('0');
                        $('#urunresim').hide();
                    }
                });
            } else {
                $('#kategori, #stok, #satisfiyati, #satisfiyatitoplam, #indirimlifiyat, #indirimlifiyattoplam').text('');
                $('#indirim').val('0');
                $('#urunresim').hide();
            }
        });

        // Miktar girilince hesapla
        $('#siparismiktari').on('input', function () {
            var siparismiktari = parseInt($(this).val());
            var stok = parseInt($('#stok').text());
            var satisfiyati = parseFloat($('#satisfiyati').text().replace(',', '.'));
            var indirim = parseFloat($('#indirim').val().replace(',', '.'));

            if (siparismiktari > stok) {
                $('#siparismiktari').val(stok);
                $('#siparismiktari').css('border-color', 'red');
            } else {
                $('#siparismiktari').css('border-color', 'green');
            }

            var siparismiktari = parseInt($(this).val());
            var toplam = satisfiyati * siparismiktari;
            var toplamFormatted = number_format(toplam, 2, ',', '.') + ' ' + parabirim;
            $('#satisfiyatitoplam').text(toplamFormatted);

            var indirimlifiyat = satisfiyati - (satisfiyati * indirim / 100);
            var indirimlifiyatFormatted = number_format(indirimlifiyat, 2, ',', '.') + ' ' + parabirim;
            $('#indirimlifiyat').text(indirimlifiyatFormatted);

            var indirimlifiyattoplam = indirimlifiyat * siparismiktari;
            var indirimlitoplamFormatted = number_format(indirimlifiyattoplam, 2, ',', '.') + ' ' + parabirim;
            $('#indirimlifiyattoplam').text(indirimlitoplamFormatted);
        });

        // İndirim değişince tekrar hesapla
        $('#indirim').on('input', function () {
            var indirim = parseFloat($(this).val().replace(',', '.'));
            var siparismiktari = parseInt($('#siparismiktari').val());
            var satisfiyati = parseFloat($('#satisfiyati').text().replace(',', '.'));

            if (isNaN(indirim) || isNaN(siparismiktari) || isNaN(satisfiyati)) return;

            var indirimlifiyat = satisfiyati - (satisfiyati * indirim / 100);
            $('#indirimlifiyat').text(number_format(indirimlifiyat, 2, ',', '.') + ' ' + parabirim);

            var toplam = indirimlifiyat * siparismiktari;
            $('#indirimlifiyattoplam').text(number_format(toplam, 2, ',', '.') + ' ' + parabirim);
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#listeyeekle').click(function () {
            var urunadiID = $('#urunadi').val();
            var urunadiText = $('#urunadi option:selected').text();
            var kategori = $('#kategori').text();
            var urunbarkodu = $('#urunbarkodu').text();
            var siparismiktari = $('#siparismiktari').val();
            var satisfiyati = $('#satisfiyati').text();
            var satisfiyatitoplam = $('#satisfiyatitoplam').text();
            var indirimlifiyat = $('#indirimlifiyat').text();
            var indirimlifiyattoplam = $('#indirimlifiyattoplam').text();

            if (!urunadiID || !siparismiktari || parseInt(siparismiktari) <= 0) {
                alert("Lütfen ürün seçiniz");
                return;
            }

            $('#siparisdetay-body').append(`
            <tr>
                
                <td>${urunadiText}</td>
                <td>${urunbarkodu}</td>
                <td>${kategori}</td>
                <td>${siparismiktari}</td>
                <td>
                    <div>${satisfiyati}
                    </div>
                    <br>
                    <div style="font-weight: bold; font-style: italic;">${satisfiyatitoplam}
                    </div>
                </td>
                <td>
                    <div>${indirimlifiyat}
                    </div>
                    <br>
                    <div style="font-weight: bold; font-style: italic;">${indirimlifiyattoplam}
                    </div>
                </td>
            </tr>
        `);

            $('#urunbarkodu').text('');
            $('#kategori').text('');
            $('#stok').text('');
            $('#siparismiktari').val('0');
            $('#satisfiyati').text('');
            $('#satisfiyatitoplam').text('');
            $('#indirim').val('0');
            $('#indirimlifiyat').text('');
            $('#indirimlifiyattoplam').text('');
            $('#urunresim').hide();
        });
    });



</script>

<script>
    $(document).ready(function () {
        $('#siparisdetay-onayla').click(function () {
            $('#siparisdetay-onayla-modal').modal('show');
        });
    });
</script>