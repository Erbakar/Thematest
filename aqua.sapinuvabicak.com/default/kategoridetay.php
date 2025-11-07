<?php
// Alt kategorileri recursive olarak bulan fonksiyon
function getAllChildCategories($ozy, $parent_id, &$all_cat_ids = array()) {
    $all_cat_ids[] = $parent_id; // Ana kategoriyi de dahil et
    $child_cats = $ozy->prepare("SELECT id FROM kategoriler WHERE durum='1' AND ustkat = ?");
    $child_cats->execute([$parent_id]);
    $children = $child_cats->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($children as $child_id) {
        getAllChildCategories($ozy, $child_id, $all_cat_ids); // Recursive çağrı
    }
    return $all_cat_ids;
}

$id = temizle($_GET['id']);
$query = $ozy->prepare("UPDATE kategoriler SET hit = (hit+1) WHERE seo=?");
$update = $query->execute(array($id));
?>
<?php
$id = temizle($_GET['id']);
$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM kategoriler WHERE seo=:id and durum=:durum");
$page = $sayfaqq->execute([':id' => $id, ':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);
$katid = $page['id'];
$maxfiyat = 0;
$katid = intval($katid); // Güvenli hale getir

// Tüm alt kategorileri dahil et (kendisi + tüm alt kategoriler)
$all_category_ids = getAllChildCategories($ozy, $katid);
$category_ids_string = implode(',', array_map('intval', $all_category_ids)); // Güvenlik için intval
$category_condition = "(" . implode(' OR ', array_map(function($id) { return "FIND_IN_SET($id, kategori)"; }, $all_category_ids)) . ")";
// Alt kategoriler dahil tüm ürünleri getir
$sql = "SELECT *, IF(idurum=1, ifiyat, fiyat) AS simdikifiyat 
        FROM urunler 
        WHERE durum = '1' AND $category_condition
        ORDER BY simdikifiyat DESC";
$stmt = $ozy->query($sql);
$maxfiyatz = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($maxfiyatz as $max) {
	$simdikifiyat = floatval($max['simdikifiyat']);
	$maxfiyat = $simdikifiyat > $maxfiyat ? $simdikifiyat : $maxfiyat;
}
$maxfiyat = ceil(intval($maxfiyat * 2));
$minfiyat = 0;
$minfiyatz = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and $category_condition order by simdikifiyat ASC")->fetchAll(PDO::FETCH_ASSOC);
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
$pageoku = $ozy->query("select * from urunler where durum='1' and $category_condition order by sira DESC")->fetchAll(PDO::FETCH_ASSOC);
$urunmarkalari = "";
foreach ($pageoku as $katurunler) {
	$urunmarkalari .= $katurunler['marka'] . ",";
?>
<?php } ?>
<main class="main">
	<?php if ($page['resim'] == 'resimyok.jpg') { ?>
		<div class="page-header text-center"
			style="background-image: url('<?php echo $sitetemasi; ?>/assets/images/page-header-bg.jpg')">
		<?php } else { ?>
			<div class="page-header text-center"
				style="background-image: url('resimler/kategoriler/<?php echo $page['resim']; ?>')">
			<?php } ?>
			<div class="container">
				<h1 class="page-title"><?php echo $page['adi']; ?><span>Anasayfa</span></h1>
			</div><!-- End .container -->
		</div><!-- End .page-header -->
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
					<?php if ($page['level'] == '2') { ?>
						<?php $ustkat1 = $page['ustkat'];
						$ustu = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat1'")->fetch(PDO::FETCH_ASSOC);
						$ustkat2 = $ustu['ustkat'];
						$ustu2 = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat2'")->fetch(PDO::FETCH_ASSOC); ?>
						<li class="breadcrumb-item"><a
								href="kategori/<?php echo $ustu2['seo']; ?>"><?php echo $ustu2['adi']; ?></a></li>
						<li class="breadcrumb-item"><a
								href="kategori/<?php echo $ustu['seo']; ?>"><?php echo $ustu['adi']; ?></a></li>
					<?php } ?>
					<?php if ($page['level'] == '1') { ?>
						<?php $ustkat1 = $page['ustkat'];
						$ustu = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat1'")->fetch(PDO::FETCH_ASSOC);
						$ustkat2 = $ustu['ustkat'];
						$ustu2 = $ozy->query("select * from kategoriler where durum='1' and id='$ustkat2'")->fetch(PDO::FETCH_ASSOC); ?>
						<li class="breadcrumb-item"><a
								href="kategori/<?php echo $ustu['seo']; ?>"><?php echo $ustu['adi']; ?></a></li>
					<?php } ?>
					<li class="breadcrumb-item active" aria-current="page"><?php echo $page['adi']; ?></li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		<div class="page-content">
			<div class="container">
				<div class="row">
					<div class="col-lg-9">
						<div class="toolbox">
							<div class="toolbox-left">
								<div class="toolbox-sort">
									<label for="sortby">Ürün Sıralama:</label>
									<div class="select-custom">
										<form action="" method="GET">
											<?php
											if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {
												$fitregelenveri = temizle($_GET["filtreleme"]);
												foreach ($fitregelenveri as $filtreverisi) { ?>
													<input type="hidden" name="filtreleme[]"
														value="<?php echo $filtreverisi; ?>" />
												<?php }
											} ?>
											<?php
											if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {
												$markagelenveri = temizle($_GET["markalar"]);
												foreach ($markagelenveri as $markaverisi) { ?>
													<input type="hidden" name="markalar[]"
														value="<?php echo $markaverisi; ?>" />
												<?php }
											} ?>
											<?php $siralama = isset($_GET['siralama']) ? $_GET['siralama'] : ''; ?>
											<select name="siralama" class="form-control" onchange='this.form.submit()'>
												<option <?php echo $siralama == 'onerilen' ? 'selected' : ''; ?>
													value="onerilen">Önerilen Sıralama</option>
												<option <?php echo $siralama == 'dusukfiyat' ? 'selected' : ''; ?>
													value="dusukfiyat">Önce En Düşük Fiyat</option>
												<option <?php echo $siralama == 'yuksekfiyat' ? 'selected' : ''; ?>
													value="yuksekfiyat">Önce En Yüksek Fiyat</option>
												<option <?php echo $siralama == 'encokyorum' ? 'selected' : ''; ?>
													value="encokyorum">En Çok Yorum Alan</option>
												<option <?php echo $siralama == 'enbegenilen' ? 'selected' : ''; ?>
													value="enbegenilen">En Çok Beğenilen</option>
												<option <?php echo $siralama == 'eskitarih' ? 'selected' : ''; ?>
													value="eskitarih">En Eski Tarihe Göre</option>
												<option <?php echo $siralama == 'yenitarih' ? 'selected' : ''; ?>
													value="yenitarih">En Yeni Tariha Göre</option>
											</select>
										</form>
									</div>
								</div><!-- End .toolbox-sort -->
							</div><!-- End .toolbox-right -->
							<div class="toolbox-right">
								<div class="toolbox-info">
									<span>
										Bu kategoride toplam <?php $katsorgu = $ozy->query("SELECT COUNT(*) FROM urunler where durum='1' and $category_condition");
										$katsay = $katsorgu->fetchColumn();
										echo '' . $katsay . ''; ?> adet ürün bulunmaktadır.</span>
								</div><!-- End .toolbox-info -->
							</div><!-- End .toolbox-left -->
						</div><!-- End .toolbox -->
						<div class="products mb-3">
							<div class="row justify-content-center">
								<?php
								$pages = intval(@$_GET['pages']);
								if (!$pages) {
									$pages = 1;
								}
								$bak = $ozy->prepare("select * from urunler where durum='1' and $category_condition");
								$bak->execute(array());
								$toplam = $bak->rowCount();
								$limit = 40;
								$goster = $pages * $limit - $limit;
								$sayfasayisi = ceil($toplam / $limit);
								$forlimit = 10;
								$where = " ";
								$marka = " ";
								$wherex = " ";
								if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {
									$fitregelenveri = temizle($_GET["filtreleme"]);
									foreach ($fitregelenveri as $filtreverisi) {
										$where .= " and FIND_IN_SET('" . $filtreverisi . "', filtre)";
									}
								}
								if (isset($_GET["fiyatfiltre"]) && $_GET["fiyatfiltre"] != "") {
									$gelenfiyat = temizle($_GET["fiyatfiltre"]);
									$fiyatexp = explode("-", $gelenfiyat);
									$wherex = " and if(idurum=1,ifiyat,fiyat)>=" . intval($fiyatexp[0]) . " and if(idurum=1,ifiyat,fiyat)<=" . intval($fiyatexp[1]);
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
										$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat) AS simdikifiyat from urunler where durum='1' and $category_condition " . $where . " " . $wherex . " " . $marka . " order by simdikifiyat ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
									} elseif (temizle($_GET["siralama"] == 'yuksekfiyat')) {
										$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat) AS simdikifiyat from urunler where durum='1' and $category_condition " . $where . " " . $wherex . " " . $marka . " order by simdikifiyat DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
									} elseif (temizle($_GET["siralama"] == 'encokyorum')) {
										$pageoku = $ozy->query("select * from urunler where durum='1' and $category_condition " . $where . " " . $wherex . " " . $marka . " order by yorum DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
									} elseif (temizle($_GET["siralama"] == 'enbegenilen')) {
										$pageoku = $ozy->query("select * from urunler where durum='1' and $category_condition " . $where . " " . $wherex . " " . $marka . " order by hit DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
									} elseif (temizle($_GET["siralama"] == 'eskitarih')) {
										$pageoku = $ozy->query("select * from urunler where durum='1' and $category_condition " . $where . " " . $wherex . " " . $marka . " order by tarih ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
									} elseif (temizle($_GET["siralama"] == 'yenitarih')) {
										$pageoku = $ozy->query("select * from urunler where durum='1' and $category_condition " . $where . " " . $wherex . " " . $marka . " order by tarih DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
									} elseif (temizle($_GET["siralama"] == 'onerilen')) {
										$pageoku = $ozy->query("select * from urunler where durum='1' and $category_condition " . $where . " " . $wherex . " " . $marka . " order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
									}
								} else {
									$pageoku = $ozy->query("select * from urunler where durum='1' and $category_condition " . $where . " " . $wherex . " " . $marka . " order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
								}
								$urunmarkalari .= "";
								$__URUN__ = false;
								foreach ($pageoku as $katurunler) {
									$urunmarkalari .= "" . $katurunler['marka'] . ",";
									$__URUN__ = true;
									?>
									<div class="col-6 col-md-4 col-lg-4 col-xl-3">
										<form method="GET" action="" />
										<div class="product product-7 text-center">
											<figure class="product-media">
												<a href="urun/<?php echo $katurunler['seo']; ?>">
													<img class="lazyload" style="width: 218px;height: 245px;"
														data-src="/resimler/urunler/<?php echo $katurunler['resim']; ?>"
														alt="Product image" class="product-image">
												</a>
												<?php if ($katurunler['yeni'] == '1') { ?>
													<span class="product-label label-circle label-new">Yeni Ürün</span>
												<?php } ?>
												<?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
												<div class="product-action-vertical">
													<a href="?favoriekle=<?php echo $katurunler['id']; ?>"
														class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
												</div><!-- End .product-action -->
												<?php } ?>
												<div class="product-action">
													<a href="urun/<?php echo $katurunler['seo']; ?>"
														class="btn-product btn-cart" title="Ürünü İncele"></a>
													<a href="?karsilastir=<?php echo $katurunler['id']; ?>"
														class="btn-product btn-quickview" title="Karşılaştır"></a>
												</div><!-- End .product-action -->
											</figure><!-- End .product-media -->
											<div class="product-body">
												<div class="product-cat">
													<a>Ürün Kodu : #<?php echo $katurunler['urunkodu']; ?></a>
												</div><!-- End .product-cat -->
												<h3 class="product-title"><a
														href="urun/<?php echo $katurunler['seo']; ?>"><?php echo $katurunler['adi']; ?></a>
												</h3><!-- End .product-title -->
												<div class="product-price">
													<?php echo urunfiyatbelirle($katurunler['kdv'], $katurunler['idurum'], $katurunler['fiyat'], $katurunler['ifiyat']); ?>
												</div><!-- End .product-price -->
												<?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
												<div class="ratings-container">
													<div class="ratings">
														<div class="ratings-val" style="width: 
														<?php
														$urunid = $katurunler['id'];
														$urun = $ozy->prepare("SELECT * FROM tumyorumlar WHERE sayfaid = ? and durum = 1");
														$urun->execute([$urunid]);
														$urun = $urun->fetchAll(PDO::FETCH_ASSOC);
														$yorumadet = 0;
														$yildiz = 0;
														foreach ($urun as $yorum) {
															$yildiz += $yorum['yildiz'];
															$yorumadet++;
														}
														$yildiz = ($yorumadet > 0) ? intval($yildiz / $yorumadet) : 0;
														?>
														<?php echo $yildiz == '1' ? '20%' : null; ?>
														<?php echo $yildiz == '2' ? '40%' : null; ?>
														<?php echo $yildiz == '3' ? '60%' : null; ?>
														<?php echo $yildiz == '4' ? '80%' : null; ?>
														<?php echo $yildiz == '5' ? '100%' : null; ?>
														;"></div><!-- End .ratings-val -->
													</div><!-- End .ratings -->
													<?php
													$sayfaid = $katurunler['id'];
													$urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='urunler' and durum='1'");
													$urunyorumsayisi->execute();
													$urunyorumsayimis = $urunyorumsayisi->fetchColumn(); ?>
													<span class="ratings-text">( <?php echo $urunyorumsayimis; ?> Yorum
														)</span>
												</div><!-- End .rating-container -->
												<?php } ?>
											</div><!-- End .product-body -->
										</div><!-- End .product -->
										</form>
									</div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
								<?php }
								if (!$__URUN__) {
									echo "<b style='font-weight: 500;background: #fafafa;padding: 10px;width: 100%;text-align: center;border: 1px solid #ededed;'>Üzgünüm Böyle bir ürün bulunamadı</b>";
								}
								?>
							</div><!-- End .row -->
						</div><!-- End .products -->
						<nav aria-label="Page navigation">
							<ul class="pagination justify-content-center">
								<?php
								for ($i = $pages - $forlimit; $i < $pages + $forlimit + 1; $i++) {
									if ($i > 0 and $i <= $sayfasayisi) {
										if ($i == $pages) {
											echo "<li class='page-item active' aria-current='page'><a>" . $i . "</a></li>";
										} else {
											$eklenecekstr = "";
											foreach ($_GET as $key => $value) {
												if ($key != "pages" and $key != "trendmaxtrs" and $key != "id")
													$eklenecekstr .= $key . "=&" . $value;
											}
											$eklenecekstr = $eklenecekstr != "" ? "&" . $eklenecekstr : "";
											echo "<li class='page-item'><a class='page-link' href='kategori/" . $page['seo'] . "?pages=" . $i . $eklenecekstr . "'>" . $i . "</a></li>";
										}
									}
								}
								?>
							</ul>
						</nav>
					</div><!-- End .col-lg-9 -->
					<aside class="col-lg-3 order-lg-first">
						<form action="" method="GET">
							<input type="hidden" name="siralama"
								value="<?php echo temizle($_GET['siralama'] ?? ''); ?>" />
							<input type="hidden" name="pages" value="<?php echo temizle($_GET['pages'] ?? ''); ?>" />
							<input type="hidden" name="fiyatfiltre"
								value="<?php echo temizle($_GET['fiyatfiltre'] ?? ''); ?>" />
							<?php
							if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {
								$markagelenveri = temizle($_GET["markalar"]);
								foreach ($markagelenveri as $markaverisi) { ?>
									<input type="hidden" name="markalar[]" value="<?php echo $markaverisi; ?>" />
								<?php }
							} ?>
							<div class="sidebar sidebar-shop">
								<div class="widget widget-clean">
									<label>Ürün Filtreleme:</label>
									<a href="kategori/<?php echo $page['seo']; ?>" class="sidebar">Filtreyi Temizle</a>
								</div><!-- End .widget widget-clean -->
								<div class="widget widget-collapsible"
									style="border: 1px solid #57aaff52;padding: 10px">
									<h3 class="widget-title">
										<a data-toggle="collapse" href="#widget-2Fiyat" role="button"
											aria-expanded="true" aria-controls="widget-2">
											Fiyat Aralığı
										</a>
									</h3><!-- End .widget-title -->
									<div class="collapse show" id="widget-2Fiyat">
										<div class="widget-body">
											<div class="filter-items">
												<?php $bolumfiyat = intval($maxfiyat / 5);
												for ($i = 0; $i < 5; $i++) {
													$basfiyat = intval($minfiyat + $i * $bolumfiyat);
													$sonfiyat = intval($minfiyat + ($i + 1) * $bolumfiyat);
													?>
													<div class="filter-item">
														<div class="custom-control custom-checkbox">
															<input <?php echo (isset($_GET['fiyatfiltre']) && $_GET['fiyatfiltre'] == $basfiyat . "-" . $sonfiyat) ? 'checked' : ''; ?> type="radio" class="custom-control-input"
																id="size-1<?php echo $i; ?>" name="fiyatfiltre"
																value="<?php echo $basfiyat . "-" . $sonfiyat; ?>">
															<label class="custom-control-label"
																for="size-1<?php echo $i; ?>"><?php echo $basfiyat . " - " . $sonfiyat; ?>
																TL</label>
														</div><!-- End .custom-checkbox -->
													</div><!-- End .filter-item -->
												<?php } ?>
											</div><!-- End .filter-items -->
										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
								</div><!-- End .widget -->
								<?php 
								// Alt kategorilerdeki filtreleri de dahil et
								$filtre_category_condition = "(" . implode(' OR ', array_map(function($id) { return "FIND_IN_SET($id, kategori)"; }, $all_category_ids)) . ")";
								$filtre = $ozy->query("select * from filtre where $filtre_category_condition order by sira desc")->fetchAll(PDO::FETCH_ASSOC);
								foreach ($filtre as $filtregel) { ?>
									<div class="widget widget-collapsible"
										style="border: 1px solid #57aaff52;padding: 10px">
										<h3 class="widget-title">
											<a data-toggle="collapse" href="#widget-2<?php echo $filtregel['fid']; ?>"
												role="button" aria-expanded="true" aria-controls="widget-2">
												<?php echo $filtregel['fadi']; ?>
											</a>
										</h3><!-- End .widget-title -->
										<div class="collapse show" id="widget-2<?php echo $filtregel['fid']; ?>">
											<div class="widget-body">
												<div class="filter-items">
													<?php
													$katoz = $filtregel['ozellik'];
													$katozel = explode(',', $katoz);
													foreach ($katozel as $katozellik => $verimiz) {
														if (isset($_GET["filtreleme"]) && $_GET["filtreleme"] != "") {
															$gelenfiltreleme = $_GET['filtreleme'];
														} ?>
														<div class="filter-item">
															<div class="custom-control custom-checkbox">
																<input <?php
																if (in_array($verimiz, $gelenfiltreleme)) {
																	echo "checked";
																}
																; ?> type="checkbox"
																	class="custom-control-input"
																	id="size-1<?php echo $verimiz; ?>" name="filtreleme[]"
																	value="<?php echo $verimiz; ?>">
																<label class="custom-control-label"
																	for="size-1<?php echo $verimiz; ?>"><?php echo $verimiz; ?></label>
															</div><!-- End .custom-checkbox -->
														</div><!-- End .filter-item -->
													<?php } ?>
												</div><!-- End .filter-items -->
											</div><!-- End .widget-body -->
										</div><!-- End .collapse -->
									</div><!-- End .widget -->
								<?php } ?>
								<div class="widget widget-collapsible"
									style="max-height: 500px;overflow: auto;border: 1px solid #57aaff52;padding: 10px">
									<h3 class="widget-title">
										<a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true"
											aria-controls="widget-4">
											Markalar
										</a>
									</h3><!-- End .widget-title -->
									<div class="collapse show" id="widget-4">
										<div class="widget-body">
											<div class="filter-items">
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
												foreach ($mark as $marka) {
													if (isset($_GET["markalar"]) && $_GET["markalar"] != "") {
														$markafiltreleme = $_GET['markalar'];
													}
													$markaidmmmm = $marka['id'];
													?>
													<div class="filter-item">
														<div class="custom-control custom-checkbox">
															<input <?php
															if (is_array($markafiltreleme) && in_array($markaidmmmm, $markafiltreleme)) {
																echo "checked";
															}
															; ?> type="checkbox" name="markalar[]"
																value="<?php echo $marka['id']; ?>"
																class="custom-control-input"
																id="brand-1<?php echo $marka['id']; ?>">
															<label class="custom-control-label"
																for="brand-1<?php echo $marka['id']; ?>"><?php echo $marka['adi']; ?></label>
														</div><!-- End .custom-checkbox -->
													</div><!-- End .filter-item -->
												<?php } ?>
											</div><!-- End .filter-items -->
										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
								</div><!-- End .widget -->
								<div class="col-6 col-lg-4 col-xl-2">
									<div class="btn-wrap">
										<button type="submit" class="btn btn-primary btn-rounded">Filteyi Uygula</a>
									</div><!-- End .btn-wrap -->
								</div>
							</div><!-- End .sidebar sidebar-shop -->
						</form>
					</aside><!-- End .col-lg-3 -->
				</div><!-- End .row -->
			</div><!-- End .container -->
		</div>
</main>