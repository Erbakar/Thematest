<title>Sayfa Bulunamadı</title>
<meta name="keywords" content="<?php echo $ayar['sitekey']; ?>">
<meta name="description" content="<?php echo $ayar['sitedesc']; ?>">
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:title" content="Sayfa Bulunamadı"/>
<meta property="og:description" content="<?php echo $ayar['sitedesc']; ?>"/>

	   
		   <main class="main">
		    <div class="page-content pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
        	<h1>404 Sayfa Bulunamadı</h1>
<p class="zoom-area"><b>Sayfa silinmiş </b> veya hiç eklenmemiş :) </p>
<section class="error-container">
  <span><span>4</span></span>
  <span>0</span>
  <span><span>4</span></span>
</section>
<div class="link-container">
  <a href="<?php echo $url;?>" class="more-link">Anasayfaya Dön</a>
</div>
  </div></div></div>  </div>      </main>
		<style>

.error-container {
  text-align: center;
  font-size: 180px;
  font-family: 'Catamaran', sans-serif;
  font-weight: 800;
  margin: 20px 15px;
  margin-top: -80px;
}
.error-container > span {
  display: inline-block;
  line-height: 0.7;
  position: relative;
  color: #FFB485;
}
.error-container > span > span {
  display: inline-block;
  position: relative;
}
.error-container > span:nth-of-type(1) {
  perspective: 1000px;
  perspective-origin: 500% 50%;
  color: #F0E395;
}
.error-container > span:nth-of-type(1) > span {
  transform-origin: 50% 100% 0px;
  transform: rotateX(0);
  animation: easyoutelastic 8s infinite;
}

.error-container > span:nth-of-type(3) {
  perspective: none;
  perspective-origin: 50% 50%;
  color: #D15C95;
}
.error-container > span:nth-of-type(3) > span {
  transform-origin: 100% 100% 0px;
  transform: rotate(0deg);
  animation: rotatedrop 8s infinite;
}
@keyframes easyoutelastic {
  0% {
    transform: rotateX(0);
  }
  9% {
    transform: rotateX(210deg);
  }
  13% {
    transform: rotateX(150deg);
  }
  16% {
    transform: rotateX(200deg);
  }
  18% {
    transform: rotateX(170deg);
  }
  20% {
    transform: rotateX(180deg);
  }
  60% {
    transform: rotateX(180deg);
  }
  80% {
    transform: rotateX(0);
  }
  100% {
    transform: rotateX(0);
  }
}

@keyframes rotatedrop {
  0% {
    transform: rotate(0);
  }
  10% {
    transform: rotate(30deg);
  }
  15% {
    transform: rotate(90deg);
  }
  70% {
    transform: rotate(90deg);
  }
  80% {
    transform: rotate(0);
  }
  100% {
    transform: rotateX(0);
  }
}
    




/* demo stuff */
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

h1 {
  text-align: center;
  margin: 30px 15px;
   margin-bottom:0px;
}
.zoom-area { 
  max-width: 490px;
  margin: 30px auto 30px;
  font-size: 19px;
  text-align: center;
  margin-bottom:0px;
}
.link-container {
  text-align: center;
}
a.more-link {
  text-transform: uppercase;
  font-size: 13px;
    background-color: #bbb;
    padding: 10px 15px;
    border-radius: 0;
    color: #fff;
    display: inline-block;
    margin-right: 5px;
    margin-bottom: 5px;
    line-height: 1.5;
    text-decoration: none;
  margin-top: 50px;
  letter-spacing: 1px;
}
		</style>