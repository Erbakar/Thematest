<?php define("guvenlik",true);?>
<?php
admin_yetki($ozy, $_SESSION['departmanid'], 3); 

function  giriskontrolx($ozy,$pgs){
	if($_SESSION['kullaniciadi'] && $_SESSION['sifre'] )
{
		$kullaniciadi = trim($_SESSION['kullaniciadi']);
		$sifre = trim($_SESSION['sifre']);
		$login_kontrol = $ozy->query("SELECT * FROM admin WHERE kullaniciadi = '{$kullaniciadi}' and sifre = '{$sifre}'")->fetch(PDO::FETCH_ASSOC);
		if ( $login_kontrol ){
			if($pgs == 0)
			{
				header("Location: index.php");
			}

}
		else {
			if($pgs != 0)
			{
				header("Location: index.php");
			exit();
			}

		}
}
else {
	if ($pgs != 0)
	{
		header("Location: index.php");
			exit();
	}


}
}
giriskontrolx($ozy,1);

if(!isset($_SESSION["giris"])){
    header("Location:index.php");
}
else {
 
}


if($_GET['tema']){
$id = temizle($_GET['tema']);
$sayfam = $ozy->query("select * from temalar where  id=$id")->fetch(PDO::FETCH_ASSOC); 
if (isset($_POST['guncelle'])) {


 
  $t4 = ($_POST['t4'] != "") ? $_POST['t4'] : "0";
  $t5 = ($_POST['t5'] != "") ? $_POST['t5'] : "0";
  $t6 = ($_POST['t6'] != "") ? $_POST['t6'] : "0";
  $t7 = ($_POST['t7'] != "") ? $_POST['t7'] : "0";
  $t8 = ($_POST['t8'] != "") ? $_POST['t8'] : "0";
  $t10 = ($_POST['t10'] != "") ? $_POST['t10'] : "0";
  $t11 = ($_POST['t11'] != "") ? $_POST['t11'] : "0";
  $t13 = ($_POST['t13'] != "") ? $_POST['t13'] : "0";
  $t50 = "display:none";
  $t49 = "Kategori Resmi";
  $t48 = "Kategori Story Resmi";
  $t47 = "Kategori Menü & Anasayfa Resmi";
  
  $temakonumv1 = $_FILES['t1']['tmp_name'];
  $temaadv1 = $_FILES['t1']['name'];
  $tematipv1 = $_FILES['t1']['type'];
  $tuzanti1 = substr($temaadv1, -5, 5);
  $t1 =  md5('t1_' . $temaadv1) . $tuzanti1;
  $temav1yol = "../resimler/temaayarlari";
  
  $temakonumv2 = $_FILES['t2']['tmp_name'];
  $temaadv2 = $_FILES['t2']['name'];
  $tematipv2 = $_FILES['t2']['type'];
  $tuzanti2 = substr($temaadv2, -5, 5);
  $t2 =  md5('t2_' . $temaadv2) . $tuzanti2;
  $temav2yol = "../resimler/temaayarlari";
  
  $temakonumv3 = $_FILES['t3']['tmp_name'];
  $temaadv3 = $_FILES['t3']['name'];
  $tematipv3 = $_FILES['t3']['type'];
  $tuzanti3 = substr($temaadv3, -5, 5);
  $t3 =  md5('t3_' . $temaadv3) . $tuzanti3;
  $temav3yol = "../resimler/temaayarlari";
  
  
  $temakonumv4 = $_FILES['anabanner']['tmp_name'];
  $temaadv4 = $_FILES['anabanner']['name'];
  $tematipv4 = $_FILES['anabanner']['type'];
  $tuzanti4 = substr($temaadv4, -5, 5);
  $anabanner =  md5('anabanner_' . $temaadv4) . $tuzanti4;
  $temav4yol = "../resimler/temaayarlari";
  
  $temakonumv5 = $_FILES['t9']['tmp_name'];
  $temaadv5 = $_FILES['t9']['name'];
  $tematipv5 = $_FILES['t9']['type'];
  $tuzanti5 = substr($temaadv5, -5, 5);
  $t9 =  md5('t9_' . $temaadv5) . $tuzanti5;
  $temav5yol = "../resimler/temaayarlari";
  
  $temakonumv6 = $_FILES['t12']['tmp_name'];
  $temaadv6 = $_FILES['t12']['name'];
  $tematipv6 = $_FILES['t12']['type'];
  $tuzanti6 = substr($temaadv6, -5, 5);
  $t12 =  md5('t12_' . $temaadv6) . $tuzanti6;
  $temav6yol = "../resimler/temaayarlari";
  
  
  if (!empty($_FILES['t1']['name'])) {
        if ($tematipv1 != 'image/jpeg' && $tematipv1 != 'image/png' && $tuzanti1 != '.jpg' && $tuzanti1 != '.png' && $tuzanti1 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav1 = move_uploaded_file($temakonumv1, $temav1yol . '/' . $t1);
            $temav1 = $ozy->prepare("update temalar set t1=? where id='$id'");
            $temav1->execute(array($t1));
		}
	
  }
  
  

  if (!empty($_FILES['t2']['name'])) {
        if ($tematipv2 != 'image/jpeg' && $tematipv2 != 'image/png' && $tuzanti2 != '.jpg' && $tuzanti2 != '.png' && $tuzanti2 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav2 = move_uploaded_file($temakonumv2, $temav2yol . '/' . $t2);
            $temav2 = $ozy->prepare("update temalar set t2=? where id='$id'");
            $temav2->execute(array($t2));
		}
	
  }
  
 
  if (!empty($_FILES['t3']['name'])) {
        if ($tematipv3 != 'image/jpeg' && $tematipv3 != 'image/png' && $tuzanti3 != '.jpg' && $tuzanti3 != '.png' && $tuzanti3 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav2 = move_uploaded_file($temakonumv3, $temav3yol . '/' . $t3);
            $temav2 = $ozy->prepare("update temalar set t3=? where id='$id'");
            $temav2->execute(array($t3));
		}
	
  }
  
    if (!empty($_FILES['anabanner']['name'])) {
        if ($tematipv4 != 'image/jpeg' && $tematipv4 != 'image/png' && $tuzanti4 != '.jpg' && $tuzanti4 != '.png' && $tuzanti4 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav4 = move_uploaded_file($temakonumv4, $temav4yol . '/' . $anabanner);
            $temav4 = $ozy->prepare("update temalar set anabanner=? where id='$id'");
            $temav4->execute(array($anabanner));
		}
	
  }
  
  if (!empty($_FILES['t9']['name'])) {
        if ($tematipv5 != 'image/jpeg' && $tematipv5 != 'image/png' && $tuzanti5 != '.jpg' && $tuzanti5 != '.png' && $tuzanti5 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav2 = move_uploaded_file($temakonumv5, $temav5yol . '/' . $t9);
            $temav2 = $ozy->prepare("update temalar set t9=? where id='$id'");
            $temav2->execute(array($t9));
		}
	
  }
  
  if (!empty($_FILES['t12']['name'])) {
        if ($tematipv6 != 'image/gif' && $tematipv6 != 'image/jpeg' && $tematipv6 != 'image/png' && $tuzanti6 != '.jpg' && $tuzanti6 != '.png' && $tuzanti6 != '.jpeg' && $tuzanti6 != '.gif') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav6 = move_uploaded_file($temakonumv6, $temav6yol . '/' . $t12);
            $temav6 = $ozy->prepare("update temalar set t12=? where id='$id'");
            $temav6->execute(array($t12));
		}
	
  }
  
  

   $stmt = $ozy->prepare("UPDATE temalar SET t4 = ?, t5 = ?, t6 = ?, t7 = ?, t8 = ?, t10 = ?, t11 = ?, t13 = ?, t50 = ?, t49 = ?, t48 = ?, t47 = ? WHERE id = ?");
   $result2 = $stmt->execute(array($t4, $t5, $t6, $t7, $t8, $t10, $t11, $t13, $t50, $t49, $t48, $t47, $id));
   
   
   
   
    if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=temaayarlari?tema='.$id.'">';

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }







	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


}
	
	
	
	
///////TEMA YÜKLEME ALANI//////	
ini_set('memory_limit', '128M');
set_time_limit(0);

function recursive_dir($dir) {
    foreach(scandir($dir) as $file) {
	    if ('.' === $file || '..' === $file) continue;
		    if (is_dir("$dir/$file")) recursive_dir("$dir/$file");
				    else unlink("$dir/$file");
			}
	    rmdir($dir);
	}
 
if($_FILES["zip_file"]["name"]) {
	$filename = $_FILES["zip_file"]["name"];
	$source = $_FILES["zip_file"]["tmp_name"];
	$type = $_FILES["zip_file"]["type"];
 
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
		$okay = true;
		break;
	}
}
 
$continue = strtolower($name[1]) == 'zip' ? true : false;
if(!$continue) {
	echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen sadece zip uzantılı bir dosya yükleyiniz...", "Başarısız");});</script>';
    
}
 
if ($_SERVER['PATH_TRANSLATED'])
{
    $yol = $_SERVER['PATH_TRANSLATED'];
}
else if ($_SERVER['SCRIPT_FILENAME'])
{
    $yol = $_SERVER['SCRIPT_FILENAME'];
}
else
{
    echo 'Yol Bulunamadı.';
    exit;
}

$path = substr($yol, 0, (strlen($yol) - 17));	
$filenoext = basename ($filename, '.zip'); 
$filenoext = basename ($filenoext, '.ZIP');
 
$myDir = $path . $filenoext; // target directory
$myFile = $path . $filename; // target zip file
 

if (is_dir($myDir)) recursive_dir ( $myDir);
     
mkdir($myDir, 0777);
 
/* here it is really happening */
 
if(move_uploaded_file($source, $myFile)) {
	$zip = new ZipArchive();
	$x = $zip->open($myFile); // open the zip file to extract
if ($x === true) {
	$zip->extractTo($myDir); // place in the directory with same name
	$zip->close();
    unlink($myFile);
}

   $t1 = "1";
   $dosyaadi = mb_substr($filename,0,-4);
   $temaadi = "".$dosyaadi.".png";
$fp = fopen(''.$myDir.'/.htaccess','w');
if($fp)
{
fwrite($fp,'RewriteEngine on
RewriteRule ^index(\.html)$ index.html [L,QSA]
RewriteRule ^index(\.php)$ index.html [L,QSA]

<Files ~ ".(xml|php|asp|aspx)$">
order deny,allow
deny from all
</Files>

<files captcha.php>
order allow,deny
allow from all
</files>');
fclose($fp);
}
   
   $temastmt = $ozy->prepare("INSERT INTO temalar (adi, temaresim) 
   VALUES (?,?)");
   $temaresult2 = $temastmt->execute(array($dosyaadi, $temaadi));
   
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Tema başarıyla yüklendi. Site ayarlarından temanızı aktif edebilirsiniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=temaayarlari?tema='.$id.'">';
   
	
	
} else {	
	echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Bir hata oluştu...", "Başarısız");});</script>';
    
}
}
///////TEMA YÜKLEME ALANI//////

if (isset($_GET['temasil'])) {
	
$temaid = temizle($_GET['temasil']);
$temabulduk = $ozy->query("select * from temalar where id='{$temaid}'")->fetch(PDO::FETCH_ASSOC);
$temasil = $ozy->prepare("delete from temalar where id='{$temaid}'");
$temasil->execute(array($temaid));

if ($temasil) {
	$temaklasoradi = $temabulduk['adi'];

if ($_SERVER['PATH_TRANSLATED'])
{
    $yol = $_SERVER['PATH_TRANSLATED'];
}
else if ($_SERVER['SCRIPT_FILENAME'])
{
    $yol = $_SERVER['SCRIPT_FILENAME'];
}
else
{
    echo 'Yol Bulunamadı.';
    exit;
}

$path = substr($yol, 0, (strlen($yol) - 17));	

     
	 
	 
	klasorsil("".$path."/".$temaklasoradi."");
	
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';
    echo '<meta http-equiv="refresh" content="1; url=temaayarlari?tema='.$id.'">';

}else{
	echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Tema mevcut değil.", "Başarısız");});</script>';
    
} 

	
}




?>



<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Genel Tema Ayarları
						</h4>
                    </div>
					

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>
                            
                            <li class="breadcrumb-item active">Genel Tema Ayarları
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
                       					
					
					
					
					
					
					
					
					
					
					        <?php if($ayar['tema']=='default'){?>
							   
							   
							
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Sol Banner</label>
                                <div class="col-sm-10">
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									
									<img src="../resimler/temaayarlari/<?php echo $sayfam['t1']; ?>" style="width: 200px; height: 200px;" alt="" />
                                    
									
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                    <span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                    <input name="t1" type="file" class="default" />
                                    </span>
                                    <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                    </div>
                                    </div>
                                    </div>
                                   
								</div>
                                            
                            </div>	
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Sol Banner Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t4" value="<?php echo $sayfam['t4']; ?>">
                                </div>
                            </div>   
						    
								
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Orta Banner</label>
                                <div class="col-sm-10">
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									<img src="../resimler/temaayarlari/<?php echo $sayfam['t2']; ?>" style="width: 200px; height: 200px;" alt="" />
                                    
									
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                    <span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                    <input name="t2" type="file" class="default" />
                                    </span>
                                    <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                    </div>
                                    </div>
                                    </div>
                                   
								</div>
                                            
                            </div>
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Orta Banner Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t5" value="<?php echo $sayfam['t5']; ?>">
                                </div>
                            </div>   
							
							
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Sağ Banner</label>
                                <div class="col-sm-10">
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									
									<img src="../resimler/temaayarlari/<?php echo $sayfam['t3']; ?>" style="width: 200px; height: 200px;" alt="" />
                                    
									
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                    <span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                    <input name="t3" type="file" class="default" />
                                    </span>
                                    <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                    </div>
                                    </div>
                                    </div>
                                   
								</div>
                                            
                            </div>
                   
                              <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Sağ Banner Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t6" value="<?php echo $sayfam['t6']; ?>">
                                </div>
                            </div>   


	
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Geniş Banner</label>
                                <div class="col-sm-10">
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									<img src="../resimler/temaayarlari/<?php echo $sayfam['anabanner']; ?>" style="width: 200px; height: 200px;" alt="" />
                                    
									
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                    <span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                    <input name="anabanner" type="file" class="default" />
                                    </span>
                                    <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                    </div>
                                    </div>
                                    </div>
                                   
								</div>
                                            
                            </div>
                   
                              <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Geniş Banner Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t7" value="<?php echo $sayfam['t7']; ?>">
                                </div>
                            </div>   



                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Footer Açıklama Metni</label>
                                <div class="col-sm-10">
                                  <textarea id="textarea" class="form-control" rows="6" name="t8"><?php echo $sayfam['t8']; ?></textarea>  
                                </div>
                                            
                            </div>	

		    <?php if($_GET['tema']){?>
	        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Popup Durumu</label>
            <div class="col-sm-10">
            <input type="checkbox" id="firsatdurumu" <?php if($sayfam['t11'] == '1') {?> checked="" <?php } ?> value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="t11"></div>                                      
            </div>   
            <?php } else { ?>
	        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Popup Durumu</label>
            <div class="col-sm-10">
            <input type="checkbox" id="firsatdurumu" value="1" data-toggle="toggle" data-onstyle="primary" data-offstyle="secondary" name="t11"></div>
            </div> 							
	        <?php } ?>		
                             
									
										
								 <div class="form-group row" id="firsatdurumum" style="<?php if($sayfam['t11'] !== '1') {?> display:none; <?php } ?> ">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Popup Resmi</label>
                               <div class="col-sm-10">
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									
									
									
									
									
									<img src="../resimler/temaayarlari/<?php echo $sayfam['t9']; ?>" style="width: 200px; height: 200px;" alt="" />
                                    
									
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                    <span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                    <input name="t9" type="file" class="default" />
                                    </span>
                                    <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                    </div>
                                    </div>
                                    </div>
                                   
								</div>
                                            
                            </div>
                   

                            <div class="form-group row" id="firsatdurumumx" style="<?php if($sayfam['t11'] !== '1') {?> display:none; <?php } ?> ">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Popup Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t10" value="<?php echo $sayfam['t10']; ?>">
                                </div>
                            </div>   
						             


                         
									
									
								   <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Üst Alan Banner (Gif Eklebilir)</label>
                                <div class="col-sm-10">
                                    
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									
									
									
									
									
									
									
									<img src="../resimler/temaayarlari/<?php echo $sayfam['t12']; ?>" style="width: 200px; height: 200px;" alt="" />
                                    
									
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                    <span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                    <input name="t12" type="file" class="default" />
                                    </span>
                                    <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                    </div>
                                    </div>
                                    </div>
                                   
								</div>
                                            
                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Üst Banner Linki </br> (Boş bırakırsanız banner pasif olacaktır)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t13" value="<?php echo $sayfam['t13']; ?>">
                                </div>
                            </div>   


									 

                           <?php } ?>




							
								
								
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
	<style>

	.box{
		width: 100%;
		margin:0 auto;
		border:1px solid #7487EF;
	}
	.heading{
height: 30px;
border-bottom: 1px solid #7487EF;
background: #7487EF;
font-size: 14px;
text-align: center;
line-height: 30px;
color: white;
font-weight: 500;
	}
	.msg{
		text-align: center;
		line-height: 30px;
		color: #FF0000;
	}
	.form_field{
		margin: 20px 0 0 20px;
		text-align: center;
	}
	label{
		
		padding: 0 20px 0 10px;
	}
	.upload{
	
	}
</style> 