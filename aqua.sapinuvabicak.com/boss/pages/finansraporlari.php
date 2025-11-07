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

						<li class="breadcrumb-item active">Finans Raporları</li>
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
							<h4 class="mt-0 header-title mb-4">Yıllık Finans Raporu</h4>
							<thead>
								<tr>
									<th>Yıl</th>
									<th>Site Maliyeti</th>
									<th>Reklam Maliyeti</th>
									<th>Satış Maliyeti</th>
									<th>Satış Brüt Kar</th>
									<th>Brüt Genel Kar</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$yil_sorgu = $ozy->prepare("SELECT SUBSTRING(tarih, 7, 4) as tarih FROM siparis WHERE durum='Sipariş Tamamlandı' GROUP BY SUBSTRING(tarih, 7, 4) ORDER BY tarih DESC");
								$yil_sorgu->execute();
								$yillar = $yil_sorgu->fetchAll(PDO::FETCH_ASSOC);



								foreach ($yillar as $yil) {
									$yil_adi = $yil['tarih'];

									$site_maliyet_sorgu = $ozy->prepare("SELECT SUM(tutar) as tutar FROM maliyetler WHERE adi='Site' AND SUBSTRING(tarih, 7, 4) = :yil");
									$site_maliyet_sorgu->execute(['yil' => $yil_adi]);
									$site_maliyet = $site_maliyet_sorgu->fetch(PDO::FETCH_ASSOC)['tutar'];

									$reklam_maliyet_sorgu = $ozy->prepare("SELECT SUM(tutar) as tutar FROM maliyetler WHERE adi='Reklam' AND SUBSTRING(tarih, 7, 4) = :yil");
									$reklam_maliyet_sorgu->execute(['yil' => $yil_adi]);
									$reklam_maliyet = $reklam_maliyet_sorgu->fetch(PDO::FETCH_ASSOC)['tutar'];

									$kargo_sorgu = $ozy->prepare("SELECT SUM(kargotutari) as toplam_kargo FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$kargo_sorgu->execute(['yil' => $yil_adi]);
									$kargo_ucreti = $kargo_sorgu->fetch(PDO::FETCH_ASSOC)['toplam_kargo'];

									$indirim_sorgu = $ozy->prepare("SELECT SUM(havaleindirimtutari) as toplam_indirim FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$indirim_sorgu->execute(['yil' => $yil_adi]);
									$indirim_tutari = $indirim_sorgu->fetch(PDO::FETCH_ASSOC)['toplam_indirim'];

									$kupon_sorgu = $ozy->prepare("SELECT SUM(kupontutari) as toplam_kupon FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$kupon_sorgu->execute(['yil' => $yil_adi]);
									$kupon_tutari = $kupon_sorgu->fetch(PDO::FETCH_ASSOC)['toplam_kupon'];

									$ciro_sorgu = $ozy->prepare("SELECT SUM(toplamtutar) as toplamtutar FROM siparis WHERE durum='Sipariş Tamamlandı' AND SUBSTRING(tarih, 7, 4) = :yil");
									$ciro_sorgu->execute(['yil' => $yil_adi]);
									$ciro = $ciro_sorgu->fetch(PDO::FETCH_ASSOC)['toplamtutar'];

									$maliyet = $kargo_ucreti + $indirim_tutari + $kupon_tutari;
									$kar = $ciro - $maliyet - $reklam_maliyet - $site_maliyet;

									$site_maliyet = number_format($site_maliyet, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($site_maliyet / $ciro * 100, 2, ",", ".") . "%)</span>";
									$reklam_maliyet = number_format($reklam_maliyet, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($reklam_maliyet / $ciro * 100, 2, ",", ".") . "%)</span>";
									$maliyet = number_format($maliyet, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($maliyet / $ciro * 100, 2, ",", ".") . "%)</span>";
									$ciro_brut = number_format($ciro, 2, ",", ".") . " TL";
									if ($kar < 0) {
										$kar = number_format($kar, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($kar / $ciro * 100, 2, ",", ".") . "%)</span>";

									} else if ($kar >= 0) {
										$kar = number_format($kar, 2, ",", ".") . " TL" . " <span class='font-weight-bold'>(" . number_format($kar / $ciro * 100, 2, ",", ".") . "%)</span>";
									}

									?>

									<tr>
										<td class="font-weight-bold"><?php echo $yil_adi; ?></td>
										<?php if ($site_maliyet == 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $site_maliyet; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $site_maliyet; ?></td>
										<?php } ?>

										<?php if ($reklam_maliyet == 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $reklam_maliyet; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $reklam_maliyet; ?></td>
										<?php } ?>

										<?php if ($maliyet == 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $maliyet; ?></td>
										<?php } else { ?>
											<td class="text-danger font-weight-bold"><?php echo $maliyet; ?></td>
										<?php } ?>

										<?php if ($ciro == 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $ciro_brut; ?></td>
										<?php } else { ?>
											<td class="text-primary font-weight-bold"><?php echo $ciro_brut; ?></td>
										<?php } ?>

										<?php if ($kar < 0) { ?>
											<td class="text-danger font-weight-bold"><?php echo $kar; ?></td>
										<?php } else if ($kar >= 0 && $kar != 0) { ?>
											<td class="text-success font-weight-bold"><?php echo $kar; ?></td>
										<?php } ?>
									</tr>

								<?php } ?>
							</tbody>



						</table>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->


	</div>
	<!-- end container-fluid -->
</div>
<!-- end wrapper -->