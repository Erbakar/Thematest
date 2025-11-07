<?php
$id = temizle($_GET['id']);
$query = $ozy->prepare("UPDATE haberler SET hit = (hit+1) WHERE seo=?");
$update = $query->execute(array($id));
?>

<?php 
$id = temizle($_GET['id']); 
$durum = "1";
$sayfaqq = $ozy->prepare("SELECT * FROM haberler WHERE seo=:id and durum=:durum");
$page = $sayfaqq->execute([':id' => $id,':durum' => $durum]);
$page = $sayfaqq->fetch(PDO::FETCH_ASSOC);

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
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title"><?php echo $page['adi'];?><span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $page['adi'];?></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
<div class="page-content">

                <div class="container">
                    <article class="entry single-entry entry-fullwidth">
                        <div class="row">
                            <div class="col-lg-11">
                                <div class="entry-body">
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

                                    <h2 class="entry-title entry-title-big">
                                        <?php echo $page['adi'];?>
                                    </h2><!-- End .entry-title -->
                                <a class="image-popup-no-margins" href="resimler/haberler/<?php echo $page['resim']?>">
								<img class="lazyload"  data-src="resimler/haberler/<?php echo $page['resim'];?>" alt="signature" class="mx-auto mb-5" <?php echo $page['resim'] == 'resimyok.jpg' ? 'style="display:none;"' : null; ?>>
								<p><?php echo $page['aciklama'];?> </p>
                                </a>
                                   
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
						<a class="image-popup-no-margins" href="resimler/genel/<?php echo $genelresim['sayfaresim'];?>">		
                              <img class="lazyload"  style="width: 370px;height: 247px;" data-src="resimler/genel/<?php echo $genelresim['sayfaresim'];?>" alt="image" class="mx-auto mb-6"></div><!-- End .icon-box -->
                        </a>
						</div><!-- End .col-lg-4 col-sm-6 -->
                    <?php } ?>
					 
					 
                    </div><!-- End .row -->
                                        </div><!-- End .entry-content -->

                                    <div class="entry-footer row no-gutters">
                                        <div class="col">
                                            <div class="entry-tags">
                                                <span>Etiketler:</span> 
												<?php 
										
										$urunozellikler = $page['skey'];

										$urunozellikler = explode(',', $urunozellikler);

										foreach( $urunozellikler as $uanahtar => $udeger ){?>
												<a><?php echo $udeger;?></a> 
											<?php } ?>
												
												
												
                                            </div><!-- End .entry-tags -->
                                        </div><!-- End .col -->
                                    </div><!-- End .entry-footer row no-gutters -->
                                </div><!-- End .entry-body -->
                            </div><!-- End .col-lg-11 -->

                            <div class="col-lg-1 order-lg-first mb-2 mb-lg-0">
                                <div class="sticky-content" style="">
                                    <div class="social-icons social-icons-colored social-icons-vertical">
                                        <span class="social-label">PAYLAŞ:</span>
                                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url;?>/blog/<?php echo $page['seo']; ?>" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a> 
                                    
                                        <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo $url;?>/blog/<?php echo $page['seo']; ?>" class="social-icon" title="X" target="_blank"><img src="resimler/siteayarlari/x.png" alt="X" style="width:16px; height:16px;"></a>
                                        <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $ayar['whatsapp']; ?>&amp;text=<?php echo $page['adi']; ?>%20hakkinda%20bilgi%20istiyorum. <?php echo $url;?>/blog/<?php echo $page['seo']; ?>"   style="background: #0dd00d;color: white;"class="social-icon social-whatsapp" title="whatsapp" target="_blank"><i class="icon-whatsapp"></i></a>
                                        <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url;?>/blog/<?php echo $page['seo']; ?>" class="social-icon social-linkedin" title="Linkedin" target="_blank"><i class="icon-linkedin"></i></a>
                            
									</div><!-- End .soial-icons -->
                                </div><!-- End .sticky-content -->
                            </div><!-- End .col-lg-1 -->
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
                        <h3 class="title"><?php echo $urunyorumsayimis;?> Yorum</h3><!-- End .title -->
                    <?php } else { ?>
					<h3 class="title">Bu yazıya henüz yorum yapılmamış. İlk yorumu sen yapmak ister misin ?</h3><!-- End .title -->
					<?php } ?>	

                                <ul>
								
								
				<?php 
				$blogid = $page['id'];
				$deneme = $ozy->query("select * from tumyorumlar where durum='1' and sayfaid='$blogid' and konu='blog' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($deneme as $blogyorum) {?>			
								
                                <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                
                                                
                                                <span class="review-date"><?php echo $blogyorum['tarih']; ?></span>
                                            </div><!-- End .col -->
                                            <div class="col">
                                               <h4><a><?php echo $blogyorum['adi']; ?></a></h4>

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
                                                            <img class="lazyload"  data-src="resimler/siteayarlari/<?php echo $ayar['logo']; ?>" alt="User name">
                                                        </a>
                                                    </figure>

                                                    <div class="comment-body">
                                                        <div class="comment-user">
                                                            <h4><a><?php echo $ayar['siteadi']; ?></a></h4>
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
					
					
                    <div class="reply">
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
                            <button type="submit" name="blogyorum" class="btn btn-outline-primary-2">
                                <span>YORUMU GÖNDER</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </form>
                    </div><!-- End .reply -->
                </div><!-- End .container -->
            </div>
        
        </main>