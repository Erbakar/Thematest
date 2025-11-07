<?php
paket_kontrol(["plus", "extreme", "enterprise"]); 
admin_yetki($ozy, $_SESSION['departmanid'], 6); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$sayfasil = $ozy->prepare("delete from support where id=?");
$sayfasil->execute(array($id));
if ($sayfasil) {


echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';
	
}


}

if (isset($_POST['uguncelle'])) {
	
$sid   = $_POST['sid'];
$durum   = $_POST['durum'];										
$ekle = $ozy->prepare("UPDATE  support SET durum='$durum' WHERE id=?");
$ekle->execute(array($sid));
                           
}



?>



<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Destek Merkezi</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Destek Merkezi</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                         
                            <p class="sub-title" style="text-align:right;">
						
                               
                            </p>

                            <table id="datatable" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                   
                                    <th>Destek No</th>
									<th>Üye</th>
									<th>İsim</th>
                                    <th>Konu</th>
                                    <th>Durumu</th>
                                    <th>Tarih</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	                        <?php 

     
        $page = intval(@$_GET['page']);
        if (!$page) {
          $page = 1;
        }
        $bak = $ozy->prepare("select * from support where uye!='0'");
        $bak->execute(array());
        $toplam= $bak->rowCount();
        $limit =2000000;
        $goster = $page*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 10;
		
	
	  
	    $pr = $ozy->query("select * from support  where uye!='0' order by id DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);
        
	  
        $__URUN__ = false;
        foreach ($pr as $iletisim) {
        $__URUN__ = true;
		?>

								
                                <tr>
                                    <td>#<?php echo $iletisim['mid']; ?></td>
									<td> <?php 
                                     $kimuye = $iletisim['uye'];
                                     $uyeb = $ozy->query("select * from users where onay='1' and id='{$kimuye}' order by id desc")->fetch(PDO::FETCH_ASSOC);?> 
                                     <a target="_blank" href="uye/duzenle/<?php echo $uyeb['id']; ?>" class="title">
                                          
									<h6 class="mb-0"><?php echo $uyeb['isim']; ?></h6>
										   </td>
									<td><?php echo $iletisim['konu']?></td>
									<td><?php echo strip_tags(mb_substr($iletisim['mesaj'],0,15));?>...</td>
									<td> 
									<a class="btn btn-sm" style="border: 1px solid #30419b;font-weight: 500;">
											    Durumu :
												<form method="POST" action=""> 
												<select class="form-control" style="max-height: 40px !important;margin-top: 23px;" name="durum" onchange="this.form.submit()">
												<option <?php echo $iletisim['durum'] == '4' ? 'selected' : null; ?> value="4">Seçiniz</option>
												<option <?php echo $iletisim['durum'] == '0' ? 'selected' : null; ?> value="0">Okunmadı</option>
												<option <?php echo $iletisim['durum'] == '1' ? 'selected' : null; ?> value="1">Okundu</option>
												<option <?php echo $iletisim['durum'] == '2' ? 'selected' : null; ?> value="2">Cevaplandı</option>
												<option <?php echo $iletisim['durum'] == '3' ? 'selected' : null; ?> value="3">Kapatıldı</option>
												<select>
												<input type="hidden" name="sid" value="<?php echo $iletisim['id']?>">
												<input type="hidden" name="uguncelle">
												</form>		
									</a>									 
										
									</td>	
										
	
									
                                    <td><?php echo $iletisim['tarih']?></td>
                                    <td>
									
								     <a href="tel:<?php echo $uyeb['telefon'];  ?>" target="_blank" onclick="return confirm('Telefon ile yanıt vermek istiyor musun ?')" class="btn btn-sm btn-danger" style="border: none;background: #4192e9;" data-toggle="tooltip" data-original-title="Telefon ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/tel.png"></img></a>									 
									<a href="https://api.whatsapp.com/send?phone=+9<?php echo $uyeb['telefon'];  ?>&amp;text=Merhaba iyi günler, <?php echo $ayar['siteadi'];?> olarak websitemizin destek formundan göndermiş olduğunuz mesaja istinaden sizi rahatsız ediyorum." target="_blank" onclick="return confirm('WhatsApp ile yanıt vermek istiyor musun  ?')" class="btn btn-sm btn-danger" style="border: #2ab200;background: #2ab200;" data-toggle="tooltip" data-original-title="WhatsApp ile Yanıtla"><img style="width: 16px;height: 16px;" src="assets/images/whatsap.jpg"></img></a>									 
                                    <a href="destek-duzenle/<?php echo $iletisim['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true" style="color:white;"></i></a>	
									<a href="destek-merkezi?temizle=<?php echo $iletisim['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i style="color:white;" class="ti-trash" aria-hidden="true"></i></a>						
												
				                  
									
									
									</td>
									
                                </tr>
                                 <?php }

                        if (!$__URUN__){
                             echo "<b style='font-weight: 500;background: #fafafa;padding: 10px;width: 100%;text-align: center;border: 1px solid #ededed;'>Mükemmel destek talebiniz bulunamadı</b>";
							
							
							}

                         ?>		
                              
							
                              
                                </tbody>
                            </table>

                                

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
