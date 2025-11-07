<?php
/**
 * Performance Monitor
 * Monitor and display site performance metrics
 */

require_once('func/cache.php');
require_once('func/db_optimizer.php');

class PerformanceMonitor {
    private $startTime;
    private $memoryStart;
    private $queries = [];
    private $cache;
    
    public function __construct() {
        $this->startTime = microtime(true);
        $this->memoryStart = memory_get_usage();
        $this->cache = new Cache();
    }
    
    /**
     * Start monitoring
     */
    public function start() {
        $this->startTime = microtime(true);
        $this->memoryStart = memory_get_usage();
    }
    
    /**
     * Log database query
     */
    public function logQuery($query, $time) {
        $this->queries[] = [
            'query' => $query,
            'time' => $time
        ];
    }
    
    /**
     * Get performance metrics
     */
    public function getMetrics() {
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        
        $executionTime = $endTime - $this->startTime;
        $memoryUsage = $endMemory - $this->memoryStart;
        
        $cacheStats = $this->cache->getStats();
        
        return [
            'execution_time' => round($executionTime, 4),
            'memory_usage' => $this->formatBytes($memoryUsage),
            'peak_memory' => $this->formatBytes(memory_get_peak_usage()),
            'queries_count' => count($this->queries),
            'queries_time' => array_sum(array_column($this->queries, 'time')),
            'cache_stats' => $cacheStats,
            'page_size' => $this->formatBytes(strlen(ob_get_contents()))
        ];
    }
    
    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
    
    /**
     * Display performance info
     */
    public function displayInfo() {
        $metrics = $this->getMetrics();
        
        echo "<!-- Performance Metrics -->\n";
        echo "<!-- Execution Time: " . $metrics['execution_time'] . "s -->\n";
        echo "<!-- Memory Usage: " . $metrics['memory_usage'] . " -->\n";
        echo "<!-- Peak Memory: " . $metrics['peak_memory'] . " -->\n";
        echo "<!-- Database Queries: " . $metrics['queries_count'] . " -->\n";
        echo "<!-- Cache Files: " . $metrics['cache_stats']['valid_files'] . " -->\n";
        echo "<!-- Cache Size: " . $metrics['cache_stats']['total_size_mb'] . "MB -->\n";
        echo "<!-- Page Size: " . $metrics['page_size'] . " -->\n";
    }
    
    /**
     * Get slow queries
     */
    public function getSlowQueries($threshold = 0.1) {
        return array_filter($this->queries, function($query) use ($threshold) {
            return $query['time'] > $threshold;
        });
    }
    
    /**
     * Generate performance report
     */
    public function generateReport() {
        $metrics = $this->getMetrics();
        $slowQueries = $this->getSlowQueries();
        
        $report = [
            'timestamp' => date('Y-m-d H:i:s'),
            'metrics' => $metrics,
            'slow_queries' => $slowQueries,
            'recommendations' => $this->getRecommendations($metrics)
        ];
        
        return $report;
    }
    
    /**
     * Get performance recommendations
     */
    private function getRecommendations($metrics) {
        $recommendations = [];
        
        if ($metrics['execution_time'] > 2) {
            $recommendations[] = 'Sayfa yükleme süresi 2 saniyeden fazla. Veritabanı sorgularını optimize edin.';
        }
        
        if ($metrics['queries_count'] > 20) {
            $recommendations[] = 'Çok fazla veritabanı sorgusu (' . $metrics['queries_count'] . '). Sorguları birleştirin veya cache kullanın.';
        }
        
        if ($metrics['memory_usage'] > '10MB') {
            $recommendations[] = 'Yüksek bellek kullanımı. Gereksiz değişkenleri temizleyin.';
        }
        
        if ($metrics['cache_stats']['valid_files'] < 5) {
            $recommendations[] = 'Cache kullanımı düşük. Daha fazla cache mekanizması ekleyin.';
        }
        
        return $recommendations;
    }
}

// Global performance monitor
$performanceMonitor = new PerformanceMonitor();

/**
 * Helper function to display performance info
 */
function displayPerformanceInfo() {
    global $performanceMonitor;
    $performanceMonitor->displayInfo();
}

/**
 * Helper function to get performance metrics
 */
function getPerformanceMetrics() {
    global $performanceMonitor;
    return $performanceMonitor->getMetrics();
}

?>
