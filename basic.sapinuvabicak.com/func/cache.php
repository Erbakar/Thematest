<?php
/**
 * Simple Cache System
 * File-based caching for improved performance
 */

class Cache {
    private $cacheDir = 'cache/';
    private $defaultTTL = 3600; // 1 hour
    
    public function __construct($cacheDir = 'cache/') {
        $this->cacheDir = rtrim($cacheDir, '/') . '/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }
    
    /**
     * Get cached data
     */
    public function get($key) {
        $file = $this->getCacheFile($key);
        
        if (!file_exists($file)) {
            return false;
        }
        
        $data = unserialize(file_get_contents($file));
        
        if ($data['expires'] < time()) {
            unlink($file);
            return false;
        }
        
        return $data['value'];
    }
    
    /**
     * Set cached data
     */
    public function set($key, $value, $ttl = null) {
        if ($ttl === null) {
            $ttl = $this->defaultTTL;
        }
        
        $data = [
            'value' => $value,
            'expires' => time() + $ttl,
            'created' => time()
        ];
        
        $file = $this->getCacheFile($key);
        return file_put_contents($file, serialize($data)) !== false;
    }
    
    /**
     * Delete cached data
     */
    public function delete($key) {
        $file = $this->getCacheFile($key);
        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }
    
    /**
     * Clear all cache
     */
    public function clear() {
        $files = glob($this->cacheDir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        return true;
    }
    
    /**
     * Check if cache exists and is valid
     */
    public function exists($key) {
        $file = $this->getCacheFile($key);
        
        if (!file_exists($file)) {
            return false;
        }
        
        $data = unserialize(file_get_contents($file));
        return $data['expires'] >= time();
    }
    
    /**
     * Get cache file path
     */
    private function getCacheFile($key) {
        return $this->cacheDir . md5($key) . '.cache';
    }
    
    /**
     * Get cache statistics
     */
    public function getStats() {
        $files = glob($this->cacheDir . '*.cache');
        $totalSize = 0;
        $validFiles = 0;
        $expiredFiles = 0;
        
        foreach ($files as $file) {
            $totalSize += filesize($file);
            $data = unserialize(file_get_contents($file));
            
            if ($data['expires'] >= time()) {
                $validFiles++;
            } else {
                $expiredFiles++;
            }
        }
        
        return [
            'total_files' => count($files),
            'valid_files' => $validFiles,
            'expired_files' => $expiredFiles,
            'total_size' => $totalSize,
            'total_size_mb' => round($totalSize / 1024 / 1024, 2)
        ];
    }
}

/**
 * Database Query Cache
 */
class QueryCache {
    private $cache;
    private $enabled = true;
    
    public function __construct() {
        $this->cache = new Cache('cache/queries/');
    }
    
    /**
     * Cache database query result
     */
    public function cacheQuery($query, $params, $result, $ttl = 300) {
        if (!$this->enabled) {
            return false;
        }
        
        $key = 'query_' . md5($query . serialize($params));
        return $this->cache->set($key, $result, $ttl);
    }
    
    /**
     * Get cached query result
     */
    public function getCachedQuery($query, $params) {
        if (!$this->enabled) {
            return false;
        }
        
        $key = 'query_' . md5($query . serialize($params));
        return $this->cache->get($key);
    }
    
    /**
     * Clear query cache
     */
    public function clearQueryCache() {
        return $this->cache->clear();
    }
    
    /**
     * Enable/disable query caching
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }
}

/**
 * Page Cache
 */
class PageCache {
    private $cache;
    private $enabled = true;
    
    public function __construct() {
        $this->cache = new Cache('cache/pages/');
    }
    
    /**
     * Cache page content
     */
    public function cachePage($url, $content, $ttl = 1800) {
        if (!$this->enabled) {
            return false;
        }
        
        $key = 'page_' . md5($url);
        return $this->cache->set($key, $content, $ttl);
    }
    
    /**
     * Get cached page content
     */
    public function getCachedPage($url) {
        if (!$this->enabled) {
            return false;
        }
        
        $key = 'page_' . md5($url);
        return $this->cache->get($key);
    }
    
    /**
     * Clear page cache
     */
    public function clearPageCache() {
        return $this->cache->clear();
    }
    
    /**
     * Enable/disable page caching
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }
}

// Global cache instances
$queryCache = new QueryCache();
$pageCache = new PageCache();

/**
 * Helper function to cache database query
 */
function cacheQuery($query, $params, $result, $ttl = 300) {
    global $queryCache;
    return $queryCache->cacheQuery($query, $params, $result, $ttl);
}

/**
 * Helper function to get cached query
 */
function getCachedQuery($query, $params) {
    global $queryCache;
    return $queryCache->getCachedQuery($query, $params);
}

/**
 * Helper function to cache page
 */
function cachePage($url, $content, $ttl = 1800) {
    global $pageCache;
    return $pageCache->cachePage($url, $content, $ttl);
}

/**
 * Helper function to get cached page
 */
function getCachedPage($url) {
    global $pageCache;
    return $pageCache->getCachedPage($url);
}
?>
