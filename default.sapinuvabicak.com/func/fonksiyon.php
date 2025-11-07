<?php
$ayar = $ozy->query("select * from siteayarlari where id=1")->fetch(PDO::FETCH_ASSOC);

$_SESSION['resim_limit'] = $ayar['resim_limit'];
$_SESSION['paketadi'] = $ayar['paketadi'];

// Paket tipine göre resim limitleri tanımla
$paket_limitleri = [
    'basic' => ['resim_limit' => 3, 'upload_modu' => 'tek_tek', 'max_bulk' => 1],
    'plus' => ['resim_limit' => 5, 'upload_modu' => 'coklu', 'max_bulk' => 5],
    'extreme' => ['resim_limit' => 5, 'upload_modu' => 'coklu', 'max_bulk' => 5],
    'enterprise' => ['resim_limit' => 5, 'upload_modu' => 'coklu', 'max_bulk' => 5]
];

// Eğer paket limitleri tanımlıysa, bunları kullan
if (isset($paket_limitleri[$_SESSION['paketadi']])) {
    $_SESSION['resim_limit'] = $paket_limitleri[$_SESSION['paketadi']]['resim_limit'];
    $_SESSION['upload_modu'] = $paket_limitleri[$_SESSION['paketadi']]['upload_modu'];
    $_SESSION['max_bulk'] = $paket_limitleri[$_SESSION['paketadi']]['max_bulk'];
} else {
    // Varsayılan değerler
    $_SESSION['upload_modu'] = 'tek_tek';
    $_SESSION['max_bulk'] = 1;
}


function giriskontrol($ozy, $pgs)
{
    if (isset($_SESSION['kullaniciadi']) && isset($_SESSION['sifre']) && $_SESSION['kullaniciadi'] && $_SESSION['sifre']) {
        $kullaniciadi = trim($_SESSION['kullaniciadi']);
        $sifre = trim($_SESSION['sifre']);
        $login_kontrol = $ozy->query("SELECT * FROM admin WHERE kullaniciadi = '{$kullaniciadi}' and sifre = '{$sifre}'")->fetch(PDO::FETCH_ASSOC);
        if ($login_kontrol) {
            if ($pgs == 0) {
                header("Location: index.php");
            }
        } else {
            if ($pgs != 0) {
                header("Location: index.php");
                exit();
            }
        }
    } else {
        if ($pgs != 0) {
            header("Location: index.php");
            exit();
        }
    }
}

function admin_yetki($ozy, $departmanid, $sayfaid)
{
    global $ayar;
    $url = $ayar['siteurl'];
    $yetki = $ozy->query("SELECT * FROM yetki WHERE departmanid = $departmanid")->fetch(PDO::FETCH_ASSOC);
    $dizi = explode(",", $yetki['menu']);
    if (!in_array($sayfaid, $dizi)) {
        header("Location: " . $url . "/boss/anasayfa.php");
        exit();
    }
}

function paket_kontrol($paketler)
{
    global $ayar;
    $url = $ayar['siteurl'];

    if (!in_array($_SESSION['paketadi'], (array) $paketler)) {
        header("Location: " . $url . "/boss/anasayfa.php");
        exit();
    }
}

function paket_kontrol_donus($paketler)
{

    if (!in_array($_SESSION['paketadi'], (array) $paketler)) {
        return false;
    } else {
        return true;
    }
}


function paket_kontrol_musteri($paketler)
{
    if (!in_array($_SESSION['paketadi'], (array) $paketler)) {
        return false;
    } else {
        return true;
    }
}

function paket_kontrol_musteri_menu($paketler)
{
    return in_array($_SESSION['paketadi'], explode(",", $paketler));
}

/**
 * Paket bilgilerini al
 */
function paket_bilgileri_al($paket_adi = null)
{
    if ($paket_adi === null) {
        $paket_adi = $_SESSION['paketadi'];
    }

    $paket_limitleri = [
        'basic' => ['resim_limit' => 3, 'upload_modu' => 'tek_tek', 'max_bulk' => 1, 'aciklama' => 'Basic'],
        'plus' => ['resim_limit' => 5, 'upload_modu' => 'coklu', 'max_bulk' => 5, 'aciklama' => 'Plus'],
        'extreme' => ['resim_limit' => 5, 'upload_modu' => 'coklu', 'max_bulk' => 5, 'aciklama' => 'Extreme'],
        'enterprise' => ['resim_limit' => 5, 'upload_modu' => 'coklu', 'max_bulk' => 5, 'aciklama' => 'Kurumsal']
    ];

    return isset($paket_limitleri[$paket_adi]) ? $paket_limitleri[$paket_adi] : null;
}

/**
 * Upload modunu al
 */
function upload_modu_al()
{
    return isset($_SESSION['upload_modu']) ? $_SESSION['upload_modu'] : 'tek_tek';
}

/**
 * Maksimum bulk limitini al
 */
function max_bulk_limit_al()
{
    return isset($_SESSION['max_bulk']) ? $_SESSION['max_bulk'] : 1;
}


function temizle($mVar)
{
    if (is_array($mVar)) {
        foreach ($mVar as $gVal => $gVar) {
            if (!is_array($gVar)) {
                $mVar[$gVal] = htmlspecialchars(strip_tags(urldecode(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($gVar))))))));  // -> Dizi olmadığını fark edip temizledik.
            } else {
                $mVar[$gVal] = temizle($gVar);
            }
        }
    } else {
        $mVar = htmlspecialchars(strip_tags(urldecode(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($mVar)))))))); // -> Dizi olmadığını fark edip temizledik.
    }
    return $mVar;
}
function seo($str, $options = array())
{
    $str = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $char_map = array(
        // Latin
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Ä' => 'A',
        'Å' => 'A',
        'Æ' => 'AE',
        'Ç' => 'C',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ð' => 'D',
        'Ñ' => 'N',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ö' => 'O',
        'Ő' => 'O',
        'Ø' => 'O',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ü' => 'U',
        'Ű' => 'U',
        'Ý' => 'Y',
        'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'å' => 'a',
        'æ' => 'ae',
        'ç' => 'c',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ð' => 'd',
        'ñ' => 'n',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ő' => 'o',
        'ø' => 'o',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ü' => 'u',
        'ű' => 'u',
        'ý' => 'y',
        'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A',
        'Β' => 'B',
        'Γ' => 'G',
        'Δ' => 'D',
        'Ε' => 'E',
        'Ζ' => 'Z',
        'Η' => 'H',
        'Θ' => '8',
        'Ι' => 'I',
        'Κ' => 'K',
        'Λ' => 'L',
        'Μ' => 'M',
        'Ν' => 'N',
        'Ξ' => '3',
        'Ο' => 'O',
        'Π' => 'P',
        'Ρ' => 'R',
        'Σ' => 'S',
        'Τ' => 'T',
        'Υ' => 'Y',
        'Φ' => 'F',
        'Χ' => 'X',
        'Ψ' => 'PS',
        'Ω' => 'W',
        'Ά' => 'A',
        'Έ' => 'E',
        'Ί' => 'I',
        'Ό' => 'O',
        'Ύ' => 'Y',
        'Ή' => 'H',
        'Ώ' => 'W',
        'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a',
        'β' => 'b',
        'γ' => 'g',
        'δ' => 'd',
        'ε' => 'e',
        'ζ' => 'z',
        'η' => 'h',
        'θ' => '8',
        'ι' => 'i',
        'κ' => 'k',
        'λ' => 'l',
        'μ' => 'm',
        'ν' => 'n',
        'ξ' => '3',
        'ο' => 'o',
        'π' => 'p',
        'ρ' => 'r',
        'σ' => 's',
        'τ' => 't',
        'υ' => 'y',
        'φ' => 'f',
        'χ' => 'x',
        'ψ' => 'ps',
        'ω' => 'w',
        'ά' => 'a',
        'έ' => 'e',
        'ί' => 'i',
        'ό' => 'o',
        'ύ' => 'y',
        'ή' => 'h',
        'ώ' => 'w',
        'ς' => 's',
        'ϊ' => 'i',
        'ΰ' => 'y',
        'ϋ' => 'y',
        'ΐ' => 'i',
        // Turkish
        'Ş' => 'S',
        'İ' => 'I',
        'Ç' => 'C',
        'Ü' => 'U',
        'Ö' => 'O',
        'Ğ' => 'G',
        'ş' => 's',
        'ı' => 'i',
        'ç' => 'c',
        'ü' => 'u',
        'ö' => 'o',
        'ğ' => 'g',
        // Russian
        'А' => 'A',
        'Б' => 'B',
        'В' => 'V',
        'Г' => 'G',
        'Д' => 'D',
        'Е' => 'E',
        'Ё' => 'Yo',
        'Ж' => 'Zh',
        'З' => 'Z',
        'И' => 'I',
        'Й' => 'J',
        'К' => 'K',
        'Л' => 'L',
        'М' => 'M',
        'Н' => 'N',
        'О' => 'O',
        'П' => 'P',
        'Р' => 'R',
        'С' => 'S',
        'Т' => 'T',
        'У' => 'U',
        'Ф' => 'F',
        'Х' => 'H',
        'Ц' => 'C',
        'Ч' => 'Ch',
        'Ш' => 'Sh',
        'Щ' => 'Sh',
        'Ъ' => '',
        'Ы' => 'Y',
        'Ь' => '',
        'Э' => 'E',
        'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'yo',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'j',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sh',
        'ъ' => '',
        'ы' => 'y',
        'ь' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye',
        'І' => 'I',
        'Ї' => 'Yi',
        'Ґ' => 'G',
        'є' => 'ye',
        'і' => 'i',
        'ї' => 'yi',
        'ґ' => 'g',
        // Czech
        'Č' => 'C',
        'Ď' => 'D',
        'Ě' => 'E',
        'Ň' => 'N',
        'Ř' => 'R',
        'Š' => 'S',
        'Ť' => 'T',
        'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c',
        'ď' => 'd',
        'ě' => 'e',
        'ň' => 'n',
        'ř' => 'r',
        'š' => 's',
        'ť' => 't',
        'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A',
        'Ć' => 'C',
        'Ę' => 'e',
        'Ł' => 'L',
        'Ń' => 'N',
        'Ó' => 'o',
        'Ś' => 'S',
        'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a',
        'ć' => 'c',
        'ę' => 'e',
        'ł' => 'l',
        'ń' => 'n',
        'ó' => 'o',
        'ś' => 's',
        'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A',
        'Č' => 'C',
        'Ē' => 'E',
        'Ģ' => 'G',
        'Ī' => 'i',
        'Ķ' => 'k',
        'Ļ' => 'L',
        'Ņ' => 'N',
        'Š' => 'S',
        'Ū' => 'u',
        'Ž' => 'Z',
        'ā' => 'a',
        'č' => 'c',
        'ē' => 'e',
        'ģ' => 'g',
        'ī' => 'i',
        'ķ' => 'k',
        'ļ' => 'l',
        'ņ' => 'n',
        'š' => 's',
        'ū' => 'u',
        'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

$karekterver = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPUQRSTUVWXYZ';
$yeniisim = substr(str_shuffle($karekterver), 0, 5);

$system = $ozy->query("select * from system where id=1")->fetch(PDO::FETCH_ASSOC);
$sitetemasi = $ayar['tema'];
$tema = $ozy->query("select * from temalar where adi='{$sitetemasi}'")->fetch(PDO::FETCH_ASSOC);
$sunucu = htmlspecialchars(trim($system['sunucum']));
$posta = htmlspecialchars(trim($system['epostam']));
$esifre = htmlspecialchars(trim($system['sifrem']));
$port = htmlspecialchars(trim($system['portum']));
$type = htmlspecialchars(trim($system['typem']));
$siteadi = htmlspecialchars(trim($ayar['siteadi']));
function sendsms($msg, $telno, $header)
{
    global $system;
    $username = $system['sadi'];
    $pass = $system['ssifre'];

    $startdate = date('d.m.Y H:i');
    $startdate = str_replace('.', '', $startdate);
    $startdate = str_replace(':', '', $startdate);
    $startdate = str_replace(' ', '', $startdate);
    $stopdate = date('d.m.Y H:i', strtotime('+1 day'));
    $stopdate = str_replace('.', '', $stopdate);
    $stopdate = str_replace(':', '', $stopdate);
    $stopdate = str_replace(' ', '', $stopdate);
    $surl = "http://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=$telno&message=$msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
    //echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $surl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //  curl_setopt($ch,CURLOPT_HEADER, false);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

// Formatlanmış string'i sayısal değere çeviren yardımcı fonksiyon
function parseFiyat($deger) {
    if (!is_string($deger)) {
        return floatval($deger);
    }
    // Türkçe format kontrolü (virgül varsa: 2.507.505,00)
    if (strpos($deger, ',') !== false) {
        // Virgülü nokta ile değiştir, binlik ayraçları (noktaları) kaldır
        $deger = str_replace('.', '', $deger); // Önce binlik ayraçlarını kaldır
        $deger = str_replace(',', '.', $deger); // Sonra virgülü nokta yap
    }
    // Sayısal değere çevir
    return floatval($deger);
}

function KdvHaric($tutar, $oran)
{ //Fonksiyon Başlangıcı
    // Sayısal değere çevir
    $tutar = parseFiyat($tutar);
    $kdvsiztutar = $tutar / (1 + ($oran / 100));
    // Sayısal değer döndür (formatlamayı fiyatgoster() yapacak)
    return floatval($kdvsiztutar);
}

function KdvDahil($tutar, $oran)
{ //Fonksiyon Başlangıcı
    // Sayısal değere çevir
    $tutar = parseFiyat($tutar);
    $biroran = $tutar * ($oran / 100);
    $kdvlitutar = $tutar + $biroran;
    // Sayısal değer döndür (formatlamayı fiyatgoster() yapacak)
    return floatval($kdvlitutar);
}


function ipadresi()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$ip = ipadresi();
if (isset($_SESSION['uyegirisdurumu']) == 'true') {
    $sepetimdekikim = temizle($_SESSION['uyeid']);
    $girdiekle = $ozy->prepare("UPDATE sepet SET gelenkim=? where kim=?");
    $girdiekle->execute(array($sepetimdekikim, $ip));
    $karsilastirguncelle = $ozy->prepare("UPDATE karsilastir SET gelenkim=? where kim=?");
    $karsilastirguncelle->execute(array($sepetimdekikim, $ip));
} else {
    $sepetimdekikim = session_id();
}
$sepetsay = $ozy->prepare("SELECT COUNT(*) FROM sepet where kim='$ip' and gelenkim='$sepetimdekikim'");
$sepetsay->execute();
$sepetsayi = $sepetsay->fetchColumn();
$arasepettoplami = $ozy->query("SELECT SUM(kdvsizfiyat*adet) FROM sepet WHERE kim='$ip' and gelenkim='$sepetimdekikim'")->fetch(PDO::FETCH_ASSOC);
foreach ($arasepettoplami as $arasepetbedeli) {
    $arasepetbedeli = number_format($arasepetbedeli, 2, '.', '');
}
$kdvm = $ozy->query("SELECT SUM(kdv*adet) FROM sepet WHERE kim='$ip' and gelenkim='$sepetimdekikim'")->fetch(PDO::FETCH_ASSOC);
foreach ($kdvm as $sepetkdv) {
    $sepetkdv = number_format($sepetkdv, 2, '.', '');
}
$sepettoplami = $ozy->query("SELECT SUM(fiyat*adet) FROM sepet WHERE kim='$ip' and gelenkim='$sepetimdekikim'")->fetch(PDO::FETCH_ASSOC);
foreach ($sepettoplami as $sepetbedeli) {
    $sepetbedeli = number_format($sepetbedeli, 2, '.', '');
}

$havaleindirim = $ozy->query("SELECT SUM(havaleindirim) FROM sepet WHERE kim='$ip' and gelenkim='$sepetimdekikim'")->fetch(PDO::FETCH_ASSOC);
foreach ($havaleindirim as $havaleindirimbedeli) {
    $havaleindirimbedeli = number_format($havaleindirimbedeli, 2, '.', '');
}

$kuponindirimi = $ozy->query("SELECT SUM(kupontutar) FROM sepet WHERE kim='$ip' and gelenkim='$sepetimdekikim'")->fetch(PDO::FETCH_ASSOC);
foreach ($kuponindirimi as $kuponindirim) {
    $kuponindirim = number_format($kuponindirim, 2, '.', '');
}

$cekindirimi = $ozy->query("SELECT SUM(cektutar) FROM sepet WHERE kim='$ip' and gelenkim='$sepetimdekikim'")->fetch(PDO::FETCH_ASSOC);
foreach ($cekindirimi as $cekindirim) {
    $cekindirim = number_format($cekindirim, 2, '.', '');
}

$kargokontrol1 = $ozy->query("SELECT SUM(kargo) FROM sepet WHERE kim='$ip' and gelenkim='$sepetimdekikim'")->fetch(PDO::FETCH_ASSOC);
foreach ($kargokontrol1 as $kargokontrol) {
}



function fiyatgoster($degisken)
{ //Fonksiyon Başlangıcı
    global $system;

    // Sayısal değere çevir (formatlanmış string gelirse parse et)
    $degisken = parseFiyat($degisken);

    if ($system['fiyatgizle'] == '0') {
        $degisken = "" . number_format($degisken, 2, ',', '.') . " TL";
    } else {

        if ($_SESSION['uyegirisdurumu'] == 'true') {
            $degisken = "" . number_format($degisken, 2, ',', '.') . " TL";
        } else {
            $degisken = "Fiyatlar Üyelere özel";
        }
    }

    return $degisken;
}



$ucretsizmikargo = (1 * $sepetsayi);
$kargombak = $system['ucretsizkargo'];

if ($sepetbedeli >= $kargombak or $ucretsizmikargo == $kargokontrol) {

    $kargometni = "Ücretsiz Kargo";
    $kargobedeli = '0.00';
} else {

    $kargometni = fiyatgoster($system['genelkargo']);
    $kargobedeli = fiyatgoster($system['genelkargo']);
}

$aratutari = fiyatgoster($arasepetbedeli);
$kdvtutari = fiyatgoster($sepetkdv);
$havaleindirimtutari = fiyatgoster($havaleindirimbedeli);
$kupontutari = fiyatgoster($kuponindirim);
$hediyecekitutari = fiyatgoster($cekindirim);

$odemetipi = $_POST['odemetipi'] ?? '';

if ($system['kapidaok'] == '1' && $odemetipi == 'Kapıda Ödeme') {
    $kapikargobedeli = $system['kapitutar'];
} else {
    $kapikargobedeli = "0.00";
}

function temiz_sayi($deger)
{
    return floatval(preg_replace('/[^0-9.]/', '', $deger));
}

$sepetbedeli = temiz_sayi($sepetbedeli);
$kargobedeli = temiz_sayi($kargobedeli);
$kupontutari = temiz_sayi($kupontutari);
$hediyecekitutari = temiz_sayi($hediyecekitutari);

$toplamtutarim = ($sepetbedeli + $kargobedeli) - ($kupontutari + $hediyecekitutari);
$toplamtutari = fiyatgoster($toplamtutarim);

// $toplamtutari = fiyatgoster(($sepetbedeli + $kargobedeli) - ($kupontutari + $hediyecekitutari));
// $toplamtutarim = ($sepetbedeli + $kargobedeli) - ($kupontutari + $hediyecekitutari);

if (!empty($_SESSION['uyegirisdurumu']) && $_SESSION['uyegirisdurumu'] == 'true') {
    $uyeid = temizle($_SESSION['uyeid']);
    $uyebilgileri = $ozy->query("SELECT * FROM users WHERE id = '$uyeid'")->fetch(PDO::FETCH_ASSOC);
} else {
    $uyeid = "0";
}
$sehir = array(
    34 => "İstanbul",
    6 => "Ankara",
    35 => "İzmir",
    1 => "Adana",
    2 => "Adıyaman",
    3 => "Afyon",
    4 => "Ağrı",
    68 => "Aksaray",
    5 => "Amasya",
    7 => "Antalya",
    75 => "Ardahan",
    8 => "Artvin",
    9 => "Aydın",
    10 => "Balıkesir",
    74 => "Bartın",
    72 => "Batman",
    69 => "Bayburt",
    11 => "Bilecik",
    12 => "Bingöl",
    13 => "Bitlis",
    14 => "Bolu",
    15 => "Burdur",
    16 => "Bursa",
    17 => "Çanakkale",
    18 => "Çankırı",
    19 => "Çorum",
    20 => "Denizli",
    21 => "Diyarbakır",
    81 => "Düzce",
    22 => "Edirne",
    23 => "Elazığ",
    24 => "Erzincan",
    25 => "Erzurum",
    26 => "Eskişehir",
    27 => "Gaziantep",
    28 => "Giresun",
    29 => "Gümüşhane",
    30 => "Hakkari",
    31 => "Hatay",
    76 => "Iğdır",
    32 => "Isparta",
    33 => "İçel",
    78 => "Karabük",
    70 => "Karaman",
    36 => "Kars",
    37 => "Kastamonu",
    38 => "Kayseri",
    71 => "Kırıkkale",
    39 => "Kırklareli",
    40 => "Kırşehir",
    79 => "Kilis",
    41 => "Kocaeli",
    42 => "Konya",
    43 => "Kütahya",
    44 => "Malatya",
    45 => "Manisa",
    46 => "Maraş",
    47 => "Mardin",
    48 => "Muğla",
    49 => "Muş",
    50 => "Nevşehir",
    51 => "Niğde",
    52 => "Ordu",
    80 => "Osmaniye",
    53 => "Rize",
    54 => "Sakarya",
    55 => "Samsun",
    56 => "Siirt",
    57 => "Sinop",
    58 => "Sivas",
    73 => "Şırnak",
    59 => "Tekirdağ",
    60 => "Tokat",
    61 => "Trabzon",
    62 => "Tunceli",
    63 => "Şanlıurfa",
    64 => "Uşak",
    65 => "Van",
    77 => "Yalova",
    66 => "Yozgat",
    67 => "Zonguldak"
);

$RandStr = chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) .
    chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90));


$url = $ayar['siteurl'];
function klasorsil($klasor)
{
    if (substr($klasor, -1) != '/')
        $klasor .= '/';
    if ($handle = opendir($klasor)) {
        while ($obj = readdir($handle)) {
            if ($obj != '.' && $obj != '..') {
                if (is_dir($klasor . $obj)) {
                    if (!klasorsil($klasor . $obj))
                        return false;
                } elseif (is_file($klasor . $obj)) {
                    if (!unlink($klasor . $obj))
                        return false;
                }
            }
        }
        closedir($handle);
        if (!@rmdir($klasor))
            return false;
        return true;
    }
    return false;
}


function urunfiyatbelirle($urunkdv, $indirim, $urunfiyat, $ifiyati)
{

    global $system;

    if ($indirim == '1') {
        if ($urunkdv > '0') { ?>
            <span class="old-price"> <?php echo $eskifiyatz = fiyatgoster(KdvDahil($urunfiyat, $urunkdv)); ?></span>&nbsp;&nbsp;
        <?php echo $yenifiyatz = fiyatgoster(KdvDahil($ifiyati, $urunkdv));
        } else { ?>
            <span class="old-price">
                <?php echo $eskifiyatz = fiyatgoster($urunfiyat); ?></span>&nbsp;&nbsp;
            <?php echo $yenifiyatz = fiyatgoster($ifiyati); ?>
<?php }
    } else {
        if ($urunkdv > '0') {
            echo $yenifiyatz = fiyatgoster(KdvDahil($urunfiyat, $urunkdv));
        } else {
            echo $yenifiyatz = fiyatgoster($urunfiyat);
        }
    }
}

$favsay = $ozy->prepare("SELECT COUNT(*) FROM favoriler where gelenkim='$sepetimdekikim'");
$favsay->execute();
$favorisayisi = $favsay->fetchColumn();
$smsbaslik = $system['sbaslik'];
$admintel = $system['stelefon'];
if (isset($_POST['delete'])) {
    $sepetkaldiralim = temizle($_POST['sepetid']);
    $sil = $ozy->prepare("DELETE FROM sepet WHERE id=?");
    $sil->execute(array($sepetkaldiralim));

    header("Location: " . $url . "");
}






?>