<?php
paket_kontrol(["plus", "extreme", "enterprise"]); 
admin_yetki($ozy, $_SESSION['departmanid'], 6); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$sayfasil = $ozy->prepare("delete from tiletisim where id='$id'");
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
                        <h4 class="page-title">Gelen Kutusu</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Gelen Kutusu</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
            <div class="col-12">
                    <!-- Left sidebar -->
                    <div class="email-leftbar card">
                        <a href="eposta-gonder" class="btn btn-danger rounded btn-custom btn-block waves-effect waves-light">Toplu Eposta Gönder</a>

                        <h6 class="m-t-30">Gelen Kutusu</h6>

                        <div class="mail-list m-t-10">
                            <a href="gelen-kutusu"> <span class="float-right">
							<?php 
							$gelen = $ozy->prepare("SELECT COUNT(*) FROM iletisim");
                            $gelen->execute();
                            $gelenmesajsayisi = $gelen->fetchColumn(); echo $gelenmesajsayisi;?>
							</span> <i class="ti-archive mr-2"></i> Gelen </a>
                            <a  href="gelen-kutusu?s=1"><span class="float-right">
							<?php 
							$giden = $ozy->prepare("SELECT COUNT(*) FROM iletisim  where giden='1'");
                            $giden->execute();
                            $gidenmesajsayisi = $giden->fetchColumn(); echo $gidenmesajsayisi;?>
							</span><i class="ti-location-arrow mr-2"></i> Cevaplanan </a>
                            <a href="gelen-kutusu?s=2" ><span class="float-right">
							<?php 
							$silinen = $ozy->prepare("SELECT COUNT(*) FROM iletisim where durum='0'");
                            $silinen->execute();
                            $silinenmesajsayisi = $silinen->fetchColumn(); echo $silinenmesajsayisi;?>
							</span><i class="ti-trash mr-2"></i> Silinen </a>
							<a href="toplu-eposta" class="active"><span class="float-right">
							<?php 
							$toplu = $ozy->prepare("SELECT COUNT(*) FROM tiletisim");
                            $toplu->execute();
                            $toplueposta = $toplu->fetchColumn(); echo $toplueposta;?>
							
							</span><i class="ti-pencil  mr-2"></i>Toplu Eposta  </a>
                            
                        </div>

                 
                    </div>
                    <!-- End Left sidebar -->

                    <!-- Right Sidebar -->
                    <div class="email-rightbar mb-3" style="background: white;padding: 10px;">
                    <p class="sub-title" style="text-align:right;">
							<a href="eposta-gonder" style="width: 100%;" class="btn btn-success waves-effect waves-lightt">
							Toplu Eposta Gönder
							</a>
                               
                            </p>
                      

                        <table id="datatable" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Toplu Eposta Adı</th>
                                    <th>Konu</th>
									<th>Durumu</th>
                                    <th>Tarih</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	                       <?php $pr = $ozy->query("select * from tiletisim ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($pr as $tr) {?>	
								
								
                                <tr>
                                    <td><?php echo $tr['adi']?></td>
                                    <td><?php echo $tr['konu']?></td>
                                   
									<td>
									<?php if($tr['durum']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Gönderildi</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Gönderilmedi</span>
                                    <?php } ?>
									</td>
                                    <td><?php echo $tr['tarih']?></td>
                                    <td>
									
									<a href="toplu-eposta?temizle=<?php echo $tr['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
			                        <a href="eposta-duzenle/<?php echo $tr['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>					
												
				
									
									
									</td>
                                </tr>
                               
		                    <?php }?>					   
							   
							   
							   
							   
                                </tbody>
                            </table>

                        </div>
                        <!-- card -->

                       

                   
                </div>
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
