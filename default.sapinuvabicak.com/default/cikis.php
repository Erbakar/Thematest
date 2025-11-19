<?php
session_destroy();
header("Refresh: 2; url=".$url."");
ob_end_flush();
?>
<title>Sistemden Çıkış</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Üyelik Sözleşmesi ve Rıza Metni"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>
 
	
		   <main class="main">
        	<div class="page-header text-center" style="background-image: url('<?php echo $sitetemasi;?>/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Sistemden Çıkış<span>Anasayfa</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="anasayfa">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sistemden Çıkış</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
   <div class="page-content pb-3">
                <div class="cart">
	                <div class="container">
	                	<div class="row">
						
						 <div class="col-md-12">
           

                <div class="card-body cart">
                    <div class="col-sm-12 empty-cart-cls text-center"> 
					<h5><strong>Oturumunuz başarıyla kapatıldı.</strong></h5>
                        <h5>Tekrar görüşmek üzere :)</h5> <a href="<?php echo $url;?>" class="btn btn-primary cart-btn-transform m-3" data-abc="true">hadi gezinelim</a>
                    </div>
                </div>
           
        </div>
						
							
	                	</div><!-- End .row -->
						
						
						
						
	                </div><!-- End .container -->
                </div>
                <div class="mb-2"></div><!-- End .mb-2 -->

            </div><!-- End .page-content -->
        </main>