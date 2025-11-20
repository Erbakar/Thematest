<title>Favori Ürünlerim</title>

<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">

<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">

<meta property="og:url" content="<?php echo $url; ?>"/>

<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>

<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>



	   

		   <main class="main">

  

       



<div class="cl-page-row">

<h1 class="cl-page-row-header">Favorilerim</h1>

<h2 class="cl-page-row-subheader">Favori ürünlerim burada saklı!</h2>







<div class="cl-product-grid cl-col-l12">

        <div class="cl-flex-row cl-page-row">

						

	                    <?php $uyesepeti11 = $ozy->prepare("SELECT * FROM urunler 

	                    INNER JOIN favoriler ON urunler.id = favoriler.urunid  

	                    WHERE favoriler.gelenkim=? ORDER BY favoriler.id DESC");                

	                    $uyesepeti11->execute(array($sepetimdekikim));

	                    foreach ($uyesepeti11 as $anaurunler) {?>

	





  

<div class="cl-col cl-col-l2 cl-col-m3 cl-col-s6">

<div class="cl-product-box">

    <div class="cl-product-images">

	

         

		

			 <?php if($anaurunler['idurum']=='1'){?>

			<p class="cl-product-badge discount">

			

			  -%<?php echo yuzdeHesaplama($anaurunler['fiyat'],$anaurunler['ifiyat']);?>

			</p>

			<?php } ?>

			

			

        <a href="urun/<?php echo $anaurunler['seo']; ?>">

            <img class="" src="resimler/urunler/<?php echo $anaurunler['resim']; ?>" data-src="resimler/urunler/<?php echo $anaurunler['resim']; ?>" alt="Ürün" title="Ürün">

        </a>

        <div class="cl-product-box-inputs">

            <div class="cl-flex-row">

                <div class="cl-product-quantity-input-container">

                   

                </div>

            </div>

			

            <button class="add-to-cart-button" type="button" onclick="location.href='urun/<?php echo $anaurunler['seo']; ?>'">Sepete Ekle </button>

            <button class="add-to-cart-button" style="background:<?php echo $tema['t8']; ?>;" type="button" onclick="location.href='?favorilsil=<?php echo $anaurunler['id']; ?>'">Sil </button>

       

		</div>

    </div>

    <div class="cl-product-info">

        <a href="urun/<?php echo $anaurunler['seo']; ?>" class="cl-product-name" title="<?php echo $anaurunler['adi']; ?>"><p>

		<?php echo $anaurunler['adi']; ?></p></a>

        <div class="cl-product-prices">

         <?php echo urunfiyatbelirle($anaurunler['kdv'],$anaurunler['idurum'],$anaurunler['fiyat'],$anaurunler['ifiyat']);?>

            

        </div>

    </div>

</div>

</div>

                

	

      

        <?php } ?>





	            	

            	</div><!-- End .container -->

            </div>

   </div>







	





        </main>