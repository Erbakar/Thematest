<?php
admin_yetki($ozy, $_SESSION['departmanid'], 8); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$sayfasil = $ozy->prepare("delete from users where id='$id'");
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
                        <h4 class="page-title">Tüm Üyeler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Üyeler</li>
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
							<a href="uye-ekle" style="width: 100%;" class="btn btn-success waves-effect waves-lightt">
							Üye Ekle
							</a>
                               
                            </p>

                            <table id="datatable" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Adı Soyadı</th>
									<th>Tüm Siparişleri</th>
                                    <th>Eposta Adresi</th>
									<th>Telefon</th>
									<th>Üyelik Tipi</th>
									<th>Durumu</th>
                                    <th>İP Adresi</th>
                                    <th>Tarih</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	                       <?php $pr = $ozy->query("select * from users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($pr as $tr) {?>	
								
								
                                <tr>
                                    <td><?php echo $tr['isim']?></td>
									<td><a target="_blank" href="uye-siparisleri?uye=<?php echo $tr['id']?>">
									
									<?php 
									$uyeidim = $tr['id'];
									$uyesay = $ozy->prepare("SELECT COUNT(*) FROM siparis where uye='{$uyeidim}'");
									$uyesay->execute();
                                    echo $uyesayi = $uyesay->fetchColumn();?> Adet Sipariş Mevcut Gör</a></td>
                                    <td><?php echo $tr['email']?></td>
									<td><?php echo $tr['telefon']?></td>
									 <td>
									<?php if($tr['uyetip']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Kurumsal Üye</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Bireysel Üye</span>
                                    <?php } ?>
									</td>
                                    <td>
									<?php if($tr['onay']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Aktif</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Pasif</span>
                                    <?php } ?>
									</td>
									
									<td><?php echo $tr['ip']?></td>
                                    <td><?php echo $tr['tarih']?></td>
                                    <td>
									
									<a href="tum-uyeler?temizle=<?php echo $tr['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
			                        <a href="uye/duzenle/<?php echo $tr['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>					
												
				
									
									
									</td>
                                </tr>
                               
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
