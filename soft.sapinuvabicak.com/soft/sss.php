<title>Sıkça Sorulan Sorular</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	<div class="cl-width-limiter">
        
        

    <div class="page topic-page" id="ph-topic">
        <div class="page-title" id="ph-title">
            <h1>Sıkça Sorulan Sorular</h1>
        </div>
        <div class="page-body">
            <style>
h1{display:none}
</style>
<div class="cl-static-page cl-footer-page">
<div class="cl-page-row">
<div class="cl-section-header">Sıkça Sorulan Sorular</div>
<div class="cl-section-body">
      <?php $ss = $ozy->query("select * from sss where durum='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                            foreach($ss as $sss){?>    
								
<div class="cl-collapsible-item">
<div class="cl-collapsible-header"><?php echo $sss['adi']; ?><span class="cl-collapsible-header-icon"></span></div>
<div class="cl-collapsible-body"><?php echo $sss['aciklama']; ?></div>
</div>
	<?php } ?>	


</div>



</div>
</div>
        </div>
    </div>





        
    </div>