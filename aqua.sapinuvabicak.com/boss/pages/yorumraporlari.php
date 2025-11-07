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

						<li class="breadcrumb-item active">Yorum Raporları</li>
					</ol>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-12">
				<div class="card m-b-30">
					<div class="card-body">
						<table id="datatable" data-order='[[ 0, "asc" ]]'
							class="table table-bordered dt-responsive nowrap"
							style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
							<h4 class="mt-0 header-title mb-4">Onaylı Ürün Yorumları</h4>
							<thead>
								<tr>
									<th>Tarih</th>
									<th>Müşteri</th>
									<th>Ürün</th>
									<th>Yorum</th>
									<th>Puan</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$yorum = $ozy->prepare("SELECT * FROM tumyorumlar WHERE durum=1 ORDER BY id DESC");
								$yorum->execute();
								$yorum = $yorum->fetchAll(PDO::FETCH_ASSOC);


								foreach ($yorum as $yorumlar) {
									$urun = $ozy->prepare("SELECT * FROM urunler WHERE id=:id");
									$urun->execute(array('id' => $yorumlar['sayfaid']));
									$urun = $urun->fetch(PDO::FETCH_ASSOC);

									?>

									<tr>
										<td><?php echo $yorumlar['tarih']; ?></td>
										<td><?php echo $yorumlar['adi']; ?></td>
										<td onclick="alert('<?php echo addslashes(strip_tags($urun['adi'])); ?>')">
											<?php echo strip_tags(mb_substr($urun['adi'], 0, 15)); ?>... <a
												class="text-primary">Devamını Gör</a>
										</td>
										<td onclick="alert('<?php echo addslashes(strip_tags($yorumlar['yorum'])); ?>')">
											<?php echo strip_tags(mb_substr($yorumlar['yorum'], 0, 15)); ?>... <a
												class="text-primary">Devamını Gör</a>
										</td>
										<td>
											<?php
											if ($yorumlar['yildiz'] == 1) {
												echo "<i class='fa fa-star text-danger'></i>";
											} else if ($yorumlar['yildiz'] == 2) {
												echo "<i class='fa fa-star text-danger'></i> <i class='fa fa-star text-danger'></i>";
											} else if ($yorumlar['yildiz'] == 3) {
												echo "<i class='fa fa-star text-warning'></i> <i class='fa fa-star text-warning'></i> <i class='fa fa-star text-warning'></i>";
											} else if ($yorumlar['yildiz'] == 4) {
												echo "<i class='fa fa-star text-success	'></i> <i class='fa fa-star text-success'></i> <i class='fa fa-star text-success'></i> <i class='fa fa-star text-success'></i>";
											} else if ($yorumlar['yildiz'] == 5) {
												echo "<i class='fa fa-star text-success'></i> <i class='fa fa-star text-success'></i> <i class='fa fa-star text-success'></i> <i class='fa fa-star text-success'></i> <i class='fa fa-star text-success'></i>";
											}
											?>
										</td>
									</tr>
								<?php } ?>

							</tbody>



						</table>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card m-b-30">
					<div class="card-body">
						<h4 class="mt-0 header-title mb-4">Yorum Performansı</h4>
						<table id="datatable" class="table table-bordered dt-responsive nowrap"
							style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
							<thead>
								<tr>
									<th>Yorum Sayısı</th>
									<th>Yıldız Ortalaması</th>
									<th>Performans</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$yorum = $ozy->prepare("SELECT * FROM tumyorumlar WHERE durum=1 ORDER BY id DESC");
								$yorum->execute();
								$yorum = $yorum->fetchAll(PDO::FETCH_ASSOC);

								$yorum_sayisi = count($yorum);
								$yorum_yildiz_toplam = 0;
								foreach ($yorum as $yorumlar) {
									$yorum_yildiz_toplam += $yorumlar['yildiz'];
								}

								$yorum_yildiz_ortalama_raw = $yorum_yildiz_toplam / $yorum_sayisi;
								$yorum_yildiz_ortalama = number_format($yorum_yildiz_ortalama_raw, 1, ",", ".");

								$yorum_performans_raw = $yorum_yildiz_ortalama_raw / 5 * 100;
								$yorum_performans = number_format($yorum_performans_raw, 0, ",", ".");
								if ($yorum_performans > 80) {
									$yorum_performans = "<span class='text-success text-bold'>" . $yorum_performans . " %</span>";
								} else if ($yorum_performans > 60) {
									$yorum_performans = "<span class='text-warning text-bold'>" . $yorum_performans . " %</span>";
								} else {
									$yorum_performans = "<span class='text-danger text-bold'>" . $yorum_performans . " %</span>";
								}

								?>
								<tr>
									<td class="text-bold"><?php echo $yorum_sayisi; ?></td>
									<td>
										<?php
										$puan = (float) str_replace(",", ".", $yorum_yildiz_ortalama); // virgülü noktaya çevir
										$tamYildiz = floor($puan);
										$yariYildiz = ($puan - $tamYildiz) >= 0.25 && ($puan - $tamYildiz) < 0.75 ? 1 : 0;
										$tamYildiz += ($puan - $tamYildiz) >= 0.75 ? 1 : 0;
										$bosYildiz = 5 - $tamYildiz - $yariYildiz;

										if ($puan < 3) {
											$renk = "text-danger";
										} elseif ($puan < 4) {
											$renk = "text-warning";
										} else {
											$renk = "text-success";
										}

										for ($i = 0; $i < $tamYildiz; $i++) {
											echo "<i class='fa fa-star {$renk}'></i> ";
										}

										if ($yariYildiz) {
											echo "<i class='fa fa-star-half {$renk}'></i> ";
										}

										?>
									</td>
									<td class="text-bold"><?php echo $yorum_performans; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>



	</div>

</div>