<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 5); 


if (isset($_GET['temizle'])) {

	

$id = temizle($_GET['temizle']);

$sayfasil = $ozy->prepare("delete from xml where id='$id'");

$sayfasil->execute(array($id));



if ($sayfasil) {





echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';

	

}





}



;?>

<div class="wrapper">

        <div class="container-fluid">

            <!-- Page-Title -->

            <div class="page-title-box">

                <div class="row align-items-center">

                    <div class="col-sm-6">

                        <h4 class="page-title">XML Listesi</h4>

                    </div>

                    <div class="col-sm-6">

                        <ol class="breadcrumb float-right">

                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                           

                            <li class="breadcrumb-item active">XML Listesi</li>

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

                                    <th>XML URL</th>

                                    <th>Durumu</th>

                                    <th>Tarih</th>

                                    <th>İşlem</th>

                                </tr>

                                </thead>





                                <tbody>

							

								

	                       <?php $pr = $ozy->query("select * from xml ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

                           foreach ($pr as $tr) {?>	

								

								

                                <tr>

                                    <td><a target="_blank" href="<?php echo $tr['xmlurl']?>"><?php echo $tr['xmlurl']?></a></td>

                                    <td>

									<?php if($tr['yukledurum']=='1'){?>

									<span style="font-size: 13px;" class="badge badge-success">Yüklendi</span>

                                    <?php } else { ?>

									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Yüklenmedi</span>

                                    <?php } ?>

									</td>

                                   

									

                                    <td><?php echo $tr['tarih']?></td>

                                    <td>

									 <a href="xml/duzenle/<?php echo $tr['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>					

									

									<a href="xml?temizle=<?php echo $tr['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 

			                        			

				

									

									

									</td>

                                </tr>

                               

		                    <?php }?>					   

							   

							   

							   	<tr>

								    

                                    <td><a target="_blank" href="<?php echo $ayar['siteurl']?>/urunler.xml"><?php echo $ayar['siteurl']?>/urunler.xml</td>

                                    <td><span style="font-size: 13px;" class="badge badge-primary">Genel XML Çıktısı</span></td>

                                    <td></td>

                                    <td></td>

								</tr>

								

								<tr>

								    

                                    <td><a target="_blank" href="<?php echo $ayar['siteurl']?>/akakce.xml"><?php echo $ayar['siteurl']?>/akakce.xml</td>

                                    <td><span style="font-size: 13px;" class="badge badge-warning">Akakce XML Çıktısı</span></td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

								</tr>

								

								<tr>

								    

                                    <td><a target="_blank" href="<?php echo $ayar['siteurl']?>/cimri.xml"><?php echo $ayar['siteurl']?>/cimri.xml</td>

                                    <td><span style="font-size: 13px;" class="badge badge-danger">Cimri XML Çıktısı</span></td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

								</tr>

								

								

								<tr>

								    

                                    <td><a target="_blank" href="<?php echo $ayar['siteurl']?>/rss.xml"><?php echo $ayar['siteurl']?>/rss.xml</td>

                                    <td><span style="font-size: 13px;" class="badge badge-success">RSS Çıktısı</span></td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

								</tr>

								

									<tr>

								    

                                    <td><a target="_blank" href="<?php echo $ayar['siteurl']?>/sitemap.xml"><?php echo $ayar['siteurl']?>/sitemap.xml</td>

                                    <td><span style="font-size: 13px;" class="badge badge-primary">Sitemap XML Çıktısı</span></td>

                                    <td></td>

                                    <td></td>

								</tr>

							   

							   	

								<tr>

								    

                                    <td><a target="_blank" href="<?php echo $ayar['siteurl']?>/merchant.xml"><?php echo $ayar['siteurl']?>/merchant.xml</td>

                                    <td><span style="font-size: 13px;" class="badge badge-warning">Google Feed XML Çıktısı</span></td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

								</tr>

							   

							   

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

