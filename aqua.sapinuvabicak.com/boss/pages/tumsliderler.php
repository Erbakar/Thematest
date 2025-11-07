<?php
admin_yetki($ozy, $_SESSION['departmanid'], 7); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$bakresim = $ozy->query("select * from slider where id='$id'")->fetch(PDO::FETCH_ASSOC);
$sayfasil = $ozy->prepare("delete from slider where id='$id'");
$sayfasil->execute(array($id));

if ($sayfasil) {
	
if($bakresim['resim']=='resimyok.jpg'){
} else {		
$silresim="../resimler/slider/".$bakresim['resim']."";
$sil =@unlink("$silresim");	
}

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
                        <h4 class="page-title">Tüm Sliderler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Sliderler</li>
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
							<a href="slider-ekle" style="width: 100%;" class="btn btn-success waves-effect waves-lightt">
							Slider Ekle
							</a>
                               
                            </p>

                            <table id="datatable" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Slider Adı</th>
                                    <th>Slider Sırası</th>

                                    <th>Slider Resmi</th>
									<th>Slider Linki</th>
                                    <th>Durumu</th>
                                    <th>Tarih</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	                       <?php $pr = $ozy->query("select * from slider ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($pr as $tr) {?>	
								
								
                                <tr>
                                    <td><?php echo $tr['adi']?></td>
                                    <td><?php echo $tr['sira']?></td>

                                    <td><a class="image-popup-no-margins" href="../resimler/slider/<?php echo $tr['resim']?>">
									<img height="60px" width="60px" src="../resimler/slider/<?php echo $tr['resim']?>"></a></td>
							        <td><a target="_blank" href="<?php echo $tr['link']?>">Sayfaya Git</a></td>
                                    <td>
									<?php if($tr['durum']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Aktif</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Pasif</span>
                                    <?php } ?>
									</td>
                                    <td><?php echo $tr['tarih']?></td>
                                    <td>
									
									<a href="tum-sliderler?temizle=<?php echo $tr['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
			                        <a href="anasayfa.php?trendmaxtrs=slider-ekle&duzenle=<?php echo $tr['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>					
												
				
									
									
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
