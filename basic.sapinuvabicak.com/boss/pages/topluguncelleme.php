<?php
paket_kontrol(["plus", "extreme", "enterprise"]); 
admin_yetki($ozy, $_SESSION['departmanid'], 5); 
if (isset($_POST['guncelle'])) { 

 
 
 
 
 
 
 
if($_POST['t1']=='on'){
if($_POST['a1']=='1'){


	
$kstok = $_POST['b1'];

$okey = $ozy->exec("UPDATE urunler SET stok=stok+'$kstok'");
if ($okey) {
	
	 echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
	
}	
	
} else {
	
$kstok = $_POST['b1'];


$okey = $ozy->exec("UPDATE urunler SET stok=stok-'$kstok'");
if ($okey) {
	
	  echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
}	




	  	
}

} else {
$kstok = $son['stok'];

}


if($_POST['t4']=='on'){
if($_POST['a4']=='0'){


	
$iurunfiyat = $_POST['b4'];
$okey = $ozy->exec("UPDATE urunler SET ifiyat=ifiyat+((ifiyat*'$iurunfiyat')/100)");
if ($okey) {
	
	  echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
	
}	
	
	
} elseif($_POST['a4']=='1'){
	
	
$iurunfiyat = $_POST['b4'];
$okey = $ozy->exec("UPDATE urunler SET ifiyat=ifiyat-((ifiyat*'$iurunfiyat')/100)");
if ($okey) {
	
echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
	
}	


	
} elseif($_POST['a4']=='2'){

$iurunfiyat = $_POST['b4'];
$okey = $ozy->exec("UPDATE urunler SET ifiyat=ifiyat+'$iurunfiyat'");
if ($okey) {
	
	 echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
}



 	
} elseif($_POST['a4']=='3'){

$iurunfiyat = $_POST['b4'];
$okey = $ozy->exec("UPDATE urunler SET ifiyat=ifiyat-'$iurunfiyat'");
if ($okey) {
	
	   echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
}



} else {
$ifiyat = $son['ifiyat'];

}
}


if($_POST['t2']=='on'){
if($_POST['a2']=='0'){


	
$urunfiyat = $_POST['b2'];
$okey = $ozy->exec("UPDATE urunler SET fiyat=fiyat+((fiyat*'$urunfiyat')/100)");
if ($okey) {
	
	   echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
}	
	
	
} elseif($_POST['a2']=='1'){
	
$urunfiyat = $_POST['b2'];
$okey = $ozy->exec("UPDATE urunler SET fiyat=fiyat-((fiyat*'$urunfiyat')/100)");
if ($okey) {
	
	  echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
	
}


	
} elseif($_POST['a2']=='2'){

$urunfiyat = $_POST['b2'];
$okey = $ozy->exec("UPDATE urunler SET fiyat=fiyat+'$urunfiyat'");
if ($okey) {
	
	   echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
}



 	
} elseif($_POST['a2']=='3'){

$urunfiyat = $_POST['b2'];
$okey = $ozy->exec("UPDATE urunler SET fiyat=fiyat-'$urunfiyat'");
if ($okey) {
	
	   echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
	
}



} else {
$urunfiyat = $son['fiyat'];

}
}








if($_POST['t6']=='on'){



	

$silstoksuzurun = $ozy->prepare("DELETE FROM urunler WHERE stok=?");
$silstoksuzurun->execute(array(0));
if ($silstoksuzurun) {
	
	    echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
}

}




if($_POST['t5']=='on'){
if($_POST['a5']=='0'){


	
$iurunfiyat = $_POST['b5'];
$okey = $ozy->exec("UPDATE urunler SET hfiyat=hfiyat+((hfiyat*'$iurunfiyat')/100)");
if ($okey) {
	
	  echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
	
}	
	
	
} elseif($_POST['a5']=='1'){
	
	
$iurunfiyat = $_POST['b5'];
$okey = $ozy->exec("UPDATE urunler SET hfiyat=hfiyat-((hfiyat*'$iurunfiyat')/100)");
if ($okey) {
	
echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
	
}	


	
} elseif($_POST['a5']=='2'){

$iurunfiyat = $_POST['b5'];
$okey = $ozy->exec("UPDATE urunler SET hfiyat=hfiyat+'$iurunfiyat'");
if ($okey) {
	
	 echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
}



 	
} elseif($_POST['a5']=='3'){

$iurunfiyat = $_POST['b5'];
$okey = $ozy->exec("UPDATE urunler SET hfiyat=hfiyat-'$iurunfiyat'");
if ($okey) {
	
	   echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	
	
}



} else {
$ifiyat = $son['hfiyat'];

}
}





}

?>


<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Toplu Güncelleme</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                           
                            <li class="breadcrumb-item active">Toplu Güncelleme</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <form action="" method="POST">
			
				
				
				
                              <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label"><input name="t1" type="checkbox"> Stok</label>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" name="b1" value="">
                                </div>
								<div class="col-sm-5">
								<select name="a1" class="form-control">
				                <option value="1">ARTTIR</option>
				                <option value="0">AZALT</option>
				                </select>
								</div>
                            </div>
							
				
			                 <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label"><input name="t2" type="checkbox"> Normal Fiyatı</label>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" name="b2" value="">
                                </div>
								<div class="col-sm-5">
								<select name="a2" class="form-control">
				                <option value="0">% ARTTIR</option>
				                <option value="1">% AZALT</option>
				                <option value="2">NORMAL ARTTIR</option>
				                <option value="3">NORMAL AZALT</option>
				                </select>
								</div>
                            </div>
							
			

				            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label"><input name="t4" type="checkbox"> İndirimli Fiyatı</label>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" name="b4" value="">
                                </div>
								<div class="col-sm-5">
								<select name="a4" class="form-control">
				                <option value="0">% ARTTIR</option>
				                <option value="1">% AZALT</option>
				                <option value="2">NORMAL ARTTIR</option>
				                <option value="3">NORMAL AZALT</option>
				                </select>
								</div>
                            </div>
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label"><input name="t5" type="checkbox"> Havale Fiyatı</label>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" name="b5" value="">
                                </div>
								<div class="col-sm-5">
								<select name="a5" class="form-control">
				                <option value="0">% ARTTIR</option>
				                <option value="1">% AZALT</option>
				                <option value="2">NORMAL ARTTIR</option>
				                <option value="3">NORMAL AZALT</option>
				                </select>
								</div>
                            </div>
							
		
				            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label"><input name="t6" type="checkbox"> Tükenen Ürünleri Gizle</label>
                              
				
                            </div>


				

				
				
			<button type="submit" name="guncelle" class="btn btn-warning btn-lg btn-block waves-effect waves-light">Güncelle</button>
                         
                          
						
				
		</form>	
				

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
