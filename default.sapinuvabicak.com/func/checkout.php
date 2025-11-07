<?php

///////// ALIŞVERİŞ TAMAMLAMA KODLARI ////////

			$sepetebak1 = $ozy->prepare("SELECT * FROM sepet WHERE kim=? and gelenkim=? order by id desc");
			$sepetebak1->execute(array($ip,$sepetimdekikim));
			if ($sepetebak1->rowCount()) {
			$uyesepeti1 = $ozy->prepare("SELECT * FROM urunler 
			INNER JOIN sepet ON urunler.id = sepet.urunid  
			WHERE sepet.kim=? and sepet.gelenkim=? ORDER BY sepet.id DESC");                
			$uyesepeti1->execute(array($ip,$sepetimdekikim));
			foreach ($uyesepeti1 as $sepet1) {
			$urunid.= "".$sepet1['urunid'].",";
			$urunadet.= "".$sepet1['adet'].",";
		    $ekozellik.= "".$sepet1['ekozellikid'].",";
			$ekozellikad.= "".$sepet1['ekozellikadet'].",";
			$birimf = fiyatgoster($sepet1['kdvsizfiyat']);
			$kdvf = fiyatgoster($sepet1['kdv']);
			$toplamf = fiyatgoster($sepet1['fiyat']*$sepet1['adet']);
			if($sepet1['alodedurum']=='1'){
			$alodevarmi= "
			<span class='badge' style='border: 1px solid #d2ab13;padding: 5px;line-height: 20px !important;color: #d2ab13;'>
			<i style='font-size: 18px;' class='icon-shopping-cart'></i> $sepet1[alodemetin]</span>
			";
			}else{
			$alodevarmi= "";
			}
			if($sepet1['kargo']=='1'){
			$kargovarmi= "
			<span class='badge' style='border: 1px solid #2cc43c;padding: 5px;line-height: 20px !important;color: #2cc43c;'>
			<i style='font-size: 18px;' class='icon-truck'></i> KARGO ÜCRETSİZ
			</span>
			";
			}else{
			$kargovarmi= "";
			}
			if($sepet1['alodedurum']=='1'){
			$newstok = $sepet1['adet']+$sepet1['alodeadet'];
			} else { 
			$newstok = $sepet1['adet'];
			}
			$uruntablomuz.="
			                             <tr>
										 <td class='product-col'>
												<div class='product'>
													<figure class='product-media'>
														<a href='$url/urun/$sepet1[seo]'>
															<img style='width: 60px;height: 60px;' src='$url/resimler/urunler/$sepet1[resim]'>
														</a>
													</figure>
													<h3 class='product-title'>
														<a href='$url/urun/$sepet1[seo]'><b style='font-weight: 400;'>$sepet1[adi]</b></br>
														<div style='font-weight: 400;font-size: 12px;margin-left: 2px;'>$sepet1[ekurun]
														</div>
														</a>
														<div class='badges' style='margin-top: 10px;display: inline-block;width: 300px;'>
														 ".$kargovarmi."
														 ".$alodevarmi."
														 
														</div>
													</h3><!-- End .product-title -->
												</div><!-- End .product -->
											</td>
											<td class='price-col'>$birimf</td>
											<td class='price-col' style='font-size: 14px;'>(% $sepet1[oran])</br>
											 $kdvf</td>
											<td class='quantity-col'>
                                                <div class='cart-product-quantity'>   
											     $newstok
												</div><!-- End .cart-product-quantity -->
                                            </td>
											<td class='total-col'>$toplamf</td>
										</tr>
                                        ";
										
										
 $mailtablomuz.="
 <tr style='direction:ltr!important'>
 <td style='border-bottom-color:#ccc; border-bottom-
 style:dotted; border-right-color:#ccc; border-right-style:dotted; direction:ltr!importa
 nt; border-collapse:collapse; font-weight:normal; padding:10px; border-width:0 1px 1px 0' valign='top' align='left'>
 <table style='direction:ltr!important; border-collapse:collap
 se; border:0' width='100%' cellspacing='0' cellpadding='0' border='0'>
 <tbody>
 <tr style='direction:ltr!important'>
 <td class='x_product-img' style='direction:ltr!important; 
 border-collapse:collapse; font-weight:normal; padding:0 10px 0 0;
 border:0' width='80' valign='top' align='left'>
 <a href='$url/urun/$sepet1[seo]' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='direction:ltr!important' data-linkindex='1'>
 <img data-imagetype='External' src='$url/resimler/urunler/$sepet1[resim]' style='display:block; direction:ltr!important;
 height:auto; line-height:100%; outline:none; text-decoration:none; border:0' width='80' border='0'></a>
 </td>
 <td style='font-family:Arial; font-size:13px; line-height:18px; color:#484848;
 direction:ltr!important; border-collapse:collapse; font-weight:normal; padding:0;
 border:0' valign='top' align='left'>
 <a href='$url/urun/$sepet1[seo]' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='font-family:Arial; font-size:13px; 
 line-height:18px; color:#484848; text-decoration:none; direction:ltr!important' data-linkindex='2'>$sepet1[adi]
 <div style='font-weight: 400;font-size: 12px;margin-left: 2px;'>$sepet1[ekurun]
 </div>
 <br style='direction:ltr!important'>
 <span style='color:#8c8c8c; font-size:11px; direction:ltr!important;display: inline-block;width: 300px;'>
 <div class='badges' style='margin-top: 10px;'>
 ".$kargovarmi."
 ".$alodevarmi."
 </div></span>
 </a>
 </td>
 </tr>
 </tbody>
 </table>
 </td>
  <td style='border-bottom-color:#ccc; border-bottom-style:dotted;
 border-right-color:#ccc; border-right-style:dotted; font-family:Arial;
 font-size:13px; line-height:18px; color:#484848; direction:ltr!important;
 border-collapse:collapse; font-weight:normal; padding:10px; border-width:0 1px 1px 0'
 valign='top' align='center'>$birimf</td>
 <td style='border-bottom-color:#ccc; border-bottom-style:dotted;
 border-right-color:#ccc; border-right-style:dotted; font-family:Arial;
 font-size:13px; line-height:18px; color:#484848; direction:ltr!important;
 border-collapse:collapse; font-weight:normal; padding:10px; border-width:0 1px 1px 0'
 valign='top' align='center'>(% $sepet1[oran])</br>
 $kdvf</td>
 <td style='border-bottom-color:#ccc; border-bottom-style:dotted;
 border-right-color:#ccc; border-right-style:dotted; font-family:Arial;
 font-size:13px; line-height:18px; color:#484848; direction:ltr!important;
 border-collapse:collapse; font-weight:normal; padding:10px; border-width:0 1px 1px 0'
 valign='top' align='center'>$newstok</td>
 <td style='border-bottom-color:#ccc; border-bottom-style:dotted;
 font-family:Arial; font-size:13px; line-height:18px; color:#484848;
 direction:ltr!important; border-collapse:collapse; font-weight:normal;
 padding:10px; border-width:0 0 1px' valign='top' align='center'>$toplamf</td>
 </tr>

 ";
			
			
			
			 }};
			 
			 
			$urunid =  mb_substr($urunid,0,-1);
			$adet =  mb_substr($urunadet,0,-1);
            $ekozellikid = mb_substr($ekozellik,0,-1);
            $ekozellikadet = mb_substr($ekozellikad,0,-1);				
			$siparisno = $RandStr;
			$odemetipi = temizle($_POST['odemetipi']);
			if(temizle($_POST['uyetip']=='0')){
			$uyetip = "Bireysel";
			$vergibilgileri = temizle("TC No : ".$_POST['tc']."");
			} else {
			$uyetip = "Kurumsal";
			$vergibilgileri = temizle("Firma Adı : ".$_POST['vergi1']." , Vergi Dairesi : ".$_POST['vergi2']." / Vergi No : ".$_POST['vergi3']."");
			}
			$adsoyad = temizle($_POST['adsoyad']);
			$telefon = temizle($_POST['telefon']);
			$email = temizle($_POST['email']);
			$adres = temizle($_POST['adres']);
			$il = temizle($_POST['il']);
			$ilce = temizle($_POST['ilce']);
			$faturatip = temizle($_POST['faturatip']);
            if(temizle($_POST['faturatip']=='0')){
			$faturaadres = temizle($_POST['adres']);
			$faturail = temizle($_POST['il']);
			$faturailce = temizle($_POST['ilce']);
			} else {
			$faturaadres = temizle($_POST['faturaadres']);
			$faturail = temizle($_POST['faturail']);
			$faturailce = temizle($_POST['faturailce']);
			}
			$mesaj = temizle($_POST['mesaj']);
			$onay = temizle($_POST['onay']);
			$aratutar = $arasepetbedeli;
			$kdvtutari = $sepetkdv;
			if($_POST['odemetipi']=='Kapıda Ödeme' and $system['kapidaok']=='1'){
			$kargotutari = $kargobedeli+$kapikargobedeli;
			} else{	
			$kargotutari = $kargobedeli;	
			}
			$havaleindirimtutari = $havaleindirimbedeli;
			$kuponid = $sepet1['kuponid'];
			$kupontutari = $kuponindirim;
			$cekid = $sepet1['cekid'];
			$cektutari = $cekindirim;
			$kapitutar = $kapikargobedeli;
			if($_POST['odemetipi']=='Havale/EFT' and $system['havaleok']=='1'){
			$toplamtutar = $toplamtutarim-$havaleindirimbedeli;	
			}elseif($_POST['odemetipi']=='Kapıda Ödeme' and $system['kapidaok']=='1'){
			$toplamtutar = $toplamtutarim+$kapikargobedeli;
			} else{	
			$toplamtutar = $toplamtutarim;	
			}
			$toplamindirim = $havaleindirimtutari+$cektutari+$kupontutari;
            if($havaleindirimbedeli>='1'){
			$havaleindirimmetin= "
			Havale İndirim Bedeli : $havaleindirimbedeli TL</br>
			";
			}
			if($kuponindirim>='1'){
			$kuponindirmetni= "
			Kupon İndirim Bedeli : $kuponindirim TL</br>
			";
			}
			if($cekindirim>='1'){
			$cekindirimetni= "
			Hediye Çeki İndirim Bedeli : $cekindirim TL</br>
			";
			}
			$mailtoplamtutari = fiyatgoster(($sepetbedeli+$kapikargobedeli-$kargobedeli));
		    $uye = $uyeid;
			$uruntablo = $uruntablomuz;
            $tarih   = date('d.m.Y H:i:s');
			$tarihson   = date('Y.m.d H:i:s');
			$mailtablo = $mailtablomuz;
			if ($_SESSION['uyegirisdurumu'] == 'true') { 
            $adresbak = $ozy->prepare("SELECT COUNT(*) FROM adreslerim where uyeid='{$uye}'");
            $adresbak->execute();
            $adressay = $adresbak->fetchColumn();
			if($adressay=='0'){
			$adresadi = "Yeni Adresim";
			$yeniadresekle = $ozy->prepare("INSERT INTO adreslerim (adi, uyeid, adres, il, ilce) 
            VALUES (?,?,?,?,?)");
            $adresekledik = $yeniadresekle->execute(array($adresadi, $uye, $adres, $il, $ilce));
	
			}}
			////////// ALIŞVERİŞ TAMAMLAMA SAYFASI BİTİŞ /////


?>