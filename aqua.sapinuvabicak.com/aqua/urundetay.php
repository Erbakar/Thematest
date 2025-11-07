<?php
$id = temizle($_GET['id']);
$query = $ozy->prepare("UPDATE urunler SET hit = (hit+1) WHERE seo=?");
$update = $query->execute(array($id));
?>

<?php 
$id = temizle($_GET['id']); 
$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM urunler WHERE seo=:id and durum=:durum");
$page = $sayfaqq->execute([':id' => $id,':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

////////URUN FİYAT BELİRMELE ALANI///////

if($page['idurum']=='1'){								
if($page['kdv']>'0'){
$eskifiyat = fiyatgoster(KdvDahil($page['fiyat'],$page['kdv']));
$yenifiyat = fiyatgoster(KdvDahil($page['ifiyat'],$page['kdv']));
} else {
$eskifiyat = fiyatgoster(KdvDahil($page['fiyat'],$system['kdv']));
$yenifiyat = fiyatgoster(KdvDahil($page['ifiyat'],$system['kdv']));
}
} else {
if($page['kdv']>'0'){
$yenifiyat = fiyatgoster(KdvDahil($page['fiyat'],$page['kdv']));
} else { 
$yenifiyat = fiyatgoster(KdvDahil($page['fiyat'],$system['kdv']));
}} 

////////URUN FİYAT BELİRMELE ALANI///////									

?>
<?php if($page['seodurum']=='1'){?>
<title><?php echo $page['stitle']; ?></title>
<meta name="keywords" content="<?php echo $page['skey']; ?>">
<meta name="description" content="<?php echo $page['sdesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="<?php echo $ayar['stitle']; ?>"/>
<meta property="og:description" content="<?php echo $page['sdesc']; ?>"/>
<?php } else { ?>
<title><?php echo $page['adi']; ?></title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="<?php echo $page['adi']; ?>"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
<?php } ?>

 
   <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h1><?php echo $page['adi'];?></h1>
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a>Ana Sayfa</a></li>
                   
			           <?php 
			            $urunkategori = $page['kategori'];
			            $kat = $ozy->query("select * from kategoriler where durum='1' and id='$urunkategori'")->fetchAll(PDO::FETCH_ASSOC); 
			            foreach($kat as $ukat){?>
			<li class="breadcrumb-item"><a href="kategori/<?php echo $ukat['seo'];?>"><?php echo $ukat['adi'];?></a></li>
			 <?php } ?>
			 
				
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $page['adi']; ?></li>
                </ol>
            </nav>
        </div>
    </section>
	
	
	
	  <section class="product mt-5">
        <div class="container-lg">
            <div class="box">
                <div class="row">
                    <div class="col-xl-6 col-lg-5">
                        <div class="productslider">
                            <div>
                                <img src="resimler/urunler/<?php echo $page['resim']?>" class="img-fluid" alt="">
                            </div>
							 <?php 
						$i =0;
					    $gelenid = $page['id'];
					    $sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='urunler' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                        foreach($sayfaresimi as $genelresim){?>
                            <div>
                                <img src="resimler/genel/<?php echo $genelresim['sayfaresim'];?>" class="img-fluid" alt="">
                            </div>
               <?php } ?>	
                        </div>
                        <div class="productsliderthumb mt-3">
                            <div>
                                <img src="resimler/urunler/<?php echo $page['resim']?>" class="img-fluid" alt="">
                            </div>
                            	 <?php 
						$i =0;
					    $gelenid = $page['id'];
					    $sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='urunler' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                        foreach($sayfaresimi as $genelresim){?>
                            <div>
                                <img src="resimler/genel/<?php echo $genelresim['sayfaresim'];?>" class="img-fluid" alt="">
                            </div>
               <?php } ?>	
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <h1 class="title mt-xl-0 mt-lg-0 mt-md-5 mt-sm-5 mt-5"><?php echo $page['adi'];?></h1>
                        <div class="scrolllr">
                            <div class="d d-flex align-items-center justify-content-between scrollin">
                                <div class="l d-flex align-items-center me-xl-0 me-lg-0 me-md-0 me-sm-3 me-3">
                                    <div class="categoryname me-3">Kategori</div> 
									
								
									   <?php 
			            $urunkategori = $page['kategori'];
			            $kat = $ozy->query("select * from kategoriler where durum='1' and id='$urunkategori'")->fetchAll(PDO::FETCH_ASSOC); 
			            foreach($kat as $ukat){?>
<a class="btn-category"href="kategori/<?php echo $ukat['seo'];?>"><?php echo $ukat['adi'];?></a>
			 <?php } ?>
									
									
                                </div>
                                <div class="r d-flex align-items-center">
								<?php if($page['stok']>='1'){?>
                                    <span class="stock me-3"><?php echo $page['stok'];?> Adet Stokta</span>
								<?php } else { ?>	
								  <span style="background: #f77171;
color: #fffdfd;" class="stock me-3">Tükendi</span>
								<?php } ?>	
                                    <span class="code">Stok Kodu: <?php echo $page['urunkodu'];?></span>
                                </div>
								
								
								
								
								
								
								
                            </div>
							
							 <div class="r d-flex align-items-center mb-3">
								<?php if($page['ucretsizkargo']=='1'){?>
                               <span class="stock me-3" style="background: white;border: 1px solid #ec3737;color: #ec3737;">
							   BU ÜRÜNDE KARGO ÜCRETSİZ</span>
								<?php } ?>	
                               	  <?php if($page['alode']=='1'){?>
                               <span class="stock me-3" style="background: white;border: 1px solid #6205a2;color: #6205a2;">
							  BU ÜRÜNDE <?php echo $page['al'];?> AL <?php echo $page['ode'];?> ÖDE FIRSATI                 
           </span>
								<?php } ?>	
								</div>
								
								
                        </div>
						<?php if($page['idurum']=='1'){?>
                        <div class="oldprice"><span><?php echo $eskifiyat;?></span> 
						
						<span class="discount ms-3">%<?php echo yuzdeHesaplama($page['fiyat'],$page['ifiyat']);?> İNDİRİM!</span>
					 
						
						</div>
							<?php } ?> 
                        <div class="price"><?php echo $yenifiyat;?></div>
						 <?php if($page['kdv']>'0'){?>	
								    <?php  $ekkdv = $page['kdv'];?>
									<?php } else { ?>
					                <?php  $ekkdv = $system['kdv'];?>
									<?php } ?>
									<?php if($page['havaledurum']=='1'){?>	
						<span class="discount ms-3" style="background: #dee6e559;
color: #272626;
display: block;
padding: 20px;
border-radius: 10px;
margin: 0px !important;
  margin-top: 0px;
margin-top: 10px !important;
font-weight: bold;">Havale Fiyatı : <?php echo $hfiyat = fiyatgoster(KdvDahil($page['hfiyat'],$ekkdv));?></span>
						
						
			<?php } ?> 				
						
						
						
						<?php if($page['kisa'] === null or $page['kisa'] === '' or $page['kisa'] === '1' or $page['kisa'] === '0'){?>
				        <?php } else { ?>	
                        <span class="time"><i class="ri-timer-flash-line"></i> <b><?php echo $page['kisa'];?></b></span>
						<?php } ?> 
						
						  <form action="" method="POST" id="add-cart-form" class="add-cart-form" autocomplete="off">

						
						<?php 
								      $kod = $page['urunkodu'];
								      $varyant = $ozy->prepare("SELECT COUNT(*) FROM urunler where durum='1' and  urunkodu='$kod'");
                                      $varyant->execute();
                                      $varyantsayi = $varyant->fetchColumn();?>
							<div style="margin-top: 10px;
background: #f9f9f9;
border-radius: 6px;
padding: 10px;
margin-bottom: 10px;<?php echo $varyantsayi <= '1' ? 'display:none;' : null; ?>" >
								<h5 style="font-size: 15px;
margin-bottom: 10px;
font-weight: bold;">Renk Seçenekleri</h5>
								<div class="image_option_type form-group required" <?php echo $varyantsayi <= '1' ? 'style="display:none;"' : null; ?>>
									<ul style="padding: 0px;list-style: none;
" class="product-options clearfix" id="input-option231">
									<?php 
										$sayfaidmiz = $page['id'];
										$urunvaryant = $ozy->query("select * from urunler where durum='1' and urunkodu='$kod' and id!='$sayfaidmiz' ORDER BY sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                                        foreach($urunvaryant as $varyantbak){?>  
										<li class="" style="float:left;margin-left:5px;">
											<a href="urun/<?php echo $varyantbak['seo'];?>">
												<img style="width: 40px;
height: 50px;" src="resimler/urunler/<?php echo $varyantbak['resim'];?>"  class="img-thumbnail icon icon-color">	
										</a>
										</li>
										<?php } ?>	
										
									
									</ul>
								</div>
								</div>
						
						
								
<style>
label {
  display: inline-block;
  padding-bottom: 10px !important;
}
.form-control{
height: 42px !important;
}
</style>

		    <?php 
									$urunid = $page['id'];
									$ozellik = $ozy->query("select * from anaozellik where tip='0' and urunid='$urunid' ORDER BY id desc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($ozellik as $anaozellik){?>  
                                    <div class="details-filter-row details-row-size">
                                        <label for="size" style="width: 100%;font-weight: 500;"><?php echo $anaozellik['adi'];?> :</label>
                                        <div class="select-custom" style="width: 100%;">
                                    <select class="form-control varyantselect" onchange="detayfiyathesapla(this);" name="ozellik[]" id="size"  required>
                                    <option data-price="0.00" value="">Seçim Yapınız</option>
									<?php 
									$altanaid = $anaozellik['id'];
									$ozellikalt = $ozy->query("select * from anaozellikalt where anaid='$altanaid' ORDER BY id asc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($ozellikalt as $anaozellikalt){?> 		
                                    <option data-price="<?php echo KdvDahil($anaozellikalt['fiyat'],$ekkdv);?>" value="<?php echo $anaozellikalt['id'];?>" <?php echo $anaozellikalt['stok'] <= '0' ? 'disabled' : null; ?>><?php echo $anaozellikalt['adi'];?> <?php echo $anaozellikalt['stok'] <= '0' ? '(Tükendi)' : null; ?></option>
                                    <?php } ?>	  
                                    </select>
                                        </div><!-- End .select-custom -->

                                    </div><!-- End .details-filter-row -->
								
								   <?php } ?>	
								   
								   
                                    <?php 
									$urunid = $page['id'];
									$iozellik = $ozy->query("select * from anaozellik where tip='1' and urunid='$urunid' ORDER BY id desc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($iozellik as $ianaozellik){?>  
									
                                    <div class="details-filter-row details-row-size" style="background: #fbf8f8;padding: 10px;width: 100%;display: flex;">
                                    <label for="size" style="width: 100%;font-weight: 500;"><?php echo $ianaozellik['adi'];?> :</label>
									<?php 
									$ialtanaid = $ianaozellik['id'];
									$iozellikalt = $ozy->query("select * from anaozellikalt where anaid='$ialtanaid' ORDER BY id asc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($iozellikalt as $ianaozellikalt){?>
			                        <label class="size-item">
				                    <input onclick="detayfiyathesapla(this);" data-price="<?php echo KdvDahil($ianaozellikalt['fiyat'],$ekkdv);?>" class="varyantradio form-control" type="radio" name="ozellik[]" level="2" <?php echo $ianaozellikalt['stok'] <= '0' ? 'disabled' : null; ?> value="<?php echo $ianaozellikalt['id'];?>" stocksize="<?php echo $ianaozellikalt['adi'];?>" available="1" required>
				                    <span <?php echo $ianaozellikalt['stok'] <= '0' ? 'style="border-color: #eee;
color: #3f3a3a;
background: #fbf8f8;"' : null; ?> class="size-slt-box" level="2" value="<?php echo $ianaozellikalt['id'];?>" name="ozellik[]"><?php echo $ianaozellikalt['adi'];?></span></label>
				                    <?php } ?>
                                    </div>
									 
                                    <?php } ?>



                                    <input type="hidden" value="<?php echo $page['id'];?>" name="urunid"/>
									
						
                        <div class="button-group d-flex align-items-center justify-content-between">
                            <div class="l d-flex align-items-center">
                                <div class="input-group number-count">
                                <span class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="adet">
                                        <span class="fa ri-subtract-line"></span>
                                    </button>
                                </span>
                                    <input type="text" name="adet" class="form-control input-number" value="1" max="<?php echo $page['stok'];?>" min="1">
                                    <span class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="adet">
                                        <span class="fa ri-add-line"></span>
                                    </button>
                                </span>
                                </div>
								<?php if($page['stok']>='1'){?>
								    <button  style="border-radius: 32px;
background-color: #00b373;
padding: 19px 22px;
font-size: 18px;
font-weight: 500;
color: #fff;
display: flex;
align-items: center;
-webkit-transition: all 0.3s;border: none;font-size:18px;
transition: all 0.3s;" name="sepetle" type="submit" class="btn-cart ms-3"><i class="ri-shopping-basket-2-line" style="font-size: 18px;
margin-right: 10px;"></i>  SEPETE EKLE</button>
                            
								 <?php } else { ?>  
                                <a style="background: #e61111 !important;" class="btn-cart ms-3"><i class="ri-shopping-basket-2-line"></i> Tükendi</a>
                            <?php } ?>
							
							
							</div>
                            <div class="r d-flex align-items-center">
							<?php if($system['whatsapal']=='1'){?>
							<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $ayar['whatsapp']; ?>&amp;text=<?php echo $page['adi']; ?>%20sipari%C5%9Fi%20vermek%20istiyorum. <?php echo $url;?>/urun/<?php echo $page['seo']; ?>" class="btn-fav me-3" style="color: white;background: #1bd96e;"><i class="ri-whatsapp-line"></i></a>
                            <?php } ?>  
                            <?php if($system['telefonal']=='1'){?>
							<a target="_blank" href="tel:<?php echo $ayar['ceptel']; ?>" class="btn-fav me-3" style="color: white;background:#9696f4;"><i class="ri-phone-line"></i></a>
                            <?php } ?>  
							 <a href="?favoriekle=<?php echo $page['id']; ?>" class="btn-fav me-3"><i class="ri-star-line"></i></a>
                                <a href="?karsilastir=<?php echo $page['id']; ?>" class="btn-compare"><i class="ri-arrow-left-right-line"></i></a>
                            </div>
                        </div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="product-detail mt-5">
        <div class="container-lg">
            <div class="card">
                <div class="card-header">
                    <ul class="nav justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="pills-tab1-t" data-bs-toggle="pill" data-bs-target="#pills-tab1" type="button" role="tab" aria-controls="pills-tab1" aria-selected="true">Ürün Özellikleri</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="pills-tab2-t" data-bs-toggle="pill" data-bs-target="#pills-tab2" type="button" role="tab" aria-controls="pills-tab2" aria-selected="false">Yorumlar</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="pills-tab4-t" data-bs-toggle="pill" data-bs-target="#pills-tab4" type="button" role="tab" aria-controls="pills-tab4" aria-selected="false">İade & Değişim Şartları</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-tab1" role="tabpanel" aria-labelledby="pills-tab1">
                         <?php echo $page['aciklama'];?>
						</div>
                        <div class="tab-pane fade" id="pills-tab2" role="tabpanel" aria-labelledby="pills-tab2">
                            
					<?php 
					$sayfaid = $page['id'];
					$urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='urunler' and durum='1'"); 
					$urunyorumsayisi->execute(); $urunyorumsayimis = $urunyorumsayisi->fetchColumn();
					if($urunyorumsayimis>'0'){?>
                      
                    <?php } else { ?>
					<h5>Bu ürüne henüz yorum yapılmamış. İlk yorumu sen yapmak ister misin ?</h5><!-- End .title -->
					<?php } ?>	
							<ul class="comments">
                                
								<?php 
				$blogid = $page['id'];
				$deneme = $ozy->query("select * from tumyorumlar where durum='1' and sayfaid='$blogid' and konu='urunler' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($deneme as $blogyorum) {?>		
								
                                <li>
                                    <div class="name"><?php echo $blogyorum['tarih']; ?> <span class="date"><?php echo $blogyorum['tarih']; ?></span></div>
                                    <p><?php echo $blogyorum['yorum']; ?></p>
                                </li>
								
							 <?php 
									$karakter_sayisi = strlen($blogyorum['cevap']);
									
									if($karakter_sayisi>'1'){?>	
								
                                <li>
                                    <div class="name"><?php echo $ayar['siteadi']; ?> <span class="date" style="background: #03c77d;
color: white;">Cevapladı</span></div>
                                    <p><?php echo $blogyorum['cevap']; ?></p>
                                </li>
								
								<?php } ?>
								<?php } ?>
                            </ul>
							
							
							
							
							
							   
              <form class="form-horizontal" method="POST" action="" style="background: #f7f7f7;
padding: 20px;
border-radius: 6px;">
                <div id="review"></div>
                
				 <p class="title-desc" style="color: #d81818;border: 1px solid #d81818;padding: 10px;font-size: 14px;border-radius: 2px;">Eposta adresiniz gizlilik nedeniyle görünmeyecektir. * Argo , küfür veya hukuka aykırı yorumlar onaylanmayacaktır.
							Bu tarz yorum yapanlar hakkında yasal süreç başlatılacaktır.</p>
                  <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name">Adınız Soyadınız</label>
                    <input type="text" class="form-control" name="adi" required="" value="<?php echo $uyebilgileri['isim'];?>">
                  </div>
                     <div class="col-sm-12">
                    <label class="control-label" for="input-name">Eposta Adresiniz</label>
                      <input type="email" class="form-control" id="reply-email" name="email" required=""  value="<?php echo $uyebilgileri['email'];?>">
                  </div>
				  
				  
				</div>
				
             
              
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review">Yorumunuz</label>
                    <textarea name="yorum" style="height: 191px !important;" rows="5" id="input-review" class="form-control" required></textarea>
                    <div class="help-block"><span class="text-danger">Not:</span> HTML'e dönüştürülmez!</div>
                  </div>
                </div>
                <div class="form-group required" style="margin-top:10px;">
                  <div class="col-sm-12">
                    <label class="control-label">Oylama</label>
                    &nbsp;&nbsp;&nbsp; Kötü&nbsp;
                    <input type="radio" name="yildiz" value="1">
                    &nbsp;
                    <input type="radio" name="yildiz" value="2">
                    &nbsp;
                    <input type="radio" name="yildiz" value="3">
                    &nbsp;
                    <input type="radio" name="yildiz" value="4">
                    &nbsp;
                    <input type="radio" name="yildiz" value="5">
                    &nbsp;İyi</div>
                </div>
                   <div class="buttons clearfix">
				    <input type="hidden" name="sayfaid" value="<?php echo $page['id'];?>"/>
                  <div class="pull-right">
                    <button type="submit" name="urunyorum" id="button-review" class="gonderbuton">Gönder</button>
                  </div>
                </div>
                              </form>
							
							
                        </div>
                        <div class="tab-pane fade" id="pills-tab4" role="tabpanel" aria-labelledby="pills-tab4">
                          	  <?php echo $system['iade']; ?>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bestsellers mt-5 pt-5 pb-5">
        <div class="container-lg">
            <div class="group d-flex align-items-center justify-content-between">
                <div class="title">BENZER ÜRÜNLER</div>
            </div>
            <div class="row mt-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 productlist">
                        
			        <?php 
				$benzerurunadi = $page['adi'];
				$benzerurunler = $ozy->query("select * from urunler where durum='1' and adi like '%$adi%' ORDER BY RAND() limit 5")->fetchAll(PDO::FETCH_ASSOC);
				foreach ($benzerurunler as $katurunler) {?>			
						
						  <div class="col">
                            <div class="item">
                                <div class="img">
                                <span class="d-flex bdgs">
								    <?php if($katurunler['ucretsizkargo']=='1'){?>
                                    <span class="bdg green">Ücretsiz Kargo!</span>
									<?php } ?> 
									<?php if($katurunler['idurum']=='1'){?>
                                    <span class="bdg orange">%<?php echo yuzdeHesaplama($katurunler['fiyat'],$katurunler['ifiyat']);?> İndirimli</span>    
                                    <?php } ?> 
									</span>
                                    <a href="urun/<?php echo $katurunler['seo']; ?>">
                                        <img src="resimler/urunler/<?php echo $katurunler['resim']; ?>" width="238" height="175" class="img-fluid" alt="">
                                    </a>
                                </div>
                                <a href="urun/<?php echo $katurunler['seo']; ?>" class="title"><h3><?php echo $katurunler['adi']; ?></h3></a>
                                <div class="pb">
                                    <?php echo xurunfiyatbelirle($katurunler['kdv'],$katurunler['idurum'],$katurunler['fiyat'],$katurunler['ifiyat']);?>
                                    <a href="urun/<?php echo $katurunler['seo']; ?>" class="addcart">SEPETE EKLE</a>
                                </div>
                            </div>
                        </div>
						
				  
						
					<?php } ?>			
						
						
                            </div>
        </div>
    </section>
	
	<style>
	.size-item {
 position:relative;
 margin-right:5px;
 margin-bottom:10px;
 cursor:pointer;
 -webkit-user-select:none;
 -moz-user-select:none;
 -ms-user-select:none;
 user-select:none;
 width: 10%;
float: left;
display: block;
margin-top: 10px;

}
.size-item .size-slt-box {

 position:relative;
 border:1px solid #fff;
 text-align:center;
 padding:8px 14px;
 color:#000;
 -webkit-box-shadow:0 0 2px 0 rgba(50,50,50,0);
 box-shadow:0 0 2px 0 rgba(50,50,50,0);
 background: white;
}
.size-item .size-slt-box .size-last {
 position:absolute;
 top:-7px;
 right:-5px;
 font-size:10px;
 line-height:12px;
 height:13px;
 font-weight:700;
 text-align:center;
 background:#e82222;
 padding:0 4px;
 color:#fff;
 border-radius:8px;
 display:block
}
.size-item input {
 position:absolute;
 opacity:0;
 cursor:pointer
}
.size-item input:checked~.size-slt-box {
 background: #ff6f38;
 color: white;
}
.size-item input[available="0"]~.size-slt-box {
 color:#a6a6a6;
 background:linear-gradient(to top right,#fff calc(50% - 1px),#d3d3d3,#fff calc(50% + 1px))
}
.size-item input:not([available="0"])~.size-slt-box:hover {
 background: #e1a635;
 color: #fff;
}
.form-control:disabled, .form-control[readonly] {
  background-color: #e9ecef;
  opacity: 0 !important;
}
	</style>
  