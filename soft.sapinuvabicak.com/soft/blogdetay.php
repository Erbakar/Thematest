<?php
// SEO değerini doğrudan al, temizleme SEO'yu bozabilir
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
$id = urldecode($id); // URL decode yap

$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM haberler WHERE seo=:id and durum=:durum");
$sayfaqq->execute([':id' => $id,':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

// Blog bulunamazsa 404 sayfasına yönlendir
if(!$page || empty($page)){
    header("Location: " . $url . "/404");
    exit;
}

// Blog bulundu, şimdi hit'i güncelle
$query = $ozy->prepare("UPDATE haberler SET hit = (hit+1) WHERE seo=?");
$query->execute(array($id));

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
	   
		   <main class="main">
        	
          
<div class="page-content" style="margin-top:10px;">

                <div class="container">
                    <article class="entry single-entry entry-fullwidth">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="entry-body">
                                 

                                    <h5 style="font-size: 15px;" class="entry-title entry-title-big">
                                        <?php echo $page['adi'];?>
                                    </h5><!-- End .entry-title -->
                                <a data-lightbox="image-1" href="resimler/haberler/<?php echo $page['resim']?>">
								<img class="lazyload" style="width: 100%;" data-src="resimler/haberler/<?php echo $page['resim'];?>" alt="signature" class="mx-auto mb-5" <?php echo $page['resim'] == 'resimyok.jpg' ? 'style="display:none;"' : null; ?>>
								   <div class="entry-meta">
                                        <span class="entry-author">
                                            <?php echo $page['tarih'];?>
                                        </span>
                                        <span class="meta-separator">|</span>
                                        <?php echo $page['hit'];?> defa okundu
                                        <span class="meta-separator">|</span>
                                        <?php 
								      $sayfaid = $page['id'];
								      $urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='blog' and durum='1'");
                                      $urunyorumsayisi->execute();
                                      $urunyorumsayimis = $urunyorumsayisi->fetchColumn();?>
                                        ( <?php echo $urunyorumsayimis;?> Yorum )
                                    </div><!-- End .entry-meta -->
								   </a>
                                   
								<p><?php echo $page['aciklama'];?> </p>
                             
                                    <div class="entry-content editor-content">
                                     <?php echo $page['aciklama'];?>
                                        <div class="pb-1"></div><!-- End .pb-1 -->
                    <div class="row justify-content-left">
					
					
			        <?php 
					$gelenid = $page['id'];
					$sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='haberler' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                    foreach($sayfaresimi as $genelresim){?>
                        <div class="col-lg-4 col-sm-6">
                            <div class="icon-box icon-box-sm text-center">
						<a data-lightbox="image-1" href="resimler/genel/<?php echo $genelresim['sayfaresim'];?>">		
                              <img class="lazyload"  style="width: 370px;height: 247px;" data-src="resimler/genel/<?php echo $genelresim['sayfaresim'];?>" alt="image" class="mx-auto mb-6"></div><!-- End .icon-box -->
                        </a>
						</div><!-- End .col-lg-4 col-sm-6 -->
                    <?php } ?>
					 
					 
                    </div><!-- End .row -->
					
					    <div class="entry-tags">
                                                <span>Etiketler:</span> 
												<?php 
										
										$urunozellikler = $page['skey'];

										$urunozellikler = explode(',', $urunozellikler);

										foreach( $urunozellikler as $uanahtar => $udeger ){?>
												<a><?php echo $udeger;?></a> 
											<?php } ?>
												
												
												
                                            </div><!-- End .entry-tags -->
					
					
					
                                        </div><!-- End .entry-content -->

                                  
                                </div><!-- End .entry-body -->
                            </div><!-- End .col-lg-11 -->

                        
                        </div><!-- End .row -->

                      
                    </article><!-- End .entry -->

                    <nav class="pager-nav" aria-label="Page navigation">
					    <?php 
						$id = $page['id'];
						$a3kz = $ozy->query("select * from haberler where durum='1' and id< $id order by id desc limit 1")->fetchAll(PDO::FETCH_ASSOC); 
                        foreach($a3kz as $a33kz){?>	
                        <a class="pager-link pager-link-prev" href="blog/<?php echo $a33kz['adi']; ?>" aria-label="Previous" tabindex="-1">
                            Önceki Yazı
                            <span class="pager-link-title"><?php echo $a33kz['adi']; ?></span>
                        </a>
                        <?php } ?>	
						
						<?php 
						$idz = $page['id'];
						$a3kzz = $ozy->query("select * from haberler where durum='1' and id> $idz order by id desc limit 1")->fetchAll(PDO::FETCH_ASSOC); 
                        foreach($a3kzz as $a33kzz){?>	
                        <a class="pager-link pager-link-next" href="blog/<?php echo $a33kzz['seo']; ?>" aria-label="Next" tabindex="-1">
                            Sonraki Yazı
                            <span class="pager-link-title"><?php echo $a33kzz['adi']; ?></span>
                        </a>
						<?php } ?>	
						
                    </nav><!-- End .pager-nav -->

        
					
					<div class="comments">
                    <?php if($urunyorumsayimis>'0'){?>
                        
                    <?php } else { ?>
					<h4 style="font-size: 15px;" class="title">Bu yazıya henüz yorum yapılmamış. İlk yorumu sen yapmak ister misin ?</h4><!-- End .title -->
					<?php } ?>	

                                <ul style="border: 1px solid <?php echo $tema['t8']; ?>;
padding: 10px !important;
margin-top: 10px;
border-radius: 6px;">
								
								
				<?php 
				$blogid = $page['id'];
				$deneme = $ozy->query("select * from tumyorumlar where durum='1' and sayfaid='$blogid' and konu='blog' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($deneme as $blogyorum) {?>			
								
                                <div class="review">
                                        <div class="row no-gutters">
                                            
                                            <div class="col">
                                               <h4 style="font-size: 15px;"><a><?php echo $blogyorum['adi']; ?></a></h4>

                                                <div class="review-content">
                                                    <p><?php echo $blogyorum['yorum']; ?></p>
                                                </div><!-- End .review-content -->

                                        <?php 
									$karakter_sayisi = strlen($blogyorum['cevap']);
									
									if($karakter_sayisi>'1'){?>
                                                <div class="review-action" style="padding: 20px;border: 1px solid #f1ecec;border-radius: 4px;">
                                                
												<div class="comment">
                                                    <figure class="comment-media">
                                                        <a href="<?php echo  $url;?>">
                                                            <img class="lazyload" style="width: 100px;" data-src="resimler/siteayarlari/<?php echo $ayar['logo']; ?>" alt="User name">
                                                        </a>
                                                    </figure>

                                                    <div class="comment-body">
                                                        <div class="comment-user">
                                                            <h6><a><?php echo $ayar['siteadi']; ?></a></h6>
                                                            <span class="comment-date"><?php echo $blogyorum['email']; ?></span>
                                                        </div><!-- End .comment-user -->

                                                        <div class="comment-content">
                                                            <p><?php echo $blogyorum['cevap']; ?></p>
                                                        </div><!-- End .comment-content -->
                                                    </div><!-- End .comment-body -->
                                                </div><!-- End .comment -->
												
												
												</div><!-- End .review-action -->
												
												<?php } ?>
												
                                            </div><!-- End .col-auto -->
                                        </div><!-- End .row -->
                                    </div> 


                       <?php } ?>
								 
								 
								 
								 
								 
								 
								 
								 
								 
                                </ul>
                            </div>
					
					
                    <div class="reply" style="border: 1px solid #c1c1c1;
padding: 10px;
border-radius: 6px;">
                        <div class="heading">
                            <h3 class="title">Yorum Yaz</h3><!-- End .title -->
                            <p class="title-desc" style="color: #d81818;border: 1px solid #d81818;padding: 10px;font-size: 14px;border-radius: 6px;">Eposta adresiniz gizlilik nedeniyle görünmeyecektir. * Argo , küfür veya hukuka aykırı yorumlar onaylanmayacaktır.
							Bu tarz yorum yapanlar hakkında yasal süreç başlatılacaktır.
							</p>
                        </div><!-- End .heading -->

                        <form action="" method="POST">
                            <label for="reply-message" class="sr-only">Yorumunuz</label>
                            <textarea name="yorum" id="reply-message" cols="30" rows="4" class="form-control" required="" placeholder="Yorumunuz *"></textarea>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="reply-name" class="sr-only">Adınız Soyadınız</label>
                                    <input type="text" class="form-control" id="reply-name" name="adi" required="" placeholder="Adınız Soyadınız *" value="<?php echo $uyebilgileri['isim'];?>">
                                </div><!-- End .col-md-6 -->

                                <div class="col-md-6">
                                    <label for="reply-email" class="sr-only">Eposta Adresiniz</label>
                                    <input type="email" class="form-control" id="reply-email" name="email" required="" placeholder="Eposta Adresiniz *" value="<?php echo $uyebilgileri['email'];?>">
                                </div><!-- End .col-md-6 -->
                            </div><!-- End .row -->
                            <input type="hidden" name="sayfaid" value="<?php echo $page['id'];?>"/>
                            <button style="margin-bottom:15px;" type="submit" name="blogyorum" class="butonok btn btn-outline-primary-2">
                                <span>YORUMU GÖNDER</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </form>
                    </div><!-- End .reply -->
                </div><!-- End .container -->
            </div>
        
        </main>