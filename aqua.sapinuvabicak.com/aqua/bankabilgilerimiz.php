<title>Banka Hesaplarımız</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>



      <section class="cover pt-5 pb-5">
        <div class="container-lg">
            <h2>Banka Hesaplarımız</h2>
        </div>
    </section>
 
  <section class="banner mt-5" style="margin-bottom:30px;">
            <div class="container-lg">
              
                <div class="row">
					<div class="col-sm-12 customer-login" style="text-align: center;border: 1px solid #d4d2d2;padding: 10px;">
						
						
						 <?php 
		$bankaoku = $ozy->query("select * from bankahesaplari where durum='1' order by sira DESC")->fetchAll(PDO::FETCH_ASSOC);
		$__BANKA__ = false;
        foreach ($bankaoku as $banka) {
        $__BANKA__ = true;?>						   
<div class="col-lg-4 col-md-4" style="border: 1px solid #ede4e4;border-radius: 4px;float: left;background: white;">
<div class="bank-acc">
<div class="row">
<div class="col-lg-12 col-md-12 col-xs-12" >
<div class="bank-img">
<img style="height: 200px;" src="resimler/bankalar/<?php echo $banka['resim'];?>" class="bank-logo">
</div>
</div>
<div class="col-lg-12 col-md-12 col-xs-12" style="  padding: 10px;text-align: left;font-weight: 500;
padding-left: 17%;">
<div class="bank_info_line"><div class="row"><div class="col-lg-12"><strong>Adı Soyadı : </strong> <?php echo $banka['alici'];?></div> </div></div>
<div class="bank_info_line"><div class="row"><div class="col-lg-12"><strong>Şube Adı & Kodu :</strong> <?php echo $banka['sube'];?> & <?php echo $banka['kod'];?></div><div class="col-lg-7 col-md-8 col-sm-9 col-xs-9">  </div></div></div>
<div class="bank_info_line"><div class="row"><div class="col-lg-12"><strong> Hesap No :</strong><?php echo $banka['hesap'];?> </div><div class="col-lg-7 col-md-8 col-sm-9 col-xs-9"> </div></div></div>
<div class="bank_info_line"><div class="row"><div class="col-lg-12"><strong> IBAN :</strong><?php echo $banka['iban'];?></div><div class="col-lg-9 col-md-8 col-sm-9 col-xs-9">  </div></div></div>
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
						
	<style>
.bank_info_line {
 margin-bottom: 5px;
}
	
</style>	
								</div>
			    
                </div>
            </div>
        </section>