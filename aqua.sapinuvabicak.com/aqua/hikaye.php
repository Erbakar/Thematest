

<style>

.hikaye {
    border: 1px solid #f7f5f5;
background: white;
padding: 10px;
}

.hikayem {
padding-left: 12%;
padding-right: 12%;
padding-top: 10px;

}
 @media screen and (max-device-width: 480px) and (orientation: portrait){
.hikayem {
padding-left: 3%;
padding-right: 3%;
padding-top: 10px;

}	 
}	 
</style>
  
   <div class="hikaye">
                
         
                 
                 
	                <div id="stories" class="storiesWrapper"></div>	
              
						
                   
          
				
				
				
            </div><!-- End .container -->
    <link rel="stylesheet" href="eklentiler/hikaye/dist/zuck.min.css">
    <link rel="stylesheet" href="eklentiler/hikaye/dist/skins/snapgram.css">
    <script src="eklentiler/hikaye/dist/zuck.min.js"></script>
    <script src="eklentiler/hikaye/demo/script.js"></script>

    <script>
      var currentSkin = getCurrentSkin();
      var stories = new Zuck('stories', {
        backNative: true,
        previousTap: true,
        skin: currentSkin['name'],
        autoFullScreen: currentSkin['params']['autoFullScreen'],
        avatars: currentSkin['params']['avatars'],
        paginationArrows: currentSkin['params']['paginationArrows'],
        list: currentSkin['params']['list'],
        cubeEffect: currentSkin['params']['cubeEffect'],
        localStorage: true,
        stories: [
            <?php $kati = $ozy->query("select * from kategoriler where durum='1' and ikongoster='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
            foreach($kati as $kategori){?>
			Zuck.buildTimelineItem(
            "<?php echo $kategori['seo']; ?>", 
            "resimler/kategoriler/<?php echo $kategori['ikon']; ?>",
            "<?php echo $kategori['adi']; ?>",
            "kategori/<?php echo $kategori['seo']; ?>",
            timestamp(),
            [
			  ["<?php echo $kategori['seo']; ?>-1", "photo", 3, "resimler/kategoriler/<?php echo $kategori['ikon']; ?>", "resimler/kategoriler/<?php echo $kategori['ikon']; ?>", 'kategori/<?php echo $kategori['seo']; ?>', 'Fırsatı İncele', false, timestamp()],
            ]
           ),
		  <?php } ?>
            <?php $kk = $ozy->query("select * from kampanyalar where durum='1' order by sira DESC")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($kk as $kampi) {?>
            Zuck.buildTimelineItem(
            "<?php echo $kampi['seo']; ?>", 
            "resimler/kampanyalar/<?php echo $kampi['resim']; ?>",
            "<?php echo $kampi['adi']; ?>",
            "kampanya/<?php echo $kampi['seo']; ?>",
            timestamp(),
            [
			  ["<?php echo $kampi['seo']; ?>-1", "photo", 3, "resimler/kampanyalar/<?php echo $kampi['resim']; ?>", "resimler/kampanyalar/<?php echo $kampi['resim']; ?>", '<?php echo $kampi["link"] == "0" ? "kampanya/".$kampi["seo"]."" : "".$kampi["link"].""; ?>', 'Fırsatı İncele', false, timestamp()],
			  
			  <?php 
			  $gelenid = $kampi['id'];
			  $sayfaresimi = $ozy->query("select * from tumresimler where sayfaid='$gelenid' and alan='kampanyalar' order by id desc")->fetchAll(PDO::FETCH_ASSOC); 
              foreach($sayfaresimi as $genelresim){?>
			  ["<?php echo $kampi['seo']; ?>-1<?php echo $genelresim['id'];?>", "photo", 3, "resimler/genel/<?php echo $genelresim['sayfaresim'];?>", "resimler/genel/<?php echo $genelresim['sayfaresim'];?>", '<?php echo $kampi["link"] == "0" ? "kampanya/".$kampi["seo"]."" : "".$kampi["link"].""; ?>', 'Fırsatı İncele', false, timestamp()],
			  <?php } ?>
            ]
          ),
		  <?php } ?>
        ]
      });
    </script>