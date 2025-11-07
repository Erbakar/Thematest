<?php
function klasorBoyutu($dizin)
{
    $boyut = 0;
    if (!is_dir($dizin))
        return 0;

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dizin, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $dosya) {
        $boyut += $dosya->getSize();
    }
    return $boyut;
}

function formatBoyut($bytes)
{
    $birimler = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($birimler) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $birimler[$i];
}

function formatBoyut2($bytes)
{
    $bytes = $bytes / 1024 / 1024 / 1024; 
    return round($bytes, 2);
}

function formatBoyut3($bytes)
{
    $bytes = $bytes / 1024 / 1024; 
    return round($bytes, 2);
}
// Belirli klasörler
$klasorler = [
    "../resimler"
];

function HamSitedepolama(): int
{
    global $klasorler;

    $toplam_boyut = 0;
    foreach ($klasorler as $klasor) {
        $toplam_boyut += klasorBoyutu($klasor);
    }
    return formatBoyut2($toplam_boyut);
}

function HamSitedepolama2(): float
{
    global $klasorler;

    $toplam_boyut = 0;
    foreach ($klasorler as $klasor) {
        $toplam_boyut += klasorBoyutu($klasor);
    }
    return formatBoyut3($toplam_boyut);
}

function sitedepolama(): string
{
    global $klasorler;

    $toplam_boyut = 0;
    foreach ($klasorler as $klasor) {
        $toplam_boyut += klasorBoyutu($klasor);
    }
    return formatBoyut($toplam_boyut);
}
