<?php
admin_yetki($ozy, $_SESSION['departmanid'], 4); 

if (isset($_POST['guncelle'])) {



   ////FİLTRE EKLEME KODLARI BAŞLANGIÇ////   
   $fsira   = ($_POST['fsira'] != "") ? $_POST['fsira'] : "0";
   $fadi   = $_POST['fadi'];
   $fozellik   = $_POST['ozellik'];
   $fid   = ($_POST['fid'] != "") ? $_POST['fid'] : "0";
   $kategori   = $_POST['kategori'.$fid];

 
$result = array_map(function ($sira, $fadi, $ozellik, $fid) {
  return array_combine(
    ['sira', 'fadi', 'ozellik', 'fid'],
    [$sira, $fadi, $ozellik, $fid]
  );
}, $fsira, $fadi, $fozellik, $fid);

foreach($result as $filtre){

$filtresira = $filtre['sira'];
$filtreadi = $filtre['fadi'];
$filtreozellik = $filtre['ozellik'];
$filtreid = $filtre['fid'];

$kategoriler="";
foreach ($_POST['kategori'.$filtreid] as $yenifiltreid){
$kategoriler.="".$yenifiltreid.",";	
}	

$bak = $ozy->query("SELECT fid FROM filtre WHERE fid = '" . $filtreid . "' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC);
if (count($bak) > 0) {

$fstmt = $ozy->prepare("UPDATE filtre SET sira=?, fadi=?, ozellik=?, kategori=? WHERE fid=?"); 
$result2f = $fstmt->execute(array($filtresira, $filtreadi, $filtreozellik, $kategoriler, $filtreid));
  
 	
} else {	
$kid = "";	
$fstmt = $ozy->prepare("INSERT INTO filtre (sira, fadi, ozellik, kategori) 
VALUES (?,?,?,?)");
$result2f = $fstmt->execute(array($filtresira, $filtreadi, $filtreozellik,$kid));

}   
 
}	
////FİLTRE EKLEME KODLARI BİTİŞ//// 	


    if($result2f){
    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	'<meta http-equiv="refresh" content="1; url=filtreleme-islemleri">';

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';


   }






}





if (isset($_GET['fsil'])) {
	
$fid = temizle($_GET['fsil']);
$fsayfasil = $ozy->prepare("delete from filtre where fid='$fid'");
$fsayfasil->execute(array($fid));

if ($fsayfasil) {
	

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
                        <h4 class="page-title">Kategori Filtreleme Kopyalama

						</h4>
                    </div>
	



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                            <li class="breadcrumb-item active">Kategori Filtreleme Kopyalama
							</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
			     <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                    <div class="card m-b-30">
                        <div class="card-body">
                         


                          <div class="tab-content">








                          <div class="tab-pane active p-3" id="home-1" role="tabpanel">




                            <?php $filtre = $ozy->query("select * from filtre order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                            foreach($filtre as $filtreee){?>
                            <input type="hidden" name="fid[]" value="<?php echo $filtreee['fid']; ?>">
	                        <div class="form-group row">
							 <div class="col-sm-2" style="font-weight: 500;"></br>
							 Filtre Sırası :</br></br>
							  Filtre Başlığı :</br></br>
							   Filtre Verileri :</br></br></br></br></br>
							    Filtre Kategorileri :
							 </div>
		                    <div class="col-sm-10" style="background: #f1efef;padding: 20px;margin: 0px !important;width: 100% !important;">
							<input class="form-control" type="text"  name="fsira[]" value="<?php echo $filtreee['sira']; ?>">
			                <input class="form-control" type="text"  name="fadi[]" value="<?php echo $filtreee['fadi']; ?>">
							<input class="form-control" type="text" data-role="tagsinput" name="ozellik[]" value="<?php echo $filtreee['ozellik']; ?>">
		                    <select class="form-control js-example-basic-multiple" name="kategori<?php echo $filtreee['fid']; ?>[]" multiple="multiple">
							<?php $kat = $ozy->query("select * from kategoriler")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($kat as $de) { ?>
							<?php $katidler = $filtreee['kategori'];
							$katidler = explode(',', $katidler);
							foreach( $katidler as $anahtar => $katdeger ){?>
							<option value="<?php echo $de['id']; ?>" <?php if ($de['id'] == $katdeger) { ?> selected="selected" <?php }}  ?>><?php echo $de['adi']; ?></option>
                            <?php } ?>
							</select> 
							</br>
							<a style="margin-bottom: 10px;width: 100%;margin-top:10px;" href="filtreleme-islemleri?fsil=<?php echo $filtreee['fid'];  ?>" onclick="return confirm('Bu filtreleme özelliğini silmek istediğinize emin misiniz ?')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i><?php echo $filtrebak['fadi'];  ?> Özelliğini Sil</a>
							</div>
	                        </div>
						
						
						    <?php } ?>		
							
						
					
                        <form action="" method="post">
                        <ul id="fieldList" style="background: #f1efef;padding: 20px;margin: 0px !important;width: 100% !important;">
						<input type="text" class="form-control" style="margin-bottom: 5px;" name="fsira[]" placeholder="Filtre Sırası"/>
				        <input type="text" class="form-control" style="margin-bottom: 5px;" name="fadi[]" placeholder="Filtre Ana Başlık"/>
						<input type="text" class="form-control" style="margin-bottom: 5px;" name="ozellik[]" data-role="tagsinput" placeholder="Filtrelenecek Öğeler"/>
                        </br>
						</ul>
						<button style="margin-top: 20px;width: 100% !important;" class="btn btn-warning waves-effect waves-light" id="addMore">Yeni Filtreme Alanı Ekle</button>
                        </form>		


							</div>













                        
















                                </div>







						 </div>







							 <button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>


                            </div>
							</form>

                        </div>
                    </div>
                </div> <!-- end col -->

            </div> <!-- end row -->

        </div>
        <!-- end container-fluid -->
    </div>
	
	
<script>
$(function() {
  $("#addMore").click(function(e) {
    e.preventDefault();
    $("#fieldList").append("</br>");
	$("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control' name='fsira[]' placeholder='Filtre Sırası (En yüksek değer en önde sıralanır.)'/>");
    $("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control' name='fadi[]' placeholder='Filtre Ana Başlık'>");
    $("#fieldList").append("<input type='text' style='margin-bottom: 5px;' class='form-control tags-input' name='ozellik[]' data-role='tagsinput' placeholder='Filtrelenecek Öğeler'>");
	$('.tags-input').tagsinput('refresh');
  });
});
</script>
		<style>
.input-group-addon {
    padding: .375rem .75rem;
    margin-bottom: 0;
    font-size: 0.9rem !important;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    text-align: center;
    white-space: nowrap;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    float: right !important;
    margin-top: -36px !important;
}
	</style>