<?php

$id = temizle($_GET['id']);

$query = $ozy->prepare("UPDATE kategoriler SET hit = (hit+1) WHERE seo=?");

$update = $query->execute(array($id));

?>

<?php
$id = temizle($_GET['id']);
$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM kategoriler WHERE seo=:id and durum=:durum");
$sayfaqq->execute([':id' => $id, ':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

// Kategori bulunamazsa 404'e yönlendir
if (!$page || empty($page['id'])) {
	header("Location: " . $url . "/404");
	exit;
}

$katid = $page['id'];

// Alt kategorileri de dahil et - tüm alt kategorilerin ID'lerini topla
$altkategoriler = array($katid); // Ana kategoriyi de dahil et
$altkat_sorgu = $ozy->prepare("SELECT id FROM kategoriler WHERE durum='1' AND ustkat = ?");
$altkat_sorgu->execute(array($katid));
$altkatlar = $altkat_sorgu->fetchAll(PDO::FETCH_ASSOC);
foreach ($altkatlar as $altkat) {
	$altkategoriler[] = $altkat['id'];
	// Alt-alt kategorileri de kontrol et (2 seviye derinlik)
	$altkat2_sorgu = $ozy->prepare("SELECT id FROM kategoriler WHERE durum='1' AND ustkat = ?");
	$altkat2_sorgu->execute(array($altkat['id']));
	$altkatlar2 = $altkat2_sorgu->fetchAll(PDO::FETCH_ASSOC);
	foreach ($altkatlar2 as $altkat2) {
		$altkategoriler[] = $altkat2['id'];
	}
}

// Kategori ID listesi oluştur (benzersiz hale getir)
$altkategoriler = array_unique($altkategoriler);
$kategori_listesi = implode(',', $altkategoriler);

// Kategori kontrolü için farklı formatları kontrol et - tüm sorgularda kullanılacak
// Hem ana kategori hem de alt kategorilerdeki ürünleri getir
// Her kategori ID için farklı formatları kontrol et
$kategori_kosullari = array();
foreach ($altkategoriler as $kat_id) {
	$kat_id = intval($kat_id); // SQL injection koruması
	$kategori_kosullari[] = "(FIND_IN_SET($kat_id,kategori) > 0 OR kategori = '$kat_id' OR kategori LIKE '$kat_id,%' OR kategori LIKE '%,$kat_id,%' OR kategori LIKE '%,$kat_id')";
}
$kategori_kosulu = "(" . implode(" OR ", $kategori_kosullari) . ")";


$maxfiyat = 0;
$maxfiyatz = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and $kategori_kosulu order by simdikifiyat DESC")->fetchAll(PDO::FETCH_ASSOC);
foreach ($maxfiyatz as $max) {
	$maxfiyat = floatval($max['simdikifiyat']) > $maxfiyat ? $max['simdikifiyat'] : $maxfiyat;
}
$maxfiyat = ceil(intval($maxfiyat * 2));
$minfiyat = 0;
$minfiyatz = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and $kategori_kosulu order by simdikifiyat ASC")->fetchAll(PDO::FETCH_ASSOC);
foreach ($minfiyatz as $min) {
	$minfiyat = floatval($min['simdikifiyat']) < $minfiyat ? $min['simdikifiyat'] : $minfiyat;
}
?>

<?php if ($page['seodurum'] == '1') { ?>

	<title><?php echo $page['stitle']; ?></title>

	<meta name="keywords" content="<?php echo $page['skey']; ?>">

	<meta name="description" content="<?php echo $page['sdesc']; ?>">

	<meta property="og:url" content="<?php echo $url; ?>" />

	<meta property="og:title" content="<?php echo $ayar['stitle']; ?>" />

	<meta property="og:description" content="<?php echo $page['sdesc']; ?>" />

<?php } else { ?>

	<title><?php echo $page['adi']; ?></title>

	<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">

	<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">

	<meta property="og:url" content="<?php echo $url; ?>" />

	<meta property="og:title" content="<?php echo $page['adi']; ?>" />

	<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>" />

<?php } ?>
<?php
// Markaları toplamak için sorgu - sayfalama olmadan (alt kategoriler dahil)
$markasorgu = $ozy->query("select * from urunler where durum='1' and $kategori_kosulu order by sira DESC")->fetchAll(PDO::FETCH_ASSOC);
$urunmarkalari = "";
foreach ($markasorgu as $katurunler) {
	$urunmarkalari .= "" . $katurunler['marka'] . ",";
}
// $pageoku değişkenini temizle - sayfalama sorgusunda tekrar tanımlanacak
$pageoku = array();
?>




<section class="cover pt-5 pb-5">
	<div class="container-lg">
		<h1><?php echo $page['adi']; ?></h1>
		<nav aria-label="breadcrumb" class="mt-3">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo $url; ?>/">Ana Sayfa</a></li>

				<?php if ($page['level'] == '2') { ?>
					<?php $ustkat1 = $page['ustkat'];
					$ustu = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat1'")->fetch(PDO::FETCH_ASSOC);
					$ustkat2 = $ustu['ustkat'];
					$ustu2 = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat2'")->fetch(PDO::FETCH_ASSOC); ?>
					<li class="breadcrumb-item"><a href="kategori/<?php echo $ustu2['seo']; ?>"><?php echo $ustu2['adi']; ?></a></li>
					<li class="breadcrumb-item"><a href="kategori/<?php echo $ustu['seo']; ?>"><?php echo $ustu['adi']; ?></a></li>
				<?php } ?>
				<?php if ($page['level'] == '1') { ?>
					<?php $ustkat1 = $page['ustkat'];
					$ustu = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat1'")->fetch(PDO::FETCH_ASSOC);
					$ustkat2 = $ustu['ustkat'];
					$ustu2 = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat2'")->fetch(PDO::FETCH_ASSOC); ?>
					<li class="breadcrumb-item"><a href="kategori/<?php echo $ustu['seo']; ?>"><?php echo $ustu['adi']; ?></a></li>
				<?php } ?>


				<li class="breadcrumb-item active" aria-current="page"><?php echo $page['adi']; ?></li>
			</ol>
		</nav>
	</div>
</section>



<section class="page category">
	<div class="container-lg">
		<div class="row">



			<div class="col-lg-2 mb-0 sbr">
				<div class="pt-4 pb-4">
					<form action="kategori/<?php echo $page['seo']; ?>" method="GET">

						<input type="hidden" name="siralama" value="<?php echo temizle($_GET['siralama']); ?>" />

						<input type="hidden" name="pages" value="<?php echo temizle($_GET['pages']); ?>" />

						<input type="hidden" name="fiyatfiltre" value="<?php echo temizle($_GET['fiyatfiltre']); ?>" />

						<?php

						if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {

							$markagelenveri = temizle($_GET["markalar"]);

							foreach ($markagelenveri as $markaverisi) { ?>

								<input type="hidden" name="markalar[]" value="<?php echo $markaverisi; ?>" />

						<?php  }
						} ?>
						<div class="kategori-box-durum">

							<div class="content-kategori" id="menucontentleft1open">

								<div class="div-block-4461292342" style="height:auto">
									<div data-w-id="7ca51662-fc7f-9641-58ff-a459ef548868" class="dropdown-trigger-kat w-clearfix" id="menucontentleft5">
										<a href="javascript:;" class="link-7">Fiyat Aralığı</a><img src="/images/down-arrow.png" loading="lazy" alt="" class="image-106" width="16">
									</div>
									<div class="content-kategori" id="menucontentleft5open">
										<div style="display: inline-flex; width: 100%;">

											<div class="w-col w-col-12">
												<div>



													<?php $bolumfiyat = intval($maxfiyat / 6);
													for ($i = 0; $i < 6; $i++) {
														$basfiyat = intval($minfiyat + $i * $bolumfiyat);
														$sonfiyat = intval($minfiyat + ($i + 1) * $bolumfiyat);
													?>

														<label>
															<input <?php echo $_GET['fiyatfiltre'] == $basfiyat . "-" . $sonfiyat ? 'checked' : null; ?> type="radio" name="fiyatfiltre" value="<?php echo $basfiyat . "-" . $sonfiyat; ?>" onchange='this.form.submit()'>
															<span><?php echo $basfiyat; ?> TL - <?php echo $sonfiyat; ?> TL</span>
														</label>

													<?php } ?>





												</div>
											</div>


										</div>
									</div>
								</div>
							</div>
						</div>



						<?php $filtre = $ozy->query("select * from filtre where $kategori_kosulu order by sira desc")->fetchAll(PDO::FETCH_ASSOC);

						foreach ($filtre as $filtregel) { ?>



							<div class="kategori-box-durum">
								<div data-w-id="ae143abe-97db-3644-3d02-5926c81887e0" class="dropdown-trigger-kat w-clearfix" id="menucontentleft3">
									<a href="#" class="link-7"><?php echo $filtregel['fadi']; ?></a>
								</div>
								<div class="content-kategori" id="menucontentleft3open">

									<div style="display: inline-flex; width: 100%;">

										<div class="w-col w-col-12">
											<?php




											$katoz = $filtregel['ozellik'];
											$katozel = explode(',', $katoz);
											$gelenfiltreleme = array(); // Varsayılan olarak boş array
											if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {
												$gelenfiltreleme = is_array($_GET['filtreleme']) ? $_GET['filtreleme'] : array($_GET['filtreleme']);
											}
											foreach ($katozel as $katozellik => $verimiz) {

											?>
												<p>
													<input <?php if (is_array($gelenfiltreleme) && in_array($verimiz, $gelenfiltreleme)) {
																echo "checked";
															}; ?> type="checkbox" name="filtreleme[]" value="<?php echo $verimiz; ?>" id="<?php echo $verimiz; ?>1" />
													<label for="<?php echo $verimiz; ?>1"><?php echo $verimiz; ?></label>
												</p>

											<?php } ?>
										</div>


									</div>


								</div>
							</div>



						<?php } ?>


						<div class="kategori-box-durum">
							<div data-w-id="ae143abe-97db-3644-3d02-5926c81887e0" class="dropdown-trigger-kat w-clearfix" id="menucontentleft3">
								<a style="" class="link-7">Markalar</a>
							</div>
							<div class="content-kategori" id="menucontentleft3open">

								<div style="display: inline-flex; width: 100%;">

									<div class="w-col w-col-12 markalar-listesi">
										<?php
										$gid = 0;
										$array = array($urunmarkalari);

										foreach ($array as $key => $value) {
											if ($key && $array[$key - 1] != $value) {
												$gid++;
											}
											$array2[$gid][] = $value;
										}

										$markalarimiz = "";
										$kelimeler = explode(",", $value);
										foreach ($kelimeler as $markamid) {
											if ($markamid == '') {
												$newid = "0";
											} else {
												$newid = $markamid;
											}

											$markalarimiz .= "" . $newid . ",";
										}
										$markalarimiz = mb_substr($markalarimiz, 0, -1);

										$mark = $ozy->query("select adi,id from markalar where durum='1' AND id IN ($markalarimiz) group by adi asc")->fetchAll(PDO::FETCH_ASSOC);

										$markafiltreleme = array(); // Varsayılan olarak boş array
										if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {
											$markafiltreleme = is_array($_GET['markalar']) ? $_GET['markalar'] : array($_GET['markalar']);
										}

										foreach ($mark as $marka) {

											$markaidmmmm = $marka['id'];
										?>

											<p>
												<input <?php if (is_array($markafiltreleme) && in_array($markaidmmmm, $markafiltreleme)) {
															echo "checked";
														}; ?> type="checkbox" name="markalar[]" value="<?php echo $marka['id']; ?>" id="Markalar-<?php echo $marka['id']; ?>" />
												<label for="Markalar-<?php echo $marka['id']; ?>"><?php echo $marka['adi']; ?></label>
											</p>

										<?php } ?>

									</div>


								</div>


							</div>
						</div>





						<div class="kategori-box-durum">
							<div data-w-id="ae143abe-97db-3644-3d02-5926c81887e0" class="dropdown-trigger-kat w-clearfix" id="menucontentleft3">
								<input style="height: 40px;
line-height: 0px;
text-align: center;" type="submit" value="Filtrele" class="gonderbuton">


								<a href="kategori/<?php echo $page['seo']; ?>" class="tagdelete"> Temizle</a>
							</div>

						</div>



						<style>
							/* Markalar bölümü için scroll ekleme */
							.markalar-listesi {
								max-height: 400px !important;
								overflow-y: auto !important;
								overflow-x: hidden !important;
								padding-right: 10px;
							}

							/* Custom scrollbar for markalar */
							.markalar-listesi::-webkit-scrollbar {
								width: 6px;
							}

							.markalar-listesi::-webkit-scrollbar-track {
								background: #f1f1f1;
								border-radius: 10px;
							}

							.markalar-listesi::-webkit-scrollbar-thumb {
								background: #888;
								border-radius: 10px;
							}

							.markalar-listesi::-webkit-scrollbar-thumb:hover {
								background: #555;
							}

							/* Firefox için scrollbar */
							.markalar-listesi {
								scrollbar-width: thin;
								scrollbar-color: #888 #f1f1f1;
							}

							/* Sayfalama (Pagination) düzenlemeleri */
							.pagination-wrapper {
								width: 100%;
								display: flex;
								justify-content: center;
								align-items: center;
								padding: 20px 0;
							}

							.pagination-wrapper .pagination {
								margin: 0;
								flex-wrap: nowrap !important;
								justify-content: center;
								gap: 5px;
								white-space: nowrap;
								max-width: 100%;
								overflow: hidden;
							}

							.pagination-wrapper .pagination .page-item {
								margin: 0 2px;
								display: inline-block;
							}

							.pagination-wrapper .pagination .page-link {
								min-width: 40px;
								height: 40px;
								display: flex;
								align-items: center;
								justify-content: center;
								padding: 0;
								border-radius: 50% !important;
								border: 1px solid #ddd;
								color: #666;
								text-decoration: none;
								transition: all 0.3s ease;
							}

							.pagination-wrapper .pagination .page-link:hover {
								background-color: #f0f0f0;
								border-color: #999;
								color: #333;
							}

							.pagination-wrapper .pagination .page-link.active {
								background-color: #007bff !important;
								border-color: #007bff !important;
								color: #fff !important;
								font-weight: 600;
							}

							@media (max-width: 768px) {
								.pagination-wrapper {
									padding: 15px 10px;
								}

								.pagination-wrapper .pagination .page-item {
									margin: 2px;
								}

								.pagination-wrapper .pagination .page-link {
									min-width: 35px;
									height: 35px;
									font-size: 14px;
								}
							}

							label {
								display: inline-block;
								font-size: 15px !important;
								margin-top: 10px !important;
								font-weight: 500 !important;
								border-radius: 14px;
								padding: 5px 5px 0px 0px;
								text-align: left;
								color: #8d94a6;
								transition: all 0.3s;
							}
						</style>




					</form>
				</div>
			</div>



			<div class="col-lg-10 mb-0">
				<div class="pt-4 pb-4">
					<div class="d-flex align-items-center justify-content-between filterbottom pb-4 mb-4">
						<div class="scrolllr">
							<div class="">
								<strong style="color: #ff0000;font-weight: 500;"><?php echo $page['adi']; ?></strong> kategorisinde toplam <strong style="font-weight: 500;color: #ff0000"> <?php $katsorgu = $ozy->query("SELECT COUNT(*) FROM urunler where durum='1' and $kategori_kosulu");


																																															$katsay = $katsorgu->fetchColumn();

																																															echo '' . $katsay . ''; ?> </strong> adet ürün bulundu..
							</div>
						</div>
						<div class="r">
							<form action="kategori/<?php echo $page['seo']; ?>" method="GET">
								<?php
								if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {
									$fitregelenveri = temizle($_GET["filtreleme"]);
									foreach ($fitregelenveri as $filtreverisi) { ?>
										<input type="hidden" name="filtreleme[]" value="<?php echo $filtreverisi; ?>" />
								<?php  }
								} ?>

								<?php
								if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {
									$markagelenveri = temizle($_GET["markalar"]);
									foreach ($markagelenveri as $markaverisi) { ?>
										<input type="hidden" name="markalar[]" value="<?php echo $markaverisi; ?>" />
								<?php  }
								} ?>
								<input type="hidden" name="pages" value="<?php echo temizle($_GET['pages']); ?>" />
								<input type="hidden" name="fiyatfiltre" value="<?php echo temizle($_GET['fiyatfiltre']); ?>" />

								<select name="siralama" class="form-select selectorder" onchange='this.form.submit()'>
									<option selected <?php echo $_GET['siralama'] == 'onerilen' ? 'selected="selected"' : null; ?> value="onerilen">Akıllı Sıralama</option>

									<option <?php echo $_GET['siralama'] == 'dusukfiyat' ? 'selected="selected"' : null; ?> value="dusukfiyat">Önce En Düşük Fiyat</option>

									<option <?php echo $_GET['siralama'] == 'yuksekfiyat' ? 'selected="selected"' : null; ?> value="yuksekfiyat">Önce En Yüksek Fiyat</option>

									<option <?php echo $_GET['siralama'] == 'encokyorum' ? 'selected="selected"' : null; ?> value="encokyorum">En Çok Yorum Alan</option>

									<option <?php echo $_GET['siralama'] == 'enbegenilen' ? 'selected="selected"' : null; ?> value="enbegenilen">En Çok Beğenilen</option>

									<option <?php echo $_GET['siralama'] == 'eskitarih' ? 'selected="selected"' : null; ?> value="eskitarih">En Eski Tarihe Göre</option>

									<option <?php echo $_GET['siralama'] == 'yenitarih' ? 'selected="selected"' : null; ?> value="yenitarih">En Yeni Tariha Göre</option>

								</select>
							</form>

						</div>
					</div>

					<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 productlist">


						<?php



						$pages = intval(@$_GET['pages']);

						if (!$pages) {

							$pages = 1;
						}
						// SQL injection koruması için prepared statement kullan - farklı kategori formatlarını kontrol et (alt kategoriler dahil)
						$bak = $ozy->query("select * from urunler where durum='1' and $kategori_kosulu");
						$toplam = $bak->rowCount();

						$limit = 36;

						$goster = $pages * $limit - $limit;

						$sayfasayisi = ceil($toplam / $limit);

						// Dinamik sayfalama: Aktif sayfa ortada, görünen alan kadar sayfa göster
						$max_visible_pages = 7; // Maksimum görünecek sayfa sayısı (tek sayı olmalı)
						$half_range = floor($max_visible_pages / 2); // Aktif sayfanın her iki yanında kaç sayfa gösterilecek

						// Başlangıç ve bitiş sayfasını hesapla
						$start_page = max(1, $pages - $half_range);
						$end_page = min($sayfasayisi, $pages + $half_range);

						// Eğer başta veya sondayız, diğer tarafa kaydır
						if ($start_page == 1) {
							$end_page = min($sayfasayisi, $max_visible_pages);
						}
						if ($end_page == $sayfasayisi) {
							$start_page = max(1, $sayfasayisi - $max_visible_pages + 1);
						}

						// $kategori_kosulu zaten yukarıda tanımlandı, tekrar tanımlamaya gerek yok

						$where = " ";

						$marka = " ";
						$markammmmm = ""; // Marka filtresi için değişken

						$wherex = " ";



						if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {

							$fitregelenveri = temizle($_GET["filtreleme"]);
							foreach ($fitregelenveri as $filtreverisi) {
								$where .= " and FIND_IN_SET('" . $filtreverisi . "', filtre)";
							}
						}



						if (isset($_GET["fiyatfiltre"]) && $_GET["fiyatfiltre"] != "") {
							if (isset($_GET["ilkfiyat"]) && $_GET["ilkfiyat"] != "" && isset($_GET["sonfiyat"]) && $_GET["sonfiyat"] != "") {

								if ($_GET['ilkfiyat'] == '') {
									echo $fiyatexp1 = "0";
								} else {
									$fiyatexp1 = $_GET['ilkfiyat'];
									echo $fiyatexp1 = str_replace('TL', '', $fiyatexp1);
								}


								if ($_GET['sonfiyat'] == '') {
									echo $fiyatexp2 = $maxfiyat;
								} else {
									$fiyatexp2 = $_GET['sonfiyat'];
									echo $fiyatexp2 = str_replace('TL', '', $fiyatexp2);
								}
								$wherex = " and if(idurum=1,ifiyat,fiyat)>=" . intval($fiyatexp1) . " and if(idurum=1,ifiyat,fiyat)<=" . intval($fiyatexp2);
							} else {


								$gelenfiyat = temizle($_GET["fiyatfiltre"]);

								$fiyatexp = explode("-", $gelenfiyat);

								$wherex = " and if(idurum=1,ifiyat,fiyat)>=" . intval($fiyatexp[0]) . " and if(idurum=1,ifiyat,fiyat)<=" . intval($fiyatexp[1]);
							}
						}

						if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {

							$markagelenveri = temizle($_GET["markalar"]);

							foreach ($markagelenveri as $markaverisi) {


								if ($markaverisi == '') {
									$newid = "0";
								} else {
									$newid = $markaverisi;
								}

								$markammmmm .= "" . $newid . ",";
							}
							$markammmmm = mb_substr($markammmmm, 0, -1);


							$marka = " AND marka IN (" . $markammmmm . ") ";
						}


						if (isset($_GET["siralama"]) && $_GET["siralama"] != "") {



							if (temizle($_GET["siralama"] == 'dusukfiyat')) {

								$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat) AS simdikifiyat from urunler where durum='1' and $kategori_kosulu " . $where . " " . $wherex . " " . $marka . " order by simdikifiyat ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
							} elseif (temizle($_GET["siralama"] == 'yuksekfiyat')) {

								$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat) AS simdikifiyat from urunler where durum='1' and $kategori_kosulu " . $where . " " . $wherex . " " . $marka . " order by simdikifiyat DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
							} elseif (temizle($_GET["siralama"] == 'encokyorum')) {

								$pageoku = $ozy->query("select * from urunler where durum='1' and $kategori_kosulu " . $where . " " . $wherex . " " . $marka . " order by yorum DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
							} elseif (temizle($_GET["siralama"] == 'enbegenilen')) {



								$pageoku = $ozy->query("select * from urunler where durum='1' and $kategori_kosulu " . $where . " " . $wherex . " " . $marka . " order by hit DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
							} elseif (temizle($_GET["siralama"] == 'eskitarih')) {



								$pageoku = $ozy->query("select * from urunler where durum='1' and $kategori_kosulu " . $where . " " . $wherex . " " . $marka . " order by tarih DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
							} elseif (temizle($_GET["siralama"] == 'yenitarih')) {



								$pageoku = $ozy->query("select * from urunler where durum='1' and $kategori_kosulu " . $where . " " . $wherex . " " . $marka . " order by tarih ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
							} elseif (temizle($_GET["siralama"] == 'onerilen')) {



								$pageoku = $ozy->query("select * from urunler where durum='1' and $kategori_kosulu " . $where . " " . $wherex . " " . $marka . " order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
							}
						} else {
							// Kategori kontrolü için farklı formatları kontrol et
							$kategori_kosulu = "($kategori_kosulu > 0 OR kategori = '$katid' OR kategori LIKE '$katid,%' OR kategori LIKE '%,$katid,%' OR kategori LIKE '%,$katid')";
							$pageoku = $ozy->query("select * from urunler where durum='1' and $kategori_kosulu " . $where . " " . $wherex . " " . $marka . " order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
						}




						$urunmarkalari .= "";

						$__URUN__ = false;

						foreach ($pageoku as $katurunler) {

							$urunmarkalari .= "" . $katurunler['marka'] . ",";

							$__URUN__ = true;



						?>



							<div class="col">
								<div class="item">
									<div class="img">
										<span class="d-flex bdgs">
											<?php if ($katurunler['ucretsizkargo'] == '1') { ?>
												<span class="bdg green">Ücretsiz Kargo!</span>
											<?php } ?>
											<?php if ($katurunler['idurum'] == '1') { ?>
												<span class="bdg orange">%<?php echo yuzdeHesaplama($katurunler['fiyat'], $katurunler['ifiyat']); ?> İndirimli</span>
											<?php } ?>
										</span>
										<a href="urun/<?php echo $katurunler['seo']; ?>">
											<img src="resimler/urunler/<?php echo $katurunler['resim']; ?>" width="238" height="175" class="img-fluid" alt="">
										</a>
									</div>
									<a href="urun/<?php echo $katurunler['seo']; ?>" class="title">
										<h3><?php echo $katurunler['adi']; ?></h3>
									</a>
									<div class="pb">
										<?php echo xurunfiyatbelirle($katurunler['kdv'], $katurunler['idurum'], $katurunler['fiyat'], $katurunler['ifiyat']); ?>
										<a href="urun/<?php echo $katurunler['seo']; ?>" class="addcart">SEPETE EKLE</a>
									</div>
								</div>
							</div>




						<?php }



						if (!$__URUN__) { ?>



							<div class="notfound_container text-center" style="padding: 40px;font-weight: 500;">


								<div class="notfound_content">
									<div class="title fs-5">Aradığın özellikte ürüne maalesef ulaşılmıyor.</div>
									<div class="text fs-5 fw-bold mt-1"><a href="kategori/<?php echo $page['seo']; ?>">Tekrar denemek ister misin ?</a></div>
								</div>
							</div>








						<?php }

						?>













					</div>

					<div class="pagination-wrapper text-center mt-4">
						<nav class="pagination" aria-label="Page navigation example">
							<ul class="pagination justify-content-center" style="flex-wrap: nowrap !important;">




								<?php
								// İlk sayfa için link
								if ($start_page > 1) {
									$eklenecekstr_ilk = "";
									foreach ($_GET as $key => $value) {
										if ($key != "pages" and $key != "oziywebs" and $key != "id") {
											if (is_array($value)) {
												foreach ($value as $array_value) {
													$eklenecekstr_ilk .= "&" . $key . "[]=" . urlencode($array_value);
												}
											} else {
												$eklenecekstr_ilk .= "&" . $key . "=" . urlencode($value);
											}
										}
									}
									echo "<li class='page-item'><a class='page-link' href='kategori/" . $page['seo'] . "?pages=1" . $eklenecekstr_ilk . "'>1</a></li>";
									if ($start_page > 2) {
										echo "<li class='page-item'><span class='page-link'>...</span></li>";
									}
								}

								// Sayfa numaralarını göster
								for ($i = $start_page; $i <= $end_page; $i++) {



									if ($i == $pages) {



										echo " <li class='page-item'><a class='page-link active'>" . $i . "</a></li>";
									} else {



										$eklenecekstr = "";

										foreach ($_GET as $key => $value) {

											if ($key != "pages" and $key != "oziywebs" and $key != "id") {
												// Array değerleri için özel işleme
												if (is_array($value)) {
													foreach ($value as $array_value) {
														$eklenecekstr .= "&" . $key . "[]=" . urlencode($array_value);
													}
												} else {
													$eklenecekstr .= "&" . $key . "=" . urlencode($value);
												}
											}
										}



										echo "<li class='page-item'><a class='page-link' href='kategori/" . $page['seo'] . "?pages=" . $i . $eklenecekstr . "'>" . $i . "</a></li>";
									}
								}

								// Son sayfa için link
								if ($end_page < $sayfasayisi) {
									if ($end_page < $sayfasayisi - 1) {
										echo "<li class='page-item'><span class='page-link'>...</span></li>";
									}
									$eklenecekstr_son = "";
									foreach ($_GET as $key => $value) {
										if ($key != "pages" and $key != "oziywebs" and $key != "id") {
											if (is_array($value)) {
												foreach ($value as $array_value) {
													$eklenecekstr_son .= "&" . $key . "[]=" . urlencode($array_value);
												}
											} else {
												$eklenecekstr_son .= "&" . $key . "=" . urlencode($value);
											}
										}
									}
									echo "<li class='page-item'><a class='page-link' href='kategori/" . $page['seo'] . "?pages=" . $sayfasayisi . $eklenecekstr_son . "'>" . $sayfasayisi . "</a></li>";
								}
								?>
							</ul>
						</nav>
					</div>













					</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>