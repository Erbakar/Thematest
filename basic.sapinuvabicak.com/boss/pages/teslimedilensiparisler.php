<?php
admin_yetki($ozy, $_SESSION['departmanid'], 2); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$sayfasil = $ozy->prepare("delete from siparis where id='$id'");
$sayfasil->execute(array($id));

if ($sayfasil) {
	
echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';
	
}


}

?>


<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Teslim Edilen Siparişler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Teslim Edilen Siparişler</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <table id="datatable" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
								    <th>Sipariş ID</th>
                                    <th>Sipariş No</th>
									<th>Kullanıcı</th>
                                    <th>Ödeme Tipi</th>
									<th>Ödenenen Tutar</th>
                                    <th>Durumu</th>
									<th>Sipariş Tarihi</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	                       <?php $pr = $ozy->query("select * from siparis where durum='Sipariş Tamamlandı' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($pr as $tr) {?>	
								
								
                                <tr>
								    <td><?php echo $tr['id']?></td>
                                    <td><?php echo $tr['siparisno']?></td>
									<?php 
									$sipuyeid = $tr['uye'];
									$kargoid = $tr['kargoid'];
									$siparisuyebilgileri = $ozy->query("select * from users where id='$sipuyeid'")->fetch(PDO::FETCH_ASSOC);
									$kargobilgileri = $ozy->query("select * from kargolar where id='$kargoid'")->fetch(PDO::FETCH_ASSOC);?>
									<?php if($sipuyeid=='0'){?>
									<td>
									<b>Misafir</b></br>
									<?php echo $tr['adsoyad'];?></br>
									</td>
									<?php } else { ?>
									<td>
									<a href="uye/duzenle/<?php echo $siparisuyebilgileri['id'];?>" target="_blank"><?php echo $siparisuyebilgileri['isim'];?></br>
			
									</a>
									</td>
									<?php } ?>
									<td><?php echo $tr['odemetipi']?></td>
                                    <td><?php echo $tr['toplamtutar']?> TL</td>
									
									 <td><span style="font-size: 13px;font-size: 13px;background: white;color: black;border: 1px solid #6975b6;border-radius: 0px;padding: 5px;" class="badge badge-success"><?php echo $tr['durum']?></td>
									</span>
                                   
									<td><?php echo $tr['tarih']?></td>
                                     <td>
									<a href="tel:<?php echo $tr['telefon'];  ?>" target="_blank" onclick="return confirm('Telefon ile yanıt vermek istiyor musun ?')" class="btn btn-sm btn-danger" style="border: none;background: #4192e9;" data-toggle="tooltip" data-original-title="Telefon ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/tel.png"></img></a>									 
									<a href="https://api.whatsapp.com/send?phone=+9<?php echo $tr['telefon'];  ?>&amp;text=Merhaba iyi günler, <?php echo $ayar['siteadi'];?> olarak websitemizinden <?php echo $tr['siparisno'];  ?> nolu siparişiniz için rahatsız ediyorum. Sipariş durumunuz <?php echo $tr['durum'];  ?> olarak güncellenmiştir. <?php echo $tr['durum'] == 'Kargoya Verildi' ? 'Kargo Bilgileriniz : '.$kargobilgileri['adi'].' Takip Numaranız : '.$tr['takipno'].'' : null; ?> İyi günler dileriz." target="_blank" onclick="return confirm('WhatsApp ile yanıt vermek istiyor musun  ?')" class="btn btn-sm btn-danger" style="border: #2ab200;background: #2ab200;" data-toggle="tooltip" data-original-title="WhatsApp ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/whatsap.jpg"></img></a>									 
									<a href="javascript:printDiv('divYazdir<?php echo $tr['id']?>');" style="background: #8a940b;color: white;" onclick="return confirm('Siparişi yazdırmak istediğine emin misin?')" class="btn btn-sm btn" data-toggle="tooltip" data-original-title="Yazdır"><i class="fa fa-print" aria-hidden="true"></i></a>									 
			                        <a href="yeni-siparisler?temizle=<?php echo $tr['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
									<a href="siparis/duzenle/<?php echo $tr['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>					
									</td>
                                </tr>
                               
							 <div class="col-12" id="divYazdir<?php echo $tr['id']?>" style="display:none;">
							 <?php $adresdizi = $dizi = explode (" ",$tr['adres']);?>
<div style="position:absolute;left:50%;margin-left:-420px;top:0px;width:841px;height:594px;border-style:outset;overflow:hidden">
<div style="position:absolute;left:0px;top:0px">
<img src="faturaback.jpg" width=841 height=594></div>
<div style="position: absolute;left: 15%;top: 40.33px;" class="cls_002"><span class="cls_002"><img src="../resimler/siteayarlari/<?php echo $ayar['logo']; ?>" style="height: 40px !important"></span></div>
<div style="position:absolute;left:41.76px;top:84.33px" class="cls_002"><span class="cls_002">Gönderici Bilgileri</span></div>
<div style="position:absolute;left:41.76px;top:106.09px" class="cls_003"><span class="cls_003">Şirket İsmi</span></div>
<div style="position:absolute;left:134.07px;top:106.09px" class="cls_003"><span class="cls_003"><?php echo $ayar['siteadi'];?></span></div>
<div style="position:absolute;left:41.76px;top:127.85px" class="cls_003"><span class="cls_003">Şirket Telefon</span></div>
<div style="position:absolute;left:134.07px;top:127.85px" class="cls_003"><span class="cls_003"><?php echo $ayar['tel'];?></span></div>
<div style="position:absolute;left:41.76px;top:149.62px" class="cls_002"><span class="cls_002">Alıcı Bilgileri</span></div>
<div style="position:absolute;left:41.76px;top:171.38px" class="cls_003"><span class="cls_003">Ad / Soyad</span></div>
<div style="position:absolute;left:134.07px;top:171.38px" class="cls_003"><span class="cls_003"><?php echo $tr['adsoyad'];?></span></div>
<div style="position:absolute;left:134.07px;top:193.15px" class="cls_003"><span class="cls_003"><?php echo $dizi[0];?> <?php echo $dizi[1];?> <?php echo $dizi[2];?> </span></div>
<div style="position:absolute;left:41.76px;top:209.66px" class="cls_003"><span class="cls_003">Adres</span></div>
<div style="position:absolute;left:134.07px;top:209.66px" class="cls_003"><span class="cls_003"><?php echo $dizi[3];?>  <?php echo $dizi[4];?> <?php echo $dizi[5];?></span></div>
<div style="position:absolute;left:134.07px;top:226.17px" class="cls_003"><span class="cls_003"><?php echo $dizi[6];?> <?php echo $dizi[7];?> <?php echo $dizi[8];?> <?php echo $dizi[9];?></span></div>
<div style="position:absolute;left:41.76px;top:247.93px" class="cls_003"><span class="cls_003">İl / İlçe</span></div>
<div style="position:absolute;left:134.07px;top:247.93px" class="cls_003"><span class="cls_003"><?php echo $tr['il'];?> / <?php echo $tr['ilce'];?></span></div>
<div style="position:absolute;left:41.76px;top:269.69px" class="cls_003"><span class="cls_003">Telefon No</span></div>
<div style="position:absolute;left:134.07px;top:269.69px" class="cls_003"><span class="cls_003"><?php echo $tr['telefon'];?></span></div>
<div style="position:absolute;left:41.76px;top:291.46px" class="cls_003"><span class="cls_003">Cep Telefonu</span></div>
<div style="position:absolute;left:134.07px;top:291.46px" class="cls_003"><span class="cls_003"><?php echo $tr['telefon'];?></span></div>
<div style="position:absolute;left:41.76px;top:313.22px" class="cls_003"><span class="cls_003">Posta Kodu</span></div>
<div style="position:absolute;left:134.07px;top:313.22px" class="cls_003"><span class="cls_003">90000</span></div>
<div style="position:absolute;left:41.76px;top:334.99px" class="cls_002"><span class="cls_002">Satış Bilgileri</span></div>
<div style="position:absolute;left:41.76px;top:356.75px" class="cls_003"><span class="cls_003">Kargo</span></div>
<div style="position:absolute;left:41.76px;top:373.26px" class="cls_003"><span class="cls_003">Bilgileri</span></div>
<div style="position:absolute;left:134.07px;top:352.69px" class="cls_003"><span class="cls_003"><?php echo $kargobilgileri['adi'];?></span></div>
<div style="position:absolute;left:134.07px;top:372.69px" class="cls_003"><span class="cls_003"><?php echo $tr['takipno'];?></span></div>
<div style="position:absolute;left:41.76px;top:395.02px" class="cls_003"><span class="cls_003">Durum : <?php echo $tr['durum'];?></span></div>
<div style="position:absolute;left:41.76px;top:416.79px" class="cls_003"><span class="cls_003">Ödeme</span></div>
<div style="position:absolute;left:134.07px;top:425.04px" class="cls_003"><span class="cls_003"><?php echo $tr['odemetipi'];?></span></div>
<div style="position:absolute;left:41.76px;top:433.30px" class="cls_003"><span class="cls_003">Yöntemi</span></div>
<div style="position:absolute;left:41.76px;top:455.06px" class="cls_003"><span class="cls_003">Sipariş Kodu</span></div>
<div style="position:absolute;left:134.07px;top:455.06px" class="cls_003"><span class="cls_003"><?php echo $tr['siparisno'];?></span></div>
</div>
                                      
								
                                    
							 
							 
							</div>
							<!-- SİPARİŞ YAZDIRMA ALANI -->
							   
							   
		                    <?php }?>					   
							   
							   
							   
							   
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
