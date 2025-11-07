<?php define("guvenlik",true);?>
<?php
require_once('func/db.php');
require_once('func/fonksiyon.php');


?>
<!DOCTYPE html>
<html style="overflow-x: hidden !important;" lang="tr">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php $url = $ayar['siteurl'];?>
<base href="<?php echo $url; ?>/">
<?php if($ayar['bakimdurum']=='1'){
	
	
	echo $ayar['bakim'];
	
	
} else { 
	

$sitetemasi = $ayar['tema'];
include_once ("".$sitetemasi."/temaheader.php");?>

	    <?php 
	    if(isset($_GET['trendmaxtrs'])){
		$s = $_GET['trendmaxtrs'];
		
		switch($s){
		
		case 'index.html';
		require_once("".$sitetemasi."/temahome.php");
		break;
		case 'index';
		require_once("".$sitetemasi."/temahome.php");
		break;
		
		
		
		case 'siparissorgulama';
		require_once("".$sitetemasi."/siparissorgulama.php");
		break;
		
		case 'bankabilgilerimiz';
		require_once("".$sitetemasi."/bankabilgilerimiz.php");
		break;
		
		case 'hesabim';
		require_once("".$sitetemasi."/hesabim.php");
		break;
		
		case 'urunkarsilastirma';
		require_once("".$sitetemasi."/urunkarsilastirma.php");
		break;
		
		case 'favorilerim';
		require_once("".$sitetemasi."/favorilerim.php");
		break;
		
		case 'sepet';
		require_once("".$sitetemasi."/sepet.php");
		break;
		
		case 'kampanyalar';
		require_once("".$sitetemasi."/kampanyalar.php");
		break;
		
		case 'bloglar';
		require_once("".$sitetemasi."/blog.php");
		break;
		
		case 'iletisim';
		require_once("".$sitetemasi."/iletisim.php");
		break;
		
		case 'gununfirsati';
		require_once("".$sitetemasi."/gununfirsati.php");
		break;
		
		case 'sizinicin';
		require_once("".$sitetemasi."/sizinicin.php");
		break;
		
		case 'sayfa';
		require_once("".$sitetemasi."/sayfadetay.php");
		break;
		
		case 'kampanya';
		require_once("".$sitetemasi."/kampanyadetay.php");
		break;
		
		case 'rizametni';
		require_once("".$sitetemasi."/rizametni.php");
		break;
		
		case 'sifremiunuttum';
		require_once("".$sitetemasi."/sifremiunuttum.php");
		break;
		
		case 'sss';
		require_once("".$sitetemasi."/sss.php");
		break;
		
		case 'blog';
		require_once("".$sitetemasi."/blogdetay.php");
		break;
		
		case 'kullanimkosullari';
		require_once("".$sitetemasi."/kullanimkosullari.php");
		break;
		
		case 'onay';
		require_once("".$sitetemasi."/onay.php");
		break;
		
		case 'kategori';
		require_once("".$sitetemasi."/kategoridetay.php");
		break;
		
		case 'urun';
		require_once("".$sitetemasi."/urundetay.php");
		break;
		
		case 'odeme';
		require_once("".$sitetemasi."/odeme.php");
		break;
		
		case 'kontrol';
		require_once("".$sitetemasi."/kontrol.php");
		break;
		
		case 'mesafeli-satis-sozlesmesi';
		require_once("".$sitetemasi."/sozlesme.php");
		break;
		
		case 'alisverisi-tamamla';
		require_once("".$sitetemasi."/alisverisitamamla.php");
		break;
		
		case 'hesabim';
		require_once("".$sitetemasi."/hesabim.php");
		break;
		
		case 'uyeol';
		require_once("".$sitetemasi."/uyeol.php");
		break;
		
		case 'cikis';
		require_once("".$sitetemasi."/cikis.php");
		break;
		
		case 'arama';
		require_once("".$sitetemasi."/arama.php");
		break;
		
		case 'paytrsonuc';
		require_once("".$sitetemasi."/paytrsonuc.php");
		break;
		
		case 'iyzicosonuc';
		require_once("".$sitetemasi."/iyzicosonuc.php");
		break;
		
		case 'shopiersonuc';
		require_once("".$sitetemasi."/shopiersonuc.php");
		break;
		
		case '404';
		require_once("".$sitetemasi."/404.php");
		break;
		
		
		default:
		require_once("".$sitetemasi."/temahome.php");
		}
	    }else{
			
	    require_once("".$sitetemasi."/temahome.php");
        }
		
		require_once ("".$sitetemasi."/temafooter.php");
        }
		
		
		?>
		<script>
$(function() {
var pageTitle = $("title").text();
$(window).blur(function() {
var fr_text = { "tr" : "<?php echo $ayar['dtitle'] ?? "";?>" ,"en" : <?php echo $ayar['dtitle'] ?? "";?> , "ar" : "{{TEXT_AR}}" , "ru" : "{{TEXT_RU}}"};
var title_text = typeof fr_text[window.LANGUAGE] !== "undefined" ? fr_text[window.LANGUAGE] : fr_text["tr"];
if(title_text!==""){
$("title").text(title_text);
}
});
$(window).focus(function() {
$("title").text(pageTitle);
});
});
</script>
<script src="boss/assets/pages/lightbox.js"></script>
<link href="eklentiler/cerez/cerez.css" rel="stylesheet" type="text/css">
<script src="eklentiler/cerez/cerez.js"></script>
<script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#000000bd",
      "text": "#fff"
    },
    "button": {
      "background": "#000000bd"
    }
  },
  "theme": "classic",
  "position": "bottom-right",
  "content": {
    "message": "Bu site, hizmetlerini sunmak ve trafiği analiz etmek için çerezlerden yararlanıyor.",
    "dismiss": "Anladım",
    "link": "Daha fazla bilgi",
    "href": "kullanim-kosullari/"
  }
})});

</script>
<style>
@media screen and (max-device-width: 480px) and (orientation: portrait){
#toast-container > div {
    padding: 8px 8px 8px 50px;
    width: 100% !important;
    padding: px;
}
}	

.top-image{
width: 100% !important;	
}	
</style>