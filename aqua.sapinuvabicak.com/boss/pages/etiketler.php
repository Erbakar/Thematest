<?php 
admin_yetki($ozy, $_SESSION['departmanid'], 3); 
if (isset($_GET['temizle'])) {
	
$id = temizle($_GET['temizle']);

$sayfasil = $ozy->prepare("delete from etiketler where id='$id'");
$sayfasil->execute(array($id));

if ($sayfasil) {
	


echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';
	
}


}



if($_GET['duzenle']){
$id = temizle($_GET['duzenle']);
$sayfam = $ozy->query("select * from etiketler where id=$id")->fetch(PDO::FETCH_ASSOC); 
///Sayfa güncelleme kodları başlangıç
if (isset($_POST['guncelle'])) {



   $adi   = temizle($_POST['adi']);
   $link   = temizle($_POST['link']);
   $durum   = temizle($_POST['durum']);
   $sira   = temizle($_POST['sira']);
   
   $id = $_GET['duzenle'];
   $stmt = $ozy->prepare("UPDATE etiketler SET adi = ?, link = ?, durum = ?, sira = ? WHERE id = ?");
   $result2 = $stmt->execute(array($adi, $link, $durum, $sira, $id));
    
   
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url='.$url.'/boss/etiket/duzenle/'.$id.'">'; 		

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }






}




////Sayfa güncelleme kodları bitiş

}else{
	

if (isset($_POST['kaydet'])) {
	
  $adi   = temizle($_POST['adi']);
  $link   = temizle($_POST['link']);
  $durum   = temizle($_POST['durum']);
  $sira   = temizle($_POST['sira']);
  $tarih   = date('d.m.Y H:i:s');

   $stmt = $ozy->prepare("INSERT INTO etiketler (adi, link, durum, sira, tarih) 
   VALUES (?,?,?,?,?)");
   $result2 = $stmt->execute(array($adi, $link, $durum, $sira, $tarih));
 
   if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi eklediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=etiketler">'; 
  



   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }
   
   


////Sayfa oluşturma kodları bitiş




}

}

	
	



?>


<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Etiketler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                            <li class="breadcrumb-item active">Etiketler</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Etiketler Listesi</h4>
                            
        <div class="custom-dd dd">
	
		
		<?php $etikets = $ozy->query("select * from etiketler order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
        foreach($etikets as $etiket){?>
        <li class='dd-item'> 
		<div class='dd-handle'>
		<?php echo $etiket['adi'];?>
		<div style="width: 100px !important;float: right;margin-right: -50px;">
		<a href="etiketler?temizle=<?php echo $etiket['id'];?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>									 
		<a href="etiket/duzenle/<?php echo $etiket['id'];?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit" aria-hidden="true"></i></a>					
		</div>							
		</div>
        </li>
        <?php } ?>	
     

							
		</div>

                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-8">
                    <div class="card m-b-30">
                        <div class="card-body">

                    <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                    <div class="card m-b-30">
                        <div class="card-body">
                         <!-- Nav tabs -->
                  


                          <div class="tab-content">
						  
						  
						  
						  
						  
						  

                           
                          <div class="tab-pane active p-3" id="home-1" role="tabpanel">
                          
							      
						  <div class="form-group">
					      <label for="example-text-input" class="col-form-label">Etiket Sırası</label>
					      <div class="controls">
					      <input type="text" class="form-control" value="<?php echo $sayfam['sira']; ?>" name="sira">
				          </div>
			              </div> 

                          <div class="form-group">
					      <label for="example-text-input" class="col-form-label">Etiket Adı</label>
					      <div class="controls">
					      <input type="text" class="form-control" value="<?php echo $sayfam['adi']; ?>" name="adi" required>
				          </div>
			              </div> 

						  
                          <div class="form-group">
					      <label for="example-text-input" class="col-form-label">Etiket Linki</label>
					      <div class="controls">
					      <input type="text" class="form-control" value="<?php echo $sayfam['link']; ?>" name="link">
				          </div>
			              </div> 
						  
						 <?php if($_GET['duzenle']){?>
						  <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                <div class="col-sm-10">
                                <input type="checkbox" <?php if($sayfam['durum'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>
                                            
                          </div>   
                        <?php } else { ?>
						 <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Durumu</label>
                                <div class="col-sm-10">
                                <input type="checkbox"  checked="" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="durum"></div>
                                            
                          </div> 

						<?php } ?> 
                         
					
								
						  </div>
                                 



                        




                         <?php if($_GET['duzenle']){?>
						  
						  <button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>
                         
                          <?php } else { ?>
						 
                          <button type="submit" name="kaydet" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Kaydet</button>
                         
						
								 
                         <?php } ?>     

			             
						 
						 </div>	
								
								
								
								
								
								
								
								
								
                            </div>
							</form>


 
						</div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row --> 

        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
	<script>
$(function() {
  $("#addMore").click(function(e) {
    e.preventDefault();
    $("#fieldList").append("</br>");
	$("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control' name='sira[]' placeholder='Filtre Sırası'/>");
    $("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control' name='fadi[]' placeholder='Filtre Ana Başlık'>");
    $("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control tags-input' name='ozellik[]' data-role='tagsinput' placeholder='Filtrelenecek Öğeler'>");
	$('.tags-input').tagsinput('refresh');
  });
});
</script>
