<title>Sipariş Sorgulama</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
		   <main class="main">
        	
  
		
            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
                      <?php if (isset($_GET['siparissorgulama'])) { 
                            $sipno = temizle($_GET['sipno']);?>
                       <?php  $pr = $ozy->query("select * from siparis where onay='1' and siparisno='{$sipno}' order by id DESC limit 1")->fetchAll(PDO::FETCH_ASSOC);
                              $__URUN__ = false;
                              foreach ($pr as $sip) {
                              $__URUN__ = true;?>    

     
        <div class="panel panel-default">
         
            <div class="col-12">

    <article class="card">
       
        <div class="card-body">
            <h6 style="padding: 10px;">Sipariş Kodunuz : <?php echo $sip['siparisno'];?></h6>
            <article class="card">
                <div class="card-body row">
                    <div class="col"> <strong>Sipariş Tarihi:</strong> <br><?php echo $sip['tarih'];?></div>
                    <div class="col"> <strong>Sipariş Durumu:</strong> <br> <?php echo $sip['durum'];?></div>
                    <?php if($sip['ekdurum']=='1'){?>
					<div class="col" style="color:red"> <strong>Yönetici Notu:</strong> <br> <?php echo $sip['eknot']; ?> </div>
                    <?php } else { ?>
					<div class="col"> <strong>Toplam Ödenen Tutar:</strong> <br> <?php echo $sip['toplamtutar']; ?> TL</div>  
					<?php } ?>
					<?php if($sip['kargoid']>'0'){?>
					<?php 
					$kargoidm = $sip['kargoid'];
					$kargomnerede = $ozy->query("select * from kargolar where id='$kargoidm'")->fetch(PDO::FETCH_ASSOC);?>
					<div class="col"> <strong>Kargo Takip :</strong> <br><?php echo $kargomnerede['adi'];?> - <a target="_blank" href="<?php echo $kargomnerede['link'];?><?php echo $sip['takipno']; ?>"><?php echo $sip['takipno']; ?></a> </div>
					<?php } ?>
                </div>
            </article>
             <div class="track">
                <div class="step <?php echo $sip['durum'] == 'Sipariş Onaylandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Hazırlandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Siparişiniz Onaylandı</span> </div>
                <div class="step <?php echo $sip['durum'] == 'Sipariş Hazırlandı' ? 'active' : null; ?><?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Siparişiniz Hazırlanıyor</span> </div>
                <div class="step <?php echo $sip['durum'] == 'Kargoya Verildi' ? 'active' : null; ?><?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Kargoya Verildi </span> </div>
                <div class="step <?php echo $sip['durum'] == 'Sipariş Tamamlandı' ? 'active' : null; ?>"> <span class="icon"> <i class="fa fa-home"></i> </span> <span class="text">Siparişiniz Tamamlandı</span> </div>
            </div>
            <hr>
       </div>
    </article>


				
			
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12" id="divYazdir">
                                    <div class="invoice-title">
                                        <h4 class="float-right font-12"><strong style="font-weight: 400;font-size: 14px;line-height: 70px;">Sipariş Kodu : <?php echo $sip['siparisno'];?></strong></h4>
                                        <h3 class="m-t-0" style="margin-bottom: -15px !important;">
                                            <img style="width: 200px;height:80px;" src="resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="logo" height="24">
                                        </h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <address>
                                                <strong style="font-weight: 500;">Alıcı Bilgileri:</strong><br>
                                                <?php echo $sip['adsoyad'];?><br>
                                                <?php echo $sip['telefon'];?><br>
                                                <?php echo $sip['email'];?><br>
												<?php echo $sip['adres'];?> <?php echo $sip['il'];?> / <?php echo $sip['ilce'];?><br>
                                            </address>
                                        </div>
                                        <div class="col-6 text-right">
                                            <address>
                                                <strong style="font-weight: 500;">Fatura Bilgileri:</strong><br>
                                                
                                                <?php if($sip['uyetip']=='1'){?> Kurumsal Üye
                                                <?php } else { ?> Bireysel Üye
												<?php } ?>
												<br>
                                                <?php echo $sip['vergibilgileri'];?><br>
                                               <?php echo $sip['faturaadres'];?> <?php echo $sip['faturail'];?> / <?php echo $sip['faturailce'];?>
                                            </address>
                                        </div>
                                    </div>
									
									<div class="row" style="margin:auto;margin: auto;
background: <?php echo $tema['t8']; ?>;
color: white;
text-align: center;
padding: 10px;">
                                    <div class="col-12 m-t-10">
                                            <address>
                                                <strong style="font-weight: 500;">Bırakılan Not:</strong><br>
                                                <?php echo $sip['mesaj'];?><br>
                                            </address>
                                        </div>
									 </div>
									
                                    <div class="row">
                                        <div class="col-6 m-t-30">
                                            <address>
                                                <strong style="font-weight: 500;">Ödeme Bilgileri:</strong><br>
                                                <?php echo $sip['odemetipi'];?><br>
                                               <span style="font-size: 13px;" class="badge badge-success"><?php echo $sip['durum'];?></span>
                                            </address>
                                        </div>
                                        <div class="col-6 m-t-30 text-right">
                                            <address>
                                                 <strong style="font-weight: 500;">Sipariş Oluşturulma Tarihi:</strong><br>
                                                <?php echo $sip['tarih'];?><br><br>
                                            </address>
                                        </div>
                                    </div>
                         
                                    <div class="panel panel-default" style="border: 1px solid #f2f2f2;padding: 5px;">
                                        <div class="p-2">
                                            <h3 class="panel-title font-20" style="font-size: 16px;"> <strong style="font-weight: 500;">Sipariş Detayları</strong></h3>
                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <td><strong>Ürün</strong></td>
                                                        <td class="text-center"><strong>Birim Fiyatı</strong></td>
														<td class="text-center"><strong>KDV</strong></td>
                                                        <td class="text-center"><strong>Adet</strong>
                                                        </td>
                                                        <td class="text-right"><strong>Toplam</strong></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                    
													
                                                    <?php echo $sip['uruntablo'];?>
													
													
													
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
														
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                         <strong>Aratutar :</strong></td>
                                                        <td class="thick-line text-right"><?php echo fiyatgoster($sip['aratutar']);?></td>
                                                    </tr>
													  <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
													
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                        <strong>KDV Bedeli :</strong></td>
                                                        <td class="thick-line text-right"><?php echo fiyatgoster($sip['kdvtutari']);?></td>
                                                    </tr>
													
													 <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
													
                                                       <td class="thick-line text-left" style="text-align: left !important;">
                                                          <strong>Kargo Bedeli</strong></td>
                                                        <td class="no-line text-right"><?php echo fiyatgoster($sip['kargotutari']);?></td>
                                                    </tr>
													
													<?php if($sip['kuponid']!='0'){?>
                                                
												    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
													
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                           <strong style="color:red;">Kupon Bedeli :</strong></td>
                                                        <td class="thick-line text-right">- <?php echo fiyatgoster($sip['kupontutari']);?></td>
                                                    </tr>	
                                                    <?php } ?>
													<?php if($sip['cekid']!='0'){?>
                                                
												    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
													
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                            <strong style="color:red;">Hediye Çeki Bedeli :</strong></td>
                                                        <td class="thick-line text-right">- <?php echo fiyatgoster($sip['cektutari']);?></td>
                                                    </tr>	
                                                    <?php } ?>
													
													<?php if($sip['havaleindirimtutari']!='0'){?>
                                                
												    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
														
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                           <strong style="color:red;">Havale/EFT İndirim Bedeli :</strong></td>
                                                        <td class="thick-line text-right">- <?php echo fiyatgoster($sip['havaleindirimtutari']);?></td>
                                                    </tr>	
                                                    <?php } ?>
													
													
                                                  
                                                    <tr>
                                                        <td class="no-line"></td>
														<td class="no-line"></td>
                                                     
                                                        <td class="thick-line text-left" style="text-align: left !important;">
                                                           <strong>Ödenecek Tutar</strong></td>
                                                        <td class="no-line text-right"><h4 class="m-0" style="font-size: 14px;"><?php echo fiyatgoster($sip['toplamtutar']);?></h4></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="d-print-none">
                                                <div class="float-right">
                                                 <a class="butonok btn btn-primary waves-effect waves-light" href="javascript:printDiv('divYazdir');">Siparişi Yazdır</a>
												
												</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div>
			
			
			
        </div>
     
    
   <?php }

                        if (!$__URUN__){
                            echo '
							
						              <p> '.$sipno.' numaralı sipariş bulunamamıştır.</p>
								    	
										
							
							
							';
                        }

                         ?>	

						 <?php  } else {?>

	
	
	
	
	
	
	
	
	
	
	
	
            			<form action="" method="GET"/>
		                	<div class="row" style="margin-top: 15px;">
		                		<div class="col-lg-12" style="border: 1px solid #f8f8f8;border-radius: 4px;">
		                			<h4 class="checkout-title" style="">Sipariş Sorgulama</h4><!-- End .checkout-title -->
		                				<div class="row">
							
							
							<div class="col-sm-12" id="bireysel">			
						    <div class="md-form md-outline">
							<input name="sipno" type="text" class="form-control" required>
                            <label for="form15" class="active">Sipariş Numaranız</label>
                            </div>
				            </div>
							
						
							
	                		


							

	                			</div><!-- End .col-lg-9 -->
		                			<button type="submit" name="siparissorgulama" class="butonok btn-outline-primary-2">
                                                <span>SİPARİŞ SORGULAMA</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
		                	</div><!-- End .row -->
							
							
							
							
							
            			</form>
						
						<?php }?>
					
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div>
			</div>
        </main>
	<style>











.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.10rem
}

.card-header:first-child {
    border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
}

.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1)
}

.track {
    position: relative;
    background-color: #ddd;
    height: 7px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 60px;
    margin-top: 50px
}

.track .step {
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    width: 25%;
    margin-top: -18px;
    text-align: center;
    position: relative
}

.track .step.active:before {
    background: #FF5722
}

.track .step::before {
    height: 7px;
    position: absolute;
    content: "";
    width: 100%;
    left: 0;
    top: 18px
}

.track .step.active .icon {
    background: #ee5435;
    color: #fff
}

.track .icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    position: relative;
    border-radius: 100%;
    background: #ddd;
    line-height: 40px;
    font-size: 20px;
    padding-top: 10px;

}

.track .step.active .text {
    font-weight: 400;
    color: #000
}

.track .text {
    display: block;
    margin-top: 7px
}

.itemside {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 100%
}

.itemside .aside {
    position: relative;
    -ms-flex-negative: 0;
    flex-shrink: 0
}

.img-sm {
    width: 80px;
    height: 80px;
    padding: 7px
}

ul.row,
ul.row-sm {
    list-style: none;
    padding: 0
}

.itemside .info {
    padding-left: 15px;
    padding-right: 7px
}

.itemside .title {
    display: block;
    margin-bottom: 5px;
    color: #212529
}

p {
    margin-top: 0;
    margin-bottom: 1rem
}

.btn-warning {
    color: #ffffff;
    background-color: #ee5435;
    border-color: #ee5435;
    border-radius: 1px
}

.btn-warning:hover {
    color: #ffffff;
    background-color: #ff2b00;
    border-color: #ff2b00;
    border-radius: 1px
}
b, strong {
    font-weight: 400;
    font-size: 13px;
}
.table td {

    padding: 4px !important;
	text-align: center !important;
	font-size: 14px;
}
.table .total-col {
    color: #c96;
    font-weight: 400;
    font-size: 14px;
}
.md-form.md-outline .form-control {
    padding: .375rem .75rem;
        padding-top: 0.375rem;
    padding-top: 10px;
}



.show {
    display: block !important;
    opacity: 1;
}

.tab-content {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 20px;
    background: white;
}


.badge {
    display: inline-block;
    min-width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: bold;
    line-height: 1;
    color: #fff !important;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: <?php echo $tema['t8']; ?>;
    border-radius: 10px;
    background: <?php echo $tema['t8']; ?> !important;
    border: none !important;
}
.panel-default > .panel-heading .badge {
    color: #fff;
    background-color: <?php echo $tema['t8']; ?> !important;
}
.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.10rem;
    padding: 1px;
}

.card-header:first-child {
    border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
}

.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1)
}

.track {
    position: relative;
    background-color: #ddd;
    height: 7px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 60px;
    margin-top: 50px
}

.track .step {
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    width: 25%;
    margin-top: -18px;
    text-align: center;
    position: relative
}

.track .step.active:before {
    background: #FF5722
}

.track .step::before {
    height: 7px;
    position: absolute;
    content: "";
    width: 100%;
    left: 0;
    top: 18px
}

.track .step.active .icon {
    background: #ee5435;
    color: #fff
}

.track .icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    position: relative;
    border-radius: 100%;
    background: #ddd;
    line-height: 20px;
    font-size: 20px;
    padding-top: 10px;

}

.track .step.active .text {
    font-weight: 400;
    color: #000
}

.track .text {
    display: block;
    margin-top: 7px
}

.itemside {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 100%
}

.itemside .aside {
    position: relative;
    -ms-flex-negative: 0;
    flex-shrink: 0
}

.img-sm {
    width: 80px;
    height: 80px;
    padding: 7px
}

ul.row,
ul.row-sm {
    list-style: none;
    padding: 0
}

.itemside .info {
    padding-left: 15px;
    padding-right: 7px
}

.itemside .title {
    display: block;
    margin-bottom: 5px;
    color: #212529
}

p {
    margin-top: 0;
    margin-bottom: 1rem
}

.btn-warning {
    color: #ffffff;
    background-color: #ee5435;
    border-color: #ee5435;
    border-radius: 1px
}

.btn-warning:hover {
    color: #ffffff;
    background-color: #ff2b00;
    border-color: #ff2b00;
    border-radius: 1px
}
b, strong {
    font-weight: 400;
    font-size: 13px;
}
.table td {

    padding: 4px !important;
	text-align: center !important;
	font-size: 14px;
}
.table .total-col {
    color: #c96;
    font-weight: 400;
    font-size: 14px;
}
.md-form.md-outline .form-control {
    padding: .375rem .75rem;
        padding-top: 0.375rem;
    padding-top: 10px;
}
.col-1,
.col-2,
.col-3,
.col-4,
.col-5,
.col-6,
.col-7,
.col-8,
.col-9,
.col-10,
.col-11,
.col-12,
.col,
.col-auto,
.col-sm-1,
.col-sm-2,
.col-sm-3,
.col-sm-4,
.col-sm-5,
.col-sm-6,
.col-sm-7,
.col-sm-8,
.col-sm-9,
.col-sm-10,
.col-sm-11,
.col-sm-12,
.col-sm,
.col-sm-auto,
.col-md-1,
.col-md-2,
.col-md-3,
.col-md-4,
.col-md-5,
.col-md-6,
.col-md-7,
.col-md-8,
.col-md-9,
.col-md-10,
.col-md-11,
.col-md-12,
.col-md,
.col-md-auto,
.col-lg-1,
.col-lg-2,
.col-lg-3,
.col-lg-4,
.col-lg-5,
.col-lg-6,
.col-lg-7,
.col-lg-8,
.col-lg-9,
.col-lg-10,
.col-lg-11,
.col-lg-12,
.col-lg,
.col-lg-auto,
.col-xl-1,
.col-xl-2,
.col-xl-3,
.col-xl-4,
.col-xl-5,
.col-xl-6,
.col-xl-7,
.col-xl-8,
.col-xl-9,
.col-xl-10,
.col-xl-11,
.col-xl-12,
.col-xl,
.col-xl-auto {
 padding-right:10px;
 padding-left:10px
}
.no-gutters {
 margin-left:0;
 margin-right:0
}
.no-gutters>.col,
.no-gutters>[class*=col-] {
 padding-left:0;
 padding-right:0
}
.container {
 width:1188px;
 max-width:100%;
 padding-left:10px;
 padding-right:10px
}
.page-wrapper {
 position:relative;
 display:flex;
 flex-direction:column;
 min-height:100%;
 transition:transform 0.4s ease
}
.mmenu-active .page-wrapper {
 transform:translateX(200px)
}







</style>
