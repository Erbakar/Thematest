    <?php define("guvenlik",true);?>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
    <link rel="mask-icon" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>" color="#666666">
    <link rel="shortcut icon" href="resimler/siteayarlari/<?php echo $ayar['favicon']; ?>">
    <!-- Plugins CSS File -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <?php require_once ("".$sitetemasi."/soft.php");?>
    <link href="<?php echo $sitetemasi;?>/css/style.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $sitetemasi;?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $sitetemasi;?>/css/swiper-bundle.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $sitetemasi;?>/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>
    <script>
        dataLayer = [];
    </script>

   <?php echo $ayar['google']; ?>
   <?php echo $ayar['yandex']; ?>
   <?php echo $ayar['reklam']; ?>
         <?php 
    function yuzdeHesaplama($sayi,$sayi2){
    $newsayi = $sayi - $sayi2;	
	$yuzdelik = $sayi/100;
	$son = $newsayi/$yuzdelik;
    return substr($son,0,2);
   } 
   

   
   ?> 
</head>
<body class="preload">
    




<main>
    <style type="text/css">
    iframe .cl-before-header-banner {
        display: none !important;
    }
</style>
<div class="cl-before-header-banner" <?php echo $tema['t13'] == '0' ? 'style="display:none;"' : null; ?>>


		<a href="<?php echo $tema['t13']; ?>"><img   style="width: 100%;" src="resimler/temaayarlari/<?php echo $tema['t12']; ?>" alt="banner"></img></a>
	
	

</div>
<header role="presentation">
  
    <div id="cl-header" class="navigation">
        <div class="cl-header-row">
            <div class="cl-width-limiter">
                <div class="nav-header">
                    <div class="nav-toggle"></div>
                    <a class="nav-brand" href="anasayfa">
                        <img src="resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="Logo" />
                    </a>
                </div>
				<form action="arama/" method="GET">
                <div class="search-input-container">
                    <input style="width: 460px;
line-height: 40px;
height: 40px;
border: 2px solid #404040;
outline: 0;
border-radius: 20px;
padding: 0 40px 0 20px;
font-size: 12px;" class="" type="text" autocomplete="off" name="arama" value="" placeholder="Ne aramıştınız?" required>
                    <div class="cl-search-input-icon">
                        <img src="<?php echo $sitetemasi;?>/images/search.png" alt="close" />
                    </div>
                </div>
				</form>
				
                <div class="nav-buttons">
                    <a style="background: #545456;" class="nav-button cl-subscribe-button" href="siparissorgulama/" rel="nofollow">
                        <p>Sipariş Sorgulama</p>
                        <img src="<?php echo $sitetemasi;?>/images/kargo.png" alt="Sorgulama" />
                    </a>
					   <a style="background: #beac1b;" class="nav-button cl-subscribe-button" href="favorilerim/" rel="nofollow">
                        <p>Favorilerim</p>
                        <img src="<?php echo $sitetemasi;?>/images/favorilerim.png" alt="favorilerim" />
                    </a>
					
					<?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>
                    <a style="background: #17056b;" class="nav-button cl-account-button" href="hesabim/" rel="nofollow">
                        <p>Hesabım</p>
                        <img src="<?php echo $sitetemasi;?>/images/login.png" alt="login" />
                    </a>
					<?php } else { ?>
					  <a style="background: #17056b;" class="nav-button cl-account-button" href="uyeol/" rel="nofollow">
                        <p>Üye Girişi</p>
                        <img src="<?php echo $sitetemasi;?>/images/login.png" alt="login" />
                    </a>
					<?php } ?>
					
					
    <a class="nav-button" href="sepet/">
    <p>Sepetim</p>
    <img src="<?php echo $sitetemasi;?>/images/basket.png" />
    <span class="cart-qty"><?php echo $sepetsayi;?></span>
    </a>


                    <a href="tel:<?php echo $ayar['tel']; ?>" class="nav-phone" rel="nofollow">
                        <img src="<?php echo $sitetemasi;?>/images/phone-icon.png" alt="phone" /><?php echo $ayar['tel']; ?>
                    </a>
                </div>
            </div>

        </div>
<div class="cl-header-row" style="background: <?php echo $tema['t8']; ?>;">
<style>
#vl-notification {z-index:1000 !important;} 
</style>
<nav class="nav-menus-wrapper">
<p class="nav-brand mobile-menu-brand"><img src="resimler/siteayarlari/<?php echo $ayar['logo'];?>" alt="Logo" /></p>
<div class="nav-menus-wrapper-close-button"><img src="<?php echo $sitetemasi;?>/images/close-icon-dark.png" alt="close" /></div>
<ul class="nav-menu">
<li><a onclick="location.href='anasayfa'" href="anasayfa">
Anasayfa
<span class="nav-menu-indicator"></span> </a>
</li>
<?php $ustkattt = $ozy->query("select * from kategoriler where durum='1' and ustkat='0' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($ustkattt as $katadi){?>

<?php if($katadi['ac']=='1'){?>
<li><a href="kategori/<?php echo $katadi['seo']; ?>">  <?php echo $katadi['adi']; ?> <span class="nav-menu-indicator"></span> </a>
<div class="megamenu-panel">
<div class="megamenu-lists">
<ul class="megamenu-list">
<?php 
				
$ustkatid = $katadi['id'];
$ustkattta = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
foreach($ustkattta as $katadi2){?>	
<li><a style="background: <?php echo $tema['t8']; ?>;color: #000;" href="kategori/<?php echo $katadi2['seo']; ?>"> <?php echo $katadi2['adi']; ?></a>


											

<ul class="megamenu-list">

<?php 
				
				$ustkatid2= $katadi2['id'];
				$ustkatttaz = $ozy->query("select * from kategoriler where durum='1' and ustkat='$ustkatid2' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                foreach($ustkatttaz as $katadi22){?>	
<li><a href="kategori/<?php echo $katadi22['seo']; ?>"> <?php echo $katadi22['adi']; ?></a>


</li>
	<?php } ?>
</ul>









</li>
<?php } ?>
</ul>



</div>
</div>
</li>

  <?php } else { ?>	


<li><a onclick="location.href='kategori/<?php echo $katadi['seo']; ?>'" href="kategori/<?php echo $katadi['seo']; ?>">
<?php echo $katadi['adi']; ?>
<span class="nav-menu-indicator"></span> </a>
</li>
<?php }} ?>  
<li><a style="color: <?php echo $tema['t8']; ?>;" onclick="kampanyalar/" href="kampanyalar/" class="campaign">  KAMPANYALAR </a></li>

</ul>
</nav>
        </div>
    </div>

</header>


