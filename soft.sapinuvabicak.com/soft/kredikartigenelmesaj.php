<?php 
 echo $genelmetin = '	   
   <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
        <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: auto;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-size: 16px;line-height: 26px;">
				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;">
					
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;">
								
								<tr>
									<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
									<div class="mktEditable" id="intro_title">
									Sayın, '.$sip['adsoyad'].'	Siparişinizi başarıyla aldık :)
									</div></td>
								</tr>
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-size: 16px;line-height: 26px;"></td>
								</tr>
								<tr>
									<td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;-webkit-text-size-adjust: none;color: #555559;font-size: 16px;line-height: 26px;background-color: #fff; text-align:center;">
									<div class="mktEditable" id="cta">
									<img style="margin-bottom: 10px;" class="top-image" src="'.$url.'/mail/webinar-no-text.png" width="560"/>
										<div><a style="color:#ffffff; background-color: #ff8300;  border: 10px solid #ff8300; border-radius: 3px; text-decoration:none;">Sipariş No : '.$siparisno.'</a>
										</div>
										<div style="margin-top: 10px;">
										<strong>Sipariş Durumu :</strong> '.$durum.'<br>
										<strong>Ödeme Yöntemi :</strong> '.$sip['odemetipi'].'<br>
										<strong>Toplam Ödenecek Tutar :</strong> '.fiyatgoster($sip['toplamtutar']).'<br>
										<strong>İP Adresi</strong>: '.$ip.'<br><br>
			                        </div>
									</div>
									</td>
								</tr>
								</table>
						</td>
					</tr>
				
				</table>
			</td>
		</tr>
	</table>
  </body> 
  
  ';
 ?>