<title>Sıkça Sorulan Sorular</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Sıkça Sorulan Sorular<span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sıkça Sorulan Sorular</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="about-text text-left">
                                <h2 class="title text-left mb-2">Sıkça Sorulan Sorular</h2><!-- End .title text-center mb-2 -->
                            <?php $ss = $ozy->query("select * from sss where durum='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                            foreach($ss as $sss){?>    
								
								
								<div style="border: 1px solid #e1dddd;padding: 10px;margin-bottom: 10px;border-radius: 6px;">
								<p style="font-weight: bold;"><?php echo $sss['adi']; ?></p>
								<b><?php echo $sss['aciklama']; ?></b>
								</div>
							<?php } ?>	
                               
                               
                            </div><!-- End .about-text -->
                        </div><!-- End .col-lg-10 offset-1 -->
                    </div><!-- End .row -->
                    
                </div><!-- End .container -->

                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>