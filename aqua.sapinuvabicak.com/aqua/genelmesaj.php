<?php 
 echo $genelmetin = '	   
  <div class="col-lg-6 successtext d-flex align-items-center">
                    <div class="g">
                        <span class="icon">
                            <i class="ri-check-double-line"></i>
                        </span>
                        <div class="successtitle">Siparişiniz başarıyla oluşturuldu!</div>
                        <p>Bizi tercih ettiğiniz için teşekkür ederiz.</p>
                        <p>Hesabınızı görüntülemek için buraya, sipariş geçmişiniz için <a href="'.$url.'/hesabim/">buraya tıklayınız</a>.</p>
                        <p>Herhangi bir sorunuz varsa <a href="'.$url.'/iletisim/">buradan</a> iletişime geçebilirsiniz.</p>
                    </div>
                </div>
                <div style="width: 30% !important;
float: right;
margin-top: -17%;" class="col-md-6 d-xl-flex d-lg-flex d-md-none d-sm-none d-none">
                    <img src="'.$sitetemasi.'/basarilisiparis.png" class="img-fluid" alt="">
                </div>
                <div class="col-12 mt-5">
                    <ul class="orderdetail d-flex align-items-center justify-content-between">
                        <li>Sipariş No: <b>'.$siparisno.'</b></li>
                        <li>Eklenme Tarihi: <b>'.$tarih.'</b></li>
                        <li>Ödeme Yöntemi: <b>'.$odemetipi.'</b></li>
                        <li>Kargo Bedeli: <b>'.$kargotutari.'</b></li>
                    </ul>
                    <div class="subtitle mt-5 mb-5">SİPARİŞ ÖZETİ</div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Ürünleriniz</th>
                                <th scope="col">Stok Kodu</th>
                                <th scope="col">Miktar</th>
                                <th scope="col">Birim Fiyatı</th>
                                <th scope="col">Toplam</th>
                            </tr>
                            </thead>
                            <tbody>
                           '.$siparissontablo.'
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        
                        <div class="col-lg-6">
                            <div class="addressbox mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3 mt-3">
                                <div class="atitle">TESLİMAT ADRESİ</div>
                                <p>
                                   '.$adsoyad.'<br />
                                    '.$telefon.'<br />
                                    '.$email.'<br />
                                    '.$adres.' -  '.$il.' /  '.$ilce.'
                                </p>
                            </div>
                        </div>
						
						<div class="col-lg-6">
                            <div class="addressbox">
                                <div class="atitle">FATURA ADRESİ</div>
                                <p>
                                    '.$adsoyad.'<br />
                                    '.$faturaadres.'<br />
                                    '.$vergibilgileri.'<br />
                                     '.$faturaadres.' -  '.$faturail.' /  '.$faturailce.'
                                </p>
                            </div>
                        </div>
						
						
                    </div>

                    <div class="button-group mt-5 text-center d-flex align-items-center justify-content-center">
                        <button style="17px 30px 18px 20px;
border-radius: 28px;
background-color: #8d94a6;
display: inline-flex;
margin-top: 20px;
justify-content: space-between;
align-items: center;
font-size: 18px;
font-weight: 600;
text-align: left;
color: #fff;border:none;" onclick="window.print()" class="btn-homepage me-2 mt-0"><i class="ri-printer-line fw-normal"></i> BU SAYFAYI YAZDIR</button>
                        <a href="'.$url.'" class="btn-complete ms-2 mt-0">ALIŞVERİŞE DEVAM ET <i class="ri-arrow-right-line"></i></a>
                    </div>
                </div>
  
  
  
  
  
  ';
 ?>