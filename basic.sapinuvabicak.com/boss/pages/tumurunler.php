<?php
admin_yetki($ozy, $_SESSION['departmanid'], 4); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);
$bakresim = $ozy->query("select * from urunler where id='$id'")->fetch(PDO::FETCH_ASSOC);
$sayfasil = $ozy->prepare("delete from urunler where id='$id'");
$sayfasil->execute(array($id));

if ($sayfasil) {
	
if($bakresim['resim']=='resimyok.jpg'){
} else {		
$silresim="../resimler/urunler/".$bakresim['resim']."";
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
                        <h4 class="page-title">Tüm Ürünler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Ürünler</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                         
                            <p class="sub-title" style="text-align:right;margin-bottom: 10px;">
							<a href="urun-ekle" style="width: 100%;" class="btn btn-success waves-effect waves-lightt">
							Ürün Ekle
							</a>
                               
                            </p>
							<div class="col-lg-12" style="background: #f9f9f9;padding: 10px !important;margin-bottom: 20px !important">
										    <form action="" method="GET"> 
                                             <label style="width: 95%;">Ürün Sıralama:</label>
										     <input type="hidden" name="pages" value="<?php echo temizle($_GET['pages']);?>"/>

										       <select name="siralama" style="width: 50%;" class="form-control" onchange='this.form.submit()'>

												<option <?php echo $_GET['siralama'] == 'onerilen' ? 'selected="selected"' : null; ?> value="onerilen">Önerilen Sıralama</option>
                                                
												<option <?php echo $_GET['siralama'] == 'azstok' ? 'selected="selected"' : null; ?> value="azstok">Stoğu Azanlar</option>
												
												<option <?php echo $_GET['siralama'] == 'dusukfiyat' ? 'selected="selected"' : null; ?> value="dusukfiyat">Önce En Düşük Fiyat</option>

												<option <?php echo $_GET['siralama'] == 'yuksekfiyat' ? 'selected="selected"' : null; ?> value="yuksekfiyat">Önce En Yüksek Fiyat</option>

												<option <?php echo $_GET['siralama'] == 'encokyorum' ? 'selected="selected"' : null; ?> value="encokyorum">En Çok Yorum Alan</option>

												<option <?php echo $_GET['siralama'] == 'enbegenilen' ? 'selected="selected"' : null; ?> value="enbegenilen">En Çok Beğenilen</option>

												<option <?php echo $_GET['siralama'] == 'eskitarih' ? 'selected="selected"' : null; ?> value="eskitarih">En Eski Tarihe Göre</option>

												<option <?php echo $_GET['siralama'] == 'yenitarih' ? 'selected="selected"' : null; ?> value="yenitarih">En Yeni Tariha Göre</option>

											</select>

									  
							
							<div style="margin-left: 53% !important;margin-top: -53px !important;">
							<label style="width: 100%;">Ürün Arama:
							<input type="search" class="form-control" name="urunara" placeholder="Ürün Adı veya kodu giriniz" aria-controls="datatable">
							</label>
							</div>
							
							<button type="submit" style="width: 100%;" class="btn btn-warning waves-effect waves-lightt">
							Arama Yap
							</button>
							
							</div>
							</form>
							
							
							
							
							
							
							
                            <table  class="table table-bordered dt-responsive nowrap tablem">
                                <thead>
                                <tr>
                               
									<th>Ürün Kodu</th>
                                    <th>Ürün Adı</th>
                                    <th>Ürün Sırası</th>
									<th>Ürün Kategori</th>
                                    <th>Ürün Resmi</th>
                                    <th>Durumu</th>
									<th>Hit</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>


                                <tbody>
								
	    <?php 

        $pages = intval(@$_GET['pages']);
        if (!$pages) {
          $pages = 1;
        }
		
        $urunarama = " ";
		if (isset($_GET["urunara"]) && $_GET["urunara"] != "") {
        $urunarax = temizle($_GET["urunara"]);
		$urunarama .= " where adi like '%{$urunarax}%' or urunkodu like '%{$urunarax}%'";
        }
		
        $bak = $ozy->prepare("select * from urunler ".$urunarama."");
        $bak->execute(array());
        $toplam= $bak->rowCount();
        $limit = 30;
        $goster = $pages*$limit-$limit;
        $sayfasayisi = ceil($toplam/$limit);
        $forlimit = 15;
		
		
		if (isset($_GET["siralama"]) && $_GET["siralama"] != "") {

			

		if(temizle($_GET["siralama"]=='dusukfiyat')){

			

		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat) AS simdikifiyat from urunler  ".$urunarama." order by simdikifiyat ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

	

        } elseif (temizle($_GET["siralama"]=='yuksekfiyat')) {



 		$pageoku = $ozy->query("select *, if( idurum=1,ifiyat,fiyat) AS simdikifiyat from urunler ".$urunarama."  order by simdikifiyat DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    	

		} elseif (temizle($_GET["siralama"]=='encokyorum')) {

			

		$pageoku = $ozy->query("select * from urunler ".$urunarama."  order by yorum DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		} elseif (temizle($_GET["siralama"]=='enbegenilen')) {

		

		$pageoku = $ozy->query("select * from urunler ".$urunarama."  order by hit DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		} elseif (temizle($_GET["siralama"]=='eskitarih')) {

		

		$pageoku = $ozy->query("select * from urunler ".$urunarama." order by tarih DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		} elseif (temizle($_GET["siralama"]=='yenitarih')) {

			

		$pageoku = $ozy->query("select * from urunler ".$urunarama."  order by tarih ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);


  	    } elseif (temizle($_GET["siralama"]=='azstok')) {	

		

		$pageoku = $ozy->query("select * from urunler ".$urunarama." order by stok ASC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		

		} elseif (temizle($_GET["siralama"]=='onerilen')) {	

		

		$pageoku = $ozy->query("select * from urunler ".$urunarama." order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		}

		

		

		} else {

		

		$pageoku = $ozy->query("select * from urunler  ".$urunarama."  order by sira DESC limit $goster,$limit")->fetchAll(PDO::FETCH_ASSOC);

  	    

		}
		
        $__URUN__ = false;
        foreach ($pageoku as $tr) {
        $__URUN__ = true;	
			
			
		?>	
								
								
                                <tr>
                                  
									<td style="width: 50px !important;"><?php echo $tr['urunkodu']?></td>
                                    <td><a target="_blank" href="../urun/<?php echo $tr['seo']?>"><?php echo mb_substr($tr['adi'],0,30);?> ...</a></td>
                                    <td><?php echo $tr['sira']?></td>
									<td>
									<?php 
                                    $katidler = $tr['kategori'];
                                    $katidler = explode(',', $katidler);
                                    foreach( $katidler as $anahtar => $katdeger ){?>
                                    <?php $kat = $ozy->query("select * from kategoriler where id='$katdeger'")->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($kat as $de) {?>
									<a target="_blank" href="../kategori/<?php echo $de['seo']; ?>"><?php echo mb_substr($de['adi'],0,30);?>...</a>
									<?php } ?>
									</br>
                                    <?php } ?>
									</td>
									
                                    <td><a class="image-popup-no-margins" href="../resimler/urunler/<?php echo $tr['resim']?>">
									<img class="lazyload" height="30px" width="30px" data-src="../resimler/urunler/<?php echo $tr['resim']?>"></a></td>
							      
                                    <td>
									<?php if($tr['durum']=='1'){?>
									<span style="font-size: 13px;" class="badge badge-success">Aktif</span>
                                    <?php } else { ?>
									<span style="font-size: 13px;" class="badge badge-pill badge-danger">Pasif</span>
                                    <?php } ?>
									</td>
									<td><?php echo $tr['hit']?></td>
                                    <td>
									
									<a href="tum-urunler?temizle=<?php echo $tr['id'];  ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
			                        <a href="urun/duzenle/<?php echo $tr['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>					
												
				
									
									
									</td>
                                </tr>
                               
		                <?php }

                        if (!$__URUN__){
                            echo " Henüz eklenmiş bir ürün bulunamadı.";
                        }

                         ?>					   
							   
							   
							   
							   
                                </tbody>
                            </table>

		  
		  
		  <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
		  <b>Toplam : <?php echo $toplam;?> adet ürün bulundu.</b>
		  <ul class="pagination">
					
  	     <?php
                for ($i= $pages - $forlimit ; $i < $pages + $forlimit + 1 ; $i++) { 
                  if ($i>0 and $i<=$sayfasayisi) {
                    
                    if ($i == $pages) {
          
                  echo '
		   <li class="paginate_button page-item active">
		   <a href="" aria-controls="datatable" data-dt-idx="1" tabindex="0" class="page-link">'.$i.'</a>
		   </li>';
               }else{
          
                  echo ' 
				  
				
		  <li class="paginate_button page-item ">
		  <a href="tum-urunler?pages='.$i.'&siralama='.$_GET['siralama'].'&urunara='.$_GET['urunara'].'" aria-controls="datatable" data-dt-idx="'.$i.'" tabindex="0" class="page-link">'.$i.'</a>
		  </li>
				  
				  ';
          
          }

                  }
                }
          
          
          
          
                   ?>  
			
			
		   <li class="paginate_button page-item ">
		   <?php $ileri = $i;?>
		  <a href="tum-urunler?pages=<?php echo $i;?>&siralama=<?php echo $_GET['siralama'];?>&urunara=<?php echo $_GET['urunara'];?>" aria-controls="datatable" data-dt-idx="<?php echo $ileri;?>" tabindex="0" class="page-link">>></a>
		  </li>
		 
		
	
		  </ul>
		  </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper --><style>@media screen and (max-device-width: 480px) and (orientation: portrait){	.tablem{    border-collapse: collapse;    border-spacing: 0;    width: 100%;    overflow: scroll;    display: block;}}</style>
