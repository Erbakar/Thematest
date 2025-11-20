<title>Kampanyalar</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		  <div class="cl-width-limiter">
        
        

    <div class="campaigns-page cl-static-page">
        <h1>Kampanyalar</h1>
        <div class="campaigns-page-card-container">
		
		                
							<?php 

     
        $pages = intval(temizle(@$_GET['pages']));
        if (!$pages) {
          $pages = 1;
        }
        
        $bak = $ozy->prepare("select * from kampanyalar where durum='1'");
        $bak->execute(array());
        $toplam= $bak->rowCount();
        $limit = 15;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 200;
		
	
	
        $pr = $ozy->query("select * from kampanyalar where durum='1' order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
        



        $__URUN__ = false;
       foreach ($pr as $blog) {
        $__URUN__ = true;

                           ?>
		
                <div class="campaigns-page-card">
                    <div class="campaigns-page-card-image" style="background-image: url('resimler/kampanyalar/<?php echo $blog['resim']; ?>') !important;"></div>
                    <span><?php echo $blog['adi']; ?></span>
                    <span class="campaigns-page-card-icon" onclick="location.href=' <?php if($blog['link']=='0'){?>kampanya/<?php echo $blog['seo']; ?><?php } else { ?><?php echo $blog['link']; ?><?php } ?>'">İncele</span> 
					<span class="campaign-detail-button cl-fancy-caller" data-src="#tag1627945967819<?php echo $blog['id']; ?>">Detay</span>
                    <div id="tag1627945967819<?php echo $blog['id']; ?>" class="campaign-detail cl-fancy-popup" style="display: none;">
                        <div class="modal-header">
                            <h3>Kampanya detayları</h3>
                        </div>
                        <div class="modal-body">
                            <p><?php echo $blog['adi']; ?></p>
                            <ul>
                            <?php echo $blog['aciklama']; ?>
                            </ul>
                        </div>
                    </div>
                </div>
               
                
               <?php }

                        if (!$__URUN__){
                            echo "Henüz blog eklenmemiş.";
                        }

                         ?>		      
					 
              
			  
			  
			  
			  
        </div>
    </div>



     <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
						<?php $geri = $_GET['pages']-1;?>
                            <li class="page-item  <?php echo $_GET['pages'] == '1' ? 'disabled' : null; ?>">
                                <a class="page-link page-link-prev" href="kampanyalar/?pages=<?php echo $geri;?>" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Geri
                                </a>
                            </li>
							 <?php
                for ($i= $pages - $forlimit ; $i < $pages + $forlimit + 1 ; $i++) { 
                  if ($i>0 and $i<=$sayfasayisi) {
                    
                    if ($i == $pages) {
          
                  echo "<li class='page-item active' aria-current='page'><a class='page-link'>".$i."</a></li>
				 
				  ";
                                      
                             }else{
          
                  echo "<li class='page-item'><a class='page-link' href='kampanyalar/?pages=".$i."'>".$i."</a></li>";
          
          }

                  }
                }
          
          
          
          
                   ?> 
             
						
                      
							
                            <li class="page-item">
							<?php $ileri = 1+$_GET['pages'];?>
                                <a class="page-link page-link-next" href="kampanyalar/?pages=<?php echo $ileri;?>" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                   İleri <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>

        
    </div>