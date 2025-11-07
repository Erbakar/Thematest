<?php
/**
 * Image Optimization Functions
 * WebP conversion and image optimization
 */

class ImageOptimizer {
    private $quality = 85;
    private $maxWidth = 1920;
    private $maxHeight = 1080;
    
    public function __construct($quality = 85) {
        $this->quality = $quality;
    }
    
    /**
     * Convert image to WebP format
     */
    public function convertToWebP($sourcePath, $destinationPath = null) {
        if (!function_exists('imagewebp')) {
            return $sourcePath; // WebP not supported
        }
        
        if (!$destinationPath) {
            $destinationPath = str_replace(['.jpg', '.jpeg', '.png'], '.webp', $sourcePath);
        }
        
        // Check if WebP already exists and is newer
        if (file_exists($destinationPath) && filemtime($destinationPath) >= filemtime($sourcePath)) {
            return $destinationPath;
        }
        
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return $sourcePath;
        }
        
        $mimeType = $imageInfo['mime'];
        
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($sourcePath);
                break;
            default:
                return $sourcePath;
        }
        
        if (!$image) {
            return $sourcePath;
        }
        
        // Resize if needed
        $image = $this->resizeImage($image, $imageInfo[0], $imageInfo[1]);
        
        // Convert to WebP
        $result = imagewebp($image, $destinationPath, $this->quality);
        imagedestroy($image);
        
        return $result ? $destinationPath : $sourcePath;
    }
    
    /**
     * Resize image if it's too large
     */
    private function resizeImage($image, $width, $height) {
        if ($width <= $this->maxWidth && $height <= $this->maxHeight) {
            return $image;
        }
        
        $ratio = min($this->maxWidth / $width, $this->maxHeight / $height);
        $newWidth = intval($width * $ratio);
        $newHeight = intval($height * $ratio);
        
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG
        if (function_exists('imagealphablending')) {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
        }
        
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);
        
        return $resizedImage;
    }
    
    /**
     * Get optimized image path
     */
    public function getOptimizedImage($imagePath, $width = null, $height = null) {
        if (!$imagePath || !file_exists($imagePath)) {
            return $imagePath;
        }
        
        // Check if WebP is supported by browser
        $acceptsWebP = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
        
        if ($acceptsWebP) {
            $webpPath = $this->convertToWebP($imagePath);
            if ($webpPath !== $imagePath) {
                return $webpPath;
            }
        }
        
        return $imagePath;
    }
    
    /**
     * Generate responsive image srcset
     */
    public function generateSrcSet($imagePath, $sizes = [320, 640, 1024, 1920]) {
        if (!$imagePath || !file_exists($imagePath)) {
            return '';
        }
        
        $srcset = [];
        $acceptsWebP = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
        
        foreach ($sizes as $size) {
            $resizedPath = $this->resizeImageToWidth($imagePath, $size);
            if ($acceptsWebP) {
                $webpPath = $this->convertToWebP($resizedPath);
                $srcset[] = $webpPath . ' ' . $size . 'w';
            } else {
                $srcset[] = $resizedPath . ' ' . $size . 'w';
            }
        }
        
        return implode(', ', $srcset);
    }
    
    /**
     * Resize image to specific width
     */
    private function resizeImageToWidth($sourcePath, $targetWidth) {
        $pathInfo = pathinfo($sourcePath);
        $resizedPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . $targetWidth . 'w.' . $pathInfo['extension'];
        
        if (file_exists($resizedPath)) {
            return $resizedPath;
        }
        
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return $sourcePath;
        }
        
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        
        if ($width <= $targetWidth) {
            return $sourcePath;
        }
        
        $ratio = $targetWidth / $width;
        $newHeight = intval($height * $ratio);
        
        $mimeType = $imageInfo['mime'];
        
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                break;
            default:
                return $sourcePath;
        }
        
        if (!$image) {
            return $sourcePath;
        }
        
        $resizedImage = imagecreatetruecolor($targetWidth, $newHeight);
        
        if (function_exists('imagealphablending')) {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
        }
        
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $targetWidth, $newHeight, $width, $height);
        
        switch ($mimeType) {
            case 'image/jpeg':
                imagejpeg($resizedImage, $resizedPath, $this->quality);
                break;
            case 'image/png':
                imagepng($resizedImage, $resizedPath, 9);
                break;
        }
        
        imagedestroy($image);
        imagedestroy($resizedImage);
        
        return $resizedPath;
    }
}

/**
 * Helper function to get optimized image
 */
function getOptimizedImage($imagePath, $width = null, $height = null) {
    static $optimizer = null;
    if (!$optimizer) {
        $optimizer = new ImageOptimizer();
    }
    return $optimizer->getOptimizedImage($imagePath, $width, $height);
}

/**
 * Helper function to generate responsive image
 */
function getResponsiveImage($imagePath, $alt = '', $class = '', $sizes = '100vw') {
    static $optimizer = null;
    if (!$optimizer) {
        $optimizer = new ImageOptimizer();
    }
    
    $srcset = $optimizer->generateSrcSet($imagePath);
    $src = getOptimizedImage($imagePath);
    
    if ($srcset) {
        return '<img src="' . $src . '" srcset="' . $srcset . '" sizes="' . $sizes . '" alt="' . htmlspecialchars($alt) . '" class="' . $class . '" loading="lazy">';
    } else {
        return '<img src="' . $src . '" alt="' . htmlspecialchars($alt) . '" class="' . $class . '" loading="lazy">';
    }
}

?>
