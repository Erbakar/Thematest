<title>Banka Hesaplarımız</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		   <main class="main">
        	
   

            <div class="page-content pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="about-text text-left">
                           <div class="row">
						   
        <?php 
		$bankaoku = $ozy->query("select * from bankahesaplari where durum='1' order by sira DESC")->fetchAll(PDO::FETCH_ASSOC);
		$__BANKA__ = false;
        foreach ($bankaoku as $banka) {
        $__BANKA__ = true;?>						   
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="background:white;border: 1px solid #ede4e4;border-radius: 16px;">
<div class="bank-acc">
<div class="row">


<img style="width: 380px;height: 250px;"src="resimler/bankalar/<?php echo $banka['resim'];?>" class="bank-logo">


<div class="col-lg-12 col-md-12 col-xs-12" style="padding: 15px;">
<div class="bank_info_line"><div class="row"><div class="col-lg-5 col-md-4 col-sm-3 col-xs-3 padr0"><strong>Adı Soyadı :</strong> </div><div class="col-lg-7 col-md-8 col-sm-9 col-xs-9"> <?php echo $banka['alici'];?></div></div></div>
<div class="bank_info_line"><div class="row"><div class="col-lg-5 col-md-4 col-sm-3 col-xs-3 padr0"><strong>Şube Adı & Kodu :</strong> </div><div class="col-lg-7 col-md-8 col-sm-9 col-xs-9"> <?php echo $banka['sube'];?> & <?php echo $banka['kod'];?> </div></div></div>
<div class="bank_info_line"><div class="row"><div class="col-lg-5 col-md-4 col-sm-3 col-xs-3 padr0"><strong> Hesap No :</strong></div><div class="col-lg-7 col-md-8 col-sm-9 col-xs-9"> <?php echo $banka['hesap'];?> </div></div></div>
<div class="bank_info_line"><div class="row"><div class="col-lg-3 col-md-4 col-sm-3 col-xs-3 padr0"><strong> IBAN :</strong></div><div class="col-lg-9 col-md-8 col-sm-9 col-xs-9"> <?php echo $banka['iban'];?> </div></div></div>
</div>
</div>
</div>
</div>


   <?php }

                        if (!$__BANKA__){
                            echo '
							
						              <p> Henüz bir banka hesabı eklenmemiştir.</p>
								    	
										
							
							
							';
                        }

                         ?>	




</div>
                            </div><!-- End .about-text -->
                        </div><!-- End .col-lg-10 offset-1 -->
                    </div><!-- End .row -->
                    
                </div><!-- End .container -->

                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>