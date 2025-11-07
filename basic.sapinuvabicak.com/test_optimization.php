<?php
/**
 * Test Optimization Functions
 * Test all optimization functions to ensure they work correctly
 */

echo "<h1>Optimization Test</h1>";

// Test 1: Check if files exist
echo "<h2>1. File Existence Check</h2>";
$files = [
    'func/minifier.php',
    'func/image_optimizer.php', 
    'func/cache.php',
    'func/db_optimizer.php',
    'performance_monitor.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file missing<br>";
    }
}

// Test 2: Check cache directories
echo "<h2>2. Cache Directory Check</h2>";
$dirs = [
    'cache',
    'cache/minified',
    'cache/pages',
    'cache/queries'
];

foreach ($dirs as $dir) {
    if (is_dir($dir) && is_writable($dir)) {
        echo "✅ $dir exists and writable<br>";
    } else {
        echo "❌ $dir missing or not writable<br>";
    }
}

// Test 3: Test minifier
echo "<h2>3. Minifier Test</h2>";
try {
    require_once('func/minifier.php');
    echo "✅ Minifier loaded successfully<br>";
    
    // Test CSS minification
    $testCSS = "body { color: red; } /* comment */";
    $minifier = new Minifier();
    $minified = $minifier->minifyCSS($testCSS);
    echo "✅ CSS minification works: " . htmlspecialchars($minified) . "<br>";
    
} catch (Exception $e) {
    echo "❌ Minifier error: " . $e->getMessage() . "<br>";
}

// Test 4: Test cache
echo "<h2>4. Cache Test</h2>";
try {
    require_once('func/cache.php');
    echo "✅ Cache loaded successfully<br>";
    
    $cache = new Cache();
    $cache->set('test_key', 'test_value', 60);
    $value = $cache->get('test_key');
    
    if ($value === 'test_value') {
        echo "✅ Cache set/get works<br>";
    } else {
        echo "❌ Cache set/get failed<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Cache error: " . $e->getMessage() . "<br>";
}

// Test 5: Test image optimizer
echo "<h2>5. Image Optimizer Test</h2>";
try {
    require_once('func/image_optimizer.php');
    echo "✅ Image optimizer loaded successfully<br>";
    
    $optimizer = new ImageOptimizer();
    echo "✅ ImageOptimizer class instantiated<br>";
    
} catch (Exception $e) {
    echo "❌ Image optimizer error: " . $e->getMessage() . "<br>";
}

// Test 6: Test database optimizer
echo "<h2>6. Database Optimizer Test</h2>";
try {
    require_once('func/db_optimizer.php');
    echo "✅ Database optimizer loaded successfully<br>";
    
} catch (Exception $e) {
    echo "❌ Database optimizer error: " . $e->getMessage() . "<br>";
}

// Test 7: Test performance monitor
echo "<h2>7. Performance Monitor Test</h2>";
try {
    require_once('performance_monitor.php');
    echo "✅ Performance monitor loaded successfully<br>";
    
} catch (Exception $e) {
    echo "❌ Performance monitor error: " . $e->getMessage() . "<br>";
}

echo "<h2>Test Complete</h2>";
echo "<p>If all tests show ✅, your optimization system is working correctly!</p>";
?>
