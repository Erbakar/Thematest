<title>Banka Hesaplarımız</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Banka Hesaplarımız<span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Banka Hesaplarımız</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

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
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="border: 1px solid #ede4e4;border-radius: 4px;">
<div class="bank-acc">
<div class="row">
<div class="col-lg-12 col-md-12 col-xs-12">
<div class="bank-img">
<img src="resimler/bankalar/<?php echo $banka['resim'];?>" class="bank-logo">
</div>
</div>
<div class="col-lg-12 col-md-12 col-xs-12">
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