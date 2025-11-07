<?php
/**
 * CSS and JS Minifier
 * Minifies CSS and JavaScript files for better performance
 */

class Minifier {
    private $cacheDir = 'cache/minified/';
    private $cacheTime = 86400; // 24 hours
    
    public function __construct() {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }
    
    /**
     * Minify CSS
     */
    public function minifyCSS($css) {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        
        // Remove unnecessary whitespace
        $css = str_replace(["\r\n", "\r", "\n", "\t"], '', $css);
        $css = preg_replace('/\s+/', ' ', $css);
        
        // Remove space around specific characters
        $css = str_replace(['; ', ' ;', '{ ', ' {', '} ', ' }', ': ', ' :', ', ', ' ,'], [';', ';', '{', '{', '}', '}', ':', ':', ',', ','], $css);
        
        // Remove unnecessary spaces
        $css = preg_replace('/\s*{\s*/', '{', $css);
        $css = preg_replace('/;\s*/', ';', $css);
        $css = preg_replace('/\s*}\s*/', '}', $css);
        $css = preg_replace('/\s*:\s*/', ':', $css);
        $css = preg_replace('/\s*,\s*/', ',', $css);
        
        return trim($css);
    }
    
    /**
     * Minify JavaScript
     */
    public function minifyJS($js) {
        // Remove single line comments
        $js = preg_replace('~//[^\r\n]*~', '', $js);
        
        // Remove multi-line comments
        $js = preg_replace('~/\*.*?\*/~s', '', $js);
        
        // Remove unnecessary whitespace
        $js = preg_replace('/\s+/', ' ', $js);
        
        // Remove space around operators
        $js = preg_replace('/\s*([{}();,=+\-*\/<>!&|])\s*/', '$1', $js);
        
        return trim($js);
    }
    
    /**
     * Combine and minify multiple CSS files
     */
    public function combineCSS($files, $outputFile = null) {
        if (!$outputFile) {
            $outputFile = $this->cacheDir . 'combined_' . md5(implode('', $files)) . '.css';
        }
        
        // Check cache
        if (file_exists($outputFile) && (time() - filemtime($outputFile)) < $this->cacheTime) {
            return $outputFile;
        }
        
        $combined = '';
        $lastModified = 0;
        
        foreach ($files as $file) {
            if (file_exists($file)) {
                $content = file_get_contents($file);
                $combined .= $this->minifyCSS($content) . "\n";
                $lastModified = max($lastModified, filemtime($file));
            }
        }
        
        file_put_contents($outputFile, $combined);
        touch($outputFile, $lastModified);
        
        return $outputFile;
    }
    
    /**
     * Combine and minify multiple JS files
     */
    public function combineJS($files, $outputFile = null) {
        if (!$outputFile) {
            $outputFile = $this->cacheDir . 'combined_' . md5(implode('', $files)) . '.js';
        }
        
        // Check cache
        if (file_exists($outputFile) && (time() - filemtime($outputFile)) < $this->cacheTime) {
            return $outputFile;
        }
        
        $combined = '';
        $lastModified = 0;
        
        foreach ($files as $file) {
            if (file_exists($file)) {
                $content = file_get_contents($file);
                $combined .= $this->minifyJS($content) . ";";
                $lastModified = max($lastModified, filemtime($file));
            }
        }
        
        file_put_contents($outputFile, $combined);
        touch($outputFile, $lastModified);
        
        return $outputFile;
    }
    
    /**
     * Get minified file path
     */
    public function getMinifiedFile($file) {
        if (!file_exists($file)) {
            return $file;
        }
        
        $pathInfo = pathinfo($file);
        $minifiedFile = $this->cacheDir . $pathInfo['filename'] . '.min.' . $pathInfo['extension'];
        
        // Check if minified version exists and is newer
        if (file_exists($minifiedFile) && filemtime($minifiedFile) >= filemtime($file)) {
            return $minifiedFile;
        }
        
        $content = file_get_contents($file);
        
        if ($pathInfo['extension'] === 'css') {
            $minified = $this->minifyCSS($content);
        } elseif ($pathInfo['extension'] === 'js') {
            $minified = $this->minifyJS($content);
        } else {
            return $file;
        }
        
        file_put_contents($minifiedFile, $minified);
        
        return $minifiedFile;
    }
    
    /**
     * Clear cache
     */
    public function clearCache() {
        $files = glob($this->cacheDir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

/**
 * Helper function to get minified CSS
 */
function getMinifiedCSS($files) {
    static $minifier = null;
    if (!$minifier) {
        $minifier = new Minifier();
    }
    
    if (is_array($files)) {
        return $minifier->combineCSS($files);
    } else {
        return $minifier->getMinifiedFile($files);
    }
}

/**
 * Helper function to get minified JS
 */
function getMinifiedJS($files) {
    static $minifier = null;
    if (!$minifier) {
        $minifier = new Minifier();
    }
    
    if (is_array($files)) {
        return $minifier->combineJS($files);
    } else {
        return $minifier->getMinifiedFile($files);
    }
}

?>
