<?php define("guvenlik",true);?>
<?php
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


 
  
  // Sadece POST'ta değer olan alanları güncelle, yoksa mevcut değerleri koru
  // $sayfam zaten yukarıda satır 47'de alınmış
  // Her alan için sadece POST'ta varsa güncelle, yoksa mevcut değeri kullan
  $updateFields = array();
  $updateValues = array();
  
  if (isset($_POST['t5'])) {
    $updateFields[] = "t5 = ?";
    $updateValues[] = $_POST['t5'];
  }
  if (isset($_POST['t6'])) {
    $updateFields[] = "t6 = ?";
    $updateValues[] = $_POST['t6'];
  }
  if (isset($_POST['t7'])) {
    $updateFields[] = "t7 = ?";
    $updateValues[] = $_POST['t7'];
  }
  if (isset($_POST['t8'])) {
    $updateFields[] = "t8 = ?";
    $updateValues[] = $_POST['t8'];
  }
  if (isset($_POST['t10'])) {
    $updateFields[] = "t10 = ?";
    $updateValues[] = $_POST['t10'];
  }
  if (isset($_POST['t11'])) {
    $updateFields[] = "t11 = ?";
    $updateValues[] = $_POST['t11'];
  }
  if (isset($_POST['t13'])) {
    $updateFields[] = "t13 = ?";
    $updateValues[] = $_POST['t13'];
  }
  if (isset($_POST['t33'])) {
    $updateFields[] = "t33 = ?";
    $updateValues[] = $_POST['t33'];
  }
  if (isset($_POST['t35'])) {
    $updateFields[] = "t35 = ?";
    $updateValues[] = $_POST['t35'];
  }
  if (isset($_POST['t36'])) {
    $updateFields[] = "t36 = ?";
    $updateValues[] = $_POST['t36'];
  }
  if (isset($_POST['t37'])) {
    $updateFields[] = "t37 = ?";
    $updateValues[] = $_POST['t37'];
  }
  if (isset($_POST['t38'])) {
    $updateFields[] = "t38 = ?";
    $updateValues[] = $_POST['t38'];
  }
  if (isset($_POST['t29'])) {
    $updateFields[] = "t29 = ?";
    $updateValues[] = $_POST['t29'];
  }
  if (isset($_POST['t40'])) {
    $updateFields[] = "t40 = ?";
    $updateValues[] = $_POST['t40'];
  }
  
  // t50, t49, t48, t47 için mevcut değerleri koru (bunlar form'dan gelmiyor)
  $t50 = isset($sayfam['t50']) && $sayfam['t50'] != "" ? $sayfam['t50'] : "display:none";
  $t49 = isset($sayfam['t49']) && $sayfam['t49'] != "" ? $sayfam['t49'] : "Kategori Detay Resmi ( Bu temada kullanılamaz )";
  $t48 = isset($sayfam['t48']) && $sayfam['t48'] != "" ? $sayfam['t48'] : "Kategori Hikaye Resmi ( Bu temada kullanılamaz )";
  $t47 = isset($sayfam['t47']) && $sayfam['t47'] != "" ? $sayfam['t47'] : "Kategori Anasayfa Resmi";
  
  $temakonumv1 = $_FILES['t1']['tmp_name'];
  $temaadv1 = $_FILES['t1']['name'];
  $tematipv1 = $_FILES['t1']['type'];
  $tuzanti1 = !empty($temaadv1) ? substr($temaadv1, -5, 5) : '';
  $t1_file = !empty($temaadv1) ? md5(uniqid(rand(time($temaadv1)))) . $tuzanti1 : '';  // Dosya yükleme için ayrı değişken
  $temav1yol = "../resimler/temaayarlari";
  
  // Dosya yükleme değişkenleri - sadece dosya yüklendiğinde kullanılacak
  $temakonumv2 = $_FILES['t2']['tmp_name'];
  $temaadv2 = $_FILES['t2']['name'];
  $tematipv2 = $_FILES['t2']['type'];
  $tuzanti2 = !empty($temaadv2) ? substr($temaadv2, -5, 5) : '';
  $t2_file = !empty($temaadv2) ? md5(uniqid(rand(time($temaadv2)))) . $tuzanti2 : '';  // Dosya yükleme için ayrı değişken - benzersiz dosya adı
  $temav2yol = "../resimler/temaayarlari";
  
  $temakonumv3 = $_FILES['t3']['tmp_name'];
  $temaadv3 = $_FILES['t3']['name'];
  $tematipv3 = $_FILES['t3']['type'];
  $tuzanti3 = !empty($temaadv3) ? substr($temaadv3, -5, 5) : '';
  $t3_file = !empty($temaadv3) ? md5(uniqid(rand(time($temaadv3)))) . $tuzanti3 : '';  // Dosya yükleme için ayrı değişken - benzersiz dosya adı
  $temav3yol = "../resimler/temaayarlari";
  
  
  $temakonumv33 = $_FILES['t4']['tmp_name'];
  $temaadv33 = $_FILES['t4']['name'];
  $tematipv33 = $_FILES['t4']['type'];
  $tuzanti33 = !empty($temaadv33) ? substr($temaadv33, -5, 5) : '';
  $t33_file = !empty($temaadv33) ? md5(uniqid(rand(time($temaadv33)))) . $tuzanti33 : '';  // Dosya yükleme için ayrı değişken - benzersiz dosya adı
  $temav33yol = "../resimler/temaayarlari";
  
  
  
  $temakonumv4 = $_FILES['anabanner']['tmp_name'];
  $temaadv4 = $_FILES['anabanner']['name'];
  $tematipv4 = $_FILES['anabanner']['type'];
  $tuzanti4 = !empty($temaadv4) ? substr($temaadv4, -5, 5) : '';
  $anabanner_file = !empty($temaadv4) ? md5(uniqid(rand(time($temaadv4)))) . $tuzanti4 : '';  // Dosya yükleme için ayrı değişken - benzersiz dosya adı
  $temav4yol = "../resimler/temaayarlari";
  
  $temakonumv5 = $_FILES['t9']['tmp_name'];
  $temaadv5 = $_FILES['t9']['name'];
  $tematipv5 = $_FILES['t9']['type'];
  $tuzanti5 = !empty($temaadv5) ? substr($temaadv5, -5, 5) : '';
  $t9_file = !empty($temaadv5) ? md5(uniqid(rand(time($temaadv5)))) . $tuzanti5 : '';  // Dosya yükleme için ayrı değişken - benzersiz dosya adı
  $temav5yol = "../resimler/temaayarlari";
  
  $temakonumv6 = $_FILES['t12']['tmp_name'];
  $temaadv6 = $_FILES['t12']['name'];
  $tematipv6 = $_FILES['t12']['type'];
  $tuzanti6 = !empty($temaadv6) ? substr($temaadv6, -5, 5) : '';
  $t12_file = !empty($temaadv6) ? md5(uniqid(rand(time($temaadv6)))) . $tuzanti6 : '';  // Dosya yükleme için ayrı değişken - benzersiz dosya adı
  $temav6yol = "../resimler/temaayarlari";
  
  
  if (!empty($_FILES['t1']['name'])) {
        if ($tematipv1 != 'image/jpeg' && $tematipv1 != 'image/png' && $tuzanti1 != '.jpg' && $tuzanti1 != '.png' && $tuzanti1 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav1 = move_uploaded_file($temakonumv1, $temav1yol . '/' . $t1_file);
            $temav1 = $ozy->prepare("update temalar set t1=? where id='$id'");
            $temav1->execute(array($t1_file));
		}
	
  }
  
  

  if (!empty($_FILES['t2']['name'])) {
        if ($tematipv2 != 'image/jpeg' && $tematipv2 != 'image/png' && $tuzanti2 != '.jpg' && $tuzanti2 != '.png' && $tuzanti2 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav2 = move_uploaded_file($temakonumv2, $temav2yol . '/' . $t2_file);
            $temav2 = $ozy->prepare("update temalar set t2=? where id='$id'");
            $temav2->execute(array($t2_file));
		}
	
  }
 
 
  if (!empty($_FILES['t3']['name'])) {
        if ($tematipv3 != 'image/jpeg' && $tematipv3 != 'image/png' && $tuzanti3 != '.jpg' && $tuzanti3 != '.png' && $tuzanti3 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav2 = move_uploaded_file($temakonumv3, $temav3yol . '/' . $t3_file);
            $temav2 = $ozy->prepare("update temalar set t3=? where id='$id'");
            $temav2->execute(array($t3_file));
		}
	
  }
  
  
   if (!empty($_FILES['t4']['name'])) {
        if ($tematipv33 != 'image/jpeg' && $tematipv33 != 'image/png' && $tuzanti33 != '.jpg' && $tuzanti33 != '.png' && $tuzanti33 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav23 = move_uploaded_file($temakonumv33, $temav33yol . '/' . $t33_file);
            $temav23 = $ozy->prepare("update temalar set t4=? where id='$id'");
            $temav23->execute(array($t33_file));
		}
	
  }
  
  
  
    if (!empty($_FILES['anabanner']['name'])) {
        if ($tematipv4 != 'image/jpeg' && $tematipv4 != 'image/png' && $tuzanti4 != '.jpg' && $tuzanti4 != '.png' && $tuzanti4 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav4 = move_uploaded_file($temakonumv4, $temav4yol . '/' . $anabanner_file);
            $temav4 = $ozy->prepare("update temalar set anabanner=? where id='$id'");
            $temav4->execute(array($anabanner_file));
		}
	
  }
  
  if (!empty($_FILES['t9']['name'])) {
        if ($tematipv5 != 'image/jpeg' && $tematipv5 != 'image/png' && $tuzanti5 != '.jpg' && $tuzanti5 != '.png' && $tuzanti5 != '.jpeg') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav2 = move_uploaded_file($temakonumv5, $temav5yol . '/' . $t9_file);
            $temav2 = $ozy->prepare("update temalar set t9=? where id='$id'");
            $temav2->execute(array($t9_file));
		}
	
  }
  
  if (!empty($_FILES['t12']['name'])) {
        if ($tematipv6 != 'image/gif' && $tematipv6 != 'image/jpeg' && $tematipv6 != 'image/png' && $tuzanti6 != '.jpg' && $tuzanti6 != '.png' && $tuzanti6 != '.jpeg' && $tuzanti6 != '.gif') {
            echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Lütfen ! Jpg ve Png uzantılı resim yükleyiniz ....", "Başarısız");});</script>';

        } else {
            $temav6 = move_uploaded_file($temakonumv6, $temav6yol . '/' . $t12_file);
            $temav6 = $ozy->prepare("update temalar set t12=? where id='$id'");
            $temav6->execute(array($t12_file));
		}
	
  }
  
  

   // Sadece değişen alanları güncelle
   if (!empty($updateFields)) {
     $updateValues[] = $id; // WHERE id = ? için
     $updateSql = "UPDATE temalar SET " . implode(", ", $updateFields) . " WHERE id = ?";
     $stmt = $ozy->prepare($updateSql);
     $result2 = $stmt->execute($updateValues);
   } else {
     $result2 = true; // Güncellenecek alan yoksa başarılı say
   }
   
   
   
   
    if($result2){
	echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veriyi güncellediniz.", "Başarılı");});</script>';
	echo '<meta http-equiv="refresh" content="1; url=temaayarlari?tema='.$id.'">';

   }else{

    echo '<script type="text/javascript">$(document).ready(function(){toastr["error"]("Üzgünüm bir hata oluştu :(", "Başarısız");});</script>';
    

   }







	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


}
	
	
	
	
///////TEMA YÜKLEME ALANI//////	
ini_set('memory_limit', '2048M');
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
						  
						  
						  
						  
						  
						  

                       					
					
					
							<div class="form-group row">
                                <label for="example-color-input" class="col-sm-2 col-form-label">Tema Rengi</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="t37" type="color" value="<?php echo $sayfam['t37']; ?>" id="example-color-input">
                                </div>
                            </div>
							
					
					
						
							
							<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa 1. Banner (338x226)</label>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa 1. Banner Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t5" value="<?php echo $sayfam['t5']; ?>">
                                </div>
                            </div>   
						    
								
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa 2. Banner (338x226)</label>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa 2. Banner Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t6" value="<?php echo $sayfam['t6']; ?>">
                                </div>
                            </div>   
							
							
								<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa 3. Banner (338x226)</label>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa 3. Banner Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t7" value="<?php echo $sayfam['t7']; ?>">
                                </div>
                            </div>   


							
	<div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa 4. Banner (338x226)</label>
                                <div class="col-sm-10">
                                    
                                    <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
									
                                   
									
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    
									 <div class="fileupload-new thumbnail fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                    
									
									<img src="../resimler/temaayarlari/<?php echo $sayfam['t4']; ?>" style="width: 200px; height: 200px;" alt="" />
                                    
									
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file" style="border: 1px solid #ebeef0;">
                                    <span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Resim Seç</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Değiştir</span>
                                    <input name="t4" type="file" class="default" />
                                    </span>
                                    <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="fileupload"><i class="fa fa-trash"></i> Sil</a>
                                    </div>
                                    </div>
                                    </div>
                                   
								</div>
                                            
                            </div>
                   
                              <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa 4. Banner Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t8" value="<?php echo $sayfam['t8']; ?>">
                                </div>
                            </div> 
							
							
						   <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Anasayfa Açıklama Metni</label>
                                <div class="col-sm-10">
                                  <textarea  id="summernote" class="form-control" rows="6" name="t40"><?php echo $sayfam['t40']; ?></textarea>  
                                </div>
                                            
                            </div>		
							
							
							
							
							 <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Google Play Uygulama Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t35" value="<?php echo $sayfam['t35']; ?>">
                                </div>
                            </div>  
							
							
							 <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">App Store Uygulama Linki</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="t36" value="<?php echo $sayfam['t36']; ?>">
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