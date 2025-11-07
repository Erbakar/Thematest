<?php
/**
 * Database Query Optimizer
 * Optimizes database queries and implements caching
 */

class DatabaseOptimizer {
    private $pdo;
    private $queryCache;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->queryCache = new QueryCache();
    }
    
    /**
     * Execute query with caching
     */
    public function executeQuery($query, $params = [], $cacheTTL = 300) {
        // Try to get from cache first
        $cachedResult = $this->queryCache->getCachedQuery($query, $params);
        if ($cachedResult !== false) {
            return $cachedResult;
        }
        
        // Execute query
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        
        // Determine result type
        if (stripos($query, 'SELECT') === 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = $stmt->rowCount();
        }
        
        // Cache the result
        $this->queryCache->cacheQuery($query, $params, $result, $cacheTTL);
        
        return $result;
    }
    
    /**
     * Get single row with caching
     */
    public function getRow($query, $params = [], $cacheTTL = 300) {
        $cachedResult = $this->queryCache->getCachedQuery($query, $params);
        if ($cachedResult !== false) {
            return $cachedResult;
        }
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->queryCache->cacheQuery($query, $params, $result, $cacheTTL);
        
        return $result;
    }
    
    /**
     * Get single value with caching
     */
    public function getValue($query, $params = [], $cacheTTL = 300) {
        $cachedResult = $this->queryCache->getCachedQuery($query, $params);
        if ($cachedResult !== false) {
            return $cachedResult;
        }
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchColumn();
        
        $this->queryCache->cacheQuery($query, $params, $result, $cacheTTL);
        
        return $result;
    }
    
    /**
     * Optimize product queries
     */
    public function getProduct($id, $seo = null) {
        if ($seo) {
            $query = "SELECT * FROM urunler WHERE seo = ? AND durum = '1'";
            $params = [$seo];
        } else {
            $query = "SELECT * FROM urunler WHERE id = ? AND durum = '1'";
            $params = [$id];
        }
        
        return $this->getRow($query, $params, 600); // Cache for 10 minutes
    }
    
    /**
     * Get products with optimized query
     */
    public function getProducts($limit = 20, $offset = 0, $category = null) {
        $query = "SELECT id, adi, seo, resim, fiyat, ifiyat, idurum, kdv, stok, yeni FROM urunler WHERE durum = '1'";
        $params = [];
        
        if ($category) {
            $query .= " AND kategori = ?";
            $params[] = $category;
        }
        
        $query .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->executeQuery($query, $params, 300); // Cache for 5 minutes
    }
    
    /**
     * Get categories with optimized query
     */
    public function getCategories($parentId = 0) {
        $query = "SELECT id, adi, seo, nikon, ac, ustkat FROM kategoriler WHERE durum = '1' AND ustkat = ? ORDER BY sira DESC";
        $params = [$parentId];
        
        return $this->executeQuery($query, $params, 1800); // Cache for 30 minutes
    }
    
    /**
     * Get product reviews with optimized query
     */
    public function getProductReviews($productId, $limit = 10) {
        $query = "SELECT adi, yorum, yildiz, tarih, cevap FROM tumyorumlar WHERE sayfaid = ? AND konu = 'urunler' AND durum = '1' ORDER BY id DESC LIMIT ?";
        $params = [$productId, $limit];
        
        return $this->executeQuery($query, $params, 600); // Cache for 10 minutes
    }
    
    /**
     * Get similar products
     */
    public function getSimilarProducts($productId, $categoryId, $limit = 6) {
        $query = "SELECT id, adi, seo, resim, fiyat, ifiyat, idurum, kdv FROM urunler WHERE durum = '1' AND kategori = ? AND id != ? ORDER BY RAND() LIMIT ?";
        $params = [$categoryId, $productId, $limit];
        
        return $this->executeQuery($query, $params, 300); // Cache for 5 minutes
    }
    
    /**
     * Get cart items with optimized query
     */
    public function getCartItems($userId, $sessionId) {
        $query = "SELECT s.*, u.adi, u.resim, u.seo FROM sepet s 
                  INNER JOIN urunler u ON s.urunid = u.id 
                  WHERE s.gelenkim = ? AND s.kim = ? 
                  ORDER BY s.id DESC";
        $params = [$userId, $sessionId];
        
        return $this->executeQuery($query, $params, 60); // Cache for 1 minute
    }
    
    /**
     * Clear query cache
     */
    public function clearCache() {
        return $this->queryCache->clearQueryCache();
    }
}

/**
 * Optimized database functions
 */
function getOptimizedProduct($id, $seo = null) {
    global $ozy;
    static $optimizer = null;
    
    if (!$optimizer) {
        $optimizer = new DatabaseOptimizer($ozy);
    }
    
    return $optimizer->getProduct($id, $seo);
}

function getOptimizedProducts($limit = 20, $offset = 0, $category = null) {
    global $ozy;
    static $optimizer = null;
    
    if (!$optimizer) {
        $optimizer = new DatabaseOptimizer($ozy);
    }
    
    return $optimizer->getProducts($limit, $offset, $category);
}

function getOptimizedCategories($parentId = 0) {
    global $ozy;
    static $optimizer = null;
    
    if (!$optimizer) {
        $optimizer = new DatabaseOptimizer($ozy);
    }
    
    return $optimizer->getCategories($parentId);
}

function getOptimizedProductReviews($productId, $limit = 10) {
    global $ozy;
    static $optimizer = null;
    
    if (!$optimizer) {
        $optimizer = new DatabaseOptimizer($ozy);
    }
    
    return $optimizer->getProductReviews($productId, $limit);
}

function getOptimizedSimilarProducts($productId, $categoryId, $limit = 6) {
    global $ozy;
    static $optimizer = null;
    
    if (!$optimizer) {
        $optimizer = new DatabaseOptimizer($ozy);
    }
    
    return $optimizer->getSimilarProducts($productId, $categoryId, $limit);
}

function getOptimizedCartItems($userId, $sessionId) {
    global $ozy;
    static $optimizer = null;
    
    if (!$optimizer) {
        $optimizer = new DatabaseOptimizer($ozy);
    }
    
    return $optimizer->getCartItems($userId, $sessionId);
}


?>
