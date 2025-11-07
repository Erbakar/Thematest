<?php
paket_kontrol(["plus", "extreme", "enterprise"]);  
admin_yetki($ozy, $_SESSION['departmanid'], 7); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$sayfasil = $ozy->prepare("delete from sss where id='$id'");
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
                        <h4 class="page-title">Tüm Sorular</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Sorular</li>
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
							<a href="sss-ekle" style="width: 100%;" class="btn btn-success waves-effect waves-lightt">
							Soru Ekle
							</a>
                               
                            </p>

                            <table id="datatable" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Soru</th>
                                    <th>Cevap</th>
                                    <th>Soru Sırası</th>
                                    <th>Durumu</th>
                                    <th>Tarih</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	                       <?php $pr = $ozy->query("select * from sss ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($pr as $tr) {?>	
								
								
                                <tr>
                                
                                    <td><?php echo $tr['adi']?></td>
                                    <td><?php echo strip_tags(mb_substr($tr['aciklama'],0,150));?></td>
                                    <td><?php echo $tr['sira']?></td>
                                    <td>
									<?php if($tr['durum']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Aktif</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Pasif</span>
                                    <?php } ?>
									</td>
									
                                    <td><?php echo $tr['tarih']?></td>
                                    <td>
									
									<a href="tum-sssler?temizle=<?php echo $tr['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
			                        <a href="sss/duzenle/<?php echo $tr['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>					
												
				
									
									
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
