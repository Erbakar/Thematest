<title>Sıkça Sorulan Sorular</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
	   
      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Sıkça Sorulan Sorular</h2>
        </div>
    </section>
<section class="page pt-5 pb-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <div class="accordion" id="patiAccordion">
				 <?php $ss = $ozy->query("select * from sss where durum='1' order by sira desc limit 1")->fetchAll(PDO::FETCH_ASSOC); 
                            foreach($ss as $sss){?>    
									
					
					
                    <div class="accordion-item">
                                <h2 class="accordion-header" id="heading0<?php echo $sss['id']; ?> ">
                                    <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapse0">
                                       <?php echo $sss['adi']; ?>                                </button>
                                </h2>
                                <div id="collapse0" class="accordion-collapse collapse show" aria-labelledby="heading0<?php echo $sss['id']; ?> " data-bs-parent="#patiAccordion">
                                    <div class="accordion-body">
                                     <?php echo $sss['aciklama']; ?>
									 </div>
                                </div>
                    </div>
					<?php } ?>		
                     
					 
					 
	 <?php 
	 $i =1;
	 $ss = $ozy->query("select * from sss where durum='1' order by sira desc limit 1,1000")->fetchAll(PDO::FETCH_ASSOC); 
                            foreach($ss as $sss){?>    
									
					
					
                    <div class="accordion-item">
                                <h2 class="accordion-header" id="heading0<?php echo $sss['id']; ?> ">
                                    <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i;?>" aria-expanded="true" aria-controls="collapse<?php echo $i;?>">
                                       <?php echo $sss['adi']; ?>                                </button>
                                </h2>
                                <div id="collapse<?php echo $i;?>" class="accordion-collapse collapse" aria-labelledby="heading0<?php echo $sss['id']; ?> " data-bs-parent="#patiAccordion">
                                    <div class="accordion-body">
                                     <?php echo $sss['aciklama']; ?>
									 </div>
                                </div>
                    </div>
					<?php } ?>	

					
                                            </div>
                </div>
            </div>
        </div>
    </section>
 