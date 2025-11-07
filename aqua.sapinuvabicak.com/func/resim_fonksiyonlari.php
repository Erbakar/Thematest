<?php
// Resim boyutlandırma fonksiyonu - 16:9 oranında maksimum 1440x810
function resizeImageToMaxSize($sourcePath, $targetPath, $maxWidth = 1440, $maxHeight = 810) {
    // Resim bilgilerini al
    $imageInfo = getimagesize($sourcePath);
    if (!$imageInfo) {
        return false;
    }
    
    $originalWidth = $imageInfo[0];
    $originalHeight = $imageInfo[1];
    $mimeType = $imageInfo['mime'];
    
    // Orijinal resim zaten maksimum boyuttan küçükse, kopyala
    if ($originalWidth <= $maxWidth && $originalHeight <= $maxHeight) {
        return copy($sourcePath, $targetPath);
    }
    
    // 16:9 oranını hesapla
    $targetRatio = 16 / 9;
    $originalRatio = $originalWidth / $originalHeight;
    
    // Yeni boyutları hesapla
    if ($originalRatio > $targetRatio) {
        // Resim daha geniş, genişliği sınırla
        $newWidth = $maxWidth;
        $newHeight = round($maxWidth / $targetRatio);
    } else {
        // Resim daha yüksek, yüksekliği sınırla
        $newHeight = $maxHeight;
        $newWidth = round($maxHeight * $targetRatio);
    }
    
    // Maksimum boyutları aşmamasını sağla
    if ($newWidth > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = round($maxWidth / $targetRatio);
    }
    if ($newHeight > $maxHeight) {
        $newHeight = $maxHeight;
        $newWidth = round($maxHeight * $targetRatio);
    }
    
    // Kaynak resmi yükle
    switch ($mimeType) {
        case 'image/jpeg':
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case 'image/gif':
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }
    
    if (!$sourceImage) {
        return false;
    }
    
    // Yeni resim oluştur
    $targetImage = imagecreatetruecolor($newWidth, $newHeight);
    
    // PNG ve GIF için şeffaflık desteği
    if ($mimeType == 'image/png' || $mimeType == 'image/gif') {
        imagealphablending($targetImage, false);
        imagesavealpha($targetImage, true);
        $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
        imagefill($targetImage, 0, 0, $transparent);
    }
    
    // Resmi yeniden boyutlandır
    imagecopyresampled($targetImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
    
    // Hedef resmi kaydet
    $result = false;
    switch ($mimeType) {
        case 'image/jpeg':
            $result = imagejpeg($targetImage, $targetPath, 90);
            break;
        case 'image/png':
            $result = imagepng($targetImage, $targetPath, 9);
            break;
        case 'image/gif':
            $result = imagegif($targetImage, $targetPath);
            break;
    }
    
    // Belleği temizle
    imagedestroy($sourceImage);
    imagedestroy($targetImage);
    
    return $result;
}

// Ürün resmi için özel boyutlandırma fonksiyonu
function resizeProductImage($sourcePath, $targetPath) {
    return resizeImageToMaxSize($sourcePath, $targetPath, 1440, 810);
}

// Thumbnail oluşturma fonksiyonu - ürün listesi için
function createThumbnail($sourcePath, $targetPath, $maxWidth = 300, $maxHeight = 300) {
    return resizeImageToMaxSize($sourcePath, $targetPath, $maxWidth, $maxHeight);
}
?>
