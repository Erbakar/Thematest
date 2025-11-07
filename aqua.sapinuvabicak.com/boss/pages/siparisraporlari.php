<?php
admin_yetki($ozy, $_SESSION['departmanid'], 53);

?>


<div class="wrapper">
	<div class="container-fluid">
		<!-- Page-Title -->
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<h4 class="page-title">Finans Raporları</h4>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-right">
						<li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

						<li class="breadcrumb-item active">Sipariş Raporları</li>
					</ol>
				</div>
			</div>
			<!-- end row -->
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card m-b-30">
					<div class="card-body">
						<table id="datatable" data-order='[[ 0, "asc" ]]'
							class="table table-bordered dt-responsive nowrap"
							style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
							<h4 class="mt-0 header-title mb-4">Tamamlanan Siparişler</h4>
							<thead>
								<tr>
									<th>Tarih</th>
									<th>Müşteri</th>
									<th>Ürün Sayısı</th>
									<th>Sepet Tutarı</th>
									<th>Toplam Sipariş Sayısı</th>
									<th>Sepet Toplam Ürün Sayısı</th>
									<th>Sipariş Toplam Tutar</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$siparis = $ozy->prepare("SELECT * FROM siparis WHERE durum='Sipariş Tamamlandı' ORDER BY id DESC");
								$siparis->execute();
								$siparis = $siparis->fetchAll(PDO::FETCH_ASSOC);


								foreach ($siparis as $siparisler) {
									$musteri = $ozy->prepare("SELECT * FROM users WHERE id=:id");
									$musteri->execute(array('id' => $siparisler['uye']));
									$musteri = $musteri->fetch(PDO::FETCH_ASSOC);

									$urun = $ozy->prepare("SELECT * FROM siparis WHERE uye=:uye");
									$urun->execute(array('uye' => $siparisler['uye']));
									$urun = $urun->fetchAll(PDO::FETCH_ASSOC);
									$siparis_toplam_tutar = 0;
									$siparis_sayisi = 0;
									foreach ($urun as $urunler) {
										if ($urunler['durum'] == "Sipariş Tamamlandı") {
											$siparis_toplam_tutar += $urunler['toplamtutar'];
											$siparis_sayisi++;
										}
									}

									$siparis_tutari = str_replace(".", ",", $siparisler['toplamtutar']);
									$siparis_tutari = number_format($siparis_tutari, 2, ",", ".") . " TL";

									$siparis_toplam_tutar = number_format($siparis_toplam_tutar, 2, ",", ".") . " TL";
									$siparis_sayisi = number_format($siparis_sayisi, 0, ",", ".");

									?>

									<tr>
										<td><?php echo $siparisler['tarih']; ?></td>
										<td><?php echo $siparisler['adsoyad']; ?></td>
										<td>** Veritabanında Yok **</td>
										<td><?php echo $siparis_tutari; ?></td>
										<td><?php echo $siparis_sayisi; ?></td>
										<td>** Veritabanında Yok **</td>
										<td><?php echo $siparis_toplam_tutar; ?></td>
									</tr>
								<?php } ?>

							</tbody>



						</table>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->

		<div class="row">
			<div class="col-12">
				<div class="card m-b-30">
					<div class="card-body">
						<table id="datatable" data-order='[[ 0, "asc" ]]'
							class="table table-bordered dt-responsive nowrap"
							style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
							<h4 class="mt-0 header-title mb-4">Yıllık Sipariş Raporu</h4>
							<thead>
								<tr>
									<th>Yıl</th>
									<th>Sipariş Sayısı</th>
									<th>Kargo Ücreti</th>
									<th>İndirim Tutarı</th>
									<th>Kupon Tutarı</th>
									<th>Ciro</th>
									<th>Maliyet</th>
									<th>Brüt Kar</th>
								</tr>
							</thead>
							<tbody>


								<?php

								$yil_sorgu = $ozy->prepare("SELECT SUBSTRING(tarih, 7, 4) as tarih FROM siparis WHERE durum='Sipariş Tamamlandı' GROUP BY SUBSTRING(tarih, 7, 4) ORDER BY tarih DESC");
								$yil_sorgu->execute();
								$yillar = $yil_sorgu->fetchAll(PDO::FETCH_ASSOC);

								foreach ($yillar as $yil) {
									$yil_adi = $yil['tarih'];

									$siparis_sayisi_sorgu = $ozy->prepare("SELECT COUNT(*) as toplam FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$siparis_sayisi_sorgu->execute(['yil' => $yil_adi]);
									$siparis_sayisi = $siparis_sayisi_sorgu->fetch(PDO::FETCH_ASSOC)['toplam'];

									$ciro_sorgu = $ozy->prepare("SELECT SUM(toplamtutar) as toplamtutar FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$ciro_sorgu->execute(['yil' => $yil_adi]);
									$ciro = $ciro_sorgu->fetch(PDO::FETCH_ASSOC)['toplamtutar'];

									$kargo_sorgu = $ozy->prepare("SELECT SUM(kargotutari) as toplam_kargo FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$kargo_sorgu->execute(['yil' => $yil_adi]);
									$kargo_ucreti = $kargo_sorgu->fetch(PDO::FETCH_ASSOC)['toplam_kargo'];

									$indirim_sorgu = $ozy->prepare("SELECT SUM(havaleindirimtutari) as toplam_indirim FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$indirim_sorgu->execute(['yil' => $yil_adi]);
									$indirim_tutari = $indirim_sorgu->fetch(PDO::FETCH_ASSOC)['toplam_indirim'];

									$kupon_sorgu = $ozy->prepare("SELECT SUM(kupontutari) as toplam_kupon FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$kupon_sorgu->execute(['yil' => $yil_adi]);
									$kupon_tutari = $kupon_sorgu->fetch(PDO::FETCH_ASSOC)['toplam_kupon'];

									$maliyet = $kargo_ucreti - $indirim_tutari - $kupon_tutari;
									$kar = $ciro - $maliyet;

									$siparis_sayisi_formatted = number_format($siparis_sayisi, 0, ",", ".");
									$ciro_formatted = number_format($ciro, 2, ",", ".") . " TL";
									$kargo_formatted = number_format($kargo_ucreti, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($kargo_ucreti / $ciro * 100, 2, ",", ".") . "%)</span>";
									$indirim_formatted = number_format($indirim_tutari, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($indirim_tutari / $ciro * 100, 2, ",", ".") . "%)</span>";
									$kupon_formatted = number_format($kupon_tutari, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($kupon_tutari / $ciro * 100, 2, ",", ".") . "%)</span>";
									$maliyet_formatted = number_format($maliyet, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($maliyet / $ciro * 100, 2, ",", ".") . "%)</span>";
									$kar_formatted = number_format($kar, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($kar / $ciro * 100, 2, ",", ".") . "%)</span>";
									?>

									<tr>
										<td class="font-weight-bold"><?php echo $yil_adi; ?></td>
										<td class="font-weight-bold"><?php echo $siparis_sayisi_formatted; ?></td>

										<?php if ($kargo_formatted == 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $kargo_formatted; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $kargo_formatted; ?></td>
										<?php } ?>

										<?php if ($indirim_formatted == 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $indirim_formatted; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $indirim_formatted; ?></td>
										<?php } ?>

										<?php if ($kupon_formatted == 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $kupon_formatted; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $kupon_formatted; ?></td>
										<?php } ?>

										<?php if ($ciro_formatted >= 0) { ?>
											<td class="text-primary font-weight-bold"><?php echo $ciro_formatted; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $ciro_formatted; ?></td>
										<?php } ?>

										<?php if ($maliyet_formatted >= 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $maliyet_formatted; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $maliyet_formatted; ?></td>
										<?php } ?>

										<?php if ($kar_formatted >= 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $kar_formatted; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $kar_formatted; ?></td>
										<?php } ?>
									</tr>

								<?php } ?>



							</tbody>



						</table>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!--

	</div>
	<!-- end container-fluid -->
	</div>
	<!-- end wrapper -->