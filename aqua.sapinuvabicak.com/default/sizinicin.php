<title>Sizin İçin Seçtiklerimiz</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>" />
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni" />
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>" />





<main class="main">
	<div class="page-header text-center"
		style="background-image: url('<?php echo $sitetemasi; ?>/assets/images/page-header-bg.jpg')">
		<div class="container">
			<h1 class="page-title">Sizin İçin Seçtiklerimiz<span>Anasayfa</span></h1>
		</div><!-- End .container -->
	</div><!-- End .page-header -->
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
				<li class="breadcrumb-item active" aria-current="page">Sizin İçin Seçtiklerimiz</li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->
	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="toolbox">
						<div class="toolbox-left">
							<div class="toolbox-sort">
								<label for="sortby">Ürün Sıralama:</label>
								<div class="select-custom">
									<form action="" method="GET">
										<input type="hidden" name="arama"
											value="<?php echo temizle($_GET['arama']); ?>" />
										<select name="siralama" class="form-control" onchange='this.form.submit()'>
											<option <?php echo $_GET['siralama'] == 'onerilen' ? 'selected="selected"' : null; ?> value="onerilen">Önerilen Sıralama</option>
											<option <?php echo $_GET['siralama'] == 'dusukfiyat' ? 'selected="selected"' : null; ?> value="dusukfiyat">Önce En Düşük Fiyat</option>
											<option <?php echo $_GET['siralama'] == 'yuksekfiyat' ? 'selected="selected"' : null; ?> value="yuksekfiyat">Önce En Yüksek Fiyat</option>
											<option <?php echo $_GET['siralama'] == 'encokyorum' ? 'selected="selected"' : null; ?> value="encokyorum">En Çok Yorum Alan</option>
											<option <?php echo $_GET['siralama'] == 'enbegenilen' ? 'selected="selected"' : null; ?> value="enbegenilen">En Çok Beğenilen</option>
											<option <?php echo $_GET['siralama'] == 'eskitarih' ? 'selected="selected"' : null; ?> value="eskitarih">En Eski Tarihe Göre</option>
											<option <?php echo $_GET['siralama'] == 'yenitarih' ? 'selected="selected"' : null; ?> value="yenitarih">En Yeni Tariha Göre</option>
										</select>
									</form>
								</div>
							</div><!-- End .toolbox-sort -->

						</div><!-- End .toolbox-right -->


						<div class="toolbox-right">
							<div class="toolbox-info">
								<span>
									Arama sonucuna göre toplam <?php $katsorgu = $ozy->prepare("SELECT COUNT(*) FROM urunler where durum='1' and agoster='1'");
									$katsorgu->execute();
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

							$bak = $ozy->prepare("select * from urunler where durum='1' and agoster='1'");
							$bak->execute(array());
							$toplam = $bak->rowCount();
							$limit = 20;
							$goster = $pages * $limit - $limit;
							$sayfasayisi = ceil($toplam / $limit);
							$forlimit = 200;




							if (isset($_GET["siralama"]) && $_GET["siralama"] != "0") {

								if (temizle($_GET["siralama"] == 'dusukfiyat')) {

									$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and agoster='1' order by simdikifiyat ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

								} elseif (temizle($_GET["siralama"] == 'yuksekfiyat')) {

									$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat ) AS simdikifiyat from urunler where durum='1' and agoster='1' order by simdikifiyat DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

								} elseif (temizle($_GET["siralama"] == 'encokyorum')) {

									$pageoku = $ozy->query("select * from urunler where durum='1' and agoster='1' order by yorum DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

								} elseif (temizle($_GET["siralama"] == 'enbegenilen')) {

									$pageoku = $ozy->query("select * from urunler where durum='1' and agoster='1' order by hit DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

								} elseif (temizle($_GET["siralama"] == 'eskitarih')) {

									$pageoku = $ozy->query("select * from urunler where durum='1' and agoster='1' order by tarih DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

								} elseif (temizle($_GET["siralama"] == 'yenitarih')) {

									$pageoku = $ozy->query("select * from urunler where durum='1' and agoster='1' order by tarih ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

								} elseif (temizle($_GET["siralama"] == 'onerilen')) {

									$pageoku = $ozy->query("select * from urunler where durum='1' and agoster='1' order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

								}


							} else {

								$pageoku = $ozy->query("select * from urunler where durum='1' and agoster='1' order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

							}



							$__URUN__ = false;
							foreach ($pageoku as $sizinicin) {
								$__URUN__ = true;

								?>



								<div class="col-6 col-md-4 col-lg-3">
									<div class="product product-2">
										<figure class="product-media">
											<a href="urun/<?php echo $sizinicin['seo']; ?>">
												<img class="lazyload" style="width: 278px;height: 310px;"
													data-src="resimler/urunler/<?php echo $sizinicin['resim']; ?>"
													alt="Product image" class="product-image">
											</a>
											<?php if ($sizinicin['yeni'] == '1') { ?>
												<span class="product-label label-circle label-new">Yeni Ürün</span>
											<?php } ?>
											<?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>
											<div class="product-action-vertical">
												<a href="?favoriekle=<?php echo $sizinicin['id']; ?>"
													class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
											</div><!-- End .product-action -->
											<?php } ?>
											<form method="GET" action="">
												<div class="product-action">
													<a href="urun/<?php echo $sizinicin['seo']; ?>"
														class="btn-product btn-cart" title="Ürünü İncele"><span>Ürünü
															İncele</span></a>
													<a href="?karsilastir=<?php echo $sizinicin['id']; ?>"
														class="btn-product btn-quickview"
														title="Karşılaştır"><span>Karşılaştır</span></a>
												</div><!-- End .product-action -->
											</form>
										</figure><!-- End .product-media -->

										<div class="product-body">
											<div class="product-cat">
												<a>Ürün Kodu : #<?php echo $sizinicin['urunkodu']; ?></a>
											</div><!-- End .product-cat -->
											<h3 class="product-title"><a
													href="urun/<?php echo $sizinicin['seo']; ?>"><?php echo $sizinicin['adi']; ?></a>
											</h3><!-- End .product-title -->
											<div class="product-price">
												<?php echo urunfiyatbelirle($sizinicin['kdv'], $sizinicin['idurum'], $sizinicin['fiyat'], $sizinicin['ifiyat']); ?>
											</div><!-- End .product-price -->
											<?php if (paket_kontrol_musteri(["plus", "extreme", "enterprise"])) { ?>

											$urunid = $sizinicin['id'];
											
											$urun = $ozy->prepare("SELECT * FROM tumyorumlar WHERE sayfaid = ? and durum = 1");
											$urun->execute([$urunid]);
											$urun = $urun->fetchAll(PDO::FETCH_ASSOC);
											$yorumadet = 0;
											$yildiz = 0;
											foreach ($urun as $yorum) {
												$yildiz += $yorum['yildiz'];
												$yorumadet++;
											}


											$yildiz = intval($yildiz / $yorumadet);




											?>
											<div class="ratings-container">
												<div class="ratings">
													<div class="ratings-val" style="width:
													<?php echo $yildiz == '1' ? '20%' : null; ?>
													<?php echo $yildiz == '2' ? '40%' : null; ?>
													<?php echo $yildiz == '3' ? '60%' : null; ?>
													<?php echo $yildiz == '4' ? '80%' : null; ?>
													<?php echo $yildiz == '5' ? '100%' : null; ?>
													;"></div><!-- End .ratings-val -->
												</div><!-- End .ratings -->
												<?php
												$sayfaid = $sizinicin['id'];
												$urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='urunler' and durum='1'");
												$urunyorumsayisi->execute();
												$urunyorumsayimis = $urunyorumsayisi->fetchColumn(); ?>
												<span class="ratings-text">( <?php echo $urunyorumsayimis; ?> Yorum )</span>
												</div><!-- End .rating-container -->
											<?php } ?>
										</div><!-- End .product-body -->
									</div><!-- End .product -->
								</div>






							<?php }

							if (!$__URUN__) {

								echo "Sizin için seçilen bir ürün bulunamadı :(";

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
												$eklenecekstr .= $key . "=" . $value;
										}
										$eklenecekstr = $eklenecekstr != "" ? "&" . $eklenecekstr : "";

										echo "<li class='page-item'><a class='page-link' href='sizinicin/?pages=" . $i . $eklenecekstr . "'>" . $i . "</a></li>";

									}

								}
							}




							?>



						</ul>
					</nav>
				</div><!-- End .col-lg-9 -->


			</div><!-- End .row -->
		</div><!-- End .container -->
	</div>

</main>