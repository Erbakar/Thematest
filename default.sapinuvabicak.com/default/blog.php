<title>Blog</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Blog<span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
            

                    <div class="entry-container" style="position: relative; height: 1140px;">
                        
							<?php 

     
        $pages = intval(temizle(@$_GET['pages']));
        if (!$pages) {
          $pages = 1;
        }
        
        $bak = $ozy->prepare("select * from haberler where durum='1'");
        $bak->execute(array());
        $toplam= $bak->rowCount();
        $limit = 15;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 200;
		
	
	
        $pr = $ozy->query("select * from haberler where durum='1' order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
        



        $__URUN__ = false;
       foreach ($pr as $blog) {
        $__URUN__ = true;

                           ?>
						
						<div class="entry-item lifestyle shopping col-sm-6 col-lg-4">
                            <article class="entry entry-mask">
                                <figure class="entry-media">
                                    <a href="blog/<?php echo $blog['seo']; ?>">
                                        <img class="lazyload"  style="width: 376px;height: 250px;" data-src="resimler/haberler/<?php echo $blog['resim']; ?>" alt="image desc">
                                    </a>
                                </figure><!-- End .entry-media -->

                                <div class="entry-body">
                                    <div class="entry-meta">
                                        <a><?php echo $blog['tarih']; ?></a>
                                        <span class="meta-separator">|</span>
                                        <a><?php 
								      $sayfaid = $blog['id'];
								      $urunyorumsayisi = $ozy->prepare("SELECT COUNT(*) FROM tumyorumlar where sayfaid='$sayfaid' and konu='blog' and durum='1'");
                                      $urunyorumsayisi->execute();
                                      $urunyorumsayimis = $urunyorumsayisi->fetchColumn();?>
                                        ( <?php echo $urunyorumsayimis;?> Yorum )</a>
                                    </div><!-- End .entry-meta -->

                                    <h2 class="entry-title">
                                        <a href="blog/<?php echo $blog['seo']; ?>"><?php echo $blog['adi']; ?></a>
                                    </h2><!-- End .entry-title -->

                                    <div class="entry-cats">
                                        <?php echo $blog['hit']; ?> defa okundu
                                      
                                    </div><!-- End .entry-cats -->
                                </div><!-- End .entry-body -->
                            </article><!-- End .entry -->
                        </div><!-- End .entry-item -->

               <?php }

                        if (!$__URUN__){
                            echo "Henüz blog eklenmemiş.";
                        }

                         ?>		      
					 
					 
					 
                    </div><!-- End .entry-container -->

                    <div class="mb-3"></div><!-- End .mb-3 -->

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
						<?php $geri = $_GET['pages']-1;?>
                            <li class="page-item  <?php echo $_GET['pages'] == '1' ? 'disabled' : null; ?>">
                                <a class="page-link page-link-prev" href="bloglar/?pages=<?php echo $geri;?>" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Geri
                                </a>
                            </li>
							 <?php
                for ($i= $pages - $forlimit ; $i < $pages + $forlimit + 1 ; $i++) { 
                  if ($i>0 and $i<=$sayfasayisi) {
                    
                    if ($i == $pages) {
          
                  echo "<li class='page-item active' aria-current='page'><a>".$i."</a></li>
				 
				  ";
                                      
                             }else{
          
                  echo "<li class='page-item'><a class='page-link' href='bloglar/?pages=".$i."'>".$i."</a></li>";
          
          }

                  }
                }
          
          
          
          
                   ?> 
             
						
                      
							
                            <li class="page-item">
							<?php $ileri = 1+$_GET['pages'];?>
                                <a class="page-link page-link-next" href="bloglar/?pages=<?php echo $ileri;?>" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                   İleri <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div><!-- End .container -->
            </div>
        </main>