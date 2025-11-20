
    </div>
    <footer>
    <div class="page-row cl-newsletter-row">
    <div class="cl-flex-row">
        <div class="cl-newsletter-col cl-col-l12 cl-col-s12 cl-flex-row">
            <p class="cl-newsletter-title">E-BÜLTENE KAYDOL</p>
            <div>
			<form action="" method="POST">
                <div class="cl-newsletter-input-container">
                    <input class="cl-newsletter-input" type="email" name="eposta" required placeholder="E-Posta adresinizi giriniz" />
                    <button type="submit" name="ebulten" class="cl-newsletter-button">KAYDOL</button>
                </div>
             </form>    
               
            </div>
          
        </div>
    </div>
</div>

<style>
@media only screen and (max-width: 767px){
.cl-footer-col:first-child, .cl-footer-col:nth-child(2),.cl-footer-col:first-child, .cl-footer-col:nth-child(3),.cl-footer-col:first-child, .cl-footer-col:nth-child(4) {
    border-bottom: 1px solid #eeeeee;
    margin-top: 0px;
}
.cl-footer-col:first-child{
order:1
}
.cl-footer-col:nth-child(2){
order:3
}
.cl-footer-col:nth-child(3){
order:4
}
.cl-footer-col:nth-child(4){
order:2
}
.cl-footer-col:nth-child(5){
order:5
}
}
</style>
<div class="page-row cl-footer-row">
<div class="cl-flex-row">

					<div class="Etiketalani">
								<div class="etiketgenel">
									<div class="Etiketbaslik">En Çok Aranan Kelimeler:</div>
									<ul class="Etiketliste">
									<?php $etikets = $ozy->query("select * from etiketler where durum='1' order by sira desc")->fetchAll(PDO::FETCH_ASSOC); 
                                    foreach($etikets as $etiket){?>
					                <li><a target="_blank" href="<?php echo $etiket['link'];?>"><?php echo $etiket['adi'];?></a></li>
									<?php } ?>
									</ul>
								</div>
							</div>
							
					<style>
.Etiketalani { float: left; width: 100%; /*! padding: 2px 0px; */ /*! border-top: 1px solid #000; */ margin-top: -20px;margin-bottom: 30px;}

.Etiketbaslik { display: inline-block; vertical-align: top; line-height: 31px; font-size: 14px; color: <?php echo $tema['t8']; ?>; font-weight: 500; margin-right: 12px; }

.Etiketliste { padding: 0px !important;display: inline-block; width: 100%;margin-left: -8px;padding-top: 5px;/*! margin-right: 50px !important; */}

.Etiketliste li { /*! border: 1px solid #f6f1f1; */display: inline-block; vertical-align: top; margin: 0px 4px; margin-bottom: 10px; /*! border-radius: 15px; *//*! color: red; */}

.Etiketliste li a:hover { background: #f0f0f0; }

.Etiketliste li a { display: block; line-height: 31px; background: #fffdfd21; padding: 0px 15px; font-size: 14px; color: #fff; font-weight: 400; border-radius: 15.5px; }

          
                    </style>					
							










<div class="cl-footer-col">
<p class="cl-footer-col-header">Hızlı Linkler</p>
<ul class="cl-footer-col-list">
<li class="cl-footer-col-list-item"><a href="urunkarsilastirma/">Karşılaştırma Listesi</a></li>
<li class="cl-footer-col-list-item"><a href="siparissorgulama/">Sipariş Sorgulama</a></li>
								<li class="cl-footer-col-list-item"><a href="bankabilgilerimiz/">Banka Bilgilerimiz</a></li>
								<li class="cl-footer-col-list-item"><a href="uyeol/">Üyelik İşlemleri</a></li>
								 <li class="cl-footer-col-list-item"><a href="kampanyalar/">Kampanyalar</a>
	            				<li class="cl-footer-col-list-item"><a href="bloglar/">Blog</a></li>
								<li class="cl-footer-col-list-item"><a href="sss/">Sıkça Sorulan Sorular</a></li>
							 	<li class="cl-footer-col-list-item"><a href="iletisim/">Bize Ulaşın</a></li>

</ul>
</div>
<div class="cl-footer-col">
<p class="cl-footer-col-header">Müşteri Hizmetler</p>
<ul class="cl-footer-col-list">

	<?php $hzmetler1 = $ozy->query("select * from sayfalar where durum='1'order by sira desc limit 6")->fetchAll(PDO::FETCH_ASSOC); 
                            foreach($hzmetler1 as $hizmetler11){?>	
                         <li class="cl-footer-col-list-item"><a href="sayfa/<?php echo $hizmetler11['seo']; ?>"><?php echo $hizmetler11['adi']; ?></a></li>
							<?php } ?>   


</ul>
</div>
<div class="cl-footer-col">
<p class="cl-footer-col-header"> </p>
<ul class="cl-footer-col-list">
	<?php $hzmetler1 = $ozy->query("select * from sayfalar where durum='1'order by sira desc limit 6,6")->fetchAll(PDO::FETCH_ASSOC); 
                            foreach($hzmetler1 as $hizmetler11){?>	
                         <li class="cl-footer-col-list-item"><a href="sayfa/<?php echo $hizmetler11['seo']; ?>"><?php echo $hizmetler11['adi']; ?></a></li>
							<?php } ?>   
</ul>
</div>
<div class="cl-footer-col">
<p class="cl-footer-col-header">Kategoriler</p>
<ul class="cl-footer-col-list">

	<?php $katttt = $ozy->query("select * from kategoriler where durum='1' order by rand() limit 8")->fetchAll(PDO::FETCH_ASSOC); 
                            foreach($katttt as $katimmm){?>	
                         <li class="cl-footer-col-list-item"><a href="kategori/<?php echo $katimmm['seo']; ?>"><?php echo $katimmm['adi']; ?></a></li>
<?php } ?>   
</ul>
</div>
<div class="cl-footer-col">
<p class="cl-footer-col-header">Sosyal</p>
<ul class="cl-footer-col-list">

  <li class="cl-footer-col-list-item" <?php echo $ayar['facebook'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['facebook']; ?>" class="social-icon" target="_blank" title="Facebook"><i class="fa fa-facebook"></i>&nbsp;Facebook</a></li>
                <li class="cl-footer-col-list-item" <?php echo $ayar['twitter'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['twitter']; ?>" class="social-icon" target="_blank" title="Twitter"><i class="fa fa-twitter"></i>&nbsp;Twitter</a></li>
               <li class="cl-footer-col-list-item" <?php echo $ayar['instagram'] == '' ? 'style="display:none;"' : null; ?>><a  href="<?php echo $ayar['instagram']; ?>" class="social-icon" target="_blank" title="instagram"><i class="fa fa-instagram"></i>&nbsp;İnstagram</a></li>
             


</ul>
<p class="cl-footer-col-header">Müşteri Destek Hattı <br /><span> <?php echo $ayar['tel']; ?></span></p>
</div>
</div>

</div>

 <div class="cl-footer-deep"><span> <?php echo $ayar['copy']; ?></span>

</div>  
</footer>

<script  src="<?php echo $sitetemasi;?>/scripts/jquery-3.3.1.min.js"></script>
<script  src="<?php echo $sitetemasi;?>/scripts/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script  src="<?php echo $sitetemasi;?>/js/swiper-bundle.min.js"></script>
<script  src="<?php echo $sitetemasi;?>/js/jquery.smooth-scroll.min.js"></script>
<script  src="<?php echo $sitetemasi;?>/js/main.min.js"></script>
<script  src="<?php echo $sitetemasi;?>/js/jquery.fancybox.min.js"></script>
<script  src="<?php echo $sitetemasi;?>/js/jquery.mask.min.js"></script>
   
<script>
 
    $(document).ready(function () {
        $('.cl-filter-col .cl-header-title span').text($('.cl-product-grid-length').text()).addClass('active');
        $('.cl-category-filter-row').addClass('active');

        var getTextWidth = function (text, textClass) {
            var span = document.createElement('span');
            span.style.opacity = 0;
            span.style.display = 'inline-block';
            span.innerHTML = text;
            if (textClass) span.classList.add(textClass);
            var body = document.querySelector('body').appendChild(span);
            var width = span.offsetWidth + 4;
            span.remove();
            return width
        }

        let selectpadding = '0px calc((50% - ' + (getTextWidth($('#products-orderby option:selected')[0].text, 'products-orderby-sample-text') + 9) + 'px) / 2)';
        document.documentElement.style.setProperty('--selectpadding', selectpadding);

        $('.cl-filter-col .collapsable-title').click(function () {
            $(this).parent().toggleClass('active');
            $(this).siblings('ul').toggleClass('collapsed');
        });
        $('.cl-category-filter-button').click(function () {
            $('.cl-filter-col').addClass('active');
        });
        $('.cl-category-filter-close-button, .overlay-filter').click(function () {
            $('.cl-filter-col').removeClass('active');
        });
        $('.cl-product-box  .cl-product-image-bullet').hover(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $(this).parent().siblings('img').attr('src', $(this).data('src'));
        });
        $('.cl-product-box').mouseleave(function () {
            $(this).find('img').attr('src', $(this).find('.cl-product-image-bullet')[0]?.dataset.src);
            $(this).find('.cl-product-image-bullet').removeClass('active');
        });

        $(".cl-plp-seoButton").on('click', function () {
            $(".cl-plp-seo").toggleClass('extended');
            if ($(".cl-plp-seo").hasClass('extended')) {
                $(this).find('.readmore').text('Daha Az');
            }
            else {
                $(this).find('.readmore').text('Devamını Oku');
            }

        });
    });


</script>
 <script>
    $(document).ready(function () {
        var galleryThumbs = new Swiper('.cl-product-gallery-thumbnails', {
            spaceBetween: 10,
            slidesPerView: 'auto',
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            
            breakpoints: {
                1: {
                    direction: 'horizontal',
                },
                991: {
                    direction: 'vertical',
                }
            }
        });
        var productImages = new Swiper('.cl-product-gallery', {
            loop: false,
            preloadImages: false,
            lazy: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            spaceBetween: 0,
            slidesPerView: 1,
            on: {
                slideChange: function (e) {
                    $(e.el).find('.lazy').each((n, i) => {
                        if ($(i).attr("src") != $(i).data("src"))
                            $(i).attr("src", $(i).data("src"))
                    });
                }
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });

    });</script>
<script>
    $(document).ready(function () {
        $("#cl-overview-activer").on("click", function () {
            $('*[data-target="tab2content"]').click();
        });
        $("#writeReviewButton").on("click", function () {
            $('*[data-target="tab2content"]').click();
        });
    });
</script>
<script>
    $(document).ready(function () {

        if (document.location.href.indexOf('#writecomment') > -1) {
            $("#writeReviewButton").click();
        }
        


    });
    $(document).on('click', '#writeReviewButton', function () {
        if ($("#cl-product-reviews iframe").attr("src") != $("#cl-product-reviews iframe").data("src")) {
            $("#cl-product-reviews iframe").attr("src", $("#cl-product-reviews iframe").data("src"));
        }
    });
</script>
<script>

    $('#readReviewButton').smoothScroll().click(function () {
        $('.cl-product-tab-header[data-target="tab2content"]').click();
    });

    $('.cl-product-tab-header').click(function () {
        if ($(this).hasClass('active') && $(window).width() <= 992) {
            $('.cl-product-tabs-container').children().removeClass('active');
            return;
        }
        else {
            $('.cl-product-tabs-container').children().removeClass('active');
            $(this).addClass('active');
            $('.' + $(this).data('target')).addClass('active');
            if ($(window).width() <= 992)
                $('html,body').animate({ scrollTop: $(this).parent().offset().top - 100 }, 400);
        }



        if ($(window).width() >= 992) {
            $('.cl-product-tabs-container').height($('.' + $(this).data('target')).height() + 110);
        }
        else {
            $('.cl-product-tabs-container').height('auto');
        }
    });
    $('.cl-product-info-expand-button').smoothScroll().click(function () {
        $('.cl-product-tab-header[data-target="tab1content"]').click();
    });

 
    $(document).ready(function () {
        if ($(window).width() >= 992) {
            $('.cl-product-tabs-container').height($('.cl-product-tab-content.active').height() + 110);
        }
        else {
            $('.cl-product-tabs-container').height('auto');
        }
        //if ($('.cl-product-info-col .cl-product-old-price').length >= 1) {
        //    $('.cl-product-info-col .cl-discount-badge').text('%' + (parseInt($('.cl-product-info-col .cl-product-old-price').text()) - parseInt($('.cl-product-info-col .cl-product-price').text())) / parseInt($('.cl-product-info-col .cl-product-old-price').text()) * 100);
        //}

        $(".cl-product-description img").one("load", function () {
            console.log('image ready')
            if ($(window).width() >= 992) {
                setTimeout(function () { $('.cl-product-tabs-container').height($('.cl-product-tab-content.active').height() + 110); }, 300);
            }
            else {
                $('.cl-product-tabs-container').height('auto');
            }
        })
        //persona product track
    });
</script>





  <!-- ////////////////////LİGHTBOX ALANI /////////////-->
    <link href="<?php echo $sitetemasi;?>/lightbox/css/lightbox.css" rel="stylesheet" media="screen" />
    <script src="<?php echo $sitetemasi;?>/lightbox/js/lightbox.js" type="text/javascript"></script>
    <!-- ////////////////////LİGHTBOX ALANI /////////////-->
	<link rel="stylesheet" href="<?php echo $sitetemasi;?>/bootstrap.min.css">
	<script src="<?php echo $sitetemasi;?>/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="<?php echo $sitetemasi;?>/lightslider.css">	
<script src="<?php echo $sitetemasi;?>/lightslider.js"></script>
<script>
    $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        slideMargin: 0,
        thumbItem: 9
    });
</script>
	
    <script type="text/javascript">
    var google_tag_params = {
        "dynx_itemid": "", "dynx_itemid2": "", "dynx_pagetype": "home", "dynx_totalvalue": 0, "ecomm_pagetype": "homepage", "ecomm_prodid": "", "ecomm_totalvalue": 0
    };
    var mainSlider = new Swiper('#cl-main-slider', {
        centeredSlides: true,
        loop: false,
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        preloadImages: false,
        lazy: true,
        on: {
            lazyImageLoad: function (swiper, slide, image) {
                $(slide).removeClass('cl-wave');
                pushPromo($(slide).data("id"), $(slide).data("name"), $(slide).data("creative"), $(slide).data("position"));              
            }
        }
    });




</script>
<?php if($tema['t11']){?>
   <div  class="newsletter-overlay">

  <div id="newsletter-popup" style="background:none !important;">
    <a href="#" class="popup-close">X</a>
      <div class="row justify-content-center">
            <div class="col-12">
              <a href="<?php echo $tema['t10']; ?>"><img style="box-shadow: 2px 2px 16px white;width:  100%;height:  100%;" src="resimler/temaayarlari/<?php echo $tema['t9']; ?>"></a></img>
                      
                  
                
            </div>
        </div>
  </div>
</div>
<?php } ?>


<?php 
$cihaz = $_SERVER['HTTP_USER_AGENT']; 
$iphone = strpos($cihaz,"iPhone"); 
$android = strpos($cihaz,"Android"); 
$ipod = strpos($cihaz,"iPod"); 
if ($iphone == true || $android == true || $ipod == true) { ?> 
<div class="altbar">
<div id="footer-bar" class="footer-bar-1">
<a href="<?php echo $url;?>" class="active-nav"><i class="fa fa-home"></i><span>Anasayfa</span></a>
<a href="sepet/"><i class="fa fa-shopping-cart"></i><span>Sepetim</span></a>
<?php if ($_SESSION['uyegirisdurumu'] == 'true') { ?>	
<a href="hesabim/"><i class="fa fa-user"></i><span>Hesabım</span></a>
<?php } else { ?>
<a href="uyeol/"><i class="fa fa-user"></i><span>Üyelik</span></a>
<?php } ?>
<a href="favorilerim/"><i class="fa fa-heart"></i><span>Favorilerim</span></a>
<a target="_blank" href="https://api.whatsapp.com/send/?phone=<?php echo $ayar['whatsapp'];?>&amp;text=Merhaba bilgi almak istiyorum."><i class="fa fa-whatsapp"></i><span>Destek</span></a>
</div>
</div>
<?php } ?>



    
	<script src="eklentiler/lazysizes.min.js" async></script>
    <link href="boss/assets/toastr/toastr.css" rel="stylesheet"/>
    <script src="boss/assets/toastr/toastr.min.js"></script>
    <?php require_once('func/global.php');?>

<style>

.altbar{
display:none !important;
}
#footer-bar {
 position:fixed;
 bottom:0;
 left:0;
 right:0;
 z-index:98;
 background-color:rgba(249,249,249,.98);
 box-shadow:0 -5px 10px 0 rgba(0,0,0,.06);
 min-height:60px;
 min-height:calc(60px + (constant(safe-area-inset-bottom))*1.1);
 min-height:calc(60px + (env(safe-area-inset-bottom))*1.1);
 display:flex;
 text-align:center;
 transition:all 350ms ease;
 line-height: 32px;
}
#footer-bar a {
    color: #1f1f1f;
    position: relative;
    flex: 1 1 auto;
    border: 1px solid #f5f6f9;
    background: white;
}
#footer-bar a span {
 position:relative;
 z-index:2;
 display:block;
 font-size:12px;
 font-weight:600;
 margin-top:-6px;
 opacity:.7;
}
#footer-bar a i {
 font-size:18px;
 position:relative;
 z-index:2
}
#footer-bar .badge {
 font-style:normal;
 z-index:5;
 top:0;
 position:absolute;
 margin-left:3px;
 color:#fff!important;
 width:18px;
 text-align:center;
 line-height:18px;
 padding:0;
 padding-left:0!important;
 border-radius:18px;
 margin-top:7px;
 font-size:11px
}
.footer-bar-2 .active-nav {
 color:#fff!important
}
.footer-bar-2 .active-nav strong {
 position:absolute;
 width:80px;
 left:50%;
 transform:translateX(-50%);
 top:0;
 bottom:0
}
.footer-bar-4 .active-nav {
 color:#fff!important
}
.footer-bar-4 .active-nav strong {
 position:absolute;
 width:47px;
 height:47px;
 border-radius:60px;
 left:50%;
 top:30px;
 transform:translate(-50%,-50%);
 bottom:0
}
.footer-bar-4 span {
 display:none!important
}
.footer-bar-4 i {
 padding-top:10px
}
.footer-bar-5 .active-nav strong {
 position:absolute;
 width:50px;
 height:2px;
 border-radius:60px;
 left:50%;
 top:0;
 transform:translateX(-50%)
}
.footer-bar-3 span {
 display:none!important
}
.footer-bar-3 .active-nav {
 padding-top:11px!important
}
.footer-bar-3 .active-nav span {
 display:block!important
}
.footer-bar-3 a {
 padding-top:18px!important
}
.footer-menu-hidden {
 transition:all 100ms ease;
 transform:translateY(100%)!important
}
.footer-bar-white * {
 color:#fff
}
#footer-bar.position-relative {
 z-index:2!important
}
.is-ios #footer-bar {
 height:calc(65px + (constant(safe-area-inset-bottom))*1.1);
 height:calc(65px + (env(safe-area-inset-bottom))*1.1)
}
.is-not-ios .footer-menu-clear {
 height:70px;
 display:block
}
.is-not-ios .footer {
 padding-bottom:0
}
.is-not-ios #footer-menu a i {
 padding-top:13px
}
.is-not-ios #footer-menu a span {
 opacity:.6
}
.footer-bar-scroll {
 display:block!important;
 overflow-x:auto;
 -webkit-overflow-scrolling:touch;
 white-space:nowrap;
 margin:0;
 padding:0
}
.footer-bar-scroll a {
 display:inline-block;
 width:19.5%
}
.footer-bar-scroll.footer-bar-4 .active-nav strong {
 margin-top:1px
}
.footer-bar-scroll.footer-bar-4 .badge {
 margin-left:-8px!important;
 margin-top:14px!important
}
.footer-bar-scroll.footer-bar-3 .badge {
 margin-left:-7px!important;
 margin-top:0!important
}
.footer-bar-scroll.footer-bar-3 i {
 transform:translateY(-10px)
}
.footer-bar-scroll.footer-bar-3 .active-nav i {
 transform:translateY(0px)
}
#newsletter-popup{
  margin: 70px auto;
  padding:30px 40px 40px;
  background: #f5828a;
  border-radius: 5px;
  width: 50%;
  position: relative;
  transition: all 1s ease-in-out;
  min-height: 300px;
}




@media screen and (max-device-width: 480px) and (orientation: portrait){
.altbar{
display:block !important;
}
}	

@media screen and (max-width: 1366px){
  #newsletter-popup{
    width: 100%;
  }
  .altbar{
display:block !important;
}
}

@media screen and (max-width: 992px){
  #newsletter-popup{
    width: 100%;
  }
  .altbar{
display:block !important;
}
}

.newsletter-overlay{
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: visible;
  opacity: 1;
  display: none;
  z-index: 999999999999;
 background: #1d1c1c87;
    border-radius: 20px;
}

#newsletter-popup h3{
  color: #fff;
  font-size: 24px;
  margin: 0 0 10px;
}

#newsletter-popup input[type="text"]{
    width: 100%;
    height: 36px;
    border: none;
    text-indent: 10px;
    font-size: 13px;
    border-bottom: 2px solid #faeaec;
    border-top: 2px solid #fff;
    padding: 0;
    color: #666;
    margin-bottom: 15px;
}

#newsletter-popup input[type="submit"]{
  background: #6EC5D9;
    border: none;
    border-bottom: 3px solid #57B8CE;
    color: #fff;
    text-align: center;
    display: block;
    padding: 0;
    line-height: 1.5;
    width: 100%;
    cursor: pointer;
    margin: 0;
    font-size: 21px;
}

#newsletter-popup .popup-close{
color: #141313;
position: absolute;
top: 30px;
right: 15px;
text-align: center;
text-decoration: none;
line-height: 30px;
font-size: 24px;
z-index: 9999;
background: #f0eded4a;
padding: 10px;
border-radius: 30px;
}
.cc-color-override--1636365854.cc-window {
    color: rgb(255, 255, 255);
    background-color: rgba(0, 0, 0, 0.74);
    display: none !important;
}
</style>

<script>
$(document).ready(function() {
		
		$(".yenile_buton").click(function(){
					$(".guvenlik_resmi").attr("src","<?php echo $sitetemasi;?>/captcha.php?d="+Math.random());
				});
		
		
		
		
		$('input[name="uyetip"]').on("change",function(){
			//alert($(this).prop("value"));
		if($(this).prop("value")=="1"){
			$("#kurumsal").show();
			$("#kurumsal2").show();
			$("#kurumsal3").show();
			$("#bireysel").hide();
		}
		else{
			$("#kurumsal").hide();
			$("#kurumsal2").hide();
			$("#kurumsal3").hide();
			$("#bireysel").show();
		}
	});	
	
	
	$('input[name="yeniletip"]').on("change",function(){
			//alert($(this).prop("value"));
		if($(this).prop("value")=="1"){
			$("#kurumsal").show();
			$("#kurumsal2").show();
			$("#kurumsal3").show();
			$("#bireysel").hide();
		}
		else{
			$("#kurumsal").hide();
			$("#kurumsal2").hide();
			$("#kurumsal3").hide();
			$("#bireysel").show();
		}
	});	
	
	
		$('input[name="sifretip"]').on("change",function(){
			//alert($(this).prop("value"));
		if($(this).prop("value")=="1"){
			$("#sifre1").show();
		}
		else{
			$("#sifre1").hide();

		}
	});	
	
	
	
		$('input[name="faturatip"]').on("change",function(){
			//alert($(this).prop("value"));
		if($(this).prop("value")=="1"){
			$("#faturaadres").show();
			$("#faturail").show();
			$("#faturailce").show();
		}
		else{
			$("#faturaadres").hide();
			$("#faturail").hide();
			$("#faturailce").hide();
		}
	});	
	
	

    
		$('#adresgeldi').on('change', function() {			
        $("#uyeadresal").val($(this).children("option:selected").attr("data-adres"));		
        $("#adresilce").val($(this).children("option:selected").attr("data-ilce"));
        $("#adresil").val($(this).children("option:selected").attr("data-il"));

        		 
			
		});	
       




    });	
		
		
	function detayfiyathesapla(obj){
		var detayfiyat=parseFloat($("#detayfiyat").attr("data-price"));
		$(".varyantselect option:selected").each(function(){
			detayfiyat+=parseFloat($(this).attr("data-price"));
		});
		$("input[type=radio]:checked").each(function(){
			detayfiyat+=parseFloat($(this).attr("data-price"));
		});
		$("#sonfiyat").html(detayfiyat.toFixed(2)+" TL");
		
	}
	

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }        

	   
	var delay = 1000; //in milleseconds

jQuery(document).ready(function($){
  setTimeout(function(){ showNewsletterPopup(); }, delay);
  
  $('.popup-close').click(function(){
      $('.newsletter-overlay').hide();
      
      //when closed create a cookie to prevent popup to show again on refresh
      setCookie('newsletter-popup', 'popped', 30);
  });
});

function showNewsletterPopup(){
  if( getCookie('newsletter-popup') == ""){
     $('.newsletter-overlay').show();
     setCookie('newsletter-popup', 'popped', 30);
  }
  else{
    console.log("Newsletter popup blocked.");
  }
}


function setCookie(cname,cvalue,exdays)
{
    var d = new Date();
    d.setTime(d.getTime()+(exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname+"="+cvalue+"; "+expires+"; path=/";
}

function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) 
    {
        var c = jQuery.trim(ca[i]);
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
    }
    return "";
}
</script>
<link rel="stylesheet" href="<?php echo $sitetemasi;?>/cookieconsent.min.css">

<script src="<?php echo $sitetemasi;?>/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
 window.cookieconsent.initialise({
   "palette": {
     "popup": {
       "background": "#646478", // Uyarının arkaplan rengi
       "text": "#ffffff" // Uyarının üzerindeki yazı rengi
     },
     "button": {
       "background": "#8ec760", // Tamam butonunun arkaplan rengi - "transparent" kullanırsanız border özelliğini açabilirsiniz.
       //"border": "#14a7d0", // Arkaplan rengini transparent yapıp çerçeve kullanabilmek için
      "text": "#ffffff" // Tamam butonunun yazı rengi
     }
   },
   "theme": "block", // Kullanabileceğiniz temalar; block, edgeless, classic. Sitenizin görüntüsüne uygun olanı seçebilirsiniz.
   "type": "opt-out", // Gizle uyarısını aktif etmek için
   // "position": "top", // Aktif ederseniz uyarı üst kısımda görünür
   //"static": true, //Aktif ederseniz uyarı üst kısımda sabit olarak görünür
   // "position": "bottom-left", // Aktif ederseniz uyarı solda görünür.
   //"position": "bottom-right", // Aktif ederseniz uyarı sağda görünür.
   "content": {
      "message": "Sitemizden en iyi şekilde faydalanabilmeniz için çerezler kullanılmaktadır. Sitemize giriş yaparak çerez kullanımını kabul etmiş sayılıyorsunuz.",
      "dismiss": "Tamam",
      "link": "Daha fazla bilgi",
      "href": "kullanim-kosullari/"
    }
})});
</script>
</body>
</html>